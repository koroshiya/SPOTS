<?php

/**
*File: SeriesGenreIO.php
*Author: Koro
*Changelog: 
*Purpose: Provides methods for interacting with SeriesGenre objects in the database
**/ 

	include 'Connection.php';

	function addSeriesGenre($seriesID, $name){
		return seriesIOFunction($seriesID, $name, 'series_add_genre');
	}

	function removeSeriesGenre($seriesID, $name){
		return seriesIOFunction($seriesID, $name, 'series_remove_genre');
	}

	function removeAllSeriesGenres($seriesID){
		return seriesFunction($seriesID, 'series_remove_genre_all');
	}

	function getSeriesGenres($seriesID){

		global $connection;
		return executeStoredProcedure('series_get_genres', $seriesID, $connection);
	}

	function getSeriesByGenre($name){
		global $connection;
		return executeStoredProcedure('series_get_by_genre', $name, $connection);
	}
	
	function seriesIOFunction($seriesID, $name, $procedure_name){

		$array = [
				"seriesID" => $seriesID,
				"name" => $name,
		];

		global $connection;
		
		$row = executeFunction($procedure_name, $array, $connection);
		return $row[0];
		
	}
	
	function seriesFunction($seriesID, $procedure_name){

		global $connection;
		
		$row = executeFunction($procedure_name, $seriesID, $connection);
		return $row[0];
		
	}

?>