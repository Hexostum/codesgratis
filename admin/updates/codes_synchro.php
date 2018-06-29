<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');
if(1 /**$my_membre->membre_pseudo=='finalserafin'**/):
	$res = mysql_query('SELECT code_id,count(code_qte) as code_qte2 FROM codesgratis_commande WHERE commande_livraison > 0 GROUP BY code_id');
	while($sql_code = mysql_fetch_array($res)):
		mysql_query('UPDATE codesgratis_codes_designation SET code_vendus='.$sql_code['code_qte2'].' WHERE code_id='.$sql_code['code_id']);
		echo mysql_error();
		echo FP_LIGNE . '<br><hr>';
	endwhile;
endif;
?>