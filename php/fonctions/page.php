<?php
$texte_preuve_page = file_get_contents(FP_CHEMIN_PREUVES . 'exemple.html');

function afficher_preuve($membre_id)
{
	$res2 = mysql_query('SELECT * FROM codesgratis_pages_clics WHERE membre_id=' . $membre_id);
	echo mysql_error();
	$liste_enregistrement = array();
	while($enr2 = mysql_fetch_array($res2,MYSQL_ASSOC)):
		$liste_enregistrement[] = $enr2;
	endwhile;
	$lignes = array();
	foreach($liste_enregistrement as $valeur):
			$lignes[] = 
				'<td>'. $valeur['clic_ip'] .'</td>' .FP_LIGNE.
				'<td>'. $valeur['clic_membre_id'] .'</td>' .FP_LIGNE .  
				'<td>'. $valeur['clic_referer'] .'</td>'
			;
	endforeach;
	$lignes_str = '<tr>' . implode ('</tr>'.FP_LIGNE.'<tr>' , $lignes ) . '</tr>';
	$texte_fichier = str_replace('{MEMBRE}',$membre_id,$GLOBALS['texte_preuve_page']);
	$texte_fichier = str_replace('{DATE}', date( 'Y-m-d' , strtotime("NOW") ),$texte_fichier);
	$texte_fichier = str_replace('{LIGNES}',$lignes_str,$texte_fichier);	
	return $texte_fichier;
}

function enregistrer_preuve($membre_id,$date,$liste_enregistrement)
{
	$dossier = FP_CHEMIN_PREUVES . $membre_id . DIRECTORY_SEPARATOR;
	if(!file_exists($dossier)):
		mkdir( $dossier , 0777 , true);
	endif;
	$fichier = $date  . '.html';
	// clic_membre_id
	// clic_ip
	// clic_referer
	$lignes = array();
	foreach($liste_enregistrement as $valeur):
			$lignes[] = 
				'<td>'. $valeur['clic_ip'] .'</td>' .FP_LIGNE.
				'<td>'. $valeur['clic_membre_id'] .'</td>' .FP_LIGNE .  
				'<td>'. $valeur['clic_referer'] .'</td>'
			;
	endforeach;
	$lignes_str = '<tr>' . implode ('</tr>'.FP_LIGNE.'<tr>' , $lignes ) . '</tr>';
	
	$texte_fichier = str_replace('{MEMBRE}',$membre_id,$GLOBALS['texte_preuve_page']);
	$texte_fichier = str_replace('{DATE}',$date,$texte_fichier);
	$texte_fichier = str_replace('{LIGNES}',$lignes_str,$texte_fichier);
	return file_put_contents($dossier . $fichier,$texte_fichier);
}
function update_page_clics()
{
	$date_hier =  date( 'Y-m-d' , strtotime("-1 day") );
	$date_minuit = mktime(0, 0, 0);
	$res = mysql_query('SELECT membre_id FROM codesgratis_pages_clics WHERE clic_date < '. $date_minuit . ' GROUP BY membre_id');
	echo mysql_error();
	while($enr = mysql_fetch_array($res)):
		$res2 = mysql_query('SELECT * FROM codesgratis_pages_clics WHERE clic_date < '. $date_minuit . ' AND membre_id=' . $enr['membre_id']);
		echo mysql_error();
		$liste_enregistrement = array();
		while($enr2 = mysql_fetch_array($res2,MYSQL_ASSOC)):
			$liste_enregistrement[] = $enr2;
		endwhile;
		if(enregistrer_preuve($enr['membre_id'],$date_hier,$liste_enregistrement)):
			mysql_query('DELETE FROM codesgratis_pages_clics WHERE clic_date < '. $date_minuit .' AND membre_id=' . $enr['membre_id']);
		else:
			break 1;
		endif;
	endwhile;
}
?>