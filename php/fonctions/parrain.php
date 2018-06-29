<?php

include_once(FP_CHEMIN_CONSTANTS. 'historique.php');
include_once(FP_CHEMIN_CONSTANTS. 'vip.php');

function parrain_point_tombola(fp_membre $parrain , fp_membre $membre , $points, $id )
{
	$contenu_texte = array();
	$contenu_texte[] =  message('Votre parrain (<a href="membre.php?_membre_id='.$membre->membre_id.'">'.$membre->membre_pseudo.'</a>) est vip niveau <strong>'.$parrain->membre_vip.'</strong>' , FP_MESSAGE_INFOS);
	if($parrain->membre_vip >= 7):
		$pourcent = $GLOBALS['vip_tombola_points'][$parrain->membre_vip];
		$parrain_points = $pourcent * $points;
		$contenu_texte[] =  message ('Votre parrain gagne ('.($pourcent * 100).'%) de vos '.$points.' points soit <strong>'.$parrain_points.'</strong> points' , FP_MESSAGE_INFOS);
		
		$contenu_texte[] =  message ('Votre parrain avait '. $parrain->membre_points .' points.' , FP_MESSAGE_INFOS );
		
		gestion_points($parrain , time() , NULL , $parrain_points , FP_TYPE_PARRAIN_TOMBOLA , $id , $parrain->membre_id , $membre->membre_id , false );
			
		$contenu_texte[] =  message ('Votre parrain a maintenant '. $parrain->membre_points .' points.' , FP_MESSAGE_INFOS);
		
		/**/	
		$membre->incremente_champ('parrain_gain_total_tombola',$parrain_points);
								
		if($membre->parrain_mois_courant != date('mY')):
			$membre->parrain_mois_courant= date('mY');
			$membre->parrain_gain_mois_affichages=0; 
			$membre->parrain_gain_mois_clics=0;
			$membre->parrain_gain_mois_jeu_hasard=0;
			$membre->parrain_gain_mois_tombola=0;
			$membre->parrain_gain_mois_concours=0;
		endif;
								
		$membre->incremente_champ('parrain_gain_mois_tombola',$parrain_points);
								
		if($membre->parrain_jour_courant != date('dmY')):
			$membre->parrain_jour_courant= date('dmY') ;
			$membre->parrain_gain_jour_affichages=0;
			$membre->parrain_gain_jour_clics=0;
			$membre->parrain_gain_jour_jeu_hasard=0;
			$membre->parrain_gain_jour_tombola=0;
			$membre->parrain_gain_jour_concours=0;
		endif;
		
		$membre->incremente_champ('parrain_gain_jour_tombola',$parrain_points);
		
		return $parrain_points;
	else:
		return 0;
	endif;
	
}

function parrain_point_hasard(fp_membre $parrain , fp_membre $membre , $points, $id)
{
	$contenu_texte = array();
	$contenu_texte[] =  message('Votre parrain (<a href="membre.php?_membre_id='.$membre->membre_id.'">'.$membre->membre_pseudo.'</a>) est vip niveau <strong>'.$parrain->membre_vip.'</strong>' , FP_MESSAGE_INFOS);
	if($parrain->membre_vip >= 7):
		$pourcent = $GLOBALS['vip_hasard_points'][$parrain->membre_vip];
		$parrain_points = $pourcent * $points;
		$contenu_texte[] =  message ('Votre parrain gagne ('.($pourcent * 100).'%) de vos '.$points.' points soit <strong>'.$parrain_points.'</strong> points' , FP_MESSAGE_INFOS);
		
		$contenu_texte[] =  message ('Votre parrain avait '. $parrain->membre_points .' points.' , FP_MESSAGE_INFOS );
		
		gestion_points($parrain , time() , NULL , $parrain_points , FP_TYPE_PARRAIN_HASARD , $id , $parrain->membre_id , $membre->membre_id , false );
			
		$contenu_texte[] =  message ('Votre parrain a maintenant '. $parrain->membre_points .' points.' , FP_MESSAGE_INFOS);
		
		/**/	
		$membre->incremente_champ('parrain_gain_total_jeu_hasard',$parrain_points);
								
		if($membre->parrain_mois_courant != date('mY')):
			$membre->parrain_mois_courant= date('mY');
			$membre->parrain_gain_mois_affichages=0; 
			$membre->parrain_gain_mois_clics=0;
			$membre->parrain_gain_mois_jeu_hasard=0;
			$membre->parrain_gain_mois_tombola=0;
			$membre->parrain_gain_mois_concours=0;
		endif;
								
		$membre->incremente_champ('parrain_gain_mois_jeu_hasard',$parrain_points);
								
		if($membre->parrain_jour_courant != date('dmY')):
			$membre->parrain_jour_courant= date('dmY') ;
			$membre->parrain_gain_jour_affichages=0;
			$membre->parrain_gain_jour_clics=0;
			$membre->parrain_gain_jour_jeu_hasard=0;
			$membre->parrain_gain_jour_tombola=0;
			$membre->parrain_gain_jour_concours=0;
		endif;
		
		$membre->incremente_champ('parrain_gain_jour_jeu_hasard',$parrain_points);
	else:
		$contenu_texte[] =  message ('Le niveau VIP de votre parrain n\'est pas assez élevé pour lui permettre de gagner des points grâce à vous', FP_MESSAGE_ERROR);
	endif;
	return $contenu_texte;
}
function parrain_points_pub(fp_membre $parrain , fp_membre $membre, $pub)
{
	$points = 0.3;
	
	$parrain->incremente_champ('membre_points',$points);
	mysql_query('INSERT INTO codesgratis_historique VALUES ( '.time().' , '.$pub->pub_url.' , '.$points.' , '.FP_TYPE_PARRAIN_PUB.', '.$pub->pub_id.' , '.$parrain->membre_id.' , '.$membre->membre_id.' )');
		
	$parrain->incremente_champ('parrain_gain_total_clics' , $points );
								
	if($parrain->parrain_mois_courant != date('mY')): 
		$parrain->parrain_mois_courant= date('mY');
		$parrain->parrain_gain_mois_affichages=0;
		$parrain->parrain_gain_mois_clics=0;
		$parrain->parrain_gain_mois_jeu_hasard=0;
		$parrain->parrain_gain_mois_tombola=0;
		$parrain->parrain_gain_mois_concours=0;
	endif;
	
	$parrain->incremente_champ('parrain_gain_mois_clics' , $points );
								
	if($parrain->parrain_jour_courant != date('dmY')): 
		$parrain->parrain_jour_courant=date('dmY');
		$parrain->parrain_gain_jour_affichages=0;
		$parrain->parrain_gain_jour_clics=0;
		$parrain->parrain_gain_jour_jeu_hasard=0;
		$parrain->parrain_gain_jour_tombola=0;
		$parrain->parrain_gain_jour_concours=0;
	endif; 
	
	$parrain->incremente_champ('parrain_gain_jour_clics' , $points);
	
}

function parrain_points_pages(fp_membre $parrain , fp_membre $membre, $points)
{
	
	$parrain->incremente_champ('membre_points',$points);
	mysql_query('INSERT INTO codesgratis_historique VALUES ( '.time().' , NULL , '.$points.' , '.FP_TYPE_PARRAIN_PAGES.', NULL , '.$parrain->membre_id.' , '.$membre->membre_id.' )');
		
	$parrain->incremente_champ('parrain_gain_total_affichages' , $points );
								
	if($parrain->parrain_mois_courant != date('mY')): 
		$parrain->parrain_mois_courant= date('mY');
		$parrain->parrain_gain_mois_affichages=0;
		$parrain->parrain_gain_mois_clics=0;
		$parrain->parrain_gain_mois_jeu_hasard=0;
		$parrain->parrain_gain_mois_tombola=0;
		$parrain->parrain_gain_mois_concours=0;
	endif;
	
	$parrain->incremente_champ('parrain_gain_mois_affichages' , $points );
								
	if($parrain->parrain_jour_courant != date('dmY')): 
		$parrain->parrain_jour_courant=date('dmY');
		$parrain->parrain_gain_jour_affichages=0;
		$parrain->parrain_gain_jour_clics=0;
		$parrain->parrain_gain_jour_jeu_hasard=0;
		$parrain->parrain_gain_jour_tombola=0;
		$parrain->parrain_gain_jour_concours=0;
	endif; 
	
	$parrain->incremente_champ('parrain_gain_jour_affichages' , $points);	
}
?>