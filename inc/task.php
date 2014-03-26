<?php

if (!fromIndex){
	die('You must access this through the root index!');
}elseif (!isset($_SESSION['SPOTS_authorized']))){
	die("You are not permitted to access this page");
}elseif (!isset($_POST['seriesID']) or empty($_POST['seriesID'])){
	die("No seriesID set");
}elseif (!isset($_POST['userID']) or empty($_POST['userID'])){
	die("No userID set");
}elseif (!isset($_POST['chapterNumber']) or empty($_POST['chapterNumber'])){
	die("No chapterNumber set");
}elseif (!isset($_POST['chapterSubNumber']) or empty($_POST['chapterSubNumber'])){
	die("No chapterSubNumber set");
}elseif (!isset($_POST['userRole']) or empty($_POST['userRole'])){
	die("No userRole set");
}

$id = $_POST['userID'];
DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir . 'UserIO.php');
session_start();

$pm = getUser($id);

?>

<section>
	
	<center>
		<div id="projectDiv">
			<table><tbody>
			<?php
				echo "<tr><th>Series</th><td>$_POST['seriesName']</td>";
				echo "<tr><th>Chapter</th><td>$_POST['chapterNumber']</td>";
				echo "<tr><th>Sub-Chapter</th><td>$_POST['chapterSubNumber']</td>";
				echo "<tr><th>Task Role</th><td>$_POST['userRole']</td>";
				echo "<tr><th>Role Status</th><td>$_POST['cstatus']</td>";
				echo "<tr><th>Assigned User</th><td>$pm[1]</td>";
				echo "<tr><th>Notes</th><td><textarea>$_POST['desc']</textarea></td>";
			?>
			</tbody></table>
		</div>
	</center>
</section>
<script type="text/javascript">
	$("#sidebar").html('<a class="sidebar_item" id="sidebar_back">Back to Projects</a>');
	$("#sidebar_back").click(function(){
		resetSidebar();
		showTasks();
	});
</script>