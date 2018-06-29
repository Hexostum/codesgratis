<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'date.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie.php');

if($my_membre->membre_existe()):
	if(isset($_GET['commande_id'])):
		$commande_id = intval($_GET['commande_id']);
		$sql_commande = new fp_enregistrement('codesgratis_commande',$commande_id,'commande_id');
		if($sql_commande->statut()):
			if($sql_commande->membre_id==$my_membre->membre_id):
				if($sql_commande->commande_livraison==null):
					$message_titre = '';
					$contenu_texte[] = 'Cette commande n\'a pas encore été livrée';
				else:
					$type_code = new fp_enregistrement('codesgratis_codes_designation' , $sql_commande->code_id  ,'code_id');
					$contenu_texte[] = '<div class="item_titre">Commande Numéro : <strong> ' . $sql_commande->commande_id . '</strong></a></div>';
					$contenu_texte[] = '<div class="item_contenu">';
		
	
					$contenu_texte[] = '<p>Date commande <strong> : ' . format_date($sql_commande->commande_date) . '</strong></p>';
					$contenu_texte[] = '<p>Date livraison <strong> : ' . format_date($sql_commande->commande_livraison) . '</strong></p>';
				
					$contenu_texte[] = '<p>Type de code <strong> : ' . $type_code->code_designation . '</strong></p>';
					$contenu_texte[] = '<p>Utilisable sur <strong> : ' . $type_code->code_site . '</strong></p>';
					$contenu_texte[] = '<p>Code commandés <strong> : ' .$sql_commande->code_qte . '</strong></p>';
	
					$code_delivres = sql_result('SELECT count(code_id) FROM codesgratis_codes WHERE commande_id=' . $sql_commande->commande_id);
					
					if($code_delivres > 0):
						$contenu_texte[] = '<p>Code délivrés<strong> : ' .$code_delivres . '</strong></p>';
					// Générer la liste des codes
						$contenu_texte[] = '<table border="1">';
						// On génére la liste de codes lié à cette commande
		
						$sql = 'SELECT code_obtenu , code_texte from codesgratis_codes where commande_id='.$sql_commande->commande_id;
						$res_codes = mysql_query($sql);
						echo mysql_error();
						while($sql_code = mysql_fetch_array($res_codes)):
							$contenu_texte[] = '<tr>';
							$contenu_texte[] = '<td>'.$sql_code['code_texte'].'</td>';
							$contenu_texte[] = '<td>'.format_date($sql_code['code_obtenu']).'</td>';
							$contenu_texte[] = '</tr>';
						endwhile;
						$contenu_texte[] = '</table>';
						$contenu_texte[] = '</div>';
					else:
						$contenu_texte[] = 'Les codes d\'avant le changement de proprietaire sont en cours de transfert, rassurez-vous ils ne sont pas perdus. En attendant que le transfert soit effectués, voici les anciens messages qui géraient les codes';
						
						$contenu_texte[] = '<table border="1">';
						$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie WHERE message_to_id='. $my_membre->membre_id .' and message_code=1 ORDER BY message_id DESC');
						echo mysql_error();
						while($donnees = mysql_fetch_array($res_messages)):
							afficher_resume($contenu_texte,$donnees);
						endwhile;
						$contenu_texte[] = '</table>';
						
						$message = new fp_enregistrement('codesgratis_messagerie',intval($_GET['message_id']),'message_id');
						
						if($message->statut()):	
							$contenu_texte = array_merge($contenu_texte,afficher_message($my_membre,$message));
						endif;
						
					endif;
				endif;
			else:
				header('Location: compte_commandes.php');
			endif;
		else:
			$contenu_texte[] = 'Cette commande n\'existe pas.';
		endif;
	else:
		$message_titre = 'Vos commandes effectuées sur CodesGratis';
		$contenu_texte[] = 
<<<eod
<h1>Vos commandes effectuées sur CodesGratis</h1>
					
<p>Le tableau suivant liste vos commandes effectuées sur CodesGratis. Encore félicitations à vous !</p>

<table>
	<tr>
		<th>#</th>
		<th>Code</th>
		<th>Coût</th>
		<th>Nombre de codes</th>
		<th>Date de commande</th>
		<th>Date de livraison</th>
	</tr>
eod;

		$retour = mysql_query('SELECT * FROM codesgratis_commande WHERE membre_id='. $my_membre->membre_id .' ORDER BY commande_id DESC');
		while($donnees = mysql_fetch_array($retour)):
		
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<td><a href="' . page_courante(array('commande_id' => $donnees['commande_id'] ))  . '">' . $donnees['commande_id'] . '</a></td>';
			$contenu_texte[] = '<td>' . $donnees['code_id'] . '</td>';
			$contenu_texte[] = '<td>' . $donnees['code_cout'] . '</td>';
			$contenu_texte[] = '<td>' . $donnees['code_qte'] . '</td>';
			
			$contenu_texte[] = '<td>Le ' . date('d/m/Y', $donnees['commande_date']) .' à '. date('H\hi', $donnees['commande_date']) . '</td>';
			if($donnees['commande_livraison'] != 0):
				$contenu_texte[] = '<td>Le '. date('d/m/Y', $donnees['commande_livraison']) .' à '. date('H\hi', $donnees['commande_livraison']) . '</td>';
			else:
				$contenu_texte[] = '<td>Pas encore livré.</td>';

			endif;
			echo '</tr>';
		endwhile;
		$contenu_texte[] = '</table>';
	endif;
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>