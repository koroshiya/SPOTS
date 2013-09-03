<?php
if (!$fromIndex){die('You must access this through the root index!');}

$parent = dirname(dirname(dirname(dirname(__FILE__)))) . '/Database/';
include_once($parent . 'SeriesIO.php');
include_once($parent . 'UserIO.php');

if (isset($_GET['series_search']) && isset($_GET['status'])) {
	$seriesList = getSeriesByStatusAndTitle($_GET['status'], $_GET['series_search']);
}else if (isset($_GET['series_search']) && !isset($_GET['status'])) {
	$seriesList = getSeriesByTitle($_GET['series_search']);
}else if (isset($_GET['status']) && !isset($_GET['series_search'])) {
	$seriesList = getSeriesByStatus($_GET['status']);
}else {
	$seriesList = getSeriesAll();
}

?>
<span style="font-style:italic; font-size:10pt;">Click on a title to edit the series</span><br>
<table id="projectList">
<tr class="projectListRow" id="projectListHeader">
	<td class="projectTitle">Project Title</td>
	<td class="projectStatus">Status</td>
	<td class="projectManager">Project Manager</td>
</tr>
<?php

foreach ($seriesList as $series) {
	if ($series[5] !== null){
		$projectManager = getUser($series[5]);
		if (is_array($projectManager) && sizeof($projectManager) > 1){
			$name = $projectManager[1];
		}else{
			$name = 'N/A';
		}
	}else{
		$name = 'N/A';
	}
	
	$projectModifyUrl = '?action=Projects&amp;sub=Modify_Project&amp;project='.str_replace('\0', '', $series[1]);
	echo '<tr class="projectListRow">
			<td class="projectTitle"><a href="'.$projectModifyUrl.'">'.$series[1].'</a></td>
			<td class="projectStatus">'. getSeriesStatusFromChar($series[2]) .'</td>
			<td class="projectManager">'. $name .'</td>
		</tr>';
}
?>

</table>