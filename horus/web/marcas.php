<?php

	include ("conexion.php");
	
	$ResMarca=mysql_query("SELECT * FROM marcas WHERE Consecutivo='".$_GET["marca"]."'");
	$RResMarca=mysql_fetch_array($ResMarca);	
	
	echo '<img src="images/barramarcas.jpg" border="0">
	<p align="right"><img src="images/'.$RResMarca["Logo"].'">
	<p align="left" class="textox">'.$RResMarca["Nombre"].'
	<p align="left" class="textox">'.$RResMarca["Desc_corta"].'
	<p align="left" class="textox">'.$RResMarca["Desc_larga"].'
	<p align="left" class="textox">'.$RResMarca["Productos"].'
	<p>&nbsp;
	<table border="0" cellspacing="0" cellpading="0" width="80%" align="center">
	<tr><td align="center" class="textox" bgcolor="#CCCCCC">&nbsp;Lineas de Productos&nbsp;</td></tr>
	<tr><td align="left" class="textoboton">';
$ResLineas=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE Nombre='".$RResMarca["Nombre"]."' AND PerteneceA='lineas' ORDER BY Descripcion ASC");
while($RResLineas=mysql_fetch_array($ResLineas))
{
	echo '<a href="#" onclick="xajax_productos_linea(\''.$RResLineas["Consecutivo"].'\')">'.htmlentities($RResLineas["Descripcion"]).'</a><br />';
}
	echo '</td></tr></table>
	<p>&nbsp;';
	
	$ResDocumentos=mysql_query("SELECT * FROM documentos WHERE PerteneceA='marca' AND Consecutivo ='".$_GET["marca"]."' ORDER BY Nombre ASC");
if(mysql_num_rows($ResDocumentos)!=0)
{
	echo'				<table border="0" cellpading="0" cellspacing="0" width="80%" align="center">
								<tr><td bgcolor="#CCCCCC" class="textox" align="center">&nbsp;Documentaci&oacute;n</td></tr>
								<tr><td align="left" class="textoboton">
									<p>';

	while($RResDocumentos=mysql_fetch_array($ResDocumentos))
	{
		if($_SESSION["autentificado"]=="SI" AND $RResDocumentos["Tipo"]=='privado')
		{
			echo '<a href="Documentos/'.$RResDocumentos["Archivo"].'" target="_blank">';
		}
		else if($RResDocumentos["Tipo"]=='publico')
		{
			echo'<a href="Documentos/'.$RResDocumentos["Archivo"].'" target="_blank">';
		}
		echo $RResDocumentos["Nombre"].'</a><br />';
	}
	echo '</td></tr></table>';
}
?>