<?php

	defined('IN_LCMS') or exit('Access denied!');

	function mp3_info() {
		return array(
			'name'	=>	'mp3',
			'description'	=>	'MP3 Lista',
			'author'	=>	'Wipstudio',
			'version'	=>	'1.0',
			'add2nav'	=>	TRUE
		);
	}

	function mp3_install() {
		global $db;
		$tablename = 'mp3';
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'mp3'),array('name'=>'opis'));
		if (!$db->_table_exists('db', $tablename)){
			if($db->create_table($tablename,$fields)){
				$newRecord = array(NULL,'test.mp3','7 dni');
				$db->insert($tablename, $newRecord);
			}
		}
}

	function mp3_uninstall() {
		global $db;
		$db->drop_table('mp3');
	}
	
?>
