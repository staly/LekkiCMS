<?php

	//Sprawdzanie, czy moduł wykonywany jest przez LCMS.
	defined('IN_LCMS') or exit('Access denied!');
	
	//Ładowanie plików językowych
	require(LANG.'googlesearch.php');
	
	//Wyświetlanie formularza modułu
	$core->replace('{{google.search}}','<form action="index.php" method="get" id="googlesearch"><input type="text" name="q" value="" placeholder="'.$lang['googlesearch']['search in google'].'"> <button type="submit" name="googlesearch">'.$lang['googlesearch']['search'].'</button></form>');
	
	//
	if(isset($_GET['googlesearch']) & isset($_GET['q'])) {
		header('Location: https://www.google.com/?q=site:'.$_SERVER['HTTP_HOST'].' '.$_GET['q'].'#q=site:'.$_SERVER['HTTP_HOST'].' '.$_GET['q']);
	}

?>
