<?php

/**
*File: SeriesIO.php
*Author: Koro
*Date created: 06/July/2012
*Date last modified: 06/July/2012
*Version: 1.00
*Changelog: 
*Purpose: Provides methods for interacting with Series objects in the database
**/ 

	include 'Connection.php';

	//Example usage:
	//echo getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	//echo getSeriesByLetter($mysql_host, $mysql_user, $mysql_password, $mysql_database, 't');

	/**
	 * Returns the number of Series currently in the DB.
	 *  
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
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByLetter($mysql_host, $mysql_user, $mysql_password, $mysql_database, $character){

		$connection = connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
		if ($connection === FALSE){
			die('Connection failed');
		}

		$query = "call get_series_by_letter('" . $character . "');";
		$result = mysqli_query($connection, $query);
		if ($result === FALSE){
			die('Failed');
		}

		$array = array();
		while ($row = mysqli_fetch_array($result)){
			array_push($array, $row);
		}

		return $array;

	}

?>