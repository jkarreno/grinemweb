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

//conecto a la base de datos
include("../conexion.php");
include("../funciones.php");

//recibo datos
$cliente=$_POST["cliente"];
$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"].' 00:00:00';
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"].' 23:59:59';
$agente=$_POST["agente"];

//Datos de la sucursal
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));

if($_POST["tipo"]=='pdf')
{
require('fpdf/fpdf.php');
//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage();

//posicion inicial y por pagina
$y_axis_initial = 25;

//Imprimir Datos de la Empresa
$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE ID='".$_SESSION["empresa"]."' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(10);
$pdf->SetX(8);
$pdf->Cell(120,4,utf8_encode($RResEmpresa["Nombre"]),0,0,'L',1);
//separador
$pdf->Line(8, 14, 200, 14);
//DATOS DEL MOVIMIENTO

//titulo
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(8);
$pdf->Cell(120,4,'REPORTE DE VENTAS POR AGENTE',0,0,'L',1);
//cliente
$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(8);
$pdf->Cell(120,4,'CLIENTE: '.$ResCliente["Nombre"],0,0,'L',1);
//agente
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$agente."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(8);
$pdf->Cell(120,4,'AGENTE: '.$ResAgente["Nombre"],0,0,'L',1);
//fecha
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(8);
$pdf->Cell(120,4,'Periodo de: '.fecha($fechai).' Hasta: '.fecha($fechaf),0,0,'L',1);
//separador
$pdf->Line(8, 32, 200, 32 );
//posicion inicial y por pagina
$y_axis_initial = 36; $y_axis=40;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,' ',1,0,'C',1);
$pdf->Cell(30,4,'Fecha',1,0,'C',1);
$pdf->Cell(30,4,'Factura',1,0,'C',1);
$pdf->Cell(30,4,'Subtotal',1,0,'C',1);
$pdf->Cell(30,4,'Iva',1,0,'C',1);
$pdf->Cell(30,4,'Total',1,0,'C',1);
$i=1; $j=1;
$ResPagos=mysql_query("SELECT Fecha, NumFactura, Serie, Subtotal, Descuento, Iva, Total FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$cliente."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Agente LIKE '".$agente."' AND Status!='Cancelada' ORDER BY NumFactura ASC");
while($RResPagos=mysql_fetch_array($ResPagos))
{
	if($j==51)
	{
		$j=1;
		$pdf->AddPage();
		
		//nombre de la empresa
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(10);
		$pdf->SetX(8);
		$pdf->Cell(120,4,utf8_encode($RResEmpresa["Nombre"]),0,0,'L',1);
		//separador
		$pdf->Line(8, 14, 200, 14);
		//DATOS DEL MOVIMIENTO

		//titulo
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(16);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'REPORTE DE VENTAS POR AGENTE',0,0,'L',1);
		//cliente
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(20);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'CLIENTE: '.$ResCliente["Nombre"],0,0,'L',1);
		//agente
		$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$agente."' LIMIT 1"));
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(24);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'AGENTE: '.$ResAgente["Nombre"],0,0,'L',1);
		//fecha
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(28);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Periodo de: '.fecha($fechai).' Hasta: '.fecha($fechaf),0,0,'L',1);
		//separador
		$pdf->Line(8, 32, 200, 32 );
		//posicion inicial y por pagina
		$y_axis_initial = 36; $y_axis=40;
		//titulos de las columnas
		$pdf->SetFillColor(000,000,000);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(8);
		$pdf->Cell(10,4,' ',1,0,'C',1);
		$pdf->Cell(30,4,'Fecha',1,0,'C',1);
		$pdf->Cell(30,4,'Factura',1,0,'C',1);
		$pdf->Cell(30,4,'Subtotal',1,0,'C',1);
		$pdf->Cell(30,4,'Iva',1,0,'C',1);
		$pdf->Cell(30,4,'Total',1,0,'C',1);
	}
		
	
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY($y_axis);
		$pdf->SetX(8);
		$pdf->Cell(10,4,$i,1,0,'C',0);
		$pdf->Cell(30,4,fecha($RResPagos["Fecha"]),1,0,'C',0);
		$pdf->Cell(30,4,$RResPagos["Serie"].' - '.$RResPagos["NumFactura"],1,0,'C',0);
		$pdf->Cell(30,4,'$ '.number_format($RResPagos["Subtotal"], 2),1,0,'R',0);
		$pdf->Cell(30,4,'$ '.number_format($RResPagos["Iva"],2),1,0,'R',0);
		$pdf->Cell(30,4,'$ '.number_format($RResPagos["Total"],2),1,0,'R',0);
		$i++; $j++; $y_axis=$y_axis+4; 
	
		$TSubtotal=$TSubtotal+$RResPagos["Subtotal"];
		$TIva=$TIva+$RResPagos["Iva"];
		$TTotal=$TTotal+$RResPagos["Total"];
	
}
//totales
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(70,4,'Total :',1,0,'R',0);
	$pdf->Cell(30,4,'$ '.number_format($TSubtotal,2),1,0,'R',0);
	$pdf->Cell(30,4,'$ '.number_format($TIva,2),1,0,'R',0);
	$pdf->Cell(30,4,'$ '.number_format($TTotal,2),1,0,'R',0);
//Envio Archivo
$pdf->Output();
}
elseif($_POST["tipo"]=='excel')
{

include ("../reportes/excelgen.class.php");

//initiate a instance of "excelgen" class
$excel = new ExcelGen("ReporteFacturas");

//initiate $row,$col variables
$row=0;
$col=0;

$excel->WriteText($row,$col,"Num. Factura");$col++;
$excel->WriteText($row,$col,"Fecha Factura");$col++;
$excel->WriteText($row,$col,"Subtotal");$col++;
$excel->WriteText($row,$col,"Iva");$col++;
$excel->WriteText($row,$col,"Total");$col++;
$excel->WriteText($row,$col,"Agente");$col++;

$row++;
$col=0;

$ResPagos=mysql_query("SELECT Fecha, NumFactura, Serie, Subtotal, Descuento, Iva, Total, Agente FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$cliente."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Agente LIKE '".$agente."' AND Status!='Cancelada' ORDER BY NumFactura ASC");
while($RResPagos=mysql_fetch_array($ResPagos))
{
	$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResPagos["Agente"]."' AND PerteneceA='AgenteV' LIMIT 1"));
	$excel->WriteText($row,$col,$RResPagos["Serie"].'-'.$RResPagos["NumFactura"]);$col++;
	$excel->WriteText($row,$col,$RResPagos["Fecha"][8].$RResPagos["Fecha"][9].'-'.$RResPagos["Fecha"][5].$RResPagos["Fecha"][6].'-'.$RResPagos["Fecha"][0].$RResPagos["Fecha"][1].$RResPagos["Fecha"][2].$RResPagos["Fecha"][3]);$col++;
	$excel->WriteNumber($row,$col,$RResPagos["Subtotal"]);$col++;
	$excel->WriteText($row,$col,$RResPagos["Iva"]);$col++;
	$excel->WriteText($row,$col,$RResPagos["Total"]);$col++;
	$excel->WriteText($row,$col,$ResAgente["Nombre"]);$col++;
$row++;
$col=0;
}
//stream Excel for user to download or show on browser
$excel->SendFile();
}
?>
