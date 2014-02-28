<?php

session_start();
DEFINE('MPFM_INDEX', true);

/*
    ini_set ("display_errors", "1");
    error_reporting(E_ALL);
*/

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
require_once('./Settings.php');
global $connection;

if (isset($_SESSION['authorized']) || !loginRequired){
    if(isset($_FILES['upload']) || isset($_POST['action']) && $_POST['action'] === "upload"){
        require_once('./UploadFile.php');
    }else{
        if (isset($_POST['file'])){
            require_once('./MoveFile.php');
        }else{
            require_once('./ListFile.php');
        }
    }
}else{
    include_once('./Login.php');
}
include_once('./footer.html');
?>