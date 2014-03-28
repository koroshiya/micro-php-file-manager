<?php

if (!MPFM_INDEX){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['MPFM_authorized'])){
    die("You are not permitted to access this page");
}

require_once('../Settings.php');

ini_set('display_errors',1);
error_reporting(E_ALL);

if(isset($_FILES["FileInput"])&&$_FILES["FileInput"]["error"]==UPLOAD_ERR_OK){

    /*
        Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
        Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
        and set them adequately, also check "post_max_size".
    */
   
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){ //check if this is an ajax request
        die("Cannot be invoked directly.");
    }elseif ($_FILES["FileInput"]["size"] > 104857600) {
        die("File size is too big!");
    }

    $File_Name          = strtolower($_FILES['FileInput']['name']);
    
    $ext = strtolower(substr($File_Name, strrpos($File_Name, '.')));
    $formats = preg_split('/;/', supportedFormats, -1, PREG_SPLIT_NO_EMPTY);
    $supported = False;
    foreach ($formats as $extension) {
        if ($ext == ".".$extension){
            $supported = True;
        }
    }
    if (!$supported){
        die('Unsupported File!');
    }elseif (move_uploaded_file($_FILES['FileInput']['tmp_name'],dest.$File_Name)){
        die('File uploaded successfully.');
    }else{
        die('Error uploading file.');
    }
}
else{
    die('Something went wrong with upload! <br />Is "upload_max_filesize" set correctly?');
}

?>