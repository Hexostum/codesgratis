<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'forum' . '.php');

$categories = array();
$categories_ids = array();

$res_cat = mysql_query('SELECT * FROM codesgratis_forum_categories ORDER BY cat_ordre');
while($sql_cat = mysql_fetch_array($res_cat,MYSQL_ASSOC)):
	$categories[$sql_cat['cat_id']] = $sql_cat;
	$categories_ids[] = $sql_cat['cat_id'];
endwhile;
echo mysql_error();

$forums = array();
$forums_id = array();
$forums_cats = array();

$res_forums = mysql_query('SELECT * FROM codesgratis_forum_forums ORDER BY forum_order');
while($sql_forum = mysql_fetch_array($res_forums,MYSQL_ASSOC)):
	$forums[$sql_forum['forum_cat_id']][$sql_forum['forum_id']] = $sql_forum;
	$forums_ids[] = $sql_forum['forum_id'];
	$forums_cats[$sql_forum['forum_id']] = $sql_forum['forum_cat_id'];
endwhile;
echo mysql_error();


$res_nb_sujets = mysql_query('SELECT COUNT(sujet_id) AS nb_topics , forum_id FROM codesgratis_forum_sujets WHERE forum_id IN ('. implode(' , ', $forums_ids) .') GROUP BY forum_id ');

while($sql_nb_sujets = mysql_fetch_array($res_nb_sujets) ):
	$forum = $sql_nb_sujets['forum_id'];
	$categorie = $forums_cats[$forum] ; 
	$forums[$categorie] [$forum] ['sujets'] = $sql_nb_sujets['nb_topics'];
endwhile;
echo mysql_error();

$res_nb_messages = mysql_query('SELECT COUNT(message_id) AS nb_posts , forum_id FROM codesgratis_forum_messages WHERE forum_id IN ('. implode(' , ', $forums_ids) .') GROUP BY forum_id');
while($sql_nb_messages = mysql_fetch_array($res_nb_messages ) ):
	$forum = $sql_nb_messages['forum_id'];
	$categorie = $forums_cats[$forum] ; 
	$forums[$categorie][$forum]['messages'] = $sql_nb_messages['nb_posts'];
endwhile;
echo mysql_error();

$contenu_texte[] = '<h1>Le forum de CodesGratis</h1>';
$contenu_texte[] = '<table>';
foreach($categories as $categorie):
	$contenu_texte = array_merge($contenu_texte,afficher_categorie($categorie,$forums[$categorie['cat_ordre']] ));
endforeach;
$contenu_texte[] = '</table>';

include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>