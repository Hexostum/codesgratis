<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'parrain' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'html_message' . '.php');
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
					if(isset($_POST['pub_id_hash'])):
						if($_POST['pub_id_hash']==md5($pub_id)):
							
							if
								(
									gestion_points ( $my_membre , time() , $sql_pub->pub_url , 0.5 , FP_TYPE_PUB, $sql_pub->pub_id , $my_membre->membre_id , 'NULL' , false)
								)
							:
					
								mysql_query('INSERT INTO codesgratis_pubs_clics VALUES(\''. $my_membre->membre_id .'\', \''. $pub_id .'\', \''. time() .'\')');
								
								if($my_parrain->membre_existe()):
									parrain_points_pub($my_parrain,$my_membre,$sql_pub);
								endif;
														
								if(!is_null($sql_pub->pub_clics)):
									$sql_pub->incremente_champ('pub_clics',-1);
								endif;
								
								$message =  message('Tout est en ordre ! Vous voici crédité(e) de 0.5 points de plus sur votre compte !',FP_MESSAGE_INFOS);
								html_message($javascript,'clics.php',$message,$pub_id);
							else:
								echo 'ERREUR ';
							endif;
						else:
							html_message($javascript,'clics.php','Paramètres incorrects !',NULL);	
						endif;
					else:
						$compteur = isset($sql_pub->pub_compteur) ? $sql_pub->pub_compteur : 5;
						$url = $sql_pub->pub_url;
						$javascript .= '<script type="text/javascript">var compteur = '. $compteur .';</script>' . FP_LIGNE;		
						$javascript .= '<script type="text/javascript" src="html/javascripts/decompte_frame.js"></script>'. FP_LIGNE;
						$message = 'Le chargement de la pub est en cours. (JAVASCRIPT REQUIS!)';
						html_message($javascript,'clics.php',$message,$pub_id);
					endif;
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
	header('Location : connexion.php');
endif;
?>