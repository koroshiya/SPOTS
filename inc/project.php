<?php

if (!fromIndex){die('You must access this through the root index!');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

if (!isset($_POST['id']) or empty($_POST['id'])){
	die("No ID set");
}

$id = $_POST['id'];
require_once(databaseDir . 'SeriesIO.php');
session_start();
$seriesInfo = getSeriesByID($id);
if (!$seriesInfo[0] || (!$seriesInfo[6] && !isset($_SESSION['SPOTS_authorized']))){
	die("You are not permitted to view this series");
}
require_once(databaseDir . 'UserIO.php');
$pm = getUser($seriesInfo[5]);

?>

<section>
	
	<center>
		<div id="projectDiv">
			<table><tbody>
			<?php
				echo "<tr><th>Title</th><td>$seriesInfo[1]</td>";
				echo "<tr><td colspan=\"2\" style=\"height:200px;\"><img style=\"max-height:200px; max-width:200px;\" src=\"thumbs/Aiki.jpg\" /></td></tr>"; //TODO: series image
				echo "<tr><th>Status</th><td>$seriesInfo[2]</td>";
				echo "<tr><th>Project Manager</th><td>$pm[1]</td>";
				/*
	seriesID smallint unsigned not null AUTO_INCREMENT,0
	seriesTitle varchar(100) not null,1
	status character null,2
	description varchar(255) null,3
	thumbnailURL varchar(255) null,4
	projectManagerID smallint unsigned null,5
	visibleToPublic boolean not null,6
	isAdult boolean not null,7
	author varchar(50) null,8
	artist varchar(50) null,9
	type varchar(50) null, --eg. manga, manhwa, etc.10
				*/
			?>
			</tbody></table>
		</div>
	</center>
</section>
<script type="text/javascript">
	$("#sidebar").html('<a class="sidebar_item" id="sidebar_back">Back to Projects</a>');
	$("#sidebar_back").click(function(){GoToPage("projects");});
</script>