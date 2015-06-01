<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Informations about this module
	function hitcounter_info() {
		return array(
			'name'	=>	'Hit Counter',
			'description'	=>	'Wyświetla liczbę odwiedzin, kod licznika: {{hit.counter}}',
			'author'	=>	'Klocek',
			'version'	=>	'0.1',
			'add2nav'	=>	FALSE
		);
	}
	
	//Installation
	function hitcounter_install() {
		global $db;
		$tablename = 'hitcounter';
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'count'));
		if(!$db->_table_exists('db', $tablename)) {
		    $db->create_table($tablename, $fields);
		}
		$newRecord = array(NULL, '0');
		$db->insert($tablename, $newRecord);
	}

	//Uninstallation
	function hitcounter_uninstall() {
		global $db;
		$db->drop_table('hitcounter');
	}
	
?>
