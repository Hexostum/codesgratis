<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
$contenu_texte [] = '<h1>Les partenaires de CodesGratis</h1>';
$contenu_texte [] = '<p>Ici sont répertoriés tous les sites partenaires de CodesGratis.</p>';
$contenu_texte [] = '<p>Cliquez sur les bannières ou sur les liens pour visiter les sites de nos partenaires.</p>';
$contenu_texte [] = '<ul class="liste_verticale">';
$contenu_texte [] = '<li>';
$contenu_texte [] = '<a href="http://www.gagner-argent-internet.org" target="_blank">';
$contenu_texte [] = '<img src="http://www.ordicoach.fr/gagnezsurinternet.gif" target="_blank">';
$contenu_texte [] = '</a>';
$contenu_texte [] = '</li>';
$contenu_texte [] = '</ul>';
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>