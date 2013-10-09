<?php
if (!$fromIndex){die('You must access this through the root index!');}

// I can't find the getStatusByChar function...
function getStatus($input) {
	if ($input == 'a') {
		return 'Active';
	}
	else if ($input == 's') {
		return 'Stalled';
	}
}

include_once($databaseDir.'SeriesIO.php');

$info = getSeriesByID($_GET['project']);

$projectAuthor = 'Author'; // Needs a slot in the Database
$projectArtist = 'Artist'; // Needs a slot in the Database
$projectType = 'Manga'; // Needs a slot in the Database
$projectGenres = array( // I don't know how to access the DB for these...
	'Comedy', 'Harem', 'Romance', 'School Life', 'Shounen'
);

$projectChapters = array(
	array(1, 'Complete', 'index.php')
);

?>
<div id="content">
	<div id="view_header">
		<span id="project_title"><?php echo $info['seriesTitle']; ?></span><br />
		<img id="project_img" src="<?php echo $info['thumbnailURL']; ?>" alt="<?php echo $projectTitle; ?>" />
		<div id="project_info">
			<div class="project_info_table"><span class="subTitle">Author</span><br />
			<span id="project_author"> <?php echo $projectAuthor; ?> </span></div>
			<div class="project_info_table"><span class="subTitle">Artist</span><br />
			<span id="project_artist"> <?php echo $projectArtist; ?> </span></div>
			<div class="project_info_table"><span class="subTitle">Status</span><br />
			<span id="project_status"> <?php echo getStatus($info['status']); ?> </span></div>
			<div><span class="subTitle">Type</span><br />
			<span id="project_type"> <?php echo $projectType; ?> </span></div>
			<br />
			<span class="subTitle">Genres</span><br />
			<ul id="project_genres">
				<?php 
					foreach($projectGenres as $projectGenre) {
						echo('<li class="project_genre">'.$projectGenre.'</li>, ');
					}
				?>
			</ul>
			<br />
			<span class="subTitle">Description</span><br />
			<p id="project_description"> <?php echo $info['description']; ?> </p>
			<?php $project = mysqli_fetch_array(mysqli_query('SELECT * FROM Series WHERE seriesID='.$_GET['project'])); 
				foreach($project as $p) {
					echo $p.', ';
				}
			?>
		</div>
	</div>
	<br />
	<div>
		<table class="list">
		<tr>
			<th class="chapter_number">Ch. #</th>
			<th class="chapter_progress">Progress</th>
			<th class="chapter_downloads">DL Links</th>
		</tr>
		<?php
			foreach($projectChapters as $projectChapter) {
				echo '<tr><td class="chapter_number">'.$projectChapter[0].'</td><td class="chapter_progress">'.$projectChapter[1].'</td><td class="chapter_downloads"><a href="'.$projectChapter[2].'">[link]</a></td></tr>';
			}
		?>
		</table>
	</div>
</div>