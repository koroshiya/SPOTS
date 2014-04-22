<?php

	require_once('Connection.php');

	/**
	 * Adds a new Series/Genre pairing to the database.
	 * 
	 * @param $seriesID ID of the series to add to the pairing.
	 * @param $name Name of the Genre to pair with the series.
	 */
	function addSeriesGenre($seriesID, $name){
		connectToMeekro();
		$result = DB::query("SELECT series_add_genre(%s);", $name);
		return $result;
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
		connectToMeekro();
		$result = DB::query("SELECT series_remove_genre(%i, %s);", $seriesID, $name);
		return $result;
	}

	/**
	 * Removes all Series/Genre pairings associated with a specific series.
	 * 
	 * @param $seriesID ID of the Series for which to remove all pairings.
	 */
	function removeAllSeriesGenres($seriesID){
		connectToMeekro();
		$result = DB::query("SELECT series_remove_genre_all(%i);", $seriesID);
		return $result;
	}

	/**
	 * Retrieves all genres for a specific series.
	 * 
	 * @param $seriesID ID of the series for which to grab all of the genres.
	 */
	function getSeriesGenres($seriesID){
		connectToMeekro();
		$result = DB::query("SELECT sg.name FROM SeriesGenre AS sg WHERE sg.seriesID = %i;", $seriesID);
		return $result;
	}

?>
