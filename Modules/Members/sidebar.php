<nav id="sidebar">
	<form method="GET" style="text-align:center;">
		<input type="hidden" name="action" value="Members">
		<input type="text" name="memberSearch" id="memberSearch" value="Search..." onfocus="if (this.value == 'Search...'){this.value=''}" onblur="if (this.value == ''){this.value='Search...'}" style="width:85%">
	</form>
	<a class="sidebar_item" href="?action=Members&amp;sub=Add_Member">Add Member</a><br>

	<div class="sidebar_heading">Sort:</div>
	<form method="GET" style="text-align:center;">
		<input type="hidden" name="action" value="Members">
		<select name="position" style="width:80%;">
			<option value="">All Members</option>
			<option value="a">Administrators</option>
			<option value="m">Moderators</option>
			<option value="s">Staff</option>
			<?php
				$parent = dirname(dirname(dirname(__FILE__))) . '/Database/';
				//echo "$parent";
				//include_once($parent . 'Connection.php');
				global $connection;
				if ($connection !== null && mysqli_ping($connection)){
					include_once($parent . 'RoleIO.php');
					foreach (getRolesAll() as $key) {
						echo "<option value=\"$key[0]\">$key[0]</option>";
					}
				}
			?>
			<!--<option>Project Managers</option>
			<option>Translators</option>
			<option>Proofreaders</option>
			<option>Cleaners</option>
			<option>Redrawers</option>
			<option>Typesetters</option>
			<option>Editors</option>
			<option>Quality Checkers</option>-->
		</select><br>
		<select name="status" style="width:80%;">
			<option>Active</option>
			<option>Inactive</option>
			<option>Guest</option>
			<option>MIA</option>
		</select><br>
		<input type="submit" value="Sort Members"><br>
	</form>
	<div style="font-style:italic; font-size:10pt; text-align:center;">Active members are shown by default</div><br>
</nav>