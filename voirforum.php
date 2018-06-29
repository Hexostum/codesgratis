<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'forum.php');

if(isset($_GET['forum_id'])):

	$forum_id = intval($_GET['forum_id']);
	
	$ce_forum = new fp_enregistrement('codesgratis_forum_forums', $forum_id, 'forum_id');		
					
	if($ce_forum->statut()):
		if
			(
				isset($_POST['submit_sujet'])
			)
		:
		
			$sujet_nom = $_POST['sujet_nom'];
			$sujet_description = $_POST['sujet_description'];
			$sujet_message = $_POST['sujet_message'];
				
			if
				( 
					!empty($sujet_nom) && 
					!empty($sujet_description) && 
					!empty($sujet_message)
				)
			:
			
				$sql = sql_insert
					(
						'codesgratis_forum_sujets', 
						array
							(
								'sujet_id' => 'NULL',
								'forum_id' => $ce_forum->forum_id ,
								'membre_id' => $my_membre->membre_id ,
								'sujet_nom' => sql_champ_texte($sujet_nom),
								'sujet_description' => sql_champ_texte($sujet_description),
								'sujet_message'=> sql_champ_texte($sujet_message),
								'sujet_vu' => 0,
								'sujet_date' => 'UNIX_TIMESTAMP()',
								'sujet_last_date' => 'UNIX_TIMESTAMP()',
								
							)
					)
				;
				if(is_admin($my_membre)):
					$contenu_texte[] = message ( $sql , FP_MESSAGE_INFOS);
				endif;
				if
					( 
						mysql_query($sql)
					)
				:
					$contenu_texte[] = message ( 'Votre sujet a bien été créé ! Merci de votre participation sur le forum !' , FP_MESSAGE_INFOS);
				else:
					$contenu_texte[] = message ( 'Une erreur est survenue lors de l\'enregistrement du nouveau sujet ['.$sql.'] ['.mysql_error().']' , FP_MESSAGE_ERROR);
				endif;
			endif;
		endif;
							
	
							
		$liste_sujets = array();
		
		$infos = sql_limiteur
			(
				array
				(
					'unit_par_page'=>20,
					'table'=>'codesgratis_forum_sujets',
					'table_compteur'=>'sujet_id',
					'where_condition' => array(0=> array('valeur_type'=>'nombre','condition'=> '=','champ' => 'forum_id' ,'valeur'=> $ce_forum->forum_id ))
				)
			)
		;
		
		$contenu_texte[] = 	'<h1>Le forum de CodesGratis : '.$ce_forum->forum_nom.'</h1>';	
		$contenu_texte[] =	'<p><a href="forum.php">Index du forum</a> -> '.$ce_forum->forum_nom.'</p>';	
		
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);

		$contenu_texte[] = '<table>';
						
		$contenu_texte[] = '	<tr>';
		$contenu_texte[] = '		<th>Sujet</th>';
		$contenu_texte[] = '		<th>Auteur</th>';
		$contenu_texte[] = '		<th>Messages</th>';
		$contenu_texte[] = '		<th>Vu</th>';
		/**/
		$contenu_texte[] = '		<th>Dernier message</th>';
		/**/
		$contenu_texte[] = '	</tr>';
		
		$retour = mysql_query('SELECT * FROM codesgratis_forum_sujets WHERE forum_id='. $ce_forum->forum_id . ' ORDER BY sujet_last_date DESC  LIMIT ' . $infos['limit'] ); 
		
		while($sql_sujet = mysql_fetch_array($retour, MYSQL_ASSOC)):
			$liste_sujets[$sql_sujet['sujet_id']] = $sql_sujet;
			$liste_sujets[$sql_sujet['sujet_id']]['messages_nombre'] = 0;
			$liste_sujets_ids[] = $sql_sujet['sujet_id'];
		endwhile;
		$nombre_sujets = sql_list
			(
				array
				(
					'table'=>'codesgratis_forum_messages',
					'table_id'=>'sujet_id',
					'liste' => $liste_sujets_ids,
					'select' => ' sujet_id , count(message_id) ',
					'group_by'=> 'sujet_id'
				)
			)
		;
		foreach($nombre_sujets as $valeur):
			$liste_sujets[$valeur->sujet_id]['messages_nombre'] = $valeur->valeur_champ('count(message_id)');
		endforeach;
		
		/**/
		$message = sql_list
			(
				array
				(
					'table'=>'codesgratis_forum_messages',
					'table_id'=>'sujet_id',
					'liste' => $liste_sujets_ids,
					'select' => ' sujet_id , max(message_id) as last_message_id ',
					'group_by'=> ' sujet_id',
					'order_by'=> 'message_id DESC'
				)
			)
		;
		/**/
		$last_message_id = array();
		foreach($message as $valeur):
			$last_message_id[$valeur->sujet_id] = $valeur->last_message_id;
		endforeach;
		
		/**/
		/**/
		$_infos = sql_list 
		(
				array
				(
					'table'=>'codesgratis_forum_messages',
					'table_id'=>'message_id',
					'clef_tableau'=>'sujet_id',
					'liste' => $last_message_id,
					'select' => ' sujet_id, message_id , membre_id, message_date '
				)
			)
		;
		
		foreach($_infos as $valeur):
			$liste_sujets[$valeur->sujet_id]['last_membre_id'] = $valeur->membre_id;
			$liste_sujets[$valeur->sujet_id]['last_date'] = $valeur->message_date;
		endforeach;
		
		$new_l_sujets = array();
		foreach($liste_sujets as $sujet0):
			if(isset($sujet0['last_date'])):
				$new_l_sujets[$sujet0['last_date']] = $sujet0;
			else:
				$new_l_sujets[$sujet0['sujet_date']] = $sujet0;
				$new_l_sujets[$sujet0['sujet_date']]['last_date'] = $sujet0['sujet_date'];
				$new_l_sujets[$sujet0['sujet_date']]['last_membre_id'] = $sujet0['membre_id'];
			endif;
		endforeach;
		
		krsort($new_l_sujets);
		
		foreach($new_l_sujets as $sujet):
		/**
		foreach($liste_sujets as $sujet):
		/**/
			$contenu_texte = array_merge($contenu_texte ,  afficher_sujet($sujet));
		endforeach;
		$contenu_texte[] = '</table>';
		/**/
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
		
					
		if($my_membre->membre_existe()):
			if
				(
					($forum_id != 9) && 
					($forum_id != 20)
				)
			:
				$contenu_texte = array_merge($contenu_texte,nouveau_sujet(0));
			elseif
				(
					$forum_id == 20 && 
					(
						is_admin($my_membre) || 
						$my_membre->membre_pseudo == 'taz06' || 
						$my_membre->membre_pseudo == 'nicoblue' || 
						$my_membre->membre_pseudo == 'fredyzzz'
					)
				):
				$contenu_texte = array_merge($contenu_texte,nouveau_sujet(0));
			endif;
		endif;
	else:
		header('Location: forum.php');
	endif;
endif;
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/bbcode.js"></script>';
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>