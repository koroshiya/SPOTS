<?php
if (!fromIndex)
	die('You must access this through the root index!');
?>

<div id="wrapper">
<span class="sectionTitle" style="margin-left:-15px;">Add Member</span><br><br>
<form id="add_member" method="POST">
	<table>
	<tr>
	<td><span class="subTitle">Username</span><br>
	<input name="userName" type="text"></td>
	<td><span class="subTitle">Email</span><br>
	<input name="userEmail" type="email"></td>
	</tr>
	<tr>
	<td><span class="subTitle">Position</span><br>
	<select name="userPosition">
		<option value="">All Members</option>
			<option value="a">Administrators</option>
			<option value="m">Moderators</option>
			<option value="s">Staff</option>
			<?php
				/*
				include_once(databaseDir . 'Connection.php');
				
				global $connection;
				if ($connection !== null && mysqli_ping($connection)){
					require_once(databaseDir . 'RoleIO.php');
					foreach (getRolesAll() as $key) {
						echo "<option value=\"$key[0]\">$key[0]</option>";
					}
				}
				*/
			?>
	</select></td>
	<td><span class="subTitle">Is Guest</span><br>
	<select name="userStatus">
		<option>No</option>
		<option>Yes</option>
	</select></td>
	</tr>
	</table><br><br>
	<input name="submit" value="Add User" type="submit"><br><br>
</form>
</div>