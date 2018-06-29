if(!document.getElementsByClassName)
{
	document.getElementsByClassName = function(nomClasse, element) 
	{
		var resultat = [];
		if(nomClasse!="") 
		{
			if(!(typeof element == 'object'))
			{
					element = document;
			}
		    var mesFils = element.getElementsByTagName('*');
		    var exp_reg = new RegExp("(^|\\s)" + nomClasse + "(\\s|$)");
		    for (var i = 0; i < mesFils.length; i++) 
			{
		      var laClasse = (mesFils[i].className) ? mesFils[i].className : "";
		      if(laClasse != "" && (laClasse == nomClasse || laClasse.match(exp_reg)))
			  {
		        resultat[resultat.length] = mesFils[i];
		      }
		    }
		}
		return resultat;
	};
}