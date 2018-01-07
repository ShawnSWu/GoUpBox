<!doctype html>
<html lang="zh_tw">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>BackEnd</title>
</head>
<body class="background">

<style>
.background{	
	background-color:#AAAAAA;
}
.fontColor{
	color="#FF0000";
}

.AccounttableBlock{
    margin-bottom: 1rem;
	background-color:#2F4F4F
	;padding:10px;margin-bottom:5px;
	border:2px 
	#ccc solid;border-radius:5px;

    max-width: 100%;
	max-height: 100%;
	position: absolute;
	top: 30%;
	left: 40%;
	margin-top:-150px;
	margin-left:-150px;
}

.machineTableBlock{
	margin-bottom: 1rem;
	background-color:#2F4F4F
	;padding:10px;margin-bottom:5px;
	border:2px 
	#ccc solid;border-radius:5px;

    max-width: 100%;
	max-height: 100%;
	position: absolute;
	top: 60%;
	left: 40%;
	margin-top:-150px;
	margin-left:-150px;
	
}


.td{
    min-width: 100%;
}
td{
    min-width: 100px;
}

a {
    color: #AA7700;
}


.logoutbtn{
	text-align:center;
	padding:10px;
	font:bold 20px Tahoma, Geneva, sans-serif;
	font-style:normal;
	color:#ffffff;
	background:#AA0000;
	border:0px solid #ffffff;
	width:340px;
	height:40px;
	-webkit-border-radius:3px 3px 3px 3px;
	
	position: absolute;
	top:80%;
	left: 40%;

}
</style>
<?php
	require('psql.php');
	include 'rootMember.php';
	include 'MachineInfo.php';
	session_start();
	$op = (int)$_REQUEST['op'];
	
	if($op == 3){
		$_SESSION['BackEndlogin']=0;
		echo '<script>alert("已登出!!");</script>';
		echo '<meta http-equiv="refresh" content="0;url=BackEnd_logInView.php">';
		die();
	}
	
	//請求連線次數 到最後一次清除
	$GLOBALS['callTime'] = 1;

	if($_SESSION['BackEndlogin'] == 0){
		echo '<script>alert("請先驗證身分")</script>';
		echo '<meta http-equiv="refresh" content="0;url=BackEnd_logInView.php">';
		die();
	}else{
				
		getUsersInfo_request();
		getMachineInfo();
		
		//rootMember陣列變數		
		$rootMemberObj = $GLOBALS['rootMemberObj'];
				
		//MachineInfo陣列變數
		$MachineInfoObj = $GLOBALS['machineInfoObj'];
		
		
		echo '
			<form method="GET" action="BackEnd_mainView.php">
				<input type="hidden" name="op" value="3">
				<input type="submit" class="logoutbtn" value="Logout"/>
			</form>
		';
		
		echo '
		<div style="color:#F5F5F5" class="AccounttableBlock">
		<table border="2">
				<tr>
				<td color="#FFFFFF">帳號</td><td width="20%">方案</td><td>到期時間</td><td>使用機器</td>
				';
			
			for($i=0 ; $i < $GLOBALS['rootMemberCount'] ; $i++){
										
				echo '<tr><td>'.$rootMemberObj[$i]->getAccount().'</td><td>'.$rootMemberObj[$i]->getProgramType().'</td>
				<td ">'.$rootMemberObj[$i]->getExpireDate().'</td>
				<td ">'.$rootMemberObj[$i]->getUsedMachine().'</td>
				<td><a href="deleteAccount.php?account='.$rootMemberObj[$i]->getAccount().'">刪除帳戶</a></td></tr>';
			}
		echo '</table></div><br><br><br><br>';
		
		
		//機器編號 機器可用容量
		echo '
		<div style="color:#F5F5F5" class="machineTableBlock">
		<table border="2">
				<tr>
				<td color="#FFFFFF">機器編號</td><td width="20%">機器最大容量(TB)</td><td>剩餘可用空間(GB)</td>
				';
			
			for($i=0 ; $i < $GLOBALS['machineCount'] ; $i++){
				echo '<tr>
						<td>'.$MachineInfoObj[$i]->getMid().'</td>
						<td>'.$MachineInfoObj[$i]->getMaxSpaceTb().'</td>
						<td>'.getRemainingSpace($MachineInfoObj[$i],$rootMemberObj).'</td>
					</tr>';
			}
		echo '</table>
		</div>		
		';
		
	}
	
	
function getRemainingSpace($machine,$rootMemberAarray){
	
	$mid = $machine->getMid();
	$onlySpace = getGBFromTB($machine->getMaxSpaceTb()); 

	for($i=0 ; $i < count($rootMemberAarray) ; $i++){
		if(trim($rootMemberAarray[$i]->getUsedMachine()) === trim($mid)){
			$onlySpace -= getUsedSpaceFromMember($rootMemberAarray[$i]);
		}
	}	

	return $onlySpace;
}

function getGBFromTB($onlySpace){
	return $onlySpace*1024;
}

function getUsedSpaceFromMember($rootMember){
	
	switch($rootMember->getProgramType()){
		
		case '免費型':
			$used_space = 5;
			break;
					
		case '50GB月租':
			$used_space = 50;
			break;
					
		case '200GB年租':
			$used_space = 200;
			break;
	}
	
	return $used_space;
}
	
function getMachineInfo(){
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select mid,max_space_tb from machine_info;";
	$result=db_exec($link,$Q);
		
	//取得所有機器的數量
	$count = db_num_rows($result,0);
	$GLOBALS['machineCount'] = $count;
	
	for($i=0;$i<$count;$i++){
		$data=db_fetch_row($result,0);
		$GLOBALS['machineInfoObj'][$i]= new MachineInfo($data[0],$data[1],$data[2]);
	}
	return $result;
}	

function getUsersInfo_request(){
	//去資料庫撈資料
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select account,program_type,enable_time,used_machine from user_info ;";
	$result=db_exec($link,$Q);
	
	//取得所有帳戶的數量
	$count = db_num_rows($result,0);
	
	$GLOBALS['rootMemberCount'] = $count;

	

	for($i=0;$i<$count;$i++){
		$data=db_fetch_row($result,0);
		$expireDate = computingTimeLeft($data[0],$data[2]);
		//全域物件陣列
		$GLOBALS['rootMemberObj'][$i]= new rootMember($data[0],$data[1],$expireDate,$data[3]);
	}	


	return $result;
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
	
	$GLOBALS['callTime']++;
	if($GLOBALS['callTime'] == $GLOBALS['rootMemberCount']){
		db_close($link);
		$GLOBALS['callTime'] = 1;
	}
	
	
	if($available_days == -99){
		return 0;//免費型
	}
	
	return $available_days;//返回使用者購買的天數
}

function computingTimeLeft($rootMember,$enableTime){
	
	$afterDays = (int)getUserProgram($rootMember);
	
echo '<script>console.log('.${afterDays}.');</script>';

	//分割字串
	$divideDateAndTime_array=explode(" ",$enableTime);	
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

?>
</body>
</html>

