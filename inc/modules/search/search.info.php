<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');
	
	//Load lang file of this module
	require('../'.LANG.'admin/search.php');

	//Informations about this module
	function search_info() {
		global $lang;
		return array(
			'name'	=>	$lang['search']['search name'],
			'description'	=>	$lang['search']['search desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.2',
			'add2nav'	=>	FALSE
		);
	}
	
	//Installation
	function search_install() {
		global $db, $lang;
		$ex = explode('/', LANG);
		$ex = explode('_', $ex[2]);
		$newRecord = array(NULL, $lang['search']['search result'], '{{search.result}}','0','none',$ex[0],'1','0','0','template.html');
		$db->insert('pages', $newRecord);
	}

	//Uninstallation
	function search_uninstall() {
		global $db;
		if($query = $db->select('pages', array('content'=>'{{search.result}}'))) {
			foreach($query as $record) {
				$db->delete('pages', array('id'=>$record['id']));
			}
		}
	}
	
?>
