<?php
function formulaire_connexion($pseudo=NULL)
{
	$texte = array();
	$texte[] = '<table><tr><th colspan="2">Connexion CodesGratis</th></tr>';
	$texte[] = '<form method="post" action="'.page_courante().'">';
	$texte[] = '<tr>';
	$texte[] = '<td><label for="pseudo">Pseudonyme</label></td>';
	$texte[] = '<td><input type="text" id="pseudo" name="pseudo" value="'.$pseudo.'" maxlength="40"></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';					
	$texte[] = '<td><label for="mdp">Mot de passe</label></td>';
	$texte[] = '<td><input type="password" id="mdp" name="mdp" maxlength="40"></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td colspan="2"><input name="submit_connexion" type="submit" value="Connexion"></td>';
	$texte[] = '</tr>';
	$texte[] = '</form>';
	$texte[] = '</table>';	
	$texte[] = message ('Vous n\'êtes pas inscrit sur codesgratis ?' , FP_MESSAGE_QUESTION);
	$texte[] = message ('Inscrivez-vous sur la page d\'<a href="inscription.php" title="EXOSTUM - CODESGRATIS - INSCRIPTION">Inscription de codesgratis</a>' , FP_MESSAGE_REPONSE);
	$texte[] = '';
	return $texte;
}
?>