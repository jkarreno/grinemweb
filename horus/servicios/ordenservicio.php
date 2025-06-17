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

include ("../conexion.php");

function fecha($date)
{
	$fecha=explode("-", $date);
	
	switch ($fecha[1])
	{
		case '01': $mes='Enero'; break;
		case '02': $mes='Febrero'; break;
		case '03': $mes='Marzo'; break;
		case '04': $mes='Abril'; break;
		case '05': $mes='Mayo'; break;
		case '06': $mes='Junio'; break;
		case '07': $mes='Julio'; break;
		case '08': $mes='Agosto'; break;
		case '09': $mes='Septiembre'; break;
		case '10': $mes='Octubre'; break;
		case '11': $mes='Noviembre'; break;
		case '12': $mes='Diciembre'; break;
	}
	
	return $fecha[2].' de '.$mes.' de '.$fecha[0];
}

//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage();

//posicion inicial y por pagina
$y_axis_initial = 25;

$ResTicket=mysql_fetch_array(mysql_query("SELECT * FROM ordenservicio WHERE Id='".$_GET["idorden"]."' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResTicket["Cliente"]."' LIMIT 1"));
$ResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));

//imagen logotipo
$pdf->Image('../images/secsalogo.jpg',10,17,100);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(45);
$pdf->Cell(120,4,strtoupper($ResEmpresa["Nombre"]),0,0,'L',1);


//numero de Ticket
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(150);
$pdf->Cell(48,4,'Numero de Orden',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(150);
$pdf->Cell(48,4,$ResTicket["NumOrden"],1,0,'C',1);
//fecha
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(150);
$pdf->Cell(48,4,'Fecha',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(150);
$pdf->Cell(48,4,fecha($ResTicket["Fecha"]),1,0,'C',1);
//status
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(150);
$pdf->Cell(48,4,'Status',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(150);
$pdf->Cell(48,4,strtoupper($ResTicket["Status"]),1,0,'C',1);
//tecnico
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(150);
$pdf->Cell(48,4,'Tecnico',1,0,'C',1);
//
$ResTecnico=mysql_fetch_array(mysql_query("SELECT Nombre From parametros WHERE Id='".$ResTicket["Tecnico"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(150);
$pdf->Cell(48,4,$ResTecnico["Nombre"],1,0,'C',1);

//datos de la orden
//Cliente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(8);
$pdf->Cell(30,4,'Cliente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(38);
$pdf->Cell(160,4,strtoupper($ResCliente["Nombre"]),1,0,'L',1);
//Unidad
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(8);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$ResTicket["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(38);
$pdf->Cell(80,4,$ResUnidad["Nombre"],1,0,'L',1);
//Num. Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(118);
$pdf->Cell(30,4,'Num. Pedido: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(148);
$pdf->Cell(50,4,$ResServicio["NumPedido"],1,0,'L',1);
//motivo del servicio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(8);
$pdf->Cell(30,4,'Motivo del Servicio: ',1,0,'L',1);
//
$ResServicio=mysql_fetch_array(mysql_query("SELECT * FROM det_orden_servicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND IdOrden='".$ResTicket["Id"]."' AND Producto='0' AND Clave='servicio' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(38);
$pdf->Cell(80,4,$ResServicio["Descripcion"],1,0,'L',1);
//
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(118);
$pdf->Cell(30,4,'Costo del Servicio: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(148);
$pdf->Cell(50,4,'$ '.number_format($ResServicio["Importe"],2),1,0,'L',1);
//observaciones
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(190,4,'Evaluación Previa: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(68);
$pdf->SetX(8);
$pdf->MultiCell(190,4,$ResTicket["EvaluacionP"],1,'L',1);
//refacciones
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(4);
$pdf->SetX(8);
$pdf->Cell(190,4,'Descripcion de Equipo: ',1,0,'L',1);
//Cantidad
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(10,4,'#',1,0,'C',1);
$pdf->Cell(20,4,'Cantidad',1,0,'C',1);
$pdf->Cell(20,4,'Clave',1,0,'C',1);
$pdf->Cell(100,4,'Descripción',1,0,'C',1);
$pdf->Cell(20,4,'Precio Unitario',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);
//paritdas
$ResPartidas=mysql_query("SELECT * FROM det_orden_servicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND IdOrden='".$ResTicket["Id"]."' AND Producto!='0' ORDER BY Id ASC");
$j=1;
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	$ResProducto=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->Ln();
	$pdf->SetX(8);
	$pdf->Cell(10,4,$j,1,0,'C',1);
	$pdf->Cell(20,4,$RResPartidas["Cantidad"],1,0,'C',1);
	$pdf->Cell(20,4,$ResProducto["Clave"],1,0,'C',1);
	$pdf->Cell(100,4,$ResProducto["Nombre"],1,0,'L',1);
	$pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"],2),1,0,'R',1);
	$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Importe"],2),1,0,'R',1);
}
//subtotal
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(170,4,'Subtotal: ',1,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(20,4,'$ '.number_format($ResTicket["Subtotal"],2),1,0,'R',1);
//IVA
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(170,4,'IVA: ',1,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(20,4,'$ '.number_format($ResTicket["Iva"],2),1,0,'R',1);
//Total
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(170,4,'Total: ',1,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(20,4,'$ '.number_format($ResTicket["Total"],2),1,0,'R',1);
//Trabajos Realizados
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(8);
$pdf->SetX(8);
$pdf->Cell(190,4,'Trabajos Realizados',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(190,4,$ResTicket["TrabajosRealizados"],1,'J',1);
//Recomendaciones
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(4);
$pdf->SetX(8);
$pdf->Cell(190,4,'Recomendaciones y/o pendientes por hacer:',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(190,4,$ResTicket["Recomendaciones"],1,'J',1);



//Envio Archivo
$pdf->Output();
?>
