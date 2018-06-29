<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	$page_titre .= ' - Clans - Aide';
	$contenu_texte[] = '<h1>Les clans sur CodesGratis : c\'est quoi ?</h1>';
	$contenu_texte[] = '<p>Vous êtes sans doute curieux ou curieuse d\'en savoir plus sur cette histoire de clans et ';
	$contenu_texte[] = 'concours sur CodesGratis. Eh bien, ici, vous apprendrez tout ce qu\'il faut savoir là-dessus ! =)</p>';
	$contenu_texte[] = '<h3>C\'est quoi, concrètement ?</h3>';
	$contenu_texte[] = '<p>Chacun(e) peut choisir de créer son propre clan ou de postuler à d\'autres clans. Chaque clan ';
	$contenu_texte[] = 'représente une équipe de 5 joueurs ou joueuses maximum.</p>';		
	$contenu_texte[] = '<p>La notion de clans est très étroitement liée à la validation des CGcodes en échange de clics rémunérés sur CodesGratis</a></p>';		
	$contenu_texte[] = '<h3>Qu\'est-ce que j\'y gagne ?</h3>';			
	$contenu_texte[] = '<p>Vous voulez dire qu\'est-ce que les joueurs de votre clan y gagnent ? C\'est simple : à la validation ';
	$contenu_texte[] = 'd\'un CGcode (qu\'il soit obtenu en vitrine ou non) pour un clic rémunéré qui n\'est ni une page de ';
	$contenu_texte[] = 'promotion CodesGratis, et ne contient pas de frame CodesGratis ou autre, le clan du valideur, ou de la ';
	$contenu_texte[] = 'valideuse, gagne 1 point concours.</p>';
	$contenu_texte[] = '<p>Si le valideur ou la valideuse ne fait pas partie d\'un clan, ce point revient au clan qui possède ';
	$contenu_texte[] = 'le moins de points concours.</p>';
	$contenu_texte[] = '<p>Les concours ont lieu chaque semaine, et finissent le dimanche, à 21h.</p>';
	$contenu_texte[] = '<p>À la fin du concours hebdomadaire, le clan qui possède le plus de points remporte le total des ';
	$contenu_texte[] = 'points concours que possèdent tous les clans réunis multiplié par 10 en points, partagés ';
	$contenu_texte[] = 'équitablement entre les différents membres du clan gagnant !</p>';
	$contenu_texte[] = '<p>Les points concours sont alors remis à 0.</p>';
	$contenu_texte[] = '<h3>C\'est compliqué. Tu peux me donner un exemple ?</h3>';
	$contenu_texte[] = '<p>Bien sûr. Imaginons qu\'en tout, cette semaine, 100 CGcodes aient été validés en échange de ';
	$contenu_texte[] = 'clics, sous les conditions requises pour qu\'ils rapportent un point concours. Parmi les clans qui ';
	$contenu_texte[] = 'se disputent, les membres du clan en tête ont validé 40 CGcodes, et leur clan a donc 40 points ';
	$contenu_texte[] = 'concours. Ce clan gagne le concours hebdomadaire, et remporte 100 * 10 = 1000 points à se partager !</p>';
	$contenu_texte[] = '<p>Imaginons encore que ce clan soit composé de 3 membres. Chaque membre remporte alors ';
	$contenu_texte[] =  '1000 / 3 = 334 points (arrondi à l\'excès) à la fin de la semaine !</p>';
	$contenu_texte[] = '<p>Et croyez-moi, j\'espère bien qu\'il y ait plus de 100 CGcodes validés en une semaine. ; )</p>';
	$contenu_texte[] = '<h3>Comment fonder un clan ?</h3>';
				
	$contenu_texte[] = '<p>Il suffit de cliquer sur le lien "Recrutement / création" dans le menu, puis d\'entrer le nom du clan et ';
	$contenu_texte[] = 'une phrase de motivation, dans les deux champs en bas.</p>';
			
	$contenu_texte[] = '<h3>Comment recruter ?</h3>';
				
	$contenu_texte[] = '<p>Ce sont les membres qui viennent à vous pour postuler. Ils s\'agit pour eux de choisir leur clan dans la ';
	$contenu_texte[] = 'même page "Recrutement / création".</p>';
			
	$contenu_texte[] = '<p>Vous serez alors prévenu(e) par un texte clignotant dans le menu, et vous serez invité(e) à accepter ';
	$contenu_texte[] = 'ou refuser la candidature.</p>';
			
	$contenu_texte[] = '<h3>Où est le classement des clans ?</h3>';
					
	$contenu_texte[] = '<p>Très simple, il suffit de cliquer sur "Classement des clans" dans le menu. ; )</p>';
			
	$contenu_texte[] = '<h3>Comment dissoudre mon clan ?</h3>';
				
	$contenu_texte[] = '<p>Vous pouvez dissoudre votre clan dans la page "Gérer mon clan", si vous y être toujours seul. Sinon, cette ';
	$contenu_texte[] = 'option est bloquée.</p>';
			
	$contenu_texte[] = '<h3>D\'autres question ?</h3>';
				
	$contenu_texte[] = '<p>Si vous avez d\'autres questions, n\'hésitez pas à me contacter sur le forum ou par mail.</p>';
				
	$contenu_texte[] = '<br>';
	$contenu_texte[] = '<br>';

	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>