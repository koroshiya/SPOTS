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
$users = getUsersAll();
//var_dump($pm);
$thumb = $seriesInfo["thumbnailURL"];
if (is_null($thumb) || strlen($thumb) == 0) {
	$thumb = "missing.png";
}

$online = $seriesInfo["readOnlineURL"];
if (is_null($online) || strlen($online) == 0) {
	$online = null;
}elseif($online[strlen($online) - 1] === '/'){
	$online .= "index.php";
}

$down = $seriesInfo["downloadURL"];
if (is_null($down) || strlen($down) == 0) {
	$down = null;
}elseif($down[strlen($down) - 1] === '/'){
	$down .= "index.php";
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

		<form action="ajax/editProject.php" method="post" enctype="multipart/form-data" id="EditProjectForm" style="display:none;">
			<table>
				<tbody style="text-align:left;">
					<tr>
						<td>
							<b>Series Title&emsp;</b>
						</td>
						<td>
							<input maxlength="100" type="text" id="form_title" name="form_title" value=<?php echo '"'.$seriesInfo["seriesTitle"].'"'; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Series Status&emsp;</b>
						</td>
						<td>
							<select id="form_status" name="form_status">
								<option value="A" <?php if ($seriesInfo["status"] == "A"){echo 'selected=selected';} ?> >Active</option>
								<option value="S" <?php if ($seriesInfo["status"] == "S"){echo 'selected=selected';} ?> >Stalled</option>
								<option value="I" <?php if ($seriesInfo["status"] == "I"){echo 'selected=selected';} ?> >Inactive</option>
								<option value="H" <?php if ($seriesInfo["status"] == "H"){echo 'selected=selected';} ?> >Hiatus</option>
								<option value="D" <?php if ($seriesInfo["status"] == "D"){echo 'selected=selected';} ?> >Dropped</option>
								<option value="C" <?php if ($seriesInfo["status"] == "C"){echo 'selected=selected';} ?> >Complete</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>Description&emsp;</b>
						</td>
						<td>
							<textarea maxlength="255" id="form_desc" name="form_desc"><?php echo $seriesInfo["description"]; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<b>Project Manager&emsp;</b>
						</td>
						<td>
							<select id="form_pm" name="form_pm">
								<option value="-1">No project manager</option>
								<?php
									foreach ($users as $user) {
										if ($pm['userID'] == $user['userID']){
											echo "<option value=\"".$user["userID"]."\" checked=\"checked\">".$user["userName"]."</option>";
										}else{
											echo "<option value=\"".$user["userID"]."\">".$user["userName"]."</option>";
										}
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>Visible to public&emsp;</b>
						</td>
						<td>
							<input type="checkbox" id="form_public" name="form_public" <?php echo $seriesInfo["visibleToPublic"] ? 'checked="checked"' : ''; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Adult series&emsp;</b>
						</td>
						<td>
							<input type="checkbox" id="form_adult" name="form_adult" <?php echo $seriesInfo["isAdult"] ? 'checked="checked"' : ''; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Author&emsp;</b>
						</td>
						<td>
							<input maxlength="50" type="text" id="form_author" name="form_author" value=<?php echo '"'.$seriesInfo["author"].'"'; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Artist&emsp;</b>
						</td>
						<td>
							<input maxlength="50" type="text" id="form_artist" name="form_artist" value=<?php echo '"'.$seriesInfo["artist"].'"'; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Comic Type&emsp;</b>
						</td>
						<td>
							<input maxlength="50" type="text" id="form_type" name="form_type" value=<?php echo '"'.$seriesInfo["type"].'"'; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Download URL&emsp;</b>
						</td>
						<td>
							<input maxlength="255" type="text" id="form_download" name="form_download" value=<?php echo '"'.$down.'"'; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Online reader URL&emsp;</b>
						</td>
						<td>
							<input maxlength="255" type="text" id="form_reader" name="form_reader" value=<?php echo '"'.$online.'"'; ?> />
						</td>
					</tr>
					<tr>
						<td>
							<b>Notes&emsp;</b>
						</td>
						<td>
							<textarea maxlength="255" id="form_notes" name="form_notes"><?php echo $seriesInfo["notes"]; ?></textarea>
						</td>
					</tr>

					<tr>
						<td>
							<input type="submit" id="btn_submit" name="btn_submit" value="Submit" />
						</td>
						<td>
							<b id="editOutput"></b>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

		<div id="projectDiv">
			<table><tbody>
				<tr><th>Title</th><td id="projectDiv_seriesTitle"><?php echo $seriesInfo["seriesTitle"]; ?></td></tr>
				<tr><td colspan="2" style="height:200px;"><img id="seriesImage" style="max-height:200px; max-width:200px;" src=<?php echo "thumbs/".$thumb; ?> /></td></tr>
				<tr><th>Status</th><td id="projectDiv_status"><?php echo getSeriesStatusFromChar($seriesInfo["status"]); ?></td></tr>
				<?php if (isset($_SESSION['SPOTS_authorized']) && !is_null($pm)){ ?>
				<tr><th>Project Manager</th><td id="userProfile"><?php echo $pm["userName"]; /*TODO: link to user's profile page*/ ?></td></tr>
				<?php } ?>
				<tr>
					<td id="projectDiv_readOnlineURL">
						<?php
							echo is_null($online) ? "No online reader<br>link available" : "<a href=".$online.">Read Online</a>";
						?>
					</td>
					<td id="projectDiv_downloadURL">
						<?php
							echo is_null($down) ? "No download<br>link available" : "<a href=".$down.">Download</a>";
						?>
					</td>
				</tr>
				<tr><th>Notes</th><td style="max-width:200px;" id="projectDiv_notes"><?php echo $seriesInfo["notes"]; ?></td></tr>
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
		'<a id="btn_thumb">New thumbnail</a>'+
		'<a id="btn_edit">Edit Project</a>'
	);
	$("#sidebar_back").click(function(){GoToPage("projects", <?php echo $_POST['start']; ?>);});

	$("#btn_thumb").click(function() {
		if ($(this).text() === "New thumbnail"){
			$(this).text("Cancel");
			$("#btn_edit").text("Edit Project");
			$("#dialogform").show();
			$("#projectDiv").hide();
			$("#EditProjectForm").hide();
		}else{
			$(this).text("New thumbnail");
			$("#dialogform").hide();
			$("#projectDiv").show();
			$("#EditProjectForm").hide();
		}
	});

	$("#btn_edit").click(function() {
		if ($(this).text() === "Edit Project"){
			$(this).text("Cancel");
			$("#btn_thumb").text("New thumbnail");
			$("#dialogform").hide();
			$("#projectDiv").hide();
			$("#EditProjectForm").show();
		}else{
			$(this).text("Edit Project");
			$("#dialogform").hide();
			$("#projectDiv").show();
			$("#EditProjectForm").hide();
		}
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
	            case 'image/webp':
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

	$('#EditProjectForm').submit(function(evt) {
		evt.preventDefault();
		var title = $("#form_title").val();
		var status = $("#form_status").val();
		var desc = $("#form_desc").val();
		var pm = $("#form_pm").val();
		var ispublic = $("#form_public").is(':checked') ? "1" : "-1";
		var isadult = $("#form_adult").is(':checked') ? "1" : "-1";
		var author = $("#form_author").val();
		var artist = $("#form_artist").val();
		var type = $("#form_type").val();
		var download = $("#form_download").val();
		var reader = $("#form_reader").val();
		var notes = $("#form_notes").val();
		$('#editOutput').text("");
	    $(this).ajaxSubmit({
	    	data: {SeriesID: <?php echo $id; ?>, title:title, status:status, desc:desc, pm:pm, ispublic:ispublic, 
	    		isadult:isadult, author: author, artist: artist, type: type, downloadURL: download, 
	    		readerURL: reader, notes: notes},
		    target: '#editOutput',   // target element(s) to be updated with server response
		    success: afterSuccessEdit,  // post-submit callback
		    resetForm: false        // reset the form after successful submit
		});
	    return false;
	});
	function afterSuccessEdit(){
		if (arguments[0].substring(0,2) == "-1"){
			$('#editOutput').text(arguments[0].substring(2));
		}else{
			$('#editOutput').text("Edited successfully");
			$("#projectDiv_seriesTitle").text($("#form_title").val());
			var statusVal = 'N/A';
			switch($("#form_status").val()){
				case 'A':
					statusVal = 'Active';
					break;
				case 'S':
					statusVal = 'Stalled';
					break;
				case 'D':
					statusVal = 'Dropped';
					break;
				case 'I':
					statusVal = 'Inactive';
					break;
				case 'C':
					statusVal = 'Complete';
					break;
				case 'H':
					statusVal = 'Hiatus';
					break;
			}
			$("#projectDiv_status").text(statusVal);

			var readerVal = $("#form_reader").val();
			if (readerVal.length > 0){
				if (endsWith(readerVal, '/')){readerVal += "index.php";}
				$("#projectDiv_readOnlineURL").html("<a href="+readerVal+">Read Online</a>");
			}else{
				$("#projectDiv_readOnlineURL").html("No online reader<br>link available");
			}

			var readerVal = $("#form_download").val();
			if (readerVal.length > 0){
				if (endsWith(readerVal, '/')){readerVal += "index.php";}
				$("#projectDiv_downloadURL").html("<a href="+readerVal+">Download</a>");
			}else{
				$("#projectDiv_downloadURL").html("No download<br>link available");
			}

			$("#projectDiv_notes").text($("#form_notes").val());
			id="projectDiv_readOnlineURL"
		}
		for (var i = 0; i < arguments.length; i++) {
			console.log(arguments[i]);
		}
	}

	function endsWith(str, suffix) {
	    return str.indexOf(suffix, str.length - suffix.length) !== -1;
	}


	<?php if (!is_null($pm)){ ?>
	$("#userProfile").click(function(){
		GoToPage("members", <?php echo $pm['userID']; ?>);
	});
	<?php } ?>
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