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
$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$_POST["cliente"]."' LIMIT 1"));

$excel->WriteText($row, $col, $ResEmpresa["Nombre"]); $row++; $col=0;
if($_POST["cliente"]=="%"){$cliente='Todos';}else{$cliente=$ResCliente["Nombre"];}
$excel->WriteText($row, $col, 'Cliente: '.$cliente);

$row++; $row++;
$col=0;

$excel->WriteText($row,$col,"Fecha");$col++;
$excel->WriteText($row,$col,"Cliente");$col++;
$excel->WriteText($row,$col,"Factura");$col++;
$excel->WriteText($row,$col,"Cantidad");$col++;
$excel->WriteText($row,$col,"1 a 30 Dias");$col++;
$excel->WriteText($row,$col,"30 a 60 Dias");$col++;
$excel->WriteText($row,$col,"60 a 90 Dias");$col++;
$excel->WriteText($row,$col,"mas de 90 Dias");$col++;

	$row++;
	$col=0;

$ResFacturas=mysql_query("SELECT Id, NumFactura, Cliente, Fecha, Total FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$_POST["cliente"]."' AND Status='Pendiente' ORDER BY Fecha ASC");
while($RResFacturas=mysql_fetch_array($ResFacturas))
{
	
	$dias=dias_entre_fechas(date("d-m-Y"), $RResFacturas["Fecha"][8].$RResFacturas["Fecha"][9].'-'.$RResFacturas["Fecha"][5].$RResFacturas["Fecha"][6].'-'.$RResFacturas["Fecha"][0].$RResFacturas["Fecha"][1].$RResFacturas["Fecha"][2].$RResFacturas["Fecha"][3]);
	
	$abono=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS pago FROM pagos_clientes WHERE IdFactura='".$RResFacturas["Id"]."' AND Status='Aplicado'"));
	
	$cliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
	
	$excel->WriteText($row,$col,fecha($RResFacturas["Fecha"]));$col++;
	$excel->WriteText($row,$col,$cliente["Nombre"]);$col++;
	$excel->WriteText($row,$col,$RResFacturas["NumFactura"]);$col++;
	$excel->WriteNumber($row,$col,$RResFacturas["Total"]);$col++;$total=$total+$RResFacturas["Total"];
	
	$saldo=$RResFacturas["Total"]-$abono["pago"];
	
	if($saldo<0){$saldo=0;}
	
	if($dias>=1 AND $dias<=29){$excel->WriteNumber($row,$col,$saldo);$uno=$uno+$saldo;}else{$excel->WriteNumber($row,$col,0);}$col++;
	if($dias>=30 AND $dias<=59){$excel->WriteNumber($row,$col,$saldo);$treinta=$treinta+$saldo;}else{$excel->WriteNumber($row,$col,0);}$col++;
	if($dias>=60 AND $dias<=89){$excel->WriteNumber($row,$col,$saldo);$sesenta=$sesenta+$saldo;}else{$excel->WriteNumber($row,$col,0);}$col++;
	if($dias>=90){$excel->WriteNumber($row,$col,$saldo);$noventa=$noventa+$saldo;}else{$excel->WriteNumber($row,$col,0);}$col++;
	
	//$excel->WriteNumber($row,$col,$dias);$col++;
	
	$row++;
	$col=0;
}

	$excel->WriteText($row,$col,'');$col++;
	$excel->WriteText($row,$col,'');$col++;
	$excel->WriteText($row,$col,'Totales: ');$col++;
	$excel->WriteNumber($row,$col,$total);$col++;
	$excel->WriteNumber($row,$col,$uno);$col++;
	$excel->WriteNumber($row,$col,$treinta);$col++;
	$excel->WriteNumber($row,$col,$sesenta);$col++;
	$excel->WriteNumber($row,$col,$noventa);$col++;

//stream Excel for user to download or show on browser
$excel->SendFile();


function dias_entre_fechas($dFecFin, $dFecIni)
{
    $dFecIni = str_replace("-","",$dFecIni);
    $dFecIni = str_replace("/","",$dFecIni);
    $dFecFin = str_replace("-","",$dFecFin);
    $dFecFin = str_replace("/","",$dFecFin);

    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

    $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

    return round(($date2 - $date1) / (60 * 60 * 24));
}
?>