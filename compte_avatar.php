<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
if($my_membre->statut()):
	if(isset($_POST['submit_avatar'])):
		$my_membre->membre_avatar = trim($_POST['avatar_url']);
	endif;
	$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th>Modification de votre avatar</th></tr>';
	$contenu_texte[] = '<tr><td><img src="'.$my_membre->membre_avatar.'"></td></tr>';
	$contenu_texte[] = '<tr><td><input type="text" name="avatar_url" id="avatar_url" style="width:99%" value="'.$my_membre->membre_avatar.'"></td></tr>';
	$contenu_texte[] = '<tr><td><input type="submit" name="submit_avatar" id="submit_avatar" value="Modifier"></td></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>