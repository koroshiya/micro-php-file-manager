<?php
if (!defined('MPFM_INDEX')){
    die('You must access this through the root index!');
}elseif (!isset($_SESSION['authorized'])){
    die('Must be logged in to access this page');
}

$exists = false;
if (isset($_POST['file']) && !is_dir($_POST['file'])) {
    $dest = dest;
    $absFile = $basedir . "/" . $file;
    $exists = file_exists($absFile);
    if ($exists) {
        $file = basename($_POST['file']);

        if (isset($_POST['action'])){
            $action = $_POST['action'];
            $file = $basedir . $file;
            $overwrite = (isset($_POST['overwrite']) && $_POST['overwrite'] === "yes");
            switch ($action){
                case "move":
                    if (isset($_POST['dest']) && is_dir($dest .$_POST['dest'])){
                        $dest .= basename($_POST['dest']);
                        if (file_exists($dest) && is_dir($dest)){
                            require_once('ProcessFile.php');
                            if (moveFile($file, $dest, $overwrite)){
                                $dest .= "/" . basename($file);
                                echo "Moved $file to $dest<br />";
                            }else{
                                echo "Failed to move $file to $dest<br />";
                            }
                        }else{
                            echo "Dir doesn't exist<br />";
                        }
                    }else{
                        echo "No destination specified<br />";
                    }
                    break;
                case "copy":
                    if (isset($_POST['dest']) && is_dir($dest .$_POST['dest'])){
                        $dest .= basename($_POST['dest']);
                        if (file_exists($dest) && is_dir($dest)){
                            require_once('ProcessFile.php');
                            if (copyFile($file, $dest, $overwrite)){
                                $dest .= "/" . basename($file);
                                echo "Copied $file to $dest<br />";
                            }else{
                                echo "Failed to copy $file to $dest<br />";
                            }
                        }else{
                            echo "Dir doesn't exist<br />";
                        }
                    }else{
                        echo "No destination specified<br />";
                    }
                    break;
                case "delete":
                    //TODO: prompt to make certain
                    require_once('ProcessFile.php');
                    
                    if (deleteFile($file)){
                        echo "File deleted successfully<br />";
                    }else{
                        echo "File could not be deleted<br />";
                    }
                    break;
                case "rename":
                    if (isset($_POST['newName']) && !is_dir($_POST['newName'])){
                        $newName = basename($_POST['newName']);
                        require_once('ProcessFile.php');
                        if (renameFile($file, $newName, $overwrite)){
                            echo "Rename successful<br />";
                        }else{
                            echo "Rename failed<br />";
                        }
                    }else{
                        echo "Rename failed<br />";
                    }
                    break;
                default:
                    break;
            }
            echo "<a href=\"index.php\">Return to index</a>";
            exit;
        }/*else{
            //echo 'No action specified';
        }*/

    }else{
        echo "File doesn't exist";
        echo "<a href=\"index.php\">Return to index</a>";
        exit;
    }

}else{
    echo "No file specified<br />";
    echo "<a href=\"index.php\">Return to index</a>";
    exit;
}

require_once('ProcessFile.php');
if ($exists){
    $destDirList = getDirs($dest);
    $file = basename($file);
    //create combobox filled with possible dirs
    echo "<br />";
    echo "Source base directory: <b>$basedir</b><br />";
    echo "Target base directory: <b>$dest</b><br />";
    echo "File to manipulate: <b>$file</b><br />";
    echo "<br />";
    
    $fattrs = stat($basedir . $file);
    $fSize = $fattrs[size];
    $unit = 'Bytes';
    if ($fSize > 1024 * 1024){
        $fSize /= 1024 * 1024;
        $unit = 'MB';
    }elseif ($fSize > 1024){
        $fSize /= 1024;
        $unit = 'KB';
    }
    $fSize = number_format($fSize, 2, '.', '');
    echo "Size: $fSize $unit<br />";
    echo 'Last modified: ' . date('d M Y H:i:s', $fattrs[mtime]) . "<br />";
    echo "<br />";
    
    $combo = "<select name=\"dest\" style=\"width:145pt;\">";
    foreach ($destDirList as $destDir) {
        $combo .= "<option value=\"$destDir\">" . $destDir . "</option>";
    }
    $combo .= "</select>";
    //echo $combo;
    echo "<form action=\"index.php\" method=\"post\">
            <button name=\"action\" type=\"submit\" value=\"move\" style=\"width:100pt;\">Move file</button>
            <input type=\"text\" name=\"file\" value=\"$file\" readonly />
            to
            $combo
            <input type=\"checkbox\" name=\"overwrite\" value=\"yes\" />Overwrite if already exists
        </form>";
    echo "<form action=\"index.php\" method=\"post\">
            <button name=\"action\" type=\"submit\" value=\"delete\" style=\"width:100pt;\">Delete file</button>
            <input type=\"text\" name=\"file\" value=\"$file\" readonly />
        </form>";
    echo "<form action=\"index.php\" method=\"post\">
            <button name=\"action\" type=\"submit\" value=\"rename\" style=\"width:100pt;\">Rename</button>
            <input type=\"text\" name=\"file\" value=\"$file\" readonly />
            to
            <input type=\"text\" name=\"newName\" value=\"\" maxlength=\"30\" />
            <input type=\"checkbox\" name=\"overwrite\" value=\"yes\" />Overwrite if already exists
         </form>";
    echo "<form action=\"index.php\" method=\"post\">
            <button name=\"action\" type=\"submit\" value=\"copy\" style=\"width:100pt;\">Copy file</button>
            <input type=\"text\" name=\"file\" value=\"$file\" readonly />
            to
            $combo
            <input type=\"checkbox\" name=\"overwrite\" value=\"yes\" />Overwrite if already exists
        </form>";
    echo "<form enctype=\"multipart/form-data\" action=\"index.php\" method=\"upload\">
            <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000\" />
            File <input type=\"file\" name=\"upload\" />
        </form>";
         //unzip
         //
}
?>