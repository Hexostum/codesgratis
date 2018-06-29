<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'parrain' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'page' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');

if(preg_match("#(loseptp)|(finies4webmaster)|(bosmaciej)|(matiszostak)#", @$_SERVER['HTTP_REFERER'])):
	header('HTTP/1.1 403 Forbidden');
	exit();
endif;

if(isset($_GET['membre'])):
	$membre = $_GET['membre'];
	if($membre == 'kredka' || $membre == 'bosmaciej' || $membre == 'kapi18wro' || $membre == 'speedway'):
		header('HTTP/1.1 403 Forbidden');
		exit();
	endif;
	$ce_membre = new fp_membre("'" . mysql_real_escape_string($membre) . "'",'membre_pseudo' );
	header("Status: 301 Moved Permanently", false, 301);
	header('Location: pages.php?membre_id='. $ce_membre->membre_id);
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

if($my_membre->membre_existe()):
	if($ce_membre->membre_existe()):
		header('Location: pages_membres.php?membre_id='. $ce_membre->membre_id);
	else:
		header('Location: index.php');
	endif;
	exit();
endif;	


$date_minuit = mktime(0, 0, 0);

$date_moins_minuit = time() - $date_minuit;

update_page_clics();
$r_cliqueur_test = new fp_enregistrement('codesgratis_pages_clics',"'" . $_SERVER['REMOTE_ADDR'] ."'",'clic_ip','clic_date');

$contenu_texte[] = '<h1>Page de promotion de <strong>'.$ce_membre->membre_pseudo.'</strong> sur codesgratis</h1>';
$page_titre .= ' - Page de promotion - ' . $ce_membre->membre_pseudo;

if(!$r_cliqueur_test->statut()):
	if($ce_membre->membre_banni==0):
		
		if
			(
				isset($_POST['submit_humain']) && 
				isset($_POST['humain']) 
			)
		:
			$page_titre .= ' - ' . $ce_membre->membre_pseudo;
				
			$nb_clics_possibles = 35;
		
			$date_debut_quinzaine = mktime(0, 0, 0) - 7*24*3600;
			
			$retour = mysql_query("SELECT COUNT(*) FROM codesgratis_codes WHERE membre_id={$ce_membre->membre_id} AND code_validation >= $date_debut_quinzaine AND code_type= " .FP_CGRATIS);
			$cggratis_nombre = mysql_result($retour,0);

			$nb_clics_possibles += $cggratis_nombre * 3;
			
			$retour = mysql_query("SELECT COUNT(*) FROM codesgratis_codes WHERE membre_id={$ce_membre->membre_id} AND code_validation >= $date_debut_quinzaine AND code_type= " .FP_CGCODES);
			$cgcodes_nombre = mysql_result($retour,0);
	
			$nb_clics_possibles += $cggratis_nombre * 5;
	
			$retour = mysql_query("SELECT COUNT(*) FROM codesgratis_codes WHERE membre_id={$ce_membre->membre_id} AND code_validation >= $date_debut_quinzaine AND code_type= " .FP_CGCODESPLUS);
			$cgcodes_plus_nombre = mysql_result($retour,0);
												
			$nb_clics_possibles += $cgcodes_plus_nombre * 15;
			/**/			
			$r_affichages = new fp_enregistrement('codesgratis_pages_clics',$ce_membre->membre_id,'membre_id','COUNT(*) AS affichages');			
						
			if($r_affichages->affichages < $nb_clics_possibles):
				$nb_clics_droit = $nb_clics_possibles - $r_affichages->affichages - 1;
				$date_preuve = time();
				
				if(!empty($_SERVER['HTTP_REFERER'])):
					mysql_query('INSERT INTO codesgratis_pages_clics VALUES( NULL , \''. $_SERVER['REMOTE_ADDR'] .'\', \''. $ce_membre->membre_id .'\', \''. $date_preuve .'\', \''. $_SERVER['HTTP_REFERER'] .'\', \'0\')');
					$page = @file_get_contents($_SERVER['HTTP_REFERER']);
					if(preg_match("#src=(?:\")?http://(www\.)?codesgratis\.fr/pages\.php\?membre=.+(?:\")#", $page)):
						mysql_query('INSERT INTO codesgratis_fraudes VALUES(\''. $_SERVER['REMOTE_ADDR'] .'\', \''. $ce_membre->membre_id .'\', \''. $date_preuve .'\', \''.$_SERVER['HTTP_REFERER'].'\', \'0\')');
					endif;
				else:
					mysql_query('INSERT INTO codesgratis_pages_clics VALUES( NULL , \''. $_SERVER['REMOTE_ADDR'] .'\', \''. $ce_membre->membre_id .'\', \''. $date_preuve .'\', NULL, \'0\')');
				endif;
				$contenu_texte[] = mysql_error();	
				$pages_points = $vip_pages_points[$ce_membre->membre_vip];
			
				$referer = @file_get_contents($_SERVER['HTTP_REFERER']);
							
				preg_match_all("#src=(?:\")?http://(www\.)?codesgratis\.fr/pages\.php\?membre=.+(?:\")#", $referer, $nb_frames, PREG_SET_ORDER);
							
				if(count($nb_frames) > 0):
					$points_gagnes = round($pages_points / count($nb_frames), 1);
				else:
					$points_gagnes = $pages_points;
				endif;
			
				$pub = mysql_query('SELECT * FROM codesgratis_pubs2 WHERE pub_affichages > 0 ORDER BY RAND()');
	
				while($pub_donnees = mysql_fetch_array($pub)):
					mysql_query('UPDATE codesgratis_pubs2 SET pub_affichages=pub_affichages-1 WHERE pub_id=\''. $pub_donnees['pub_id'] .'\'');
				endwhile;
			
				if
					(
						gestion_points($ce_membre ,  time() , @$_SERVER['REMOTE_ADDR']  , $points_gagnes , FP_TYPE_PAGES, 'NULL' , $ce_membre->membre_id , 'NULL' , false  )
					)
				:
			
					if($ce_parrain->membre_existe()):
						if(count($nb_frames) > 0):
							parrain_points_pages($ce_parrain , $ce_membre , round(0.3 / count($nb_frames), 1));
						else:
							parrain_points_pages($ce_parrain , $ce_membre , 0.3 );
						endif;
					else:
						$contenu_texte[] = "pas de parrain";
					endif;
			
					$contenu_texte[] = "<p><strong>{$ce_membre->membre_pseudo}</strong> vous remercie de lui avoir donné <strong>{$points_gagnes}</strong> point(s) ! Il a maintenant <strong>{$ce_membre->membre_points}</strong> point(s).</p>";
					$contenu_texte[] = "<p>{$ce_membre->membre_pseudo} a encore droit à ";
					$contenu_texte[] = "<strong>$nb_clics_droit</strong> affichages de sa page de promotion aujourd'hui, sur ";
					$contenu_texte[] = "<strong>{$nb_clics_possibles}</strong> au total pour ce jour.</p>";
					$contenu_texte[] = "<p>Vous devez prouver que vous êtes allé sur cette page ? Voici le lien à montrer :";
					$contenu_texte[] = "<span style=\"color:green\">http://www.codesgratis.fr/preuve_clic.php?membre_id={$ce_membre->membre_id}&amp;date={$date_preuve}</span></p>";
					$contenu_texte[] = "<p>Revenez demain pour donner à nouveau un point à <strong>{$ce_membre->membre_pseudo}</strong> !</p>";
					
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
  
					
					//$contenu_texte[] = '<h3>Découvrez les publicités de nos membres !</h3>';
				
					//include(FP_CHEMIN_PHP . 'pages_pub_affichage.php');
				
					//$contenu_texte[] = '<h3>Fin des publicités de nos membres</h3>';
			
					$contenu_texte[] = '<table><tr><th>Cliqueurs solidaires : Aide pour poster sur un forum (copier-coller le texte ci-dessous)</th></tr><tr><td>';
					$contenu_texte[] = '<textarea style="width:99%" rows="6">'.
					"[b]{$ce_membre->membre_pseudo}[/b] vous remercie de lui avoir donné [b]{$points_gagnes}[/b] point(s) ! Il a maintenant [b]{$ce_membre->membre_points}[/b] point(s).\r\n\r\n".
					 "[b]{$ce_membre->membre_pseudo}[/b] a encore droit à ".
					 "[b] $nb_clics_droit [/b] affichages de sa page de promotion aujourd'hui, sur ".
					 "[b]{$nb_clics_possibles}[/b] au total pour ce jour.\r\n\r\n".
					 "Vous devez prouver que vous êtes allé sur cette page ? ".
					 "[url=http://www.codesgratis.fr/preuve_clic.php?membre_id={$ce_membre->membre_id}&amp;date={$date_preuve}]Voici le lien à montrer[/url]".
					 "\r\n\r\nRevenez demain pour donner à nouveau un point à [b]{$ce_membre->membre_pseudo}[/b] !".
					 '</textarea>';
					 $contenu_texte[] = '</td></tr></table>';
					
				else:
					$contenu_texte[] = 'ERREUR';
					$contenu_texte[] = mysql_error();
				endif;
			else:
				$contenu_texte[] = '<p>Désolé, le membre <strong>'. $ce_membre->membre_pseudo .'</strong> a atteint sa limite d\'affichages de';
				$contenu_texte[] = 'sa page pour aujourd\'hui, et vous ne pouvez pas par conséquent lui donner un point. Réessayez'; 
				$contenu_texte[] =	'demain. </p>';
				
				$contenu_texte[] = '<table><tr><th>Cliqueurs solidaires : Aide pour poster sur un forum (copier-coller le texte ci-dessous)</th></tr><tr><td>';
				$contenu_texte[] = '<textarea style="width:99%" rows="6">'.
					'Désolé, le membre [b]'. $ce_membre->membre_pseudo .'[/b] a atteint sa limite d\'affichages de'.
					'sa page pour aujourd\'hui, et vous ne pouvez pas par conséquent lui donner un point. Réessayez'.
					'demain.'.
					 		'</textarea>';
				$contenu_texte[] = '</td></tr></table>';
			endif;
		else:
			$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
			$contenu_texte[] = '<table><tr><th colspan="2">Page de promotion : Vérification anti-spam</th></tr><tr><td>';
			$contenu_texte[] = '<input type="checkbox" name="humain" id="humain"></td><td> Je coche cette case si je suis un humain</td></tr>';
			$contenu_texte[] = '<tr><th colspan="2"><input type="submit" name="submit_humain" id="submit_humain"></th></tr></table>';
			$contenu_texte[] = '</form>';
		endif;
	else:
		$contenu_texte[] = "<p>Désolé, mais <strong> {$ce_membre->membre_pseudo}</strong> n'a gagné aucun point, malgré votre aide, car ce membre a été <strong>banni</strong>";
		$contenu_texte[] = "pour cause de fraude relativement conséquente (généralement du picturing, ou des récidives pour d'autres fautes).</p>";
		
		$contenu_texte[] = '<table><tr><th>Cliqueurs solidaires : Aide pour poster sur un forum (copier-coller le texte ci-dessous)</th></tr><tr><td>';
		$contenu_texte[] = '<textarea style="width:99%" rows="6">'.
					 "Désolé, mais [b]{$ce_membre->membre_pseudo}[/b] n'a gagné aucun point, malgré votre aide, car ce membre a été [b]banni[/b]".
					 "pour cause de fraude relativement conséquente (généralement du picturing, ou des récidives pour d'autres fautes).".
					 	   '</textarea>';
		$contenu_texte[] = '</td></tr></table>';
	endif;
else:
	$temps_pour_redonner_point = ceil(24-($date_moins_minuit/3600));
	$contenu_texte[] = message ("Vous avez déjà donné un point à un membre de CodesGratis Le <strong>". format_date($r_cliqueur_test->clic_date)."</strong>." , FP_MESSAGE_ERROR );
	$contenu_texte[] = message ("<strong>{$ce_membre->membre_pseudo}</strong> a <strong>{$ce_membre->membre_points}</strong> point(s)." , FP_MESSAGE_INFOS);
	$contenu_texte[] = message ("Revenez dans <strong>{$temps_pour_redonner_point}</strong> heures pour donner à nouveau un point à <strong>{$ce_membre->membre_pseudo}</strong> !" , FP_MESSAGE_INFOS);
	
	$contenu_texte[] = '<table><tr><th>Cliqueurs solidaires : Aide pour poster sur un forum (copier-coller le texte ci-dessous)</th></tr><tr><td>';
	$contenu_texte[] = '<textarea style="width:99%" rows="6">'.
						 "Vous avez déjà donné un point à un membre de CodesGratis Le [b]". format_date($r_cliqueur_test->clic_date)."[/b].".
						 "\r\n\r\n [b]{$ce_membre->membre_pseudo}[/b] a [b]{$ce_membre->membre_points}[/b] point(s).".
						 "\r\n\r\n Revenez dans [b]{$temps_pour_redonner_point}[/b] heures pour donner à nouveau un point à [b]{$ce_membre->membre_pseudo}[/b] !".
					 '</textarea>';
	$contenu_texte[] = '</td></tr></table>';
endif;
$contenu_texte[] = message ('Voir le <a href="membre.php?_membre_id='.$ce_membre->membre_id.'"> profil de '.$ce_membre->membre_pseudo.' sur codesgratis</a>' , FP_MESSAGE_INFOS);

$afficher_pub=false;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>