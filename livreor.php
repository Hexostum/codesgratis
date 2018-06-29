<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

$page_titre = 'Livre d\'or';
$contenu_texte[] = '<h1>Le livre d\'or de CodesGratis</h1>';


$infos = sql_limiteur
	(
		array
		(
			'unit_par_page'=>30,
			'table'=>'codesgratis_coms',
			'table_compteur'=>'com_id',
			'where_condition'=> 
				array
				(
					 0=> array( 'champ' => 'com_type' , 'valeur'=>'livredor','condition' => '=','valeur_type'=>'texte' )
				)
		)
	)
;
if(isset($_GET['page'])):
	if
	(
		@intval($_GET['page']) > $infos['unit_pages']
	)
	:
		header('Location: livreor.php');
		exit();
	endif;
	if
		(
			intval($_GET['page'])==0
		)
	:
		header('Location: livreor.php');
		exit();
	else:
		$page_titre .= ' [page : '.(intval($_GET['page'])+1).'] ';
	endif;
else:
	$page_titre .= ' [première page]';
endif;

				
//Si le membre laisse un message

if(isset($_POST['submit_com'])):
	$retour = mysql_query('SELECT * FROM codesgratis_coms WHERE com_type=\'livredor\' ORDER BY com_id DESC');
	$sql_last_com = mysql_fetch_array($retour);
				
	$com_message = mysql_real_escape_string(strip_tags(stripslashes(trim($_POST['com_message']))));
					
	if 
		(
			( $sql_last_com['membre_id'] == $my_membre->membre_id ) && 
			( $sql_last_com['com_texte'] == $com_message )
		)
	: 
		$sauvegarde_champ_message = stripslashes($com_message);
		$com_message = ''; 
	endif;

	if($com_message != ''):
		$sql = 'INSERT INTO codesgratis_coms VALUES("livredor", NULL , NULL , '. $my_membre->membre_id .', "'. $com_message .'", "'. time() .'" )';
		if(mysql_query($sql)):
			$contenu_texte[] = '<p>Votre message a bien été enregistré ! Merci de votre participation !</p>';
		else:
			$contenu_texte[] =  $sql;
			$contenu_texte[] =  '<p>Votre message n\'a pas été enregistré pour la raison suivante : ['.mysql_error().']';
		endif;
	endif;
endif;

$sql_coms = array();

$retour = mysql_query('SELECT * FROM codesgratis_coms WHERE com_type=\'livredor\' ORDER BY com_id DESC LIMIT '. $infos['limit']);
if(mysql_num_rows($retour) >= 1):
	include_once(FP_CHEMIN_FONCTIONS . 'bbcode.php');
	$sql_coms_ids = array();
	while($sql_com = mysql_fetch_array($retour)):
		$sql_coms[] = $sql_com;
		$sql_coms_ids[$sql_com['membre_id']] = $sql_com['membre_id'];
	endwhile;
else:
	$contenu_texte[] = 'Soyez le premier à signer le livre d\'or de CodesGratis ! (inscription requise)<br />';
endif;

if(count($sql_coms)>0):
	$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
	$liste_membre = sql_list
		(
			array
			(
				'table'=>'codesgratis_membres',
				'table_id'=>'membre_id',
				'liste'=>$sql_coms_ids
			)
		)
	;
	foreach($sql_coms as $sql_com):
		if(isset($liste_membre[$sql_com['membre_id']])):
			$contenu_texte[] = '<table>';
			$contenu_texte[] = '<tr><th colspan="2">' . format_date($sql_com['com_date']) .'</th></tr>';
			$contenu_texte[] = '<tr><td rowspan="2" width="100">';
			$contenu_texte[] = membre_pseudo( $liste_membre[$sql_com['membre_id']]->membre_id );
			$contenu_texte[] = membre_avatar( $liste_membre[$sql_com['membre_id']]);
			$contenu_texte = array_merge($contenu_texte , membre_vip( $liste_membre[$sql_com['membre_id']]));
			$contenu_texte[] = '</td></tr>';
			$contenu_texte[] = '<tr><td>' . bbcode_replace(stripslashes($sql_com['com_texte'])) . '</td></tr>';
			$contenu_texte[] = '<tr><td colspan="2">' . bbcode_replace(stripslashes($liste_membre[$sql_com['membre_id']]->membre_signature)) . '</td></tr>';
			$contenu_texte[] = '</table>';
		endif;
	endforeach;
	$contenu_texte = array_merge($contenu_texte,$infos['pagination']);
endif;	

if($my_membre->membre_existe()):
	$contenu_texte[] = '<table>';
	$contenu_texte[] = '<tr><th>Signer le livre d\'or :</th></tr>';
							
	$contenu_texte[] = '<form method="post" action="livreor.php">';
	$contenu_texte[] = '<tr><td><p id="com_message_infos"></p></td></tr>';
	$contenu_texte[] = '<tr><td><textarea class="bbcode" name="com_message" id="com_message" style="width:60%;height:150px;font-family:\'Comic sans MS\',serif;font-size:10pt;font-color:#8d8d8d;">' .  @$sauvegarde_champ_message. '</textarea></tr></td>';
								
	
								
	$contenu_texte[] = '<tr><td><input type="submit" id="submit_com" name="submit_com" value="Signer le livre !"></td></tr>';
	$contenu_texte[] = '</form>';
	$contenu_texte[] = '</table>';

endif;
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/getElementsByClassName.js"></script>';
$contenu_script [] = '<script type="text/javascript" src="html/javascripts/bbcode.js"></script>';

include(FP_CHEMIN_PHP . 'page_end' . '.php');
?>