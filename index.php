<?php

session_start();
DEFINE('MPFM_INDEX', true);

require_once('./Database.php');
    if (isset($_POST['username']) && isset($_POST['password'])){
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
                
        global $connection;

        if ($connection === null || !mysqli_ping($connection)){
            die('Database connection failed during login');
        }else{
            $valid = login($username, $password);
            if ($valid){
                $_SESSION['authorized'] = $valid == '-2' ? '-2' : $username;
                $_POST['company'] = "All";
            }
        }
    }

if (isset($_POST['action']) && $_POST['action'] === "logout"){
    $_SESSION['authorized'] = null;
}

require_once('./header.php');
$fromIndex = true;
require_once('./Settings.php');
global $connection;

if (isset($_SESSION['authorized'])){
    if(isset($_FILES['upload']) || 
            isset($_POST['action']) && 
            $_POST['action'] === "upload"){
        require_once('./UploadFile.php');
    }else{
        if (isset($_POST['file'])){
            require_once('./MoveFile.php');
        }else{
            require_once('./ProcessFile.php');
            echo "<center>";
            //require_once('./UploadFile.php');
            echo "<form method=\"post\" action=\"index.php\">";
            $fileArray = getFilesByExtension($basedir, $supportedFormats);
            //$fileArray = getFiles('.');
            if (sizeof($fileArray) > 0){
                echo 'Select the file to move, rename, delete, etc.';
                foreach ($fileArray as $file) {
                    echo "<article>";
                    echo "<button name=\"file\" type=\"submit\" value=\"$file\">$file</button>";
                    echo "</article>";
                }
            }else{
                echo 'No applicable files in source folder.';
            }
            echo "</form>";
            echo "</center>";
        }
    }
}else{
    include_once('./Login.php');
}
include_once('./footer.html');
?>