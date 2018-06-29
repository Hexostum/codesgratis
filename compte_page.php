<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

include(FP_CHEMIN_FONCTIONS . 'points.php');
include(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');


if($my_membre->membre_existe()):
	$nb_clics_possibles = 35;
						
	$date_debut_quinzaine = mktime(0, 0, 0) - 7*24*3600;
			
	$retour = mysql_query("SELECT COUNT(*) FROM codesgratis_codes WHERE membre_id={$my_membre->membre_id} AND code_validation >= $date_debut_quinzaine AND code_type= " .FP_CGRATIS);
	$cggratis_nombre = mysql_result($retour,0);

	$nb_clics_possibles += $cggratis_nombre * 3;
			
	$retour = mysql_query("SELECT COUNT(*) FROM codesgratis_codes WHERE membre_id={$my_membre->membre_id} AND code_validation >= $date_debut_quinzaine AND code_type= " .FP_CGCODES);
	$cgcodes_nombre = mysql_result($retour,0);
	
	$nb_clics_possibles += $cggratis_nombre * 5;
	
	$retour = mysql_query("SELECT COUNT(*) FROM codesgratis_codes WHERE membre_id={$my_membre->membre_id} AND code_validation >= $date_debut_quinzaine AND code_type= " .FP_CGCODESPLUS);
	$cgcodes_plus_nombre = mysql_result($retour,0);
												
	$nb_clics_possibles += $cgcodes_plus_nombre * 15;
						
	$r_affichages = new fp_enregistrement('codesgratis_pages_clics',$my_membre->membre_id,'membre_id','COUNT(*) AS affichages');
	$nb_clics_droit = $nb_clics_possibles - $r_affichages->affichages;			
	
	$contenu_texte[] = '<h1>Informations sur votre page.</h1>';
			
	$contenu_texte[] = '<p>Votre lien est : <br>';
	$contenu_texte[] = '	<input style="width:100%" type="text" value="http://' .  $_SERVER['HTTP_HOST']. '/pages.php?membre_id=' .  $my_membre->membre_id. '">';
	$contenu_texte[] = '</p>';
		
	$contenu_texte[] = '<p>Vous avez encore droit aujourd\'hui à <strong>' .  $nb_clics_droit. '</strong> affichages de votre page de promotion aujourd\'hui, sur <strong>' .  $nb_clics_possibles. '</strong> au total pour ce jour.</p>';
	
	$contenu_texte[] = '<h1>Preuves de clics.</h1>';
	$contenu_texte[] = '<p>La liste des preuves de clics est ici : <br>';
	$contenu_texte[] = '<a href="http://' .  $_SERVER['HTTP_HOST']. '/preuves/' .  $my_membre->membre_id. '/">Preuves</a>';
	$contenu_texte[] = '</p>';
	
			
	$contenu_texte[] = '<h1>Liste des sites interdits</h1>';
	$contenu_texte[] = '<p>Ces sites sont interdits car il utilisent des techniques interdites par le réglement de codesgratis. Vous ne pouvez pas mettre votre lien sur ces sites</p>';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<th>Adresse du site</th>';
	$contenu_texte[] = '		<th>Raison de l\'exclusion</th>';
	$contenu_texte[] = '		<th>Bannisement de votre compte si votre lien est trouvé sur ce site ?</th>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>lords-of-traffic.com</td>';
	$contenu_texte[] = '		<td>Picturing</td>';
	$contenu_texte[] = '		<td>Enquête en cours.</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '	<tr>';
	$contenu_texte[] = '		<td>tsubaframe.net || www.web-affiliation.biz </td>';
	$contenu_texte[] = '		<td>Picturing</td>';
	$contenu_texte[] = '		<td>Non (car il impossible de savoir qui a mis le lien sur le site)</td>';
	$contenu_texte[] = '	</tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '<br><br>';
	$contenu_texte[] = '<h1>Historique des visites de votre page.</h1>';
	
	afficher_historique($contenu_texte,$my_membre->membre_id,true,FP_TYPE_PAGES);
	
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
			
else:
	header('Location: connexion.php');
	exit();
endif;
?>