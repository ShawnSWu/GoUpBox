<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
</head>
<body bgcolor="#DDDDDD">
<?php
session_start();
checkHack($_FILES['file']);

if(!isset($_FILES['file'])){die();}

$file = $_FILES['file'];

$account = $_SESSION['account'];

$memberAccount = trim($account);
$dir = "/home/s/x071/WWW/UserFile/${memberAccount}/";  


if(move_uploaded_file($file['tmp_name'],$dir.$file['name'])){

}

function checkHack($file){
	if($file == null){
		$_SESSION['login'] = 0;
		echo '<meta http-equiv="refresh" content="0;url=logInView.php">';
		die();
	}
}

?>
</body>
</html>