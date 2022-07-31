<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');
include ('../include/config.php');
include ('../include/utility.php');

$q = "select ifnull(sum(number_of_pages*copies), 0) as totalBw from print_job pj where pj.color = 'bw' and stauts = 'Completed'";
$row = mysql_fetch_array(mysql_query($q));
$totalBw = $row['totalBw'];

$q = "select ifnull(sum(number_of_pages*copies), 0) as totalColored from print_job pj where pj.color != 'bw' and stauts = 'Completed'";
$row = mysql_fetch_array(mysql_query($q));
$totalColored = $row['totalColored'];

$q = "select ifnull(sum(price), 0) as totalEarning from print_job pj where stauts = 'Completed'";
$row = mysql_fetch_array(mysql_query($q));
$totalEarning = $row['totalEarning'];

$usedMemory = (getDirectorySize("../user_files/")/($maxUploadLimit*1024*1024))*100;

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
        <link href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
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
                            <img alt="" src="../images/photos/user01.jpg" class="media-object">
                            <div class="media-body">
                                <h4><?php echo $_SESSION["user_name"]; ?></h4>

                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">Account</h5>
                        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                            <li><a href="account-preference.php"><i class="fa fa-user"></i> <span>My Profile</span></a></li>
                            <li><a href="help.php"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
                            <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Log out</span></a></li>
                        </ul>
                    </div>

                    <h5 class="sidebartitle">Menu</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li class="active"><a href="home.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li><a href="print-list.php"><i class="glyphicon glyphicon-list"></i> <span>Print Jobs</a></li>
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
                    <h2><i class="fa fa-table"></i>Dashboard</h2>
                </div>
                <div class="alert" style="display: none;">
                    <a href="#" class="close" aria-label="close">&times;</a>
                    <span id="msg">No message.</span>
                </div>
                <div class="contentpanel">
                    <div class="row">

                        <div class="col-sm-6 col-md-4">
                            <div class="panel panel-success panel-stat">
                                <div class="panel-heading">

                                    <div class="stat">
                                        <div class="row text-center">
                                            <div class="col-xs-4">
                                                <img src="../images/is-document.png" alt="" />
                                            </div>
                                            <div class="col-xs-8">
                                                <small class="stat-label">TOTAL B/W PRINTED PAGES</small>
                                                <h1><?php echo $totalBw?></h1>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- stat -->

                                </div><!-- panel-heading -->
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->

                        <div class="col-sm-6 col-md-4">
                            <div class="panel panel-danger panel-stat">
                                <div class="panel-heading">

                                    <div class="stat">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <img src="../images/is-document.png" alt="" />
                                            </div>
                                            <div class="col-xs-8">
                                                <small class="stat-label">TOTAL COLOR PAGES PRINTED</small>
                                                <h1><?php echo $totalColored; ?></h1>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- stat -->

                                </div><!-- panel-heading -->
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->

                        <div class="col-sm-6 col-md-4">
                            <div class="panel panel-primary panel-stat">
                                <div class="panel-heading">

                                    <div class="stat">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <img src="../images/is-money.png" alt="" />
                                            </div>
                                            <div class="col-xs-8">
                                                <small class="stat-label">Total Credits Earned</small>
                                                <h1><?php echo $totalEarning; ?></h1>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- stat -->

                                </div><!-- panel-heading -->
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                    </div><!-- row -->

                    <div class="row">
                        <div class="col-md-12 mb30">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h5 class="subtitle mb5">Percentage of storage space used</h5>
                                    <h5 class="subtitle mb5">Total: <?php echo $maxUploadLimit;?> MB</h5>
                                    <div id="piechart" style="width: 100%; height: 300px"></div>
                                </div><!-- panel-body -->
                            </div><!-- panel -->

                        </div><!-- col-sm-3 -->

                    </div><!-- row -->
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
        <script src="../js/flot/flot.symbol.min.js"></script>
        <script src="../js/flot/flot.crosshair.min.js"></script>
        <script src="../js/flot/flot.categories.min.js"></script>
        <script src="../js/flot/flot.pie.min.js"></script>
        <script src="../js/morris.min.js"></script>
        <script src="../js/raphael-2.1.0.min.js"></script>

        <script src="../js/custom.js"></script>
        <!--<script src="../js/charts.js"></script>-->
        
        <script type="text/javascript">
            $(document).ready(function() {
                var piedata = [
                    { label: "Used", data: [[1,<?php echo $usedMemory;?>]], color: '#D9534F'},
                    { label: "Free", data: [[1,<?php echo (100-$usedMemory);?>]], color: '#1CAF9A'},
                     ];

                jQuery.plot('#piechart', piedata, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 2/3,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                });

                function labelFormatter(label, series) {
                            return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
                    }
            });
        </script>

    </body>
</html>