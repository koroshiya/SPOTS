$("#header_user").click(function(){
	$("#userMenu").toggle();
});

function GoToPage(page){
	$("#pageContent").html("Loading...");
	/*$("#pageContent").load("./inc/"+page+".php", function(response, status, xhr) {
	  if (status == "error") {
	    var msg = "Sorry but there was an error: ";
	    $("#pageContent").html(msg + xhr.status + " " + xhr.statusText);
	  }
	});*/
	//$("#pageContent").load("./inc/"+page+".php");
	$.post("./inc/"+page+".php")
		.done(function(data) {
			$("#pageContent").html(data);
		})
		.fail(function() {
			$("#pageContent").html("Failed to load document");
		});
}

$("#header_title").click(function(){
	GoToPage("main");
});
$("#nav_tasks").click(function(){
	GoToPage("tasks");
});
$("#nav_projects").click(function(){
	GoToPage("projects");
});
$("#nav_members").click(function(){
	GoToPage("members");
});
$("#nav_groups").click(function(){
	GoToPage("groups");
});
$("#nav_settings").click(function(){
	GoToPage("settings");
});

$(document).ready(function(){
	GoToPage("projects");
});