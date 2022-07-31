<?php

	function sendEmail($to, $subject, $content) {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: WeScriba<info@wescriba.it>' . "\r\n";

		mail($to,$subject,$content,$headers);	
	}
	
	function getDirectorySize($directory){
		$size = 0;
		$files= glob($directory.'/*');
		foreach($files as $path){
			is_file($path) && $size += filesize($path);
			is_dir($path) && get_dir_size($path);
		}
		return $size;
	}
	
	function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

?>