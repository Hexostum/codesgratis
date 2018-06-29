<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'points.php');
include_once(FP_CHEMIN_FONCTIONS . 'parrain.php');
include_once(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'tombola' . '.php');

$contenu_texte[] = message('La tombola est temporairement désactivée (13/10/2010) le temps de corriger le bogue qui fait gagner plusieurs fois à la même tombola.' , FP_MESSAGE_ERROR);
/**
if($my_membre->statut()):

	$contenu_texte[] = '<h1>Tentez votre chance sur la tombola de CodesGratis !</h1>';
	$an = date('Y', time());
	$mois = date('m', time());
	$jour = date('d', time());
	
	$tombola_id = $an . $mois . $jour;
	
	$my_tombola = new fp_enregistrement('codesgratis_tombolas',sql_champ_texte($tombola_id),'tombola_id');
	if(!$my_tombola->statut()):
		gagnant_tombola(mktime(0,0,0 , $mois , ($jour-1), $an ));
		if(nouvelle_tombola($tombola_id)):
			$my_tombola = new fp_enregistrement('codesgratis_tombolas',sql_champ_texte($tombola_id),'tombola_id');
		endif;
	endif;
	
	if(isset($_POST['ticket_acheter'])):
		if($my_membre->membre_points_plus > 50):
			enregistrer_ticket($my_membre,$my_tombola);
		endif;
	endif;
	
	$tickets = sql_result ('SELECT count(tombola_ticket_numero) from codesgratis_tombola_tickets where tombola_id=' . $tombola_id);
	$my_tombola->tombola_tickets = $tickets;
	$cagnote = $tickets * 40; 
	
	$contenu_texte[] = message ('Chaque ticket coûte <strong> 50 </strong> points plus' , FP_MESSAGE_INFOS);
	$contenu_texte[] = message ('La cagnote est de <strong>'.$cagnote.'</strong> points' , FP_MESSAGE_INFOS);
	
	if($my_membre->membre_points_plus > 50):
		$contenu_texte = array_merge($contenu_texte,formulaire_tickets());
	else:
		$contenu_texte[] = message ('Vous n\'avez pas assez de points plus pour jouer. Voullez-vous en <strong><a href="cgcode_achat.php">acheter</a></strong> ?' , FP_MESSAGE_ERROR);
	endif;
	
	afficher_historique($contenu_texte,$my_membre->membre_id , true , array(FP_TYPE_R_TOMBOLA , FP_TYPE_TOMBOLA) );
else:
	header('Location : connexion.php');
endif;
/**/
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>