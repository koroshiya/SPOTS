<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You must be logged in to access this page.');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

?>

<section>
	<center><div id="projectList"></div></center>
</section>

<script type="text/javascript">
	var arrayOfTasks = [];
	function resetSidebar(){
		var sidebar = $("#sidebar");
		sidebar.html('<a id="sidebar_my_tasks">My Tasks</a><br />');

		var sidespan = $('<span id="sidebar_my_task_list" class="hidden"></span>');
		sidespan.append('<a id="sidebar_tasks_all">All Tasks</a><br />');
		sidespan.append('<a id="sidebar_tasks_active">Active</a><br />');
		sidespan.append('<a id="sidebar_tasks_inactive">Inactive</a><br />');
		sidespan.append('<a id="sidebar_tasks_stalled">Stalled</a><br />');
		sidespan.append('<a id="sidebar_tasks_complete">Complete</a><br />');
		sidebar.append(sidespan);

		sidebar.append('<a id="sidebar_my_profile">Profile</a><br />');
		sidebar.append('<a id="sidebar_my_pm">Project Management</a><br />');
	}
	function translateStatusChar(schar){
		switch(schar){
			case 'A':
				return "Active";
			case 'I':
				return "Inactive";
			case 'S':
				return "Stalled";
			case 'C':
				return "Complete";
			default:
				return "All";
		}
	}
	function FilterTasks(status){
		$("#projectList").html("Loading...");

		var postdata = $.post("./ajax/retrievePersonalTasks.php",{status: status});
	    postdata.done(function(sArray){
	    	arrayOfTasks.length = 0;
	    	arrayOfTasks = $.parseJSON(sArray);
	    	if (arrayOfTasks.length === 0){
	    		$("#projectList").html("<h3>No tasks found matching the following criteria</h3>");
	    		$("#projectList").append("<h4>Status: "+translateStatusChar(status)+"</h4>");
	    	}else{
	    		myTasks();
	    	}
	    });
	    postdata.fail(function(e){
	    	console.log("Retrieve failed");
	    	console.log(e);
	    });
	}
	function getSeriesName(id){
		for (var i = arrayOfSeries.length - 1; i >= 0; i--) {
			if (arrayOfSeries[i].seriesID == id){
				return arrayOfSeries[i].seriesTitle;
			}
		};
		return "N/A";
	}
	function myTasks(){
	    $("#projectList").html("");
	    var ntable = $('<table class="equitable"></table>');
	    var htable = $("<thead></thead>");
	    var hrow = $("<tr></tr>");
	    hrow.append("<th>Series</th>");
	    hrow.append("<th>Chapter #</th>");
	    hrow.append("<th>Role</th>");
	    hrow.append("<th>Status</th>");
	    htable.append(hrow);
	    ntable.append(htable);
	    var btable = $("<tbody></tbody>");
	    
		$.each(arrayOfTasks, function( index, value ) {
			var tr = $('<tr class="clickable"></tr>');
			tr.append("<td>"+getSeriesName(value.seriesID)+"</td>");
			tr.append("<td>"+value.chapterNumber+"."+value.chapterSubNumber+"</td>");
			tr.append("<td>"+value.userRole+"</td>");
			tr.append("<td>"+translateStatusChar(value.status)+"</td>");
			tr.click(function(){showTask(value);});
		    btable.append(tr);
		});
	    ntable.append(btable);
		$("#projectList").html(ntable);
	}
	resetSidebar();
	$("#sidebar_my_tasks").click(function(){
		$("#sidebar_my_task_list").toggle();
	});
	$("#sidebar_my_profile").click(function(){});
	$("#sidebar_my_pm").click(function(){});
	$("#sidebar_tasks_all").click(function(){FilterTasks("-1");});
	$("#sidebar_tasks_active").click(function(){FilterTasks("A");});
	$("#sidebar_tasks_inactive").click(function(){FilterTasks("I");});
	$("#sidebar_tasks_stalled").click(function(){FilterTasks("S");});
	$("#sidebar_tasks_complete").click(function(){FilterTasks("C");});
</script>