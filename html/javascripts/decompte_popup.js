// JavaScript Document
function decompte()
{
	compteur--;
				
	if(compteur > 0)
	{
		document.getElementById('info').innerHTML = 'Vous serez crédité(e) dans '+compteur+' secondes. Visitez le site ci-dessous en attendant. <img src=http://www.pcconviction.com/smileys/Content1.gif />';
	}
	else
	{
		end_interval();
		document.getElementById('compteur').submit();
	}
}
function presence_pub()
{
	try
	{
		/**/
		if(window.opera)
		{
			if(window.pub.name=="pub")
			{
				decompte();
				window.pub.focus();
			}
			else
			{
				end_interval();
				if(window.pub.name=='')
				{
					document.getElementById('info').innerHTML = 'Vous avez fermé la publicité avant la fin du temps imparti. Merci d\'attendre jusqu\'à la fin du compteur (pub.name==\'\')';
				}
				else
				{
					document.getElementById('info').innerHTML = 'Merci d\'utiliser OPERA, le meilleur navigateur au monde. Cependant votre bloqueur de popups est activé, Merci d\'appuyer sur F12 afin de le désactiver et profiter ainsi de vos clics remunérés';
				}
			
			}
		}
		else
		{
		/**/
			if(window.pub.closed==true)
			{
				end_interval();
				document.getElementById('info').innerHTML = 'Vous avez fermé la publicité avant la fin du temps imparti. Merci d\'attendre jusqu\'à la fin du compteur';
			}
			else
			{
				decompte();
				window.pub.focus();
			}
		/**/
		}
		/**/
	}
	catch(e)
	{
		end_interval();
		document.getElementById('info').innerHTML = 'Une erreur javascript s\'est produite merci de la signaler au webmasteur : [' + e + ']';
	}
}
function set_interval()
{
	window.timer = window.setInterval(presence_pub,1000);
}
function end_interval()
{
	window.timer = window.clearInterval(window.timer);
}
function start()
{
	window.pub = window.open('pub.php?pub_id=' + pub_id,'pub');
	if(window.pub)
	{
		set_interval();
	}
	else
	{
		document.getElementById('info').innerHTML = 'Votre navigateur utilise un bloqueur de Popup. Pensez à la désactivez pour profiter de vos clics remunérés';
	}
}
window.onload = start;