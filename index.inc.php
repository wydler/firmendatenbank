<?php
	class Page {
		public $validGET;
		
		function __construct() {
			$dbhost = "neptun.fbe.fh-weingarten.de:3306";
			$dbname = "webprog_07";
			$dbuser = "webprog_07";
			$dbpass = "webprog_07";
	
			mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
			mysql_select_db($dbname) or die(mysql_error());
			
			$this->validGET = $this->validateGET();
		}
		
		function __destruct() {
			mysql_close();
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
	
		function getFirmen() 
		{
			static $array;
			if(isset($array)) {
				return $array;
			}
		
			$array = array();
			$result = mysql_query("SELECT * FROM firmen") or die(mysql_error());
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
		
			return $array;
		}
		
		function getFirma($fid)
		{
			$result = mysql_query("SELECT * FROM firmen WHERE fid = $fid") or die(mysql_error());
			
			$row = mysql_fetch_assoc($result);
			
			return $row;
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
		
		function getThemenTOP($limit = 3) 
		{
			static $array;
			if(isset($array)) {
				return $array;
			}
		
			$array = array();
			
			if($this->validGET['showallthemen'] == 1)
			{
				$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk GROUP BY tid") or die(mysql_error());
			}
			else
			{
				$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk GROUP BY tid ORDER BY count DESC LIMIT $limit") or die(mysql_error());
			}
			
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
		
		function getSchwerpunkteFID($fid)
		{
			$array = array();
			$result = mysql_query("SELECT * FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk WHERE fid_fk=$fid") or die(mysql_error());
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
			
			return $array;
		}
		
		function getThemenFID($fid)
		{
			$array = array();
			$result = mysql_query("SELECT * FROM themen LEFT JOIN behandelt ON tid=tid_fk WHERE fid_fk=$fid") or die(mysql_error());
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
		
			if(array_key_exists("fid", $get))
			{
				$validGET['fid'] = $get['fid'];
			}
			
			if(array_key_exists("schwerpunkte", $get) || array_key_exists("addschwerpunkt", $get))
			{
				$validSchwerpunkte = array();
				$querySchwerpunkte = array();
				
				$allSchwerpunkte = $this->getSchwerpunkte();
				
				if(array_key_exists("schwerpunkte", $get))
				{
					$querySchwerpunkte = $get['schwerpunkte'];
				}
				if(array_key_exists("addschwerpunkt", $get))
				{
					$addSchwerpunkt = $get['addschwerpunkt'];
				}
				if(array_key_exists("removeschwerpunkt", $get))
				{
					$removeSchwerpunkt = $get['removeschwerpunkt'];
				}
				
				foreach($allSchwerpunkte as $aspValue)
				{
					if(in_array(strtolower($aspValue['name']), $querySchwerpunkte) || strtolower($aspValue['name']) == strtolower($addSchwerpunkt))
					{
						if(strtolower($aspValue['name']) != strtolower($removeSchwerpunkt))
						{
							array_push($validSchwerpunkte, strtolower($aspValue['name']));
						}
					}
				}
				if(count($validSchwerpunkte) > 0)
				{
					$validGET['schwerpunkte'] = $validSchwerpunkte;
				}
			}
		
			if(array_key_exists("themen", $get) || array_key_exists("addthema", $get))
			{
				$validThemen = array();
				$queryThemen = array();
				
				$allThemen = $this->getThemen();
				
				if(array_key_exists("themen", $get))
				{
					$queryThemen = $get['themen'];
				}
				if(array_key_exists("addthema", $get))
				{
					$addThema = $get['addthema'];
				}
				if(array_key_exists("removethema", $get))
				{
					$removeThema = $get['removethema'];
				}
				
				foreach($allThemen as $athValue)
				{
					if(in_array(strtolower($athValue['name']), $queryThemen) || strtolower($athValue['name']) == strtolower($addThema))
					{
						if(strtolower($athValue['name']) != strtolower($removeThema))
						{
							array_push($validThemen, strtolower($athValue['name']));
						}
					}
				}
				if(count($validThemen) > 0)
				{
					$validGET['themen'] = $validThemen;
				}
			}
		
			if(array_key_exists("rating", $get))
			{
				$validGET['rating'] = $this->validRating($get['rating']);
			}
			
			if(array_key_exists("showallthemen", $get))
			{
				$validGET['showallthemen'] = $_GET['showallthemen'];
			}
			
			#print_r($validGET);
			
			return $validGET;
		}
	}
?>
