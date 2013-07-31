<?php
/*
Title: SPOTS Admin Control Panel
Version: 0.02
*/

if (!$fromIndex)
	die('You must access this through the root index!');

?>

<nav id="sidebar">
	<a class="sidebar_item" href="?action=AdminCP">Dashbaord</a><br>
	<a class="sidebar_item" href="?action=AdminCP&amp;sub=Manage_Projects">Projects</a><br>
	<a class="sidebar_item" href="?action=AdminCP&amp;sub=Manage_Members">Members</a><br>
	<a class="sidebar_item" href="?action=AdminCP&amp;sub=Manage_Groups">Joint Groups</a><br>
	<a class="sidebar_item" href="?action=AdminCP&amp;sub=SPOTSSettings">SPOTS Settings</a><br>
</nav>
<div id="module">

<?php

if (!include($moduleDir.'/sindex.php'))
	echo '<div style="margin-top:50px; margin-left:230px; color:black;">This is not a valid submodule!</div>';

?>
</div>