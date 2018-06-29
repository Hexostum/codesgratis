<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

$page_titre .= ' - Vitrine.';

$contenu_texte[] = '<h1>La vitrine de CodesGratis !</h1>';

$contenu_texte[] = message ( 'La vitrine de codesgratis est désactivée jusqu\'à la mise en place de la nouvelle version prévue' , FP_MESSAGE_INFOS);

/**			
$contenu_texte[] = message ( 'Voici la liste des codes disponibles à la commandes sur codesgratis' , FP_MESSAGE_INFOS ) ;
$contenu_texte[] = message ( 'Le délai des livraison peut varier de une semaine jusqu\'à un mois selon la disponibilité des codes chez le fournisseur' , FP_MESSAGE_INFOS ) ;

$contenu_texte[] = '<table>';
$contenu_texte[] = '<tr>';
$contenu_texte[] = '	<th>Code</th>';
$contenu_texte[] = '	<th>Valide sur le site :</th>';
$contenu_texte[] = '	<th>Coût en points</th>';

// $contenu_texte[] = '	<th>Stock</th>';

$contenu_texte[] = '	<th>Vendus</th>';
$contenu_texte[] = '</tr>';

$codes_res = mysql_query('SELECT * FROM codesgratis_codes_designation');
$codes = array();
while($sql_code = mysql_fetch_array($codes_res,MYSQL_ASSOC)):
	$codes[] = $sql_code;
endwhile;
foreach($codes as $code):
	$contenu_texte[] = '<tr>';
				
	$contenu_texte[] = '	<td>';

	if($code['code_actif'] && $my_membre->membre_existe()):
		$contenu_texte[] =  '<a href="commande.php?code_id='.$code['code_id'].'">'.$code['code_designation'].'</a>'; 
	else:
		$contenu_texte[] =  $code['code_designation'];
	endif;

	$contenu_texte[] = '</td>';
	$contenu_texte[] = '<td><a href="http://www.' .  $code['code_site']. '">' .  $code['code_site']. '</a></td>';
	$contenu_texte[] = '<td>';

	if($code['code_actif']):
		$contenu_texte[] =  $code['code_cout']; 
	else:
		$contenu_texte[] =  'ce code n\'est pas disponible dans la vitrine';
	endif;

	$contenu_texte[] = '</td>';
	
	// $contenu_texte[] = '	<td>' .  $code['code_stock']. '</td>';
	
	$contenu_texte[] = '	<td>' .  $code['code_vendus']. '</td>';
	$contenu_texte[] = '</tr>';

endforeach;
$contenu_texte[] = '</table>';
/**/
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');	
?>