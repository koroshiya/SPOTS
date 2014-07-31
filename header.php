<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>SPOTS</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin:0px; margin-left:10px;" role="navigation">
		<a id="header_title">SPOTS</a>
		<a class="header_nav" id="nav_tasks">Tasks</a>
		<a class="header_nav" id="nav_projects">Projects</a>
		<a class="header_nav" id="nav_members">Members</a>
		<a class="header_nav" id="nav_groups">Groups</a>
		<a class="header_nav" id="nav_user">My Page</a>
		<a class="header_nav" id="nav_homeurl" href=<?php echo homeURL; ?>><?php echo homeMessage; ?></a>
	</nav>
    <span id="header_user"></span>
</header>
<div id="userMenu">
	<br />
	<form action="./ajax/login.php" id="loginForm" name="loginForm" method="post">
		Username:<br /><input type="text" id="loginUser" name="loginUser" /><br />
		Password:<br /><input type="password" id="loginPass" name="loginPass" /><br />
		<input action="index.php" type="submit" value="login" style="margin-top:12px;" />
	</form>
	<br />
	<script type="text/javascript">
		$("#header_user").click(function(){
			if (!loggedIn){
				$("#userMenu").toggle();
			}else{
				$.post("./ajax/logout.php",{})
					.done(function(data) {
						isLoggedIn(false);
					})
					.fail(function(msg) {
						console.log(msg);
						console.log("Logout failed");
						$("#userMenu").hide();
					});
			}
		});
		$('#loginForm').submit(function(evt) {
			if (!loggedIn){
				evt.preventDefault();
			    $(this).ajaxSubmit({
				    success: loginSuccess,  // post-submit callback
				    resetForm: true        // reset the form after successful submit
				});
			}
		    return false;
		});
		function loginSuccess(output){
			$("#userMenu").hide();
			console.log(output);
			if (output !== "Success"){
				alert("Invalid username or password");
				return false; //login failed
			}
			isLoggedIn(true);
		}
		function isLoggedIn(login){
			$("#userMenu").hide();
			loggedIn = login;
			if (login){
				$("#header_user").text("Logout");
			}else{
				$("#header_user").text("Login");
			}
			showTabs(login);
			GoToPage("projects");
		}
		function showTabs(login){
			var menuItems = ["nav_tasks", "nav_projects", "nav_members", "nav_groups", "nav_user"];
			var i = menuItems.length - 1;
			if (login){
				for (; i >= 0; i--) {
					$("#"+menuItems[i]).show();
				};
				$("#nav_homeurl").hide();
			}else{
				for (; i >= 0; i--) {
					$("#"+menuItems[i]).hide();
				};
				$("#nav_homeurl").show();
			}
		}
		<?php echo 'var loggedIn = '.($loggedIntoSPOTS ? "true" : "false").';'; ?>
		$("#header_user").text(loggedIn ? "Logout" : "Login");
		showTabs(loggedIn);
	</script>

</div>

<nav id="sidebar"></nav>
<br /><br />
<div id="pageContent"></div>