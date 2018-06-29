<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	$clef = isset($_GET['clef']) ? $_GET['clef'] : 0;
	
	if($clef < max(array_keys($liste_pseudo)) ):
		echo $liste_pseudo[$clef];
	
		mysql_query('UPDATE codesgratis_forum_sujets set membre_id = '.$clef.' where membre_pseudo = \''. $liste_pseudo[$clef].'\' ');
		echo '<script type="text/javascript">window.location=\'?clef='.($clef+1).'\'</script>';
	endif;
endif;
?>