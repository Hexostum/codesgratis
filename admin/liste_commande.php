<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'date' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');
error_reporting(E_ALL);
if(is_admin($my_membre)):
	$sql = 'SELECT codesgratis_commande.code_id, code_designation, codesgratis_codes_designation.code_cout, sum( code_qte ) as code_qtes'
        . ' FROM codesgratis_commande, codesgratis_codes_designation'
        . ' WHERE codesgratis_commande.code_id = codesgratis_codes_designation.code_id'
        . ' and `commande_livraison` IS NULL '
        . ' GROUP BY codesgratis_commande.code_id'
        . ' LIMIT 0 , 30';
		
	$res_sql = mysql_query($sql);
	$contenu_texte[] = '<table>';
	while($arr_sql = mysql_fetch_array($res_sql)):
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>'.$arr_sql['code_designation'].'</td>';
		$contenu_texte[] = '<td>'.$arr_sql['code_qtes'].'</td>';
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '</table>';
endif;
include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
?>