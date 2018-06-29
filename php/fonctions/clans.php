<?php
function renouvellement_clan()
{
/* Concours entre clans */
									
$retour3 = mysql_query('SELECT * FROM codesgratis_concours ORDER BY concours_id DESC LIMIT 1');
$sql_concours = mysql_fetch_array($retour3,MYSQL_ASSOC);
$ce_concours = new fp_enregistrement_sql($sql_concours,'codesgratis_concours','concours_id');
/* Gestion du renouvellement des concours */
$date_maintenant = time();
								
if($date_maintenant >= $ce_concours->concours_fin):
	
	//Concours de la semaine terminé
	
	$clans_gagnants = array(NULL, NULL, NULL);
	$gain = array(0, 0, 0);
	$gain_par_cgcode = array(10, 4, 2);
	$i = 1;
	
	$retour = mysql_query('SELECT * FROM codesgratis_clans WHERE clan_points > 0 ORDER BY clan_points DESC LIMIT 3');
	while($sql_clans_gagnant = mysql_fetch_array($retour,MYSQL_ASSOC)):
		$clans_gagnants[$i] = new fp_enregistrement_sql($sql_clans_gagnant,'codesgratis_clans','clan_id');
		$i++;
	endwhile;
	
	$i = 1;
	$gain_total = 0;
	
	$retour2 = mysql_query('SELECT * FROM codesgratis_clans WHERE clan_points > 0 ORDER BY clan_points DESC');
	while($sql_clan_courant = mysql_fetch_array($retour2,MYSQL_ASSOC)):
		$clan_courant = new fp_enregistrement_sql($sql_clan_courant,'codesgratis_clans','clan_id');
		
		if($i <= 10):
			if(!mysql_query('INSERT INTO codesgratis_concours_classements VALUES( '. $ce_concours->concours_id .', '. $clan_courant->clan_id .', '. $i .', '. $clan_courant->clan_points .')')):
				echo mysql_error();
			endif;			
			$i++;
		endif;
		$gain_total += $clan_courant->clan_points;
		
		if($i>4):
			if(!($clan_courant->clan_points=0) ):
				echo mysql_error();
			endif;
		endif;
	endwhile;
	
	foreach($clans_gagnants as $clef_clan => $clan):
		
		if(is_object($clan)):
			$gain[$clef_clan] = ceil($gain_total*$gain_par_cgcode[$clef_clan-1]);
			$nb_cgcodes_clan = $clan->clan_points;		
		
			$retour3 = mysql_query('SELECT * FROM codesgratis_membres WHERE membre_clan_id='. $clan->clan_id );
			echo mysql_error();
			while($sql_membre = mysql_fetch_array($retour3,MYSQL_ASSOC)):
			
				$ce_membre = new fp_membre_sql($sql_membre);
				
				$points = sql_result('SELECT sum(clan_points) FROM codesgratis_clan_points WHERE membre_id='.$ce_membre->membre_id.' AND points_date > '.$ce_concours->concours_debut.' AND points_date < ' . $ce_concours->concours_fin );
				
				$gain_joueur = ceil($gain[$clef_clan] * ($points/$nb_cgcodes_clan));
				
				
				gestion_points($ce_membre , time() , NULL , $gain_joueur , FP_TYPE_CLANS_CONCOURS , $ce_concours->concours_id ,$ce_membre->membre_id);
				
				/* Gains du parrain */
				$ce_parrain = new fp_membre($ce_membre->membre_parrain_id,'membre_id');
				if($ce_parrain->membre_existe()):	
					$gain_parrain = $GLOBALS['vip_clans_points_parrain'][$ce_parrain->membre_vip] * $gain_joueur;
					gestion_points($ce_parrain , time() , NULL , $gain_parrain , FP_TYPE_CLANS_CONCOURS_PARRAIN , $ce_concours->concours_id , $ce_parrain->membre_id , $ce_membre->membre_id );
				endif;
				/*Fin des gains du parrain */
			endwhile;
		
			$ce_concours->{'clan_id_'.$clef_clan } = $clan->clan_id;
			$ce_concours->{'concours_gain_' . $clef_clan } = $gain[$clef_clan];
			
			if(!($clan->clan_points=0) ):
				echo mysql_error();
			endif;
		endif;		
	endforeach;
	$date_fin_nouveau_concours = $ce_concours->concours_fin + 7*24*3600;
	if(!mysql_query('INSERT INTO codesgratis_concours VALUES(\'\', \''. $ce_concours->concours_fin .'\', \''. $date_fin_nouveau_concours .'\', NULL , NULL , NULL , NULL , NULL , NULL )')):
		echo mysql_error();
	endif;
endif;
}

function crediter_clan($clan_id,$points_clan,$my_membre)
{
	$message= array();
	
	if($clan_id!=''):	
		$my_clan = new fp_enregistrement('codesgratis_clans',intval($clan_id),'clan_id');
		
		if($my_clan->statut()):
			if($my_clan->incremente_champ('clan_points',$points_clan)):		
				mysql_query('INSERT INTO codesgratis_clan_points VALUES( '.$my_membre->membre_id.' , '.$my_clan->clan_id.' , '.$points_clan.' , '.time().' )');
				$message[] = message('Votre clan <strong> '. $my_clan->clan_nom .'</strong> gagne <strong>'. $points_clan .'</strong> point(s) grâce à vous !',FP_MESSAGE_INFOS);
			else:
				$message[] = mysql_error();
			endif;
		endif;
	else:
		$clan_id = sql_result('SELECT clan_id FROM codesgratis_clans where membre_id is not null ORDER BY rand() LIMIT 1');
		$my_clan = new fp_enregistrement('codesgratis_clans',intval($clan_id),'clan_id');
		if($my_clan->statut()):
			if($my_clan->incremente_champ('clan_points',$points_clan)):
				mysql_query('INSERT INTO codesgratis_clan_points VALUES( '.$my_membre->membre_id.' , '.$my_clan->clan_id.' , '.$points_clan.' , '.time().' )');
				$message[] = message('Le clan <strong>'. $my_clan->clan_nom .'</strong> gagne <strong>'. $points_clan .'</strong> points grâce à vous !</p>',FP_MESSAGE_INFOS);
			else:
				$message[] = mysql_error();
			endif;
		endif;
	endif;
	return $message;
}
?>
