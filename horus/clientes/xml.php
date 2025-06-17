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
include ("../conexion.php");

if($_POST["idfactura"]){$idfactura=$_POST["idfactura"];}
elseif($_GET["idfactura"]){$idfactura=$_GET["idfactura"];}
//generales de la factura
$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));
$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
$ResEmpresa=mysql_fetch_array(mysql_query("SELECT * FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));
	
$xml='<?xml version="1.0" encoding="UTF-8"?>
<Comprobante xmlns="http://www.sat.gob.mx/cfd/2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/2 http://www.sat.gob.mx/sitio_internet/cfd/2/cfdv2.xsd http://www.sat.gob.mx/ecc http://www.sat.gob.mx/sitio_internet/cfd/ecc/ecc.xsd" version="2.0"';
if($ResFactura["Serie"]!=''){$xml.=' serie="'.$ResFactura["Serie"].'"';}
$xml.=' folio="'.$ResFactura["NumFactura"].'" fecha="';
for($i=0; $i<=9; $i++){$xml.=$ResFactura["Fecha"][$i];}
$xml.='T';
for($i=11; $i<=18;$i++){$xml.=$ResFactura["Fecha"][$i];}
$cer=file_get_contents('../certificados/'.$ResFFacturas["NumCertificado"].'.cer.pem'); //leemos el certificado
$cer1=str_replace('-----BEGIN CERTIFICATE-----','',$cer);
$certificado=str_replace('-----END CERTIFICATE-----','',$cer1);
$xml.='" sello="'.file_get_contents('../certificados2/sellos2/sello_'.$idfactura.'.txt').'"  noCertificado="'.$ResFFacturas["NumCertificado"].'" certificado="'.utf8_encode($certificado).'" subTotal="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Subtotal"];}$xml.='" total="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]),2,'.','' );}else{$xml.=$ResFactura["Total"];}$xml.='" noAprobacion="'.$ResFFacturas["NumAprobacion"].'" anoAprobacion="'.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3].'" formaDePago="PAGO EN UNA SOLA EXHIBICION" tipoDeComprobante="ingreso">';

if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ')
{
$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'" nombre="'.$ResEmpresa["Nombre"].'" >
        <DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>
        <ExpedidoEn calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'" />
    </Emisor>';
}
else
{
	$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' AND Nombre LIKE 'MATRIZ%' ORDER BY Id DESC LIMIT 1"));
	$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'" nombre="'.$ResEmpresa["Nombre"].'" >
        <DomicilioFiscal calle="'.$ResMatriz["Calle"].'"';if($ResMatriz["NoExterior"]!=''){$xml.=' noExterior="'.$ResMatriz["NoExterior"].'"';}if($ResMatriz["NoInterior"]!=''){$xml.=' noInterior="'.$ResMatriz["NoInterior"].'"';}$xml.=' colonia="'.$ResMatriz["Colonia"].'"';if($ResMatriz["Localidad"]!=''){$xml.=' localidad="'.$ResMatriz["Localidad"].'"';}$xml.=' municipio="'.$ResMatriz["Municipio"].'" estado="'.$ResMatriz["Estado"].'" pais="'.$ResMatriz["Pais"].'" codigoPostal="'.$ResMatriz["CodPostal"].'"/>
        <ExpedidoEn calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>
    </Emisor>';
}

$xml.='<Receptor rfc="'.$ResCliente["RFC"].'" nombre="'.$ResCliente["Nombre"].'">
       <Domicilio calle="'.$ResCliente["Direccion"].'"';if($ResCliente["NumExterior"]!=''){$xml.=' noExterior="'.$ResCliente["NumExterior"].'"';}if($ResCliente["NumInterior"]!=''){$xml.=' noInterior="'.$ResCliente["NumInterior"].'"';}$xml.=' colonia="'.$ResCliente["Colonia"].'" estado="'.$ResCliente["Estado"].'"';if($ResCliente["Ciudad"]){$xml.=' localidad="'.$ResCliente["Ciudad"].'"';}if($ResCliente["Municipio"]!=''){$xml.=' municipio="'.$ResCliente["Municipio"].'"';}$xml.=' pais="'.$ResCliente["Pais"].'" codigoPostal="'.$ResCliente["CP"].'"/>
		</Receptor>
		<Conceptos>';

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
  $xml.='<Concepto cantidad="'.$RResPartidas["Cantidad"].'" ';
	if($RResPartidas["Producto"]!=0)
	{
  	$xml.='unidad="'.$ResUnidad["Nombre"].'" noIdentificacion="'.$RResPartidas["Clave"].'" descripcion="'.$ResProd["Nombre"].' - '.$ResProd["Clave"].'"';
	}
	else
	{
		$xml.='descripcion="'.$RResPartidas["Descripcion"].'" noIdentificacion="'.$RResPartidas["Clave"].'"';
	}
	$xml.=' valorUnitario="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($RResPartidas["PrecioUnitario"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$RResPartidas["PrecioUnitario"];}$xml.='" importe="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($RResPartidas["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$RResPartidas["Subtotal"];}$xml.='"/>';
}
$IVA=explode('.', $_SESSION["iva"]);
$xml.='</Conceptos>
    <Impuestos totalImpuestosTrasladados="';if($ResFactura["Moneda"]=='USD'){$xml.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Iva"];}$xml.='">
        <Traslados>
            <Traslado importe="';if($ResFactura["Moneda"]=='USD'){$xml.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Iva"];}$xml.='" impuesto="IVA" tasa="'.$IVA[1].'.00"/>
        </Traslados>
    </Impuestos>
</Comprobante>';

$cIniHexXML = hex2bin("efbbbf");
$NuevoXML = $cIniHexXML.$xml;

header( "Content-Type: application/octet-stream");
header( "Content-Disposition: attachment; filename=".$ResFactura["Serie"].$ResFactura["NumFactura"].".xml"); 
print($NuevoXML);
//echo utf8_encode($xml);

function hex2bin($h)
{
   if (!is_string($h)) return null;
   $r='';
   for ($a=0; $a<strlen($h); $a+=2) { 
      $r.=chr(hexdec($h{$a}.$h{($a+1)})); 
   }
   return $r;
} 
?>