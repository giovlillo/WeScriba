<?php
include_once('mysql-fix.php');
include ('admin/include/db-connect.php');
session_start();

?>

<!DOCTYPE html>

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
<body class="notfound">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
  <div class="notfoundpanel">
	<h3>Recharge Credit</h3>
    <?php echo $_SESSION["user_name"]; ?>
                        
                        <?php
                            if (isset($_SESSION['confirmationId'])) {
                               echo '<div class="alert alert-success">Credits added successfully.</div><h4><a href="print-now.php">Click here</a> click here to return to the desk and start printing your files</h4><br />';
                            } else {
                                echo '<div class="alert alert-danger">Impossible add credits. Please contact the administrator for more information.</div><h4">You can return to the <a href="buy-now.php">Buy now</a> page to try again.</h4><br />';
                            }
                        ?>
  </div><!-- notfoundpanel -->
  
</section>


<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/retina.min.js"></script>

<script src="js/custom.js"></script>

</body>
</html>