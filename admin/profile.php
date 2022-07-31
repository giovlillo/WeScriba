<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');

if(isset($_POST["profileUpdateSubmit"])) {
    $password = $_POST["password"];
    $name = $_POST["name"];
    $surname = $_POST["sname"];
    $user_email_address = $_POST["user_email_address"];
    
    $query = "update users set name = '{$name}', surname = '{$surname}', user_email_address = '{$user_email_address}' ";
    if(strlen($password) != 0) {
        $hashedPass = md5($password);
        $query .= " ,password = '{$hashedPass}'";
    }
    $query .= " where user_id = {$_SESSION["user_id"]}";
    $res = mysql_query($query);
    if($res !== FALSE) {
        $msg = "success";
    } else {
        $msg = "error";
    }
}

$result = mysql_query("SELECT * from users where user_id = {$_SESSION['user_id']}");
$row = mysql_fetch_array($result);
        
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../images/favicon/favicon.ico" type="image/png">
        <title>Print Center - print your documents online</title>
        <link href="../css/style.default.css" rel="stylesheet">
        <link href="../css/style.inverse.css" rel="stylesheet">
        <link href="../css/jquery.datatables.css" rel="stylesheet">
        <link href="../css/custom.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/validate.js"></script>

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
                            <img alt="" src="/images/photos/user01.jpg" class="media-object">
                            <div class="media-body">
                                <h4><?php echo $_SESSION["user_name"]; ?></h4>

                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">Account</h5>
                        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                            <li><a href="account-preference.php"><i class="fa fa-user"></i> <span>My Profile</span></a></li>
                            <li><a href="#"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
                            <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Log out</span></a></li>
                        </ul>
                    </div>

                    <h5 class="sidebartitle">MENU</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li><a href="home.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li class="active"><a href="#"><i class="glyphicon glyphicon-list"></i> <span>Print Jobs</a></li>
                        <li><a href="user-list.php"><i class="glyphicon glyphicon-user"></i> <span>User List</span></a></li>
                        <li><a href="#"><i ></i> <span></span></a></li>
                        <li><a href="system-preference.php"><i class="glyphicon glyphicon-check"></i> <span>System Preferences</span></a></li> 

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
                                        <img src="../images/photos/user01.jpg" alt="" /><span><?php echo $_SESSION["user_name"]; ?></span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                        <li><a href="profile.php"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                                        <li><a href="help.php"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                                        <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div><!-- header-right -->   
                </div><!-- headerbar -->

                <div class="pageheader">
                    <h2><i class="fa fa-table"></i>My Profile</h2>
                </div>
                <div class="alert" style="display: none;">
                    <a href="#" class="close" aria-label="close">&times;</a>
                    <span id="msg">No message.</span>
                </div>
                <div class="contentpanel">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Update profile</h2>
                        </div> 
                        <div class="panel-body">
                            <form action="" method="post">
                                <table id="large" class="tablesorter" style="width: 99%;">
                                    <tr>
                                        <td>

                                            <?php
                                            if (isset($msg)) {
                                                if ($msg == "success") {
                                                    echo '<div class="alert alert-success"> Dati My Profile aggiornati con successo.</div>';
                                                } elseif ($msg = "error") {
                                                    echo '<div class="alert alert-danger">Si e\' verificato un problema. Riprova piu\' tardi.</div>';
                                                }
                                            }
                                            ?>				
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Username:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="user_name" value="<?php echo $row['user_name'] ?>" disabled />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="name" value="<?php echo $row['name'] ?>" required=""/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Surname:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="sname" value="<?php echo $row['surname'] ?>" required=""/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Email:</label>
                                                    <div class="col-sm-6">
                                                        <input type="email" name="user_email_address" class="form-control" value="<?php echo $row['user_email_address'] ?>" required=""/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Password:</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="password" class="form-control" value=""/>
                                                        <p class="help-text">Leave the field blank if you don't want to change your password.</p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-6">
                                                        <input type="submit" name="profileUpdateSubmit" class="btn btn-success"/>
                                                    </div>
                                                </div>
                                            </div>     
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="../js/jquery-migrate-1.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/modernizr.min.js"></script>
        <script src="../js/jquery.sparkline.min.js"></script>
        <script src="../js/toggles.min.js"></script>
        <script src="../js/retina.min.js"></script>
        <script src="../js/jquery.cookies.js"></script>

        <script src="../js/flot/flot.min.js"></script>
        <script src="../js/flot/flot.resize.min.js"></script>
        <script src="../js/morris.min.js"></script>
        <script src="../js/raphael-2.1.0.min.js"></script>

        <script src="../js/jquery.datatables.min.js"></script>
        <script src="../js/chosen.jquery.min.js"></script>

        <script src="../js/custom.js"></script>
        <script src="../js/dashboard.js"></script>

    </body>
</html>