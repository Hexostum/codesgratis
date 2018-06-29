<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'page' . '.php');
if(isset($_GET['membre_id']) && isset($_GET['date'])):
	$now = date( 'Y-m-d' , strtotime("now") );
	$membre_id = intval($_GET['membre_id']);
	$date = $_GET['date'];
	$ce_membre = new fp_membre($membre_id);			
	if($ce_membre->membre_existe()):
		$dossier = FP_CHEMIN_PREUVES . $membre_id . DIRECTORY_SEPARATOR;
		if(!file_exists( $dossier )):
			mkdir( $dossier, 0777 , true);
		endif;
		if($date == $now):
			exit(afficher_preuve($membre_id,$now));
		else:
			if(strlen($date)==strlen('0000-00-00')):
				$date_frag = explode('-',$date);
				if(count($date_frag)==3):
					$an = intval($date_frag[0]);
					$mois = intval($date_frag[1]);
					$jour = intval($date_frag[2]);
				
					$file = sprintf('%04s-%02s-%02s' ,$an,$mois,$jour) . '.html';
				
					if(file_exists($dossier . $file)):
						exit(file_get_contents($dossier . $file));
					else:
						exit(file_get_contents(FP_CHEMIN_PREUVES . 'rien.html'));
					endif;
				else:
					
					$date = intval($date);
					$an = date('Y',$date);
					$mois = date('m',$date);
					$jour = date('d',$date);
					$format = sprintf('%04s-%02s-%02s' ,$an,$mois,$jour);
					header('Location: preuve_clic.php?membre_id='.$membre_id.'&date='.$format);		
				endif;
			else:
				$date = intval($date);
				$an = date('Y',$date);
				$mois = date('m',$date);
				$jour = date('d',$date);
				$format = sprintf('%04s-%02s-%02s' ,$an,$mois,$jour);
				header('Location: preuve_clic.php?membre_id='.$membre_id.'&date='.$format);				
			endif;
		endif;
	else:
		exit(file_get_contents(FP_CHEMIN_PREUVES . 'membre.html'));		
	endif;
endif;
?>