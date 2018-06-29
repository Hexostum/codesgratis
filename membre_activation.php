<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
if(!$my_membre->statut()):
	$page_titre .=  ' - Activation de votre compte.';
	if(isset($_GET['clef']) && isset($_GET['compte_id'])):
		$test_membre = new fp_membre(intval($_GET['compte_id']));
		if($test_membre->statut()):
			if($test_membre->membre_activation==0):
				if($test_membre->membre_activation_code==$_GET['clef']):
					$test_membre->membre_activation=1;
					$contenu_texte[] = message('Votre compte sur ce site a été activé',FP_MESSAGE_INFOS);
				endif;
			else:
				$contenu_texte[] = message('Votre compte sur ce site a déjà été activé',FP_MESSAGE_INFOS);
			endif;
		else:
			$contenu_texte[] = message('Ce compte n\'existe pas sur ce site.' , FP_MESSAGE_INFOS);
		endif;
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
endif;
?>