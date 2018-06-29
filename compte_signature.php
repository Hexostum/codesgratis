<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
if($my_membre->statut()):
	if(isset($_POST['submit_signature'])):
		$my_membre->membre_signature = trim($_POST['signature']);
	endif;
	$contenu_texte[] = '<form action="#" method="post">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th>Modicifiation de votre signature</th></tr>';
	$contenu_texte[] = '<tr><td><div id="signature_infos">'.$my_membre->membre_signature.'</div></td></tr>';
	$contenu_texte[] = '<tr><td><textarea class="bbcode" name="signature" id="signature" style="width:99%">'.$my_membre->membre_signature.'</textarea></td></tr>';
	$contenu_texte[] = '<tr><td><input type="submit" name="submit_signature" id="submit_signature" value="Modifier"></td></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	$contenu_script [] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
	$contenu_script [] = '<script type="text/javascript" src="html/javascripts/bbcode.js"></script>';
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>