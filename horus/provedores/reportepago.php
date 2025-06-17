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

require('../clientes/fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");
include("../funciones.php");

//recibo datos
$idpago=$_GET["idpago"];
$ResPago=mysql_fetch_array(mysql_query("SELECT Id, Fecha, TipoMovimiento, NumMovimiento, Provedor FROM pagos_provedores WHERE Id='".$idpago."' LIMIT 1"));

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
$pdf->Cell(120,4,'REPORTE DE PAGO',0,0,'L',1);
//fecha
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(8);
$pdf->Cell(120,4,'Fecha de Pago: '.fecha($ResPago["Fecha"]),0,0,'L',1);
//provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(8);
$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$ResPago["Provedor"]."' LIMIT 1"));
$pdf->Cell(120,4,'Provedor: '.$ResProvedor["Nombre"],0,0,'L',1);
//Tipo de Movimiento
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(8);
$pdf->Cell(120,4,'Tipo de Movimiento: '.$ResPago["TipoMovimiento"].' Num. Movimiento: '.$ResPago["NumMovimiento"],0,0,'L',1);
//Num. Movimiento

//separador
$pdf->Line(8, 32, 200, 32);
//posicion inicial y por pagina
$y_axis_initial = 36; $y_axis=40;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,' ',1,0,'C',1);
$pdf->cell(30,4,'Factura',1,0,'C',1);
$pdf->Cell(50,4,'Monto Factura',1,0,'C',1);
$pdf->Cell(50,4,'Abono en Pago',1,0,'C',1);
$i=1; $j=1;
$ResPagos=mysql_query("SELECT * FROM pagos_provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND TipoMovimiento='".$ResPago["TipoMovimiento"]."' AND NumMovimiento='".$ResPago["NumMovimiento"]."' ORDER BY Id ASC");
while($RResPagos=mysql_fetch_array($ResPagos))
{
	
	$ResFactura=mysql_fetch_array(mysql_query("SELECT FacturaP, TotalFactura FROM facturasprovedores WHERE Id='".$RResPagos["IdFacturaP"]."' LIMIT 1"));
	//facturas
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(10,4,$i,1,0,'C',0);
	$pdf->cell(30,4,$ResFactura["FacturaP"],1,0,'L',0);
	$pdf->Cell(50,4,'$ '.number_format($ResFactura["TotalFactura"],2),1,0,'R',0);
	$pdf->Cell(50,4,'$ '.number_format($RResPagos["Abono"],2),1,0,'R',0);
	$i++; $j++; $y_axis=$y_axis+4; 
	
	$totalabonos=$totalabonos+$RResPagos["Abono"];
}
//totales
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(90,4,'Total :',1,0,'R',0);
	$pdf->Cell(50,4,'$ '.number_format($totalabonos,2),1,0,'R',0);

//Envio Archivo
$pdf->Output();
?>
