<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'messagerie' . '.php');
//include_once(FP_CHEMIN_FONCTIONS . 'support' . '.php');

$contenu_texte[] = '<h1>Support de codesgratis</h1>';
$contenu_texte[] = '<table>';
$contenu_texte[] = '<tr><td>MSN</td><td>***@***</td></tr>';
$contenu_texte[] = '<tr><td>courriel</td><td>support@****</td></tr>';
$contenu_texte[] = '<tr><td>ICQ</td><td>*******</td></tr>';
$contenu_texte[] = '<tr><td>IRC</td><td>irc.epiknet.org #codesgratis</td></tr>';
$contenu_texte[] = '<tr><td>AIM</td><td>******</td></tr>';
$contenu_texte[] = '<tr><td>yahoo</td><td>******</td></tr>';
$contenu_texte[] =  '</table>';

form_support($contenu_texte);

$contenu_texte [] = '<iframe src="http://www.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=****&amp;color=%232952A3&amp;ctz=Europe%2FParis" style=" border-width:0 " width="600" height="600" frameborder="0" scrolling="no"></iframe>';
/**
$mode = $_GET['mode'];

switch($mode):
	case 'nouveau':
		// ajouter un nouveau ticket
		if($my_membre->statut()):
			
		else:
			
		endif;
	break;
	case 'ticket':
		if($my_membre->statut()):
			$ce_ticket = new fp_enregistrement('codesgratis_tickets',intval($_GET['ticket_id']),'ticket_id');
			if($ce_ticket->statut()):
				if($ce_ticket->membre_id==$my_membre->membre_id):
					contenu_texte[] = afficher_ticket($ce_ticket);
				endif;
			endif;
		else:
			
			$ce_ticket = new fp_enregistrement('codesgratis_tickets',intval($_GET['ticket_id']),'ticket_id');
			if($ce_ticket->statut()):
				if($ce_ticket->ticket_hashcode==$_GET['ticket_hascode'] && $ce_ticket->ticket_courriel==$_GET['ticket_courriels']):
					contenu_texte[] = afficher_ticket($ce_ticket);
				endif;
			endif;
		endif;	
	break;
	
	default:
		if($my_membre->statut()):
			$contenu_texte[] = liste_ticket($my_membre->membre_id);
			$contenu_texte[] = new_ticket($my_membre->membre_id);
		else:
			$contenu_texte[] = new_ticket();
		endif;
	break;	
endswitch;
**/
include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
?>
