<?php
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("../conexion.php");
include ("../funciones.php");
include ("../reportes/excelgen.class.php");

$ResSucursal=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Empresa='".$_SESSSION["empresa"]."' AND Id='".$_SESSION["sucursal"]."' LIMIT 1"));
//initiate a instance of "excelgen" class
$excel = new ExcelGen("InventarioSucursal".$ResSucursal["Nombre"]);

//initiate $row,$col variables
$row=0;
$col=0;



$excel->WriteText($row,$col,"Inventario de la sucursal ".$ResSucursal["Nombre"]." al dia ".fecha(date("Y-m-d")));

$row++;
$col=0;

$excel->WriteText($row,$col,"Clave");$col++;
$excel->WriteText($row,$col,"Producto");$col++;
$excel->WriteText($row,$col,"Cantidad");$col++;

$row++;
$col=0;

$ResProductos=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
while($RResProductos=mysql_fetch_array($ResProductos))
{
	$excel->WriteText($row,$col,$RResProductos["Clave"]);$col++;
	$excel->WriteText($row,$col,$RResProductos["Nombre"]);$col++;
	$excel->WriteNumber($row,$col,inventario_stock($RResProductos["Id"]));$col++;
	
	$row++;
	$col=0;
}

//stream Excel for user to download or show on browser
$excel->SendFile();

function inventario_stock ($producto, $almacen=NULL)
{
	include ("../conexion.php"); $cantidad=0;
	
  $ResMovimientos=mysql_query("SELECT Movimiento, Cantidad FROM movinventario WHERE Producto='".$producto."' ORDER BY Fecha ASC, Id ASC");
	while($RResMovimientos=mysql_fetch_array($ResMovimientos))
	{
	if($RResMovimientos["Movimiento"]=='Entrada'){$cantidad=$cantidad+$RResMovimientos["Cantidad"];}
	elseif($RResMovimientos["Movimiento"]=='Salida'){$cantidad=$cantidad-$RResMovimientos["Cantidad"];}
	if($RResMovimientos["Descripcion"]=='Inventario Inicial'){$cantidad=$RResMovimientos["Cantidad"];}
	}
	
	
	return $cantidad;
}