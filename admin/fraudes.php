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
	
				
	if
		(
			!isset ( $_GET['membre_id'] )
		)
	:
		$contenu_texte[] = '<div class="item_titre"><h1>Répression des fraudes : Liste des membres potentiellement fraudeurs</h1></div>';
		$res_fraudes = mysql_query('SELECT membre_id, count(fraude_referer) FROM codesgratis_fraudes WHERE fraude_statut=0 GROUP BY membre_id');
		
		$contenu_texte[] = '<table border="1">';
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<th>Pseudo</th><th>URLS</th>';
		$contenu_texte[] = '</tr>';
		while($sql_fraude = mysql_fetch_array($res_fraudes)):
			$contenu_texte[] =  '<tr>';
			$contenu_texte[] =  '<td><a href="'.FP_PAGE.'?membre_id='.$sql_fraude['membre_id'].'">'. $liste_pseudo[$sql_fraude['membre_id']] .'</a></td>';
			$contenu_texte[] =  '<td>'. $sql_fraude[1] .' </td>';
			$contenu_texte[] =  '</tr>';
		endwhile;
		$contenu_texte[] =  '</table>';
	else:
	
		$membre_id = intval($_GET['membre_id']);
		$ce_membre= new fp_membre($membre_id);
		
		if($ce_membre->membre_existe()):
		
			if
				(
					
					isset($_POST['submit_sanction']) 
				)
			:
				echo $ce_membre;
				print_r ($_POST);
				$motif1 = '';
				$motif2 = '';
				$motif3 = '';
				echo $ce_membre->membre_points;
				$ce_membre->membre_points = $_POST['membre_points'];
				echo $ce_membre->membre_points;
				
				$commande_annul = sql_result('SELECT COUNT(*) AS nb_commandes_annulees FROM codesgratis_commande WHERE membre_id='. $ce_membre->membre_id .' AND commande_livraison is null');
				echo mysql_error();
				if($commande_annul > 0 && $_POST['commandes_annulees'] == 'on'):
					mysql_query('DELETE FROM codesgratis_commande WHERE membre_id='. $ce_membre->membre_id  .' AND commande_livraison is null');
				endif;
				echo mysql_error();
						
				if($_POST['Autosurf'] == 'on'):
					$motif1 = '<br>Usage d\'autosurf(s)';
				endif;
			
				if($_POST['Picturing'] == 'on'):
					$motif2 = '<br>Picturing (mise en image du site sur une autre page : le script s\'exécute, mais la page n\'est pas affichée)';
				endif;
				
				if($_POST['Autre'] == 'on' && isset($_POST['motif_autre'])):
					$motif3 = '<br>'. $_POST['motif_autre'];
				endif;
						
				if($_POST['envoi_mail'] == 'on'):
				/**
					Envoi du mail */
							
					$Name = "Répression des fraudes de CodesGratis"; //senders name
					$email = "webmaster@codesgratis.fr"; //senders e-mail adress
					$recipient = $ce_membre->membre_courriel; //recipient
					if($_POST['commandes_annulees'] == 'on'):
						$mail_body = '<html>
									<head>
									</head>
										<body>
													<p>Bonjour '. $ce_membre->membre_pseudo .',</p>
													<p>Ceci est un mail semi-automatique envoyé de la part du webmaster de CodesGratis.</p>
													<p>Vous venez d\'être sanctionné(e) pour fraude.</p>
													<p>Le(s) motif(s) exact(s) :</p>
													<p>'. $motif1 . $motif2 . $motif3 .'</p>
													<p>Vos points sont remis à '. $_POST['membre_points'] .', et vos éventuelles commandes annulées.</p>
													<p>Cordialement,</p>
													<p>Le webmaster de CodesGratis.</p>
												</body>
											</html>'; //mail body
					
					else:
				
						$mail_body = '<html>
												<head>
												</head>
												<body>
													<p>Bonjour '. $ce_membre->membre_pseudo .',</p>
													<p>Ceci est un mail semi-automatique envoyé de la part du webmaster de CodesGratis.</p>
													<p>Vous venez d\'être sanctionné(e) pour fraude.</p>
													<p>Le(s) motif(s) exact(s) :</p>
													<p>'. $motif1 . $motif2 . $motif3 .'</p>
													<p>Vos points sont remis à '. $_POST['membre_points'] .'.</p>
													<p>Cordialement,</p>
													<p>Le webmaster de CodesGratis.</p>
												</body>
											</html>'; //mail body
					endif;
					
					$subject = "CodesGratis : répression des fraudes ..."; //subject
					$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields
							// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						    // En-têtes additionnels
					$headers .= 'To: '. $ce_membre->membre_pseudo .' <'. $recipient .'>' . "\r\n";
					$headers .= 'From: Webmaster Codesgratis <webmaster@codesgratis.fr>' . "\r\n";
					$headers .= 'Bcc: finalserafin@gmail.com' . "\r\n";


					mail($recipient, $subject, $mail_body, $headers); //mail command :)
				else:
					$contenu_texte[] =  '<p style="color:green">Mail non envoyé.</p>';
				endif;	
				$contenu_texte[] =  '<p style="color:green">Effectué ('. $commande_annul .' commandes annulées)</p>';
			endif;
		
					
			if
				(
					isset ( $_POST['bannir_membre'] ) 
				)
			:
				$ce_membre->membre_banni=1;
				$contenu_texte[] =  '<p style="color:green">Le membre '. $ce_membre->membre_pseudo .' ne peut plus gagner de point par affichage de sa page de promotion, à présent.</p>';
			endif;
	
			if
				(
					isset($_POST['submit_retirer'])
				)
				
			:
				if(isset($_POST['retirer_tous'])):
					$sql = 'UPDATE codesgratis_fraudes SET fraude_statut=1 WHERE membre_id='.$ce_membre->membre_id;
					echo $sql;
					mysql_query($sql);
				else:
					$list = array();
					foreach($_POST['retirer'] as $valeur):
						$list[] = $valeur;
					endforeach;
					$sql = 'UPDATE codesgratis_fraudes SET fraude_statut=1 WHERE fraude_referer IN (\''. implode('\',\'',$list) .'\') AND membre_id='.$ce_membre->membre_id;
					echo $sql;
					mysql_query($sql);
				endif;
			endif;
			$contenu_texte[] = '<div class="item_titre"><h1>Répression des fraudes : '. $ce_membre->membre_pseudo .'</h1></div>';
			
			$contenu_texte[] = '<div class="item_contenu">';
		
			$retour = mysql_query('SELECT fraude_referer, count(fraude_referer) as nb FROM codesgratis_fraudes WHERE membre_id='. $ce_membre->membre_id .' AND fraude_statut=0 group by fraude_referer');
			if(mysql_num_rows($retour) > 0):
				$contenu_texte[] =  '<form method="post" action="'.FP_PAGE.'?membre_id='.$ce_membre->membre_id.'">';
				$contenu_texte[] =  '<table border="1">';
				$contenu_texte[] =  '<tr>';
				$contenu_texte[] = 	'<th>URL</th><th>NB</th><th><input type="checkbox" name="retirer_tous" id="retirer_tous"></th>';
				$contenu_texte[] =  '</tr>';
				while($donnees = mysql_fetch_array($retour)):
					$contenu_texte[] =  '<tr>';	
					$contenu_texte[] =  '<td>'.
					'<a onclick="javascript:window.open(\''. $donnees['fraude_referer'] .'\', \'popup_clics\', \'scrollbars=yes, width=900px, height:400px\');return false" href="'. $donnees['fraude_referer'] .'">'. $donnees['fraude_referer'] .'</a></td>';
					$contenu_texte[] = '<td>'.$donnees['nb'].'</td>';
					$contenu_texte[] = '<td><input type="checkbox" name="retirer[]" id="retirer[]" value="'.$donnees['fraude_referer'].'"></td>';
					$contenu_texte[] = '</tr>';
				endwhile;
				$contenu_texte[] = '<tr><td colspan="3"><input type="submit" name="submit_retirer" id="submit_retirer" value="retirer"></td></tr>';
				$contenu_texte[] =  '</table>';
				$contenu_texte[] =  '</form>';
				/**/
				$contenu_texte[] = '</div>';
				$contenu_texte[] = '</div>';
				
				$contenu_texte[] = '<div class="item">';
				$contenu_texte[] = '<div class="item_titre"><h1>Sanction</h1></div>';
				$contenu_texte[] = '<div class="item_contenu">';
				// Commencer la gestion des points
				$contenu_texte[] =  '<form method="post" action="'.FP_PAGE.'?membre_id='.$ce_membre->membre_id.'">';
				// Modification des points
				$contenu_texte[] = '<input type="text" name="membre_points" id="membre_points" value="'. $ce_membre->membre_points .'"> points.<br>';
				$contenu_texte[] = '<label for="commandes_annulees">Annuler commandes</label> : <input type="checkbox" name="commandes_annulees"><br>';
				$contenu_texte[] = 'Motif : <br>
											- <input type="checkbox" name="Autosurf"> <label for="Autosurf">Autosurf</label><br />
											- <input type="checkbox" name="Picturing"> <label for="Picturing">Picturing</label><br />
											- <input type="checkbox" name="Autre"> <label for="Autre">Autre</label> <input type="text" name="motif_autre" /><br />
											<label for="envoi_mail">Envoi d\'un mail</label> : <input type="checkbox" name="envoi_mail" /><br />
											<label for="envoi_mail">Empêcher le gain de points</label> : <input type="checkbox" name="bannir" /><br />
											<input type="submit" value="OK" name="submit_sanction" id="submit_sanction">';
				$contenu_texte[] = '</div>';
				$contenu_texte[] = '</div>';
				/**/
			else:
				$contenu_texte[] =  '<p>Aucune occurrence pour le membre '. $ce_membre->membre_pseudo .'.</p>';
			endif;
			$contenu_texte[] = '<p><a href="'.FP_PAGE.'">Retour à la liste des fraudes</a></p>';
			$contenu_texte[] = '</div>';
		else:
			// Le membre n'existe pas
		endif;
	endif;
else:
	
endif;
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/link_popup.js"></script>';
include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
?>