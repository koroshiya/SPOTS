<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You are not authorized to access this page.');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

?>

<section>
	
	<center>
		<div id="projectList">
			
			<?php

				require_once(databaseDir . 'SeriesIO.php');

				$arrayOfSeries = getSeriesAll();

				if ($arrayOfSeries !== false && sizeof($arrayOfSeries) > 0){
					echo '<script type="text/javascript">';
					echo 'var arrayOfSeries = [];';
					foreach ($arrayOfSeries as $series) {
						$title = $series[1];
						$status = $series[2];
						$desc = $series[3];
						$thumb  = $series[4];
						$adult  = $series[7];

						echo 'arrayOfSeries.push({
							title: "'.$title.'",
							status: "'.$status.'",
							desc: "'.$desc.'",
							thumb: "'.$thumb.'",
							adult: '.$adult.',
						});';
					}
					//anch_img.attr("src", value.thumb);
					echo '$.each(arrayOfSeries, function( index, value ) {
							var anch_img = $("<img id=\"imgDiv\" />");
							anch_img.attr("src", "thumbs/Aiki.jpg");
							$("#projectList").append(anch_img);
						});';
					echo '</script>';

				}else{
					echo 'No series found';
				}

			?>
	
		</div>
	</center>
</section>
<script type="text/javascript">
	$("#sidebar").html('<a class="sidebar_item" id="sidebar_all">All Series</a><br />'+
						'<a class="sidebar_item" id="sidebar_active">Active Series</a><br />'+
						'<a class="sidebar_item" id="sidebar_stalled">Stalled Series</a><br />'+
						'<a class="sidebar_item" id="sidebar_inactive">Inactive Series</a><br />'+
						'<a class="sidebar_item" id="sidebar_hiatus">Series on Hiatus</a><br />'+
						'<a class="sidebar_item" id="sidebar_complete">Completed Series</a><br />'+
						'<a class="sidebar_item" id="sidebar_dropped">Dropped Series</a><br />');
	
	function FilterSeries(filter, title){
		$("#projectList").html("<h2>"+title+"</h2><br><br>");
		$.each(arrayOfSeries, function( index, value ) {
			if (filter === "all" || filter === value.status){
				var anch_img = $("<img />");
				anch_img.attr("src", "thumbs/Aiki.jpg"); //anch_img.attr("src", value.thumb);
				$("#projectList").append(anch_img);
			}
		});
	}
	$("#sidebar_all").click(function(){FilterSeries("all", "All Series");});
	$("#sidebar_active").click(function(){FilterSeries("A", "Active Series");});
	$("#sidebar_stalled").click(function(){FilterSeries("S", "Stalled Series");});
	$("#sidebar_inactive").click(function(){FilterSeries("I", "Inactive Series");});
	$("#sidebar_hiatus").click(function(){FilterSeries("H", "Series on Hiatus");});
	$("#sidebar_complete").click(function(){FilterSeries("C", "Complete Series");});
	$("#sidebar_dropped").click(function(){FilterSeries("D", "Dropped Series");});
</script>
</div>