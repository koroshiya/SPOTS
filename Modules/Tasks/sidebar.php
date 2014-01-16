<nav id="sidebar">
	<div class="sidebar_heading">Sort:</div>
	<form method="GET" style="text-align:center;">
		<input type="hidden" name="action" value="Tasks">
		<select name="pname" style="width:80%"> <!-- This drop-down will sort your tasks by Project title -->
			<option>Series Name...</option>
			<option>All</option>
		</select><br />
		<select name="role" style="width:80%"> <!-- This drop-down will sort your tasks by the title of the task -->
			<option>Task Name...</option>
			<option>All</option>
			<option>Cleaning</option>
			<option>Redrawing</option>
			<option>Typesettings</option>
		</select><br />
		<select name="status" style="width:80%"> <!-- This drop-down will sort your tasks by the status of the task -->
			<option>Task Status...</option>
			<option>All</option>
			<option>Active</option>
			<option>Inactive</option>
			<option>Stalled</option>
			<option>Complete</option>
		</select><br />
		<input type="submit" value="Sort Projects">
	</form>
</nav>
