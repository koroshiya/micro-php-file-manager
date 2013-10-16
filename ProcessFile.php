<?php

if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

/*ProcessFile.php*/

/**
 * Moves a single file to another location on disk.
 * ex. $boolResult = moveFile('/home/user/file.html', '/home/newUser');
 * ^Would move /home/user/file.html to /home/newUser/file.html
 *
 * @param $file Absolute file path of file to move.
 * @param $dest Full name of path to move file to.
 * @param $force If true, overwrite any existing file defined by the new name.
 *
 * @return True if successful, otherwise false.
 */
function moveFile($file, $dest, $force){
	$dest .= "/" . basename($file);
	if (!(!$force && file_exists($dest))){
		if (validFile($file) && validDir($dest)){
			return rename($file, $dest);
		}
	}
	return false;
}

/**
 * Copies a single file from one location on disk to another.
 * ex. $boolResult = copyFile('/home/user/file.html', '/home/newUser');
 * ^Would create the file /home/newUser/file.html, leaving the original file intact.
 *
 * @param $file Absolute file path of file to move.
 * @param $dest Full name of path to copy file to.
 * @param $force If true, overwrite any existing file defined by the new name.
 *
 * @return True if successful, otherwise false.
 */
function copyFile($file, $dest, $force){ //currently copies as PHP user
	$test = $dest . "/" . basename($file);
	if (!(!$force && file_exists($test))){
		if (validFile($file) && validDir($dest)){
			return copy($file, $test);
		}
	}
	return false;
}

/**
 * Checks to see if a variable passed in points to a valid file.
 * Convenience method for checking if a file exists and is not a directory.
 * ex. $boolValid = validFile('/home/user/file.html');
 *
 * @param $file Absolute path of file to check.
 *
 * @return True if file is valid, otherwise false.
 */
function validFile($file){
	if (!file_exists($file)){
		echo 'File doesn\'t exist';
		return false;
	}elseif (is_dir($file)){
		echo 'Source is a directory';
		return false;
	}
	return true;
}

/**
 * Checks to see if a variable passed in points to a valid directory.
 * Convenience method for checking if a directory exists, it is indeed a directory, and is writable.
 * ex. $boolValid = validDir('/home/user/');
 *
 * @param $file Absolute path of directory to check.
 *
 * @return True if file is valid, otherwise false.
 */
function validDir($dir){
	if (!file_exists($dir)){
		echo "$dir does not exist";
		return false;
	}elseif(!is_dir($dir)){
		echo "$dir is not a directory";
		return false;
	}elseif(!is_writable($dir)){
		echo "$dir is not writable";
		return false;
	}
	return true;
}

/**
 * Renames a file. First checks if the file exists and the new filename is valid.
 * ex. $boolSuccess = renameFile('/home/user/file.html', 'test.html');
 *
 * @param $file Absolute path of file to rename.
 * @param $newName New name to give to file.
 * @param $force If true, overwrite any existing file defined by the new name.
 *
 * @return True if successful, otherwise false.
 */
function renameFile($file, $newName, $force){
	$newName = dirname($file) . "/" . basename($newName);
	if (!(!$force && file_exists($newName))){
		if (validFile($file) && validFilename($newName)){
			if (rename($file, $newName)){
				return true;
			}
		}
	}
	return false;
}

/**
 * Checks a file to see if its name is valid.
 * ie. Checks for invalid filename characters, such as {, }, ?, etc.
 * ex. $boolValid = validFilename('file.html');
 *
 * @param $file Filename to check.
 *
 * @return True if name is valid, otherwise false.
 */
function validFilename($file){
	$regex = "/^[^\/\?\*:;{}\\\]+\.[^\/\?\*:;{}\\\]+$/";
	if (!preg_match($regex, basename($file))){
		echo "Invalid filename<br />";
		return false;
	}
	return true;
}

/**
 * Deletes a file from disk.
 * ex. $boolSuccess = deleteFile('/home/user/file.html');
 *
 * @param $file Absolute path of file to delete.
 *
 * @return True if successful, otherwise false.
 */
function deleteFile($file){
	$result = false;
	if (file_exists($file) && !is_dir($file)){
		$result = unlink($file);
	}
	return $result;
}

/**
 * Retrieves all files in a directory that fit the extension(s) passed in.
 *
 * @param $dir String representing directory within which to look for files.
 * @param $ext Array of extensions (or single extension) pertaining to files to look for.
 *				NULL if you want to return all non-hidden files.
 *
 * @return Array of strings representing files found in directory.
 **/
function getFilesByExtension($dir, $ext){

	if ($ext !== null && !is_array($ext)){
		$ext = array($ext);
	}

	$files = scandir($dir);
	$fileList = array();
	foreach ($files as $file) {
		if (!is_dir($file) && $file[0] != ".") {
			$file_parts = pathinfo($file);
			$fileExtension = $file_parts['extension'];
			if ($ext === null){
				array_push($fileList, $file);
			}else{
				foreach ($ext as $key) {
					if ($key === $fileExtension){
						array_push($fileList, $file);
					}
				}
			}
		}
	}
	return $fileList;
}

/**
 * Retrieves all non-hidden first-level directories within a directory.
 *
 * @param $dir String representing directory within which to look for files.
 *
 * @return Array of strings representing first-level directories found within a directory.
 */
function getDirs($dir){

	$fileList = array();
	if ($handle = opendir($dir)){
		while (false !== ($entry = readdir($handle))) {
			if (is_dir($dir . $entry) && $entry[0] != "."){
            	array_push($fileList, $entry);
        	}
    	}
    	closedir($handle);
	}
	return $fileList;
}

/**
 * Finishes a single 
 *
 * @param $name Name of upload request. Should be assigned by the calling form.
 * @param $dest Absolute path to upload file to, including preceeding and trailing slashes.
 *				eg. '/tmp/' is valid, '/tmp' is not.
 *
 * @return True if successful, otherwise false.
 */
function uploadFile($name, $dest){
	return move_uploaded_file ($_FILES[$name]['tmp_name'],
							"$dest{$_FILES[$name]['name']}");
}

?>