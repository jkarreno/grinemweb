<?php
require('xml2array.php');

//conecto a la base de datos
include("../conexion.php");

//recibo el id de la factura
$idfactura=$_GET["idfactura"];

//datos de la factura
$ResFactura=mysql_fetch_array(mysql_query("SELECT XML FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));

$xml=xml2array(utf8_decode($ResFactura["XML"]));

print_r($xml);

?>