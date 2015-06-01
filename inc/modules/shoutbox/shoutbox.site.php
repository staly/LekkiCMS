<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');
	
	//Replace pattern by function
	$core->replace('{{shoutbox}}', shoutbox());

	//Your functions --------------------------------------
	function shoutbox() {
		global $core, $db;
		$result = null;
		
		$core->append("
<script type='text/javascript'>
setInterval('getData();',3000);

var ObiektXMLHttp = false;
if (window.XMLHttpRequest) { 
   ObiektXMLHttp = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
   ObiektXMLHttp = new ActiveXObject('Microsoft.XMLHTTP');
}
function getData() { 
   if(ObiektXMLHttp) {
      ObiektXMLHttp.open('GET', 'sb_load.php');
      ObiektXMLHttp.onreadystatechange = function() {
          if (ObiektXMLHttp.readyState == 4) {
            document.getElementById('sb_load').innerHTML=ObiektXMLHttp.responseText;
         }
      }
      ObiektXMLHttp.send(null);
   }
} 
</script>

		", 'head');
		
		
		
		$result .= '<div class="sb_box">';
		
		if(isset($_SESSION['sb_'.$_SERVER['REMOTE_ADDR']])) {
			if(isset($_POST['sb_send'])) {
				if(!empty($_POST['sb_cont']) && mb_strlen($_POST['sb_cont']) <= 650) {
					$content = htmlspecialchars($_POST['sb_cont']);
					$date = date('Y-m-d H:i:s');
					$author_name = $_SESSION['sb_'.$_SERVER['REMOTE_ADDR']]['nick'];
					$author_ip = $_SERVER['REMOTE_ADDR'];
					$author_agent = $_SERVER['HTTP_USER_AGENT'];
					
					$newRecord = array(NULL, $content, $date, $author_name, $author_ip, $author_agent);
					if($db->insert('shoutbox_posts', $newRecord)) header('refresh: 0;');
				}
			}
			$result .= '<div id="sb_form">';
			$result .= '<form action="" method="post">';
			$result .= '<input type="text" name="sb_cont" id="sb_cont" value="" placeholder="Wpisz wiadomość, a nastepnie kliknij w wyślij.">';
			$result .= '<button type="submit" name="sb_send" id="sb_send">»</button>';
			$result .= '</form>';
			$result .= '</div><br>';
		} else {
			if(isset($_POST['sb_login'])) {
				if(!empty($_POST['sb_nick']) && mb_strlen($_POST['sb_nick']) >= 3 && mb_strlen($_POST['sb_nick']) <= 40) {
					if($_SESSION['sb_'.$_SERVER['REMOTE_ADDR']] = array('nick'=>htmlspecialchars($_POST['sb_nick']))) header('refresh: 0;');
				}
			}
			$result .= '<div id="sb_form">';
			$result .= '<form action="" method="post">';
			$result .= '<input type="text" name="sb_nick" id="sb_nick" value="" placeholder="Wprowadź swój nick, a następnie kontynuuj.">';
			$result .= '<button type="submit" name="sb_login" id="sb_login">»</button>';
			$result .= '</form>';
			$result .= '</div><br>';
		}
		
		$result .= '<div id="sb_load">';
		if($query = $db->select('shoutbox_posts')) {
			$i = 0;
			krsort($query);
			foreach($query as $record) {
				if($i < 10) $result .= '<div class="sb_post"><strong>'.$record['author_name'].'</strong> <span style="float:right">'.$record['date_added'].'</span> <div class="sb_post_cont">'.$record['content'].'</div></div>';
				$i++;
			}
		} else $result .= '<div class="sb_post">Brak wpisów.</div>';
		$result .= '</div></div>';
		
		return $result;
	}

?>
