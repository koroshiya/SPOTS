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
	function singleMemberSidebar(){
		var sidebar = $("#sidebar");
		var back_anch = $('<a id="sidebar_back_to_members">Back To All Members</a>');
		sidebar.html(back_anch);
		back_anch.click(function(){
			showMembers();
			resetSidebar();
		});
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
		singleMemberSidebar();
		$.post("./ajax/memberInfo.php", {userID: member.userID})
			.done(function(data) {
				var params = $.parseJSON(data);
				
				var memberDiv = $("<div></div>");
				memberDiv.append("<h2>"+member.userName+"</h2>");
				memberDiv.append("<br>");
				memberDiv.append("<b>User ID: #"+member.userID+"</b>");
				memberDiv.append("<br>");
				if (params[0] == "1"){
					memberDiv.append("<b>User is a project manager</b>"); //TODO: list of series being managed?
					memberDiv.append("<br>");
				}
				memberDiv.append("<b>User has "+params[1]+" active tasks");

				$("#projectList").html(memberDiv);

			})
			.fail(function(msg) {
				console.log(msg);
				$("#projectList").html("Query failed");
			});
	}
	function showMemberById(id){
		$.each(memberList, function( index, value ) {
			console.log(index+": "+value+" versus "+value.userID);
			if (value.userID == id){
				showMember(value);
				return;
			}
		});
		console.log("Empty list");
	}
	resetSidebar();
	queryMembers(0);

	$(document).ready(function(){
	<?php if (isset($_POST['args'])){ ?>
		if (typeof start == 'undefined' || start < 0){
			start = 0;
		}
		$.post("./ajax/memberList.php", {userID: <?php echo $_POST['args']; ?>})
			.done(function(data) {
				member = $.parseJSON(data);
				showMember(member);
			})
			.fail(function(msg) {
				console.log(msg);
				$("#projectList").html("Query failed");
			});
	<?php } ?>
	});

</script>
</div>