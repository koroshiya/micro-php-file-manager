<?php

if (!$fromIndex){die('You must access this through the root index!');}

DEFINE(host, 'localhost');
DEFINE(dbUser, 'root');
DEFINE(dbPass, '');
DEFINE(dbName, 'Mover');

$supportedFormats = array('zip', 'rar', 'html'); //formats of files to search for in source directory
$basedir = dirname(__FILE__) . '/'; //source directory; contains files to be manipulated
$dest = $basedir . 'workspace/'; //default target directory; target of copy, move, etc. operations

?>