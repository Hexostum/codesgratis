<?php
function form_confirm($sql_code,$cout,$qte)
{
	return
<<<EOD
<form action="commande.php?code_id={$sql_code->code_id}" method="post">
<table>
<tr>
	<th colspan="2">Commande de {$sql_code->code_designation}</th>
</tr>
<tr>
	<td>Cout : </td>
	<td>{$cout}</td>
</tr>
<tr>
	<td>Quantité (MAX : $qte)</td>
	<td><input type="text" id="codes_qte" name="codes_qte" value="1"></td>
</tr>
<tr>
	<td colspan="2"><input type="checkbox" name="confirm_commande" id="confirm_commande">Oui c'est bien cela. Je confirme ma commande</td></tr>
	<tr><td colspan="2"><input type="checkbox" name="commande_points_plus" id="commande_points_plus">Payer avec des points plus</td></tr>
<tr>
	<td colspan="2"><input type="submit" name="submit_commande" id="submit_commande" value="commander"></td>
</tr>
</table>
</form>
EOD;
}
?>