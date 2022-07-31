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
        <link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/png">
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
                    <h2><i class="fa fa-table"></i> Help</h2>
                </div>
                <div class="contentpanel">
                <div class="row blog-content">
                <div class="panel panel-default panel-blog">
                    <div class="panel-body">    
                    
            <p><b>- What files can I print?</b></p>
            <p>You can print files in PDF format (Portable Document Format) of Abobe System and files in DOCX and PPTX format belonging to the Microsoft Office suite from version 2007 onwards..</p>
            <br />
                        
            <p><b>- Types of errors</b></p>
            <p>1.<b>"Invalid File Type. Please upload valid file type."</b> accepted files must have the extension .pdf / .docx / .pptx</p>
            <p>2.<b>"The maximum upload limit has been reached: %MB, please contact your printing center."</b> Your print center has reached the maximum space for uploading your customers' files. Please try again later or contact your print shop. The problem is only temporary..</p>
            <p>3.<b>"An error has occurred. Please contact administrator for help."</b> This problem is our fault. Please contact us by writing to [insert email]</p>
            <p>4.<b>“Error:”</b> It may occur when sending PDF files. The file was not created / converted according to ISO standards, therefore it is not possible to read the total number of pages. Please make / convert the PDF file with suitable software or send the file directly to the print shop..</p>      
            <br />
            <p><b>- Can I transfer my credit?</b></p>
            <p>Credit purchased at a Print Center can only be used in that center. We recommend that you purchase credit at the nearest printing center.</p>
            <br /> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                        </div></div>
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