<!doctype html>
<html lang="zh_tw">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>BackEnd</title>
</head>
<body>
<?php

	session_start();

	$account = str_replace("'","''",$_REQUEST['mangerAccount']);
	$password = str_replace("'","''",$_REQUEST['mangerPassword']);
	
	$stophack = (int)str_replace("'","''",$_REQUEST['stophack']);
	
	if($stophack != 99){
				$_SESSION['BackEndlogin']=0;
		echo '<script>alert("不要駭我!!");</script>';
		echo '<meta http-equiv="refresh" content="0;url=BackEnd_logInView.php">';
		die();
	}
	
	
	if(trim($account) == "rootManger" && trim($password) == "rootManger0123"){
		
		echo '<script>alert("驗證成功");</script>';
		$_SESSION['BackEndlogin']=1;
		echo '<meta http-equiv="refresh" content="0;url=BackEnd_mainView.php">';
		
	}else{
		echo '<script>alert("驗證失敗!!");</script>';
		echo '<meta http-equiv="refresh" content="0;url=BackEnd_logInView.php">';
	
	}


?>
</body>
</html>
