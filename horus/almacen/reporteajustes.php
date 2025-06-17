<?php 
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la pï¿½gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

require('../clientes/fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");
include("../funciones.php");

//recibo datos
$producto=$_POST["producto"];
$fechai='2011-02-02 00:00:00';
$fechaf=date("Y-m-d").' 23:59:59';



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
//Titulo
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(8);
$pdf->Cell(120,4,'REPORTE DE AJUSTES DE PRODUCTO',0,0,'L',1);
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
$pdf->Cell(5,4,' ',1,0,'C',1);
$pdf->cell(23,4,'Fecha',1,0,'C',1);
$pdf->Cell(15,4,'Movimiento',1,0,'C',1);
$pdf->Cell(15,4,'Almacen',1,0,'C',1);
$pdf->Cell(60,4,'Producto',1,0,'C',1);
$pdf->Cell(60,4,'Descripción',1,0,'C',1);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);

$i=1; $j=1;
//Ajustes
//$pdf->SetFillColor(255,255,255);
//$pdf->SetFont('Arial','',7);
//$pdf->SetTextColor(000,000,000);
//$pdf->SetY(270);
//$pdf->SetX(8);
//$pdf->MultiCell(175,4,'II-Inventario Inicial. TA-Traslado Almacen. DM-Devolución de Mercancía. CM-Cambio por otra Mercancía. OP-Obsequio de Provedor. CD-Compra Directa. FL-Factura Libre. OC-Obsequio de Cliente. P-Promoción',1,1,'L',1);

$ResMovimientos=mysql_query("SELECT * FROM movinventario WHERE Producto LIKE '".$producto."' AND Ajuste!='TA' AND Ajuste!='' AND Ajuste!='II' AND Almacen LIKE '".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."%' ORDER BY Id ASC, Fecha ASC");
while($RResMovimientos=mysql_fetch_array($ResMovimientos))
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
		//Titulo
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(16);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'REPORTE DE TRASLADOS DE PRODUCTO',0,0,'L',1);
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
		$pdf->Cell(5,4,' ',1,0,'C',1);
		$pdf->cell(23,4,'Fecha',1,0,'C',1);
		$pdf->Cell(15,4,'Movimiento',1,0,'C',1);
		$pdf->Cell(15,4,'Almacen',1,0,'C',1);
		$pdf->Cell(60,4,'Producto',1,0,'C',1);
		$pdf->Cell(60,4,'Descripción',1,0,'C',1);
		$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
		
		
	}
	//producto
	$ResProducto=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id LIKE '".$producto."' LIMIT 1"));
	
	$almacen=explode('_', $RResMovimientos["Almacen"]);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(5,4,$i,1,0,'C',1);
	$pdf->cell(23,4,fecha($RResMovimientos["Fecha"]),1,0,'C',1);
	$pdf->Cell(15,4,$RResMovimientos["Movimiento"],1,0,'C',1);
	$pdf->Cell(15,4,$almacen[2],1,0,'C',1);
	$pdf->Cell(60,4,$ResProducto["Clave"].' - '.$ResProducto["Nombre"],1,0,'L',1);
	$pdf->Cell(60,4,substr($RResMovimientos["Descripcion"],0,35),1,0,'L',1);
	$pdf->Cell(15,4,$RResMovimientos["Cantidad"],1,0,'C',1);
	
	
	$i++; $j++; $y_axis=$y_axis+4; 
}
//Envio Archivo
$pdf->Output();
?>
