<?php
include_once('mysql-fix.php');
session_start();
include ('admin/include/db-connect.php');
include "include/config.php";
include "include/utility.php";

if(!isset($_GET["token"]) || !isset($_GET["email"]) || $_GET["token"] == '') {
    header("Location: {$BASE_URL}/login.php");
    exit();
}
$encodedToken = $_GET["token"];
$encodedEmail = $_GET["email"];

$token = base64_decode($encodedToken);
$email = base64_decode($encodedEmail);

$sqlQuery = "select * from users where user_email_address = '{$email}' and forgot_password_token = '{$token}'";
$res = mysql_query($sqlQuery);
$userDetails = mysql_fetch_array($res);

if(!isset($userDetails["user_id"])) {
    header("Location: {$BASE_URL}/login.php");
    exit();
}

if(isset($_POST["recover_password_submit"])) {
    $password = $_POST["password"];
    $rePassword = $_POST["rePassword"];
    
    if($password != $rePassword) {
        $error = 1; // two passwords must be same..
    } else {
        $hashedPassword = md5($password);
        $sqlQuery = "update users set `password` = '{$hashedPassword}', `forgot_password_token` = ''  where user_id = '{$userDetails["user_id"]}'";
        mysql_query($sqlQuery);
        
        $success = 1;
    }
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="img/favicon.ico" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Center - print your documents online</title>
        <link href="css/style.default.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="signin">
        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>

        <section>
            <div class="signinpanel">
				<div class="row">	
					<div class="col-md-6 col-md-offset-3">
						<form method="post" class="text-center">

							<h4 class="nomargin">New password</h4>
							<p class="mt5 mb20">It's time to enter a new password.</p>

							<?php
							if (isset($error) && $error == 1) {
								echo '<div class="alert alert-danger">Attention, the two passwords do not match.</div>';
							} else if(isset($success) && $success == 1) {
								echo "<div class='alert alert-success'>Your password has been successfully updated. You can go back to using WeScriba <a href='{$BASE_URL}/login.php'>Login</a></div>";
							}
							?>

							<input type="password" id="password" name="password" class="form-control password" placeholder="Password..." required/>
							<input type="password" id="rePassword" name="rePassword" class="form-control rePassword" placeholder="Re-type password..." required/>
							<input type="submit" name="recover_password_submit" value="Submit" class="btn btn-success btn-block">
						</form>  
					</div>
				</div>
                
				<div class="row">
					<div class="col-md-12">
						<div class="signup-footer">
							<div class="pull-left">
								&copy; 2017. All rights reserved. WeScriba
							</div>        
						</div>
					</div>
				</div>
            </div>
        </section>
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/retina.min.js"></script>

        <script src="js/custom.js"></script>
    </body>

</html>