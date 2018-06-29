var bbcodes =
[
 	[ /\[b\](.+)\[\/b\]/gi , "<strong>$1</strong>" ] ,
	[ /\[i\](.+)\[\/i\]/gi , "<em>$1</em>" ] ,
	[ /\[u\](.+)\[\/u\]/gi, "<u>$1</u>" ] ,		
	[ /(?:\[c(?:olor)?[:=](red|green|blue|purple|yellow|olive|yellowgreen|white|turquoise|teal|pink|orange|navy|magenta|indigo|gold|fuchsia|gray|cyan|chocolate|brown|black|aqua)\])(.+)(?:\[\/c(?:olor)?(?:=(?:5|(?:$1)))?\])/gi, '<span style="color:$1">$2</span>' ] ,
	[ /\[c(?:olor)?[:=](\#[0-9a-f]{6})\](.+)\[\/c(?:olor)?(?:[:=](\#[0-9a-f]{6}))?\]/gi, '<span style="color:$1">$2</span>' ] ,
	[ /\[c(?:olor)?[:=]0\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:black">$1</span>' ] ,
	[ /\[c(?:olor)?[:=]1\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:white">$1</span>' ] ,
	[ /\[c(?:olor)?[:=]2\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:navy">$1</span>' ] ,
	[ /\[c(?:olor)?[:=]3\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:green">$1</span>' ] ,
	//Rouge :
	[ /\[c(?:olor)?[:=]4\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:red">$1</span>' ] ,	
	//Rouge fonc (maroon) :
	[ /\[c(?:olor)?[:=]5\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:maroon">$1</span>' ] ,
	//Violet/Magenta fonc :
	[ /\[c(?:olor)?[:=]6\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkmagenta">$1</span>' ] ,
	//Orange fonc :
	[ /\[c(?:olor)?[:=]7\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkorange">$1</span>' ] ,
	//Jaune :
	[ /\[c(?:olor)?[:=]8\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:yellow">$1</span>' ] ,
	//Vert fluo :
	[ /\[c(?:olor)?[:=]9\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lime">$1</span>' ] ,
	//Bleu-vert (darkcyan, le plus fort des hroooos xD)
	[ /\[c(?:olor)?[:=]10\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkcyan">$1</span>' ] ,
	//Cyan :
	[ /\[c(?:olor)?[:=]11\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:aqua">$1</span>' ] ,
	//Bleu :
	[ /\[c(?:olor)?[:=]12\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:blue">$1</span>' ] ,
	//Fuchsia :
	[ /\[c(?:olor)?[:=]13\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:fuchsia">$1</span>' ] ,
	//Gris (fonc) :
	[ /\[c(?:olor)?[:=]14\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gray">$1</span>' ] ,
	//Gris clair :
	[ /\[c(?:olor)?[:=]15\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightgrey">$1</span>' ] ,
	//Gris encore plus clair :
	[ /\[c(?:olor)?[:=]16\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gainsboro">$1</span>' ] ,
	//Gris clair 'le mme que le 15 mais faut bien afficher ce que a affiche xD) :
	[ /\[c(?:olor)?[:=]17\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightgrey">$1</span>' ] ,
	//Saumon :
	[ /\[c(?:olor)?[:=]18\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:navajowhite">$1</span>' ] ,
	//Rose clair  la "rose saumon" :
	[ /\[c(?:olor)?[:=]19\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightpink">$1</span>' ] ,
	//Rose ple (c'est du violet clair mais bon xD) :
	[ /\[c(?:olor)?[:=]20\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:violet">$1</span>' ] ,
	//Violet clair :
	[ /\[c(?:olor)?[:=]21\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:violet">$1</span>' ] ,
	//Turquoise ple :
	[ /\[c(?:olor)?[:=]22\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#afeeee">$1</span>' ] ,
	//Vert ple :
	[ /\[c(?:olor)?[:=]23\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:palegreen">$1</span>' ] ,
	//Jaune ple :
	[ /\[c(?:olor)?[:=]24\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:palegoldenrod">$1</span>' ] ,
	//Gris-argent :
	[ /\[c(?:olor)?[:=]25\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:silver">$1</span>' ] ,
	//Gris-gris fonc :
	[ /\[c(?:olor)?[:=]26\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkgray">$1</span>' ] ,
	//Orange ple :
	[ /\[c(?:olor)?[:=]27\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:sandybrown">$1</span>' ] ,
	//Rose/rouge/saumon :
	[ /\[c(?:olor)?[:=]28\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:salmon">$1</span>' ] ,
	//Rose :
	[ /\[c(?:olor)?[:=]29\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:violet">$1</span>' ] ,
	//Bleu-violet :
	[ /\[c(?:olor)?[:=]30\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:mediumslateblue">$1</span>' ] ,
	//Turquoise clair/marine :
	[ /\[c(?:olor)?[:=]31\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:aquamarine">$1</span>' ] ,
	//Vert clair :
	[ /\[c(?:olor)?[:=]32\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightgreen">$1</span>' ] ,
	//Jaune un peu ple :
	[ /\[c(?:olor)?[:=]33\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#f9ff57">$1</span>' ] ,
	//Gris (encore !!) :
	[ /\[c(?:olor)?[:=]34\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gray">$1</span>' ] ,
	//Gris (... et encore ...) :
	[ /\[c(?:olor)?[:=]35\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gray">$1</span>' ] ,
	//Orange (normal) :
	[ /\[c(?:olor)?[:=]36\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:orange">$1</span>' ] ,
	//Rouge/orange :
	[ /\[c(?:olor)?[:=]37\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:orangered">$1</span>' ] ,
	//Fuchsia (et oui, encore xD) :
	[ /\[c(?:olor)?[:=]38\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:fuchsia">$1</span>' ] ,
	//Bleu (marine normalement mais bleu) :
	[ /\[c(?:olor)?[:=]39\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:blue">$1</span>' ] ,
	//Vert-turquoise :
	[ /\[c(?:olor)?[:=]40\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:mediumspringgreen">$1</span>' ] ,
	//Vert clair / vers le fluo :
	[ /\[c(?:olor)?[:=]41\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lawngreen">$1</span>' ] ,
	//Jaune xD :
	[ /\[c(?:olor)?[:=]42\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:yellow">$1</span>' ] ,
	//Gris (dimgray) :
	[ /\[c(?:olor)?[:=]43\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:dimgray">$1</span>' ] ,
	//Gris (pareil xD) :
	[ /\[c(?:olor)?[:=]44\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:dimgray">$1</span>' ] ,
	//Ocre :
	[ /\[c(?:olor)?[:=]45\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:goldenrod">$1</span>' ] ,
	//Rouge :
	[ /\[c(?:olor)?[:=]46\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:red">$1</span>' ] ,
	//Rose / fuchsia :
	[ /\[c(?:olor)?[:=]47\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:fuchsia">$1</span>' ] ,
	//Bleu indigo :
	[ /\[c(?:olor)?[:=]48\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:mediumblue">$1</span>' ] ,
	//Vert "d'eau" :
	[ /\[c(?:olor)?[:=]49\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#02cc88">$1</span>' ] ,
	//Vert olive :
	[ /\[c(?:olor)?[:=]50\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#58d80c">$1</span>' ] ,
	//Vert olive plus fonc :
	[ /\[c(?:olor)?[:=]51\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#49b00a">$1</span>' ] ,
	//Noir clair :
	[ /\[c(?:olor)?[:=]52\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#333335">$1</span>' ] ,
	//Noir clair (ouais encore xD) :
	[ /\[c(?:olor)?[:=]53\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#333335">$1</span>' ] ,
	//Marron :
	[ /\[c(?:olor)?[:=]54\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:saddlebrown">$1</span>' ] ,
	//Rouge Bordeaux :
	[ /\[c(?:olor)?[:=]55\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#8b0000">$1</span>' ] ,
	//Violet / magenta fonc :
	[ /\[c(?:olor)?[:=]56\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkmagenta">$1</span>' ] ,
	//Bleu marine :
	[ /\[c(?:olor)?[:=]57\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkblue">$1</span>' ] ,
	//Vert penchant vers "teal" :
	[ /\[c(?:olor)?[:=]58\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#00885e">$1</span>' ] ,
	//Vert un peu olive :
	[ /\[c(?:olor)?[:=]59\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#379600">$1</span>' ] ,
	//Vert caca d'oie (beurk) :
	[ /\[c(?:olor)?[:=]60\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#999e14">$1</span>' ] ,
	//Marron / brun clair :
	[ /\[c(?:olor)?[:=]61\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#473400">$1</span>' ] ,
	//Brun / marron-rouge :
	[ /\[c(?:olor)?[:=]62\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#4d0000">$1</span>' ] ,
	//Violet fonc :
	[ /\[c(?:olor)?[:=]63\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#5f0062">$1</span>' ] ,
	//Bleu trs fonc :
	[ /\[c(?:olor)?[:=]64\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#000047">$1</span>' ] ,
	//Vert fonc :
	[ /\[c(?:olor)?[:=]65\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#05502e">$1</span>' ] ,
	//Vert / vert kaki :
	[ /\[c(?:olor)?[:=]66\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#1c5300">$1</span>' ] ,
	//Vrai kaki / marron
	[ /\[c(?:olor)?[:=]67\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#544d04">$1</span>' ] ,
	//Noir :
	[ /\[c(?:olor)?[:=]68\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:black">$1</span>' ] ,
	
		//C'est cool a man ! Allez, on se tape le surlignage :
		
	//Bon bah on est parti : le noir :
	[ /\[a[:=]0\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:black">$1</span>' ] ,
	//Le blanc :
	[ /\[a[:=]1\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:white">$1</span>' ] ,
	//Bleu fonc :
	[ /\[a[:=]2\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:navy">$1</span>' ] ,
	//Vert :
	[ /\[a[:=]3\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:green">$1</span>' ] ,
	//Rouge :
	[ /\[a[:=]4\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:red">$1</span>' ] ,	
	//Rouge fonc (maroon) :
	[ /\[a[:=]5\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:maroon">$1</span>' ] ,
	//Violet/Magenta fonc :
	[ /\[a[:=]6\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkmagenta">$1</span>' ] ,
	//Orange fonc :
	[ /\[a[:=]7\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkorange">$1</span>' ] ,
	//Jaune :
	[ /\[a[:=]8\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:yellow">$1</span>' ] ,
	//Vert fluo :
	[ /\[a[:=]9\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lime">$1</span>' ] ,
	//Bleu-vert (darkcyan, le plus fort des hroooos xD)
	[ /\[a[:=]10\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkcyan">$1</span>' ] ,
	//Cyan :
	[ /\[a[:=]11\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:aqua">$1</span>' ] ,
	//Bleu :
	[ /\[a[:=]12\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:blue">$1</span>' ] ,
	//Fuchsia :
	[ /\[a[:=]13\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:fuchsia">$1</span>' ] ,
	//Gris (fonc) :
	[ /\[a[:=]14\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gray">$1</span>' ] ,
	//Gris clair :
	[ /\[a[:=]15\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightgrey">$1</span>' ] ,
	//Gris encore plus clair :
	[ /\[a[:=]16\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gainsboro">$1</span>' ] ,
	//Gris clair 'le mme que le 15 mais faut bien afficher ce que a affiche xD) :
	[ /\[a[:=]17\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightgrey">$1</span>' ] ,
	//Saumon :
	[ /\[a[:=]18\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:navajowhite">$1</span>' ] ,
	//Rose clair  la "rose saumon" :
	[ /\[a[:=]19\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightpink">$1</span>' ] ,
	//Rose ple (c'est du violet clair mais bon xD) :
	[ /\[a[:=]20\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:violet">$1</span>' ] ,
	//Violet clair :
	[ /\[a[:=]21\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:violet">$1</span>' ] ,
	//Turquoise ple :
	[ /\[a[:=]22\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#afeeee">$1</span>' ] ,
	//Vert ple :
	[ /\[a[:=]23\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:palegreen">$1</span>' ] ,
	//Jaune ple :
	[ /\[a[:=]24\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:palegoldenrod">$1</span>' ] ,
	//Gris-argent :
	[ /\[a[:=]25\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:silver">$1</span>' ] ,
	//Gris-gris fonc :
	[ /\[a[:=]26\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkgray">$1</span>' ] ,
	//Orange ple :
	[ /\[a[:=]27\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:sandybrown">$1</span>' ] ,
	//Rose/rouge/saumon :
	[ /\[a[:=]28\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:salmon">$1</span>' ] ,
	//Rose :
	[ /\[a[:=]29\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:violet">$1</span>' ] ,
	//Bleu-violet :
	[ /\[a[:=]30\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:mediumslateblue">$1</span>' ] ,
	//Turquoise clair/marine :
	[ /\[a[:=]31\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:aquamarine">$1</span>' ] ,
	//Vert clair :
	[ /\[a[:=]32\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightgreen">$1</span>' ] ,
	//Jaune un peu ple :
	[ /\[a[:=]33\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#f9ff57">$1</span>' ] ,
	//Gris (encore !!) :
	[ /\[a[:=]34\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gray">$1</span>' ] ,
	//Gris (... et encore ...) :
	[ /\[a[:=]35\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gray">$1</span>' ] ,
	//Orange (normal) :
	[ /\[a[:=]36\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:orange">$1</span>' ] ,
	//Rouge/orange :
	[ /\[a[:=]37\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:orangered">$1</span>' ] ,
	//Fuchsia (et oui, encore xD) :
	[ /\[a[:=]38\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:fuchsia">$1</span>' ] ,
	//Bleu (marine normalement mais bleu) :
	[ /\[a[:=]39\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:blue">$1</span>' ] ,
	//Vert-turquoise :
	[ /\[a[:=]40\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:mediumspringgreen">$1</span>' ] ,
	//Vert clair / vers le fluo :
	[ /\[a[:=]41\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lawngreen">$1</span>' ] ,
	//Jaune xD :
	[ /\[a[:=]42\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:yellow">$1</span>' ] ,
	//Gris (dimgray) :
	[ /\[a[:=]43\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:dimgray">$1</span>' ] ,
	//Gris (pareil xD) :
	[ /\[a[:=]44\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:dimgray">$1</span>' ] ,
	//Ocre :
	[ /\[a[:=]45\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:goldenrod">$1</span>' ] ,
	//Rouge :
	[ /\[a[:=]46\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:red">$1</span>' ] ,
	//Rose / fuchsia :
	[ /\[a[:=]47\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:fuchsia">$1</span>' ] ,
	//Bleu indigo :
	[ /\[a[:=]48\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:mediumblue">$1</span>' ] ,
	//Vert "d'eau" :
	[ /\[a[:=]49\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#02cc88">$1</span>' ] ,
	//Vert olive :
	[ /\[a[:=]50\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#58d80c">$1</span>' ] ,
	//Vert olive plus fonc :
	[ /\[a[:=]51\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#49b00a">$1</span>' ] ,
	//Noir clair :
	[ /\[a[:=]52\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#333335">$1</span>' ] ,
	//Noir clair (ouais encore xD) :
	[ /\[a[:=]53\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#333335">$1</span>' ] ,
	//Marron :
	[ /\[a[:=]54\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:saddlebrown">$1</span>' ] ,
	//Rouge Bordeaux :
	[ /\[a[:=]55\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#8b0000">$1</span>' ] ,
	//Violet / magenta fonc :
	[ /\[a[:=]56\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkmagenta">$1</span>' ] ,
	//Bleu marine :
	[ /\[a[:=]57\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkblue">$1</span>' ] ,
	//Vert penchant vers "teal" :
	[ /\[a[:=]58\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#00885e">$1</span>' ] ,
	//Vert un peu olive :
	[ /\[a[:=]59\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#379600">$1</span>' ] ,
	//Vert caca d'oie (beurk) :
	[ /\[a[:=]60\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#999e14">$1</span>' ] ,
	//Marron / brun clair :
	[ /\[a[:=]61\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#473400">$1</span>' ] ,
	//Brun / marron-rouge :
	[ /\[a[:=]62\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#4d0000">$1</span>' ] ,
	//Violet fonc :
	[ /\[a[:=]63\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#5f0062">$1</span>' ] ,
	//Bleu trs fonc :
	[ /\[a[:=]64\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#000047">$1</span>' ] ,
	//Vert fonc :
	[ /\[a[:=]65\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#05502e">$1</span>' ] ,
	//Vert / vert kaki :
	[ /\[a[:=]66\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#1c5300">$1</span>' ] ,
	//Vrai kaki / marron
	[ /\[a[:=]67\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#544d04">$1</span>' ] ,
	//Noir :
	[ /\[a[:=]68\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:black">$1</span>' ] ,
		
	
	[ /(?:\[a[:=](red|green|blue|purple|yellow|olive|yellowgreen|white|turquoise|teal|pink|orange|navy|magenta|indigo|gold|fuchsia|gray|cyan|chocolate|brown|black|aqua)\])(.+)(?:\[\/a(?:=(?:5|(?:$1)))?\])/gi, '<span style="background-color:$1">$2</span>' ] ,
	
		//L'hxadcimal :
		
	[ /\[a[:=](\#[0-9a-f]{6})\](.+)\[\/a(?:[:=](\#[0-9a-f]{6}))?\]/gi, '<span style="background-color:$1">$2</span>' ] ,
	
	[ /\[img]([^\]]*)\[\/img]/mig , '<img src="$1" border="0">' ],
	[ /\[url]([^\]]*)\[\/url]/mig , '<a href="$1">$1</a> '],
	[ /\[url=([^\[]*)\]([^\]]*)\[\/url\]/mig , '<a href=\'$1\'>$2</a>' ],
	[ /\^\^/gi, '<img src="html/images/smileys/^^.gif" alt="^^" >' ] ,
	[ /\-_\-/gi, '<img src="html/images/smileys/-_-.gif" alt="-_-" >' ] ,
	[ / [:=]p /gi, '<img src="html/images/smileys/=P.gif" alt="=P" >' ] ,
	[ /;\)/gi, '<img src="html/images/smileys/Clin_d\'oeil.gif" alt=";)" >' ] ,
	[ /:\)/gi, '<img src="html/images/smileys/Content1.gif" alt=":)" >' ] ,
	[ /=\)/gi, '<img src="html/images/smileys/Content1.gif" alt="=)" >' ] ,
	[ /[=:][@(]/gi, '<img src="html/images/smileys/Pas_content.gif" alt=":(" >' ] ,
	[ /[:=]d/gi, '<img src="html/images/smileys/Sourire_chinois.gif" alt=":D" >' ] ,
	[ /[:=]\$/gi, '<img src="html/images/smileys/euh.gif" alt="=$" >' ] ,
	[ /Oo/g, '<img src="html/images/smileys/Oo.gif" alt="Oo" >' ] ,
	[ /:censure:/gi, '<img src="html/images/smileys/censure.gif" alt="Censur" >' ] ,
	[ /:siffle:/gi, '<img src="html/images/smileys/siffleAirDeRien.gif" alt="Siffle l\'air de rien" >' ] 
];
									  
function bbcode(texte)
{
	for(i=0; i < bbcodes.length;i++)
	{
		texte = texte.replace(bbcodes[i][0],bbcodes[i][1]);
	}
	return texte;
}

function verif()
{
	var elements = document.getElementsByClassName('bbcode');
	for (var i=0;i < elements.length ;i++)
	{
		elements[i].onkeyup = function()
		{
			document.getElementById(this.id + '_infos').innerHTML=bbcode(this.value);
		};
	}
}
window.onload=verif;