<?php
if (!$fromIndex)
	die('You must access this through the root index!');

//I am 100% certain that most of this code can be changed/cleaned up, it's just example code.
//Dummy Data to be replaced with SQL calls later.
$seriesList = array(
'Comic Studio', 'Active', 'Daktyl198',
'Sun-Ken Rock', 'Active', 'Weaper'
);

if (isset($_GET['series_search']) && isset($_GET['status'])) {
	//$seriesList = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT seriesTitle AND status AND projectManager FROM projects WHERE status='.$_GET['status'].' AND seriesTitle LIKE '.$_POST['series_search']));
}
else if (isset($_GET['series_search']) && !isset($_GET['status'])) {
	//$seriesList = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT seriesTitle AND status AND projectManager FROM projects WHERE seriesTitle LIKE '.$_POST['series_search']));
}
else if (isset($_GET['status']) && !isset($_GET['series_search'])) {
	//$seriesList = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT seriesTitle AND status AND projectManager FROM projects WHERE status='.$_GET['status']));
}
else {
	//$seriesList = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT seriesTitle AND status AND projectManager FROM projects));
}

$count = 0;

echo '
<span style="font-style:italic; font-size:10pt;">Click on a title to edit the series</span><br>
<table id="projectList">
<tr class="projectListRow" id="projectListHeader">
	<td class="projectTitle">Project Title</td>
	<td class="projectStatus">Status</td>
	<td class="projectManager">Project Manager</td>
</tr>
';

while (isset($seriesList[$count])) {
	$projectModifyUrl = '?action=Projects&amp;sub=Modify_Project&amp;project='.str_replace('\0', '', $seriesList[$count]);
	echo '<tr class="projectListRow"><td class="projectTitle"><a href="'.$projectModifyUrl.'">'.$seriesList[$count].'</a></td><td class="projectStatus">'.$seriesList[$count+1].'</td><td class="projectManager">'.$seriesList[$count+2].'</td></tr>';
	$count += 3;
}

echo '</table>';

?>
