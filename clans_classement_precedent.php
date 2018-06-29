<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'clans' . '.php');

renouvellement_clan();

$page_titre .= ' - Clans - Classement du concours des clans';

$contenu_texte[] = '<h1>Classement du concours des clans !</h1>';			
$concours = array();
$clans = array();
$res_concours_a = mysql_query('SELECT * FROM codesgratis_concours ORDER BY concours_id DESC');
while($sql_concours_a = mysql_fetch_array($res_concours_a, MYSQL_ASSOC)):
	$concour = new fp_enregistrement_sql($sql_concours_a,'codesgratis_concours' , 'concours_id');
	$concours[$concour->concours_id] = $concour;
	$clans[$concour->clan_id_1] = $concour->clan_id_1;
	$clans[$concour->clan_id_2] = $concour->clan_id_2;
	$clans[$concour->clan_id_3] = $concour->clan_id_3;
endwhile;
unset($clans['']);
$res_clans = mysql_query('SELECT * from codesgratis_clans where clan_id in ('.implode($clans , ' , ').');');
echo mysql_error();
$sql_clans = array();
while($sql_clan = mysql_fetch_array($res_clans,MYSQL_ASSOC)):
	$clan = new fp_enregistrement_sql($sql_clan,'codesgratis_clans','clan_id');
	$sql_clans[$clan->clan_id] = $clan; 
endwhile;
$contenu_texte[] = '<table>';
foreach ($concours as $concour):
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>' . $concour->concours_id . '</td>';
	$contenu_texte[] = '<td>' . format_date($concour->concours_debut) . '</td>';
	$contenu_texte[] = '<td>' . format_date($concour->concours_fin) . '</td>';
	if($concour->concours_gain_1 > 0):
		$contenu_texte[] = '<td>'.$sql_clans[$concour->clan_id_1]->clan_nom.' ['.$concour->concours_gain_1.']</td>';
	else:
		$contenu_texte[] = '<td> Pas de gagnants </td>';
	endif;
	if($concour->concours_gain_2 > 0):
		$contenu_texte[] = '<td>'.$sql_clans[$concour->clan_id_2]->clan_nom.' ['.$concour->concours_gain_2.']</td>';
	else:
		$contenu_texte[] = '<td> Pas de gagnants </td>';
	endif;
	if($concour->concours_gain_3 > 0):
		$contenu_texte[] = '<td>'.$sql_clans[$concour->clan_id_3]->clan_nom.' ['.$concour->concours_gain_3.']</td>';
	else:
		$contenu_texte[] = '<td> Pas de gagnants </td>';
	endif;
	$contenu_texte[] = '</tr>'; 
endforeach;
$contenu_texte[] = '</table>';
/**
$id_precedent = $sql_concours_a['concours_id'] - 1;

$ce_concours = new fp_enregistrement('codesgratis_concours',$id_precedent,'concours_id');
			
if($ce_concours->statut()):
	$clan_gagnant = new fp_enregistrement('codesgratis_clans',$ce_concours->clan_id_1,'clan_id');
	if($clan_gagnant->statut()):
		$contenu_texte[] = '<p>Ce concours, dont le gain s\'élevait à ' . $ce_concours->concours_gain_1.' a été gagné par';
		$contenu_texte[] = $clan_gagnant->clan_nom .' ! Félicitations à notre clan victorieux !</p>';
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<th>Clan</th>';
		$contenu_texte[] = '<th>Origine</th>';
		$contenu_texte[] = '<th>Joueurs du clan</th>';
		$contenu_texte[] = '<th>Nombre de points</th>';
		$contenu_texte[] = '</tr>';
		
		$res_classement = mysql_query('SELECT * FROM codesgratis_concours_classements WHERE concours_id=\''. $ce_concours->concours_id .'\' ORDER BY concours_place');
				
		while($sql_classement = mysql_fetch_array($res_classement)):
	
			$ce_clan = new fp_enregistrement('codesgratis_clans',$sql_classement['clan_id'],'clan_id');
			
			$joueurs_clan = array();
					
			$res_clan_membres = mysql_query('SELECT membre_id,membre_pseudo FROM codesgratis_membres WHERE membre_clan_id='. $ce_clan->clan_id );
			while($sql_clan_membre = mysql_fetch_array($res_clan_membres)):
				$joueurs_clan[$sql_clan_membre['membre_id']] = $sql_clan_membre['membre_pseudo'];
			endwhile;
			
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<td>' . $ce_clan->clan_nom . '</td>';
			$contenu_texte[] = '<td>Fondé par ' . stripslashes($joueurs_clan[$ce_clan->membre_id]) . ', le  ' . date('d/m/Y à H\hi', $ce_clan->clan_fondation) . '</td>';
			$contenu_texte[] = '<td>' . implode(' , ' , $joueurs_clan) . '</td>';
			$contenu_texte[] = '<td>' . $ce_clan->clan_points; '</td>';
			$contenu_texte[] = '</tr>';
		endwhile;
	else:
		$contenu_texte[] = '<p>Aucun concours ne s\'est passé la semaine précédente.</p>';
	endif;
else:
	$contenu_texte[] = '<p>Aucun concours ne s\'est passé la semaine précédente.</p>';
endif;
	$contenu_texte[] = '</table>';
/**/
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');			
?>