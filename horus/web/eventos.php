<?php
include ("conexion.php");

$ResEvento=mysql_query("SELECT * FROM eventos WHERE Consecutivo='".$_GET["evento"]."'");
$RResEvento=mysql_fetch_array($ResEvento);

echo '<div id="detevento" style="background-image: url(images/eventos.jpg); background-repeat: no-repeat; width="100%>
				<p>&nbsp;
				<p>&nbsp;
				<table border="0" cellpading="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top" width="20%">
							<img src="images/eventos/'.$RResEvento["Imagen"].'" border="0" width="100" height="100">
						</td>
						<td valign="top" class="textox">
							<p class="textoevento1">'.htmlentities($RResEvento["Nombre"]).'
							<p><span class="textox">Fecha:</span>&nbsp;<span class="textoy">'.$RResEvento["Fecha"].'</span><br />
							<span class="textox">Lugar:</span>&nbsp;<span class="textoy">'.htmlentities($RResEvento["Lugar"]).'</span>
							<p align="justify"><span class="textox">Descripci&oacute;n del Evento:</span><br />&nbsp;<br /><span class="textoy">'.htmlentities($RResEvento["Descripcion"]).'</span>
						</td>
					</tr>
				</table>
				<p>&nbsp;
				<table border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td colspan="3" bgcolor="#CCCCC" class="textox" align="center">Mas eventos...</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td class="textox" align="center" width="20%">&nbsp;Fecha&nbsp;</td>
						<td class="textox" align="center" width="20%">&nbsp;Lugar&nbsp;</td>
						<td class="textox" align="center" width="60%">&nbsp;Evento&nbsp;</td>
					</tr>';
$ResEventos=mysql_query("SELECT Nombre, Fecha, Lugar FROM eventos ORDER BY Fecha DESC LIMIT 5");
while($RResEventos=mysql_fetch_array($ResEventos))
{
	echo '<tr bgcolor="#33CCCC">
					<td class="textoevento2" align="center" width="20%">&nbsp;'.$RResEventos["Fecha"].'&nbsp;</td>
					<td class="textoevento2" align="center" width="20%">&nbsp;'.htmlentities($RResEventos["Lugar"]).'&nbsp;</td>
					<td class="textoevento2" align="left" width="60%">&nbsp;'.htmlentities($RResEventos["Nombre"]).'&nbsp;</td>
				</tr>';
}
	echo '</table>
			</div>';
?>