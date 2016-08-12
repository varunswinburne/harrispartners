<?php

	function getjsoncontents($name)
	{
		return json_decode(file_get_contents($name), true);
	}
	
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