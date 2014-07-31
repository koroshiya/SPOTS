<?php

session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
	die("You are not permitted to access this page");
}elseif (!isset($_POST['seriesID'])){
	die("No seriesID set");
}elseif (!isset($_POST['userID'])){
	die("No userID set");
}elseif (!isset($_POST['chapterNumber'])){
	die("No chapterNumber set");
}elseif (!isset($_POST['chapterSubNumber'])){
	die("No chapterSubNumber set");
}elseif (!isset($_POST['userRole']) or empty($_POST['userRole'])){
	die("No userRole set");
}

$id = $_POST['userID'];
DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir . 'UserIO.php');

$pm = getUser($id);

?>

<section>
	<center>
		<div id="projectDiv">
			<table><tbody>
				<tr><th>Series</th><td><?php echo $_POST['seriesName']; ?></td>
				<tr><th>Chapter</th><td><?php echo $_POST['chapterNumber']; ?></td>
				<tr><th>Sub-Chapter</th><td><?php echo $_POST['chapterSubNumber']; ?></td>
				<tr><th>Task Role</th><td><?php echo $_POST['userRole']; ?></td>
				<tr><th>Role Status</th><td><?php echo $_POST['status']; ?></td>
				<tr><th>Assigned User</th><td><?php echo $pm['userName']; ?></td>
				<tr><th>Notes</th><td><textarea><?php echo $_POST['desc']; ?></textarea></td>
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