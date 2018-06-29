<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

$page_titre .= ' - Membres en ligne du site'; 

$contenu_texte[] = '<h1>Qui est en ligne sur CodesGratis ?</h1>';
			
$retour4 = mysql_query('SELECT membre_id FROM codesgratis_sessions WHERE membre_id is not null AND session_date > ' . (time()-60*5) );

$ids = array();
while($donnees4 = mysql_fetch_array($retour4)):
	$ids[] = $donnees4['membre_id'];
endwhile;
if(count($ids)>0):
	
	$contenu_texte[] = '<p>Le tableau liste joueurs actuellement en ligne (sur la base des 5 dernières minutes). Un élan de ';
	$contenu_texte[] = 'générosité de votre part serait sympathique : il suffirait de cliquer sur leurs liens. =)</p>';

	$contenu_texte[] = '<table>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<th>Joueur</th>';
	$contenu_texte[] = '		<th>Nombre de points</th>';
	$contenu_texte[] = '		<th>Date d\'inscription</th>';
	$contenu_texte[] = '		<th>Dernière connexion</th>';
	$contenu_texte[] = '	</tr>';
	
	$retour = mysql_query("SELECT * FROM codesgratis_membres WHERE membre_id IN (". implode(' , ', $ids) ." ) ");
	
	while($sql_membre = mysql_fetch_array($retour , MYSQL_ASSOC) ):
		$ce_membre = new fp_membre_sql ($sql_membre);
	

		$contenu_texte[] = '	<tr>';
		$contenu_texte[] = '		<td>';
		$contenu_texte[] = membre_pseudo($ce_membre->membre_id);
		$contenu_texte[] = membre_avatar($ce_membre);
		$contenu_texte = array_merge($contenu_texte , membre_vip ($ce_membre));
		$contenu_texte[] = '		</td>';
		$contenu_texte[] = '		<td>' . $sql_membre['membre_points']. '</td>';
		$contenu_texte[] = '		<td>' . format_date( $sql_membre['membre_inscription']). '</td>';
		$contenu_texte[] = '		<td>' . format_date( $sql_membre['session_date']) . '</td>';
		$contenu_texte[] = '	</tr>';

	endwhile;
	$contenu_texte[] = '</table>';
else:
	$contenu_texte[] = '<p>Il n\'y a aucun membres connectés en ce moment sur le site.</p>';
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>