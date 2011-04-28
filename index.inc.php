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
			
			session_start();
			
			if(isset($_SESSION) && (count($_GET) == 0))
			{
				$this->validGET = $_SESSION;
			}
			else
			{
				$this->validGET = $this->validateGET();
			}
		}
		
		function __destruct() {
			mysql_close();
		}
		
		function clearFilter()
		{
			$_SESSION = array();
			$this->validGET = array();
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
		
		function addBewertung()
		{
			$bewertung = $_POST['rating'];
			$kommentar = $_POST['text'];
			$fid = $_POST['fid'];
			if($bewertung >= 0 && $bewertung <= 5 && strlen($kommentar) <= 50)
			{
				mysql_query("INSERT INTO bewertungen (bewertung, kommentar, gehoertzu_fid_fk) VALUES ($bewertung, '{$kommentar}', $fid)") or die(mysql_error());
				
				$array = array();
				$result = mysql_query("SELECT count(bewertung) as cnt, avg(bewertung) as avg FROM bewertungen WHERE gehoertzu_fid_fk = $fid") or die(mysql_error());
				while($row = mysql_fetch_assoc($result))
				{
					$array = $row;
				}
				
				mysql_query("UPDATE firmen SET bew_cnt = {$array['cnt']} WHERE fid = $fid") or die(mysql_error());
				mysql_query("UPDATE firmen SET bew_avg = {$array['avg']} WHERE fid = $fid") or die(mysql_error());
				
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		function getBewertungen($fid, $limit = NULL)
		{
			$array = array();
			$result = mysql_query("SELECT * FROM bewertungen WHERE gehoertzu_fid_fk = $fid ORDER BY bid DESC") or die(mysql_error());
			while($row = mysql_fetch_assoc($result))
			{
				array_push($array, $row);
			}
		
			return $array;
		}
		
		function getFirmen() 
		{
			$array = array();
			$query = "SELECT f.* FROM firmen f, behandelt b, themen t, decktab d, studienschwerpunkte s WHERE f.fid=b.fid_fk AND t.tid=b.tid_fk AND f.fid=d.fid_fk AND s.sid=d.sid_fk ";
			
			$schwerpunkte = $this->validGET['schwerpunkte'];
			if(isset($schwerpunkte))
			{
				$query .= "AND ";
				foreach($schwerpunkte as $schwerpunkt)
				{
					$query .= "s.name = '{$schwerpunkt}' ";
				}
			}
			$themen = $this->validGET['themen'];
			if(isset($themen))
			{
				foreach($themen as $thema)
				{
					$query .= "AND t.name = '{$thema}' ";
				}
			}
			
			$rating = $this->validGET['rating'];
			if(isset($rating))
			{
				$query .= "AND f.bew_avg > {$rating} ";
			}
			
			$page = $this->validGET['page'];
			if(isset($page))
			{
				if($page == 'Alle')
				{
					//$result = mysql_query("SELECT * FROM firmen") or die(mysql_error());
				}
				else
				{
					$query .= "AND f.name REGEXP '^[$page]' ";
					//$result = mysql_query("SELECT * FROM firmen WHERE name REGEXP '^[$page]'") or die(mysql_error());
				}
			}
			
			$query .= "GROUP BY f.name";
			
			echo $query;
			/*
			else
			{
				$result = mysql_query("SELECT * FROM firmen") or die(mysql_error());
			}
			*/
			
			$result = mysql_query($query) or die(mysql_error());
			
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
	
		function getThemen($fid = NULL) 
		{
			if(isset($fid))
			{
				$array = array();
				$result = mysql_query("SELECT * FROM themen LEFT JOIN behandelt ON tid=tid_fk WHERE fid_fk=$fid") or die(mysql_error());
				while($row = mysql_fetch_array($result))
				{
					array_push($array, $row);
				}
			
				return $array;
			}
			
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
		
		function getThemenCount()
		{
			$result = mysql_query("SELECT COUNT(*) as count FROM themen") or die(mysql_error());
			
			while ($row = mysql_fetch_assoc($result)) {
				return $row["count"];
			}
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
	
		function getSchwerpunkte($fid = NULL)
		{
			if(isset($fid))
			{
				$array = array();
				$result = mysql_query("SELECT * FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk WHERE fid_fk=$fid") or die(mysql_error());
				while($row = mysql_fetch_array($result))
				{
					array_push($array, $row['name']);
				}
			
				return $array;
			}
			
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
		
			if(array_key_exists("fid", $get))
			{
				$allFirmen = $this->getFirmen();
				foreach($allFirmen as $firma)
				{
					if($firma['fid'] == $get['fid'])
					{
						$_SESSION['fid'] = $get['fid'];
						$validGET['fid'] = $get['fid'];
					}
				}
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
					$_SESSION['schwerpunkte'] = $validSchwerpunkte;
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
					$_SESSION['themen'] = $validThemen;
					$validGET['themen'] = $validThemen;
				}
			}
		
			if(array_key_exists("rating", $get))
			{
				$_SESSION['rating'] = $this->validRating($get['rating']);
				$validGET['rating'] = $this->validRating($get['rating']);
			}
			
			if(array_key_exists("page", $get))
			{
				$_SESSION['page'] = $get['page'];
				$validGET['page'] = $get['page'];
			}
			
			if(array_key_exists("showallthemen", $get))
			{
				$_SESSION['showallthemen'] = $_GET['showallthemen'];
				$validGET['showallthemen'] = $_GET['showallthemen'];
			}
			
			#print_r($validGET);
			
			return $validGET;
		}
	}
?>
