<?php
define('FP_MISE_A_JOUR' , false);
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
	error_reporting(E_ALL);	
	mysql_connect('localhost','root','');
	mysql_select_db('codesgratis');
else:
	if(FP_MISE_A_JOUR):
		define('FP_DEBUG',true);
		error_reporting(E_ALL);		
	else:
		define('FP_DEBUG',false);
		error_reporting(E_ERROR);
	endif;
	
	/** GIT : enlever les mots de passe pour publication git **/
	mysql_connect('***','***','***');
	/** --- --- **/
	
	mysql_select_db('exostumnet');
endif;

mysql_set_charset('utf8');

define('FP_CHEMIN_CLASSES', FP_CHEMIN_PHP . 'classes' . DIRECTORY_SEPARATOR );
define('FP_CHEMIN_FONCTIONS', FP_CHEMIN_PHP . 'fonctions' . DIRECTORY_SEPARATOR );
define('FP_CHEMIN_CACHE' , FP_CHEMIN_PHP . 'cache' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_CONSTANTS', FP_CHEMIN_PHP . 'constants' . DIRECTORY_SEPARATOR );
define('FP_CHEMIN_PREUVES' , FP_CHEMIN . 'preuves' . DIRECTORY_SEPARATOR);

function __autoload($nom)
{
	$nom_fichier = str_replace('fp_','',$nom);
	$lettre = $nom_fichier{0};
	require_once( FP_CHEMIN_CLASSES . $lettre . DIRECTORY_SEPARATOR . $nom_fichier . '.php');
}
include_once(FP_CHEMIN_CACHE . 'code_designation.php');
include_once(FP_CHEMIN_CACHE . 'membre_pseudo.php');

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
include_once(FP_CHEMIN_FONCTIONS . 'membres.php');



if
	(
		isset($_COOKIE['session_id'])
	)
:
	if
		(
			session_id() !==
			$_COOKIE['session_id']
		)
	:
		session_id($_COOKIE['session_id']);
	endif;
else:
	mysql_query('DELETE FROM codesgratis_sessions WHERE session_id=\'' . session_id(). '\'');
endif;
session_start();
define('FP_SESSION_ID' , session_id());

setcookie('session_id', FP_SESSION_ID , time()+60*60*24*30 );

$session_membre = new fp_enregistrement('codesgratis_sessions' , "'".FP_SESSION_ID."'" , 'session_id' );
if
	(
		$session_membre->statut()
	)
:
	$sql_membre_id = $session_membre->membre_id;
	mysql_query('DELETE FROM codesgratis_sessions WHERE membre_id='.$sql_membre_id.' AND session_id <> \'' . FP_SESSION_ID . '\'');
else:
	$sql_membre_id = NULL;
endif;
if
	(
		is_null($sql_membre_id)
	)
:
	$sql_membre_id = 'NULL';
endif;

$my_membre = new fp_membre($sql_membre_id);
$my_parrain = new fp_membre($my_membre->membre_parrain_id);

$my_session = new fp_enregistrement('codesgratis_sessions',"'".FP_SESSION_ID."'",'session_id');

if
	(
		!$my_session->statut()
	)
: 
	if
		(
			$my_membre->membre_existe()
		)
	:
		mysql_query("INSERT INTO codesgratis_sessions VALUES('".FP_SESSION_ID."' ,'" . $_SERVER['REMOTE_ADDR'] . "', ". time() .", ". $my_membre->membre_id .", '". @$_SERVER['HTTP_REFERER'] ."', '". $_SERVER['PHP_SELF'] ."')");
	else:
		mysql_query("INSERT INTO codesgratis_sessions VALUES('".FP_SESSION_ID."' ,'" . $_SERVER['REMOTE_ADDR'] . "', ". time() .", NULL, '". @$_SERVER['HTTP_REFERER'] ."', '". $_SERVER['PHP_SELF'] ."')");
	endif;
else:
	$my_session->session_date = time();
	if
		(
			$my_membre->membre_existe()
		)
	:
		$my_session->membre_id = $my_membre->membre_id;
	else:
		$my_session->membre_id = NULL;
	endif;
endif;

$time = time() - (60*5);
$sql = 'DELETE FROM codesgratis_sessions WHERE membre_id is null AND session_date < '. $time ;
mysql_query($sql);

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
			exit('<p>Le site est en cours de mise à jour. Veuillez patienter !</p>');
		/**
		**/
		endif;
		/**
		**/
	endif;
endif;
/**/

$page_titre = 'EXOSTUM - CODESGRATIS';
$contenu_texte = array();
$contenu_script = array();
?>