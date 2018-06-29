<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);

include(FP_CHEMIN_PHP . 'page_start' . '.php');
$contenu_texte[] = 
<<<EOD
			<h1>Le réglement sur CodesGratis</h1>
			
			<p>J'ai bien conscience du fait que les règlements sont très ennuyants à lire, mais, si vous ne lisez pas 
			tout, je vous demanderai de prendre au moins connaissance des règles du jeu (c'est quand même le 
			minimum, quand on joue à quelque chose ^^). Mesdames, Mesdemoiselles, Messieurs, devant vos yeux 
			éblouis, voici ... Le réglement de CodesGratis !! =)</p>
			
			<h3>Sommaire</h3>
			<h5><a href="#art1">Informations sur CodesGratis</a></h5>
			<h5><a href="#art2">Respect de la vie privée des joueurs</a></h5>
			<h5><a href="#art3">Règles du jeu</a></h5>
			<h5><a href="#art9">Le parrainage</a></h5>
			<h5><a href="#art4">Obtention des gains</a></h5>
			<h5><a href="#art5">Répression des fraudes</a></h5>
			<h5><a href="#art6">La vie dans la communauté de CodesGratis</a></h5>
			<h5><a href="#art7">Exclusivité sur les CGcodes</a></h5>
			<h5><a href="#art8">Mise à jour du règlement</a></h5>
			<h5><a href="#art9">Contacter l'administrateur</a></h5>
			
			<h3 id="art1">Informations sur CodesGratis</a></h3>
			
			<p>CodesGratis est un site créé et administré par un Auto-entrepreneur (dénommé ci-après Exostum). Les informations concernant l'entreprise sont disponibles 
			ici : <a href="http://www.exostum.net">Exostum</a>
			</p>
			
			<p>Exostum garantie la sanitude et l'honnêteté de son site envers ses joueurs, tout 
			comme envers ses visiteurs, bien entendu.</p>
			
			<p>Il vous est donc garanti que CodesGratis ne présente aucun danger potentiel pour quiconque.</p>
			
			<h3 id="art2">Respect de la vie privée des joueurs</h3>
				
			<p>En aucun cas CodesGratis ne dévoilera autre information que le pseudonyme, le nombre de points ainsi 
			que les dates d'inscription et de dernière connexion sur ses membres.</p>
			
			<p>Plus particulièrement, l'<strong>adresse courriel que vous spécifiez à votre inscription ne sera utilisée 
			que dans les buts de vous envoyer vos gains ou de répondre à vos mails dans le cas où vous en auriez envoyé
			</strong>. Dans la même optique, <em>CodesGratis se refuse à des envois massifs de mails à ses 
			membres</em> (tels que des newsletters).</p>
			
			<h3 id="art3">Règles du jeu</h3>
				
			<p>Les règles du jeu sont simples : à votre inscription, un lien propre à votre compte vous est fourni. 
			Ce lien sera de la forme suivante http://www.codesgratis.fr/pages.php?membre_id=membre_id où membre_id sera votre numéro de membre.</p>
			
			<p>Vous devrez amener les gens à visiter la page de ce lien, de manière à gagner un point à chaque visite 
			unique (un visiteur ne peut vous faire remporter qu'un point toutes les 24h) de la page. Vous accumulerez 
			ainsi les points qui, lorsqu'ils seront en nombre suffisant (à partir de 60 points seulement !), pourront 
			être échangés contre un (ou des) code(s) de votre choix dans la vitrine.</p>
			
			
			<p>Vous obtiendrez ce code dans un délai de trois semaines maximum (le délai réel peut être bien plus 
			court, cela dépend de la disponibilité du webmaster). Si ce délai n'est pas respecté, vous serez 
			remboursé de 30% du nombre de points dépensés. 
			<a href="#art4">Voyez ici pour plus d'informations sur l'obtention des gains</a>.</p>
			
			<p><a href="#art5">Toute forme de fraude sera réprimée.</a></p>
			
			<h3 id="art9">Le parrainage</h3>
				
			<p>Vous gagnez 0.3 points à chaque affichage de la page perso de vos filleuls, ou à chaque clic 
			rémunéré qu'ils effectuent !</p>
			
			<p><strong>Vos filleuls n'y perdent rien, c'est CodesGratis qui offre !</strong></p>
			
			<p>Seulement, quelques règles s'imposent pour modérer certains comportements ...</p>
			
			<p>Ainsi, tout membre surpris en possession de plusieurs comptes pour lui seul sera sévèrement 
			puni, les sanctions pouvant aller de la suppression des comptes en trop, à la suspension du 
			membre.</p>
			
			<p>De plus, les points gagnés grâce à filleul les gagnant frauduleusement seront 
			retirés du compte du parrain sans préavis, ni réclamation possible. Tout le monde ne pourra s'en 
			prendre qu'au fraudeur.</p>
			
			<h3 id="art4">Obtention des gains</h3>
				
			<p>Lorsque vous aurez assez de points pour les échanger contre un code (60 points minimum), vous en serez 
			informés dans les informations sur votre compte dans le menu à gauche (lorsque vous êtes connecté).</p>
			
			<p>Un lien avec le texte "Cliquez ici pour échanger vos points contre le(s) code(s) de votre choix !" 
			apparaîtra alors dans ce même menu. Lorsque vous cliquerez dessus, vous atteindrez une page vous listant 
			tous les codes que vous avez les moyens d'obtenir. Il vous suffira alors de cliquer sur le lien 
			"Commander" de la ligne correspondant au code que vous désirez, puis de confirmer votre commande en 
			cliquant sur le lien "Oui, c'est bien cela. Je confirme ma commande.", et celle-ci sera mise sur la file 
			d'attente.</p>
			
			<p>Vous vous verrez alors débité du nombre de points correspondant au coût du code commandé.</p>
			
			<p>Ce sera alors le webmaster du site qui se chargera de satisfaire votre commande en vous envoyant votre 
			code par mail (assurez-vous donc que l'adresse mail que vous avez spécifiée est bien correcte) dans un 
			délai de trois semaines maximum (le délai réel peut être bien plus court, cela dépend de la 
			disponibilité du webmaster). Dépassé ce délai, vous serez remboursé de 30% du 
			nombre de points dépensés, et votre code sera tout de même livré, bien entendu.</p>
			
			<h3 id="art5">Répression des fraudes</h3>
				
			<p>Tout utilisateur suspecté de spam sera, si cela est prouvé, averti (par courriel) et sanctionné (voir les 
			sanctions plus loin).</p>
			
			<p>Les points gagnés grâce à filleul les gagnant frauduleusement seront 
			retirés du compte du parrain sans préavis, ni réclamation possible. Tout le monde ne pourra s'en 
			prendre qu'au fraudeur.</p>
			
			<p>Tout membre surpris en possession de plusieurs comptes pour lui seul sera sévèrement 
			puni, les sanctions pouvant aller de la suppression des comptes en trop, à la suspension du 
			membre.</p>
			
			<p>Toutes pratiques telles que le picturing, la simulation de clics, et ce parmi une liste 
			non exhaustive, en bref, toute pratique par laquelle les points sont gagnés automatiquement est 
			prohibée et sera punie.</p>
			
			<p>Les autosurfs ne sont tolérés que dans un maximum de 50 affichages via les autosurfs chaque jour 
			pour chaque membre.</p>
			
			<p>L'usage de frame est autorisé dans des conditions qui se veulent strictes : la frame doit faire, au 
			minimum, 80% de la largeur de la page, qui ne doit pas être large de moins de 600px, sur 500px de 
			hauteur, le scrolling doit être actif, et un nombre de 3 frames maximum par pages (que ce soit 
			celle de CodesGratis où d'autres sites) est imposé.</p>
			
			<p>Les sanctions que CodesGratis se réserve le droit de prendre contre ces fraudes sont, dans un ordre 
			croissant suivant la gravité des faits :</p>
			
			<ul>
				<li>L'avertissement par mail de l'utilisateur.</li>
				<li>La diminution des points de l'utilisateur, pouvant aller jusqu'à la suppression complète de ses 
				points, si cela est jugé nécessaire.</li>
				<li>Dans la même visée, l'annulation des commandes en cours de traitement, si les codes concernés 
				s'avèrent avoir été gagnés par supercherie.</li>
				<li>La suppression du compte de l'utilisateur en cas de récidive, ou dans des cas extrêmes.</li>
			</ul>
			
				<h3 id="art6">La vie dans la communauté de CodesGratis</h3>
				
			<p>Lorsque vous participez à la vie du site en postant dans le forum, en laissant des commentaire de 
			news, ou encore un ou des message(s) dans le livre d'or, vous êtes prié de respecter les règles 
			suivantes, sous peine de sanctions :</p>
			
			<ul>
				<li>Respecter les règles élémentaires de politesse ("bonjour", "merci", ça ne coûte rien mais 
				c'est toujours agréable pour les autres).</li>
				<li>Pas d'injures de quelque sorte qu'elles soient (générales, raciales, discriminatoires ...) ! </li>
				<li>Lorsque vous laissez un message dans le livre d'or, si celui-ci est une critique négative, vous 
				êtes prié de développer vos arguments. En effet, les messages tels que "CodesGratis, c'est naze." 
				seront effacés sans avis préalable. Il n'est cependant pas interdit de critiquer : un message 
				négatif aura sa place dans le livre d'or s'il est écrit intelligemment.</li>
			</ul>
			
				<h3 id="art7">Exclusivité sur les CGcodes</h3>
				
			<p>L'exclusivité de la vente de CGcodes, codes du site, revient à moi-même, le webmaster, FLo, les 
			CGcodes que vous possédez sont destinés pour une utilisation personnelle.</p>
			
			<p>Les sites de jeux cependant sont autorisés à en faire un lot pour les gagnants, mais en aucun cas 
			ces codes ne peuvent être vendus en dur, si le vendeur n'est pas moi-même.</p>
			
				<h3 id="art8">Mise à jour du règlement</h3>
				
			<p>En acceptant les conditions du présent règlement, vous admettez également que celui-ci n'est pas 
			définitif et vous vous engagez à respecter les règles qui seront ajoutées par la suite (ce qui ne 
			devrait poser aucun problème pour un membre respectant les règles actuelles).</p>
			
				<h3 id="art9">Contacter l'administrateur</h3>
				
			<p>Si vous avez une question, un problème, ou autre, vous pouvez contacter l'administrateur de 
			CodesGratis à cette adresse : <a id="webmaster_courriel">Chargement en cours (JAVASCRIPT REQUIS)</a>.</p>
EOD;
include(FP_CHEMIN_PHP . 'page_end' . '.php');
?>