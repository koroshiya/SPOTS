<?php

require_once('./header.php');

echo "<div style=\"overflow-x:hidden;top:50%;margin: -75px 0 0 0px;position:fixed;\">
		<div style=\"margin: 0px 0 0 -150px; position:fixed; left:50%; \">";

if (isset($_SESSION['username'])){ //session_is_registered(username)
	echo "Login successful";
}else{

	if (isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		require_once('./Database/Connection.php');
		global $connection;
		if ($connection === null || !mysqli_ping($connection)){
			connect('localhost', 'root', '', 'SPOTS');
		}
		if ($connection === null || !mysqli_ping($connection)){
			die('Database connection failed');
		}else{
			require_once('./Database/UserIO.php');
			$valid = userGetPasswordIsValidByName($username, $password);
			if ($valid){
				session_register("username");
				session_register("password");
				echo "Login successful<br />";
			}else{
				echo "Wrong Username or Password<br />";
			}
		}

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

<?php

}

echo "</div></div>";

require_once('./footer.html');

?>