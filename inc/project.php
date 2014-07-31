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
//var_dump($seriesInfo);
//echo $seriesInfo["status"];
if ($seriesInfo['visibleToPublic'] || isset($_SESSION['SPOTS_authorized'])){
	
require_once(databaseDir . 'UserIO.php');
$pm = getUser($seriesInfo['projectManagerID']);
//var_dump($pm);
$thumb = $seriesInfo["thumbnailURL"];
if (is_null($thumb) || strlen($thumb) == 0) {
	$thumb = "missing.png";
}

$online = $seriesInfo["readOnlineURL"];
if (is_null($thumb) || strlen($thumb) == 0) {
	$online = null;
}
$down = $seriesInfo["downloadURL"];
if (is_null($down) || strlen($down) == 0) {
	$down = null;
}

?>

<section>
	
	<center>
		<div id="dialogform" style="display:none; width:200px;">
			<form action="ajax/uploadThumb.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
			<input name="FileInput" id="FileInput" type="file" /><br /><br />
			<div id="progressbox">
				<div id="progressbar"></div>
				<div id="statustxt">0%</div>
			</div><br />
			<input type="submit" id="submit-btn" value="Upload" style="float:left; width:90px;" /><br /><br />
			<div id="output"></div>
			</form>
		</div>
		<div id="projectDiv">
			<table><tbody>
				<tr><th>Title</th><td><?php echo $seriesInfo["seriesTitle"]; ?></td></tr>
				<tr><td colspan="2" style="height:200px;"><img id="seriesImage" style="max-height:200px; max-width:200px;" src=<?php echo "thumbs/".$thumb; ?> /></td></tr>
				<tr><th>Status</th><td><?php echo getSeriesStatusFromChar($seriesInfo["status"]); ?></td></tr>
				<?php if (isset($_SESSION['SPOTS_authorized'])){ ?>
				<tr><th>Project Manager</th><td id="userProfile"><?php echo $pm["userName"]; /*TODO: link to user's profile page*/ ?></td></tr>
				<?php } ?>
				<tr>
					<td>
						<?php
							echo is_null($online) ? "No online reader<br>link available" : "<a href=".$seriesInfo["readOnlineURL"].">Read Online</a>";
						?>
					</td>
					<td>
						<?php
							echo is_null($down) ? "No download<br>link available" : "<a href=".$seriesInfo["downloadURL"].">Download</a>";
						?>
					</td>
				</tr>
				<tr><th>Notes</th><td style="max-width:200px;"><?php echo $seriesInfo["notes"]; ?></td></tr>
			</tbody></table>
		</div>
	</center>
</section>

<?php

if (isset($_SESSION['SPOTS_authorized'])){

?>

<script type="text/javascript">
	$("#sidebar").html(
		'<a id="sidebar_back">Back to Projects</a>'+
		'<a id="btn_thumb">New thumbnail</a>'
	);
	$("#sidebar_back").click(function(){GoToPage("projects");});

	$("#btn_thumb").click(function() {
		$(this).text($(this).text() === "New thumbnail" ? "Cancel" : "New thumbnail");

		$("#dialogform").toggle();
		$("#projectDiv").toggle();
	});
	
	$('#MyUploadForm').submit(function(evt) {
		evt.preventDefault();
	    $(this).ajaxSubmit({
	    	data: {SeriesID: <?php echo $id; ?>},
		    target: '#output',   // target element(s) to be updated with server response
		    beforeSubmit: beforeSubmit,  // pre-submit callback
		    success: afterSuccess,  // post-submit callback
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
	   
	    	if (fsize>1048576){ //1MB limit
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
	function afterSuccess(){
		$('#statustxt').html("100%");
		for (var i = 0; i < arguments.length; i++) {
			console.log(arguments[i]);
		}
		$("#seriesImage").attr('src', 'thumbs/'+<?php echo $id; ?>+"."+$('#FileInput')[0].files[0].name.split('.').pop());
		$("#btn_thumb").text("Return to Series");
	}
	$("#userProfile").click(function(){
		GoToPage("members", <?php echo $pm['userID'] ?>);
	});
</script>

<?php }else{ ?>

<script type="text/javascript">
	$("#sidebar").html('<a id="sidebar_back">Back to Projects</a>');
	$("#sidebar_back").click(function(){GoToPage("projects");});
</script>

<?php } }else{ /*TODO: show series info, without edit options and such*/ ?>

<center>You are not permitted to view this series</center>
<script type="text/javascript">
	$("#sidebar").html('<a id="sidebar_back">Back to Projects</a>');
	$("#sidebar_back").click(function(){GoToPage("projects");});
</script>

<?php } ?>