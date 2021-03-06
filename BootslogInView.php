<!DOCTYPE html>
<html lang="en">
  <head>
  	<link rel="icon" href="box.png" type="image/x-icon" />
    <meta charset="utf-8">
    <title>Sign In GoUpBox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../assets/css/bootstrap.css" rel="stylesheet">
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
	  
		.loginbackground{
			background-image:url(login_back.jpg);
			background-repeat: no-repeat; 
			background-attachment: fixed;
			background-position: center;
			background-size: cover;
		}
		.loginbtn{
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
		.loginAccount{
			width:360px;
			height:25px;
			-webkit-border-radius:5px 5px 5px 5px;
			margin-top: 10px;
			border-style: solid;
			border-width: 0.5px;
			padding:5dp;
			color: #DCDCDC;
		}
		.loginblock{
			opacity:0.99;
			background-color:rgba(52,73,94,0.7);
			padding:10px;
			 solid;border-radius:5px;
		}
		.signinblock{
			opacity:0.99;
			background-color:rgba(52,73,94,0.7);
			padding:10px;margin-bottom:5px;

			border-radius:5px;
			text-align:center;padding:10px;
			 margin-top: 20px;
		}

		input#account{
			background-image:url(icon_account.png);
			background-size:19px;
			background-repeat:no-repeat;
			background-position:3px;
			color:#696969;
			border:1px solid #DADADA;
			margin-top:10px;
			padding-left:32px;
			width:310px;
			height:30px;
			font-size:14px;

		}

		input#password{
			background-image:url(icon_password.png);
			background-size:19px;
			background-repeat:no-repeat;
			background-position:3px;
			color:#696969;
			border:1px solid #DADADA;
			margin-top:10px;
			padding-left:32px;
			width:310px;
			height:30px;
			font-size:14px;
			}
			.titleBlock{
			padding:10px;margin-bottom:5px;
			solid;border-radius:5px;
			border-style:none;
			background-image:url(box.png);
			background-repeat:no-repeat;
			text-align:center;padding:10px;
		}
		.allBlack{
			width:360px;
			height:160px;
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top:-150px;
			margin-left:-150px;
		}
    </style>
  </head>
  <body class="loginbackground">
  
  <?php
  
  session_start();
	if($_SESSION['login'] != 0){
		echo '<meta http-equiv="refresh" content="0;url=BootsMainView.php">';
	}else{
		
  echo '
    <div class="container">
     <div class="allBlack" >
		<div class="titleBlock">
			<span  style="font-family:fantasy;font-size:35px;color:#8FBC8F;" >G o U p B o x</span>
		</div>
		<div class="loginblock">
			<form method="post" action="drive_auth.php">
				<input id="account" type="text" name="account" size="20" placeholder="Account" class="loginAccount"/><br>
				<input id="password" type="password" name="password" size="20" placeholder="password" class="loginAccount"/><br>
				<input type="hidden" name="stophack" value="99">
				<input type="submit" name="signin" value="Login" class="loginbtn"/>
			</form>
		</div>
		<div class="signinblock">
		 Join us?<a href="BootsSignUpView.php">  Sign up</a>
		</div>
		</div>
    </div> 
	<!-- /container -->
';
	}

	?>
  </body>
</html>
