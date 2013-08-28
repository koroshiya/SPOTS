var userMenu = document.getElementById("userMenu");

//Fix an error where on the first check, userMenu.style.visibility is defined as "" despite being defined as "hidden" in the css file
userMenu.style.visibility = "hidden";

document.getElementById("header_user").onclick = function() {
	if (userMenu.style.visibility == "hidden") {
		userMenu.style.visibility = "visible";
	} else {
		userMenu.style.visibility = "hidden";
	}
}