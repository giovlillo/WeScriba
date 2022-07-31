<?php
    include_once('mysql-fix.php');
	include ('admin/include/db-connect.php');

    global $SITE_URL;
	// STEP 1: read POST data
	// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
	// Instead, read raw POST data from the input stream.
    $emaiTo = "info@wescriba.it";

	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	foreach ($raw_post_array as $keyval) {
	  $keyval = explode ('=', $keyval);
	  if (count($keyval) == 2)
	     $myPost[$keyval[0]] = urldecode($keyval[1]);
	}
	// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
	$req = 'cmd=_notify-validate';
	if(function_exists('get_magic_quotes_gpc')) {
	   $get_magic_quotes_exists = true;
	} 
	foreach ($myPost as $key => $value) {        
	   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
	        $value = urlencode(stripslashes($value)); 
	   } else {
	        $value = urlencode($value);
	   }
	   $req .= "&$key=$value";
	}
	 
	// STEP 2: POST IPN data back to PayPal to validate
	$ch = curl_init('https://sandbox.paypal.com/cgi-bin/webscr');
	//$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	// In wamp-like environments that do not come bundled with root authority certificates,
	// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
	// the directory path of the certificate as shown below:
	// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
	if( !($res = curl_exec($ch)) ) {
	    // error_log("Got " . curl_error($ch) . " when processing IPN data");
	    curl_close($ch);
	    exit;
	}
	curl_close($ch);
	 
	// STEP 3: Inspect IPN validation result and act accordingly
	if (strcmp ($res, "VERIFIED") == 0) {
	    // The IPN is verified, process it:
	    // check whether the payment_status is Completed
	    // check that txn_id has not been previously processed
	    // check that receiver_email is your Primary PayPal email
	    // check that payment_amount/payment_currency are correct
	    // process the notification
	    // assign posted variables to local variables
	    $custom = $_POST['custom'];
	    //$customFieldsArray = array();
	    //$customFieldsArray = explode(",", $custom);
	    $customData = array("baseUrl" => $SITE_URL, "txn_id" => $_POST["txn_id"], "payment_status" => $_POST["payment_status"]);
		$customData["paymantData"] = $custom;

	    // finding user id //
	    $userIdParts = explode("[", $custom);
    	$user_id = explode("]", $userIdParts[1])[0];
    	// finding number of pages bought //
    	$pageParts = explode(" ", $custom);
    	$numberOfPagesBought = trim($pageParts[count($pageParts)-2]);
	    // update credit in database //
	    $sql = "UPDATE `users` SET credits=credits + " . $numberOfPagesBought . " WHERE  `user_id` =" . $user_id;
    	mysql_query($sql);

        $emailHtml = file_get_contents($SITE_URL . "email_template/payment_noti_email_template.php?" . http_build_query($customData));

        $result = sendEmail($emaiTo, "New Payment from WeScriba ", $emailHtml);

	} else if (strcmp ($res, "INVALID") == 0) {
	    // IPN invalid, log for manual investigation
	}


        
    function sendEmail($to,$subject, $content) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: WeScriba <sales@wescriba.it>' . "\r\n";

        return mail($to,$subject,$content,$headers);
    }
?>