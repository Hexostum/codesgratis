<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'membres' . '.php');

if($my_membre->statut()):
	if(isset($_POST['submit_config'])):
		if($_POST['config']==1):
			remove_option($my_membre,'no_lettres_maj');
		else:
			set_option($my_membre,'no_lettres_maj');
		endif;
	endif;
	$config_value = option($my_membre,'no_lettres_maj');
	
	$config_non = ($config_value) ? ' selected': '';
	$config_oui = ($config_value) ? '' : ' selected';
	
	$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th>Modification de votre configuration concernant la reception de la lettre de mise à jour</th></tr>';
	$contenu_texte[] = '<tr><td>Souhaitez-vous recevoir un courriel quand une mise à jour est postée sur le site ?</td></tr>';
	$contenu_texte[] = '<tr><td><select name="config" id="config"><option value="1"'.$config_oui.'>Oui</option><option value="0"'.$config_non.'>Non</option></select></td></tr>';
	$contenu_texte[] = '<tr><td><input type="submit" name="submit_config" id="submit_config" value="Modifier"></td></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>