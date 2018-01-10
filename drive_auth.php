<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
<title>check</title>
</head>
<style type="text/css">
.loginbackground{
background-image:url(login_back.jpg);
background-repeat: no-repeat; 
background-size:cover;
}

</style>
<body class="loginbackground">
<?php
require('psql.php');
session_start();

/*
op=5 登出
*/

$op = (int)$_REQUEST['op'];
$account = str_replace("'","''",$_REQUEST['account']);
$password = str_replace("'","''",$_REQUEST['password']);

checkIfHack();


if($_SESSION['login'] == 0){
	//未登入時
	login($account,$password);
}else{
	//登入後	
	if($op==5){
		$_SESSION['login']=0;
        $_SESSION['account']='';
		$_SESSION['password']='';
		
		header('location:BootslogInView.php');
		die();
	}else if($op==6){
		echo '載入中...';
		echo '<meta http-equiv="refresh" content="1;url=BootsMainView.php">';
	}
	
	
}

function checkIfHack(){
	
	$stophack = (int)str_replace("'","''",$_REQUEST['stophack']);
	$op = (int)$_REQUEST['op'];
	if($op == 0){
		if($stophack != 99){
			$_SESSION['BackEndlogin']=0;
			echo '<script>alert("不要駭我!!");</script>';
			echo '<meta http-equiv="refresh" content="0;url=BootslogInView.php">';
			die();
				
		}
	}
}


function login($account,$password){

	//相符的資料應該只有一筆
	$result = login_request($account,$password);
	$count = db_num_rows($result);
	
	if($count == 1){
		$data=db_fetch_row($result,0);
		
		echo '<script>alert("登入成功!!!")</script>';
		
		$_SESSION['login']=1;
		$_SESSION['account']=$account;
		$_SESSION['password']=$password;
		
		echo '<meta http-equiv="refresh" content="1;url=BootsMainView.php">';
	}else{
		echo '<script>alert("帳號或密碼錯誤!!");</script>';
		echo '<meta http-equiv="refresh" content="0;url=BootslogInView.php">';
	}
	
}


function login_request($account,$password){
	$sha1pwd = sha1($password);
	//登入:去資料庫撈資料
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select account,password from user_info where account = '${account}' and password = '${sha1pwd}'";
	$result=db_exec($link,$Q);
	db_close($link);
	
	return $result;
}


function getUserInfo_request($account){
	//去資料庫撈資料
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select account,email,phone,program_type,enable_time from user_info 
		where account = '${account}' ;";
	$result=db_exec($link,$Q);
	db_close($link);
	return $result;
}


?>
		
</body>
</html>
