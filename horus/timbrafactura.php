<?php
include ("conexion.php");

$idfactura=39720;
$empresa=2;
$sucursal=2;
 
 //Genera Cadena Original
		//datos de la factura
		$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));
		$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$empresa."' AND Sucursal='".$sucursal."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));
		$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");
		
		//Datos del Emisor y del Receptor
		$ResEmpresa=mysql_fetch_array(mysql_query("SELECT * FROM empresas WHERE Id='".$empresa."' LIMIT 1"));
		$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$sucursal."' LIMIT 1"));
		$ResSuc=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id!='".$sucursal."' AND Empresa='".$empresa."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));
		$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$empresa."' AND Id!='".$sucursal."' AND Nombre LIKE 'MATRIZ%' ORDER BY Id DESC LIMIT 1"));
		
	//cadena orginal
	//version
	$cadenaoriginal='||'.$ResFactura["Version"].'|'; 
	//serie
	//if($ResFactura["Serie"]!=''){$cadenaoriginal.=$ResFFacturas["Serie"].'|';}
	//folio
	//e$cadenaoriginal.=$ResFactura["NumFactura"].'|';
	//fecha
	for($i=0; $i<=9; $i++){$cadenaoriginal.=$ResFactura["Fecha"][$i];}
	$cadenaoriginal.='T';
	for($i=11; $i<=18;$i++){$cadenaoriginal.=$ResFactura["Fecha"][$i];}
	//datos emisor
	//numaprobacion
	//$cadenaoriginal.='|'.$ResFFacturas["NumAprobacion"].'|'.$ResFFacturas["NumCertificado"].'|';
	//$cadenaoriginal.='|'.$ResFFacturas["NumAprobacion"].'|';
	//añoaprovacion
	//$cadenaoriginal.=$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3].'|';
	//tipo de comprovante
	$cadenaoriginal.='|ingreso|';
	//forma de pago
	$cadenaoriginal.='PAGO EN UNA SOLA EXHIBICION|';
	//condiciones de pago
	//subtotal
	if($ResFactura["TipoCambio"]!='0.00'){$cadenaoriginal.=number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','').'|';}else{$cadenaoriginal.=$ResFactura["Subtotal"].'|';}
	//descuento
	if($ResFactura["Descuento"]!=0)
	{
		$desc='0.'.$ResFactura["Descuento"];
		$sdescuento=$ResFactura["Subtotal"]*$desc;
		$cadenaoriginal.=number_format($sdescuento, 2).'|';
	}
	//total
	if($ResFactura["TipoCambio"]!='0.00'){$cadenaoriginal.=number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]),2,'.','').'|';}else{$cadenaoriginal.=$ResFactura["Total"].'|';}
	//metodo de pago
	$cadenaoriginal.=$ResFactura["Fpago"].'|';
	//lugar expedicion
	$cadenaoriginal.=$ResEmisor["Estado"].'|';
	//numero de la cuenta
	if($ResFactura["Ncuenta"]!=''){$cadenaoriginal.=$ResFactura["Ncuenta"].'|';}
	//rfc del emisor
	$cadenaoriginal.=$ResEmisor["RFC"].'|';	
	if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ' OR $ResSuc["Nombre"][0].$ResSuc["Nombre"][1].$ResSuc["Nombre"][2].$ResSuc["Nombre"][3].$ResSuc["Nombre"][4].$ResSuc["Nombre"][5].$ResSuc["Nombre"][6].$ResSuc["Nombre"][7]=='MATRIZPB')
	{
		//Nombre del emisor
		$cadenaoriginal.=$ResEmpresa["Nombre"].'|';
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
		//$cadenaoriginal.=$ResEmisor["CodPostal"].'|LUG. EXPEDICION ';if($_SESSION["sucursal"]==1){$cadenaoriginal.='CANCUN QUINTANA ROO';}else{$cadenaoriginal.='MEXICO D. F.';}$cadenaoriginal.=' A '.$ResFactura["Fecha"][8].$ResFactura["Fecha"][9].'/'.$ResFactura["Fecha"][5].$ResFactura["Fecha"][6].'/'.$ResFactura["Fecha"][0].$ResFactura["Fecha"][1].$ResFactura["Fecha"][2].$ResFactura["Fecha"][3].'|';
		$cadenaoriginal.=$ResEmisor["CodPostal"].'|';
		//lugar de emision
		//$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//$cadenaoriginal.=$ResEmisor["Pais"].'|';
		//repite el emisor
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
		//$cadenaoriginal.=$ResEmisor["CodPostal"].'|LUG. EXPEDICION ';if($_SESSION["sucursal"]==1){$cadenaoriginal.='CANCUN QUINTANA ROO';}else{$cadenaoriginal.='MEXICO D. F.';}$cadenaoriginal.=' A '.$ResFactura["Fecha"][8].$ResFactura["Fecha"][9].'/'.$ResFactura["Fecha"][5].$ResFactura["Fecha"][6].'/'.$ResFactura["Fecha"][0].$ResFactura["Fecha"][1].$ResFactura["Fecha"][2].$ResFactura["Fecha"][3].'|';
		$cadenaoriginal.=$ResEmisor["CodPostal"].'|';
		//lugar de emision
		//$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//$cadenaoriginal.=$ResEmisor["Pais"].'|';
		
	}
	else
	{
		//Nombre del emisor
		$cadenaoriginal.=$ResEmpresa["Nombre"].'|';
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
		$cadenaoriginal.=$ResEmisor["CodPostal"].'|';
		
		//Calle del domicilio fiscal de la sucursal (lugar de expedicion)
		$cadenaoriginal.=$ResMatriz["Calle"].'|';
		//numero exterior del emisor
		if($ResMatriz["NoExterior"]!=''){$cadenaoriginal.=$ResMatriz["NoExterior"].'|';}
		//numero interior del emisor
		if($ResMatriz["NoInterior"]!=''){$cadenaoriginal.=$ResMatriz["NoInterior"].'|';}
		//colonia del emisor
		if($ResMatriz["Colonia"]!=''){$cadenaoriginal.=$ResMatriz["Colonia"].'|';}
		//localidad del emisor
		if($ResMatriz["Localidad"]!=''){$cadenaoriginal.=$ResMatriz["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResMatriz["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResMatriz["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResMatriz["Pais"].'|';
		//codigo porstal del emisor
		$cadenaoriginal.=$ResMatriz["CodPostal"].'|';
	}
	
	//regimen fiscal
	$cadenaoriginal.=$ResEmpresa["Regimen"].'|';
	
	//datos receptor
	//rfc del receptor
	$cadenaoriginal.=$ResCliente["RFC"].'|';
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
	
	
	
	while($RResPartidas=mysql_fetch_array($ResPartidas))
	{
		if($ResFactura["NumOrden"]!=0)
		{
			$ProdOV=mysql_fetch_array(mysql_query("SELECT Producto FROM detordenventa WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1")); //selecciona el producto de la orden de venta
			$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$ProdOV["Producto"]."' LIMIT 1"));//Selecciona los datos del producto
		}
		elseif($ResFactura["NumOrden"]==0)
		{
			$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
		}
		
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
		//cantidad
		$cadenaoriginal.=$RResPartidas["Cantidad"].'|';
		//unidad
		if($RResPartidas["Producto"]=='0'){$cadenaoriginal.=$RResPartidas["Unidad"].'|';}
		else{$cadenaoriginal.=$ResUnidad["Nombre"].'|';}
		//numero de identificacion (clave)
		$cadenaoriginal.=$RResPartidas["Clave"].'|';
		//descripcion
		if($RResPartidas["Producto"]!=0){$cadenaoriginal.=$ResProd["Nombre"].' - '.$ResProd["Clave"].'|';}
		else{$cadenaoriginal.=$RResPartidas["Descripcion"].'|';}		
		//valor unitario
		if($ResFactura["TipoCambio"]!='0.00'){$cadenaoriginal.=number_format(($RResPartidas["PrecioUnitario"]/$ResFactura["TipoCambio"]),2,'.','').'|';}else{$cadenaoriginal.=$RResPartidas["PrecioUnitario"].'|';}
		//importe
		if($ResFactura["TipoCambio"]!='0.00'){$cadenaoriginal.=number_format(($RResPartidas["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','').'|';}else{$cadenaoriginal.=$RResPartidas["Subtotal"].'|';}
	}
	//continua cadena original
	//tipo de inpuesto
	$cadenaoriginal.='IVA|'.($_SESSION["iva"]*100).'.00|';
	//importe
	if($ResFactura["TipoCambio"]!='0.00'){$cadenaoriginal.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','').'|'.number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','').'||';}else{$cadenaoriginal.=$ResFactura["Iva"].'|'.$ResFactura["Iva"].'||';}

	//reemplaza espacios en blanco
	$cadenaoriginal=str_replace(' | ','|',$cadenaoriginal);
	$cadenaoriginal=str_replace(' |','|',$cadenaoriginal);
	$cadenaoriginal=str_replace('| ','|',$cadenaoriginal);
	$cadenaoriginal=str_replace('  ',' ',$cadenaoriginal);
	//sellamos cadena
		$cadenaoriginal_sellada = utf8_encode($cadenaoriginal) ;
		//guardamos en archivo
		$fp = fopen ("certificados2/sellos2/".$idfactura.".txt", "w+");
  	     fwrite($fp, $cadenaoriginal_sellada);
		fclose($fp);
		//archivo .key
		$key='certificados/'.$ResFFacturas["ArchivoCadena"];
		//sellamos archivo
		exec("openssl dgst -sha1 -sign ".$key." certificados2/sellos2/".$idfactura.".txt | openssl enc -base64 -A > certificados2/sellos2/sello_".$idfactura.".txt");
		//leer sello
		$f=fopen("certificados2/sellos2/".$idfactura.".txt",'r');
 	  $selloemisor=fread($f,filesize("certificados2/sellos2/sello_".$idfactura.".txt"));
  	fclose($f);
	
	
	//Generamos XML
	$cer=file_get_contents('certificados/'.$ResFFacturas["NumCertificado"].'.cer.pem'); //leemos el certificado
	$cer1=str_replace('-----BEGIN CERTIFICATE-----','',$cer);
	$certificado=str_replace('-----END CERTIFICATE-----','',$cer1);
	
	$xml='<?xml version="1.0" encoding="UTF-8"?>
	<cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="'.$ResFactura["Version"].'"';
	//serie
	if($ResFactura["Serie"]!=''){$xml.=' serie="'.$ResFactura["Serie"].'"';}
	//folio
	$xml.=' folio="'.$ResFactura["NumFactura"].'" fecha="';
	//fecha
	for($i=0; $i<=9; $i++){$xml.=$ResFactura["Fecha"][$i];}
	$xml.='T';
	for($i=11; $i<=18;$i++){$xml.=$ResFactura["Fecha"][$i];}
	//sello
	$xml.='" sello="'.file_get_contents('certificados2/sellos2/sello_'.$idfactura.'.txt').'"';
	//numaprobacion
	//$xml.=' noAprobacion="'.$ResFFacturas["NumAprobacion"].'"';
	//añoaprovacion
	//$xml.=' anoAprobacion="'.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3].'"';
	//tipo de comprovante
	$xml.=' tipoDeComprobante="ingreso"';
	//forma de Pago
	$xml.=' formaDePago="PAGO EN UNA SOLA EXHIBICION"';
	//num certificado
	$xml.=' noCertificado="'.$ResFFacturas["NumCertificado"].'"';
	//certificado
	$xml.=' certificado="'.utf8_encode($certificado).'"';
	//condiciones de pago
	//subtotal
	$xml.=' subTotal="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Subtotal"];}$xml.='"';
	//descuento
	if($ResFactura["Descuento"]!=0)
	{
		$desc='0.'.$ResFactura["Descuento"];
		$sdescuento=$ResFactura["Subtotal"]*$desc;
		$xml.=' descuento="'.number_format($sdescuento, 2).'"';
	}
	//total
	$xml.=' total="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]),2,'.','' );}else{$xml.=$ResFactura["Total"];}$xml.='"';
	//metodo de pago
	$xml.=' metodoDePago="'.$ResFactura["Fpago"].'"';
	//lugar expedicion
	$xml.=' LugarExpedicion="'.$ResEmisor["Estado"].'"';
	//numero de la cuenta
	if($ResFactura["Ncuenta"]!=''){$xml.=' NumCtaPago="'.$ResFactura["Ncuenta"].'"';}$xml.='>';
//datos del emisor

if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ')
{
	//RFC del emisor
	$xml.='<cfdi:Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'">';
	//domicilio del emisor
	$xml.='<cfdi:DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.='<cfdi:ExpedidoEn calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'" />';
	//regimen fiscal
	$xml.='<cfdi:RegimenFiscal Regimen="'.$ResEmpresa["Regimen"].'" /></cfdi:Emisor>';
}
else
{
	
	//RFC del emisor
	$xml.='<cfdi:Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'" >';
	//domicilio del emisor
	$xml.='<cfdi:DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.='<cfdi:ExpedidoEn calle="'.$ResMatriz["Calle"].'"';if($ResMatriz["NoExterior"]!=''){$xml.=' noExterior="'.$ResMatriz["NoExterior"].'"';}if($ResMatriz["NoInterior"]!=''){$xml.=' noInterior="'.$ResMatriz["NoInterior"].'"';}$xml.=' colonia="'.$ResMatriz["Colonia"].'"';if($ResMatriz["Localidad"]!=''){$xml.=' localidad="'.$ResMatriz["Localidad"].'"';}$xml.=' municipio="'.$ResMatriz["Municipio"].'" estado="'.$ResMatriz["Estado"].'" pais="'.$ResMatriz["Pais"].'" codigoPostal="'.$ResMatriz["CodPostal"].'"/>';
	//regimen fiscal
	$xml.='<cfdi:RegimenFiscal Regimen="'.$ResEmpresa["Regimen"].'" /></cfdi:Emisor>';
}
	//datos receptor
	//rfc del receptor
	$xml.='<cfdi:Receptor rfc="'.$ResCliente["RFC"].'"';
	//nombre del receptor
	$xml.=' nombre="'.$ResCliente["Nombre"].'">';
	//domicilio receptor
  $xml.='<cfdi:Domicilio calle="'.$ResCliente["Direccion"].'"';if($ResCliente["NumExterior"]!=''){$xml.=' noExterior="'.$ResCliente["NumExterior"].'"';}if($ResCliente["NumInterior"]!=''){$xml.=' noInterior="'.$ResCliente["NumInterior"].'"';}$xml.=' colonia="'.$ResCliente["Colonia"].'" estado="'.$ResCliente["Estado"].'"';if($ResCliente["Ciudad"]){$xml.=' localidad="'.$ResCliente["Ciudad"].'"';}if($ResCliente["Municipio"]!=''){$xml.=' municipio="'.$ResCliente["Municipio"].'"';}$xml.=' pais="'.$ResCliente["Pais"].'" codigoPostal="'.$ResCliente["CP"].'"/></cfdi:Receptor><cfdi:Conceptos>';

$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
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
  $xml.='<cfdi:Concepto cantidad="'.$RResPartidas["Cantidad"].'" ';
	if($RResPartidas["Producto"]!=0)
	{
  	$xml.='unidad="'.$ResUnidad["Nombre"].'" noIdentificacion="'.$RResPartidas["Clave"].'" descripcion="'.$ResProd["Nombre"].' - '.$ResProd["Clave"].'"';
	}
	else
	{
		$xml.='unidad="'.$RResPartidas["Unidad"].'"  noIdentificacion="'.$RResPartidas["Clave"].'" descripcion="'.$RResPartidas["Descripcion"].'"';
	}
	$xml.=' valorUnitario="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($RResPartidas["PrecioUnitario"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$RResPartidas["PrecioUnitario"];}$xml.='" importe="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($RResPartidas["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$RResPartidas["Subtotal"];}$xml.='"/>';
}
$IVA=explode('.', $_SESSION["iva"]);
$xml.='</cfdi:Conceptos><cfdi:Impuestos totalImpuestosTrasladados="';if($ResFactura["Moneda"]=='USD'){$xml.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Iva"];}$xml.='"><cfdi:Traslados><cfdi:Traslado importe="';if($ResFactura["Moneda"]=='USD'){$xml.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Iva"];}$xml.='" impuesto="IVA" tasa="'.$IVA[1].'.00"/></cfdi:Traslados></cfdi:Impuestos></cfdi:Comprobante>';

//guarda XML y Cadena original

mysql_query("UPDATE facturas SET CadenaOriginal='".$cadenaoriginal_sellada."',
																 XML='".$xml."',
																 SelloEmisor='".file_get_contents('certificados2/sellos2/sello_'.$idfactura.'.txt')."'
													WHERE Id='".$idfactura."'");

//conexion al web service

	//creamos carpeta con archivo xml
	//$dirmake = mkdir("xmls/".$idfactura, 0777); 

	//guardamos precfdi
	$fp = fopen ("xmls/".$idfactura."/".$idfactura.".xml", "w+");
  	     fwrite($fp, $xml);
		fclose($fp);

	//incluimos libreria y servicio
	require_once('nusoap/nusoap.php');
	$servicio="https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl";
	//$servicio="http://www.facturaverde.net/_secsa/timbresecsa.php";

	//parametros
	$parametros=array();
	switch ($_SESSION["empresa"])
	{
		case 1: //teresa varela
			$parametros["user"]="VAVT500519UG1"; //String
			$parametros["password"]="urshrkxci";//String
			break;
		case 2: //secsa 
			$parametros["user"]="SIL071211M50"; //String
			$parametros["password"]="jrgdwpaft";//String
			break;
		case 3: //surtidora
			$parametros["user"]="SEC871208M21"; //String
			$parametros["password"]="wrkrrvpni";//String
			break;
	}
	$parametros["file"]=base64_encode(file_get_contents("xmls/".$idfactura."/".$idfactura.".xml"));
	//$parametros["emp"]=$_SESSION["empresa"];
	//$parametros["idf"]=$idfactura;
	//$parametros["xml"]=$xml;

	//Se crea el cliente del servicio
	$client = new nusoap_client($servicio, true);

	//Se hace el metodo que vamos a probar
	$result = $client->call("getTimbreCfdi", $parametros);
	//$result = $client->call("generaTimbreRequest", array("emp" => $_SESSION["empresa"], "idf" => $idfactura, "xml" => $xml));

	//guardamos el .zip
	/*file_put_contents('xmls/'.$idfactura.'/regresa.zip', base64_decode($result["getTimbreCfdiReturn"]));

	//extraemos el xml con el timbre
	//$zip = new ZipArchive;
	//if ($zip->open('xmls/'.$idfactura.'/regresa.zip') === TRUE) {
    //$zip->extractTo('xmls/'.$idfactura.'/', 'TIMBRE_XML_COMPROBANTE_3_0.xml');
    //$zip->close();

	 require_once('pclzip.lib.php');
	$archive = new PclZip("xmls/".$idfactura."/regresa.zip");
  	if ($archive->extract() == 0) {
    	die("Error : ".$archive->errorInfo(true));
    }

    
    //leemos el contenido del timbre
    $complemento=file_get_contents("TIMBRE_XML_COMPROBANTE_3_0.xml");
    unlink("TIMBRE_XML_COMPROBANTE_3_0.xml");

    //leemos la respuesta del timbre
    require('clientes/xml2array.php');
	$complementoxml=xml2array($complemento);
	//$complemento=$result["generaTimbreResponse"];*/



print_r($result);

?>