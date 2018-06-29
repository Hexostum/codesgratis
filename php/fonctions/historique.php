<?php
function gestion_points($my_membre , $date , $texte , $points , $type , $type_id , $membre_id , $filleul_id='NULL' , $points_plus=false)
{
	$sql = 
'INSERT INTO codesgratis_historique VALUES ( '.
$date. ' , \''.
$texte.'\' , '.
$points.' , '.
$type.' , '.
$type_id.' , '.
$membre_id.' , '.
$filleul_id.' )'
;
	if(mysql_query($sql)):
		if($points_plus):
			return $my_membre->incremente_champ('membre_points_plus',$points);
		else:
			return $my_membre->incremente_champ('membre_points',$points);
		endif;
	else:
		echo '['.$sql.'] ['.mysql_error().']' . FP_LIGNE . '<br>';
		return false;
	endif;										
}
?>