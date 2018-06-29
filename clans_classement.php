<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'clans' . '.php');
renouvellement_clan();

$contenu_texte [] = '<h1>Le classement du concours actuel sur CodesGratis !</h1>';
$contenu_texte [] = '<p><a href="clans_classement_precedent.php">Cliquez ici pour prendre connaissance du classement';
$contenu_texte [] = 'de la semaine dernière.</a></p>';
$contenu_texte [] = '<p>Le tableau suivant classe les clans de CodesGratis selon le nombre de points qu\'ils possèdent :</p>';
$contenu_texte [] = '<table>';
$contenu_texte [] = '<tr>';
$contenu_texte [] = '<th>Clan</th>';
$contenu_texte [] = '<th>Origine</th>';
$contenu_texte [] = '<th>Joueurs du clan</th>';
$contenu_texte [] = '<th>Nombre de points</th>';
$contenu_texte [] = '</tr>';

$res_clans = mysql_query('SELECT * FROM codesgratis_clans WHERE clan_points > 0 ORDER BY clan_points DESC');
			
while($sql_clan = mysql_fetch_array($res_clans,MYSQL_ASSOC)):
	$ce_clan = new fp_enregistrement_sql($sql_clan,'codesgratis_clans','clan_id');
	
	if($ce_clan->membre_id!=null):
		$joueurs_clan = array();
		$i = 1;
				
		$res_clan_membres = mysql_query('SELECT membre_id,membre_pseudo FROM codesgratis_membres WHERE membre_clan_id=\''. $ce_clan->clan_id .'\'');
		while($sql_clan_membres = mysql_fetch_array($res_clan_membres)):
			$joueurs_clan[$sql_clan_membres['membre_id']] = $sql_clan_membres['membre_pseudo'];
		endwhile;

		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>' . $ce_clan->clan_nom .'</td>';
		$contenu_texte[] = '<td>Fondé par ' . stripslashes($joueurs_clan[$ce_clan->membre_id]).' , Le ' . date('d/m/Y à H\hi', $ce_clan->clan_fondation) . '</td>';
		$contenu_texte[] = '<td>' . implode(' , ',$joueurs_clan) . '</td>';
		$contenu_texte[] = '<td>' . $ce_clan->clan_points . '</td>';
		$contenu_texte[] = '</tr>';
	endif;
endwhile;
$contenu_texte[] = '</table>';
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>