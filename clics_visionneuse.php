<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'pubs' . '.php');

if
	(
		$my_membre->membre_existe()
	)
:
	$javascript = '<script type="text/javascript" src="html/javascripts/retour.js"></script>'. FP_LIGNE;
	if
		(
			isset($_GET['pub_id'])
		)
	:
		$pub_id = intval($_GET['pub_id']);
		$sql_pub = new fp_enregistrement('codesgratis_pubs',$pub_id,'pub_id');
		
		if
			(
				$sql_pub->statut()
			)
		:
			if
				(
					(is_null($sql_pub->pub_clics)) || 
					($sql_pub->pub_clics > 0) 
				)
			:
				
				$date_minuit = purger_pubs_clic();
				$date_moins_minuit = time() - $date_minuit;
			
				if
					(
						clic_sur_pub($pub_id,$my_membre)==0
					)
				:
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html lang="fr">
<head>
<title>CodesGratis : gagnez des codes audiotels gratis très facilement !!</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="html/javascripts/frame.js"></script>
</head>
<frameset rows="90,*" border="2" framespacing="0">
  <frame name="barre" src="clics_compteur.php?pub_id=<?php echo $sql_pub->pub_id; ?>" scrolling="No" style="border-bottom:ridge 1px #000000;text-align:center;">
  <frame name="site" src="<?php echo $sql_pub->pub_url; ?>" scrolling="Auto">
</frameset>
<noframes></noframes>
</html>
<?php
				else:
					$temps_pour_recliquer = ceil(24-($date_moins_minuit/3600));
					$message = message('Vous avez déjà cliqué sur cette publicité aujourd\'hui !',FP_MESSAGE_ERROR);	
					$message .= message('Revenez dans '. $temps_pour_recliquer .'h pour recliquer sur cette publicité !',FP_MESSAGE_INFOS);	
					html_message($javascript,'clics.php',$message,NULL,false);
				endif;
			else:
				html_message($javascript,'clics.php',message('La campagne de cette pub est finie !',FP_MESSAGE_ERROR),NULL,false);
			endif;
		else:
			html_message($javascript,'clics.php',message('Cette pub n\'existe pas !',FP_MESSAGE_ERROR),NULL,false);	
		endif;
	else:
		html_message($javascript,'clics.php',message('Paramètres incorrects !',FP_MESSAGE_ERROR),NULL,false);
	endif;
else:
	header('location: connexion.php');
endif;
?>
