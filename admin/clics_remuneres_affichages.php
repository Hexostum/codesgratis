<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

include(FP_CHEMIN_FONCTIONS . 'pagination' . '.php');
include(FP_CHEMIN_FONCTIONS . 'hasard_recapitulatif' . '.php');

if($my_membre->membre_pseudo=='finalserafin'):
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">

<head>
	<title>Exostum - CodesGratis - Administration</title>
	
	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="http://www.exostum.net/style.css">
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
		<div class="item_titre"><h1> Affichages des clics rémunérés par les membres</h1></div>
		<div class="item_contenu">
			<?php
			$retour = mysql_query('SELECT * FROM codesgratis_pubs_clics ORDER BY membre_id , pub_id ');
			
			$retour2 = mysql_query('SELECT * FROM codesgratis_pubs ');
			
			$clics_remuneres  = array();
			$clics_membres = array();
			while($clics_remunere = mysql_fetch_array($retour2,MYSQL_ASSOC)):
				$clics_remuneres[$clics_remunere['pub_id']] = $clics_remunere;
			endwhile;
			$i=0;
			while($clics_membre = mysql_fetch_array($retour,MYSQL_ASSOC)):
				$clics_membres[$clics_membre['membre_id']][] = $clics_membre;
			endwhile;
			foreach($clics_membres as $membre => $clics):
				echo "<table border=\"1\">" . "\r\n";
				echo "<tr>". "\r\n";
				echo "<th colspan=\"4\"> $membre</th>" . "\r\n";
				echo "</tr>". "\r\n";
				echo "<tr>". "\r\n";
				echo "<td> ID </td>". "\r\n";
				echo "<td> Acheteur </td>". "\r\n";
				echo "<td> URL </td>". "\r\n";
				echo "<td> Date </td>". "\r\n";
				echo "</tr>". "\r\n";
				foreach($clics as $clic):
					echo "<tr>". "\r\n";
					echo "<td> $clic[id_pub] </td>". "\r\n";
					echo "<td> ".$clics_remuneres[$clic['pub_id']]['membre_id']." </td>". "\r\n";
					echo "<td> ".$clics_remuneres[$clic['pub_id']]['pub_url']." </td>". "\r\n";
					echo '<td>' .  date('d/m/Y H:i:s',$clic['clic_date']) . '</td>'. "\r\n";
					echo "</tr>". "\r\n";
				endforeach;				
				echo "</table>". "\r\n";				
				echo "<br>";
			endforeach;
			
		?>
		</div>
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
else:
	header('Location : ../index.php');
endif;
?>