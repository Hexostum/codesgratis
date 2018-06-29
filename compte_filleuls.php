<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Le parrainage sur CodesGratis : ' . $my_membre->membre_pseudo .'</h1>';
	$contenu_texte[] = '<h2>Vos filleuls</h2>';
	$retour = mysql_query('SELECT membre_pseudo FROM codesgratis_membres WHERE membre_parrain_id='. $my_membre->membre_id );
				
	if(mysql_num_rows($retour) > 0):
	
		if(mysql_num_rows($retour) == 1):
			$donnees = mysql_fetch_array($retour);
			$contenu_texte[] = '<p>Vous avez '. mysql_num_rows($retour) .' filleul : '. $donnees['membre_pseudo'] .'.</p>';
		else:
			$contenu_texte[] = '<p>Vous avez '. mysql_num_rows($retour) .' filleuls : ';
			$i = 1;
			while($donnees = mysql_fetch_array($retour)):
				if($i != mysql_num_rows($retour)):
					$contenu_texte[] = $donnees['membre_pseudo'] .', ';
				else:
					$contenu_texte[] = $donnees['membre_pseudo'] .'.';
				endif;
				$i++;
			endwhile;
			$contenu_texte[] = '</p>';
		endif;
		$contenu_texte[] = '<p><a href="compte_filleuls_gains.php">Pour plus de détails sur vos filleuls, cliquez ici.</a></p>';
	else:
		$contenu_texte[] = '<p>Vous n\'avez pas encore de filleul ! Suivez les instructions ci-dessous pour en obtenir.</p>';
	endif;
	
	$contenu_texte[] = '		<h2>Qu\'est-ce que je gagne à parrainer sur CodesGratis ?</h2>';
				
	$contenu_texte[] = '		<p>Vous gagnez 0.3 points à chaque affichage de la page perso de vos filleuls, ou à chaque clic 
			rémunéré qu\'ils effectuent !</p>';
			
	$contenu_texte[] = '		<p><strong>Vos filleuls n\'y perdent rien, c\'est CodesGratis qui offre !</strong></p>';
			
	$contenu_texte[] = '			<h2>Comment puis-je parrainer ?</h2>';
				
	$contenu_texte[] = '		<p>Il vous suffit de faire de la publicité pour CodesGratis sur le web, en donnant un lien qui vous ';
	$contenu_texte[] = '		est spécifique. Si un nouveau membre s\'est inscrit avec votre lien de parrainage, il est votre ';
	$contenu_texte[] = '		filleul ! De la même façon, un nouveau membre inscrit depuis votre page perso devient également ';
	$contenu_texte[] = '		votre filleul.</p>';
			
	$contenu_texte[] = '		<p>Les liens en questions à mettre sur des forums essentiellement, avec ou sans bannière ';
	$contenu_texte[] = '		CodesGratis (choississez parmi les trois liens proposés) :</p>';
			
	$contenu_texte[] = '		<br>';
			
	$contenu_texte[] = '		<table>';
	$contenu_texte[] = '			<tr>';
	$contenu_texte[] = '				<td>Texte à mettre</td>';
	$contenu_texte[] = '				<td>[url=http://' . $_SERVER['HTTP_HOST']. '/index.php?parrain_id=' . $my_membre->membre_id.']CodesGratis : Vos ';
	$contenu_texte[] = '				codes gratis facilement ![/url]</td>';
	$contenu_texte[] = '			</tr>';
	$contenu_texte[] = '			<tr>';
	$contenu_texte[] = '				<td>Résultat</td>';
	$contenu_texte[] = '				<td><a href="http://' . $_SERVER['HTTP_HOST'].'/index.php?parrain_id=' . $my_membre->membre_id.'">';
	$contenu_texte[] = '				CodesGratis : Vos codes gratis facilement !</a></td>';
	$contenu_texte[] = '			</tr>';
	$contenu_texte[] = '		</table>';
			
	$contenu_texte[] = '		<br>';
			
	$contenu_texte[] = '		<table>';
	$contenu_texte[] = '			<tr>';
	$contenu_texte[] = '				<td>Texte à mettre</td>';
	$contenu_texte[] = '				<td>[url=http://' . $_SERVER['HTTP_HOST'].'/index.php?parrain_id=' . $my_membre->membre_id.']';
	$contenu_texte[] = '				[img]http://' . $_SERVER['HTTP_HOST'].'/images/banniere_codesgratis2.png[/img][/url]</td>';
	$contenu_texte[] = '			</tr>';
	$contenu_texte[] = '			<tr>';
	$contenu_texte[] = '				<td>Résultat</td>';
	$contenu_texte[] = '				<td><a href="http://' . $_SERVER['HTTP_HOST'].'/index.php?parrain_id=' . $my_membre->membre_id.'">';
	$contenu_texte[] = '				<img src="http://' . $_SERVER['HTTP_HOST'].'/images/banniere_codesgratis2.png">';
	$contenu_texte[] = '				</a></td>';
	$contenu_texte[] = '			</tr>';
	$contenu_texte[] = '		</table>';
			
	$contenu_texte[] = '		<br>';
			
	$contenu_texte[] = '		<table>';
	$contenu_texte[] = '			<tr>';
	$contenu_texte[] = '				<td>Texte à mettre</td>';
	$contenu_texte[] = '				<td>[url=http://' . $_SERVER['HTTP_HOST'].'/index.php?parrain_id=' . $my_membre->membre_id.']';
	$contenu_texte[] = '				[img]http://' . $_SERVER['HTTP_HOST'].'/images/banniere_codesgratis.png[/img][/url]</td>';
	$contenu_texte[] = '			</tr>';
	$contenu_texte[] = '			<tr>';
	$contenu_texte[] = '				<td>Résultat</td>';
	$contenu_texte[] = '				<td><a href="http://' . $_SERVER['HTTP_HOST'].'/index.php?parrain_id=' . $my_membre->membre_id.'">';
	$contenu_texte[] = '				<img src="http://' . $_SERVER['HTTP_HOST'].'/images/banniere_codesgratis.png">';
	$contenu_texte[] = '				</a></td>';
	$contenu_texte[] = '			</tr>';
	$contenu_texte[] = '		</table>';
			
	$contenu_texte[] = '		<h2>Les limites du parrainage</h2>';
				
	$contenu_texte[] = '		<p>Lisez bien <a href="reglement.php#art9">l\'article du règlement concernant le parrainage</a>, vous voilà ';
	$contenu_texte[] = '		prévenu(e) !</p>';
			
	include(FP_CHEMIN_PHP . 'page_end' . '.php');	
else:
	header('Location: connexion.php');
endif;
?>