<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'cache.php');
if(is_admin($my_membre)):
	cache
	(
		array
		(
			'nom_cache' => 'code_designation',
			'champ_clef' => 'code_id',
			'champ_valeur' => 'code_designation',
			'table' => 'codesgratis_codes_designation'
		)
	);
endif;
?>