<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

$page_titre .= ' - classement des membres. ';

$infos = sql_limiteur(
	array
	(
		'unit_par_page' => 50,
		'table' => 'codesgratis_membres',
		'table_compteur'=> 'membre_id'
	)
);

$retour = mysql_query('SELECT * FROM codesgratis_membres ORDER BY membre_points_vip DESC LIMIT ' . $infos['limit']);

$sql_membres = array();
while($sql_membre = mysql_fetch_array($retour)):
	$sql_membres[] = new fp_membre_sql($sql_membre);
endwhile;
unset($sql_membre);

if(isset($_GET['page'])):
	if(intval($_GET['page'])==0):
		header('Location: classement.php');
		exit();
	else:
		$page_titre .= ' [page : '.(intval($_GET['page'])+1).'] ';
	endif;
else:
	$page_titre .= ' [première page]';
endif;	

if(count($sql_membres)>0):
	$contenu_texte[] = '<h1>Le classement des membres de CodesGratis !</h1>';
	$contenu_texte[] = '<p>Le tableau suivant classe les membres de CodesGratis suivant le nombre de points détenus : </p>';
	$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th>Joueur</th>';
	$contenu_texte[] = '<th>Nombre de points</th>';
	$contenu_texte[] = '<th>Date d\'inscription</th>';
	$contenu_texte[] = '<th>Dernière connexion</th>';
	$contenu_texte[] = '</tr>';
	
	foreach($sql_membres as $sql_membre):	
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>';
		$contenu_texte[] = membre_pseudo($sql_membre->membre_id);
		$contenu_texte[] = membre_avatar($sql_membre);
		$contenu_texte = array_merge($contenu_texte,membre_vip($sql_membre));
		$contenu_texte [] =  '</td>';
		$contenu_texte [] =  '<td>' . $sql_membre->membre_points. '</td>';
		$contenu_texte [] =  '<td>' . format_date($sql_membre->membre_inscription) . '</td>';
		$contenu_texte [] =  '<td>' . format_date($sql_membre->membre_connexion) . '</td>';
		$contenu_texte [] =  '</tr>';
	endforeach;
	$contenu_texte[]  = '</table>';
	$contenu_texte = array_merge ($contenu_texte, $infos['pagination']);
	
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: index.php');
	exit();
endif;
?>