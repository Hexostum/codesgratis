<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'points.php');
include_once(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Historique de vos gains de points.</h1>';
	afficher_historique($contenu_texte,$my_membre->membre_id);
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;
?>