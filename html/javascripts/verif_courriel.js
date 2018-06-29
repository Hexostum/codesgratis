// JavaScript Document
function verif_courriel(element)
{
	var courriel = element.value;
	if(courriel.match(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z0-9._-]{2,4}$/i))
	{
		document.getElementById('infos_'+element.id).innerHTML = '<span style="color:green">Forme de l\'adresse (utilisateur@domaine.extension) O.K.</span>';
	}
	else
	{
		document.getElementById('infos_'+element.id).innerHTML = '<span style="color:red">Mauvaise forme de l\'adresse (utilisateur@domaine.extension).</span>';		
	}
}