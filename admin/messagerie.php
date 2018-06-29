<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');

if(is_admin($my_membre)):

	$contenu_texte[] = '<div class="item_titre"><h1>Liste des messages dans la messagerie</h1></div>';
	$contenu_texte[] = '<div class="item_contenu">';
	if
		(
			isset($_GET['message_id'])
		)
	:
		$ce_message = new fp_enregistrement ('codesgratis_messagerie',intval($_GET['message_id']) ,   'message_id');
		if
			(
				$ce_message->statut()
			)
		:
			if
				(
					isset($_POST['message_texte'])
				)
			:
				$ce_message->message_texte = stripslashes($_POST['message_texte']);
			endif;
			
			if
				(
					isset($_POST['message_sujet'])
				)
			:
				$ce_message->message_sujet = stripslashes($_POST['message_sujet']);
			endif;
			
			if
				(
					isset($_POST['message_supprimer'])
				)
			:
				$ce_message->delete();
			endif;
			
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
			$contenu_texte[] = '<tr><th>Champ</th><th>Valeur</th><th>Aperçu</th></tr>';
			$contenu_texte[] = '<tr><td>Message_id</td><td>'.$ce_message->message_id.'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><td>Expéditeur</td><td>'. $ce_message->message_from_id .'</td></tr>';
			$contenu_texte[] = '<tr><td>Destinataire</td><td>'. $ce_message->message_to_id .'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><td>Sujet</td><td><textarea id="message_sujet" name="message_sujet" rows="10" cols="100">'.$ce_message->message_sujet.'</textarea><td>'. bbcode_replace(nl2br($ce_message->message_sujet)) .'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><td>Message</td><td><textarea id="message_texte" name="message_texte" rows="10" cols="100">'.$ce_message->message_texte.'</textarea></td><td>'. bbcode_replace(nl2br($ce_message->message_texte)) .'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><td>Code ?</td><td>'. $ce_message->message_code .'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><td>date</td><td>'. $ce_message->message_date .'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><td>Expéditeur LU ?</td><td>'. $ce_message->message_from_lu .'</td></tr>';
			$contenu_texte[] = '<tr><td>Destinataire LU ?</td><td>'. $ce_message->message_to_lu .'</td></tr>';
			$contenu_texte[] = '<tr><td>Expéditeur SUPP ?</td><td>'. $ce_message->message_from_statut .'</td></tr>';
			$contenu_texte[] = '<tr><td>Destinataire SUPP ?</td><td>'. $ce_message->message_to_statut .'</td></tr>';
			/**/
			$contenu_texte[] = '<tr><th colspan="3"><input type="submit" value="Modifier"></th></tr>';
			$contenu_texte[] = '<tr><th colspan="3"><input type="submit" name="message_supprimer" id="message_supprimer" value="supprimer"></th></tr>';
			$contenu_texte[] = '</form>';
			$contenu_texte[] = '</table>';
		endif;
		$contenu_texte[] = '<a href="'.page_courante(array(),true).'">Retour</a>';
		
	else:
		
		$infos = sql_limiteur 
			(
				array
				(
					'unit_par_page'=>50,
					'table'=>'codesgratis_messagerie',
					'table_compteur'=>'message_id'
				)
			)
		;
		$tri = isset($_GET['tri']) ? $_GET['tri'] :  'message_id';
		$sens = isset($_GET['sens']) ? $_GET['sens'] : 'DESC';
		$autre_sens = ($sens=='DESC') ? 'ASC' : 'DESC';
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr><th><a href="'.page_courante(array('tri'=>'message_id','sens'=> $autre_sens)).'">ID</a></th><th>Titre</th><th><a href="'.page_courante(array('tri'=>'message_from_id','sens'=> $autre_sens)).'">Expéditeur</a></th><th><a href="'.page_courante(array('tri'=>'message_to_id','sens'=> $autre_sens)).'">Destinataire</a></th><th>Date</th></tr>';
		$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie ORDER BY '.$tri.' '.$sens.' , message_date DESC LIMIT ' . $infos['limit']);
	
		while
			(
				$donnees = mysql_fetch_array($res_messages)
			)
		:
	
			$contenu_texte = array_merge($contenu_texte,afficher_resume_admin2(new fp_enregistrement_sql($donnees,'codesgratis_messagerie','message_id')));
		endwhile;
		$contenu_texte[] = '</table>';
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
		$contenu_texte[] = '</div>';
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	header('Location: ../index.php');
endif;
?>