<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'historique.php');
include_once(FP_CHEMIN_FONCTIONS . 'hasard_recapitulatif.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Tentez votre chance au jeu de hasard de CodesGratis !</h1>';
	
	if(isset($_POST['jouer'])):
	
		if($my_membre->membre_points_plus >= 20):
			
			$session_id = sql_result('SELECT MAX(jeu_session) FROM codesgratis_jeu_hasard');
			if(is_null($session_id)):
				$session_id=0;
				$ticket=1;
			else:
				$ticket = sql_result('SELECT MAX(jeu_ticket) FROM codesgratis_jeu_hasard WHERE jeu_session='.$session_id);
				$ticket++; 
				if($ticket==201):
					$ticket=1;
					$session_id++;
				endif;
			endif;
			
			//On attribut un prix selon le nombre
			
			$id = $session_id . sprintf('%03s',$ticket);
			
			if($ticket == 200):
				$gain_jeu = 1000;
			elseif($ticket==100):
				$gain_jeu = 500;
			elseif($ticket==20):
				$gain_jeu = 100;
			elseif($ticket==10):
				$gain_jeu = 50;
			else:
				$gain_jeu = 25;								
			endif;
			
			$contenu_texte[] = message('Vous avez gagné '.$gain_jeu.' points grâce au ticket N° S' . $session_id . '_T' .sprintf('%03s',$ticket)  , FP_MESSAGE_INFOS) ;
			
			$points = $my_membre->membre_points;
			
			if(gestion_points($my_membre , time() , NULL , -20 , FP_TYPE_R_HASARD, $id , $my_membre->membre_id , 'NULL' , true )):
				if(gestion_points($my_membre , time() , NULL , $gain_jeu , FP_TYPE_HASARD, $id , $my_membre->membre_id , 'NULL' , false )):
			
					mysql_query('INSERT INTO codesgratis_jeu_hasard VALUES ( '. $session_id .' , '. $ticket .' , '.time().' , '.$gain_jeu.'  ,  '.$my_membre->membre_id.'   )');			
	
					if($my_parrain->membre_existe()):
						include(FP_CHEMIN_FONCTIONS . 'parrain.php');
						$contenu_texte = array_merge($contenu_texte,parrain_point_hasard( $my_parrain , $my_membre , $gain_jeu , $id ));
					else:
						$contenu_texte[] = message ('Vous n\'avez pas de parrain' , FP_MESSAGE_ERROR );
					endif;
				else:
					mysql_query('INSERT INTO codesgratis_jeu_hasard VALUES ( '. $session_id .' , '. $ticket .' , '.time().' , '.$gain_jeu.'  ,  '.$my_membre->membre_id.'   )');
					$contenu_texte[] = 'ERREUR : le cout du ticket a été prelévé mais l\'actualisation des points a échouée';
				endif;
			endif;
		endif;
	endif;
	
	$contenu_texte[] = message ('Coût d\'une partie : <strong>20</strong> points plus. ' , FP_MESSAGE_INFOS);
	
	if($my_membre->membre_points_plus > 20):
		$contenu_texte[] = '<form method="post" action="jeu_hasard.php"><table><tr><th>Jouer une partie</th></tr><tr><td><input name="jouer" type="submit" value="Jouer"></td></tr></table></form>';
	else:
		$contenu_texte[] = message ('Vous n\'avez pas assez de points plus pour jouer. Voullez-vous en <strong><a href="cgcode_achat.php">acheter</a></strong> ?' , FP_MESSAGE_ERROR);
	endif;
	
	$contenu_texte[] = message ('Tous les coups vous font gagner des points (25 , 50 , 100 , 500 et finalement 1000 points).' , FP_MESSAGE_INFOS);					
	
	$parties_joues = sql_result('SELECT COUNT(membre_id) FROM codesgratis_jeu_hasard WHERE membre_id='.$my_membre->membre_id );
	
	$contenu_texte[] = message('Vous avez déjà joué : <strong>'.$parties_joues.'</strong> fois au jeu de hasard.', FP_MESSAGE_INFOS);
	
	hasard_recapitulatif($contenu_texte,$my_membre);
	hasard_stat($contenu_texte);
	
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
	
else:
	header('Location: connexion.php');
endif;
?>