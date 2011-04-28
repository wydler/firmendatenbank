<?php 
	include 'index.inc.php';
	$page = new Page();

	if(array_key_exists("fid", $_POST))
	{
		$result = $page->firmen->addBewertung();
	}
?>
