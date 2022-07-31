<?php
include_once('mysql-fix.php');
include ('include/dashboard.php');

$job_id = isset($_POST['job']) ? $_POST['job'] : die('Error');

$sql = "UPDATE  `print_job` SET `stauts`='Deleted' WHERE `job_id` =" . $job_id."";

if (mysql_query($sql)) {

    

    echo $sql = "SELECT job_id, number_of_pages, stauts, date FROM print_job WHERE user_id = '". $_SESSION['user_id'] ."' AND `stauts` != 'Deleted'";

    $result = mysql_query($sql) or die("Error");

    echo '<table id="large" class="tablesorter" style="width: 100%;">';

    echo '<thead><tr><th style="text-align: left;">Job ID</th><th style="width: 50px; text-align: left;">Page</th><th style="width: 150px; text-align: left;">Status</th><th style="width: 200px; text-align: left;">Date</th><th style="width: 70px; text-align: left;">Option</th></tr></thead>';

    

    $i=1;

    while ($row = mysql_fetch_array($result)) {

        if ($i++ % 2 == 0) {

            echo '<tr class="tr-even">';

            echo '<td>'.$row['job_id'].'</td>';

            echo '<td>'.$row['number_of_pages'].'</td>';

            echo '<td class="'.$row['job_id'].'">'.$row['stauts'].'</td>';

            echo '<td>'.$row['date'].'</td>';

            echo '<td><a id="'.$row['job_id'].'" class="lnk">Delete</a></td>';

            echo '</tr>';

        } else {

            echo '<tr class="tr-odd">';

            echo '<td>'.$row['job_id'].'</td>';

            echo '<td>'.$row['number_of_pages'].'</td>';

            echo '<td class="'.$row['job_id'].'">'.$row['stauts'].'</td>';

            echo '<td>'.$row['date'].'</td>';

            echo '<td><a id="'.$row['job_id'].'" class="lnk">Delete</a></td>';

            echo '</tr>';

        }

    }

    echo '</table>';

}

else{

echo "Error";

}

?>