document.getElementById("header_user").onclick = function() {
	var userMenuStyle = document.getElementById("userMenu").style;
	userMenuStyle.display = (userMenuStyle.display == 'block') ? 'none' : 'block';
}