<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');



if (isset($_POST['submit_paypal'])) {



    $paypal = $_POST['paypal'];
    $a3PriceMargin = addslashes($_POST["a3_price_margin"]);
    $coloredPriceMargin = addslashes($_POST["colored_price_margin"]);

    $sql = "UPDATE `system_preference` SET `paypal_account`='{$paypal}', a3_price_margin = '{$a3PriceMargin}', colored_price_margin = '{$coloredPriceMargin}'";

    mysql_query($sql);



    $active = (isset($_POST['active']) ? "1" : "0");

    $price = $_POST['price'];

    $currency = $_POST['currency'];

    $page = $_POST['page'];



    $query = "UPDATE `price_option` SET `price`='" . $price . "',`currency`='" . $currency . "',`page`='" . $page . "',`active`='" . $active . "' WHERE `id`='1'";

    mysql_query($query);



    $active2 = (isset($_POST['active2']) ? "1" : "0");

    $price2 = $_POST['price2'];

    $currency2 = $_POST['currency2'];

    $page2 = $_POST['page2'];



    $query = "UPDATE `price_option` SET `price`='" . $price2 . "',`currency`='" . $currency2 . "',`page`='" . $page2 . "',`active`='" . $active2 . "' WHERE `id`='2'";

    mysql_query($query);



    $active3 = (isset($_POST['active3']) ? "1" : "0");

    $price3 = $_POST['price3'];

    $currency3 = $_POST['currency3'];

    $page3 = $_POST['page3'];



    $query = "UPDATE `price_option` SET `price`='" . $price3 . "',`currency`='" . $currency3 . "',`page`='" . $page3 . "',`active`='" . $active3 . "' WHERE `id`='3'";

    mysql_query($query);



    $active4 = (isset($_POST['active4']) ? "1" : "0");

    $price4 = $_POST['price4'];

    $currency4 = $_POST['currency4'];

    $page4 = $_POST['page4'];



    $query = "UPDATE `price_option` SET `price`='" . $price4 . "',`currency`='" . $currency4 . "',`page`='" . $page4 . "',`active`='" . $active4 . "' WHERE `id`='4'";

    mysql_query($query);
}



if (isset($_POST['submit_print'])) {

    $pricmptxt = $_POST['print_com_txt'];
    $priprobtxt = $_POST['print_prob_txt'];
    $whatsappCompleteTxt = $_POST["whatsapp_complete_text"];
    $whatsappErrorTxt = $_POST["whatsapp_error_text"];
    
    $sql = "UPDATE `system_preference` SET `print_complt_txt`='{$pricmptxt}',`print_problm_txt`='{$priprobtxt}', whatsapp_complete_text = '{$whatsappCompleteTxt}', whatsapp_error_text = '{$whatsappErrorTxt}'";
    mysql_query($sql);
}



if (isset($_POST['submit'])) {



    $enabcol = (isset($_POST['ena_col']) ? "1" : "0");

    $enaba3 = (isset($_POST['ena_a3']) ? "1" : "0");

    $enaba2 = (isset($_POST['ena_a2']) ? "1" : "0");

    $enabook = (isset($_POST['ena_book']) ? "1" : "0");



    $sql = "UPDATE `system_preference` SET `enable_color`='" . $enabcol . "',`enable_a3`='" . $enaba3 . "',`enable_2_sided`='" . $enaba2 . "',`enable_booklet`='" . $enabook . "'";

    $result = mysql_query($sql);
}

$result = mysql_query("select * from system_preference");

while ($row = mysql_fetch_array($result)) {
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
            <script>
                $(function () {
                    $("#tabs").tabs();
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
                            <li><a href="user-list.php"><i class="glyphicon glyphicon-user"></i> <span>User List</span></a></li>
                            <li><a href="#"><i ></i> <span></span></a></li>
                            <li class="active"><a href="system-preference.php"><i class="glyphicon glyphicon-check"></i> <span>System Preferences</span></a></li> 

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
                        <h2><i class="fa fa-table"></i>System Preference</h2>
                    </div>

                    <div class="contentpanel">
                        <div class="table-responsive">
                            <form action="" method="post">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tabs-1" data-toggle="tab"><strong>Printer</strong></a></li>
                                    <li><a href="#tabs-2" data-toggle="tab"><strong>Payment</strong></a></li>
                                    <li><a href="#tabs-3" data-toggle="tab"><strong>Message</strong></a></li>
                                </ul>
                                <!-- TAB 1 -->
                                <div class="tab-content mb30">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="ena_col" value="" <?php
                                                        if ($row['enable_color']) {
                                                            echo "checked=checked";
                                                        }
                                                        ?>> Enable color printing
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="ena_a3" value=""<?php
                                                        if ($row['enable_a3']) {
                                                            echo "checked=checked";
                                                        }
                                                        ?>> Enable A3 format
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="ena_a2" value=""<?php
                                                        if ($row['enable_2_sided']) {
                                                            echo "checked=checked";
                                                        }
                                                        ?>> Enable Two-sided
                                                    </div>
                                                    <!--<div class="form-group">
                                                        <input type="checkbox" name="ena_book" value=""<?php
                                                        if ($row['enable_booklet']) {
                                                            echo "checked=checked";
                                                        }
                                                        ?>> Abilita Libretto
                                                    </div>-->
                                                    <div class="form-group">
                                                        <input type="submit" name="submit" id="submit" class="update btn btn-success" value="Save">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB 2 -->
                                    <div class="tab-pane" id="tabs-2">
                                        <strong>&nbsp;Paypal account</strong> 
                                        <input type="text" class="form-control" name="paypal"class="ipbox2" value="<?php echo $row['paypal_account']; ?>">

                                        <?php
                                        $sql = "select * from price_option";
                                        $result = mysql_query($sql);
                                        $value;
                                        while ($row_new = mysql_fetch_array($result)) {
                                            $values[] = $row_new;
                                            //echo "<pre>"; print_r($values); echo "</pre>"; 
                                        }
                                        ?>

                                        <br><br>
                                        <strong>Price per Pages</strong>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input class="" type="checkbox" name="active" value=""<?php
                                                            if ($values[0][4] == 1) {
                                                                echo "checked=checked";
                                                            }
                                                            ?>> 
                                                            <label class="control-label">Price:</label>
                                                            <input type="text" name="price"class="ipbox2 form-control"  value="<?php echo $values[0][1]; ?>">
                                                            <select name="currency" class="form-control mobileTopMargin">
                                                                <option value="&#128;"<?php
                                                                if ($values[0][2] == '€') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#128;</option>
                                                                <option  value="&#36;"<?php
                                                                if ($values[0][2] == '$') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#36;</option>
                                                            </select>
                                                            <label class="control-label">- Credits</label>
                                                            <input type="text" name="page" class="ipbox2 form-control" value="<?php echo $values[0][3]; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input type ="checkbox" name="active2" value = ""<?php
                                                            if ($values[1][4] == 1) {
                                                                echo "checked=checked";
                                                            }
                                                            ?>> 
                                                            <label class="control-label">Price:</label>
                                                            <input type="text" name="price2" class="ipbox2 form-control" value="<?php echo $values[1][1]; ?>">

                                                            <select name="currency2" class="form-control mobileTopMargin">
                                                                <option value="&#128;"<?php
                                                                if ($values[1][2] == '€') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#128;</option>
                                                                <option value="&#36;"<?php
                                                                if ($values[1][2] == '$') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#36;</option>
                                                            </select>

                                                            <label class="control-label">- Credits</label>
                                                            <input type="text" name="page2" class="ipbox2 form-control" value="<?php echo $values[1][3]; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input type="checkbox" name="active3" value = ""<?php
                                                            if ($values[2][4] == 1) {
                                                                echo "checked=checked";
                                                            }
                                                            ?>>
                                                            <label class="control-label">Price:</label>
                                                            <input type="text" name="price3" class="ipbox4 form-control" value="<?php echo $values[2][1]; ?>">

                                                            <select name="currency3" class="form-control mobileTopMargin">
                                                                <option value="&#128;"<?php
                                                                if ($values[2][2] == '€') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#128; </option>
                                                                <option  value="&#36;"<?php
                                                                if ($values[2][2] == '$') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#36; </option>
                                                            </select>

                                                            <label class="control-label">- Credits</label>
                                                            <input type="text" name="page3" class="ipbox4 form-control" value="<?php echo $values[2][3]; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input type="checkbox" name="active4" value=""<?php
                                                            if ($values[3][4] == 1) {
                                                                echo "checked=checked";
                                                            }
                                                            ?>>
                                                            <label class="control-label">Price:</label>
                                                            <input type="text" name="price4" class="ipbox4 form-control mobileTopMargin" value="<?php echo $values[3][1]; ?>"> 
                                                            <select name="currency4" class="form-control">
                                                                <option value="&#128;"<?php
                                                                if ($values[3][2] == '€') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#128;</option>
                                                                <option value="&#36;"<?php
                                                                if ($values[3][2] == '$') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>&#36;</option>
                                                            </select>

                                                            <label class="control-label">- Credits</label>
                                                            <input type="text" name="page4" class="ipbox4 form-control" value="<?php echo $values[3][3]; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12 form-horizontal">
                                                    <strong>Extra Credits:</strong>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-xs-2 col-md-1 control-label">A3:</label>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                                                                    <input id="email" type="text" class="form-control" name="a3_price_margin" placeholder="1" value="<?php echo $row["a3_price_margin"];?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-xs-2 col-md-1 control-label">Color:</label>
                                                            <div class="col-xs-4 col-md-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                                                                    <input id="email" type="text" class="form-control" name="colored_price_margin" placeholder="3" value="<?php echo $row["colored_price_margin"]?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="submit" name="submit_paypal" id="submit" class="update btn btn-success" value="Save">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--TAB 3 -->
                                    <div class="tab-pane" id="tabs-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <strong>E-mail - Print Completed</strong>
                                                    <textarea class="form-control" rows="6" name="print_com_txt"><?php echo $row['print_complt_txt']; ?></textarea>
                                                </div>
                                                <div class="col-md-6 mobileTopMargin">
                                                    <strong>E-mail - There was a problem</strong>
                                                    <textarea class="form-control" rows="6" name="print_prob_txt"><?php echo $row['print_problm_txt']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 20px;">
                                                <div class="col-md-6">
                                                    <strong>Whatsapp - Print Completed (coming soon)</strong>
                                                    <textarea class="form-control" rows="6" name="whatsapp_complete_text"><?php echo $row['whatsapp_complete_text']; ?></textarea>
                                                </div>
                                                <div class="col-md-6 mobileTopMargin">
                                                    <strong>Whatsapp - There was a problem (coming soon)</strong>
                                                    <textarea class="form-control" rows="6" name="whatsapp_error_text"><?php echo $row['whatsapp_error_text']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group" style='margin-top: 15px;'>
                                                        <input type="submit" name="submit_print" id="submit" class="update btn btn-success" value="Save">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>                
                        </form>
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
        
        <style>
            .form-horizontal .control-label {
                text-align: left !important;
            }
        </style>
        
    </html>

<?php } ?>