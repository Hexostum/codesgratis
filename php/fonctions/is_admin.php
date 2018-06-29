<?php
function is_admin($my_membre)
{
if(is_object($my_membre)):
	if($my_membre->statut()):
		if($my_membre->membre_id==0):
			return true;
		else:
			return false;
		endif;
	else:
		return false;
	endif;
else:
	return false;
endif;
}
?>