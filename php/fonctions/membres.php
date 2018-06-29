<?php
$GLOBALS['avatar_id']=0;

function option($my_membre,$option)
{
	$options = $my_membre->membre_options;
	if(strstr($options,$option)):
		return true;
	else:
		return false;
	endif;
}

function set_option($my_membre,$option)
{
	if(!option($my_membre,$option)):
		$my_membre->membre_options = $my_membre->membre_options . ' ' . $option;
	endif;
}

function remove_option($my_membre,$option)
{
	if(option($my_membre,$option)):
		$my_membre->membre_options = str_replace($option,'',$my_membre->membre_options);
	endif;
}

function membre_avatar($my_membre,$statut_lien=true)
{
	
	if
		(
			$my_membre->membre_avatar==''
		)
	:
		$avatar = 'http://images.exostum.net/avatars/100_100/no_avatar.png' ;
	else:
		$avatar = $my_membre->membre_avatar . '?' .  $GLOBALS['avatar_id']++;
	endif;
	if($statut_lien):
		return '<div class="membre_avatar"><a href="membre.php?_membre_id='.$my_membre->membre_id.'"><img src="'.$avatar.'" alt="avatar" width="100" height="100"></a></div>';	
	else:
		return '<div class="membre_avatar"><img src="'.$avatar.'" alt="avatar" width="100" height="100"></div>';	
	endif;
}

function membre_pseudo($membre_id,$statut_lien=true)
{
	
	if($statut_lien):
		return '<div class="membre_pseudo"><a href="membre.php?_membre_id='.$membre_id.'">' .$GLOBALS['cache_membre_pseudo'][$membre_id] . '</a></div>';	
	else:
		return '<div class="membre_pseudo">' .$GLOBALS['cache_membre_pseudo'][$membre_id] . '</div>';	
	endif;
}

function membre_vip ($cet_auteur)
{
	$texte = array();
	if(!is_admin($cet_auteur)):
		if($cet_auteur->membre_vip > 0):
			$texte[] = '<img src="html/images/vip/vip' . $cet_auteur->membre_vip . '.png" alt="V.I.P. '. $cet_auteur->membre_vip . '">';	
		else:
			$texte[] = '<img src="html/images/vip/non_vip.png" alt="Non V.I.P.">';
		endif;
	endif;
	if(is_modo($cet_auteur)):						
		$texte[] = '<img src="html/images/forum_statut_modo.png" alt="Modérateur">';
	elseif(is_admin($cet_auteur)):
		$texte[] = '<img src="html/images/forum_statut_admin.png" alt="Administrateur">';
	endif;
	return $texte;
}
?>