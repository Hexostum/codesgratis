// JavaScript Document
function est_identique(id)
{
	var id_1 = id + '[' + 1 + ']' ;
	var id_2 = id + '[' + 2 + ']' ;
	if(document.getElementById(id_1).value==document.getElementById(id_2).value)
	{
		return true;
	}
	else
	{
		window.alert('les deux champs doivent être identiques');
		return false;
	}
}