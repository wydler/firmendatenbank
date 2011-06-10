<?php 
	include 'classes/page.class.php';
	
	// Seitenobjekt erstellen
	$page = new Page();
	$get = $page->validGET;

	// SQL-Query generieren.
	$query = "SELECT f.fid, f.name, f.strasse, f.standort, f.plz, f.url, f.email FROM firmen f ";
	
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
		$char = $get['page'];
		if($char == NULL || $char == 'Alle')
		{
			$query .= ' ';
		}
		else
		{
			$query .= "AND f.name REGEXP '^[$char]' ";
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
			$query .= "AND f.fid IN (SELECT fid_fk FROM decktab d INNER JOIN studienschwerpunkte s ON s.sid=d.sid_fk WHERE s.name='$schwerpunkt') ";
		}
		
		$themen = array();
		if(isset($get['themen']))
		{
			$themen = $get['themen'];
			$query .= "AND (";
		}
		foreach($themen as $thema)
		{
			$query .= "f.fid IN (SELECT fid_fk FROM behandelt b INNER JOIN themen t ON t.tid=b.tid_fk WHERE t.name='$thema') OR ";
		}
		if(isset($get['themen']))
		{
			$query .= "f.fid IN (SELECT fid_fk FROM behandelt b INNER JOIN themen t ON t.tid=b.tid_fk WHERE t.name='')) ";
		}
	}
	
	$query .= "GROUP BY f.fid ORDER BY f.name ASC";
	
	// SQL-Query ausführen.
	$result = mysql_query($query) or die(mysql_error()." : ".$query);
	
	// XML-Objekt erzeugen.
	$xml = new SimpleXMLElement("<?xml version='1.0' standalone='yes'?><firmen xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"xml/firmendb.xsd\"/>");
	
	// Child-Knoten mit den Inhalt des Spaltennamens füllen  
	while($data = mysql_fetch_assoc($result))
	{
		// Werte in den Child-Knoten einfügen.
		$row = $xml->addChild('firma');
		foreach($data as $key => $val){
			if($key != "fid")
			{
				$row->addChild($key,$val);
			}
		}
		
		$schwerpunkte = $page->schwerpunkte->getByFID($data['fid']);
		if(count($schwerpunkte) > 0)
		{
			$row2 = $row->addChild('schwerpunkte');
			
			foreach($schwerpunkte as $schwerpunkt)
			{
				$row2->addChild("schwerpunkt",$schwerpunkt);
			}
		}
		
		$themen = $page->themen->getByFID($data['fid']);
		if(count($themen) > 0)
		{
			$row3 = $row->addChild('themen');
			
			foreach($themen as $thema)
			{
				$row3->addChild("thema",$thema['name']);
			}
		}
	}
	
	// Header-Typ auf XML ändern.
	header('Content-Type: text/xml');
	// XML-Objekt ausgeben.
	echo $xml->asXML();
	
	// Alternative zu Header-Typ ändern:
	// XML in neue Datei schreiben und dann die Datei öffnen.
	#header('Location: export.xml');
?>
