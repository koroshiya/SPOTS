<nav id="sidebar">
	<form method="GET" style="text-align:center;">
		<input type="hidden" name="action" value="Projects">
		<input type="text" name="series_search" id="projectSearch" value="Search..." onfocus="if (this.value == 'Search...'){this.value=''}" onblur="if (this.value == ''){this.value='Search...'}" style="width:85%">
	</form>
	<a class="sidebar_item" href="?action=Projects&amp;sub=Add_Project">Add Project</a><br />

	<div class="sidebar_heading">Sort:</div>
	<form method="GET" style="text-align:center;">
		<input type="hidden" name="action" value="Projects">
		<select name="status" style="width:80%;">
			<option value="">All Projects</option>
			<option value="a">Active</option>
			<option value="s">Stalled</option>
			<option value="i">Inactive</option>
			<option value="h">Hiatus</option>
			<option value="c">Complete</option>
			<option value="d">Dropped</option>
		</select><br />
		<input type="submit" value="Sort Projects">
	</form>
</nav>