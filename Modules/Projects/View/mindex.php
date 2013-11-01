<?php
if (!fromIndex){die('You must access this through the root index!');}

/*
TODO:
- Make the genres display as a proper table instead of a list
- Make the genres editable inside their table cells... (this comes after the item before it)
- Get "textarea" to accept a default value...
*/

require_once(databaseDir.'SeriesIO.php');
require_once(databaseDir.'SeriesGenreIO.php');
require_once(databaseDir.'ChapterIO.php');

$sID = $_GET['project'];
$info = getSeriesByID($sID);

$projectAuthor = $info[8] == null ? 'N/A' : $info[8];
$projectArtist = $info[9] == null ? 'N/A' : $info[9];
$projectType = $info[10] == null ? 'N/A' : $info[10];

$projectGenres = getSeriesGenres($sID);
$projectChapters = getChapterBySeriesId($sID);

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
			<span id="project_status"> <?php echo getSeriesStatusFromChar($info['status']); ?> </span></div>
			<div><span class="subTitle">Type</span><br />
			<span id="project_type"> <?php echo $projectType; ?> </span></div>
			<br />
			<span class="subTitle">Genres</span><br />
			<ul id="project_genres">
				<?php 
					foreach($projectGenres as $projectGenre) {
						echo('<li class="project_genre">'.$projectGenre.'</li>');
					}
				?>
			</ul>
			<br />
			<span class="subTitle">Description</span><br />
			<p id="project_description"> <?php echo $info['description']; ?> </p>
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
