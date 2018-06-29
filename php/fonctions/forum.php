<?php
function supprimer_message($message_id,$ce_membre)
{
	$message = new fp_enregistrement('codesgratis_forum_posts',$message_id,'id');
	
	if($message->statut()):
		if( ($message->auteur==$ce_membre->membre_pseudo)  || ($ce_membre->membre_pseudo=='FLo') ):
	
			if($_POST['check_supprimer'] == 'supprimer_message_ok'):
				$message->delete();
				return '<p>Votre message a été supprimé avec succès.</p>';
			else:
				return '<p>Votre message n\'a pas été supprimé.</p>';
			endif;
		endif;
	endif;
}
function confirm_supprimer_message($message_id,$ce_membre)
{
	$message = new fp_enregistrement('codesgratis_forum_posts',$message_id,'id');
	
	if($message->statut()):
		if( ($message->auteur==$ce_membre->membre_pseudo)  || ($ce_membre->membre_pseudo=='FLo') ):
?>
			<p>Vous êtes sur le point de supprimer l'un de vos messages. Confirmer ?</p><br>								
			<form method="post" action="voirtopic.php?sujet_id=<?php echo $message_id->forum; ?>&message_id=<?php echo $message_id->id; ?>">
				<label for="check_supprimer">Oui, supprimer mon message.</label><input type="checkbox" name="check_supprimer" value="supprimer_message_ok">
				<input type="submit" value="Confirmer la réponse (laissez la case vide pour annuler)">
			</form>
<?php
		endif;
	endif;
}
function afficher_categorie($sql_categorie,$forums)
{
	$texte = array();
	$texte[] = '<tr class="forum_categorie">';
	$texte[] = '<th colspan="4">'.$sql_categorie['cat_texte'].'</th>';
	$texte[] = '</tr>';
	foreach($forums as $forum):
		$texte = array_merge($texte,afficher_forum($forum));
	endforeach;	
	return $texte;
}
function afficher_forum($forum)
{
	$texte[] = '<tr class="forum_forum">';
	$texte[] = '<td style="width:55%">';
	$texte[] = '<a href="voirforum.php?forum_id=' . $forum['forum_id'].'" class="nom_forum">'. $forum['forum_nom'] . '</a>';
	$texte[] = '<br>';
	$texte[] = '<span class="description_forum">' . $forum['forum_description'] . '</span>';
	$texte[] = '</td>';
	$texte[] = '<td style="width:10%">';
	$texte[] = $forum['sujets'] .' sujets. ';
	$texte[] = '</td>';
	$texte[] = '<td style="width:10%">';
	$texte[] = $forum['messages'] .' messages.';
	$texte[] = '</td>';
	/**/
	$texte[] = '<td style="width:25%">';
	$texte[] = '</td>';
	/**/
	$texte[] = '</tr>';
	return $texte;
}
function afficher_sujet($sujet)
{
	$texte[] = '<tr>';
	$texte[] = '<td style="width:75%">';
	$texte[] = '<div class="sujet_nom"><a href="voirtopic.php?sujet_id='.$sujet['sujet_id'].'" class="nom_topic">'.strip_tags(stripslashes($sujet['sujet_nom'])).'</a></div>';
	$texte[] = '<div class="sujet_description">'.bbcode_replace(stripslashes(strip_tags($sujet['sujet_description']))).'</div>';
	$texte[] = '</td>';
	$texte[] = '<td><a href="membre.php?_membre_id='.$sujet['membre_id'].'">'.$GLOBALS['cache_membre_pseudo'][$sujet['membre_id']].'</a></td>';
	$texte[] = '<td style="width:15%">'.$sujet['messages_nombre'].'</td>';
	$texte[] = '<td style="width:5%">'.$sujet['sujet_vu'].'</td>';
	/**/
	$texte[] = '<td style="width:25%">';
	if(isset($sujet['last_membre_id'])):
		$page_cible = ceil($sujet['messages_nombre']/15) - 1;
		$texte[] = '<a href="voirtopic.php?sujet_id='. $sujet['sujet_id'] .'&amp;page='. $page_cible .'">
									'. $GLOBALS['cache_membre_pseudo'][$sujet['last_membre_id']].'<br> 
									'.format_date($sujet['last_date']).'</a>';
	else:
		$texte[] =  'N/A';
	endif;
	$texte[] = '</td>';
	/**/
	$texte[] = '</tr>';
	return $texte;
}
function afficher_sujet_message($ce_sujet,$cet_auteur)
{
	$texte[] = '<table>';
	$texte[] = '<tr>';
	$texte[] = '<th colspan="2">';
	
	$texte[] = format_date($ce_sujet->sujet_date);
	/**
	if(droit('edit',$ce_message,$cet_auteur)): 
		$texte[] = '<a href="?sujet_id='. $_GET['sujet_id'].'&amp;message_id='. $ce_message->message_id.'&amp;mode=editer" class="float1">Editer</a>';
	endif;
	if(droit('supprimer',$ce_message,$cet_auteur)):
		$texte[] = '<a href="?sujet_id='. $_GET['sujet_id'].'&amp;message_id='.  $ce_message->message_id.'&amp;mode=supprimer" class="float1">Supprimer</a>';
	endif;
	/**/
	$texte[] = '</th>';
	$texte[] = '</tr>';
	
	$texte[] = '<tr>';
	$texte[] = '<td width="150">';
	$texte[] = membre_pseudo ($cet_auteur->membre_id);
	$texte[] = membre_avatar ($cet_auteur);
	$texte = array_merge ($texte , membre_vip ($cet_auteur));
	$texte[] = '</td>';
								
	$texte[] = '<td>';
	$texte[] = bbcode_replace( stripslashes($ce_sujet->sujet_message) ); 
	$texte[] = '</td>';
	$texte[] = '</tr>';
							
	if($cet_auteur->membre_signature  != NULL):
		$texte[] = '<tr>';
		$texte[] = '<td colspan="2">';
		$texte[] = bbcode_replace( stripslashes($cet_auteur->membre_signature) ); 
		$texte[] = '</td>';
		$texte[] = '</tr>';							
	endif;
				
	$texte[] = '</table>';
	return $texte;
	
}
function nouveau_sujet($message)
{
	$texte[] = '<form method="post" action="'.page_courante().'">';
	$texte[] = '<table>';
	$texte[] = '<tr><th colspan="3">Créer un nouveau sujet :</th></tr>';
	$texte[] = '<tr>';
	$texte[] = '<td><label for="sujet_nom">Nom de votre sujet :</label></td>';
	$texte[] = '<td><input class="bbcode" type="text" name="sujet_nom" id="sujet_nom" maxlength="255" value="Nom du sujet"></td>';
	$texte[] = '<td><p id="sujet_nom_infos"></p></td>';
	$texte[] = '</tr>';	
	$texte[] = '<tr>';
	$texte[] = '<td><label for="sujet_description">description de votre sujet :</label></td>';
	$texte[] = '<td><input class="bbcode" type="text" name="sujet_description" id="sujet_description" maxlength="255" value="description du sujet"></td>';
	$texte[] = '<td><p id="sujet_description_infos"></p></td>';
	$texte[] = '</tr>';	
	$texte[] = '<tr>';
	$texte[] = '<td><label for="sujet_message">description de votre sujet :</label></td>';
	$texte[] = '<td><textarea class="bbcode" name="sujet_message" id="sujet_message"></textarea></td>';
	$texte[] = '<td><p id="sujet_message_infos"></p></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr><td colspan="3"><input type="submit" name="submit_sujet" id="submit_sujet" value="Envoyer votre sujet"></td></tr>';
	$texte[] = '</table>';
	$texte[] = '</form>';
	
	return $texte;
}
function afficher_message($ce_message,$cet_auteur)
{
	$texte[] = '<table>';
	$texte[] = '<tr>';
	$texte[] = '<th colspan="2">';
	
	$texte[] = format_date($ce_message->message_date);
	if(droit('edit',$ce_message,$cet_auteur)): 
		$texte[] = '<a href="?sujet_id='. $_GET['sujet_id'].'&amp;message_id='. $ce_message->message_id.'&amp;mode=editer" class="float1">Editer</a>';
	endif;
	if(droit('supprimer',$ce_message,$cet_auteur)):
		$texte[] = '<a href="?sujet_id='. $_GET['sujet_id'].'&amp;message_id='.  $ce_message->message_id.'&amp;mode=supprimer" class="float1">Supprimer</a>';
	endif;
	$texte[] = '</th>';
	$texte[] = '</tr>';
	
	$texte[] = '<tr>';
	$texte[] = '<td width="150">';
	$texte[] = membre_pseudo ($cet_auteur->membre_id);
	$texte[] = membre_avatar ($cet_auteur);
	$texte = array_merge ($texte , membre_vip ($cet_auteur));
	$texte[] = '</td>';
								
	$texte[] = '<td>';
	$texte[] = bbcode_replace( stripslashes($ce_message->message_texte) ); 
	$texte[] = '</td>';
	$texte[] = '</tr>';
							
	if($cet_auteur->membre_signature  != NULL):
		$texte[] = '<tr>';
		$texte[] = '<td colspan="2">';
		$texte[] = bbcode_replace( stripslashes($cet_auteur->membre_signature) ); 
		$texte[] = '</td>';
		$texte[] = '</tr>';							
	endif;
				
	$texte[] = '</table>';
	return $texte;
}
function nouveau_message()
{
	/**/
	$texte[] = '<form method="post" action="'.page_courante().'">';
	$texte[] = '<table>';
	$texte[] = '<tr><th colspan="3">Créer un nouveau message :</th></tr>';
	$texte[] = '<tr>';
	$texte[] = '<td><label for="topic">Votre message :</label></td>';
	$texte[] = '<td><textarea class="bbcode" name="message_texte" id="message_texte" style="height:150px;font-family:\'Comic sans MS\',serif;font-size:10pt;font-color:#8d8d8d;"></textarea></td>';
	$texte[] = '<td><p id="message_texte_infos"></p></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr><td colspan="3"><input type="submit" name="submit_message" id="submit_message" value="Envoyer votre message"></td></tr>';
	$texte[] = '</table>';
	$texte[] = '</form>';
	
	return $texte;
	/**/
}
?>