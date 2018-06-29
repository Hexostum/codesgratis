<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'parrain' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'page' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');

$afficher_pub=false;

if($my_membre->membre_existe()):
	if(isset($_GET['membre'])):
		$membre = $_GET['membre'];
		if($membre == 'kredka' || $membre == 'bosmaciej' || $membre == 'kapi18wro' || $membre == 'speedway'):
			header('HTTP/1.1 403 Forbidden');
			exit();
		endif;
		$ce_membre = new fp_membre("'" . mysql_real_escape_string($membre) . "'",'membre_pseudo' );
		header("Status: 301 Moved Permanently", false, 301);
		header('Location: pages_membres.php?membre_id='. $ce_membre->membre_id);
		exit();
	elseif(isset($_GET['membre_id'])):
		$membre_id = intval($_GET['membre_id']);
		$ce_membre = new fp_membre($membre_id,'membre_id' );
		$ce_parrain= new fp_membre($ce_membre->membre_parrain_id,'membre_id');
		if(!$ce_membre->membre_existe()):
			header('Location: index.php');
			exit();
		endif;
	else:
		header('Location: index.php');
		exit();
	endif;
	
	$afficher_pub=true;
				
			
	$donner_point = 0;
					
	$date_minuit = mktime(0, 0, 0);
	$date_moins_minuit = time() - $date_minuit;
	
	update_page_clics();
	
	
	$ce_membre_clics = mysql_result(mysql_query("SELECT COUNT(*) FROM codesgratis_pages_clics WHERE membre_id={$membre_id} and clic_membre_id={$my_membre->membre_id} "),0);
	
	if($ce_membre_clics==0):
	
		$my_membre_clics = new fp_enregistrement('codesgratis_pages_clics',$my_membre->membre_id,'clic_membre_id','COUNT(*) as clics');
	
						
		$nb_clics_restants_membre = 50 - $my_membre_clics->clics;		
	
		if($nb_clics_restants_membre > 0):
			if($ce_membre->membre_banni==0):
				if(!empty($_SERVER['HTTP_REFERER'])):
					mysql_query('INSERT INTO codesgratis_pages_clics VALUES( '.$my_membre->membre_id.' , \''. $_SERVER['REMOTE_ADDR'] .'\', \''. $ce_membre->membre_id .'\', '. time() .', \''. $_SERVER['HTTP_REFERER'] .'\', \'1\')');
				else:
					mysql_query('INSERT INTO codesgratis_pages_clics VALUES( '.$my_membre->membre_id.' , \''. $_SERVER['REMOTE_ADDR'] .'\', \''. $ce_membre->membre_id .'\', '. time() .', NULL , \'1\')');
				endif;
				$points_gagnes = 0.2;
				
				
				$pub = mysql_query('SELECT * FROM codesgratis_pubs2 WHERE pub_affichages > 0 ORDER BY RAND()');
	
				while($pub_donnees = mysql_fetch_array($pub)):
					mysql_query('UPDATE codesgratis_pubs2 SET pub_affichages=pub_affichages-1 WHERE pub_id=\''. $pub_donnees['pub_id'] .'\'');
				endwhile;
				
				if
					(
						gestion_points($ce_membre ,  time() , @$_SERVER['REMOTE_ADDR']  , $points_gagnes , FP_TYPE_PAGES, 'NULL' , $ce_membre->membre_id , 'NULL' , false  )
					)
				:
					$contenu_texte[] =  message("<strong>{$ce_membre->membre_pseudo}</strong> vous remercie de lui avoir donné <strong>{$points_gagnes}</strong> point(s) !" , FP_MESSAGE_INFOS);
					
					$contenu_texte[] =  message("Vous pouvez encore afficher <strong>{$nb_clics_restants_membre}</strong> pages de promotion d'autres membres." , FP_MESSAGE_INFOS);
					/**
					$contenu_texte[] = '<!-- Tag PromoBenef site membre N°75212-->
<script type="text/javascript">
<!--
var promobenef_site = "75212";
var promobenef_minipub = "0";
var promobenef_format = "1";
//-->
</script>
<script type="text/javascript" src="http://www.promobenef.com/pub/"></script>
<noscript><p><a href="http://www.promobenef.com/">PromoBenef : r&eacute;gie publicitaire<img src="http://www.promobenef.com/no_js/?sid=75212&fid=1" alt="PromoBenef" width="0" height="0" style="border:none;" /></a></p></noscript>';
/**/
					$contenu_texte[] = message ("Vous devez prouver que vous êtes allé sur cette page ? Voici le lien à montrer : http://www.codesgratis.fr/preuve_clic.php?membre_id={$ce_membre->membre_id}&amp;date={$date_minuit}" , FP_MESSAGE_INFOS);
					$contenu_texte[] =  message ("Revenez demain pour donner à nouveau un point  à <strong>{$ce_membre->membre_pseudo}</strong> !" , FP_MESSAGE_INFOS);
				else:
					$contenu_texte[] = 'ERREUR';
					$contenu_texte[] = mysql_error();
				endif;
			else:
				$message = message ("Désolé, mais {$ce_membre->membre_pseudo} n'a gagné aucun point, malgré votre aide, car ce membre a été banni pour cause de fraude relativement conséquente (généralement du picturing, ou des récidives pour d'autres fautes).", FP_MESSAGE_ERROR);
			endif;
		else:
			$message = message("Vous avez déjà cliqué pour 50 membres aujourd'hui, et ainsi atteint la limite. Revenez demain ! =)",FP_MESSAGE_ERROR);
		endif;
	else:
		$date_minuit = mktime(0, 0, 0);
		$date_moins_minuit = time() - $date_minuit;
		$temps_pour_redonner_point = ceil(24-($date_moins_minuit/3600));	
		$contenu_texte[] = message ("Vous avez déjà donné ses points à <strong>{$ce_membre->membre_pseudo}</strong> aujourd'hui." , FP_MESSAGE_ERROR);
		$contenu_texte[] = message ("Revenez dans <strong>{$temps_pour_redonner_point}</strong> heures pour donner à nouveau un point à <strong>{$ce_membre->membre_pseudo}</strong> !", FP_MESSAGE_INFOS);
	endif;
					
	$contenu_texte[] = message ('Voir le <a href="membre.php?_membre_id='.$ce_membre->membre_id.'"> profil de '.$ce_membre->membre_pseudo.' sur codesgratis</a>' , FP_MESSAGE_INFOS);
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;
?>