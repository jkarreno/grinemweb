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

//recibo el id de la factura
$idfactura=$_GET["idfactura"];

//datos de la factura
$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturasprovedores WHERE  Id='".$idfactura."' LIMIT 1"));

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
$ResProvedor=mysql_fetch_array(mysql_query("SELECT * FROM provedores WHERE Id='".$ResFactura["Provedor"]."' LIMIT 1"));

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
//provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(8);
$pdf->Cell(120,4,'Provedor.: '.$ResProvedor["Nombre"],0,0,'L',1);
//fecha emision
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(8);
$pdf->Cell(120,4,'Fecha Emision: '.$ResFactura["FechaEmision"],0,0,'L',1);
//fecha recepcion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(8);
$pdf->Cell(120,4,'Fecha Recepción: '.$ResFactura["FechaRecepcion"],0,0,'L',1);
//fecha recepcion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(8);
$pdf->Cell(120,4,'Num. Factura: '.$ResFactura["FacturaP"],0,0,'L',1);
//separador*/
$pdf->Line(8, 30, 200, 30);
//posicion inicial y por pagina
$y_axis_initial = 34; $y_axis=38;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->cell(30,4,'Clave',1,0,'C',1);
$pdf->Cell(110,4,'Descripcion',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);

$ResPartidas=mysql_query("SELECT * FROM det_fact_prov WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	if($partidas==20)
	{
		$partidas=1;
		$pdf->AddPage();
		
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
		//provedor
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(14);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Provedor.: '.$ResProvedor["Nombre"],0,0,'L',1);
		//fecha emision
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(18);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Fecha Emision: '.$ResFactura["FechaEmision"],0,0,'L',1);
		//fecha recepcion
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(22);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Fecha Recepción: '.$ResFactura["FechaRecepcion"],0,0,'L',1);
		//fecha recepcion
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(26);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'Num. Factura: '.$ResFactura["FacturaP"],0,0,'L',1);
		//separador*/
		$pdf->Line(8, 30, 200, 30);
		//posicion inicial y por pagina
		$y_axis_initial = 34; $y_axis=38;
		//titulos de las columnas
		$pdf->SetFillColor(000,000,000);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(8);
		$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
		$pdf->cell(30,4,'Clave',1,0,'C',1);
		$pdf->Cell(110,4,'Descripcion',1,0,'C',1);
		$pdf->Cell(20,4,'Precio',1,0,'C',1);
		$pdf->Cell(20,4,'Importe',1,0,'C',1);
	}
	$ResProducto=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResPartidas["IdProducto"]."' LIMIT 1"));
		
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    $pdf->SetY($y_axis);
    $pdf->SetX(8);
    $pdf->Cell(15,4,$RResPartidas["Cantidad"],0,0,'C',1);
    $pdf->Cell(30,4,$ResProducto["Clave"],0,0,'C',1);
   	$pdf->Cell(110,4,$ResProducto["Nombre"],0,0,'L',1);
    $pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"], 2),0,0,'R',1);
    $pdf->Cell(20,4,'$ '.number_format($RResPartidas["Importe"], 2),0,0,'R',1);
    
    $y_axis = $y_axis + 4;
    
    $subtotal=$subtotal+$RResPartidas["Importe"];
		
	$partidas++;
}


//desplegar subtotal, Iva y total
//desplegar subtotal
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($subtotal, 2),0,0,'R',1);
$y_axis=$y_axis+4;
if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
$iva=$subtotal*$ivaa;
$total=$subtotal+$iva;
//desplegar numero en letra
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(8);
$numero=explode('.', $total);
$pdf->Cell(100,4,strtoupper(convertir_a_letras($numero[0]).'pesos '.$numero[1].'/100 M. N.'),0,0,'L',1);
//descuento 1
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Descuento 1: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,' '.$ResFactura["Descuento1"]." %",0,0,'R',1);
$y_axis=$y_axis+4;
//descuento 2
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Descuento 1: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,' '.$ResFactura["Descuento2"]." %",0,0,'R',1);
$y_axis=$y_axis+4;
//descuento 3
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Descuento 1: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,' '.$ResFactura["Descuento3"]." %",0,0,'R',1);
$y_axis=$y_axis+4;
//despliega Iva
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Iva: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($iva, 2),0,0,'R',1);
$y_axis=$y_axis+4;
//despliega total
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Total: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($total, 2),0,0,'R',1);
$y_axis=$y_axis+4;

//Envio Archivo
$pdf->Output();


// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.

function centimos()
{
	global $importe_parcial;

	$importe_parcial = number_format($importe_parcial, 2, ".", "") * 100;

	if ($importe_parcial > 0)
		$num_letra = " con ".decena_centimos($importe_parcial);
	else
		$num_letra = "";

	return $num_letra;
}

function unidad_centimos($numero)
{
	switch ($numero)
	{
		case 9:
		{
			$num_letra = "nueve céntimos";
			break;
		}
		case 8:
		{
			$num_letra = "ocho céntimos";
			break;
		}
		case 7:
		{
			$num_letra = "siete céntimos";
			break;
		}
		case 6:
		{
			$num_letra = "seis céntimos";
			break;
		}
		case 5:
		{
			$num_letra = "cinco céntimos";
			break;
		}
		case 4:
		{
			$num_letra = "cuatro céntimos";
			break;
		}
		case 3:
		{
			$num_letra = "tres céntimos";
			break;
		}
		case 2:
		{
			$num_letra = "dos céntimos";
			break;
		}
		case 1:
		{
			$num_letra = "un céntimo";
			break;
		}
	}
	return $num_letra;
}

function decena_centimos($numero)
{
	if ($numero >= 10)
	{
		if ($numero >= 90 && $numero <= 99)
		{
			  if ($numero == 90)
				  return "noventa céntimos";
			  else if ($numero == 91)
				  return "noventa y un céntimos";
			  else
				  return "noventa y ".unidad_centimos($numero - 90);
		}
		if ($numero >= 80 && $numero <= 89)
		{
			if ($numero == 80)
				return "ochenta céntimos";
			else if ($numero == 81)
				return "ochenta y un céntimos";
			else
				return "ochenta y ".unidad_centimos($numero - 80);
		}
		if ($numero >= 70 && $numero <= 79)
		{
			if ($numero == 70)
				return "setenta céntimos";
			else if ($numero == 71)
				return "setenta y un céntimos";
			else
				return "setenta y ".unidad_centimos($numero - 70);
		}
		if ($numero >= 60 && $numero <= 69)
		{
			if ($numero == 60)
				return "sesenta céntimos";
			else if ($numero == 61)
				return "sesenta y un céntimos";
			else
				return "sesenta y ".unidad_centimos($numero - 60);
		}
		if ($numero >= 50 && $numero <= 59)
		{
			if ($numero == 50)
				return "cincuenta céntimos";
			else if ($numero == 51)
				return "cincuenta y un céntimos";
			else
				return "cincuenta y ".unidad_centimos($numero - 50);
		}
		if ($numero >= 40 && $numero <= 49)
		{
			if ($numero == 40)
				return "cuarenta céntimos";
			else if ($numero == 41)
				return "cuarenta y un céntimos";
			else
				return "cuarenta y ".unidad_centimos($numero - 40);
		}
		if ($numero >= 30 && $numero <= 39)
		{
			if ($numero == 30)
				return "treinta céntimos";
			else if ($numero == 91)
				return "treinta y un céntimos";
			else
				return "treinta y ".unidad_centimos($numero - 30);
		}
		if ($numero >= 20 && $numero <= 29)
		{
			if ($numero == 20)
				return "veinte céntimos";
			else if ($numero == 21)
				return "veintiun céntimos";
			else
				return "veinti".unidad_centimos($numero - 20);
		}
		if ($numero >= 10 && $numero <= 19)
		{
			if ($numero == 10)
				return "diez céntimos";
			else if ($numero == 11)
				return "once céntimos";
			else if ($numero == 11)
				return "doce céntimos";
			else if ($numero == 11)
				return "trece céntimos";
			else if ($numero == 11)
				return "catorce céntimos";
			else if ($numero == 11)
				return "quince céntimos";
			else if ($numero == 11)
				return "dieciseis céntimos";
			else if ($numero == 11)
				return "diecisiete céntimos";
			else if ($numero == 11)
				return "dieciocho céntimos";
			else if ($numero == 11)
				return "diecinueve céntimos";
		}
	}
	else
		return unidad_centimos($numero);
}

function unidad($numero)
{
	switch ($numero)
	{
		case 9:
		{
			$num = "nueve";
			break;
		}
		case 8:
		{
			$num = "ocho";
			break;
		}
		case 7:
		{
			$num = "siete";
			break;
		}
		case 6:
		{
			$num = "seis";
			break;
		}
		case 5:
		{
			$num = "cinco";
			break;
		}
		case 4:
		{
			$num = "cuatro";
			break;
		}
		case 3:
		{
			$num = "tres";
			break;
		}
		case 2:
		{
			$num = "dos";
			break;
		}
		case 1:
		{
			$num = "uno";
			break;
		}
	}
	return $num;
}

function decena($numero)
{
	if ($numero >= 90 && $numero <= 99)
	{
		$num_letra = "noventa ";
		
		if ($numero > 90)
			$num_letra = $num_letra."y ".unidad($numero - 90);
	}
	else if ($numero >= 80 && $numero <= 89)
	{
		$num_letra = "ochenta ";
		
		if ($numero > 80)
			$num_letra = $num_letra."y ".unidad($numero - 80);
	}
	else if ($numero >= 70 && $numero <= 79)
	{
			$num_letra = "setenta ";
		
		if ($numero > 70)
			$num_letra = $num_letra."y ".unidad($numero - 70);
	}
	else if ($numero >= 60 && $numero <= 69)
	{
		$num_letra = "sesenta ";
		
		if ($numero > 60)
			$num_letra = $num_letra."y ".unidad($numero - 60);
	}
	else if ($numero >= 50 && $numero <= 59)
	{
		$num_letra = "cincuenta ";
		
		if ($numero > 50)
			$num_letra = $num_letra."y ".unidad($numero - 50);
	}
	else if ($numero >= 40 && $numero <= 49)
	{
		$num_letra = "cuarenta ";
		
		if ($numero > 40)
			$num_letra = $num_letra."y ".unidad($numero - 40);
	}
	else if ($numero >= 30 && $numero <= 39)
	{
		$num_letra = "treinta ";
		
		if ($numero > 30)
			$num_letra = $num_letra."y ".unidad($numero - 30);
	}
	else if ($numero >= 20 && $numero <= 29)
	{
		if ($numero == 20)
			$num_letra = "veinte ";
		else
			$num_letra = "veinti".unidad($numero - 20);
	}
	else if ($numero >= 10 && $numero <= 19)
	{
		switch ($numero)
		{
			case 10:
			{
				$num_letra = "diez ";
				break;
			}
			case 11:
			{
				$num_letra = "once ";
				break;
			}
			case 12:
			{
				$num_letra = "doce ";
				break;
			}
			case 13:
			{
				$num_letra = "trece ";
				break;
			}
			case 14:
			{
				$num_letra = "catorce ";
				break;
			}
			case 15:
			{
				$num_letra = "quince ";
				break;
			}
			case 16:
			{
				$num_letra = "dieciseis ";
				break;
			}
			case 17:
			{
				$num_letra = "diecisiete ";
				break;
			}
			case 18:
			{
				$num_letra = "dieciocho ";
				break;
			}
			case 19:
			{
				$num_letra = "diecinueve ";
				break;
			}
		}
	}
	else
		$num_letra = unidad($numero);

	return $num_letra;
}

function centena($numero)
{
	if ($numero >= 100)
	{
		if ($numero >= 900 & $numero <= 999)
		{
			$num_letra = "novecientos ";
			
			if ($numero > 900)
				$num_letra = $num_letra.decena($numero - 900);
		}
		else if ($numero >= 800 && $numero <= 899)
		{
			$num_letra = "ochocientos ";
			
			if ($numero > 800)
				$num_letra = $num_letra.decena($numero - 800);
		}
		else if ($numero >= 700 && $numero <= 799)
		{
			$num_letra = "setecientos ";
			
			if ($numero > 700)
				$num_letra = $num_letra.decena($numero - 700);
		}
		else if ($numero >= 600 && $numero <= 699)
		{
			$num_letra = "seiscientos ";
			
			if ($numero > 600)
				$num_letra = $num_letra.decena($numero - 600);
		}
		else if ($numero >= 500 && $numero <= 599)
		{
			$num_letra = "quinientos ";
			
			if ($numero > 500)
				$num_letra = $num_letra.decena($numero - 500);
		}
		else if ($numero >= 400 && $numero <= 499)
		{
			$num_letra = "cuatrocientos ";
			
			if ($numero > 400)
				$num_letra = $num_letra.decena($numero - 400);
		}
		else if ($numero >= 300 && $numero <= 399)
		{
			$num_letra = "trescientos ";
			
			if ($numero > 300)
				$num_letra = $num_letra.decena($numero - 300);
		}
		else if ($numero >= 200 && $numero <= 299)
		{
			$num_letra = "doscientos ";
			
			if ($numero > 200)
				$num_letra = $num_letra.decena($numero - 200);
		}
		else if ($numero >= 100 && $numero <= 199)
		{
			if ($numero == 100)
				$num_letra = "cien ";
			else
				$num_letra = "ciento ".decena($numero - 100);
		}
	}
	else
		$num_letra = decena($numero);
	
	return $num_letra;
}

function cien()
{
	global $importe_parcial;
	
	$parcial = 0; $car = 0;
	
	while (substr($importe_parcial, 0, 1) == 0)
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);
	
	if ($importe_parcial >= 1 && $importe_parcial <= 9.99)
		$car = 1;
	else if ($importe_parcial >= 10 && $importe_parcial <= 99.99)
		$car = 2;
	else if ($importe_parcial >= 100 && $importe_parcial <= 999.99)
		$car = 3;
	
	$parcial = substr($importe_parcial, 0, $car);
	$importe_parcial = substr($importe_parcial, $car);
	
	$num_letra = centena($parcial).centimos();
	
	return $num_letra;
}

function cien_mil()
{
	global $importe_parcial;
	
	$parcial = 0; $car = 0;
	
	while (substr($importe_parcial, 0, 1) == 0)
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);
	
	if ($importe_parcial >= 1000 && $importe_parcial <= 9999.99)
		$car = 1;
	else if ($importe_parcial >= 10000 && $importe_parcial <= 99999.99)
		$car = 2;
	else if ($importe_parcial >= 100000 && $importe_parcial <= 999999.99)
		$car = 3;
	
	$parcial = substr($importe_parcial, 0, $car);
	$importe_parcial = substr($importe_parcial, $car);
	
	if ($parcial > 0)
	{
		if ($parcial == 1)
			$num_letra = "mil ";
		else
			$num_letra = centena($parcial)." mil ";
	}
	
	return $num_letra;
}

function millon()
{
	global $importe_parcial;
	
	$parcial = 0; $car = 0;
	
	while (substr($importe_parcial, 0, 1) == 0)
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);
	
	if ($importe_parcial >= 1000000 && $importe_parcial <= 9999999.99)
		$car = 1;
	else if ($importe_parcial >= 10000000 && $importe_parcial <= 99999999.99)
		$car = 2;
	else if ($importe_parcial >= 100000000 && $importe_parcial <= 999999999.99)
		$car = 3;
	
	$parcial = substr($importe_parcial, 0, $car);
	$importe_parcial = substr($importe_parcial, $car);
	
	if ($parcial == 1)
		$num_letras = "un millón ";
	else
		$num_letras = centena($parcial)." millones ";
	
	return $num_letras;
}

function convertir_a_letras($numero)
{
	global $importe_parcial;
	
	$importe_parcial = $numero;
	
	if ($numero < 1000000000)
	{
		if ($numero >= 1000000 && $numero <= 999999999.99)
			$num_letras = millon().cien_mil().cien();
		else if ($numero >= 1000 && $numero <= 999999.99)
			$num_letras = cien_mil().cien();
		else if ($numero >= 1 && $numero <= 999.99)
			$num_letras = cien();
		else if ($numero >= 0.01 && $numero <= 0.99)
		{
			if ($numero == 0.01)
				$num_letras = "un céntimo";
			else
				$num_letras = convertir_a_letras(($numero * 100)."/100")." céntimos";
		}
	}
	return $num_letras;
}
?>