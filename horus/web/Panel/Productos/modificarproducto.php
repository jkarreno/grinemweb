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
if ($_POST["botmodprod"])
{
	if($_POST["cambimagen"]==1)
	{
	//datos del arhivo 
	$nombre_archivo = $HTTP_POST_FILES['uparchivo']['name']; 
	$tipo_archivo = $HTTP_POST_FILES['uparchivo']['type']; 
	$tamano_archivo = $HTTP_POST_FILES['uparchivo']['size']; 
	
	if (is_uploaded_file($HTTP_POST_FILES['uparchivo']['tmp_name']))
  { 
    if(copy($HTTP_POST_FILES['uparchivo']['tmp_name'], $upload_dir.$nombre_archivo))
    {
    	if(mysql_query("UPDATE productos SET Marca='".$_POST["marca"]."', 
    																				Linea='".$_POST["linea"]."', 
    																				Producto='".$_POST["producto"]."', 
    																				Descripcion='".$_POST["descripcion"]."', 
    																				Imagen='".$nombre_archivo."', 
    																				Destacado='".$_POST["destacado"]."' 
    																	WHERE Consecutivo='".$_POST["consecutivo"]."'"))
    	{
    		$mensaje='<p align="center" class="textomensaje">Se ha modificado el producto '.$_POST["producto"].' exitosamente';
    	}
    	else 
    	{
    		$mensaje='Ocurrio un error, no se pudo modificar el producto '.$_POST["producto"].', consulte a Mickey Mouse';
    	}
    }
  }
 	}
  else
  {
  	if(mysql_query("UPDATE productos SET Marca='".$_POST["marca"]."', 
    																				Linea='".$_POST["linea"]."', 
    																				Producto='".$_POST["producto"]."', 
    																				Descripcion='".$_POST["descripcion"]."', 
    																				Destacado='".$_POST["destacado"]."' 
    																	WHERE Consecutivo='".$_POST["consecutivo"]."'"))
  	{
    		$mensaje='<p align="center" class="textomensaje">Se ha modificado el producto '.$_POST["producto"].' exitosamente';
    }
    else 
    {
    	$mensaje='Ocurrio un error, no se pudo modificar el producto '.$_POST["producto"].', consulte a Mickey Mouse';
    }
  }
  		$ResProd=mysql_query("SELECT * FROM productos WHERE Consecutivo='".$_POST["consecutivo"]."' ORDER BY Consecutivo DESC LIMIT 1");
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
<?php if ($mensaje!=''){echo '<p align="center" class="textomensaje">'.$mensaje.'</p>';} else { ?>

<?php
	$ResProduc=mysql_query("SELECT * FROM productos WHERE Consecutivo='".$_GET["producto"]."'");
	$RResProduc=mysql_fetch_array($ResProduc);
?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<td align="center" class="textotitpanel" bgcolor="#0284c2">Modificar Producto</td>
	</tr>
	<tr>
		<td align="left" bgcolor="#CCCCCC" class="texto2">
		 <form id="adproducto" action="modificarproducto.php" method="POST" enctype="multipart/form-data">
		 &nbsp; Marca: <select name="marca" onChange="xajax_linea(this.value)">
		 	<option>Selecciona</option>
<?php 
	
	
	$ResMarcas=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='marcas' ORDER BY Nombre ASC");
	while($RResMarcas=mysql_fetch_array($ResMarcas))
	{
		echo '<option value="'.$RResMarcas["Nombre"].'"'; if ($RResMarcas["Nombre"]==$RResProduc["Marca"]){ echo 'selected';}echo '>'.$RResMarcas["Nombre"].'</option>';
	}
?>
			</select>&nbsp;<div id="linea" style="position:absolute">L&iacute;nea: <select name="linea" id="linea">';
			<?php 
				$ResLineas=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE PerteneceA='lineas' AND Nombre='".$RResProduc["Marca"]."' ORDER BY Nombre");
				while($RResLineas=mysql_fetch_array($ResLineas))
				{
					echo '<option value="'.$RResLineas["Consecutivo"].'"'; if ($RResLineas["Consecutivo"]==$RResProduc["Linea"]){ echo 'selected';} echo '>'.htmlentities($RResLineas["Descripcion"]).'</option>';
				}
				echo '</select>';
			?>	
			</div>
			<p>&nbsp;Producto: <input type="text" name="producto" size="25" value="<?php echo $RResProduc["Producto"]; ?>">
			<p>&nbsp;Descripci&oacute;n:<br /><textarea name="descripcion" rows="15" cols="80" style="width: 80%"><?php echo $RResProduc["Descripcion"]; ?></textarea>
			<p>&nbsp;Imagen: <br />&nbsp;<img src="../../Productos/images/<?php echo $RResProduc["Imagen"]; ?>" width="50" height="50" style="float:left;"><br />Cambiar Imagen: <input type="checkbox" name="cambimagen" value="1"><br /><input type="file" name="uparchivo">
			<p>&nbsp;Producto Destacado <input type="checkbox" name="destacado" value="1" <?php if($RResProduc["Descripcion"]==1) echo 'checked';?>>
			<input type="hidden" name="consecutivo" value="<?php echo $RResProduc["Consecutivo"]; ?>">
			<p align="center"><input type="submit" name="botmodprod" value="Modificar>>">
		</form>
		</td>
	</tr>
</table>
<?php } ?>
</body>
</html>