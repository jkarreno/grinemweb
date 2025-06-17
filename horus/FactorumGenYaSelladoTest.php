<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php


//Se asigna el servicio
$servicio="https://www.factorumweb.com/FactorumWSv32/FactorumCFDiService.asmx?WSDL"; //url del servicio
//parametros de la llamada
$parametros=array();

//Este es el metodo que vamos a probar
/*
 *< xmlns="http://cfdi.einvoicews.factorum.com/">
 *     <usuario>string</usuario>
 *     <rfc>string</rfc>
 *     <password>string</password>
 *     <xml>string</xml>
 *  </FactorumGenYaSelladoTest>

 */

//Se obtiene el archivo XML
/*En lugar del archivo xml, se obtiene
* el valor de un string o campo texto
*/
$data = "";

//Se preparan los parametros con los valores adecuados
$parametros['usuario']="prueba1@factorum.com.mx"; //String
$parametros['rfc']="AAA010101AAA";//String
$parametros['password']="prueba2011";//String
$parametros['xml']=$data; //string, pero se maneja String aqui

//Se crea el cliente del servicio
$client = new SoapClient( $servicio, $parametros);

//Se hace el metodo que vamos a probar
$result = $client->FactorumGenYaSelladoTest($parametros);

//Para observar el Dump de lo que regresa, es puramente de debug
echo "Valor dump del servicio:";
echo "<BR>";
var_dump($result);
echo "<BR>";
echo "<BR>";

//Aislar cada valor de lo que regresa, y poder manipularlo como sea
foreach($result as $key => $value) {
    echo "Valor de ReturnStringXML:";
    echo "<BR>";
    var_dump($value->ReturnStringXML);
    echo "<BR>";
    echo "<BR>";
    echo "Valor de ReturnFileXML:";
    echo "<BR>";
    var_dump($value->ReturnFileXML);
    echo "<BR>";
    echo "<BR>";
    echo "Valor de ReturnFileQRCode:";
    echo "<BR>";
    var_dump($value->ReturnFileQRCode);
}

?>

    </body>
</html>
