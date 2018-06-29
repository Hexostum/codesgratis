<?php
define('FP_TABLE_PUB_AFFICHAGES','codesgratis_pubs2');
define('FP_TABLE_PUB_CLICS','codesgratis_pubs');


function afficher_pubs_affichages()
{
	$pub = mysql_query('SELECT * FROM codesgratis_pubs2 WHERE pub_affichages > 0 ORDER BY RAND()');

	while($pub_donnees = mysql_fetch_array($pub)):
		echo '<p><a href="'. $pub_donnees['pub_url'] .'"><img src="'. $pub_donnees['pub_image'] .'" alt="Publicité 
		de '. $pub_donnees['membre_pseudo'] .'." /></a></p><br />';
	endwhile;
}

function resume_pubs_clic_membre($my_membre)
{
	if
		(
			(!option($my_membre,'cacher_pubs_c_resume')) 
		)
	:
		if(isset($_POST['submit_cacher_resume'])):
			set_option($my_membre,'cacher_pubs_c_resume');
			$texte[] = message('Vous avez caché l\'affichage de votre resumé de clics sur les pubs aux clics. <a href="'.page_courante().'">continuer</a>',FP_MESSAGE_INFOS);
		else:
	
		$texte = array();
		$texte[] = '<table>';
		$texte[] = '<tr>';
		$texte[] = '<th colspan="4">Vos clics du jour <form action="'.page_courante().'" method="post"><input type="submit" name="submit_cacher_resume" id="submit_cacher_resume" value="cacher"></form></th>';
		$texte[] = '</tr>';
		$texte[] = '<tr>';
		$texte[] = '<td>Id du clic</td>';
		$texte[] = '<td>Membre</td>';
		$texte[] = '<td>URL</td>';
		$texte[] = '<td>Heure du clic</td>';
		$texte[] = '</tr>';
		$retour = mysql_query('SELECT pub_id, clic_date FROM codesgratis_pubs_clics WHERE membre_id=\''. $my_membre->membre_id .'\'');
		if(is_resource($retour)):
			$sql_clics = array();
			$sql_clics_timestamp = array();
			$i=0;
			while( $sql_clic = mysql_fetch_array($retour) ):
				$sql_clics[$sql_clic['clic_date']] = $sql_clic['pub_id'];
				$sql_clics_timestamp[$sql_clic['pub_id']] = $sql_clic['clic_date'];
			endwhile;
			ksort($sql_clics);
			$resultat = implode(' , ',$sql_clics);
			$retour2 = mysql_query('SELECT * FROM codesgratis_pubs WHERE pub_id IN ('.$resultat.')');
			if($retour2):
				while($sql_clic = mysql_fetch_array($retour2)):
					$texte[] = '<tr>';
					$texte[] = '<td>' . $sql_clic['pub_id'] . '</td>';
					if($sql_clic['membre_id']==null):
						$texte[] = '<td>Webmasteur de codesgratis</td>';
					else:
						$texte[] = '<td>' . $sql_clic['membre_id'] . '</td>';
					endif;
					$texte[] = '<td>' . $sql_clic['pub_url'] . '</td>';
					$texte[] = '<td>' . format_date($sql_clics_timestamp[$sql_clic['pub_id']]) . '</td>';
					$texte[] = '</tr>';
				endwhile;
			endif;
		else:
			$texte[] = mysql_error();
		endif;
	
		$texte[] = '</table>';
		endif;
	else:
		if(isset($_POST['submit_afficher_resume'])):
			remove_option($my_membre,'cacher_pubs_c_resume');
			$texte[] = message('Vous avez réactivé l\'affichage du résumé de vos clics sur les pubs aux clics. <a href="'.page_courante().'">Continuer</a>' , FP_MESSAGE_INFOS);
		else:
			$texte[] = message('L\'affichage du résumé de vos clics sur les pubs aux clics est désactivé. <form action="'.page_courante().'" method="post"><input type="submit" id="submit_afficher_resume" name="submit_afficher_resume" value="afficher"></form>',FP_MESSAGE_REPONSE);
		
		endif;
	endif;
	
	return $texte;
}


function afficher_pubs_clic($my_membre)
{
	$texte = array();
	/**/
	if
		(
			(!option($my_membre,'cacher_pubs_c_popup')) 
		)
	:
		if(isset($_POST['submit_cacher_popup'])):
			set_option($my_membre,'cacher_pubs_c_popup');
			$texte[] = message('Vous avez cacher l\'affichage des pubs aux clics en mode popup. <a href="'.page_courante().'">continuer</a>',FP_MESSAGE_INFOS);
		else:
			$retour = mysql_query('SELECT * FROM codesgratis_pubs WHERE pub_clics > 0 AND membre_id is not null AND membre_id <> '.$my_membre->membre_id.' AND pub_mode=\'popup\' ORDER BY RAND()');
	
			if(is_resource($retour)):
				$texte[] = '<table><tr><th colspan="4">Publicités aux clics (POPUP)<form action="'.page_courante().'" method="post"><input type="submit" name="submit_cacher_popup" id="submit_cacher_popup" value="cacher"></form></th></tr><tr><th>Publicité</th><th>Points</th><th>compteur</th><th>membre</th></tr>';
				while($donnees = mysql_fetch_array($retour,MYSQL_ASSOC)): 
					$clic = new fp_enregistrement_sql($donnees,'codesgratis_pubs','pub_id');
					$retour2 = mysql_query('SELECT count(pub_id) FROM codesgratis_pubs_clics WHERE membre_id=\''. $my_membre->membre_id .'\' AND pub_id=\''. $clic->pub_id .'\'');
					if(mysql_result($retour2,0) == 0):
						$texte = array_merge($texte,afficher_pub_clic($clic));
					endif;
				endwhile;
				$texte[] = '</table>';
			else:
				$texte[] = mysql_error();
			endif;
		endif;
	else:
		if(isset($_POST['submit_afficher_popup'])):
			remove_option($my_membre,'cacher_pubs_c_popup');
			$texte[] = message('Vous avez réactivé l\'affichage des pubs aux clics en mode popup. <a href="'.page_courante().'">Continuer</a>' , FP_MESSAGE_INFOS);
		else:
			$texte[] = message('L\'affichage des pubs aux clics en mode popup est désactivé. <form action="'.page_courante().'" method="post"><input type="submit" id="submit_afficher_popup" name="submit_afficher_popup" value="afficher"></form>',FP_MESSAGE_REPONSE);
		
		endif;
	endif;
	
	if
		(
			(!option($my_membre,'cacher_pubs_c_frame'))
		)
	:
		if(isset($_POST['submit_cacher_frame'])):
			set_option($my_membre,'cacher_pubs_c_frame');
			$texte[] = message('Vous avez cacher l\'affichage des pubs aux clics en mode frame. <a href="'.page_courante().'">continuer</a>',FP_MESSAGE_INFOS);
		else:
		
			$retour = mysql_query('SELECT * FROM codesgratis_pubs WHERE pub_clics > 0 AND membre_id is not null AND membre_id <> '.$my_membre->membre_id.' AND pub_mode=\'frame\' ORDER BY RAND()');
			if(is_resource($retour)):
				$texte[] = '<table><tr><th colspan="4">Publicités aux clics (FRAME)<form action="'.page_courante().'" method="post"><input type="submit" name="submit_cacher_frame" id="submit_cacher_frame" value="cacher"></form></th></tr><tr><th>Publicité</th><th>Points</th><th>compteur</th><th>membre</th></tr>';
				while($donnees = mysql_fetch_array($retour,MYSQL_ASSOC)): 
					$clic = new fp_enregistrement_sql($donnees,'codesgratis_pubs','pub_id');
					$retour2 = mysql_query('SELECT count(pub_id) FROM codesgratis_pubs_clics WHERE membre_id=\''. $my_membre->membre_id .'\' AND pub_id=\''. $clic->pub_id .'\'');
					if(mysql_result($retour2,0) == 0):
						$texte = array_merge($texte,afficher_pub_clic($clic));
					endif;
				endwhile;
				$texte[] = '</table>';
			else:
				$texte[] = mysql_error();
			endif;
		endif;
	else:
		if(isset($_POST['submit_afficher_frame'])):
			remove_option($my_membre,'cacher_pubs_c_frame');
			$texte[] = message('Vous avez réactivé l\'affichage des pubs aux clics en mode frame. <a href="'.page_courante().'">Continuer</a>' , FP_MESSAGE_INFOS);
		else:
			$texte[] = message('L\'affichage des pubs aux clics en mode frame est désactivé. <form action="'.page_courante().'" method="post"><input type="submit" id="submit_afficher_frame" name="submit_afficher_frame" value="afficher"></form>',FP_MESSAGE_REPONSE);
		
		endif;
	endif;
	
	/**/
	return $texte;
}

function afficher_pub_clic($clic)
{
	$texte = array();
	
	$texte[] = '<tr>';
	/**/
	if($clic->pub_image_l==0):
		$clic->pub_image_l=468;
	endif;
	if($clic->pub_image_h==0):
		$clic->pub_image_h=60;
	endif;
	if($clic->pub_mode == 'popup'):
		$texte[] = '<td><a class="lien_popup" href="clics_compteur_popup.php?pub_id='.$clic->pub_id.'">
				<img src="'. $clic->pub_image .'" alt="'. $clic->pub_image_alt .'" width="'. $clic->pub_image_l .'" heigth="'. $clic->pub_image_h .'">				
			</a></td>';
	else:
		$texte[] = '<td><a href="clics_visionneuse.php?pub_id='. $clic->pub_id .'" target="_blank">
				<img src="'. $clic->pub_image .'" alt="'. $clic->pub_image_alt .'" width="'. $clic->pub_image_l .'" heigth="'. $clic->pub_image_h .'">
			</a></td>';
	endif;
	$texte[] = '<td>0.5</td><td>'. $clic->pub_compteur .'</td>';
	$texte[] = '<td>'.@$GLOBALS['cache_membre_pseudo'][$clic->membre_id].'</td>';
	$texte[] = '</tr>';
	/**/
	return $texte;
}
function purger_pubs_clic()
{
	$date_minuit = mktime(0, 0, 0);
	mysql_query('DELETE FROM codesgratis_pubs_clics WHERE clic_date < '. $date_minuit);
	return $date_minuit;
}

function clic_sur_pub($pub_id,$my_membre)
{
	return sql_result('SELECT COUNT(*) FROM codesgratis_pubs_clics WHERE membre_id='. $my_membre->membre_id .' AND pub_id=\''. $pub_id .'\'');
}

function afficher_resume_pub_clic($cette_pub)
{
	$texte = array();
	$texte[] = '<tr>';
	$texte[] = '<td><a href="'. page_courante(array('pub_id'=>$cette_pub->pub_id)) .'">'. $cette_pub->pub_id .'</a></td>';
	$texte[] = '<td>' . $cette_pub->pub_image . '</td>';
	$texte[] = '<td>' . $cette_pub->pub_url . '</td>';
	$texte[] = '<td>' . $cette_pub->pub_mode . '</td>';
	$texte[] = '<td>' . $cette_pub->pub_clics . '</td>';
	$texte[] = '</tr>';
	return $texte;
}

function form_pub($cette_pub,$my_membre)
{
	$selected_frame = ($cette_pub->pub_mode=='frame') ? 'selected' : '';
	$selected_popup = ($cette_pub->pub_mode=='popup') ? 'selected' : '';
	
	$texte = array();
	
	
	$texte[] = '<table>';
	$texte[] = '	<form action="'.page_courante().'" method="post">';
	$texte[] = '	<tr>';
	$texte[] = '		<th colspan="3">Publicité N°'.$cette_pub->pub_id.'</th>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td>Image : </td>';
	$texte[] = '		<td><input type="text" name="image" id="image" value="'.$cette_pub->pub_image.'"></td>';
	$texte[] = '		<td><input type="submit" id="submit_modifier_image" name="submit_modifier_image" value="modifier"></td>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td>URL</td>';
	$texte[] = '		<td><input type="text" name="url" id="url" value="'.$cette_pub->pub_url.'"></td>';
	$texte[] = '		<td><input type="submit" id="submit_modifier_url" name="submit_modifier_url" value="modifier"></td>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td colspan="3"><a href="'.$cette_pub->pub_url.'"><img src="'.$cette_pub->pub_image.'"></a></td>';
	$texte[] = '	</tr>';
	$texte[] = '	';
	$texte[] = '	<tr>';
	$texte[] = '		<td>Mode</td>';
	$texte[] = '		<td>';
	$texte[] = '			<select name="mode" id="mode" style="text-align:center;">';
	$texte[] = '				<option value="frame"'.$selected_frame.'>Frame(Méthode usuelle des PTC).</option>';
	$texte[] = '				<option value="popup"'.$selected_popup.'>Popup(En cas de casseur de frame).</option>';	
	$texte[] = '			</select>';
	$texte[] = '		</td>';
	$texte[] = '		<td><input type="submit" id="submit_modifier_mode" name="submit_modifier_mode" value="modifier"></td>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td>Clics restants</td>';
	$texte[] = '		<td colspan="2">'.$cette_pub->pub_clics.'</td>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td>Recharger.</td>';	
	$texte[] = '		<td>100 clics pour 200 points.</td>';
	$texte[] = '		<td><input name="submit_crediter" id="submit_crediter" type="submit" value="recharger"></td>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td>Recharger</td>';
	$texte[] = '		<td>100 clics pour 100 points plus</td>';
	$texte[] = '		<td><input type="submit" id="submit_crediter_plus" name="submit_crediter_plus" value="Recharger"></td>';
	$texte[] = '	</tr>';
	$texte[] = '	<tr>';
	$texte[] = '		<td>Suppression</td>';
	$texte[] = '		<td><input type="checkbox" name="check_supprimer" id="check_supprimer" value="supprimer_pub_ok">';
	$texte[] = '			<label for="check_supprimer">Oui, supprimer cette publicité. J&rsquo;ai bien compris que les clics restants sont perdus.</label>';
	$texte[] = '		<td><input id="submit_supprimer" name="submit_supprimer" type="submit" value="valider"></td>';
	$texte[] = '	</tr>';
	$texte[] = '	</form>';
	$texte[] = '</table>';
	
	$texte = array_merge($texte,resume_pubs_clic($cette_pub,$my_membre));
	return $texte;
}

function resume_pubs_clic($cette_pub,$my_membre)
{
	if
		(
			(!option($my_membre,'cacher_pubs_c_resume2')) 
		)
	:
		if(isset($_POST['submit_cacher_resume'])):
			set_option($my_membre,'cacher_pubs_c_resume2');
			$texte[] = message('Vous avez caché l\'affichage du resumé des clics sur votre pubs aux clics. <a href="'.page_courante().'">continuer</a>',FP_MESSAGE_INFOS);
		else:
	
		$texte = array();
		$texte[] = '<table>';
		$texte[] = '<tr>';
		$texte[] = '<th colspan="4">Clics du jour sur votre publicité aux clics <form action="'.page_courante().'" method="post"><input type="submit" name="submit_cacher_resume" id="submit_cacher_resume" value="cacher"></form></th>';
		$texte[] = '</tr>';
		$texte[] = '<tr>';
		$texte[] = '<td>Membre</td>';
		$texte[] = '<td>Heure du clic</td>';
		$texte[] = '</tr>';
		$retour = mysql_query('SELECT membre_id, clic_date FROM codesgratis_pubs_clics WHERE pub_id='. $cette_pub->pub_id );
		if(is_resource($retour)):
			while($sql_clic = mysql_fetch_array($retour)):
				$texte[] = '<tr>';
				$texte[] = '<td>' . $GLOBALS['liste_pseudo'][$sql_clic['membre_id']] . '</td>';
				$texte[] = '<td>' . format_date($sql_clic['clic_date']) . '</td>';
				$texte[] = '</tr>';
			endwhile;
		else:
			$texte[] = mysql_error();
		endif;
	
		$texte[] = '</table>';
		endif;
		
	else:
		if(isset($_POST['submit_afficher_resume'])):
			remove_option($my_membre,'cacher_pubs_c_resume2');
			$texte[] = message('Vous avez réactivé l\'affichage du résumé des clics sur votre pub aux clics. <a href="'.page_courante().'">Continuer</a>' , FP_MESSAGE_INFOS);
		else:
			$texte[] = message('L\'affichage du résumé des clics sur votre pub aux clics est désactivé. <form action="'.page_courante().'" method="post"><input type="submit" id="submit_afficher_resume" name="submit_afficher_resume" value="afficher"></form>',FP_MESSAGE_REPONSE);
		
		endif;
	endif;
	
	return $texte;
}

function crediter_pub($cette_pub,$my_membre,$mode)
{
	$texte = array();
	switch($mode):
		case 'pointsplus':
			if
				(
					$my_membre->membre_points_plus >= 100  
				)
			:
				if
					(
						$cette_pub->incremente_champ('pub_clics',100)
					)
				:
					if
						(
							gestion_points($my_membre , time() , $cette_pub->pub_url , -100 , FP_TYPE_R_PUBS1PLUS, $cette_pub->pub_id , $my_membre->membre_id , 'NULL' , true )
						)
					:
						$texte[] = message('Votre publicité a bien été créditée de 100 clics.', FP_MESSAGE_INFOS);
						$texte = array_merge($texte,clan_check($cette_pub->pub_url,$my_membre));  						
					else:
						$cette_pub->incremente_champ('pub_clics',-100);
						$texte[] = message('Une erreur est survenue',FP_MESSAGE_ERROR);
					endif;
				else:
					$texte[] = message(mysql_error(),FP_MESSAGE_ERROR);
				endif;
			else:
				$texte[] = message('Vous ne disposez pas d\'assez de points plus pour acheter des clics.', FP_MESSAGE_ERROR);
			endif;
		break;
	
		// RECHARGER UNE PUB AVEC 200 points
		case 'points':
			if
				(
					$my_membre->membre_points >= 200
				)
			:
				if
					(
						$cette_pub->incremente_champ('pub_clics',100)
					)
				:
					if
						(
							gestion_points($my_membre , time() , $cette_pub->pub_url , -200 , FP_TYPE_R_PUBS1 , $cette_pub->pub_id , $my_membre->membre_id , 'NULL' , false)
						)
					:
						$texte[] = message('Votre publicité a bien été créditée de 100 clics.', FP_MESSAGE_INFOS);
					else:
						$cette_pub->incremente_champ('pub_clics',-100);
						$texte[] = message('Une erreur est survenue',FP_MESSAGE_ERROR);
					endif;
				else:
					$texte[] = message(mysql_error(),FP_MESSAGE_ERROR);
				endif;
			else:
			$texte[] = message('Vous ne disposez pas d\'assez de points pour acheter des clics.',FP_MESSAGE_ERROR);
			endif;
		break;
		
		
	endswitch;
	return $texte;
} 

function clan_check($url,$my_membre)
{
	$texte = array();
	
	if(!preg_match("#^http://(www\.)?codesgratis\.fr/pages\.php\?membre=.+$#", $url)):						
		$page = @file_get_contents($url);
		if(!preg_match("#src=(?:\")?http://(www\.)?codesgratis\.fr/pages\.php\?membre=.+(?:\")#", $page)):
		
			renouvellement_clan();
			
			$points_clan = 1 * (1 + ( $my_membre->membre_vip/10) );
			$texte = array_merge($texte , instant_gagnant($my_membre, (50 * ( $points_clan - 1 )) ));
			$clan_id = $my_membre->membre_clan_id;
			$texte = array_merge($texte,crediter_clan($clan_id , $points_clan , $my_membre ));
		else:
			$texte[] = message('Cette publicité ne permet pas de participer au concours de clan' , FP_MESSAGE_ERROR);
		endif;
	else:
		$texte[] = message('Cette publicité ne permet pas de participer au concours de clan', FP_MESSAGE_ERROR);
	endif;
	
	return $texte;
}

function acheter_pub($my_membre)
{
	$contenu_texte = array();
	if($my_membre->membre_points_plus >= 100):
		
		$url = mysql_real_escape_string(strip_tags($_POST['url']));
		$image = mysql_real_escape_string(strip_tags($_POST['image']));
		$mode = mysql_real_escape_string(strip_tags($_POST['mode']));
						
		if(!preg_match("#^(frame)|(popup)$#", $mode)):
			$mode = 'frame';
		endif;
							
		$url_save = stripslashes($url);
		$image_save = stripslashes($image);
						
		if(check_url_ok($url)):
			if(check_url_unique($url)):
				if(check_image_pattern($image)):
					$infos_image = check_image($image);
					if($infos_image['flag']):
						$sql = sql_insert('codesgratis_pubs',array(
						'pub_id' => 'NULL',
						'membre_id'=> $my_membre->membre_id ,
						'pub_url' => sql_champ_texte($url),
						'pub_image' => sql_champ_texte($image),
						'pub_image_l' => 0,
						'pub_image_h' => 0,
						'pub_image_alt'=> sql_champ_texte('publicité de ' . $my_membre->membre_pseudo),
						'pub_mode' => sql_champ_texte($mode),
						'pub_compteur'=> 5,
						'pub_clics'=> 100,
						'pub_statut'=> 1
						));
						if
							(
								mysql_query($sql)
							)
						:
							if
								(
									gestion_points($my_membre, time() , $url , -100 , FP_TYPE_R_PUBS1PLUS , mysql_insert_id() , $my_membre->membre_id,  'NULL' , true)
								)
							:
								$contenu_texte[] =  message('Votre publicité a bien été ajoutée dans les clics rémunérés, et créditée de 100 clics.', FP_MESSAGE_INFOS);
								
								//gestion du clan
								$contenu_texte = array_merge($contenu_texte,clan_check($url,$my_membre));
								// fin clan
							else:
								mysql_query('DELETE FROM codesgratis_pub WHERE pub_id='. mysql_insert_id());
								$contenu_texte[] = 'une erreur est survenue.';
							endif;
						else:
							$contenu_texte[] =  '<p style="color:red">Une erreur est survenue lors de l\'enregistrement dans la base de données. ['.$sql.']['.mysql_error().']</p>';
						endif;
					else:
						$contenu_texte[] =  message( 'L\'image que vous avez indiqué n\'existe pas.', FP_MESSAGE_ERROR);
					endif;				
				else:
					$contenu_texte[] = message ( 'L\'adresse de la bannière semble être erronée, ou l\'extension spécifiée n\'est pas reconnue.' , FP_MESSAGE_ERROR ) ;
				endif;
			else:
				$contenu_texte[] =  message( 'La pub que vous tentez d\'ajouter a la même URL qu\'une autre publicité.' , FP_MESSAGE_ERROR ) ;
			endif;
		else:
			$contenu_texte[] = message ( 'L\'adresse web que vous avez fournie semble erronée. Merci de la rectifier.' , FP_MESSAGE_ERROR ) ;
		endif;
	else:
		$contenu_texte[] = message ('Vous ne disposez pas d\'assez de points pour acheter des clics.' , FP_MESSAGE_ERROR );
	endif;
	return $contenu_texte;
}
function acheter_pub2($my_membre)
{
	$contenu_texte = array();
	if($my_membre->membre_points >= 200):
		
		$url = mysql_real_escape_string(strip_tags($_POST['url']));
		$image = mysql_real_escape_string(strip_tags($_POST['image']));
		$mode = mysql_real_escape_string(strip_tags($_POST['mode']));
						
		if(!preg_match("#^(frame)|(popup)$#", $mode)):
			$mode = 'frame';
		endif;
							
		$url_save = stripslashes($url);
		$image_save = stripslashes($image);
						
		if(check_url_ok($url)):
			if(check_url_unique($url)):
				if(check_image_pattern($image)):
					$infos_image = check_image($image);
					if($infos_image['flag']):
						$sql = sql_insert('codesgratis_pubs',array(
						'pub_id' => 'NULL',
						'membre_id'=> $my_membre->membre_id ,
						'pub_url' => sql_champ_texte($url),
						'pub_image' => sql_champ_texte($image),
						'pub_image_l' => 0,
						'pub_image_h' => 0,
						'pub_image_alt'=> sql_champ_texte('publicité de ' . $my_membre->membre_pseudo),
						'pub_mode' => sql_champ_texte($mode),
						'pub_compteur'=> 5,
						'pub_clics'=> 100,
						'pub_statut'=> 1
						));
						if
							(
								mysql_query($sql)
							)
						:
							if
								(
									gestion_points($my_membre, time() , $url , -200 , FP_TYPE_R_PUBS1 , mysql_insert_id() , $my_membre->membre_id,  'NULL' , false)
								)
							:
								$contenu_texte[] =  message('Votre publicité a bien été ajoutée dans les clics rémunérés, et créditée de 100 clics.', FP_MESSAGE_INFOS);
							else:
								mysql_query('DELETE FROM codesgratis_pub WHERE pub_id='. mysql_insert_id());
								$contenu_texte[] = 'une erreur est survenue.';
							endif;
						else:
							$contenu_texte[] =  '<p style="color:red">Une erreur est survenue lors de l\'enregistrement dans la base de données. ['.$sql.']['.mysql_error().']</p>';
						endif;
					else:
						$contenu_texte[] =  message( 'L\'image que vous avez indiqué n\'existe pas.', FP_MESSAGE_ERROR);
					endif;				
				else:
					$contenu_texte[] = message ( 'L\'adresse de la bannière semble être erronée, ou l\'extension spécifiée n\'est pas reconnue.' , FP_MESSAGE_ERROR ) ;
				endif;
			else:
				$contenu_texte[] =  message( 'La pub que vous tentez d\'ajouter a la même URL qu\'une autre publicité.' , FP_MESSAGE_ERROR ) ;
			endif;
		else:
			$contenu_texte[] = message ( 'L\'adresse web que vous avez fournie semble erronée. Merci de la rectifier.' , FP_MESSAGE_ERROR ) ;
		endif;
	else:
		$contenu_texte[] = message ('Vous ne disposez pas d\'assez de points pour acheter des clics.' , FP_MESSAGE_ERROR );
	endif;
	return $contenu_texte;
}

function check_url_ok($url)
{
	if(preg_match("#^https?://[a-z0-9\._/\?&-]+#i", $url)):
		return true;
	else:
		return false;
	endif;
}

function check_url_unique($url)
{
	$count = sql_result('SELECT count(pub_id) FROM codesgratis_pubs where pub_url=\''.$url.'\'');
	if($count==0):
		return true;
	else:
		return false;
	endif;
}
function check_image_pattern($url_image)
{
	if(preg_match('#https?://[a-z0-9._/-]+\.((png)|(jpg)|(gif)|(bmp))$#i', $url_image)):
		return true;
	else:
		return false;
	endif;
}
function check_image($url_image)
{
	(bool)$flag = $data = @getimagesize($image);
	if($flag):
		return array(
		'flag' => true,
		'data' => $data
		);
	else:
		return array(
		'flag' => 'false',
		'data' => array()
		);
	endif;
}

function formulaire_nouvelle_pub($url_save,$image_save)
{
	$action = page_courante();
	return 
<<<EOD
<br>
<form method="post" action="$action">
<table>
<tr>
	<th colspan="3">Créer une nouvelle pub</th>
</tr>
<tr>
	<td><label for="url">URL : </label></td>
	<td colspan="2"><input class="apercu_clic_url" type="text" name="url" id="url" maxlength="255" value="$url_save" onClick="javascript:document.getElementById('apercu_clic').innerHTML='<a href=\''+this.value+'\'><img src=\''+document.getElementById('image').value+'\' /></a>';" onKeyUp="javascript:document.getElementById('apercu_clic').innerHTML='<a href=\''+this.value+'\'><img src=\''+document.getElementById('image').value+'\' ></a>';"></td>
</tr>
<tr>
	<td><label for="image">Votre bannière (468x60 requis): </label></td>
	<td colspan="2"><input class="apercu_clic_image" type="text" name="image" id="image" maxlength="255" value="$image_save" onClick="javascript:document.getElementById('apercu_clic').innerHTML='<a href=\''+document.getElementById('url').value+'\'><img src=\''+this.value+'\' /></a>';" onKeyUp="javascript:document.getElementById('apercu_clic').innerHTML='<a href=\''+document.getElementById('url').value+'\'><img src=\''+this.value+'\' ></a>';"></td>
</tr>
<tr>
	<td colspan="3"><p id="apercu_clic"><a href=""><img src="$image_save"></a></p></td>
</tr>
<tr>
	<td><label for="mode">Mode :</label></td>
	<td colspan="3"><select name="mode" style="text-align:center;">
			<option value="frame">Frame(Méthode usuelle des PTC).</option>
			<option value="popup">Popup(En cas de casseur de frame).</option>
		</select>
	</td>
</tr>
<tr>
	<td>Acheter.</td>
	<td>100 clics pour 200 points.</td>
	<td><input name="submit_acheter" id="submit_acheter" type="submit" value="acheter"></td>
</tr>
<tr>
	<td>Acheter.</td>
	<td>100 clics pour 100 points plus.</td>
	<td><input name="submit_acheter_plus" id="submit_acheter_plus" type="submit" value="acheter"></td>
	</tr>
</table>
</form>
<br>
EOD;
}
?>