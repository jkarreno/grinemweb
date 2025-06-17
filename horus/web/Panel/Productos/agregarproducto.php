<?php
//Opciones para agregar el archivo//////////////////////////////////////////////////////////////////////////////
$_max_file_size = '250000000'; //file size in bytes.

$upload_dir = '../../Productos/images/'; //upload folder..chmod to 777

$_i = "1";                //number of files to upload at one time

//xajax/////////////////////////////////////////////////////////////////////////////////////////////////////////
require ('../xajax/xajax.inc.php');
include ("funcionesproductos.php");
$xajax = new xajax(); 
$xajax->registerFunction("linea");
$xajax->processRequests();

//conecta a base //////////////////////////////////////////////////////////////////////////////////////////////
include ("../conexion.php");

//Agrega el producto a base y crea archivo independiente//////////////////////////////////////////////////////
if ($_POST["botadprod"])
{
	//datos del arhivo 
	$nombre_archivo = $HTTP_POST_FILES['uparchivo']['name']; 
	$tipo_archivo = $HTTP_POST_FILES['uparchivo']['type']; 
	$tamano_archivo = $HTTP_POST_FILES['uparchivo']['size']; 
	
	if (is_uploaded_file($HTTP_POST_FILES['uparchivo']['tmp_name']))
  { 
    if(copy($HTTP_POST_FILES['uparchivo']['tmp_name'], $upload_dir.$nombre_archivo))
    {
    	if (mysql_query("INSERT INTO productos (Marca, Linea, Producto, Descripcion, Imagen, Destacado) VALUES
							    													 ('".$_POST["marca"]."', '".$_POST["linea"]."', '".$_POST["producto"]."', '".$_POST["descripcion"]."', '".$nombre_archivo."', '".$_POST["destacado"]."')"))
			{
				$ResProd=mysql_query("SELECT * FROM productos ORDER BY Consecutivo DESC LIMIT 1");
				$RResProd=mysql_fetch_array($ResProd);
		
				//crea el archivo del producto
				$fl=fopen("../../Productos/".$RResProd["Consecutivo"].".php", "w+") or die("Problemas en la creacion");
				fputs($fl,'<?php include("header.php");');
				fputs($fl, 'echo \'<div id="detproducto" style="background-image: url(images/bdetallesdelproducto.jpg); background-repeat: no-repeat; width="100%>
				<p>&nbsp;
				<p>&nbsp;
				<table border="0" cellpading="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top">
							<img src="images/productos/'.$RResProd["Imagen"].'" border="0" width="100" height="100">
						</td>
						<td valign="top" class="textox">
							<strong>'.htmlentities($RResProd["Producto"]).'</strong>
							<p>'.htmlentities($RResProd["Descripcion"]).'
						</td>
					</tr>
				</table>
				</div>\';');
				fputs($fl, 'include("footer.php"); ?>');
				fclose($fl);
		
				$mensaje='<p align="center" class="textomensaje">Se ha agregado el producto '.$_POST["producto"].' exitosamente';
  		}
  		else
  		{
   			$mensaje='Ocurrio un error, no se pudo agregar el producto '.$_POST["producto"].', consulte a Mickey Mouse';
  		}
		}
	}
}
?>
<html>
<head>
<?php $xajax->printJavascript('../xajax/'); ?>
<style type="text/css">
body {	
 margin-left: 0px; 
 margin-top: 0px; 
 margin-right: 0px;	
 margin-bottom: 0px;	
 background-color: #CCCCCC;
}
</style>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
      mode : "textareas",
      theme : "simple"
   });
</script>
</head>
<body>
<?php if ($mensaje!=''){echo '<p align="center" class="textomensaje">'.$mensaje.'</p>';} ?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<td align="center" class="textotitpanel" bgcolor="#0284c2">Agregar Producto</td>
	</tr>
	<tr>
		<td align="left" bgcolor="#CCCCCC" class="texto2">
		 <form id="adproducto" action="agregarproducto.php" method="POST" enctype="multipart/form-data">
		 &nbsp; Marca: <select name="marca" onChange="xajax_linea(this.value)">
		 	<option>Selecciona</option>
<?php 
	$ResMarcas=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='marcas' ORDER BY Nombre ASC");
	while($RResMarcas=mysql_fetch_array($ResMarcas))
	{
		echo '<option value="'.$RResMarcas["Nombre"].'">'.$RResMarcas["Nombre"].'</option>';
	}
?>
			</select>&nbsp;<div id="linea" style="position:absolute"></div>
			<p>&nbsp;Producto: <input type="text" name="producto" size="25">
			<p>&nbsp;Descripci&oacute;n:<br /><textarea name="descripcion" rows="15" cols="80" style="width: 80%"></textarea>
			<p>&nbsp;Imagen: <br />&nbsp;<input type="file" name="uparchivo">
			<p>&nbsp;Producto Destacado <input type="checkbox" name="destacado" value="1">
			<p align="center"><input type="submit" name="botadprod" value="Agregar>>">
		</form>
		</td>
	</tr>
</table>
</body>
</html>