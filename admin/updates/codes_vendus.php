<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start_admin' . '.php');
if(is_admin($my_membre)):
	$code = @sql_result("SELECT code
FROM codesgratis_cgcodes_plus
WHERE OK=0 AND utilisateur is null
LIMIT 1");
	echo $code;
	echo mysql_error();
	if($code!=''):
		$sql = 'INSERT INTO codesgratis_codes VALUES( NULL , \''.$code.'\' , 	'.FP_CGCODESPLUS.'  , 	NULL  , NULL , NULL , NULL ) ';
		if(mysql_query($sql)):
			mysql_query('UPDATE codesgratis_cgcodes_plus SET OK=1 WHERE code = \'' . $code. '\'');
			echo $code , 'OK';
			$true=true;
		else:
			$true=false;
			echo $sql;
			echo mysql_error();
		endif;
		if($true):
			echo '<script type="text/javascript">function reload() {window.location.reload();} window.onload = reload;</script>';
		endif;
	endif;
endif;
?>