<section>
	<div id="dhtmltooltip"></div>
	<script type="text/javascript" defer="defer" src="ToolTip.js"></script>
	
		<div id="projectList" onmouseout="hideddrivetip()">
			
			<?php

				$parent = dirname(dirname(dirname(dirname(__FILE__)))) . '/Database/';
				include_once($parent . 'SeriesIO.php');

				if (isset($_GET['status']) && strlen($_GET['status']) == 1 && preg_match("/[a-z]/", $_GET['status'])){
					$arrayOfSeries = getSeriesByStatus($_GET['status']);
				}else{
					$arrayOfSeries = getSeriesAll();
				}

				if (sizeof($arrayOfSeries) > 0){

					foreach ($arrayOfSeries as $series) {
						$title = $series[1];
						$status = getSeriesStatusFromChar($series[2]);
						$desc = $series[3];
						$thumb  = $series[4];
						$adult  = $series[7];

						//echo "Title: $title<br />";

								/*HTML5 tooltip
								data-tip=\"$mouseText\"
								class=\"tooltip\"
								*/

						$mouseText = mouseover($title, $status, $desc);
						echo '<a id="imgDiv" 
								href="\"
								onmouseover="' . $mouseText . '">
								<img src="thumbs/' . $thumb . '" />
							
							</a>';
					}

				}else{
					echo 'No series found';
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