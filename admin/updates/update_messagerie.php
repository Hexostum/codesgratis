<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	$clef = isset($_GET['clef']) ? $_GET['clef'] : 0;
	
	if($clef < max(array_keys($liste_pseudo)) ):
		echo $liste_pseudo[$clef];
		mysql_query('UPDATE codesgratis_messagerie set message_from_id = '.$clef.' where message_from_pseudo = \''. $liste_pseudo[$clef].'\' ');
		mysql_query('UPDATE codesgratis_messagerie set message_to_id = '.$clef.' where message_to_pseudo = \''. $liste_pseudo[$clef].'\' ');
		echo '<script type="text/javascript">
		function next()
		{
			window.location=\'?clef='.($clef+1).'\'
		}
		window.onload=next;
		</script>';
	endif;
endif;
?>