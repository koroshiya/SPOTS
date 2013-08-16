<?php

/**
 * File: SeriesIO.php
 * Author: Koro
 * Date created: 06/July/2012
 * Changelog:	1.01: Reduced repeat code in getSeriesByLetter, implemented getSeriesStatus, getSeriesByStatus, getSeriesByID
 *				1.02: Implemented addSeries, deleteSeries, deleteSeriesByForce, modifySeriesStatus, seriesSetVisible, seriesSetAdult, seriesSetProjectManager
 						Implemented basic type checking for some methods
 				1.03: Removed genre inputs to reflect changes to DB
 				1.04: Added missing connection params
 				1.05: Updated to reflect changes to DB
 * Purpose: Provides methods for interacting with Series objects in the database
 **/ 

	include 'Connection.php';

	//Example usage:
	//$connection = connect('localhost', 'user', 'pass', 'SPMS'); //TODO: connection should later be defined elsewhere. eg. index.php
	//echo getProjectCount();
	//echo getSeriesByLetter('t');
	//echo getSeriesStatus(4);
	//echo getSeriesByStatus('d');
	//echo getSeriesByID(4);


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

		global $connection;
		$procedure_name = 'insert_series';
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function deleteSeries($seriesID){

		global $connection;
		$procedure_name = 'delete_series';
		$args = array($seriesID);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function deleteSeriesByForce($seriesID){

		global $connection;
		$procedure_name = 'delete_series_force';
		$args = array($seriesID);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function seriesSetStatus($seriesID, $status){

		global $connection;
		$procedure_name = 'series_set_status';
		$args = array($seriesID, $status);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function seriesSetVisible($seriesID, $boolVisible){

		global $connection;
		$procedure_name = 'series_set_visible';
		$args = array($seriesID, $boolVisible);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function seriesSetAdult($seriesID, $boolAdult){

		global $connection;
		$procedure_name = 'series_set_adult';
		$args = array($seriesID, $boolAdult);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function seriesSetProjectManager($seriesID, $managerID){

		global $connection;
		$procedure_name = 'series_set_project_manager';
		$args = array($seriesID, $managerID);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}


	/**
	 * Returns the number of Series currently in the DB.
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @return Number of projects ("Series" in the DB). If connection failed, returns false.
	 **/
	function getProjectCount(){
		
		global $connection;
		$procedure_name = 'get_project_count';
		$row = executeFunction($procedure_name, null, $connection);

		return $row[0];
		
	}

	/**
	 * Returns the series specified by the ID passed in
	 * @param $seriesID ID of the series to retrieve
	 * @return Series corresponding to the ID passed in, retrieved as an array of parameters
	 **/
	function getSeriesByID($seriesID){

		global $connection;
		$procedure_name = "get_series_by_id";
		$result = executeStoredProcedure($procedure_name, $seriesID, $connection);
		
		return $result;

	}

	/**
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByLetter($character){

		global $connection;
		$procedure_name = "get_series_by_letter";
		$result = executeStoredProcedure($procedure_name, "'" . $character . "'", $connection);
		
		return $result;

	}

	/**
	 * Returns all series for which the specified status applies
	 * @param $character Char representing the status of a series. eg. 'd' for Dropped.
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByStatus($character){

		global $connection;
		$procedure_name = "get_series_by_status";
		$result = executeStoredProcedure($procedure_name, "'" . $character . "'", $connection);

		return $result;

	}

	/**
	 * Returns the status of a particular series
	 * @param $seriesID ID of the series to retrieve the status for
	 * @return Returns a String representing the series' status. eg. "Dropped", "Complete", etc.
	 **/
	function getSeriesStatus($seriesID){

		global $connection;
		$procedure_name = "get_series_status";
		$result = executeFunction($procedure_name, $seriesID, $connection);
                $resultRow = $result[0];
		return getSeriesStatusFromChar($resultRow);

	}

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

	function getSeriesAll(){
		global $connection;
		$procedure_name = "get_series_all";
		$result = executeStoredProcedure($procedure_name, null, $connection);
		return $result;
	}

?>