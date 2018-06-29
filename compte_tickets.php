<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = message('Les tickets seront automatiquement convertis lors du passage à la nouvelle version prévue fin décembre 2011',FP_MESSAGE_INFOS);
	/**
	if(isset($_POST['submit_echanger'])):
		$qte_tickets = doubleval($_POST['qte_tickets']);
		$qte_tickets_max = $my_membre->membre_tickets;
		if( $qte_tickets > $qte_tickets_max ):
			$qte_tickets = $qte_tickets_max;
		endif;
		if($qte_tickets > 0):
			$points_plus = $qte_tickets * 20;
			$my_membre->incremente_champ('membre_points_plus' , $points_plus);
			$my_membre->incremente_champ('membre_tickets' , -$qte_tickets );
		
			$contenu_texte[] = '<p>Vous avez echangé <strong>'.$qte_tickets.'</strong>tickets contre <strong>'.$points_plus.'</strong>points plus.</p>';
		endif;
		
		$qte_tickets_plus = doubleval($_POST['qte_tickets_plus']);
		$qte_tickets_plus_max = $my_membre->membre_tickets_plus;
		if( $qte_tickets_plus > $qte_tickets_plus_max ):
			$qte_tickets_plus = $qte_tickets_plus_max;
		endif;
		if($qte_tickets_plus > 0):
			$points_plus = $qte_tickets_plus * 50;
			$my_membre->incremente_champ('membre_points_plus' , $points_plus);
			$my_membre->incremente_champ('membre_tickets_plus' , -$qte_tickets_plus );
		
			$contenu_texte[] = '<p>Vous avez echangé <strong>'.$qte_tickets_plus.'</strong>tickets contre <strong>'.$points_plus.'</strong>points plus.</p>';
		endif;	
	endif;
	
	$contenu_texte[] = '<form method="post" action="'.page_courante().'">';
	$contenu_texte[] = '<table><tr><th colspan="3">Echanger des anciens tickets contre des points plus .</th></tr>';
	$contenu_texte[] = '<tr><td>Tickets</td><td><input type="text" name="qte_tickets" id="qte_ticket" value="'.$my_membre->membre_tickets.'"></td><td>20 points plus</td></tr>';
	$contenu_texte[] = '<tr><td>Tickets plus</td><td><input type="text" name="qte_tickets_plus" id="qte_tickets_plus" value="'.$my_membre->membre_tickets_plus.'"></td><td>50 points plus</td></tr>';
	$contenu_texte[] = '<tr><td colspan="3"><input name="submit_echanger" id="submit_echanger" type="submit" value="Echanger"></td></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	/**/
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>