<!doctype html>
<html lang="zh_tw">
<head>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.6.1.min.js"></script>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>GoUpBox雲端硬碟</title>
</head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body bgcolor="#DDDDDD">
<style>
.profileBlock{
	background-color:#D3D3D3;
	width:210px;height:100%;
	position: absolute;
	top: 0px;
	left: 0px;
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
	background-position:3px;
	padding-left:32px;
	 position: absolute;
	  top: 10%;
	  left: 25%;
}


.table {
    width: 60%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
	
	background-color:#FFFFFF;
	padding:10px;
	margin-bottom:5px;
	border:2px #ccc solid;
	border-radius:5px;

	position: absolute;
	top: 50%;
	left: 50%;
	margin: -230px 0 0 -400px;
}

.table th, .table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #c2cfd6;
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
	font-size:9px;
	
	position: absolute;
	top: 0%;
	left: 50%;
}

</style>




<?php
	require('psql.php');
	include 'Member.php';
	session_start();

	if($_SESSION['login'] == 0){
		echo '<script>alert("請先登入")</script>';
		echo '<meta http-equiv="refresh" content="0;url=logInView.php">';
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

	
	onCreate($Member);
	
	
	if($_REQUEST['uploadbtn']){
		handleUpload($GLOBALS['memberAccountFilePath']);
	}
	
	
function handleUpload($memberAccountFilePath){
					
	$savePathName = $memberAccountFilePath.$_FILES['uploadfile']['name'];

	copy($_FILES['uploadfile']['tmp_name'],$savePathName) or die("失敗");

	echo "<script>alert('成功');";
	echo "location.href = 'mainView.php';";
	echo '</script>';
}	
	
function onCreate($Member){
	
	echo '<div id="loading" class="loading" style="display: none">上傳中...</div>';
	
	$fileList = showFileList($Member);
	$filesizeList = getFileSizeList($Member);
	
	//使用者存資料的資料夾
	$memberAccount = trim($Member->getAccount());
	$memberAccountFilePath = "/home/s/x071/WWW/UserFile/${memberAccount}/";
	
		echo '
		<!-- Sidebar -->
		<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:20%">
		  <h3 class="w3-bar-item">首頁</h3>
		  <a href class="w3-bar-item w3-button">帳號：'.$Member->getAccount().'</a>
		  <a href class="w3-bar-item w3-button">Email：'.$Member->getEmail().'</a>
		  <a href class="w3-bar-item w3-button">電話：'.$Member->getPhone().'</a>
		  <a href class="w3-bar-item w3-button">方案：'.$Member->getProgramType().'</a>
		  <a href class="w3-bar-item w3-button">啟用時間：'.$Member->getEnableTime().'</a>
		  <a href class="w3-bar-item w3-button">到期時間：'.computingDays($Member).'</a>
		  <br><br><br><br><br><br>
		  
		  <a href="drive_auth.php?op=5" class="w3-bar-item w3-button" color: hotpink;>登出</a>
		  <br><br>
		</div>';
		
		
		
		uploadBtnView();
		
		
		
		
		
	//if(count($fileList) > 0){
		echo '
		<table border="2" class="table">
				<tr>
				<td>檔名</td><td width="20%">檔案大小</td><td>上傳日期</td><td>載點</td>
				';
			
			for($i=0 ; $i < count($fileList) ; $i++){
				
				$chooseFiles = $fileList[$i];
				
				$downloadFile = $memberAccountFilePath.$chooseFiles;
				
				$uploadTime = date("F d Y H:i:s.",filemtime($downloadFile));
								
				echo '<tr><td>'.splitFileName($chooseFiles).'</td><td>'.getFilesizes($filesizeList[$i]).'</td>
				<td ">'.monthChangeChiese($uploadTime).'</td>
				<td><a href="download.php?file='.${downloadFile}.'">下載</a></td>
				<td><a href="deleteFile.php?account='.${memberAccount}.'&file='.${chooseFiles}.'">刪除</a></td></tr>';
			}
		echo '</tr><tr>
			<td>剩餘空間：'.computingSpaceSize($filesizeList).' GB'.'</td>
			</tr>
			</table>';
	//}
			
}	

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
