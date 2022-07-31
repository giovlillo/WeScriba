<?php
include_once('mysql-fix.php');
include ('include/dashboard.php');
include ('include/translation.php');
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
        <script>
            $(document).ready(function () {
                $('#large').dataTable({
                    "sPaginationType": "full_numbers",
                    "iDisplayLength": 5,
                    "oLanguage": {
                        "sInfo": "Showing _START_ to _END_ of _TOTAL_ jobs",
                        "sEmptyTable": "No print job list",
                        "sInfoEmpty": "Showing 0 to 0 of 0 jobs",
                        "sSearch": "Search:",
                        "sLengthMenu": "Showing _MENU_ jobs",
                        "oPaginate": {
                            "sFirst": "First",
                            "sPrevious": "Previous",
                            "sNext": "Next",
                            "sLast": "Last"
                        },
                    },
                    "aoColumnDefs": [
                        {
                            "bSortable": false,
                            "aTargets": [-1]
                        }
                    ]

                });
            });
        </script>
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
                            <li><a href="account-preference.php"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                            <li><a href="help.php"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                            <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
                        </ul>
                    </div>

                    <h5 class="sidebartitle">Menu</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li><a href="print_job_list.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li><a href="print-now.php"><i class="fa fa-envelope-o"></i> <span>Print Now</a></li>
                        <li class="active"><a href="#"><i class="fa fa-edit"></i> <span>Print Jobs</span></a></li>
                        <li><a href="#"><i ></i> <span></span></a></li>
                        <li ><a href="buy-now.php"><i class="fa fa-th-list"></i> <span>Buy Now</span></a></li>
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

                <div class="pageheader">
                    <h2><i class="fa fa-table"></i> Print Job List</h2>
                </div>
                <div class="contentpanel">
                    <div class="table-responsive">
                        <table id="large" class="table">
                            <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Pages</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <?php
                                $sql = "SELECT job_id, number_of_pages, print_type, file_type, number_of_pages, copies, stauts, date,
                                        color, paper_size, orientation, print_type
                                        FROM print_job WHERE user_id = '" . $_SESSION['user_id'] . "' AND `stauts` != 'Deleted'";
                                $result = mysql_query($sql);
                                $i = 1;
                                while ($row = mysql_fetch_array($result)) {
                                    $formattedDate = date("Y-m-d H:i", strtotime($row["date"]));
                                    
                                    $color = $translateWords['it'][$row["color"]];
                                    $printType = $translateWords['it'][$row["print_type"]];
                                    $orientation = $translateWords['it'][$row["orientation"]];
                                                    
                                       echo "<tr data-color='{$color}' data-paper-size='{$row["paper_size"]}' data-print-type='{$printType}' data-file-type='{$row["file_type"]}' data-orientation='{$orientation}' data-date='{$formattedDate}'>";
                                        echo "<td>{$row["job_id"]}</td>";
                                        echo "<td>{$row["number_of_pages"]}</td>";
                                        if($row['stauts']=="Pending"){echo "<td>Pending</td>"; } elseif($row['stauts']=="Working"){echo "<td>Working</td>";}elseif($row['stauts']=="<td>Canceled</td>"){echo "<td>Canceled</td>";} elseif($row['stauts']=="Completed"){echo "<td>Completed</td>";} else{echo "<td>Deleted</td>";};
                                        echo "<td><a class='btn-sm btn-success showJobDetails'> Details</a></td>";
                                        echo "</tr>";
                                }
                            
                            ?>
                        </table>

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
    
    <!-- Modal -->
    <div class="modal fade" id="jobDetailsModal" tabindex="-1" role="dialog" aria-labelledby="jobDetailsModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Printing Details</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p><b>Type:</b> <span class="jobColorInModal">-</span></p>
                        <p><b>Paper Size:</b> <span class="jobPaperSizeInModal">-</span></p>
                        <p><b>Print Type:</b> <span class="jobPrintTypeInModal">-</span></p>
                        <p><b>File Format:</b> <span class="jobFileTypeInModal">-</span></p>
                        <p><b>Orientation:</b> <span class="jobOrientationInModal">-</span></p>
                        <p><b>Date:</b> <span class="jobDateInModal">-</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='glyphicon glyphicon-remove'></i> Close</button>
                </div>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    
    <script type="text/javascript">
        $(document).ready(function() {
            $(".table").on("click",".showJobDetails", function() {
				var currTrObj = $(this).parent().parent();
                $(".jobColorInModal").text(currTrObj.data("color"));
                $(".jobPaperSizeInModal").text(currTrObj.data("paperSize"));
                $(".jobPrintTypeInModal").text(currTrObj.data("printType"));
                $(".jobFileTypeInModal").text(currTrObj.data("fileType"));
                $(".jobOrientationInModal").text(currTrObj.data("orientation"));
                $(".jobDateInModal").text(currTrObj.data("date"));
                
                $("#jobDetailsModal").modal();
			});
        });
    </script>
    
    <style>
        .showJobDetails {
            cursor: pointer;
        }
    </style>
    
</html>