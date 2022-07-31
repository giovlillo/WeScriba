<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');

if(isset($_POST['update'])){

    $sql = "UPDATE `users` SET credits=credits + ".$_POST['credits']." WHERE  `user_id` =". $_POST['user_id']."";

    if(mysql_query($sql)){

            $msg = "sent";

    }else

    {

            $msg = "notsent";

    }

}

if(isset($_GET['user'])){

    $sql = "SELECT `user_name`,`credits` FROM `users` WHERE `user_id` =" . $_GET['user'];

    $result = mysql_query($sql);

    $result = mysql_fetch_array($result);

	if(is_array($result)){

		$name= $result['user_name'];

		$credits = $result['credits'];

		$id= $_GET['user'];

	}

	else{

		header("Location:login.php");

	}

?>

<html>
<head>
  <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/png">
        <title>Print Center - print your documents online</title>
        <link href="../css/style.default.css" rel="stylesheet">
		<link href="../css/style.inverse.css" rel="stylesheet">
		<link href="../css/jquery.datatables.css" rel="stylesheet">
		<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script>

            $(document).ready(function() {

                $('#large').dataTable({

                    "sPaginationType": "full_numbers",

                     "iDisplayLength": 5,

                     "aoColumnDefs": [

                        { 

                          "bSortable": false, 

                          "aTargets": [ -1 ]

                         } 

                     ]

                });

                $(".lnk").click(function() {

                    if(confirm("This user will be deleted. Press ok to confirm.")){

                        $.ajax({

                            type: "POST",

                            url: "deactivate-user.php",

                            data: { "user": $(this).attr('id')},

                            dataType: 'HTML',

                            success: function(data) {

                                if(data == "Error"){

                                    $("#msg").html("Error occured while removing user! Please try after some time.");

                                    $("#msg").addClass("red-box");

                                    $("#msg").css("display","block");

                                }

                                else{

                                    $("#msg").html("User has been removed successfully.");

                                    $("#msg").addClass("green-box");

                                    $("#msg").css("display","block");

                                    $("#main-table").html(data);

                                }

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
                <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div><!-- header-right -->
      
    </div><!-- headerbar -->

              <div class="pageheader">
      <h2><i class="fa fa-table"></i>Add Credit</h2>
		</div>

                    <div class="contentpanel">

                    <div style="padding-left:10px;">

                        <h3>Added credits to the user: <span style="color:green;"><?php echo $name; ?></span></h3>

						Current credit: <span style="color:green;"><?php echo $credits; ?></span> credits

						<form action="" method="post">
						
						<br><input type="hidden" name="user_id" value="<?php echo $id; ?>">

						Enter the number of credits to add: <input type="text" name="credits" /><br>

						</br><input type="submit" name="update" value="Save" class="btn btn-success" />

						</form>

						<?php

							if(isset($msg)){

								if($msg == "notsent"){

									echo '<div class="alert alert-danger">An error has occurred: Error#1105.</div>';

								}

								elseif($msg == "sent"){

									echo '<div class="alert alert-success"> Credit added successfully.</div>';

								}

							}

						?>

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

<script src="../js/jquery.datatables.min.js"></script>
<script src="../js/chosen.jquery.min.js"></script>

<script src="../js/custom.js"></script>
<script src="../js/dashboard.js"></script>

</body>
</html>

<?php

}

else{

	header("Location:login.php");

}

?>