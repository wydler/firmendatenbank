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

		/**
		 * Gibt alle Schwerpunkte aus der Datenkbank zurueck.
		 */
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
		 * Sucht nach einem Schwerpunkt mit der ID $sid in der Datenbank.
		 *
		 * $sid = ID des Themas
		 */
		function getByFID($sid)
		{
			$array = array();
			
			$result = mysql_query("SELECT *, COUNT(sid_fk) as count FROM studienschwerpunkte LEFT JOIN decktab ON sid=sid_fk WHERE fid_fk=$sid GROUP BY sid") or die(mysql_error());
			
			while($row = mysql_fetch_array($result))
			{
				array_push($array, $row['name']);
			}
		
			return $array;
		}
		
		/*
		 * Sucht allen Schwerpunkte die den String $name beinhalten.
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
	}
?>
