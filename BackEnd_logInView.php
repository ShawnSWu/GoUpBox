<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
<title>GoUpBox BackEnd</title>
</head>

<style>
.background{
	background-color:#666666;
}

.loginblock{
	width:360px;
	height:160px;
	background-color:#2F4F4F;
	border-radius:5px;
	position: absolute;
	top: 50%;
	left: 50%;
	margin-top:-150px;
	margin-left:-150px;
}
.login{
	background-color:#2F4F4F;
	color:#FFFFFF;
	border:1px solid #DADADA;
	margin-top:10px;
	margin-left:10px;
	padding-left:32px;
	width:300px;
	height:30px;
	font-size:14px;
}

.loginbtn{
	text-align:center;
	padding:10px;
	font:bold 20px Tahoma, Geneva, sans-serif;
	font-style:normal;
	color:#ffffff;
	background:#AA0000;
	border:0px solid #ffffff;
	width:330px;
	height:40px;
	-webkit-border-radius:3px 3px 3px 3px;
	margin-top: 10px;
	margin-left: 10px;
	opacity:0.7;
}

</style>

<body class="background">
<?php
	session_start();
	if($_SESSION['BackEndlogin'] == 0){
		
		echo '
			<div class="loginblock">
				<form action="auth_BackEnd.php" method="post">
					<input id="mangerAccount" type="text" name="mangerAccount" size="20" placeholder="Account" class="login"/><br>
					<input id="mangerPassword" type="password" name="mangerPassword" size="20" placeholder="password" class="login"/><br>
					<input type="hidden" name="stophack" value="99">
					<input type="submit" name="signin" value="Login" class="loginbtn"/>
				</form>
			</div>

		';
	}else{
		echo '<meta http-equiv="refresh" content="0;url=BackEnd_mainView.php">';
	}
?>
</body>
</html>