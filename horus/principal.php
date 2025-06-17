<?php 
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la pï¿½gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("conexion.php");
include ("funciones.php");

require ('xajax/xajax.inc.php');

include ("administracion/funcionesadministracion.php");
include ("provedores/funcionesprovedores.php");
include ("clientes/funcionesclientes.php");
include ("clientes/funcionesclientes2.php");
include ("productos/funcionesproductos.php");
include ("almacen/funcionesalmacen.php");
include ("pos/funcionespos.php");
include ("reportes/funcionesreportes.php");

$xajax = new xajax(); 
	
	//administracion
	$xajax->registerFunction("menu_administracion");
	$xajax->registerFunction("empresas");
	$xajax->registerFunction("edit_empresa");
	$xajax->registerFunction("sucursales");
	$xajax->registerFunction("usuarios");
	$xajax->registerFunction("sucursal_empresa_ad_usuario");
	$xajax->registerFunction("adfolios");
	$xajax->registerFunction("bancos");
	$xajax->registerFunction("agentes");
	$xajax->registerFunction("permisos_usuarios");
	$xajax->registerFunction("permisos_usuarios2");
	$xajax->registerFunction("tipo_cambio");
	//provedores
	$xajax->registerFunction("provedores");
	$xajax->registerFunction("compra_provedor");
	$xajax->registerFunction("nueva_orden_compra_provedor");
	$xajax->registerFunction("claves");
	$xajax->registerFunction("nombres");
	$xajax->registerFunction("ver_orden_compra_provedor");
	$xajax->registerFunction("revisiones");
	$xajax->registerFunction("cuentas_pagar");
	$xajax->registerFunction("guarda_revision_prev");
	$xajax->registerFunction("guarda_revision");
	$xajax->registerFunction("aplica_pagos");
	$xajax->registerFunction("documentos_provedores");
	$xajax->registerFunction("reporte_pagos");
	$xajax->registerFunction("guarda_aplica_pagos");
	$xajax->registerFunction("compras");
	$xajax->registerFunction("guarda_orden_compra_provedor");
	//clientes
	$xajax->registerFunction("clientes");
	$xajax->registerFunction("clientes_pactados");
	$xajax->registerFunction("facturacion_cliente");
	$xajax->registerFunction("lista_ordenes_venta");
	$xajax->registerFunction("orden_venta");
	$xajax->registerFunction("claves_clientes");
	$xajax->registerFunction("factura_orden");
	$xajax->registerFunction("finaliza_factura_orden");
	$xajax->registerFunction("facturas");
	$xajax->registerFunction("guarda_orden_venta");
	$xajax->registerFunction("productos_clientes");
	$xajax->registerFunction("finaliza_factura_directa");
	$xajax->registerFunction("cancela_orden_venta");
	$xajax->registerFunction("cancela_factura");
	$xajax->registerFunction("factura_libre");
	$xajax->registerFunction("finaliza_factura_libre");
	$xajax->registerFunction("aplica_pagos_clientes");
	$xajax->registerFunction("guarda_aplica_pagos_clientes");
	$xajax->registerFunction("documentos_clientes");
	$xajax->registerFunction("reporte_pagos_clientes");
	$xajax->registerFunction("ventas");
	$xajax->registerFunction("reporte_mensual");
	$xajax->registerFunction("nota_credito");
	$xajax->registerFunction("guarda_nota_credito");
	$xajax->registerFunction("claves_clientes_nc");
	$xajax->registerFunction("ver_notas_credito");
	$xajax->registerFunction("cancela_nota_credito");
	$xajax->registerFunction("moneda");
	$xajax->registerFunction("cancela_pago_cliente");
	$xajax->registerFunction("cobro_agente");
	$xajax->registerFunction("cotizaciones");
	$xajax->registerFunction("nueva_cotizacion");
	$xajax->registerFunction("guarda_cotizacion");
	$xajax->registerFunction("unidades_cliente");
	$xajax->registerFunction("ad_unidades_clientes");
	$xajax->registerFunction("ad_unidades_clientes_2");
	$xajax->registerFunction("edit_unidades_clientes");
	$xajax->registerFunction("edit_unidades_clientes_2");
	$xajax->registerFunction("delete_unidades_clientes");
	$xajax->registerFunction("unidades_cliente_orden");
	$xajax->registerFunction("venta_agente");
	$xajax->registerFunction("edit_status_orden");
	$xajax->registerFunction("edit_status_orden_2");
	$xajax->registerFunction("orden_cotizacion");
	$xajax->registerFunction("guarda_orden_cotizacion");
	$xajax->registerFunction("factura_cotizacion");
	$xajax->registerFunction("finaliza_factura_cotizacion");
	$xajax->registerFunction("unidades_cliente_facturas");
	$xajax->registerFunction("cancela_cotizacion");
	$xajax->registerFunction("forma_pago_cliente");
	//productos	
	$xajax->registerFunction("productos");
	$xajax->registerFunction("clases");
	$xajax->registerFunction("unidades");
	$xajax->registerFunction("grupos");
	$xajax->registerFunction("tipo_producto");
	$xajax->registerFunction("buscar_producto");
	$xajax->registerFunction("imagen_producto");
	//almacen
	$xajax->registerFunction("almacenes");
	$xajax->registerFunction("guarda_almacenes");
	$xajax->registerFunction("inventario");
	$xajax->registerFunction("ingresa_mercancia");
	$xajax->registerFunction("check_orden_prov");
	$xajax->registerFunction("surtir_mercancia");
	$xajax->registerFunction("surtir_mercancia_orden_venta");
	$xajax->registerFunction("surtir_mercancia_orden_venta_2");
	$xajax->registerFunction("inventario_inicial");
	$xajax->registerFunction("claves_almacen");
	$xajax->registerFunction("ingresa_mercancia_orden");
	$xajax->registerFunction("traslado_almacen");
	$xajax->registerFunction("reportes_almacen");
	$xajax->registerFunction("ajustes_inventario");
	//POS
	$xajax->registerFunction("nota_nueva");
	$xajax->registerFunction("cliente_mostrador");
	$xajax->registerFunction("claves_clientes_mostrador");
	$xajax->registerFunction("claves_clientes_mostrador_pos");
	$xajax->registerFunction("productos_clientes_mostrador");
	$xajax->registerFunction("productos_clientes_mostrador_pos");
	$xajax->registerFunction("finaliza_nota");
	$xajax->registerFunction("factura_pos");
	$xajax->registerFunction("finaliza_factura_pos");
	$xajax->registerFunction("factura_dia");
	$xajax->registerFunction("corte_caja");
	$xajax->registerFunction("cancela_nota");
	$xajax->registerFunction("resumen_notas_ventas");
	$xajax->registerFunction("pos_ventas_agente");
	$xajax->registerFunction("nueva_cotizacion_pos");
	$xajax->registerFunction("rfc_nombre_clientepos");
	$xajax->registerFunction("venta_dia");
	$xajax->registerFunction("ver_detalle");
	$xajax->registerFunction("detalle_nota");
	$xajax->registerFunction("resumen_total_venta");
	$xajax->registerFunction("gastos");
	$xajax->registerFunction("debe");
	//extras
	$xajax->registerFunction("consulta_precios");
	$xajax->registerFunction("claves_consulta_productos");
	//reportes
	$xajax->registerFunction("reporte_ventas_x_unidad");
	$xajax->registerFunction("reporte_saldos");
	
	$xajax->processRequests();
	
	$ResSucursal=mysql_query("SELECT Nombre, Iva, IniciarEn FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' AND Empresa='".$_SESSION["empresa"]."' LIMIT 1");
	$RResSucursal=mysql_fetch_array($ResSucursal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>GREEN STORE - Sistema de Administración de Tienda</title>
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
<body onload="mueveReloj();<?php if($RResSucursal["IniciarEn"]=='ventadia'){echo 'xajax_venta_dia()';}elseif($RResSucursal["IniciarEn"]=='notaventa'){echo 'xajax_nota_nueva()';}?>">
<div id="menuizq" style="position: absolute; width:120px; left: 10px; top: 60px "></div>
<div id="top" style="width:100%; height: 81px; background-color: #4db6fc;">
<div id="bienvenida" style="position: absolute; width: 100%; left:0px; padding: 0 25 0 0px;"><p align="right" class="texto2">Bienvenid@ <?php echo utf8_encode($_SESSION["nombreuser"]);?></p></div>
<div id="empresa" style="position: absolute; width: 1000px; left:0px; z-index:2;">
<?php $ResEmpresa=mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);

$_SESSION["iva"]=$RResSucursal["Iva"];
?>
<p align="left" class="texto2"><?php echo utf8_encode($RResEmpresa["Nombre"]).' Suc. '.utf8_encode($RResSucursal["Nombre"]);?> - 2012</p></div>
</div>
<div id="cuadro" style="width:100%; background-color: #FFFFFF; border: 1px solid #8c5816; position: absolute; top: 40px; left:0px;">
	<div id="menutop" style="width:100%; height: 40px; background-color: #a19aaa; position: absolute; top: 0px; padding: 0 10 5 10px; z-index:1000;">
		<ul>
				<li><a href="#" onclick="<?php echo activapermisos('xajax_venta_dia()', 'pos-');?>">&raquo; POS</a>
					<ul>
						<li><a href="#" onclick="xajax_venta_dia()">Venta del D&iacute;a</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_nota_nueva()', 'posnotv-');?>">Nota de Venta</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_factura_pos()', 'posfac-');?>">Factura</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_corte_caja()', 'poscorc-');?>">Corte de Caja</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_gastos()','posgas-');?>">Gastos</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_debe()','posdebe-');?>">Debe(pago de adeudos)</a></li>
						<li><hr></hr></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_resumen_notas_ventas()', 'posrenva-');?>">Resumen Notas de Venta</a></li>
						<li><hr></hr></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_resumen_total_venta()', 'posresven-');?>">Resumen Total de Venta</a></li>
					</ul>
				</li>
				<?php if($RResSucursal["IniciarEn"]=='ventadia'){echo '<li><a href="#" onclick="'.activapermisos('xajax_venta_dia()', 'pos-').'">&raquo; Venta del D&iacutea</a></li>';}
					elseif($RResSucursal["IniciarEn"]=='notaventa'){echo '<li><a href="#" onclick="'.activapermisos('xajax_nota_nueva()', 'posnotv-').'">&raquo; Nota de Venta</a></li>';}?>
				<!--<li><a href="#" onclick="<?php echo activapermisos('xajax_clientes()', 'cli-');?>">&raquo; Clientes</a>
					<ul>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_lista_ordenes_venta()', 'cliordv-');?>">Ordenes de Venta</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_facturacion_cliente()', 'clifac-');?>">Facturacion</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_factura_libre()', 'clifacl-');?>">Factura Libre</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_facturas()', 'clifacs-');?>">Facturas</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_aplica_pagos_clientes()', 'cliaplp-');?>">Aplicar Pagos</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_reporte_pagos_clientes()', 'clirepp-');?>">Reporte Pagos</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_cobro_agente()', 'clirepca');?>">Reporte Cobro Agente</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_venta_agente()', 'clirepva');?>">Reporte Ventas Agente</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_ventas()', 'cliven-');?>">Ventas</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_reporte_mensual()', 'clirepm-');?>">Reporte Mensual</a></li>
						<li><hr></hr></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_nota_credito()', 'clinc-');?>">Nueva Nota de Credito</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_ver_notas_credito()', 'clivnc-');?>">Ver Notas de Credito</a></li>
						<li><hr></hr></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_cotizaciones()', 'clicots-');?>">Cotizaciones</a></li>
					</ul>
				</li>  -->
				<li><a href="#" onclick="<?php echo activapermisos('xajax_provedores()', 'prov-');?>">&raquo; Provedores</a>
					<ul>
						<!--  <li><a href="#" onclick="<?php echo activapermisos('xajax_compra_provedor()', 'provordc-');?>">Ordenes de Compra</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_revisiones()', 'provrev-');?>">Revisiones / Orden de Compra</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_cuentas_pagar()', 'provcuep-');?>">Cuentas Por Pagar</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_aplica_pagos()', 'provaplp-');?>">Aplicar Pagos</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_reporte_pagos()', 'provrepp-');?>">Reporte Pagos</a></li>-->
					</ul>
				</li>
				<li><a href="#" onclick="<?php echo activapermisos('xajax_productos()', 'prod-');?>">&raquo; Productos</a>
					<ul></ul>
				</li>
				<li><a href="#" onclick="<?php echo activapermisos('xajax_inventario()', 'alm-');?>">&raquo; Almacen</a>
					<ul>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_inventario_inicial()', 'alminvi-');?>">Inventario Inicial</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_ajustes_inventario()', 'almajui-');?>">Ajustes al Inventario</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_ingresa_mercancia()', 'almingm-');?>">Ingresar Mercancia</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_traslado_almacen()', 'almtram-');?>">Traslado de Mercancia</a></li>
						<li><a href="#" onclick="<?php echo activapermisos('xajax_reportes_almacen()', 'almrep-');?>">Reportes</a></li>
					</ul>
				</li>
				<!--  <li><a href="#">&raquo; Reportes</a>
					<ul>
						<li><a href="#" onclick="xajax_reporte_ventas_x_unidad()">Ventas por Unidades</a></li>
						<li><a href="#" onclick="xajax_reporte_saldos()">Saldos Clientes</a></li>
					</ul>-->
				<li><a href="#">&raquo; Administrador</a>
					<ul>
					<li><a href="#" onclick="<?php echo activapermisos('xajax_empresas()', 'admemp-');?>">Empresa</a></li>
					<li><a href="#" onclick="<?php echo activapermisos('xajax_usuarios()', 'admusu-');?>">Usuarios</a></li>
					<!--  <li><a href="#" onclick="<?php echo activapermisos('xajax_agentes()', 'admage-');?>">Agentes</a></li>
					<li><a href="#" onclick="<?php echo activapermisos('xajax_bancos()', 'admban-');?>">Bancos</a></li>
					<li><a href="#" onclick="<?php echo activapermisos('xajax_tipo_cambio()', 'admtc-');?>">Tipo de Cambio</a></li>-->
					</ul>
				</li>
				<li><a href="logout.php">&raquo; Salir</a>
					<ul></ul>
				</li>
			</ul>
			<form name="form_reloj"><input type="text" name="reloj" id="reloj" size="5" class="input"></form>
	</div>
	 
	
	<div id="lightbox" style="position: absolute; top:70px; left:100px; width:800px; padding: 10 10 10 10px; z-index:100; visibility:hidden;"></div>
	<div id="contenido" style="position: absolute; top:50px; left:25px; width:950px; padding: 10 10 10 10px; text-align: center;">
	<!-- Aqui va el contenido -->

	
	</div>
</div>
</body>
</html>

