<script>

    function validateForm() {
        var x = document.forms["regist"]["user_name"].value;
        if (x.length <= 3) {
            document.getElementById('user_name').style.borderColor = "red";
            $('#name_3').html("Username must contain at least 3 characters");
            return false;
        } else
        {
            $('#name_3').html("");
            return false;
        }
    }

</script>

<script type="text/javascript"  src="js/jquery-3.1.1.js"></script>
<script type="text/javascript">

    function checkname()
    {
        var name = document.getElementById("user_name").value;


        if (name)
        {
            $.ajax({
                type: 'post',
                url: 'checkdata.php',
                data: {
                    user_name: name,
                },
                success: function (response) {
                    $('#name_status').html(response);
                    if (response == "OK")
                    {
                        return true;
                    } else
                    {

                        $("#user_name").addClass('errorClass');
                        return false;
                    }
                }
            });
        } else
        {
            $('#name_status').html("");
            return false;
        }


    }

    function checkemail()
    {
        var email = document.getElementById("user_email_address").value;

        if (email)
        {
            $.ajax({
                type: 'post',
                url: 'checkdata.php',
                data: {
                    user_email_address: email,
                },
                success: function (response) {
                    $('#email_status').html(response);
                    if (response == "OK")
                    {
                        return true;
                    } else
                    {
                        return false;
                    }
                }
            });
        } else
        {
            $('#email_status').html("");
            return false;
        }
    }
</script>

<?php
include_once('mysql-fix.php');
include ('admin/include/db-connect.php');
include ('include/utility.php');



$name = "";

$surname = "";

$username = "";

$password = "";

//$phoneNumber = "";

//$isWhatsappMessage = 0;

$email = "";



if (isset($_POST['register'])) {
    
    $allow_register = TRUE;
    $name = $_POST['name'];
    $surname = $_POST['sname'];
    $username = $_POST['user_name'];
    $password = md5($_POST['password']);
   // $phoneNumber = $_POST['phone_number'];
    // $countryCode = $_POST["country_code"];
    
    //if(isset($_POST["is_whatsapp_message"]) && $_POST["is_whatsapp_message"] == 1) {
    //       $isWhatsappMessage = 1;
   // }

    $email = $_POST['user_email_address'];

    $msg = "";

    $sql = "INSERT INTO users (`name`,`surname`,`user_name`,`password`, `user_email_address`, type, `active`) VALUES ('$name','$surname','$username','$password', '$email', 'user', '1')";
    
    if (mysql_query($sql)) {

        $msg = "registered";
		
		// Send email to admin and user for registration confirmation //
		$emailText = "Hi {$name} {$surname}, <br><br>Your account has been successfully registered. Now you can print your documents. <br><br>Thank you.<br><br>Print Center";
		sendEmail($email, "Account registration - WeScriba", $emailText);
		
		$queryStr = "SELECT * FROM users WHERE type = 'admin'";
		$res = mysql_query($queryStr);
		$adminDetails = mysql_fetch_array($res);
		$emailText = "Dear Admin, <br><br>A new user <b><i>{$name} {$surname}</i></b> has just registered. Details: <br>
			Name: {$name} <br>
			Surname: {$surname} <br>
			Username: {$username} <br>
			<br>Thank you.<br><br>WeScriba.";
		sendEmail($adminDetails['user_email_address'], "New user registration - Print Center", $emailText);
		
    } else {

        $msg = "Error";
    }

    
}

?>

</head>


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
        <script>

            $(document).ready(function () {

                $('#name').blur(function () {

                    return name_blur();

                });

                $('#sname').blur(function () {

                    return sr_name_blur();

                });

                $('#user_email_address').blur(function () {

                    return email_blur();

                });

                $('#user_name').blur(function () {


                    return user_name_blur();





                });



                $('#password').blur(function () {

                    return password_blur();

                });

                $('#terms').blur(function () {

                    return terms();

                });



                $('#register').click(function () {



                    if (name_blur() == true && sr_name_blur() == true && email_blur() == true && user_name_blur() == true && password_blur() == true && terms() == true)

                    {

                        return true;

                    } else

                    {

                        return false;



                    }



                });







            });

        </script>
    </head>

    <body class="signin">

        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
        <section>

            <div class="signuppanel">

                <div class="row">

                    <div class="col-md-6">

                        <div class="signup-info">
                            <div class="logopanel">
                                <h1><span>[</span> Print Center <span>]</span></h1>
                            </div><!-- logopanel -->

                            <div class="mb20"></div>

                            <h5><strong>Welcome to Print Center!</strong></h5>
                            <p>With Print Center you are free from the stress of toner, inks and out of cartridges, from jammed paper and non-functioning printers.</p>
                            <p>But from today everything changes: </p>
                            <div class="mb20"></div>

                            <div class="feat-list">
                                <i class="fa  fa-globe"></i>
                                <h4 class="text-success">Wherever you are</h4>
                                <p>It doesn't matter where you are. Buy credits at one of the WeScriba centers and start printing</p>
                            </div>

                            <div class="feat-list">
                                <i class="fa  fa-laptop"></i>
                                <h4 class="text-success">From any device</h4>
                                <p>From your home PC, from your office PC, from your smartphone or tablet. WeScriba centers are always reachable.</p>
                            </div>

                            <div class="feat-list mb20">
                                <i class="fa  fa-rocket"></i>
                                <h4 class="text-success">Fast and without waiting</h4>
                                <p>Like you, we hate queues. Send your documents, pick them up when ready. No waiting :)</p>
                            </div>

                            <h4 class="mb20">Don't waste any more time ...</h4>

                        </div><!-- signup-info --> 
                    </div><!-- col-sm-6 -->     
                    <!----------------------------------------------->

                    <div class="col-md-6">

                        <form id="basicForm" name="regist" action="" method="post" onsubmit="return checkall();" >
                            <h3 class="nomargin">Sign in</h3>
                            <p class="mt5 mb20">Are you already registered? <a href="login.php"><strong>Log in</strong></a></p>                          

<?php
if (isset($msg)) {

    echo '<tr><td align="center" colspan="2">';



    if ($msg == 'registered') {

        echo '<div class="alert alert-success">Registration was successful!.<br /></div>';
    }

    if ($msg == 'Error') {

        echo '<span class="red-box" style="color: #FF0000;">An error has occurred! Please try again later<br /></span>';
    }



    echo '</td></tr>';
}
?>

                            <label class="control-label">Dati personali<span class="asterisk">*</span></label>
                            <div class="row mb10">
                                <div class="form-group col-sm-6">
                                    <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Name" required />

                                </div>

                                <div class="form-group col-sm-6">
                                    <input type="text" id="sname" name="sname"  class="form-control" value="<?php echo $surname; ?>" placeholder="Surname" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Username<span class="asterisk">*</span></label>
                                <input type="text" id="user_name" name="user_name" class="form-control" onkeyup="checkname();
                                validateForm();" value="<?php echo $username; ?>" required /> <span id="name_status" style="color:#FF0000;"> </span><span id="name_3" style="color: #FFA500;"></span>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Password<span class="asterisk">*</span></label>
                                <input type="password" id="password" name="password" class="form-control" required />
                            </div>
                            <!--whatsapp-->
                            <div class="form-group">
                                <label class="control-label">Email
                                <span class="asterisk">*</span></label>
                                <input type="email" id="user_email_address" name="user_email_address" class="form-control" onkeyup="checkemail();" value="<?php echo $email; ?>" required/>
                                <span id="email_status" style="color:#FF0000;"></span>
                            </div>		

                            <div class="form-group">
                                <div class="ckbox ckbox-success">
                                    <input type="checkbox" id="checkboxSuccess" value="1" name="int[]" required />
                                    <label for="checkboxSuccess">I have read, understand and agree <br><a href="terms-and-conditions.pdf">Terms and Conditions</a><span class="asterisk">*</span></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="ckbox ckbox-success">
                                    <input type="checkbox" id="checkboxSuccess1" value="1" name="int1[]" required />
                                    <label for="checkboxSuccess1">I have read, understand and agree <br><a href="privacy-policy.pdf">Privacy Policy</a><span class="asterisk">*</span></label>
                                </div>
                            </div>
                            <button type="submit" name="register" id="register"  value="Register"  class="register btn btn-success btn-block">Sign In</button>

                        </form>
                    </div><!-- col-sm-6 -->

                </div><!-- row -->

                <div class="signup-footer">
                    <div class="pull-left">
                        &copy; 2021. All rights reserved. Print Center
                    </div>
                </div>

            </div><!-- signuppanel -->

        </section>


        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/jquery.sparkline.min.js"></script>
        <script src="js/toggles.min.js"></script>
        <script src="js/retina.min.js"></script>
        <script src="js/jquery.cookies.js"></script>

        <script src="js/jquery.validate.min.js"></script>

        <script src="js/custom.js"></script>
        <script>
                                    jQuery(document).ready(function () {

                                        // Basic Form
                                        jQuery("#basicForm").validate({
                                            highlight: function (element) {
                                                jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                                            },
                                            success: function (element) {
                                                jQuery(element).closest('.form-group').removeClass('has-error');
                                            }
                                        });
                                        // Error Message In One Container
                                        jQuery("#basicForm2").validate({
                                            errorLabelContainer: jQuery("#basicForm2 div.error")
                                        });
                                    });
        </script>
        <script>
            jQuery(document).ready(function () {

                // Chosen Select
                jQuery(".chosen-select").chosen({
                    'width': '100%',
                    'white-space': 'nowrap',
                    disable_search_threshold: 10
                });

            });
        </script>


    </body>
</html>
