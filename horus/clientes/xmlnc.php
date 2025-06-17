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
include ("../conexion.php");

if($_POST["idnota"]){$idnota=$_POST["idnota"];}
elseif($_GET["idnota"]){$idnota=$_GET["idnota"];}
//generales de la factura
$ResNota=mysql_fetch_array(mysql_query("SELECT * FROM nota_credito WHERE Id='".$idnota."' LIMIT 1"));
$ResFNotasC=mysql_fetch_array(mysql_query("SELECT * FROM fnotascredito WHERE FolioI<='".$ResNota["NumNota"]."' AND FolioF>='".$ResNota["NumNota"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$ResNota["Serie"]."' ORDER BY Id DESC LIMIT 1"));

//echo $ResNota["Serie"];

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
$ResEmpresa=mysql_fetch_array(mysql_query("SELECT * FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResNota["Cliente"]."' LIMIT 1"));
	
$xml='<?xml version="1.0" encoding="UTF-8" ?>
<Comprobante xmlns="http://www.sat.gob.mx/cfd/2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/2 http://www.sat.gob.mx/sitio_internet/cfd/2/cfdv2.xsd http://www.sat.gob.mx/ecc http://www.sat.gob.mx/sitio_internet/cfd/ecc/ecc.xsd" version="2.0"';
if($ResNota["Serie"]!=''){$xml.=' serie="'.$ResNota["Serie"].'"';}
$xml.=' folio="'.$ResNota["NumNota"].'" fecha="';
for($i=0; $i<=9; $i++){$xml.=$ResNota["Fecha"][$i];}
$xml.='T';
for($i=11; $i<=18;$i++){$xml.=$ResNota["Fecha"][$i];}
$cer=file_get_contents('../certificados/'.$ResFNotasC["NumCertificado"].'.cer.pem'); //leemos el certificado
$cer1=str_replace('-----BEGIN CERTIFICATE-----','',$cer);
$certificado=str_replace('-----END CERTIFICATE-----','',$cer1);
$xml.='" sello="'.file_get_contents('../certificados/sellos/nc/sello_'.$idnota.'.txt').'"  noCertificado="'.$ResFNotasC["NumCertificado"].'" certificado="'.$certificado.'" subTotal="'.$ResNota["Importe"].'" total="'.$ResNota["Total"].'" noAprobacion="'.$ResFNotasC["NumAprobacion"].'" anoAprobacion="'.$ResFNotasC["Fecha"][0].$ResFNotasC["Fecha"][1].$ResFNotasC["Fecha"][2].$ResFNotasC["Fecha"][3].'" formaDePago="PAGO EN UNA SOLA EXHIBICIÓN" tipoDeComprobante="egreso">';
$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'" nombre="'.$ResEmpresa["Nombre"].'" >
        <DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>
    </Emisor>
    <Receptor rfc="'.$ResCliente["RFC"].'" nombre="'.$ResCliente["Nombre"].'">
       <Domicilio calle="'.$ResCliente["Direccion"].'"';if($ResCliente["NumExterior"]!=''){$xml.=' noExterior="'.$ResCliente["NumExterior"].'"';}if($ResCliente["NumInterior"]!=''){$xml.=' noInterior="'.$ResCliente["NumInterior"].'"';}$xml.=' colonia="'.$ResCliente["Colonia"].'" estado="'.$ResCliente["Estado"].'"';if($ResCliente["Ciudad"]){$xml.=' localidad="'.$ResCliente["Ciudad"].'"';}if($ResCliente["Municipio"]!=''){$xml.=' municipio="'.$ResCliente["Municipio"].'"';}$xml.=' pais="'.$ResCliente["Pais"].'" codigoPostal="'.$ResCliente["CP"].'"/>
		</Receptor>
		<Conceptos>';

$ResPartidas=mysql_query("SELECT * FROM det_nota_credito WHERE IdNota='".$idnota."' ORDER BY Id ASC");
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
	
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
  
	$xml.='<Concepto cantidad="'.$RResPartidas["Cantidad"].'" ';
	if($RResPartidas["Producto"]!=0)
	{
  	$xml.='unidad="'.$ResUnidad["Nombre"].'" descripcion="'.$ResProd["Nombre"].' - '.$ResProd["Clave"].'"';
	}
	else
	{
		$xml.='descripcion="'.$RResPartidas["Descripcion"].'"';
	}
	$xml.=' valorUnitario="'.$RResPartidas["PrecioUnitario"].'" importe="'.$RResPartidas["Importe"].'"/>';
}
$IVA=explode('.', $_SESSION["iva"]);
$xml.='</Conceptos>
    <Impuestos totalImpuestosTrasladados="'.$ResNota["Iva"].'">
        <Traslados>
            <Traslado importe="'.$ResNota["Iva"].'" impuesto="IVA" tasa="'.$IVA[1].'.00"/>
        </Traslados>
    </Impuestos>
</Comprobante>';

header( "Content-Type: application/octet-stream");
header( "Content-Disposition: attachment; filename=".$ResNota["Serie"]."_".$ResNota["NumNota"].".xml"); 
print(utf8_encode($xml));
//echo utf8_encode($xml);
 

?>