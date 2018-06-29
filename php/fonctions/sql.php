<?php
function sql_limiteur($params)
{
	$params = new fp_params($params);
	$sql = '';
	if($params->table_compteur_overdrive):
		$unit_nombre = $params->table_compteur_overdrive;
		$sql = $unit_nombre;
	else:
		if($params->where_condition):
			$where = '';
			foreach($params->where_condition as $valeur):
				if(isset($valeur['conjonction'])):
					$where .= ' ' . $valeur['conjonction'] . ' ';
				endif;
				switch($valeur['valeur_type']):
					case 'texte':
						$where .= $valeur['champ'] . $valeur['condition'] . "'" . $valeur['valeur'] . "'";
					break;
					
					case 'nombre':
						$where .= $valeur['champ'] . $valeur['condition'] . $valeur['valeur'];
					break;
				endswitch;
			endforeach;
			$sql = 'SELECT count('.$params->table_compteur.') FROM '.$params->table . ' WHERE ' . $where;
			$unit_nombre = sql_result( $sql );
		else:
			$sql = 'SELECT count('.$params->table_compteur.') FROM '.$params->table;
			$unit_nombre = sql_result( $sql );
		endif;
	endif;
	$unit_pages = ceil( $unit_nombre / $params->unit_par_page );
	$pagination = pagination($unit_pages);
	$limit = sql_limit($params->unit_par_page);
	return 
	array
		(
			'limit' => $limit,
			'pagination' => $pagination,
			'unit_pages'=> $unit_pages,
			'sql' => $sql
		)
	;
}

function sql_limit($nombre_par_page,$nompage='page')
{
	if(isset($_GET[$nompage])):
		$page = intval($_GET[$nompage]);
	else:
		$page = 0;
	endif;
	$limit_1 = $page * $nombre_par_page; 
	$limit_2 = $nombre_par_page; 
	return $limit_1 .' , '. $limit_2; 
}

function sql_result($sql,$defaut=null)
{
	$res_sql = mysql_query($sql);
	if(is_resource($res_sql)):
		if(mysql_num_rows($res_sql)>0):
			return mysql_result($res_sql,0);
		else:
			return $defaut;
		endif;
	else:
		return $defaut;
	endif;
}
function sql_list($params)
{
	$params = new fp_params($params);
	$select = $params->get_prop('select','*');
	$group_by = $params->group_by;
	$order_by = $params->order_by;
	$clef_tableau  = $params->clef_tableau;
	if($group_by):
		$sql = 'SELECT '.$select.' FROM '.$params->table.' WHERE '.$params->table_id.'  IN ('.implode(' , ',$params->liste).') GROUP BY '.$group_by;
	else: 
		$sql = 'SELECT '.$select.' FROM '.$params->table.' WHERE '.$params->table_id.'  IN ('.implode(' , ',$params->liste).')';
	endif;
	if($order_by):
		$sql .= ' ORDER BY ' . $order_by;
	endif;
	
	$res = mysql_query($sql);
	if(is_resource($res)):
		while($sql_enr = mysql_fetch_array($res,MYSQL_ASSOC)):
			if($clef_tableau):
				$liste[$sql_enr[$clef_tableau]] = new fp_enregistrement_sql($sql_enr,$params->table,$params->table_id); 
			else:
				$liste[$sql_enr[$params->table_id]] = new fp_enregistrement_sql($sql_enr,$params->table,$params->table_id); 
			endif;
		endwhile;
		return $liste;
	else:
		return array();
	endif;
}
function sql_insert($table,$champs)
{
	$champ_clefs = array();
	$champ_valeurs = array();
	foreach($champs as $clef => $valeur):
		$champ_clefs[] = $clef;
		$champ_valeurs[] = $valeur; 
	endforeach;
	
	$texte = 'INSERT INTO ' . $table . ' ( ' . implode( ' , ' , $champ_clefs) . ' ) VALUES ( ' . implode (' , ' , $champ_valeurs) . ' ) ';
	return $texte;
}
function sql_champ_texte($texte)
{
	$texte = stripslashes($texte);
	return "'" . mysql_real_escape_string($texte) . "'";
}
function droit()
{
}
function is_modo()
{
}
?>