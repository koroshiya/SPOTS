<?php
if (!fromIndex){die('You must access this through the root index!');}

if (isset($_GET['project']) && is_numeric($_GET['project'])) {
	$projID = (int)$_GET['project'];
	require_once(databaseDir . 'SeriesIO.php');

	$series = getSeriesByID($projID);
	$title = $series[1];
	$statusChar = $series[2];
	$desc = $series[3];
	$isVisible = $series[6];
	$isAdult = $series[7];
	$statusString = getSeriesStatusFromChar($statusChar);
	
	$statusStrings = array('Active', 'Inactive', 'Stalled', 'Hiatus', 'Dropped', 'Complete');
	$statusArray = array();
	foreach ($statusStrings as $key) {
		$line = "<option value=\"$key\"";
		if ($key === $statusString){
			$line .= 'selected="selected"';
		}
		$line .= ">$key</option>";
		array_push($statusArray, $line);
	}

/*if (isset($_POST['projectGenres'])) {
	foreach($_POST['projectGenres'] as $projectGenre) {
    	$projectGenresString .= '<li class="projectGenre">'.$projectGenre.'</li>';
    }
    echo $projectGenresString;
    echo $_POST['projectDescription'];
}*/

//Dummy data to be replaced with a SQL call later
$genres = array(
	'Action', 'Drama', 'Romance', 'Tragedy'
);

echo '<div id="wrapper">
<span class="sectionTitle" style="margin-left:-15px;">Add Project</span><br /><br />
<form id="add_project" method="POST">
	<table>
	<tr>
	<td><span class="subTitle">Title</span><br />';
echo "<input name=\"projectTitle\" type=\"text\" value=\"$title\"></td>";
echo '<td><span class="subTitle">Author</span><br />
	<input name="projectAuthor" type="text"></td>
	<td><span class="subTitle">Artist</span><br />
	<input name="projectArtist" type="text"></td>
	</tr>
	<tr>
	<td><span class="subTitle">Type</span><br />
	<select name="projectType" style="width:100px;">
		<option value="Manga">Manga</option>
		<option value="Manhwa">Manhwa</option>
		<option value="Manhua">Manhua</option>
		<option value="Webtoon">Webtoon</option>
	</select></td>
	<td><span class="subTitle">Status</span><br />
	<select name="projectStatus" style="width:100px;">
		';
	foreach ($statusArray as $key) {
		echo $key;
	}
echo '</select></td>
	<td><span class="subTitle">Is Adult</span><br />
	<select name="isAdult" style="width:100px;">';
echo ("<option value=\"0\"" . ($isAdult ? '' : 'selected="selected"') . ">No</option>");
echo ("<option value=\"1\"" . ($isAdult ? 'selected="selected"' : '') . ">Yes</option>");
echo '</select></td>
	</tr>
	</table><br />
	<span class="subTitle">Genres</span><br />';
	
		//Do note that I haven't quite figured out how to make the genres line up correctly. I'm assuming a table of some sort would be best but the last time I tried that it didn't work so meh
		$count = 0;
		foreach($genres as $genre) {
			echo '<input type="checkbox" name="projectGenres[]" value="'.$genre.'" id="genre'.$count.'"><label for="genre'.$count.'">'.$genre.'</label>';
			$count++;
		}
	
echo '<br /><br />
	<span class="subTitle">Description</span><br />';
echo "<textarea name=\"projectDescription\" style=\"width:800px; height:70px\">$desc</textarea><br /><br />";
echo '<span class="subTitle">Visible to Public</span><br />
	<select name="visibleToPublic" style="width:100px;">';
echo ("<option value=\"0\"" . ($isVisible ? '' : 'selected="selected"') . ">No</option>");
echo ("<option value=\"1\"" . ($isVisible ? 'selected="selected"' : '') . ">Yes</option>");
echo '</select><br /><br />
	<input name="submit" value="Add Project" type="submit"><br /><br />
</form>
</div>';
}else{
	echo 'Invalid series';
}
?>