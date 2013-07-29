<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Series</title>
		<link rel="stylesheet" href="project.css" />
	</head>
	<body>
	<center><div id="content_wrapper">
		<a href="">
			<header>
				<img src="images/logox200.png">
			</header>
		</a>
		<nav id="nav">
			<ul id="tabs">
				<li><a href="http://japanzai.com">Home</a></li>
				<li>
					<p class="home">
						Read online
						<span><a href="http://reader.japanzai.com">Online reader</a></span>
						<span class="span_level_two"><a href="http://ecchi.japanzai.com">Ecchi reader</a></span>
						<span class="span_level_three"><a href="http://h.japanzai.com">18+ reader</a></span>
					</p>
				</li>
				<li><a href="http://download.japanzai.com">Download</a></li>
				<li>
					<p class="home">
						Filter series
						<span><a href="projects.php?filter=All">All</a></span>
						<span class="span_level_two"><a href="projects.php?filter=Active">Active</a></span>
						<span class="span_level_three"><a href="projects.php?filter=Inactive">Inactive</a></span>
						<span class="span_level_four"><a href="projects.php?filter=Dropped">Dropped</a></span>
						<span class="span_level_five"><a href="projects.php?filter=Complete">Complete</a></span>
					</p>
				</li>
			</ul>
		</nav>
		<!--<aside>
			<ul>
				<li>All series</li>
				<li>Active series</li>
				<li>Complete series</li>
				<li>Stalled series</li>
				<li>Dropped series</li>
			</ul>
		</aside>-->
		<section>
			<div id="dhtmltooltip"></div>
			<script type="text/javascript" defer="defer" src="ToolTip.js"></script>
			
				<div id="projectList" onmouseout="hideddrivetip()">
				
<?php

	include 'Database/SeriesIO.php';
	$connection = connect('localhost', '', '', 'SPMS');
	$arrayOfSeries = getSeriesAll();

	for($i = 0; $i < count($arrayOfSeries); $i++) {
		$project = $arrayOfSeries[$i];
		$title = $project[1];
		$status = getSeriesStatusFromChar($project[2]);
		$desc  = $project[3]; //Scrollover?
		$thumb  = $project[4];
		$adult  = $project[7]; //adult warning underneath
		//echo "Title: $title<br />";

				/*HTML5 tooltip
				data-tip=\"$mouseText\"
				class=\"tooltip\"
				*/

		$mouseText = mouseover($title, $status, $desc);
		echo "<a id=\"imgDiv\" 
				href=\"\" 
				onmouseover=\"$mouseText\">
			
				<img src=\"thumbs/$thumb\" />
			
			</a>";
	}

	function mouseover($title, $status, $desc){
		return "ddrivetip('<b id=toolTitle>$title</b><br /><br /><b id=ecchiTag>Mature</b> - Action - Martial Arts<br />Status: $status<br /><br />$desc')";
	}

?>
				
				</div></center>
		</section>
		<!--<footer>
			Copyright
		</footer>-->
		</div>
	</body>
</html>