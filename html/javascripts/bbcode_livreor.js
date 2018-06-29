function bbcode()
{
		/*Gestion des sauts de ligne*/
		
	apercu_message = apercu_message.replace(/\n/g, "<br />");

		/*Message en italique :*/
		
	apercu_message = apercu_message.replace(/\[b\](.+)\[\/b\]/gi, "<strong>$1</strong>");

		/*Message en italique :*/
		
	apercu_message = apercu_message.replace(/\[i\](.+)\[\/i\]/gi, "<em>$1</em>");
		
		//Message en soulign
		
	apercu_message = apercu_message.replace(/\[u\](.+)\[\/u\]/gi, "<u>$1</u>");
		
		//Yes yes yeeeeeeees c'est bon a ! Allez, on passe aux couleurs !
		//Par nom :
		
	apercu_message = apercu_message.replace(/(?:\[c(?:olor)?[:=](red|green|blue|purple|yellow|olive|yellowgreen|white|turquoise|teal|pink|orange|navy|magenta|indigo|gold|fuchsia|gray|cyan|chocolate|brown|black|aqua)\])(.+)(?:\[\/c(?:olor)?(?:=(?:5|(?:$1)))?\])/gi, '<span style="color:$1">$2</span>');
		
		//Par hxadcimal :
		
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=](\#[0-9a-f]{6})\](.+)\[\/c(?:olor)?(?:[:=](\#[0-9a-f]{6}))?\]/gi, '<span style="color:$1">$2</span>');
		
		//Sujet pineux : les numros de couleurs =P :
		
	//Bon bah on est parti : le noir :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]0\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:black">$1</span>');
	//Le blanc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]1\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:white">$1</span>');
	//Bleu fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]2\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:navy">$1</span>');
	//Vert :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]3\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:green">$1</span>');
	//Rouge :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]4\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:red">$1</span>');	
	//Rouge fonc (maroon) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]5\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:maroon">$1</span>');
	//Violet/Magenta fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]6\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkmagenta">$1</span>');
	//Orange fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]7\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkorange">$1</span>');
	//Jaune :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]8\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:yellow">$1</span>');
	//Vert fluo :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]9\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lime">$1</span>');
	//Bleu-vert (darkcyan, le plus fort des hroooos xD)
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]10\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkcyan">$1</span>');
	//Cyan :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]11\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:aqua">$1</span>');
	//Bleu :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]12\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:blue">$1</span>');
	//Fuchsia :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]13\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:fuchsia">$1</span>');
	//Gris (fonc) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]14\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gray">$1</span>');
	//Gris clair :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]15\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightgrey">$1</span>');
	//Gris encore plus clair :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]16\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gainsboro">$1</span>');
	//Gris clair 'le mme que le 15 mais faut bien afficher ce que a affiche xD) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]17\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightgrey">$1</span>');
	//Saumon :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]18\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:navajowhite">$1</span>');
	//Rose clair  la "rose saumon" :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]19\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightpink">$1</span>');
	//Rose ple (c'est du violet clair mais bon xD) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]20\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:violet">$1</span>');
	//Violet clair :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]21\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:violet">$1</span>');
	//Turquoise ple :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]22\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#afeeee">$1</span>');
	//Vert ple :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]23\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:palegreen">$1</span>');
	//Jaune ple :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]24\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:palegoldenrod">$1</span>');
	//Gris-argent :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]25\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:silver">$1</span>');
	//Gris-gris fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]26\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkgray">$1</span>');
	//Orange ple :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]27\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:sandybrown">$1</span>');
	//Rose/rouge/saumon :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]28\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:salmon">$1</span>');
	//Rose :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]29\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:violet">$1</span>');
	//Bleu-violet :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]30\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:mediumslateblue">$1</span>');
	//Turquoise clair/marine :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]31\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:aquamarine">$1</span>');
	//Vert clair :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]32\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lightgreen">$1</span>');
	//Jaune un peu ple :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]33\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#f9ff57">$1</span>');
	//Gris (encore !!) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]34\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gray">$1</span>');
	//Gris (... et encore ...) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]35\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:gray">$1</span>');
	//Orange (normal) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]36\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:orange">$1</span>');
	//Rouge/orange :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]37\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:orangered">$1</span>');
	//Fuchsia (et oui, encore xD) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]38\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:fuchsia">$1</span>');
	//Bleu (marine normalement mais bleu) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]39\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:blue">$1</span>');
	//Vert-turquoise :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]40\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:mediumspringgreen">$1</span>');
	//Vert clair / vers le fluo :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]41\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:lawngreen">$1</span>');
	//Jaune xD :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]42\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:yellow">$1</span>');
	//Gris (dimgray) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]43\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:dimgray">$1</span>');
	//Gris (pareil xD) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]44\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:dimgray">$1</span>');
	//Ocre :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]45\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:goldenrod">$1</span>');
	//Rouge :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]46\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:red">$1</span>');
	//Rose / fuchsia :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]47\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:fuchsia">$1</span>');
	//Bleu indigo :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]48\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:mediumblue">$1</span>');
	//Vert "d'eau" :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]49\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#02cc88">$1</span>');
	//Vert olive :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]50\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#58d80c">$1</span>');
	//Vert olive plus fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]51\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#49b00a">$1</span>');
	//Noir clair :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]52\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#333335">$1</span>');
	//Noir clair (ouais encore xD) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]53\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#333335">$1</span>');
	//Marron :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]54\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:saddlebrown">$1</span>');
	//Rouge Bordeaux :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]55\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#8b0000">$1</span>');
	//Violet / magenta fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]56\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkmagenta">$1</span>');
	//Bleu marine :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]57\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:darkblue">$1</span>');
	//Vert penchant vers "teal" :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]58\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#00885e">$1</span>');
	//Vert un peu olive :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]59\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#379600">$1</span>');
	//Vert caca d'oie (beurk) :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]60\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#999e14">$1</span>');
	//Marron / brun clair :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]61\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#473400">$1</span>');
	//Brun / marron-rouge :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]62\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#4d0000">$1</span>');
	//Violet fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]63\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#5f0062">$1</span>');
	//Bleu trs fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]64\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#000047">$1</span>');
	//Vert fonc :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]65\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#05502e">$1</span>');
	//Vert / vert kaki :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]66\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#1c5300">$1</span>');
	//Vrai kaki / marron
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]67\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:#544d04">$1</span>');
	//Noir :
	apercu_message = apercu_message.replace(/\[c(?:olor)?[:=]68\](.+)\[\/c(?:olor)?(?:[:=]0)?\]/gi, '<span style="color:black">$1</span>');
	
		//C'est cool a man ! Allez, on se tape le surlignage :
		
	//Bon bah on est parti : le noir :
	apercu_message = apercu_message.replace(/\[a[:=]0\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:black">$1</span>');
	//Le blanc :
	apercu_message = apercu_message.replace(/\[a[:=]1\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:white">$1</span>');
	//Bleu fonc :
	apercu_message = apercu_message.replace(/\[a[:=]2\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:navy">$1</span>');
	//Vert :
	apercu_message = apercu_message.replace(/\[a[:=]3\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:green">$1</span>');
	//Rouge :
	apercu_message = apercu_message.replace(/\[a[:=]4\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:red">$1</span>');	
	//Rouge fonc (maroon) :
	apercu_message = apercu_message.replace(/\[a[:=]5\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:maroon">$1</span>');
	//Violet/Magenta fonc :
	apercu_message = apercu_message.replace(/\[a[:=]6\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkmagenta">$1</span>');
	//Orange fonc :
	apercu_message = apercu_message.replace(/\[a[:=]7\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkorange">$1</span>');
	//Jaune :
	apercu_message = apercu_message.replace(/\[a[:=]8\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:yellow">$1</span>');
	//Vert fluo :
	apercu_message = apercu_message.replace(/\[a[:=]9\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lime">$1</span>');
	//Bleu-vert (darkcyan, le plus fort des hroooos xD)
	apercu_message = apercu_message.replace(/\[a[:=]10\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkcyan">$1</span>');
	//Cyan :
	apercu_message = apercu_message.replace(/\[a[:=]11\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:aqua">$1</span>');
	//Bleu :
	apercu_message = apercu_message.replace(/\[a[:=]12\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:blue">$1</span>');
	//Fuchsia :
	apercu_message = apercu_message.replace(/\[a[:=]13\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:fuchsia">$1</span>');
	//Gris (fonc) :
	apercu_message = apercu_message.replace(/\[a[:=]14\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gray">$1</span>');
	//Gris clair :
	apercu_message = apercu_message.replace(/\[a[:=]15\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightgrey">$1</span>');
	//Gris encore plus clair :
	apercu_message = apercu_message.replace(/\[a[:=]16\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gainsboro">$1</span>');
	//Gris clair 'le mme que le 15 mais faut bien afficher ce que a affiche xD) :
	apercu_message = apercu_message.replace(/\[a[:=]17\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightgrey">$1</span>');
	//Saumon :
	apercu_message = apercu_message.replace(/\[a[:=]18\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:navajowhite">$1</span>');
	//Rose clair  la "rose saumon" :
	apercu_message = apercu_message.replace(/\[a[:=]19\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightpink">$1</span>');
	//Rose ple (c'est du violet clair mais bon xD) :
	apercu_message = apercu_message.replace(/\[a[:=]20\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:violet">$1</span>');
	//Violet clair :
	apercu_message = apercu_message.replace(/\[a[:=]21\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:violet">$1</span>');
	//Turquoise ple :
	apercu_message = apercu_message.replace(/\[a[:=]22\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#afeeee">$1</span>');
	//Vert ple :
	apercu_message = apercu_message.replace(/\[a[:=]23\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:palegreen">$1</span>');
	//Jaune ple :
	apercu_message = apercu_message.replace(/\[a[:=]24\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:palegoldenrod">$1</span>');
	//Gris-argent :
	apercu_message = apercu_message.replace(/\[a[:=]25\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:silver">$1</span>');
	//Gris-gris fonc :
	apercu_message = apercu_message.replace(/\[a[:=]26\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkgray">$1</span>');
	//Orange ple :
	apercu_message = apercu_message.replace(/\[a[:=]27\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:sandybrown">$1</span>');
	//Rose/rouge/saumon :
	apercu_message = apercu_message.replace(/\[a[:=]28\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:salmon">$1</span>');
	//Rose :
	apercu_message = apercu_message.replace(/\[a[:=]29\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:violet">$1</span>');
	//Bleu-violet :
	apercu_message = apercu_message.replace(/\[a[:=]30\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:mediumslateblue">$1</span>');
	//Turquoise clair/marine :
	apercu_message = apercu_message.replace(/\[a[:=]31\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:aquamarine">$1</span>');
	//Vert clair :
	apercu_message = apercu_message.replace(/\[a[:=]32\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lightgreen">$1</span>');
	//Jaune un peu ple :
	apercu_message = apercu_message.replace(/\[a[:=]33\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#f9ff57">$1</span>');
	//Gris (encore !!) :
	apercu_message = apercu_message.replace(/\[a[:=]34\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gray">$1</span>');
	//Gris (... et encore ...) :
	apercu_message = apercu_message.replace(/\[a[:=]35\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:gray">$1</span>');
	//Orange (normal) :
	apercu_message = apercu_message.replace(/\[a[:=]36\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:orange">$1</span>');
	//Rouge/orange :
	apercu_message = apercu_message.replace(/\[a[:=]37\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:orangered">$1</span>');
	//Fuchsia (et oui, encore xD) :
	apercu_message = apercu_message.replace(/\[a[:=]38\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:fuchsia">$1</span>');
	//Bleu (marine normalement mais bleu) :
	apercu_message = apercu_message.replace(/\[a[:=]39\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:blue">$1</span>');
	//Vert-turquoise :
	apercu_message = apercu_message.replace(/\[a[:=]40\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:mediumspringgreen">$1</span>');
	//Vert clair / vers le fluo :
	apercu_message = apercu_message.replace(/\[a[:=]41\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:lawngreen">$1</span>');
	//Jaune xD :
	apercu_message = apercu_message.replace(/\[a[:=]42\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:yellow">$1</span>');
	//Gris (dimgray) :
	apercu_message = apercu_message.replace(/\[a[:=]43\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:dimgray">$1</span>');
	//Gris (pareil xD) :
	apercu_message = apercu_message.replace(/\[a[:=]44\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:dimgray">$1</span>');
	//Ocre :
	apercu_message = apercu_message.replace(/\[a[:=]45\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:goldenrod">$1</span>');
	//Rouge :
	apercu_message = apercu_message.replace(/\[a[:=]46\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:red">$1</span>');
	//Rose / fuchsia :
	apercu_message = apercu_message.replace(/\[a[:=]47\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:fuchsia">$1</span>');
	//Bleu indigo :
	apercu_message = apercu_message.replace(/\[a[:=]48\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:mediumblue">$1</span>');
	//Vert "d'eau" :
	apercu_message = apercu_message.replace(/\[a[:=]49\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#02cc88">$1</span>');
	//Vert olive :
	apercu_message = apercu_message.replace(/\[a[:=]50\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#58d80c">$1</span>');
	//Vert olive plus fonc :
	apercu_message = apercu_message.replace(/\[a[:=]51\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#49b00a">$1</span>');
	//Noir clair :
	apercu_message = apercu_message.replace(/\[a[:=]52\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#333335">$1</span>');
	//Noir clair (ouais encore xD) :
	apercu_message = apercu_message.replace(/\[a[:=]53\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#333335">$1</span>');
	//Marron :
	apercu_message = apercu_message.replace(/\[a[:=]54\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:saddlebrown">$1</span>');
	//Rouge Bordeaux :
	apercu_message = apercu_message.replace(/\[a[:=]55\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#8b0000">$1</span>');
	//Violet / magenta fonc :
	apercu_message = apercu_message.replace(/\[a[:=]56\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkmagenta">$1</span>');
	//Bleu marine :
	apercu_message = apercu_message.replace(/\[a[:=]57\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:darkblue">$1</span>');
	//Vert penchant vers "teal" :
	apercu_message = apercu_message.replace(/\[a[:=]58\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#00885e">$1</span>');
	//Vert un peu olive :
	apercu_message = apercu_message.replace(/\[a[:=]59\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#379600">$1</span>');
	//Vert caca d'oie (beurk) :
	apercu_message = apercu_message.replace(/\[a[:=]60\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#999e14">$1</span>');
	//Marron / brun clair :
	apercu_message = apercu_message.replace(/\[a[:=]61\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#473400">$1</span>');
	//Brun / marron-rouge :
	apercu_message = apercu_message.replace(/\[a[:=]62\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#4d0000">$1</span>');
	//Violet fonc :
	apercu_message = apercu_message.replace(/\[a[:=]63\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#5f0062">$1</span>');
	//Bleu trs fonc :
	apercu_message = apercu_message.replace(/\[a[:=]64\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#000047">$1</span>');
	//Vert fonc :
	apercu_message = apercu_message.replace(/\[a[:=]65\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#05502e">$1</span>');
	//Vert / vert kaki :
	apercu_message = apercu_message.replace(/\[a[:=]66\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#1c5300">$1</span>');
	//Vrai kaki / marron
	apercu_message = apercu_message.replace(/\[a[:=]67\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:#544d04">$1</span>');
	//Noir :
	apercu_message = apercu_message.replace(/\[a[:=]68\](.+)\[\/a(?:[:=]0)?\]/gi, '<span style="background-color:black">$1</span>');
		
		//1 minute chrono !! =P
		//Hum j'oublie l'appel par nom et hxadcimal, allez, vite fait :
		
		//Le nom : 
		
	apercu_message = apercu_message.replace(/(?:\[a[:=](red|green|blue|purple|yellow|olive|yellowgreen|white|turquoise|teal|pink|orange|navy|magenta|indigo|gold|fuchsia|gray|cyan|chocolate|brown|black|aqua)\])(.+)(?:\[\/a(?:=(?:5|(?:$1)))?\])/gi, '<span style="background-color:$1">$2</span>');
	
		//L'hxadcimal :
		
	apercu_message = apercu_message.replace(/\[a[:=](\#[0-9a-f]{6})\](.+)\[\/a(?:[:=](\#[0-9a-f]{6}))?\]/gi, '<span style="background-color:$1">$2</span>');
	
		
		//Ben voil =P
		//On a quand les liens hypertexte et les smileys  rajouter :
		
	//Bon, voil pour les liens :
	apercu_message = apercu_message.replace(/(http:\/\/[a-z0-9._\/-]+\.[a-z0-9._\/-]+[a-z0-9?&=_-]*)/gi, '<a href="../../$1">$1</a>');
	
	
	//Trs bien. Maintenant, on finit par les smileys :
	
	//Le smiley ^^
	apercu_message = apercu_message.replace(/\^\^/gi, '<img src="http://www.pcconviction.com/Smileys/^^.gif" alt="^^" />');
	//-_- 
	apercu_message = apercu_message.replace(/\-_\-/gi, '<img src="http://www.pcconviction.com/Smileys/-_-.gif" alt="-_-" />');
	//=P
	apercu_message = apercu_message.replace(/[:=]p/gi, '<img src="http://www.pcconviction.com/Smileys/=P.gif" alt="=P" />');
	//;)
	apercu_message = apercu_message.replace(/;\)/gi, '<img src="http://www.pcconviction.com/Smileys/Clin_d\'oeil.gif" alt=";)" />');
	//:) =)
	apercu_message = apercu_message.replace(/:\)/gi, '<img src="http://www.pcconviction.com/Smileys/Content1.gif" alt=":)" />');
	apercu_message = apercu_message.replace(/=\)/gi, '<img src="http://www.pcconviction.com/Smileys/Content1.gif" alt="=)" />');
	//:(  =(
	apercu_message = apercu_message.replace(/[=:][@(]/gi, '<img src="http://www.pcconviction.com/Smileys/Pas_content.gif" alt=":(" />');
	//:D
	apercu_message = apercu_message.replace(/[:=]d/gi, '<img src="http://www.pcconviction.com/Smileys/Sourire_chinois.gif" alt=":D" />');
	//Gn
	apercu_message = apercu_message.replace(/[:=]\$/gi, '<img src="http://www.pcconviction.com/Smileys/euh.gif" alt="=$" />');
	//Oo
	apercu_message = apercu_message.replace(/ Oo/g, ' <img src="http://www.pcconviction.com/Smileys/Oo.gif" alt="Oo" />');
	//Rouge avec panneau "Censur"
	apercu_message = apercu_message.replace(/:censure:/gi, '<img src="http://www.pcconviction.com/Smileys/Censure.gif" alt="Censur" />');
	//Gras qui siffle l'air de rien
	apercu_message = apercu_message.replace(/:siffle:/gi, '<img src="http://www.pcconviction.com/Smileys/siffleAirDeRien.gif" alt="Siffle l\'air de rien" />');
	
	return apercu_message;
}