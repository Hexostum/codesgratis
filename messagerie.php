<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');

if($my_membre->membre_existe()):

	$contenu_texte[] = '<h1>Messagerie de CodesGratis</h1>';
		
	$contenu_texte[] = '<ul>';
	$contenu_texte[] = '	<li><a href="messagerie.php?mode=from" title="Voir vos messages reçus">Messages reçus</a></li>';
	$contenu_texte[] = '	<li><a href="messagerie.php?mode=to" title="Voir vos messages envoyés">Messages envoyés</a></li>';
	$contenu_texte[] = '	<li><a href="messagerie.php?mode=nouveau" title="Voir vos messages envoyés">Ecrire un message</a></li>';
	$contenu_texte[] = '</ul>';
	
	if(isset($_POST['submit_message'])):
		if($_GET['mode']=='support'):
			$destinataire = 0;
			$destinataire = new fp_membre($destinataire);
		else:
			$destinataire = trim($_POST['destinataire']);
			if(is_numeric($destinataire)):
				$destinataire = intval($destinataire);
				$destinataire = new fp_membre($destinataire);
			else:
				$destinataire = new fp_membre(sql_champ_texte($destinataire),'membre_pseudo');
			endif;
		endif;
		$sujet = trim($_POST['sujet']);
		$message = trim($_POST['message']);
				
		
					
		if(!$destinataire->membre_existe()):
			$contenu_texte[] =  message ('Le destinataire que vous avez spécifié est introuvable. Votre message n\'a pas pu être envoyé.' , FP_MESSAGE_ERROR );
			
		elseif($destinataire->membre_id==$my_membre->membre_id):
			if(envoyer_message ( $my_membre->membre_id, $destinataire->membre_id , $sujet , $message )):
				$contenu_texte[] =  message ('Vous vous êtes envoyés un message !' , FP_MESSAGE_REPONSE ) ;
			else:
				$contenu_texte[] = message ('Une erreur est survenue lors de l\'envoie du message privé ' , FP_MESSAGE_ERROR);
			endif;
		else:
			if(envoyer_message ( $my_membre->membre_id, $destinataire->membre_id , $sujet , $message )):
				$contenu_texte[] = message ('Votre message a bien été envoyé à '. $destinataire->membre_pseudo .' !' , FP_MESSAGE_INFOS) ;
			else:
				$contenu_texte[] = message ('Une erreur est survenue lors de l\'envoie du message privé ' , FP_MESSAGE_ERROR);
			endif;
		endif;
	endif;
	
	if(isset($_POST['submit_lu'])):
		$sql = 'UPDATE codesgratis_messagerie set message_to_lu=1 where message_id in ('.implode (' , ' , $_POST['check_message']).')';
		if(mysql_query($sql)):
			$contenu_texte[] = message('Les messages ont bien été marqués comme lus' , FP_MESSAGE_INFOS);
		else:
			$contenu_texte[] = message('Une erreur est survenue' , FP_MESSAGE_ERROR);
			$contenu_texte[] = message_admin($sql . mysql_error(), FP_MESSAGE_ERROR);
		endif;
	endif;
	
	if(isset($_POST['submit_supprimer'])):
		$sql = 'UPDATE codesgratis_messagerie set message_to_statut=0 where message_id in ('.implode (' , ' , $_POST['check_message']).')';
		if(mysql_query($sql)):
			$contenu_texte[] = message('Les messages ont bien été supprimés' , FP_MESSAGE_INFOS);
		else:
			$contenu_texte[] = message('Une erreur est survenue' , FP_MESSAGE_ERROR);
			$contenu_texte[] = message_admin($sql . mysql_error(), FP_MESSAGE_ERROR);
		endif;
	endif;
	
	$contenu_texte[] = '<table>';
	
	switch(@$_GET['mode']):
		case 'from':
		default: 
			$contenu_texte[] = '<form action="'.page_courante().'" method="post">';	
			$contenu_texte[] = '<tr><th colspan="4">Message(s) non lu(s)</th></tr>';
			// En premier on met les messages non lus 
			$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie WHERE message_to_id='. $my_membre->membre_id .' and message_code=0 and message_to_lu=0 and message_to_statut=1 ORDER BY message_id  DESC');
			while($donnees = mysql_fetch_array($res_messages)):
				afficher_resume($contenu_texte,$donnees);
			endwhile;
			$contenu_texte[] = '<tr><th colspan="4"><input type="submit" name="submit_lu" id="submit_lu" value="Marquer les messages selectionnés comme lus"></th></tr>';
			
			$contenu_texte[] = '<tr><th colspan="4">Message(s) lu(s)</th></tr>';
			// Ensuite les messages lus
			$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie WHERE message_to_id='. $my_membre->membre_id .' and message_code=0 and message_to_lu=1 and message_to_statut=1 ORDER BY message_from_id , message_id  DESC');
			while($donnees = mysql_fetch_array($res_messages)):
				afficher_resume($contenu_texte,$donnees);
			endwhile;
			$contenu_texte[] = '<tr><th colspan="4"><input type="submit" name="submit_supprimer" id="submit_supprimer" value="Supprimer les messages selectionnés"></th></tr>';
		break;
		case 'to':
			// On récupère les messages
			$contenu_texte[] = '<tr><th colspan="4">Message(s) non lu(s)</th></tr>';
			$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie WHERE message_from_id='. $my_membre->membre_id .' and message_code=0 AND message_from_lu=0 and message_from_statut=1 ORDER BY message_id DESC');
			while($donnees = mysql_fetch_array($res_messages)):
				afficher_resume($contenu_texte,$donnees,true);
			endwhile;
			$contenu_texte[] = '<tr><th colspan="4">Message(s) lu(s)</th></tr>';
			// On récupère les messages
			$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie WHERE message_from_id='. $my_membre->membre_id .' and message_code=0 AND message_from_lu=1 and message_from_statut=1 ORDER BY message_to_id, message_id DESC');
			while($donnees = mysql_fetch_array($res_messages)):
				afficher_resume($contenu_texte,$donnees,true);
			endwhile;
		break;
		
		case 'message':
			$message = new fp_enregistrement('codesgratis_messagerie',intval($_GET['message_id']),'message_id');
			if($message->statut()):
				$flag_to = ($message->message_to_id==$my_membre->membre_id);
				$flag_from = ($message->message_from_id==$my_membre->membre_id);
				if( $flag_from || $flag_to  ):
					if(isset($_POST['s_supprimer_message'])):
						if($flag_from):
							$message->message_from_statut = 0;
						endif;
					
						if($flag_to):
							$message->message_to_statut = 0;
						endif;
						
					else:
					
						if($flag_from):
							$message->message_from_lu = 1;
						endif;
					
						if($flag_to):
							$message->message_to_lu = 1;
						endif;
					
						$cet_auteur = new fp_membre($message->message_from_id);
						$contenu_texte = array_merge($contenu_texte,afficher_message($cet_auteur,$message));
						if($flag_to):
							form_repondre($contenu_texte,$message);
						endif;
					endif;
				else:
					$contenu_texte[] = '<h2>Vous n\'avez pas les droits suffisants pour lire ce message<h2>';
				endif;
			else:
				$contenu_texte[] = '<h2>Ce message n\'existe pas<h2>';
			endif;
		break;
		case 'support':
			$contenu_texte[] = message('Votre message a été envoyé au support' ,FP_MESSAGE_INFOS);
		break;
		case 'nouveau':
			form_nouveau($contenu_texte);
		break;
	endswitch;
	
	$contenu_texte[] = '</table>';
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>