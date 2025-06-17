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

//initiate a instance of "excelgen" class
$excel = new ExcelGen("ReporteFacturas");

//initiate $row,$col variables
$row=0;
$col=0;

if($_POST["serie"]==''){$serie="%";}else{$serie=$_POST["serie"];}
if($_POST["numfactura"]==''){$numfactura='%';}else{$numfactura=$_POST["numfactura"];}
if($_POST["cliente"]==''){$cliente='%';}else{$cliente=$_POST["cliente"];}
$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"].' 00:00:00';
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"].' 23:59:59';
if($_POST["unidad"]=='todas'){$unidadc='%';}else{$unidadc=$_POST["unidad"];}
		
$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie LIKE '".$serie."' AND NumFactura LIKE '".$numfactura."' AND Cliente LIKE '".$cliente."' AND UnidadCliente LIKE '".$unidadc."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status LIKE '".$_POST["status"]."%' ORDER BY Fecha DESC, NumFactura DESC");

$excel->WriteText($row,$col,"Serie");$col++;
$excel->WriteText($row,$col,"Num. Factura");$col++;
$excel->WriteText($row,$col,"Fecha");$col++;
$excel->WriteText($row,$col,"Cliente");$col++;
$excel->WriteText($row,$col,"Unidad");$col++;
$excel->WriteText($row,$col,"Importe");$col++;
$excel->WriteText($row,$col,"IVA");$col++;
$excel->WriteText($row,$col,"Total");$col++;
$excel->WriteText($row,$col,"Status");$col++;

$row++;
$col=0;

while($RResFacturas=mysql_fetch_array($ResFacturas))
{
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
	$ResUniClie=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResFacturas["UnidadCliente"]."' LIMIT 1"));
	
	$excel->WriteText($row,$col,$RResFacturas["Serie"]);$col++;
	$excel->WriteText($row,$col,$RResFacturas["NumFactura"]);$col++;
	$excel->WriteText($row,$col,$RResFacturas["Fecha"][8].$RResFacturas["Fecha"][9].' - '.$RResFacturas["Fecha"][5].$RResFacturas["Fecha"][6].' - '.$RResFacturas["Fecha"][0].$RResFacturas["Fecha"][1].$RResFacturas["Fecha"][2].$RResFacturas["Fecha"][3]);$col++;
	$excel->WriteText($row,$col,$ResCliente["Nombre"]);$col++;
	$excel->WriteText($row,$col,$ResUniClie["Nombre"]);$col++;
	$excel->WriteNumber($row,$col,$RResFacturas["Subtotal"]);$col++;
	$excel->WriteNumber($row,$col,$RResFacturas["Iva"]);$col++;
	$excel->WriteNumber($row,$col,$RResFacturas["Total"]);$col++;
	if($RResFacturas["Status"]=='Pendiente'){$status='';}else{$status=$RResFacturas["Status"];}
	$excel->WriteText($row,$col,$status);$col++;
	
$row++;
$col=0;

}
//stream Excel for user to download or show on browser
$excel->SendFile();
