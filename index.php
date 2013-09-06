<?php

require_once('./header.html');
$fromIndex = true;
require_once('./Settings.php');

if ($connection === null || !mysqli_ping($connection)){
    require_once('./Database.php');
    connect();
    if ($connection === null || !mysqli_ping($connection)){
        die('Could not connect to Database');
    }
}

session_start();
if (isset($_SESSION['authorized'])){
    if (isset($_POST['action']) && $_POST['action'] === "logout"){
        $_SESSION['authorized'] = null;
        echo "<div style=\"top:50%;margin: -75px 0 0 0px;position:relative;\">";
        echo "<div align=\"center\">";
        echo "Logged out successfully<br />";
        echo "<a href=\"index.php\">Refresh</a>";
        echo "</div>";
    }else{
        echo "<form action=\"index.php\" method=\"post\">
                <button name=\"action\" type=\"submit\" value=\"logout\">Logout</button>
            </form>";
        if (isset($_POST['file'])){
            require_once('./MoveFile.php');
        }else{
            require_once('./ProcessFile.php');
            echo "<center>";
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