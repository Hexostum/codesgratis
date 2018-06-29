<?php
function format_texte($array,$indent=0)
{
	return FP_LIGNE . str_repeat(FP_TAB,$indent) . implode(FP_LIGNE . str_repeat(FP_TAB,$indent) , $array) . FP_LIGNE . @str_repeat(FP_TAB,$indent-1);
}
?>