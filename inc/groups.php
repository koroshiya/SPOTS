<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You must be logged in to access this page.');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

?>

<section>
	<center>
		<div id="projectList">
		</div>
	</center>
</section>

<script type="text/javascript">
	var groupList = [];
	function resetSidebar(){
		var sidebar = $("#sidebar");
		sidebar.html("");
		//sidebar.append('<a id="sidebar_personal">Search Personal Tasks</a><br />');
	}
	function singleGroupSidebar(){
		var sidebar = $("#sidebar");
		var back_anch = $('<a>Back To All Groups</a>');
		sidebar.html(back_anch);
		back_anch.click(function(){
			showGroups();
			resetSidebar();
		});
	}
	function queryGroups(start){
		if (typeof start == 'undefined' || start < 0){
			start = 0;
		}
		$.post("./ajax/groupList.php", {start: start})
			.done(function(data) {
				groupList = $.parseJSON(data);
				console.log(groupList);
				showGroups();
			})
			.fail(function(msg) {
				console.log(msg);
				$("#projectList").html("Query failed");
			});
	}
	function showGroups(){
	    $("#projectList").html("");
	    var ntable = $('<table class="equitable"></table>');
	    var htable = $("<thead></thead>");
	    var hrow = $("<tr></tr>");
	    hrow.append("<th>Group ID #</th>");
	    hrow.append("<th>Group Name</th>");
	    hrow.append("<th>Website</th>");
	    htable.append(hrow);
	    ntable.append(htable);
	    var btable = $("<tbody></tbody>");
	    
		$.each(groupList, function( index, value ) {
				var tr = $('<tr class="clickable"></tr>');
				tr.append("<td>"+value.groupID+"</td>");
				tr.append("<td>"+value.groupName+"</td>");
				tr.append("<td>"+value.URL+"</td>");
				tr.click(function(){showGroup(value);});
		    	btable.append(tr);
		});
	    ntable.append(btable);
		$("#projectList").html(ntable);
	}
	function showGroup(group){
		$("#projectList").html("Loading...");
		singleGroupSidebar();
		$.post("./ajax/groupInfo.php", {groupID: group.groupID})
			.done(function(data) {
				var arr = $.parseJSON(data);
				var count = arr[0][0].count;
				var chapters = arr[1];
				
				var memberDiv = $("<div></div>");
				memberDiv.append("<h2>"+group.groupName+"</h2>");
				memberDiv.append("<br>");
				memberDiv.append("<b>Website: <a href=\"http://"+group.URL+"\">"+group.URL+"</a></b>");
				memberDiv.append("<br>");
				memberDiv.append("<b>Group ID: #"+group.groupID+"</b>");
				memberDiv.append("<br>");
				memberDiv.append("<b>Group has worked on "+count+" chapter(s)");
				memberDiv.append("<br>");
	    
				$.each(chapters, function( index, value ) {
						var tr = $('<a></a>');
						tr.append("<b>Series #"+value.seriesID+
									", Chapter #"+value.chapterNumber+
									"."+value.chapterSubNumber+
									", Rev. #"+value.chapterRevisionNumber+"</b>"
						); //chapterName
						//tr.click(function(){showMember(value);});
				    	memberDiv.append(tr);
				});

				$("#projectList").html(memberDiv);

			})
			.fail(function(msg) {
				console.log(msg);
				$("#projectList").html("Query failed");
			});
	}
	resetSidebar();
	queryGroups(0);
</script>
</div>