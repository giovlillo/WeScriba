<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');

$result = mysql_query("select * from system_preference");
$systemPref = mysql_fetch_array($result);
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
        <script type="text/javascript" language="javascript" src="../js/validate.js"></script>
        <script>

            $(document).ready(function () {
                var userTable = $('#large').dataTable({
                    "responsive": true,
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
                    "aoColumns": [
                        null,
                        null,
                        null,
                        {"bSortable": false},
                        null,
                        {"bSortable": false},
                        {"bSortable": false},
                    ]

                });

                $("body").on("click", ".lnk", function () {

                    var _this = $(this);

                    if (confirm("Do you want to delete it? Press OK to confirm.")) {

                        $.ajax({
                            type: "POST",
                            url: "deactive-job.php",
                            data: {"job": $(this).attr('id')},
                            dataType: 'HTML',
                            success: function (data) {

                                if (data == "Error") {

                                    $("#msg").html("An error has occurred! Try later.");

                                    $("#msg").parents(".alert").removeClass("alert-success").addClass("alert-danger").fadeIn();

                                } else {

                                    $("#msg").html("File successfully deleted.");

                                    $("#msg").parents(".alert").removeClass("alert-danger").addClass("alert-success").fadeIn();

                                    //$("." + _this.attr("id") + "").val("Deleted");
                                    //$("." + _this.attr("id") + "").prop('disabled', true);
                                }

                                setTimeout(function () {
                                    $("#msg").parents(".alert").fadeOut();
                                }, 2000);

                            }

                        });

                    }

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

                    <h5 class="sidebartitle">Menu</h5>
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
                    <h2><i class="fa fa-table"></i>Print Jobs</h2>
                </div>
                <div class="alert" style="display: none;">
                    <a href="#" class="close" aria-label="close">&times;</a>
                    <span id="msg">No message.</span>
                </div>
                <div class="contentpanel">
                    <div class="">
                        <table id="large" class="table responsive printListTable" style='width:100%;'>
                            <thead>
                                <tr>
                                    <th class="desktop">ID</th>
                                    <th class="all">Username</th>
                                    <th class="all">Pages</th>								
                                    <th class="all">Status</th>
                                    <th class="all">Date</th>
                                    <th class="all">Details</th>
                                    <th class="all">Option</th>
                                    <th class="all">Email</th>
                                </tr>
                            </thead>
                            <?php
                            $cntr = 0;

                            $sql = "SELECT p.job_id, p.number_of_pages, p.color, p.file_path, p.print_type, p.stauts, p.orientation, p.date, u.user_name, u.name, u.surname, u.is_whatsapp_message, u.country_code, u.phone_number

                                    FROM print_job p, users u

                                    WHERE p.user_id = u.user_id order by p.job_id desc";

                            $result = mysql_query($sql);

                            while ($row = mysql_fetch_array($result)) {
                                $cntr++;

                                $downloadAndDeleteBtnClass = "";
                                if ($row["stauts"] == "Completed" || $row["stauts"] == "Deleted" || $row["stauts"] == "Canceled") {
                                    $downloadAndDeleteBtnClass = "disabled";
                                }

                                $formattedDate = date("Y-m-d H:i", strtotime($row["date"]));

                                if ($cntr % 2 == 0) {
                                    $trClass = "tr-event";
                                } else {
                                    $trClass = "tr-odd";
                                }
                                ?>

                                <tr class="<?php echo $trClass; ?>" id='<?php echo $row['job_id']; ?>'>

                                    <td><?php echo $row['job_id']; ?></td>

                                    <td>
                                        <span data-placement="top" data-toggle="tooltip" class="tooltips" data-original-title="<?php echo "{$row["name"]} {$row["surname"]}"; ?>">
                                            <?php echo $row['user_name']; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span data-placement="top" data-toggle="tooltip" class="tooltips" data-original-title="<?php echo "{$row["color"]}-{$row["print_type"]}-{$row["orientation"]}"; ?>">
                                            <?php echo $row['number_of_pages']; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <select class="<?php echo $row['job_id']; ?> form-control" id="curJobStatus" onChange='update_status(this)' <?php
                                        if ($row['stauts'] == "Deleted" || $row['stauts'] == "Completed" || $row["stauts"] == "Canceled") {
                                            echo "disabled='disabled'";
                                        }
                                        ?>>

                                            <option value="Pending" <?php
                                            if ($row['stauts'] == "Pending") {
                                                echo "selected";
                                            }
                                            ?>>Pending</option>

                                            <option value="Working" <?php
                                            if ($row['stauts'] == "Working") {
                                                echo "selected";
                                            }
                                            ?>>Working</option>

                                            <option value="Canceled" <?php
                                            if ($row['stauts'] == "Canceled") {
                                                echo "selected";
                                            }
                                            ?>>Canceled</option>

                                            <option value="Completed" <?php
                                            if ($row['stauts'] == "Completed") {
                                                echo "selected";
                                            }
                                            ?>>Completed</option>

                                            <option value="Deleted" <?php
                                            if ($row['stauts'] == "Deleted") {
                                                echo "selected";
                                            }
                                            ?>>Deleted</option>

                                        </select> 
                                    </td>

                                    <td><?php echo $formattedDate; ?></td>
                                                                                                  
                                    <td><a class='btn-sm btn-success showJobDetails'> Details</a></td>

                                    <td>
                                        <a href='download.php?download_file=<?php echo $row['file_path']; ?>' id="lnk" class="btn-xs btn-default btn <?php echo $downloadAndDeleteBtnClass; ?> <?php echo "job_download_{$row['job_id']}"; ?>">Download</a>
                                        <a href="#" id="<?php echo $row['job_id']; ?>" class="btn-xs btn-danger lnk btn <?php echo $downloadAndDeleteBtnClass; ?> <?php echo "job_delete_{$row['job_id']}"; ?>">Delete</a>
                                    </td>


                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-warning">Email</button>
                                            <button type="button" class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" style="min-height: 27px;">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#" onclick='get_job_id(this)'>Complete</a></li>
                                                <li><a href="#" onclick='problem_link(this)'>Problem</a></li>
                                            </ul>
                                        </div>
                                        <!--whatsapp code -->
                                    </td>

                                </tr>

                                <?php
                            }
                            ?>

                        </table>

                    </div>
                </div>
            </div>
            
            <textarea class="hidden" id="whatsappCompleteTxt"><?php echo $systemPref["whatsapp_complete_text"];?></textarea>
            <textarea class="hidden" id="whatsappErrorTxt"><?php echo $systemPref["whatsapp_complete_text"];?></textarea>
            
        </section>


        <script src="../js/jquery-1.10.2.min.js"></script>
        <script src="../js/jquery-migrate-1.2.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/modernizr.min.js"></script>
        <script src="../js/jquery.sparkline.min.js"></script>
        <script src="../js/toggles.min.js"></script>
        <script src="../js/retina.min.js"></script>
        <script src="../js/jquery.cookies.js"></script>
        <script src="../js/morris.min.js"></script>
        <script src="../js/raphael-2.1.0.min.js"></script>
        <script src="../js/jquery.dataTables.js"></script>
        <script src="../js/dataTables.responsive.js"></script>
        <script src="../js/chosen.jquery.min.js"></script>
        <script src="../js/custom.js"></script>

    </body>
    
    <style>
        .dropdown-menu {
            min-width: 140px !important;
        }
        .hidden {
            display: none;
        }
    </style>
    
    <!--whatsapp script -->
    
</html>