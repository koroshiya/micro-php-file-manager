<?php
if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

function printError($message){
    echo "<br /><center><span class=\"error\">".$message."</span></center>";
}
function finishPrematurely($message){
    echo "<br /><center><h3>".$message."</h3></center>";
    require_once('./ListFile.php');
    exit;
}
$exists = false;
if (isset($_POST['file']) && !is_dir($_POST['file'])) {
    $dest = dest;
    $absFile = basedir . "/" . $file;
    $exists = file_exists($absFile);
    if ($exists) {
        $file = basename($_POST['file']);

        if (isset($_POST['action'])){
            $action = $_POST['action'];
            $file = basedir . $file;
            $overwrite = (isset($_POST['overwrite']) && $_POST['overwrite'] === "yes");
            switch ($action){
                case "move":
                    if (isset($_POST['dest']) && is_dir($dest .$_POST['dest'])){
                        $dest .= basename($_POST['dest']);
                        if (file_exists($dest) && is_dir($dest)){
                            require_once('ProcessFile.php');
                            if (moveFile($file, $dest, $overwrite)){
                                $dest .= "/" . basename($file);
                                finishPrematurely("Moved $file to $dest");
                            }else{
                                printError("Failed to move $file to $dest");
                            }
                        }else{
                            printError("Directory doesn't exist");
                        }
                    }else{
                        printError("No destination specified");
                    }
                    break;
                case "copy":
                    if (isset($_POST['dest']) && is_dir($dest .$_POST['dest'])){
                        $dest .= basename($_POST['dest']);
                        if (file_exists($dest) && is_dir($dest)){
                            require_once('ProcessFile.php');
                            if (copyFile($file, $dest, $overwrite)){
                                $dest .= "/" . basename($file);
                                finishPrematurely("Copied $file to $dest");
                            }else{
                                printError("Failed to copy $file to $dest");
                            }
                        }else{
                            printError("Directory doesn't exist");
                        }
                    }else{
                        printError("No destination specified");
                    }
                    break;
                case "delete":
                    //TODO: prompt to make certain
                    require_once('ProcessFile.php');
                    
                    if (deleteFile($file)){
                        finishPrematurely("File deleted successfully");
                    }else{
                        printError("File could not be deleted");
                    }
                    break;
                case "rename":
                    if (isset($_POST['newName']) && !is_dir($_POST['newName'])){
                        $newName = basename($_POST['newName']);
                        require_once('ProcessFile.php');
                        if (renameFile($file, $newName, $overwrite)){
                            finishPrematurely("Rename successful");
                        }else{
                            printError("Rename failed");
                        }
                    }else{
                        printError("Rename failed");
                    }
                    break;
                default:
                    break;
            }
            //echo "<a href=\"index.php\">Return to index</a>";
            //exit;
        }/*else{
            //echo 'No action specified';
        }*/

    }else{
        printError("File doesn't exist");
        //echo "<a href=\"index.php\">Return to index</a>";
        //exit;
    }

}else{
    printError("No file specified");//<a href=\"index.php\">Return to index</a>";
    //exit;
}

require_once('./ProcessFile.php');
if ($exists){
    
    echo "<div style=\"padding-top:20pt;\"><div class=\"move-form\">";
    
    $destDirList = getDirs($dest);
    $file = basename($file);
    //create combobox filled with possible dirs
    echo "<br />
        Source base directory: <b>".basedir."</b><br />
        Target base directory: <b>".dest."</b><br />
        File to manipulate: <b>$file</b><br />
        <br />";
    
    $fattrs = stat(basedir . $file);
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
    $input = '<input type="text" name="file" value="'.$file.'" readonly />';
?>
    <form action="index.php" method="post">
        <button name="action" type="submit" value="move" class="upload-button">Move file</button>
        <?php echo $input; ?>
        to
        <?php echo $combo;?>
        <input type="checkbox" name="overwrite" value="yes" />Overwrite if already exists
    </form>

    <form action="index.php" method="post">
        <button name="action" type="submit" value="delete" class="upload-button">Delete file</button>
        <?php echo $input; ?>
    </form>
    <form action="index.php" method="post">
        <button name="action" type="submit" value="rename" class="upload-button">Rename</button>
        <?php echo $input; ?>
        to
        <input type="text" name="newName" value="" maxlength="30" style="width:142pt;" />
        <input type="checkbox" name="overwrite" value="yes"/>Overwrite if already exists
    </form>
    <form action="index.php" method="post">
        <button name="action" type="submit" value="copy" class="upload-button">Copy file</button>
        <?php echo $input; ?>
        to
        <?php echo $combo;?>
        <input type="checkbox" name="overwrite" value="yes" />Overwrite if already exists
    </form>
<?php
    /*echo "<form enctype=\"multipart/form-data\" action=\"index.php\" method=\"upload\">
            <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000\" />
            File <input type=\"file\" name=\"upload\" />
        </form>";*/
         //unzip
         //
}
?>
</div></div>