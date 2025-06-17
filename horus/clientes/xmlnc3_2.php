<?php

include ("../conexion.php");

$idnota=$_GET["idnota"];
$empresa=$_GET["empresa"];
$sucursal=$_GET["sucursal"];
//generales de la factura
$ResNota=mysql_fetch_array(mysql_query("SELECT Serie, NumNota, XML FROM nota_credito WHERE Id='".$idnota."' LIMIT 1"));
	
$xml=str_replace('cfdv2.xsd','cfdv22.xsd',$ResNota["XML"]);

//$cIniHexXML = hex2bin("efbbbf");
//$NuevoXML = $cIniHexXML.$xml;

header( "Content-Type: application/octet-stream");
header( "Content-Disposition: attachment; filename=".$ResNota["Serie"].$ResNota["NumNota"].".xml"); 
print($xml);
//echo utf8_encode($xml);

/*function hex2bin($h)
{
   if (!is_string($h)) return null;
   $r='';
   for ($a=0; $a<strlen($h); $a+=2) { 
      $r.=chr(hexdec($h{$a}.$h{($a+1)})); 
   }
   return $r;
} */
?>