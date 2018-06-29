<?php
$cg_letters = array
(
	'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J' , 'K' , 'L' , 'M', 'N' , 'O' , 'P' , 'Q' , 'R', 'S', 'T' , 'U', 'V', 'W','X','Y','Z'
);
function generer_cggratuit()
{
	$code = 'CGRATUIT' . str_repeat(' ',13);
	
	for($i;$i<=13;$i++):
		$code{$i+8} = $GLOBALS['cg_letters'][rand(0,35)];
	endfor;
	return $code;
}
function generer_cgcode()
{
	$code = 'CG' . str_repeat(' ',13);
	for($i;$i<=13;$i++):
		$code{$i+2} = $GLOBALS['cg_letters'][rand(0,35)];
	endfor;
	return $code;
}
function generer_cgplus()
{
	$code = 'CG+' . str_repeat(' ',13);
	for($i;$i<=13;$i++):
		$code{$i+2} = $GLOBALS['cg_letters'][rand(0,35)];
	endfor;
	return $code;
}
function gain_cgcode($membre_vip)
{
	return (26  * (1 + (0.05 * intval($membre_vip) )  ) ); 
}

function gain_cgplus($membre_vip)
{
	return (65  * (1 + (0.05 * intval($membre_vip) )  ) ); 
}
function gain_cgpaypal($membre_vip)
{
	return (333  * (1 + (0.05 * intval($membre_vip) )  ) ); 
}

function gain_cggratis($membre_vip)
{
	return (20 * (1 + (0.05 * intval($membre_vip) ) ) );
}

function afficher_cgcode(&$contenu_texte ,$membre_id , $type)
{
	$codes_nbr = sql_result('SELECT count(code_id) FROM codesgratis_codes where code_type='.$type.' AND membre_id=' . $membre_id);
	
	$nombreDePages  = ceil($codes_nbr / 20);
	$str_pagination = pagination($nombreDePages , 'page_code_' . $type );
	$limit = sql_limit(20);
	
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	$contenu_texte[] = '<form action="'.page_courante().'" method="POST">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th colspan="5">'.$GLOBALS['cache_code_designation'][$type].'</th></tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th>Code</th>';
	$contenu_texte[] = '<th>Date obtention</th>';
	$contenu_texte[] = '<th>Date Validé</th>';
	$contenu_texte[] = '<th>Valider</th>';
	$contenu_texte[] = '</tr>';
	
	$test_res = mysql_query('SELECT * FROM codesgratis_codes WHERE code_type='.$type.' AND membre_id=' . $membre_id . ' LIMIT ' . $limit);
	
	while($sql_code = mysql_fetch_array($test_res,MYSQL_ASSOC)):
		$ce_code = new fp_enregistrement_sql($sql_code,'codesgratis_codes','code_id');
		$code_texte = $ce_code->code_texte;
		if($ce_code->code_validation==null):
			$validation = true;
		else:
			$validation=false;
		endif;
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>'.$code_texte.'</td>';
		$contenu_texte[] = '<td>'.format_date($ce_code->code_obtenu).'</td>';
		$contenu_texte[] = '<td>'.format_date($ce_code->code_validation).'</td>';
		if($validation):
			$contenu_texte[] = '<td><input type="checkbox" name="code[]" value="'.$ce_code->code_id.'"></td>';
		else:
			$contenu_texte[] = '<td>-</td>';
		endif;
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '<tr><th colspan="4"><input type="submit" name="submit_codes_'.$type.'" id="submit_codes_'.$type.'" value="valider"></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
}
?>