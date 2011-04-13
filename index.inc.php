<?php
	$dbhost = "neptun.fbe.fh-weingarten.de:3306";
	$dbname = "webprog_07";
	$dbuser = "webprog_07";
	$dbpass = "webprog_07";
	
	mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());
	
	$validGET = validateGET();
	
	function inArray($_array, $_name)
	{
		foreach($_array as $key => $value)
		{
			if(strtolower($value) == strtolower($_name))
			{
				return "checked";
			}
		}
	}
	
	function validRating($num)
	{
		if(is_numeric($num) && $num >= 0 && $num <= 4)
		{
			return $num;
		}
		else
		{
			return 0;
		}
	}
	
	function getThemen() 
	{
		static $array;
		if(isset($array)) {
			return $array;
		}
		
		$array = array();
		$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk GROUP BY tid") or die(mysql_error());
		while($row = mysql_fetch_array($result))
		{
			array_push($array, $row);
		}
		
		return $array;
	}
	
	function getSchwerpunkte() 
	{
		static $array;
		if(isset($array))
		{
			return $array;
		}
		
		$array = array();
		$result = mysql_query("SELECT *, COUNT(sid_fk) as count FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk GROUP BY sid") or die(mysql_error());
		while($row = mysql_fetch_array($result))
		{
			array_push($array, $row);
		}
		
		return $array;
	}
	
	function createURL($page) 
	{
		$url = $_SERVER[QUERY_STRING];
		$url .= "&page=".$page;
		
		return $url;
	}
	
	function validateGET() {
		$get = $_GET;
		$validGET = array();
		
		if(array_key_exists("schwerpunkte", $get))
		{
			$validSchwerpunkte = array();
			$allSchwerpunkte = getSchwerpunkte();
			$querySchwerpunkte = $get['schwerpunkte'];
			foreach($allSchwerpunkte as $aspValue)
			{
				if(in_array(strtolower($aspValue['name']), $querySchwerpunkte))
				{
					array_push($validSchwerpunkte, strtolower($aspValue['name']));
				}
			}
			if(count($validSchwerpunkte) > 0)
			{
				//array_push($validGET, $validSchwerpunkte);
				$validGET['schwerpunkte'] = $validSchwerpunkte;
			}
		}
		
		if(array_key_exists("themen", $get))
		{
			$validThemen = array();
			$allThemen = getThemen();
			$queryThemen = $get['themen'];
			foreach($allThemen as $athValue)
			{
				if(in_array(strtolower($athValue['name']), $queryThemen))
				{
					array_push($validThemen, strtolower($athValue['name']));
				}
			}
			if(count($validThemen) > 0)
			{
				//array_push($validGET, $validSchwerpunkte);
				$validGET['themen'] = $validThemen;
			}
		}
		
		if(array_key_exists("rating", $get))
		{
			$validGET['rating'] = validRating($get['rating']);
		}
		//print_r($validGET);
		
		return $validGET;
	}
?>
