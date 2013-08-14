<?php
if (!$fromIndex)
	die('You must access this through the root index!');
?>

<a href="?action=Projects">
<div class="section">
	<div class="title">Projects</div>
	<p class="info">Add, delete, and edit your group's projects.</p>
</div></a>

<a href="?action=Members">
<div class="section">
	<div class="title">Members</div>
	<p class="info">Manage the members of the group and their various permissions</p>
</div></a>

<a href="?action=AdminCP&amp;sub=Groups">
<div class="section">
	<div class="title">Joint Groups</div>
	<p class="info">Add, remove, and edit the info for groups you joint with</p>
</div></a>

<a href="?action=AdminCP&amp;sub=Settings">
<div class="section">
	<div class="title">SPOTS Settings</div>
	<p class="info">Edit the settings of SPOTS</p>
</div></a>
