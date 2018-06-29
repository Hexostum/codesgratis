<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

require_once(FP_CHEMIN_PHP . 'page_start' . '.php');

$sql_pub = new fp_enregistrement('codesgratis_pubs',intval($_GET['pub_id']),'pub_id');

if($sql_pub->statut()):
	header ('Location: ' . $sql_pub->pub_url);
endif;
?>