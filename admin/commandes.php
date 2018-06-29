<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);
/**/
include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'date' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');



if(is_admin($my_membre)):

if
	(
		!isset( $_GET['commande_id'] )
	)
:
	$contenu_texte[] = '<div class="item_titre"><h1>Les commandes sur CodesGratis</h1></div>';
	
	if(isset($_POST['submit_retirer'])):
		$sql = 'DELETE FROM codesgratis_commande WHERE commande_id IN ( '. implode (' , ' , $_POST['supprimer']) .' )';
		mysql_query($sql);
		echo mysql_affected_rows();
	endif;

	if(isset($_GET['membre_id'])):
		$infos = sql_limiteur
		(
			array
			(
				'unit_par_page'=>50,
				'table'=>'codesgratis_commande',
				'table_compteur'=>'commande_id',
				'where_condition' => array(0=>array('valeur_type'=>'nombre','condition' => '=' , 'champ'=>'membre_id','valeur' => intval($_GET['membre_id']) ))
			)
		);
		$sql = 'SELECT * FROM codesgratis_commande WHERE membre_id = '.intval($_GET['membre_id']).' LIMIT ' . $infos['limit'];
	else:
		$order = isset($_GET['order']) ? $_GET['order'] : 'commande_id';
		$infos = sql_limiteur
		(
			array
			(
				'unit_par_page'=>50,
				'table'=>'codesgratis_commande',
				'table_compteur'=>'commande_id'
			)
		);
		
		$limit = $infos['limit'];
		$sql = 'SELECT * FROM codesgratis_commande ORDER BY commande_livraison ASC , '.$order.' DESC  LIMIT ' . $limit;
		
	endif;
	$str_pagination=$infos['pagination'];
	
	
	$res_commande = mysql_query($sql);
	
	$contenu_texte = array_merge($str_pagination,$contenu_texte);
	parse_str($_SERVER['QUERY_STRING'],$params);
	
	
	$contenu_texte[] = '<table border="1">';
	$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th></th>';
	$params['order'] = 'commande_id';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">ID</a></th>';
	$params['order'] = 'membre_id';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">MEMBRE</a></th>';
	/**/
	$params['order'] = 'commande_cout';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">cout</a></th>';
	/**/
	$params['order'] = 'code_id';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">CODE ID</a></th>';
	$params['order'] = 'code_qte';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">CODE QTE</a></th>';
	$params['order'] = 'commande_livraison';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">LIVRAISON</a></th>';
	$params['order'] = 'commande_date';
	$contenu_texte[] = '<th><a href="'.FP_PAGE.'?'.http_build_query($params).'">DATE</a></th>';
	$contenu_texte[] = '</tr>';

	while($sql_commande = mysql_fetch_array($res_commande,MYSQL_ASSOC)):
		$cette_commande = new fp_enregistrement_sql($sql_commande,'codesgratis_commande','commande_id');
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td><input type="checkbox" id="supprimer[]" name="supprimer[]" value="'.$cette_commande->commande_id.'"></td>';
		$contenu_texte[] = '<td><a href="'. FP_PAGE. '?commande_id=' . $cette_commande->commande_id . '">' . $cette_commande->commande_id . '</a></td>';
		$contenu_texte[] = '<td><a href="'. FP_PAGE. '?membre_id=' . $cette_commande->membre_id . '">'.$cette_commande->membre_id.'</a></td>';
		/**/
		$contenu_texte[] = '<td>' . $cette_commande->code_cout . '</td>';
		/**/
		$contenu_texte[] = '<td>' . $cette_commande->code_id . '</td>';
		$contenu_texte[] = '<td>' . $cette_commande->code_qte . '</td>';
		$contenu_texte[] = '<td>' . format_date($cette_commande->commande_livraison) . '</td>';
		$contenu_texte[] = '<td>' . format_date($cette_commande->commande_date) . '</td>';
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '<tr><td colspan="8"><input type="submit" name="submit_retirer" id="submit_retirer"></td></tr>';
	$contenu_texte[] = '</form>';
	$contenu_texte[] = '</table>';
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
else:
	
	$commande_id = intval($_GET['commande_id']);
	$cette_commande = new fp_enregistrement('codesgratis_commande',$commande_id,'commande_id');
	if($cette_commande->statut()):
		if
			(
				isset( $_POST['submit_qte'] )
			)
		:
		
			$cette_commande->code_qte = intval($_POST['qte_commande']);
		endif;	
	
		if
			(
				isset( $_POST['submit_annuler'] )
			)
		:
			$cette_commande->delete();
		endif;
		
		
		
		$type_code = new fp_enregistrement('codesgratis_codes_designation' , $cette_commande->code_id  ,'code_id');
		$commande_membre = new fp_membre($cette_commande->membre_id);
		
		if
			(
				isset( $_POST['submit_rembourser'] )
			)
		:
			$code_cout = $cette_commande->code_cout;
			$code_qte = $cette_commande->code_qte;
			$a_rembourser = $code_cout * $code_qte;
			
			if(gestion_points($commande_membre , time() , null  , $a_rembourser, FP_TYPE_COMMANDE_R, $commande_id , $commande_membre->membre_id , 'NULL' , false)):
				$cette_commande->delete();
			endif;
			
		endif;
		
		if
			(
				isset( $_POST['submit_code'] )
			)
		:
			// OK on submit un code pour la commande
			// On vérifie d'abord que le code n'est pas déjà dans la base de données
			
			$code = $_POST['code'];
			$liste_code = explode("\r\n",$code);
			function ajouter_code($code,$cette_commande,$commande_membre,$type_code)
			{
				$code = trim($code);
				$code_test = new fp_enregistrement('codesgratis_codes',"'".$code."'",'code_texte');
				if(!$code_test->statut()):
					$sql = 'INSERT INTO codesgratis_codes VALUES ( NULL , \''.$code.'\' , '.$type_code->code_id.' , '.$commande_membre->membre_id.' , '.time().' , NULL , '.$cette_commande->commande_id.'   );';
					if(!mysql_query($sql)):
						echo $sql;
						echo mysql_error();
					endif;
				else:
					if($code_test->commande_id==null):
						$code_test->commande_id=$cette_commande->commande_id;
						$code_test->code_obtenu=$cette_commande->commande_livraison;
					endif;
				endif;
			}
			foreach($liste_code as $code):
				ajouter_code($code,$cette_commande,$commande_membre,$type_code);
			endforeach;
		endif;
		
		if
			(
				isset($_GET['actualiser_date'])
			)
		:
			$message_id = intval($_GET['message_id']);
			$message = new fp_enregistrement('codesgratis_messagerie',$message_id,'message_id');
			if($message->statut()):
				$cette_commande->commande_livraison=$message->message_date;
				$sql = 'update codesgratis_codes set code_obtenu='.$cette_commande->commande_livraison.' WHERE commande_id='.$cette_commande->commande_id;
				mysql_query( $sql);
			endif;
		endif;
		
		
		
		$contenu_texte[] = '<div class="item_titre">Commande Numéro : <strong> ' . $cette_commande->commande_id . '</strong></a></div>';
		$contenu_texte[] = '<div class="item_contenu">';
		$contenu_texte[] = '<p>Membre : <strong>' . $commande_membre->membre_pseudo . '('.$cette_commande->membre_id.')</strong> <a href="fraudes.php?membre_id='.$commande_membre->membre_id.'">fraudes</a> <a href="affichages.php?membre_id='.$commande_membre->membre_id.'">tous les affichages</a></p>';
		$contenu_texte[] = '<p>Points du Membre : <strong>' . $commande_membre->membre_points . '</strong>';
	
		$contenu_texte[] = '<p>Date commande <strong> : ' . format_date($cette_commande->commande_date) . '</strong></p>';
		$contenu_texte[] = '<p>Date livraison <strong> : ' . format_date($cette_commande->commande_livraison) . '</strong></p>';
		$contenu_texte[] = '<p>Type de code <strong> : ' . $type_code->code_id . '</strong></p>';	
		$contenu_texte[] = '<p>Type de code <strong> : ' . $type_code->code_designation . '</strong></p>';
		$contenu_texte[] = '<p>Type de code <strong> : ' . $type_code->code_site . '</strong></p>';
		$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
		$contenu_texte[] = '<p>Code commandés <strong> : ' .$cette_commande->code_qte . '</strong> <input type="text" name="qte_commande" id="qte_commande" value="'.$cette_commande->code_qte.'"></p>';
		$contenu_texte[] = '<input type="submit" name="submit_qte" id="submit_qte"></form>';
		$code_delivres = sql_result('SELECT count(code_id) FROM codesgratis_codes WHERE commande_id=' . $cette_commande->commande_id);
		$contenu_texte[] = '<p>Code délivrés<strong> : ' .$code_delivres . '</strong></p>';
	
		if($code_delivres > 0):
	
		// Générer la liste des codes
			$contenu_texte[] = '<table border="1">';
		// On génére la liste de codes lié à cette commande
		
			$sql = 'SELECT code_obtenu , code_texte from codesgratis_codes where commande_id='.$cette_commande->commande_id;
			$res_codes = mysql_query($sql);
			echo mysql_error();
			while($sql_code = mysql_fetch_array($res_codes)):
				$contenu_texte[] = '<tr>';
				$contenu_texte[] = '<td>'.$sql_code['code_texte'].'</td>';
				$contenu_texte[] = '<td>'.format_date($sql_code['code_obtenu']).'</td>';
				$contenu_texte[] = '</tr>';
			endwhile;
			$contenu_texte[] = '</table>';
		endif;
		if($code_delivres < $cette_commande->code_qte):
		// Ok on rajoute le formulaire de saise de code
			$contenu_texte[] = '<form action="'. page_courante().'" method="post">';
			$contenu_texte[] = '<p><textarea name="code" id="code">'.$type_code->code_designation.'</textarea></p>';
			$contenu_texte[] = '<p><input type="submit" name="submit_code" id="submit_code" value="envoyer le code"></p>';
			if($code_delivres==0):
				$contenu_texte[] = '<p><input type="submit" name="submit_rembourser" id="submit_rembourser" value="Rembourser la commande"></p>';
				$contenu_texte[] = '<p><input type="submit" name="submit_annuler" id="submit_annuler" value="Annuler la commande"></p>';
			endif;
			$contenu_texte[] = '</form>';
		endif;
		
		//afficher les codes de la commande
			
			$message = new fp_enregistrement('codesgratis_messagerie',intval($_GET['message_id']),'message_id');
			if($message->statut()):
				if(!isset($_GET['supprimer'])):
					$contenu_texte = array_merge($contenu_texte,afficher_message($my_membre,$message));
				else:
					$message->delete();	
				endif;
			endif;
			
			
			$contenu_texte[] = '<table border="1">';
			$res_messages = mysql_query('SELECT * FROM codesgratis_messagerie WHERE message_to_id='. $commande_membre->membre_id .' and message_code=1 ORDER BY message_id DESC');
			echo mysql_error();
			while($donnees = mysql_fetch_array($res_messages)):
				afficher_resume_admin($contenu_texte,$donnees);
			endwhile;
			$contenu_texte[] = '</table>';
			
		
		if($code_delivres==$cette_commande->code_qte):
			if(isset($_GET['actualiser'])):
				$cette_commande->commande_livraison=time();
				$recipient = $ce_membre->membre_courriel . ',finalserafin@gmail.com'; //recipient
				$subject = "CodesGratis : Livraison commande"; //subject
				$headers = '';
				/**/
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				/**/
				$headers .= 'From: Webmaster Codesgratis <webmaster@codesgratis.fr>' . "\r\n";
				$headers .= 'Bcc: finalserafin@gmail.com' . "\r\n";
				$mail_body = '<html>
												<head>
													<base href="http://www.codesgratis.fr/">
													<title>EXOSTUM - CODESGRATIS</title>
	<link type="text/css" media="screen" rel="stylesheet" title="Design" href="html/style/design3.css">
	<link rel="icon" type="image/png" href="html/images/favicon_codesgratis.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
												</head>
												<body>
													<p>Bonjour '. $ce_membre->membre_pseudo .',</p>
													<p>Ceci est un mail semi-automatique envoyé de la part du webmaster de CodesGratis.</p>
													<p>Votre <a href="http://www.codesgratis.fr/compte_commandes.php?commande_id='.$cette_commande->commande_id.'">commande N° '.$cette_commande->commande_id.'</a> a été livrée.</p>
													<p>Cordialement,</p>
													<p>Le webmaster de CodesGratis.</p>
												</body>
											</html>'; //mail body
											
				mail($commande_membre->membre_courriel,$subject,$mail_body,$headers);
			endif;
			$contenu_texte[] = '<br><a href="'.FP_PAGE.'?commande_id='.$cette_commande->commande_id.'&amp;actualiser">Livrer cette commande.</a>';
		else:
			//$cette_commande->commande_livraison=null;
		endif;
		$contenu_texte[] = '<p><a href="'. page_courante (array('actualiser_date' => true)) .'">Actualiser cette ancienne commande</a></p>';
		$contenu_texte[] = '<p><a href="'.FP_PAGE.'">Retour aux commandes</a></p>';
		$contenu_texte[] = '</div>';
	else:
		$contenu_texte[] = '<p><a href="'.FP_PAGE.'">Retour aux commandes</a></p>';
	endif;
endif;
include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:

endif;
?>