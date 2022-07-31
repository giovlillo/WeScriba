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
        <link href="../css/style.default.css" rel="stylesheet">
        <link href="../css/style.inverse.css" rel="stylesheet">
        <link href="../css/jquery.datatables.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        
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
                            <li><a href="account-preference.php"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                            <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                            <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
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
                    <h2><i class="fa fa-table"></i> Help</h2>
                </div>
                <div class="contentpanel">
                <div class="row blog-content">
                <div class="panel panel-default panel-blog">
                    <div class="panel-body">    
                    
            <p><b>Print Jobs</b></p>
            <p>Through the section "Job List" it is possible to know the situation of the jobs to be printed and to communicate to the customer the progress of the printing.</p>
            <br />
            <p>ID: Global progressive number of the jobs received</p>
            <p>Username: username of the customer</p>
            <p>Pages: Total number of pages to be printed</p>
            <br />
            <p>Status:</p>          
            <ul>
                <li>Pending: New print job just arrived / The file has not been downloaded yet</li>
                <li>Working: The file has been downloaded / The file is ready to be printed</li>
                <li>Cancelled: An error occurred during printing. Therefore the file cannot be printed / Contact the customer</li>
                <li>Completed: File printed successfully !!</li>
                <li>Deleted: The “Completed or Canceled” file has been deleted * from WeScriba servers. </li>
            </ul>           
            <p>(* - In case of "Completed" file, the file is automatically deleted from WeScriba servers)</p>      
            <br />
            <p>Option:</p>
            <p>Download: Download the file to print :)</p>
            <p>Delete: Delete the file. (Note. The file can no longer be recovered)</p>
            <br />
            <p>Email:</p>
            <p>Allows you to send preset email messages through the section: "System Preferences" - "Message"</p>
            <br />
            <p>Complete: File printed successfully !!</p>
            <p>Error: An error occurred while printing. Therefore the file cannot be printed</p>
            <br />
            <p><b>User List</b></p>
            <p>Through the section "User list" it is possible to monitor and manage the customers registered at your print center.</p>
            <br />
            <p>ID: Overall progressive number of customers registered at your printing center</p>
            <p>Credit: Allows you to manually top up the user's credit.</p>
            <p>Delete: Allows you to manually delete a user. (Note. Once deleted, the user can no longer be reactivated. He will have to make a new registration)</p>
            <br />
            <p><b>System Preferences</b></p>
            <br />
            <p>ID: Overall progressive number of customers registered at your printing center</p>
            <p>"Printer" tab<br /> Check box to set color printing / A3 size / duplex printing. (Note. Each print shop can set the desired options according to their needs)</p>
            <p>"Payment" tab<br /> Paypal account: Enter your PayPal email address to start receiving payments from your customers. (Note. If the address is not entered, customers will not be able to purchase the credits necessary for printing)</p>
            <br />
            <p>Price per page: Set the 4 credit packages that the customer will be able to purchase.</p>
            <p>One credit corresponds to one printed page.</p>
            <p>Credit details: Set the extra credits for A3 printing (e.g. +1) and for color printing (e.g. + 3)</p>
            <br />
            <p>"Message" Tab<br /> Set the preset texts for customer email.</p>
                        
                        </div></div>
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

        <script src="../js/morris.min.js"></script>
        <script src="../js/raphael-2.1.0.min.js"></script>

        <script src="../js/jquery.datatables.min.js"></script>
        <script src="../js/chosen.jquery.min.js"></script>

        <script src="../js/custom.js"></script>

    </body>
    
    <!-- Modal -->
    <div class="modal fade" id="jobDetailsModal" tabindex="-1" role="dialog" aria-labelledby="jobDetailsModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Dettagli di stampa</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p><b>Tipo:</b> <span class="jobColorInModal">-</span></p>
                        <p><b>Formato:</b> <span class="jobPaperSizeInModal">-</span></p>
                        <p><b>Fronte/Retro:</b> <span class="jobPrintTypeInModal">-</span></p>
                        <p><b>Tipo di file:</b> <span class="jobFileTypeInModal">-</span></p>
                        <p><b>Orientamento:</b> <span class="jobOrientationInModal">-</span></p>
                        <p><b>Data:</b> <span class="jobDateInModal">-</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='glyphicon glyphicon-remove'></i> Log out</button>
                </div>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    
    <script type="text/javascript">
        $(document).ready(function() {
            $(".showJobDetails").click(function() {
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