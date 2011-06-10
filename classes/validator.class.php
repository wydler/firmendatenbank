<?php
	class Validator 
	{
		public $validGET;
		public $validPOST;
		
		private $firmen;
		private $schwerpunkte;
		private $themen;
		
		/**
		 * Erstellt die benoetigten Objekte.
		 */
		function __construct()
		{
			$this->firmen = new Firmen();
			$this->schwerpunkte = new Schwerpunkte();
			$this->themen = new Themen();
		}
		
		/**
		 * Zerstört alle erstellen Objekte wieder.
		 */
		function __destruct()
		{
			unset($this->firmen);
			unset($this->schwerpunkte);
			unset($this->themen);
		}
		
		/**
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
		
		/**
		 * Prueft, ob die Firma in der Datenbank vorhanden ist.
		 *
		 * $fid = Firmen-ID
		 */
		function validateFirma($fid)
		{
			$firmen = $this->firmen->getAll();
			foreach($firmen as $firma)
			{
				if($firma['fid'] == $fid)
				{
					return TRUE;
				}
			}
			
			return FALSE;
		}
		
		/**
		 * Prueft, ob ein gueltiger Anfangsbuchstabe gegeben ist.
		 *
		 * $regex = Regular-Expression
		 */
		function validatePage($regex)
		{
			$regexs = array('Alle', '0-9', 'AÄ', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'OÖ', 'P', 'Q', 'R', 'S', 'T', 'UÜ', 'V', 'W', 'X', 'Y', 'Z');
			if(in_array($regex, $regexs))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		/**
		 * Validiert alle $POST-Daten für neue Bewertungen.
		 *
		 * $post = POST-Daten
		 */
		function validateRatingPOST($post)
		{
			$validPOST = array();
			
			// Firmen-ID prüfen.
			if(array_key_exists("fid", $post))
			{
				if($this->validateFirma($post['fid']))
				{
					$validPOST['fid'] = $post['fid'];
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
			
			// Bewertung prüfen.
			if(array_key_exists("rating", $post))
			{
				if($post['rating'] >= 1 && $post['rating'] <= 5)
				{
					$validPOST['rating'] = $post['rating'];
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
			
			// Bewertungstext prüfen.
			if(array_key_exists("text", $post))
			{
				$text = $post['text'];
				
				if(strlen($text) <= 50)
				{
					// SQL-Kommandos escapen.
					$tmp = mysql_real_escape_string($text);
					// HTML-Kommandos escapen.
					$tmp2 = htmlentities($tmp);
					
					$validPOST['text'] = $tmp2;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
			
			return $validPOST;
		}
		
		/**
		 * Prueft alle $get-Argument auf Korrektheit.
		 *
		 * $get = GET-Daten
		 */
		function validateGET($get)
		{
			$validGET = array();
			
			if(array_key_exists("fid", $get))
			{
				if($this->validateFirma($get['fid']))
				{
					$validGET['fid'] = $get['fid'];
				}
			}
			
			if(array_key_exists("schwerpunkte", $get) || array_key_exists("addschwerpunkt", $get))
			{
				$allSchwerpunkte = array();
				$validSchwerpunkte = array();
				$querySchwerpunkte = array();
				$addSchwerpunkt = '';
				$removeSchwerpunkt = '';
				
				$allSchwerpunkte = $this->schwerpunkte->getAll();
				
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
				else
				{
					unset($_SESSION['schwerpunkte']);
				}
			}
		
			if(array_key_exists("themen", $get) || array_key_exists("addthema", $get))
			{
				$allThemen = array();
				$validThemen = array();
				$queryThemen = array();
				$addThema = '';
				$removeThema = '';
				
				$allThemen = $this->themen->getAll();
				
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
				else
				{
					unset($_SESSION['themen']);
				}
			}
		
			if(array_key_exists("rating", $get))
			{
				if($this->validateRating($get['rating']))
				{
					$_SESSION['rating'] = $get['rating'];
					$validGET['rating'] = $get['rating'];
				}
			}
			
			if(array_key_exists("page", $get))
			{
				if($this->validatePage($get['page']))
				{
					$_SESSION['page'] = $get['page'];
					$validGET['page'] = $get['page'];
				}
			}
			
			if(array_key_exists("showallthemen", $get))
			{
				if($get['showallthemen'] == 1 || $get['showallthemen'] == 0)
				{
					$_SESSION['showallthemen'] = $get['showallthemen'];
					$validGET['showallthemen'] = $get['showallthemen'];
				}
			}
			
			return $validGET;
		}
	}
?>
