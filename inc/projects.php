<?php

if (!fromIndex){die('You must access this through the root index!');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

?>

<section>
	
	<center>
		<div id="projectList">
			
			<?php

				require_once(databaseDir . 'SeriesIO.php');

				session_start();
				if (!isset($_SESSION['SPOTS_authorized'])){
					$arrayOfSeries = getSeriesAllPublic();
				}else{
					$arrayOfSeries = getSeriesAll();
				}

				if ($arrayOfSeries !== false && sizeof($arrayOfSeries) > 0){
					echo '<script type="text/javascript">';
					echo 'var arrayOfSeries = [];';
					foreach ($arrayOfSeries as $series) {
						echo 'arrayOfSeries.push({
							id: "'.$series[0].'",
							title: "'.$series[1].'",
							status: "'.$series[2].'",
							desc: "'.$series[3].'",
							thumb: "'.$series[4].'",
							adult: '.$series[7].'
						});';
					}
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
						'<a class="sidebar_item" id="sidebar_dropped">Dropped Series</a>'+
						'<p>------------------------------------</p>'+
						'<a class="sidebar_item" id="sidebar_add_series">Add Series</a><br />'
					);
	
	function FilterSeries(filter, title){
		$("#projectList").html("<h2>"+title+"</h2><br><br>");
		$.each(arrayOfSeries, function( index, value ) {
			if (filter === "all" || filter === value.status){
				var anch = $("<div id=\"imgDiv\"></div>");
				var anch_img = $("<img />");
				anch_img.attr("src", "thumbs/Aiki.jpg"); //anch_img.attr("src", value.thumb);
				anch.append(anch_img);
				anch.append("<br />");
				var btitle = $("<b></b>");
				btitle.append(value.title);
				anch.append(btitle);
				anch.click(function(){
					$("#projectList").html("Loading...");
					$.post("./inc/project.php", {id: value.id})
						.done(function(data) {
							$("#pageContent").html(data);
						})
						.fail(function() {
							console.log("Series does not exist or could not be loaded");
							FilterSeries("A", "Active Series");
						});
				});
				$("#projectList").append(anch);
			}
		});
	}
	$("#sidebar_all").click(function(){FilterSeries("all", "All Series");});
	$("#sidebar_active").click(function(){FilterSeries("A", "Active Series");});
	$("#sidebar_stalled").click(function(){FilterSeries("S", "Stalled Series");});
	$("#sidebar_inactive").click(function(){FilterSeries("I", "Inactive Series");});
	$("#sidebar_hiatus").click(function(){FilterSeries("H", "Series on Hiatus");});
	$("#sidebar_dropped").click(function(){FilterSeries("D", "Dropped Series");});
	$("#sidebar_complete").click(function(){FilterSeries("C", "Complete Series");});
	$("#sidebar_add_series").click(function(){GoToPage("project_add");});
	FilterSeries("A", "Active Series");
</script>
</div>