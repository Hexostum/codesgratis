<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'clans' . '.php');

if($my_membre->membre_existe()):
	$my_clan = new fp_enregistrement('codesgratis_clans',$my_membre->membre_clan_id,'clan_id');

	if($my_clan->statut()):
		$message = '';
		renouvellement_clan();
		$res_concours = mysql_query('SELECT * FROM codesgratis_concours ORDER BY concours_id DESC LIMIT 1');
		$sql_concours = mysql_fetch_array($res_concours,MYSQL_ASSOC);
		$ce_concours = new fp_enregistrement_sql($sql_concours,'codesgratis_concours','concours_id');
		if(isset($_POST['submit_candidature_accepter'])):

			$candidat_id = intval($_POST['membre_id']);
			$candidat = new fp_membre($candidat_id,'membre_id');
			if($candidat->statut()):
				if
					(
						mysql_num_rows(mysql_query("SELECT * FROM codesgratis_clans_candidatures WHERE clan_id='". $my_clan->clan_id ."' AND membre_id='$candidat_id'")) == 1
					)
				:
					
					$candidat->membre_clan_id = $my_clan->clan_id;
					mysql_query('DELETE FROM codesgratis_clans_candidatures WHERE membre_id='. $candidat_id);
					$message .= '<p style="color:green">'. $candidat->membre_pseudo .' fait maintenant partie de votre clan !</p>';
				else:
					$message .= '<p style="color:red">Le membre '. $candidat->membre_pseudo .' n\'est pas candidat à l\'entrée dans votre clan.</p>';
				endif;
			else:
				$message .= '<p style="color:red">Le membre spécifié n\'existe pas dans la base de données.</p>';
			endif;
		endif;
		
		if(isset($_POST['submit_candidature_refuser'])):
			$candidat_id = intval($_POST['membre_id']);
			$candidat = new fp_membre($candidat_id,'membre_id');
			if($candidat->statut()):
				if
					(
						mysql_num_rows(mysql_query("SELECT * FROM codesgratis_clans_candidatures WHERE clan_id='". $my_clan->clan_id ."' AND membre_id='$candidat_id'")) == 1
					)
				:
					
					mysql_query('DELETE FROM codesgratis_clans_candidatures WHERE clan_id='. $my_clan->clan_id .' AND membre_id='. $candidat_id );
					$message .= '<p style="color:green">La candidature de '. $candidat->membre_pseudo .' a bien été rejetée.</p>';
				else:
					$message .= '<p style="color:red">Le membre '. $candidat->membre_pseudo .' n\'est pas candidat à l\'entrée dans votre clan.</p>';
				endif;
			else:
				$message .= '<p style="color:red">Le membre spécifié n\'existe pas dans la base de données.</p>';
			endif;
		endif;
			
		if(isset($_POST['submit_supprimer_clan'])):
			if(isset($_POST['confirm_supprimer'])):
				$my_clan->clan_motivation = '--clan supprimé--';
				$my_clan->clan_fondation = null;
				$my_clan->membre_id = null;
				mysql_query('DELETE FROM codesgratis_clans_candidatures WHERE clan_id='. $my_clan->clan_id );
				mysql_query('UPDATE codesgratis_membres SET membre_clan_id=NULL WHERE membre_clan_id='.$my_clan->clan_id);	
			endif;
		endif;
			
		if(isset($_POST['submit_exclure'])):
	
			if(/**/ date('w') >= '3' &&  date('w') <= '6' /**/ ):
	
				$membre_id = intval($_POST['membre_id']);
		
				$clan_membre = new fp_membre($membre_id,'membre_id');		
				
				if($clan_membre->membre_clan_id==$my_clan->clan_id):
					if($nb_cgcodes_valides_joueur <= 0):
						$clan_membre->membre_clan_id=null;
							
						$message .='<p style="color:green">Vous venez d\'exclure '. $clan_membre->membre_pseudo .' de votre clan.</p>';
					else:
						$message .= '<p style="color:red">'. $clan_membre->membre_pseudo .' a validé au moins un CGcode cette semaine, et vous ne pouvez donc pas l\'exclure de votre clan.</p>';
					endif;
				endif;
			else:
				$message .= '<p style="color:red">Vous ne pouvez exclure des membres de votre clan que du mercredi au vendredi.</p>';
			endif;
		endif;
		
		if($my_clan->membre_id==$my_membre->membre_id):
			
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th colspan="2">Votre clan sur CodesGratis</th></tr>';
			$contenu_texte[] = '<tr><td>Rang</td><td>fondateur</td>';
			$contenu_texte[] = '<tr><td>Fondation</td><td>'.date('d/m/Y à H\hi', $my_clan->clan_fondation).'</td></tr>';
			$contenu_texte[] = '<tr><td>Membres</td><td>'.sql_result('SELECT count(membre_id) FROM codesgratis_membres WHERE membre_clan_id='. $my_clan->clan_id).'</td></tr>';
			$contenu_texte[] = '<tr><td>Points</td><td>' . $my_clan->clan_points. '</td></tr>';
			$contenu_texte[] = '</table>';

			$joueurs_clan = '';
					
			$res_clans_membres = mysql_query('SELECT * FROM codesgratis_membres WHERE membre_clan_id='. $my_clan->clan_id );
			
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th>Pseudo</th><th>Points</th><th>Exclure</th>';
				
			while($sql_clans_membres = mysql_fetch_array($res_clans_membres,MYSQL_ASSOC)):
				$ce_membre = new fp_membre_sql($sql_clans_membres);
				
				$points = sql_result('SELECT sum(clan_points) FROM codesgratis_clan_points WHERE membre_id='.$ce_membre->membre_id.' AND points_date > '.$ce_concours->concours_debut.' AND points_date < ' . $ce_concours->concours_fin );
				
					
				if( /**/ (date('w') >= '3' && date('w') <= '6') && /**/ ($ce_membre->membre_id != $my_membre->membre_id) ):
					$joueurs_clan .= 
					'<form method="post" action="clans_gestion.php">
						<input type="hidden" name="membre_id" value="'. $ce_membre->membre_id .'">
						<input type="submit" id="submit_exclure" name="submit_exclure" value="Exclure du clan">
					</form>';
					
				endif;
				$contenu_texte[] = '<tr><td>'.$ce_membre->membre_pseudo.'</td><td>'.$points.'</td><td>'.$joueurs_clan.'</td></tr>';
			endwhile;
			
			$contenu_texte[] = '</table>';

			$res_clans_candidatures = mysql_query('SELECT * FROM codesgratis_clans_candidatures WHERE clan_id='. $my_clan->clan_id);
				
			if(mysql_num_rows($res_clans_membres) < 5 && mysql_num_rows($res_clans_candidatures) > 0):

				$contenu_texte[] = '<p>Vous avez ' . mysql_num_rows($res_clans_candidatures).' candidatures :</p>';
					
				$contenu_texte[] = '<table>';
				$contenu_texte[] = '<tr>';
				$contenu_texte[] = '<th>Membre</th>';
				$contenu_texte[] = '<th>Nombre de points</th>';
				/**
				$contenu_texte[] = '<th>Commandes</th>';
				/**/
				$contenu_texte[] = '<th>Accepter</th>';
				$contenu_texte[] = '<th>Refuser</th>';
				$contenu_texte[] = '</tr>';

				while($sql_candidat = mysql_fetch_array($res_clans_candidatures)):
					$candidat = new fp_membre($sql_candidat['membre_id'],'membre_id');

					$contenu_texte[] = '<tr>';
					$contenu_texte[] = '<td>';
					$contenu_texte[] = $candidat->membre_pseudo;
					$contenu_texte[] = '<br>';
					if($candidat->membre_vip > 0):
						$contenu_texte[] = '<img src="html/images/vip/vip' . $candidat->membre_vip . '.png" alt="V.I.P. ' . $candidat->membre_vip.'">';
					else:
						$contenu_texte[] = '<img src="html/images/vip/non_vip.png" alt="Non V.I.P.">';
					endif;
					$contenu_texte[] = '</td>';
					$contenu_texte[] = '<td>' . $candidat->membre_points.'</td>';
					/**
					$contenu_texte[] = '<td>' . $candidat->membre_commandes.'</td>';
					/**/
					$contenu_texte[] = '<td>';
					$contenu_texte[] = '<form method="post" action="clans_gestion.php">';
					$contenu_texte[] = '<input type="hidden" name="membre_id" value="' . $candidat->membre_id.'">';
					$contenu_texte[] = '<input type="submit" id="submit_candidature_accepter" name="submit_candidature_accepter" value="Accepter">';
					$contenu_texte[] = '</form>';
					$contenu_texte[] = '</td>';
					$contenu_texte[] = '<td>';
					$contenu_texte[] = '<form method="post" action="clans_gestion.php">';
					$contenu_texte[] = '<input type="hidden" name="membre_id" value="' . $candidat->membre_id.'">';
					$contenu_texte[] = '<input type="submit" id="submit_candidature_refuser" name="submit_candidature_refuser" value="Refuser">';
					$contenu_texte[] = '</form>';
					$contenu_texte[] = '</td>';
					$contenu_texte[] = '</tr>';
				endwhile;
				$contenu_texte[] = '</table>';
			endif;
	
			if(mysql_num_rows($res_clans_membres) == 1):
				
				$contenu_texte[] = '<p>Vous êtes encore seul(e) dans votre clan, et il est encore temps de stopper l\'aventure, si';
				$contenu_texte[] = 'vous le désirez. Pour cela, il suffit de cliquer sur le bouton qui suit, et votre clan ne'; 
				$contenu_texte[] = 'sera plus :</p>';
					
				$contenu_texte[] = '<center>';
				$contenu_texte[] = '<form method="post" action="clans_gestion.php">';
				$contenu_texte[] = '<input type="checkbox" name="confirm_supprimer" id="confirm_supprimer">';
				$contenu_texte[] = '<label for="confirm_supprimer">Oui, Je veux supprimer mon clan.</label><br>';
				$contenu_texte[] = '<input id="submit_supprimer_clan" name="submit_supprimer_clan" type="submit" value="Supprimer mon clan">';
				$contenu_texte[] = '</form>';
				$contenu_texte[] = '</center>';
			endif;
		else:
			// Suppression du clan OK
			header('Location: clans_recrutement.php');
		endif;
	else:
		header('Location: clans_recrutement.php');
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>