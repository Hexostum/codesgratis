<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'points.php');
include_once(FP_CHEMIN_FONCTIONS . 'parrain.php');
include_once(FP_CHEMIN_FONCTIONS . 'points_explication' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'tombola' . '.php');

$GLOBALS['instant_gagnant_gains'] = array
(
	'2000',
	'5000',
	'10000',
	'20000',
	'50000',
	'100000',
	'500000',
	'1000000',
	'1500000'	
);

function instant_gagnant($ce_gain)
{
	$sql = 'SELECT instant_gagnant_id FROM codesgratis_instant_gagnant where instant_gagnant_gain='.$ce_gain.' AND membre_id is null';
	$ig_id = sql_result($sql);
	if($ig_id===NULL):
		$sql = sql_insert
		(	
			'codesgratis_instant_gagnant',
			array
				(
					'instant_gagnant_id' => 'NULL',
					'instant_gagnant_gain' => $ce_gain,
					'instant_gagnant_ticket_joues' => 0,
					'membre_id' => 'NULL'
				)
		);
		if(mysql_query($sql)):
			$ig_id = mysql_insert_id();
			$cet_instant_gagnant = new fp_enregistrement('codesgratis_instant_gagnant',$ig_id,'instant_gagnant_id');
		else:
			echo mysql_error();
		endif;
	else:
		$cet_instant_gagnant = new fp_enregistrement('codesgratis_instant_gagnant',$ig_id,'instant_gagnant_id');
	endif;
	return $cet_instant_gagnant;
}
function instant_gagnant_ticket_joues(&$cet_instant_gagnant)
{
	$cet_instant_gagnant->instant_gagnant_ticket_joues = sql_result('SELECT count(instant_gagnant_ticket) FROM codesgratis_instant_gagnant_jeu WHERE instant_gagnant_id='.$cet_instant_gagnant->instant_gagnant_id,0);
	return $cet_instant_gagnant->instant_gagnant_ticket_joues;
}

function instant_gagnant_ticket_enregister(&$cet_instant_gagnant,&$my_membre)
{
	$sql = sql_insert
	(
		'codesgratis_instant_gagnant_jeu',
		array
		(
			'instant_gagnant_id' => $cet_instant_gagnant->instant_gagnant_id ,
			'instant_gagnant_ticket' => $cet_instant_gagnant->instant_gagnant_ticket_joues,
			'membre_id' => $my_membre->membre_id
		)
	)
	;
	if(mysql_query($sql)):
		gestion_points($my_membre , time() , $cet_instant_gagnant->instant_gagnant_id , -500 , FP_TYPE_R_IGG, ($cet_instant_gagnant->instant_gagnant_ticket_joues+1) , $my_membre->membre_id , 'NULL' , true );
		return 1;
	else:
		echo mysql_error();
		return 0;
	endif;
}

function instant_gagnant_ticket_gagnants($gain)
{
	$cout = 1000;
	$ticket_nombre = ceil(($gain/(950*0.99)));
	return $ticket_nombre;
}

if($my_membre->statut()):
	
	$contenu_texte[] = '<h1>Jouez à l\'instant gagnant ! </h1>';
	
	if($my_membre->membre_points_plus > 500):
		if(isset($_GET['gain'])):
			$ce_gain = $GLOBALS['instant_gagnant_gains'][intval($_GET['gain'])];
			
			if
				(
					isset($_POST['submit_jouer']) &&
					isset($_POST['check_ok'])
				)
			:
					$cet_instant_gagnant = instant_gagnant($ce_gain);
					$cet_instant_gagnant->instant_gagnant_ticket_joues = instant_gagnant_ticket_joues($cet_instant_gagnant) + instant_gagnant_ticket_enregister($cet_instant_gagnant,$my_membre);
					if($cet_instant_gagnant->instant_gagnant_ticket_joues==instant_gagnant_ticket_gagnants($ce_gain)):
						$cet_instant_gagnant->membre_id=$my_membre->membre_id;
						gestion_points($my_membre , time() , $cet_instant_gagnant->instant_gagnant_ticket_joues , $ce_gain , FP_TYPE_IGG, $cet_instant_gagnant->instant_gagnant_id , $my_membre->membre_id , 'NULL' , false );
						$contenu_texte[] = message('Bravo, vous avez gagnez <strong>'.$ce_gain.'</strong>  points grâce à l\'instant gagnant N°' . $cet_instant_gagnant->instant_gagnant_id,FP_MESSAGE_INFOS);
						$sql = sql_insert
						(
							'codesgratis_maj',array
							(
								'maj_id' => 'NULL',
								'maj_date' => 'UNIX_TIMESTAMP()',
								'maj_auteur'=> sql_champ_texte('Robot Instant Gagnant'),	
								'maj_titre'=> sql_champ_texte('Instant Gagnant N°' . $cet_instant_gagnant->instant_gagnant_id),
								'maj_texte' => sql_champ_texte($my_membre->membre_pseudo . ' a gagné <strong>'.number_format($ce_gain,0,',',' ').'</strong> points grâce à l\'instant gagnant N°' . $cet_instant_gagnant->instant_gagnant_id)
							)
						);
						mysql_query($sql);
						envoyer_message
						(
							0,
							$my_membre->membre_id,
							'Instant Gagnant N°' . $cet_instant_gagnant->instant_gagnant_id,
							'Bravo ' . $my_membre->membre_pseudo . ', vous avez gagné <strong>'.number_format($ce_gain,0,',',' ').'</strong> points grâce à l\'instant gagnant N°' . $cet_instant_gagnant->instant_gagnant_id
						);
					else:
						$contenu_texte[] = message('Dommage vous n\'avez pas gagnez. En revanche vous recevez <strong>50</strong> points en compensation',FP_MESSAGE_REPONSE);
						gestion_points($my_membre , time() , $cet_instant_gagnant->instant_gagnant_ticket_joues , 50 , FP_TYPE_IGG_C, $cet_instant_gagnant->instant_gagnant_id , $my_membre->membre_id , 'NULL' , false );
					endif;
					$contenu_texte[] = message('<a href="'.page_courante().'">Retentez votre chanche !</a>', FP_MESSAGE_INFOS);
			else:
				$contenu_texte[] = message ('Vous jouez pour gagner <strong>'.number_format($ce_gain,0,',',' ').'</strong> points (soit un équivalent de '.number_format(($ce_gain/1000),0,',',' ').' €). ' , FP_MESSAGE_INFOS);
				
				$contenu_texte[] = '<form action="'.page_courante().'" method="post">';
				$contenu_texte[] = '<table><tr><th>Jouez</th></tr>';
				$contenu_texte[] = '<tr><td><input type="checkbox" name="check_ok" id="check_ok"><label for="check_ok"> Oui, je souhaite jouez mes <strong> 500 </strong> points plus pour tenter de gagner <strong>'.number_format($ce_gain,0,',',' ').'</strong> points (soit un équivalent de '.number_format(($ce_gain/1000),0,',',' ').' €). </label>';
				$contenu_texte[] = '</td></tr>';
				$contenu_texte[] = '<tr><td><input type="submit" name="submit_jouer" id="submit_jouer" value="Jouer"></td></tr></table></form>';			
			endif;
			$contenu_texte[] = message('<a href="'.page_courante(array(),true).'">Revenir aux chois des lots ! </a>',FP_MESSAGE_INFOS);
		else:
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th>Jouer à l\'instant gagnant !</th></tr>';
			foreach($GLOBALS['instant_gagnant_gains'] as $clef => $valeur):
				$contenu_texte[] = '<tr><td>Jouez pour gagner <strong><a href="'.page_courante(array('gain'=>$clef)).'">'.number_format($valeur,0,'.',' ').'</a></strong> points (soit un équivalent de '.number_format(($valeur/1000),0,'.',' ').' €) Un gagnant tous les  '.instant_gagnant_ticket_gagnants($valeur).' Joueurs </tr>';
			endforeach;
			$contenu_texte[] = '</table>';
		endif;
		
	else:
		$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th>Gains de l\'instant gagnant !</th></tr>';
			foreach($GLOBALS['instant_gagnant_gains'] as $clef => $valeur):
				$contenu_texte[] = '<tr><td>Gagner <strong><a href="cgcode_achat.php">'.number_format($valeur,0,'.',' ').'</a></strong> points (soit un équivalent de '.number_format(($valeur/1000),0,'.',' ').' €) Un gagnant tous les  '.instant_gagnant_ticket_gagnants($valeur).' Joueurs </tr>';
			endforeach;
			$contenu_texte[] = '</table>';
		$contenu_texte[] = message ('Vous n\'avez pas assez de points plus pour jouer. Voullez-vous en <strong><a href="cgcode_achat.php">acheter</a></strong> ?' , FP_MESSAGE_ERROR);
		$contenu_texte[] = message ('Une partie coûte 500 points plus.' , FP_MESSAGE_ERROR);
	endif;
	afficher_historique($contenu_texte,$my_membre->membre_id,true,array(FP_TYPE_IGG,FP_TYPE_R_IGG,FP_TYPE_IGG_C));
else:
	
endif;
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>