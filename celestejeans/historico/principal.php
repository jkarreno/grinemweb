<?php 
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

date_default_timezone_set('America/Mexico_City');

include ("conexion.php");

require ('xajax/xajax.inc.php');

include ("clientes/funcionesclientes.php");
include ("provedores/funcionesprovedores.php");
include ("pagos/funcionespagos.php");
include ("bancos/funcionesbancos.php");
include ("existencias/funcionesexistencias.php");
include ("gastos/funcionesgastos.php");
include ("gastos/funcionesgastosazul.php");
include ("programacion/funcionesprogramacion.php");
include ("costos/funcionescostos.php");
include ("metros/funcionesmetros.php");


$xajax = new xajax(); 
	
	//clientes
	$xajax->registerFunction("clientes");
	$xajax->registerFunction("agregar_cliente");
	$xajax->registerFunction("agregar_cliente_2");
	$xajax->registerFunction("editar_cliente");
	$xajax->registerFunction("editar_cliente_2");
	$xajax->registerFunction("historico_cliente");
	$xajax->registerFunction("ver_historico");
	//provedores
	$xajax->registerFunction("provedores");
	$xajax->registerFunction("agregar_provedor");
	$xajax->registerFunction("agregar_provedor_2");
	$xajax->registerFunction("edita_provedor");
	$xajax->registerFunction("editar_provedor_2");
	//pagos
	$xajax->registerFunction("pagos");
	$xajax->registerFunction("agregar_venta");
	$xajax->registerFunction("editar_venta");
	$xajax->registerFunction("agregar_pago");
	$xajax->registerFunction("aplica_restante");
	$xajax->registerFunction("agregar_cheque");
	$xajax->registerFunction("editar_cheque");
	$xajax->registerFunction("editar_pago");
	$xajax->registerFunction("pagos_provedor");
	$xajax->registerFunction("cheque_pago");
	$xajax->registerFunction("agregar_compra");
	$xajax->registerFunction("editar_compra");
	$xajax->registerFunction("agregar_pago_prov");
	$xajax->registerFunction("editar_pago_prov");
	$xajax->registerFunction("agregar_cheque_prov");
	$xajax->registerFunction("editar_cheque_prov");
	$xajax->registerFunction("cheque_pago_prov");
	$xajax->registerFunction("juridico");
	$xajax->registerFunction("ver_juridico");
	//bancos
	$xajax->registerFunction("bancos");
	$xajax->registerFunction("agregar_cuenta");
	$xajax->registerFunction("agregar_cuenta_2");
	$xajax->registerFunction("editar_cuenta");
	$xajax->registerFunction("editar_cuenta_2");
	$xajax->registerFunction("cuenta");
	$xajax->registerFunction("agregar_concepto");
	$xajax->registerFunction("editar_concepto");
	//existencias
	$xajax->registerFunction("telas");
	$xajax->registerFunction("agregar_tela");
	$xajax->registerFunction("agregar_tela_2");
	$xajax->registerFunction("editar_tela");
	$xajax->registerFunction("editar_tela_2");
	$xajax->registerFunction("existencias");
	$xajax->registerFunction("agregar_venta_tela");
	$xajax->registerFunction("editar_venta_tela");
	$xajax->registerFunction("agregar_compra_tela");
	$xajax->registerFunction("editar_compra_tela");
	//gastos
	$xajax->registerFunction("gastos_jack");
	$xajax->registerFunction("agregar_gasto_jack");
	$xajax->registerFunction("editar_gasto_jack");
	$xajax->registerFunction("editar_gasto_jack_nuevo_monto");
	$xajax->registerFunction("gastos_azul");
	$xajax->registerFunction("agregar_gasto_azul");
	$xajax->registerFunction("editar_gasto_azul");
	$xajax->registerFunction("editar_gasto_azul_nuevo_monto");
	//programacion
	$xajax->registerFunction("programacion");
	$xajax->registerFunction("agregar_programacion");
	$xajax->registerFunction("editar_programacion");
	$xajax->registerFunction("agregar_programacion_venta");
	$xajax->registerFunction("editar_programacion_venta");
	$xajax->registerFunction("calcular_todo");
	//costos
	$xajax->registerFunction("costos");
	$xajax->registerFunction("agregar_costo");
	$xajax->registerFunction("agregar_costo_2");
	$xajax->registerFunction("editar_costo");
	$xajax->registerFunction("editar_costo_2");
	$xajax->registerFunction("costos_check");
	$xajax->registerFunction("comentarios_costo");
	$xajax->registerFunction("comentarios_pago");
	$xajax->registerFunction("eliminar_costo");
	//metros
	$xajax->registerFunction("metros");
	$xajax->registerFunction("editar_compra_metros");
	$xajax->registerFunction("editar_venta_metros");
	//avios
	$xajax->registerFunction("avios");
	$xajax->registerFunction("agregar_avio");
	$xajax->registerFunction("agregar_avio_2");
	$xajax->registerFunction("editar_avio");
	$xajax->registerFunction("editar_avio_2");
	$xajax->registerFunction("existencias_avios");
	$xajax->registerFunction("agregar_compra_avio");
	$xajax->registerFunction("editar_compra_avio");
	$xajax->registerFunction("agregar_venta_avio");
	$xajax->registerFunction("editar_venta_avio");

	
	$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Sistema de Control de Pagos</title>
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/menu.css" rel="stylesheet" type="text/css">
<?php $xajax->printJavascript('xajax/'); ?>
<script language="JavaScript" type="text/javascript" src="js/codigo.js"></script>
<script language="JavaScript">
function mueveReloj(){ 
   	momentoActual = new Date() 
   	hora = momentoActual.getHours() 
   	minuto = momentoActual.getMinutes() 
   	segundo = momentoActual.getSeconds() 

   	str_segundo = new String (segundo) 
   	if (str_segundo.length == 1) 
      	 segundo = "0" + segundo 

   	str_minuto = new String (minuto) 
   	if (str_minuto.length == 1) 
      	 minuto = "0" + minuto 

   	str_hora = new String (hora) 
   	if (str_hora.length == 1) 
      	 hora = "0" + hora 

   	horaImprimible=hora+":"+minuto+":"+segundo 

   	document.form_reloj.reloj.value = horaImprimible 

   	setTimeout("mueveReloj()",1000) 
} 



</script>
</head>
<body onload="xajax_pagos()">
<div id="menuizq" style="position: absolute; width:120px; left: 10px; top: 60px "></div>
<div id="top" style="width:100%; height: 81px; background-color: #355a9e; top: 0px;  position: fixed; z-index:999;"><div id="logo" style="position: absolute; left:10px; top:5px; font-family: Arial; font-weight: bold; color:#FFF;"><img src="images/FondoAzul.jpg" border="0"></div>
<div id="bienvenida" style="position: absolute; width: 100%; left:0px; padding: 0 20 0 0px;"><p align="right" class="texto2"><?php echo utf8_encode($_SESSION["nombreuser"]);?></p></div>
<div id="empresa" style="position: absolute; width: 1000px; left:0px; z-index:2;">
<?php 
	//$ResCuenta=mysql_fetch_array(mysql_query("SELECT Empresa FROM cuentas WHERE Consecutivo='".$_SESSION["cuenta"]."' LIMIT 1"));
?>
<p align="left" class="texto2"><?php //echo utf8_encode($ResCuenta["Empresa"]);?></p></div>
</div>
<div id="cuadro" style="width:100%; background-color: #FFFFFF; border: 1px solid #008001; position: absolute; top: 40px; left:0px;">
	<div id="menutop" style="width:100%; height: 40px; background-color: #ffb6c1; position: fixed; top: 40px; padding: 0 10 5 10px; z-index:1000;">
		<ul>
				<li><a href="principal.php"><img src="images/home.png" border="0" width="80%"></a></li>
				<li><a href="#" onclick="xajax_clientes()">Clientes</a>
					<ul>
					</ul>
				</li>
				<li><a href="#" onclick="xajax_provedores()">Proveedores</a>
					<ul>
					</ul>
				</li>
				<li><a href="#" onclick="xajax_bancos()">Bancos</a>
					<ul>
					</ul>
				</li>
				<li><a href="#" onclick="xajax_telas()">Modelos</a>
					<ul>
					</ul>
				</li>
				<li><a href="#" onclick="xajax_avios()">Avios</a>
					<ul>
					</ul>
				</li>
				<!--<li><a href="#" onclick="xajax_programacion()">Programación</a>
					<ul>
					</ul>
				</li>-->
				<li><a href="#" onclick="xajax_gastos_azul('','','<?php echo (date("Y")-1);?>')">Gastos Celeste</a>
					<ul>
					</ul>
				</li>
				<li><a href="#" onclick="xajax_gastos_jack('','','<?php echo (date("Y")-1);?>')">Gastos Jack</a>
					<ul>
					</ul>
				</li>
				<li><a href="#" onclick="xajax_metros()">Pantalones</a>
				<li><a href="#" onclick="xajax_costos()">Costos</a>
					<ul>
					</ul>
				</li>
				<li><a href="../logout.php">Salir</a>
					<ul></ul>
				</li>
		</ul>
	</div>
	 
	
	<div id="lightbox" style="position: absolute; top:70px; left:100px; width:1200px; padding: 10 10 10 10px; z-index:100; visibility:hidden"></div>
	<div id="contenido" style="position: absolute; top:50px; left:0px; width:100%; padding: 10 10 10 10px; text-align: center;">
	<!-- Aqui va el contenido -->

	
	</div>
</div>
</body>
</html>
<?php
//funciones comunes

function fecha($fecha)
{
	switch($fecha[5].$fecha[6])
	{
		case '01'; $mes='Ene'; break;
		case '02'; $mes='Feb'; break;
		case '03'; $mes='Mar'; break;
		case '04'; $mes='Abr'; break;
		case '05'; $mes='May'; break;
		case '06'; $mes='Jun'; break;
		case '07'; $mes='Jul'; break;
		case '08'; $mes='Ago'; break;
		case '09'; $mes='Sep'; break;
		case '10'; $mes='Oct'; break;
		case '11'; $mes='Nov'; break;
		case '12'; $mes='Dic'; break;
	}
	
	$fechanew=$fecha[8].$fecha[9].'-'.$mes.'-'.$fecha[2].$fecha[3];
	
	return $fechanew;
}
function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	//$dias 	= abs($dias); $dias = floor($dias);	
	if ($dias<=0){return 0;}
	else{return $dias;}
}
?>
