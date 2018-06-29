<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');

if(is_admin($my_membre)):

	liste_courriel();
	
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	//redirect('../connexion.php');
endif;
?>