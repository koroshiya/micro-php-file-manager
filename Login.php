<?php

if (!$fromIndex){
	die('You must access this through the root index!');
}else{
	echo "<div style=\"top:50%;margin: -75px 0 0 0px;position:relative;\">";
	if (isset($_POST['username']) && isset($_POST['password'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		//echo $username;
		global $connection;
		
		echo "<div align=\"center\">";
		if ($connection === null || !mysqli_ping($connection)){
			die('Database connection failed');
		}else{
			require_once('Database.php');
			//$username = quote_smart($username);
			//$password = quote_smart($password);
			//echo $username;
			$valid = login($username, $password);
			if ($valid){
				session_start();
				$_SESSION['authorized'] = 1; //TODO: change depending on user auth level
				echo "Login successful<br />";
				echo "<a href=\"index.php\">Return to index</a>";
				exit;
			}else{
				echo "Wrong Username or Password<br />";
			}
		}
		echo "</div>";

	}

?>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<tr>
		<form name="form1" method="post" action="">
			<td>
				<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
					<tr>
						<td colspan="2"><strong>Member Login</strong></td>
					</tr>
					<tr>
						<td width="78">Username:</td>
						<td width="294"><input name="username" type="text" id="username" maxlength="30"  size="35"></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input name="password" type="password" id="password" maxlength="20" size="35"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="Submit" value="Login"></td>
					</tr>
				</table>
			</td>
		</form>
	</tr>
</table>
</div>
<?php

}

?>