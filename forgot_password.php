<?php
session_start();
include_once('mysql-fix.php');
include ('admin/include/db-connect.php');
include "include/config.php";
include "include/utility.php";

if(isset($_POST["forgot_password_submit"])) {
	$email_address = $_POST["email_address"];
	
	$sqlQuery = "select * from users where user_email_address = '{$email_address}'";
	$resultObj = mysql_query($sqlQuery);
	$userDetails = mysql_fetch_assoc($resultObj);
	if(!isset($userDetails["user_id"])) {
		$error = 1; // no email address exists //
	} else {
		$token = generateRandomString(8) . uniqid();
		$encodedToken = base64_encode($token);
		$encodedEmail = base64_encode($email_address);
		$recoverPasswordUrl = $BASE_URL . "/recover_password.php?email={$encodedEmail}&token={$encodedToken}";
		
		$emailText = "Dear {$userDetails["name"]} {$userDetails["surname"]}, <br><br>
			Click the button or copy the following link into your browser to reset your password. <a href='{$recoverPasswordUrl}'>Recovery</a> SIf you do not want to reset your password or if you did not request this change, you can ignore this email<br><br>
			Thank you.";
		sendEmail($email_address, "Recovery Password", $emailText);
		
		$sqlQuery = "update users set forgot_password_token = '{$token}' where user_id = {$userDetails["user_id"]}";
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
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="theme-color" content="#ffffff">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Center - print your documents online</title>
        <link href="css/style.default.css" rel="stylesheet">
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

							<h4 class="nomargin">Password recovery</h4>
							<p class="mt5 mb20">Enter your e-mail address to proceed with password recovery.</p>

							<?php
							if (isset($error) && $error == 1) {
								echo '<div class="alert alert-danger">Attention, invalid e-mail address.</div>';
							} else if(isset($success) && $success == 1) {
								echo '<div class="alert alert-success">Email successfully sent. Check your inbox to complete the password recovery.</div>';
							}
							?>

							<input type="email" id="email_address" name="email_address" class="form-control email_address" placeholder="E-mail..." required/>
							<input type="submit" name="forgot_password_submit" value="Recovery" class="btn btn-success btn-block">
						</form>  
					</div>
				</div>
                
				<div class="row">
					<div class="col-md-12">
						<div class="signup-footer">
							<div class="pull-left">
								&copy; 2021. All rights reserved. Print Center
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