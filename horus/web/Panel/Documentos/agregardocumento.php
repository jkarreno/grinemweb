<?php
//Opciones para agregar el archivo//////////////////////////////////////////////////////////////////////////////
$_max_file_size = '250000000'; //file size in bytes.

$upload_dir = '../../Documentos/'; //upload folder..chmod to 777

$_i = "1";                //number of files to upload at one time

 include ("../conexion.php");
 
 if($_POST["botaddocumento"])
 {
 	//datos del arhivo 
	$nombre_archivo = $HTTP_POST_FILES['documento']['name']; 
	$tipo_archivo = $HTTP_POST_FILES['documento']['type']; 
	$tamano_archivo = $HTTP_POST_FILES['documento']['size'];
	
	if (is_uploaded_file($HTTP_POST_FILES['documento']['tmp_name']))
  { 
    if(copy($HTTP_POST_FILES['documento']['tmp_name'], $upload_dir.$nombre_archivo))
    {
    	if($_POST["marca"]!=0){$pertenece='marca'; $consecutivo=$_POST["marca"];}
    	else if($_POST["producto"]!=0){$pertenece='producto'; $consecutivo=$_POST["producto"];}
    	else if($_POST["pagina"]!=0){$pertenece='pagina'; $consecutivo=$_POST["pagina"];}
    	
    	if (mysql_query("INSERT INTO documentos (Consecutivo, Nombre, PerteneceA, Archivo, Tipo) 
    																	 VALUES ('".$consecutivo."', '".$_POST["nombre"]."', '".$pertenece."', '".$nombre_archivo."', '".$_POST["tipo"]."')"))
    	{
    		$mensaje='<p class="textomensaje">Se agrego el documento '.$_POST["nombre"].' correctamente';
    	}
    	else 
    	{
    		$mensaje='<p class="textomensaje">Ocurrio un problema, no se pudo agregar el documento '.$_POST["nombre"].', consulte a Vicente Fox';
    	}
    }
  }
 }
?>
<html>
<head>

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
</head>
<body>
<?php echo $mensaje; ?>
<form name="addocumento" method="POST" action="agregardocumento.php" enctype="multipart/form-data">
 <table border="0" bordercolor="#0284c2" cellpadding="0" cellspacing="0" width="100%">
 	<tr>
 		<td align="center" class="texto2">&nbsp;Agregar a Marca&nbsp;
 			<br /><select name="marca"><option value="0">Seleccione</option>
 			<?php
 				$ResMarcas=mysql_query("SELECT Consecutivo, Nombre FROM parametros WHERE PerteneceA='marcas' ORDER BY Nombre ASC");
 				while ($RResMarcas=mysql_fetch_array($ResMarcas))
 				{
 					echo '<option value="'.$RResMarcas["Consecutivo"].'"'; if($_POST["marca"]==$RResMarcas["Consecutivo"]){echo 'selected';} echo '>'.$RResMarcas["Nombre"].'</option>';
 				}
 			?>
 			</select>
 		</td>
 		<td align="center" class="texto2">&nbsp;Agregar a Producto&nbsp;
 			<br /><select name="producto"><option value="0">Seleccione</option>
 			<?php
 				$ResProductos=mysql_query("SELECT Consecutivo, Marca, Producto FROM productos ORDER BY Marca ASC, Producto ASC");
 				while ($RResProductos=mysql_fetch_array($ResProductos))
 				{
 					if($marca!=$RResProductos["Marca"])
 					{
 						echo '<option value="0">---'.$RResProductos["Marca"].'---</option>';
 					}
 					echo '<option value="'.$RResProductos["Consecutivo"].'"'; if($_POST["producto"]==$RResProductos["Consecutivo"]){echo 'selected';} echo '>'.$RResProductos["Producto"].'</option>';
 					$marca=$RResProductos["Marca"];
 				}
 			?>
 			</select>
 		</td>
 		<td align="center" class="texto2">&nbsp;Agregar a Pagina&nbsp;
 			<br /><select name="pagina"><option value="0">Seleccione</option>
 			<?php
 				$ResPaginas=mysql_query("SELECT Consecutivo, Pagina FROM paginas ORDER BY Pagina ASC");
 				while ($RResPaginas=mysql_fetch_array($ResPaginas))
 				{
 					echo '<option value="'.$RResPaginas["Consecutivo"].'"'; if($_POST["pagina"]==$RResPaginas["Consecutivo"]){echo 'selected';} echo '>'.$RResPaginas["Pagina"].'</option>';
 				}
 			?>
 			</select>
 		</td>
 	</tr>
 	<tr>
 		<td colspan="3" class="texto2" height="30" valign="middle">
 			&nbsp; Nombre Documento: <input type="text" name="nombre" size="50">
 		</td>
 	</tr><tr>
 		<td colspan="3" class="texto2" height="60" valign="middle">
 			&nbsp; Seleccione Documento: <input type="file" name="documento" size="80">
 		</td>
 	</tr>
 	<tr>
 		<td class="texto2" height="30" valign="middle">
 		&nbsp; Publico <input type="radio" name="tipo" value="publico">&nbsp; Privado <input type="radio" name="tipo" value="privado"> 
 		</td>
 		<td colspan="2">
 			<input type="submit" name="botaddocumento" value="Agregar>>">
 		</td>
 	</tr>
 </table>
</form>
</body>
</html>