<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php
require_once('nusoap/nusoap.php');
$servicio="https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl";

//parametros de la llamada
$parametros=array();

$parametros["user"]="SEC871208M21"; //String
$parametros["password"]="wrkrrvpni";//String
$parametros["rfc"]="SEC871208M21";//
$parametros["uuid"]="0B16D78A-5AF4-46E8-8A8B-59A039998AF4";
$parametros["pfx"]=base64_encode(file_get_contents("00001000000202660143.pfx"));
$parametros["pfxPassword"]="surti14";



//Se crea el cliente del servicio
$client = new nusoap_client($servicio, true);

//Se hace el metodo que vamos a probar
$result = $client->call("cancelaCFDi", $parametros);

//$result2=$result["cancelaCFDiReturn"]; //convertimos el objeto a array
		
//file_put_contents('regresa.xml', $result["cancelaCFDiResponse"]);


//print_r($result);

echo  base64_decode($result["cancelaCFDiReturn"]["ack"]);

?></body>
</html>

