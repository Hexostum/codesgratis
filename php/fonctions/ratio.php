<?php
include_once(FP_CHEMIN_FONCTIONS . 'vip.php');

function update_ratio($membre_id)
{
	$ce_membre = new fp_membre($membre_id);
					
	//Calcul de l'augmentation du ratio en fonction du temps passé
	$temps_passe = time() - $ce_membre->membre_ratio_date;
					
	//Mise à jour de la valeur de dernière augmentation
	$ce_membre->membre_ratio = time();
	
	$niveau_vip = $ce_membre->membre_vip;
													
	$ratio_max = 1.5 - ($niveau_vip / 100);
					
	if($ce_membre->membre_ratio <= $ratio_max - $temps_passe*0.0000005):
		$ratio = $ce_membre->membre_ratio + $temps_passe*0.0000005;
	else:
		$ratio = 1.5 - ($niveau_vip / 100);
	endif;
	$ce_membre->membre_ratio = $ratio;
	return $ratio;
}
?>