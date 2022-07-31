<?php
error_reporting(-1);
include_once('mysql-fix.php');
include ('include/dashboard.php');
include ('include/config.php');
include ('include/utility.php');
include ('include/translation.php');

$result = mysql_query("SELECT `enable_color`,`enable_a3`,`enable_2_sided`,`enable_booklet`, a4_price, a3_price_margin, colored_price_margin FROM `system_preference`");
$systemPref = mysql_fetch_array($result);

if (isset($_POST['printSubmitBtn'])) {
	$_SESSION["printDetails"] = $_POST;
    //$allowedExts = array("doc", "docx", "xls", "xlsx", "pdf", "dwg", "odt");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
	$_SESSION["printDetails"]["extension"] = $extension;
    $msg = "";
    $credits = "";
    $max_file_size_allowed = 15728640;  // in bytes. (15 X 1024 X 1024 = 15728640 B = 15 MB)
    //$_FILES["file"]["type"] . "<br />" . $extension;
    //MIME type check
    $allowed_mime = array("application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.presentationml.presentation","officedocument.wordprocessingml.document");

    if ($_FILES["file"]["size"] < $max_file_size_allowed && in_array($_FILES["file"]["type"], $allowed_mime)) {
        if ($_FILES["file"]["error"] > 0) {
            $msg = "Error";
        } else if((getDirectorySize("user_files/") + $_FILES["file"]["size"]) > $maxUploadLimit*1024*1024) {
			$msg = "uploadLimitError";
		} else {
            //gather required values
            $f_date = date('mdYhis', time());

            $uploaded_path = $_FILES["file"]["tmp_name"];


            switch ($extension) {
                case 'pdf':
                    if (file_exists($uploaded_path)) {
                        require_once('fpdf/fpdf.php');
                        require_once('fpdi/fpdi.php');
                        $pdf = new FPDI();                              // initiate FPDI
                        $pages = $pdf->setSourceFile($uploaded_path);   // get the page count
                    }
                    break;
                case 'docx':
                    $zip = new ZipArchive();

                    if ($zip->open($uploaded_path) === true) {
                        if (($index = $zip->locateName('docProps/app.xml')) !== false) {
                            $data = $zip->getFromIndex($index);
                            $xml = new SimpleXMLElement($data);
                            $pages = (string)$xml->Pages;
                        }
                        $zip->close();
                    }
                    break;
                case 'pptx':
                    $zip = new ZipArchive();

                    if ($zip->open($uploaded_path) === true) {
                        if (($index = $zip->locateName('docProps/app.xml')) !== false) {
                            $data = $zip->getFromIndex($index);
                            $xml = new SimpleXMLElement($data);

                            $pages = (string)$xml->Slides;
                        }
                        $zip->close();
                    }
                    break;
                default:
                    $pages = 0;
                    break;
            }
			
			$_SESSION["printDetails"]["pages"] = $pages;
			$_SESSION["printDetails"]["file_contents"] = file_get_contents($uploaded_path);
			$_SESSION["printDetails"]["file_name"] = "user_files/" . $_SESSION["user_id"] . "_" . $f_date . "_" . $_FILES["file"]["name"];
            
            // price calculation
            $singlePagePrice = 0;
            if($_POST["paper_size"] == "A3") {
                $singlePagePrice += $systemPref["a3_price_margin"];
            }
            if($_POST["color"] == 'color') {
                $singlePagePrice += $systemPref['colored_price_margin'];
            }
            $singlePagePrice += $systemPref["a4_price"];
            
            $totalPrice = $singlePagePrice * $_POST["copies"] * $pages;
			$_SESSION["printDetails"]["totalPrice"] = $totalPrice;
        }
    } else {
        $msg = "Invalid file";
    }
	
	if($msg != "") {
		$_SESSION["msg"] = $msg;
		header("Location:print-now.php");
		exit();
	}
} else if(isset($_POST["printFinalSubmitBtn"])) {
	//deduct credits as per pages in documents
	$query = "SELECT * FROM users WHERE user_id=" . $_SESSION["user_id"];
	$result = mysql_query($query);
	$userDetails = mysql_fetch_array($result);
	$credit = $userDetails["credits"];
	
	if ($credit >= $_SESSION["printDetails"]["totalPrice"]) {
		$query = "UPDATE users SET credits = credits - {$_SESSION["printDetails"]["totalPrice"]} WHERE user_id=" . $_SESSION["user_id"];
		if (mysql_query($query)) {
			// store uploaded file
			$uploaded_new_path = $_SESSION["printDetails"]["file_contents"];
			file_put_contents($_SESSION["printDetails"]["file_name"], $uploaded_new_path);

			//store new job
			$date = date('Y-m-d h:i:s', time());
			$query = "INSERT INTO print_job (user_id, file_path, file_type, number_of_pages, stauts, date, color, paper_size, orientation, print_type, copies, price) 
												VALUES ({$_SESSION["user_id"]},'{$_SESSION["printDetails"]["file_name"]}','{$_SESSION["printDetails"]["extension"]}',{$_SESSION["printDetails"]["pages"]},'Pending','{$date}','{$_SESSION["printDetails"]['color']}','{$_SESSION["printDetails"]['paper_size']}','{$_SESSION["printDetails"]['orientation']}','{$_SESSION["printDetails"]['print_type']}','{$_SESSION["printDetails"]['copies']}', '{$_SESSION["printDetails"]["totalPrice"]}')";
			if (mysql_query($query)) {
				$msg = "Done";
				// send message to admin regarding printing information //
				$queryStr = "SELECT * FROM users WHERE type = 'admin'";
				$res = mysql_query($queryStr);
				$adminDetails = mysql_fetch_array($res);
				$emailContent = "Caro admin, <br><br>
								Hai una nuova richiesta di stampa da <b><i>{$userDetails["user_name"]}</i></b>. Ecco i dettagli: <br><br>
								<b>N. di pagine:</b> {$_SESSION["printDetails"]["pages"]}<br>
								<b>Tipo:</b> {$translateWords["it"][$_SESSION["printDetails"]['color']]}<br>
								<b>Formato:</b> {$_SESSION["printDetails"]['paper_size']}<br>
								<b>Orientamento:</b> {$translateWords["it"][$_SESSION["printDetails"]['orientation']]}<br>
								<b>Fronte/Retro:</b> {$translateWords["it"][$_SESSION["printDetails"]['print_type']]}<br>
								<b>Copie:</b> {$_SESSION["printDetails"]['copies']}<br><br>
								Grazie, <br>
								-WeScriba team";
				sendEmail($adminDetails['user_email_address'], "Nuova richiesta di stampa", $emailContent);
			} else {
				$msg = "notsaved";
			}
		} else {
			$msg = "notsaved";
		}
	} else {
		$msg = "nocredit";
	}
	$_SESSION["msg"] = $msg;
	header("Location:print-now.php");
	exit();
} else {
	header("Location:print-now.php");
	exit();
}
?>
<!DOCTYPE html>
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
        <!-- <link href="css/jquery.datatables.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script> ->

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
                <div id="main-content">
                    <div id="main-area">
                        <div class="pageheader">
                            <h2><i class="fa fa-table"></i>Print Now</h2>
                        </div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">  
                                    <h2 class="panel-title">Print confirmation:</h2>
                                </div>
                                <div class="panel-body">
                                    <form method="post" id="printForm" enctype="multipart/form-data">
                                        <div class="row">
											<div class="col-xs-12">
                                                <div class="col-xs-6"><p>N. of pages:</p></div>
												<div class="col-xs-6"><p><?php echo $_SESSION["printDetails"]["pages"];?></p></div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="col-xs-6"><p>Tipo:</p></div>
												<div class="col-xs-6"><p><?php if($_SESSION["printDetails"]["color"]=="bw"){echo "B/W"; } else{echo "Color";}?></p></div>
                                            </div>
											<div class="col-xs-12">
                                                <div class="col-xs-6"><p>Paper size:</p></div>
												<div class="col-xs-6"><p><?php echo $_SESSION["printDetails"]["paper_size"];?></p></div>
                                            </div>
											<div class="col-xs-12">
                                                <div class="col-xs-6"><p>Orientation:</p></div>
												<div class="col-xs-6"><p><?php if($_SESSION["printDetails"]["orientation"]=="portrait"){echo "Portrait"; } else{echo "Landscape";}?></p></div>
                                            </div>
											<div class="col-xs-12">
                                                <div class="col-xs-6"><p>Print type:</p></div>
												<div class="col-xs-6"><p><?php if($_SESSION["printDetails"]["print_type"]=="1-sided"){echo "1-sided"; } else{echo "2-sided";}?></p></div>
                                            </div>
											<div class="col-xs-12">
                                                <div class="col-xs-6"><p>Copies:</p></div>
												<div class="col-xs-6"><p><?php echo $_SESSION["printDetails"]["copies"];?></p></div>
                                            </div>
											<div class="col-xs-12">
                                                <div class="col-xs-6"><h4>Total:</h4></div>
												<div class="col-xs-6"><h4><?php echo $_SESSION["printDetails"]["totalPrice"];?> credits</h4></div>
                                            </div>
											<div class="col-xs-12" style='padding-top:15px;'>
                                                <div class="col-xs-12">
													<span><input type="submit" name='printFinalSubmitBtn' value="Confirm" class="btn btn-success"/></span>
													<span><a href="print-now.php" class="btn btn-danger">Cancel</a></span>
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
        <!--<script src="js/jquery-migrate-1.2.1.min.js"></script>-->
        <script src="js/bootstrap.min.js"></script>
        <!--<script src="js/modernizr.min.js"></script>-->
        <!--<script src="js/jquery.sparkline.min.js"></script>
        <script src="js/toggles.min.js"></script>
        <script src="js/retina.min.js"></script>
        <script src="js/jquery.cookies.js"></script>-->
<!--        <script src="js/flot/flot.min.js"></script>
        <script src="js/flot/flot.resize.min.js"></script>-->
        <!--<script src="js/morris.min.js"></script>-->
        <!--<script src="js/raphael-2.1.0.min.js"></script>-->
        <!--<script src="js/jquery.datatables.min.js"></script>-->
        <!--<script src="js/chosen.jquery.min.js"></script>-->
        <script src="js/custom.js"></script>
        <!--<script src="js/dashboard.js"></script>-->
    </body>
</html>