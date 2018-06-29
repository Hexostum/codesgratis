<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
require(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	header('Location: index.php');
	exit();
endif;
//On vérifie si les champ de modification ont été remplis
if(!empty($_POST['adresse']) && !empty($_POST['pseudo'])):
	//Sécurité pour la base de données
	$adresse = mysql_real_escape_string(htmlspecialchars($_POST['adresse'], ENT_QUOTES));
	$pseudo = mysql_real_escape_string(htmlspecialchars($_POST['pseudo'], ENT_QUOTES));
	$r_membre= new fp_membre("'" . $pseudo ."'",'membre_pseudo');
	if($r_membre->membre_existe()):
		if( ($r_membre->membre_courriel == $adresse) && ($r_membre->membre_pseudo==$pseudo) ):
		/* Génération du mot de passe */
			$caracteres = array
			(
				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
				'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', 
				'4', '5', '6', '7', '8', '9'
			);
							
			$nouveau_mdp = '';
							
			$entrees_caracteres = count($caracteres);
			$entrees_caracteres--;
							
			for($i = 1 ; $i <= 8 ; $i++):
				$id_caractere = rand(0, $entrees_caracteres);
				$nouveau_mdp .= $caracteres[$id_caractere];
			endfor;
			/* Fin de génération du mot de passe */
							
			//Les infos sont exactes, on modifie l'adresse dans la base de donnees
			$r_membre->membre_passe = md5($nouveau_mdp);
			$contenu_texte[] = '<p>Votre nouveau mot de passe  vous a été envoyé par mail.</p>';
							
			/* Envoi du mail au membre */
						
			$Name = "CodesGratis";
			$email = "webmaster@codesgratis.fr"; //senders e-mail adress
															
			$recipient = $adresse;
							
			$mail_body = '<html>
						<head>
						</head>
								<body>
												<p>Bonjour '. $pseudo .', ceci est un message semi-automatique de CodesGratis.</p>
												<p>Vous avez demandé à changer votre mot de passe, car vous l\'aviez oublié. 
												Si non, merci de signaler cette anomalie au webmaster de CodesGratis.</p>
												<p>Vos nouveaux identifiants :</p>
												<p>Pseudonyme : '. $pseudo .'</p>
												<p>Mot de passe : '. $nouveau_mdp .'</p>
										
												<p>Cordialement,<br />
												FLo, webmaster de CodesGratis.</p>
							
											</body>
										</html>';
			
							
			$subject = "CodesGratis : Vos nouveaux identifiants.";
			$header = "From: ". $Name . " <" . $email . ">\r\n";
							
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'To: '. $r_membre->membre_pseudo .' <'. $recipient .'>' . "\r\n";
			$headers .= 'From: CodesGratis <webmaster@codesgratis.fr>' . "\r\n";

			mail($recipient, $subject, $mail_body, $headers);
		else:
			$contenu_texte[] = message ( 'L\'adresse courriel que vous avez indiquée ne correspond pas.' , FP_MESSAGE_ERROR );
			
			$contenu_texte[] = '<table><tr><th colspan="2">Obtenir un nouveau mot de passe</th></tr>';			
			$contenu_texte[] = '<form method="post" action="'.page_courante().'">';
			$contenu_texte[] = '<tr><td>Pseudonyme</td><td><input type="text" name="pseudo" id="pseudo" maxlength="40"></td></tr>';
			$contenu_texte[] = '<tr><td>courriel</td><td><input type="text" name="adresse" id="adresse" maxlength="150"></td></tr>';
			$contenu_texte[] = '<tr><td colspan="2"><input type="submit" value="Modifier" id="bouton_modifier"></tr>';
			$contenu_texte[] = '</form>';
			$contenu_texte[] = '</table>';
		endif;		
	else:
		$contenu_texte[] = message('Ce membre n\'existe pas.' , FP_MESSAGE_ERROR ) ;
		
		$contenu_texte[] = '<table><tr><th colspan="2">Obtenir un nouveau mot de passe</th></tr>';			
		$contenu_texte[] = '<form method="post" action="'.page_courante().'">';
		$contenu_texte[] = '<tr><td>Pseudonyme</td><td><input type="text" name="pseudo" id="pseudo" maxlength="40"></td></tr>';
		$contenu_texte[] = '<tr><td>courriel</td><td><input type="text" name="adresse" id="adresse" maxlength="150"></td></tr>';
		$contenu_texte[] = '<tr><td colspan="2"><input type="submit" value="Modifier" id="bouton_modifier"></tr>';
		$contenu_texte[] = '</form>';
		$contenu_texte[] = '</table>';
	endif;
else:
	$contenu_texte[] = '<table><tr><th colspan="2">Obtenir un nouveau mot de passe</th></tr>';			
	$contenu_texte[] = '<form method="post" action="'.page_courante().'">';
	$contenu_texte[] = '<tr><td>Pseudonyme</td><td><input type="text" name="pseudo" id="pseudo" maxlength="40"></td></tr>';
	$contenu_texte[] = '<tr><td>courriel</td><td><input type="text" name="adresse" id="adresse" maxlength="150"></td></tr>';
	$contenu_texte[] = '<tr><td colspan="2"><input type="submit" value="Modifier" id="bouton_modifier"></tr>';
	$contenu_texte[] = '</form>';
	$contenu_texte[] = '</table>';
endif;

include(FP_CHEMIN_PHP . 'page_end' . '.php');
?>