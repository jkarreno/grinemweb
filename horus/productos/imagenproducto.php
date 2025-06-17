<html>
<head>
<title></title>
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css">
</head>
<body background="" class="body">
<?php
//Opciones para agregar el archivo//////////////////////////////////////////////////////////////////////////////
$_max_file_size = '250000000'; //file size in bytes.

$upload_dir = '../images/'; //upload folder..chmod to 777

$_i = "1";                //number of files to upload at one time


//conecta a base //////////////////////////////////////////////////////////////////////////////////////////////
include ("../conexion.php");

//Agrega el producto a base y crea archivo independiente//////////////////////////////////////////////////////
if ($_POST["botloadimage"])
{
//	// Primero creamos un ID de conexión a nuestro servidor
//	$cid = ftp_connect("ftp.neocom.cc");
//	// Luego creamos un login al mismo con nuestro usuario y contraseña
//	$resultado = ftp_login($cid, "greenstore","Tienda12");
//	// Comprobamos que se creo el Id de conexión y se pudo hacer el login
//	if ((!$cid) || (!$resultado)) {
//		echo "Fallo en la conexión"; die;
//	} else {
//		echo "Conectado. <br />";
//	}
//	// Cambiamos a modo pasivo, esto es importante porque, de esta manera le decimos al 
//	//servidor que seremos nosotros quienes comenzaremos la transmisión de datos.
//	ftp_pasv ($cid, true) ;
//	//echo "<br> Cambio a modo pasivo<br />";
//	// Nos cambiamos al directorio, donde queremos subir los archivos
//	ftp_chdir($cid, "images");
	//datos del arhivo 
	$nombre_archivo = $HTTP_POST_FILES['imagenprod']['name']; 
	$tipo_archivo = $HTTP_POST_FILES['imagenprod']['type']; 
	$tamano_archivo = $HTTP_POST_FILES['imagenprod']['size']; 

	
	if (is_uploaded_file($HTTP_POST_FILES['imagenprod']['tmp_name']))
  { 
    if(copy($HTTP_POST_FILES['imagenprod']['tmp_name'], $upload_dir.$nombre_archivo))
    {
    	if(mysql_query("UPDATE productos SET Imagen='".$nombre_archivo."' WHERE Id='".$_GET["producto"]."' AND Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."'"))
    	{
    		echo '<p align="center" class="textomensaje">Se agrego la imagen satisfactoriamente';
  		}
  		else
  		{
   			echo '<p align="center" class="textomensaje">2. Ocurrio un error, Intentelo nuevamente<br />'.mysql_error();
  		}
    	
    }
    else
    {
    	echo '<p align="center" class="textomensaje">3. Ocurrio un error, Intentelo nuevamente';
    }
	}
	else
  {
   	echo '<p align="center" class="textomensaje">4. Ocurrio un error, Intentelo nuevamente';
  }
}
else 
{
	$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre, Id FROM productos WHERE Id='".$_GET["producto"]."' AND Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' LIMIT 1"));
	
?>
<form name="floadcer" id="floadcer" method="POST" action="imagenproducto.php?empresa=<?php echo $_GET["empresa"];?>&sucursal=<?php echo $_GET["sucursal"];?>&producto=<?php echo $_GET["producto"];?>" enctype="multipart/form-data">
<table border="0" bordercolor="#ffffff" cellpadding="5" cellspacin="0" align="center">
<tr>
	<th colspan="2" bgcolor="#754200" align="center" class="texto3">Agregar Imagen para el Producto <?php echo utf8_encode($ResProducto["Nombre"]);?></th>
</tr>
<tr>
	<td bgcolor="#ba9464" align="left" class="texto">Selecciona Imagen (.jpg, .png):</td>
	<td bgcolor="#ba9464" align="left" class="texto"><input type="file" name="imagenprod" id="imagenprod" size="25" class="input"></td>
</tr>
<tr> 
	<th colspan="2" align="center" bgcolor="#ba9464" class="texto">
		<input type="submit" name="botloadimage" id="botloadimage" value="Cargar Imagen>>" class="boton">
	</th>
</tr>
</table>
</form>
<?php }?>
</body>