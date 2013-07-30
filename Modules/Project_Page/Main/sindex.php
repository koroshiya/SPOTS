<section>
	<div id="dhtmltooltip"></div>
	<script type="text/javascript" defer="defer" src="ToolTip.js"></script>
	
		<div id="projectList" onmouseout="hideddrivetip()">
			
			<?php

				include 'Database/SeriesIO.php';
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