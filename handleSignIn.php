<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
<title>註冊驗證</title>
</head>
<body>
<?php
	require('psql.php');

	$account = str_replace("'","''",$_REQUEST['account']);
	$password = str_replace("'","''",$_REQUEST['password']);
	$confirm_password = str_replace("'","''",$_REQUEST['confirm_password']);
	$email = str_replace("'","''",$_REQUEST['email']);
	$phone = str_replace("'","''",$_REQUEST['phone']);
	$selected_program = str_replace("'","''",$_REQUEST['selected_program']);
	
	checkHack($account);


	if(authInputDataIsNotNull($account,$password,$confirm_password,$email,$phone,$selected_program)){

		if(authInputDataFormat(
				$account,$password,$confirm_password,$email,$phone,$selected_program)){
			singInMember($account,$password,$email,$phone,$selected_program);
		}else{
			echo '<meta http-equiv="refresh" content="1;url=SignInView.php">';
		}
	}else{
		echo '<meta http-equiv="refresh" content="1;url=SignInView.php">';
	}
	
	
function checkHack($account){
	

	
	if($account == null){
		$_SESSION['login'] = 0;
		echo '<meta http-equiv="refresh" content="0;url=logInView.php">';
		die();
	}
}


function auth_IfRepeatAccount($account){
	//去資料庫撈資料
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select account from user_info 
		where account = '${account}' ;";
	$result=db_exec($link,$Q);
	$count = db_num_rows($result);
			
	if($count==0){
		return true;
	}else{
		return false;
	}
}

function singInMember($account,$password,$email,$phone,$selected_program){
	
	$systemTime = date("Y-m-d H:i:s");
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	$shapaw = sha1($password);
	db_set_encoding($link,'utf-8');
		
	$randomMachine = chooseMachine();
	
	$Q="insert into user_info values('${account}','${shapaw}','${email}','${phone}'
	,'${selected_program}','${systemTime}','${randomMachine}');";
	
	$result=db_exec($link,$Q);
	
	db_close($link);
				
	echo '<script>alert("註冊成功!!!")</script>';
	echo '<meta http-equiv="refresh" content="2;url=logInView.php">';
}

	
	
function chooseMachine(){
	
	$results = getMachineInfo();
	
	//機器總量
	$count = (int)db_num_rows($results,0);
		
	$randomNumber = rand(1,$count);
	$machineCode = sprintf("%03d", $randomNumber);
	$choosedMacine = 'M'.$machineCode;
	
	return $choosedMacine;
}
	
function getMachineInfo(){
		
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select mid,max_space_tb from machine_info;";
	$result=db_exec($link,$Q);

	return $result;
}	
	
function authInputDataFormat(
	$account,$password,$confirm_password,$email,$phone,$selected_program){
			
	if($password != $confirm_password){
		echo '<script>alert("錯誤 : 密碼輸入不重複!!!")</script>';
		return false;	
	}
		
	if(strlen($phone)> 20){
		echo '<script>alert("錯誤 : 電話格式錯誤!!!")</script>';
		return false;	
	}
		
	if(strlen($account)> 30){
		echo '<script>alert("錯誤 : 帳號長度過長!!!")</script>';
		return false;	
	}
		
	if(!auth_IfRepeatAccount($account)){
		echo '<script>alert("錯誤 : 帳號已被使用!!!")</script>';
		return false;
	}
		
	if(!preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $email)){
		echo '<script>alert("錯誤 : Email格式錯誤!!!")</script>';
		return false;
	}
		
	return true;
	
}
	
function authInputDataIsNotNull($account,$password,$confirm_password,$email,$phone,$selected_program){
		
	if(empty($account)){
		echo '<script>alert("錯誤 : 帳號不可為空")</script>';
		return false;
	}
		
	if(empty($password)){
		echo '<script>alert("錯誤 : 密碼不可為空")</script>';	
		return false;
	}
		
	if(empty($confirm_password)){
		echo '<script>alert("錯誤 : 確認密碼不可為空")</script>';	
		return false;
	}
		
	if(empty($email)){
		echo '<script>alert("錯誤 : Email不可為空")</script>';	
		return false;
	}
		
	if(empty($phone)){
		echo '<script>alert("錯誤 : 電話不可為空")</script>';
		return false;
	}
		
	return true;
}
?>

</body>
</html>





