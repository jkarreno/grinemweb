<?php

include ("../conexion.php");
//include ("../funciones.php");
//include ("../reportes/excelgen.class.php");

//initiate a instance of "excelgen" class
//$excel = new ExcelGen("Almacen");

//initiate $row,$col variables
//$row=0;
//$col=0;

$clave=$_POST["clave"];
$empresa=$_GET["empresa"];
$sucursal=$_GET["sucursal"];

$ResProductos=mysql_query("SELECT Id, Clave, Nombre, Unidad FROM productos WHERE Empresa='".$empresa."' AND Sucursal='".$sucursal."' ORDER BY Nombre ASC");
echo '<table border="1" cellpadding="0" cellspacing="0">';
$a=1;
while($RResProductos=mysql_fetch_array($ResProductos))
{
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResProductos["Unidad"]."' LIMIT 1"));
	echo '<tr>
			<td>'.$a.'</td>
			<td>'.$ResUnidad["Nombre"].'</td>
			<td>'.$RResProductos["Clave"].'</td>
			<td>'.$RResProductos["Nombre"].'</td>';
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$empresa."' AND Sucursal='".$sucursal."' ORDER BY Nombre ASC");
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
	$ResMovimientosEntrada=mysql_fetch_array(mysql_query("SELECT Id, SUM(Cantidad) AS Entradas FROM movinventario WHERE Movimiento='Entrada' AND Producto='".$RResProductos["Id"]."'"));
	$ResMovimientosSalida=mysql_fetch_array(mysql_query("SELECT Id, SUM(Cantidad) AS Salidas FROM movinventario WHERE Movimiento='Salida' AND Producto='".$RResProductos["Id"]."'"));
	
		echo '<td>'.($ResMovimientosEntrada["Entradas"]-$ResMovimientosSalida["Salidas"]).'</td>';
		
		
	}
	mysql_free_result($ResAlmacenes);
	echo '</tr>'; $a++; $cantidad=0;
}
echo '</table>';
	

/*function inventario_stock ($producto, $almacen)
{
	include ("../conexion.php"); $cantidad=0;
	
	$ResId=mysql_query("SELECT Id FROM movinventario WHERE Producto='".$producto."' AND Almacen='".$almacen."' AND Descripcion='Inventario Inicial' ORDER BY Id DESC LIMIT 1");
	$RResId=mysql_fetch_array($ResId);
	
	//if(mysql_num_rows($ResId)==0)
	//{
	//	$cantidad=$RResId["Id"];
	/*}
	else
	{
	$ResMovimientos=mysql_query("SELECT Id, Movimiento, Cantidad, Descripcion FROM movinventario WHERE Producto='".$producto."' AND Id>='".$RResId["Id"]."' ORDER BY Fecha ASC, Id ASC");
	while($RResMovimientos=mysql_fetch_array($ResMovimientos))
	{
	if($RResMovimientos["Movimiento"]=='Entrada'){$cantidad=$cantidad+$RResMovimientos["Cantidad"];}
	elseif($RResMovimientos["Movimiento"]=='Salida'){$cantidad=$cantidad-$RResMovimientos["Cantidad"];}
	if($RResMovimientos["Descripcion"]=='Inventario Inicial'){$cantidad=$RResMovimientos["Cantidad"];}
	}
	}
	
	
	return $cantidad;
}*/
?>