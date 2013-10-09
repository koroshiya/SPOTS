$(document).ready(function(){

	//TODO: Get this hidden-div thing working. It was the best solution I found online for creating a "click-off" function to hide a div
	$("#userMenu").hide();

	$("#header_user").click(function() {
		$("#userMenu").toggle();
		var visible = $("#userMenu").css("visibility") == "visible" ? "hidden" : "visible";
		$("#userMenu").css("visibility", visible);
		/*if ($("#userMenu").css("visibility") == "visible") {
			$("#umClickOff").show();
		}else {
			$("#umClickOff").hide();
		}*/
	});

});