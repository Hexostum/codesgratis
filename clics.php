<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'pubs' . '.php');
error_reporting(E_ALL);
if($my_membre->membre_existe()):
	purger_pubs_clic();
	
	$contenu_texte[] = '<p style="text-align:center;text-decoration:blink;"><a href="compte_pubs_clic.php">Achetez des clics pour votre lien ici !</a></p>';
	$contenu_texte[] = '<h1>Les clics rémunérés aux points</h1>';
					
	$contenu_texte[] = message('Les publicités aux clics : Soyez rémunérés en cliquant sur les publicités des membres de codesgratis (1 Clic toutes les 24 Heures pour chaque publicité)', FP_MESSAGE_INFOS);
					
	$contenu_texte[] = message('Veuillez bien laisser se charger la page jusqu\'à la fin pour que les points soient comptabilisés.', FP_MESSAGE_INFOS);
					
	$contenu_texte[] = message('Votre navigateur doit accepter les popups et le javascript pour pouvoir bénéficier de vos points.' , FP_MESSAGE_INFOS);
	
	
	$contenu_texte[] = '<br><br>';
	
	$contenu_texte = array_merge($contenu_texte,resume_pubs_clic_membre($my_membre));
	
	$contenu_texte = array_merge($contenu_texte,afficher_pubs_clic($my_membre));
	
	$contenu_script[] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
	$contenu_script[] = '<script type="text/javascript" src="html/javascripts/link_popup.js"></script>';
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>