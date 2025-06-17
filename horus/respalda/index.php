<?php
	include ("../conexion.php");
	
	require('../clientes/fpdf/fpdf.php');
	require('../clientes/xml2array.php');
	
	include ("../clientes/phpqrcode/qrlib.php"); 
	//set it to writable location, a place for temp generated PNG files
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
	//html PNG location prefix
	$PNG_WEB_DIR = 'temp/';
	
if(isset($_GET["id"]))
{
	$ResFacResp=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura, XML FROM facturas WHERE Id='".$_GET["id"]."' LIMIT 1"));
	
	$xml=str_replace('cfdv2.xsd','cfdv22.xsd',$ResFacResp["XML"]);
	
	$fp = fopen ("xmls/".$ResFacResp["Serie"].$ResFacResp["NumFactura"].".xml", "w+");
  	fwrite($fp, $xml);
	fclose($fp);
	
	$idfactura=$_GET["id"];
	
//datos de la factura
$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));
$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));
$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");
$ResPartidasFactura=mysql_fetch_array(mysql_query("SELECT Descripcion FROM parametros WHERE Empresa='4' AND PerteneceA='ConfigFacturas' AND Nombre='Partidas' LIMIT 1"));
$paginas=ceil(mysql_num_rows($ResPartidas)/$ResPartidasFactura["Descripcion"]); $cuentapaginas=1;
$xml=xml2array($ResFactura["XML"]); //lee el xml y lo convierte en array

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_GET["sucursal"]."' LIMIT 1"));
$ResSuc=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id!='".$_GET["sucursal"]."' AND Empresa='4' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));

//genera codigo QR
$filename = $PNG_TEMP_DIR.$ResFactura["Serie"].'_'.$ResFactura["NumFactura"].'.png';
QRcode::png('?re='.$xml["cfdi:Comprobante"]["cfdi:Emisor_attr"]["rfc"].'&rr='.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["rfc"].'&tt='.$ResFactura["Total"].'0000&id='.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"], $filename, 'H', '4', 2);
//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage();

//posicion inicial y por pagina
$y_axis_initial = 25;

//Imprimir Datos de la Empresa
$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE ID='4' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);
//logotipo
$pdf->Image('../images/'.$RResEmpresa["Logotipo"],8,6,30);//100
$pdf->SetY(13);
$pdf->SetX(50);
$pdf->SetFillColor(076,076,076);
$pdf->Cell(100,0.8,'',0,0,'L',1);
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
$pdf->Cell(120,4,'R.F.C.: '.$ResEmisor["RFC"],0,0,'L',1);
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
/*$pdf->SetFillColor(255,255,255);
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
$pdf->Cell(120,4,'R.F.C.: '.$ResSuc["RFC"],0,0,'L',1);
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
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);*/
//DATOS DE LA FACTURA
//folio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(6);
$pdf->SetX(140);
$pdf->Cell(60,4,'Tipo de Comprobante: Ingreso',1,0,'C',1);
//serie y numero
if($ResFactura["Serie"])
{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(10);
	$pdf->SetX(140);
	$pdf->Cell(60,4,'Serie: '.$ResFactura["Serie"].' No. '.$ResFactura["NumFactura"],1,0,'C',1);
}
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(140);
$pdf->Cell(60,4,'Folio Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(140);
$pdf->Cell(60,4,strtoupper($xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"]),1,0,'C',1);
//certificado 
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del Emisor',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(140);
$pdf->Cell(60,4,$ResFFacturas["NumCertificado"],1,0,'C',1);
//certificado SAT
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del SAT',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["noCertificadoSAT"],1,0,'C',1);
//Fecha y Hora de Certificación
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(140);
$pdf->Cell(60,4,'Fecha y Hora de Certificación',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"],1,0,'C',1);
//Lugar de Elaboración
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(46);
$pdf->SetX(140);
$pdf->Cell(60,4,'Lugar de Elaboración',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(50);
$pdf->SetX(140);
if($_SESSION["sucursal"]==4){$pdf->Cell(60,4,'QUERETARO','LTR',0,'C',1);}
else{$pdf->Cell(60,4,'Ciudad de México, México','LTR',0,'C',1);}
//$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["municipio"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["pais"],'LTR',0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["fecha"],'LRB',0,'C',1);
//Regimen Fiscal
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(140);
$pdf->Cell(60,4,'Régimen Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(140);
$pdf->MultiCell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:RegimenFiscal_attr"]["Regimen"],1,'C',1);

/*/Año de aprobacion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(135);
$pdf->Cell(120,4,'Año Aprobación: '.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],0,0,'L',1);
//Expedido en
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(135);
$pdf->Cell(120,4,'Expedido en: '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);*/
//separador
$pdf->Line(8, 46, 200, 46);
//DATOS DEL RECEPTOR
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(47);
$pdf->SetX(8);
$pdf->Cell(16,4,'Cliente: ',0,0,'L',0);
//Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(51);
$pdf->SetX(8);
$pdf->Cell(8,3,'RFC.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["rfc"],0,0,'L',0);
//RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(8);
$pdf->Cell(8,3,$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["nombre"],0,0,'L',0);
//domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(57);
$pdf->SetX(8);
//$domr=$ResCliente["Direccion"];if($ResCliente["NumExterior"]){$domr.=' NUM. '.$ResCliente["NumExterior"];}if($ResCliente["NumInterior"]){$domr.=' INTERIOR : '.$ResCliente["NumInterior"];}
$domr=$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["calle"];if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"];}if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"];}
$pdf->Cell(8,3,utf8_decode($domr.' Col. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["colonia"]),0,0,'L',1);
//ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(8);
$pdf->Cell(8,3,utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["estado"]),0,0,'L',1);
//codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(63);
$pdf->SetX(8);
$pdf->Cell(8,3,'C. P.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["codigoPostal"].' '.utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["pais"]),0,0,'L',1);
/*/Numero de Provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(55,4,'Provedor Num.: '.$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(60);
$pdf->Cell(60,4,'Pedido Num.: '.$ResFactura["NumPedido"],1,0,'L',1);*/

//Unidad del Cliente
/*if($ResFactura["UnidadCliente"]!=0)
{
	$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(64);
	$pdf->SetX(135);
	$pdf->Cell(10,4,'Unidad: '.$ResUnidadCli["Nombre"],0,0,'L',1);
}*/
//separador
$pdf->Line(8, 68, 140, 68);


//
////observaciones
$pdf->SetY(70);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(71);
$pdf->SetX(9);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',0);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(9);
$pdf->MultiCell(190,3,$ResFactura["Observaciones"],0,'L',0);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1); $cuentapaginas++;
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["cfdi:Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["cfdi:Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["cfdi:Comprobante_attr"]["NumCtaPago"],1,0,'L',1);


//Partida de la Factura

//Agente
//$pdf->SetFillColor(255,255,255);
//$pdf->SetFont('Arial','',10);
//$pdf->SetTextColor(000,000,000);
//$pdf->SetY(82);
//$pdf->SetX(8);
//$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
//$pdf->Cell(195,4,'Agente: '.$ResAgente["Nombre"],0,0,'L',1);
/*/Num Hojas
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(82);
$pdf->SetX(135);
$pdf->Cell(195,4,'Pagina: '.$cuentapaginas.' de '.$paginas,0,0,'L',1);*/

//posicion inicial y por pagina
$y_axis_initial = 100; $y_axis=104;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,'#',1,0,'C',1);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->Cell(15,4,'Unidad',1,0,'C',1);
$pdf->Cell(15,4,'Clave',1,0,'C',1);
$pdf->Cell(100,4,'Concepto',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);

$i=1;
$partidas=1; $partidas2=1;
$pdf->SetY($y_axis);
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	if($partidas>=$ResPartidasFactura["Descripcion"])
	{
		$pdf->AddPage();
	
		//logotipo
$pdf->Image('../images/'.$RResEmpresa["Logotipo"],8,6,30);//100
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
$pdf->Cell(120,4,'R.F.C.: '.$ResEmisor["RFC"],0,0,'L',1);
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
/*$pdf->SetFillColor(255,255,255);
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
$pdf->Cell(120,4,'R.F.C.: '.$ResSuc["RFC"],0,0,'L',1);
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
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);*/
//DATOS DE LA FACTURA
//folio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(6);
$pdf->SetX(140);
$pdf->Cell(60,4,'Tipo de Comprobante: Ingreso',1,0,'C',1);
//serie y numero
if($ResFactura["Serie"])
{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(10);
	$pdf->SetX(140);
	$pdf->Cell(60,4,'Serie: '.$ResFactura["Serie"].' No. '.$ResFactura["NumFactura"],1,0,'C',1);
}
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(140);
$pdf->Cell(60,4,'Folio Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(140);
$pdf->Cell(60,4,strtoupper($xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"]),1,0,'C',1);
//certificado 
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del Emisor',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(140);
$pdf->Cell(60,4,$ResFFacturas["NumCertificado"],1,0,'C',1);
//certificado SAT
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del SAT',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["noCertificadoSAT"],1,0,'C',1);
//Fecha y Hora de Certificación
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(140);
$pdf->Cell(60,4,'Fecha y Hora de Certificación',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"],1,0,'C',1);
//Lugar de Elaboración
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(46);
$pdf->SetX(140);
$pdf->Cell(60,4,'Lugar de Elaboración',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->Cell(60,4,'Ciudad de México, México','LTR',0,'C',1);
//$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["municipio"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["pais"],'LTR',0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["fecha"][0].$xml["cfdi:Comprobante_attr"]["fecha"][1].$xml["cfdi:Comprobante_attr"]["fecha"][2].$xml["cfdi:Comprobante_attr"]["fecha"][3].$xml["cfdi:Comprobante_attr"]["fecha"][4].$xml["cfdi:Comprobante_attr"]["fecha"][5].$xml["cfdi:Comprobante_attr"]["fecha"][6].$xml["cfdi:Comprobante_attr"]["fecha"][7].$xml["cfdi:Comprobante_attr"]["fecha"][8].$xml["cfdi:Comprobante_attr"]["fecha"][9],'LRB',0,'C',1);
//Regimen Fiscal
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(140);
$pdf->Cell(60,4,'Régimen Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(140);
$pdf->MultiCell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:RegimenFiscal_attr"]["Regimen"],1,'C',1);

/*/Año de aprobacion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(135);
$pdf->Cell(120,4,'Año Aprobación: '.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],0,0,'L',1);
//Expedido en
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(135);
$pdf->Cell(120,4,'Expedido en: '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);*/
//separador
$pdf->Line(8, 46, 200, 46);
//DATOS DEL RECEPTOR
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(47);
$pdf->SetX(8);
$pdf->Cell(16,4,'Cliente: ',0,0,'L',0);
//Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(51);
$pdf->SetX(8);
$pdf->Cell(8,3,'RFC.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["rfc"],0,0,'L',0);
//RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(8);
$pdf->Cell(8,3,$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["nombre"],0,0,'L',0);
//domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(57);
$pdf->SetX(8);
//$domr=$ResCliente["Direccion"];if($ResCliente["NumExterior"]){$domr.=' NUM. '.$ResCliente["NumExterior"];}if($ResCliente["NumInterior"]){$domr.=' INTERIOR : '.$ResCliente["NumInterior"];}
$domr=$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["calle"];if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"];}if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"];}
$pdf->Cell(8,3,utf8_decode($domr.' Col. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["colonia"]),0,0,'L',1);
//ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(8);
$pdf->Cell(8,3,utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["estado"]),0,0,'L',1);
//codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(63);
$pdf->SetX(8);
$pdf->Cell(8,3,'C. P.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["codigoPostal"].' '.utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["pais"]),0,0,'L',1);
/*/Numero de Provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(55,4,'Provedor Num.: '.$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(60);
$pdf->Cell(60,4,'Pedido Num.: '.$ResFactura["NumPedido"],1,0,'L',1);*/

//Unidad del Cliente
if($ResFactura["UnidadCliente"]!=0)
{
	$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(64);
	$pdf->SetX(135);
	$pdf->Cell(10,4,'Unidad: '.$ResUnidadCli["Nombre"],0,0,'L',1);
}
//separador
$pdf->Line(8, 68, 140, 68);


//
////observaciones
$pdf->SetY(70);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(71);
$pdf->SetX(9);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',0);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(9);
$pdf->MultiCell(190,4,$ResFactura["Observaciones"],0,'L',0);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1); $cuentapaginas++;
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["cfdi:Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["cfdi:Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["cfdi:Comprobante_attr"]["NumCtaPago"],1,0,'L',1);


//Partida de la Factura

//Agente
//$pdf->SetFillColor(255,255,255);
//$pdf->SetFont('Arial','',10);
//$pdf->SetTextColor(000,000,000);
//$pdf->SetY(82);
//$pdf->SetX(8);
//$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
//$pdf->Cell(195,4,'Agente: '.$ResAgente["Nombre"],0,0,'L',1);
/*/Num Hojas
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(82);
$pdf->SetX(135);
$pdf->Cell(195,4,'Pagina: '.$cuentapaginas.' de '.$paginas,0,0,'L',1);*/

//posicion inicial y por pagina
$y_axis_initial = 100; $y_axis=104;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,'#',1,0,'C',1);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->Cell(15,4,'Unidad',1,0,'C',1);
$pdf->Cell(15,4,'Clave',1,0,'C',1);
$pdf->Cell(100,4,'Concepto',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);

$i=1;
$partidas=1;
$pdf->SetY($y_axis);

	}

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
	
	
	if($RResPartidas["Unidad"]!=''){$unidad=$RResPartidas["Unidad"];}
	else{$unidad=$ResUnidad["Nombre"];}
	
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    if($RResPartidas["Clave"]==''){$clave=$ResProd["Clave"];}
	else{$clave=$RResPartidas["Clave"];}
    $pdf->SetX(8);
    $pdf->Cell(10,4,$partidas2,0,0,'C',1);
    $pdf->Cell(15,4,$RResPartidas["Cantidad"],0,0,'C',1);
    $pdf->Cell(15,4,$unidad,0,0,'C',1);
    $pdf->Cell(15,4,$clave,0,0,'C',1);
    $pdf->SetX(163);
    if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($RResPartidas["PrecioUnitario"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"], 2),0,0,'R',1);}
    if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($RResPartidas["Subtotal"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Subtotal"], 2),0,0,'R',1);}
    $pdf->SetX(63);
    //$pdf->Cell(10,4,$ResUnidad["Nombre"],0,0,'C',1);
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
    $pdf->MultiCell(100,4,$RResPartidas["Descripcion"],0,'C',0);	
    }
	if($RResPartidas["DescripcionProducto"]!='')
	{
	$pdf->SetX(63);
	$pdf->SetFont('Arial','',7);
	$pdf->MultiCell(100,3,$RResPartidas["DescripcionProducto"],0,'L',0);
	}
    $pdf->Ln(4);
    //$y_axis = $y_axis + 4;
    $y_axis=$pdf->GetY();
	
	
    /*if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }*/
		
	$partidas++; $i++; $partidas2++;
	
	/*/Imprime piecera sin datos
	if($i==21 AND $cuentapaginas<$paginas)
	{
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
	}*/
}
//if($partidas==25)
//$y_axis=176;
$y_axis++;


if($y_axis>=250)
    {
    	$pdf->AddPage();
    	$y_axis=10;
		
//logotipo
$pdf->Image('../images/'.$RResEmpresa["Logotipo"],8,6,30);//100
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
$pdf->Cell(120,4,'R.F.C.: '.$ResEmisor["RFC"],0,0,'L',1);
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
/*$pdf->SetFillColor(255,255,255);
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
$pdf->Cell(120,4,'R.F.C.: '.$ResSuc["RFC"],0,0,'L',1);
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
$pdf->Cell(120,4,'Correo Electronico: '.$ResSuc["CorreoE"],0,0,'L',1);*/
//DATOS DE LA FACTURA
//folio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(6);
$pdf->SetX(140);
$pdf->Cell(60,4,'Tipo de Comprobante: Ingreso',1,0,'C',1);
//serie y numero
if($ResFactura["Serie"])
{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(10);
	$pdf->SetX(140);
	$pdf->Cell(60,4,'Serie: '.$ResFactura["Serie"].' No. '.$ResFactura["NumFactura"],1,0,'C',1);
}
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(140);
$pdf->Cell(60,4,'Folio Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(140);
$pdf->Cell(60,4,strtoupper($xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"]),1,0,'C',1);
//certificado 
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del Emisor',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(140);
$pdf->Cell(60,4,$ResFFacturas["NumCertificado"],1,0,'C',1);
//certificado SAT
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del SAT',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["noCertificadoSAT"],1,0,'C',1);
//Fecha y Hora de Certificación
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(140);
$pdf->Cell(60,4,'Fecha y Hora de Certificación',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"],1,0,'C',1);
//Lugar de Elaboración
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(46);
$pdf->SetX(140);
$pdf->Cell(60,4,'Lugar de Elaboración',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->Cell(60,4,'Ciudad de México, México','LTR',0,'C',1);
//$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["municipio"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["pais"],'LTR',0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["fecha"][0].$xml["cfdi:Comprobante_attr"]["fecha"][1].$xml["cfdi:Comprobante_attr"]["fecha"][2].$xml["cfdi:Comprobante_attr"]["fecha"][3].$xml["cfdi:Comprobante_attr"]["fecha"][4].$xml["cfdi:Comprobante_attr"]["fecha"][5].$xml["cfdi:Comprobante_attr"]["fecha"][6].$xml["cfdi:Comprobante_attr"]["fecha"][7].$xml["cfdi:Comprobante_attr"]["fecha"][8].$xml["cfdi:Comprobante_attr"]["fecha"][9],'LRB',0,'C',1);
//Regimen Fiscal
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(140);
$pdf->Cell(60,4,'Régimen Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(140);
$pdf->MultiCell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:RegimenFiscal_attr"]["Regimen"],1,'C',1);

/*/Año de aprobacion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(135);
$pdf->Cell(120,4,'Año Aprobación: '.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],0,0,'L',1);
//Expedido en
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(135);
$pdf->Cell(120,4,'Expedido en: '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);*/
//separador
$pdf->Line(8, 46, 200, 46);
//DATOS DEL RECEPTOR
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(47);
$pdf->SetX(8);
$pdf->Cell(16,4,'Cliente: ',0,0,'L',0);
//Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(51);
$pdf->SetX(8);
$pdf->Cell(8,3,'RFC.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["rfc"],0,0,'L',0);
//RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(8);
$pdf->Cell(8,3,$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["nombre"],0,0,'L',0);
//domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(57);
$pdf->SetX(8);
//$domr=$ResCliente["Direccion"];if($ResCliente["NumExterior"]){$domr.=' NUM. '.$ResCliente["NumExterior"];}if($ResCliente["NumInterior"]){$domr.=' INTERIOR : '.$ResCliente["NumInterior"];}
$domr=$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["calle"];if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"];}if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"];}
$pdf->Cell(8,3,utf8_decode($domr.' Col. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["colonia"]),0,0,'L',1);
//ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(8);
$pdf->Cell(8,3,utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["estado"]),0,0,'L',1);
//codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(63);
$pdf->SetX(8);
$pdf->Cell(8,3,'C. P.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["codigoPostal"].' '.utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["pais"]),0,0,'L',1);
/*/Numero de Provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(55,4,'Provedor Num.: '.$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(60);
$pdf->Cell(60,4,'Pedido Num.: '.$ResFactura["NumPedido"],1,0,'L',1);*/

//Unidad del Cliente
/*if($ResFactura["UnidadCliente"]!=0)
{
	$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(64);
	$pdf->SetX(135);
	$pdf->Cell(10,4,'Unidad: '.$ResUnidadCli["Nombre"],0,0,'L',1);
}*/
//separador
$pdf->Line(8, 68, 140, 68);


//
////observaciones
$pdf->SetY(70);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(71);
$pdf->SetX(9);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',0);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(75);
$pdf->SetX(9);
$pdf->MultiCell(190,3,$ResFactura["Observaciones"],0,'L',0);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1); $cuentapaginas++;
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["cfdi:Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["cfdi:Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["cfdi:Comprobante_attr"]["NumCtaPago"],1,0,'L',1);		
$pdf->Ln();
    }
//desplegar subtotal, descuento, Iva y total
//desplegar subtotal
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',0,0,'R',1);
$pdf->SetFont('Arial','',7);
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Subtotal"], 2),0,0,'R',1);}
$y_axis=$y_axis+4;
if($ResFactura["Descuento"]!=0)
{
	if($ResFactura["Descuento"]<=9){$avgdesc='0.0'.$ResFactura["Descuento"];}
	else{$avgdesc='0.'.$ResFactura["Descuento"];}
	$sdescuento=$ResFactura["Subtotal"]*$avgdesc;
//desplegar descuento
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(163);
$pdf->Cell(20,4,'Desc. '.$ResFactura["Descuento"].'%: ',0,0,'R',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($sdescuento, 2),0,0,'R',1);
$y_axis=$y_axis+4;
//desplegar subtotal condescuento
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',0,0,'R',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Subtotal"]-$sdescuento), 2),0,0,'R',1);
$y_axis=$y_axis+4;
}
//desplegar numero en letra
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
if($ResFactura["Moneda"]=='USD'){$numero=explode('.', ($ResFactura["Total"]/$ResFactura["TipoCambio"]));}else{$numero=explode('.', $ResFactura["Total"]);}
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' dolares '.$numero[1][0].$numero[1][1].'/100 USD'),0,0,'L',1);}else{$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' pesos '.$numero[1].'/100 M. N.'),0,0,'L',1);}
//despliega Iva
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
//$pdf->Ln();
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetX(123);
$pdf->Cell(60,4,'Tasa Iva 16%: ',0,0,'R',1);
$pdf->SetFont('Arial','',7);
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Iva"], 2),0,0,'R',1);}
$y_axis=$y_axis+4;
//despliega total
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(163);
$pdf->Cell(20,4,'Total: ',0,0,'R',0);
$pdf->SetFont('Arial','',7);
if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Total"], 2),0,0,'R',1);}
$y_axis=$y_axis+8;


//pagare
//muestra cadena original
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pagare='Este documento es una representación impresa de un CFDI. 
La tenencia de este documento no es comprobante de pago.
Contribuyente Del Regimen de Transparencia.
La Firma o sello puesto en cualquier lugar de esta factura implica la total aceptación. Cualquier devolución tendra cargo de 20%.
En caso de devolución de su cheque se cobrará el 20% de cargo de acuerdo al art. 193 de la ley general de titulos y operaciones de credito.
Por este pagare me(nos) obligo(amos) a pagar incondicionalmente a la orden de '.utf8_decode($RResEmpresa["Nombre"]).' el importe total de esta factura valor de las mercancias especificadas a nuestra entera satisfacción por nuestro factor o dependiente. Si no fuera pagada a su vencimiento causara un interes del 5% mensual durante el tiempo que permanezca total o parcialmente insoluto sin que esto se entienda prorrogado el pago';
$pdf->MultiCell(195,4,$pagare,1,'J');
$y_axis=$y_axis+4;
//Codigo QR
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }

//titulos de la columna
if($y_axis>=230)
    {
    	$pdf->AddPage();
    	$y_axis=10;
		
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
$pdf->Cell(120,4,'R.F.C.: '.$ResEmisor["RFC"],0,0,'L',1);
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
$pdf->Cell(120,4,'R.F.C.: '.$ResSuc["RFC"],0,0,'L',1);
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
$pdf->SetY(6);
$pdf->SetX(140);
$pdf->Cell(60,4,'Tipo de Comprobante: Ingreso',1,0,'C',1);
//serie y numero
if($ResFactura["Serie"])
{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(10);
	$pdf->SetX(140);
	$pdf->Cell(60,4,'Serie: '.$ResFactura["Serie"].' No. '.$ResFactura["NumFactura"],1,0,'C',1);
}
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(140);
$pdf->Cell(60,4,'Folio Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(140);
$pdf->Cell(60,4,strtoupper($xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"]),1,0,'C',1);
//certificado 
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del Emisor',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(140);
$pdf->Cell(60,4,$ResFFacturas["NumCertificado"],1,0,'C',1);
//certificado SAT
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(140);
$pdf->Cell(60,4,'Certificado del SAT',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["noCertificadoSAT"],1,0,'C',1);
//Fecha y Hora de Certificación
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(140);
$pdf->Cell(60,4,'Fecha y Hora de Certificación',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"],1,0,'C',1);
//Lugar de Elaboración
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(46);
$pdf->SetX(140);
$pdf->Cell(60,4,'Lugar de Elaboración',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->Cell(60,4,'Ciudad de México, México','LTR',0,'C',1);
//$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["municipio"].' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:ExpedidoEn_attr"]["pais"],'LTR',0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(140);
$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["fecha"][0].$xml["cfdi:Comprobante_attr"]["fecha"][1].$xml["cfdi:Comprobante_attr"]["fecha"][2].$xml["cfdi:Comprobante_attr"]["fecha"][3].$xml["cfdi:Comprobante_attr"]["fecha"][4].$xml["cfdi:Comprobante_attr"]["fecha"][5].$xml["cfdi:Comprobante_attr"]["fecha"][6].$xml["cfdi:Comprobante_attr"]["fecha"][7].$xml["cfdi:Comprobante_attr"]["fecha"][8].$xml["cfdi:Comprobante_attr"]["fecha"][9],'LRB',0,'C',1);
//Regimen Fiscal
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(140);
$pdf->Cell(60,4,'Régimen Fiscal',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(140);
$pdf->MultiCell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:RegimenFiscal_attr"]["Regimen"],1,'C',1);

/*/Año de aprobacion
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(135);
$pdf->Cell(120,4,'Año Aprobación: '.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3],0,0,'L',1);
//Expedido en
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(135);
$pdf->Cell(120,4,'Expedido en: '.$ResEmisor["Localidad"].' '.$ResEmisor["Estado"],0,0,'L',1);*/
//separador
$pdf->Line(8, 46, 200, 46);
//DATOS DEL RECEPTOR
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(47);
$pdf->SetX(8);
$pdf->Cell(16,4,'Cliente: ',0,0,'L',0);
//Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(51);
$pdf->SetX(8);
$pdf->Cell(8,3,'RFC.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["rfc"],0,0,'L',0);
//RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(54);
$pdf->SetX(8);
$pdf->Cell(8,3,$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["nombre"],0,0,'L',0);
//domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(57);
$pdf->SetX(8);
//$domr=$ResCliente["Direccion"];if($ResCliente["NumExterior"]){$domr.=' NUM. '.$ResCliente["NumExterior"];}if($ResCliente["NumInterior"]){$domr.=' INTERIOR : '.$ResCliente["NumInterior"];}
$domr=$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["calle"];if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"]){$domr.=' NUM. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noExterior"];}if($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"]){$domr.=' INTERIOR '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["noInterior"];}
$pdf->Cell(8,3,utf8_decode($domr.' Col. '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["colonia"]),0,0,'L',1);
//ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(8);
$pdf->Cell(8,3,utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["localidad"].' '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["estado"]),0,0,'L',1);
//codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(63);
$pdf->SetX(8);
$pdf->Cell(8,3,'C. P.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["codigoPostal"].' '.utf8_decode($xml["cfdi:Comprobante"]["cfdi:Receptor"]["cfdi:Domicilio_attr"]["pais"]),0,0,'L',1);
/*/Numero de Provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(55,4,'Provedor Num.: '.$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(60);
$pdf->Cell(60,4,'Pedido Num.: '.$ResFactura["NumPedido"],1,0,'L',1);*/

//Unidad del Cliente
/*if($ResFactura["UnidadCliente"]!=0)
{
	$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY(64);
	$pdf->SetX(135);
	$pdf->Cell(10,4,'Unidad: '.$ResUnidadCli["Nombre"],0,0,'L',1);
}*/
//separador
$pdf->Line(8, 68, 140, 68);


//
////observaciones
$pdf->SetY(70);
$pdf->SetX(8);
$pdf->Cell(195,12,'',1,0,'L',1);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(71);
$pdf->SetX(9);
$pdf->Cell(30,4,'Observaciones: ',0,0,'L',0);
////
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(75);
$pdf->SetX(9);
$pdf->MultiCell(190,3,$ResFactura["Observaciones"],0,'L',0);
//Numero de Provedor
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(8);
$pdf->Cell(30,4,'Provedor Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(38);
$pdf->Cell(20,4,$ResCliente["NumProvedor"],1,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(58);
$pdf->Cell(25,4,'Pedido Num.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(83);
$pdf->Cell(30,4,$ResFactura["NumPedido"],1,0,'L',1);
//Unidad del Cliente
$ResUnidadCli=mysql_fetch_array(mysql_query("SELECT Nombre FROm unidades_cliente WHERE Id='".$ResFactura["UnidadCliente"]."' LIMIT 1"));
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(113);
$pdf->Cell(30,4,'Unidad: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(84);
$pdf->SetX(143);
$pdf->Cell(60,4,$ResUnidadCli["Nombre"],1,0,'L',1);
//Agente
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResFactura["Agente"]."' LIMIT 1"));
$pdf->Cell(30,4,'Agente: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(38);
$pdf->Cell(70,4,$ResAgente["Nombre"],1,0,'L',1);
//Num Hojas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(83);
$pdf->Cell(20,4,'Pagina: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(103);
$pdf->Cell(15,4,$cuentapaginas.' de '.$paginas,1,0,'L',1); $cuentapaginas++;
//Forma de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(118);
$pdf->Cell(30,4,'Forma de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(88);
$pdf->SetX(148);
$pdf->Cell(55,4,$xml["cfdi:Comprobante_attr"]["formaDePago"],1,0,'L',1);
//Metodo de Pago
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(8);
$pdf->Cell(30,4,'Metodo de Pago: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(38);
$pdf->Cell(50,4,$xml["cfdi:Comprobante_attr"]["metodoDePago"],1,0,'L',1);
//Cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(88);
$pdf->Cell(20,4,'Cta. Pago:',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(92);
$pdf->SetX(108);
$pdf->Cell(95,4,$xml["cfdi:Comprobante_attr"]["NumCtaPago"],1,0,'L',1);		
$pdf->Ln();
    
    }
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(150,4,'Cadena Original del Complemento',1,0,'C',1);
$y_axis=$y_axis+8;
//Codigo QR
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(160);
$pdf->Cell(40,4,'Codigo QR',1,0,'C',1);
$y=$pdf->GetY();
$pdf->Image($PNG_WEB_DIR.basename($filename),160,($y+6),40);
$y_axis=$y_axis+4;
//muestra cadena original
if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }
$cadenao='||1.0|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"].'|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"].'|'.$ResFactura["SelloEmisor"].'|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["noCertificadoSAT"].'||';
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',5);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(150,2,$cadenao,0,'L');
$y_axis=$y_axis+4;
//sello digital
/*if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }*/
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(150,4,'Sello Digital',1,0,'C',1);
$y_axis=$y_axis+4;
//despliega el sello emisor
/*if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }*/
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(150,4,$ResFactura["SelloEmisor"],0,'J');
$y_axis=$y_axis+4;
//sello sat
/*if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }*/
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(150,4,'Sello Digital SAT',1,0,'C',1);
$y_axis=$y_axis+4;
//despliega el sello sat
/*if($y_axis>=240)
    {
    	$pdf->AddPage();
    	$y_axis=10;
    }*/
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(150,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["selloSAT"],0,'J');
$y_axis=$y_axis+4;

if($ResFactura["AcuseCancela"]!='')
{
	$pdf->SetFillColor(000,000,000);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTextColor(255,255,255);
	$pdf->Ln();
	$pdf->SetX(8);
	$pdf->Cell(150,4,'Acuse Cancelación SAT',1,0,'C',1);
	$y_axis=$y_axis+4;
	//
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(000,000,000);
	$pdf->Ln();
	$pdf->SetX(8);
	$pdf->MultiCell(150,4,$ResFactura["AcuseCancela"],0,'J');
	$y_axis=$y_axis+4;
}


//Envio Archivo
$pdf->Output("xmls/".$ResFacResp["Serie"].$ResFacResp["NumFactura"].".pdf");
	
	mysql_query("UPDATE facturas SET XML='', CadenaOriginal='', SelloEmisor='', AcuseCancela='' WHERE Id='".$_GET["id"]."'") or die(mysql_error());
}
	
	echo '<p><form name="fbusfac" id="fbusfac" action="index.php" method="GET">
			<select name="mes" id="mes">
				<option value="01"';if($_GET["mes"]=='01'){echo ' selected';}echo '>Enero</option>
				<option value="02"';if($_GET["mes"]=='02'){echo ' selected';}echo '>Febrero</option>
				<option value="03"';if($_GET["mes"]=='03'){echo ' selected';}echo '>Marzo</option>
				<option value="04"';if($_GET["mes"]=='04'){echo ' selected';}echo '>Abril</option>
				<option value="05"';if($_GET["mes"]=='05'){echo ' selected';}echo '>Mayo</option>
				<option value="06"';if($_GET["mes"]=='06'){echo ' selected';}echo '>Junio</option>
				<option value="07"';if($_GET["mes"]=='07'){echo ' selected';}echo '>Julio</option>
				<option value="08"';if($_GET["mes"]=='08'){echo ' selected';}echo '>Agosto</option>
				<option value="09"';if($_GET["mes"]=='09'){echo ' selected';}echo '>Septiembre</option>
				<option value="10"';if($_GET["mes"]=='10'){echo ' selected';}echo '>Octubre</option>
				<option value="11"';if($_GET["mes"]=='11'){echo ' selected';}echo '>Noviembre</option>
				<option value="12"';if($_GET["mes"]=='12'){echo ' selected';}echo '>Diciembre</option>
			</select> <select name="anno" id="anno">';
	for($i=2014; $i<=date("Y"); $i++)
	{
		echo '<option value="'.$i.'"';if($_GET["anno"]==$i){echo ' selected';}echo '>'.$i.'</option>';
	}
	echo '	</select> <select name="sucursal" id="sucursal">';
	$ResSuc=mysql_query("SELECT Id, Nombre FROM sucursales ORDER BY Nombre ASC");
	while($RResSuc=mysql_fetch_array($ResSuc))
	{
		echo '	<option value="'.$RResSuc["Id"].'"';if($_GET["sucursal"]==$RResSuc["Id"]){echo ' selected';}echo '>'.$RResSuc["Nombre"].'</option>';
	}
	echo '</select>	<input type="submit" name="botbus" id="botbus" value="Buscar >>"></p>';
	
if(isset($_GET["mes"]))
{
	echo '<table border="1" cellpadding="3" cellspacing="0">
			<tr>
				<td align="center">Serie</td>
				<td align="center">Num. Factura</td>
				<td align="center">Cliente</td>
				<td align="center">Total</td>
				<td align="center">&nbsp;</td>
			</tr>';
	$ResFacturas=mysql_query("SELECT Id, Serie, NumFactura, Sucursal, Cliente, Total FROM facturas WHERE Fecha LIKE '".$_GET["anno"]."-".$_GET["mes"]."-%' AND Sucursal='".$_GET["sucursal"]."' AND XML !='' ORDER BY NumFactura ASC");
	while($RResFacturas=mysql_fetch_array($ResFacturas))
	{
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
		echo '<tr>
				<td align="center">'.$RResFacturas["Serie"].'</td>
				<td align="center">'.$RResFacturas["NumFactura"].'</td>
				<td align="left">'.$ResCliente["Nombre"].'</td>
				<td align="right">$ '.number_format($RResFacturas["Total"], 2).'</td>
				<td align="center"><a href="index.php?mes='.$_GET["mes"].'&anno='.$_GET["anno"].'&sucursal='.$_GET["sucursal"].'&id='.$RResFacturas["Id"].'">respaldar</a></td>
			</tr>';
	}
}

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