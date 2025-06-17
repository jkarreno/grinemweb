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
include ("excelgen.class.php");

//initiate a instance of "excelgen" class
$excel = new ExcelGen("ReporteVentasPorUnidad");

//initiate $row,$col variables
$row=0;
$col=0;

$ResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));
$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$_POST["unidad"]."' LIMIT 1"));
$ResCLiente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$_POST["cliente"]."' LIMIT 1"));

if($_POST["unidad"]!='%'){$unidad=$ResUnidad["Nombre"];}else{$unidad='Todas';}

$excel->WriteText($row, $col, $ResEmpresa["Nombre"]);
$row++; $col=0;

$excel->WriteText($row, $col, 'Cliente: '.$ResCLiente["Nombre"]);
$row++; $col=0;

$excel->WriteText($row,$col, 'Unidad: '.$unidad);
$row++; $row++; $col=0;


$excel->WriteText($row,$col,"Fecha");$col++;
if($_POST["documento"]=='factura'){$excel->WriteText($row,$col,"Factura");}elseif($_POST["documento"]=='ordenv'){$excel->WriteText($row,$col,"Orden de Venta");}$col++;
$excel->WriteText($row,$col,"Unidad");$col++;
$excel->WriteText($row,$col,"Clave");$col++;
$excel->WriteText($row,$col,"Producto");$col++;
$excel->WriteText($row,$col,"Cantidad");$col++;

$row++;
$col=0;
$fechaini=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"];
$fechafin=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"];

if($_POST["documento"]=='factura')
{
	$ResFacturas=mysql_query("SELECT Id, Fecha, Serie, NumFactura, UnidadCliente FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha>='".$fechaini."' AND Fecha<='".$fechafin."' AND Cliente LIKE '".$_POST["cliente"]."' AND UnidadCliente LIKE '".$_POST["unidad"]."' ORDER BY Fecha ASC");
	while($RResFacturas=mysql_fetch_array($ResFacturas))
	{
		$ResProductos=mysql_query("SELECT Producto, Cantidad FROM detfacturas WHERE IdFactura='".$RResFacturas["Id"]."' AND Producto LIKE '".$_POST["producto"]."' ORDER BY Id ASC");
		while($RResProductos=mysql_fetch_array($ResProductos))
		{
			$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResFacturas["UnidadCliente"]."' LIMIT 1"));
			$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResProductos["Producto"]."' LIMIT 1"));
		
			$excel->WriteText($row,$col,fecha($RResFacturas["Fecha"]));$col++;
			$excel->WriteText($row,$col,$RResFacturas["Serie"].$RResFacturas["NumFactura"]);$col++;
			$excel->WriteText($row,$col,$ResUnidad["Nombre"]);$col++;
			$excel->WriteText($row,$col,$ResProd["Clave"]);$col++;
			$excel->WriteText($row,$col,$ResProd["Nombre"]);$col++;
			$excel->WriteNumber($row,$col,$RResProductos["Cantidad"]);$col++;
		
			$cantidad=$cantidad+$RResProductos["Cantidad"];
		
			$row++;
			$col=0;
		}
	}
	$col=3;

	$excel->WriteText($row,$col,"Total :");$col++;
	$excel->WriteNumber($row,$col,$cantidad);$col++;
}
elseif($_POST["documento"]=='ordenv')
{
	$ResOrden=mysql_query("SELECT Id, Fecha, NumOrden, UnidadCliente FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha>='".$fechaini."' AND Fecha<='".$fechafin."' AND Cliente LIKE '".$_POST["cliente"]."' AND UnidadCliente LIKE '".$_POST["unidad"]."' ORDER BY Fecha ASC");
	while($RResOrden=mysql_fetch_array($ResOrden))
	{
		$ResProductos=mysql_query("SELECT Producto, Cantidad FROM detordenventa WHERE Idorden='".$RResOrden["Id"]."' AND Producto LIKE '".$_POST["producto"]."' ORDER BY Id ASC");
		while($RResProductos=mysql_fetch_array($ResProductos))
		{
			$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResFacturas["UnidadCliente"]."' LIMIT 1"));
			$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResProductos["Producto"]."' LIMIT 1"));
		
			$excel->WriteText($row,$col,fecha($RResOrden["Fecha"]));$col++;
			$excel->WriteText($row,$col,$RResOrden["NumOrden"]);$col++;
			$excel->WriteText($row,$col,$ResUnidad["Nombre"]);$col++;
			$excel->WriteText($row,$col,$ResProd["Clave"]);$col++;
			$excel->WriteText($row,$col,$ResProd["Nombre"]);$col++;
			$excel->WriteNumber($row,$col,$RResProductos["Cantidad"]);$col++;
		
			$cantidad=$cantidad+$RResProductos["Cantidad"];
		
			$row++;
			$col=0;
		}
	}
	$col=4;

	$excel->WriteText($row,$col,"Total :");$col++;
	$excel->WriteNumber($row,$col,$cantidad);$col++;
}
//stream Excel for user to download or show on browser
$excel->SendFile();

?>