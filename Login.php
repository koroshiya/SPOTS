<?php

if (!fromIndex){die('You must access this through the root index!');}

require_once('./Database/Connection.php');
    
if (isset($_POST['loginUser']) && isset($_POST['loginPass'])){
    	
    $username = htmlspecialchars($_POST['loginUser']);
    $password = htmlspecialchars($_POST['loginPass']);
    unset($_POST['loginUser']);
    unset($_POST['loginPass']);
    
    connect();

    if ($connection === null || !mysqli_ping($connection)){
        die('Database connection failed');
    }else{
        require_once('./Database/UserIO.php');
        $valid = userGetPasswordIsValidByName($username, $password);
        if ($valid != 65535){
            $_SESSION['SPOTS_authorized'] = $valid;
            $_SESSION['SPOTS_user'] = $username;
            $_SESSION['SPOTS_ID'] = $valid;
        }
    }
}elseif (isset($_SESSION['SPOTS_authorized'])){
    $_SESSION['SPOTS_authorized'] = null;
    $_SESSION['SPOTS_user'] = null;
    $_SESSION['SPOTS_ID'] = null;
}else{
    unset($_POST['loginUser']);
	unset($_POST['loginPass']);
}

?>