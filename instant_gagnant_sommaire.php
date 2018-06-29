<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):

	$contenu_texte[] = '<h1>Jouez vos tickets+ sur les instants gagnants pour gagner des codes instantanément !</h1>';
			
	$contenu_texte[] = '<p>Il est à noter que si un nombre non négligeable de membres le demandent, il est possible de rajouter un instant gagnant pour de nouveaux codes.</p>';
				
	$contenu_texte[] = '<p>Choississez parmi les instants gagnants suivants :</p>';
					
	$contenu_texte[] = '<br>';
	$contenu_texte[] = '<ul>';
	$contenu_texte[] = '	<li><a href="instant_gagnant_bankiz_plus.php">Jouez vos tickets+ ici pour tenter de gagner des lots de 2 bankiz+ tous les 8 tickets+ joués par la totalité des 	membres !</a></li>';
	$contenu_texte[] = '	<br>';
	$contenu_texte[] = '	<li><a href="instant_gagnant_byncodes.php">Jouez vos tickets+ ici pour tenter de ';
	$contenu_texte[] = '						gagner des lots de 5 byncodes tous les 10 tickets+ joués par la totalité des membres !</a></li>';
	$contenu_texte[] = '	<br>';
	$contenu_texte[] = '	<li><a href="instant_gagnant_cliquopass.php">Jouez vos tickets+ ici pour tenter de ';
	$contenu_texte[] = '						gagner des lots de 5 cliquopass tous les 15 tickets+ joués par la totalité des ';
	$contenu_texte[] = '						membres !</a></li>';
	$contenu_texte[] = '	<br>';
	$contenu_texte[] = '	<li><a href="instant_gagnant_gratcodes.php">Jouez vos tickets+ ici pour tenter de ';
	$contenu_texte[] = '		gagner des lots de 5 gratcodes tous les 10 tickets+ joués par la totalité des ';
	$contenu_texte[] = '		membres !</a></li>';
	$contenu_texte[] = '</ul>';
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;

?>