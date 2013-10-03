<?php

$projectImage = 'http://orinjido.info/myimages/project_images/shurabara!.jpg';
$projectTitle = 'Shurabara!';
$projectAuthor = 'Author';
$projectArtist = 'Artist';
$projectGenres = [
	'Comedy', 'Harem', 'Romance', 'School Life', 'Shounen'
];

?>

<div id="content">
	<div id="view_header">
		<?php 

		echo '
			<span id="project_title">'.$projectTitle.'</span> <br />
			<img id="project_img" src="'.$projectImage.'" alt="'.$projectTitle.'" />
			<div id="project_info">
				<span id="project_author">'.$projectAuthor.'</span>
				<span id="project_artist">'.$projectArtist.'</span> <br />

				<ul id="project_genres">'
					foreach($projectGenres as $projectGenre) {
						echo('<li>'.$projectGenre.'</li>');
					}
				'</ul>
			</div>
		';

		?>
	</div>
</div>