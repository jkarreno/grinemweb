<?php
function menuproductos()
{
	$cadena='<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<th colspan="4" align="center" class="textotitpanel" bgcolor="#0284c2">Productos</th>
	</tr>
<tr>
	<td align="center"><a href="#" onclick="xajax_adproductos()"><span class="texto">Agregar Producto</span></a></td>
	<td align="center"><a href="#" onclick="xajax_modificaproducto()"><span class="texto">Modificar Producto</span></a></td>
	<td align="center"><a href="#" onclick="xajax_eliminaproducto()"><span class="texto">Eliminar Producto</span></a></td>
	<td align="center">&nbsp;</td>
</tr>
<tr>
	<th colspan="4"><div id="conteni2"></div></th>
</tr>
</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
function adproductos()
{
	include ("conexion.php");

	$cadena='<iframe name="imagen" frameborder="0" scrolling="no" width="100%" height="600" src="Productos/agregarproducto.php"></iframe>';
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function adproductos_2($producto)
{
	include ("conexion.php");
	
	if (mysql_query("INSERT INTO productos (Marca, Linea, Producto, Descripcion, Imagen, Destacado) VALUES
							    											 ('".$producto["marca"]."', '".$producto["linea"]."', '".$producto["producto"]."', '".$producto["descripcion"]."', '".$_SESSION["archivo"]."', '".$producto["destacado"]."')"))
	{
		$ResProd=mysql_query("SELECT * FROM productos ORDER BY Consecutivo DESC LIMIT 1");
		$RResProd=mysql_fetch_array($ResProd);
		
		//crea el archivo del producto
		$fl=fopen("../Productos/".$RResProd["Consecutivo"].".php", "w+") or die("Problemas en la creacion");
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
		
		$cadena='<p align="center" class="textomensaje">Se ha agregado el producto '.$producto["producto"].' exitosamente';
	}
	else
	{
		$cadena=$producto["marca"].'<br />'.$producto["linea"].'<br />'.$producto["producto"].'<br />'.$producto["descripcion"].'<br />'.$_SESSION["archivo"].'<br />'.$producto["destacado"].'<p align="center" class="textomensaje">Ocurrio un error, consulte a Buda';
	}
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function modificaproducto()
{
	include ("conexion.php");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<td align="center" class="textotitpanel" bgcolor="#0284c2">Modificar Producto</td>
	</tr>
	<tr>
		<td align="left" bgcolor="#CCCCCC" class="texto2">
		 <form id="modproducto">
		 &nbsp;Selecciona Producto <select name="producto">';
	$ResProductos=mysql_query("SELECT Consecutivo, Marca, Producto FROM productos ORDER BY Marca ASC, Producto ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		if($marca!=$RResProductos["Marca"])
		{
			$cadena.='<option>--'.$RResProductos["Marca"].'--</option>';
		}
		$cadena.='<option value="'.$RResProductos["Consecutivo"].'">'.$RResProductos["Producto"].'</option>';
		$marca=$RResProductos["Marca"];
	}
	$cadena.='</select> <input type="button" name="botselcod" value="Seleccionar>>" onclick="xajax_modificaproducto_2(xajax.getFormValues(\'modproducto\'))">
	</form>';
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function modificaproducto_2($producto)
{
	$cadena='<iframe name="imagen" frameborder="0" scrolling="no" width="100%" height="600" src="Productos/modificarproducto.php?producto='.$producto["producto"].'"></iframe>';
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function modificaproducto_3($producto)
{
	include ("conexion.php");
	
	$Reslinea=mysql_query("SELECT Nombre FROM parametros WHERE Consecutivo='".$producto["linea"]."'");
	$RReslinea=mysql_fetch_array($Reslinea);
	
	if(mysql_query("UPDATE productos SET Marca='".$producto["marca"]."', 
																			 Linea='".$RReslinea["Nombre"]."', 
																			 Producto='".$producto["producto"]."', 
																			 Descripcion='".$producto["descripcion"]."', 
																			 Imagen='".$_SESSION["archivo"]."', 
																			 Destacado='".$producto["destacado"]."' 
																 WHERE Consecutivo='".$producto["consecutivo"]."'"))
	{
		//crea el archivo del producto
		$fl=fopen("../Productos/".$producto["consecutivo"].".php", "w+") or die("Problemas en la creacion");
		fputs($fl,'<?php include("header.php");');
		fputs($fl, 'echo \'<div id="detproducto" style="background-image: url(images/bdetallesdelproducto.jpg); background-repeat: no-repeat; width="100%>
				<p>&nbsp;
				<p>&nbsp;
				<table border="0" cellpading="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top">
							<img src="images/productos/'.$_SESSION["archivo"].'" border="0" width="100" height="100">
						</td>
						<td valign="top" class="textox">
							<strong>'.htmlentities($producto["producto"]).'</strong>
							<p>'.htmlentities($producto["descripcion"]).'
						</td>
					</tr>
				</table>
			</div>\';');
		fputs($fl, 'include("footer.php"); ?>');
		fclose($fl);
		
		$cadena='<p align="center" class="textomensaje">Se ha actualizado el producto '.$producto["producto"].' exitosamente';
	}
	else 
	{
		$cadena='<p align="center" class="textomensaje">Ocurrio un problema, consulte al dalai lama';
	}
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function eliminaproducto()
{
		include ("conexion.php");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<td align="center" class="textotitpanel" bgcolor="#0284c2">Eliminar Producto</td>
	</tr>
	<tr>
		<td align="left" bgcolor="#CCCCCC" class="texto2">
		 <form id="delproducto">
		 &nbsp;Selecciona Producto <select name="producto">';
	$ResProductos=mysql_query("SELECT Consecutivo, Producto FROM productos ORDER BY Producto ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$cadena.='<option value="'.$RResProductos["Consecutivo"].'">'.$RResProductos["Producto"].'</option>';
	}
	$cadena.='</select> <input type="button" name="botselcod" value="Seleccionar>>" onclick="xajax_eliminaproducto_2(xajax.getFormValues(\'delproducto\'))">
	</form>';
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function eliminaproducto_2($producto)
{
	include ("conexion.php");
	
	$ResImaPro=mysql_query("SELECT Imagen, Producto FROM productos WHERE Consecutivo='".$producto["producto"]."'");
	$RResImaPro=mysql_query($ResImaPro);
	
	if(mysql_query("DELETE FROM productos WHERE Consecutivo='".$producto["producto"]."'"))
	{
		//elimina los archivos
		unlink('../Productos/'.$producto["producto"].'.php');
		unlink('../Productos/images/'.$RResImaPro["Imagen"]);
		
		$cadena='<p align="center" class="textomensaje">Se ha eliminado el producto '.$RResImaPro["Producto"].' exitosamente';
	}
	else 
	{
		$cadena='<p align="center" class="textomensaje">Ocurrio un error, no se pudo eliminar el producto, consulte a Gandhi';
	}
}

function linea($marca)
{
	include("../conexion.php");
	
	$cadena='L&iacute;nea: <select name="linea" id="linea">';
	$ResLineas=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE PerteneceA='lineas' AND Nombre='".$marca."' ORDER BY Nombre");
	while($RResLineas=mysql_fetch_array($ResLineas))
	{
		$cadena.='<option value="'.$RResLineas["Consecutivo"].'">'.htmlentities($RResLineas["Descripcion"]).'</option>';
	}
	$cadena.='</select>';
	
	 $respuesta = new xajaxResponse();
   $respuesta->addAssign("linea","innerHTML",$cadena);
   return $respuesta;
}
?>