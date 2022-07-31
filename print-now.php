<?php
include_once('mysql-fix.php');
include ('include/dashboard.php');

unset($_SESSION["printDetails"]); // remove all saved print details //

$result = mysql_query("SELECT `enable_color`,`enable_a3`,`enable_2_sided`,`enable_booklet`, a4_price, a3_price_margin, colored_price_margin FROM `system_preference`");
$systemPref = mysql_fetch_array($result);

$result = mysql_query("SELECT `credits` from users where `user_id`=" . $_SESSION['user_id'] . "");
$row = mysql_fetch_array($result);
$credits = $row['credits'];
?>
<!DOCTYPE html>
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
                        <li class="active"><a href="#"><i class="fa fa-envelope-o"></i> <span>Print Now</a></li>
                        <li><a href="print_job_list.php"><i class="fa fa-edit"></i> <span>Print Jobs</span></a></li>
                        <li><a href="#"><i ></i> <span></span></a></li>
                        <li><a href="buy-now.php"><i class="fa fa-th-list"></i> <span>Buy Now</span></a></li>
                        <li><a href="account-preference.php"><i class="fa fa-map-marker"></i> <span>Account Preference</span></a></li> 

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
                            <h2><i class="fa fa-table"></i>Print your Documents</h2>
                        </div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">  
                                    <h2 class="panel-title">Print your Documents</h2>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="print_now_confirmation.php" id="printForm" enctype="multipart/form-data">
                                        <?php
                                        if (isset($_SESSION["msg"])) {
                                            if ($_SESSION["msg"] == "Invalid file") {
                                                echo '<div class="alert alert-danger"> Invalid File Type. Please upload valid file type.</div>';
                                            } elseif ($_SESSION["msg"] == "Done") {
                                                echo '<div class="alert alert-success"> Your file has been saved successfully!!</div>';
                                            } elseif ($_SESSION["msg"] == "Error") {
                                                echo '<div class="alert alert-danger">Error: ' . $_FILES["file"]["error"] . '<br></div>';
                                            } elseif ($_SESSION["msg"] == "notsaved") {
                                                echo '<div class="alert alert-danger">An error has occurred. Please contact administrator for help.</div>';
                                            } elseif ($_SESSION["msg"] == "nocredit") {
                                                echo '<div class="alert alert-warning">Insufficient credit. Recharge your credit to continue.</div>';
                                            }  else if($_SESSION["msg"] == "uploadLimitError") {
												echo "<div class='alert alert-warning'>The maximum upload limit has been reached: {$maxUploadLimit} MB, please contact your printing center.</div>";		
											}
											unset($_SESSION["msg"]);
                                        }
                                        ?>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-1">File</div>
                                                <div class="col-sm-4"><input type="file" class='btn btn-default' name="file" value=""></div>
                                                <div class="col-sm-2"><input type="submit" value="Print" name="printSubmitBtn" class="btn btn-success mobileTopMargin"></div>
												
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border"><br />Supported File Type</legend>
                                                        <img src="images/user/pdf.png" alt="PDF" />
                                                        <img src="images/user/docxico.png" alt="DOCX" />
                                                        <img src="images/user/powerpoint.png" alt="PPTX" />                                                       
                                                    </fieldset>
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border">
                                                            <br />Credit
                                                        </legend>
                                                        Credits available: 
                                                        <input type="text" value="<?php echo $credits; ?>" disabled="disabled" class="ipbox2 form-control">
                                                        <div class="orfont"><a style="text-decoration:none; color:red;" href="buy-now.php" >ADD CREDITS</a></div>
                                                    </fieldset>

                                                </div>
                                                <div class="col-md-6 form-horizontal">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border"><br/>Print Properties</legend>
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label class="col-xs-3 control-label">Color Type:</label>
                                                                <div class="col-xs-9">
                                                                    <select name="color" id="color" class='form-control'>
                                                                        <option value="bw">B/W</option>
                                                                        <?php
                                                                        if ($systemPref['enable_color']) {
                                                                            echo "<option value='color'>Color</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label class="col-xs-3 control-label">Paper Size:</label>
                                                                <div class="col-xs-9">
                                                                    <select id="paper_size" name="paper_size" class='form-control'>
                                                                        <option value="A4">A4</option>
                                                                        <?php
                                                                        if ($systemPref['enable_a3']) {
                                                                            echo "<option value='A3'>A3</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label class="col-xs-3 control-label">Orientation:</label>
                                                                <div class="col-xs-9">
                                                                    <select name="orientation" id="orientation" class='form-control'>
                                                                        <option value="portrait">Portrait </option>
                                                                        <option value="landscape">Landscape</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label class="col-xs-3 control-label">Print Type:</label>
                                                                <div class="col-xs-9">
                                                                    <select name="print_type" id="print_type" class='form-control'>
                                                                        <option value="1-sided">1-Sided</option>
                                                                        <?php
                                                                        if ($systemPref['enable_2_sided']) {
                                                                            echo "<option value='2-sided'>2-Sided</option>";
                                                                        }
                                                                        if ($systemPref['enable_booklet']) {
                                                                            echo "<option value='booklet'>Booklet</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <div class="col-xs-3 control-label">Copies:</div>
                                                                <div class="col-xs-9">
                                                                    <select name="copies" id="copies" class='form-control'>
                                                                        <?php 
                                                                            for($i=1; $i<=10; $i++) {
                                                                                echo "<option value='{$i}'>{$i}</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
        <script src="js/jquery.sparkline.min.js"></script>
        <script src="js/toggles.min.js"></script>
        <script src="js/retina.min.js"></script>
        <script src="js/jquery.cookies.js"></script>
        <script src="js/morris.min.js"></script>
        <script src="js/raphael-2.1.0.min.js"></script>
        <script src="js/jquery.datatables.min.js"></script>
        <script src="js/chosen.jquery.min.js"></script>
        <script src="js/custom.js"></script>
        
    </body>
</html>