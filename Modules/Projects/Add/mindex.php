<?php
if (!fromIndex){die('You must access this through the root index!');}

//FIXME: Files are not transfered to the server. Probably a stupid mistake on my part but I'll leave it for later.

if (isset($_POST['projectGenres'])) {
	foreach($_POST['projectGenres'] as $projectGenre) {
    	$projectGenresString .= '<li class="projectGenre">'.$projectGenre.'</li>';
    }
}

//Dummy data to be replaced with a SQL call later
$genres = array(
	'Action', 'Drama', 'Romance', 'Tragedy'
);

?>

<div id="wrapper">
<span class="sectionTitle" style="margin-left:-15px;">Add Project</span><br><br>
<form id="add_project" method="POST" enctype="multipart/form-data">
	<table>
	<tr>
	<td><span class="subTitle">Title</span><br>
	<input name="projectTitle" type="text"></td>
	<td><span class="subTitle">Author</span><br>
	<input name="projectAuthor" type="text"></td>
	<td><span class="subTitle">Artist</span><br>
	<input name="projectArtist" type="text"></td>
	</tr>
	<tr>
	<td><span class="subTitle">Type</span><br>
	<select name="projectType" style="width:100px;">
		<option value="Manga">Manga</option>
		<option value="Manhwa">Manhwa</option>
		<option value="Manhua">Manhua</option>
		<option value="Webtoon">Webtoon</option>
	</select></td>
	<td><span class="subTitle">Status</span><br>
	<select name="projectStatus" style="width:100px;">
		<option value="Active">Active</option>
		<option value="Stalled">Stalled</option>
		<option value="Dropped">Dropped</option>
	</select></td>
	<td><span class="subTitle">Is Adult</span><br>
	<select name="isAdult" style="width:100px;">
		<option value="0">No</option>
		<option value="1">Yes</option>
	</select></td>
	</tr>
	</table><br>
	<span class="subTitle">Genres</span><br>
	<?php
		//Do note that I haven't quite figured out how to make the genres line up correctly. I'm assuming a table of some sort would be best but the last time I tried that it didn't work so meh
		$count = 0;
		foreach($genres as $genre) {
			echo '<input type="checkbox" name="projectGenres[]" value="'.$genre.'" id="genre'.$count.'"><label for="genre'.$count.'">'.$genre.'</label>';
			$count++;
		}
	?><br><br>
	<span class="subTitle">Description</span><br>
	<textarea name="projectDescription" style="width:800px; height:70px"></textarea><br><br>
	<span class="subTitle">Visible to Public</span><br>
	<select name="visibleToPublic" style="width:100px;">
		<option value="0">No</option>
		<option value="1">Yes</option>
	</select><br><br>
	<input name="submit" value="Add Project" type="submit"><br><br>
</form>
</div>