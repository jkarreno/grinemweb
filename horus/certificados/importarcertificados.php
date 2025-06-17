<html>
<head>
<title></title>
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css">
</head>
<body background="" class="body">
<?php
//Opciones para agregar el archivo//////////////////////////////////////////////////////////////////////////////
$_max_file_size = '250000000'; //file size in bytes.

$upload_dir = './'; //upload folder..chmod to 777

$_i = "1";                //number of files to upload at one time


//conecta a base //////////////////////////////////////////////////////////////////////////////////////////////
include ("../conexion.php");

//Agrega el producto a base y crea archivo independiente//////////////////////////////////////////////////////
if ($_POST["botloadfiles"])
{
	//datos del arhivo 
	$nombre_archivo = $HTTP_POST_FILES['certificado']['name']; 
	$tipo_archivo = $HTTP_POST_FILES['certificado']['type']; 
	$tamano_archivo = $HTTP_POST_FILES['certificado']['size']; 
	
	$nombre_archivo_2 = $HTTP_POST_FILES['llave']['name']; 
	$tipo_archivo_2 = $HTTP_POST_FILES['llave']['type']; 
	$tamano_archivo_2 = $HTTP_POST_FILES['llave']['size'];
	
	if (is_uploaded_file($HTTP_POST_FILES['certificado']['tmp_name']) AND is_uploaded_file($HTTP_POST_FILES['llave']['tmp_name']))
  { 
    if(copy($HTTP_POST_FILES['certificado']['tmp_name'], $upload_dir.$nombre_archivo) AND copy($HTTP_POST_FILES['llave']['tmp_name'], $upload_dir.$nombre_archivo_2))
    {
    	shell_exec('openssl pkcs8 -inform DER -in '.$nombre_archivo_2.' -passin pass:'.$_POST["contrasena"].' -out '.$nombre_archivo_2.'.pem');
    	
    	shell_exec('openssl x509 -inform DER -outform PEM -in '.$nombre_archivo.' -pubkey > '.$nombre_archivo.'.pem');
			
    	if($_POST["documento"]=='factura')
    	{
    	if(mysql_query("INSERT INTO ffacturas (Empresa, Sucursal, Serie, FolioI, FolioF, Factura, NumAprobacion, NumCertificado, Fecha, ArchivoCadena)
    																 VALUES ('".$_GET["empresa"]."', '".$_GET["sucursal"]."', '".$_POST["serie"]."', '".$_POST["folioini"]."',
    																 				 '".$_POST["foliofin"]."', '".$_POST["folioini"]."', '".$_POST["numaprobacion"]."', '".$_POST["numcertificado"]."', '".$_POST["fechahora"]."', '".$nombre_archivo_2.".pem')"))
    	{
    		echo 'Se cargaron los archivos satisfactoriamente';
  		}
  		else
  		{
   			echo '1. Ocurrio un error, Intentelo nuevamente, probablemente la contraseña es incorrecta.<br />'.mysql_error();
  		}
    	}
    	elseif($_POST["documento"]=="notac")
    	{
    	if(mysql_query("INSERT INTO fnotascredito (Empresa, Sucursal, Serie, FolioI, FolioF, Nota, NumAprobacion, NumCertificado, Fecha, ArchivoCadena)
    																 VALUES ('".$_GET["empresa"]."', '".$_GET["sucursal"]."', '".$_POST["serie"]."', '".$_POST["folioini"]."',
    																 				 '".$_POST["foliofin"]."', '".$_POST["folioini"]."', '".$_POST["numaprobacion"]."', '".$_POST["numcertificado"]."', '".$_POST["fechahora"]."', '".$nombre_archivo_2.".pem')"))
    	{
    		echo 'Se cargaron los archivos satisfactoriamente';
  		}
  		else
  		{
   			echo '2. Ocurrio un error, Intentelo nuevamente, probablemente la contraseña es incorrecta.<br />'.mysql_error();
  		}
    	}
    }
    else
    {
    	echo '3. Ocurrio un error, Intentelo nuevamente, probablemente la contraseña es incorrecta';
    }
	}
	else
  {
   	echo '4. Ocurrio un error, Intentelo nuevamente, probablemente la contraseña es incorrecta';
  }
}
else {
	$ResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_GET["empresa"]."' LIMIT 1"));
	$ResSucursal=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Id='".$_GET["sucursal"]."' LIMIT 1"));
	
?>
<form name="floadcer" id="floadcer" method="POST" action="importarcertificados.php?empresa=<?php echo $_GET["empresa"];?>&sucursal=<?php echo $_GET["sucursal"];?>" enctype="multipart/form-data">
<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacin="0" align="center">
<tr>
	<th colspan="2" bgcolor="#287d29" align="center" class="texto3">Agregar Folios para la empresa <?php echo utf8_encode($ResEmpresa["Nombre"]);?> Sucursal <?php echo utf8_encode($ResSucursal["Nombre"]);?></th>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Selecciona certificado (.cer):</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="file" name="certificado" id="certificado" size="10" class="input"></td>
</tr>
<tr> 
	<td bgcolor="#7abc7a" align="left" class="texto">Selecciona llave (.key):</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="file" name="llave" id="llave" size="10" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Contrase&ntildea:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="contrasena" id="contrasena" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Num. Aprobaci&oacute;n:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="numaprobacion" id="numaprobacion" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Num. Certificado:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="numcertificado" id="numcertificado" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Serie:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="serie" id="serie" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Folio Inicial:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="folioini" id="folioini" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Folio Final:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="foliofin" id="foliofin" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Fecha y Hora de la transaccion:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="fechahora" id="fechahora" size="25" class="input"></td>
</tr>
<tr>
	<td bgcolor="#7abc7a" align="left" class="texto">Tipo Documento:</td>
	<td bgcolor="#7abc7a" align="left" class="texto"><input type="radio" name="documento" id="documento" value="factura"> Factura <input type="radio" name="documento" id="documento" value="notac">Nota de Credito</td>
</tr>
<tr> 
	<th colspan="2" align="center" bgcolor="#7abc7a" class="texto"><input type="submit" name="botloadfiles" id="botloadfiles" value="Cargar Archivos>>" class="boton"></th>
</tr>
</table>
</form>
<?php }?>
</body>