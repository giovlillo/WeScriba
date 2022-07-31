<?php

    //$path = $_SERVER['DOCUMENT_ROOT']."/rd/form/"; // change the path to fit your websites document structure 
    include ('include/dashboard.php');

    $fullPath = $_GET['download_file']; 



    if ($fd = fopen ($fullPath, "r")) { 

        $fsize = filesize($fullPath); 

        $path_parts = pathinfo($fullPath); 

        $ext = strtolower($path_parts["extension"]);

        switch ($ext) { 

            case "txt": 

            header("Content-type: application/txt"); // add here more headers for diff. extensions 

            header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download 

            break; 

            default; 

            header("Content-type: application/octet-stream"); 

            header("Content-Disposition: filename=\"".$path_parts["basename"]."\""); 

        } 

        header("Content-length: $fsize"); 

        header("Cache-control: private"); //use this to open files directly 

        while(!feof($fd)) { 

            $buffer = fread($fd, 2048); 

            echo $buffer; 

        }

        fclose ($fd);

    }

?>