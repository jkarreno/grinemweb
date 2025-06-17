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

require('fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");

//recibo el id de la factura
if($_POST["idnota"]){$idnota=$_POST["idnota"];}
elseif($_GET["idnota"]){$idnota=$_GET["idnota"];}

//datos de la nota de credito
$ResNota=mysql_fetch_array(mysql_query("SELECT * FROM nota_credito WHERE Id='".$idnota."' LIMIT 1"));
$ResFNotasC=mysql_fetch_array(mysql_query("SELECT * FROM fnotascredito WHERE FolioI<='".$ResNota["NumNota"]."' AND FolioF>='".$ResNota["NumNota"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));

//numero de factura
$ResFact=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura FROM facturas WHERE Id='".$ResNota["IdFactura"]."' LIMIT 1"));

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
$ResSuc=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id!='".$_SESSION["sucursal"]."' AND Empresa='".$_SESSION["empresa"]."' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResNota["Cliente"]."' LIMIT 1"));
	
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
$pdf->Cell(120,4,strtoupper($RResEmpresa["Nombre"]),0,0,'L',1);
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(8);
if($ResEmisor["Nombre"]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
//RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(17);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["RFC"],0,0,'L',1);
//Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(8);
$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' Interior '.$ResEmisor["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
//Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(23);
$pdf->SetX(8);
$pdf->Cell(120,4,'Col. '.$ResEmisor["Colonia"],0,0,'L',1);
//Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["Municipio"].' '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);
//codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(29);
$pdf->SetX(8);
$pdf->Cell(120,4,'C. P.: '.$ResEmisor["CodPostal"].' '.$ResEmisor["Pais"],0,0,'L',1);
//Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(32);
$pdf->SetX(8);
$telefonos=$ResEmisor["Telefono1"];if($ResEmisor["Telefono2"]!=''){$telefonos.=', '.$ResEmisor["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
//Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(35);
$pdf->SetX(8);
$pdf->Cell(120,4,'Correo Electronico: '.$ResEmisor["CorreoE"],0,0,'L',1);
//DATOS DE LA SUCURSAL
if($ResSuc["Nombre"]!='')
{
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(70);
if($ResSuc["Nombre"]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
//RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(17);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["RFC"],0,0,'L',1);
//Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(70);
$dome=$ResSuc["Calle"].' No. '.$ResSuc["NoExterior"];if($ResSuc["NoInterior"]!=''){$dome.=' Interior '.$ResSuc["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
//Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(23);
$pdf->SetX(70);
$pdf->Cell(120,4,'Col. '.$ResSuc["Colonia"],0,0,'L',1);
//Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["Municipio"].' '.$ResSuc["Localidad"].' '.$ResSuc["Estado"],0,0,'L',1);
//codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(29);
$pdf->SetX(70);
$pdf->Cell(120,4,'C. P.: '.$ResSuc["CodPostal"].' '.$ResSuc["Pais"],0,0,'L',1);
//Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(32);
$pdf->SetX(70);
$telefonos=$ResSuc["Telefono1"];if($ResSuc["Telefono2"]!=''){$telefonos.=', '.$ResSuc["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
//Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(35);
$pdf->SetX(70);
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);
}
//DATOS DE LA NOTA DE CREDITO
//folio
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(10);
$pdf->SetX(135);
$pdf->Cell(120,4,'Nota de Credito',0,0,'L',1);
//serie
if($ResNota["Serie"])
{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(14);
	$pdf->SetX(135);
	$pdf->Cell(120,4,'Serie: '.$ResNota["Serie"],0,0,'L',1);
}
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(135);
$pdf->Cell(120,4,'No. '.$ResNota["NumNota"],0,0,'L',1);

//fecha
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(135);
$pdf->Cell(120,4,'Fecha: '.$ResNota["Fecha"],0,0,'L',1);
//aprobacion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(135);
$pdf->Cell(120,4,'Aprobación: '.$ResFNotasC["NumAprobacion"],0,0,'L',1);
//certificado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(135);
$pdf->Cell(120,4,'Certificado: '.$ResFNotasC["NumCertificado"],0,0,'L',1);
//Año de aprobacion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(135);
$pdf->Cell(120,4,'Año Aprobación: '.$ResFNotasC["Fecha"][0].$ResFNotasC["Fecha"][1].$ResFNotasC["Fecha"][2].$ResFNotasC["Fecha"][3],0,0,'L',1);
//separador
$pdf->Line(8, 42, 200, 42);
//DATOS DEL RECEPTOR
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(8);
$pdf->Cell(8,4,'Cliente: ',0,0,'L',1);
//Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(25);
$pdf->Cell(8,4,$ResCliente["Nombre"],0,0,'L',1);
//RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(25);
$pdf->Cell(8,4,$ResCliente["RFC"],0,0,'L',1);
//domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(25);
$domr=$ResCliente["Direccion"];if($ResCliente["NumExterior"]){$domr.=' NUM. '.$ResCliente["NumExterior"];}if($ResCliente["NumInterior"]){$domr.=' INTERIOR : '.$ResCliente["NumInterior"];}
$pdf->Cell(8,4,$domr.' Col. '.$ResCliente["Colonia"],0,0,'L',1);
//ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(25);
$pdf->Cell(8,4,$ResCliente["Ciudad"].' '.$ResCliente["Estado"],0,0,'L',1);
//codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(25);
$pdf->Cell(8,4,'C. P.: '.$ResCliente["CP"].' '.$ResCliente["Pais"],0,0,'L',1);
//Numero de Provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(10,4,'Provedor Num.: '.$ResCliente["NumProvedor"],0,0,'L',1);
//Numero de Factura
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(80);
$pdf->Cell(10,4,'Aplicada a Factura: '.$ResFact["Serie"].' '.$ResFact["NumFactura"],0,0,'L',1);
//separador
$pdf->Line(8, 68, 200, 68);
//cadena orginal
	//version
	$cadenaoriginal='||2.0|'; 
	//serie
	if($ResNota["Serie"]!=''){$cadenaoriginal.=$ResFNotasC["Serie"].'|';}
	//folio
	$cadenaoriginal.=$ResNota["NumNota"].'|';
	//fecha
	for($i=0; $i<=9; $i++){$cadenaoriginal.=$ResNota["Fecha"][$i];}
	$cadenaoriginal.='T';
	for($i=11; $i<=18;$i++){$cadenaoriginal.=$ResNota["Fecha"][$i];}
	//datos emisor
	//numaprobacion
	//$cadenaoriginal.='|'.$ResFFacturas["NumAprobacion"].'|'.$ResFFacturas["NumCertificado"].'|';
	$cadenaoriginal.='|'.$ResFNotasC["NumAprobacion"].'|';
	//añoaprovacion
	$cadenaoriginal.=$ResFNotasC["Fecha"][0].$ResFNotasC["Fecha"][1].$ResFNotasC["Fecha"][2].$ResFNotasC["Fecha"][3].'|';
	//tipo de comprovante
	$cadenaoriginal.='egreso|';
	//forma de pago
	$cadenaoriginal.='PAGO EN UNA SOLA EXHIBICIÓN|';
	//condiciones de pago
	//subtotal
	$cadenaoriginal.=$ResNota["Importe"].'|';
	//descuento
	//total
	$cadenaoriginal.=$ResNota["Total"].'|';
	//rfc del emisor
	$cadenaoriginal.=$ResEmisor["RFC"].'|';
	//Nombre del emisor
	$cadenaoriginal.=$RResEmpresa["Nombre"].'|';
	//Calle del domicilio fiscal del emisor
	$cadenaoriginal.=$ResEmisor["Calle"].'|';
	//numero exterior del emisor
	if($ResEmisor["NoExterior"]!=''){$cadenaoriginal.=$ResEmisor["NoExterior"].'|';}
	//numero interior del emisor
	if($ResEmisor["NoInterior"]!=''){$cadenaoriginal.=$ResEmisor["NoInterior"].'|';}
	//colonia del emisor
	if($ResEmisor["Colonia"]!=''){$cadenaoriginal.=$ResEmisor["Colonia"].'|';}
	//localidad del emisor
	if($ResEmisor["Localidad"]!=''){$cadenaoriginal.=$ResEmisor["Localidad"].'|';}
	//municipio del emisro
	$cadenaoriginal.=$ResEmisor["Municipio"].'|';
	//estado del emisor
	$cadenaoriginal.=$ResEmisor["Estado"].'|';
	//pais del emisor
	$cadenaoriginal.=$ResEmisor["Pais"].'|';
	//codigo porstal del emisor
	$cadenaoriginal.=$ResEmisor["CodPostal"];
	//datos receptor
	//rfc del receptor
	$cadenaoriginal.='|'.$ResCliente["RFC"].'|';
	//nombre del receptor
	$cadenaoriginal.=$ResCliente["Nombre"].'|';
	//calle del receptor
	$cadenaoriginal.=$ResCliente["Direccion"].'|';
	//numero exterior del receptor
	if($ResCliente["NumExterior"]!=''){$cadenaoriginal.=$ResCliente["NumExterior"].'|';}
	//numero interior del receptor
	if($ResCliente["NumInterior"]!=''){$cadenaoriginal.=$ResCliente["NumInterior"].'|';}
	//colonia del receptor
	if($ResCliente["Colonia"]!=''){$cadenaoriginal.=$ResCliente["Colonia"].'|';}
	//localidad del receptor
	if($ResCliente["Ciudad"]!=''){$cadenaoriginal.=$ResCliente["Ciudad"].'|';}
	//municipio del receptor
	if($ResCliente["Municipio"]!=''){$cadenaoriginal.=$ResCliente["Municipio"].'|';}
	//estado del receptor
	if($ResCliente["Estado"]!=''){$cadenaoriginal.=$ResCliente["Estado"].'|';}
	//pais del receptor
	$cadenaoriginal.=$ResCliente["Pais"].'|';
	//codigo postal del receptor
	if($ResCliente["CP"]!=''){$cadenaoriginal.=$ResCliente["CP"].'|';}
//Partida de la Factura
//observaciones
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(70);
$pdf->SetX(8);
$pdf->MultiCell(195,4,'Observaciones: '.$ResNota["Observaciones"],0,'L',1);
//Agente
//$pdf->SetFillColor(255,255,255);
//$pdf->SetFont('Arial','',10);
//$pdf->SetTextColor(000,000,000);
//$pdf->SetY(82);
//$pdf->SetX(8);
//$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
//$pdf->Cell(195,4,'Agente: '.$ResAgente["Nombre"],0,0,'L',1);
//posicion inicial y por pagina
$y_axis_initial = 86; $y_axis=90;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->Cell(30,4,'Clave',1,0,'C',1);
$pdf->Cell(10,4,'Unidad',1,0,'C',1);
$pdf->Cell(100,4,'Descripcion',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);

$ResPartidas=mysql_query("SELECT * FROM det_nota_credito WHERE IdNota='".$idnota."' ORDER BY Id ASC");
$partidas=1;
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
	
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
	
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    $pdf->SetY($y_axis);
    $pdf->SetX(8);
    $pdf->Cell(15,4,$RResPartidas["Cantidad"],0,0,'C',1);
    $pdf->Cell(30,4,$RResPartidas["Clave"],0,0,'C',1);
    $pdf->Cell(10,4,$ResUnidad["Nombre"],0,0,'C',1);
    $ResMarca=mysql_query("SELECT Id FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='tproducto' ORDER BY Id ASC"); 
    $J=1;
    while($RResMarca=mysql_fetch_array($ResMarca))
    {
    	if($RResMarca["Id"]==$ResProd["TipoProducto"]){$numero=$J;}
    	$J++;
    }
    if($RResPartidas["Producto"]!=0)
    {
    $pdf->Cell(100,4,$ResProd["Nombre"].' - '.$ResProd["Clave"].' - '.$numero,0,0,'L',1);
    }
    else
    {
    $pdf->Cell(100,4,$RResPartidas["Descripcion"],0,0,'L',1);	
    }
    $pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"], 2),0,0,'R',1);
    $pdf->Cell(20,4,'$ '.number_format($RResPartidas["Importe"], 2),0,0,'R',1);
    
    $y_axis = $y_axis + 4;
    
    //continua cadena original
		//cantidad
		$cadenaoriginal.=$RResPartidas["Cantidad"].'|';
		//unidad
		if($ResUnidad["Nombre"]){$cadenaoriginal.=$ResUnidad["Nombre"].'|';}
		//numero de identificacion (clave)
		//$cadenaoriginal.=$RResPartidas["Clave"].'|';
		//descripcion
		if($RResPartidas["Producto"]!=0){$cadenaoriginal.=$ResProd["Nombre"].' - '.$ResProd["Clave"].'|';}
		else{$cadenaoriginal.=$RResPartidas["Descripcion"].'|';}		
		//valor unitario
		$cadenaoriginal.=$RResPartidas["PrecioUnitario"].'|';
		//importe
		$cadenaoriginal.=$RResPartidas["Importe"].'|';
		
	$partidas++;
}
//partidas en blanco
for($partidas; $partidas<=15; $partidas++)
{
	$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    $pdf->SetY($y_axis);
    $pdf->SetX(8);
    $pdf->Cell(15,4,'',0,0,'C',1);
    $pdf->Cell(30,4,'',0,0,'C',1);
    $pdf->Cell(110,4,'',0,0,'L',1);
    $pdf->Cell(20,4,'',0,0,'R',1);
    $pdf->Cell(20,4,'',0,0,'R',1);
    $y_axis = $y_axis + 4;
}
//continua cadena original
	//tipo de inpuesto
	$cadenaoriginal.='IVA|'.($_SESSION["iva"]*100).'.00|';
	//importe
	$cadenaoriginal.=$ResNota["Iva"].'|'.$ResNota["Iva"].'||';
//desplegar subtotal, Iva y total
//desplegar subtotal
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($ResNota["Importe"], 2),0,0,'R',1);
$y_axis=$y_axis+4;
//desplegar numero en letra
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(8);
$numero=explode('.', $ResNota["Total"]);
$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' pesos '.$numero[1].'/100 M. N.'),0,0,'L',1);
//despliega Iva
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Iva: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($ResNota["Iva"], 2),0,0,'R',1);
$y_axis=$y_axis+4;
//despliega total
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Total: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($ResNota["Total"], 2),0,0,'R',1);
$y_axis=$y_axis+4;
//pagare
//muestra cadena original
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pagare='PAGO EN UNA SOLA EXHIBICIÓN.
Este documento es una representación impresa de un CFD. La tenencia de este documento no es comprobante de pago.
La Firma o sello puesto en cualquier lugar de esta factura implica la total aceptación. Cualquier devolución tendra cargo de 20%.
En caso de devolución de su cheque se cobrará el 20% de cargo de acuerdo al art. 193 de la ley general de titulos y operaciones de credito.
Por este pagare me(nos) oblico(amos) a pagar incondicionalmente a la orden de '.$RResEmpresa["Nombre"].' el importe total de esta factura valor de las mercacias especificadas a nuestra entera satisfacción por nuestro factor o dependiente. Si no fuera pagada a su vencimiento causara un interes del 5% mensual durante el tiempo que permanezca total o parcialmente insoluto sin que esto se entienda prorrogado el pago';
$pdf->MultiCell(195,4,$pagare,1,'J');
$y_axis=$y_axis+4;
//titulos de la columna
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(195,4,'Cadena Original',1,0,'C',1);
$y_axis=$y_axis+4;
//muestra cadena original
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(195,4,$cadenaoriginal,0,'L');
$y_axis=$y_axis+4;

//digestion sha1
	$cadenaoriginal = utf8_encode($cadenaoriginal) ;
	//$cadenaoriginal=md5($cadenaoriginal);
	//guardamos en archivo
	$fp = fopen ("../certificados/sellos/nc/".$idnota.".txt", "w+");
       fwrite($fp, $cadenaoriginal);
	fclose($fp);
	//archivo .key
	$key='../certificados/'.$ResFNotasC["ArchivoCadena"];
	//sellamos archivo
	exec("openssl dgst -sha1 -sign $key ../certificados/sellos/nc/".$idnota.".txt | openssl enc -base64 -A > ../certificados/sellos/nc/sello_".$idnota.".txt");

//sello digital
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(195,4,'Sello Digital',1,0,'C',1);
$y_axis=$y_axis+4;
//despliega el sello
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);

 		$f=fopen("../certificados/sellos/nc/sello_".$idnota.".txt",'r');
    $txt=fread($f,filesize("../certificados/sellos/nc/sello_".$idnota.".txt"));
    fclose($f);
//$sello=readfile("../certificados/sellos/sello_".$idnota.".txt");
$pdf->MultiCell(195,4,$txt,0,'J');
$y_axis=$y_axis+4;

//Envio Archivo
$pdf->Output();

// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.

function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' uno' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'un'; 
         $subcent = 'os'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'un'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 
?>
