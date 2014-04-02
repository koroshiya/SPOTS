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
	var memberList = [];
	function resetSidebar(){
		var sidebar = $("#sidebar");
		sidebar.html("");
		//sidebar.html("<h3>Search by Role</h3>");
		//sidebar.append('<a id="sidebar_submit">Search All Tasks</a><br />');
		//sidebar.append('<a id="sidebar_personal">Search Personal Tasks</a><br />');
	}
	function decodeUserStatus(status){
		if (status == 'A'){
			return "Active";
		}else if (status == "S"){
			return "Semi-active";
		}else if (status == "B"){
			return "On Break";
		}else if (status == "I"){
			return "Inactive";
		}else if (status == 'R'){
			return "Retired";
		}else{
			return "N/A";
		}
	}
	function decodeUserTitle(title){
		if (title == 'a'){
			return "Admin";
		}else if (title == 'm'){
			return "Mod";
		}else if (title == 's'){
			return "Staff";
		}else{
			return "N/A";
		}
	}
	function singleMemberSidebar(){
		var sidebar = $("#sidebar");
		sidebar.html('<a id="sidebar_back_to_members"></a><br />');
	}
	function queryMembers(start){
		if (typeof start == 'undefined' || start < 0){
			start = 0;
		}
		$.post("./ajax/memberList.php", {start: start})
			.done(function(data) {
				memberList = $.parseJSON(data);
				showMembers();
			})
			.fail(function(msg) {
				console.log(msg);
				$("#projectList").html("Query failed");
			});
	}
	function showMembers(){
	    $("#projectList").html("");
	    var ntable = $('<table class="equitable"></table>');
	    var htable = $("<thead></thead>");
	    var hrow = $("<tr></tr>");
	    hrow.append("<th>ID #</th>");
	    hrow.append("<th>Username</th>");
	    hrow.append("<th>Title</th>");
	    hrow.append("<th>Status</th>");
	    htable.append(hrow);
	    ntable.append(htable);
	    var btable = $("<tbody></tbody>");
	    
		$.each(memberList, function( index, value ) {
				var tr = $('<tr class="clickable"></tr>');
				tr.append("<td>"+value.userID+"</td>");
				tr.append("<td>"+value.userName+"</td>");
				tr.append("<td>"+decodeUserTitle(value.title)+"</td>");
				tr.append("<td>"+decodeUserStatus(value.status)+"</td>");
				tr.click(function(){showMember(value);});
		    	btable.append(tr);
		});
	    ntable.append(btable);
		$("#projectList").html(ntable);
	}
	function showMember(member){
		$("#projectList").html("Loading...");
	}
	resetSidebar();
	queryMembers(0);
	$("#sidebar_back_to_members").click(function(){showMembers();});
</script>
</div>