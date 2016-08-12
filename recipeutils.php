<?php

/**
 * This utility class manages parsing of json and csv contents
 */
 	/*
 	*	This method parses a JSON file and returns a json object
 	*	@return json object
 	*/
	function getjsoncontents($name)
	{
		return json_decode(file_get_contents($name), true);
	}
	
	/*
 	*	This method parses a CSV file and returns an array object
 	*	@return array object
 	*/
	function getcsvcontents($name)
	{
		$filehandler = fopen($name, 'r');
		$ingredients = array();
		while( ($row = fgetcsv($filehandler, 8192)) !== FALSE ) {
			$ingredients [] = $row;
		}
		fclose($filehandler);
		return $ingredients;
	}
	
?>