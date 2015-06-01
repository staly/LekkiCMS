<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Replace pattern by function
	$core->replace('{{hit.counter}}', hitcounter());

	//Main functions --------------------------------------
	function hitcounter() {
		global $db;
		
		if(!isset($_COOKIE['hitcounter'])) {
			if($query = $db->select('hitcounter', array('id'=>'1'))) {
				$record = $query[0];
				if($db->update('hitcounter', array('id'=>'1'), array('1',$record['count']+1))) {
					setcookie('hitcounter', '1');
				}
			}
		}
		
		if($query = $db->select('hitcounter', array('id'=>'1'))) {
			$record = $query[0];
			return $record['count'];
		}
	}

?>
