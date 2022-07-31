<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');


if(!isset($_POST["user"])) {
	echo "Error";
} else {
	$user_id = (int)$_POST["user"];

	$sql = "DELETE FROM users where user_id = {$user_id}";
    $result = mysql_query($sql);

    if($result) {
    	echo "Success";
    } else {
    	echo "Error";
    }
}


?>