<?php
if (!fromIndex){die('You must access this through the root index!');}

require_once(databaseDir.'UserIO.php');
$info = getUser($_GET['member']);

function userRoleGet($input) {
	if ($input == 'a') {
		echo 'Administrator';
	}
	else if ($input == 'm') {
		echo 'Moderator';
	}
}

?>
<div id="content">
	<div id="view_header">
		<span id="member_name"><?php echo $info['userName']; ?></span><br />
		<div id="user_info">
			<span class="subTitle">Position:</span><br />
			<span class="member_info_table"><?php userRoleGet($info['title']); ?></span>
		</div>
	</div>
</div>