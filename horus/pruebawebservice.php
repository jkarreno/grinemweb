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

//
$parametros["user"]="SIL071211M50"; //String
$parametros["password"]="jrgdwpaft";//String
$parametros["file"]=base64_encode(file_get_contents(utf8_decode("4.xml")));

/*$parametros='<?xml version="1.0" encoding="UTF-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cfdi="http://cfdi.service.ediwinws.edicom.com"><soapenv:Header/><soapenv:Body><cfdi:getCfdiTest><cfdi:user>'.$usuario.'</cfdi:user><cfdi:password>'.$contrasena.'</cfdi:password><cfdi:file>'.$xml.'</cfdi:file></cfdi:getCfdiTest></soapenv:Body></soapenv:Envelope>';
*/

//Se crea el cliente del servicio
$client = new nusoap_client($servicio, true);

//Se hace el metodo que vamos a probar
$result = $client->call("getTimbreCfdiTest", $parametros);

//$result2=get_object_vars($result); //convertimos el objeto a array
		
file_put_contents('regresa.zip', base64_decode($result["getTimbreCfdiTestReturn"]));


require_once('pclzip.lib.php');
	$archive = new PclZip("regresa.zip");
  	if ($archive->extract() == 0) {
    	die("Error : ".$archive->errorInfo(true));
    }

    
    //leemos el contenido del timbre
    $complemento=file_get_contents("TIMBRE_XML_COMPROBANTE_3_0.xml");

?></body>
</html>