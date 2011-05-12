<?php
	class Schwerpunkte
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

		function getAll()
		{
			$array = array();

			$result = mysql_query("SELECT * FROM studienschwerpunkte ORDER BY name") or die(mysql_error());

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
			
			$result = mysql_query("SELECT *, COUNT(sid_fk) as count FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk WHERE fid_fk=$fid GROUP BY sid") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row['name']);
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
			
			$result = mysql_query("SELECT *, COUNT(sid_fk) as count FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk WHERE name='$name' GROUP BY sid") or die(mysql_error());
			
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
		function getTop10($limit = NULL)
		{
			$array = array();
			
			$result = mysql_query("SELECT *, COUNT(sid_fk) as count FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk GROUP BY sid ORDER BY count DESC LIMIT $limit") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row);
			}
		
			return $array;
		}
	}
?>
