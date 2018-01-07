<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
<title>註冊</title>
</head>
<body class="loginbackground">
<h3>Sign up to GoUpBox</h3>

<style>

.loginbackground{
background-image:url(login_back.jpg);
background-repeat: no-repeat; 
background-size:cover;
}

.singuptitleBlock{
padding:10px;margin-bottom:5px;
solid;border-radius:5px;
border-style:none;
color:#FFFFFF;
text-align:center;padding:10px;
}

.signupBlock{
	background-color:#2F4F4F;
	opacity:0.8;
	padding:10px;
	solid;border-radius:3px;
	position: absolute;
	top: 50%;
	left: 40%;
	margin-top:-150px;
	margin-left:-150px;
}

.inputEdit{
background-color:#2F4F4F;
color:#FFFFFF;
border:1px solid #DADADA;
margin-top:10px;
padding-left:32px;
width:310px;
height:30px;
font-size:14px;
}

.signinbtn{
text-align:center;
padding:10px;
font:bold 20px Tahoma, Geneva, sans-serif;
font-style:normal;
color:#ffffff;
background:#c2c6cc;
border:0px solid #ffffff;
width:340px;
height:40px;
-webkit-border-radius:3px 3px 3px 3px;
margin-top: 20px;
}

.chooseprogram{
   width: 240px;
   height: 34px;
   overflow: hidden;
   	background-color:#2F4F4F;
	color:#FFFFFF;
}
</style>

<?php 
require('psql.php');
include 'program.php';
session_start();

getProgramDateRequest();
getSelectProgramList();




function getSelectProgramList(){
	
	$count = $_SESSION['program_count'];
	
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select program_type from program;";
	$result=db_exec($link,$Q);

	for($i=0;$i<$count;$i++){
		$data=db_fetch_row($result,0);
		$GLOBALS['program_type'][$i] = new program($data[0],$data[1],$data[2],$data[3]);
	}
echo '

<div class="signupBlock">

		<form method="post" action="handleSignIn.php">
		
		<h2 class="singuptitleBlock">Sign up</h2>
			<input type="text" name="account" placeholder="Account" size="15" class="inputEdit"/>
			<input type="text" name="email" placeholder="Email" size="15" class="inputEdit"/><br>		
			<input type="password" name="password" placeholder="Password" size="15" class="inputEdit"/>
			<input type="password" name="confirm_password" placeholder="ConfrimPassword" size="15" class="inputEdit"/><br>
			<input type="text" name="phone" placeholder="Phone" size="15" class="inputEdit"/>
			<select name="selected_program" placeholder="choose" class="chooseprogram"><br>
			';

		for($i=0;$i<$count;$i++){
			echo '<option>'.$GLOBALS['program_type'][$i]->getProgramType().'</option>';
		}
		echo '</select>
		<center>
			<input type="submit" name="signin" value="註冊" class="signinbtn"/>
			</center>
		</form>
		</div>
				
';
	
}


function getProgramDateRequest(){
	//去資料庫撈資料
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select program_type from program;";
	$result=db_exec($link,$Q);
	$_SESSION['program_count'] = db_NumRows($result);
	db_close($link);
	return $result;
}


?>
</body>
</html>