<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'historique.php');
include_once(FP_CHEMIN_FONCTIONS . 'cgcodes.php');


// affichage des codes obtenus
if($my_membre->membre_existe()):
	update_vip($my_membre);
	// si on a posté des codes
	
	if(isset($_POST['code'])):
		foreach($_POST['code'] as $code_id):
			$ce_code = new fp_enregistrement('codesgratis_codes','code_id',$code_id);
			if($ce_code->statut()):
				if($ce_code->membre_id==$my_membre->membre_id):
					switch($ce_code->code_type):
					
						case FP_CGPAYPAL:
							$ce_code->code_validation = time();
							gestion_points($my_membre , time() , $ce_code->code_texte , gain_cgpaypal($my_membre->membre_vip) , FP_TYPE_CGCODE , $code_id , $my_membre->membre_id , 'NULL' , true );
							update_vip($my_membre);
						break;
					
						case FP_CGCODESPLUS:
							$ce_code->code_validation = time();
							gestion_points($my_membre , time() , $ce_code->code_texte , gain_cgplus($my_membre->membre_vip) , FP_TYPE_CGCODE , $code_id , $my_membre->membre_id , 'NULL' , true );
							update_vip($my_membre);
						break;
					
						case FP_CGCODES:
							$ce_code->code_validation = time();
							gestion_points($my_membre , time() , $ce_code->code_texte , gain_cgcode($my_membre->membre_vip) , FP_TYPE_CGCODE , $code_id , $my_membre->membre_id , 'NULL' , true );
							update_vip($my_membre);
						break;
						
						case FP_CGRATIS:
							$ce_code->code_validation = time();
							gestion_points($my_membre , time() , $ce_code->code_texte , gain_cggratis($my_membre->membre_vip) , FP_TYPE_CGCODE , $code_id , $my_membre->membre_id , 'NULL' , true );
							update_vip($my_membre);
						break;
						
					endswitch;
				endif;
			endif;
		endforeach;
		
	elseif(isset($_POST['submit_code_externe'])):
		$code_id = $_POST['code_externe'];
		$ce_code = new fp_enregistrement('codesgratis_codes',"'".$code_id."'",'code_texte');
		if($ce_code->statut()):
			if($ce_code->membre_id==null):
				$ce_code->membre_id = $my_membre->membre_id;
				$ce_code->code_obtenu = time();
				$ce_code->code_validation = time();
				switch($ce_code->code_type):
					case FP_CGPAYPAL:
							$ce_code->code_validation = time();
							gestion_points($my_membre , time() , $ce_code->code_texte , gain_cgpaypal($my_membre->membre_vip) , FP_TYPE_CGCODE , $code_id , $my_membre->membre_id , 'NULL' , true );
							update_vip($my_membre);
					break;
						
					case FP_CGCODESPLUS:
						gestion_points($my_membre , time() , $ce_code->code_texte , gain_cgplus($my_membre->membre_vip) , FP_TYPE_CGCODE , $ce_code->code_id , $my_membre->membre_id , 'NULL' , true );
						update_vip($my_membre);
					break;
					
					case FP_CGCODES:
						gestion_points($my_membre , time() , $ce_code->code_texte , gain_cgcode($my_membre->membre_vip) , FP_TYPE_CGCODE , $ce_code->code_id , $my_membre->membre_id , 'NULL' , true );
						update_vip($my_membre);
					break;
						
					case FP_CGRATIS:
						gestion_points($my_membre , time() , $ce_code->code_texte , gain_cggratis($my_membre->membre_vip) , FP_TYPE_CGCODE , $ce_code->code_id , $my_membre->membre_id , 'NULL' , true );
					break;
				endswitch;	
			endif;
		endif;
	endif;
	
	$contenu_texte[] = '<h1>Validation des CGCODES</h1>';
	$contenu_texte[] = '<table><tr><th>Type</th><th>Points Plus</th><th>Points VIP</th>';
	$contenu_texte[] = '<tr><td>CGRATIS</td><td>'. gain_cggratis($my_membre->membre_vip)  . '</td><td>-</td></tr>';
	$contenu_texte[] = '<tr><td>CGCODE</td><td>'. gain_cgcode($my_membre->membre_vip) . '</td><td>80</td></tr>';
	$contenu_texte[] = '<tr><td>CGPLUS</td><td>'. gain_cgplus($my_membre->membre_vip) . '</td><td>200</td></tr>';
	$contenu_texte[] = '<tr><td>CGPAYPAL</td><td>'. gain_cgpaypal($my_membre->membre_vip) . '</td><td>1000</td></tr>';
	$contenu_texte[] = '</table>';
	
	
	$contenu_texte[] = '<form action="'.page_courante().'" method="POST">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th colspan="2">Validation CG, CG+ et CGratuits externes ou achetés avant la migration</th></tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<td>Code</td>';
	$contenu_texte[] = '<td><input type="textarea" name="code_externe" id="code_externe"></td>';
	$contenu_texte[] = '</tr><tr>';
	$contenu_texte[] = '<th colspan="2"><input type="submit" name="submit_code_externe" id="submit_code_externe" value="Valider"></th>';
	$contenu_texte[] = '</tr></table></form>';
	
	afficher_cgcode($contenu_texte,$my_membre->membre_id,FP_CGRATIS);
	afficher_cgcode($contenu_texte,$my_membre->membre_id,FP_CGCODES);
	afficher_cgcode($contenu_texte,$my_membre->membre_id,FP_CGCODESPLUS);
	afficher_cgcode($contenu_texte,$my_membre->membre_id,FP_CGPAYPAL);
	
	/** CGCODES **
	
	
	$cgcodes_nbr = sql_result('SELECT count(code_id) FROM codesgratis_codes where code_type='.FP_CGCODES.' AND membre_id=' . $my_membre->membre_id);
	
	$nombreDePages  = ceil($cgcodes_nbr / 20);
	$str_pagination = pagination($nombreDePages);
	$limit = sql_limit(20);
	
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	$contenu_texte[] = '<form action="'.page_courante().'" method="POST">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th colspan="5">CGCODES</th></tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th>Code</th>';
	$contenu_texte[] = '<th>Date obtention</th>';
	$contenu_texte[] = '<th>Date Validé</th>';
	$contenu_texte[] = '<th>Valider</th>';
	$contenu_texte[] = '</tr>';
	
	$test_res = mysql_query('SELECT * FROM codesgratis_codes WHERE code_type='.FP_CGCODES.' AND membre_id=' . $my_membre->membre_id . ' LIMIT ' . $limit);
	
	while($sql_code = mysql_fetch_array($test_res,MYSQL_ASSOC)):
		$ce_code = new fp_enregistrement_sql($sql_code,'codesgratis_codes','code_id');
		$code_texte = $ce_code->code_texte;
		if($ce_code->code_obtenu==null):
			$code_date_o = '';
		else:
			$code_date_o = format_date($ce_code->code_obtenu);
		endif;
		if($ce_code->code_validation==null):
			$validation = true;
			$code_date_v = 'N/A';
		else:
			$validation=false;
			$code_date_v = format_date($ce_code->code_validation);
		endif;
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>'.$code_texte.'</td>';
		$contenu_texte[] = '<td>'.$code_date_o.'</td>';
		$contenu_texte[] = '<td>'.$code_date_v.'</td>';
		if($validation):
			$contenu_texte[] = '<td><input type="checkbox" name="code[]" value="'.$ce_code->code_id.'"></td>';
		else:
			$contenu_texte[] = '<td>-</td>';
		endif;
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '<tr><th colspan="4"><input type="submit" name="submit_codes" id="submit_codes" value="valider"></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	
	
	/** CGCODESplus **
	
	
	$cgcodes_nbr = sql_result('SELECT count(code_id) FROM codesgratis_codes where code_type='.FP_CGCODESPLUS.' AND membre_id=' . $my_membre->membre_id);
	
	$nombreDePages  = ceil($cgcodes_nbr / 20);
	$str_pagination = pagination($nombreDePages,'pageplus');
	$limit = sql_limit(20,'pageplus');
	
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	$contenu_texte[] = '<form action="'.page_courante().'" method="POST">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th colspan="5">CGCODESPLUS</th></tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th>Code</th>';
	$contenu_texte[] = '<th>Date obtention</th>';
	$contenu_texte[] = '<th>Date Validé</th>';
	$contenu_texte[] = '<th>Valider</th>';
	$contenu_texte[] = '</tr>';
	
	$test_res = mysql_query('SELECT * FROM codesgratis_codes WHERE code_type='.FP_CGCODESPLUS.' AND membre_id=' . $my_membre->membre_id . ' LIMIT ' . $limit);
	
	while($sql_code = mysql_fetch_array($test_res,MYSQL_ASSOC)):
		$ce_code = new fp_enregistrement_sql($sql_code,'codesgratis_codes','code_id');
		$code_texte = $ce_code->code_texte;
		if($ce_code->code_obtenu==null):
			$code_date_o = '';
		else:
			$code_date_o = date('d/m/Y,  H:i',$ce_code->code_obtenu);
		endif;
		if($ce_code->code_validation==null):
			$validation = true;
			$code_date_v = 'N/A';
		else:
			$validation=false;
			$code_date_v = date('d/m/Y,  H:i',$ce_code->code_validation);
		endif;
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>'.$code_texte.'</td>';
		$contenu_texte[] = '<td>'.$code_date_o.'</td>';
		$contenu_texte[] = '<td>'.$code_date_v.'</td>';
		if($validation):
			$contenu_texte[] = '<td><input type="checkbox" name="code[]" value="'.$ce_code->code_id.'"></td>';
		else:
			$contenu_texte[] = '<td>-</td>';
		endif;
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '<tr><th colspan="4"><input type="submit" name="submit_codesplus" id="submit_codesplus" value="valider"></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	
	
	/** CGRATIS **
	
	
	$cgcodes_nbr = sql_result('SELECT count(code_id) FROM codesgratis_codes where code_type=-1 AND membre_id=' . $my_membre->membre_id);
	
	$nombreDePages  = ceil($cgcodes_nbr / 20);
	$str_pagination = pagination($nombreDePages,'pagegratis');
	$limit = sql_limit(20,'pagegratis');
	
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	$contenu_texte[] = '<form action="'.FP_PAGE.'" method="POST">';
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th colspan="5">CGRATIS</th></tr>';
	$contenu_texte[] = '<tr>';
	$contenu_texte[] = '<th>Code</th>';
	$contenu_texte[] = '<th>Date obtention</th>';
	$contenu_texte[] = '<th>Date Validé</th>';
	$contenu_texte[] = '<th>Valider</th>';
	$contenu_texte[] = '</tr>';
	
	$test_res = mysql_query('SELECT * FROM codesgratis_codes WHERE code_type=-1 AND membre_id=' . $my_membre->membre_id . ' LIMIT ' . $limit);
	
	while($sql_code = mysql_fetch_array($test_res,MYSQL_ASSOC)):
		$ce_code = new fp_enregistrement_sql($sql_code,'codesgratis_codes','code_id');
		$code_texte = $ce_code->code_texte;
		if($ce_code->code_obtenu==null):
			$code_date_o = '';
		else:
			$code_date_o = date('d/m/Y,  H:i',$ce_code->code_obtenu);
		endif;
		if($ce_code->code_validation==null):
			$validation = true;
			$code_date_v = 'N/A';
		else:
			$validation=false;
			$code_date_v = date('d/m/Y,  H:i',$ce_code->code_validation);
		endif;
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<td>'.$code_texte.'</td>';
		$contenu_texte[] = '<td>'.$code_date_o.'</td>';
		$contenu_texte[] = '<td>'.$code_date_v.'</td>';
		if($validation):
			$contenu_texte[] = '<td><input type="checkbox" name="code[]" value="'.$ce_code->code_id.'"></td>';
		else:
			$contenu_texte[] = '<td>-</td>';
		endif;
		$contenu_texte[] = '</tr>';
	endwhile;
	$contenu_texte[] = '<tr><th colspan="4"><input type="submit" name="submit_codesgratis" id="submit_codesgratis" value="valider"></tr>';
	$contenu_texte[] = '</table>';
	$contenu_texte[] = '</form>';
	
	$contenu_texte = array_merge($contenu_texte,$str_pagination);
	
/**/
endif;
page_courante(array('truc'=>'moche'));
include(FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR . 'page_end.php');
?>