<?php

	require_once('Connection.php');

	/**
	 * Creates a new series genre.
	 *
	 * @param $name Name of the genre to add.
	 */
	function addGenre($name){

		connectToMeekro();
		$result = DB::query("SELECT insert_genre(%s);", $name);
		return $result;
		
	}

	/**
	 * Removes an existing genre from the DB.
	 * Fails if any SeriesGenre objects rely on this genre.
	 *
	 * @param $name Name of the genre to remove.
	 */
	function removeGenre($name){

		connectToMeekro();
		$result = DB::query("SELECT delete_genre(%s);", $name);
		return $result;
		
	}

	/**
	 * Removes an existing genre from the DB.
	 *
	 * @param $name Name of the genre to add.
	 */
	function removeGenreForce($name){

		connectToMeekro();
		$result = DB::query("SELECT delete_genre_force(%s);", $name);
		return $result;
		
	}

?>