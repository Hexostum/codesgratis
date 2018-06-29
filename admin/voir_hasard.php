<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');

include(FP_CHEMIN_FONCTIONS . 'pagination' . '.php');
include(FP_CHEMIN_FONCTIONS . 'hasard_recapitulatif' . '.php');

if(is_admin($my_membre)):
	$reload=false;
	$membre_affiche=null;
	
	if(isset($_GET['membre_id'])):
		$membre_affiche = new fp_membre($_GET['membre_id'],'membre_id');
	elseif(isset($_GET['membre_pseudo'])):
		$membre_affiche = new fp_membre("'" . $_GET['membre_pseudo'] . "'" ,'membre_pseudo');
	endif;	
		
	if(is_object($membre_affiche)):
		if($membre_affiche->membre_existe()):
			$contenu_texte[] =  '<div class="item_titre"> Tickets de ' . $membre_affiche->membre_pseudo . '</div>';
			$contenu_texte[] =  '<div class="item_contenu">'; 
			hasard_recapitulatif($contenu_texte,$membre_affiche);
			
			$contenu_texte[] = '<br><a href='.FP_PAGE.'>Afficher les tickets de tous les membres.</a><br>';
			$contenu_texte[] =  '</div>'; 
		else:
			$contenu_texte[] =  'ce membre n\'existe pas.';
		endif;
	else:
		$contenu_texte[] =  '<div class="item_titre"> Tickets de tous les membres</div>';
		$contenu_texte[] =  '<div class="item_contenu">'; 
		hasard_recapitulatif_complet($contenu_texte);
		$contenu_texte[] =  '</div>';
	endif;
	$contenu_texte[] =  '</div>'; 
	$contenu_texte[] =  '<div class="item">'; 
	$contenu_texte[] =  '<div class="item_titre"> Statistiques</div>';
	$contenu_texte[] =  '<div class="item_contenu">'; 
	hasard_stat($contenu_texte);
	$contenu_texte[] =  '</div>';
	if($reload):
	
		$contenu_javascript[] = '<script type="text/javascript">';
		$contenu_javascript[] = 'window.location.reload();';
		$contenu_javascript[] = '</script>';
		
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	header('Location: ../index.php');
endif;
?>