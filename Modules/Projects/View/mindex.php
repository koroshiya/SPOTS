<?php

$projectImage = 'http://psylockescans.files.wordpress.com/2012/11/i155391.jpg?w=210&amp;h=300';
$projectTitle = 'Comic Studio';
$projectAuthor = 'Author';
$projectArtist = 'Artist';
$projectGenres = [
	'Comedy', 'Romance', 'Seinen'
];

?>

<div id="content">
	<div id="view_header">
		<?php 

		echo '
			<div id="project_title">'.$projectTitle.'</div> <br />
			<img id="project_img" src="'.$projectImage.'" alt="'.$projectTitle.'" />
			<div id="project_info">
				<span id="project_author">'.$projectAuthor.'</span>
				<span id="project_artist">'.$projectArtist.'</span> <br />

				<ul id="project_genres">
				</ul>
			</div>
		';

		?>
	</div>
</div>