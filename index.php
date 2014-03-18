<?php

DEFINE('fromIndex', TRUE);
DEFINE('databaseDir', dirname(__FILE__).'/Database/');

require_once(databaseDir.'Connection.php');
global $connection;
if ($connection === null || !mysqli_ping($connection)){
	connect();
	if ($connection === null || !mysqli_ping($connection)){
		die('Failure to connect to database.');
	}
}

session_start();
$loggedIntoSPOTS = isset($_SESSION['SPOTS_authorized']);
if (!$loggedIntoSPOTS || $_GET['action'] === 'logout'){
    require_once('./Login.php');
}
$loggedIntoSPOTS = isset($_SESSION['SPOTS_authorized']);

require_once('./header.php');
echo '<script type="text/javascript">var loggedIn = '.($loggedIntoSPOTS ? "true" : "false").';</script>';
require_once('./footer.html');

?>
