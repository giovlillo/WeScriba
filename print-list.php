<?php
include_once('mysql-fix.php');
include ('include/dashboard.php');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="img/favicon.ico" type="image/png">
        <title>Print Center - print your documents online</title>
        <link href="css/style.default.css" rel="stylesheet">
        <link href="css/style.inverse.css" rel="stylesheet">
        <link href="css/jquery.datatables.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script>
            $(document).ready(function () {
                $('#large').dataTable({
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
                    "aoColumnDefs": [
                        {
                            "bSortable": false,
                            "aTargets": [-1]
                        }
                    ]

                });
                $(".lnk").click(function () {
                    if ($("." + $(this).attr("id") + "").html() == "Pending")
                    {
                        if (confirm("This job will be deleted. Press ok to confirm.")) {
                            $.ajax({
                                type: "POST",
                                url: "deactivate-job.php",
                                data: {"job": $(this).attr('id')},
                                dataType: 'HTML',
                                success: function (data) {
                                    if (data == "Error") {
                                        $("#msg").html("Error occured while removing job! Please try after some time.");
                                        $("#msg").addClass("red-box");
                                        $("#msg").css("display", "block");
                                    } else {
                                        $("#msg").html("Job has been removed successfully.");
                                        $("#msg").addClass("green-box");
                                        $("#msg").css("display", "block");
                                        $("#main-table").html(data);
                                        $('#large').dataTable({
                                            "sPaginationType": "full_numbers",
                                            "iDisplayLength": 5,
                                            "aoColumnDefs": [
                                                {
                                                    "bSortable": false,
                                                    "aTargets": [-1]
                                                }
                                            ]
                                        });
                                    }
                                }
                            });
                        }
                    } else
                    {
                        alert('You can not Delete this job.');
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

                    <h5 class="sidebartitle">Menù</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li><a href="print-list.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li><a href="print-now.php"><i class="fa fa-envelope-o"></i> <span>Print Now</a></li>
                        <li class="active"><a href="#"><i class="fa fa-edit"></i> <span>Print Jobs</span></a></li>
                        <li><a href="print_job_list.php"><i class="fa fa-th-list"></i> <span>Print Job List</span></a></li>
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
                    <h2><i class="fa fa-table"></i> Elenco lavori</h2>
                </div>
                <div class="contentpanel">
                    <div class="">
                        <table id="large" class="table responsive" style='width:100%;'>
                            <thead>
                                <tr>
                                    <th class="all">Job ID</th>
                                    <th class="all">Pagine</th>
                                    <th class="desktop">F/R</th>
                                    <th class="all">Copie</th>
                                    <th class="desktop">Orientamento</th>
                                    <th class="all">Status</th>
                                    <th class="desktop">Data</th>
                                    <th class="all">Download</th>
                                    <th class="desktop">Est.</th>                                   
                                </tr>
                            </thead>
                            <?php
                            $sql = "SELECT job_id, number_of_pages, print_type, file_type, number_of_pages, copies, orientation,stauts, date, file_path FROM print_job WHERE user_id = '" . $_SESSION['user_id'] . "' AND `stauts` != 'Deleted'";
                            $result = mysql_query($sql);
                            $i = 1;
                            while ($row = mysql_fetch_array($result)) {

                                if ($i++ % 2 == 0) {
                                    ?>
                                    <tr class="tr-even">
                                        <td>
                                            <?php echo $row['job_id']; ?>
                                        </td>                               
                                        <td>
                                            <?php echo $row['number_of_pages']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['print_type'] == "1-sided") {
                                                echo "1-lato";
                                            } else {
                                                echo "2-lati";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['copies']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['orientation'] == "portrait") {
                                                echo "<img src='img/portrait.png' alt='Portrait' height='32' witdth='32'>";
                                            } else {
                                                echo "<img src='img/landscape.png' alt='Landscape' height='32' witdth='32'>";
                                            }
                                            ?>
                                        </td>
                                        <td class="<?php echo $row['job_id']; ?>">
                                            <?php
                                            if ($row['stauts'] == "Pending") {
                                                echo "In attesa";
                                            } elseif ($row['stauts'] == "Working") {
                                                echo "In lavorazione";
                                            } elseif ($row['stauts'] == "Canceled") {
                                                echo "Annullato";
                                            } elseif ($row['stauts'] == "Completed") {
                                                echo "Completato";
                                            } else {
                                                echo "Eliminato";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['date']; ?>
                                        </td> 
                                        <th>
                                            <a href='download.php?download_file=<?php echo $row['file_path']; ?>' class='btn-sm btn-default'>Download</a>
                                        </th>                   
                                        <td>
                                            <?php
                                            if ($row['file_type'] == "pdf") {
                                                echo "<img src='img/pdf_user.png' alt='PDF' height='32' witdth='32'>";
                                            } elseif ($row['file_type'] == "docx") {
                                                echo "<img src='img/docx_user.png' alt='DOCX' height='32' witdth='32'>";
                                            } else {
                                                echo "<img src='img/pptx_user.png' alt='PPTX' height='32' witdth='32'>";
                                            }
                                            ?>
                                        </td>							
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr class="tr-odd">
                                        <td>
                                            <?php echo $row['job_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['number_of_pages']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['print_type'] == "1-sided") {
                                                echo "1-lato";
                                            } else {
                                                echo "2-lati";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['copies']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['orientation'] == "portrait") {
                                                echo "<img src='img/portrait.png' alt='Portrait' height='32' witdth='32'>";
                                            } else {
                                                echo "<img src='img/landscape.png' alt='Landscape' height='32' witdth='32'>";
                                            }
                                            ?>
                                        </td>								
                                        <td class="<?php echo $row['job_id']; ?>">
                                            <?php
                                            if ($row['stauts'] == "Pending") {
                                                echo "In attesa";
                                            } elseif ($row['stauts'] == "Working") {
                                                echo "In lavorazione";
                                            } elseif ($row['stauts'] == "Canceled") {
                                                echo "Annullato";
                                            } elseif ($row['stauts'] == "Completed") {
                                                echo "Completato";
                                            } else {
                                                echo "Eliminato";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['date']; ?>
                                        </td> 
                                        <th>
                                            <a href='download.php?download_file=<?php echo $row['file_path']; ?>' class='btn-sm btn-default'>Download</a>
                                        </th>                             
                                        <td>
                                            <?php
                                            if ($row['file_type'] == "pdf") {
                                                echo "<img src='img/pdf_user.png' alt='PDF' height='32' witdth='32'>";
                                            } elseif ($row['file_type'] == "docx") {
                                                echo "<img src='img/docx_user.png' alt='DOCX' height='32' witdth='32'>";
                                            } else {
                                                echo "<img src='img/pptx_user.png' alt='PPTX' height='32' witdth='32'>";
                                            }
                                            ?>
                                        </td>
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

        <script src="js/jquery.dataTables.js"></script>
        <script src="js/dataTables.responsive.js"></script>
        <script src="js/chosen.jquery.min.js"></script>

        <script src="js/custom.js"></script>
        <script src="js/dashboard.js"></script>


    </body>
</html>