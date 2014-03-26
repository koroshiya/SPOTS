<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You must be logged in to access this page.');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

?>

<section>
	
	<center>
		<div id="projectList">
			
			<?php
				require_once(databaseDir . 'TaskIO.php');
				require_once(databaseDir . 'RoleIO.php');
				require_once(databaseDir . 'SeriesIO.php');
				$arrayOfTasks = getUserTasks($_SESSION['SPOTS_ID']);
				$arrayOfSeries = getSeriesAll();
				$arrayOfRoles = getRolesAll();

				echo '<script type="text/javascript">';
				echo 'var arrayOfTasks = [];';
				echo 'var arrayOfSeries = [];';
				echo 'var arrayOfRoles = [];';
				foreach ($arrayOfTasks as $task) {
					echo 'arrayOfTasks.push({
						seriesID: '.$task[0].',
						chapterNumber: '.$task[1].',
						chapterSubNumber: '.$task[2].',
						userID: '.$task[3].',
						desc: "'.$task[4].'",
						cstatus: "'.$task[5].'",
						userRole: "'.$task[6].'"
					});';
				}
				foreach ($arrayOfSeries as $series) {
					echo 'arrayOfSeries.push({
						seriesID: "'.$series[0].'",
						seriesTitle: "'.$series[1].'"
					});';
				}
				foreach ($arrayOfRoles as $role) {
					echo 'arrayOfRoles.push({role: "'.$role[0].'"});';
				}
				echo '</script>';

			?>
	
		</div>
	</center>
</section>
<script type="text/javascript">
	function resetSidebar(){
		var sidebar = $("#sidebar");
		var sidespan = $('<span style="padding-left:20px;display:block;"></span>');
		sidespan.append("<h3>Task Series</h3>");
		var sel1 = $('<select name="sidebar_series" id="sidebar_series"></select>');
		sel1.append('<option value="-1">All</option>');
		for (var i = arrayOfSeries.length - 1; i >= 0; i--) {
			var series = arrayOfSeries[i];
			sel1.append('<option value="'+series.seriesID+'">'+series.seriesTitle+'</option>');
		};
		sidespan.append(sel1);
		sidespan.append('<h3>Task Role</h3>');
		var sel2 = $('<select name="sidebar_role" id="sidebar_role"></select>');
		sel2.append('<option value="-1">All</option>');
		for (var i = arrayOfRoles.length - 1; i >= 0; i--) {
			var role = arrayOfRoles[i];
			sel2.append('<option value="'+role.role+'">'+role.role+'</option>');
		};
		sidespan.append(sel2);
		sidespan.append('<h3>Task Status</h3>');
		var sel3 = $('<select name="sidebar_status" id="sidebar_status"></select>');
		sel3.append('<option value="-1">All</option>');
		sel3.append('<option value="A">Active</option>');
		sel3.append('<option value="I">Inactive</option>');
		sel3.append('<option value="S">Stalled</option>');
		sel3.append('<option value="C">Complete</option>');
		sidespan.append(sel3);
		sidespan.append('<a class="sidebar_item" id="sidebar_submit">Search</a><br />');
		sidebar.html(sidespan);
	}
	function getSeriesName(id){
		for (var i = arrayOfSeries.length - 1; i >= 0; i--) {
			if (arrayOfSeries[i].seriesID == id){
				return arrayOfSeries[i].seriesTitle;
			}
		};
		return "N/A";
	}
	function showTasks(){
	    $("#projectList").html("");
		$.each(arrayOfTasks, function( index, value ) {
			var listing = $("<div></div>");
			listing.text(getSeriesName(value.seriesID)+
				", Chapter #"+value.chapterNumber+"."+value.chapterSubNumber+
				" - "+value.userRole+
				" - "+value.cstatus+
				" - Assigned to #"+value.userID);
			$("#projectList").append(listing);
		});
	}
	function FilterTasks(){
		$("#projectList").html("Loading...");
		var series = $('#sidebar_series').val();
		var role = $('#sidebar_role').val();
		var status = $('#sidebar_status').val();

		var postdata = $.post("./ajax/retrieveTasks.php", {series: series, role: role, status: status});
	    postdata.done(function(sArray){
	    	arrayOfTasks.length = 0;
	    	arrayOfTasks = $.parseJSON(sArray);
	    	showTasks();
	    });
	    postdata.fail(function(e){
	    	console.log("Retrieve failed");
	    	console.log(e);
	    });
	}
	resetSidebar();
	showTasks();
	$("#sidebar_submit").click(function(){FilterTasks();});
</script>
</div>