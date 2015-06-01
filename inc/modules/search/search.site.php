<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require(LANG.'search.php');
	
	//Replace pattern by function
	$core->replace('{{search.form}}', search_form());
	$core->replace('{{search.result}}', search_result());

	//Main functions --------------------------------------
	function search_form() {
		global $core, $db, $lang;
		$action = NULL;
		
		if($query = $db->select('pages', array('content'=>'{{search.result}}'))) {
			foreach($query as $record) {
				if($record['lang'] == $_GET['lang']) $action = 'index.php?go='.$record['id'].'&lang='.$record['lang'];
			}
		}
		

		$result = '<form name="search" method="post" action="'.$action.'">';
		$result .= '<input type="text" name="search" value="'.htmlspecialchars(@$_POST['search']).'" />';
		$result .= '<button name="send">'.$lang['search']['search'].'</button>';
		$result .= '</form>';
		return $result;
	}
	
	function search_result() {
		global $core, $db, $lang;
		$result = NULL;
	
		if(isset($_POST['search'])) {
			if(empty($_POST['search']) || strlen($_POST['search'])<3) $result = $lang['search']['too short'];
			else {
				$search = htmlspecialchars(trim($_POST['search']));
				if($query = $db->select('pages')) {
					$count = 0;
					$result = '<ul>';
					foreach($query as $record) {
						if(strpos($record['title'],$search) !== false || strpos($record['content'],$search) !== false) {
							$result .= '<li><a href="index.php?go='.$record['id'].'&lang='.$record['lang'].'">'.$record['title'].'</a></li>';
							$count++;
						}
					}
					$result .= '</ul>';
					
					if(!$count) $result = $lang['search']['no result'];
				}
			}
		} else $result = $lang['search']['no result'];
		
		return $result;
	}

?>
