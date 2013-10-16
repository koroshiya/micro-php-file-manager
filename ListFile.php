<?php
if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

require_once('./ProcessFile.php');
echo "<center><div class=\"list-div\"><form method=\"post\" action=\"index.php\">";
$supportedFormats = preg_split('/;/', supportedFormats, -1, PREG_SPLIT_NO_EMPTY);
$fileArray = getFilesByExtension(basedir, $supportedFormats);

if (sizeof($fileArray) > 0){
	echo "Select the file to move, rename, delete, etc.<br /><br />";
    foreach ($fileArray as $file) {
    	echo "<article><button name=\"file\" type=\"submit\" value=\"$file\" class=\"edit-button\"></button>$file</article>";
    }
}else{
	echo 'No applicable files in source folder.';
}
?>
</form></div></center>
