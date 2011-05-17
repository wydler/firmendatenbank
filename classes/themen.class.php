<?php
	class Themen
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
			
			$result = mysql_query("SELECT * FROM themen ORDER BY name ASC") or die(mysql_error());
			
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
		function getByFID($fid)
		{
			$array = array();
			
			$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk WHERE fid_fk=$fid GROUP BY tid") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
		
			return $array;
		}
		
		/*
		 * Sucht alle Themen die den String $name beinhalten.
		 *
		 * $name = Suchstring
		 */
		function getByName($name)
		{
			$array = array();
			
			$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk WHERE name='$name' GROUP BY tid") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
		
			return $array;
		}
		
		/*
		 * Gibt die 10 haeufigsten Themen zurueck.
		 * Falls $max gesetzt ist, werden die $max-haeufigsten
		 * Themen zurueckegeben.
		 *
		 * $limit = Anzahl Elemente (Default = NULL)
		 */
		function getTop10($limit = 10)
		{
			$array = array();
			
			$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk GROUP BY tid ORDER BY count DESC,name ASC LIMIT $limit") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
		
			return $array;
		}
	}
?>
