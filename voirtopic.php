<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'forum' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');

error_reporting(E_ALL);

if(isset($_GET['sujet_id'])):
	
	$sujet_id = intval($_GET['sujet_id']);
	
	$ce_sujet = new fp_enregistrement('codesgratis_forum_sujets',$sujet_id,'sujet_id');
	if($ce_sujet->statut()):
	
		$ce_forum = new fp_enregistrement('codesgratis_forum_forums', $ce_sujet->forum_id,'forum_id');
							
		if($my_membre->statut()):
			if(isset($_POST['submit_message'])):
				$message_texte = stripslashes($_POST['message_texte']);
								
				$dernier_message_id = sql_result ('SELECT message_id FROM codesgratis_forum_messages ORDER BY message_id DESC LIMIT 1');
				$dernier_message = new fp_enregistrement ('codesgratis_forum_messages' , $dernier_message_id , 'message_id');
								
				if
					(
						$dernier_message->membre_id == $my_membre->membre_id && 
						(time() - $dernier_message->message_date < 15 )
					)
				:
					$sauvegarde_champ_message_texte = $message_texte;
					$message_texte= '';
					$contenu_texte[] = message ('Vous ne pouvez pas poster un nouveau message moins de 15 secondes après le précédent' , FP_MESSAGE_ERROR);
				endif;
								
								
				if
					(
						$dernier_message->message_texte == $message_texte && 
						$dernier_message->membre_id == $my_membre->membre_id
					)
				:
				
					$sauvegarde_champ_message_texte = $message_texte;
					$message_texte = ''; 
					$contenu_texte[] = message ('Vous avez déjà posté un message similaire dans ce sujet ' , FP_MESSAGE_INFOS);
				endif;
				
				if($message_texte != ''):
				
					if(isset($_POST['message_id'])):
							mysql_query('UPDATE codesgratis_forum_messages SET message_texte=\''. $message_texte .'\' WHERE message_id=\''. $_POST['message_id'] .'\'');
							echo '<p>Votre message a bien t dit !</p>';
					else:
						$sql = sql_insert 
							(
								'codesgratis_forum_messages' , 
								array 
								(	 
									'message_id' => 'NULL', 
									'sujet_id' => $ce_sujet->sujet_id , 
									'forum_id' => $ce_forum->forum_id , 
									'membre_id' => $my_membre->membre_id , 
									'message_texte' => sql_champ_texte ($message_texte) , 
									'message_date' => 'UNIX_TIMESTAMP()', 	
									'message_edit' => 0
								)
							)
						;
						if
							(
								mysql_query($sql)
							)
						:
											
							$contenu_texte[] = message ('Votre message a bien été enregistré ! Merci de votre participation sur le forum !' , FP_MESSAGE_INFOS);
						else:
							$contenu_texte[] = message ('Une erreur SQL est survenue lors de l\'enregistrement de votre message ['.mysql_error().'] ' , FP_MESSAGE_ERROR);
							$contenu_texte[] = message_admin ($sql , FP_MESSAGE_ERROR);
						endif;
					endif;
				endif;
			endif;
		endif;
		
		
		
		$contenu_texte[] = 	'<h1>Le forum de CodesGratis : '.$ce_forum->forum_nom.'</h1>';	
		$contenu_texte[] =	'<p><a href="forum.php">Index du forum</a> -> <a href="voirforum.php?forum_id='.$ce_forum->forum_id.'">'.$ce_forum->forum_nom.'</a> -> ' . $ce_sujet->sujet_nom . '</p>';	
		
		$infos = sql_limiteur
			(
				array
				(
					'unit_par_page'=>15,
					'table'=>'codesgratis_forum_messages',
					'table_compteur'=>'message_id',
					'where_condition' => 
						array
						( 
							0 => array
								(
									'champ' => 'sujet_id',
									'valeur' => $ce_sujet->sujet_id,
									'condition' => '=',
									'valeur_type' => 'nombre'
								)
							,
						)
				)
			)
		;
		
		$res_messages = mysql_query('SELECT * FROM codesgratis_forum_messages WHERE sujet_id='. $ce_sujet->sujet_id .' ORDER BY sujet_id LIMIT '. $infos['limit']);
		$liste_messages = array();
		$liste_auteur = array();
		while($sql_message = mysql_fetch_array($res_messages,MYSQL_ASSOC)):
			$liste_messages[$sql_message['message_id']] = new fp_enregistrement_sql($sql_message,'codesgratis_forum_messages','message_id');
			$liste_auteur[$sql_message['membre_id']] = $sql_message['membre_id'] ;
		endwhile;
		
		$liste_auteur[$ce_sujet->membre_id] = $ce_sujet->membre_id;
		$liste_membre = sql_list
			(
				array
				(
					'table' => 'codesgratis_membres',
					'table_id' => 'membre_id',
					'liste' => $liste_auteur
				)
			)
		;
		$contenu_texte = array_merge($contenu_texte , $infos['pagination']);
		if($ce_sujet->sujet_message!=''):
			$contenu_texte = array_merge($contenu_texte,afficher_sujet_message($ce_sujet,$liste_membre[$ce_sujet->membre_id]));
		endif;
		foreach($liste_messages as $message):
			$contenu_texte = array_merge($contenu_texte,afficher_message($message,$liste_membre[$message->membre_id]));
		endforeach;
		$contenu_texte = array_merge($contenu_texte , $infos['pagination']);
		$contenu_texte = array_merge($contenu_texte , nouveau_message());
		$contenu_script [] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
		$contenu_script [] = '<script type="text/javascript" src="html/javascripts/bbcode.js"></script>';
	else:
		header('Location: forum.php');
		exit();
	endif;
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>