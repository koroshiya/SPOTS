<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You must be logged in to access this page.');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'UserIO.php');

$users = getUsersAll();

?>

<section>
	
	<center>

		<form id="MyUploadForm">
			<input maxlength="100" type="text" id="form_title" name="form_title" />
			<select id="form_status" name="form_status">
				<option value="A">Active</option>
				<option value="S">Stalled</option>
				<option value="I">Inactive</option>
				<option value="H">Hiatus</option>
				<option value="D">Dropped</option>
				<option value="C">Complete</option>
			</select>
			<textarea maxlength="255" id="form_desc" name="form_desc"></textarea>
			<select id="form_pm" name="form_pm">
				<option value="-1">No project manager</option>
				<?php
					foreach ($users as $user) {
						echo "<option value=\"$user[0]\">".$user[1]."</option>";
					}
				?>
			</select>
			<input type="checkbox" id="form_public" name="form_public" />
			<input type="checkbox" id="form_adult" name="form_adult" />
		</form>

	</center>

</section>

<script type="text/javascript">
	
</script>