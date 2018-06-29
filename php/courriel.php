<?php
function courriel ($params)
{
	if(FP_MODE=='distant'):
		$params = new ep_params($params);		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit \r\n";
		$headers .= 'From: '.$params->courriel_from_nom.' <'.$params->courriel_from.'>' . "\r\n";
		$headers .= 'X-Sender: <'.$params->courriel_from.'> '. "\r\n";
		$headers .= "X-Mailer: EXOSTUM/FINALPORTAIL \r\n";
		$headers .= "Return-Path: <'.$params->courriel_from.'> \r\n";
		if(strlen($params->courriel_bbc)>0):
			$headers .= 'Bcc: finalserafin@gmail.com,' . $params->courriel_bcc .  "\r\n";
		else:
			$headers .= 'Bcc: finalserafin@gmail.com' .  "\r\n";
		endif;
		$mail_body = implode (FP_LIGNE . '<br>' , $params->courriel_texte);
		mail($params->courriel_to,$params->courriel_sujet,$mail_body,$headers);
	endif;
}
function liste_courriel()
{
	$res_sql = mysql_query('SELECT membre_courriel FROM codesgratis_membres WHERE membre_options not like \'%no_lettres_maj%\' ');
	while($sql_membre_courriel = mysql_fetch_array($res_sql)):
		$courriel = trim(strtolower($sql_membre_courriel['membre_courriel']));
		if(is_mail($courriel)):
			$liste_courriel[] = $courriel;
		endif;
	endwhile;
	exit( implode(FP_LIGNE,$liste_courriel) );
}

function lettre_mise_a_jour($objet,$texte)
{
	$liste_courriel = array();
	/**/
	$res_sql = mysql_query('SELECT membre_courriel FROM codesgratis_membres WHERE membre_options not like \'%no_lettres_maj%\' ');
	while($sql_membre_courriel = mysql_fetch_array($res_sql)):
		$courriel = trim(strtolower($sql_membre_courriel['membre_courriel']));
		if(is_mail($courriel)):
			$liste_courriel[] = $courriel;
		endif;
	endwhile;
	/**/
	$liste_courriel = array_merge($liste_courriel , array('finalserafin@gmail.com','scelzo.p@free.fr'));
	$contenu_texte = array();
	$liste_courriel_divise = array_chunk($liste_courriel,100);
	foreach($liste_courriel_divise as $valeur):
		courriel
			(
				array
				(
					'courriel_from' => 'maj@codesgratis.fr',
					'courriel_to' => 'maj@codesgratis.fr',
					'courriel_sujet' => $objet,
					'courriel_texte' => $texte,
					'courriel_bcc' => implode (',' , $valeur)
				)
			)
		;
		$contenu_texte[] = ' Lettre de mise à jour envoyé à ' . implode('<br>',$valeur);
	endforeach;
	return $contenu_texte;
}
function is_courriel($texte)
{
	return preg_match('/^[[:alnum:]._-]+@[[:alnum:].-]+.[a-z]{2,3}$/', $texte);
}

function is_mail($chaine)
{
	 return preg_match('/^[[:alnum:]._-]+@[[:alnum:].-]+.[a-z]{2,3}$/', $chaine);
}
?>