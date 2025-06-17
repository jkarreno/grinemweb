<?php
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("../conexion.php");
$ResRFC=mysql_fetch_array(mysql_query("SELECT RFC FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id='".$_SESSION["sucursal"]."' LIMIT 1"));

//Facturas
$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha LIKE '".$_POST["anno"]."-".$_POST["mes"]."-%'  ORDER BY Id ASC");
while($RResFacturas=mysql_fetch_array($ResFacturas))
{
	$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$RResFacturas["NumFactura"]."' AND FolioF>='".$RResFacturas["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT RFC FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
	$cadena.='|'.$ResCliente["RFC"].'|'.$ResFFacturas["Serie"].'|'.$RResFacturas["NumFactura"].'|'.$ResFFacturas["NumAprobacion"].'|'.$RResFacturas["Fecha"][8].$RResFacturas["Fecha"][9].'/'.$RResFacturas["Fecha"][5].$RResFacturas["Fecha"][6].'/'.$RResFacturas["Fecha"][0].$RResFacturas["Fecha"][1].$RResFacturas["Fecha"][2].$RResFacturas["Fecha"][3].' '.$RResFacturas["Fecha"][11].$RResFacturas["Fecha"][12].$RResFacturas["Fecha"][13].$RResFacturas["Fecha"][14].$RResFacturas["Fecha"][15].$RResFacturas["Fecha"][16].$RResFacturas["Fecha"][17].$RResFacturas["Fecha"][18];
	if($RResFacturas["Moneda"]=='USD'){$cadena.='|'.($RResFacturas["Total"]*$RResFacturas["TipoCambio"]).'|'.($RResFacturas["Iva"]*$RResFacturas["TipoCambio"]).'|';}
	else{$cadena.='|'.$RResFacturas["Total"].'|'.$RResFacturas["Iva"].'|';}
	$cadena.='1|I|';
	$cadena.='<br />';
}
//Notas de Credito
$ResNotasC=mysql_query("SELECT * FROM nota_credito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha LIKE '".$_PSOT["anno"]."-".$_POST["mes"]."-%' ORDER BY Id ASC");
while($RResNotasC=mysql_fetch_array($ResNotasC))
{
	$ResFNotasC=mysql_fetch_array(mysql_query("SELECT * FROM fnotascredito WHERE FolioI<='".$RResNotasC["NumNota"]."' AND FolioF>='".$RResNotasC["NumNota"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT RFC FROM clientes WHERE Id='".$RResNotasC["Cliente"]."' LIMIT 1"));
	$cadena.='|'.$ResCliente["RFC"].'|'.$ResFNotasC["Serie"].'|'.$RResNotasC["NumNota"].'|'.$ResFNotasC["NumAprobacion"].'|'.$RResNotasC["Fecha"][8].$RResNotasC["Fecha"][9].'/'.$RReNotasC["Fecha"][5].$RResNotasC["Fecha"][6].'/'.$RResNotasC["Fecha"][0].$RResNotasC["Fecha"][1].$RResNotasC["Fecha"][2].$RResNotasC["Fecha"][3].' '.$RResNotasC["Fecha"][11].$RResNotasC["Fecha"][12].$RResNotasC["Fecha"][13].$RResNotasC["Fecha"][14].$RResNotasC["Fecha"][15].$RResNotasC["Fecha"][16].$RResNotasC["Fecha"][17].$RResNotasC["Fecha"][18];
	$cadena.='|'.$RResNotasC["Total"].'|'.$RResNotasC["Iva"].'|';
	$cadena.='1|E|';
	$cadena.='<br />';
}

////Canceladas
//Facturas
$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND FechaCancelada LIKE '".$_POST["anno"]."-".$_POST["mes"]."-%' AND Status='Cancelada' ORDER BY Id ASC");
while($RResFacturas=mysql_fetch_array($ResFacturas))
{
	$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$RResFacturas["NumFactura"]."' AND FolioF>='".$RResFacturas["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT RFC FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
	$cadena.='|'.$ResCliente["RFC"].'|'.$ResFFacturas["Serie"].'|'.$RResFacturas["NumFactura"].'|'.$ResFFacturas["NumAprobacion"].'|'.$RResFacturas["FechaCancelada"][8].$RResFacturas["FechaCancelada"][9].'/'.$RResFacturas["FechaCancelada"][5].$RResFacturas["FechaCancelada"][6].'/'.$RResFacturas["FechaCancelada"][0].$RResFacturas["FechaCancelada"][1].$RResFacturas["FechaCancelada"][2].$RResFacturas["FechaCancelada"][3].' '.$RResFacturas["FechaCancelada"][11].$RResFacturas["FechaCancelada"][12].$RResFacturas["FechaCancelada"][13].$RResFacturas["FechaCancelada"][14].$RResFacturas["FechaCancelada"][15].$RResFacturas["FechaCancelada"][16].$RResFacturas["FechaCancelada"][17].$RResFacturas["FechaCancelada"][18];
	$cadena.='|'.$RResFacturas["Total"].'|'.$RResFacturas["Iva"].'|';
	$cadena.='0|I|';
	$cadena.='<br />';
}
//Notas de Credito
$ResNotasC=mysql_query("SELECT * FROM nota_credito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND FechaCancelada LIKE '".$_POST["anno"]."-".$_POST["mes"]."-%' AND Status='Cancelada' ORDER BY Id ASC");
while($RResNotasC=mysql_fetch_array($ResNotasC))
{
	$ResFNotasC=mysql_fetch_array(mysql_query("SELECT * FROM fnotascredito WHERE FolioI<='".$RResNotasC["NumNota"]."' AND FolioF>='".$RResNotasC["NumNota"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT RFC FROM clientes WHERE Id='".$RResNotasC["Cliente"]."' LIMIT 1"));
	$cadena.='|'.$ResCliente["RFC"].'|'.$ResFNotasC["Serie"].'|'.$RResNotasC["NumNota"].'|'.$ResFNotasC["NumAprobacion"].'|'.$RResNotasC["FechaCancelada"][8].$RResNotasC["FechaCancelada"][9].'/'.$RReNotasC["FechaCancelada"][5].$RResNotasC["FechaCancelada"][6].'/'.$RResNotasC["FechaCancelada"][0].$RResNotasC["FechaCancelada"][1].$RResNotasC["FechaCancelada"][2].$RResNotasC["FechaCancelada"][3].' '.$RResNotasC["FechaCancelada"][11].$RResNotasC["FechaCancelada"][12].$RResNotasC["FechaCancelada"][13].$RResNotasC["FechaCancelada"][14].$RResNotasC["FechaCancelada"][15].$RResNotasC["FechaCancelada"][16].$RResNotasC["FechaCancelada"][17].$RResNotasC["FechaCancelada"][18];
	$cadena.='|'.$RResNotasC["Total"].'|'.$RResNotasC["Iva"].'|';
	$cadena.='1|E|';
	$cadena.='<br />';
}

echo $cadena;

//header( "Content-Type: application/octet-stream");
//header( "Content-Disposition: attachment; filename=".$ResRFC["RFC"].$_POST["mes"].$_POST["anno"].".txt"); 
//print($cadena);
?>