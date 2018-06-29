<?php
function hasard_recapitulatif(&$contenu_texte,fp_membre $membre)
{
	if($membre->membre_existe()):
		$tickets_page = 50;
		$retour = mysql_query('SELECT count(membre_id) as nbre FROM codesgratis_jeu_hasard WHERE membre_id='.$membre->membre_id);
		$nbre = mysql_result($retour,0);
		$str_pagination = pagination(ceil($nbre / $tickets_page));
		
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
		
		$contenu_texte[] = '<div class="historique" id="historique_jeu_hasard">';
		$contenu_texte[] = '	<table>';
		$contenu_texte[] = '		<tr>';
		$contenu_texte[] = '			<th colspan="3">Tickets utilisés au jeu de hasard.</th>';
		$contenu_texte[] = '		</tr>';
		$contenu_texte[] = '		<tr>';
		$contenu_texte[] = '			<td>Numéro du ticket</td>';
		$contenu_texte[] = '			<td>Gain</td>';
		$contenu_texte[] = '			<td>Date</td>';
		$contenu_texte[] = '		</tr>';
		
		if(isset($_GET['page'])):
			$_start = $_GET['page'] * $tickets_page;
			$_limit = $tickets_page;
		else:
			$_start = 0;
			$_limit = $tickets_page;
		endif;
		$limit = $_start . ' , ' . $_limit;
		$retour = mysql_query('SELECT * FROM codesgratis_jeu_hasard WHERE membre_id='.$membre->membre_id.' ORDER BY jeu_date DESC LIMIT ' .$limit);
		if(is_resource($retour)):
			while($un_ticket  = mysql_fetch_array($retour)):
				$contenu_texte[] = '<tr>';
				$contenu_texte[] = '<td>' . 'S' . $un_ticket['jeu_session'] . '_T' . sprintf("%03s",$un_ticket['jeu_ticket']) .'</td>';
				$contenu_texte[] = '<td>' . $un_ticket['jeu_gain'] . '</td>';
				$contenu_texte[] = '<td>' . date('d/m/Y à H\hi:s',$un_ticket['jeu_date']) . '</td>';
				$contenu_texte[] = '</tr>';
			endwhile;
		endif;
		$contenu_texte[] = '</table>';
		$contenu_texte[] = '</div>';
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
	endif;
}
function hasard_recapitulatif_complet(&$contenu_texte)
{
	$tickets_page = 50;
	
	$retour = mysql_query('SELECT count(membre_id) as nbre FROM codesgratis_jeu_hasard');
		$nbre = mysql_result($retour,0);
		$str_pagination = pagination(ceil($nbre / $tickets_page));
		
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
		
		$contenu_texte[] = '<div class="historique" id="historique_jeu_hasard">';
		$contenu_texte[] = '	<table>';
		$contenu_texte[] = '		<tr>';
		$contenu_texte[] = '			<th colspan="3">Tickets utilisés au jeu de hasard.</th>';
		$contenu_texte[] = '		</tr>';
		$contenu_texte[] = '		<tr>';
		$contenu_texte[] = ' 			<td>Membre ID</td>';
		$contenu_texte[] = '			<td>Numéro du ticket</td>';
		$contenu_texte[] = '			<td>Gain</td>';
		$contenu_texte[] = '			<td>Date</td>';
		$contenu_texte[] = '		</tr>';
		
		if(isset($_GET['page'])):
			$_start = $_GET['page'] * $tickets_page;
			$_limit = $tickets_page;
		else:
			$_start = 0;
			$_limit = $tickets_page;
		endif;
		$limit = $_start . ' , ' . $_limit;
		$retour = mysql_query('SELECT * FROM codesgratis_jeu_hasard ORDER BY jeu_date DESC LIMIT ' .$limit);
		if(is_resource($retour)):
			while($un_ticket  = mysql_fetch_array($retour)):
				$contenu_texte[] = '<tr>';
				$contenu_texte[] = '<td><a href="'.FP_PAGE . '?' . http_build_query( array( 'membre_id' => $un_ticket['membre_id']))  .'">' . $un_ticket['membre_id'] . '</a></td>';
				$contenu_texte[] = '<td>' . 'S' . $un_ticket['jeu_session'] . '_T' . sprintf("%03s",$un_ticket['jeu_ticket']) .'</td>';
				$contenu_texte[] = '<td>' . $un_ticket['jeu_gain'] . '</td>';
				$contenu_texte[] = '<td>' . date('d/m/Y à H\hi:s',$un_ticket['jeu_date']) . '</td>';
				$contenu_texte[] = '</tr>';
			endwhile;
		endif;
		$contenu_texte[] = '</table>';
		$contenu_texte[] = '</div>';
		$contenu_texte = array_merge($contenu_texte,$str_pagination);
}
function hasard_stat(&$contenu_texte)
{
	$res_sql = mysql_query('SELECT jeu_gain, count(jeu_gain) as nbre FROM codesgratis_jeu_hasard GROUP BY jeu_gain');
	$total = 0;
	$gains = array( 25=>0, 50 => 0 , 100 =>0 , 500=>0 , 1000 => 0  );
	$gains_total=0;
	$depenses = 0;
	while($gain = mysql_fetch_array($res_sql,MYSQL_ASSOC)):
		$gains[$gain['jeu_gain']] = $gain['nbre'];
		$total += $gain['nbre'];
		$gains_total += $gain['jeu_gain'] * $gain['nbre'];
		$depenses += 40 * $gain['nbre'];
	endwhile;
	$stat = array( 25=>0, 50 => 0 , 100 =>0 , 500=>0 , 1000 => 0  );
	if($depenses > 0):
		foreach($gains as $clef => $valeur):
			$stat[$clef] = number_format((($valeur / $total) * 100), 2, ',', ' ');
		endforeach;
		$taux = number_format( (($gains_total/$depenses)*100) , 2 , ',' , ''  );
	else:
		$taux=0;
	endif;

	$contenu_texte[] = '	<div class="stat" id="stat_jeu_hasard">';
	$contenu_texte[] = '	<table>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<th colspan="2">Statistiques du jeu de hasard</th>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>Gain</td>';
	$contenu_texte[] = '			<td>%</td>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>25</td>';
	$contenu_texte[] = '			<td>' . $stat[25]. '</td>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>50</td>';
	$contenu_texte[] = '			<td>' . $stat[50]. '</td>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>100</td>';
	$contenu_texte[] = '			<td>' . $stat[100]. '</td>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>500</td>';
	$contenu_texte[] = '			<td>' . $stat[500]. '</td>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>1000</td>';
	$contenu_texte[] = '			<td>' . $stat[1000]. '</td>';
	$contenu_texte[] = '		</tr>';	
	$contenu_texte[] = '		<tr>';
	$contenu_texte[] = '			<td>Taux de reversement</td>';
	$contenu_texte[] = '			<td>' . $taux. '</td>';
	$contenu_texte[] = '		</tr>';
	$contenu_texte[] = '	</table>';
	$contenu_texte[] = '	</div>';

}
?>