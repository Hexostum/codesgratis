<?php
function format_date($timestamp,$null='N/A')
{
	if($timestamp==0):
		return $null;
	else:
		return date('d/m/Y H\hi\:s',$timestamp);
	endif;
}
?>