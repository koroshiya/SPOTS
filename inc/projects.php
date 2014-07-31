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
					echo '<script type="text/javascript">var arrayOfSeries = '.$arrayOfSeries.';</script>';

				}else{
					echo 'No series found';
				}

			?>
	
		</div>
	</center>
</section>
<script type="text/javascript">
	$("#sidebar").html('<a id="sidebar_all">All Series</a><br />'+
						'<a id="sidebar_active">Active Series</a><br />'+
						'<a id="sidebar_stalled">Stalled Series</a><br />'+
						'<a id="sidebar_inactive">Inactive Series</a><br />'+
						'<a id="sidebar_hiatus">Series on Hiatus</a><br />'+
						'<a id="sidebar_complete">Completed Series</a><br />'+
						'<a id="sidebar_dropped">Dropped Series</a>'+
						<?php if (isset($_SESSION['SPOTS_authorized'])){
							echo "'<p>------------------------------------</p>'+";
							echo "'<a id=\"sidebar_add_series\">Add Series</a>'+";
						}
						?>
						'<br />'
					);
	
	function FilterSeries(filter, title){
		$("#projectList").html("<h2>"+title+"</h2><br><br>");
		$.each(arrayOfSeries, function( index, value ) {
			if (filter === "all" || filter === value.status){
				var anch = $("<div id=\"imgDiv\" style=\"height: 340px; width: 300px;\"></div>");
				var anch_img = $("<img style=\"max-width:300px; max-height:300px;\" />");

				value.thumbnailURL = value.thumbnailURL == null ? 'missing.png' : value.thumbnailURL;

				anch_img.attr("src", "thumbs/"+value.thumbnailURL);
				anch.append(anch_img);
				anch.append("<br />");
				var btitle = $("<b></b>");
				btitle.append(value.seriesTitle);
				anch.append(btitle);
				anch.click(function(){
					$("#projectList").html("Loading...");
					$.post("./inc/project.php", {id: value.seriesID})
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
	FilterSeries("all", "All Series");
</script>
</div>