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

require('fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");
include("../funciones.php");

//recibo datos
$cliente=$_POST["cliente"];
$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"].' 00:00:00';
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"].' 23:59:59';

//Datos de la sucursal
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
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

//cliente
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(8);
$pdf->Cell(120,4,'REPORTE DE VENTAS',0,0,'L',1);
//fecha
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(8);
$pdf->Cell(120,4,'Periodo de: '.fecha($fechai).' Hasta: '.fecha($fechaf),0,0,'L',1);
//separador
$pdf->Line(8, 24, 200, 24);
//posicion inicial y por pagina
$y_axis_initial = 30; $y_axis=34;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,' ',1,0,'C',1);
$pdf->cell(100,4,'Cliente',1,0,'C',1);
$pdf->Cell(20,4,'Num. Factura',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);
$pdf->Cell(20,4,'Iva',1,0,'C',1);
$pdf->Cell(20,4,'Total',1,0,'C',1);
$i=1; $j=1;
$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$cliente."' AND fecha>='".$fechai."' AND fecha<='".$fechaf."' AND Status!='Cancelada' ORDER BY NumFactura ASC");
while($RResFacturas=mysql_fetch_array($ResFacturas))
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

		//cliente
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(16);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'REPORTE DE VENTAS',0,0,'L',1);
		//fecha
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(20);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Periodo de: '.fecha($fechai).' Hasta: '.fecha($fechaf),0,0,'L',1);
		//separador
		$pdf->Line(8, 24, 200, 24);
		//posicion inicial y por pagina
		$y_axis_initial = 30; $y_axis=34;
		//titulos de las columnas
		$pdf->SetFillColor(000,000,000);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(8);
		$pdf->Cell(10,4,' ',1,0,'C',1);
		$pdf->cell(100,4,'Cliente',1,0,'C',1);
		$pdf->Cell(20,4,'Num. Factura',1,0,'C',1);
		$pdf->Cell(20,4,'Importe',1,0,'C',1);
		$pdf->Cell(20,4,'Iva',1,0,'C',1);
		$pdf->Cell(20,4,'Total',1,0,'C',1);
	}
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
	//facturas
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(10,4,$i,1,0,'C',0);
	$pdf->cell(100,4,$ResCliente["Nombre"],1,0,'L',0);
	$pdf->Cell(20,4,$RResFacturas["Serie"].' - '.$RResFacturas["NumFactura"],1,0,'C',0);
	$pdf->Cell(20,4,'$ '.number_format($RResFacturas["Subtotal"],2),1,0,'R',0);
	$pdf->Cell(20,4,'$ '.number_format($RResFacturas["Iva"],2),1,0,'R',0);
	$pdf->Cell(20,4,'$ '.number_format($RResFacturas["Total"],2),1,0,'R',0);
	$i++; $j++; $y_axis=$y_axis+4; 
	
	$totalsubtotales=$totalsubtotales+$RResFacturas["Subtotal"];
	$totaliva=$totaliva+$RResFacturas["Iva"];
	$totaltotal=$totaltotal+$RResFacturas["Total"];
}
//totales
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(130,4,'Total :',1,0,'R',0);
	$pdf->Cell(20,4,'$ '.number_format($totalsubtotales,2),1,0,'R',0);
	$pdf->Cell(20,4,'$ '.number_format($totaliva,2),1,0,'R',0);
	$pdf->Cell(20,4,'$ '.number_format($totaltotal,2),1,0,'R',0);
//Envio Archivo
$pdf->Output();
?>
