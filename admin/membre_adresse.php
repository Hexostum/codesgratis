<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel.php');
if(is_admin($my_membre)):
	if(isset($_GET['membre_id'])):
		$ce_membre = new fp_membre(intval($_GET['membre_id']));
		if($ce_membre->statut()):
			if(isset($_GET['mode'])):
				if($_GET['mode']=='adresse_supprimer'):
					$ce_membre->membre_adresse_code = null;
					$ce_membre->membre_adresse_ok = 0;
					$ce_membre->membre_adresse = null;
					envoyer_message
					(
						0,
						$ce_membre->membre_id,
						'[ADRESSE POSTALE] Message automatique',
						'Ceci est un message automatique : Votre adresse postale a été supprimée parce qu\'elle était mal formée' . FP_LIGNE .
						'Rappel : Une adresse postale contient  ' . FP_LIGNE .
						' - Nom et prénom  ' . FP_LIGNE .
						' - numéro et nom de la rue (et éventuellement des compléments)  ' . FP_LIGNE .
						' - Code postale et Ville ' . FP_LIGNE .
						' - Pays (dans le cas où vous résidez en dehors de la France)'
					);
				endif;
			endif;
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th>membre N°'.$ce_membre->membre_id.'</th></tr>';
			$contenu_texte[] = '<tr><td>Pseudo</td><td>'.$ce_membre->membre_pseudo.'</td></tr>';
			$contenu_texte[] = '<tr><td>courriel</td><td>'.$ce_membre->membre_courriel.'</td></tr>';
			$contenu_texte[] = '<tr><td>Adresse</td><td>'.nl2br(stripslashes($ce_membre->membre_adresse)).'</td></tr>';
			$contenu_texte[] = '<tr><td>Adresse Code </td><td>'.$ce_membre->membre_adresse_code.'</td></tr>';
			$contenu_texte[] = '<tr><td>Adresse OK </td><td>'.$ce_membre->membre_adresse_ok.'</td></tr>';
			$contenu_texte[] = '<tr><td>parrain</td><td>'.$liste_pseudo[$ce_membre->membre_parrain_id].'</td></tr>';
			$contenu_texte[] = '<tr><td>Clan</td><td>'.$ce_membre->membre_clan_id.'</td></tr>';
			$contenu_texte[] = '<tr><td>VIP</td><td>'.$ce_membre->membre_vip.'</td></tr>';
			$contenu_texte[] = '<tr><td>points</td><td>'.$ce_membre->membre_points.'</td></tr>';
			$contenu_texte[] = '<tr><td>points plus</td><td>'.$ce_membre->membre_points_plus.'</td></tr>';
			$contenu_texte[] = '<tr><td>avatar</td><td>'.$ce_membre->membre_avatar.'</td></tr>';
			$contenu_texte[] = '<tr><td>signature</td><td>'.$ce_membre->membre_signature.'</td><td></td></tr>';
			$contenu_texte[] = '</table>';
			if($ce_membre->membre_adresse_ok==0):
				$contenu_texte[] = '<a href="'.page_courante(array('mode'=>'adresse_supprimer')).'">Supprimer Adresse</a>';
			endif;
		endif;
	else:
		$infos = sql_limiteur
		(
			array
			(
				'unit_par_page'=>20,
				'table'=>'codesgratis_membres',
				'table_compteur'=>'membre_id'
			)
		);
		$retour = mysql_query('SELECT * FROM codesgratis_membres where membre_adresse <> \'\' ORDER BY membre_adresse_ok DESC, membre_vip DESC LIMIT '. $infos['limit']);
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr><th>VIP</th><th>Adresse</th><th>Pseudo</th></tr>';
		while($sql_membre = mysql_fetch_array($retour,MYSQL_ASSOC)):
			$ce_membre = new fp_membre_sql($sql_membre);
			$contenu_texte[] = '<tr>';
			$contenu_texte[] = '<td>' . $ce_membre->membre_vip . '</td>';
			$contenu_texte[] = '<td>' . $ce_membre->membre_adresse_ok . '</td>';
			$contenu_texte[] = '<td><a href="'.page_courante(array('membre_id'=>$ce_membre->membre_id),true).'">'.$ce_membre->membre_pseudo.'</a></td>';
			$contenu_texte[] = '</tr>';
		endwhile;
		$contenu_texte[] = '</table>';
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	header('Location: ../index.php');
endif;
?>