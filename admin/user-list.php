<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../images/favicon/favicon.ico" type="image/png">
        <title>Print Center - print your documents online</title>
        <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> ORIGINAL-->
        <link href="../css/style.default.css" rel="stylesheet">
        <link href="../css/style.inverse.css" rel="stylesheet">
        <link href="../css/jquery.datatables.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>

        <style>
            #large th {
                padding-right: 15px !important;
            }
        </style>

        <script>

            $(document).ready(function () {

                var userTable = $('#large').dataTable({
                    "responsive": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayLength": 5,
                    "oLanguage": {
                        "sInfo": "Showing _START_ to _END_ of _TOTAL_ users",
                        "sEmptyTable": "No users listed",
                        "sInfoEmpty": "Showing 0 to 0 of 0 users",
                        "sSearch": "Search:",
                        "sLengthMenu": "Showing _MENU_ users",
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

                $("body").on("click", ".lnk", function (event) {

                    var _this = $(this);

                    if (confirm("User will be deleted. press OK to confirm.")) {

                        $.ajax({
                            type: "POST",
                            url: "deactivate-user.php",
                            data: {"user": $(this).attr('id')},
                            dataType: 'HTML',
                            success: function (data) {

                                if (data == "Error") {

                                    $("#msg").html("An error has occurred. Try later.");

                                    $("#msg").parents(".alert").removeClass("alert-success").addClass("alert-danger").fadeIn();

                                } else {

                                    $("#msg").html("User successfully deleted.");

                                    $("#msg").parents(".alert").removeClass("alert-danger").addClass("alert-success").fadeIn();

                                    var aPos = userTable.fnGetPosition(_this.closest('tr').get(0));
                                    userTable.fnDeleteRow(aPos);
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
                            <img alt="" src="../images/photos/user01.jpg" class="media-object">
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
                        <li><a href="print-list.php"><i class="glyphicon glyphicon-list"></i> <span>Print Jobs</a></li>
                        <li class="active"><a href="user-list.php"><i class="glyphicon glyphicon-user"></i> <span>User List</span></a></li>
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
                    <h2><i class="fa fa-table"></i>User List</h2>
                </div>
                <div class="alert" style="display: none;">
                    <a href="#" class="close" aria-label="close">&times;</a>
                    <span id="msg">No message.</span>
                </div>
                <div class="contentpanel">
                    <div class="">
                        <table id="large" class="table responsive" style='width:100%;'>
                            <thead>
                                <tr>

                                    <th class="all">ID</th>
                                    <th class="desktop">Name</th>
                                    <th class="desktop">Surname</th>
                                    <th class="all">Username</th>
                                    <th class="desktop">Registration Date</th>
                                    <th class="all">Status</th>
                                    <th class="all">Credits</th>
                                    <th class="all">Option</th>
                                </tr>
                            </thead>



                            <?php
                            $sql = "SELECT user_id, name, surname, active, credits, registration_date, user_name FROM users WHERE type != 'admin'";

                            $result = mysql_query($sql);

                            $i = 1;

                            while ($row = mysql_fetch_array($result)) {

                                if ($i++ % 2 == 0) {
                                    ?>

                                    <tr >

                                        <td><?php echo $row['user_id']; ?></td>

                                        <td><?php echo $row['name']; ?></td>

                                        <td><?php echo $row['surname']; ?></td>

                                        <td><?php echo $row['user_name']; ?></td>

                                        <td><?php echo $row['registration_date']; ?></td>

                                        <td><?php
                                            if ($row['active'] == "1") {
                                                echo "<img src='../images/admin/active.png' alt='Active' height='32' witdth='32'>";
                                            } else {
                                                echo "<img src='../images/admin/delete.png' alt='Delete' height='32' witdth='32'>";
                                            }
                                            ?></td>
                                        <td><?php echo $row['credits']; ?></td>
                                        <td><a href="add-credit.php?user=<?php echo $row['user_id']; ?>" name="credit" class="btn btn-primary credit">Credits</a>

                                            <a id="<?php echo $row['user_id']; ?>" class="btn btn-danger lnk">Delete</a></td>

                                    </tr>

                                    <?php
                                } else {
                                    ?>

                                    <tr>

                                        <td><?php echo $row['user_id']; ?></td>

                                        <td><?php echo $row['name']; ?></td>

                                        <td><?php echo $row['surname']; ?></td>

                                        <td><?php echo $row['user_name']; ?></td>

                                        <td><?php echo $row['registration_date']; ?></td>

                                        <td><?php
                                            if ($row['active'] == "1") {
                                                echo "<img src='../images/admin/active.png' alt='Active' height='32' witdth='32'>";
                                            } else {
                                                echo "<img src='../images/admin/delete.png' alt='Delete' height='32' witdth='32'>";
                                            }
                                            ?></td>
                                        <td><?php echo $row['credits']; ?></td>

                                        <td><a href="add-credit.php?user=<?php echo $row['user_id']; ?>" name="credit" class="btn btn-primary credit">Credits</a>

                                            <a id="<?php echo $row['user_id']; ?>" class="btn btn-danger lnk">Delete</a></td>

                                    </tr>

                                    <?php
                                }
                            }
                            ?>

                        </table>

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

        <script src="../js/jquery.dataTables.js"></script>
        <script src="../js/dataTables.responsive.js"></script>
        <script src="../js/chosen.jquery.min.js"></script>

        <script src="../js/custom.js"></script>
        <script src="../js/dashboard.js"></script>

    </body>
</html>