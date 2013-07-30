<?php
if (!$fromIndex)
	die('You must access this through the root index!');

?>

<nav id="sidebar">
	<a class="sidebar_item" href="?action=Project_Page">All Series</a><br>
	<a class="sidebar_item" href="?action=Project_Page&amp;filter=active">Active Series</a><br>
	<a class="sidebar_item" href="?action=Project_Page&amp;filter=stalled">Stalled Series</a><br>
	<a class="sidebar_item" href="?action=Project_Page&amp;filter=complete">Completed Series</a><br>
	<a class="sidebar_item" href="?action=Project_Page&amp;filter=dropped">Dropped Series</a><br>
</nav>
<div id="module">

<?php

if (!include('./Modules/'.$action.'/'.$sub.'/sindex.php'))
	echo '<div style="margin-top:50px; margin-left:230px; color:black;">This is not a valid submodule!</div>';

?>
</div>