<?php
	include 'validator.class.php';
	include 'firmen.class.php';
	include 'schwerpunkte.class.php';
	include 'themen.class.php';
	
	class Page {
		public $validGET;
		
		public $validator;
		public $firmen;
		public $schwerpunkte;
		public $themen;
		
		/**
		 * Konstruktor, stellt die Datenbankverbindung her und erstellt
		 * die notwendigen Objekte.
		 */
		function __construct() {
			// Verbindungsdaten fuer die Datenbank
			$dbhost = "neptun.fbe.fh-weingarten.de:3306";
			$dbname = "webprog_07";
			$dbuser = "webprog_07";
			$dbpass = "webprog_07";
			
			// Datenkbankverbindung aufbauen
			mysql_connect($dbhost,$dbuser,$dbpass) or die("connect : ".mysql_error());
			// Datenbank auswaehlen
			mysql_select_db($dbname) or die("select_db : ".mysql_error());
			
			mysql_query("SET NAMES utf8") or die("setnames : ".mysql_error());
			
			// Objekte erstellen
			$this->validator = new Validator();
			$this->firmen = new Firmen();
			$this->schwerpunkte = new Schwerpunkte();
			$this->themen = new Themen();
			
			// Session erstellen
			session_start();
			
			/*
			 * Falls Filtereinstellungen in der Session gespeichert sind und
			 * keine $GET-Parameter vorhanden sind, werden die Filterein-
			 * stellungen aus der Session geladen.
			 */
			if(isset($_SESSION) && (count($_GET) == 0))
			{
				$this->validGET = $this->validator->validateGET($_SESSION);
			}
			else
			{
				$this->validGET = $this->validator->validateGET($_GET);
			}
		}
		
		/**
		 * Destruktor, loescht alle Objekte wieder und trennt die
		 * Datenbankverbindung.
		 */
		function __destruct()
		{
			// Objekte loeschen
			unset($this->themen);
			unset($this->schwerpunkte);
			unset($this->firmen);
			unset($this->validator);
			
			// Dabenkbankverbindung schliessen
			mysql_close();
		}
		
		/**
		 * Loescht alle Filtereinstellungen.
		 */
		function clearFilter()
		{
			// Session loeschen
			session_unset();
			// validGET loeschen
			$this->validGET = array();
		}
	}
?>
