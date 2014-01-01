<?php

require_once(databaseDir . 'UserIO.php');
require_once(databaseDir . 'UserRoleIO.php');

if (isset($_GET['position'])){
	if (strlen($_GET['position']) == 1 && preg_match("/[a-z]/", $_GET['position'])){
		$userList = getUsersByPosition($_GET['position']);
	}else{
		$userList = getUsersByRole($_GET['position']);
	}
}else{
	$userList = getUsersAll();
}

?>
	<span style="font-style:italic; font-size:10pt;">Click on a title to view the member's details</span><br />
	<table id="memberList" class="list">
	<tr class="memberListRow" id="memberListHeader">
		<th class="memberName">Member Name</th>
		<th class="memberPositionMain">Position (Main)</th>
		<th class="lastActive">Last Active</th>
	</tr>
<?php

if ($userList === FALSE){
	echo('Database connection failed' . "<br />");
}elseif (count($userList) == 0){
	echo('No users in database' . "<br />");
}else{
	foreach($userList as $user){
		$memberViewUrl = '?action=Members&amp;sub=View&amp;member='.str_replace('\0', '', $user[0]);

		// I don't know all the actual characters, so I'm just gonna throw in two conversions
		if ($user[4] == 'a') {
			$memberRole = 'Administrator';
		}
		else if ($user[4] == 't') {
			$memberRole = 'Translator';
		}
		else
		{
			$memberRole = $user[4];
		}

		echo '<tr class="memberListRow">
				<td class="memberName"><a href="'. $memberViewUrl .'">'.$user[1].'</a></td>
				<td class="memberPositionMain">'. $memberRole .'</td>
				<td class="lastActive">'.'N/A'.'</td>
			</tr>';
	}
}

echo '</table>';

?>