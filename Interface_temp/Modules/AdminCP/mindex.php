<?php
/*
Title: SPOTS Admin Control Panel
Version: 0.02
*/
?>

<nav id="sidebar">
	<a class="sidebar_item" href="?action=AdminCP">Dashbaord</a><br>
	<a class="sidebar_item" href="?action=AdminCP&sub=Manage Projects">Projects</a><br>
	<a class="sidebar_item" href="?action=AdminCP&sub=Manage Members">Members</a><br>
	<a class="sidebar_item" href="?action=AdminCP&sub=Manage Groups">Joint Groups</a><br>
	<a class="sidebar_item" href="?action=AdminCP&sub=SPOTS Settings">SPOTS Settings</a><br>
</nav>
<div id="module">

<?php

if (!include('./Modules/'.$action.'/'.$sub.'/sindex.php'))
	echo '<div style="margin-top:50px; margin-left:230px; color:black;">This is not a valid submodule!</div>';

?>
</div>