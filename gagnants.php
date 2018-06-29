<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'pagination.php');

$page_titre .= ' - Gagnants du site'; 

$contenu_texte[] = '<h1>Les gagnants sur CodesGratis !</h1>';
$contenu_texte[] = message ( 'Le tableau suivant liste les différents gains sur CodesGratis et leurs gagnants. Félicitations à nos heureux gagnants !' , FP_MESSAGE_INFOS ) ;

$infos = sql_limiteur(
	array
	(
		'unit_par_page' => 50,
		'table' => 'codesgratis_commande',
		'table_compteur'=> 'commande_id'
	)
);

$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
$contenu_texte[] = '<table>';
$contenu_texte[] = '	<tr>';
$contenu_texte[] = '		<th>Joueur</th>';
$contenu_texte[] = '		<th>Code</th>';
$contenu_texte[] = '		<th>Quantité</th>';
$contenu_texte[] = '		<th>Date de commande</th>';
$contenu_texte[] = '		<th>Date de livraison</th>';
$contenu_texte[] = '	</tr>';
$retour = mysql_query('SELECT * FROM codesgratis_commande ORDER BY commande_id DESC LIMIT ' . $infos['limit']);
			
while($donnees = mysql_fetch_array($retour)):
			
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td><a href="membre.php?_membre_id='.$donnees['membre_id'].'">' . $cache_membre_pseudo[$donnees['membre_id']]. '</a></td>';
	$contenu_texte[] = '		<td>' . $cache_code_designation[$donnees['code_id']]. '</td>';
	$contenu_texte[] = '		<td>' . $donnees['code_qte']. '</td>';
	$contenu_texte[] = '		<td>' . format_date ($donnees['commande_date']) . '</td>';
	$contenu_texte[] = '		<td>' . format_date ( $donnees['commande_livraison']) . '</td>';	
	$contenu_texte[] = '	</tr>';
endwhile;
$contenu_texte[] = '</table>';
$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>