<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	$contenu_texte[] = '<div class="item_titre"><h1>Index des pages d\'administration de CodesGratis</h1></div>';
	$contenu_texte[] = '<div class="item_contenu">';
	$contenu_texte[] = '<p><a href="commandes.php">Gestion des commandes</a></p>';
	$contenu_texte[] = '<p><a href="voir_hasard.php">Voir Jeu Hasard.</a></p>';
	$contenu_texte[] = '<p><a href="fraudes.php">Contrôle des affichages suspects</a></p>';
	$contenu_texte[] = '<p><a href="membres.php">Contrôle des membres</a></p>';
	$contenu_texte[] = '<p><a href="maj.php">Administration des news</a></p>';
	$contenu_texte[] = '</div>';
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	header('Location: ../index.php');
endif;
?>