<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'commande' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'points.php');
include_once(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');

if($my_membre->membre_existe()):

	$points = $my_membre->membre_points;
	/**
	if((isset($_GET['code_id'])) && !(isset($_POST['submit_commande']))):
	
		$code_id = intval($_GET['code_id']);
		$sql_code = new fp_enregistrement('codesgratis_codes_designation',$code_id,'code_id');
		if($sql_code->statut()):
			$cout = $sql_code->code_cout;
			$qte = ceil($points / $cout );
			if($qte>30): 
				$qte = 30;
			endif;
			$page_titre .= ' - Commande de '.$sql_code->code_designation.'.';
			$contenu_texte[] =  '<h1>Commande de '.$sql_code->code_designation.' .</h1>';
			$contenu_texte[] =  form_confirm($sql_code,$cout,$qte);
			$contenu_texte[] =  message( 'Vous avez eu un changement d\'avis ? Vous pouvez <a href="commande.php">retourner à la page des commandes des codes</a>.' , FP_MESSAGE_QUESTION);
		else:
			$page_titre .= '- Commande de codes - Code inexistant.';
			$contenu_texte[] = '<h1>Informations ! </h1>';
			$contenu_texte[] = message ('Ce code n\'existe pas. <a href="commande.php">Retourner à la page des commandes des codes</a>.' , FP_MESSAGE_ERROR);
		endif;
	endif;
	
	if(isset($_POST['submit_commande'])):
		if(isset($_POST['confirm_commande'])):
		
			$code_id = intval($_GET['code_id']);
			$sql_code = new fp_enregistrement('codesgratis_codes_designation',$code_id,'code_id');
			if($sql_code->statut()):
				$cout = $sql_code->code_cout;	
				$statut_points_plus = isset($_POST['commande_points_plus']);
				
				if($statut_points_plus):
					$points = ($my_membre->membre_points_plus * 2) ;
					
					$qte_max = ceil($points / $cout);
					if($qte_max>30): 
						$qte_max = 30;
					endif;
				
					$qte = intval($_POST['codes_qte']);
					if($qte>$qte_max):
						$qte=$qte_max;
					endif;
					$cout_total = (ceil( $qte * $cout ));
					
				else:
					$qte_max = ceil($points / $cout);
					if($qte_max>30): 
						$qte_max = 30;
					endif;
				
					$qte = intval($_POST['codes_qte']);
					if($qte>$qte_max):
						$qte=$qte_max;
					endif;
					$cout_total = (ceil( $qte * $cout ));
				endif;
								
				if($points > $cout_total):
					$sql = sql_insert
						(
							'codesgratis_commande',
							array
							(
								'commande_id' => 'NULL',
								'commande_date' => 'UNIX_TIMESTAMP()',
								'commande_livraison' => 'NULL',
								'membre_id'=> $my_membre->membre_id,
								'code_id' => $sql_code->code_id,
								'code_cout' => $cout,
								'code_qte' => $qte,
							)
						)
					;
					if(mysql_query($sql)):
						$commande_id = mysql_insert_id();
						
						$commande_statut = false;
						if($statut_points_plus):
							$commande_statut = gestion_points($my_membre , time() , $qte . ' '.$sql_code->code_designation , -($cout_total/2), FP_TYPE_COMMANDE_PLUS, $commande_id , $my_membre->membre_id , 'NULL' , true);
						else:
							$commande_statut = gestion_points($my_membre , time() , $qte . ' '.$sql_code->code_designation , -$cout_total, FP_TYPE_COMMANDE, $commande_id , $my_membre->membre_id , 'NULL' , false);
						endif;
						if
							(
								$commande_statut				
							)
						:					
							$page_titre = "Commande N° $commande_id de $qte $sql_code->code_designation effectuée";				
							$contenu_texte[] = "<h1>Commande N° $commande_id de $qte $sql_code->code_designation effectuée</h1>";
							$contenu_texte[] = message ("Votre commande N° $commande_id de $qte $sql_code->code_designation sera traitée dans un délai d'un mois. Dépassé ce délai, votre commande sera annulé et vos points restiués. " , FP_MESSAGE_INFOS);
							$contenu_texte[] = message ('Vous faites maintenant partie de nos <a href="gagnants.php" title="Qui a gagné quoi ?">heureux gagnants</a> !' , FP_MESSAGE_INFOS);
							$contenu_texte[] = message ("Bonne continuation sur CodesGratis ! Nous vous souhaitons de nombreux gains !", FP_MESSAGE_INFOS);
						else:
							mysql_query('DELETE FROM codesgratis_commande WHERE commande_id='.$commande_id);
							$page_titre = 'Erreur SQL !';
							$contenu_texte[] = '<h1>Erreur SQL !</h1>';
							$contenu_texte[] = message ('Une erreur sql est survenue, merci de contacter le webmaster avec ce message ['.mysql_error().']' , FP_MESSAGE_ERROR);
						endif;
					else:
						$page_titre = 'Erreur SQL !';
						$contenu_texte[] = '<h1>Erreur SQL !</h1>';
						$contenu_texte[] = messaqge ('Une erreur sql est survenue, merci de contacter le webmaster avec ce message ['.mysql_error().']' , FP_MESSAGE_ERROR);
					endif;
				else:
					$contenu_texte[] = message ('Vos points sont insufissants.' , FP_MESSAGE_ERROR);
				endif;
			else:
				$page_titre = 'Commande de codes - Code inexistant.';
				$contenu_texte[] = '<h1>Informations !</h1>';
				$contenu_texte[] = '<p>Ce code n\'existe pas. <a href="commande.php" title="Echangez vos points contre le(s) code(s) de votre choix !">Retourner à la page des commandes des codes</a>.</p>';
			endif;
		else:
			$page_titre = 'Commande de codes - Confirmation demandé.';
			$contenu_texte[] = '<h1>Informations !</h1>';
			$contenu_texte[] = message ('Pensez à cochez la case de confirmation lorsque vous passez une commande. <a href="commande.php" title="Echangez vos points contre le(s) code(s) de votre choix !">Retourner à la page des commandes des codes</a>.' , FP_MESSAGE_INFOS);
		endif;		
	endif;
	/**
	if(!(isset($_GET['code_id']))):
	/**/
		$page_titre .= 'Commande de codes.';		
		
		$contenu_texte[] = message ('La commande de code est désactivé jusqu\'à la mise en place de la nouvelle version de codesgratis prévue fin décembre 2011',FP_MESSAGE_INFOS);
		/**
		$contenu_texte[] = '<h1>Utilisez vos points : commandez vos codes sur CodesGratis !</h1>';
		$contenu_texte[] = message ('Bonjour, <strong>'. $my_membre->membre_pseudo .'</strong> !' , FP_MESSAGE_INFOS);
		$contenu_texte[] = message ('Vous avez <strong>'. $points .'</strong> points.' , FP_MESSAGE_INFOS);
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<th colspan="4">Commandes de codes</th>';
		$contenu_texte[] = '</tr>';
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<th>Action</th>';
		$contenu_texte[] = '<th>Code</th>';
		$contenu_texte[] = '<th>Valide sur le site :</th>';
		$contenu_texte[] = '<th>Coût en points</th>';
		$contenu_texte[] = '</tr>';
		
		$codes_res = mysql_query('SELECT * FROM codesgratis_codes_designation where code_actif=1');
		$codes = array();
		while($sql_code = mysql_fetch_array($codes_res,MYSQL_ASSOC)):
			$codes[] = $sql_code;
		endwhile;
		foreach($codes as $code):
			if( $code['code_cout'] <= $points):
				$contenu_texte[] =  '<tr>';
				$contenu_texte[] =  '<td><a href="commande.php?code_id=' .$code['code_id']. '">Commander</a></td>';
				$contenu_texte[] =  '<td>'.$code['code_designation'].'</td>';
				$contenu_texte[] =  '<td><a href="http://www.'. $code['code_site'] .'">' . $code['code_site'] . '</a></td>';
				$contenu_texte[] =  '<td>' . $code['code_cout'] . '</td>';
				$contenu_texte[] =  '</tr>';
			endif;
		endforeach;
		$contenu_texte[] =  '</table>';
	/**
	endif;
	/**/
	afficher_historique($contenu_texte,$my_membre->membre_id,true, array(FP_TYPE_COMMANDE , FP_TYPE_COMMANDE_PLUS));
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');	
else:
	header('Location: connexion.php');
endif;
?>