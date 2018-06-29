function check_link()
{
	var elements = document.getElementsByClassName('retour');
	for (var i=0;i < elements.length ;i++)
	{
		elements[i].onclick=function ()
		{
			if(window.opener)
			{
				window.opener.location=this.href;
				window.opener.focus();
				window.close();
				return false;
			}
		};
	}
}
window.onload=check_link;