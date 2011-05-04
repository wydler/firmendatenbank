<?php
	class Firmen
	{
		/*
		 * Konstruktor, macht im moment noch gar nichts.
		 */
		function __construct()
		{
			
		}
		
		/*
		 * Dekonstruktor, macht im moment noch gar nichts.
		 */
		function __destruct()
		{
			
		}
		
		/*
		 * Gibt alle Themen aus der Datenbank zurueck.
		 */
		function getAll()
		{
			$array = array();
			
			$result = mysql_query("SELECT * FROM firmen ORDER BY name ASC") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
			
			return $array;
		}
		
		function getByFilter($get)
		{
			$array = array();
			$query = "SELECT f.* FROM firmen f INNER JOIN decktab d ON d.fid_fk=f.fid INNER JOIN studienschwerpunkte s ON s.sid=d.sid_fk INNER JOIN behandelt b ON b.fid_fk=f.fid INNER JOIN themen t ON t.tid=b.tid_fk ";
			
			if(array_key_exists("rating", $get))
			{
				$rating = $get['rating'];
				$query .= "WHERE f.bew_avg >= $rating ";
			}
			else
			{
				$query .= "WHERE f.bew_avg >= 0 ";
			}
			
			if(array_key_exists("page", $get))
			{
				$page = $get['page'];
				if($page == NULL || $page == 'Alle')
				{
					$query .= '';
				}
				else
				{
					$query .= "AND f.name REGEXP '^[$page]' ";
				}
			}
			
			if(array_key_exists("schwerpunkte", $get) || array_key_exists("themen", $get))
			{
				$schwerpunkte = array();
				if(isset($get['schwerpunkte']))
				{
					$schwerpunkte = $get['schwerpunkte'];
				}
				foreach($schwerpunkte as $schwerpunkt)
				{
					$query .= "AND f.fid IN (SELECT fid_fk FROM decktab d INNER JOIN studienschwerpunkte s ON s.sid=d.sid_fk WHERE s.name='$schwerpunkt')";
				}
				
				$themen = array();
				if(isset($get['themen']))
				{
					$themen = $get['themen'];
				}
				foreach($themen as $thema)
				{
					$query .= "AND f.fid IN (SELECT fid_fk FROM behandelt b INNER JOIN themen t ON t.tid=b.tid_fk WHERE t.name='$thema')";
				}
			}
			
			$query .= "GROUP BY f.fid ORDER BY f.name ASC";
			
			#echo $query;
			
			$result = mysql_query($query) or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
			
			return $array;
		}
		
		/*
		 * Sucht nach einem Thema mit der ID $tid in der Datenbank.
		 *
		 * $tid = ID des Themas
		 */
		function getByPk($fid)
		{
			$array = array();
			
			$result = mysql_query("SELECT * FROM firmen WHERE fid=$fid") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				return $row;
			}
			
			return 0;
		}
		
		/*
		 * Sucht alle Themen die den String $name beinhalten.
		 *
		 * $name = Suchstring
		 */
		function getByName($name)
		{
			$array = array();
			
			$result = mysql_query("SELECT * FROM firmen WHERE name='$name'") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
			
			return $array;
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
	}
?>
