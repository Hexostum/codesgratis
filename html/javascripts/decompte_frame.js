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
		window["interval"]=null;
		document.getElementById('compteur').submit();
	}
}
function start()
{
	window["interval"] = setInterval(decompte,1000);
}