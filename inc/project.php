<?php

if (!fromIndex){die('You must access this through the root index!');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');

if (!isset($_POST['id']) or empty($_POST['id'])){
	die("No ID set");
}

$id = $_POST['id'];
require_once(databaseDir . 'SeriesIO.php');
session_start();
$seriesInfo = getSeriesByID($id);
if (!$seriesInfo[0] || (!$seriesInfo[6] && !isset($_SESSION['SPOTS_authorized']))){
	die("You are not permitted to view this series");
}
require_once(databaseDir . 'UserIO.php');
$pm = getUser($seriesInfo[5]);

?>

<section>
	
	<center>
		<div id="dialogform" style="display:none; width:200px;">
			<form action="ajax/uploadThumb.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
			<input name="FileInput" id="FileInput" type="file" /><br /><br />
			<input type="submit"  id="submit-btn" value="Upload" style="float:left;" />
			<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
			</form>
			<div id="progressbox">
				<div id="progressbar"></div>
				<div id="statustxt">0%</div>
			</div>
			<div id="output"></div>
		</div>
		<div id="projectDiv">
			<table><tbody>
			<?php
				echo "<tr><th>Title</th><td>$seriesInfo[1]</td>";
				echo "<tr><td colspan=\"2\" style=\"height:200px;\"><img style=\"max-height:200px; max-width:200px;\" src=\"thumbs/Aiki.jpg\" /></td></tr>"; //TODO: series image
				echo "<tr><th>Status</th><td>$seriesInfo[2]</td>";
				echo "<tr><th>Project Manager</th><td>$pm[1]</td>";
				/*
	seriesID smallint unsigned not null AUTO_INCREMENT,0
	seriesTitle varchar(100) not null,1
	status character null,2
	description varchar(255) null,3
	thumbnailURL varchar(255) null,4
	projectManagerID smallint unsigned null,5
	visibleToPublic boolean not null,6
	isAdult boolean not null,7
	author varchar(50) null,8
	artist varchar(50) null,9
	type varchar(50) null, --eg. manga, manhwa, etc.10
				*/
			?>
			<tr><td><button id="btn_thumb">New thumbnail</button></td></tr>
			</tbody></table>
		</div>
	</center>
</section>
<script type="text/javascript">
	$("#sidebar").html('<a class="sidebar_item" id="sidebar_back">Back to Projects</a>');
	$("#sidebar_back").click(function(){GoToPage("projects");});

	$("#btn_thumb").click(function() {
		$("#dialogform").toggle();
		$("#projectDiv").toggle();
	});
	       
	$('#MyUploadForm').submit(function(evt) {
		evt.preventDefault();
	    $(this).ajaxSubmit({
		    target:   '#output',   // target element(s) to be updated with server response
		    beforeSubmit:  beforeSubmit,  // pre-submit callback
		    success:       afterSuccess,  // post-submit callback
		    uploadProgress: OnProgress, //upload progress callback
		    resetForm: false        // reset the form after successful submit
		});
	    return false;
	});
	function beforeSubmit(){
		if (!(window.File && window.FileReader && window.FileList && window.Blob)){
	       alert("Your browser does not support this feature.");
	    }else{
	    	var fsize = $('#FileInput')[0].files[0].size; //get file size
        	var ftype = $('#FileInput')[0].files[0].type; // get file type
        	//allow file types
	    	switch(ftype){
	            case 'image/png':
	            case 'image/gif':
	            case 'image/jpeg':
	            	break;
	            default:
	            	$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
	         		return false
	        }
	   
	    	if (fsize>5242880){ //5MB limit
	        	alert("<b>"+fsize +"</b>File is too big. It should be less than 5 MB.");
	        	return false
	    	}
	    }
	}
	function OnProgress(event, position, total, percentComplete){
	    $('#progressbox').show();
	    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
	    $('#statustxt').html(percentComplete + '%'); //update status text
	    if(percentComplete>50){
	        $('#statustxt').css('color','#000'); //change status text to white after 50%
	    }
	}
	function afterSuccess(a, b, c, d){
		console.log("a: "+a);
		console.log("b: "+b);
		console.log("c: "+c);
		console.log("d: "+d);
	}
	//"ajax/uploadThumb.php"
</script>