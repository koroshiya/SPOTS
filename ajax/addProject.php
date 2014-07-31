<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}

function returnError($msg){
	echo "-1";
	die($msg);
}

$title = $_POST['title'];

if (strlen($title) > 100){returnError("Series title is too long");}
elseif (strlen($title) == 0){returnError("Series title not entered");}

$status = $_POST['status'];

switch ($status) {
	case 'A':
	case 'S':
	case 'I':
	case 'H':
	case 'D':
	case 'C':
		break;
	default:
		returnError("Invalid status code");
		break;
}

$desc = $_POST['desc'];

if (strlen($desc) > 255){returnError("Series description is too long");}
elseif (is_null($desc) || strlen($desc) == 0){$desc = null;}

$pm = $_POST['pm'];

if (!is_numeric($pm)){returnError("Invalid project manager ID");}
elseif ($pm == -1){$pm = null;}

$public = $_POST['ispublic'] == "1" ? "True" : "False";
$adult = $_POST['isadult'] == "1" ? "True" : "False";

$author = $_POST['author'];

if (strlen($author) > 50){returnError("Author is too long");}

$artist = $_POST['artist'];

if (strlen($artist) > 50){returnError("Artist is too long");}

$type = $_POST['type'];

if (strlen($type) > 50){returnError("Type is too long");}

$download = $_POST['downloadURL'];

if (strlen($download) > 255){returnError("Download URL is too long");}

$reader = $_POST['readerURL'];

if (strlen($reader) > 255){returnError("Reader URL is too long");}

$notes = $_POST['notes'];

if (strlen($notes) > 255){returnError("Series description is too long");}
elseif (is_null($notes) || strlen($notes) == 0){$notes = null;}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'SeriesIO.php');

return addSeries($title, $status, $desc, $pm, $public, $adult, $author, $artist, $type, $download, $reader, $notes);

?>