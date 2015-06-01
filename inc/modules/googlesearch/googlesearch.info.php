<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Informations about this module
	function googlesearch_info() {
		return array(
			'name'	=>	'Google Search',
			'description'	=>	'Lekka wyszukiwarka Google dla LCMS2',
			'author'	=>	'MaTvA',
			'version'	=>	'0.1',
			'add2nav'	=>	FALSE
		);
	}
	
?>
