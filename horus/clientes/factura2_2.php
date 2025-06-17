<?php
require('fpdf/fpdf.php');
require('xml2array.php');

//conecto a la base de datos
include("../conexion.php");

$idfactura=$_GET["idfactura"];
$empresa=$_GET["empresa"];
$sucursal=$_GET["sucursal"];

//datos de la factura
$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));
$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$empresa."' AND Sucursal='".$sucursal."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));
$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");
$xml=xml2array(utf8_encode($ResFactura["XML"])); //lee el xml y lo convierte en array
$paginas=ceil(mysql_num_rows($ResPartidas)/20); $cuentapaginas=1;
if(strlen($ResFactura["CadenaOriginal"])>3000){$paginas++;}

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$sucursal."' LIMIT 1"));
$ResSuc=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id!='".$sucursal."' AND Empresa='".$empresa."' AND Nombre!='MATANT' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));
	
//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage();

//posicion inicial y por pagina
$y_axis_initial = 25;

//Imprimir Datos de la Empresa
$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE ID='".$empresa."' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);
//logotipo
$pdf->Image('../images/'.$RResEmpresa["Logotipo"],8,6,100);
$pdf->SetY(13);
$pdf->SetX(100);
$pdf->SetFillColor(076,076,076);
$pdf->Cell(50,0.8,'',0,0,'L',1);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(15);
$pdf->SetX(44);
$pdf->Cell(120,4,strtoupper($RResEmpresa["Nombre"]),0,0,'L',1);
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(8);
if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
////RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["RFC"],0,0,'L',1);
////Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(8);
$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' Interior '.$ResEmisor["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
////Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(31);
$pdf->SetX(8);
$pdf->Cell(120,4,'Col. '.$ResEmisor["Colonia"],0,0,'L',1);
////Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["Municipio"].' '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);
////codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(37);
$pdf->SetX(8);
$pdf->Cell(120,4,'C. P.: '.$ResEmisor["CodPostal"].' '.$ResEmisor["Pais"],0,0,'L',1);
////Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(40);
$pdf->SetX(8);
$telefonos=$ResEmisor["Telefono1"];if($ResEmisor["Telefono2"]!=''){$telefonos.=', '.$ResEmisor["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
////Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(43);
$pdf->SetX(8);
$pdf->Cell(120,4,'Correo Electronico: '.$ResEmisor["CorreoE"],0,0,'L',1);
//DATOS DE LA SUCURSAL
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(70);
if($ResSuc["Nombre"][0].$ResSuc["Nombre"][1].$ResSuc["Nombre"][2].$ResSuc["Nombre"][3].$ResSuc["Nombre"][4].$ResSuc["Nombre"][5]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
//RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["RFC"],0,0,'L',1);
//Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(70);
$dome=$ResSuc["Calle"].' No. '.$ResSuc["NoExterior"];if($ResSuc["NoInterior"]!=''){$dome.=' Interior '.$ResSuc["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
//Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(31);
$pdf->SetX(70);
$pdf->Cell(120,4,'Col. '.$ResSuc["Colonia"],0,0,'L',1);
//Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["Municipio"].' '.$ResSuc["Localidad"].' '.$ResSuc["Estado"],0,0,'L',1);
//codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(37);
$pdf->SetX(70);
$pdf->Cell(120,4,'C. P.: '.$ResSuc["CodPostal"].' '.$ResSuc["Pais"],0,0,'L',1);
//Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(40);
$pdf->SetX(70);
$telefonos=$ResSuc["Telefono1"];if($ResSuc["Telefono2"]!=''){$telefonos.=', '.$ResSuc["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
//Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(43);
$pdf->SetX(70);
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);
//DATOS DE LA FACTURA
//folio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(8);
$pdf->SetX(135);
$pdf->Cell(34,4,'Factura: ',1,0,'L',1);
//serie y folio
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(8);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFactura["Serie"].$ResFactura["NumFactura"],1,0,'L',1);
//fecha
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(12);
$pdf->SetX(135);
$pdf->Cell(34,4,'Fecha: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(12);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFactura["Fecha"],1,0,'L',1);
//aprobacion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(135);
$pdf->Cell(34,4,'Aprobación: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["NumAprobacion"],1,0,'L',1);
//certificado
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(135);
$pdf->Cell(34,4,'Certificado: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["NumCertificado"],1,0,'L',1);
//Año de aprobacion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(135);
$pdf->Cell(34,4,'Año Aprobación: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],1,0,'L',1);
//Expedido en
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(135);
$pdf->Cell(34,4,'Expedido en: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],1,0,'L',1);
//Regimen
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(32);
$pdf->SetX(135);
$pdf->Cell(68,4,'Regimen Fiscal: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(36);
$pdf->SetX(135);
$pdf->MultiCell(68,4,$RResEmpresa["Regimen"],1,'L',1);
////Nota
if($ResFactura["Nota"]!='')
{
	$Y=$pdf->GetY();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(135);
$pdf->MultiCell(68,4,$ResFactura["Nota"],1,'L',1);
}

////DATOS DEL RECEPTOR
$pdf->SetY(50);
$pdf->SetX(8);
$pdf->Cell(195,24,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(8);
$pdf->Cell(20,4,'Cliente: ',0,0,'L',1);
//
////Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(9);
$pdf->Cell(8,4,utf8_decode($xml["Comprobante"]["Receptor_attr"]["nombre"]),0,0,'L',1);
////RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor_attr"]["rfc"],0,0,'L',1);
////domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(9);
$domr=$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["calle"];if($xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"];}if($xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR : '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"];}
$pdf->Cell(8,4,$domr.' Col. '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["colonia"],0,0,'L',1);
////ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["localidad"].' '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["estado"],0,0,'L',1);
////codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(68);
$pdf->SetX(9);
$pdf->Cell(8,4,'C. P.: '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["codigoPostal"].' '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["pais"],0,0,'L',1);
//
////observaciones
$pdf->SetY(76);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(76);
$pdf->SetX(8);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(80);
$pdf->SetX(9);
$pdf->MultiCell(190,4,$ResFactura["Observaciones"],0,'L',1);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1);
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["Comprobante_attr"]["NumCtaPago"],1,0,'L',1);
//posicion inicial y por pagina
$y_axis_initial = 104; $y_axis=108;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,'#',1,0,'C',1);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->Cell(20,4,'Clave',1,0,'C',1);
$pdf->Cell(20,4,'Unidad',1,0,'C',1);
$pdf->Cell(90,4,'Descripcion',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);

$i=1;
$partidas=1;
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
//Repite Cabecera
	if($i==21)
	{
		$i=1; $cuentapaginas++;
		
		$pdf->AddPage();
		
		//posicion inicial y por pagina
		$y_axis_initial = 25;

//logotipo
$pdf->Image('../images/'.$RResEmpresa["Logotipo"],8,6,100);
$pdf->SetY(13);
$pdf->SetX(100);
$pdf->SetFillColor(076,076,076);
$pdf->Cell(50,0.8,'',0,0,'L',1);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(15);
$pdf->SetX(44);
$pdf->Cell(120,4,strtoupper($RResEmpresa["Nombre"]),0,0,'L',1);
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(8);
if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
////RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["RFC"],0,0,'L',1);
////Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(8);
$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' Interior '.$ResEmisor["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
////Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(31);
$pdf->SetX(8);
$pdf->Cell(120,4,'Col. '.$ResEmisor["Colonia"],0,0,'L',1);
////Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["Municipio"].' '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);
////codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(37);
$pdf->SetX(8);
$pdf->Cell(120,4,'C. P.: '.$ResEmisor["CodPostal"].' '.$ResEmisor["Pais"],0,0,'L',1);
////Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(40);
$pdf->SetX(8);
$telefonos=$ResEmisor["Telefono1"];if($ResEmisor["Telefono2"]!=''){$telefonos.=', '.$ResEmisor["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
////Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(43);
$pdf->SetX(8);
$pdf->Cell(120,4,'Correo Electronico: '.$ResEmisor["CorreoE"],0,0,'L',1);
//DATOS DE LA SUCURSAL
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(70);
if($ResSuc["Nombre"][0].$ResSuc["Nombre"][1].$ResSuc["Nombre"][2].$ResSuc["Nombre"][3].$ResSuc["Nombre"][4].$ResSuc["Nombre"][5]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
//RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["RFC"],0,0,'L',1);
//Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(70);
$dome=$ResSuc["Calle"].' No. '.$ResSuc["NoExterior"];if($ResSuc["NoInterior"]!=''){$dome.=' Interior '.$ResSuc["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
//Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(31);
$pdf->SetX(70);
$pdf->Cell(120,4,'Col. '.$ResSuc["Colonia"],0,0,'L',1);
//Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["Municipio"].' '.$ResSuc["Localidad"].' '.$ResSuc["Estado"],0,0,'L',1);
//codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(37);
$pdf->SetX(70);
$pdf->Cell(120,4,'C. P.: '.$ResSuc["CodPostal"].' '.$ResSuc["Pais"],0,0,'L',1);
//Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(40);
$pdf->SetX(70);
$telefonos=$ResSuc["Telefono1"];if($ResSuc["Telefono2"]!=''){$telefonos.=', '.$ResSuc["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
//Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(43);
$pdf->SetX(70);
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);
//DATOS DE LA FACTURA
//folio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(8);
$pdf->SetX(135);
$pdf->Cell(34,4,'Factura: ',1,0,'L',1);
//serie y folio
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(8);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFactura["Serie"].$ResFactura["NumFactura"],1,0,'L',1);
//fecha
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(12);
$pdf->SetX(135);
$pdf->Cell(34,4,'Fecha: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(12);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFactura["Fecha"],1,0,'L',1);
//aprobacion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(135);
$pdf->Cell(34,4,'Aprobación: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["NumAprobacion"],1,0,'L',1);
//certificado
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(135);
$pdf->Cell(34,4,'Certificado: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["NumCertificado"],1,0,'L',1);
//Año de aprobacion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(135);
$pdf->Cell(34,4,'Año Aprobación: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],1,0,'L',1);
//Expedido en
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(135);
$pdf->Cell(34,4,'Expedido en: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],1,0,'L',1);
//Regimen
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(32);
$pdf->SetX(135);
$pdf->Cell(68,4,'Regimen Fiscal: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(36);
$pdf->SetX(135);
$pdf->MultiCell(68,4,$RResEmpresa["Regimen"],1,'L',1);
////Nota
if($ResFactura["Nota"]!='')
{
	$Y=$pdf->GetY();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(135);
$pdf->MultiCell(68,4,$ResFactura["Nota"],1,'L',1);
}

////DATOS DEL RECEPTOR
$pdf->SetY(50);
$pdf->SetX(8);
$pdf->Cell(195,24,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(8);
$pdf->Cell(20,4,'Cliente: ',0,0,'L',1);
//
////Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor_attr"]["nombre"],0,0,'L',1);
////RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor_attr"]["rfc"],0,0,'L',1);
////domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(9);
$domr=$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["calle"];if($xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"];}if($xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR : '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"];}
$pdf->Cell(8,4,$domr.' Col. '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["colonia"],0,0,'L',1);
////ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["localidad"].' '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["estado"],0,0,'L',1);
////codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(68);
$pdf->SetX(9);
$pdf->Cell(8,4,'C. P.: '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["codigoPostal"].' '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["pais"],0,0,'L',1);
//
////observaciones
$pdf->SetY(76);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(76);
$pdf->SetX(8);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(80);
$pdf->SetX(9);
$pdf->MultiCell(190,4,$ResFactura["Observaciones"],0,'L',1);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1);
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["Comprobante_attr"]["NumCtaPago"],1,0,'L',1);
//posicion inicial y por pagina
$y_axis_initial = 104; $y_axis=108;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,'#',1,0,'C',1);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->Cell(20,4,'Clave',1,0,'C',1);
$pdf->Cell(20,4,'Unidad',1,0,'C',1);
$pdf->Cell(90,4,'Descripcion',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);
	}//termina cabecera
	//si la factura es de orden de venta
	if($ResFactura["NumOrden"]==0)//no es de orden
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
	}
	elseif($ResFactura["NumOrden"]!=0)//si es de orden
	{
		$ProdOV=mysql_fetch_array(mysql_query("SELECT Producto FROM detordenventa WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1")); //selecciona el producto de la orden de venta
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$ProdOV["Producto"]."' LIMIT 1"));//Selecciona los datos del producto
	}
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
	
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    $pdf->SetY($y_axis);
    $pdf->SetX(8);
    $pdf->Cell(10,4,$partidas,'LR',0,'C',1);
    $pdf->Cell(15,4,$RResPartidas["Cantidad"],'LR',0,'C',1);
    $pdf->Cell(20,4,$RResPartidas["Clave"],'LR',0,'C',1);
    if($RResPartidas["Unidad"]==''){$pdf->Cell(20,4,$ResUnidad["Nombre"],'LR',0,'C',1);}
    else {$pdf->Cell(20,4,$RResPartidas["Unidad"],'LR',0,'C',1);}
    $ResMarca=mysql_query("SELECT Id FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='tproducto' ORDER BY Id ASC"); 
    $J=1;
    while($RResMarca=mysql_fetch_array($ResMarca))
    {
    	if($RResMarca["Id"]==$ResProd["TipoProducto"]){$numero=$J;}
    	$J++;
    }
    if($RResPartidas["Producto"]!=0)
    {
    $pdf->Cell(90,4,$ResProd["Nombre"].' - '.$ResProd["Clave"].' - '.$numero,'LR',0,'L',1);
    }
    else
    {
    $pdf->Cell(90,4,$RResPartidas["Descripcion"],'LR',0,'L',1);	
    }
    if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($RResPartidas["PrecioUnitario"]/$ResFactura["TipoCambio"]), 2),'LR',0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"], 2),'LR',0,'R',1);}
    if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($RResPartidas["Subtotal"]/$ResFactura["TipoCambio"]), 2),'LR',0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Subtotal"], 2),'LR',0,'R',1);}
    
    $y_axis = $y_axis + 4;
    
    
		
	$partidas++; $i++;
	
	if($i==21)
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY($y_axis);
		$pdf->SetX(8);
		$pdf->Cell(10,1,'','LRB',0,'C',1);
		$pdf->Cell(15,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$pdf->Cell(90,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$y_axis = $y_axis + 4;
		
		//muestra bloqueo
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',6);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(8);
		for($t=1;$t<=7000;$t++)
		{
			$pagare.='|';
		}
		$pdf->MultiCell(195,4,$pagare,1,'J');
		$y_axis=$y_axis+4;
		$pagare='';
		//$partidas=1;
	}
	
	
}

for($i;$i<21;$i++)
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY($y_axis);
		$pdf->SetX(8);
		$pdf->Cell(10,4,'','LR',0,'C',1);
		$pdf->Cell(15,4,'','LR',0,'C',1);
		$pdf->Cell(20,4,'','LR',0,'C',1);
		$pdf->Cell(20,4,'','LR',0,'C',1);
		$pdf->Cell(90,4,'','LR',0,'C',1);
		$pdf->Cell(20,4,'','LR',0,'C',1);
		$pdf->Cell(20,4,'','LR',0,'C',1);
		$y_axis = $y_axis + 4;
	}
	if($i==21)
	{
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY($y_axis);
		$pdf->SetX(8);
		$pdf->Cell(10,1,'','LRB',0,'C',1);
		$pdf->Cell(15,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$pdf->Cell(90,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$pdf->Cell(20,1,'','LRB',0,'C',1);
		$y_axis = $y_axis + 4;
	}
	
	//Imprime piecera sin datos
//	if($i==21 AND $cuentapaginas<$paginas)
//	{
//		//muestra bloqueo
//		$pdf->SetFillColor(255,255,255);
//		$pdf->SetFont('Arial','',6);
//		$pdf->SetTextColor(000,000,000);
//		$pdf->Ln();
//		$pdf->Ln();
//		$pdf->Ln();
//		$pdf->Ln();
//		$pdf->Ln();
//		$pdf->SetX(8);
//		for($t=1;$t<=7000;$t++)
//		{
//			$pagare.='|';
//		}
//		$pdf->MultiCell(195,4,$pagare,1,'J');
//		$y_axis=$y_axis+4;
//	}


//if($partidas==25)
//$y_axis=189;
$y_axis=$y_axis;
//desplegar subtotal
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',1,0,'L',1);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(000,000,000);
$pdf->SetFont('Arial','',7);
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]), 2),1,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Subtotal"], 2),1,0,'R',1);}
$y_axis=$y_axis+4;
if($ResFactura["Descuento"]!=0)
{
//desplegar descuento
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Desc. '.$ResFactura["Descuento"].'%: ',1,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(000,000,000);
$pdf->Cell(20,4,'$ '.number_format($sdescuento, 2),1,0,'R',1);
$y_axis=$y_axis+4;
//desplegar subtotal condescuento
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(000,000,000);
$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Subtotal"]-$sdescuento), 2),0,0,'R',1);
$y_axis=$y_axis+4;
}
//desplegar numero en letra
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(8);
if($ResFactura["Moneda"]=='USD'){$numero=explode('.', ($ResFactura["Total"]/$ResFactura["TipoCambio"]));}else{$numero=explode('.', $ResFactura["Total"]);}
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' dolares '.$numero[1][0].$numero[1][1].'/100 USD'),0,0,'L',1);}else{$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' pesos '.$numero[1].'/100 M. N.'),0,0,'L',1);}
//despliega Iva
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Iva: ',1,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(000,000,000);
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]), 2),1,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Iva"], 2),1,0,'R',1);}
$y_axis=$y_axis+4;
//despliega total
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Total: ',1,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(000,000,000);
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]), 2),1,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Total"], 2),1,0,'R',1);}
$y_axis=$y_axis+4;
//pagare
//muestra cadena original
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(); $pdf->Ln();
$pdf->SetX(8);
$pagare='EFECTOS FISCALES AL PAGO
Este documento es una representación impresa de un CFD. La tenencia de este documento no es comprobante de pago.
La Firma o sello puesto en cualquier lugar de esta factura implica la total aceptación. Cualquier devolución tendra cargo de 20%.
En caso de devolución de su cheque se cobrará el 20% de cargo de acuerdo al art. 193 de la ley general de titulos y operaciones de credito.
Por este pagare me(nos) oblico(amos) a pagar incondicionalmente a la orden de '.$RResEmpresa["Nombre"].' el importe total de esta factura valor de las mercacias especificadas a nuestra entera satisfacción por nuestro factor o dependiente. Si no fuera pagada a su vencimiento causara un interes del 5% mensual durante el tiempo que permanezca total o parcialmente insoluto sin que esto se entienda prorrogado el pago';
$pdf->MultiCell(195,4,$pagare,1,'J');
$y_axis=$y_axis+4;


if(strlen($ResFactura["CadenaOriginal"])>3000)
{
	$pdf->AddPage(); $cuentapaginas++;
//logotipo
$pdf->Image('../images/'.$RResEmpresa["Logotipo"],8,6,100);
$pdf->SetY(13);
$pdf->SetX(100);
$pdf->SetFillColor(076,076,076);
$pdf->Cell(50,0.8,'',0,0,'L',1);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(15);
$pdf->SetX(44);
$pdf->Cell(120,4,strtoupper($RResEmpresa["Nombre"]),0,0,'L',1);
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(8);
if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
////RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["RFC"],0,0,'L',1);
////Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(8);
$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' Interior '.$ResEmisor["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
////Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(31);
$pdf->SetX(8);
$pdf->Cell(120,4,'Col. '.$ResEmisor["Colonia"],0,0,'L',1);
////Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["Municipio"].' '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);
////codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(37);
$pdf->SetX(8);
$pdf->Cell(120,4,'C. P.: '.$ResEmisor["CodPostal"].' '.$ResEmisor["Pais"],0,0,'L',1);
////Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(40);
$pdf->SetX(8);
$telefonos=$ResEmisor["Telefono1"];if($ResEmisor["Telefono2"]!=''){$telefonos.=', '.$ResEmisor["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
////Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(43);
$pdf->SetX(8);
$pdf->Cell(120,4,'Correo Electronico: '.$ResEmisor["CorreoE"],0,0,'L',1);
//DATOS DE LA SUCURSAL
//Sucursal o Matriz
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(70);
if($ResSuc["Nombre"][0].$ResSuc["Nombre"][1].$ResSuc["Nombre"][2].$ResSuc["Nombre"][3].$ResSuc["Nombre"][4].$ResSuc["Nombre"][5]=='MATRIZ'){$pdf->Cell(120,4,'MATRIZ',0,0,'L',1);}else{$pdf->Cell(120,4,'SUCURSAL',0,0,'L',1);}
//RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["RFC"],0,0,'L',1);
//Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(70);
$dome=$ResSuc["Calle"].' No. '.$ResSuc["NoExterior"];if($ResSuc["NoInterior"]!=''){$dome.=' Interior '.$ResSuc["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
//Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(31);
$pdf->SetX(70);
$pdf->Cell(120,4,'Col. '.$ResSuc["Colonia"],0,0,'L',1);
//Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(70);
$pdf->Cell(120,4,$ResSuc["Municipio"].' '.$ResSuc["Localidad"].' '.$ResSuc["Estado"],0,0,'L',1);
//codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(37);
$pdf->SetX(70);
$pdf->Cell(120,4,'C. P.: '.$ResSuc["CodPostal"].' '.$ResSuc["Pais"],0,0,'L',1);
//Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(40);
$pdf->SetX(70);
$telefonos=$ResSuc["Telefono1"];if($ResSuc["Telefono2"]!=''){$telefonos.=', '.$ResSuc["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
//Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(43);
$pdf->SetX(70);
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);
//DATOS DE LA FACTURA
//folio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(8);
$pdf->SetX(135);
$pdf->Cell(34,4,'Factura: ',1,0,'L',1);
//serie y folio
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(8);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFactura["Serie"].$ResFactura["NumFactura"],1,0,'L',1);
//fecha
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(12);
$pdf->SetX(135);
$pdf->Cell(34,4,'Fecha: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(12);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFactura["Fecha"],1,0,'L',1);
//aprobacion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(135);
$pdf->Cell(34,4,'Aprobación: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["NumAprobacion"],1,0,'L',1);
//certificado
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(135);
$pdf->Cell(34,4,'Certificado: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["NumCertificado"],1,0,'L',1);
//Año de aprobacion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(135);
$pdf->Cell(34,4,'Año Aprobación: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(24);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],1,0,'L',1);
//Expedido en
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(135);
$pdf->Cell(34,4,'Expedido en: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(28);
$pdf->SetX(169);
$pdf->Cell(34,4,$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],1,0,'L',1);
//Regimen
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(32);
$pdf->SetX(135);
$pdf->Cell(68,4,'Regimen Fiscal: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(36);
$pdf->SetX(135);
$pdf->MultiCell(68,4,$RResEmpresa["Regimen"],1,'L',1);
////Nota
if($ResFactura["Nota"]!='')
{
	$Y=$pdf->GetY();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(135);
$pdf->MultiCell(68,4,$ResFactura["Nota"],1,'L',1);
}

////DATOS DEL RECEPTOR
$pdf->SetY(50);
$pdf->SetX(8);
$pdf->Cell(195,24,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(8);
$pdf->Cell(20,4,'Cliente: ',0,0,'L',1);
//
////Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor_attr"]["nombre"],0,0,'L',1);
////RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor_attr"]["rfc"],0,0,'L',1);
////domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(9);
$domr=$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["calle"];if($xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"];}if($xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR : '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["noExterior"];}
$pdf->Cell(8,4,$domr.' Col. '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["colonia"],0,0,'L',1);
////ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(9);
$pdf->Cell(8,4,$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["localidad"].' '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["estado"],0,0,'L',1);
////codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(68);
$pdf->SetX(9);
$pdf->Cell(8,4,'C. P.: '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["codigoPostal"].' '.$xml["Comprobante"]["Receptor"]["Domicilio_attr"]["pais"],0,0,'L',1);
//
////observaciones
$pdf->SetY(76);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(76);
$pdf->SetX(8);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(80);
$pdf->SetX(9);
$pdf->MultiCell(190,4,$ResFactura["Observaciones"],0,'L',1);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1);
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(98);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["Comprobante_attr"]["NumCtaPago"],1,0,'L',1);
//posicion inicial y por pagina
$pdf->Ln();
}

//Cadena Original
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(195,4,'Cadena Original',1,0,'C',1);
$y_axis=$y_axis+4;
//muestra cadena original
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',5);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(195,2,$ResFactura["CadenaOriginal"],1,'L');
$y_axis=$y_axis+4;


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
$pdf->MultiCell(195,4,$xml["Comprobante_attr"]["sello"],1,'J');
$y_axis=$y_axis+4;
$y_axis=$pdf->GetY();

//descarga xml
//$pdf->Ln();
//$pdf->SetX(8);
//$pdf->Cell(195,4,'Si desea el XML de esta Factura puede descargarlo en: http://www.gruposecsa.net/factura/xml2_2.php?idfactura='.$idfactura.'&empresa='.$empresa.'&sucursal='.$sucursal,0,0,'L',1);

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
         $t .= ' ' . $matsub[$sub] . 'on'; 
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