<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

include_once(FP_CHEMIN_FONCTIONS . 'historique' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');

$page_titre .= ' - Achat de filleuls';

if
	(
		$my_membre->membre_existe()
	)
:

	$contenu_texte[] = '<h1>Parrainez au maximum pour un rendement efficace en achetant des filleuls !</h1>';
	$contenu_texte[] = '<p>Voici la liste de tous les membres qui ne sont pas encore parrainés. Vous pouvez les acheter à l\'aide';
	$contenu_texte[] = 'de points plus. Cela correspond donc en quelque sorte à un investissement pour gagner plus grâce à des filleuls';
	$contenu_texte[] = 'actifs. Et il ne tient qu\'à vous de les motiver toujours plus !</p>';

	$niveau_vip = $my_membre->membre_vip;
	
	if($niveau_vip > 0):
		$reduction = $niveau_vip * 0.005;
		$reduction_affichage = $reduction * 100;
		$contenu_texte[] = message ('En tant que joueur (joueuse) de niveau V.I.P. '. $niveau_vip . ', vous bénéficiez d\'une réduction de '.$reduction_affichage.'% sur tous les filleuls achetés !' , FP_MESSAGE_INFOS ) ;
	else:
		$reduction=0;
	endif;
	
	$contenu_texte[] = message ('Vous disposez de <strong>'. $my_membre->membre_points_plus . '</strong> points plus.' , FP_MESSAGE_INFOS ) ;
	
	
	if
		(
			isset($_POST['filleul'])
		)
	:
		$filleul_id = intval($_POST['filleul']) ;	
		$my_filleul = new fp_membre($filleul_id);
		if
			(
				$my_filleul->membre_existe()
			)
		:
			if
				(
					is_null($my_filleul->membre_parrain_id)
				)
			:
				$cout_tickets = (1500) + ($my_filleul->membre_vip * (600));
				$cout_tickets -= $reduction*$cout_tickets;
							
				if
					(
						$my_membre->membre_points_plus >= $cout_tickets
					)
				:
			
					if
						(
							gestion_points($my_membre , time() , '' , -$cout_tickets , FP_TYPE_FILLEULS , 'NULL' , $my_membre->membre_id , $my_filleul->membre_id , true)
						)
					:
						$my_filleul->membre_parrain_id = $my_membre->membre_id;
						$benef_filleul = 0.05 * $cout_tickets;
						gestion_points($my_filleul , time() , '' , $benef_filleul , FP_TYPE_FILLEULSR , 'NULL' , $my_filleul->membre_id , 'NULL' , true);
						envoyer_message
						(
							0 ,
							$my_filleul->membre_id,
							'Votre nouveau parrain !',
							'Bonjour, '.$my_filleul->membre_pseudo. FP_LIGNE .
							'Ceci est un message automatique.'. FP_LIGNE . 
							$my_membre->membre_pseudo.', ayant payé pour cela, est désormais votre parrain ou marraine !' . FP_LIGNE .
							'Vous avez touché 5% de la valeur de l\'achat de tickets+.' . FP_LIGNE .
							'J\'espère que vous vous entendrez bien avec votre lui ou elle. =)'. FP_LIGNE .
							'Cordialement,' . FP_LIGNE .
							'Le webmaster.'
						);
								
						$contenu_texte[] = message ( $my_filleul->membre_pseudo .' est désormais votre filleul ! ' , FP_MESSAGE_INFOS ) ;
					else:
						$contenu_texte[] =  'ERREUR';
					endif;				
				else:
					$contenu_texte[] =  message ('Vous ne disposez pas de suffisamment de points plus pour pouvoir acheter '. $my_filleul->membre_pseudo .'. Voulez-vous en <a href="cgcode_achat.php">acheter</a> ?' , FP_MESSAGE_ERROR);
				endif;
			else:
				$contenu_texte[] =  message ($my_filleul->membre_pseudo .' est déjà parrainé(e).' , FP_MESSAGE_ERROR );
			endif;
		else:
			$contenu_texte[] =  message ('Le membre '. $membre_id .' n\'existe pas.' , FP_MESSAGE_ERROR );
		endif;
	endif;
	
	
	
	$membres_page = 30;
	$membres_nbre = sql_result("SELECT COUNT(membre_id) AS nbre FROM codesgratis_membres WHERE membre_parrain_id is null");
	$pages_nbre  = ceil($membres_nbre / $membres_page);

	$limit = sql_limit($pages_nbre);
	$pagination_str = pagination($pages_nbre);

	$contenu_texte = array_merge($contenu_texte,$pagination_str) ;
	$contenu_texte[] ='<table>';
	$contenu_texte[] ='<tr>';
	$contenu_texte[] ='<th>Joueur</th>';
	$contenu_texte[] ='<th>Nombre de points</th>';
	$contenu_texte[] ='<th>Commandes</th>';
	$contenu_texte[] ='<th>Date d\'inscription</th>';
	$contenu_texte[] ='<th>Dernière connexion</th>';
	$contenu_texte[] ='<th>Coût et action</th>';
	$contenu_texte[] ='</tr>';

	$retour = mysql_query("SELECT * FROM codesgratis_membres WHERE membre_parrain_id is null AND membre_points >= 0 AND membre_id <> 0 ORDER BY membre_vip DESC, membre_points DESC LIMIT $limit");

	$sql_membres = array();
	$sql_ids = array();

	while($sql_membre = mysql_fetch_array($retour,MYSQL_ASSOC)):
		$sql_membres[$sql_membre['membre_id']] = $sql_membre;
		$sql_ids[] = $sql_membre['membre_id'];
	endwhile;

	$pseudos = implode("' , '" ,$sql_ids);

	$query_res = mysql_query('SELECT SUM(code_qte) AS codes_nbre , membre_id FROM codesgratis_commande WHERE membre_id IN (\''. $pseudos .'\') GROUP BY membre_id ');
	
	$sql_commandes = array();
	while($sql_commande = mysql_fetch_array($query_res)):
		$sql_commandes[$sql_commande['membre_id']] = $sql_commande['codes_nbre'];
	endwhile;

	// 1 Ticket plus = 0.20€ soit 200 point soit 100 points plus
			
	foreach($sql_membres as $membre):
		
		$membre = new fp_membre_sql ($membre);			
		$cout_tickets = 1500 + ($membre->membre_vip * 600);
		$cout_tickets -= $reduction * $cout_tickets;

		$contenu_texte[] ='<tr>';
		$contenu_texte[] ='<td>';
		$contenu_texte[] = membre_pseudo($membre->membre_id);
		$contenu_texte[] = membre_avatar($membre);
		$contenu_texte = array_merge($contenu_texte,membre_vip($membre));
		/**
		if( $membre['membre_vip'] > 0 ):
			$contenu_texte[] ='<img src="images/vip/vip'.$membre['membre_vip'].'.png" alt="V.I.P. '.$membre['membre_vip'].'">';
		else:
			$contenu_texte[] ='<img src="html/images/vip/non_vip.png" alt="Non V.I.P.">';
		endif;
		**/
		$contenu_texte[] ='</td>';
		$contenu_texte[] ='<td>' . $membre->membre_points.'</td>';
		$contenu_texte[] ='<td>' . (array_key_exists($membre->membre_id,$sql_commandes) ? $sql_commandes[$membre->membre_id] : 0) . ' codes commandés</td>';
		$contenu_texte[] ='<td>' . 'Le '. format_date ( $membre->membre_inscription )  .'</td>';
		$contenu_texte[] ='<td>' . 'Le '. format_date ( $membre->membre_connexion ) .'</td>';
		$contenu_texte[] ='<td>';
		$contenu_texte[] = $cout_tickets .' points plus';
		$contenu_texte[] ='<br>';
		$contenu_texte[] ='<form method="post" action="achat_filleuls.php">';
		$contenu_texte[] ='<input type="hidden" name="filleul" value="' . $membre->membre_id.'">';
		$contenu_texte[] ='<input type="submit" value="Acheter ce filleul.">';
		$contenu_texte[] ='</form>';
		$contenu_texte[] ='</td>';
		$contenu_texte[] ='</tr>';
	endforeach;
	
	$contenu_texte[] = '</table>';
	
	$contenu_texte = array_merge($contenu_texte , $pagination_str);
	
	
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>