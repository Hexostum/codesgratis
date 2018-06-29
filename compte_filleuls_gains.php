<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Récapitulatif de vos gains grâce à vos filleuls</h1>';
	switch(@$_GET['mode']):
	
		case 'mois':
			$contenu_texte[] = '<p>Le tableau suivant liste vos filleuls avec les gains (pas toujours fiables à 100%, si votre filleul ';
			$contenu_texte[] = 'est lui-même parrain) qu\'ils vous ont occasionnés depuis leur ';
			$contenu_texte[] = 'inscription, et aujourd\'hui.</p>';
			
			$contenu_texte[] = '<br>';
			
			$contenu_texte[] = '<ul class="menu_h">';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php">Gains totaux</a></li>';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php?mode=mois">Gains du mois</a></li>';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php?mode=jour">Gains du jour</a></li>';
			$contenu_texte[] = '</ul>';
			
			$contenu_texte[] = '<br>';
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<th>Filleul</th>';
			$contenu_texte[] = '<th colspan="5">Gains du mois</th>';
			$contenu_texte[] = '</tr>';
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<th></th>';
			$contenu_texte[] = '<th>Affichages</th>';
			$contenu_texte[] = '<th>Clics rémunérés</th>';
			$contenu_texte[] = '<th>Jeu de hasard</th>';
			$contenu_texte[] = '<th>Tombola</th>';
			$contenu_texte[] = '<th>Concours</th>';
			$contenu_texte[] = '</tr>';

			$retour = mysql_query('SELECT * FROM codesgratis_membres WHERE membre_parrain_id='. $my_membre->membre_id .' ORDER BY membre_vip');
			if(mysql_num_rows($retour) > 0):
				while($donnees = mysql_fetch_array($retour)):
					$ce_filleul = new fp_membre_sql($donnees);
		
					if($ce_filleul->parrain_mois_courant != date('dmY')):
						$ce_filleul->parrain_mois_courant= date('dmY') ;
						$ce_filleul->parrain_gain_mois_affichages=0;
						$ce_filleul->parrain_gain_mois_clics=0;
						$ce_filleul->parrain_gain_mois_jeu_hasard=0;
						$ce_filleul->parrain_gain_mois_tombola=0;
						$ce_filleul->parrain_gain_mois_concours=0;
					endif;
					$contenu_texte[] = '<tr>';
					$contenu_texte[] = '<td>';
					$contenu_texte[] = '<a href="pages.php?membre_id=' .  $ce_filleul->membre_id. '">';
					$contenu_texte[] = $ce_filleul->membre_pseudo;
					$contenu_texte[] = '<br>';			
					if($ce_filleul->membre_vip > 0):
						$contenu_texte[] = '<img src="html/images/vip/vip' .  $ce_filleul->membre_vip . '.png" alt="V.I.P. ' .  $ce_filleul->membre_vip.'">';
					else:
						$contenu_texte[] = '<img src="html/images/vip/non_vip.png" alt="Non V.I.P.">';
					endif;
					$contenu_texte[] = '</a>';
					$contenu_texte[] = '</td>';	
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_mois_affichages. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_mois_clics. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_mois_jeu_hasard. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_mois_tombola. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_mois_concours. '</td>';
					$contenu_texte[] = '</tr>';
				endwhile;
			else:
				$contenu_texte[] = '<p>Vous n\'avez pas de filleul. <a href="compte_filleuls.php">Découvrez ici comment en obtenir !</a></p>';
			endif;
			$contenu_texte[] = '</table>';
		break;
	
		case 'jour':
			$contenu_texte[] = '<p>Le tableau suivant liste vos filleuls avec les gains (pas toujours fiables à 100%, si votre filleul ';
			$contenu_texte[] = 'est lui-même parrain) qu\'ils vous ont occasionnés depuis leur ';
			$contenu_texte[] = 'inscription, et aujourd\'hui.</p>';
			
			$contenu_texte[] = '<br>';
			
			$contenu_texte[] = '<ul class="menu_h">';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php">Gains totaux</a></li>';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php?mode=mois">Gains du mois</a></li>';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php?mode=jour">Gains du jour</a></li>';
			$contenu_texte[] = '</ul>';
			
			$contenu_texte[] = '<br>';
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<th>Filleul</th>';
			$contenu_texte[] = '<th colspan="5">Gains du jour</th>';
			$contenu_texte[] = '</tr>';
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<th></th>';
			$contenu_texte[] = '<th>Affichages</th>';
			$contenu_texte[] = '<th>Clics rémunérés</th>';
			$contenu_texte[] = '<th>Jeu de hasard</th>';
			$contenu_texte[] = '<th>Tombola</th>';
			$contenu_texte[] = '<th>Concours</th>';
			$contenu_texte[] = '</tr>';

			$retour = mysql_query('SELECT * FROM codesgratis_membres WHERE membre_parrain_id='. $my_membre->membre_id .' ORDER BY membre_vip');
			if(mysql_num_rows($retour) > 0):
				while($donnees = mysql_fetch_array($retour)):
					$ce_filleul = new fp_membre_sql($donnees);
		
					if($ce_filleul->parrain_jour_courant != date('dmY')):
						$ce_filleul->parrain_jour_courant= date('dmY') ;
						$ce_filleul->parrain_gain_jour_affichages=0;
						$ce_filleul->parrain_gain_jour_clics=0;
						$ce_filleul->parrain_gain_jour_jeu_hasard=0;
						$ce_filleul->parrain_gain_jour_tombola=0;
						$ce_filleul->parrain_gain_jour_concours=0;
					endif;
					$contenu_texte[] = '<tr>';
					$contenu_texte[] = '<td>';
					$contenu_texte[] = '<a href="pages.php?membre_id=' .  $ce_filleul->membre_id. '">';
					$contenu_texte[] = $ce_filleul->membre_pseudo;
					$contenu_texte[] = '<br>';			
					if($ce_filleul->membre_vip > 0):
						$contenu_texte[] = '<img src="html/images/vip/vip' .  $ce_filleul->membre_vip . '.png" alt="V.I.P. ' .  $ce_filleul->membre_vip.'">';
					else:
						$contenu_texte[] = '<img src="html/images/vip/non_vip.png" alt="Non V.I.P.">';
					endif;
					$contenu_texte[] = '</a>';
					$contenu_texte[] = '</td>';	
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_jour_affichages. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_jour_clics. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_jour_jeu_hasard. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_jour_tombola. '</td>';
					$contenu_texte[] = '<td>' .  $ce_filleul->parrain_gain_jour_concours. '</td>';
					$contenu_texte[] = '</tr>';
				endwhile;
			else:
				$contenu_texte[] = '<p>Vous n\'avez pas de filleul. <a href="compte_filleuls.php">Découvrez ici comment en obtenir !</a></p>';
			endif;
			$contenu_texte[] = '</table>';
		break;
		
		default:
			$contenu_texte[] = '<p>Le tableau suivant liste vos filleuls avec les gains (pas toujours fiables à 100%, si votre filleul 
			est lui-même parrain) qu\'ils vous ont occasionnés depuis leur 
			inscription, et aujourd\'hui.</p>';
			
			$contenu_texte[] = '<br>';
			
			$contenu_texte[] = '<ul class="menu_h">';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php">Gains totaux</a></li>';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php?mode=mois">Gains du mois</a></li>';
			$contenu_texte[] = '<li><a href="compte_filleuls_gains.php?mode=jour">Gains du jour</a></li>';
			$contenu_texte[] = '</ul>';
			
			$contenu_texte[] = '<br>';

			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<th>Filleul</th>';
			$contenu_texte[] = '<th colspan="5">Gains depuis le 15 avril</th>';
			$contenu_texte[] = '</tr>';
				
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<th></th>';
			$contenu_texte[] = '<th>Affichages</th>';
			$contenu_texte[] = '<th>Clics rémunérés</th>';
			$contenu_texte[] = '<th>Jeu de hasard</th>';
			$contenu_texte[] = '<th>Tombola</th>';
			$contenu_texte[] = '<th>Concours</th>';
			$contenu_texte[] = '</tr>';

			$retour = mysql_query('SELECT * FROM codesgratis_membres WHERE membre_parrain_id='. $my_membre->membre_id .' ORDER BY membre_vip');
			if(mysql_num_rows($retour) > 0):
				while($donnees = mysql_fetch_array($retour)):
			
					$contenu_texte[] = '<tr>';
					$contenu_texte[] = '<td>';
					$contenu_texte[] = '<a href="pages.php?membre_id=' . $donnees['membre_id'] . '">';
					$contenu_texte[] = stripslashes($donnees['membre_pseudo']) . '';
					$contenu_texte[] = '<br>';
					
					if($donnees['membre_vip'] > 0):
					
						$contenu_texte[] = '<img src="html/images/vip/vip' . $donnees['membre_vip'] . '.png" alt="V.I.P. ' . $donnees['membre_vip'] . '">';
					
					else:
					
						$contenu_texte[] = '<img src="html/images/vip/non_vip.png" alt="Non V.I.P.">';
					
					endif;
					
					$contenu_texte[] = '</a>';
					$contenu_texte[] = '</td>';
					$contenu_texte[] = '<td>' . $donnees['parrain_gain_total_affichages'] . '</td>';
					$contenu_texte[] = '<td>' . $donnees['parrain_gain_total_clics'] . '</td>';
					$contenu_texte[] = '<td>' . $donnees['parrain_gain_total_jeu_hasard'] . '</td>';
					$contenu_texte[] = '<td>' . $donnees['parrain_gain_total_tombola'] . '</td>';
					$contenu_texte[] = '<td>' . $donnees['parrain_gain_total_concours'] . '</td>';
					$contenu_texte[] = '</tr>';
		
				endwhile;
			else:
				$contenu_texte[] = '<p>Vous n\'avez pas de filleuls. <a href="compte_filleuls.php">Découvrez ici comment en obtenir !</a></p>';
			endif;
			$contenu_texte[] = '</table>';
		break;
		
	endswitch;
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>