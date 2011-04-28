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
			
			$result = mysql_query("SELECT *, COUNT(tid_fk) as count FROM themen LEFT JOIN behandelt ON tid=tid_fk GROUP BY tid") or die(mysql_error());
			
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
		function getByID($tid)
		{
			
		}
		
		/*
		 * Sucht alle Themen die den String $name beinhalten.
		 *
		 * $name = Suchstring
		 */
		function getByName($name)
		{
			
		}
		
		/*
		 * Gibt die 10 haeufigsten Themen zurueck.
		 * Falls $max gesetzt ist, werden die $max-haeufigsten
		 * Themen zurueckegeben.
		 *
		 * $max = Anzahl Elemente (Default = NULL)
		 */
		function getTop10($max = NULL)
		{
			
		}
		
		/*
		 * Wenn kein Argument uebergeben wird, werden alle Themen
		 * gezaehlt. Wenn ein Argument vorhanden ist, wird die Anzahl
		 * der Element in dem Array gezaehlt.
		 *
		 * $array = Liste mit Elementen (Default = NULL)
		 */
		function count($array = NULL)
		{
			
		}
	}
