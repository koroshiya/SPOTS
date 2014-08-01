<?php

	require_once('Connection.php');

	/**
	 * Adds a new series to the database.
	 * 
	 * @param $seriesTitle Title of the series.
	 * @param $status Current status of the series (dropped, complete, etc.)
	 * @param $description Description of the series to add.
	 * @param $thumbnailURL URL path (relative or absolute) to the series' thumbnail.
	 * @param $projectManagerID ID of the member managing this specific series.
	 * @param $visibleToPublic True if series is visible to guest users, otherwise false.
	 * @param $boolAdult True if series is adults-only, otherwise false.
	 */
	function addSeries($seriesTitle, $status, $description, $projectManagerID, $visibleToPublic, $boolAdult, $author, $artist, $type, $download, $reader, $notes){

		$names = array('seriesTitle', 'status', 'description', 'projectManagerID', 'visibleToPublic', 'isAdult', 'author', 'artist', 'type', 'downloadURL', 'readOnlineURL', 'notes');
		$params = array($seriesTitle, $status, $description, $projectManagerID, $visibleToPublic, $boolAdult, $author, $artist, $type, $download, $reader, $notes);
		return insertIntoTable('Series', $names, $params);
		
	}

	/**
	 * Removes a series from the database.
	 * Fails if the series has any chapters, tasks, etc. assigned to it.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteSeries($seriesID){

		connectToMeekro();
		$result = DB::query("SELECT delete_series(%i);", $seriesID);
		return $result;
		
	}

	/**
	 * Removes a series from the database.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteSeriesByForce($seriesID){

		connectToMeekro();
		$result = DB::query("SELECT delete_series_force(%i);", $seriesID);
		return $result;
		
	}

	/**
	 * Updates the status of a series.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 * @param $status New status to set for the series. eg. Dropped, complete, etc.
	 *
	 * @return True if successful, otherwise false.
	 */
	function seriesSetStatus($seriesID, $status){

		connectToMeekro();
		$result = DB::query("SELECT series_set_status(%i, %s);", $seriesID, $status);
		return $result;
		
	}

	/**
	 * Updates the status of a series.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 * @param $boolVisible True if the series is visible to guests, otherwise false.
	 *
	 * @return True if successful, otherwise false.
	 */
	function seriesSetVisible($seriesID, $boolVisible){

		connectToMeekro();
		$result = DB::query("SELECT series_set_visible(%i, %s);", $seriesID, $boolVisible);
		return $result;
		
	}

	/**
	 * Updates the status of a series.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 * @param $boolAdult True if the series is adults-only, otherwise false.
	 *
	 * @return True if successful, otherwise false.
	 */
	function seriesSetAdult($seriesID, $boolAdult){

		connectToMeekro();
		$result = DB::query("SELECT series_set_adult(%i, %s);", $seriesID, $boolAdult);
		return $result;
		
	}

	/**
	 * Updates the status of a series.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 * @param $managerID ID of the user to assign as a series' manager.
	 *
	 * @return True if successful, otherwise false.
	 */
	function seriesSetProjectManager($seriesID, $managerID){

		connectToMeekro();
		$result = DB::query("SELECT series_set_project_manager(%i, %i);", $seriesID, $managerID);
		return $result;
		
	}

	/**
	 * Returns the number of Series currently in the DB.
	 * 
	 * @return Number of projects ("Series" in the DB). If connection failed, returns false.
	 **/
	function getProjectCount($status=null){

		connectToMeekro();
		if (is_null($status)){
			$result = DB::query("SELECT COUNT(*) FROM Series;");
		}else{
			$result = DB::query("SELECT COUNT(*) FROM Series AS s WHERE s.status = %s;", $status);
		}
		return current($result[0]);
		
	}

	function getProjectCountPublic($status=null){

		connectToMeekro();
		if (is_null($status)){
			$result = DB::query("SELECT COUNT(*) FROM Series AS s WHERE s.visibleToPublic = True;");
		}else{
			$result = DB::query("SELECT COUNT(*) FROM Series AS s WHERE s.visibleToPublic = True AND s.status = %s;", $status);
		}
		return current($result[0]);
		
	}

	/**
	 * Returns the series specified by the ID passed in.
	 *
	 * @param $seriesID ID of the series to retrieve.
	 *
	 * @return Series corresponding to the ID passed in, retrieved as an array of parameters.
	 **/
	function getSeriesByID($seriesID){

		connectToMeekro();
		$result = DB::query("SELECT * FROM Series AS s WHERE s.seriesID = %i;", $seriesID);
		return $result[0];

	}

	function updateSeriesThumbnail($seriesID, $thumb){

		connectToMeekro();
		$result = DB::query("UPDATE Series AS s SET s.thumbnailURL = %s WHERE s.seriesID = %i;", $thumb, $seriesID);
		return $result;

	}

	/**
	 * Gets all series that start with a specific character.
	 *
	 * @param $character Letter to retrieve series beginning with.
	 *
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByLetter($character){

		connectToMeekro();
		$result = DB::query("SELECT * FROM Series AS s WHERE s.seriesTitle LIKE %s;", $character);
		return $result;

	}

	/**
	 * Returns all series adhering to the specified genre.
	 *
	 * @param $genre Name of the genre to search against.
	 *
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 */
	function getSeriesByGenre($genre){

		connectToMeekro();
		$result = DB::query("SELECT * FROM SERIES AS s INNER JOIN SeriesGenre AS sg ON sg.name = %s WHERE s.seriesID = sg.seriesID;", $genre);
		return $result;

	}

	/**
	 * Returns all series with a title similar to the string provided.
	 * eg. A search string of "love" would return results such as "1 love 9", "gun x clover", etc.
	 *
	 * @param $searchString Title to query against the database.
	 *
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 */
	function getSeriesByTitle($searchString){

		connectToMeekro();
		$result = DB::query("SELECT * FROM Series AS s WHERE s.seriesTitle LIKE $ss;", $character);
		return $result;
		
	}

	/**
	 * Returns all series with a title similar to the string provided, and of the entered status.
	 *
	 * @param $searchString Title to query against the database.
	 * @param $character Char representing the status of a series. eg. 'd' for Dropped.
	 *
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 */
	function getSeriesByStatusAndTitle($character, $searchString){

		connectToMeekro();
		$result = DB::query("SELECT * FROM Series AS s WHERE s.status = $s AND s.seriesTitle LIKE $ss;", $character, $searchString);
		return $result;

	}

	/**
	 * Returns the status of a particular series.
	 *
	 * @param $seriesID ID of the series to retrieve the status for.
	 *
	 * @return Returns a String representing the series' status. eg. "Dropped", "Complete", etc.
	 **/
	function getSeriesStatus($seriesID){

		connectToMeekro();
		$result = DB::query("SELECT get_series_status($i);", $seriesID);
		return getSeriesStatusFromChar($result);

	}

	/**
	 * Gets the status string corresponding to a specific character.
	 *
	 * @param $char Character representing a possible series status.
	 *
	 * @return String portraying a series' status.
	 */
	function getSeriesStatusFromChar($char){

		if (is_null($char) || strlen($char) != 1){
			return "N/A";
		}

		switch (strtolower($char)) {
			case 'i':
				return "Inactive";
			case 'a':
				return "Active";
			case 's':
				return "Stalled";
			case 'h':
				return "Hiatus";
			case 'd':
				return "Dropped";
			case 'c':
				return "Complete";
			default:
				return "N/A";
		}

	}

	/**
	 * Retrieves all series from the database.
	 *
	 * @return All series from the database.
	 */
	function getSeriesAll($status=null, $start=0, $limit=10){

		connectToMeekro();
		if (is_null($status)){
			$result = DB::query("SELECT * FROM Series LIMIT %i, %i;", $start, $limit);
		}else{
			$result = DB::query("SELECT * FROM Series AS s WHERE s.status = %s LIMIT %i, %i;", $status, $start, $limit);
		}
		return json_encode($result);

	}

	/**
	 * Retrieves all series from the database.
	 *
	 * @return All series from the database.
	 */
	function getSeriesAllPublic($status=null, $start=0, $limit=10){

		connectToMeekro();
		if (is_null($status)){
			$result = DB::query("SELECT * FROM Series AS s WHERE s.visibleToPublic = True LIMIT %i, %i;", $start, $limit);
		}else{
			$result = DB::query("SELECT * FROM Series AS s WHERE s.visibleToPublic = True AND s.status = %s LIMIT %i, %i;", $status, $start, $limit);
		}
		return json_encode($result);

	}

?>