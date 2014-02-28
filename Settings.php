<?php

if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

DEFINE(host, 'localhost');
DEFINE(dbUser, 'root');
DEFINE(dbPass, 'toor');
DEFINE(dbName, 'Mover');

DEFINE(loginRequired, true);
DEFINE(displayFolders, true);

DEFINE(supportedFormats, 'zip;rar;html');
/*
	Semi-colon separated list of formats of files to search for in source directory.
	Retrieved via: preg_split('/;/', supportedFormats, -1, PREG_SPLIT_NO_EMPTY);
	eg. $formats = preg_split('/;/', supportedFormats, -1, PREG_SPLIT_NO_EMPTY);
	Thereafter, $formats is an array of permitted extensions.
*/

DEFINE(basedir, dirname(__FILE__) . '/'); //source directory; contains files to be manipulated
DEFINE(dest, basedir . 'workspace/'); //default target directory; target of copy, move, etc. operations
DEFINE(uploaddir, '/tmp/');

?>