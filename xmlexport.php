<?php 
	require_once 'index.inc.php';
	
	// Seitenobjekt erstellen
	$page = new Page();
	$get = $page->validGET;

	$array = array();
	$query = "SELECT f.name, f.strasse, f.standort, f.plz, f.url, f.email FROM firmen f ";
	
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
		$page = $get['page'];
		if($page == NULL || $page == 'Alle')
		{
			$query .= '';
		}
		else
		{
			$query .= "AND f.name REGEXP '^[$page]' ";
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
			$query .= "f.fid IN (SELECT fid_fk FROM behandelt b INNER JOIN themen t ON t.tid=b.tid_fk WHERE t.name=''))";
		}
	}
	
	$query .= "GROUP BY f.fid ORDER BY f.name ASC";
	
	$result = mysql_query($query) or die(mysql_error());
	
	$xml = new SimpleXMLElement("<?xml version='1.0' standalone='yes'?><firmen/>");
	
	while($data = mysql_fetch_assoc($result))
	{
		//Child mit den Inhalt des Spaltennamens füllen  
        $row = $xml->addChild('firma');
        foreach ($data as $key => $val){
            //Werte in das Child eintragen  
            $row->addChild($key,$val);
        }
	}
	
	header('Content-Type: text/xml');
	echo $xml->asXML();
	
	#header('Location: export.xml');
?>
