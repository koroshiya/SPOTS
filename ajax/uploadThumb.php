<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
//if (!isset($_SESSION['SPOTS_authorized'])){
    //die("You are not permitted to view this series");
//}


if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK){
    $UploadDirectory = realpath(dirname(dirname(__FILE__))).'/thumbs/';
   
    /*
    Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
    Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
    and set them adequately, also check "post_max_size".
    */
   
    //check if this is an ajax request
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        die();
    }elseif ($_FILES["FileInput"]["size"] > 5242880) {
        die("File size is too big!");
    }
   
    //allowed file type Server side check
    switch(strtolower($_FILES['FileInput']['type'])){
        //allowed file types
        case 'image/png':
        case 'image/gif':
        case 'image/jpeg':
            break;
        default:
            die('Unsupported File!'); //output error
    }
   
    $File_Name          = strtolower($_FILES['FileInput']['name']);
    $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
   
    if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.'1'.$File_Ext )){
        die('Success! File Uploaded.');
    }else{
        die('Error uploading file.');
    }
   
}
else{
    die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}



?>