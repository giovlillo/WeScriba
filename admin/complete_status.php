<?php



//connection
include_once('../mysql-fix.php');
include ('./include/db-connect.php');

$func = isset($_POST['fnc']) ? $_POST['fnc'] : die("Error in retrieving values.");

switch ($func) {

    case 'when_click_complete':

        $jb_id = $array = isset($_REQUEST['id']) ? $_POST['id'] : die("Error in array");

        $sql_get_uid = "select user_id from print_job where job_id=" . $jb_id;

        $rsuid = mysql_query($sql_get_uid) or die('select get uid qry prblm');

        $result = mysql_fetch_assoc($rsuid);

        //get email of user

        $sql_get_email = "select user_email_address from users where user_id=" . $result['user_id'];

        $rsueml = mysql_query($sql_get_email) or die('select get email qry prblm');

        $result_eml = mysql_fetch_assoc($rsueml);

        //end get 

        //get mail data

        $sql_get_cmplt_msg = "select print_complt_txt from system_preference";

        $rsmsg = mysql_query($sql_get_cmplt_msg) or die('select get msg qry prblm');

        $result_msg = mysql_fetch_assoc($rsmsg);

        //for email send

        $to = $result_eml['user_email_address'];

        $subject = "Print completed - Print Center";

        $txt = $result_msg['print_complt_txt'];

        $headers = "From: Print Center printr@center.com";



        if (mail($to, $subject, $txt, $headers)) {

            echo 'Email successfully sent!!!';

        } else {

            echo 'Sending error. Please contact the administrator';

        }

        break;



    case 'when_click_problem':

        $jb_id = $array = isset($_REQUEST['p_id']) ? $_POST['p_id'] : die("Error in array");

        $sql_get_uid = "select user_id from print_job where job_id=" . $jb_id;

        $rsuid = mysql_query($sql_get_uid) or die('select get uid qry prblm');

        $result = mysql_fetch_assoc($rsuid);

        //get email of user

        $sql_get_email = "select user_email_address from users where user_id=" . $result['user_id'];

        $rsueml = mysql_query($sql_get_email) or die('select get email qry prblm');

        $result_eml = mysql_fetch_assoc($rsueml);

        //end get 

        //get mail data

        $sql_get_cmplt_msg = "select print_problm_txt from system_preference";

        $rsmsg = mysql_query($sql_get_cmplt_msg) or die('select get msg qry prblm');

        $result_msg = mysql_fetch_assoc($rsmsg);

        //for email send

        $to = $result_eml['user_email_address'];

        $subject = "Error - Print Center";

        $txt = $result_msg['print_problm_txt'];

       $headers = "From: Print Center printr@center.com";



        if (mail($to, $subject, $txt, $headers)) {

            echo 'Email successfully sent!!!';

        } else {

            echo 'Sending error. Please contact the administrator';

        }

        break;

        

        case 'for_update_status':

            $up_jb_id = $array = isset($_REQUEST['up_jb_id']) ? $_POST['up_jb_id'] : die("Error in array");

            $up_sts_val = $array = isset($_REQUEST['stts']) ? $_POST['stts'] : die("Error in array");

            $sql_update_status="update print_job set `stauts`='$up_sts_val' where job_id=".$up_jb_id;

            if(mysql_query($sql_update_status))

            {
                if($up_sts_val == "Completed" || $up_sts_val == "Canceled" || $up_sts_val == "Deleted") { // delete file when the job is completed or cancelled or deleted //
                    $queryStr = "SELECT p.job_id, p.file_path FROM print_job p where p.job_id = {$up_jb_id}";
                    $res = mysql_query($queryStr);
                    $jobDetails = mysql_fetch_array($res);
                    if(file_exists("../{$jobDetails["file_path"]}")) {
                        unlink("../{$jobDetails["file_path"]}");
                    }
                }

                echo 'update status successfully';

            }

            else

            {

                die('Update Query Problem');

            }

            break;

}

?>

