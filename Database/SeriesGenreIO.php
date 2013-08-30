<?php

/**
 *File: SeriesGenreIO.php
 *Author: Koro
 *Changelog: 
 *Purpose: Provides methods for interacting with SeriesGenre objects in the database
*/ 

	include 'Connection.php';

	/**
	 * Adds a new Series/Genre pairing to the database.
	 * 
	 * @param $seriesID ID of the series to add to the pairing.
	 * @param $name Name of the Genre to pair with the series.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function addSeriesGenre($seriesID, $name){
		$procedure_name = 'series_add_genre';
		return seriesIOFunction($seriesID, $name, $procedure_name);
	}

	/**
	 * Removes a Series/Genre pairing to the database.
	 * 
	 * @param $seriesID ID of the Series/Genre pairing to remove.
	 * @param $name Name of the Series/Genre pairing to remove.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function removeSeriesGenre($seriesID, $name){
		$procedure_name = 'series_remove_genre';
		return seriesIOFunction($seriesID, $name, $procedure_name);
	}

	/**
	 * Removes all Series/Genre pairings associated with a specific series.
	 * 
	 * @param $seriesID ID of the Series for which to remove all pairings.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function removeAllSeriesGenres($seriesID){
		$procedure_name = 'series_remove_genre_all';
		return seriesFunction($seriesID, $procedure_name);
	}

	/**
	 * Retrieves all genres for a specific series.
	 * 
	 * @param $seriesID ID of the series for which to grab all of the genres.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function getSeriesGenres($seriesID){
		global $connection;
		$procedure_name = 'series_get_genres';
		return executeStoredProcedure($procedure_name, $seriesID, $connection);
	}

	/**
	 * Retrieves all series of a specific genre.
	 * 
	 * @param $name Name of the Genre for which to retrieve series pertaining to it.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function getSeriesByGenre($name){
		global $connection;
		$procedure_name = 'series_get_by_genre';
		return executeStoredProcedure($procedure_name, $name, $connection);
	}
	
	/**
	 * Convenience method for performing an IO function.
	 * 
	 * @param $seriesID ID of the Series of a pairing.
	 * @param $name Name of the Genre of a pairing.
	 * @param $procedure_name Name of the IO function to run.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function seriesIOFunction($seriesID, $name, $procedure_name){

		global $connection;

		$array = array($seriesID, $name);
		$row = executeFunction($procedure_name, $array, $connection);
		return $row[0];
		
	}
	
	/**
	 * Convenience method for performing a Series function.
	 * 
	 * @param $seriesID ID of the series to add to the pairing.
	 * @param $procedure_name Name of the function to run.
	 * 
	 * @return True if successful, otherwise false.
	 */
	function seriesFunction($seriesID, $procedure_name){

		global $connection;
		
		$row = executeFunction($procedure_name, $seriesID, $connection);
		return $row[0];
		
	}

?>