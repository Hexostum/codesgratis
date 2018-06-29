<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	$sql = 'select DISTINCT(membre_parrain) from codesgratis_membres';
	$res_parrain = mysql_query($sql);
	while($sql_parrain = mysql_fetch_array($res_parrain)):
		$pseudo = $sql_parrain[0];
		$pseudo = trim($pseudo);
		$pseudo = strtolower($pseudo);
		$membre_id = array_keys($liste_pseudo,$pseudo);
		if(count($membre_id)==1):
			$sql = 'UPDATE codesgratis_membres SET membre_parrain_id='.$membre_id[0].' WHERE membre_parrain like \''.$sql_parrain[0].'\'';
		else:
			$sql = 'UPDATE codesgratis_membres SET membre_parrain_id=NULL WHERE membre_parrain like \''.$sql_parrain[0].'\'';
		endif;
		echo $sql . FP_LIGNE;
		mysql_query($sql);
	endwhile;
	$sql = 'UPDATE codesgratis_membres SET membre_parrain_id=NULL WHERE membre_parrain is null';
	echo $sql;
	mysql_query($sql);
endif;
?>