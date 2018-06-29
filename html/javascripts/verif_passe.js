// JavaScript Document
function verif_passe(element)
{
	var motdepasse = element.value;
	if(motdepasse.match(/^.{8,40}$/i))
	{
		document.getElementById('infos_'+element.id).innerHTML = '<span style="color:green">Ce mot de passe a la longueur requise.</span>';
		return true;
	}
	else
	{
		document.getElementById('infos_'+element.id).innerHTML = '<span style="color:red">Votre mot de passe est trop court. Celui-ci doit être compris entre 8 et 40 caractres.</span>';		
		return false;
	}
}