<?php
if (!$fromIndex)
	die('You must access this through the root index!');
$genres = array(
		'Action',
		'Adult',
		'Adventure',
		'Comedy',
		'Doujinshi',
		'Drama',
		'Ecchi',
		'Fantasy',
		'Gender Bender',
		'Harem',
		'Hentai',
		'Historical',
		'Horror',
		'Josei',
		'Lolicon',
		'Martial Arts',
		'Mature',
		'Mecha',
		'Mystery',
		'Psychological',
		'Romance',
		'School Life',
		'Sci-fi',
		'Seinen',
		'Shotacon',
		'Shoujo',
		'Shoujo-Ai',
		'Shounen',
		'Shounen-Ai',
		'Slice of Live',
		'Smut',
		'Sports',
		'Supernatural',
		'Tragedy',
		'Yaoi',
		'Yury'
	);

function manageProjects($type) {
	global $genres;

	echo '
		<form id="'.$type.'Project" method="POST">
		<span class="pTitle">Project Title</span><br>
		<input name="projectTitle" type="text"><br>
		<span class="pGenres">Project Genres</span><br>
	';
	foreach($genres as $genre) {
		$_genre = str_replace(' ', '_', $genre);
		echo '<label><input type="checkbox" name="'.$type.'ProjectGenres[]" value="'.$genre.'">'.$genre.'</label>';
	}
	echo '
		<br>
		<span class="">Project Description</span>
		<br><input type="textarea" name="projectDescription">
		<br><input type="submit" value="Submit">
		</form>
	';
}

$projectGenresString = '';
	foreach($_POST['addProjectGenres'] as $projectGenresTemp) {
    	$projectGenresString .= '<li class="projectGenreLi">'.$projectGenresTemp.'</li>';
    }

if (isset($_POST['addProject']) and $_POST['addProject'] === true) {
	$lastID = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT count(projectID) FROM projects'));
	$projectID = lastID + 1;

	if (
		is_string($_POST['projectName']) and 
		is_string($projectGenresString) and 
		is_string($_POST['projectDescription']) and
		is_int($_POST['projectStatus']) and
		is_string($_POST['projectImage']) and
		is_int($_POST['projectManagerID']) and
		is_bool($_POST['visableToPublic']) and
		is_bool($_POST['isAdult'])) {

			mysqli_query($dbconnect, "INSERT INTO projects VALUES (
				{$projectID}, 
				{$_POST['projectName']}, 
				{$_POST['projectGenres']}, 
				{$_POST['projectDescription']}, 
				{$_POST['projectStatus']}, 
				{$_POST['projectImage']}, 
				{$_POST['projectManagerID']}, 
				{$_POST['visableToPublic']}, 
				{$_POST['isAdult']}
				)"
			);
	
	}

}

?>

<span class="sectionTitle">Add Project</span>
<div class="section">
	<?php
		manageProjects('add');
	?>
</div>