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
$cliente=$_POST["cliente"];
$producto=$_POST["producto"];
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
//Titulo
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(8);
$pdf->Cell(120,4,'REPORTE DE MOVIMIENTOS DE INVENTARIO DEL '.$_POST["diai"].'-'.$_POST["mesi"].'-'.$_POST["annoi"].' AL '.$_POST["diaf"].'-'.$_POST["mesf"].'-'.$_POST["annof"],0,0,'L',1);


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
$pdf->cell(30,4,'Fecha',1,0,'C',1);
$pdf->Cell(20,4,'Clave',1,0,'C',1);
$pdf->Cell(20,4,'Movimiento',1,0,'C',1);
$pdf->Cell(20,4,'Cantidad',1,0,'C',1);
$pdf->Cell(20,4,'Orden Venta',1,0,'C',1);
$pdf->Cell(20,4,'Orden Compra',1,0,'C',1);
$pdf->Cell(20,4,'Factura',1,0,'C',1);
$pdf->Cell(20,4,'N. de Credito',1,0,'C',1);
$pdf->Cell(20,4,'Ajuste',1,0,'C',1);

$i=1; $j=1;
//Ajustes
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(270);
$pdf->SetX(8);
$pdf->MultiCell(175,4,'II-Inventario Inicial. TA-Traslado Almacen. DM-Devolución de Mercancía. CM-Cambio por otra Mercancía. OP-Obsequio de Provedor. CD-Compra Directa. FL-Factura Libre. OC-Obsequio de Cliente. P-Promoción',1,1,'L',1);

$ResMovimientos=mysql_query("SELECT * FROM movinventario WHERE Fecha>='".$fechai."' AND Fecha<='".$fechaf."' ORDER BY Fecha ASC, Id ASC");
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
		$pdf->Cell(120,4,'REPORTE DE MOVIMIENTOS DE INVENTARIO DEL '.$_POST["diai"].'-'.$_POST["mesi"].'-'.$_POST["annoi"].' AL '.$_POST["diaf"].'-'.$_POST["mesf"].'-'.$_POST["annof"],0,0,'L',1);
		//Producto

		

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
		$pdf->cell(30,4,'Fecha',1,0,'C',1);
		$pdf->Cell(20,4,'Clave',1,0,'C',1);
		$pdf->Cell(20,4,'Movimiento',1,0,'C',1);
		$pdf->Cell(20,4,'Cantidad',1,0,'C',1);
		$pdf->Cell(20,4,'Orden Venta',1,0,'C',1);
		$pdf->Cell(20,4,'Orden Compra',1,0,'C',1);
		$pdf->Cell(20,4,'Factura',1,0,'C',1);
		$pdf->Cell(20,4,'N. de Credito',1,0,'C',1);
		$pdf->Cell(20,4,'Ajuste',1,0,'C',1);
		//Ajustes
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(270);
		$pdf->SetX(8);
		$pdf->MultiCell(175,4,'II-Inventario Inicial. TA-Traslado Almacen. DM-Devolución de Mercancía. CM-Cambio por otra Mercancía. OP-Obsequio de Provedor. CD-Compra Directa. FL-Factura Libre. OC-Obsequio de Cliente. P-Promoción',1,1,'L',1);
		
	}
	//despliega los novimientos
	//convierte 0s
	if($RResMovimientos["IdOrdenCompra"]==0){$ordencompra='-';}
	else{$ResOC=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordencompraprov WHERE Id='".$RResMovimientos["IdOrdenCompra"]."' LIMIT 1"));$ordencompra=$ResOC["NumOrden"];}
	if($RResMovimientos["IdOrdenVenta"]==0){$ordenventa='-';}
	else{$ResOV=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenventa WHERE Id='".$RResMovimientos["IdOrdenVenta"]."' LIMIT 1")); $ordenventa=$ResOV["NumOrden"];}
	if($RResMovimientos["IdFactura"]==0){$factura='-';}
	else{$ResF=mysql_fetch_array(mysql_query("SELECT NumFactura FROM facturas WHERE Id='".$RResMovimientos["IdFactura"]."' LIMIT 1"));$factura=$ResF["NumFactura"];}
	if($RResMovimientos["IdNotaCredito"]==0){$notacredito='-';}
	else{$ResNC=mysql_fetch_array(mysql_query("SELECT NumNota FROM nota_credito WHERE Id='".$RResMovimientos["IdNotaCredito"]."' LIMIT 1")); $notacredito=$ResNC["NumNota"];}
	
	//Despliega movimientos
	$ResClave=mysql_fetch_array(mysql_query("SELECT Clave FROM productos WHERE Id='".$RResMovimientos["Producto"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(5,4,$i,1,0,'C',1);
	$pdf->cell(30,4,fecha($RResMovimientos["Fecha"]),1,0,'C',1);
	$pdf->Cell(20,4,$ResClave["Clave"],1,0,'C',1);
	$pdf->Cell(20,4,$RResMovimientos["Movimiento"],1,0,'C',1);
	$pdf->Cell(20,4,$RResMovimientos["Cantidad"],1,0,'C',1);
	$pdf->Cell(20,4,$ordenventa,1,0,'C',1);
	$pdf->Cell(20,4,$ordencompra,1,0,'C',1);
	$pdf->Cell(20,4,$factura,1,0,'C',1);
	$pdf->Cell(20,4,$notacredito,1,0,'C',1);
	$pdf->Cell(20,4,$RResMovimientos["Ajuste"],1,0,'C',1);
	
	$i++; $j++; $y_axis=$y_axis+4; 
}
//Envio Archivo
$pdf->Output();
?>
