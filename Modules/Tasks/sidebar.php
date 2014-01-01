<nav id="sidebar">
	<div class="sidebar_heading">Sort:</div>
	<form method="GET" style="text-align:center;">
		<input type="hidden" name="action" value="Tasks">
		<select name="pname" style="width:80%"> <!-- This drop-down will sort your tasks by Project title -->
			<option>Series Name...</option>
			<option>Dummy Data</option>
		</select><br />
		<select name="task" style="width:80%"> <!-- This drop-down will sort your tasks by the title of the task -->
			<option>Task Name...</option>
			<option>Cleaning</option>
			<option>Redrawing</option>
			<option>Typesettings</option>
		</select><br />
		<input type="submit" value="Sort Projects">
	</form>
</nav>
