<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):
	//$contenu_texte[] = '<CENTER>';
	$contenu_texte[] = '<APPLET name="coolsmile" code="EIRC.class" codebase="html/java/" width="100%" height="600">';
	$contenu_texte[] = '<PARAM name="archive" value="EIRC.jar,EIRC-cfg.jar">';
	$contenu_texte[] = '<PARAM name="cabbase" value="EIRC.cab,EIRC-cfg.cab">';
	$contenu_texte[] = '<PARAM name="server" value="irc.epiknet.org">';
	$contenu_texte[] = '<PARAM name="port" value="6667">';
	$contenu_texte[] = '<PARAM name="irc_pass" value="">';
	$contenu_texte[] = '<PARAM name="font_name" value="SansSerif">';
	$contenu_texte[] = '<PARAM name="font_size" value="11">';
	$contenu_texte[] = '<PARAM name="language" value="FR">';
	$contenu_texte[] = '<PARAM name="mainbg" value="#809BDC">';
	$contenu_texte[] = '<PARAM name="mainfg" value="#000000">';
	$contenu_texte[] = '<PARAM name="textbg" value="#FFFFFF">';
	$contenu_texte[] = '<PARAM name="textfg" value="#000000">';
	$contenu_texte[] = '<PARAM name="selbg" value="#F0F0FF">';
	$contenu_texte[] = '<PARAM name="selfg" value="#000000">';
	$contenu_texte[] = '<PARAM name="join" value="#codesgratis">';
	$contenu_texte[] = '<PARAM name="username" value="test">';
	$contenu_texte[] = '<PARAM name="realname" value="test">';
	$contenu_texte[] = '<PARAM name="nickname" value="'.$my_membre->membre_pseudo.'">';
	$contenu_texte[] = '<PARAM name="user_modes" value="">';
	$contenu_texte[] = '<PARAM name="nicksrv_pass" value="">';
	$contenu_texte[] = '<PARAM name="login" value="1">';
	$contenu_texte[] = '<PARAM name="asl" value="1">';
	$contenu_texte[] = '<PARAM name="spawn_frame" value="0">';
	$contenu_texte[] = '<PARAM name="disabled_cmds" value="join">';
	$contenu_texte[] = '<PARAM name="gui_nick" value="0">';
	$contenu_texte[] = '<PARAM name="gui_away" value="1">';
	$contenu_texte[] = '<PARAM name="gui_chanlist" value="0">';
	$contenu_texte[] = '<PARAM name="gui_userlist" value="0">';
	$contenu_texte[] = '<PARAM name="gui_options" value="0">';
	$contenu_texte[] = '<PARAM name="gui_help" value="0">';
	$contenu_texte[] = '<PARAM name="gui_connect" value="0">';
	$contenu_texte[] = '<PARAM name="width" value="700">';
	$contenu_texte[] = '<PARAM name="height" value="500">';
	$contenu_texte[] = '<PARAM name="write_color" value="12">';
	$contenu_texte[] = '<PARAM name="debug_traffic" value="0">';
	$contenu_texte[] = '<PARAM name="boxmessage" value="Please wait while loading chat box...">';
	$contenu_texte[] = '<PARAM name="boxbgcolor" value="blue">';
	$contenu_texte[] = '<PARAM name="boxfgcolor" value="black">';
	$contenu_texte[] = '<PARAM name="progressbar" value="true">';
	$contenu_texte[] = '<PARAM name="progresscolor" value="red">';
	$contenu_texte[] = message('<A HREF="http://www.java.com">Java</A> doit être activé !', FP_MESSAGE_ERROR);
	$contenu_texte[] = '</APPLET>';
	//$contenu_texte[] = '</CENTER>';
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>