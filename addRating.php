<?php 
	require_once 'index.inc.php';
	
	// Seitenobjekt erstellen
	$page = new Page();

	// Wenn es eine fid in den POST-Daten gibt, wird eine neue Bewertung erstellt.
	if(array_key_exists("fid", $_POST) && array_key_exists("text", $_POST))
	{
		$result = $page->firmen->addBewertung();
	}
?>
