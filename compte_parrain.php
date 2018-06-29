<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');


include_once(FP_CHEMIN_FONCTIONS . 'points.php');
include_once(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');

if($my_membre->membre_existe()):
	if($my_parrain->statut()):
		$contenu_texte[] = '<h1>Gains de votre parrain ' . $my_parrain->membre_pseudo . '.</h1>';
		afficher_historique($contenu_texte,$my_membre->membre_id,false);
	else:
		$contenu_texte[] = 'Vous n\'avez pas de parrain';
	endif;
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;
?>