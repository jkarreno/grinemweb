<?php
//incluimos la clase nusoap.php
require_once('2011/nusoap/lib/nusoap.php');

$cliente = new soapclient('http://www.gruposecsa.net/2011/serviciows.php?wsdl', true);
$resultado = $cliente->call('OrdenVenta', '');

echo "Resultados<br/>";
echo $resultado;
?>