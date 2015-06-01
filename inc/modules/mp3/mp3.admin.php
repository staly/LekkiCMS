<?php

	defined('IN_LCMS') or exit('Access denied!');
	$core->append(addHEAD(), 'head'); 
	
	function mp3_pages() {
		$pages[] = array(
			'func'  => 'lista',
			'title' => 'Zarządzanie utworami'
		);
		$pages[] = array(
			'func'  => 'nowa',
			'title' => 'Dodaj'
		);
		
		return $pages;
	}
	
// Lista 
	function lista() {
		global $lang, $db, $core;
		$result = NULL;
       
		if(isset($_GET['q']) && isset($_GET['id'])) {
			$condtion = array('id'=>$_GET['id']);
			$query = $db->select('mp3', $condtion);
			
			if($query) {
				if($_GET['q']=='edit') {
					if(isset($_POST['save'])) 
					
		
					{
					  /*Wprowadzone zmiany*/
                    if(empty($_POST['mp3'])) $_POST['mp3'] = $query[0]['mp3'];
                    /*Wprowadzone zmiany - koniec*/
					 
						if(!empty($_POST['mp3']) && !empty($_POST['opis'])  ) {
							$updateRecord = array($_POST['id'], $_POST['mp3'], $_POST['opis']);//htmlspecialchars_decode(str_replace(PHP_EOL, '\n', stripslashes//
							
							if($db->update('mp3', $condtion, $updateRecord)) {
								$core->notify('Pozycja została dodana',1);
							}
						}
					} else {
						$condtion = array('id'=>$_GET['id']);
						$query = $db->select('mp3', $condtion);
						$record = $query[0];
						$result .= mp3_form($record);
					}
				}

				if($_GET['q']=='del') {
					if($db->delete('mp3', $condtion)) {
						$core->notify('Pozycja została usunięta',1);
					}
				}
			} else $core->notify("The record doesn't exist",2);
		}

		$query = $db->select('mp3');
		$result .= '<table> <thead>';
		$result .= '<tr> <td>Plik</td><td>Opcje</td> </tr>';
		$result .= '</thead> <tbody>';
		foreach($query  as $record) {
			$result .= '<tr> <td>'.$record['opis'].'</td><td><a href="?go=mp3&q=edit&id='.$record['id'].'" class="icon">Z</a> <a href="?go=mp3&q=del&id='.$record['id'].'" class="icon">l</a></td> </tr>';
		}
		$result .= '</tbody> </table>';
		
		$result .= '<span class="info">opis jest edytowany po kliknięciu edytuj. KOD: {{mp3}}</span>';

		return $result;
	}
	
// Nowy
	function nowa() {
		global $lang, $db, $core;
		$result = NULL;

		$result = mp3_form();

			if(isset($_POST['save'])) {
						if(!empty($_POST['mp3'])  && !empty($_POST['opis']) )  {
							$newRecord = array($_POST['id'], $_POST['mp3'],$_POST['opis']);
				if($db->insert('mp3', $newRecord)) {
					$core->notify('Pozycja dodana',1); //1 - success, 2 - fail
				}
			} else {
				$core->notify("Pola nie mogą być puste",2); //1 - success, 2 - fail
			}
		}
		return $result;
	}
//dodawanie

			
 $plik_tmp = $_FILES['plik']['tmp_name']; 
$plik_nazwa = $_FILES['plik']['name']; 
if(is_uploaded_file($plik_tmp)) { 
   move_uploaded_file($plik_tmp, "../mp3/$plik_nazwa"); 
  echo "Plik: <strong>$plik_nazwa</strong><strong> przesłany na serwer!";
}
$_POST['mp3'] = $plik_nazwa; 
// formularz
	function mp3_form($data = array()) {

	    
		
		$result = '<form method="post" class="wysiwygform" name="upload" enctype="multipart/form-data">';
		$result .= '<input type="file" name="plik" value="'.@$data['mp3'].'" /><br><br>';
		$result .= '<label>Opis <span>Bla bla bla</span></label>';
	//$result .= '<div class="wysiwyg"><textarea name="opis" id="wysiwyg">'.htmlspecialchars(str_replace('\n', "\n",@$data['opis'])).'</textarea></div>';
		$result .= '<input type="text" name="opis" value="'.@$data['opis'].'" />';
		$result .= '<button type="submit" name="save">Zapisz</button>';
		if($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" />';
		$result .= '</form><br>';

		return $result;
	}
		
		function addHEAD() {
		global $core;

$head = '<style type="text/css">
			.LCMS form label {
				width: 12%;
			}
			.LCMS form input[type="text"], .LCMS form textarea {
				width: 80%;
			}
			.LCMS form input[type="submit"], .LCMS form button {
				margin-left: 14%;
			}
			.LCMS form textarea {
				height: 164px;
			}
			.LCMS form .wysiwyg {
				float: left;
				width: 81.5%;
				margin: 0px 0px 20px 10px;
			}
			.LCMS form .wysiwyg textarea {
				width: 100% !important;
				overflow: hidden;
				padding: 0px;
				margin: 0px;
				border: 0;
				font-size: 10pt;
			}
			.LCMS form .wysiwyg textarea:focus {
				box-shadow: none;
			}
		</style>';
	
			$head .= '<link rel="stylesheet" type="text/css" href="../inc/jscripts/CLEditor/jquery.cleditor.css" />
			<script type="text/javascript" src="../inc/jscripts/CLEditor/jquery.cleditor.min.js"></script>
			<script type="text/javascript">$(document).ready(function () { $("textarea").cleditor(); });</script>';
		
		return $head;
	}
	