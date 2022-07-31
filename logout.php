<?php
include_once('mysql-fix.php');


session_start();

unset($_SESSION["user_id"]);

unset($_SESSION["user_name"]);

unset($_SESSION["password"]);

header("Location:login.php");

?>

