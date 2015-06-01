<?php

defined('IN_LCMS') or exit('Access denied!');
$core->replace('{{mp3}}',mp3());

function mp3 () {

        global $lang, $db, $core;
        $result = NULL;
        $query = $db->select('mp3');
		
		$result ='<div>';
	
	 foreach($query as $record) {
     $result .='<div style="float:left;padding:15px;"><h2>'.$record['opis'].'</h2><br><br><audio controls>  <source src="../mp3/'.$record['mp3'].'" type="audio/mpeg"></audio></div>';}
$result .='</div>';

			return $result;
}
	
?>
