<?php

include ("../conexion.php");

$idfactura=$_GET["idfactura"];
$empresa=$_GET["empresa"];
$sucursal=$_GET["sucursal"];
//generales de la factura
$ResFactura=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura, XML FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));
	
$xml=str_replace('cfdv2','cfdv22',$ResFactura["XML"]);

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