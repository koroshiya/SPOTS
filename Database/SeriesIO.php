<?php

/**
 * File: SeriesIO.php
 * Author: Koro
 * Date created: 06/July/2012
 * Changelog:	1.01: Reduced repeat code in getSeriesByLetter, implemented getSeriesStatus, getSeriesByStatus, getSeriesByID
 *				1.02: Implemented addSeries, deleteSeries, deleteSeriesByForce, modifySeriesStatus, seriesSetVisible, seriesSetAdult, seriesSetProjectManager
 *						Implemented basic type checking for some methods
 *				1.03: Removed genre inputs to reflect changes to DB
 *				1.04: Added missing connection params
 *				1.05: Updated to reflect changes to DB
 * Purpose: Provides methods for interacting with Series objects in the database
*/ 

	include_once('Connection.php');

	//Example usage:
	//echo getProjectCount();
	//echo getSeriesByLetter('t');
	//echo getSeriesStatus(4);
	//echo getSeriesByStatus('d');
	//echo getSeriesByID(4);


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
	 *
	 * @return True if command is successful, otherwise false.
	 */
	function addSeries($seriesTitle, $status, $description, $thumbnailURL, $projectManagerID, $visibleToPublic, $boolAdult){

		$args = [
				"seriesTitle" => $seriesTitle,
				"status" => $status,
				"description" => $description,
				"thumbnailURL" => $thumbnailURL,
				"projectManagerID" => $projectManagerID,
				"visibleToPublic" => $visibleToPublic,
				"boolAdult" => $boolAdult,
		];

		$procedure_name = 'insert_series';
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
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

		$procedure_name = 'delete_series';
		$args = array($seriesID);
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
	}

	/**
	 * Removes a series from the database.
	 *
	 * @param $seriesID ID of the series to perform this function on.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteSeriesByForce($seriesID){

		$procedure_name = 'delete_series_force';
		$args = array($seriesID);
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
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

		$procedure_name = 'series_set_status';
		$args = array($seriesID, $status);
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
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

		$procedure_name = 'series_set_visible';
		$args = array($seriesID, $boolVisible);
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
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

		$procedure_name = 'series_set_adult';
		$args = array($seriesID, $boolAdult);
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
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

		$procedure_name = 'series_set_project_manager';
		$args = array($seriesID, $managerID);
		$result = executeFunction($procedure_name, $args);
		return $result[0];
		
	}


	/**
	 * Returns the number of Series currently in the DB.
	 * 
	 * @return Number of projects ("Series" in the DB). If connection failed, returns false.
	 **/
	function getProjectCount(){
		
		$procedure_name = 'get_project_count';
		$row = executeFunction($procedure_name, null);

		return $row[0];
		
	}

	/**
	 * Returns the series specified by the ID passed in.
	 *
	 * @param $seriesID ID of the series to retrieve.
	 *
	 * @return Series corresponding to the ID passed in, retrieved as an array of parameters.
	 **/
	function getSeriesByID($seriesID){

		$procedure_name = "get_series_by_id";
		return executeStoredProcedure($procedure_name, $seriesID);

	}

	/**
	 * Gets all series that start with a specific character.
	 *
	 * @param $character Letter to retrieve series beginning with.
	 *
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByLetter($character){

		$procedure_name = "get_series_by_letter";
		return executeStoredProcedure($procedure_name, "'" . $character . "'");

	}

	/**
	 * Returns all series for which the specified status applies.
	 *
	 * @param $character Char representing the status of a series. eg. 'd' for Dropped.
	 *
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByStatus($character){

		$procedure_name = "get_series_by_status";
		return executeStoredProcedure($procedure_name, "'" . $character . "'");

	}

	/**
	 * Returns the status of a particular series.
	 *
	 * @param $seriesID ID of the series to retrieve the status for.
	 *
	 * @return Returns a String representing the series' status. eg. "Dropped", "Complete", etc.
	 **/
	function getSeriesStatus($seriesID){

		$procedure_name = "get_series_status";
		$result = executeFunction($procedure_name, $seriesID);
		return getSeriesStatusFromChar($result[0]);

	}

	/**
	 * Gets the status string corresponding to a specific character.
	 *
	 * @param $char Character representing a possible series status.
	 *
	 * @return String portraying a series' status.
	 */
	function getSeriesStatusFromChar($char){

		if ($char === 'i') {
			return "Inactive";
		} else if ($char === 'a') {
			return "Active";
		} else if ($char === 'a') {
			return "Stalled";
		} else if ($char === 'h') {
			return "Hiatus";
		} else if ($char === 'd') {
			return "Dropped";
		} else if ($char === 'c') {
			return "Complete";
		} else {
			return "N/A";
		}

	}

	/**
	 * Retrieves all series from the database.
	 *
	 * @return All series from the database.
	 */
	function getSeriesAll(){
		$procedure_name = "get_series_all";
		return executeStoredProcedure($procedure_name, null);
	}

?>