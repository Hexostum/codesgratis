<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

/**
if($my_membre->membre_pseudo=='finalserafin'):
/**/
if($my_membre->membre_existe()):
	if( isset($_POST['submit_passe']) ):
		$_POST['ancien_passe'] = trim(htmlspecialchars($_POST['ancien_passe'], ENT_QUOTES));
		$_POST['nouveau_passe'][1] = trim(htmlspecialchars($_POST['nouveau_passe'][1], ENT_QUOTES));
		$_POST['nouveau_passe'][2] = trim(htmlspecialchars($_POST['nouveau_passe'][2], ENT_QUOTES));
					
		if( md5($_POST['ancien_passe']) == $my_membre->membre_passe):
			if($_POST['nouveau_passe'][1]==$_POST['nouveau_passe'][2]):
				$nouveau_passe = $_POST['nouveau_passe'][1];
				if(preg_match("#.{8,40}#", $nouveau_passe)):
					$nouveau_passe = stripslashes($nouveau_passe);
					$my_membre->membre_passe = md5($nouveau_passe);
					$contenu_texte[] = 'Votre mot de passe a bien été modifié, c\'est maintenant : '. $nouveau_passe;
				else:
					$contenu_texte[] = 'Votre mot de passe est trop court. Celui-ci doit être compris entre 8 et 40 caractres. Merci de le rectifier.';
				endif;
			else:
				$contenu_texte[] = 'Vous devez entrez deux fois le même mot de passe';
			endif;
		else:
			$contenu_texte[] = 'L\'ancien mot de passe ('.$_POST['ancien_passe'].') que vous avez spécifié n\'est pas correct. Merci de rectifier cela.';
		endif;	
	endif;
	$contenu_texte[] = '<h1>Changer votre mot de passe</h1>';
	$contenu_texte[] = '<form method="post" action="compte_passe.php">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th colspan="2">Modifier votre mot de passe.</th>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre ancien mot de passe :</td>';
	$contenu_texte[] = '<td><input type="password" name="ancien_passe" id="ancien_passe" maxlength="40">';
	$contenu_texte[] = '<br><p id="infos_ancien_passe"></p>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre nouveau mot de passe :</td>';
	$contenu_texte[] = '<td><input type="password" name="nouveau_passe[1]" id="nouveau_passe[1]" maxlength="40">';
	$contenu_texte[] = '<br><p id="infos_nouveau_passe[1]"></p>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Votre nouveau mot de passe :</td>';
	$contenu_texte[] = '<td><input type="password" name="nouveau_passe[2]" id="nouveau_passe[2]" maxlength="40">';
	$contenu_texte[] = '<br><p id="infos_nouveau_passe[2]"></p>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td colspan="2"><input name="submit_passe" id="submit_passe" type="submit" value="Modifier votre mot de passe."></td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;
/**
endif;
/**/
?>