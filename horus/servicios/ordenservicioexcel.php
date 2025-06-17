<?php
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p?gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("../conexion.php");
include ("../funciones.php");
include ("../reportes/excelgen.class.php");

//initiate a instance of "excelgen" class
$excel = new ExcelGen("ReporteOrdenesServicios");

//initiate $row,$col variables
$row=0;
$col=0;

if($_POST["cliente"]=='todos'){$cliente='%';}else{$cliente=$_POST["cliente"];}
if($_POST["unidadclie"]=='Seleccione'){$unidadclie="%";}else{$unidadclie=$_POST["unidadclie"];}
if($_POST["numorden"]==''){$numorden='%';}else{$numorden=$_POST["numorden"];}

$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"].' 00:00:00';
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"].' 23:59:59';

if($_POST["status"]=='Todas'){$status='%';}else{$status=$_POST["status"];}

$ResOrdenes=mysql_query("SELECT * FROM ordenservicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status LIKE '".$status."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' AND NumOrden LIKE '".$numorden."' AND UnidadCliente LIKE '".$unidadclie."' ORDER BY NumOrden DESC");

$excel->WriteText($row,$col,"Num. Orden");$col++;
$excel->WriteText($row,$col,"Fecha");$col++;
$excel->WriteText($row,$col,"Cliente");$col++;
$excel->WriteText($row,$col,"Unidad");$col++;
$excel->WriteText($row,$col,"Tecnico Asignado");$col++;
$excel->WriteText($row,$col,"Status");$col++;
$excel->WriteText($row,$col,"Importe");$col++;


$row++;
$col=0;

while($RResOrdenes=mysql_fetch_array($ResOrdenes))
{
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResOrdenes["UnidadCliente"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenes["Cliente"]."' LIMIT 1"));
	$ResTecnico=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResOrdenes["Tecnico"]."' LIMIT 1"));
	
	$excel->WriteText($row,$col,$RResOrdenes["NumOrden"]);$col++;
	$excel->WriteText($row,$col,$RResOrdenes["Fecha"]);$col++;
	$excel->WriteText($row,$col,$ResCliente["Nombre"]);$col++;
	$excel->WriteText($row,$col,$ResUnidad["Nombre"]);$col++;
	$excel->WriteText($row,$col,$ResTecnico["Nombre"]);$col++;
	$excel->WriteText($row,$col,$RResOrdenes["Status"]);$col++;
	$excel->WriteNumber($row,$col,$RResOrdenes["Total"]);$col++;
	
	
$row++;
$col=0;

}

//stream Excel for user to download or show on browser
$excel->SendFile();

?>
	
