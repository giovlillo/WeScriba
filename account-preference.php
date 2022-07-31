  <?php
include_once('mysql-fix.php');
include ('include/dashboard.php');

if (isset($_POST['delete'])) {
    $query = "DELETE FROM `users` WHERE  `user_id` ='" . $_SESSION['user_id'] . "'";
    mysql_query($query);
    echo '<span style="color:red;"> Account successfully deleted. <a href="login.php">Click here</a> to return to the login page.</span>';
    exit;
}

if (isset($_POST['save'])) {
    
    $isWhatsppMessage = 0;
    if(isset($_POST["is_whatsapp_message"]) && $_POST["is_whatsapp_message"] == 1) {
        $isWhatsppMessage = 1;
    }
    
    $msg = "";
    $cpass = md5($_POST['newpass']);
    $npass = md5($_POST['repass']);
    $query = "";
    if (strlen($_POST['newpass']) != 0 || strlen($_POST['repass']) != 0) {
        if ($cpass === $npass) {
            $query = "UPDATE  `users` SET `name` = '" . $_POST['name'] . "', `surname` = '" . $_POST['sname'] . "', `user_email_address` =  '" . $_POST['user_email_address'] . "', `password` = '" . $cpass . "', phone_number = '{$_POST["phone_number"]}', is_whatsapp_message = '{$isWhatsppMessage}' WHERE  `user_id` =" . $_SESSION['user_id'] . "";
            mysql_query($query);
            $msg = "Updated";
        } else {
            $msg = "nomatch";
        }
    } else {
        $query = "UPDATE  `users` SET `name` = '" . $_POST['name'] . "', `surname` = '" . $_POST['sname'] . "', `user_email_address` =  '" . $_POST['user_email_address'] . "', phone_number = '{$_POST["phone_number"]}', is_whatsapp_message = '{$isWhatsppMessage}' WHERE  `user_id` =" . $_SESSION['user_id'] . "";
        mysql_query($query);
        $msg = "Updated";
    }
}
$result = mysql_query("SELECT user_name,name,surname,user_email_address, country_code, phone_number, is_whatsapp_message from users where `user_id`=" . $_SESSION['user_id'] . "");
$row = mysql_fetch_array($result);

$query = "SELECT * FROM `country_codes` order by name asc";
$resObj = mysql_query($query);
$countryList = array();
while($countryRow = mysql_fetch_assoc($resObj)) {
	$countryList[] = $countryRow;
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
        <link href="css/style.inverse.css" rel="stylesheet">
        <link href="css/jquery.datatables.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    </head>
    <body>
        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
        <section>

            <div class="leftpanel">

                <div class="logopanel">
                    <h1><span>[</span> Print Center <span>]</span></h1>
                </div><!-- logopanel -->

                <div class="leftpanelinner">

                    <!-- This is only visible to small devices -->
                    <div class="visible-xs hidden-sm hidden-md hidden-lg">   
                        <div class="media userlogged">
                            <img alt="" src="images/photos/user01.jpg" class="media-object">
                            <div class="media-body">
                                <h4><?php echo $_SESSION["user_name"]; ?></h4>

                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">Account</h5>
                        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                            <li><a href="account-preference.php"><i class="fa fa-user"></i> <span>My Profile</span></a></li>
                            <li><a href="#"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Log out</span></a></li>
                        </ul>
                    </div>

                    <h5 class="sidebartitle">Menu</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li><a href="print_job_list.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li><a href="print-now.php"><i class="fa fa-envelope-o"></i> <span>Print Now</a></li>
                        <li><a href="print_job_list.php"><i class="fa fa-edit"></i> <span>Print Jobs</span></a></li>
                        <li><a href="#"><i ></i> <span></span></a></li>
                        <li ><a href="buy-now.php"><i class="fa fa-th-list"></i> <span>Buy Now</span></a></li>
                        <li class="active"><a href="account-preference.php"><i class="fa fa-map-marker"></i> <span>Account Preference</span></a></li> 

                    </ul>  
                </div><!-- leftpanelinner -->
            </div><!-- leftpanel -->


            <div class="mainpanel">
                <div class="headerbar">
                    <a class="menutoggle"><i class="fa fa-bars"></i></a>   
                    <div class="header-right">
                        <ul class="headermenu">   
                            <li>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <img src="images/photos/user01.jpg" alt="" /><span><?php echo $_SESSION["user_name"]; ?></span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                        <li><a href="account-preference.php"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                                        <li><a href="help.php"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                                        <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div><!-- header-right -->

                </div><!-- headerbar -->
                <div id="main-content">
                    <div id="main-area">
                        <div class="pageheader">
                            <h2><i class="fa fa-table"></i>Account preference area</h2>
                        </div>
                        <form action="" method="post">
                            <div class="panel-body">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2 class="panel-title">Account preference</h2>
                                    </div> 

                                    <div class="panel-body">
                                        <form action="" method="post">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        if (isset($msg)) {
                                                            if ($msg == "nomatch") {
                                                                echo '<div class="alert alert-danger"> Attention!! Password does not match<br></div>';
                                                            } elseif ($msg = "Updated") {
                                                                echo '<div class="alert alert-success"> Account Updated Successfully</div>';
                                                            } elseif ($msg == "empty") {
                                                                echo '<div class="alert alert-danger"> Attention!! Enter password</div>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Username:</label>
                                                                <input type="text" class="form-control" name="user_name" value="<?php echo $row['user_name'] ?>" disabled />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Name:</label>
                                                                <input type="text" class="form-control" name="name" value="<?php echo $row['name'] ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Surname:</label>
                                                                <input type="text" class="form-control" name="sname" value="<?php echo $row['surname'] ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Email:</label>
                                                                <input type="email" name="user_email_address" class="form-control" value="<?php echo $row['user_email_address'] ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
													<!--<div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
																<label class="control-label">Prefisso</label>
																<select class="form-control" name="country_code">
																	<option value="">Selezionare la nazione</option>
																	<?php
																		$selectHtml = "";
																		foreach($countryList as $aCountry) {
																			if($aCountry["code"] == $row['country_code']) {
																				$selectHtml = " selected ";
																			} else {
																				$selectHtml = "";
																			}
																			echo "<option value='{$aCountry["code"]}' {$selectHtml}>{$aCountry["name"]} ({$aCountry["code"]})</option>";
																		}
																	?>
																</select>
															</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                           <div class="form-group">
																<label class="control-label">Numero cellulare 
                                                                </label>
																<input type="text" id="phone_number" name="phone_number" class="form-control" value="<?php echo $row['phone_number']; ?>"/>
															</div>
                                                        </div>
                                                    </div> -->
                                                    <!--<div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="ckbox ckbox-success">
                                                                    <input type="checkbox" id="checkboxSuccess2" value="1" name="is_whatsapp_message" <?php if($row['is_whatsapp_message'] == 1) echo " checked ";?> />
                                                                    <label for="checkboxSuccess2">Comunicazioni via WhatsApp</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            
                                                        </div>
                                                    </div>-->

                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <h5>Change Password</h5>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Password:</label>
                                                                <input type="password" class="form-control" name="newpass" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Confirm password:</label>
                                                                <input type="password" class="form-control" name="repass"/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="submit" name="save" class="btn btn-success " value="Save">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="col-md-6"></br>
                                                            <h5>Delete Account</h5>
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="submit" onclick="return confirm('Are you sure you want to delete your account?');" name="delete" class="btn btn-danger" value="Delete me">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <span>(The credit will not be refunded)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <script src="js/jquery-1.10.2.min.js"></script>
            <script src="js/jquery-migrate-1.2.1.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/modernizr.min.js"></script>
            <script src="js/jquery.sparkline.min.js"></script>
            <script src="js/toggles.min.js"></script>
            <script src="js/retina.min.js"></script>
            <script src="js/jquery.cookies.js"></script>

            <script src="js/flot/flot.min.js"></script>
            <script src="js/flot/flot.resize.min.js"></script>
            <script src="js/morris.min.js"></script>
            <script src="js/raphael-2.1.0.min.js"></script>

            <script src="js/jquery.datatables.min.js"></script>
            <script src="js/chosen.jquery.min.js"></script>

            <script src="js/custom.js"></script>
            <script src="js/dashboard.js"></script>

    </body>
</html>