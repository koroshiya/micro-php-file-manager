<?php
if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

echo "<div style=\"top:50%;margin: -75px 0 0 0px;position:relative;\">";

if (isset($_FILES['upload'])) {
	require_once('./ProcessFile.php');
	if (uploadFile('upload', '/tmp/')){
		echo '<p><em>File uploaded successfully!</em></p>';
	}else{
		echo 'File upload failed';
	}
    echo "<a href=\"index.php\">Return to index</a>";
}else{

echo "<div style=\"text-align:left;\">
	Target directory: $basedir<br />
	<!--Name of file to upload: <br />-->"

?>
	<form enctype="multipart/form-data" action="index.php" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        File <input type="file" name="upload" /><br />
        <button name=\"action\" type=\"submit\" value=\"upload\" style=\"width:100pt;\">Upload file</button>
    </form>
</div></div>

<?php

}

?>