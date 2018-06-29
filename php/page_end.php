<?php
html
	(
		array
		(
			'page_titre' => $page_titre,
			'contenu_menu' => format_texte(menu(),3),
			'contenu_pied' => format_texte(pied(),2),
			'contenu_pub' => format_texte(pub($afficher_pub),3),
			'contenu_texte' => 	format_texte($contenu_texte,3),
			'contenu_script' => format_texte($contenu_script,2)
		)
	)
;
?>