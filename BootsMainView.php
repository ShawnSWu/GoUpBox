<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GoUpBox</title>
	<link rel="icon" href="box.png" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
	  
	.uploadbuttton {
		display: inline-block;
		background: #D0EEFF;
		border: 1px solid #99D3F5;
		border-radius: 4px;
		padding: 4px 12px;
		overflow: hidden;
		color: #1E88C7;
		text-decoration: none;
		text-indent: 0;
		line-height: 20px;
		background-image:url(icon_upload.png);
		background-size:19px;
		background-repeat:no-repeat;
		background-position:4px;
		padding-left:32px;
	}

	.loading{
		z-index: 1;
		padding: 10px 10px 5px;
		background:#008866;
		left: 0;
		top: 0;
		color: #fff;
		position: fixed;
		width: 150px;
		height: 30px;
		text-align: center;
		box-shadow: 2px 2px 10px;
		border-radius: 5px;
		font-size:10px;
		
		position: absolute;
		top: 5%;
		left: 50%;
	}

	.accountIcon{
		background-image:url(icon_account.png);
		background-size:14px;
		background-repeat:no-repeat;
		background-position:3px;
	}

	.emailIcon{
		background-image:url(icon_email.png);
		background-size:14px;
		background-repeat:no-repeat;
		background-position:3px;
	}
	.phoneIcon{
		background-image:url(icon_phone.png);
		background-size:14px;
		background-repeat:no-repeat;
		background-position:3px;
	}
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
  </head>
<body>
<?php
	require('psql.php');
	include 'Member.php';
	session_start();

	if($_SESSION['login'] == 0){
		echo '<script>alert("請先登入")</script>';
		echo '<meta http-equiv="refresh" content="0;url=BootslogInView.php">';
		die();
	}
			
	getDataToGlobalsMember();
	$Member = $GLOBALS['Member'];

	$memberAccount = trim($Member->getAccount());

	//使用者存資料的資料夾
	$memberAccountFilePath = "/home/s/x071/WWW/UserFile/${memberAccount}/";
	$GLOBALS['memberAccountFilePath'] = $memberAccountFilePath;
	
	if(!is_dir($memberAccountFilePath)){
		mkdir($memberAccountFilePath,0777);
		chmod($memberAccountFilePath,0777);	
	}
	
	if($memberAccount == null){
		
		$_SESSION['login']=0;
        $_SESSION['account']='';
		$_SESSION['password']='';
				
		header('location:logInView.php');

		die();
		
	}


	echo '<div id="loading" class="loading" style="display: none">上傳中...</div>';

	echo '
		<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container-fluid">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="brand" href="#">GoUpBox</a>
			  <div class="nav-collapse collapse">
				<p class="navbar-text pull-right">
				  <a href="drive_auth.php?op=5" class="w3-bar-item w3-button" color: hotpink;>登出</a>
				</p>
				<ul class="nav">
				  <li class="active"><a href="#">首頁</a></li>
				  <li><a href="#account">帳戶</a></li>
				  <li><a href="#program">購買方案</a></li>
				</ul>
			  </div>
			</div>
		  </div>
		</div>';
		
		echo '
			<div class="container-fluid">
			  <div class="row-fluid">
				<div class="span2">
				  <div class="well sidebar-nav">
					<ul class="nav nav-list">
					  <li class="nav-header">帳戶</li>
						<li><a href="#"><span class="accountIcon">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Member->getAccount().'</span></a></li>
						<li><a href="#"><span class="emailIcon">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Member->getEmail().'</span></a></li>
						<li><a href="#"><span class="phoneIcon">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Member->getPhone().'</span></a></li>
					  <li class="nav-header">使用方案 - '.$Member->getProgramType().'</li>
					  <li><a href="#">啟用時間：'.$Member->getEnableTime().'</a></li>
					  <li><a href="#">到期時間：'.computingDays($Member).'</a></li>
					</ul>
			   </div><!--/.well -->
			</div><!--/span-->
				
			<div class="span6">
			  <div class="row-fluid">
				<div class="span10">
				<h1>首頁</h1>
				<br><br>
			';
			
			
		uploadBtnView();
			
			
		echo '
			<h5>最近</h5>
			<hr>
			  
			  <table border="2" class="table">
				<tr>
				<td>檔名</td><td>檔案大小</td><td>上傳日期</td><td>載點</td><td>移除</td></tr>';
				
				$fileList = showFileList($Member);
				$filesizeList = getFileSizeList($Member);
				
				for($i=0 ; $i < count($fileList) ; $i++){
					
					$chooseFiles = $fileList[$i];
					
					$downloadFile = $memberAccountFilePath.$chooseFiles;
						
					$uploadTime = date("F d Y H:i:s.",filemtime($downloadFile));
															
					echo '<tr><td>'.splitFileName($chooseFiles).'</td><td>'.getFilesizes($filesizeList[$i]).'</td>
					<td ">'.monthChangeChiese($uploadTime).'</td>
					<td><a href="download.php?file='.${downloadFile}.'">下載</a></td>
					<td><a href="deleteFile.php?account='.${memberAccount}.'&file='.${chooseFiles}.'">刪除</a></td>
					</tr>';
			}
				
			echo'
			</table>
              <p>剩餘空間：'.computingSpaceSize($filesizeList).' GB'.'</p>
            </div>
		  </div>

		  <hr>
		  <footer>
			<p>&copy; KSU-DataBase 2018</p>
		  </footer>
		</div>
	';
	
	
function splitFileName($fileName){
	
	if(strlen($fileName) > 20){
		
		$a = str_split($fileName, 8);
		
		$b = substr($fileName,-10);
	
		return $a[0].'...'.$b ;
	}
	return $fileName;
}


function uploadBtnView(){
			
		echo '	
		<div  class="uploadbuttton">
				<label>
				<input style="display:none;" type="file" id="myfile" multiple>
				<span >上傳檔案</span> 
				</label>
				
		</div>
			 ';
				
		echo "
			<script type='text/javascript'>
				function _id(e){return document.getElementById(e)}
				
				_id('myfile').onchange = function(){
					document.getElementById('loading').style.display='';
					var theFile = this.files;
					
					if(theFile.length === 1){

						var uploader = new XMLHttpRequest();
						var file = new FormData();
						file.append('file',theFile[0]);
						
						uploader.onreadystatechange = function(){
							if(uploader.readyState ===4 && uploader.status === 200){
								console.log(uploader.responseTeXt);								
							}
						}
						uploader.open('POST','uploadfile.php',true);
						uploader.send(file);
						alert('上傳1個檔案成功');		
						document.getElementById('loading').style.display='none';
						window.location.reload();
				
					}else{
				
						var start = 0,
						setter,
						buff = true;
						
						setter = setInterval(function(){						
										
							if(start === theFile.length){
								buff = false;
								clearInterval(setter);
								alert('上傳'+theFile.length+'個檔案成功');
								window.location.reload();
								document.getElementById('loading').style.display='none';
							}
													
							if(buff === true){
								console.log('another');
								buff = false;
								var uploader = new XMLHttpRequest();
								var file = new FormData();
								file.append('file',theFile[start]);
								
								uploader.onreadystatechange = function(){
									if(uploader.readyState === 4 && uploader.status === 200){
										console.log(uploader.responseTeXt);
										start++;
										buff = true;
									}
								}
								
								uploader.open('POST','uploadfile.php',true);
								uploader.send(file);
								console.log(start);
							}
				
						
						},900);
				
					}	
				
				}
				</script>
				
		";
	
}


function monthChangeChiese($month){
		
	if(preg_match("/January/i",$month)){
		$c = str_replace("January","1月",$month);
	}
	
	if(preg_match("/February/i",$month)){
		$c = str_replace("February","2月",$month);			
	}
	
	if(preg_match("/March/i",$month)){
		$c = str_replace("March","3月",$month);
	}
		
	if(preg_match("/April/i",$month)){
		$c = str_replace("April","4月",$month);	
	}
		
	if(preg_match("/May/i",$month)){
		$c = str_replace("May","5月",$month);
	}
		
	if(preg_match("/June/i",$month)){
		$c = str_replace("June","6月",$month);	
	}
		
	if(preg_match("/July/i",$month)){
		$c = str_replace("July","7月",$month);		
	}
		
	if(preg_match("/August/i",$month)){
		$c = str_replace("August","8月",$month);		
	}
		
	if(preg_match("/September/i",$month)){		
		$c = str_replace("September","9月",$month);
	}
		
	if(preg_match("/October/i",$month)){
		$c = str_replace("October","10月",$month);
	}
		
	if(preg_match("/November/i",$month)){
		$c = str_replace("November","11月",$month);
	}
		
	if(preg_match("/December/i",$month)){
		$c = str_replace("December","12月",$month);
	}
		
	return $c;
}

function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL; 
  return (count(scandir($dir)) == 2);
}

function showFileList($Member){
	
	$memberAccount = trim($Member->getAccount());
	$dir = "/home/s/x071/WWW/UserFile/${memberAccount}";  

	if(!is_dir_empty($dir)){
		$fileList = scandir($dir);
	}
	
	$size = 0;
 
 	for($i=2;$i<count($fileList);$i++){
		$fileListWithOutRoot[$size] = $fileList[$i];
		$size++;
	}
	return $fileListWithOutRoot;
}

function getFileSizeList($Member){

	$fileList = showFileList($Member);
	
	$memberAccount = trim($Member->getAccount());
	$dir = "/home/s/x071/WWW/UserFile/${memberAccount}/";  
	
	for($i=0;$i<count($fileList);$i++){
		
		$fileSizeList[$i] = filesize($dir.$fileList[$i]);
		//echo date("F d Y H:i:s.",filemtime($dir.$fileList[$i])).'<br>';
	}
	
	clearstatcache();
	
	return $fileSizeList;
}

function computingSpaceSize($filesizeList){
	$spaceSize = $GLOBALS['used_space_GB'];
	
	//把所有檔案的大小加起來(單位byte)
	for($i=0;$i<count($filesizeList);$i++){
		$allFileSize += $filesizeList[$i];
	}
		
	$totalSize = ($spaceSize*1073741824) - $allFileSize;
	return (int)($totalSize/1073741824);
}

function getFilesizes($num){
   $p = 0;
   $format='bytes';
   if($num>0 && $num<1024){
     $p = 0;
     return number_format($num).' '.$format;
   }
   if($num>=1024 && $num<pow(1024, 2)){
     $p = 1;
     $format = 'KB';
  }
  if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
    $p = 2;
    $format = 'MB';
  }
  if ($num>=pow(1024, 3) && $num<pow(1024, 4)) {
    $p = 3;
    $format = 'GB';
  }
  if ($num>=pow(1024, 4) && $num<pow(1024, 5)) {
    $p = 3;
    $format = 'TB';
  }
  $num /= pow(1024, $p);
  return number_format($num, 3).' '.$format;
}

function computingDays($Member){
	
	$afterDays = (int)getUserProgram($Member->getAccount());
	
echo '<script>console.log('.${afterDays}.');</script>';

	//分割字串
	$divideDateAndTime_array=explode(" ",$Member->getEnableTime());	
	//日期
	$divideDate = $divideDateAndTime_array[0];
	//時間
	$divideTime = $divideDateAndTime_array[1];
	
	//針對日期再做切割
	$divideDate_array=explode("-",$divideDate);

	(int)$final_Y = $divideDate_array[0];
	(int)$final_M = $divideDate_array[1];
	(int)$final_D = $divideDate_array[2];

	//帶入切割的日期做運算
	if($afterDays == 0){
		return '無限制';
	}else if($afterDays == 365){
		$maturityDate = ((int)$final_Y + 1).'-'.(int)$final_M.'-'.(int)$final_D;
	}else if($afterDays == 30){
		$maturityDate = date("Y-m-d" , mktime((int)$final_M,(int)$final_D,(int)$final_Y,date("m")+1,date("d"),date("Y")));
	}
	
	
	return $maturityDate.' '.$divideTime;
}
	
function getDataToGlobalsMember(){
	$account = $_SESSION['account'];
		
	//撈使用者資料到物件裡
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select account,password,email,phone,program_type,enable_time,used_machine from user_info 
		where account = '${account}' ;";
	$result=db_exec($link,$Q);
	$data=db_fetch_row($result,0);
	db_close($link);
	$GLOBALS['Member'] = new Member($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6]);	
}

function getUserProgram($account){
			
	//取得使用者的方案資料
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q = "select program_type from user_info where account = '${account}' ;";
	$result=db_exec($link,$Q);
	$data=db_fetch_row($result,0);

	//使用者方案
	$program_type = $data[0];	
	
	$Q2 = "select available_days,used_space_GB from program where program_type = '${program_type}' ;";
	$result2=db_exec($link,$Q2);
	$data2=db_fetch_row($result2,0);
	
	$available_days = $data2[0];	
	$GLOBALS['used_space_GB'] = $data2[1];
	db_close($link);
	
	if($available_days == -99){
		return 0;//免費型
	}
	
	return $available_days;//返回使用者購買的天數
}

	
	?>
  </body>
</html>
