<?php

/**
 * File: SeriesIO.php
 * Author: Koro
 * Date created: 06/July/2012
 * Date last modified: 08/July/2012
 * Version: 1.01
 * Changelog: 1.01: Reduced repeat code in getSeriesByLetter, implemented getSeriesStatus, getSeriesByStatus, getSeriesByID
 * Purpose: Provides methods for interacting with Series objects in the database
 **/ 

	include 'Connection.php';

	//Example usage:
	//echo getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	//echo getSeriesByLetter($mysql_host, $mysql_user, $mysql_password, $mysql_database, 't');
	//echo getSeriesStatus($mysql_host, $mysql_user, $mysql_password, $mysql_database, 4);
	//echo getSeriesByStatus($mysql_host, $mysql_user, $mysql_password, $mysql_database, 'd');
	//echo getSeriesByID($mysql_host, $mysql_user, $mysql_password, $mysql_database, 4);

	/**
	 * Returns the number of Series currently in the DB.
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @return Number of projects ("Series" in the DB). If connection failed, returns false.
	 **/
	function getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		$procedure_name = 'get_project_count';
		$row = connectAndExecuteSingleFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database);

		return $row[0];
		
	}

	/**
	 * Returns the series specified by the ID passed in
	 * @param $seriesID ID of the series to retrieve
	 * @return Series corresponding to the ID passed in, retrieved as an array of parameters
	 **/
	function getSeriesByID($mysql_host, $mysql_user, $mysql_password, $mysql_database, $seriesID){

		$procedure_name = "get_series_by_id";
		$result = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $seriesID);
		
		return $result;

	}

	/**
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByLetter($mysql_host, $mysql_user, $mysql_password, $mysql_database, $character){

		$procedure_name = "get_series_by_letter";
		$result = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, "'" . $character . "'");
		
		return $result;

	}

	/**
	 * Returns all series for which the specified status applies
	 * @param $character Char representing the status of a series. eg. 'd' for Dropped.
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByStatus($mysql_host, $mysql_user, $mysql_password, $mysql_database, $character){

		$procedure_name = "get_series_by_status";
		$result = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, "'" . $character . "'");

		return $result;

	}

	/**
	 * Returns the status of a particular series
	 * @param $seriesID ID of the series to retrieve the status for
	 * @return Returns a String representing the series' status. eg. "Dropped", "Complete", etc.
	 **/
	function getSeriesStatus($mysql_host, $mysql_user, $mysql_password, $mysql_database, $seriesID){

		$procedure_name = "get_series_status";
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $seriesID);
		$result = $result[0];

		if ($result === 'i') {
			return "Inactive";
		} else if ($result === 'a') {
			return "Active";
		} else if ($result === 'a') {
			return "Stalled";
		} else if ($result === 'h') {
			return "Hiatus";
		} else if ($result === 'd') {
			return "Dropped";
		} else if ($result === 'c') {
			return "Complete";
		} else {
			return "N/A";
		}

	}

?>