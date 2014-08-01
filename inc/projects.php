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
					$totalSeries = getProjectCountPublic();
				}else{
					$arrayOfSeries = getSeriesAll();
					$totalSeries = getProjectCount();
				}

				echo '<script type="text/javascript">';
				if ($arrayOfSeries !== false && sizeof($arrayOfSeries) > 0){
					echo 'var arrayOfSeries = '.$arrayOfSeries.';';
					echo 'var sCount = '.$totalSeries.';';
					echo '</script>';
				}else{
					echo 'var arrayOfSeries = [];';
					$totalSeries = 0;
					echo '</script>';
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
	
	function FilterSeries(filter, title, count){

		var sArr = ['all', 'active', 'stalled', 'inactive', 'hiatus', 'dropped', 'complete'];
		$.each(sArr, function( index, value ) {
			if (value == filter || value[0] == filter.toLowerCase() && value != 'all'){
				$("#sidebar_"+value).addClass('sidebar_selected');
			}else{
				$("#sidebar_"+value).removeClass('sidebar_selected');
			}
		});

		$("#projectList").html("<h2>"+title+"</h2>");
		var sCount = <?php echo $totalSeries; ?>;
		if (typeof(count)!=='undefined'){
			sCount = count;
		}
		if (sCount > 10){
			for (var i = 0, sCurrent = 0; i < sCount; i+=10, sCurrent++){
				var curImage = $("<span><b id=\""+sCurrent+"\" class=\"pageNumber\">"+(sCurrent+1)+"</b>&emsp;</span>");
				curImage.click(function(event){
					$("#projectList").html("Loading...");
					$.ajax({
						type: "POST", url: "./ajax/projectList.php",
						data: {start: event.target.id * 10}, dataType: 'json'
					})
					.done(function(data) {
						sCount = data[0];
						arrayOfSeries = $.parseJSON(data[1]);
					})
					.fail(function() { console.log("Series listing failed"); })
					.always(function() { FilterSeries(filter, title); });
				});
				$("#projectList").append(curImage);
			}
		}
		$("#projectList").append("<br><br>");
		$.each(arrayOfSeries, function( index, value ) {
			var anch = $("<div class=\"imgDiv\"></div>");
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
						FilterSeries("all", "All Series");
					});
			});
			$("#projectList").append(anch);
		});
	}
	function resetFilter(code, title){
		$("#projectList").html("Loading...");
		$.ajax({
			type: "POST", url: "./ajax/projectList.php",
			data: {start: 0, status: code}, dataType: 'json'
		})
		.done(function(data) {
			arrayOfSeries = $.parseJSON(data[1]);
			FilterSeries(code, title, data[0]);
		})
		.fail(function() { console.log("Series listing failed"); });
	}
	$("#sidebar_all").click(function(){resetFilter("all", "All Series");});
	$("#sidebar_active").click(function(){resetFilter("A", "Active Series");});
	$("#sidebar_stalled").click(function(){resetFilter("S", "Stalled Series");});
	$("#sidebar_inactive").click(function(){resetFilter("I", "Inactive Series");});
	$("#sidebar_hiatus").click(function(){resetFilter("H", "Series on Hiatus");});
	$("#sidebar_dropped").click(function(){resetFilter("D", "Dropped Series");});
	$("#sidebar_complete").click(function(){resetFilter("C", "Complete Series");});
	$("#sidebar_add_series").click(function(){GoToPage("project_add");});
	FilterSeries("all", "All Series");
</script>
</div>