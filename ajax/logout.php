<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not logged in");
}

$_SESSION['SPOTS_authorized'] = null;
$_SESSION['SPOTS_user'] = null;
$_SESSION['SPOTS_ID'] = null;

return true;

?>