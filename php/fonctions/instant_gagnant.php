<?php
function instant_gagnant($my_membre,$points_plus)
{
	$message = array();
	$current = sql_result('SELECT ig_points FROM codesgratis_igs ORDER BY ig_id DESC LIMIT 1 ');
	
	$last_ig_id = sql_result('SELECT ig_id FROM codesgratis_igs ORDER BY ig_id DESC LIMIT 1 ');
	$message[] = message('Vous avez validé <strong>'.$points_plus.'</strong> points plus pour l\'instant gagnant N°' . $last_ig_id , FP_MESSAGE_INFOS);
	
	$next = $current + $points_plus;
	while($next >= 5000 ):
		$last_ig_id = sql_result('SELECT ig_id FROM codesgratis_igs ORDER BY ig_id DESC LIMIT 1');
		if(mysql_query('UPDATE codesgratis_igs SET membre_id='.$my_membre->membre_id.' , ig_points=5000 , ig_date=UNIX_TIMESTAMP() WHERE ig_id='.$last_ig_id)):
		
			gestion_points($my_membre, time() , '' , 250 , FP_TYPE_IG, $last_ig_id , $my_membre->membre_id , 'NULL' , true);
			$next -= 5000;
			$sql = sql_insert
			(
				'codesgratis_igs' , 
				array
				(
					'ig_id' => 'NULL',
					'membre_id'=> 'NULL',
					'ig_date'=> 'NULL',
					'ig_points'=> 0,
				)
			);
			mysql_query($sql);
			$message[] = message('Vous voilà l\'heureux ou heureuse gagnant(e) de 250 points plus avec l\'instant gagnant N°'.$last_ig_id.'!',FP_MESSAGE_INFOS);
		else:
			$message[] = message(mysql_error(),FP_MESSAGE_ERROR);
		endif;
	endwhile;
	$last_ig_id = sql_result('SELECT ig_id FROM codesgratis_igs ORDER BY ig_id DESC LIMIT 1 ');
	if(!mysql_query('UPDATE codesgratis_igs SET ig_points='.$next.' WHERE ig_id='.$last_ig_id)):
		$message[] = message(mysql_error(),FP_MESSAGE_ERROR);
	else:
		$message[] = message('Il reste <strong>'.(5000-$next).'</strong> points plus à valider avant le prochain gain à l\'instant gagnant',FP_MESSAGE_INFOS);
	endif;
	return $message;
}
?>