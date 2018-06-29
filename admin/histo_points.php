<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start_admin' . '.php');

include(FP_CHEMIN_FONCTIONS . 'pagination' . '.php');
include(FP_CHEMIN_FONCTIONS . 'points' . '.php');
include(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');

if(is_admin($my_membre)):
	$membre_affiche=null;
	
	if(isset($_GET['membre_id'])):
		$membre_affiche = new fp_membre(intval($_GET['membre_id']),'membre_id');
	elseif(isset($_GET['membre_pseudo'])):
		$membre_affiche = new fp_membre("'" . $_GET['membre_pseudo'] . "'" ,'membre_pseudo');
	endif;
			
	if(is_object($membre_affiche)):
		afficher_historique($contenu_texte,$membre_affiche->membre_id);
	else:
		afficher_historique($contenu_texte);
	endif;
	include(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
endif;
?>
