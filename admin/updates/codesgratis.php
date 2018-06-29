<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	$utilisateur = sql_result("SELECT utilisateur, count( * ) AS cte
FROM codesgratis_cgcodes
WHERE code 
REGEXP '^CGRATIS[A-Z0-9]+' AND
 OK=0 AND utilisateur is not null
GROUP BY utilisateur
ORDER BY cte ASC 
LIMIT 1");
	echo $utilisateur;
	if($utilisateur!=''):
		$sql = 'SELECT membre_id FROM codesgratis_membres WHERE membre_pseudo=\''.trim($utilisateur).'\' ';
		$membre_id =  sql_result($sql) ;
		if($membre_id==''):
			$membre_id=0;
		endif;
		$true = true;
		if($membre_id>=0):
			$res = mysql_query('SELECT * FROM codesgratis_cgcodes WHERE code REGEXP \'^CGRATIS[A-Z0-9]+\' AND OK=0 AND utilisateur=\''.$utilisateur.'\' LIMIT 20 ');
			echo mysql_error();
			while($sql_code = mysql_fetch_array($res,MYSQL_ASSOC)):
		
		
				$date = $sql_code['date_validation'] ;
				$code = "'".$sql_code['code']."'";
		
					$sql = 'INSERT INTO codesgratis_code VALUES( NULL , '.$code.' , 	'.FP_CGRATIS.'  , 	'.$membre_id.'  , 	'.$date.'  ,	'.$date.', NULL ) ';
					if(mysql_query($sql)):
						mysql_query('UPDATE codesgratis_cgcodes SET OK=1 WHERE code = ' . $code);
						echo $code , 'OK';
				
					else:
						$true=false;
						echo $sql;
						echo mysql_error();
					endif;
		
				
				echo FP_LIGNE . '<br><hr>';
			endwhile;
			if($true):
				echo '<script type="text/javascript">function reload() {window.location.reload();} window.onload = reload;</script>';
			endif;
		else:
				$true=false;
				echo $sql;
				echo mysql_error();
		endif;
	endif;
endif;
?>