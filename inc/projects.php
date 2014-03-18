<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You are not authorized to access this page.');}

/*
TODO:
- Make the genres display as a proper table instead of a list
- Make the genres editable inside their table cells... (this comes after the item before it)
- Get "textarea" to accept a default value...
*/

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

?>
<section>
	<div id="dhtmltooltip"></div>
	
		<div id="projectList" onmouseout="hideddrivetip()">
			
			<?php

				include_once(databaseDir . 'SeriesIO.php');

				if (isset($_GET['status']) && strlen($_GET['status']) == 1 && preg_match("/[a-z]/", $_GET['status'])){
					$arrayOfSeries = getSeriesByStatus($_GET['status']);
				}else{
					$arrayOfSeries = getSeriesAll();
				}

				if ($arrayOfSeries !== false && sizeof($arrayOfSeries) > 0){

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