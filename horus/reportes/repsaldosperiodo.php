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
$excel = new ExcelGen("ReporteSaldos");

//initiate $row,$col variables
$row=0;
$col=0;

$ResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id LIKE '".$_POST["cliente"]."' LIMIT 1"));

$excel->WriteText($row, $col, $ResEmpresa["Nombre"]); $row++; $col=0;
if($_POST["cliente"]=="%"){$cliente='Todos';}else{$cliente=$ResCliente["Nombre"];}
$excel->WriteText($row, $col, 'Cliente: '.$cliente);

$row++; $row++;
$col=0;

$excel->WriteText($row,$col,"Fecha");$col++;
$excel->WriteText($row,$col,"Cliente");$col++;
$excel->WriteText($row,$col,"Factura");$col++;
$excel->WriteText($row,$col,"Cantidad");$col++;
$excel->WriteText($row,$col,"Pagado");$col++;
$excel->WriteText($row,$col,"Adeudo");$col++;

	$row++;
	$col=0;

$ResFacturas=mysql_query("SELECT Id, NumFactura, Cliente, Fecha, Total FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$_POST["cliente"]."' AND Fecha<='".$_POST["anno"]."-".$_POST["mes"]."-".$_POST["dia"]." 23:59:59' AND Status!='Cancelada' ORDER BY Fecha ASC");
while($RResFacturas=mysql_fetch_array($ResFacturas))
{
	
	$pagado=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS pagado FROM pagos_clientes WHERE IdFactura='".$RResFacturas["Id"]."' AND Fecha<='".$_POST["anno"]."-".$_POST["mes"]."-".$_POST["dia"]."'"));
	
	$cliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
	
	if(($RResFacturas["Total"]-$pagado["pagado"])>0)
	{
	$excel->WriteText($row,$col,fecha($RResFacturas["Fecha"]));$col++;
	$excel->WriteText($row,$col,$cliente["Nombre"]);$col++;
	$excel->WriteText($row,$col,$RResFacturas["NumFactura"]);$col++;
	$excel->WriteNumber($row,$col,$RResFacturas["Total"]);$col++;$total=$total+$RResFacturas["Total"];
	$excel->WriteNumber($row,$col,$pagado["pagado"]);$col++;$totalpagado=$totalpagado+$pagado["pagado"];
	$excel->WriteNumber($row,$col,($RResFacturas["Total"]-$pagado["pagado"]));$col++;$totaladeudo=$totaladeudo+($RResFacturas["Total"]-$pagado["pagado"]);
	
	$row++;
	$col=0;
	}
}

	$excel->WriteText($row,$col,'');$col++;
	$excel->WriteText($row,$col,'');$col++;
	$excel->WriteText($row,$col,'Totales: ');$col++;
	$excel->WriteNumber($row,$col,$total);$col++;
	$excel->WriteNumber($row,$col,$totalpagado);$col++;
	$excel->WriteNumber($row,$col,$totaladeudo);$col++;


//stream Excel for user to download or show on browser
$excel->SendFile();

?>