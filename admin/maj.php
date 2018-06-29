<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'courriel' . '.php');
include_once(FP_CHEMIN_FONCTIONS . 'bbcode' . '.php');

if(is_admin($my_membre)):

	include(FP_CHEMIN_FONCTIONS . 'maj.php');

	if(isset($_GET['maj_id'])):
		$maj_id = intval($_GET['maj_id']);
		$sql_maj = new fp_enregistrement('codesgratis_maj',$maj_id,'maj_id');
		
		$sql_maj->maj_coms = sql_result('SELECT COUNT(com_id) FROM codesgratis_coms WHERE com_type_id = ' . $sql_maj->maj_id);
		
		if($sql_maj->statut()):
		
				switch(@$_GET['mode']):
				case 'coms':
					$contenu_texte[] = '<div class="item_titre">		<h1>Gestion des commentaires d\'une mise à jour</h1></div>';
					$contenu_texte[] = '<div class="item_contenu">';
					$contenu_texte[] = liste_coms($sql_maj);
					$contenu_texte[] = '<br><a href="'.page_courante(array(),true).'">Retour aux mises à jour.</a><br>';
					$contenu_texte[] = '</div>';
				break;
				
				case 'supprimer':
				
					$sql_maj->delete();
					$contenu_texte[] = 'La mise à jour N°'.$sql_maj->maj_id.' a été supprimée.';
					$contenu_texte[] = '<br><a href="'.page_courante(array(),true).'">Retour aux mises à jour.</a><br>';
				
				break;
				
				
				case 'resend_lettre':
					$contenu_texte[] = '<h1>Renvoie de la lettre de mise à jour</h1>';
					$texte = lettre_mise_a_jour
					(
						'[CODESGRATIS] [Mise à jour N°' . $sql_maj->maj_id . '] ' . $sql_maj->maj_titre  ,
						
						array
						(
							bbcode_replace($sql_maj->maj_texte),
							'--------------------------------',						
							'Cette mise à jour a été postée sur le site de Codesgratis d\'Exostum sur lequel vous êtes inscrit. Si vous n\'arrivez pas à lire ce courriel voici le lien pour accéder directement à la mise à jour sur le site  : http://www.codesgratis.fr/index.php?maj_id=' . $sql_maj->maj_id ,
							'',
							'Vous pouvez à tout moment configurer votre compte pour arrêter de recevoir des courriels quand une mise à jour est postée sur le site Codesgratis d\'Exostum.',
							'',
							'--------------------------------',
						    'Final Lucyën Arkansérafin-Haylea',
							'Ce site est édité par Scelzo Patrick Jean (Auto-Entrepreneur).',
							'Code SIRET : 514 550 763 00015',
							'Code APE : 6201Z (Programmation Informatique)',
							'http://www.codesgratis.fr/',
							'http://www.exostum.net/'
						)
					)
				;
					$contenu_texte  = array_merge($contenu_texte,$texte);
				break;
				
	
				case 'edit':
				default:
					if(isset($_POST['submit_maj'])):
						$sql_maj->maj_auteur = trim($_POST['maj_auteur']);
						$sql_maj->maj_texte = trim($_POST['maj_texte']);
						$sql_maj->maj_titre = trim($_POST['maj_titre']);
					endif;
					
					
					$contenu_texte[] = '<div class="item_titre">		<h1>Gestion d\'une mise à jour</h1></div>';
					$contenu_texte[] = '<div class="item_contenu">';
					$contenu_texte[] = editer_maj($sql_maj);
					$contenu_texte[] = '<br><a href="'.page_courante(array('mode'=>'resend_lettre')).'">Renvoyer la lettre de mise à jour.</a><br>';
					$contenu_texte[] = '<br><a href="'.page_courante(array(),true).'">Retour aux mises à jour.</a><br>';
					$contenu_texte[] = '</div>';
				break;
				
			endswitch;
		endif;
	elseif(isset($_GET['maj_com_id'])):
		$maj_com_id = intval($_GET['maj_com_id']);
		$sql_com = new fp_enregistrement('codesgratis_coms',$maj_com_id,'com_id');
		if($sql_com->statut()):
			switch(@$_GET['mode']):
				case 'editer':
					if($sql_com->statut()):
						$contenu_texte[] = $sql_com;
					endif;
				break;
				case 'supprimer':
					$sql_maj = new fp_enregistrement('codesgratis_maj',$sql_com->com_type_id,'maj_id');
					if($sql_maj->statut()):
						$sql_com->delete();
						$sql_maj->maj_coms = sql_result('SELECT COUNT(com_id) FROM codesgratis_coms WHERE com_type_id = ' . $sql_maj->maj_id);
						$contenu_texte[] = 'Le commentaire N° ' . $sql_com->com_id .' de la mise à jour ' . $sql_com->com_type_id . ' a été supprimé.';
					endif;					
				break;
			endswitch;
		else:
			$contenu_texte[] = 'Le commentaire N°'.$maj_com_id.' n\'existe pas';
		endif;
		$contenu_texte[] = '<br><a href="'.page_courante(array('maj_id'=>$sql_com->com_type_id,'mode'=>'coms'),true).'">Retour aux mises à jour.</a><br>';
		$contenu_texte[] = '</div>';
	else:		
		$contenu_texte[] = '<div class="item_titre"><h1>Gestion des mises à jour</h1></div>';

		$retour = mysql_query('SELECT count(maj_id) FROM codesgratis_maj ORDER BY maj_id DESC');
		$maj_nombre = mysql_result($retour,0);
		if($maj_nombre > 0):

			$majs_page = 20;
		
			$pages_nombre  = ceil($maj_nombre / $majs_page);
			$str_pagination = pagination($pages_nombre);
			$contenu_texte = array_merge($contenu_texte, $str_pagination);

			$contenu_texte[] =' 			<table>';
			$contenu_texte[] ='				<tr>';
			$contenu_texte[] ='					<th>Titre</th>';
			$contenu_texte[] ='					<th>Auteur</th>';
			$contenu_texte[] ='					<th>Date</th>';
			$contenu_texte[] ='					<th>Commentaires</th>';
			$contenu_texte[] ='				</tr>';
		
			$limit = sql_limit($majs_page);
		
			$retour2 = mysql_query('SELECT * FROM codesgratis_maj ORDER BY maj_id DESC LIMIT '.$limit);				
			
			while($sql_maj = mysql_fetch_array($retour2)):								
				$contenu_texte[] = '<tr>';
				$contenu_texte[] = '<td><a href="maj.php?maj_id='.$sql_maj['maj_id'].'&amp;mode=edit">'. $sql_maj['maj_titre'] .'</a></td>';
				$contenu_texte[] = '<td>'. $sql_maj['maj_auteur'] .'</td>';
				$contenu_texte[] = '<td>Le '. date('d/m/Y', $sql_maj['maj_date']) .', à '. date('H\hi', $sql_maj['maj_date']) .'</td>';
				$contenu_texte[] = '<td><a href="maj.php?maj_id='.$sql_maj['maj_id'].'&amp;mode=coms">'. $sql_maj['maj_coms'] .' commentaires</td>';
				$contenu_texte[] = '</tr>';
			endwhile;
			$contenu_texte[] ='</table>';
			$contenu_texte = array_merge($contenu_texte, $str_pagination);
			$contenu_texte = array_merge($contenu_texte,new_maj());
		endif;	
		
		if(isset($_POST['submit_maj'])):
			$maj_auteur = trim($_POST['maj_auteur']);
			$maj_texte = trim($_POST['maj_texte']);
			$maj_titre = trim($_POST['maj_titre']);
			$sql = sql_insert
				(
					'codesgratis_maj',
					array
						(
							'maj_id' => 'NULL',
							'maj_auteur' => sql_champ_texte($maj_auteur),
							'maj_titre'=> sql_champ_texte($maj_titre),
							'maj_texte'=> sql_champ_texte($maj_texte),
							'maj_date'=> 'UNIX_TIMESTAMP()',
							'maj_coms'=>0,
						)
				)
			;
			if(mysql_query($sql)):
				$texte = lettre_mise_a_jour
					(
						'[CODESGRATIS] [Mise à jour N°' . $sql_maj->maj_id . '] ' . $sql_maj->maj_titre  ,
						
						array
						(
							bbcode_replace($sql_maj->maj_texte),
							'--------------------------------',						
							'Cette mise à jour a été postée sur le site de Codesgratis d\'Exostum sur lequel vous êtes inscrit. Si vous n\'arrivez pas à lire ce courriel voici le lien pour accéder directement à la mise à jour sur le site  : http://www.codesgratis.fr/index.php?maj_id=' . $sql_maj->maj_id ,
							'',
							'Vous pouvez à tout moment configurer votre compte pour arrêter de recevoir des courriels quand une mise à jour est postée sur le site Codesgratis d\'Exostum.',
							'',
							'--------------------------------',
						    'Final Lucyën Arkansérafin-Haylea',
							'Ce site est édité par Scelzo Patrick Jean (Auto-Entrepreneur).',
							'Code SIRET : 514 550 763 00015',
							'Code APE : 6201Z (Programmation Informatique)',
							'http://www.codesgratis.fr/',
							'http://www.exostum.net/'
						)
					)
				;
				$contenu_texte  = array_merge($contenu_texte,$texte);
				/**/
			else:
				echo mysql_error();
			endif;
		endif;	
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end_admin' . '.php');
else:
	//redirect('../connexion.php');
endif;
?>