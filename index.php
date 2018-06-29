<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

require_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'bbcode.php');
include_once(FP_CHEMIN_FONCTIONS . 'maj.php');

verif_variables_get(array( 'maj_id' , 'page' , 'parrain_id' , 'membre_id' ));
	
if
	( 
		(isset($_GET['parrain'])) || 
		(isset($_GET['parrain_id']))
	)
:
	//Sécurité MySQL
	$parrain_pseudo = htmlspecialchars($_GET['parrain'], ENT_QUOTES);
	$parrain_id = intval($_GET['parrain_id']);
			
	//Vérification de l'existence de ce membre
	if($parrain_id>0):
		$m_parrain = new fp_membre($parrain_id);
	else:
		$m_parrain = new fp_membre("'".$parrain_pseudo."'",'membre_pseudo');
	endif;
	if($m_parrain->membre_existe()):
		$_SESSION['parrain_id'] = $m_parrain->membre_id;
	endif;
	unset($m_parrain);
endif;

$page_titre .= ' - Mise à jour du site ';

if
	(
		!$my_membre->membre_existe()
	)
:
/**
	$contenu_texte[] = '<h1>Bienvenue sur CodesGratis !!</h1>';
	$contenu_texte[] = '<p>Ce site n\'attend que vous pour vous faire remporter gratuitement et facilement des';
	$contenu_texte[] = '<a href="vitrine.php" title="Venez prendre connaissance des prix à gagner, et de que faire pour les obtenir !">codes audiotels</a> ';
	$contenu_texte[] = 'pour vos jeux Internet favoris (par exemple : Pack+ pour ';
	$contenu_texte[] = '<a href="http://www.prizee.com">Prizee</a>, Y-code pour <a href="http://www.yacado.com">Yacado</a> ou 	';
	$contenu_texte[] = 'Gratcode pour <a href="http://www.gratkado.com">Gratkado</a>, entre encore ';
	$contenu_texte[] = '<a href="vitrine.php" title="Venez prendre connaissance des prix à gagner, et de que faire pour les obtenir !">	';
	$contenu_texte[] = 'de nombreux autres</a> !) !</p>';
	$contenu_texte[] = ' 			';		
	$contenu_texte[] = '<p>Le but du jeu est très simple : ';
	$contenu_texte[] = '<a href="inscription.php" title="Inscrivez-vous, et gagnez des codes gratuitements !">vous vous inscrivez ';
	$contenu_texte[] = 'ici</a>, et un lien propre à votre compte vous sera fourni. Vous devrez amener les gens à visiter la page ';
	$contenu_texte[] = 'de ce lien, de manière à gagner un point à chaque visite unique (un visiteur ne peut vous faire remporter ';
	$contenu_texte[] = 'qu\'un point chaque jour) de la page. Vous accumulerez ainsi les points ';
	$contenu_texte[] = 'qui, lorsqu\'ils seront en nombre suffisant, pourront être échangés ';
	$contenu_texte[] = 'contre un (ou des) code(s) de votre choix dans la ';
	$contenu_texte[] = '<a href="vitrine.php" title="Venez prendre connaissance des prix à gagner, et de que faire pour les obtenir !">vitrine</a>.</p>';
	$contenu_texte[] = '				';
	$contenu_texte[] = '<p>Vous obtiendrez ce code dans un délai d\'un mois maximum (le délai réel peut être bien plus ';
	$contenu_texte[] = 'court, cela dépend de la disponibilité du webmaster). Si ce délai n\'est pas respecté, vous serez ';
	$contenu_texte[] = 'remboursé de 100% du nombre de points dépensés.</p>';
	$contenu_texte[] = ' 					';
	$contenu_texte[] = '<p>N\'attendez pas, <a href="inscription.php" title="Inscrivez-vous, et gagnez des codes gratuitements !">';
	$contenu_texte[] = 'inscrivez-vous dès maintenant</a>, jouez, et remportez vos codes !</p>';
	$contenu_texte[] = '					';
	$contenu_texte[] = '<br>';
	$contenu_texte[] = '<br>';
	$contenu_texte[] = ' ';
/**/
else:
	
endif;


if
	(
		!isset($_GET['maj_id'])
	)
:
	$infos = sql_limiteur
	(
		array
		(
			'unit_par_page'=>20,
			'table'=>'codesgratis_maj',
			'table_compteur'=>'maj_id'
		)
	);
	
	$sql_maj_1 = new fp_enregistrement('codesgratis_maj',sql_result('SELECT maj_id FROM codesgratis_maj ORDER BY maj_date DESC LIMIT 1'),'maj_id');
	
	$retour = mysql_query('SELECT * FROM codesgratis_maj ORDER BY maj_date DESC LIMIT '. $infos['limit']);
	$texte =  array();
	
	while($sql_maj = mysql_fetch_array($retour,MYSQL_ASSOC)):
		if($sql_maj_1->maj_id!==$sql_maj['maj_id']):
			$texte = array_merge($texte, resume_maj(new fp_enregistrement_sql($sql_maj,'codesgratis_maj','maj_id') ));
		endif;
	endwhile;
	
	if(count($texte)==0):
		if(isset($_GET['page'])):
			header('Location: index.php');
			exit();
		else:
			$texte .= '<p>Aucune mise à jour pour l\'instant. </p>';
		endif;
	else:
		if(isset($_GET['page'])):
			if(intval($_GET['page'])==0):
				header('Location: index.php');
				exit();
			else:
				$page_titre .= ' [page : '.(intval($_GET['page'])+1).'] ';
			endif;
		else:
			$page_titre .= ' [première page]';
		endif;
		
		$contenu_texte[] = message('<h1>Dernière mise à jour du site.</h1>', FP_MESSAGE_INFOS);
		$contenu_texte[]= afficher_maj($sql_maj_1,true);
		$contenu_texte[] = message ('<h1>Archives des mises à jour du site.</h1>', FP_MESSAGE_INFOS);
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
		$contenu_texte[] = '<table>';
		$contenu_texte = array_merge($contenu_texte,$texte);
		$contenu_texte[] = '</table>';
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
	endif;
	
else:

	$maj_id = intval($_GET['maj_id']);
	$sql_maj = new fp_enregistrement('codesgratis_maj',$maj_id,'maj_id');
	
	if($sql_maj->statut()):	
		if($my_membre->membre_existe()):
			
			if(isset($_POST['submit_com'])):
				$commentaire = $_POST['com_message'];
				
				if($commentaire != ''):
					$sql = sql_insert
					(
						'codesgratis_coms',
						array
						(
							'com_type' => sql_champ_texte('maj'),
							'com_type_id' => $maj_id,
							'com_id' => 'NULL',
							'membre_id' => $my_membre->membre_id,
							'com_texte' => sql_champ_texte($commentaire),
							'com_date' => 'UNIX_TIMESTAMP()'
						)
					);
					$contenu_texte[] = message_admin($sql , FP_MESSAGE_INFOS);
					if(mysql_query($sql)):
						$sql_maj->maj_coms++;
						$contenu_texte[] =  message ( 'Votre commentaire a bien été enregistré ! Merci de votre participation !' , FP_MESSAGE_INFOS);
					else:
						$contenu_texte[] = message_admin( mysql_error() , FP_MESSAGE_ERROR);
					endif;
				endif;
				
			endif;
			
		endif;
		$contenu_texte[]= afficher_maj($sql_maj,true);
		$page_titre .= ' [' . $sql_maj->maj_titre . ']';
		if(isset($_GET['page'])):
			if(intval($_GET['page'])==0):
				header('Location: index.php?maj_id='.$maj_id);
				exit();
			else:
				$page_titre .= ' [page : '.(intval($_GET['page'])+1).'] ';
			endif;
		else:
			$page_titre .= ' [première page]';
		endif;
		
	endif;
	
endif;
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/bbcode.js"></script>';

include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>