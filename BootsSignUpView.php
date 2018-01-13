<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	  	<link rel="icon" href="box.png" type="image/x-icon" />
    <title>Sign up GoUpBox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
<body class="loginbackground">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
	.form-signin {
		max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
       font-size: 16px;
       height: auto;
       margin-bottom: 15px;
       padding: 7px 9px;
    }
	.titleBlock{
		padding:10px;margin-bottom:5px;
		solid;border-radius:5px;
		border-style:none;
		background-image:url(box.png);
		background-repeat:no-repeat;
		text-align:center;padding:10px;
	}

	.loginbackground{
		background-image:url(login_back.jpg);
		background-repeat: no-repeat; 
		background-attachment: fixed;
		background-position: center;
		background-size: cover;
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
  </head>
<?php  
require('psql.php');
include 'program.php';
session_start();

getSelectProgramList();
getProgramDateRequest();
		
function getSelectProgramList(){
	
	
	$link = db_connect("host=localhost dbname=x071 user=x071 password=Parw%Pe^u");
	db_set_encoding($link,'utf-8');
	$Q="select program_type from program;";
	$result=db_exec($link,$Q);

	$count = db_NumRows($result);
	
	for($i=0;$i<$count;$i++){
		$data=db_fetch_row($result,0);
		$GLOBALS['program_type'][$i] = new program($data[0],$data[1],$data[2],$data[3]);
		echo $GLOBALS['program_type'][$i]->getProgramType();
	}
	
	echo ' 
		<div class="container">
		  <div class="signupBlock">
			<form method="post" action="handleSignUp.php">
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
		</div>
		<!-- /container -->
		';
}

function getProgramDateRequest(){
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