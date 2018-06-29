<?php
include_once(FP_CHEMIN_FONCTIONS . 'bbcode.php');

function liste_coms($sql_maj)
{
	$infos = sql_limiteur
	(
		array
		(
			'unit_par_page'=>10,
			'table_compteur_overdrive'=> $sql_maj->maj_coms
		)
	);
	$str_pagination = $infos['pagination'];								
	$retour = mysql_query('SELECT * FROM codesgratis_coms WHERE com_type=\'maj\'  AND com_type_id=\''. $sql_maj->maj_id .'\' ORDER BY com_date DESC LIMIT '. $infos['limit']);
	$sql_coms = array();
	$sql_ids = array();
	while($sql_com = mysql_fetch_array($retour)):
		$sql_coms[$sql_com['com_id']] = new fp_enregistrement_sql($sql_com,'codesgratis_coms','com_type_id');
		$sql_ids[$sql_com['membre_id']] = $sql_com['membre_id'];
	endwhile;
	$liste_pseudo = 
	sql_list
	(
		array
		(
			'table' => 'codesgratis_membres',
			'table_id'=>'membre_id',
			'liste' => $sql_ids
			)
		)
	;
	$texte = array();
	$texte = array_merge($texte, $str_pagination);
	$texte[] = '<table border="1">';
	$texte[] = '<tr><th>Com IDE</th><th>Membre ID</th><th>Pseudonyme</th><th>Texte</th><th>Action</th></tr>';
	foreach($sql_coms as $sql_com):
		$texte[] = '<tr>';
		$texte[] = '<td><a href="'.page_courante(array('maj_com_id'=>$sql_com->com_id,'mode'=>'editer'),true).'">'.$sql_com->com_id.'</a></td>';
		$texte[] = '<td>' . $sql_com->membre_id . '</td>';
		$texte[] = '<td>' . $liste_pseudo[$sql_com->membre_id]->membre_pseudo . '</td>';
		$texte[] = '<td>' . bbcode_replace(stripslashes($sql_com->com_texte)) . '</td>';
		$texte[] = '<td><a href="'.page_courante (array ('maj_com_id'=>$sql_com->com_id , 'mode' => 'supprimer'),true) .'">Supprimer</a></td>';
		$texte[] = '</tr>';
	endforeach;
	$texte[] = '</table>';
	$texte = array_merge($texte, $str_pagination);
	return format_texte($texte,3);
}

function editer_maj($sql_maj)
{
	$sql_maj->maj_texte = trim(stripslashes($sql_maj->maj_texte));
	$sql_maj->maj_titre = trim(stripslashes($sql_maj->maj_titre));
	
	$contenu = str_replace('<br />','<br>',nl2br(stripslashes($sql_maj->maj_texte)));
		
	$texte[] = '<div class="maj" id="maj_' . $sql_maj->maj_id . '">';
	$texte[] = FP_TAB . '<h3>';
	$texte[] = bbcode_replace($sql_maj->maj_titre);
	$texte[] = FP_TAB . FP_TAB . '<em>par ' . $sql_maj->maj_auteur . ' , le ' . date('d/m/Y à H\hi', $sql_maj->maj_date) . '</em>';
	$texte[] = FP_TAB . '</h3>';
	$texte[] = FP_TAB . '<p>';
	$texte[] = FP_TAB . FP_TAB . str_replace(FP_LIGNE , FP_LIGNE . str_repeat(FP_TAB,5) ,bbcode_replace($contenu));
	$texte[] = FP_TAB . '</p>';
	$texte[] = '</div>';
	
	// Edit form
	$texte[] = '<form method="post" action="'.page_courante().'">';
	$texte[] = '<table order="1" style="width:98%">';
	$texte[] = '<tr><th colspan="2">Edition de la Mise A Jour</th></tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Auteur</td>';
	$texte[] = '<td><input type="text" name="maj_auteur" id="maj_auteur" value="'.$sql_maj->maj_auteur.'"></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Titre</td>';
	$texte[] = '<td><input type="text" name="maj_titre" id="maj_titre" value="'.$sql_maj->maj_titre.'"></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Date</td>';
	$texte[] = '<td></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Contenu</td>';
	$texte[] = '<td><textarea rows="25" style="width:100%" id="maj_texte" name="maj_texte">'.stripslashes($sql_maj->maj_texte).'</textarea></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<th colspan="2"><input type="submit" name="submit_maj" id="submit_maj"></th></tr>';
	$texte[] = '<tr><th colspan="2"><a href="'.page_courante(array('mode' => 'supprimer')).'">Supprimer la mise à jour</a></th>';
	$texte[] = '</tr>';
	$texte[] = '</table>';
	$texte[] = '</form>';
	return format_texte($texte,3);
	
}

function new_maj()
{
	$texte = array();
	$texte[] = '<form method="post" action="'.FP_PAGE .'?mode=nouveau">';
	$texte[] = '<table order="1" style="width:98%">';
	$texte[] = '<tr><th colspan="2">Edition de la Mise A Jour</th></tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Auteur</td>';
	$texte[] = '<td><input type="text" name="maj_auteur" id="maj_auteur" value=""></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Titre</td>';
	$texte[] = '<td><input type="text" name="maj_titre" id="maj_titre" value=""></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Date</td>';
	$texte[] = '<td></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<td>Contenu</td>';
	$texte[] = '<td><textarea rows="25" style="width:100%" id="maj_texte" name="maj_texte"></textarea></td>';
	$texte[] = '</tr>';
	$texte[] = '<tr>';
	$texte[] = '<th colspan="2"><input type="submit" name="submit_maj" id="submit_maj"></th>';
	$texte[] = '</tr>';
	$texte[] = '</table>';
	$texte[] = '</form>';
	return $texte;
}

function afficher_maj($sql_maj,$b_coms=false)
{
	$texte = array();
	
	if($b_coms):
		$infos = sql_limiteur
		(
			array
			(
				'unit_par_page'=>10,
				'table_compteur_overdrive'=> $sql_maj->maj_coms
			)
		);
		$str_pagination = $infos['pagination'];
										
		$retour = mysql_query('SELECT * FROM codesgratis_coms WHERE com_type=\'maj\'  AND com_type_id=\''. $sql_maj->maj_id .'\' ORDER BY com_date DESC LIMIT '. $infos['limit']);
		$sql_coms = array();
		$sql_membre_ids = array();
		while($sql_com = mysql_fetch_array($retour)):
			$sql_coms[$sql_com['com_id']] = new fp_enregistrement_sql($sql_com,'codesgratis_coms','com_type_id');
			$sql_membre_ids[$sql_com['membre_id']] = $sql_com['membre_id'];
		endwhile;
	endif;
	
	$contenu = str_replace('<br />','<br>',nl2br(stripslashes($sql_maj->maj_texte)));
		
	$texte[] = '<div class="maj" id="maj_' . $sql_maj->maj_id . '">';
	$texte[] = FP_TAB . '<h3>';
	if($b_coms): 
		$texte[] = bbcode_replace($sql_maj->maj_titre); 	
	else:
		$texte[] = FP_TAB .FP_TAB .  '<a href="index.php?maj_id='.$sql_maj->maj_id.'">' . bbcode_replace($sql_maj->maj_titre) . '</a>';
	endif;
	$texte[] = FP_TAB . FP_TAB . '<em>par ' . $sql_maj->maj_auteur . ' , le ' . format_date($sql_maj->maj_date) . '</em>';
	$texte[] = FP_TAB . '</h3>';
	
	$texte[] = FP_TAB . '<p>';
	$texte[] = FP_TAB . FP_TAB . str_replace(FP_LIGNE , FP_LIGNE . str_repeat(FP_TAB,5) ,bbcode_replace($contenu));
	$texte[] = FP_TAB . '</p>';
	if(!$b_coms):
		$texte[] = FP_TAB .  '<a href="index.php?maj_id=' . $sql_maj->maj_id . '">'.$sql_maj->maj_coms.' commentaires</a>';
	else:
		if($GLOBALS['my_membre']->membre_existe()):
			$texte[] = '<table>';
			$texte[] = '<tr><th colspan="2">Laisser un commentaires</th></tr>';
			$texte[] = '<tr><td>Aperçu</td><td><p id="com_message_infos"></p></td></tr>';
			$texte[] = '<form action="' . page_courante ( array ( 'maj_id' => $sql_maj->maj_id ) ) . '" method="post">';
			$texte[] = '<tr><td>Votre commentaire :</td><td><textarea class="bbcode" style="width:98%;" name="com_message" id="com_message">Entrez ici votre commentaire</textarea></td></tr>';
			$texte[] = '<tr><td colspan="2"><input type="submit" name="submit_com" id="submit_com" value="Envoyer votre commentaire"></tr></td>';
			$texte[] = '</form>';
			$texte[] = '</table>';
		endif;
		
		if
			(
				count($sql_coms) > 0
			)
		:
			$liste_membre = 
				sql_list
				(
					array
					(
						'table' => 'codesgratis_membres',
						'table_id'=>'membre_id',
						'liste' => $sql_membre_ids
					)
				)
			;
			$texte = array_merge($texte, $str_pagination);
			foreach($sql_coms as $sql_com):
				if(isset($liste_membre[$sql_com->membre_id])):
					$texte[] = '<table>';
					$texte[] = '<tr>';
					$texte[] = '<th rowspan="2" width="100">';
					$texte[] =  membre_pseudo($sql_com->membre_id);
					$texte[] =  membre_avatar($liste_membre[$sql_com->membre_id]);
					$texte =  array_merge($texte,membre_vip($liste_membre[$sql_com->membre_id]));
					$texte[] =  '</td>';
					$texte[] = '<th>' . format_date($sql_com->com_date) . '</th></tr>';
					$texte[] = '<tr><td colspan="2">' . bbcode_replace(stripslashes($sql_com->com_texte)) . '</td></tr>';
					$texte[] = '<tr><td colspan="2">' . bbcode_replace(stripslashes($liste_membre[$sql_com->membre_id]->membre_signature)) . '</td></tr>';
					$texte[] = '</table>';
				endif;
			endforeach;
		
			$texte = array_merge($texte, $str_pagination);
		endif;
	endif;
	$texte[] = '</div>';
	return format_texte($texte,3);
}
function resume_maj($maj)
{
	$texte = array();
	$texte[] = '<tr>';
	$texte[] = '<td>'.$maj->maj_auteur . '</td>';
	$texte[] = '<td><a href="'.page_courante(array('maj_id'=>$maj->maj_id),true).'">'.$maj->maj_titre . '</a></td>';
	$texte[] = '<td>'.format_date($maj->maj_date) . '</td>';
	$texte[] = '</tr>';
	return $texte;
}
?>