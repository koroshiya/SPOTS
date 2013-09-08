<?php

//Dummy Data to be replaced with SQL calls later.
require_once($databaseDir . 'UserIO.php');
require_once($databaseDir . 'UserRoleIO.php');

if (isset($_GET['position'])){
	if (strlen($_GET['position']) == 1 && preg_match("/[a-z]/", $_GET['position'])){
		$userList = getUsersByPosition($_GET['position']);
	}else{
		$userList = getUsersByRole($_GET['position']);
	}	
}else{
	$userList = getUsersAll();
}
if ($userList === FALSE){
	die('Database connection failed');
}elseif (count($userList) == 0){
	die('No users in database');
}
/*$memberList = array(
	'Daktyl198', 'Administrator', '2 days ago',
	'Koro', 'Administrator', '1 week ago', 
	'metalbr0', 'Cleaner', 'Yesterday',
	'Pistachio', 'Typesetter', 'Today'
);

$count = 0;*/

?>
	<span style="font-style:italic; font-size:10pt;">Click on a title to view the member's details</span><br />
	<table id="memberList" class="list">
	<tr class="memberListRow" id="memberListHeader">
		<th class="memberName">Member Name</th>
		<th class="memberPositionMain">Position (Main)</th>
		<th class="lastActive">Last Active</th>
	</tr>
<?php

foreach($userList as $user){
	$memberViewUrl = '?action=Members&amp;sub=View&amp;member='.str_replace('\0', '', $user[0]);
	echo '<tr class="memberListRow">
			<td class="memberName"><a href="'.$memberViewUrl.'">'.$user[1].'</a></td>
			<td class="memberPositionMain">'.$user[4].'</td>
			<td class="lastActive">'.'N/A'.'</td>
		</tr>';
}

/*while (isset($memberList[$count])) {
	$memberViewUrl = '?action=Members&amp;sub=View_Member&amp;member='.str_replace('\0', '', $memberList[$count]);
	echo '<tr class="memberListRow">
			<td class="memberName"><a href="'.$memberViewUrl.'">'.$memberList[$count].'</a></td>
			<td class="memberPositionMain">'.$memberList[$count+1].'</td>
			<td class="lastActive">'.$memberList[$count+2].'</td>
		</tr>';
	$count += 3;
}*/

echo '</table>';

?>