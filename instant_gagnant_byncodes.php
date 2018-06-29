<?php
if(0):
session_start();
mysql_connect('sql1.exostum.net','exostumnet','DG5c2Axp');
mysql_select_db("exostumnet");
mysql_set_charset('utf8');
include('php/connectes_purger.php'); 
if(isset($_SESSION['pseudo']) && $_SESSION['pseudo'] != ''):
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">

<head>
	<title>CodesGratis : gagnez des codes audiotels gratis très facilement !!</title>
	
	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="html/style/design3.css">
	<link rel="icon" type="image/png" href="html/images/favicon_codesgratis.png">
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

	<div id="global">
	
		<div id="header"></div>
		
		<div id="menu">
			<?php include('php/menu.php'); ?>
		</div>
	
		<div id="corps" style="text-align:center">
			
			<h1>Tentez votre chance sur l'instant gagnant byncodes !</h1>
			
			<?php
	if($_POST['jouer'] == 1)
	{
	
		$retour = mysql_query('SELECT nb_tickets_plus FROM inscrits WHERE pseudo=\''. $_SESSION['pseudo'] .'\'');
		$donnees = mysql_fetch_array($retour);
						
		if($donnees['nb_tickets_plus'] >= 1)
		{
			$retour2 = mysql_query('SELECT code FROM codesgratis_cgcodes_plus WHERE utilisateur=\''. $_SESSION['pseudo'] .'\' AND utilisation=\'Seulement validé\'');
			$donnees2 = mysql_fetch_array($retour2);
			mysql_query('UPDATE codesgratis_cgcodes_plus SET utilisation=\'Instant gagnant byncode\' WHERE code=\''. $donnees2['code'] .'\'');
							
			$nb_tickets_plus = $donnees['nb_tickets_plus'];
			$nb_tickets_plus--;
			mysql_query('UPDATE inscrits SET nb_tickets_plus=\''. $nb_tickets_plus .'\' WHERE pseudo=\''. $_SESSION['pseudo'] .'\'');
						
							
			//Instant gagnant
			mysql_query('UPDATE codesgratis_instants_gagnants_byncode SET nb_courant=nb_courant+1');
			$retour3 = mysql_query('SELECT nb_courant FROM codesgratis_instants_gagnants_byncode');
			$donnees3 = mysql_fetch_array($retour3);
			if($donnees3['nb_courant'] == 10)
			{
				mysql_query('UPDATE codesgratis_instants_gagnants_byncode SET nb_courant=0');
				mysql_query('INSERT INTO codesgratis_instants_gagnants_byncode_gagnants VALUES(\'\', \''. $_SESSION['pseudo'] .'\', \''. time() .'\')');
							
				$codes_gagnant = '';
				for($i = 1 ; $i <= 5 ; $i++)
				{
					$retour7 = mysql_query('SELECT code FROM codesgratis_instants_gagnants_byncode_codes');
					$donnees7 = mysql_fetch_array($retour7);
					$codes_gagnant .= $donnees7['code'] .'\n';
					mysql_query('DELETE FROM codesgratis_instants_gagnants_byncode_codes WHERE code=\''. $donnees7['code'] .'\'');
				}
								
				mysql_query("INSERT INTO codesgratis_messagerie VALUES('', 'FLo', '". $_SESSION['pseudo'] ."', 'Vos 5 byncodes gagnés à l\'instant gagnant !', 'Félicitations à vous ! =)\n\nVos 5 byncodes :\n\n$codes_gagnant\n\nCordialement,\nFLo.', '0', '". time() ."')");
							
				echo '<p style="color:green">Vous remportez cet instant gagnant ! 5 byncodes vous ont été 
								envoyés à l\'instant. Félicitations ! 
								<img src="http://www.pcconviction.com/smileys/Content1.gif" alt="=)" /></p>';
			}
			else
			{
				$retour7 = mysql_query('SELECT code FROM codesgratis_cgcodes WHERE utilisation=\'Instants gagnants\'');
				$donnees7 = mysql_fetch_array($retour7);
				$cgcodes_gagnant = $donnees7['code'];
				mysql_query('UPDATE codesgratis_cgcodes SET utilisation=NULL WHERE code=\''. $donnees7['code'] .'\'');
							
				mysql_query("INSERT INTO codesgratis_messagerie VALUES('', 'FLo', '". $_SESSION['pseudo'] ."', 'Votre CGcode gagné à l\'instant gagnant.', 'Vous aurez sans doute plus de chance la prochaine fois. ;)\n\nEn attendant, le CGcode en question :\n\n $cgcodes_gagnant\n\nCordialement,\nFLo.', '0', '". time() ."')");
								
				echo "<p style=\"color:green\">Désolé, vous ne remportez pas le lot pour cette fois ... Mais un 
								CGcode vient tout de même de vous être envoyé dans votre messagerie ! 
							<img src=\"http://www.pcconviction.com/smileys/Clin_d'oeil.gif\" alt=\"=)\" /></p>";
			}
		}
		else
		{
			echo '<p>Vous n\'avez pas de ticket+ pour tenter votre chance à l\'instant gagnant. 
						<a href="validation_cgcodes_plus.php">Achetez-en un ici avec un CGcode+ !</a></p>';
		}
						
		$retour = mysql_query('SELECT nb_tickets_plus FROM inscrits WHERE pseudo=\''. $_SESSION['pseudo'] .'\'');
		$donnees = mysql_fetch_array($retour);
						
		echo '<hr /><br />';
						
		if($donnees['nb_tickets_plus'] > 1)
		{
			echo '<p style="color:green">Vous avez maintenant '. $donnees['nb_tickets_plus'] .' tickets+.</p>';
		}
		else
		{
			echo '<p style="color:green">Vous avez maintenant '. $donnees['nb_tickets_plus'] .' ticket+.</p>';
		}
						
		echo '<hr /><br />';
	}
	$retour = mysql_query('SELECT nb_tickets_plus FROM inscrits WHERE pseudo=\''. $_SESSION['pseudo'] .'\'');
	$donnees = mysql_fetch_array($retour);
					
	echo '<p>Cet instant gagnant permet de gagner 5 byncodes !</p>';
					
	echo '<p>C\'est le membre qui valide le dixième ticket+ qui les remporte. Les autres tickets+ joués 
					sont tous gagnants d\'un CGcode !</p>';
					
	echo '<p>Les codes sont instantanément envoyés dans la messagerie personnelle de CodesGratis !</p>';
					
	$dernier_gagnant = mysql_query('SELECT * FROM codesgratis_instants_gagnants_byncode_gagnants ORDER BY id DESC LIMIT 1');
	$dernier_gagnant = mysql_fetch_array($dernier_gagnant);
					
	if(!empty($dernier_gagnant['gagnant']))
	{
		echo '<p>Le dernier instant gagnant byncodes a été remporté 
					par '. $dernier_gagnant['gagnant'] .'. Félicitations à notre gagnant(e) !</p>';
	}
					
	$retour4 = mysql_query('SELECT COUNT(*) AS nb_tickets_plus_tombola FROM codesgratis_tombola_tickets');
	$donnees4 = mysql_fetch_array($retour4);
					
	if($_POST['jouer'] != 1)
	{
		if($donnees['nb_tickets_plus'] > 1)
		{
			echo '<p>Vous avez actuellement '. $donnees['nb_tickets_plus'] .' tickets+.</p>';
		}
		else
		{
			echo '<p>Vous avez actuellement '. $donnees['nb_tickets_plus'] .' ticket+.</p>';
		}
	}
	$retour7 = mysql_query('SELECT COUNT(*) AS nb_dispos FROM codesgratis_instants_gagnants_byncode_codes');
	$donnees7 = mysql_fetch_array($retour7);
					
	if($donnees['nb_tickets_plus'] >= 1)
	{
		if($donnees7['nb_dispos'] >= 5)
		{
			?>
				
							<form method="post" action="instant_gagnant_byncodes.php">
								<input type="hidden" name="jouer" value="1">
								<br>
								<input type="submit" value="Cliquez ici pour enregistrer un ticket+ et tenter de gagner l'instant gagnant byncodes ! (1 ticket+ requis)">
							</form>
				
			<?php
		}
		else
		{
			echo '<p>Il n\'y a pas assez de byncodes consacrés à l\'instant gagnant pour le 
					moment. Le webmaster en rajoutera dès que possible. Merci pour votre patience.</p>';
		}
	}
	else
	{
		echo '<p>Vous n\'avez pas de ticket pour tenter votre chance à l\'instant gagnant. 
						<a href="validation_cgcodes_plus.php">Achetez-en un ici avec un CGcode+ !</a></p>';
	}

				
				
			?>
					</table>
		</div>
	
		<p id="footer">
	  <a href="http://www.xiti.com/xiti.asp?s=393972" title="WebAnalytics" target="_top">
				<script type="text/java-script">
				<!--
				Xt_param = 's=393972&p=instant_gagnant_byncodes';
				try {Xt_r = top.document.referrer;}
				catch(e) {Xt_r = document.referrer; }
				Xt_h = new Date();
				Xt_i = '<img width="80" height="15" border="0" alt="" ';
				Xt_i += 'src="http://logv9.xiti.com/bcg.xiti?'+Xt_param;
				Xt_i += '&hl='+Xt_h.getHours()+'x'+Xt_h.getMinutes()+'x'+Xt_h.getSeconds();
				if(parseFloat(navigator.appVersion)>=4)
				{Xt_s=screen;Xt_i+='&r='+Xt_s.width+'x'+Xt_s.height+'x'+Xt_s.pixelDepth+'x'+Xt_s.colorDepth;}
				document.write(Xt_i+'&ref='+Xt_r.replace(/[<>"]/g, '').replace(/&/g, '$')+'" title="Internet Audience">');
				//-->
				</script>
				<noscript>
				Mesure d'audience ROI statistique webanalytics par <img width="39" height="25" src="http://logv9.xiti.com/hit.xiti?s=393972&p=tombola" alt="WebAnalytics">
				</noscript></a>
			
			<br>
			<?php include('php/include_partenaires.php'); ?>
		</p>
		
	</div>
	
</body>

</html>
<?php
else:
	header('Location : connexion.php');
endif;
endif;
?>