<?php
//incluimos la clase nusoap.php
require_once('nusoap/lib/nusoap.php');

$servidor = new soap_server();
$servidor->configureWSDL("OrdenVentawsdl","urn:OrdenVentawsdl");

$servidor->register(
"OrdenVenta", 
'', // no pasa parámetros
array("return" => "xsd:string"), // pero si recibe una respuesta en formato 'string'
"uri:OrdenVentawsdl",
"uri:OrdenVentawsdl/Posts",
"rpc",
"encoded",
"Toma el nombre o titulo de los articulos publicados en sindicados.com"
);

function OrdenVenta(){
include("conexion.php");
$sql = "SELECT * FROM ordenventa ORDER BY Id ASC LIMIT 3";
$rs = mysql_query($sql);
$html = "";

while ($row = mysql_fetch_array($rs)) {

$html .=$row["Id"]."<br />";
}

return $html;

}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$servidor->service($HTTP_RAW_POST_DATA); 
?>