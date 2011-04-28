<?php
	include 'classes/validator.inc.php';
	include 'classes/firmen.inc.php';
	include 'classes/schwerpunkte.inc.php';
	include 'classes/themen.inc.php';
	
	class Page {
		public $validGET;
		
		public $validator;
		public $firmen;
		public $schwerpunkte;
		public $themen;
		
		function __construct() {
			$dbhost = "neptun.fbe.fh-weingarten.de:3306";
			$dbname = "webprog_07";
			$dbuser = "webprog_07";
			$dbpass = "webprog_07";
	
			mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
			mysql_select_db($dbname) or die(mysql_error());
			
			$this->validator = new Validator();
			$this->firmen = new Firmen();
			$this->schwerpunkte = new Schwerpunkte();
			$this->themen = new Themen();
			
			session_start();
			
			if(isset($_SESSION) && (count($_GET) == 0))
			{
				$this->validGET = $_SESSION;
			}
			else
			{
				$this->validGET = $this->validator->validateGET($_GET);
			}
		}
		
		function __destruct()
		{
			unset($this->themen);
			unset($this->schwerpunkte);
			unset($this->firmen);
			unset($this->validator);
			
			mysql_close();
		}
		
		function clearFilter()
		{
			$_SESSION = array();
			$this->validGET = array();
		}
	}
?>
