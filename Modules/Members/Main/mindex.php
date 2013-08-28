<?php

//Dummy Data to be replaced with SQL calls later.
$memberList = array(
	'Daktyl198', 'Administrator', '2 days ago',
	'Koro', 'Administrator', '1 week ago', 
	'metalbr0', 'Cleaner', 'Yesterday',
	'Pistachio', 'Typesetter', 'Today'
);

$count = 0;

echo '
	<span style="font-style:italic; font-size:10pt;">Click on a title to view the member\'s details</span><br>
	<table id="memberList">
	<tr class="memberListRow" id="memberListHeader">
		<td class="memberName">Member Name</td>
		<td class="memberPositionMain">Position (Main)</td>
		<td class="lastActive">Last Active</td>
	</tr>
';

while (isset($memberList[$count])) {
	$memberViewUrl = '?action=Members&amp;sub=View_Member&amp;member='.str_replace('\0', '', $memberList[$count]);
	echo '<tr class="memberListRow"><td class="memberName"><a href="'.$memberViewUrl.'">'.$memberList[$count].'</a></td><td class="memberPositionMain">'.$memberList[$count+1].'</td><td class="lastActive">'.$memberList[$count+2].'</td></tr>';
	$count += 3;
}

echo '</table>';

?>