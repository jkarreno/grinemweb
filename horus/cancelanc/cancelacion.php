<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php
	include ("../conexion.php");
	require('../clientes/xml2array.php');
	require_once('../nusoap/nusoap.php');
	
	$ResNC=mysql_fetch_array(mysql_query("SELECT Id, XML FROM nota_credito WHERE Id='".$_GET["idnota"]."' LIMIT 1"));
	$xml=xml2array($ResNC["XML"]);
	$UUID=$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"];
	
	$servicio="https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl";

	//parametros de la llamada
	$parametros=array();

	$parametros["user"]="GEI1404043C1"; //String
	$parametros["password"]="0jt7jbavcj";//String
	$parametros["rfc"]="GEI1404043C1";//
	$parametros["uuid"]=$UUID;
	$parametros["pfx"]=base64_encode(file_get_contents("0000100000030408763.pfx"));
	$parametros["pfxPassword"]="IMEX14";
	
	//Se crea el cliente del servicio
	$client = new nusoap_client($servicio, true);

	//Se hace el metodo que vamos a probar
	$result = $client->call("cancelaCFDi", $parametros);
	
	$acusecancelada=base64_decode($result["cancelaCFDiReturn"]["ack"]);
	
	mysql_query("UPDATE nota_credito SET AcuseCancela='".$result["cancelaCFDiReturn"]["ack"]."' WHERE Id='".$_GET["idnota"]."'") or die(mysql_error());
	
	echo '<p>UUID: '.$UUID;
	
	echo '<p>Acuse de cancelacion: ';
	
	echo  base64_decode($result["cancelaCFDiReturn"]["ack"]);
	
	echo '<p><form name="fcancelanota" id="fcancelanota" action="index.php" method="POST">
			<input type="hidden" name="mes" id="mes" value="'.$_GET["mes"].'">
			<input type="hidden" name="anno" id="anno" value="'.$_GET["anno"].'">
			<input type="hidden" name="sucursal" id="sucursal" value="'.$_GET["sucursal"].'">
			<input type="submit" name="butconnota" id="butconnota" value="Regresar a Notas de Credito>>">
		</form>';
?>
