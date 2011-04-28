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
		
		/*
		 * Sucht nach einem Thema mit der ID $tid in der Datenbank.
		 *
		 * $tid = ID des Themas
		 */
		function getByID($fid)
		{
			$array = array();
			
			$result = mysql_query("SELECT * FROM firmen WHERE fid=$fid") or die(mysql_error());
			
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
			
			$result = mysql_query("SELECT * FROM firmen WHERE name='$name'") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
			
			return $array;
		}
	}
?>
