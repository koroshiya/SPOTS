<?php

$projectImage = 'http://orinjido.info/myimages/project_images/shurabara!.jpg';
$projectTitle = 'Shurabara!';
$projectAuthor = 'Author';
$projectArtist = 'Artist';
$projectStatus = 'Active';
$projectType = 'Manga';
$projectGenres = array(
	'Comedy', 'Harem', 'Romance', 'School Life', 'Shounen'
);
$projectDescription = 'Blah blah blah blah blah description blah';
$projectChapters = array(
	array(1, 'Complete', 'index.php')
);

?>

<div id="content">
	<div id="view_header">
		<span id="project_title"><?php echo $projectTitle; ?></span><br />
		<img id="project_img" src="<?php echo $projectImage; ?>" alt="<?php echo $projectTitle; ?>" />
		<div id="project_info">
			<table id="project_info_table">
				<tr>
				<td><span class="subTitle">Author</span><br />
				<span id="project_author"> <?php echo $projectAuthor; ?> </span></td>
				<td><span class="subTitle">Artist</span><br />
				<span id="project_artist"> <?php echo $projectArtist; ?> </span></td>
				<td><span class="subTitle">Status</span><br />
				<span id="project_status"> <?php echo $projectStatus; ?> </span></td>
				<td><span class="subTitle">Type</span><br />
				<span id="project_type"> <?php echo $projectType; ?> </span></td>
				</tr>
			</table><br />
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
			<p id="project_description"> <?php echo $projectDescription; ?> </p>
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