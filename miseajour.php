<?php
if
	(
		$_SERVER['HTTP_HOST']=='localhost' || 
		$_SERVER['HTTP_HOST']=='127.0.0.1'
	)
:
	define('FP_MODE','local');
else:
	define('FP_MODE','distant');
endif;
include_once(dirname(__file__) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'miseajour.php');
if(FP_MISE_A_JOUR==true):
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
	<title>EXOSTUM - CODESGRATIS - Mise à jour</title>
	<?php if(FP_MODE=='distant'):?>
	<base href="http://www.codesgratis.fr">
	<?php else:?>
	<base href="http://localhost/codesgratis/">
	<?php endif;?>
	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="html/style/design3.css">
	<link rel="icon" type="image/png" href="html/images/favicon_codesgratis.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
		<div id="menu">
			<h2>CodesGratis</h2>
			<ul>
				<li><a href="index.php" title="Retourner  la page d\'accueil">Accueil</a></li>
			</ul>
		</div>
		<div id="corps">
			<div class="habillage_pub_banniere">
				<div class="pub_banniere">
					<!-- BEGIN CODE NetAffiliation : http://www.netaffiliation.com/ -->
					<iframe src="http://action.metaffiliation.com/emplacement.php?emp=57689Ib0acdc6770e2f8b5" width="468" height="60" scrolling="no" frameborder="0"></iframe>
					<!-- END CODE NetAffiliation -->
				</div>
			</div>
			<div class="message_erreur">Le site est en cours de mise à jour. Veuillez patienter.</div>
			<div class="message_informations">Etape 1 : Récupération de la base de données Début : 6 mai 2013 17H50 </div>
			<div class="message_informations">Etape 2 : Importation des 455 784  enregistrements des 52 tables de la base de donnée  pour un total de 23,8 Mio Début : 6 mai 2013 17H51 Fin : 17 mai 2013 00H28 </div>
			<div class="message_informations">Correction de bogue : Réparation d'une erreur de syntaxe dans la page de mise à jour (6 mai 2013 00H32)</div>
			<div class="message_informations">Information : Mise à jour de la page de mise à jour pour information sur l'avancement du site (6 mai 2013 00H30)</div>
		</div>
		<div id="footer">
			<!--<h2><a href="support.php">Informations de support.</a></h2>-->
				<div class="partenaires">
					<h1 class="petit_titre_h">Partenaires :</h1>
						<ul class="menu_h">
						<li><a href="http://www.gagner-argent-internet.org" title="GSI : Gagner de l\'argent avec l\'Internet">GSI</a></li>
						<li><a href="http://www.CrocAstuce.fr" title="CrocAstuce : Astuces de jeu"><strong>Astuces de jeu</strong></a></li>
						<li><a href="http://www.sitacados.com" title="Jeux gratuits">Jeux</a></li>
						<li><a href="http://www.portaildesjeux.com" title="Portail des Jeux - Annuaire de jeux">Jeux gratuits</a></li>
						<li><a href="http://www.wincode.fr">Wincode</a></li>
						<li><a href="http://www.fastcodes.fr">Fastcodes</a></li>
						<li><a href="http://www.codilo.com">Codilo</a></li>
						<li><a href="http://www.pcconviction.com">PC Conviction</a></li>
					</ul>
				</div>
				<div id="site_informations">
				Ce site est édité par <a href="http://www.exostum.net/">Scelzo Patrick Jean (Auto-Entrepreneur)</a>.<br>
				Code SIRET : 514 550 763 00015<br>
				Code APE : 6201Z (Programmation Informatique)<br>
				L'intégralité de ce site est protégé par le droit d'auteur.<br>
				Ce site utilise une version modifié de <a href="http://forum.exostum.net/viewforum.php?f=174">Final Portail</a> (CMS) non ouverte au public.</div>
		</div>
		<div id="footer_b"></div>
	</div>
</body>
</html>
<?php
else:
	header('Location: index.php');
endif;
?>