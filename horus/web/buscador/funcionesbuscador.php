<?php
function buscador($palabra)
{
	include ("conexion.php");
	
	$ResBuscaMarcas=mysql_query("SELECT Consecutivo, Nombre FROM marcas WHERE Desc_corta LIKE '%".$palabra."%' OR Desc_larga LIKE '%".$palabra."%' ORDER BY Nombre");
	$ResBuscaProducto=mysql_query("SELECT Consecutivo, Producto FROM productos WHERE Descripcion LIKE '%".$palabra."%' OR Producto LIKE '%".$palabra."%' OR Marca LIKE '%".$palabra."%' ORDER BY Producto");
	
	$cadena='Resultados de la busqueda:
	<p>Marcas<br />
	<ul>';
	while ($RResBuscaMarcas=mysql_fetch_array($ResBuscaMarcas))
	{
		$cadena.='<li><a href="#" onClick="llamarasincrono(\'marcas.php?marca='.$RResBuscaMarcas["Consecutivo"].'\',\'contenido\')">'.$RResBuscaMarcas["Nombre"].'</a></li>';
	}
	$cadena.='</ul>
	<p>Productos<br />
	<ul>';
	while ($RResBuscaProducto=mysql_fetch_array($ResBuscaProducto))
	{
		$cadena.='<li><a href="#" onClick="llamarasincrono(\'detproducto.php?producto='.$RResBuscaProducto["Consecutivo"].'\',\'contenido\')">'.$RResBuscaProducto["Producto"].'</a></li>';
	}
	$cadena.='</ul>
	<p>Documentos
	<p>Archivos';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
?>