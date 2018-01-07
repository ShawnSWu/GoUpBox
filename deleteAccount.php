<!doctype html>
<html lang="zh_tw">
<head>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.6.1.min.js"></script>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>deleteAccount</title>
</head>
<?php
require('psql.php');


$deleteAccount = str_replace("'","''",$_REQUEST['account']);

deleteMember_request($deleteAccount);


function deleteMember_request($deleteAccount){
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="delete from user_info where account ='${deleteAccount}';";
	$result=db_exec($link,$Q);
	
	
	$memberAccountFilePath = "/home/s/x071/WWW/UserFile/${deleteAccount}";

	deleteDir($memberAccountFilePath);
	

	return $result;
}	

function deleteDir($dirPath)
{
    if (! is_dir($dirPath)) {
		deleteSuccess();
        die();
		
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file); // recursion
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
	deleteSuccess();
		
}

function deleteSuccess(){
		
	echo '<script>alert("刪除成功!!")</script>';
	echo '<meta http-equiv="refresh" content="0;url=BackEnd_mainView.php">';
}

?>
</body>
</html>
