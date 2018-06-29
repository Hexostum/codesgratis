<?php
function menu()
{
	$my_membre = $GLOBALS['my_membre'];
	$my_parrain = $GLOBALS['my_parrain'];
	$connectes_nombre = $GLOBALS['connectes_nombre'];
	$texte = array();
	
	$texte[] = '<ul>';
	$texte[] = '<h2><a href="http://www.exostum.net/">Réseau Exostum</a></h2>';
	$texte[] = '<li>Codesgratis</li>';
	//$texte[] = '<li><a href="http://dimensionrpg.exostum.net/"</a>dimensionrpg</a></li>';
	$texte[] = '<li><a href="http://blog.exostum.net/">Blog du webmasteur</a></li>';
	$texte[] = '<li><a href="http://forum.exostum.net/">Forum du webmasteur</a></li>';
	$texte[] = '</ul>';
	
	$texte[] = '<ul>';
	$texte[] = '<h2>CodesGratis</h2>';
	$texte[] = FP_TAB . '<li><a href="index.php" title="Retourner  la page d\'accueil">Accueil</a></li>';
	$texte[] = FP_TAB . '<li><a href="vitrine.php" title="Venez prendre connaissance des prix à gagner">La vitrine</a></li>';
	$texte[] = FP_TAB . '<li><a href="classement.php" title="Découvrez le classement de nos joueurs inscrits !">Le classement</a></li>';
	$texte[] = FP_TAB . '<li><a href="gagnants.php" title="Qui a gagné quoi ?">Les gagnants</a></li>';
	$texte[] = FP_TAB . '<li><a href="enligne.php" title="Qui a gagné quoi ?">Les membres en ligne.</a></li>';
	$texte[] = FP_TAB . '<li><a href="http://forum.exostum.net/" title="">Le forum</a></li>';
	$texte[] = FP_TAB . '<li><a href="livreor.php" title="CodesGratis vous plait ? N\'hésitez pas à le dire !">Le livre d\'or</a></li>';
	$texte[] = FP_TAB . '<li><a href="support.php" title="Support et contact">Support et contact.</a></li>';
	$texte[] = FP_TAB . '<li><a href="reglement.php" title="Avant de jouer, prenez bien en compte le réglement !">Le réglement</a></li>';
	$texte[] = FP_TAB . '<li><a href="partenaires.php" title="Les partenaires de CodesGratis">Partenaires</a></li>';
	$texte[] = '</ul>';
	
	$texte[] = '<ul>';
	$texte[] = '<h2>Statistiques</h2>';
	$texte[] = '<li>Le '. format_date(time()) . '</li>';
	$points = sql_result('SELECT sum(membre_points) FROM codesgratis_membres where membre_id > 0 AND membre_banni=0');
	$points_plus = sql_result('SELECT sum(membre_points_plus) FROM codesgratis_membres where membre_id > 0 AND membre_banni=0');
	$total = ($points + ($points_plus *2 ) ) / 1000;
	$texte[] = '<li> Compte joueurs : '.number_format($total,2,',',' ').' € </li>';
	$texte[] = '<li> Connectés : ' . $connectes_nombre . '</li>';
	$inscrits = sql_result('SELECT count(membre_id) from codesgratis_membres where membre_banni=0');
	$texte[] = '<li> Membres : <a href="membre.php">'.$inscrits.'</a> </li>';
	$texte[] = '</ul>';

	if(!$my_membre->membre_existe()):
		if($_SERVER['PHP_SELF']!='/connexion.php'):
			$texte[] = '<ul>';
			$texte[] = '<h2>Connexion</h2>';
			$texte[] = FP_TAB . '<li><p><a href="connexion.php">Connexion</a></p></li>';
			$texte[] = FP_TAB . '<li><p><a href="inscription.php" title="Inscrivez-vous, et gagnez des codes gratuitements !">Inscription</a></p></li>';
			$texte[] = '</ul>';
		endif;
	else:
		include(FP_CHEMIN_PHP . 'infos_compte.php');
	endif;
	return $texte ;
}
function pied($indent=0)
{
	$xiti_page = basename($_SERVER['PHP_SELF'],'.php');
	$texte = array();
	
	$texte[] = '<div id="footer">';	
	$texte[] = '<h2><a href="support.php">Informations de support.</a></h2>';
	$texte[] = FP_TAB . '<div class="partenaires">';
	$texte[] = FP_TAB . FP_TAB . '<h1 class="petit_titre_h">Partenaires :</h1>';
	$texte[] = FP_TAB . FP_TAB . '<ul class="menu_h">';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.gagner-argent-internet.org" title="GSI : Gagner de l\'argent avec l\'Internet">GSI</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.envoyersms.biz/" target="_blank" title="Envoyer SMS">Envoyer SMS</a></li>';
	
	/**
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.gagner-argent-internet.org" title="GSI : Gagner de l\'argent avec l\'Internet">GSI</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.CrocAstuce.fr" title="CrocAstuce : Astuces de jeu"><strong>Astuces de jeu</strong></a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.sitacados.com" title="Jeux gratuits">Jeux</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.portaildesjeux.com" title="Portail des Jeux - Annuaire de jeux">Jeux gratuits</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.wincode.fr">Wincode</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.fastcodes.fr">Fastcodes</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.codilo.com">Codilo</a></li>';
	$texte[] = FP_TAB . FP_TAB . FP_TAB . '<li><a href="http://www.pcconviction.com">PC Conviction</a></li>';
	/**/
	$texte[] = FP_TAB . FP_TAB . '</ul>';
	$texte[] = FP_TAB . '</div>';
	
	
	$texte[] = '<div id="site_informations">';
	$texte[] ='Ce site est édité par <a href="http://www.exostum.net/">Scelzo Patrick Jean (Auto-Entrepreneur)</a>.<br>';
	$texte[] ='Code SIRET : 514 550 763 00015<br>';
	$texte[] ='Code APE : 6201Z (Programmation Informatique)<br>';
	$texte[] ='L\'intégralité de ce site est protégé par le droit d\'auteur.<br>';
	$texte[] ='Ce site utilise une version modifié de <a href="http://forum.exostum.net/viewforum.php?f=174">Final Portail</a> (CMS) non ouverte au public.';
	$texte[] = '</div>';
	$texte[] = '</div>';
	$texte[] = '<div id="footer_b"></div>';
	
	return $texte ;
	
}
function pub($ok=true)
{
	$texte = array();
	if($ok):
		$texte [] = '<div class="pub" id="pub_promobenef">';
		$texte [] = FP_TAB . '<!-- Tag PromoBenef site membre N75212-->
<script type="text/javascript">
<!--
var promobenef_site = "75212";
var promobenef_minipub = "0";
var promobenef_format = "1";
//-->
</script>
<script type="text/javascript" src="http://www.promobenef.com/pub/"></script>
<noscript><p><a href="http://www.promobenef.com/">PromoBenef : r&eacute;gie publicitaire<img src="http://www.promobenef.com/no_js/?sid=75212&amp;fid=1" alt="PromoBenef" width="0" height="0" style="border:none;" /></a></p></noscript>';
		$texte [] = '</div>';
	endif;
	return $texte;
}
?>