$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});

function GoToPage(page){
	$("#pageContent").html("Loading...");
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
$("#nav_user").click(function(){
	GoToPage("home");
});

$(document).ready(function(){
	GoToPage("projects");
});