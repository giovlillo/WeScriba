<?php
session_start();

include_once('../mysql-fix.php');
include ('include/db-connect.php');

if (isset($_SESSION['user_name'])) {




    $user_name = $_SESSION['user_name'];

    $password = $_SESSION['password'];

    $active = "";




    $query = "SELECT * FROM users WHERE `user_name`='$user_name' and `password`='$password' and `active`='1' and `type`='admin'";

    $result = mysql_query($query);

    $result = mysql_fetch_array($result);



    if ((is_array($result))) {

        header("Location: home.php");
    }
}

if (isset($_POST['submit'])) {



    $username = stripslashes($_POST['user_name']);

    $username = mysql_real_escape_string($username);

    $password = stripslashes($_POST['password']);

    $password = md5(mysql_real_escape_string($password));



    $sql = "SELECT * FROM users WHERE `user_name`='$username' and `password`='$password' and `active`='1' and `type`='admin'";

    $result = mysql_query($sql);

    $row = mysql_fetch_array($result);



    if (is_array($row)) {

        $_SESSION['user_id'] = $row ['user_id'];

        $_SESSION['user_name'] = $row ['user_name'];

        $_SESSION['password'] = $row ['password'];

        header("Location:home.php");
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
        <link rel="shortcut icon" href="../images/favicon/favicon.ico" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Center - print your documents online</title>
        <link href="../css/style.default.css" rel="stylesheet">
    </head>

    <body class="signin">
        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>

        <section>
            <div class="signinpanel">

                <div  class="lockedpanel">

                    <form method="post">

                        <h4 class="nomargin">Sign in</h4>
                        <p class="mt5 mb20">Login to access your account</p>

                        <?php
                        if (isset($msg)) {

                            if ($msg == "wrong") {

                                echo '<tr><td align="left" colspan="2">';

                                echo '<div class="alert alert-danger"> Wrong username / password</div>';

                                echo '</td></tr>';
                            }
                        }
                        ?>

                        <input type="text" id="user_name" name="user_name" class="form-control uname" placeholder="Username" />
                        <input type="password" id="password" name="password" class="form-control pword" placeholder="Password" />
                        <input type="submit" name="submit" value="Login" class="btn btn-success btn-block">
						<p style='margin-top: 15px;'>Lost password? <a href="../forgot_password.php">Recover</a></p>
                    </form>  
                </div>

                <div class="signup-footer">
                    <div class="pull-left">
                        &copy; 2021. All rights reserved. Print Center
                    </div>        
                </div>
            </div>
        </section>
        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="../js/jquery-migrate-1.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/modernizr.min.js"></script>
        <script src="../js/retina.min.js"></script>

        <script src="../js/custom.js"></script>
    </body>

</html>