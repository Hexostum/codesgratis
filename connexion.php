<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include(FP_CHEMIN_PHP . 'page_start' . '.php');
include(FP_CHEMIN_FONCTIONS . 'connexion' . '.php');
/**
switch(@$_GET['mode']):
	case 'KO': // deconnexion 

		mysql_query('UPDATE codesgratis_sessions SET membre_id=NULL WHERE session_id=\''.session_id().'\'' );
		$my_membre = new fp_membre(NULL);
		$contenu_texte [] = message ('Déconnexion réussie ! ' , FP_MESSAGE_REPONSE );
		$contenu_texte [] = message ('En espérant vous revoir bientôt.' , FP_MESSAGE_INFOS );
	break;
	
	case 'OK': // connexion
	default:


		if($my_membre->membre_existe()):

			$contenu_texte[] =  message ('Vous êtes déjà connecté(e) sous le pseudonyme de '. $my_membre->valeur_champ('membre_pseudo','stripslashes') .'.' , FP_MESSAGE_REPONSE );
			$contenu_texte[] =  message ('<a href="connexion.php?mode=KO" title="Cliquez ici pour vous déconnecter">Deconnexion</a>.' , FP_MESSAGE_INFOS );
	
		else:

			if( isset ($_POST['submit_connexion']) ):

		
				$_POST['pseudo'] = trim($_POST['pseudo']);
				$_POST['mdp'] = trim($_POST['mdp']);
				
	
				$test_membre = new fp_membre("'" . mysql_real_escape_string($_POST['pseudo']) . "'",'membre_pseudo');
					
				if($test_membre->membre_existe()):
			
					if(md5($_POST['mdp']) == $test_membre->membre_passe):
						if
							(
								($test_membre->membre_activation) || 
								($test_membre->membre_activation_code=='')
							)
						:
							$sql = 'UPDATE codesgratis_sessions SET membre_id='.$test_membre->membre_id.' WHERE session_id=\''.session_id().'\'';
			
							if(mysql_query( $sql )):
								$test_membre->membre_connexion=time();
								$test_membre->membre_ip=$_SERVER['REMOTE_ADDR'];
								$my_membre = $test_membre;				
								$contenu_texte[]  = message ('Connexion réussie ! Bienvenue '. $my_membre->membre_pseudo .' !' , FP_MESSAGE_INFOS);
							else:
								$contenu_texte[]  = '<p>Une erreur SQL est survenue : '. mysql_error() .'</p>';
							endif;
						else:
							$contenu_texte[]  = message ('Votre compte n\'est pas encore activé sur codesgratis. Suivez les instructions fournis dans votre courriel d\'inscription au site' , FP_MESSAGE_ERROR);
						endif;
					else:
						$contenu_texte[] = message('Votre mot de passe est incorrect. Merci de le rectifier.', FP_MESSAGE_ERROR);
						$contenu_texte[] = message('Si vous avez oubliez votre mot de passe vous pouvez demander un nouveau mot de passe sur cette <a href="mdp_oubli.php">page</a>.', FP_MESSAGE_INFOS);
						$contenu_texte = array_merge($contenu_texte,formulaire_connexion(trim(stripslashes($_POST['pseudo']))));	
					endif;
				else:
					$contenu_texte[] = message('Le pseudo que vous avez entré n\'existe pas. Merci de le rectifier.', FP_MESSAGE_ERROR) ;
					$contenu_texte[] = message('Si vous avez oubliez votre mot de passe vous pouvez demander un nouveau mot de passe sur cette <a href="mdp_oubli.php">page</a>.', FP_MESSAGE_INFOS);
					$contenu_texte = array_merge($contenu_texte,formulaire_connexion(trim(stripslashes($_POST['pseudo']))));	
				endif;
			else:
				$contenu_texte = array_merge($contenu_texte,formulaire_connexion());
			endif;
		endif;
	break;
endswitch;
**/

$contenu_texte[] = message ('La partie membre est désactivé pour le moment' , FP_MESSAGE_INFOS);
$contenu_texte[] = message ('Votre navigateur doit accepter les cookies pour pouvoir se connecter à codesgratis' , FP_MESSAGE_INFOS);

include(FP_CHEMIN_PHP . 'page_end' . '.php');
?>