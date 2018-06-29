<?php
include_once(FP_CHEMIN_PHP . 'miseajour.php');
define('FP_LIGNE' , "\r\n");
define('FP_TAB' , "\t");
define('FP_PAGE' , basename($_SERVER['PHP_SELF']) );
define('FP_ARG' , $_SERVER['QUERY_STRING']);

if
	(
		$_SERVER['HTTP_HOST']=='localhost' || 
		$_SERVER['HTTP_HOST']=='127.0.0.1'
	)
:
	define('FP_DEBUG',true);
	define('FP_MODE','local');
	error_reporting(E_ALL);	
	mysql_connect('localhost','root','');
	mysql_select_db('codesgratis');
else:
	if(FP_MISE_A_JOUR):
		define('FP_DEBUG',true);
		error_reporting(E_ALL);	
		define('FP_MODE','miseajour');	
	else:
		define('FP_DEBUG',false);
		error_reporting(E_ALL);
		define('FP_MODE','distant');
	endif;
	
	/** GIT : enlever les mots de passe pour publication git **/
	mysql_connect('***','***','***');
	/** --- --- **/
	
	mysql_select_db('exostumnet');
endif;

mysql_set_charset('utf8');

define('FP_CHEMIN_CLASSES', FP_CHEMIN_PHP . 'classes' . DIRECTORY_SEPARATOR );
define('FP_CHEMIN_FONCTIONS', FP_CHEMIN_PHP . 'fonctions' . DIRECTORY_SEPARATOR );
define('FP_CHEMIN_CONSTANTS', FP_CHEMIN_PHP . 'constants' . DIRECTORY_SEPARATOR );
define('FP_CHEMIN_CACHE' , FP_CHEMIN_PHP . 'cache' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PREUVES' , FP_CHEMIN . 'preuves' . DIRECTORY_SEPARATOR);

function __autoload($nom)
{
	$nom_fichier = str_replace('fp_','',$nom);
	$lettre = $nom_fichier{0};
	require_once( FP_CHEMIN_CLASSES . $lettre . DIRECTORY_SEPARATOR . $nom_fichier . '.php');
}

include_once(FP_CHEMIN_CACHE . 'membre_pseudo.php');
include_once(FP_CHEMIN_CACHE . 'code_designation.php');

include_once(FP_CHEMIN_CONSTANTS . 'codes.php');
include_once(FP_CHEMIN_CONSTANTS . 'historique.php');
include_once(FP_CHEMIN_CONSTANTS . 'vip.php');

include_once(FP_CHEMIN_FONCTIONS . 'html_message.php');
include_once(FP_CHEMIN_FONCTIONS . 'site.php');
include_once(FP_CHEMIN_FONCTIONS . 'vip.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique.php');
include_once(FP_CHEMIN_FONCTIONS . 'sql.php');
include_once(FP_CHEMIN_FONCTIONS . 'format_texte.php');
include_once(FP_CHEMIN_FONCTIONS . 'is_admin.php');
include_once(FP_CHEMIN_FONCTIONS . 'pagination.php');
include_once(FP_CHEMIN_FONCTIONS . 'date.php');
include_once(FP_CHEMIN_FONCTIONS . 'serveur.php');
include_once(FP_CHEMIN_FONCTIONS . 'message.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode.php');
include_once(FP_CHEMIN_FONCTIONS . 'membres.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie.php');

$my_session = new fp_session();
$my_membre = $my_session->my_membre();
$my_parrain = new fp_membre($my_membre->membre_parrain_id);
$my_session->purger(60*5);
$connectes_nombre = $my_session->connectes_nombre(60*5);


$sql_config = new fp_sql_config();
/**/
if
	(
		!isset($_GET['bypass'])
	)
:
	if(FP_MISE_A_JOUR):
		/**
		**/
		if
			(
				! ( is_admin($my_membre) ) 
			)
		:
		/**
		**/
			header('Location: miseajour.php');
			exit();
		/**
		**/
		endif;
		/**
		**/
	endif;
endif;

/**/
if
	(
		is_admin($my_membre)
	)
:
	if
		(
			isset($_GET['overdrive_id'])
		)
	:
		$my_membre = new fp_membre(intval($_GET['overdrive_id']));
		$my_parrain = new fp_membre(intval($my_membre->membre_parrain_id));
	endif;
endif;
/**/

$page_titre = 'EXOSTUM - CODESGRATIS';
$contenu_texte = array();
$contenu_script = array();
if
	(
		$my_membre->membre_existe()
	)
:
	update_vip($my_membre);
	if($my_membre->membre_tickets > 0 || $my_membre->membre_tickets_plus > 0 ):
		$contenu_texte[] = message ('Vos anciens tickets peuvent être échangés contre des points plus ici : <a href="compte_tickets.php">http://www.codesgratis.fr/compte_tickets.php</a>.', FP_MESSAGE_INFOS);
	endif;
		
	if($my_membre->membre_courriel==''):
		$contenu_texte[] = message ('Votre adresse courriel n\'est pas renseigné. Afin de pouvoir jouer à certains jeux ou gagner certains cadeaux, votre adresse courriel est requise. <a href="compte_courriel.php">Modifier votre adresse courriel</a>' , FP_MESSAGE_ERROR);
	else:
		if($my_membre->membre_courriel_ok==0):
			$contenu_texte[] = message ('Votre adresse courriel est renseigné, vous avez reçu un courriel contenant un code vous permettant de valider votre adresse courriel. <a href="compte_courriel.php">Rentrez le code</a>' , FP_MESSAGE_REPONSE);
		endif;
	endif;
	
	$messages_lu = sql_result('SELECT count(message_id) FROM codesgratis_messagerie where message_to_lu=0 and message_code=0 and message_to_id = '.$my_membre->membre_id);
	if($messages_lu > 0):
		$contenu_texte[] = message ('Vous avez '.$messages_lu.' message(s) non lu(s)' , FP_MESSAGE_INFOS);
	endif;
endif;
$afficher_pub=false;
?>