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
$excel = new ExcelGen("ReporteOrdenesdeVentas");

//initiate $row,$col variables
$row=0;
$col=0;

$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"];
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"];
if($_POST["cliente"]=='todos'){$cliente='%';}else{$cliente=$_POST["cliente"];}

$ResOrdenesVenta=mysql_query("SELECT * FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='".$_POST["status"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' ORDER BY NumOrden DESC");

$excel->WriteText($row,$col,"Num. Orden");$col++;
$excel->WriteText($row,$col,"Fecha");$col++;
$excel->WriteText($row,$col,"Cliente");$col++;
$excel->WriteText($row,$col,"Status");$col++;

$row++;
$col=0;

while($RResOrdenesVenta=mysql_fetch_array($ResOrdenesVenta))
{
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenesVenta["Cliente"]."' LIMIT 1"));
	
	$excel->WriteText($row,$col,$RResOrdenesVenta["NumOrden"]);$col++;
  $excel->WriteText($row,$col,$RResOrdenesVenta["Fecha"][8].$RResOrdenesVenta["Fecha"][9].'-'.$RResOrdenesVenta["Fecha"][5].$RResOrdenesVenta["Fecha"][6].'-'.$RResOrdenesVenta["Fecha"][0].$RResOrdenesVenta["Fecha"][1].$RResOrdenesVenta["Fecha"][2].$RResOrdenesVenta["Fecha"][3]);$col++;
  $excel->WriteText($row,$col,$ResCliente["Nombre"]);$col++;
  $excel->WriteText($row,$col,$RResOrdenesVenta["Status"]);$col++;
  
  $row++;
$col=0;
}

//stream Excel for user to download or show on browser
$excel->SendFile();
		

?>