<?php

require_once('./header.php');
$fromIndex = true;
require_once('./Settings.php');

if ($connection === null || !mysqli_ping($connection)){
    require_once('./Database.php');
    connect();
    if ($connection === null || !mysqli_ping($connection)){
        die('Could not connect to Database');
    }
}

if (isset($_SESSION['authorized'])){
    if (isset($_POST['action']) && $_POST['action'] === "logout"){
        $_SESSION['authorized'] = null;
        echo "<div style=\"top:50%;margin: -75px 0 0 0px;position:relative;\">";
        echo "<div align=\"center\">";
        echo "Logged out successfully<br />";
        echo "<a href=\"index.php\">Refresh</a>";
        echo "</div>";
    }elseif(isset($_FILES['upload']) || 
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