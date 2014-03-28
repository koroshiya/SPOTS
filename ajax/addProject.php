<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}

$title = $_POST['form_title'];

if (strlen($title) > 100){die("Series title is too long");}

$status = $_POST['form_status'];

switch ($status) {
	case 'A':
	case 'S':
	case 'I':
	case 'H':
	case 'D':
	case 'C':
		break;
	default:
		die("Invalid status code");
		break;
}

$desc = $_POST['form_desc'];

if (strlen($desc) > 255){die("Series description is too long");}

$pm = $_POST['form_pm'];

if (!is_numeric($pm)){die("Invalid project manager ID");}
elseif ($pm == -1){$pm = null;}

$public = $_POST['form_public'];
$adult = $_POST['form_adult'];

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'SeriesIO.php');

?>