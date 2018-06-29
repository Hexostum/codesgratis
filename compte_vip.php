<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Les niveaux V.I.P. sur CodesGratis</h1>';
				
	$contenu_texte[] = '<h2>Votre niveau V.I.P.</h2>';
	if($my_membre->membre_vip == 0):
		$contenu_texte[] = '<p>Vous n\'êtes actuellement pas membre V.I.P. ; validez plus de CGcodes pour le devenir et profiter des avantages !</p>';
	else:
		$contenu_texte[] = '<p>Vous êtes V.I.P. de niveau '. $my_membre->membre_vip .' !</p>';
	endif;
	
	$points_vip = $my_membre->membre_points_vip;
				
	$contenu_texte[] = '<p>Vous avez actuellement <strong>'. $points_vip .'</strong> points vip.';		
	if($points_vip >= ($vip_codes2[10]) ):
		$contenu_texte[] = 'Vous n\'avez pour le moment plus la possibilité de monter dans les niveaux V.I.P. Vous avez accès la <a href="compte_fidelite.php">Carte de fidélité Codesgratis</a> .</p>';
	else:
		$nb_codes_a_valider = ($vip_codes2[$my_membre->membre_vip+1]) - $points_vip;
		$contenu_texte[] = 'Il vous reste <strong>'. $nb_codes_a_valider .'</strong> points vip à obtenir pour devenir V.I.P. de niveau '. ($my_membre->membre_vip + 1) .'.</p>';
	endif;
	$contenu_texte[] = '<h2>Comment fonctionnent les niveaux V.I.P. sur CodesGratis ?</h2>';
	$contenu_texte[] = '<p>Le niveau V.I.P. de chaque membre de CodesGratis évolue avec son nombre de points VIP (obtenu à chaque validation de cgcodes).</p>';
	$contenu_texte[] = '<h2>Quels sont les niveaux V.I.P., et leurs avantages ?</h2>';
	$contenu_texte[] = '<p>Il existe actuellement 10 niveaux V.I.P. sur CodesGratis.</p>';
	$contenu_texte[] = '<p>Voici le nombre de points VIP à atteindre, et les avantages dont bénéficie le membre V.I.P., selon le niveau :</p>';		
	$contenu_texte[] = '<br>';

	$contenu_texte[] = '<table>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<th>Niveau</th>';
	$contenu_texte[] = '		<th>Points VIP </th>';
	$contenu_texte[] = '		<th>Avantages points</th>';
	$contenu_texte[] = '		<th>Avantages parrainage</th>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 1</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[1].'</td>';
	$contenu_texte[] = '		<td>Pas d\'avantage au niveau des points.</td>';
	$contenu_texte[] = '		<td>Réduction de 0.5% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 2</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[2].'</td>';
	$contenu_texte[] = '		<td>1.2 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Réduction de 1% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 3</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[3].'</td>';
	$contenu_texte[] = '		<td>1.3 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Réduction de 1.5% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 4</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[4].'</td>';
	$contenu_texte[] = '		<td>1.4 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Réduction de 2% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 5</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[5].'</td>';
	$contenu_texte[] = '		<td>1.5 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Réduction de 2.5% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 6</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[6].'</td>';
	$contenu_texte[] = '		<td>1.6 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Réduction de 3% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 7</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[7].'</td>';
	$contenu_texte[] = '		<td>1.7 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Sans que vos filleuls y perdent, les points que vous gagnez sont en excès : 5% des ';
	$contenu_texte[] = '			gains de vos filleuls au jeu de hasard et 3% sur la tombola ; Réduction de 3.5% sur l\'achat ';
	$contenu_texte[] = '			des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 8</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[8].'</td>';
	$contenu_texte[] = '		<td>1.8 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Sans que vos filleuls y perdent, les points que vous gagnez sont en excès : 7% des ';
	$contenu_texte[] = '		gains de vos filleuls au jeu de hasard, 5% sur la tombola et 2% sur le concours des ';
	$contenu_texte[] = '		clans ; Réduction de 4% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 9</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[9].'</td>';
	$contenu_texte[] = '		<td>1.9 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Sans que vos filleuls y perdent, les points que vous gagnez sont en excès : 10% des ';
	$contenu_texte[] = '		gains de vos filleuls au jeu de hasard, 7% sur la tombola et 4% sur le concours des ';
	$contenu_texte[] = '		clans ; Réduction de 4.5% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>V.I.P. 10</td>';
	$contenu_texte[] = '		<td>'.$vip_codes2[10].'</td>';
	$contenu_texte[] = '		<td>2 points gagnés à l\'affichage de la page perso du joueur, au lieu de 1.</td>';
	$contenu_texte[] = '		<td>Sans que vos filleuls y perdent, les points que vous gagnez sont en excès : 15% des ';
	$contenu_texte[] = '		gains de vos filleuls au jeu de hasard, 10% sur la tombola et 7% sur le concours des ';
	$contenu_texte[] = '		clans ; Réduction de 5% sur l\'achat des filleuls.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '</table>';
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>