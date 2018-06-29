<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
if($my_membre->statut()):
	$contenu_texte[] = message("Le concours est annulé vu qu'aucun ticket n'a été vendu depuis l'apparition du concours il y a plus d'un an",FP_MESSAGE_INFOS);
	/**
	$contenu_texte[] = '<h1>Concours XBOX 360</h1>';
	
	/**
	if($my_membre->membre_adresse_ok==1):
	/**
		if(isset($_POST['submit_tickets'])):
			$qte = intval($_POST['qte']);
		
			$qte_max = floor( $my_membre->membre_points_plus / 600 );
		
			if($qte > $qte_max):
				$qte = $qte_max;
			endif;
		
			if($qte > 0):
				$ticket_id = (sql_result('SELECT count(ticket_id) FROM codesgratis_concours_cadeaux_tickets WHERE concours_id=1') + 1);
				$sql = sql_insert('codesgratis_concours_cadeaux_tickets', array(
				'concours_id' => '1',
				'ticket_id' => $ticket_id,
				'ticket_qte' => $qte,
				'ticket_date' => 'UNIX_TIMESTAMP()',
				'membre_id' => $my_membre->membre_id,
				));
				if(gestion_points($my_membre , time() , $qte , -($qte * 600) , FP_TYPE_CONCOURS_C , 1 , $my_membre->membre_id , 'NULL' , true  )):
					mysql_query($sql);
				endif;
			endif;
	
		endif;
	
		if($my_membre->membre_points_plus > 600):
	
			$contenu_texte[] = '<table><tr><th colspan="2">Achat des tickets pour le concours</th></tr>';
			$contenu_texte[] = '<form action='.page_courante().' method="post">';
			$contenu_texte[] = '<tr><td>Tickets (600 points plus pour un ticket)</td><td><input type="text" name="qte" id="qte"></td></tr>';
			$contenu_texte[] = '<tr><td colspan="2"><input type="submit" id="submit_tickets" name="submit_tickets" value="acheter tickets"</td></tr>';
			$contenu_texte[] = '</form>';
			$contenu_texte[] = '</table>';
		else:
			$contenu_texte[] = message ('un ticket coûte 600 points plus, vous n\'avez pas assez. Voullez-vous en <a href="cgcode_achat.php">acheter</a> ?' , FP_MESSAGE_INFOS);
		endif;
	/**
	endif;
	/**
	
	$cout_xbox = 100 * 1000;
	$marge_xbox = 100 * 1000;
	
	$ticket = sql_result('SELECT sum(ticket_qte) FROM codesgratis_concours_cadeaux_tickets WHERE concours_id=1');
	
	$ca = $ticket * 600;
	$benef = $ca - ($cout_xbox + $marge_xbox);
	
	$bonus1 = 20000;
	
	if( ($benef - $bonus1) > $bonus1):
		$flag_bonus1 = true;
	else:
		$flag_bonus1 = false;
	endif;
	
	$bonus2 = 10000;
	
	if( ($benef - $bonus1 - $bonus2) > ($bonus1 + $bonus2)):
		$flag_bonus2 = true;
	else:
		$flag_bonus2 = false;
	endif;
	
	
	$benef = $benef - $bonus1 - $bonus2;
	
	if(is_admin($my_membre)):
		$contenu_texte[] = message ((($benef / 1000)*2) . '€' , FP_MESSAGE_INFOS);
	endif;
	
	$contenu_texte[] = message('<strong>'.$ticket.'</strong> Tickets ont été vendus jusqu\'a présent' , FP_MESSAGE_INFOS);
	$contenu_texte[] = '<table><tr><th colspan="2">Gain du concours</th></tr>';
	$contenu_texte[] = '<tr><td>1</td><td>XBOX 360 + 3 jeux</td></tr>';
	if($flag_bonus1):
		$contenu_texte[] = '<tr><td>2</td><td>20 000 points</td></tr>';
	endif;
	if($flag_bonus2):
		$contenu_texte[] = '<tr><td>3</td><td>10 000 points</td></tr>';
	endif;
	$contenu_texte[] = '</table>';	
	/**/
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>