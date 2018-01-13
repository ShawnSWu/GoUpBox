<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
</head>
<body bgcolor="#DDDDDD">
<?php
session_start();


//取得帳號
$account = $_GET["account"];
checkHack($account);
$files = $_GET["file"];
$memberAccountFilePath = "/home/s/x071/WWW/UserFile/${account}/";

if($account!=null && $files!=null){
$deleteFile = $memberAccountFilePath.$files;

	unlink($deleteFile);

	echo "<script>alert('刪除成功');";
	echo "location.href = 'BootsMainView.php';";
	echo '</script>';
}

function checkHack($account){

	
	if($account == null){
		$_SESSION['login'] = 0;
		echo '<meta http-equiv="refresh" content="0;url=logInView.php">';
		die();
	}
}
?>
</body>
</html>