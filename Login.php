<?php

if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

if (isset($_SESSION['MPFM_authorized'])){
    $_SESSION['MPFM_authorized'] = null;
}

?>

    <body class="background">

<!--[if lt IE 9]>
<br /><br /><p>&emsp;You are using an <b>outdated</b> browser.<br />
&emsp;To ensure compatibility, please use a <a href="http://browsehappy.com/">modern browser</a>.
<![endif]-->

		<div id="wrapper">

	<form name="login-form" class="login-form" action="" method="post">
	
		<div class="header">
		<h1>micro-fm Login</h1>
		<span>Please enter your username and password in the fields below.</span>
		</div>
	
		<div class="content">
		<input name="username" type="text" class="input username" placeholder="Username" />
		<div class="user-icon"></div>
		<input name="password" type="password" class="input password" placeholder="Password" />
		<div class="pass-icon"></div>
		</div>

		<div class="footer">
		<input type="submit" name="submit" value="Login" class="button" />
		<?php
			if (isset($_POST['password']) || isset($_POST['username'])){
				echo "<p style=\"color:red;\">Incorrect username or password!</p>";
			}
		?>
		</div>
	
	</form>

</div>
<div class="gradient"></div>