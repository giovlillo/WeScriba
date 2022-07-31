<?php
include_once('../mysql-fix.php');
include ('include/dashboard.php');


if(!isset($_POST["job"])) {
	echo "Error";
} else {
	$job_id = (int)$_POST["job"];


	$sql = "SELECT file_path FROM print_job WHERE job_id = {$job_id}";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0) {
		echo "Error";
	} else {

		$rowData = mysql_fetch_array($result);
		unlink("../" . $rowData["file_path"]);

		
		echo "Success";
	}
}


?>