<?php
function bbcode_replace($texte)
{
	$texte = trim($texte);
	$texte = strip_tags($texte);
	//Pour mettre le message en gras :
	$texte = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $texte);
	$texte = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $texte);
	$texte = preg_replace('#\[u\](.+)\[/u\]#isU', '<span style="text-decoration:underline;">$1</span>', $texte);
	$texte = preg_replace('#(?:\[c(?:olor)?[:=](red|green|blue|purple|yellow|olive|yellowgreen|white|turquoise|teal|pink|orange|navy|magenta|indigo|gold|fuchsia|gray|cyan|chocolate|brown|black|aqua)\])(.+)(?:\[/c(?:olor)?(?:=(?:5|(?:$1)))?\])#isU', '<span style="color:$1">$2</span>'
		, $texte);
	$texte = preg_replace('#\[c(?:olor)?[:=](\#[0-9a-f]{6})\](.+)\[/c(?:olor)?(?:[:=](\#[0-9a-f]{6}))?\]#isU', '<span style="color:$1">$2</span>', $texte);
	$texte = preg_replace('#\[c(?:olor)?[:=]0\](.+)\[/c(?:olor)?(?:[:=]0)?\]#isU', '<span style="color:black">$1</span>', $texte); 	//Le blanc :
	$texte = preg_replace('#\[c(?:olor)?[:=]1\](.+)\[/c(?:olor)?(?:[:=]1)?\]#isU', '<span style="color:white">$1</span>', $texte); 	//Bleu fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]2\](.+)\[/c(?:olor)?(?:[:=]2)?\]#isU', '<span style="color:navy">$1</span>', $texte); 	//Vert :
	$texte = preg_replace('#\[c(?:olor)?[:=]3\](.+)\[/c(?:olor)?(?:[:=]3)?\]#isU', '<span style="color:green">$1</span>', $texte); 	//Rouge :
	$texte = preg_replace('#\[c(?:olor)?[:=]4\](.+)\[/c(?:olor)?(?:[:=]4)?\]#isU', '<span style="color:red">$1</span>', $texte); 	//Rouge fonc (maroon) :
	$texte = preg_replace('#\[c(?:olor)?[:=]5\](.+)\[/c(?:olor)?(?:[:=]5)?\]#isU', '<span style="color:maroon">$1</span>', $texte); 	//#ee82ee/Magenta fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]6\](.+)\[/c(?:olor)?(?:[:=]6)?\]#isU', '<span style="color:#8b008b">$1</span>', $texte); 	//Orange fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]7\](.+)\[/c(?:olor)?(?:[:=]7)?\]#isU', '<span style="color:#ff8c00">$1</span>', $texte);	//Jaune :
	$texte = preg_replace('#\[c(?:olor)?[:=]8\](.+)\[/c(?:olor)?(?:[:=]8)?\]#isU', '<span style="color:yellow">$1</span>', $texte); 	//Vert fluo :
	$texte = preg_replace('#\[c(?:olor)?[:=]9\](.+)\[/c(?:olor)?(?:[:=]9)?\]#isU', '<span style="color:lime">$1</span>', $texte); 	//Bleu-vert (#008b8b, le plus fort des hroooos xD)
	$texte = preg_replace('#\[c(?:olor)?[:=]10\](.+)\[/c(?:olor)?(?:[:=]10)?\]#isU', '<span style="color:#008b8b">$1</span>', $texte); 	//Cyan :
	$texte = preg_replace('#\[c(?:olor)?[:=]11\](.+)\[/c(?:olor)?(?:[:=]11)?\]#isU', '<span style="color:aqua">$1</span>', $texte); 	//Bleu :
	$texte = preg_replace('#\[c(?:olor)?[:=]12\](.+)\[/c(?:olor)?(?:[:=]12)?\]#isU', '<span style="color:blue">$1</span>', $texte); 	//Fuchsia :
	$texte = preg_replace('#\[c(?:olor)?[:=]13\](.+)\[/c(?:olor)?(?:[:=]13)?\]#isU', '<span style="color:fuchsia">$1</span>', $texte); 	//Gris (fonc) :
	$texte = preg_replace('#\[c(?:olor)?[:=]14\](.+)\[/c(?:olor)?(?:[:=]14)?\]#isU', '<span style="color:gray">$1</span>', $texte); 	//Gris clair :
	$texte = preg_replace('#\[c(?:olor)?[:=]15\](.+)\[/c(?:olor)?(?:[:=]15)?\]#isU', '<span style="color:#d3d3d3">$1</span>', $texte); 	//Gris encore plus clair :
	$texte = preg_replace('#\[c(?:olor)?[:=]16\](.+)\[/c(?:olor)?(?:[:=]16)?\]#isU', '<span style="color:#dcdcdc">$1</span>', $texte); 	//Gris clair 'le mme que le 15 mais faut bien afficher ce que a affiche xD) :
	$texte = preg_replace('#\[c(?:olor)?[:=]17\](.+)\[/c(?:olor)?(?:[:=]17)?\]#isU', '<span style="color:#d3d3d3">$1</span>', $texte); 	//Saumon :
	$texte = preg_replace('#\[c(?:olor)?[:=]18\](.+)\[/c(?:olor)?(?:[:=]18)?\]#isU', '<span style="color:#ffdead">$1</span>', $texte); 	//Rose clair  la "rose saumon" :
	$texte = preg_replace('#\[c(?:olor)?[:=]19\](.+)\[/c(?:olor)?(?:[:=]19)?\]#isU', '<span style="color:#ffb6c1">$1</span>', $texte); 	//Rose ple (c'est du #ee82ee clair mais bon xD) :
	$texte = preg_replace('#\[c(?:olor)?[:=]20\](.+)\[/c(?:olor)?(?:[:=]20)?\]#isU', '<span style="color:#ee82ee">$1</span>', $texte); 	//#ee82ee clair :
	$texte = preg_replace('#\[c(?:olor)?[:=]21\](.+)\[/c(?:olor)?(?:[:=]21)?\]#isU', '<span style="color:#ee82ee">$1</span>', $texte); 	//Turquoise ple :
	$texte = preg_replace('#\[c(?:olor)?[:=]22\](.+)\[/c(?:olor)?(?:[:=]22)?\]#isU', '<span style="color:#afeeee">$1</span>', $texte); 	//Vert ple :
	$texte = preg_replace('#\[c(?:olor)?[:=]23\](.+)\[/c(?:olor)?(?:[:=]23)?\]#isU', '<span style="color:#98fb98">$1</span>', $texte); 	//Jaune ple :
	$texte = preg_replace('#\[c(?:olor)?[:=]24\](.+)\[/c(?:olor)?(?:[:=]24)?\]#isU', '<span style="color:#eee8aa">$1</span>', $texte); 	//Gris-argent :
	$texte = preg_replace('#\[c(?:olor)?[:=]25\](.+)\[/c(?:olor)?(?:[:=]25)?\]#isU', '<span style="color:silver">$1</span>', $texte); 	//Gris-gris fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]26\](.+)\[/c(?:olor)?(?:[:=]26)?\]#isU', '<span style="color:#a9a9a9">$1</span>', $texte); 	//Orange ple :
	$texte = preg_replace('#\[c(?:olor)?[:=]27\](.+)\[/c(?:olor)?(?:[:=]27)?\]#isU', '<span style="color:#f4a460">$1</span>', $texte); 	//Rose/rouge/saumon :
	$texte = preg_replace('#\[c(?:olor)?[:=]28\](.+)\[/c(?:olor)?(?:[:=]28)?\]#isU', '<span style="color:#fa8072">$1</span>', $texte); 	//Rose :
	$texte = preg_replace('#\[c(?:olor)?[:=]29\](.+)\[/c(?:olor)?(?:[:=]29)?\]#isU', '<span style="color:#ee82ee">$1</span>', $texte); 	//Bleu-#ee82ee :
	$texte = preg_replace('#\[c(?:olor)?[:=]30\](.+)\[/c(?:olor)?(?:[:=]30)?\]#isU', '<span style="color:#7b68ee">$1</span>', $texte); 	//Turquoise clair/marine :
	$texte = preg_replace('#\[c(?:olor)?[:=]31\](.+)\[/c(?:olor)?(?:[:=]31)?\]#isU', '<span style="color:#7fffd4">$1</span>', $texte); 	//Vert clair :
	$texte = preg_replace('#\[c(?:olor)?[:=]32\](.+)\[/c(?:olor)?(?:[:=]32)?\]#isU', '<span style="color:#90ee90">$1</span>', $texte); 	//Jaune un peu ple :
	$texte = preg_replace('#\[c(?:olor)?[:=]33\](.+)\[/c(?:olor)?(?:[:=]33)?\]#isU', '<span style="color:#f9ff57">$1</span>', $texte); 	//Gris (encore !!) :
	$texte = preg_replace('#\[c(?:olor)?[:=]34\](.+)\[/c(?:olor)?(?:[:=]34)?\]#isU', '<span style="color:gray">$1</span>', $texte); 	//Gris (... et encore ...) :
	$texte = preg_replace('#\[c(?:olor)?[:=]35\](.+)\[/c(?:olor)?(?:[:=]35)?\]#isU', '<span style="color:gray">$1</span>', $texte); 	//Orange (normal) :
	$texte = preg_replace('#\[c(?:olor)?[:=]36\](.+)\[/c(?:olor)?(?:[:=]36)?\]#isU', '<span style="color:orange">$1</span>', $texte); 	//Rouge/orange :
	$texte = preg_replace('#\[c(?:olor)?[:=]37\](.+)\[/c(?:olor)?(?:[:=]37)?\]#isU', '<span style="color:#ff4500">$1</span>', $texte); 	//Fuchsia (et oui, encore xD) :
	$texte = preg_replace('#\[c(?:olor)?[:=]38\](.+)\[/c(?:olor)?(?:[:=]38)?\]#isU', '<span style="color:fuchsia">$1</span>', $texte); 	//Bleu (marine normalement mais bleu) :
	$texte = preg_replace('#\[c(?:olor)?[:=]39\](.+)\[/c(?:olor)?(?:[:=]39)?\]#isU', '<span style="color:blue">$1</span>', $texte); 	//Vert-turquoise :
	$texte = preg_replace('#\[c(?:olor)?[:=]40\](.+)\[/c(?:olor)?(?:[:=]40)?\]#isU', '<span style="color:#00fa9a">$1</span>', $texte); 	//Vert clair / vers le fluo :
	$texte = preg_replace('#\[c(?:olor)?[:=]41\](.+)\[/c(?:olor)?(?:[:=]41)?\]#isU', '<span style="color:#7cfc00">$1</span>', $texte); 	//Jaune xD :
	$texte = preg_replace('#\[c(?:olor)?[:=]42\](.+)\[/c(?:olor)?(?:[:=]42)?\]#isU', '<span style="color:yellow">$1</span>', $texte); 	//Gris (#696969) :
	$texte = preg_replace('#\[c(?:olor)?[:=]43\](.+)\[/c(?:olor)?(?:[:=]43)?\]#isU', '<span style="color:#696969">$1</span>', $texte); 	//Gris (pareil xD) :
	$texte = preg_replace('#\[c(?:olor)?[:=]44\](.+)\[/c(?:olor)?(?:[:=]44)?\]#isU', '<span style="color:#696969">$1</span>', $texte); 	//Ocre :
	$texte = preg_replace('#\[c(?:olor)?[:=]45\](.+)\[/c(?:olor)?(?:[:=]45)?\]#isU', '<span style="color:#daa520">$1</span>', $texte); 	//Rouge :
	$texte = preg_replace('#\[c(?:olor)?[:=]46\](.+)\[/c(?:olor)?(?:[:=]46)?\]#isU', '<span style="color:red">$1</span>', $texte); 	//Rose / fuchsia :
	$texte = preg_replace('#\[c(?:olor)?[:=]47\](.+)\[/c(?:olor)?(?:[:=]47)?\]#isU', '<span style="color:fuchsia">$1</span>', $texte);	//Bleu indigo :
	$texte = preg_replace('#\[c(?:olor)?[:=]48\](.+)\[/c(?:olor)?(?:[:=]48)?\]#isU', '<span style="color:#0000cd">$1</span>', $texte);	//Vert "d'eau" :
	$texte = preg_replace('#\[c(?:olor)?[:=]49\](.+)\[/c(?:olor)?(?:[:=]49)?\]#isU', '<span style="color:#02cc88">$1</span>', $texte);	//Vert olive :
	$texte = preg_replace('#\[c(?:olor)?[:=]50\](.+)\[/c(?:olor)?(?:[:=]50)?\]#isU', '<span style="color:#58d80c">$1</span>', $texte);	//Vert olive plus fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]51\](.+)\[/c(?:olor)?(?:[:=]51)?\]#isU', '<span style="color:#49b00a">$1</span>', $texte);	//Noir clair :
	$texte = preg_replace('#\[c(?:olor)?[:=]52\](.+)\[/c(?:olor)?(?:[:=]52)?\]#isU', '<span style="color:#333335">$1</span>', $texte);	//Noir clair (ouais encore xD) :
	$texte = preg_replace('#\[c(?:olor)?[:=]53\](.+)\[/c(?:olor)?(?:[:=]53)?\]#isU', '<span style="color:#333335">$1</span>', $texte);	//Marron :
	$texte = preg_replace('#\[c(?:olor)?[:=]54\](.+)\[/c(?:olor)?(?:[:=]54)?\]#isU', '<span style="color:#8b4513">$1</span>', $texte);	//Rouge Bordeaux :
	$texte = preg_replace('#\[c(?:olor)?[:=]55\](.+)\[/c(?:olor)?(?:[:=]55)?\]#isU', '<span style="color:#8b0000">$1</span>', $texte);	//#ee82ee / magenta fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]56\](.+)\[/c(?:olor)?(?:[:=]56)?\]#isU', '<span style="color:#8b008b">$1</span>', $texte);	//Bleu marine :
	$texte = preg_replace('#\[c(?:olor)?[:=]57\](.+)\[/c(?:olor)?(?:[:=]57)?\]#isU', '<span style="color:#00008b">$1</span>', $texte);	//Vert penchant vers "teal" :
	$texte = preg_replace('#\[c(?:olor)?[:=]58\](.+)\[/c(?:olor)?(?:[:=]58)?\]#isU', '<span style="color:#00885e">$1</span>', $texte);	//Vert un peu olive :
	$texte = preg_replace('#\[c(?:olor)?[:=]59\](.+)\[/c(?:olor)?(?:[:=]59)?\]#isU', '<span style="color:#379600">$1</span>', $texte);	//Vert caca d'oie (beurk) :
	$texte = preg_replace('#\[c(?:olor)?[:=]60\](.+)\[/c(?:olor)?(?:[:=]60)?\]#isU', '<span style="color:#999e14">$1</span>', $texte);	//Marron / brun clair :
	$texte = preg_replace('#\[c(?:olor)?[:=]61\](.+)\[/c(?:olor)?(?:[:=]61)?\]#isU', '<span style="color:#473400">$1</span>', $texte);	//Brun / marron-rouge :
	$texte = preg_replace('#\[c(?:olor)?[:=]62\](.+)\[/c(?:olor)?(?:[:=]62)?\]#isU', '<span style="color:#4d0000">$1</span>', $texte); 	//#ee82ee fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]63\](.+)\[/c(?:olor)?(?:[:=]63)?\]#isU', '<span style="color:#5f0062">$1</span>', $texte);	//Bleu trs fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]64\](.+)\[/c(?:olor)?(?:[:=]64)?\]#isU', '<span style="color:#000047">$1</span>', $texte);	//Vert fonc :
	$texte = preg_replace('#\[c(?:olor)?[:=]65\](.+)\[/c(?:olor)?(?:[:=]65)?\]#isU', '<span style="color:#05502e">$1</span>', $texte); 	//Vert / vert kaki :
	$texte = preg_replace('#\[c(?:olor)?[:=]66\](.+)\[/c(?:olor)?(?:[:=]66)?\]#isU', '<span style="color:#1c5300">$1</span>', $texte);
	$texte = preg_replace('#\[c(?:olor)?[:=]67\](.+)\[/c(?:olor)?(?:[:=]67)?\]#isU', '<span style="color:#544d04">$1</span>', $texte);
	$texte = preg_replace('#\[c(?:olor)?[:=]68\](.+)\[/c(?:olor)?(?:[:=]68)?\]#isU', '<span style="color:black">$1</span>', $texte);
	
	$texte = preg_replace('#\[a[:=]0\](.+)\[/a(?:[:=]0)?\]#isU', '<span style="background-color:black">$1</span>', $texte); 	//Le blanc :
	$texte = preg_replace('#\[a[:=]1\](.+)\[/a(?:[:=]1)?\]#isU', '<span style="background-color:white">$1</span>', $texte); 	//Bleu fonc :
	$texte = preg_replace('#\[a[:=]2\](.+)\[/a(?:[:=]2)?\]#isU', '<span style="background-color:navy">$1</span>', $texte); 	//Vert :
	$texte = preg_replace('#\[a[:=]3\](.+)\[/a(?:[:=]3)?\]#isU', '<span style="background-color:green">$1</span>', $texte); 	//Rouge :
	$texte = preg_replace('#\[a[:=]4\](.+)\[/a(?:[:=]4)?\]#isU', '<span style="background-color:red">$1</span>', $texte); 	//Rouge fonc (maroon) :
	$texte = preg_replace('#\[a[:=]5\](.+)\[/a(?:[:=]5)?\]#isU', '<span style="background-color:maroon">$1</span>', $texte); 	//#ee82ee/Magenta fonc :
	$texte = preg_replace('#\[a[:=]6\](.+)\[/a(?:[:=]6)?\]#isU', '<span style="background-color:#8b008b">$1</span>', $texte); 	//Orange fonc :
	$texte = preg_replace('#\[a[:=]7\](.+)\[/a(?:[:=]7)?\]#isU', '<span style="background-color:#ff8c00">$1</span>', $texte); 	//Jaune :
	$texte = preg_replace('#\[a[:=]8\](.+)\[/a(?:[:=]8)?\]#isU', '<span style="background-color:yellow">$1</span>', $texte); 	//Vert fluo :
	$texte = preg_replace('#\[a[:=]9\](.+)\[/a(?:[:=]9)?\]#isU', '<span style="background-color:lime">$1</span>', $texte); 	//Bleu-vert (#008b8b, le plus fort des hroooos xD)
	$texte = preg_replace('#\[a[:=]10\](.+)\[/a(?:[:=]10)?\]#isU', '<span style="background-color:#008b8b">$1</span>', $texte); 	//Cyan :
	$texte = preg_replace('#\[a[:=]11\](.+)\[/a(?:[:=]11)?\]#isU', '<span style="background-color:aqua">$1</span>', $texte); 	//Bleu :
	$texte = preg_replace('#\[a[:=]12\](.+)\[/a(?:[:=]12)?\]#isU', '<span style="background-color:blue">$1</span>', $texte); 	//Fuchsia :
	$texte = preg_replace('#\[a[:=]13\](.+)\[/a(?:[:=]13)?\]#isU', '<span style="background-color:fuchsia">$1</span>', $texte); 	//Gris (fonc) :
	$texte = preg_replace('#\[a[:=]14\](.+)\[/a(?:[:=]14)?\]#isU', '<span style="background-color:gray">$1</span>', $texte);	//Gris clair :
	$texte = preg_replace('#\[a[:=]15\](.+)\[/a(?:[:=]15)?\]#isU', '<span style="background-color:#d3d3d3">$1</span>', $texte);	//Gris encore plus clair :
	$texte = preg_replace('#\[a[:=]16\](.+)\[/a(?:[:=]16)?\]#isU', '<span style="background-color:#dcdcdc">$1</span>', $texte);	//Gris clair 'le mme que le 15 mais faut bien afficher ce que a affiche xD) :
	$texte = preg_replace('#\[a[:=]17\](.+)\[/a(?:[:=]17)?\]#isU', '<span style="background-color:#d3d3d3">$1</span>', $texte);	//Saumon :
	$texte = preg_replace('#\[a[:=]18\](.+)\[/a(?:[:=]18)?\]#isU', '<span style="background-color:#ffdead">$1</span>', $texte);	//Rose clair  la "rose saumon" :
	$texte = preg_replace('#\[a[:=]19\](.+)\[/a(?:[:=]19)?\]#isU', '<span style="background-color:#ffb6c1">$1</span>', $texte);	//Rose ple (c'est du #ee82ee clair mais bon xD) :
	$texte = preg_replace('#\[a[:=]20\](.+)\[/a(?:[:=]20)?\]#isU', '<span style="background-color:#ee82ee">$1</span>', $texte);	//#ee82ee clair :
	$texte = preg_replace('#\[a[:=]21\](.+)\[/a(?:[:=]21)?\]#isU', '<span style="background-color:#ee82ee">$1</span>', $texte);	//Turquoise ple :
	$texte = preg_replace('#\[a[:=]22\](.+)\[/a(?:[:=]22)?\]#isU', '<span style="background-color:#afeeee">$1</span>', $texte);	//Vert ple :
	$texte = preg_replace('#\[a[:=]23\](.+)\[/a(?:[:=]23)?\]#isU', '<span style="background-color:#98fb98">$1</span>', $texte);	//Jaune ple :
	$texte = preg_replace('#\[a[:=]24\](.+)\[/a(?:[:=]24)?\]#isU', '<span style="background-color:#eee8aa">$1</span>', $texte);	//Gris-argent :
	$texte = preg_replace('#\[a[:=]25\](.+)\[/a(?:[:=]25)?\]#isU', '<span style="background-color:silver">$1</span>', $texte);	//Gris-gris fonc :
	$texte = preg_replace('#\[a[:=]26\](.+)\[/a(?:[:=]26)?\]#isU', '<span style="background-color:#a9a9a9">$1</span>', $texte);	//Orange ple :
	$texte = preg_replace('#\[a[:=]27\](.+)\[/a(?:[:=]27)?\]#isU', '<span style="background-color:#f4a460">$1</span>', $texte);	//Rose/rouge/saumon :
	$texte = preg_replace('#\[a[:=]28\](.+)\[/a(?:[:=]28)?\]#isU', '<span style="background-color:#fa8072">$1</span>', $texte);	//Rose :
	$texte = preg_replace('#\[a[:=]29\](.+)\[/a(?:[:=]29)?\]#isU', '<span style="background-color:#ee82ee">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]30\](.+)\[/a(?:[:=]30)?\]#isU', '<span style="background-color:#7b68ee">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]31\](.+)\[/a(?:[:=]31)?\]#isU', '<span style="background-color:#7fffd4">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]32\](.+)\[/a(?:[:=]32)?\]#isU', '<span style="background-color:#90ee90">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]33\](.+)\[/a(?:[:=]33)?\]#isU', '<span style="background-color:#f9ff57">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]34\](.+)\[/a(?:[:=]34)?\]#isU', '<span style="background-color:gray">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]35\](.+)\[/a(?:[:=]35)?\]#isU', '<span style="background-color:gray">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]36\](.+)\[/a(?:[:=]36)?\]#isU', '<span style="background-color:orange">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]37\](.+)\[/a(?:[:=]37)?\]#isU', '<span style="background-color:#ff4500">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]38\](.+)\[/a(?:[:=]38)?\]#isU', '<span style="background-color:fuchsia">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]39\](.+)\[/a(?:[:=]39)?\]#isU', '<span style="background-color:blue">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]40\](.+)\[/a(?:[:=]40)?\]#isU', '<span style="background-color:#00fa9a">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]41\](.+)\[/a(?:[:=]41)?\]#isU', '<span style="background-color:#7cfc00">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]42\](.+)\[/a(?:[:=]42)?\]#isU', '<span style="background-color:yellow">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]43\](.+)\[/a(?:[:=]43)?\]#isU', '<span style="background-color:#696969">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]44\](.+)\[/a(?:[:=]44)?\]#isU', '<span style="background-color:#696969">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]45\](.+)\[/a(?:[:=]45)?\]#isU', '<span style="background-color:#daa520">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]46\](.+)\[/a(?:[:=]46)?\]#isU', '<span style="background-color:red">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]47\](.+)\[/a(?:[:=]47)?\]#isU', '<span style="background-color:fuchsia">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]48\](.+)\[/a(?:[:=]48)?\]#isU', '<span style="background-color:#0000cd">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]49\](.+)\[/a(?:[:=]49)?\]#isU', '<span style="background-color:#02cc88">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]50\](.+)\[/a(?:[:=]50)?\]#isU', '<span style="background-color:#58d80c">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]51\](.+)\[/a(?:[:=]51)?\]#isU', '<span style="background-color:#49b00a">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]52\](.+)\[/a(?:[:=]52)?\]#isU', '<span style="background-color:#333335">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]53\](.+)\[/a(?:[:=]53)?\]#isU', '<span style="background-color:#333335">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]54\](.+)\[/a(?:[:=]54)?\]#isU', '<span style="background-color:#8b4513">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]55\](.+)\[/a(?:[:=]55)?\]#isU', '<span style="background-color:#8b0000">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]56\](.+)\[/a(?:[:=]56)?\]#isU', '<span style="background-color:#8b008b">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]57\](.+)\[/a(?:[:=]57)?\]#isU', '<span style="background-color:#00008b">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]58\](.+)\[/a(?:[:=]58)?\]#isU', '<span style="background-color:#00885e">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]59\](.+)\[/a(?:[:=]59)?\]#isU', '<span style="background-color:#379600">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]60\](.+)\[/a(?:[:=]60)?\]#isU', '<span style="background-color:#999e14">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]61\](.+)\[/a(?:[:=]61)?\]#isU', '<span style="background-color:#473400">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]62\](.+)\[/a(?:[:=]62)?\]#isU', '<span style="background-color:#4d0000">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]63\](.+)\[/a(?:[:=]63)?\]#isU', '<span style="background-color:#5f0062">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]64\](.+)\[/a(?:[:=]64)?\]#isU', '<span style="background-color:#000047">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]65\](.+)\[/a(?:[:=]65)?\]#isU', '<span style="background-color:#05502e">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]66\](.+)\[/a(?:[:=]66)?\]#isU', '<span style="background-color:#1c5300">$1</span>', $texte);
	$texte = preg_replace('#\[a[:=]67\](.+)\[/a(?:[:=]67)?\]#isU', '<span style="background-color:#544d04">$1</span>', $texte);
	
	
	$texte = preg_replace('#(?:\[a[:=](red|green|blue|purple|yellow|olive|yellowgreen|white|turquoise|teal|pink|orange|navy|magenta|indigo|gold|fuchsia|gray|cyan|chocolate|brown|black|aqua)\])(.+)(?:\[/a\])#isU', '<span style="background-color:$1">$2</span>'
		, $texte);		
	$texte = preg_replace('#\[a[:=](\#[0-9]{6})\](.+)\[/a(?:[:=](\#[0-9]{6}))?\]#isU', '<span style="background-color:$1">$2</span>', $texte);
	
	
	//$texte = preg_replace('#https?://[a-z0-9._/-]+\.[a-z0-9._/-]+[a-z0-9?\#&=_-]*#i', '<a href="$0">$0</a>', $texte);
	$texte = preg_replace('#\[img\](.+)\[/img\]#isUe', "'<img src=\"'.strip_tags('$1').'\">'", $texte);
	$texte = preg_replace('#\[url=(.+)\](.+)\[/url\]#isUe', "'<a href=\"'.strip_tags('$1').'\">'.stripslashes('$2').'</a>'", $texte);
	$texte = preg_replace('#\[url\](.+)\[/url\]#isUe', "'<a href=\"'.strip_tags('$1').'\">'.strip_tags('$1').'</a>'", $texte);
	/**
	$texte = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $texte);
	$texte = preg_replace('#\[u\](.+)\[/u\]#isU', '<span style="text-decoration:underline;">$1</span>', $texte);
	**/
	
	$texte = preg_replace('# \^\^ #', '<img src="html/images/smileys/^^.gif" alt="^^" >', $texte);
	$texte = preg_replace('# \-_\- #', '<img src="html/images/smileys/-_-.gif" alt="-_-" >', $texte);
	$texte = preg_replace('# (=P|=p|:p|:P) #', '<img src="html/images/smileys/=P.gif" alt="=P" >', $texte);
	$texte = preg_replace('# ;\) #', '<img src="html/images/smileys/clin_doeil.gif" alt=";)" >', $texte);
	$texte = preg_replace('# :\) #', '<img src="html/images/smileys/content1.gif" alt=":)" >', $texte);
	$texte = preg_replace('# =\) #', '<img src="html/images/smileys/content1.gif" alt="=)" >', $texte);
	$texte = preg_replace('# [=:][@(] #', '<img src="html/images/smileys/pas_content.gif" alt=":(" >', $texte);
	$texte = preg_replace('# [:=][dD] #', '<img src="html/images/smileys/sourire_chinois.gif" alt=":D" >', $texte);
	$texte = preg_replace('# [:=]\$ #', '<img src="html/images/smileys/euh.gif" alt="=$" >', $texte);
	$texte = preg_replace('# Oo #', ' <img src="html/images/smileys/Oo.gif" alt="Oo" >', $texte);
	$texte = preg_replace('#:censure:#i', '<img src="html/images/smileys/censure.gif" alt="Censur" >', $texte);
	$texte = preg_replace('#:siffle:#i', '<img src="html/images/smileys/siffleairderien.gif" alt="Siffle l\'air de rien" >', $texte);		
	//$texte = preg_replace('#\[(.+)\]#i','',$texte); 
	$texte = str_replace (FP_LIGNE,'{LIGNE}',$texte);
	$texte = preg_replace('#\{LIGNE\}{2,}#','{LIGNE}',$texte);
	$texte = str_replace('{LIGNE}','<br>'.FP_LIGNE,$texte);
	return $texte;
} 
		
?>