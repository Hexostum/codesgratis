<?php
define('FP_MESSAGE_ERROR','message_erreur');
define('FP_MESSAGE_INFOS','message_informations');
define('FP_MESSAGE_QUESTION','message_question');
define('FP_MESSAGE_REPONSE','message_reponse');
function message($message_texte, $message_type)
{
	return '<div class="'.$message_type.'">' . $message_texte . '</div>';
}
function message_admin($message_texte, $message_type)
{
	$test_membre = $GLOBALS['my_membre'];
	if
		(
			is_admin($test_membre)
		)
	:
		return message ( $message_texte , $message_type);
	else:
		return null;
	endif;
}
?>