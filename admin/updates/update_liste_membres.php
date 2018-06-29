<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'liste.php');
if(is_admin($my_membre)):
	liste_init
	(
		array
		(
			'nom_liste' => 'pseudo',
			'champ_clef' => 'membre_id',
			'champ_valeur' => 'membre_pseudo',
			'table' => 'codesgratis_membres'
		)
	);
endif;
?>