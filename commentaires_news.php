<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');

if(isset($_GET['maj_id'])):
	$maj_id = intval($_GET['maj_id']);
	if($maj_id==$_GET['maj_id']):
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: index.php?maj_id='.$maj_id);
		header('Connection: close');
		exit();
	else:
		header('HTTP/1.1 404 Page Not Found');
		exit();	
	endif;				
else:
	header('HTTP/1.1 404 Page Not Found');
	exit();
endif;
?>