<?php
//digestion sha1
	$cadenaoriginal = utf8_encode('||2.0|FACTURAS|1050|2011-04-19T19:52:18|344791|2010|ingreso|PAGO EN UNA SOLA EXHIBICIÓN|10.00|11.60|SEC871208M21|SURTIDORA ELECTRICA DEL CENTRO S. A. DE C. V.|REVILLAGIGEDO|34|2o PISO|CENTRO|CUAUHTEMOC|DISTRITO FEDERAL|MEXICO|06050|AIA941123Q99|ADMINISTRACION INTEGRAL DE ALIMENTOS, S.A. DE C.V.|LAGO ZURICH # 245 EDIFICIO PRESA FALCON PISO 7|GRANADA AMPLIACION| MIGUEL HIDALGO|MEXICO, D.F.|MEXICO|11529|1|PZ|PLACA ALUMINIO 100/2R - 100/2R|0.91|0.91|IVA|16.00|0.15|0.15||') ;
	echo '<p>'.$cadenaoriginal;
	//guardamos en archivo
	$fp = fopen ("../certificados/sellos/facprueba.txt", "w+");
       fwrite($fp, $cadenaoriginal);
	fclose($fp);
	//archivo .key
	$key='../certificados/sil071211m50_1012210918s.key.pem';
	//sellamos archivo
	exec("openssl dgst -sha1 -sign $key ../certificados/sellos/facprueba.txt | openssl enc -base64 -A > ../certificados/sellos/sello_facprueba.txt");

//sello digital


 		$f=fopen("../certificados/sellos/sello_facprueba.txt",'r');
    $txt=fread($f,filesize("../certificados/sellos/sello_facprueba.txt"));
    fclose($f);
//$sello=readfile("../certificados/sellos/sello_".$idfactura.".txt");
echo '<p>'.$txt;


?>