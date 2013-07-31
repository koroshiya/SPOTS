<?php
if (!$fromIndex)
	die('You must access this through the root index!');

$seriesList = [
	'Comic Studio', 14,
	'Sun-Ken Rock', 189	
];
$count = 0;

?>
<form method="POST" action="?action=AdminCP&amp;sub=Manage_Projects">
<input type="text" name="series_search"><input type="submit" value="Search">
</form>
<table>
<tr>
	<td>Series Title</td>
	<td>Current Chapter</td>
	<td>Details</td>
</tr>
<?php 
	while (isset($seriesList[$count])) {
		echo '<tr><td>'.$seriesList[$count].'</td><td>'.$seriesList[$count+1].'</td><td><a href="?action=AdminCP&amp;sub=Manage_Projects&series='.$seriesList[$count].'">Details</td></tr>';
		$count += 2;
	}
	echo $_POST['series_search'];
?>
</table>