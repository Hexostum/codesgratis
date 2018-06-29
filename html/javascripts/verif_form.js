// JavaScript Document
function verif_form(form)
{
	var flag=true;
	for (var i=0; i < form.elements.length; i++)
	{
		element = form.elements[i];
		if(element.getAttribute('class')=='password')
		{
			flag = (flag && verif_passe(element));
		}
		if(element.getAttribute('class')=='t_courriel')
		{
			flag = (flag && verif_courriel(element.id))	
		}
	}
	return flag;		
}