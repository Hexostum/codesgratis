<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	if(isset($_GET['membre_id'])):
		$ce_membre = new fp_membre(intval($_GET['membre_id']));
		if($ce_membre->statut()):
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th>membre N°'.$ce_membre->membre_id.'</th></tr>';
			$contenu_texte[] = '<tr><td>Pseudo</td><td>'.$ce_membre->membre_pseudo.'</td></tr>';
			$contenu_texte[] = '<tr><td>courriel</td><td>'.$ce_membre->membre_courriel.'</td></tr>';
			$contenu_texte[] = '<tr><td>Adresse</td><td>'.$ce_membre->membre_adresse.'</td></tr>';
			$contenu_texte[] = '<tr><td>parrain</td><td>'.$liste_pseudo[$ce_membre->membre_parrain_id].'</td></tr>';
			$contenu_texte[] = '<tr><td>Clan</td><td>'.$ce_membre->membre_clan_id.'</td></tr>';
			$contenu_texte[] = '<tr><td>VIP</td><td>'.$ce_membre->membre_vip.'</td></tr>';
			$contenu_texte[] = '<tr><td>points</td><td>'.$ce_membre->membre_points.'</td></tr>';
			$contenu_texte[] = '<tr><td>points plus</td><td>'.$ce_membre->membre_points_plus.'</td></tr>';
			$contenu_texte[] = '<tr><td>avatar</td><td>'.$ce_membre->membre_avatar.'</td></tr>';
			$contenu_texte[] = '<tr><td>signature</td><td>'.$ce_membre->membre_signature.'</td><td></td></tr>';
			$contenu_texte[] = '</table>';
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
		$retour = mysql_query('SELECT * FROM codesgratis_membres where membre_banni=0 ORDER BY membre_vip DESC LIMIT '. $infos['limit']);
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
		$contenu_texte[] = '<table>';
		while($sql_membre = mysql_fetch_array($retour,MYSQL_ASSOC)):
			$ce_membre = new fp_membre_sql($sql_membre);
			$contenu_texte[] = '<tr><td><a href="'.page_courante(array('membre_id'=>$ce_membre->membre_id)).'">'.$ce_membre->membre_pseudo.'</a></td><td>'.$ce_membre->membre_vip.'</td><td>'.$ce_membre->membre_courriel.'</td></tr>';
		endwhile;
		$contenu_texte[] = '</table>';
		$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	header('Location: ../index.php');
endif;
?>