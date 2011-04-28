<?php
	class Validator 
	{
		public $validGET;
		
		/*
		 * Konstruktor, macht im moment noch gar nichts.
		 */
		function __construct() {
			
		}
		
		/*
		 * Dekonstruktor, macht im moment noch gar nichts.
		 */
		function __destruct() {
			
		}
		
		/*
		 * Prueft ob die uebergebene Zahl eine gueltige Bewertung
		 * zwischen 0 und 5 ist. Wenn gültig, wird die Bewertung
		 * zurueckgegeben, ansonsten wird 0 zurueckgegeben.
		 *
		 * $num = Bewertung
		 */
		function validateRating($num)
		{
			if(is_numeric($num) && $num >= 0 && $num <= 4)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		function validateFirma($fid)
		{
			$firmen = $this->getFirmen();
			foreach($firmen as $firma)
			{
				if($firma['fid'] == $fid)
				{
					return TRUE;
				}
			}
			
			return FALSE;
		}
		
		function validatePage($regex)
		{
			$regexs = array('Alle', '0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			if(in_array($regex, $regexs))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		/*
		 * Prueft alle $_GET-Argument auf Korrektheit.
		 */
		function validateGET() {
			$validGET = array();
		
			if(array_key_exists("fid", $_GET))
			{
				if($this->validateFirma($_GET['fid']))
				{
					$validGET['fid'] = $_GET['fid'];
				}
			}
			
			if(array_key_exists("schwerpunkte", $_GET) || array_key_exists("addschwerpunkt", $_GET))
			{
				$validSchwerpunkte = array();
				$querySchwerpunkte = array();
				
				$allSchwerpunkte = $this->getSchwerpunkte();
				
				if(array_key_exists("schwerpunkte", $_GET))
				{
					$querySchwerpunkte = $_GET['schwerpunkte'];
				}
				if(array_key_exists("addschwerpunkt", $_GET))
				{
					$addSchwerpunkt = $_GET['addschwerpunkt'];
				}
				if(array_key_exists("removeschwerpunkt", $_GET))
				{
					$removeSchwerpunkt = $_GET['removeschwerpunkt'];
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
		
			if(array_key_exists("themen", $_GET) || array_key_exists("addthema", $_GET))
			{
				$validThemen = array();
				$queryThemen = array();
				
				$allThemen = $this->getThemen();
				
				if(array_key_exists("themen", $_GET))
				{
					$queryThemen = $_GET['themen'];
				}
				if(array_key_exists("addthema", $_GET))
				{
					$addThema = $_GET['addthema'];
				}
				if(array_key_exists("removethema", $_GET))
				{
					$removeThema = $_GET['removethema'];
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
		
			if(array_key_exists("rating", $_GET))
			{
				if($this->validRating($_GET['rating']))
				{
					$_SESSION['rating'] = $_GET['rating'];
					$validGET['rating'] = $_GET['rating'];
				}
			}
			
			if(array_key_exists("page", $_GET))
			{
				if($this->validatePage($_GET['page']))
				{
					$_SESSION['page'] = $_GET['page'];
					$validGET['page'] = $_GET['page'];
				}
			}
			
			if(array_key_exists("showallthemen", $_GET))
			{
				if($_GET['showallthemen'] == 1 || $_GET['showallthemen'] == 0)
				{
					$_SESSION['showallthemen'] = $_GET['showallthemen'];
					$validGET['showallthemen'] = $_GET['showallthemen'];
				}
			}
			
			#print_r($validGET);
			
			return $validGET;
		}
	}
?>
