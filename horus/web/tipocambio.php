<?php
function tipocambio()
{
	include("conexion.php");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<td align="center" class="textotitpanel" bgcolor="#0284c2">Tipo de Cambio</td>
	</tr>
	<tr>
		<td align="left" bgcolor="#CCCCCC" class="texto2">';
	$ResTipo=mysql_query("SELECT Descripcion FROM Parametos WHERE PerteneA='Tipo de Cambio'");
	$RResTipo=mysql_fetch_array($ResTipo);
	$cadena.='<form id="tcambio">
							&nbsp; Tipo de Cambio: <input type="text" size="5" name="tcambio"><input type="button" value="Modificar>>" name="butmodtipo">';
}
?>
