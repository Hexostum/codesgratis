<?php 
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include_once(FP_CHEMIN_PHP . 'page_start' . '.php');

if($my_membre->membre_existe()):

	
	
	if(isset($_POST['submit_candidature'])):
		$clan_id = intval($_POST['clan_id']);
	
		$clan_postule = new fp_enregistrement('codesgratis_clans',$clan_id,'clan_id');
				
		if($clan_postule->statut()):
			if($clan_postule->membre_id!==$my_membre->membre_id):
				if(mysql_query('INSERT INTO codesgratis_clans_candidatures VALUES( '.$my_membre->membre_id.' , '. $clan_id .' )')):
			
					
					$contenu_texte[] = '<p style="color:green">Votre candidature au clan des '. $clan_postule->clan_nom .' a bien été enregistrée. Si elle est 
					acceptée, vous ferez immédiatement partie de ce clan. Sinon, vous ne recevrez pas de 
					nouvelle.</p>';
					
					$contenu_texte[] = '<p style="color:green">Si vous avez postulé à plusieurs clans, le premier à vous accepter sera celui auquel vous appartiendrez.</p>';
				else:
					$contenu_texte[] ='<p style="color:red">Vous avez déjà postulé à ce clan.</p>';		
				endif;
			else:
				$contenu_texte[] ='<p style="color:red">Heu, vous êtes déjà le fondateur de ce clan... (Je me demande si on va voir un jour ce message).</p>';
			endif;			
		else:
			$contenu_texte[] = '<p style="color:red">Le clan n\'existe pas.</p>';
		endif;
	endif;
			
	if(isset($_POST['submit_fonder'])):
		$clan = mysql_real_escape_string(strip_tags($_POST['nom_clan']));
		$motivation = mysql_real_escape_string(strip_tags($_POST['motivation_clan']));
				
		if
			( 
				mysql_num_rows(mysql_query('SELECT * FROM codesgratis_clans WHERE clan_nom=\''. $clan .'\'')) == 0 && 
				mysql_num_rows(mysql_query("SELECT * FROM codesgratis_clans WHERE membre_id={$my_membre->membre_id}")) == 0
			)
		:
			if(mysql_query('INSERT INTO codesgratis_clans VALUES( NULL , \''. $clan .'\', \''. $motivation .'\', '. $my_membre->membre_id .', '. time() .', 0 )')):
				$my_membre->membre_clan_id = mysql_insert_id();
				mysql_query('INSERT INTO codesgratis_forum_topics VALUES(\'\', \'9\', \''. $my_membre->membre_pseudo .'\', \''. $clan .'\', \''. $motivation .'\', \'\', \''. $my_membre->membre_pseudo .'\', \''. time() .'\')');
				mysql_query('DELETE FROM codesgratis_concours_clans_candidatures WHERE membre_id='. $my_membre->membre_id );
				header('Location: clans_gestion.php');
				exit();
			else:
				$contenu_texte[] = mysql_error();
			endif;
		else:
			$contenu_texte[] = '<p style="color:red">Le clan '. $clan .' existe déjà.</p>';
		endif;
	endif;
	
	$contenu_texte[] = '<h1>Les clans recruteurs sur CodesGratis</h1>';

	if(is_null($my_membre->membre_clan_id)):	
		$contenu_texte[] = '<p>Le tableau suivant liste les clans de CodesGratis qui ne sont pas encore au complet :</p>';
		$contenu_texte[] = '<table>';
		$contenu_texte[] = '<tr>';
		$contenu_texte[] = '<th>Clan</th>';
		$contenu_texte[] = '<th>Phrase de motivation</th>';
		$contenu_texte[] = '<th>Origine</th>';
		$contenu_texte[] = '<th>Joueurs du clan</th>';
		$contenu_texte[] = '<th>Nombre de points</th>';
		$contenu_texte[] = '<th>Action</th>';
		$contenu_texte[] = '</tr>';
		$retour = mysql_query('SELECT * FROM codesgratis_clans ORDER BY clan_points DESC');
				
		while($sql_clan = mysql_fetch_array($retour,MYSQL_ASSOC)):
			$clan_courant = new fp_enregistrement_sql($sql_clan,'codesgratis_clans','clan_id');
			if(!is_null($clan_courant->membre_id)):
				$joueurs_clan = '';
				$i = 1;					
				$retour2 = mysql_query("SELECT membre_pseudo FROM codesgratis_membres WHERE membre_clan_id=". $clan_courant->clan_id );
				echo mysql_error();
		
				if(mysql_num_rows($retour2) < 5):
					$joueurs_clan = array();
					while($donnees2 = mysql_fetch_array($retour2)):
						$joueurs_clan[]= trim($donnees2['membre_pseudo']);
					endwhile;

					$contenu_texte[] = '<tr>';
					$contenu_texte[] = '<td>' . stripslashes($clan_courant->clan_nom).'</td>';
					$contenu_texte[] = '<td>' . stripslashes($clan_courant->clan_motivation).'</td>';
					$contenu_texte[] = '<td>Fondé par ' . stripslashes($clan_courant->membre_id).', ' . 'le '. date('d/m/Y à H\hi',$clan_courant->clan_fondation).'.</td>';
					$contenu_texte[] = '<td>' . implode(' , ',$joueurs_clan).'</td>';
					$contenu_texte[] = '<td>' . $clan_courant->clan_points.'</td>';
					$contenu_texte[] = '<td>';
					$contenu_texte[] = '<form method="post" action="clans_recrutement.php">';
					$contenu_texte[] = '<input type="hidden" name="clan_id" value="' . $clan_courant->clan_id.'">';
					$contenu_texte[] = '<input type="submit" id="submit_candidature" name="submit_candidature" value="Postuler à ce clan">';
					$contenu_texte[] = '</form>';
					$contenu_texte[] = '</td>';
					$contenu_texte[] = '</tr>';

				endif;
			endif;
		endwhile;

		$contenu_texte[] = '</table>';
				
		$contenu_texte[] = '<br>';
		$contenu_texte[] = '<br>';
		$contenu_texte[] = '<br>';
				
		$contenu_texte[] = '<p>Ou bien peut-être voulez-vous fonder votre propre clan ? Alors, entrez seulement le nom de ';
		$contenu_texte[] = 'votre clan et une phrase de motivation, cliquez sur le bouton, et c\'est parti pour l\'aventure !</p>';
				
		$contenu_texte[] = '<center>';
		$contenu_texte[] = '<form method="post" action="clans_recrutement.php">';
		$contenu_texte[] = '<label for="nom_clan">Nom de votre clan : </label><input type="text" name="nom_clan" maxlength="100">';
		$contenu_texte[] = '<br>';
		$contenu_texte[] = '<label for="motivation_clan">Phrase de motivation :</label>';
		$contenu_texte[] = '<br>';
		$contenu_texte[] = '<input type="text" name="motivation_clan" maxlength="255">';
		$contenu_texte[] = '<br>';
		$contenu_texte[] = '<input type="submit" id="submit_fonder" name="submit_fonder" value="Fonder ce clan">';
		$contenu_texte[] = '</form>';
		$contenu_texte[] = '</center>';
	else:
		$contenu_texte[] = '<p>Vous faites déjà partie d\'un clan </p>';
	endif;
	include_once(FP_CHEMIN_PHP . 'page_end' . '.php');
else:
	header('Location: connexion.php');
endif;
?>