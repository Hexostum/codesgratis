<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	$message = '';
	if( isset($_POST['submit_courriel']) ):
		$passe = trim(htmlspecialchars($_POST['passe'], ENT_QUOTES));
		$_POST['nouveau_courriel'][1] = trim(htmlspecialchars($_POST['nouveau_courriel'][1], ENT_QUOTES));
		$_POST['nouveau_courriel'][2] = trim(htmlspecialchars($_POST['nouveau_courriel'][2], ENT_QUOTES));
					
		if($_POST['nouveau_courriel'][1]==$_POST['nouveau_courriel'][2]):
			$nouveau_courriel = $_POST['nouveau_courriel'][1];
			if(md5($passe) == $my_membre->membre_passe):
				if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z0-9._-]{2,4}$#i", $nouveau_courriel )):
					$my_membre->membre_courriel=$nouveau_courriel;
					$message =  'Votre courriel a bien été modifié, c\'est maintenant : '. $my_membre->membre_courriel;
				else:
					$message = 'Votre courriel('.$nouveau_courriel.') est incorrecte. Celle-ci doit être de la forme : utilisateur@domaine.extension.<br>';
					$message .= 'Merci de rectifier ceci.';
					$sauvegarde_champ_nouveau_courriel = $nouveau_courriel;
				endif;
			else:
				$message = 'Votre mot de passe est incorrect. Veuillez ressayer.';
				$nouveau_courriel = stripslashes($nouveau_courriel);
				$sauvegarde_champ_nouvelle_adresse = $nouveau_courriel;	
			endif;
		else:
			$message = 'Vous devez entrez deux fois le même courriel.';
		endif;
	endif;
	
	if(isset($_POST['submit_code'])):
		if($my_membre->membre_courriel_code==$_POST['code']):
			$my_membre->membre_courriel_ok=1;
		endif;
	endif;
	
	$contenu_texte[] = '<h1>courriel : ' . $my_membre->membre_courriel . '</h1>';
	
	if($message!=''):
		$contenu_texte[] =  '<hr><br>';
		$contenu_texte[] =  '<h1 style="text-decoration:blink"> /!\ Message /!\ </h1>';
		$contenu_texte[] =  '<strong>'.$message.'</strong>';
		$contenu_texte[] =  '<hr><br>';
	endif;
	
	$contenu_texte[] = '<form method="post" action="compte_courriel.php">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th colspan="2">Modifier votre courriel :';
	$contenu_texte[] = '</th>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre courriel :</td>';
	$contenu_texte[] = '<td>' . $my_membre->membre_courriel .'</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre nouveau courriel (saisie 1) : </td>';
	$contenu_texte[] = '<td><input class="t_courriel" type="text" name="nouveau_courriel[1]" id="nouveau_courriel[1]" maxlength="70" value="' . @$sauvegarde_champ_nouvelle_adresse.'">';
	$contenu_texte[] = '<br><p id="infos_nouveau_courriel[1]"></p>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre nouveau courriel (saisie 2) : </td>';
	$contenu_texte[] = '<td><input class="t_courriel" type="text" name="nouveau_courriel[2]" id="nouveau_courriel[2]" maxlength="70" value="' . @$sauvegarde_champ_nouvelle_adresse . '">';
	$contenu_texte[] = '<br><p id="infos_nouveau_courriel[2]"></p>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre mot de passe :</td>';
	$contenu_texte[] = '<td><input class="password" type="password" name="passe" id="passe" maxlength="40">';
	$contenu_texte[] = '<br><p id="infos_passe"></p>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td colspan="2"><input name="submit_courriel" id="submit_courriel" type="submit" value="Modifier votre courriel"></td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	
	if($my_membre->membre_courriel_ok==0):
		$contenu_texte[] = '<form method="post" action="compte_courriel.php">';
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<th colspan="2">Code de confirmation';
		$contenu_texte[] = '</th></tr>';
		$contenu_texte[] = '<tr><td>Code</td><td><input type="texte" name="code" id="code"></td></tr>';
		$contenu_texte[] = '<tr><td colspan="2"><input type="submit" name="submit_code" id="submit_code"></td></tr>';
		$contenu_texte[] = '</table>';
		$contenu_texte[] = '</form>';
	endif;
	
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;

?>