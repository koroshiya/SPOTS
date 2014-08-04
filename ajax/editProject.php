<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}

function returnError($msg){
	die("-1".$msg);
}

$id = $_POST['SeriesID'];

if (!(isset($id) && strlen($id) > 0 && is_numeric($id))){
	returnError("SeriedID invalid or not specified");
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

if (is_null($desc) || strlen($desc) == 0){$desc = null;}
elseif (strlen($desc) > 255){returnError("Series description is too long");}

$pm = $_POST['pm'];

if (!is_numeric($pm)){returnError("Invalid project manager ID");}
elseif ($pm == -1){$pm = null;}

$public = $_POST['ispublic'] == "1" ? 1 : 0;
$adult = $_POST['isadult'] == "1" ? 1 : 0;

$author = $_POST['author'];

if (strlen($author) > 50){returnError("Author is too long");}

$artist = $_POST['artist'];

if (strlen($artist) > 50){returnError("Artist is too long");}

$type = $_POST['type'];

if (strlen($type) > 50){returnError("Type is too long");}

$download = $_POST['downloadURL'];

$dlSize = strlen($download);
if ($dlSize > 255){returnError("Download URL is too long");}

$reader = $_POST['readerURL'];

$dlSize = strlen($reader);
if ($dlSize > 255){returnError("Reader URL is too long");}

$notes = $_POST['notes'];

if (is_null($notes) || strlen($notes) == 0){$notes = null;}
elseif (strlen($notes) > 255){returnError("Series description is too long");}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'SeriesIO.php');

return updateSeries($id, $title, $status, $desc, $pm, $public, $adult, $author, $artist, $type, $download, $reader, $notes);

?>