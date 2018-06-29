<?php

function nouvelle_tombola($jour)
{
	$sql = sql_insert
	(
		'codesgratis_tombolas',
		array
			(
				'tombola_id' => sql_champ_texte($jour),
				'tombola_tickets' => 0,
				'tombola_gains' => 0,
				'membre_id' => 'NULL'
			)
	);
	if(mysql_query($sql)):
		return true;
	else:
		echo mysql_error();
		return false;
	endif;
}
function formulaire_tickets()
{
	$contenu = array();
	$contenu[] = '<form method="post" action="'.page_courante().'">';
	$contenu[] = '<table><tr><th>Jouer à la tombola</th></tr>';
	$contenu[] = '<tr><td><input type="submit" name="ticket_acheter" id="ticket_acheter" value="Acheter un ticket"></td></tr></table>';
	$contenu[] = '</form>';
	return $contenu;
}
function enregistrer_ticket($my_membre,$my_tombola)
{
	if($my_tombola->statut()):
		$sql = sql_insert
		(
			'codesgratis_tombola_tickets',
			array
				(
					'tombola_id' => $my_tombola->tombola_id,
					'tombola_ticket_numero' => ($my_tombola->tombola_tickets+1),
					'membre_id' => $my_membre->membre_id
				)
		
		);
		if(mysql_query($sql)):
			$my_tombola->tombola_tickets++;
			gestion_points($my_membre,time(),$my_tombola->tombola_tickets,-50,FP_TYPE_R_TOMBOLA, $my_tombola->tombola_id , $my_membre->membre_id , 'NULL' , true );
		endif;
	endif;
}
function gagnant_tombola($jour)
{
	$an = date('Y', $jour);
	$mois = date('m', $jour);
	$jour = date('d', $jour);
	
	$tombola_id = $an . $mois . $jour;
	
	$my_tombola = new fp_enregistrement('codesgratis_tombolas',sql_champ_texte($tombola_id),'tombola_id');
	if($my_tombola->statut()):
		$tickets = sql_result ('SELECT count(tombola_ticket_numero) from codesgratis_tombola_tickets where tombola_id=' . $tombola_id);
		$my_tombola->tombola_tickets = $tickets;
		$ticket_gagnant = rand(1, $tickets);
		$ce_gagnant = new fp_membre( sql_result('SELECT membre_id FROM codesgratis_tombola_tickets WHERE tombola_ticket_numero='. $ticket_gagnant ) );
		$my_tombola->membre_id=$ce_gagnant->membre_id;
		$gain = $tickets * 40;
		$my_tombola->tombola_gains=$gain;
		if($gain > 0):
			gestion_points($ce_gagnant,time(),$ticket_gagnant,$gain,FP_TYPE_TOMBOLA, $my_tombola->tombola_id , $ce_gagnant->membre_id , 'NULL' , false );
		
			envoyer_message
			(
				0,
				$ce_gagnant->membre_id,
				'[TOMBOLA N°'.$my_tombola->tombola_id.'] GAGNANT !',
				'Bonjour et félicitations, vous êtes l\'heureux gagnant de la tombola '.$my_tombola->tombola_id.' avec points '.$gain.' gagnés grâce à votre ticket N° '.$ticket_gagnant
			);
		
			$parrain_gagnant = new fp_membre($ce_gagnant->membre_parrain_id);
			if($parrain_gagnant->statut()):
				$gain_parrain = parrain_point_tombola($parrain_gagnant,$ce_gagnant,$gain,$my_tombola->tombola_id);
					envoyer_message
					(
						0,
						$ce_gagnant->membre_parrain_id,
						'[TOMBOLA N°'.$my_tombola->tombola_id.'] Gain de parrainage grâce à un de vos filleuls  !',
						'Bonjour et félicitations, l\'heureux gagnant de la tombola '.$my_tombola->tombola_id.' avec points '.$gain.' gagnés grâce à son ticket N° '.$ticket_gagnant . 'vous fait gagner '.$gain_parrain.' points'
					);
				
			endif;	
		endif;
	endif;
}

function liste_tombola_maj($tombola_id)
{
	// poster une nouvelle pour chaque tombola gagnée
	$res_sql = mysql_query('SELECT * FROM codesgratis_tombolas WHERE tombola_maj=0 AND tombola_id <>' . $tombola_id);
	while($arr_sql = mysql_fetch_array($res_sql,MYSQL_ASSOC)):
		$cette_tombola = new fp_enregistrement_sql($arr_sql,'codesgratis_tombolas','tombola_id');
		if($cette_tombola->tombola_gains > 0):
			$tombola_tickets = $cette_tombola->tombola_tickets;
			$tombola_gains = $cette_tombola->tombola_gains;
			$tombola_an = substr($cette_tombola->tombola_id,0,4);
			$tombola_mois = substr($cette_tombola->tombola_id,4,2);
			$tombola_jour = substr($cette_tombola->tombola_id,6,2);
			$texte_titre = 'Tombola du '.$tombola_jour.'/'.$tombola_mois.'/'.$tombola_an;
			$nom_robot = 'Robot Tombola';
			$date = mktime(0,0,0,intval($tombola_mois),intval($tombola_jour),intval($tombola_an));
			$texte = 'Lors de la ' . $texte_titre . ' Il y a eu <strong>'.$tombola_tickets.'</strong> tickets joués.<strong><a href="membre.php?_membre_id='.$cette_tombola->membre_id.'">'. $GLOBALS['cache_membre_pseudo'][$cette_tombola->membre_id] .'</a></strong> a gagné <strong>'.$tombola_gains.'</strong> points grâce à son ticket gagnant.';
			
		else:
			$tombola_tickets = $cette_tombola->tombola_tickets;
			$tombola_gains = $cette_tombola->tombola_gains;
			$tombola_an = substr($cette_tombola->tombola_id,0,4);
			$tombola_mois = substr($cette_tombola->tombola_id,4,2);
			$tombola_jour = substr($cette_tombola->tombola_id,6,2);
			$texte_titre = 'Tombola du '.$tombola_jour.'/'.$tombola_mois.'/'.$tombola_an;
			$nom_robot = 'Robot Tombola';
			$date = mktime(0,0,0,intval($tombola_mois),intval($tombola_jour),intval($tombola_an));
			$texte = 'Lors de la ' . $texte_titre . ' personne n\'a participé à la tombola, donc aucun gagnant.';
			
			
		endif;
		$sql = sql_insert
			(
				'codesgratis_maj',
				array
					(
						'maj_id' => 'NULL',
						'maj_auteur' => sql_champ_texte($nom_robot),
						'maj_titre'=> sql_champ_texte($texte_titre),
						'maj_texte'=> sql_champ_texte($texte),
						'maj_date'=> $date,
						'maj_coms'=>0,
					)
			)
		;
		if(mysql_query($sql)):
			$cette_tombola->tombola_maj=1;
		endif;
	endwhile;
}



// Connexion
	/*TIRAGE DU GAGNANT DE LA TOMBOLA DE LA VEILLE, SI ELLE EST TERMINEE*
							
	$jour = date('dmY', time());
				
	$retour3 = mysql_query('SELECT * FROM codesgratis_tombola WHERE jour=\''. $jour .'\'');
	if(mysql_num_rows($retour3) == 0)
	{
		//On tire le gagnant, et on lui donne son prix
		$retour4 = mysql_query('SELECT COUNT(*) AS nb_tickets_tombola FROM codesgratis_tombola_tickets');
					$donnees4 = mysql_fetch_array($retour4);
						
					$ticket_gagnant = rand(1, $donnees4['nb_tickets_tombola']);
					$retour5 = mysql_query('SELECT joueur FROM codesgratis_tombola_tickets WHERE numero=\''. $ticket_gagnant .'\'');
					$donnees5 = mysql_fetch_array($retour5);
								
					$gain_tombola = 100;
					$gain_tombola += $donnees4['nb_tickets_tombola']*35;
								
					$gain_cgcodes = (floor($gain_tombola/1000))*2;
								
					$nb_tickets_gagnants = floor($gain_tombola/1000);
								
					$retour6 = mysql_query('SELECT * FROM inscrits WHERE pseudo=\''. $donnees5['joueur'] .'\'');
					$donnees6 = mysql_fetch_array($retour6);
								
					/* Gains du parrain *
								
					$gain_parrain = 0;
								
					$retour7 = mysql_query('SELECT niveau_vip FROM inscrits WHERE pseudo=\''. $donnees6['parrain'] .'\'');
					$donnees7 = mysql_fetch_array($retour7);
					if($donnees7['niveau_vip'] == 7)
					{
						$gain_parrain = 0.03*$gain_tombola;
					}
					else if($donnees7['niveau_vip'] == 8)
					{
						$gain_parrain = 0.05*$gain_tombola;
					}
					else if($donnees7['niveau_vip'] == 9)
					{
						$gain_parrain = 0.07*$gain_tombola;
					}
					else if($donnees7['niveau_vip'] == 10)
					{
						$gain_parrain = 0.1*$gain_tombola;
					}
					
					mysql_query('UPDATE inscrits SET nb_points=nb_points+'. $gain_parrain .' WHERE pseudo=\''. $donnees6['parrain'] .'\'');
								
					if(!empty($donnees6['parrain']))
					{										
						mysql_query("UPDATE inscrits SET parrain_gain_total_tombola=parrain_gain_total_tombola+$gain_parrain WHERE pseudo='". $donnees5['joueur'] ."'");
									
						if($donnees6['parrain_mois_courant'] != date('mY'))
						{
							mysql_query("UPDATE inscrits SET parrain_mois_courant=". date('mY') ." WHERE pseudo='". $donnees5['joueur'] ."'");
							mysql_query("UPDATE inscrits SET parrain_gain_mois_affichages=0, parrain_gain_mois_clics=0, parrain_gain_mois_jeu_hasard=0, parrain_gain_mois_tombola=0, parrain_gain_mois_concours=0 WHERE pseudo='". $donnees5['joueur'] ."'");
						}
									
						mysql_query("UPDATE inscrits SET parrain_gain_mois_tombola=parrain_gain_mois_tombola+$gain_parrain WHERE pseudo='". $donnees5['joueur'] ."'");
								
						if($donnees6['parrain_jour_courant'] != date('dmY'))
						{
							mysql_query("UPDATE inscrits SET parrain_jour_courant=". date('dmY') ." WHERE pseudo='". $donnees5['joueur'] ."'");
							mysql_query("UPDATE inscrits SET parrain_gain_jour_affichages=0, parrain_gain_jour_clics=0, parrain_gain_jour_jeu_hasard=0, parrain_gain_jour_tombola=0, parrain_gain_jour_concours=0 WHERE pseudo='". $donnees5['joueur'] ."'");
						}
									
						mysql_query("UPDATE inscrits SET parrain_gain_jour_tombola=parrain_gain_jour_tombola+$gain_parrain WHERE pseudo='". $donnees5['joueur'] ."'");
					}
								
					/*Fin des gains du parrain *
								
					$nb_points = $donnees6['nb_points'];
					$nb_points += $gain_tombola;
					mysql_query('UPDATE inscrits SET nb_points=\''. $nb_points .'\' WHERE pseudo=\''. $donnees5['joueur'] .'\'');
								
					$cgcodes_gagnant = '';
					for($i = 1 ; $i <= $gain_cgcodes ; $i++)
					{
						$retour7 = mysql_query('SELECT code FROM codesgratis_cgcodes WHERE utilisation=\'Gain tombola\'');
						$donnees7 = mysql_fetch_array($retour7);
						$cgcodes_gagnant .= $donnees7['code'] .'\n';
						mysql_query('UPDATE codesgratis_cgcodes SET utilisation=NULL WHERE code=\''. $donnees7['code'] .'\'');
					}
					if($gain_cgcodes > 0)
					{
						mysql_query('INSERT INTO codesgratis_messagerie VALUES(\'\', \'FLo\', \''. $donnees5['joueur'] .'\', \'Vos CGcodes gagnés avec la tombola !\', \'Félicitations à vous pour cette tombola ! =)\n\nVos '. $gain_cgcodes .' CGcodes :\n\n'. $cgcodes_gagnant .'\n\nBonne nuit !\', \'1\', \''. time() .'\')');
					}
								
					if($nb_tickets_gagnants > 0)
					{
						$deja_gagnants = '('. $donnees5['joueur'] .')';
									
						for($i = 1 ; $i <= $nb_tickets_gagnants ; $i++)
						{
							if(mysql_num_rows(mysql_query('SELECT * FROM codesgratis_tombola_tickets WHERE joueur NOT REGEXP \''. $deja_gagnants .'\'')) > 0)
							{
								$retour8 = mysql_query('SELECT joueur FROM codesgratis_tombola_tickets WHERE joueur NOT REGEXP \''. $deja_gagnants .'\' ORDER BY RAND() LIMIT 1');
								$donnees8 = mysql_fetch_array($retour8);
												
								$deja_gagnants .= '|('. $donnees8['joueur'] .')';
							}
							else
							{
								$retour8 = mysql_query('SELECT joueur FROM codesgratis_tombola_tickets ORDER BY RAND() LIMIT 1');
								$donnees8 = mysql_fetch_array($retour8);
							}
							$retour7 = mysql_query('SELECT code FROM codesgratis_cgcodes WHERE utilisation=\'Gain tombola\'');
							$donnees7 = mysql_fetch_array($retour7);
							$cgcodes_gagnant = $donnees7['code'];
							mysql_query('UPDATE codesgratis_cgcodes SET utilisation=NULL WHERE code=\''. $donnees7['code'] .'\'');
										
							mysql_query("INSERT INTO codesgratis_messagerie VALUES('', 'FLo', '". $donnees8['joueur'] ."', 'L\'un de vos tickets de tombola vous fait remporter un CGcode de consolation !', 'Vous aurez sans doute plus de chance la prochaine fois. ;)\n\nEn attendant, le CGcode en question :\n\n $cgcodes_gagnant \n\nBonne nuit !', '1', '". time() ."')");
						}
					}
					$jour_veille = date('dmY', time()-86400);
					mysql_query('UPDATE codesgratis_tombola SET gagnant=\''. $donnees5['joueur'] .'\' WHERE jour=\''. $jour_veille .'\'');
					mysql_query('UPDATE codesgratis_tombola SET gain=\''. $gain_tombola .'\' WHERE jour=\''. $jour_veille .'\'');
								
					mysql_query('DELETE FROM codesgratis_tombola_tickets');
								
					//Création automatique de la tombola du jour
					mysql_query('INSERT INTO codesgratis_tombola VALUES(\'\', \''. $jour .'\', \'\', \'0\')');
					$retour3 = mysql_query('SELECT * FROM codesgratis_tombola WHERE jour=\''. $jour .'\'');
				}
						
				/*FIN DU TIRAGE DU GAGNANT DE LA TOMBOLA DE LA VEILLE, SI ELLE EST TERMINEE*/