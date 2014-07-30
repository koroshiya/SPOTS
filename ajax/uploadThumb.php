<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this series");
}
#TODO: resize the image after upload using imagemagik: https://stackoverflow.com/questions/9084751/how-to-scale-down-an-image-on-the-server-side-with-php

if(isset($_FILES["FileInput"])&&isset($_POST['SeriesID'])&&$_FILES["FileInput"]["error"]==UPLOAD_ERR_OK){
    $UploadDirectory = realpath(dirname(dirname(__FILE__))).'/thumbs/';
    if (!is_numeric($_POST['SeriesID'])){
        die('Invalid series ID');
    }
    DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
    require_once(databaseDir.'SeriesIO.php');
    /*
        Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
        Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
        and set them adequately, also check "post_max_size".
    */
   
    //check if this is an ajax request
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        die();
    }elseif ($_FILES["FileInput"]["size"] > 1048576) {
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
   
    if(move_uploaded_file($_FILES['FileInput']['tmp_name'],$UploadDirectory.$_POST['SeriesID'].$File_Ext)){
        $result = updateSeriesThumbnail($_POST['SeriesID'], $_POST['SeriesID'].$File_Ext);
        //echo "Update thumbnail success: $result";
        die('Success! File Uploaded.');
    }else{
        die('Error uploading file.');
    }
}
else{
    die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}



?>