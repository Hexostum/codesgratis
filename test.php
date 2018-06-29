<html>
<head>
<script type="text/javascript">
window.test1 = window.open("popup.html","nom_popup","width=200, height=200");


function Scanner() 
{
    if (window.test1.closed) 
	{
     	alert("Le popup a été fermé");
    } 
	else 
	{
    	setTimeout("Scanner()",1000);
	}
}
 setTimeout("Scanner()",1000);
</script>
</head>
<body></body>
</html>