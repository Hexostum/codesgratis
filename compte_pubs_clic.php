<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'clans' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'points' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'instant_gagnant' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'pubs' . '.php');


if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Vos publicité aux clics</h1>';
	$contenu_texte[] = '<ul>';
	$contenu_texte[] = '<li><a href="'.page_courante(array(),true).'">Mes publicités</a></li>';
	$contenu_texte[] = '<li><a href="'.page_courante(array('mode'=>'nouvelle'),true).'">Nouvelle publicité</a></li>';
	$contenu_texte[] = '</ul>';

	$url_save = '';
	$image_save = 'http://'.$_SERVER['HTTP_HOST'].'/html/images/clic_remunere_defaut.png';

	switch(@$_GET['mode']):
	
		case 'nouvelle':
			$contenu_texte[] = formulaire_nouvelle_pub($url_save,$image_save);
			
			if(isset($_POST['submit_acheter_plus'])):
				$contenu_texte = array_merge($contenu_texte,acheter_pub($my_membre));
			endif;
				
			if(isset($_POST['submit_acheter'])):
				$contenu_texte = array_merge($contenu_texte,acheter_pub2($my_membre));
			endif;
		break;
		
		default:
		
			if(isset($_GET['pub_id'])):
			
				$pub_id = intval($_GET['pub_id']);
				$cette_pub = new fp_enregistrement('codesgratis_pubs',$pub_id,'pub_id');
				
				if($cette_pub->statut()):
					if($cette_pub->pub_statut==1):
						if($cette_pub->membre_id == $my_membre->membre_id):
							$b_formulaire = true;
							
							if(isset($_POST['submit_supprimer'])):
								if(@$_POST['check_supprimer'] == 'supprimer_pub_ok'):
									if($cette_pub->mise_a_jour_champ('pub_statut',0)):
										$contenu_texte[] = '<p>Votre publicité <strong>'.$pub_id.'</strong> a été supprimée avec succès.</p>';
										$contenu_texte[] = '<p><a href="compte_pubs_clic.php">Retour à la liste de vos publicités.</a></p>';
										$b_formulaire=false;
									else:
										$contenu_texte[] = '<p>Votre publicité <strong>'.$pub_id.'</strong> n\'a pas été supprimée.</p>';
									endif;
								else:
									$contenu_texte[] = '<p>Votre publicité <strong>'.$pub_id.'</strong> n\'a pas été supprimée.</p>';
								endif;
								
							endif;
							
							if(isset($_POST['submit_modifier_mode'])):
								$mode = $_POST['mode'];
								$cette_pub->pub_mode=$mode;
							endif;
							
							if(isset($_POST['submit_modifier_url'])):
								$url = $_POST['url'];
								if(preg_match("#^https?://[a-z0-9\._/\?&-]+#i", $url)):
									$count = mysql_result(mysql_query('SELECT count(pub_id) FROM codesgratis_pubs where pub_url=\''.$url.'\''),0);
									if($count ==0):
										$cette_pub->pub_url=$url;
									else:
										$contenu_texte[] = '<p>Cette url est déjà utilisé par une autre publicité.</p>';
									endif;
								else:
									$contenu_texte[] = '<p>Cette url est incorrecte.</p>';
								endif;
							endif;
							
							if(isset($_POST['submit_modifier_image'])):
								$image = $_POST['image'];
								if(preg_match('#https?://[a-z0-9._/-]+\.((png)|(jpg)|(gif)|(bmp))$#i', $image)):
									(bool)$flag = list($width, $height, $type, $attr) = @getimagesize($image);
									if($flag):
										$cette_pub->pub_image=$image;
									else:
										$contenu_texte[] = '<p>l\'image n\'existe pas.</p>';	
									endif;
								else:
									$contenu_texte[] = '<p>Le format de l\'image est incorrect.</p>';
								endif;
							endif;
							
							if(isset($_POST['submit_crediter_plus'])):
								$contenu_texte = array_merge($contenu_texte,crediter_pub($cette_pub,$my_membre,'pointsplus'));
							endif;
							
							if(isset($_POST['submit_crediter'])):
								$contenu_texte = array_merge($contenu_texte,crediter_pub($cette_pub,$my_membre,'points'));
							endif;
							
							if($b_formulaire):
								$contenu_texte = array_merge($contenu_texte,form_pub($cette_pub,$my_membre));
							endif;
							
						else:
							$contenu_texte[] = message('Vous n\'êtes pas le propriétaire de cette publicité.', FP_MESSAGE_ERROR);
						endif;
					else:
						$contenu_texte[] = message('Cette publicité a été supprimée.',FP_MESSAGE_INFOS);
					endif;
				else:
					$contenu_texte[] = message('Cette publicité n\'existe pas.', FP_MESSAGE_ERROR);
				endif;
			else:
				$retour = mysql_query('SELECT * FROM codesgratis_pubs WHERE membre_id=\''. $my_membre->membre_id .'\' AND pub_statut=1 ');				
				if(mysql_num_rows($retour) > 0):
					$contenu_texte[] = '<table>';
					while($donnees = mysql_fetch_array($retour,MYSQL_ASSOC)):
						$cette_pub= new fp_enregistrement_sql($donnees,'codesgratis_pubs','pub_id');
						$contenu_texte = array_merge($contenu_texte,afficher_resume_pub_clic($cette_pub));
					endwhile;
					$contenu_texte[] = '</table>';
				endif;
			endif;			
		break;
		
	endswitch;
	
	afficher_historique($contenu_texte,$my_membre->membre_id,true,FP_TYPE_R_PUBS1);
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('location: connexion.php');
endif;
?>