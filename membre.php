<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

require_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if(isset($_GET['_membre_id'])):

	$membre_id = intval($_GET['_membre_id']);
	$ce_membre = new fp_membre($membre_id);
	if($ce_membre->statut()):
		$page_titre .= ' - Profil de ' . $ce_membre->membre_pseudo;
		$sql = 'select sum(code_qte) as qte , code_id from codesgratis_commande where membre_id='.$ce_membre->membre_id .' GROUP BY code_id';
		$res_codes = mysql_query($sql);
		$codes = array();
		while($sql_code = mysql_fetch_array($res_codes,MYSQL_ASSOC)):
			$codes[$sql_code['code_id']] = $sql_code['qte'];
		endwhile;
		
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr><th colspan="3">Profil du membre N° ' . $ce_membre->membre_id .' - '.$ce_membre->membre_pseudo.' </th></tr>';
		$contenu_texte[] = '<tr><td rowspan="10">'.
		membre_avatar($ce_membre,false).
		implode('',membre_vip($ce_membre,false)).
		'</td></tr>';
		$contenu_texte[] = '<tr><td>Date d\'inscription</td><td>'.format_date($ce_membre->membre_inscription).'</td></tr>';
		$contenu_texte[] = '<tr><td>Date de dernière connexion</td><td>'.format_date($ce_membre->membre_connexion).'</td></tr>';
		$contenu_texte[] = '<tr><td>Points</td><td>'.$ce_membre->membre_points.'</td></tr>';
		$contenu_texte[] = '<tr><td>Points Plus</td><td>'.$ce_membre->membre_points_plus.'</td></tr>';
		$contenu_texte[] = '<tr><td>Points VIP</td><td>'.$ce_membre->membre_points_vip.'</td></tr>';
		$contenu_texte[] = '<tr><td>Codes commandés</td><td><table>';
		foreach($codes as $clef => $valeur):
			$contenu_texte[] = '<tr><td>'.$cache_code_designation[$clef].'</td><td>'.$valeur.'</td></tr>';
		endforeach;
		$contenu_texte[] = '</table></td></tr>';
	
		$clan = new fp_enregistrement('codesgratis_clans',$ce_membre->membre_clan_id,'clan_id');
		if($clan->statut()):
			$contenu_texte[] = '<tr><td>Clan</td><td>'.$clan->clan_nom.'</td></tr>';
		else:
			$contenu_texte[] = '<tr><td>Clan</td><td>Ce membre n\'appartient à aucun clan</td></tr>';
		endif;
	
		$ce_parrain_id = $ce_membre->membre_parrain_id;
		if($ce_parrain_id > 0):
			$contenu_texte[] = '<tr><td>Parrain</td><td><a href="membre.php?_membre_id='.$ce_parrain_id.'">'.$cache_membre_pseudo[$ce_parrain_id].'</a></td></tr>';
		else:
			$contenu_texte[] = '<tr><td>Parrain</td><td>Ce membre n\'a pas de parrain</td></tr>';
		endif;
		$contenu_texte[] = '<tr><td>Filleuils</td><td>';

		$retour = mysql_query('SELECT membre_id FROM codesgratis_membres WHERE membre_parrain_id='. $ce_membre->membre_id );
				
		if(mysql_num_rows($retour) > 0):
			$contenu_texte[] = '<ul>';
			while($donnees = mysql_fetch_array($retour)):
				$ce_filleul = $donnees['membre_id'];
				$contenu_texte[] = '<li><a href="membre.php?_membre_id='.$ce_filleul.'">'.$cache_membre_pseudo[$ce_filleul].'</a></li>';
			endwhile;
			$contenu_texte[] = '</ul>';
		else:
			$contenu_texte[] = 'aucun filleuils';
		endif;
		$contenu_texte[] = '</td></tr>';
		
	
		$contenu_texte[] = '<tr><td colspan="3">'.bbcode_replace($ce_membre->membre_signature).'</td></tr>';
		$contenu_texte[] = '</table>';
	endif;
else:
	$infos = sql_limiteur
	(
		array
		(
			'unit_par_page'=>20,
			'table'=>'codesgratis_membres',
			'table_compteur'=>'membre_id',
			'where_condition'=> array( array('valeur_type' => 'nombre' , 'champ' => 'membre_banni' , 'valeur' => 0 ,  'condition' => '=' ) )
		)
	);
	$retour = mysql_query('SELECT * FROM codesgratis_membres where membre_banni=0 ORDER BY membre_id DESC LIMIT '. $infos['limit']);
	$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
	$contenu_texte[] = '<table><tr><th>ID</th><th>Pseudonyme</th><th>Date d\'inscription</td></tr>';
	while($sql_membre = mysql_fetch_array($retour,MYSQL_ASSOC)):
		$ce_membre = new fp_membre_sql($sql_membre);
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>'.$ce_membre->membre_id.'</td>';
		$contenu_texte[] = '<td><a href="'.page_courante(array('_membre_id'=>$ce_membre->membre_id)).'">'.$ce_membre->membre_pseudo.'</a></td>';
		$contenu_texte[] = '<td>'.format_date($ce_membre->membre_inscription).'</td>';
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '</table>';
	$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
endif;

require_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>