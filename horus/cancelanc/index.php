<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php
	include ("../conexion.php");

echo '<form name="fcancelanc" id="fcancelanc" action="index.php" method="POST">
		Mes a cancelar: <select name="mes" id="mes">
			<option value="01"';if($_POST["mes"]=='01'){echo 'selected';}echo '>Enero</option>
			<option value="02"';if($_POST["mes"]=='02'){echo 'selected';}echo '>Febrero</option>
			<option value="03"';if($_POST["mes"]=='03'){echo 'selected';}echo '>Marzo</option>
			<option value="04"';if($_POST["mes"]=='04'){echo 'selected';}echo '>Abril</option>
			<option value="05"';if($_POST["mes"]=='05'){echo 'selected';}echo '>Mayo</option>
			<option value="06"';if($_POST["mes"]=='06'){echo 'selected';}echo '>Junio</option>
			<option value="07"';if($_POST["mes"]=='07'){echo 'selected';}echo '>Julio</option>
			<option value="08"';if($_POST["mes"]=='08'){echo 'selected';}echo '>Agosto</option>
			<option value="09"';if($_POST["mes"]=='09'){echo 'selected';}echo '>Septiembre</option>
			<option value="10"';if($_POST["mes"]=='10'){echo 'selected';}echo '>Octubre</option>
			<option value="11"';if($_POST["mes"]=='11'){echo 'selected';}echo '>Noviembre</option>
			<option value="12"';if($_POST["mes"]=='12'){echo 'selected';}echo '>Diciembre</option>
		</select> <select name="anno" id="anno">'; 
for($i=2014; $i<=date("Y"); $i++)
{
	echo '	<option value="'.$i.'"';if($_POST["anno"]==$i){echo 'selected';}echo '>'.$i.'</option>';
}
echo '	</select> Sucural: <select name="sucursal" id="sucursal">';
$ResSucursales=mysql_query("SELECT Id, Nombre FROM sucursales ORDER BY Nombre ASC");
while($RResSucursales=mysql_fetch_array($ResSucursales))
{
	echo '<option value="'.$RResSucursales["Id"].'"';if($RResSucursales["Id"]==$_POST["sucursal"]){echo ' selected';}echo '>'.$RResSucursales["Nombre"].'</option>';
}
echo '</select> <input type="submit" name="butconfact" id="butconfact" value="Consultar>>">
</form>';

if(isset($_POST["butconfact"]))
{
	echo '<table border="2" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
			<tr>
				<td align="center" bgcolor="#A9A9A9">&nbsp;</td>
				<td align="center" bgcolor="#A9A9A9">Num. Factura</td>
				<td align="center" bgcolor="#A9A9A9">Fecha</td>
				<td align="center" bgcolor="#A9A9A9">Cliente</td>
				<td align="center" bgcolor="#A9A9A9">Subtotal</td>
				<td align="center" bgcolor="#A9A9A9">Iva</td>
				<td align="center" bgcolor="#A9A9A9">Total</td>
				<td align="center" bgcolor="#A9A9A9">&nbsp;</td>
			</tr>';
	
	$ResNC=mysql_query("SELECT Id, Serie, NumNota, Cliente, Fecha, Importe, Iva, Total FROM nota_credito WHERE Sucursal='".$_POST["sucursal"]."' AND Status='Cancelada' AND Fecha LIKE '".$_POST["anno"]."-".$_POST["mes"]."%' AND XML LIKE '%UUID%' AND AcuseCancela='' ORDER BY NumNota ASC");
	$bgcolor="#FFFFFF"; $A=1;
	while($RResNC=mysql_fetch_array($ResNC))
	{
		$cliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResNC["Cliente"]."' LIMIT 1"));
		
		echo '<tr>
				<td align="center" bgcolor="'.$bgcolor.'">'.$A.'</td>
				<td align="center" bgcolor="'.$bgcolor.'">'.$RResNC["Serie"].' '.$RResNC["NumNota"].'</td>
				<td align="center" bgcolor="'.$bgcolor.'">'.$RResNC["Fecha"][8].$RResNC["Fecha"][9].'-'.$RResNC["Fecha"][5].$RResNC["Fecha"][6].' '.$RResNC["Fecha"][0].$RResNC["Fecha"][1].$RResNC["Fecha"][2].$RResNC["Fecha"][3].'</td>
				<td align="left" bgcolor="'.$bgcolor.'">'.$cliente["Nombre"].'</td>
				<td align="right" bgcolor="'.$bgcolor.'">$ '.number_format($RResNC["Importe"],2).'</td>
				<td align="right" bgcolor="'.$bgcolor.'">$ '.number_format($RResNC["Iva"],2).'</td>
				<td align="right" bgcolor="'.$bgcolor.'">$ '.number_format($RResNC["Total"],2).'</td>
				<td align="right" bgcolor="'.$bgcolor.'"><a href="cancelacion.php?idnota='.$RResNC["Id"].'&mes='.$_POST["mes"].'&anno='.$_POST["anno"].'&sucursal='.$_POST["sucursal"].'">Cancelar</a></td>
			</tr>';
			
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
		$A++;
	}
	
	echo '</table>';
}
?>