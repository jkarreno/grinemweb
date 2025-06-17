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
$banco=$_GET["banco"];
$movimiento=$_GET["movimiento"];
$nummov=$_GET["nummov"];
$cliente=$_GET["cliente"];
$fecha=$_GET["fecha"];
$folio=$_GET["folio"];

//Datos de la sucursal
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
//Datos del cliente
$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));

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
$pdf->Cell(120,4,'Cliente: '.$ResCliente["Nombre"],0,0,'L',1);
//fecha
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(8);
$pdf->Cell(120,4,'Fecha: '.fecha($fecha),0,0,'L',1);
//folio
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(8);
$pdf->Cell(120,4,'Folio: '.$folio,0,0,'L',1);
//movimiento
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(8);
$pdf->Cell(120,4,'Movimiento: '.$movimiento,0,0,'L',1);
//num movimiento
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(32);
$pdf->SetX(8);
$pdf->Cell(120,4,'Mumero: '.$nummov,0,0,'L',1);
//separador
$pdf->Line(8, 36, 200, 36);
//posicion inicial y por pagina
$y_axis_initial = 40; $y_axis=44;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(15,4,' ',1,0,'C',1);
$pdf->cell(40,4,'Num. Factura',1,0,'C',1);
$pdf->Cell(40,4,'Importe',1,0,'C',1);
$pdf->Cell(40,4,'Abono',1,0,'C',1);
$i=1;$j=1;
if($folio=='')
{
$ResMovimiento=mysql_query("SELECT * FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fecha."' AND Banco='".$banco."' AND TipoMovimiento='".$movimiento."' AND NumMovimiento='".$nummov."' AND Cliente='".$cliente."' ORDER BY Id ASC");
}
else
{
$ResMovimiento=mysql_query("SELECT * FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumFolio='".$folio."' AND Fecha='".$fecha."' AND Banco='".$banco."' AND TipoMovimiento='".$movimiento."' AND NumMovimiento='".$nummov."' AND Cliente='".$cliente."' ORDER BY Id ASC");	
}

while($RResMovimiento=mysql_fetch_array($ResMovimiento))
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
		$pdf->Cell(120,4,'Cliente: '.$ResCliente["Nombre"],0,0,'L',1);
		//fecha
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(20);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Fecha: '.fecha($fecha),0,0,'L',1);
		//folio
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(24);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Folio: '.$folio,0,0,'L',1);
		//movimiento
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(28);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Movimiento: '.$movimiento,0,0,'L',1);
		//num movimiento
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(32);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Mumero: '.$nummov,0,0,'L',1);
		//separador
		$pdf->Line(8, 36, 200, 36);
		//posicion inicial y por pagina
		$y_axis_initial = 40; $y_axis=44;
		//titulos de las columnas
		$pdf->SetFillColor(000,000,000);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(8);
		$pdf->Cell(15,4,' ',1,0,'C',1);
		$pdf->cell(40,4,'Num. Factura',1,0,'C',1);
		$pdf->Cell(40,4,'Importe',1,0,'C',1);
		$pdf->Cell(40,4,'Abono',1,0,'C',1);
	}
	$ResNumFact=mysql_fetch_array(mysql_query("SELECT NumFactura, Total FROM facturas WHERE Id='".$RResMovimiento["IdFactura"]."' LIMIT 1"));
	//partidas del pago
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(15,4,$i,1,0,'C',1);
	$pdf->cell(40,4,$ResNumFact["NumFactura"],1,0,'C',1);
	$pdf->Cell(40,4,'$ '.number_format($ResNumFact["Total"],2),1,0,'C',1);
	$pdf->Cell(40,4,'$ '.number_format($RResMovimiento["Abono"],2),1,0,'C',1);
	
	$i++; $j++; $y_axis=$y_axis+4; $total=$total+$ResNumFact["Total"];$totalabono=$totalabono+$RResMovimiento["Abono"];
}

//totales
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->cell(55,4,'Total :',1,0,'R',1);
	$pdf->Cell(40,4,'$ '.number_format($total,2),1,0,'C',1);
	$pdf->Cell(40,4,'$ '.number_format($totalabono,2),1,0,'C',1);


//Envio Archivo
$pdf->Output();
?>