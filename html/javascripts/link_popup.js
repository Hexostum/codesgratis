// JavaScript Document
function verif()
{
	var elements = document.getElementsByClassName('lien_popup');
	for (var i=0;i < elements.length ;i++)
	{
		elements[i].onclick=function()
		{
			window.open(this.href + '&mode=popup', 'popup', 'scrollbars=yes, width=900px, height=90px');
			return false;
		};
	}
}
window.onload=verif;