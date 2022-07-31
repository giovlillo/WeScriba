<?php
include_once('mysql-fix.php');
include ('include/dashboard.php');

global $SITE_URL;

$sys = mysql_query("select paypal_account from system_preference");
$email = mysql_fetch_array($sys);
$e_val = $email['paypal_account'];
$businessEmail = $e_val;

if (isset($_POST["printingPackageSubmit"])) {
    // printing packet form has been submitted //
    $page = $_POST["page"];
    $pricingOptionParts = explode("-", $page);
    if (count($pricingOptionParts) != 3) {
        // wrong data passed //
    } else {
        $price = $pricingOptionParts[0];
        $noOfPage = $pricingOptionParts[1];
        $currency = $pricingOptionParts[2];

        if (trim($currency) == "$") {
            $currencyCode = "USD";
        } else {
            $currencyCode = "EUR";
        }

        $dataString = "{$_SESSION["user_name"]} [{$_SESSION["user_id"]}] has paid {$currency}{$price} to buy {$noOfPage} pages.";

        // prepares Paypal form data //
        $_SESSION['confirmationId'] = base64_encode(uniqid());
        $paypalData = array();
        $paypalData['cmd'] = '_xclick';
        $paypalData['business'] = $businessEmail;
        $paypalData['address_override'] = '1';
        $paypalData['item_name'] = "Print Center Credits";
        $paypalData["item_number"] = "Buy Now/pages";
        $paypalData['quantity'] = 1;
        $paypalData['amount'] = $price;
        $paypalData["currency_code"] = $currencyCode;
        $paypalData['cancel_return'] = $SITE_URL . "buy-now.php";
        $paypalData['return'] = $SITE_URL . "order_completion.php?confirmationId=" . $_SESSION['confirmationId'];
        $paypalData["notify_url"] = $SITE_URL . "paypal_instant_paym_noti.php";
        $paypalData["custom"] = $dataString;
        processAndSendPaypalFormData($paypalData);
    }
}

function processAndSendPaypalFormData($paypalQueryData) {
    // Prepare query string
    $query_string = http_build_query($paypalQueryData);
    header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
    //header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);
    exit();
}

$sql = "SELECT  `active`,`price`, `currency`, `page` FROM  `price_option` WHERE  `active` ='1'";
$result = mysql_query($sql);
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
                        <li><a href="print-now.php"><i class="fa fa-envelope-o"></i> <span>Print Now</a></li>
                        <li><a href="print_job_list.php"><i class="fa fa-edit"></i> <span>Print Jobs</span></a></li>
                        <li><a href="#"><i ></i> <span></span></a></li>
                        <li class="active"><a href="buy-now.php"><i class="fa fa-th-list"></i> <span>Buy Now</span></a></li>
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
                            <h2><i class="fa fa-table"></i>Add Credits</h2>
                        </div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-title">Get new credits</h2>
                                </div>
                                <div class="panel-body">
                                    <h4 class="panel-title">Choose:</h4>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-6">

                                                <form action="" method="POST">
                                                    <?php
                                                    if (mysql_num_rows($result) < 1) {
                                                        echo "no payment option available";
                                                    } else {
                                                        $flag = 0;
                                                        $cnt = 0;
                                                        $flag_chcked = 0;
                                                        while ($row = mysql_fetch_array($result)) {
                                                            if ($cnt % 2 == 0) {
                                                                echo "<tr>";
                                                                if ($flag_chcked == 1) {
                                                                    echo " <div class='checkbox ckbox block'><input type='radio' value='" . $row['price'] . "-" . $row['page'] . "-" . $row['currency'] . "' name='page'>" . $row['price'] . $row['currency'] . " - " . $row['page'] . " Credits" . "</div>";
                                                                } else {
                                                                    echo "<div class='checkbox ckbox block'><input type='radio' value='" . $row['price'] . "-" . $row['page'] . "-" . $row['currency'] . "' checked='checked' name='page'>" . $row['price'] . $row['currency'] . " - " . $row['page'] . " Credits" . "</div>";
                                                                    $flag_chcked = 1;
                                                                }
                                                                $flag = 0;
                                                            } else {
                                                                echo "<div class='checkbox block'><input type='radio' value='" . $row['price'] . "-" . $row['page'] . "-" . $row['currency'] . "' name='page'>" . $row['price'] . $row['currency'] . " - " . $row['page'] . " Credits" . "</div>";
                                                                echo "</tr>";
                                                                $flag = 1;
                                                            }
                                                            $cnt++;
                                                        }
                                                        if ($flag == 0) {
                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>

                                                    </br>
                                                    <input type="submit" value="Buy Now" class="btn btn-success" name="printingPackageSubmit">
                                                </form>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6"></br>
                                            <h4 class="panel-title">Payment Method</h4>
                                            <table border="0" cellpadding="10" cellspacing="0" align="left"><tbody><tr><td align="left"></td></tr><tr><td align="left"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png" alt="Buy now with PayPal" /></td></tr></tbody></table>
                                        </div> 
                                    </div> 
                                </div>
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

        <script src="js/flot/flot.min.js"></script>
        <script src="js/flot/flot.resize.min.js"></script>
        <script src="js/morris.min.js"></script>
        <script src="js/raphael-2.1.0.min.js"></script>

        <script src="js/jquery.datatables.min.js"></script>
        <script src="js/chosen.jquery.min.js"></script>

        <script src="js/custom.js"></script>
        <script src="js/dashboard.js"></script>
    </body>
</html>

