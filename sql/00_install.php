<?php

DEFINE('fromIndex', TRUE);
DEFINE('databaseDir', '../Database/');

require_once(databaseDir.'Settings.php');

$link = mysqli_connect(host, dbUser, dbPass);
if (!$link) {die('Could not connect to MySQL');}

$db_selected = mysqli_select_db($link, dbName);
if (!$db_selected) { //DB doesn't yet exist
	ParseBasicSQLFile('01_initial_build.sql', $link);
	$db_selected = mysqli_select_db($link, dbName);
	if (!$db_selected) { //Build failed, abort
		die('Unable to create database');
	}
}else{
	//prompt to make sure they want to proceed with the installation?
}

foreach (scandir('.') as $spfile) {
	ParseSPSQLFile($spfile, $link);
}

echo "<br /><br />Finished";

function ParseBasicSQLFile($sqlFile, $conn){
	$queryLine = '';
	$lines = file($sqlFile);
	foreach ($lines as $line_num => $line) {
		if (substr($line, 0, 2) != '--' && $line != '') {
			$queryLine .= $line;
			if (substr(trim($line), -1, 1) == ';') {
				mysqli_query($conn, $queryLine) or print('Error performing query \'<b>' . $queryLine . '</b>\': ' . mysql_error() . '<br /><br />');
				$queryLine = '';
			}
		}
	}
}

function ParseSPSQLFile($sqlFile, $conn){
	$queryLine = '';
	$lines = file($sqlFile);
	$boolq = false;
	$comment = false;
	foreach ($lines as $line_num => $line) {
		$tline = trim($line);
		$twostub = substr($tline, 0, 2);
		if ($boolq){
			if($twostub == '/*'){
				$comment = true;
			}
			if (substr($tline, -2, 2) == '*/' || substr($tline, -3, 3) == '*/ '){
				$comment = false;
			}
		}
		if (!$comment && $boolq && $twostub != '--' && $line != '') {
			if (substr($tline, 0, 9) === 'DELIMITER'){
				$boolq = false;
				str_replace("//", "", $queryLine);
				mysqli_query($conn, $queryLine) or print('Error performing query \'<b>' . $queryLine . '</b>\': ' . mysql_error() . '<br /><br />');
				$queryLine = '';
			}elseif(substr($tline, 0, 4) == 'DROP'){
				mysqli_query($conn, str_replace(" //", ";", $tline)) or print('Error performing query \'<b>' . $queryLine . '</b>\': ' . mysql_error() . '<br /><br />');
			}else{
				$queryLine .= str_replace(" //", ";", $tline) . " ";
			}
		}elseif (substr($tline, 0, 9) === 'DELIMITER'){
			$boolq = true;
		}
	}
}

?>