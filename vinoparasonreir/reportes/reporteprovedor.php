<?php 

require('fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");

$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$_GET["provedor"]."' LIMIT 1"));

//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage('P', 'Letter');

//posicion inicial y por pagina
$y_axis_initial = 30;

//logotipo
$pdf->Image('../images/AC.jpg',4,4,100);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(4);
$pdf->SetX(110);
$pdf->Cell(120,4,'REPORTE DE PROVEDORES: ',0,0,'L',0);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->SetX(110);
$pdf->Cell(120,4,$ResProvedor["Nombre"],0,0,'L',0);
//separador
$pdf->Line(4, 25, 210, 25);
////COMPRAS
//titulos de las tablas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis_initial);
$pdf->SetX(15);
$pdf->Cell(175,5,'VENTAS',1,0,'C',1);
//
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->Cell(20,5,'#',1,0,'C',1);
$pdf->Cell(25,5,'FECHA',1,0,'C',1);
$pdf->Cell(40,5,'IMPORTE',1,0,'C',1);
$pdf->Cell(40,5,'SALDO',1,0,'C',1);
$pdf->Cell(25,5,'VENCE',1,0,'C',1);
$pdf->Cell(25,5,'STATUS',1,0,'C',1);
$ResCompras=mysql_query("SELECT * FROM compras WHERE Provedor='".$_GET["provedor"]."' ORDER BY Fecha ASC");
$saldo=0; $i=1; $lineas=1;
while($RResCompras=mysql_fetch_array($ResCompras))
{
	if($lineas==40)
	{
		$lineas=1;
		//Agregamos la primer pagina
		$pdf->AddPage('P', 'Letter');

		//posicion inicial y por pagina
		$y_axis_initial = 30;
		//logotipo
		$pdf->Image('../images/AC.jpg',4,4,100);
		//nombre de la empresa
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(4);
		$pdf->SetX(110);
		$pdf->Cell(120,4,'REPORTE DE PROVEDORES: ',0,0,'L',0);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(110);
		$pdf->Cell(120,4,$ResProvedor["Nombre"],0,0,'L',0);
		//separador
		$pdf->Line(4, 25, 210, 25);
		////COMPRAS
		//titulos de las tablas
		$pdf->SetFillColor(204,204,204);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(15);
		$pdf->Cell(175,5,'VENTAS',1,0,'C',1);
		//
		$pdf->SetFillColor(204,204,204);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln(5);
		$pdf->SetX(15);
		$pdf->Cell(20,5,'#',1,0,'C',1);
		$pdf->Cell(25,5,'FECHA',1,0,'C',1);
		$pdf->Cell(40,5,'IMPORTE',1,0,'C',1);
		$pdf->Cell(40,5,'SALDO',1,0,'C',1);
		$pdf->Cell(25,5,'VENCE',1,0,'C',1);
		$pdf->Cell(25,5,'STATUS',1,0,'C',1);
	}
	$fecha=$RResCompras["Fecha"];
	$nuevafecha = strtotime ( '+'.$RResCompras["Apagar"].' day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		
	if(date("Y-m-d")>$nuevafecha)
	{
		$status="VENCIDA";
	}
	if($RResCompras["Status"]=='PAGADO')
	{
		$status="PAGADO";
	}
	$saldo=$saldo+$RResCompras["Importe"];
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->Ln(5);
	$pdf->SetX(15);
	$pdf->Cell(20,5,$i,1,0,'C',1);
	$pdf->Cell(25,5,fecha($RResCompras["Fecha"]),1,0,'C',1);
	$pdf->Cell(40,5,'$ '.number_format($RResCompras["Importe"],2),1,0,'C',1);
	$pdf->Cell(40,5,'$ '.number_format($saldo,2),1,0,'C',1);
	$pdf->Cell(25,5,fecha($nuevafecha),1,0,'C',1);
	$pdf->Cell(25,5,$status,1,0,'C',1);
	$i++; $lineas++;
	$status='';
}

////PAGOS
//titulos de las tablas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(15);
$pdf->Cell(175,5,'PAGOS',1,0,'C',1);
//
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->Cell(20,5,'#',1,0,'C',1);
$pdf->Cell(25,5,'BANCO',1,0,'C',1);
$pdf->Cell(40,5,'CHEQUE',1,0,'C',1);
$pdf->Cell(40,5,'FECHA',1,0,'C',1);
$pdf->Cell(25,5,'PAGO',1,0,'C',1);
$pdf->Cell(25,5,'SALDO',1,0,'C',1);

$ResPagos=mysql_query("SELECT * FROM pagos_prov WHERE Provedor='".$_GET["provedor"]."' ORDER BY Fecha ASC");
$pago=0; $p=1; 
while($RResPagos=mysql_fetch_array($ResPagos))
{
	if($lineas==40)
	{
		$lineas=1;
		//Agregamos la primer pagina
		$pdf->AddPage('P', 'Letter');

		//posicion inicial y por pagina
		$y_axis_initial = 30;
		//logotipo
		$pdf->Image('../images/AC.jpg',4,4,100);
		//nombre de la empresa
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(4);
		$pdf->SetX(110);
		$pdf->Cell(120,4,'REPORTE DE PROVEDORES: ',0,0,'L',0);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(110);
		$pdf->Cell(120,4,$ResProvedor["Nombre"],0,0,'L',0);
		//separador
		$pdf->Line(4, 25, 210, 25);
		//titulos de las tablas
		$pdf->SetFillColor(204,204,204);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln();
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(15);
		$pdf->Cell(175,5,'PAGOS',1,0,'C',1);
		//
		$pdf->SetFillColor(204,204,204);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln(5);
		$pdf->SetX(15);
		$pdf->Cell(20,5,'#',1,0,'C',1);
		$pdf->Cell(25,5,'BANCO',1,0,'C',1);
		$pdf->Cell(40,5,'CHEQUE',1,0,'C',1);
		$pdf->Cell(40,5,'FECHA',1,0,'C',1);
		$pdf->Cell(25,5,'PAGO',1,0,'C',1);
		$pdf->Cell(25,5,'SALDO',1,0,'C',1);
	}
	
	$pago=$pago+$RResPagos["Pago"];
	if($RResPagos["Banco"]==0){$banco="EFECTIVO";}
	elseif($RResPagos["Banco"]!=0){$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResPagos["Banco"]."' LIMIT 1")); $banco=$ResBanco["Nombre"];}
		
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->Ln(5);
	$pdf->SetX(15);
	$pdf->Cell(20,5,$p,1,0,'C',1);
	$pdf->Cell(25,5,$banco,1,0,'C',1);
	$pdf->Cell(40,5,$RResPagos["Cheque"],1,0,'C',1);
	$pdf->Cell(40,5,fecha($RResPagos["Fecha"]),1,0,'C',1);
	$pdf->Cell(25,5,'$ '.number_format($RResPagos["Pago"],2),1,0,'R',1);
	$pdf->Cell(25,5,'$ '.number_format($pago,2),1,0,'R',1);
	$p++; $lineas++;
		
}

////CHEQUES POR COBRAR
//titulos de las tablas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(15);
$pdf->Cell(175,5,'CHEQUES POR COBRAR',1,0,'C',1);
//
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(5);
$pdf->SetX(15);
$pdf->Cell(20,5,'#',1,0,'C',1);
$pdf->Cell(25,5,'BANCO',1,0,'C',1);
$pdf->Cell(40,5,'FECHA',1,0,'C',1);
$pdf->Cell(40,5,'CHEQUE',1,0,'C',1);
$pdf->Cell(25,5,'IMPORTE',1,0,'C',1);
$pdf->Cell(25,5,'SALDO',1,0,'C',1);
$ResCheques=mysql_query("SELECT * FROM chequepost_prov WHERE Provedor='".$_GET["provedor"]."' ORDER BY Fecha ASC");
$saldoc=0; $c=1;
while($RResCheques=mysql_fetch_array($ResCheques))
{
	if($lineas==40)
	{
		$lineas=1;
		//Agregamos la primer pagina
		$pdf->AddPage('P', 'Letter');

		//posicion inicial y por pagina
		$y_axis_initial = 30;
		//logotipo
		$pdf->Image('../images/AC.jpg',4,4,100);
		//nombre de la empresa
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(4);
		$pdf->SetX(110);
		$pdf->Cell(120,4,'REPORTE DE PROVEDORES: ',0,0,'L',0);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(110);
		$pdf->Cell(120,4,$ResProvedor["Nombre"],0,0,'L',0);
		//separador
		$pdf->Line(4, 25, 210, 25);
		//titulos de las tablas
		$pdf->SetFillColor(204,204,204);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln();
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(15);
		$pdf->Cell(175,5,'CHEQUES POR COBRAR',1,0,'C',1);
		//
		$pdf->SetFillColor(204,204,204);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln(5);
		$pdf->SetX(15);
		$pdf->Cell(20,5,'#',1,0,'C',1);
		$pdf->Cell(25,5,'BANCO',1,0,'C',1);
		$pdf->Cell(40,5,'FECHA',1,0,'C',1);
		$pdf->Cell(40,5,'CHEQUE',1,0,'C',1);
		$pdf->Cell(25,5,'IMPORTE',1,0,'C',1);
		$pdf->Cell(25,5,'SALDO',1,0,'C',1);
	}
	$saldoc=$saldoc+$RResCheques["Importe"];
	$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResCheques["Banco"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->Ln(5);
	$pdf->SetX(15);
	$pdf->Cell(20,5,$c,1,0,'C',1);
	$pdf->Cell(25,5,$ResBanco["Nombre"],1,0,'C',1);
	$pdf->Cell(40,5,fecha($RResCheques["Fecha"]),1,0,'C',1);
	$pdf->Cell(40,5,$RResCheques["NumCheque"],1,0,'C',1);
	$pdf->Cell(25,5,'$ '.number_format($RResCheques["Importe"], 2),1,0,'R',1);
	$pdf->Cell(25,5,'$ '.number_format($saldoc, 2),1,0,'R',1);
	$c++; $lineas++;
}

if($lineas==40)
	{
		$lineas=1;
		//Agregamos la primer pagina
		$pdf->AddPage('P', 'Letter');

		//posicion inicial y por pagina
		$y_axis_initial = 30;
		//logotipo
		$pdf->Image('../images/AC.jpg',4,4,100);
		//nombre de la empresa
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(4);
		$pdf->SetX(110);
		$pdf->Cell(120,4,'REPORTE DE PROVEDORES: ',0,0,'L',0);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(110);
		$pdf->Cell(120,4,$ResProvedor["Nombre"],0,0,'L',0);
		$pdf->SetY($y_axis_initial);
	}

//Deudas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(15);
$pdf->Cell(100,5,'DEUDA AL PROVEDOR: ',1,0,'R',1);
$pdf->SetX(115);
$pdf->Cell(50,5,'$ '.number_format(($saldo-$pago),2),1,0,'R',1);
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(15);
$pdf->Cell(100,5,'DEUDA MENOS CHEQUES POST FECHADOS :',1,0,'R',1);
$pdf->SetX(115);
$pdf->Cell(50,5,'$ '.number_format((($saldo-$pago)-$saldoc),2),1,0,'R',1);
//Envio Archivo
$pdf->Output();

function fecha($fecha)
{
	switch($fecha[5].$fecha[6])
	{
		case '01'; $mes='Ene'; break;
		case '02'; $mes='Feb'; break;
		case '03'; $mes='Mar'; break;
		case '04'; $mes='Abr'; break;
		case '05'; $mes='May'; break;
		case '06'; $mes='Jun'; break;
		case '07'; $mes='Jul'; break;
		case '08'; $mes='Ago'; break;
		case '09'; $mes='Sep'; break;
		case '10'; $mes='Oct'; break;
		case '11'; $mes='Nov'; break;
		case '12'; $mes='Dic'; break;
	}
	
	$fechanew=$fecha[8].$fecha[9].'-'.$mes.'-'.$fecha[2].$fecha[3];
	
	return $fechanew;
}
?>