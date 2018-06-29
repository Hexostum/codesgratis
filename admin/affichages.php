<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);
/**/
include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if
	(
		is_admin($my_membre)
	)
:
					
	$membre_id = intval($_POST['membre_id']);
	$ce_membre = new fp_membre($membre_id);
	/**
	if($ce_membre->membre_existe()):
	**/
	/**			
	if
		(
			isset($_POST['membre']) && 
			isset($_POST['nb_points_sanction']) && 
			(
				($_POST['commandes_annulees'] == 'on') || 
				($_POST['Autosurf'] == 'on') || 
				($_POST['Picturing'] == 'on') || 
				($_POST['Autre'] == 'on')
			)
		)
	:
	
		$motif1 = '';
		$motif2 = '';
		$motif3 = '';
						
			mysql_query('UPDATE inscrits SET nb_points=\''. $_POST['nb_points_sanction'] .'\' WHERE pseudo=\''. $_POST['membre'] .'\'');
						
			$retour = mysql_query('SELECT COUNT(*) AS nb_commandes_annulees FROM gagnants WHERE gagnant=\''. $_POST['membre'] .'\' AND date_livraison=\'0\'');
						$donnees = mysql_fetch_array($retour);
						if($donnees['nb_commandes_annulees'] > 0 && $_POST['commandes_annulees'] == 'on')
						{
							mysql_query('DELETE FROM gagnants WHERE gagnant=\''. $_POST['membre'] .'\' AND date_livraison=\'0\'');
						}
						
						if($_POST['Autosurf'] == 'on')
						{
							$motif1 = '<br />Usage d\'autosurf(s)';
						}
						if($_POST['Picturing'] == 'on')
						{
							$motif2 = '<br />Picturing (mise en image du site sur une autre page : le script s\'ex�cute, mais la page n\'est pas affich�e)';
						}
						if($_POST['Autre'] == 'on' && isset($_POST['motif_autre']))
						{
							$motif3 = '<br />'. $_POST['motif_autre'];
						}
						
						if($_POST['envoi_mail'] == 'on')
						{
							/* Envoi du mail *
							
							$Name = "R�pression des fraudes de CodesGratis"; //senders name
							$email = "webmaster@codesgratis.fr"; //senders e-mail adress
							
							$retour2 = mysql_query('SELECT adresse FROM inscrits WHERE pseudo=\''. $_POST['membre'] .'\'');
							$donnees2 = mysql_fetch_array($retour2);
							
							$recipient = $donnees2['adresse']; //recipient
							if($_POST['commandes_annulees'] == 'on')
							{
								$mail_body = '<html>
												<head>
												</head>
												<body>
													<p>Bonjour '. $_POST['membre'] .',</p>
													<p>Ceci est un mail semi-automatique envoy� de la part du webmaster de CodesGratis.</p>
													<p>Vous venez d\'�tre sanctionn�(e) pour fraude.</p>
													<p>Le(s) motif(s) exact(s) :</p>
													<p>'. $motif1 . $motif2 . $motif3 .'</p>
													<p>Vos points sont remis � '. $_POST['nb_points_sanction'] .', et vos �ventuelles commandes annul�es.</p>
													<p>Aucune r�clamation n\'est possible, vous ne pouvez vous en prendre qu\'� vous-m�me.</p>
													<p>Cordialement,</p>
													<p>FLo, webmaster de CodesGratis.</p>
												</body>
											</html>'; //mail body
							}
							else
							{
								$mail_body = '<html>
												<head>
												</head>
												<body>
													<p>Bonjour '. $_POST['membre'] .',</p>
													<p>Ceci est un mail semi-automatique envoy� de la part du webmaster de CodesGratis.</p>
													<p>Vous venez d\'�tre sanctionn�(e) pour fraude.</p>
													<p>Le(s) motif(s) exact(s) :</p>
													<p>'. $motif1 . $motif2 . $motif3 .'</p>
													<p>Vos points sont remis � '. $_POST['nb_points_sanction'] .'.</p>
													<p>Aucune r�clamation n\'est possible, vous ne pouvez vous en prendre qu\'� vous-m�me.</p>
													<p>Cordialement,</p>
													<p>FLo, webmaster de CodesGratis.</p>
												</body>
											</html>'; //mail body
							}
							$subject = "CodesGratis : r�pression des fraudes ..."; //subject
							$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields
							// Pour envoyer un mail HTML, l'en-t�te Content-type doit �tre d�fini
						    $headers  = 'MIME-Version: 1.0' . "\r\n";
						    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						    // En-t�tes additionnels
						    $headers .= 'To: '. $_POST['membre'] .' <'. $recipient .'>' . "\r\n";
						    $headers .= 'From: R�pression des fraudes de CodesGratis <webmaster@codesgratis.fr>' . "\r\n";

							//ini_set('sendmail_from', 'cunchifan@hotmail.fr'); //Suggested by "Some Guy"

							mail($recipient, $subject, $mail_body, $headers); //mail command :)
						}
						else
						{
							echo '<p style="color:green">Mail non envoy�.</p>';
						}
						
						echo '<p style="color:green">Effectu� ('. $donnees['nb_commandes_annulees'] .' commandes annul�es)</p>';
					}
					
					if($_POST['effacer_membre'] == 'oui')
					{
						for($i = 1 ; $i <= 50 ; $i)
						{
							$retour = mysql_query('SELECT ip, referer FROM pages_reconnaissance_ip WHERE membre=\''. $_POST['membre'] .'\' AND verifie=\'0\' LIMIT 0,1');
							$donnees = mysql_fetch_array($retour);
							mysql_query('UPDATE pages_reconnaissance_ip SET verifie=\'1\' WHERE membre=\''. $_POST['membre'] .'\' AND verifie=\'0\' AND ip=\''. $donnees['ip'] .'\' AND referer=\''. $donnees['referer'] .'\'');
							$membre = $_POST['membre'];
						}
						echo '<p style="color:green">Occurrences retir�es de la liste</p>';
					}
					
					if($_POST['bannir_membre'] == 'oui')
					{
						mysql_query('INSERT INTO codesgratis_membres_bannis VALUES(\'\', \''. $_POST['membre'] .'\')');
						echo '<p style="color:green">Le membre '. $_POST['membre'] .' ne peut plus gagner de point 
						par affichage de sa page de promotion, � pr�sent.</p>';
					}
				}
**/	
					
?>
			
<h1>Contrôle des affichages de la page de promotion de <?php echo $ce_membre->membre_pseudo; ?> ces dernières 24 heures :</h1>
				
			<table>
				
				<tr>
					<th colspan="2">Sanction ?</th>
				</tr>
				
				<tr>
					<?php
					
						echo '<td><form method="post" action="admin_affichages.php?membre='. $membre .'">
							<input type="hidden" name="membre" value="'. $membre .'" />
							<input type="text" name="nb_points_sanction" value="'. $donnees2['nb_points'] .'" /> points.<br />
							<label for="commandes_annulees">Annuler commandes</label> : <input type="checkbox" name="commandes_annulees" /><br />
							Motif : <br />
							- <input type="checkbox" name="Autosurf" /> <label for="Autosurf">Autosurf</label><br />
							- <input type="checkbox" name="Picturing" /> <label for="Picturing">Picturing</label><br />
							- <input type="checkbox" name="Autre" /> <label for="Autre">Autre</label> <input type="text" name="motif_autre" /><br />
							<label for="envoi_mail">Envoi d\'un mail</label> : <input type="checkbox" name="envoi_mail" /><br />
							<input type="submit" value="OK" />
							</form></td>';
						echo '<td>
							<form method="post" action="admin_affichages.php?membre='. $membre .'">
							<input type="hidden" name="membre" value="'. $membre .'" />
							<input type="hidden" name="bannir_membre" value="oui" />
							<input type="submit" value="Emp�cher le gain de points" />
							</form></td>';
					?>
				</tr>
				
				<tr>
					<?php
						echo '<td colspan="2">
							<form method="post" action="admin_affichages.php">
							<input type="hidden" name="membre" value="'. $membre .'" />
							<input type="hidden" name="effacer_membre" value="oui" />
							<input type="submit" value="Retirer ces 50 occurrences de la liste (et voir les suivantes)" />
							</form></td>';
					?>
				</tr>
				
				<?php					
					
						
	$retour = mysql_query('SELECT * FROM codes_page_clics WHERE membre_id='. $membre_id .' AND clic_statut=0 LIMIT 0,50');
						
	if(mysql_num_rows($retour) > 0):
		while($donnees = mysql_fetch_array($retour)):
			echo '<tr>';
			echo '<td colspan="2"><a onclick="javascript:window.open(\''. $donnees['clic_referer'] .'\', \'popup_clics\', \'scrollbars=yes, width=900px, height:400px\');">'. $donnees['referer'] .'</a></td>';
			echo '</tr>';
		endwhile;
	else:
		echo '<tr>';
		echo '<td colspan="2">Plus d\'occurrence pour le membre '. $membre_id .'.</td>';
		echo '</tr>';
	endif;
					
endif;
?>