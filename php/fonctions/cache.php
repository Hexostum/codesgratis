<?php
function cache($params)
{
	$params = new fp_params($params);
	$texte_debut = 
'<?php
$cache_'.$params->nom_cache.'=array();';

$texte_fin = '?>';
	$message = array();
	$sql = 'SELECT '.$params->champ_clef.' , '.$params->champ_valeur.' FROM '.$params->table.' ORDER BY '.$params->champ_clef.' ';
	$retour = mysql_query($sql);
	if(is_resource($retour)):
		while($array = mysql_fetch_array($retour)):
			$message[] = '$cache_'.$params->nom_cache.'['.$array[$params->champ_clef].'] = \''.trim(addslashes(stripslashes($array[$params->champ_valeur]))).'\';';
		endwhile;
	endif;
	$fp = fopen(FP_CHEMIN_CACHE .$params->nom_cache.'.php','w');
	fwrite($fp,$texte_debut);
	fwrite($fp,FP_LIGNE);
	fwrite($fp,implode(FP_LIGNE,$message));
	fwrite($fp,FP_LIGNE);
	fwrite($fp,$texte_fin);
	fclose($fp);
}
?>