<?php
function afficher_explication($type,$id,$points,$membre_id,$texte,$reverse=false)
{
	switch($type):
		case FP_TYPE_CGCODE:
			return 'Gain de <b>'.$points.'</b> point plus grâce à la validation du CGCODE ['.$texte.'] .';
		break;
		case FP_TYPE_R_TOMBOLA:
			return '-<b>'.$points.'</b> points plus Achat du ticket N°'.$texte.' pour la tombola <b>'.$id.'</b>.';
		break;
		case FP_TYPE_TOMBOLA:
			return 'Gain de <b>'.$points.'</b> points grâce au ticket N°'.$texte.' de la tombola <b>'.$id.'</b>.';
		break;
		case FP_TYPE_HASARD:
			return 'Gain de <b>'.$points.'</b> point au jeu de hasard (Ticket N°<b>'.$id.'</b>).';
		break;
		case FP_TYPE_R_HASARD:
			return '<b>'.$points.'</b> point plus pour l\'achat du Ticket N°<b>'.$id.'</b>.';
		break;
		case FP_TYPE_PARRAIN_HASARD:
			if($reverse):
				return 'Votre parrain a gagné <b>'.$points.'</b> points grâce à votre ticket N°<b>'.$id.'</b> du jeu de hasard';				
			else:
				return 'Parrainage : Gain de <b>'.$points.'</b> point grâce au filleul <b>'.$membre_id.'</b> au jeu de hasard (Ticket N°<b>'.$id.'</b>)';
			endif;
		break;
		case FP_TYPE_PARRAIN_TOMBOLA:
			if($reverse):
				return 'Votre parrain a gagné <b>'.$points.'</b> points grâce à votre gain de la tombola N°<b>'.$id.'</b> ';				
			else:
				return 'Parrainage : Gain de <b>'.$points.'</b> point grâce au filleul <b>'.$membre_id.'</b> qui a gagné à la tombola N°<b>'.$id.'</b>)';
			endif;
		break;
		case FP_TYPE_R_PUBS1:
			return '<strong>'.$points.'</strong> points : Achat de 100 affichages pour votre pub ('.$id.') au clic ('.$texte.').';
		break;
		case FP_TYPE_R_PUBS1PLUS:
			return '<strong>'.$points.'</strong> points plus : Achat de 100 affichages pour votre pub ('.$id.') au clic ('.$texte.').';
		break;
		
		case FP_TYPE_PUB:
			return 'Gain de <b>'.$points.'</b> points grâce à votre clic sur la publicité du membre <b>'.$id.'</b> ('.$texte.').';
		break;
		case FP_TYPE_PARRAIN_PUB:
			if($reverse):
				return 'Votre parrain a gagné <b>'.$points.'</b> points grâce à votre clic sur la pub du membre <b>'.$id.'</b>';
			else:
				return 'Parrainage : Gain de <b>'.$points.'</b> points grâce à votre filleul <b>'.$membre_id.'</b> qui a cliqué sur la pub du membre <b>'.$id.'</b>)';
			endif;
		break;
		case FP_TYPE_PAGES:
			if($id==''):
				return 'Gain de <b>'.$points.'</b> points grâce à une visite (IP : '.$texte.' ) sur votre page PTP.';		
			else:
				return 'Gain de <b>'.$points.'</b> points grâce à une visite du membre '.$id.' sur votre page PTP.';		
			endif;
		break;
		case FP_TYPE_PARRAIN_PAGES:
			if($reverse):
				return 'Votre parrain a gagné <b>'.$points.'</b> points parce qu\'on a visité votre page PTP';
			else:
				return 'Parrainage : Gain de <b>'.$points.'</b> points grâce à votre filleul <b>'.$membre_id.'</b> dont la page PTP a été visité';
			endif;
		break;
		case FP_TYPE_IG:
			return 'Gain de <b>'.$points.'</b> points plus grâce à l\'instant gagnant N° <b>'.$id.'</b> .';
		break;		
		case FP_TYPE_COMMANDE:
			return '<b>'.$points.'</b>. Commande N° '. $id .' de '.$texte;
		break;
		case FP_TYPE_COMMANDE_PLUS:
			return '<b>'.$points.'</b> points plus. Commande N° '. $id .' de '.$texte;
		break;
		case FP_TYPE_COMMANDE_R:
			return '<b>'.$points.'</b>. Remboursement de la commande annulée N° '. $id;
		break;
		case FP_TYPE_FILLEULS:
			return '<b>'.$points.'</b> points plus. Achat du filleul '. $membre_id ;
		break;	
		case FP_TYPE_FILLEULSR:
			return '<b>'.$points.'</b>points plus grâce à votre parrain.';
		break;	
		case FP_TYPE_CONCOURS_C:
			return '<b>'.$points.'</b>points plus pour l\'achat de '.$texte.' ticket(s) pour le concours N°'. $id;
		break;
		case FP_TYPE_IGG:
			return 'Gain de <strong>'.$points.'</strong> points à l\'instant gagnant N°' . $id ;
		break;
		case FP_TYPE_IGG_C:
			return 'Gain de <strong>'.$points.'</strong> points de compensation à l\'instant gagnant N°' . $id . ' grâce à votre ticket N°' . $texte ;
		break;
		case FP_TYPE_R_IGG:
			return '<strong>'.$points.'</strong> points plus pour l\'achat du ticket N°'.$id.' pour l\'instant gagnant N°' . $texte ;
		break;
		default:
			return "Le webmaster a oublié d'expliquer à quoi correspond cet historique :  [ $type ]    [ $id  ]  [ $points ]   [ $membre_id ]  [ $texte ] . ";
		break;		
	endswitch;
}

?>