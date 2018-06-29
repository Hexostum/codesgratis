<?php
html_admin
	(
		array
		(
			'page_titre' => $page_titre,
			/**
			'contenu_menu' => format_texte(menu_admin(),3),
			'contenu_pied' => format_texte(pied_admin(),2),			
			**/
			'contenu_texte' => 	format_texte($contenu_texte,3),
			'contenu_script' => format_texte($contenu_script,2)
		)
	)
;
?>