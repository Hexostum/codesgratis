<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'tombola' . '.php');
// define('FP_CRON_CLEF_1','exogratis');
// define('FP_CRON_CLEF_2','codetum');

if
	(
		md5($_GET['clef_1'])=='98a1d61ae99f1ff145094c48ba7d4035' && 
		md5($_GET['clef_2'])=='fdaa33e2088f8f0be6c05ccc5580f0fa'
	)
:
	/**/
	
	$an = date('Y', time());
	$mois = date('m', time());
	$jour = date('d', time());
	
	$tombola_id = $an . $mois . $jour;
	
	$my_tombola = new fp_enregistrement('codesgratis_tombolas',sql_champ_texte($tombola_id),'tombola_id');
	if(!$my_tombola->statut()):
		gagnant_tombola(mktime(0,0,0 , $mois , ($jour-1), $an ));
		if(nouvelle_tombola($tombola_id)):
			$my_tombola = new fp_enregistrement('codesgratis_tombolas',sql_champ_texte($tombola_id),'tombola_id');
			echo 'tombola ' . $tombola_id . ' a été créé ' . FP_LIGNE;
		else:
			echo 'tombola ' . $tombola_id . ' n\'a pas été créé ' . FP_LIGNE;
		endif;
	else:
		echo 'tombola ' . $tombola_id . ' existe déjà' . FP_LIGNE;
 	endif;
	
	liste_tombola_maj($tombola_id);
	
else:
	echo 'KO';
endif;
?>