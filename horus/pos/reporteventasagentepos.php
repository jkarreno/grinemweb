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

$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"].' 00:00:00';
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"].' 23:59:59';
$agente=$_POST["agente"];

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

//titulo
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(8);
$pdf->Cell(120,4,'REPORTE DE VENTAS POR AGENTE POS',0,0,'L',1);
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
$pdf->Cell(30,4,'Nota',1,0,'C',1);
$pdf->Cell(30,4,'Total',1,0,'C',1);
$i=1; $j=1;
$ResPagos=mysql_query("SELECT Fecha, NumNota, Total FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Agente LIKE '".$agente."' AND Status!='Cancelada' ORDER BY NumNota ASC");
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
		$pdf->Cell(120,4,'REPORTE DE VENTAS POR AGENTE POS',0,0,'L',1);
		
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
		$pdf->Cell(30,4,'Nota',1,0,'C',1);
		$pdf->Cell(30,4,'Total',1,0,'C',1);
	}
		
	
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY($y_axis);
		$pdf->SetX(8);
		$pdf->Cell(10,4,$i,1,0,'C',0);
		$pdf->Cell(30,4,fecha($RResPagos["Fecha"]),1,0,'C',0);
		$pdf->Cell(30,4,$RResPagos["Serie"].$RResPagos["NumNota"],1,0,'C',0);
		$pdf->Cell(30,4,'$ '.number_format($RResPagos["Total"],2),1,0,'R',0);
		$i++; $j++; $y_axis=$y_axis+4; 
	
		//$TSubtotal=$TSubtotal+$RResPagos["Subtotal"];
		//$TIva=$TIva+$RResPagos["Iva"];
		$TTotal=$TTotal+$RResPagos["Total"];
	
}
//totales
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(70,4,'Total :',1,0,'R',0);
	$pdf->Cell(30,4,'$ '.number_format($TTotal,2),1,0,'R',0);
//Envio Archivo
$pdf->Output();
?>
