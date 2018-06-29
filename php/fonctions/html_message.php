<?php
function html_mail($contenu)
{
	/**/
	$texte = array();
	$texte [] = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
	$texte [] = '<html>';
	$texte [] =	'<head>';
	$texte [] =	'	<base href="http://www.codesgratis.fr">';
	$texte [] =	'	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="html/style/design3.css">';
	$texte [] =	'	<link rel="icon" type="image/png" href="html/images/favicon_codesgratis.png">';
	$texte [] =	'	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	$texte [] =	'</head>';
	$texte [] =	'<body>';
	$texte [] = $contenu;
	$texte [] =	'</body>';
	$texte [] = '</html>';
	return implode ("\r\n" , $texte);
	/**/
}
function html_message($script,$href,$message,$pub_id,$form=true)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<?php if(FP_MODE=='local'):?>
		<base href="http://localhost/codesgratis/">
		<?php else:?>
		<base href="http://www.codesgratis.fr">
		<?php endif;?>
		<link type="text/css" media="screen" rel="stylesheet" title="Design" href="html/style/design3.css">
		<link rel="icon" type="image/png" href="html/images/favicon_codesgratis.png">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body style="text-align:center;">
		<?php if($form): ?>
		<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post" name="compteur" id="compteur">
			<input type="hidden" name="pub_id_hash" id="pub_id_hash" value="<?php echo md5($pub_id); ?>">
			<?php endif; ?>	
			<p id="info"><?php echo $message ?></p>
			<?php if($form): ?>
		</form>
		<?php endif; ?>
		<p><a class="retour" target="_top" href="<?php echo $href; ?>">Cliquez ici pour fermer cette fenêtre.</a></p>
		<div class="javascript">
			<?php echo $script; ?>	
		</div>
	</body>
</html>
<?php
}
function html ( $params )
{
	$l_params = new fp_params($params);
	$page_titre = $l_params->page_titre;
	$contenu_menu = $l_params->contenu_menu;
	$contenu_pub = $l_params->contenu_pub;
	$contenu_texte = $l_params->contenu_texte;
	$contenu_pied = $l_params->contenu_pied;
	$contenu_script = $l_params->contenu_script;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html lang="fr">
<head>
	<title><?php echo $page_titre; ?></title>
	<?php if(FP_MODE=='local'):?>
	<base href="http://localhost/codesgratis/">
	<?php else:?>
	<base href="http://www.codesgratis.fr">
	<?php endif;?>
	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="html/style/design3.css">
	<link rel="icon" type="image/png" href="html/images/favicon_codesgratis.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="robots" content="noindex">
<script type="text/javascript">
<!--
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12095172-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
  })();
-->
</script>
</head>
<body>
	<div id="global">
		<div id="header"></div>
		<div id="menu"><?php echo $contenu_menu; ?></div>
		<div id="corps"><?php echo $contenu_pub; ?><?php echo $contenu_texte; ?></div>
<?php echo $contenu_pied; ?></div>
	<div id="javascript"><?php echo $contenu_script; ?></div>
</body>
</html>
<?php
}
function html_admin( $params )
{
	$l_params = new fp_params($params);
	$page_titre = $l_params->page_titre;
	$contenu_menu = $l_params->contenu_menu;
	$contenu_pub = $l_params->contenu_pub;
	$contenu_texte = $l_params->contenu_texte;
	$contenu_pied = $l_params->contenu_pied;
	$contenu_script = $l_params->contenu_script;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">

<head>
	<title>Exostum - CodesGratis - Administration - <?php echo $page_titre; ?></title>
	
	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="../html/style/admin.css">
	<link rel="icon" type="image/png" href="../html/images/favicon_codesgratis.png">
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<!--//SECTION[TITRE]//-->
<div class="section" id="section_titre">

	<!--//CONTENU[TITRE]//-->
	<div class="section_contenu">
		<h1>Exostum</h1>
	</div>
	<!--//CONTENU[TITRE]//-->
	
</div>
<!--//SECTION[TITRE]//-->

<!--//SECTION[CONTENU]//-->
<div class="section" id="section_contenu">

	<!--//CONTENU[CONTENU]//-->
	<div class="section_contenu">
		<div class="item"><?php echo $contenu_texte; ?></div>
	</div>
</div>

<!--//SECTION[MENU]//-->
<div class="section" id="section_menu">

	<!--//CONTENU[MENU]//-->
	<div class="section_menu">
		<ul>
			<li><a href="../index.php"> Sortir de l'administration</a></li>
			<li><a href="index.php"> Revenir à l'index</a></li>
		</ul>
	</div>
	<!--//CONTENU[MENU]//-->
	
</div>
<!--//SECTION[MENU]//-->


	
</body>
</html>
<?php
}
?>