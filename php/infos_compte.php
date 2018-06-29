<?php
		
$texte[] =  '<ul>' . FP_LIGNE;
	
$texte[] =  '<h2>Gagner des points</h2>' . FP_LIGNE;
	
$texte[] =  '<ul>' . FP_LIGNE;
$texte[] =  '<li><a href="jeu_instant_gagnant.php" title="Gagner des points à l\'instant gagnant">Instant Gagnant</a></li>' . FP_LIGNE;
$texte[] =  '<li><a href="jeu_hasard.php" title="Tentez votre chance au jeu de hasard, et gagnez des points instantanément !">Jeu de hasard</a></li>' . FP_LIGNE;
$texte[] =  '<li><a href="jeu_tombola.php" title="Participez à la tombola du jour !">Tombola</a></li>';
$texte[] =  '<li><a href="concours_xbox.php" title="Tentez de gagner une XBOX 360">Gagner une XBOX 360</a></li>';
$texte[] =  '<li><a href="clics.php" title="Gagnez des points en cliquant simplement sur des publicités !">Clics rémunérés</a></li>' . FP_LIGNE;		
$texte[] =  '<li><a href="achat_filleuls.php" title="Parrainez de nouveaux filleuls moyennant un paiement en points plus !">Achat de filleuls</a></li>';
	
/**			
$texte[] =  '<li><a href="tableau_solidarite.php" title="Les plus démunis comptent sur vous changer cela en cliquant 
	pour eux !">Tableau de la solidarité</a></li>';
/**/		
$texte[] =  '</ul>' . FP_LIGNE;


$texte[] =  '<ul>' . FP_LIGNE;
$texte[] =  '<h2>Votre compte</h2>' . FP_LIGNE;
$texte[] =  '<li>Bonjour, '. $my_membre->membre_pseudo .' !</li>'  . FP_LIGNE;
$texte[] =  '<li><a href="messagerie.php" title="Messagerie">Messagerie</a></li>';
$texte[] =  '<li><a href="chat.php" title="">Webchat instantané</a></li>';

if($my_membre->membre_points <= 1):
	$texte[] =  '<li><a href="compte_points.php">Point : <strong>'. $my_membre->membre_points .'</strong></a>.</li>'  . FP_LIGNE;
else:
	$texte[] =  '<li><a href="compte_points.php">Points : <strong>'. $my_membre->membre_points .'</strong></a>.</li>' . FP_LIGNE;
endif;
$texte[] =  '<li><a href="compte_vip.php">Points PLUS : '. $my_membre->membre_points_plus .'</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_vip.php">Points VIP : '. $my_membre->membre_points_vip .'</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_tickets.php">Echange des anciens tickets</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_page.php">Votre page</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_parrain.php">Votre Parrain</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_filleuls.php">Votre Parrainage</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_avatar.php">Votre Avatar</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_signature.php">Votre signature</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_courriel.php">Courriel</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_adresse.php">Adresse Postale</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_passe.php">Mot de passe</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_maj.php">Lettre de mise à jour.</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_pubs_clic.php">Vos Pubs aux clics</a>.</li>' . FP_LIGNE;
$texte[] =  '<li><a href="compte_commandes.php">Vos commandes</a>.</li>' . FP_LIGNE;
$texte[] =  '</ul>' . FP_LIGNE;


$texte[] =  '<ul>' . FP_LIGNE;
$texte[] =  '<h2>Codes</h2>'  . FP_LIGNE;
$texte[] =  '<li><a href="cgcode_achat.php">Achat CGCodes</a></li>'  . FP_LIGNE;
$texte[] =  '<li><a href="cgcode_validation.php">Validation CGCodes</a></li>'  . FP_LIGNE;
$texte[] =  '</ul>' . FP_LIGNE;


$texte[] =  '<ul>';
$texte[] =  '<h2>Clans et concours</h2>';
if(is_null($my_membre->membre_clan_id)):
	$texte[] =  '<li><a href="clans_recrutement.php" title="Faites-vous recruter dans un clan, ou bien fondez-en un, et gagnez plus !">Recrutement / Création</li>';	
else:
	$my_clan = new fp_enregistrement('codesgratis_clans',$my_membre->membre_clan_id,'clan_id');
	if($my_clan->statut()):
		if($my_clan->membre_id == $my_membre->membre_id):
			$clan_membre = mysql_result(mysql_query('SELECT count(membre_id) FROM codesgratis_membres WHERE membre_clan_id='. $my_clan->clan_id ),0);
			$clan_candidature = mysql_result(mysql_query('SELECT count(membre_id) FROM codesgratis_clans_candidatures WHERE clan_id='. $my_clan->clan_id ),0);
			if($clan_membre < 5 && $clan_candidature > 0):
				$texte[] =  '<li><a href="clans_gestion.php" title="Vous avez '. $clan_candidature .' candidatures !" style="text-decoration:blink;">Vous avez '. $clan_candidature .' candidatures !</li>';
			else:
				$texte[] =  '<li><a href="clans_gestion.php" title="Gérez ici votre clan">Gérer mon clan</li>';
			endif;
		else:
			$texte[] =  '<li>Mon Clan : '.$my_clan->clan_nom.'</li>';	
		endif;
	else:
		$texte[] =  '<li><a href="clans_recrutement.php" title="Faites-vous recruter dans un clan, ou bien fondez-en un, et gagnez plus !">Recrutement / Création</li>';		
	endif;
endif;
	
$texte[] =  '<li><a href="clans_classement.php" title="Découvrez le classement actuel des clans sur CodesGratis">Classement des clans</li>';
	
$texte[] =  '<li><a href="clans_classement_precedent.php" title="Découvrez le classement précédent des clans sur CodesGratis">Classement précédent</li>';
	
$texte[] =  '<li><a href="clans_aide.php" title="Besoin d\'aide ?">Aide</a></li>';
	
$texte[] =  '</ul>';

$texte[] =  '<h2>Déconnexion</h2>' . FP_LIGNE;
	
$texte[] =  '<ul>' . FP_LIGNE;
	
$texte[] =  '<li><a href="connexion.php?mode=KO" title="Cliquez ici pour vous déconnecter">Se déconnecter</a></li>' . FP_LIGNE;
	
$texte[] =  '</ul>' . FP_LIGNE;	
?>