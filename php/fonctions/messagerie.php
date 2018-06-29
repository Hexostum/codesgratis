<?php
function afficher_resume(&$contenu_texte,$sql_message,$reverse=false)
{
	$contenu_texte[] = '<tr>';
	$sujet_reponse = stripslashes($sql_message['message_sujet']);
	if(!preg_match("#^re:#", $sql_message['message_sujet'])):
		$sujet_reponse = 're: '. $sql_message['message_sujet'];
	endif;
	$donnees['sujet'] = stripslashes($sql_message['message_sujet']);
	$contenu_texte[] = '<td><input type="checkbox" id="check_message[]" name="check_message[]" value="'.$sql_message['message_id'].'"></td>';
	$contenu_texte[] = '<td><a href="messagerie.php?mode=message&amp;message_id=' .  $sql_message['message_id'] . '">' .  $sql_message['message_sujet'] . '</a></td>';
	$contenu_texte[] = '<td><a href="membre.php?_membre_id='.(($reverse) ? $sql_message['message_to_id'] : $sql_message['message_from_id']).'">' .  (($reverse) ? $GLOBALS['cache_membre_pseudo'][$sql_message['message_to_id']] : $GLOBALS['cache_membre_pseudo'][$sql_message['message_from_id']] ) . '</a></td>';
	$contenu_texte[] = '<td>' .  format_date ( $sql_message['message_date'] ) . '</td>';
	$contenu_texte[] = '</tr>';
}
function afficher_resume_admin2($sql_message)
{
	$contenu_texte[] = '<tr>';
	$_sujet = stripslashes($sql_message->message_sujet);
	$contenu_texte[] = '<td>'.$sql_message->message_id.'</td>';
	$contenu_texte[] = '<td><a href="'. page_courante(array('message_id'=>$sql_message->message_id),true) .'">' .  $_sujet . '</a></td>';
	$contenu_texte[] = '<td>'. @$GLOBALS['liste_pseudo'][$sql_message->message_from_id] .' (' . $sql_message->message_from_id . ')</td>';
	$contenu_texte[] = '<td>'. @$GLOBALS['liste_pseudo'][$sql_message->message_to_id] .' (' . $sql_message->message_to_id . ')</td>';
	$contenu_texte[] = '<td>' .  format_date($sql_message->message_date) . '</td>';
	$contenu_texte[] = '</tr>';
	return $contenu_texte;
	/**/
}
function afficher_resume_admin(&$contenu_texte,$sql_message,$reverse=false)
{
	$contenu_texte[] = '<tr>';
	$sujet_reponse = stripslashes($sql_message['message_sujet']);
	if(!preg_match("#^re:#", $sql_message['message_sujet'])):
		$sujet_reponse = 're: '. $sql_message['message_sujet'];
	endif;
	$donnees['sujet'] = stripslashes($sql_message['message_sujet']);
	parse_str($_SERVER['QUERY_STRING'],$params);
	$ces_params = array_merge($params,array('message_id' => $sql_message['message_id']));
	
	$contenu_texte[] = '<td><a href="'.FP_PAGE.'?' . http_build_query($ces_params) .'">' .  $sql_message['message_sujet'] . '</a></td>';
	$contenu_texte[] = '<td>' .  (($reverse) ? stripslashes($sql_message['message_to_id']) : stripslashes($sql_message['message_from_id'])) . '</td>';
	$contenu_texte[] = '<td>' .  date('d/m/Y à H\hi', $sql_message['message_date']) . '</td>';
	$contenu_texte[] = '</tr>';
}

function afficher_message($cet_auteur,$ce_message)
{
	$texte[] = '<table>';
	$texte[] = '<tr>';
	$texte[] = '<th colspan="2">' . $ce_message->message_sujet .'</th>';
	$texte[] = '</tr>';
	
	$texte[] = '<tr>';
	
	$texte[] = '<td width="150">';
	$texte[] = membre_pseudo($cet_auteur->membre_id);
	$texte[] = membre_avatar($cet_auteur);
	$texte = array_merge($texte,membre_vip($cet_auteur));
	$texte[] = '</td>';
	
	$texte[] = '<td>';
	$texte[] = bbcode_replace( stripslashes($ce_message->message_texte) ); 
	$texte[] = '</td>';
	
	$texte[] = '</tr>';
							

	$texte[] = '<tr>';
	$texte[] = '<td colspan="2">';
	$texte[] = bbcode_replace( stripslashes($cet_auteur->membre_signature) ); 
	$texte[] = '</td>';
	$texte[] = '</tr>';
	
	$texte[] = '<tr><th colspan="2"><form action='.page_courante().' method="post"><input type="submit" name="s_supprimer_message" id="s_supprimer_message" value="Supprimer message"></form></th></tr>';
	$texte[] = '</table>';
	return $texte;
}

function form_repondre(&$contenu_texte,$message)
{

	$contenu_texte[] = '<form action="messagerie.php?mode=message&message_id=' .  $message->message_id . '" method="post">';
	$contenu_texte[] = '<input type="hidden" id="destinataire" name="destinataire" value="' . ($message->message_from_id) . '">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<th>Répondre à '.$GLOBALS['cache_membre_pseudo'][$message->message_from_id]. ' (' . ($message->message_from_id) . ')</th>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td><input id="sujet" name="sujet"  style="width:99%" type="text" value="RE : ' .  stripslashes($message->message_sujet) . '"></td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';	
	$contenu_texte[] = '		<td><textarea name="message"  style="width:99%" rows="' .  (substr_count($message->message_texte,"\n") +5) . '">' . stripslashes($message->message_texte) . '</textarea></td>';	
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td><input type="submit" name="submit_message" id="submit_message" value="envoyer"></td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';

}

function form_nouveau(&$contenu_texte)
{
	if(isset($_GET['message_to_id'])):
		$my_destinataire = new fp_membre(intval($_GET['message_to_id']));
		if($my_destinataire->statut()):
			$contenu_texte[] = '<form action="messagerie.php?mode=nouveau" method="post">';
			$contenu_texte[] = '<table><tr><th colspan="2">Envoyer un message à '.$my_destinataire->membre_pseudo.'<input type="hidden" name="destinataire" id="destinataire" value="'.$my_destinataire->membre_id.'"></th></tr>';
			$contenu_texte[] = '	<tr>';
			$contenu_texte[] = '		<td>Sujet</td><td><input id="sujet" name="sujet"  style="width:99%" type="text" value=""></td>';
			$contenu_texte[] = '	</tr>';
			$contenu_texte[] = '	<tr>';
			$contenu_texte[] = '		<td>Message</td><td><textarea name="message"  style="width:99%" rows="20"></textarea></td>';
			$contenu_texte[] = '	</tr>';
			$contenu_texte[] = '	<tr>';
			$contenu_texte[] = '		<td colspan="2"><input type="submit" name="submit_message" id="submit_message" value="envoyer"></td>';
			$contenu_texte[] = '	</tr>';
			$contenu_texte[] = '</table>';
			$contenu_texte[] = '</form>';
		endif;
	else:
		$contenu_texte[] = '<form action="messagerie.php?mode=nouveau" method="post">';
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr><th colspan="2">Envoyer un message privé.</th><tr>';
		$contenu_texte[] = '	<tr>';
		$contenu_texte[] = '		<th>Destinataire</th><th><input id="destinataire" name="destinataire" value=""></th>';
		$contenu_texte[] = '	</tr>';
		$contenu_texte[] = '	<tr>';
		$contenu_texte[] = '		<th>Sujet du message</th><td><input id="sujet" name="sujet"  style="width:99%" type="text" value=""></td>';
		$contenu_texte[] = '	</tr>';
		$contenu_texte[] = '	<tr>';
		$contenu_texte[] = '		<th>Message à envoyer</th><td><textarea name="message"  style="width:99%" rows="20"></textarea></td>';
		$contenu_texte[] = '	</tr>';
		$contenu_texte[] = '	<tr>';
		$contenu_texte[] = '		<td colspan="2"><input type="submit" name="submit_message" id="submit_message" value="envoyer"></td>';
		$contenu_texte[] = '	</tr>';
		$contenu_texte[] = '</table>';
		$contenu_texte[] = '</form>';
	endif;
}

function form_support(&$contenu_texte)
{
	$contenu_texte[] = '<form action="messagerie.php?mode=support" method="post">';
	$contenu_texte[] = '<table><tr><th colspan="2">Envoyer un message au support</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>Sujet</td><td><input id="sujet" name="sujet"  style="width:99%" type="text" value="[SUPPORT] Votre sujet ici"></td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>Message</td><td><textarea name="message"  style="width:99%" rows="20">Votre message de support ici</textarea></td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td colspan="2"><input type="submit" name="submit_message" id="submit_message" value="envoyer"></td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
}

function envoyer_message
	(
		$from,
		$to,
		$titre,
		$message	
	)
{
	$sql = sql_insert
	(
		'codesgratis_messagerie',
		array
		(
			'message_id' => 'null',	
			'message_from_id' => $from,
			'message_to_id' => $to,
			'message_sujet' => sql_champ_texte($titre),
			'message_texte' => sql_champ_texte($message),
			'message_code' => 0,
			'message_date' => 'UNIX_TIMESTAMP()',
		)
	)
	;
	if
		( 
			mysql_query
			(
				$sql
			)
		)
	:
		$my_membre = new fp_membre($to);
		$from_membre = new fp_membre($from);
		courriel
			(
				array
				(
					'courriel_from' => 'messagerie_interne@codesgratis.fr',
					'courriel_to' => $my_membre->membre_courriel,
					'courriel_sujet' => '[CODESGRATIS] [Messagerie Interne] Vous avez un nouveau message de la part de ' . $from_membre->membre_pseudo ,
					'courriel_texte' => array
						(
							$from_membre->membre_pseudo . ' vous a envoyé un message par l\'intermédiaire de la messagerie interne du site codesgratis', 
							'Vous pouvez lire ce message en vous connectant sur codesgratis.'
						)
				)
			)
		;
		
		return true;
	else:
		return false;
	endif;				
}
function confirm_self_message()
{
	$contenu_texte[] = '<form action="#" method="post">';
	$contenu_texte[] = '<table><tr><th colspan="2">Messagerie: Informations</th></tr><tr><td>';
	$contenu_texte[] = '<input type="checkbox" name="check_self" id="check_self"></td><td> Je coche cette case si je veux m\'envoyer un message à moi-même</td></tr>';
	$contenu_texte[] = '<tr><th colspan="2"><input type="submit" name="submit_self" id="submit_self"></th></tr></table>';
	$contenu_texte[] = '</form>';
	return $contenu_texte;
}
?>