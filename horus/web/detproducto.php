<?php
include ("conexion.php");

$ResProducto=mysql_query("SELECT * FROM productos WHERE Consecutivo='".$_GET["producto"]."'");
$RResProducto=mysql_fetch_array($ResProducto);

if ($_GET["destacado"]==1)
{
	$image='images/prd_destacados.jpg';
}
else if ($_GET["novedad"]==1)
{
	$image='images/novedades.jpg';
}
else 
{
	$image='images/bdetallesdelproducto.jpg';
}

echo '<div id="detproducto" style="background-image: url('.$image.'); background-repeat: no-repeat;" width="100%" onmouseover="ocultar(\'menumarcas\'); ocultar(\'menutopproductos\')">
				<p>&nbsp;
				<p>&nbsp;
				<table border="0" cellpading="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top" width="20%">
							<img src="Productos/images/'.$RResProducto["Imagen"].'" border="0" width="100" height="100">
						</td>
						<td valign="top" class="textoy">'.$RResProducto["Producto"].'
							<p>'.$RResProducto["Descripcion"].'
							<p>&nbsp;';
$ResDocumentos=mysql_query("SELECT * FROM documentos WHERE PerteneceA='producto' AND Consecutivo ='".$_GET["producto"]."' ORDER BY Nombre ASC");
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
echo '			</td>
					</tr>
				</table>
			</div>';
?>