<?php
function afficher_historique(&$contenu_texte,$membre_id=null,$mode=true,$type=null)
{
	if(is_null($membre_id)):
		if($type):
		else:
			$histo_nombre = sql_result('SELECT count(histo_date) FROM codesgratis_historique');
		endif;
	else:
		if($mode):
			if($type):
				if(is_array($type)):
					$histo_nombre = sql_result('SELECT count(histo_date) FROM codesgratis_historique where histo_type in ( '.implode (' , ', $type).' )  AND membre_id='.$membre_id);
				else:
					$histo_nombre = sql_result('SELECT count(histo_date) FROM codesgratis_historique where histo_type='.$type.' AND membre_id='.$membre_id);
				endif;
			else:
				$histo_nombre = sql_result('SELECT count(histo_date) FROM codesgratis_historique where membre_id='.$membre_id);
			endif;
		else:
			if($type):
				
			else:
				$histo_nombre = sql_result('SELECT count(histo_date) FROM codesgratis_historique where filleul_id='.$membre_id);
			endif;
		endif;
	endif;
	$histos_page = 50;
	
	$pages = ceil($histo_nombre / $histos_page);
	$str_pagination = pagination($pages);
	
	if(isset($_GET['page'])):
		$_start = intval($_GET['page']) * $histos_page;
		$_limit = $histos_page;
	else:
		$_start = 0;
		$_limit = $histos_page;
	endif;
	
	$limit = implode(' , ' , array($_start, $_limit));
	if(is_null($membre_id)):
		if($type==null):
			$retour = mysql_query('SELECT * FROM codesgratis_historique ORDER BY histo_date DESC LIMIT '.$limit);
		else:
			if(is_array($type)):
				$sql = 'SELECT * FROM codesgratis_historique where histo_type in ( '.implode(' , ' , $type).' ) ORDER BY histo_date DESC LIMIT '.$limit;
				echo $sql;
				$retour = mysql_query($sql);
				
			else:
				$retour = mysql_query('SELECT * FROM codesgratis_historique where histo_type='.$type.' ORDER BY histo_date DESC LIMIT '.$limit);
			endif;
		endif;
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
		$contenu_texte[] = '<table><tr><th coslpan="2">Historique des points</th></tr><tr><td>date</td><td>Explication</td></tr>';
		while($sql_histo = mysql_fetch_array($retour,MYSQL_ASSOC)):
			$contenu_texte[]  = '<tr>';
			$contenu_texte[]  = '<td>'.format_date($sql_histo['histo_date']).'</td>';
			$contenu_texte[]  = '<td>'.afficher_explication($sql_histo['histo_type'],$sql_histo['histo_type_id'],$sql_histo['histo_point'],$sql_histo['filleul_id'],$sql_histo['histo_texte']).'</td>';
			$contenu_texte[]  = '</tr>';
		endwhile;
		$contenu_texte[]  = '</table>';
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
	else:
	if($mode):
		if($type==null):
			$retour = mysql_query('SELECT * FROM codesgratis_historique where membre_id='.$membre_id . ' ORDER BY histo_date DESC LIMIT '.$limit);
		else:
			if(is_array($type)):
				$retour = mysql_query('SELECT * FROM codesgratis_historique where membre_id='.$membre_id . ' AND histo_type in ( '.implode (' , ', $type).' ) ORDER BY histo_date DESC LIMIT '.$limit);
			else:
				$retour = mysql_query('SELECT * FROM codesgratis_historique where membre_id='.$membre_id . ' AND histo_type='.$type.' ORDER BY histo_date DESC LIMIT '.$limit);
			endif;
		endif;
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
		$contenu_texte[] ='<table><tr><th colspan="2">Historique des points</th></tr><tr><td>date</td><td>Explication</td></tr>';
		while($sql_histo = mysql_fetch_array($retour,MYSQL_ASSOC)):
			$contenu_texte[]  = '<tr>';
			$contenu_texte[]  = '<td>'.format_date($sql_histo['histo_date']).'</td>';
			$contenu_texte[]  = '<td>'.afficher_explication($sql_histo['histo_type'],$sql_histo['histo_type_id'],$sql_histo['histo_point'],$sql_histo['filleul_id'],$sql_histo['histo_texte']).'</td>';
			$contenu_texte[]  = '</tr>';
		endwhile;
		$contenu_texte[]  = '</table>';
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
	else:
		if($type==null):
			$retour = mysql_query('SELECT * FROM codesgratis_historique where filleul_id='.$membre_id . ' ORDER BY histo_date DESC LIMIT '.$limit);
		else:
			$retour = mysql_query('SELECT * FROM codesgratis_historique where filleul_id='.$membre_id . ' AND histo_type='.$type.' ORDER BY histo_date DESC LIMIT '.$limit);
		endif;
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
		$contenu_texte[] =  '<table>';
		while($sql_histo = mysql_fetch_array($retour,MYSQL_ASSOC)):
			$contenu_texte[]  = '<tr>';
			$contenu_texte[]  = '<td>'.format_date($sql_histo['histo_date']).'</td>';
			$contenu_texte[] =  '<td>'.afficher_explication($sql_histo['histo_type'],$sql_histo['histo_type_id'],$sql_histo['histo_point'],$sql_histo['membre_id'],$sql_histo['histo_texte'],true).'</td>';
			$contenu_texte[] =  '</tr>';
		endwhile;
		$contenu_texte[] =  '</table>';
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
	endif;
	endif;
}
?>