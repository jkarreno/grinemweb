<?php 
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la pï¿½gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 
include ("../conexion.php");

if($_POST["idfactura"]){$idfactura=$_POST["idfactura"];}
elseif($_GET["idfactura"]){$idfactura=$_GET["idfactura"];}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>SECSA - Sistema de Control Interno</title>
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Datos de la Factura -->
<?php 
	$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));
	$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$ResFactura["Serie"]."' LIMIT 1"));
	
	echo '<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="right">
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">Serie: </td>
						<td align="right" bgcolor="#FFFFFF" class="texto">'.$ResFactura["Serie"].'</td>
					</tr>
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">Folio: </td>
						<td align="right" bgcolor="#FFFFFF" class="texto">'.$ResFactura["NumFactura"].'</td>
					</tr>
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">Fecha: </td>
						<td align="right" bgcolor="#FFFFFF" class="texto">'.$ResFactura["Fecha"].'</td>
					</tr>
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">Aprobaci&oacute;n: </td>
						<td align="right" bgcolro="#FFFFFF" class="texto">'.$ResFFacturas["NumAprobacion"].'</td>
					</tr>
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">Certificado: </td>
						<td align="right" bgcolor="#FFFFFF" class="texto">'.$ResFFacturas["NumCertificado"].'</td>
					</tr>
				</table>';
//Datos del Emisor y del Receptor
	$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
	$ResEmpresa=mysql_fetch_array(mysql_query("SELECT * FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));
	
	echo '<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center" width="100%">
					<tr>
						<th colspan="2" align="center" bgcolor="#CCCCCC" class="texto" width="50%">Emisor</th>
						<th colspan="2" align="center" bgcolor="#CCCCCC" class="texto" width="50%">Receptor</th>
					</tr>
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">Nombre: </td>
						<td align="left" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResEmpresa["Nombre"]).'</td>
						<td align="left" bgcolor="#CCCCCC" class="texto">Nombre: </td>
						<td align="left" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResCliente["Nombre"]).'</td>
					</tr>
					<tr>
						<td align="left" bgcolor="#CCCCCC" class="texto">R.F.C.: </td>
						<td align="right" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResEmisor["RFC"]).'</td>
						<td align="left" bgcolor="#CCCCCC" class="texto">R.F.C.: </td>
						<td align="right" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResCliente["RFC"]).'</td>
					</tr>
					<tr>
						<th colspan="2" bgcolor="#CCCCCC" class="texto">Domicilio</th>
						<th colspan="2" bgcolor="#CCCCCC" class="texto">Domicilio</th>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResEmisor["Calle"]).' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){echo 'Interior '.$ResEmisor["NoInterior"];}echo '</td>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResCliente["Direccion"]).'</td>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">Col. '.utf8_encode($ResEmisor["Colonia"]).'</td>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">Col. '.utf8_encode($ResCliente["Colonia"]).'</td>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResEmisor["Localidad"]).' '.utf8_encode($ResEmisor["Municipio"]).' '.utf8_encode($ResEmisor["Estado"]).'</td>
						<td oolspan="2" align="left" bgcolor="#FFFFFF" class="texto">'.utf8_encode($ResCliente["Ciudad"]).' '.utf8_encode($ResCliente["Estado"]).'</td>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">C. P.: '.$ResEmisor["CodPostal"].' '.$ResEmisor["Pais"].'</td>
						<td colspan="2" align="left" bgcolor="#FFFFFF" class="texto">C. P.: '.$ResCliente["CP"].'</td>
					</tr>
				</table>';
	
	//cadena orginal
	//version
	$cadenaoriginal='||2.0|'; 
	//serie
	if($ResFactura["Serie"]!=''){$cadenaoriginal.=$ResFactura["Serie"].'|';}
	//folio
	$cadenaoriginal.=$ResFactura["NumFactura"].'|';
	//fecha
	for($i=0; $i<=9; $i++){$cadenaoriginal.=$ResFactura["Fecha"][$i];}
	$cadenaoriginal.='T';
	for($i=11; $i<=18;$i++){$cadenaoriginal.=$ResFactura["Fecha"][$i];}
	//datos emisor
	//numaprobacion
	$cadenaoriginal.='|'.$ResFFacturas["NumAprobacion"].'|'.$ResFFacturas["NumCertificado"].'|';
	//añoaprovacion
	$cadenaoriginal.=$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3].'|';
	//tipo de comprovante
	$cadenaoriginal.='ingreso|';
	//forma de pago
	$cadenaoriginal.=utf8_encode('Pago en una sola exhibición|');
	//condiciones de pago
	//subtotal
	$cadenaoriginal.=$ResFactura["Subtotal"].'|';
	//descuento
	//total
	$cadenaoriginal.=$ResFactura["Total"].'|';
	//rfc del emisor
	$cadenaoriginal.=$ResEmisor["RFC"].'|';
	//Nombre del emisor
	$cadenaoriginal.=utf8_encode($ResEmpresa["Nombre"]).'|';
	//Calle del domicilio fiscal del emisor
	$cadenaoriginal.=utf8_encode($ResEmisor["Calle"]).'|';
	//numero exterior del emisor
	if($ResEmisor["NoExterior"]!=''){$cadenaoriginal.=$ResEmisor["NoExterior"].'|';}
	//numero interior del emisor
	if($ResEmisor["NoInterior"]!=''){$cadenaoriginal.=$ResEmisor["NoInterior"].'|';}
	//colonia del emisor
	if($ResEmisor["Colonia"]!=''){$cadenaoriginal.=utf8_encode($ResEmisor["Colonia"]).'|';}
	//localidad del emisor
	if($ResEmisor["Localidad"]!=''){$cadenaoriginal.=utf8_encode($ResEmisor["Localidad"]).'|';}
	//municipio del emisro
	$cadenaoriginal.=utf8_encode($ResEmisor["Municipio"]).'|';
	//estado del emisor
	$cadenaoriginal.=utf8_encode($ResEmisor["Estado"]).'|';
	//pais del emisor
	$cadenaoriginal.=utf8_encode($ResEmisor["Pais"]).'|';
	//codigo porstal del emisor
	$cadenaoriginal.=$ResEmisor["CodPostal"];
	//datos receptor
	//rfc del receptor
	$cadenaoriginal.='|'.$ResCliente["RFC"].'|';
	//nombre del receptor
	$cadenaoriginal.=utf8_encode($ResCliente["Nombre"]).'|';
	//calle del receptor
	$cadenaoriginal.=utf8_encode($ResCliente["Direccion"]).'|';
	//numero exterior del receptro
	//numero interior del receptor
	//colonia del receptor
	if($ResCliente["Colonia"]!=''){$cadenaoriginal.=utf8_encode($ResCliente["Colonia"]).'|';}
	//localidad del receptor
	if($ResCliente["Ciudad"]!=''){$cadenaoriginal.=utf8_encode($ResCliente["Ciudad"]).'|';}
	//municipio del receptor
	if($ResCliente["Municipio"]!=''){$cadenaoriginal.=utf8_encode($ResCliente["Municipio"]).'|';}
	//estado del receptor
	if($ResCliente["Estado"]!=''){$cadenaoriginal.=utf8_encode($ResCliente["Estado"]).'|';}
	//pais del receptor
	$cadenaoriginal.=utf8_encode($ResCliente["Pais"]).'|';
	//codigo postal del receptor
	if($ResCliente["CP"]!=''){$cadenaoriginal.=$ResCliente["CP"].'|';}
	
	//Partida de la Factura
	$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");
	
	echo '<table border="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto">Cantidad</td>
						<td bgcolor="#CCCCCC" align="center" class="texto">Descripcion</td>
						<td bgcolor="#CCCCCC" align="center" class="texto">Precio</td>
						<td bgcolor="#CCCCCC" align="center" class="texto">Importe</td>
					</tr>';
	while($RResPartidas=mysql_fetch_array($ResPartidas))
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
		echo '<tr>
						<td bgcolor="#FFFFFF" align="center" class="texto">'.$RResPartidas["Cantidad"].'</td>
						<td bgcolor="#FFFFFF" align="left" class="texto">'.$RResPartidas["Clave"].' - '.utf8_encode($ResProd["Nombre"]).' - '.$ResProd["Clave"].'</td>
						<td bgcolor="#FFFFFF" align="right" class="texto">$ '.number_format($RResPartidas["PrecioUnitario"], 2).'</td>
						<td bgcolor="#FFFFFF" align="right" class="texto">$ '.number_format($RResPartidas["Subtotal"],2 ).'</td>
					</tr>';
		//continua cadena original
		//cantidad
		$cadenaoriginal.=$RResPartidas["Cantidad"].'|';
		//unidad
		$cadenaoriginal.=$ResUnidad["Nombre"].'|';
		//numero de identificacion (clave)
		$cadenaoriginal.=$RResPartidas["Clave"].'|';
		//descripcion
		$cadenaoriginal.=utf8_encode($ResProd["Nombre"]).' - '.$ResProd["Clave"].'|';
		//valor unitario
		$cadenaoriginal.=$RResPartidas["PrecioUnitario"].'|';
		//importe
		$cadenaoriginal.=$RResPartidas["Subtotal"].'|';
	}
	//continua cadena original
	//tipo de inpuesto
	$cadenaoriginal.='IVA|';
	//importe
	$cadenaoriginal.=$ResFactura["Iva"].'||';
	
	//Subtotal, Iva y Total
	echo '<tr>
					<td colspan="3" bgcolor="#CCCCCC" align="right" class="texto">Subtotal: </td>
					<td bgcolor="#FFFFFF" align="right" class="texto">$ '.number_format($ResFactura["Subtotal"], 2).'</td>
				</tr>
				<tr>
					<td colspan="3" bgcolor="#CCCCCC" align="right" class="texto">Iva: </td>
					<td bgcolor="#FFFFFF" align="right" class="texto">$ '.number_format($ResFactura["Iva"], 2).'</td>
				</tr>
				<tr>
					<td colspan="3" bgcolor="#CCCCCC" align="right" class="texto">Total: </td>
					<td bgcolor="#FFFFFF" align="right" class="texto">$ '.number_format($ResFactura["Total"], 2).'</td>
				</tr>';
	//cadena original
	echo '<tr>
					<th colspan="4" bgcolor="#CCCCCC" align="center" class="texto">Cadena Original</th>
				</tr>
				<tr>
					<th colspan="4" bgcolor="#FFFFFF" align="left" class="textoco">'.$cadenaoriginal.'</th>
				</tr>
				<tr>
					<th colspan="4" bgcolor="#CCCCCC" align="center" class="texto">Sello Digital</th>
				</tr>';
	//digestion md5
	$cadenaoriginal=md5($cadenaoriginal);
	//guardamos en archivo
	$fp = fopen ("../certificados/sellos/".$idfactura.".txt", "w+");
       fwrite($fp, $cadenaoriginal);
	fclose($fp);
	//archivo .key
	$key='../certificados/'.$ResFFacturas["ArchivoCadena"];
	//sellamos archivo
	exec("openssl dgst -sign ".$key." ../certificados/sellos/".$idfactura.".txt | openssl enc -base64 -A > ../certificados/sellos/sello_".$idfactura.".txt");
	echo '<tr>
					<th colspan="4" bgcolor="#FFFFFF" align="left" class="textoco">'."openssl dgst -sign ".$key." ../certificados/sellos/".$idfactura.".txt | openssl enc -base64 -A > ../certificados/sellos/sello_".$idfactura.".txt";
	readfile("../certificados/sellos/sello_".$idfactura.".txt");
	echo '	</th>
				</tr>';
?>
</body>
