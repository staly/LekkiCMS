<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Informations about this module
	function shoutbox_info() {
		return array(
			'name'	=>	'Shoutbox',
			'description'	=>	'Lekki czat na stronę',
			'author'	=>	'MaTvA',
			'version'	=>	'0.1',
			'add2nav'	=>	FALSE
		);
	}
	
	//Installation
	function shoutbox_install() {
		global $db;
		$tablename = 'shoutbox_posts';
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'content'),array('name'=>'date_added'),array('name'=>'author_name'),array('name'=>'author_ip'),array('name'=>'author_agent'));
		if (!$db->_table_exists('db', $tablename)){
		    $db->create_table($tablename,$fields);
		}
	}
	
	//Uninstallation
	function shoutbox_uninstall() {
		global $db;
		$db->drop_table('shoutbox_posts');
	}

?>
