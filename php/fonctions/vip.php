<?php

function determination_vip2($nb_points_vip)
{
	krsort($GLOBALS['vip_codes']);
	foreach($GLOBALS['vip_codes'] as $clef => $valeur):
		if($nb_points_vip >= $clef):
			$niveau_vip = $valeur;
			break 1;
		endif;
	endforeach;
	ksort($GLOBALS['vip_codes']);
	return $niveau_vip;	
}

function update_vip(&$membre)
{
	$points_vip = 80;
	$points_vip *= sql_result('SELECT count(code_id) FROM codesgratis_codes WHERE code_type=-2 AND membre_id='.$membre->membre_id.' AND code_validation is not null');
	$points_vip += (200 * sql_result('SELECT count(code_id) FROM codesgratis_codes WHERE code_type=-3 AND membre_id='.$membre->membre_id.' AND code_validation is not null')); 
	$membre->membre_points_vip = $points_vip;
	$membre->membre_vip = determination_vip2($points_vip);
	
}
?>