<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');

if($my_membre->statut()):
	$form_cache = array
	(
		'membre_civilite' => $my_membre->membre_civilite,
		'membre_nom'=> $my_membre->membre_nom,
		'membre_prenom'=> $my_membre->membre_prenom,
		'membre_adresse' => $my_membre->membre_adresse,
		'membre_cp' => $my_membre->membre_cp,
		'membre_ville' => $my_membre->membre_ville,
		'membre_pays' => $my_membre->membre_pays
	);
		
	if(isset($_POST['submit_adresse'])):
		
		$p_civilite = trim(strip_tags(stripslashes($_POST['membre_civilite'])));
		$p_nom = trim(strip_tags(stripslashes($_POST['membre_nom'])));
		$p_prenom = trim(strip_tags(stripslashes($_POST['membre_prenom'])));
		$p_adresse = trim(strip_tags(stripslashes($_POST['membre_adresse'])));
		$p_cp = trim(strip_tags(stripslashes($_POST['membre_cp'])));
		$p_ville = trim(strip_tags(stripslashes($_POST['membre_ville'])));
		$p_pays = trim(strip_tags(stripslashes($_POST['membre_pays'])));
		
		$flag=true;
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
		if($flag):
			$my_membre->membre_civilite = $form_cache['membre_civilite'];
			$my_membre->membre_nom = $form_cache['membre_nom'];
			$my_membre->membre_prenom = $form_cache['membre_prenom'];
			$my_membre->membre_adresse = $form_cache['membre_adresse'];
			$my_membre->membre_cp = $form_cache['membre_cp'];
			$my_membre->membre_ville = $form_cache['membre_ville'];
			$my_membre->membre_pays = $form_cache['membre_pays'];
			envoyer_message
			(
				$my_membre->membre_id,
				0,
				'[ADRESSE POSTALE] Message automatique',
				'J\'ai modifié mon adresse postale.'
			);
		endif;
	endif;
	$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th colspan="2">Modification de votre adresse postale</th></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_civilite">Civilité</label></td><td><select name="membre_civilite" id="membre_civilite"><option value="monsieur">M</option><option value="madame">Mme</option><option value="mademoiselle">Mlle</option></select></td></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_nom">Nom</label></td><td><input type="text" name="membre_nom" id="membre_nom" value="'.$form_cache['membre_nom'].'"></td></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_prenom">Prénom</label></td><td><input type="text" name="membre_prenom" id="membre_prenom" value="'.$form_cache['membre_prenom'].'"></td></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_adresse">Adresse</label></td><td><textarea name="membre_adresse" id="membre_adresse">'.$form_cache['membre_adresse'].'</textarea></td></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_cp">Code Postal</label></td><td><input type="text" name="membre_cp" id="membre_cp" value="'.$form_cache['membre_cp'].'"></td></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_ville">Ville</label></td><td><input type="text" name="membre_ville" id="membre_ville" value="'.$form_cache['membre_ville'].'"></td></tr>';
	$contenu_texte[] = '<tr><td><label for="membre_pays">Pays</label></td><td><input type="text" name="membre_pays" id="membre_pays" value="'.$form_cache['membre_pays'].'"></td></tr>';
	$contenu_texte[] = '<tr><td colspan="2"><input type="submit" name="submit_adresse" id="submit_adresse" value="modifier"></td></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	
	$contenu_texte[] = message ('Vous pouvez continuer à utiliser votre compte même si vous ne renseignez pas votre adresse postale' , FP_MESSAGE_INFOS);
	
	$contenu_texte[] = message ('Le webmaster s\'engage à utiliser votre nom, prénom, adresse postale et adresse courriel uniquement dans le cas de constitution du fichier client. Vos données ne seront pas vendus, ni communiquées à une entité extérieure à l\'auto-entreprise Exostum.' , FP_MESSAGE_INFOS);
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>