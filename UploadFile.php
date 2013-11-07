<?php
if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

echo "<div style=\"top:50%;margin: -110pt 0 0 0px;position:relative;\">";

if (isset($_FILES['upload'])) {
	require_once('./ProcessFile.php');
	if (uploadFile('upload', uploaddir)){
		echo '<p><em>File uploaded successfully!</em></p>';
	}else{
		echo 'File upload failed';
	}
    echo "<a href=\"index.php\">Return to index</a>";
}else{

?>

<div class="upload-form">
	<span class="h3">Target directory:</span><br />
	<?php echo dest; ?><br /><br /><br /><br />
	<!--Name of file to upload: <br />-->

	<form enctype="multipart/form-data" action="index.php" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" name="upload" /><br />
        <button name="action" type="submit" value="upload" class="upload-button">Upload file</button>
    </form>
</div></div>

<?php

}

?>