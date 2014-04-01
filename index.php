<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

DEFINE('fromIndex', TRUE);
DEFINE('databaseDir', dirname(__FILE__).'/Database/');

session_start();
$loggedIntoSPOTS = isset($_SESSION['SPOTS_authorized']);

require_once('./header.php');
require_once('./footer.html');

?>
