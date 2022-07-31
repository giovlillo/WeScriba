<?php
include_once('mysql-fix.php');
session_start();

if (isset($_SESSION['user_name'])) {

	include ('admin/include/db-connect.php');

    $user_name = $_SESSION['user_name'];

    $password = $_SESSION['password'];

    $active = "";


    $query = "SELECT * FROM users WHERE `user_name`='$user_name' and `password`='$password' and `active`='1' and type != 'admin'";

    $result = mysql_query($query);

    $result = mysql_fetch_array($result);

	

    if ((is_array($result))) {
        header("Location: print_job_list.php");
    }

}

if (isset($_POST['submit'])) {

    include ('admin/include/db-connect.php');


    $username = stripslashes($_POST['user_name']);

    $username = mysql_real_escape_string($username);

    $password = stripslashes($_POST['password']);

    $password = md5(mysql_real_escape_string($password));



    $sql = "SELECT * FROM users WHERE `user_name`='$username' and `password`='$password' and `active`='1' and type != 'admin'";

    $result = mysql_query($sql);

    $row = mysql_fetch_array($result);



    if (is_array($row)) {

        $_SESSION['user_id'] = $row ['user_id'];

        $_SESSION['user_name'] = $row ['user_name'];

        $_SESSION['password'] = $row ['password'];

        header("Location:print_job_list.php");

    } else {

		$msg = "wrong";

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
        <div class="row" >

            

            

                <div class="col-md-7">
                
                <div class="signin-info">
                    <div class="logopanel">
                        <h1><span>[</span> Print Center <span>]</span></h1>
                    </div><!-- logopanel -->
                
                    <div class="mb20"></div>
                
                    <h5><strong>Change the way you print !!</strong></h5>
                    <ul>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Free yourself from the stress of toner and cartridges</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Print wherever you are. And wherever you want</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> Fast. No queue</li>
                        <li><i class="fa fa-arrow-circle-o-right mr5"></i> No more unnecessary waiting ...</li>
                    </ul>
                    <div class="mb20"></div>
                    <strong>Now are you convinced? <a href="user-registration.php">Sign in</a></strong>
                </div><!-- signin0-info -->
            
            </div><!-- col-sm-7 -->

                <div  class="col-md-5">

                    <form method="post">

					<h4 class="nomargin">Welcome to Print Center</h4>
                    <p class="mt5 mb20">Log in to your account.</p>

							<?php

								if(isset($msg)){

									if($msg == "wrong"){

										echo '<tr><td align="left" colspan="2">';

										echo '<div class="alert alert-danger"> 
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										Wrong username / password							
										</div>';

										echo '</td></tr>';

									}

								}

							?>

                    <input type="text" id="user_name" name="user_name" class="form-control uname" placeholder="Username" />
                    <input type="password" id="password" name="password" class="form-control pword" placeholder="Password" />
                    <input type="submit" name="submit" value="Login" class="btn btn-success btn-block">
                    <br><td colspan="2" align="right">Do not have an account? <a href="user-registration.php">Sign in</a></td> <br>
					<p>Lost password? <a href="forgot_password.php">Recover</a></p>
                </form>  
                </div>
            </div>
			<div class="signup-footer">
            <div class="pull-left">
                &copy; 2021. All rights reserved. Print Center
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