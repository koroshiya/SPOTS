<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){die('You must be logged in to access this page.');}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'UserIO.php');

$users = getUsersAll();

?>

<section>
	
	<center>

		<form action="ajax/addProject.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
			<table>
				<tbody style="text-align:left;">
					<tr>
						<td>
							<b>Series Title&emsp;</b>
						</td>
						<td>
							<input maxlength="100" type="text" id="form_title" name="form_title" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Series Status&emsp;</b>
						</td>
						<td>
							<select id="form_status" name="form_status">
								<option value="A">Active</option>
								<option value="S">Stalled</option>
								<option value="I">Inactive</option>
								<option value="H">Hiatus</option>
								<option value="D">Dropped</option>
								<option value="C">Complete</option>
								<option value="L">Licensed</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>Description&emsp;</b>
						</td>
						<td>
							<textarea maxlength="255" id="form_desc" name="form_desc"></textarea>
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
										echo "<option value=\"".$user["userID"]."\">".$user["userName"]."</option>";
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
							<input type="checkbox" id="form_public" name="form_public" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Adult series&emsp;</b>
						</td>
						<td>
							<input type="checkbox" id="form_adult" name="form_adult" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Author&emsp;</b>
						</td>
						<td>
							<input maxlength="50" type="text" id="form_author" name="form_author" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Artist&emsp;</b>
						</td>
						<td>
							<input maxlength="50" type="text" id="form_artist" name="form_artist" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Comic Type&emsp;</b>
						</td>
						<td>
							<input maxlength="50" type="text" id="form_type" name="form_type" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Download URL&emsp;</b>
						</td>
						<td>
							<input maxlength="255" type="text" id="form_download" name="form_download" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Online reader URL&emsp;</b>
						</td>
						<td>
							<input maxlength="255" type="text" id="form_reader" name="form_reader" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Notes&emsp;</b>
						</td>
						<td>
							<textarea maxlength="255" id="form_notes" name="form_notes"></textarea>
						</td>
					</tr>

					<tr>
						<td>
							<input type="submit" id="btn_submit" name="btn_submit" value="Submit" />
						</td>
						<td>
							<b id="output"></b>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

	</center>

</section>

<script type="text/javascript">
	$('#MyUploadForm').submit(function(evt) {
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
		$('#output').text("");
	    $(this).ajaxSubmit({
	    	data: {title:title, status:status, desc:desc, pm:pm, ispublic:ispublic, isadult:isadult,
	    		author: author, artist: artist, type: type, downloadURL: download, readerURL: reader, 
	    		notes: notes},
		    success: afterSuccess,
		    resetForm: true
		});
	    return false;
	});
	function afterSuccess(){
		if (arguments[0].substring(0,2) == "-1"){
			$('#output').text(arguments[0].substring(2));
		}else{
			$('#output').text("Series added successfully");
		}
		for (var i = 0; i < arguments.length; i++) {
			console.log(arguments[i]);
		}
	}
</script>