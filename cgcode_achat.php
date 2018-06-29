<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

include(FP_CHEMIN_FONCTIONS . 'points.php');
include(FP_CHEMIN_FONCTIONS . 'cgcodes.php');
include(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');

if($my_membre->membre_existe()):
	$contenu_texte[] = '<h1>Achat de cgcodes.</h1>';
	$contenu_texte[] = '<h2> /!\ Cette page est en cours de test /!\ </h2>';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th>Code</th><th>€</th><th>Points VIP</th><th>Points plus</th><th>Frais partenaire</th><th>Moyen de paiement</th><th>Infos</th></tr>';
	/**/
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>CG Paypal </td></td>';
	$contenu_texte[] = '<td>1.30</td>';
	$contenu_texte[] = '<td>1000</td>';
	$contenu_texte[] = '<td>'. gain_cgpaypal($my_membre->membre_vip) .'</td>';
	$contenu_texte[] = '<td> 0.25€ + 1.4% </td>';
	$contenu_texte[] = '<td><a href="https://www.paypal.fr">paypal</a></td>';
	
	
	$contenu_texte[] = '<td>' .
'<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="RUHY2WXM2RB7U">
<input type="image" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>' . '</td>';
/**
	$contenu_texte[] = '</tr>';
	
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>CG+</td><td>paypal</td>';
	$contenu_texte[] = '<td>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="L39Z3HRXZDDE4">
<input type="image" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>

	</td>';
	$contenu_texte[] = '</tr>';
	/**/
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>CG</td>';
	$contenu_texte[] = '<td>0.08</td>';
	$contenu_texte[] = '<td>80</td>';
	$contenu_texte[] = '<td>'. gain_cgcode($my_membre->membre_vip) .'</td>';
	$contenu_texte[] = '<td> 1% </td>';
	$contenu_texte[] = '<td><a href="https://www.moneybookers.com/app/?rid=9713884">moneybookers</a></td>';
	$contenu_texte[] = '<td>
<form action="https://www.moneybookers.com/app/payment.pl" method="post" target="_blank">
<input type="hidden" name="pay_to_email" value="finalserafin@gmail.com">
<input type="hidden" name="status_url" value="finalserafin@gmail.com"> 
<input type="hidden" name="language" value="FR">
<input type="hidden" name="amount" value="0.08">
<input type="hidden" name="currency" value="EUR">
<input type="hidden" name="detail1_description" value="CGCODE">
<input type="hidden" name="detail1_text" value="CGCODE utilisable sur codesgratis">
<input type="submit" value="Payer!">
</form>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '<td>CG+</td>';
	$contenu_texte[] = '<td>0.20</td>';
	$contenu_texte[] = '<td>200</td>';
	$contenu_texte[] = '<td>'. gain_cgplus($my_membre->membre_vip) .'</td>';
	$contenu_texte[] = '<td> 1% </td>';
	$contenu_texte[] = '<td><a href="https://www.moneybookers.com/app/?rid=9713884">moneybookers</a></td>';
	$contenu_texte[] = '<td>
<form action="https://www.moneybookers.com/app/payment.pl" method="post" target="_blank">
<input type="hidden" name="pay_to_email" value="finalserafin@gmail.com">
<input type="hidden" name="status_url" value="finalserafin@gmail.com"> 
<input type="hidden" name="language" value="FR">
<input type="hidden" name="amount" value="0.20">
<input type="hidden" name="currency" value="EUR">
<input type="hidden" name="detail1_description" value="CG+">
<input type="hidden" name="detail1_text" value="CG+ utilisable sur codesgratis">
<input type="submit" value="Payer!">
</form>';
	$contenu_texte[] = '</td>';
	$contenu_texte[] = '</tr>';
	$contenu_texte[] = '</table>';
	include(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location : connexion.php');
endif;
?>