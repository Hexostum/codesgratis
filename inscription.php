<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel' . '.php');

if(!$my_membre->statut()):
/**
	$page_titre .=  ' - Inscription';
	$form_cache = array
	(
		'membre_pseudo' => '',
		'membre_passe' => '',
		'membre_courriel' => '',
		'membre_no_adresse' => '',
		'membre_civilite' => '',
		'membre_nom'=> '',
		'membre_prenom'=> '',
		'membre_adresse' => '',
		'membre_cp' => '',
		'membre_ville' => '',
		'membre_pays' => '',
		'reglement'=> false
	);
	$flag=true;
	$form=true;
	if(isset($_POST['submit_inscription'])):
		$p_pseudo = trim(strip_tags(stripslashes($_POST['pseudo'])));
		$p_courriel_1 = trim(strip_tags(stripslashes($_POST['courriel_1'])));
		$p_courriel_2 = trim(strip_tags(stripslashes($_POST['courriel_2'])));
		$p_passe_1 = trim(strip_tags(stripslashes($_POST['passe_1'])));
		$p_passe_2 = trim(strip_tags(stripslashes($_POST['passe_2'])));
		
		$p_civilite = trim(strip_tags(stripslashes($_POST['membre_civilite'])));
		$p_nom = trim(strip_tags(stripslashes($_POST['membre_nom'])));
		$p_prenom = trim(strip_tags(stripslashes($_POST['membre_prenom'])));
		$p_adresse = trim(strip_tags(stripslashes($_POST['membre_adresse'])));
		$p_cp = trim(strip_tags(stripslashes($_POST['membre_cp'])));
		$p_ville = trim(strip_tags(stripslashes($_POST['membre_ville'])));
		$p_pays = trim(strip_tags(stripslashes($_POST['membre_pays'])));
		
		if(strlen($p_pseudo)>3):
			$test_pseudo = new fp_membre( sql_champ_texte($p_pseudo) , 'membre_pseudo');
			if($test_pseudo->statut()):
				$contenu_texte[] = message('Ce pseudonyme est déjà utilisé par un membre de ce site.' , FP_MESSAGE_ERROR );
				$flag = false;
			else:
				$form_cache['membre_pseudo'] = $p_pseudo;
			endif;
		else:
			$contenu_texte[] = message('Votre pseudonyme doit avoir au moins 3 lettres.' , FP_MESSAGE_ERROR);
			$flag = false;
		endif;
		
		if(is_courriel($p_courriel_1)):
			if(strlen($p_courriel_1)>0):
				if($p_courriel_1==$p_courriel_2):
					$test_courriel = new fp_membre( sql_champ_texte($p_courriel_1) , 'membre_courriel' );
					if($test_courriel->statut()):
						$contenu_texte[] = message('Cette adresse courriel est déjà utilisée par un membre de ce site.' , FP_MESSAGE_ERROR);
						$flag=false;
					else:
						$form_cache['membre_courriel'] = $p_courriel_1;
					endif;
				else:
					$contenu_texte[] = message('Les deux adresses courriels indiquées ne correspondent pas.' , FP_MESSAGE_ERROR);
					$flag=false;
				endif;
			else:
				$contenu_texte[] = message('Votre adresse courriel est obligatoire.' , FP_MESSAGE_ERROR);
				$flag = false;
			endif;
		else:
			$contenu_texte[] = message('L\'adresse courriel que vous avez indiqué n\'est pas valide .' , FP_MESSAGE_ERROR);
			$flag = false;
		endif;
		
		if(strlen($p_passe_1) > 6):
			if($p_passe_1==$p_passe_2):
				$p_passe = $p_passe_1;
				$form_cache['membre_passe'] = $p_passe;
			else:
				$contenu_texte[] = message('Les deux mots de passes indiqués ne correspondent pas.' , FP_MESSAGE_ERROR);
				$flag=false;
			endif;
		else:
			$contenu_texte[] = message('Votre mot de passe doit faire obligatoirement plus de 6 lettres.' , FP_MESSAGE_ERROR);
			$flag = false;
		endif;
		
		if(!isset($_POST['reglement'])):
			$form_cache['reglement']=false;
			$contenu_texte[] = message('Vous devez indiquer que vous avez lu le réglement.' , FP_MESSAGE_ERROR);
			$flag=false;
		else:
			$form_cache['reglement']=true;
		endif;
		
		if(!isset($_POST['membre_no_adresse'])):
			$form_cache['membre_no_adresse']=false;
			$form_cache['membre_civilite'] = $_POST['membre_civilite'];
			if(strlen($p_nom)==0):
				$contenu_texte[] = message('Vous devez indiquer votre nom de famille.' , FP_MESSAGE_ERROR);
				$flag = false;
			else:
				$form_cache['membre_nom']=$p_nom;
			endif;
			if(strlen($p_prenom)==0):
				$contenu_texte[] = message('Vous devez indiquer votre prénom .' , FP_MESSAGE_ERROR);
				$flag = false;
			else:
				$form_cache['membre_prenom']=$p_prenom;
			endif;
			if(strlen($p_adresse)==0):
				$contenu_texte[] = message('Vous devez indiquer votre adresse.' , FP_MESSAGE_ERROR);
				$flag = false;
			else:
				$form_cache['membre_adresse']=$p_adresse;
			endif;
			if(strlen($p_cp)==0):
				$contenu_texte[] = message('Vous devez indiquer votre code postal.' , FP_MESSAGE_ERROR);
				$flag = false;
			else:
				$form_cache['membre_cp']=$p_cp;
			endif;
			if(strlen($p_ville)==0):
				$contenu_texte[] = message('Vous devez indiquer votre ville de résidence.' , FP_MESSAGE_ERROR);
				$flag = false;
			else:
				$form_cache['membre_ville']=$p_ville;
			endif;
			if(strlen($p_pays)==0):
				$contenu_texte[] = message('Vous devez indiquer votre pays de résidence.' , FP_MESSAGE_ERROR);
				$flag = false;
			else:
				$form_cache['membre_pays']=$p_pays;
			endif;
		else:
			$form_cache['membre_no_adresse']=true;
		endif;
		
		
		if($flag):
			$activation_code = md5($form_cache['membre_pseudo'] . $form_cache['membre_courriel'] . time());
			
			if($form_cache['membre_no_adresse']):
				$adresse_activation = '';
			else:
				$adresse_activation = md5($form_cache['membre_pseudo'] . $form_cache['membre_adresse'] . time());
			endif;
			
			$sql = sql_insert
				(
					'codesgratis_membres',
					array
					(
						'membre_id' => 'NULL' ,
						'membre_banni' => 0,
						
						'membre_activation'=>0,
						'membre_activation_code'=> sql_champ_texte( $activation_code ) ,
						
						'membre_pseudo' => sql_champ_texte($form_cache['membre_pseudo']),
						'membre_passe' => sql_champ_texte(md5($form_cache['membre_passe'])),
						
						'membre_courriel' => sql_champ_texte($form_cache['membre_courriel']),
						'membre_courriel_ok' => 0,
						'membre_courriel_code' => sql_champ_texte(''),
						
						'membre_civilite' => sql_champ_texte($form_cache['membre_civilite']),
						'membre_nom' => sql_champ_texte($form_cache['membre_nom']),
						'membre_prenom' => sql_champ_texte($form_cache['membre_prenom']),
						'membre_adresse' => sql_champ_texte($form_cache['membre_adresse']),
						'membre_cp' => sql_champ_texte($form_cache['membre_cp']),
						'membre_ville' => sql_champ_texte($form_cache['membre_ville']),
						'membre_pays' => sql_champ_texte($form_cache['membre_pays']),
						
						'membre_adresse_ok' => 0,
						'membre_adresse_code'=> sql_champ_texte($adresse_activation),
						
						
						'membre_parrain_id' => 'NULL',
						'membre_clan_id' => 'NULL',
						'membre_vip' => 0,
						'membre_points'=> 0,
						'membre_points_plus'=> 0,
						'membre_points_vip'=> 0,
						'membre_tickets' => 0 ,
						'membre_tickets_plus' => 0,
						'membre_inscription' => 'UNIX_TIMESTAMP()' ,
						'membre_ip' => sql_champ_texte($_SERVER['REMOTE_ADDR']) ,
						'membre_avatar'=> 'NULL',
						'membre_avatar_l' => 0,
						'membre_avatar_h'=> 0,
						'membre_signature' => 'NULL',
						'membre_options' => sql_champ_texte(''),
						
						'parrain_gain_total_affichages' => 0,
						'parrain_gain_total_clics' => 0,
						'parrain_gain_total_jeu_hasard'=> 0,
						'parrain_gain_total_tombola'=> 0,
						'parrain_gain_total_concours'=> 0,
						'parrain_mois_courant'=> 0,
						'parrain_gain_mois_affichages'=> 0,
						'parrain_gain_mois_clics'=> 0,
						'parrain_gain_mois_jeu_hasard' => 0,
						'parrain_gain_mois_tombola' => 0,
						'parrain_gain_mois_concours'=> 0,
						'parrain_jour_courant'=> 0,
						'parrain_gain_jour_affichages'=> 0,
						'parrain_gain_jour_clics'=> 0,
						'parrain_gain_jour_jeu_hasard'=> 0,
						'parrain_gain_jour_tombola'=> 0,
						'parrain_gain_jour_concours'=> 0,
					)
				)
			; 
			
			
			if(mysql_query($sql)):
				$membre_id = mysql_insert_id();
				$contenu_texte[] = message('Votre inscription a réussi', FP_MESSAGE_INFOS);
				$contenu_texte[] = message('Vous avez reçu dans votre boîte courriel un message pour activer votre compte sur ce site' , FP_MESSAGE_REPONSE);
				
				courriel
				(
					array
					(
						'courriel_from' => 'inscription@codesgratis.fr',
						'courriel_to' => $form_cache['membre_courriel'],
						'courriel_sujet' => '[CODESGRATIS] INSCRIPTION',
						'courriel_texte' => array
						(
							'Vous vous êtes inscrit sur le site CODESGRATIS d\'exostum, voici vos informations de connexion : ',
							'Pseudonyme : ' . $form_cache['membre_pseudo'] ,
							'Mot de passe : ' . $form_cache['membre_passe'] ,
							'Cliquez sur le lien ci-après pour activer votre compte sur le site CODESGRATIS d\'exostum http://codesgratis.exostum.net/membre_activation.php?compte_id='.mysql_insert_id().'&clef=' . $activation_code
						)
					)
				);
				$form=false;
			else:
				$contenu_texte[] = message('Une erreur sql a eu lieu ['.mysql_error().']', FP_MESSAGE_ERROR);
			endif;
		endif;

	endif;


	if($form):
		$contenu_texte[] = '<h1>Inscrivez-vous sur CodesGratis :</h1>';
		$contenu_texte[] = '<form method="post" action="inscription.php">';
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr><td>Pseudonyme</td>';
		$contenu_texte[] = '<td><input type="text" name="pseudo" id="pseudo" value="'. $form_cache['membre_pseudo'] .'" maxlength="40"><tr>';
		$contenu_texte[] = '<tr><td>Mot de passe</td><td><input type="password" name="passe_1" id="passe_1" maxlength="40" value="'.$form_cache['membre_passe'].'"></td></tr>';
		$contenu_texte[] = '<tr><td>Mot de passe</td><td><input type="password" name="passe_2" id="passe_2" maxlength="40" value="'.$form_cache['membre_passe'].'"></td></tr>';
		$contenu_texte[] = '<tr><td>Courriel</td><td><input type="text" name="courriel_1" id="courriel_1" value="'.$form_cache['membre_courriel'].'" maxlength="40"></td></tr>';
		$contenu_texte[] = '<tr><td>Courriel</td><td><input type="text" name="courriel_2" id="courriel_2" value="'.$form_cache['membre_courriel'].'" maxlength="40"></td></tr>';
		if($form_cache['membre_no_adresse']):
			$contenu_texte[] = '<tr><td>Adresse Postale (Pour recevoir les chèques et les cadeaux chez vous)</td><td>
			<table>
			<tr><td><label for="membre_civilite">Civilité</label></td><td><select name="membre_civilite" id="membre_civilite"><option value="civilite_monsieur">M</option><option value="civilite_madame">Mme</option><option value="civilite_mademoiselle">Mlle</option></select></td></tr>
			<tr><td><label for="membre_nom">Nom</label></td><td><input type="text" name="membre_nom" id="membre_nom"></td></tr>
			<tr><td><label for="membre_prenom">Prénom</label></td><td><input type="text" name="membre_prenom" id="membre_prenom"></td></tr>
			<tr><td><label for="membre_adresse">Adresse</label></td><td><textarea name="membre_adresse" id="membre_adresse"></textarea></td></tr>
			<tr><td><label for="membre_cp">Code Postal</label></td><td><input type="text" name="membre_cp" id="membre_cp"></td></tr>
			<tr><td><label for="membre_ville">Ville</label></td><td><input type="text" name="membre_ville" id="membre_ville"></td></tr>
			<tr><td><label for="membre_pays">Pays</label></td><td><input type="text" name="membre_pays" id="membre_pays"></td></tr>
			<tr><td><input name="membre_no_adresse" id="membre_no_adresse" type="checkbox" value="no_adresse" checked></td><td><label for="membre_no_adresse">Je ne remplis pas mon adresse postale, j\'ai bien compris qu\'en ce cas je ne pourrais recevoir mes gains que par paypal ou moneybookers (Si vous changez d\'avis, vous pouvez remplir votre adresse postale plus tard)</label></td></tr>
			</table>';
		else:
			$contenu_texte[] = '<tr><td>Adresse Postale (Pour recevoir les chèques et les cadeaux chez vous)</td><td>
			<table>
			<tr><td><label for="membre_civilite">Civilité</label></td><td><select name="membre_civilite" id="membre_civilite"><option value="monsieur">M</option><option value="madame">Mme</option><option value="mademoiselle">Mlle</option></select></td></tr>
			<tr><td><label for="membre_nom">Nom</label></td><td><input type="text" name="membre_nom" id="membre_nom" value="'.$form_cache['membre_nom'].'"></td></tr>
			<tr><td><label for="membre_prenom">Prénom</label></td><td><input type="text" name="membre_prenom" id="membre_prenom" value="'.$form_cache['membre_prenom'].'"></td></tr>
			<tr><td><label for="membre_adresse">Adresse</label></td><td><textarea name="membre_adresse" id="membre_adresse">'.$form_cache['membre_adresse'].'</textarea></td></tr>
			<tr><td><label for="membre_cp">Code Postal</label></td><td><input type="text" name="membre_cp" id="membre_cp" value="'.$form_cache['membre_cp'].'"></td></tr>
			<tr><td><label for="membre_ville">Ville</label></td><td><input type="text" name="membre_ville" id="membre_ville" value="'.$form_cache['membre_ville'].'"></td></tr>
			<tr><td><label for="membre_pays">Pays</label></td><td><input type="text" name="membre_pays" id="membre_pays" value="'.$form_cache['membre_pays'].'"></td></tr>
			<tr><td><input name="membre_no_adresse" id="membre_no_adresse" type="checkbox" value="no_adresse"></td><td><label for="membre_no_adresse">Je ne remplis pas mon adresse postale, j\'ai bien compris qu\'en ce cas je ne pourrais recevoir mes gains que par paypal ou moneybookers (Si vous changez d\'avis, vous pouvez remplir votre adresse postale plus tard)</label></td></tr>
			</table>';
		endif;
		$contenu_texte[] = '</td></tr>';
		$reglement_checked = ($form_cache['reglement']) ? ' checked' : '';
		$contenu_texte[] = '<tr><td><input type="checkbox" name="reglement" id="reglement" value="confirmation_lecture_reglement"'.$reglement_checked.'></td>';
		$contenu_texte[] = '<td><label for="reglement">Vous confirmez avoir lu <a href="reglement.php">le règlement</a>.</label></td>';
		$contenu_texte[] = '<tr><td colspan="2"><input type="submit" value="inscription" id="submit_inscription" name="submit_inscription"></td></tr>';
		$contenu_texte[] = '</table></form>';
	endif;
	/**/
else:

endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>