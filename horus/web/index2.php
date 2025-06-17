<?php

//Inicio la sesi�n 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    //$mensajebienvenida='Bienvenido '.$_SESSION["Nombre"]; 
    //ademas salgo de este script 
    //exit();  
} 
else 
{
	$mensajebienvenida='Bienvenido '.htmlentities($_SESSION["Nombre"]);
}

include ("conexion.php");

require ('xajax/xajax.inc.php');

include ("buscador/funcionesbuscador.php");
include ("funciones.php");

	$xajax = new xajax(); 
	
	//buscador
	$xajax->registerFunction("buscador");
	$xajax->registerFunction("principal");
	//registro
	$xajax->registerFunction("registro");
	//menu izquierdo
	$xajax->registerFunction("menu_left");
	//marcas
	$xajax->registerFunction("detalles_marca");
	$xajax->registerFunction("marcas");
		//quejas
	$xajax->registerFunction("quejas");
	$xajax->registerFunction("quejas_2");
	//productos
	$xajax->registerFunction("productos");
	$xajax->registerFunction("productos_linea");
	//paginas
	$xajax->registerFunction("vepagina");
	
	$xajax->processRequests();

?>
<html>
<head>
<title>Pillar Mexicana S. A. de C. V.</title>

<script language="JavaScript" type="text/javascript" src="js/codigo.js"></script>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
/* Capas  */
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #00548E;
	background-image: url(images/fondogral2.png);
}


#central {
	position:relative;
	left:0px;
	margin-left:auto;
  top:0px;
	width:984px;
	margin: 0px auto; /* centrar con firefox */
	text-align:center; /* centra las capas con internet explorer */
	z-index: 1; 
}

#header {
	width:984px;
	height:161px;
	background-image: url(images/fondocabecera.jpg);
	background-repeat: no-repeat;
	z-index: 2; 
}

#bienvenida {
	position: absolute;
	width: 800px;
	height: 20px;
	top: 0px;
	z-index: 14;
	text-align: right;
}

#centro { /* no cambiar */
	width:984px;
	height:630px;
	background-image: url(images/fondocentral.jpg);
	z-index: 3; 
}

#piecera {
	width:984px;
	height:101px;
	background-image: url(images/fondofoot.jpg);
	background-repeat: no-repeat;
	z-index: 4; 
}
#tipo{
	position:absolute;
	left:656 px;
	right:60px;
	top:108px;
	z-index: 5; 
}
#botonproductos a {
	position:absolute;
	width:102px;
	height:30px;
	left:314px;
	right:570px;
	top:130px;
	background: url(images/boton1.png) left top;
	z-index: 6;
	vertical-align: middle;
	text-decoration: none;
	font-family: Verdana;
	color: #00548E;
	font-weight: bold;
	font-size: 10px; 
}

#botonproductos a:hover { background: url(images/boton1.png) left 40px;}

#botonmarcas a {
	position:absolute;
	width:102px;
	height:41px;
	left:416px;
	top:130px;
	text-align: center;
	display: table-cell;
	vertical-align: middle;
	background-image: url(images/boton1.png);
	z-index: 6;
	vertical-align: middle;
	text-decoration: none;
	font-family: Verdana;
	color: #00548E;
	font-weight: bold;
	font-size: 10px; 
}

#botonmarcas a:hover { background: url(images/boton1.png) left 40px;}

#botonquienes a {
	position:absolute;
	width:102px;
	height:41px;
	left:518px;
	top:130px;
	text-align: center;
	vertical-align: middle;
	background-image: url(images/boton1.png);
	z-index: 6;
	vertical-align: middle;
	text-decoration: none;
	font-family: Verdana;
	color: #00548E;
	font-weight: bold;
	font-size: 10px; 
}

#botonquienes a:hover { background: url(images/boton1.png) left 40px;}

#botonregistro a {
	position:absolute;
	width:102px;
	height:41px;
	left:620px;
	top:130px;
	text-align: center;
	vertical-align: middle;
	background-image: url(images/boton1.png);
	z-index: 6;
	vertical-align: middle;
	text-decoration: none;
	font-family: Verdana;
	color: #00548E;
	font-weight: bold;
	font-size: 10px; 
}

#botonregistro a:hover { background: url(images/boton1.png) left 40px;}

#botondistribuidores a {
	position:absolute;
	width:102px;
	height:41px;
	left:722px;
	top:130px;
	text-align: center;
	vertical-align: middle;
	background-image: url(images/boton1.png);
	z-index: 6;
	vertical-align: middle;
	text-decoration: none;
	font-family: Verdana;
	color: #00548E;
	font-weight: bold;
	font-size: 10px; 
}

#botondistribuidores a:hover { background: url(images/boton1.png) left 40px;}

#botoncontacto a {
	position:absolute;
	width:102px;
	height:41px;
	left:824px;
	top:130px;
	text-align: center;
	vertical-align: middle;
	background-image: url(images/boton1.png);
	z-index: 6;
	vertical-align: middle;
	text-decoration: none;
	font-family: Verdana;
	color: #00548E;
	font-weight: bold;
	font-size: 10px; 
}

#botoncontacto a:hover { background: url(images/boton1.png) left 40px;}

#sitio { /*no cambiar*/
	position: absolute;
	width: 872px;
	height: 620px;
	top: 160px;
	left: 53px;
	z-index: 7;
	background-color: #FFFFFF;
}
#menu { /*no cambiar */
	position: absolute;
	width: 253px;
	height: 420px;
	left: 63px;
	top: 350px;
	background-color: #00548E;
	z-index:8;
}
#menu2 { /*no cambiar */
	position: absolute;
	width: 245px;
	height: 352px;
	left: 67px;
	top: 353px;
	background-color: #00548E;
	z-index:9;
}
#contenido { /*no cambiar */
	text-align: left;	
	position: absolute;
	width: 600px;
	height: 400px;
	left: 320px;
	top: 350px;
	background-color: #FFFFFF;
	z-index:10;
	overflow: auto;
}
#destacados {
  position: relative;
	width: 293px;
	height: 400px;
	text-align:justify;
  background-image: url(images/prd_destacados.jpg);
  background-repeat: no-repeat;
  z-index: 11;
}
#novedades {
  position: absolute;
  top: 0px;
  left: 310px;
	width: 283px;
	height: 150px;
  background-image: url(images/novedades.jpg);
  background-repeat: no-repeat;
  z-index: 12;
}
#eventos {
  position: absolute;
  top: 150px;
  left: 310px;
	width: 283px;
	height: 250px;
  background-image: url(images/eventos.jpg);
  background-repeat: no-repeat;
  z-index: 12;
}
#menumarcas {
	position: absolute;
	width: 856px;
	height: 150px;
	top: 160px; /* no cambiar */
	left: 61px;
	z-index: 100;
	visibility: hidden;
	background-image: url(images/fondopantalla.png);
	background-repeat: no-repeat;
}
#botbusca {
	position: absolute;
	width: 45px;
	height: 24px;
	top: 65px;
	left: 880px;
	z-index: 13;
}
#tipocambio {
	position: absolute;
	width: 200px;
	height:20px;
	z-index: 101;
	top: 110px;
	left: 460px;
	text-align: right;
	visibility: hidden;
}
#menutopproductos {
	position: absolute;
	z-index: 200;
	top: 160px;
	left: 315px;
	text-align: left;	
	visibility: hidden;
}
#menutopmarcas {
	position: absolute;
	z-index: 200;
	top: 160px;
	left: 418px;
	text-align: left;	
	visibility: hidden;
}
</style>
<link rel="shortcut icon" href="images/favicon.ico" >
<?php $xajax->printJavascript('xajax/'); ?>
</head>
</head>
<body>
<center><div id="central"><div id="bienvenida"><span class="busqueda"><?php echo $mensajebienvenida; ?></span></div>
	<div id="header">
		<table border="0" cellpadding="0" cellspacing="0" align="right">
			<tr>
				<td width="247" align="right">
					<a href="index.php"><img src="images/bothome.gif" border="0" alt="Inicio"></a>&nbsp;<a href="mailto:info@pillar.com.mx"><img src="images/botmail.gif" border="0" alt="Contacto"></a>
				</td>
				<td width="62">&nbsp;</td>
			</tr>
			<tr>
				<td height="83" width="247" valign="middle" class="busqueda">
				BUSQUEDA<br />
				<div><input type="text" name="palabra" id="palabra" size="30" class="input">&nbsp;<div id="botbusca"><a href="#" onClick="xajax_buscador(document.getElementById('palabra').value)"><img src="images/botbusca.gif" border="0" alt="Buscar"></a></div></div>
				</td>
				<td width="62">&nbsp;</td>
			</tr>
		</table>
		<?php $ResTCambio=mysql_query("SELECT Descripcion FROM parametros WHERE PerteneceA='TipoC' AND Nombre='Dolar'");
		$RResTCambio=mysql_fetch_array($ResTCambio);?>
		<div id="tipocambio"><span class="busqueda">$ <?php echo $RResTCambio["Descripcion"]; ?></span></div>
		<div id="tipo"><a href="#" onmouseover="mostrar('tipocambio')" onmouseout="ocultar('tipocambio')"><img src="images/tipocambio.png" border="0" onmouseover="mostrar('tipocambio')" onmouseout="ocultar('tipocambio')"></a><img src="images/barrita.png" boder="0"><a href="#" onclick="xajax_quejas()"><img src="images/quejas.png" border="0"></a></div>
		<div id="botonproductos" align="center" onmouseover="ocultar('menumarcas')"><a href="#" onmouseover="mostrar('menutopproductos'); ocultar('menutopmarcas')" onclick="xajax_productos()"><br />Productos</a></div>
		<div id="botonmarcas"  align="center" onmouseover="ocultar('menumarcas')"><a href="#" onmouseover="mostrar('menutopmarcas'); ocultar('menutopproductos')" onclick="xajax_marcas()"><br />Marcas</a></div>
		<div id="botonquienes" align="center" onmouseover="ocultar('menumarcas')"><a href="index2.php?contenido=quienes"><br />Qui&eacute;nes Somos</a></div>
		<div id="botonregistro" align="center" onmouseover="ocultar('menumarcas')"><a href="index2.php?contenido=registro"><br />Ingresar</a></div>
		<div id="botondistribuidores" align="center" onmouseover="ocultar('menumarcas')"><a href="index2.php?contenido=distribuidores"><br />Distribuidores</a></div>
		<div id="botoncontacto" align="center" onmouseover="ocultar('menumarcas')"><a href="#"><br />Contacto</a></div>
	</div>
	<div id="menutopproductos">
		<table border="0" cellpadding="0" cellspacing="0" >
		<?php 
			$ResLineas=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE PerteneceA='lineas' ORDER BY Descripcion ASC");
			while ($RResLineas=mysql_fetch_array($ResLineas))
			{
				if($linea!=$RResLineas["Descripcion"])
				{
					echo '<tr class="filaItem0" onmouseover="this.className=\'filaItem1\'" onmouseout="this.className=\'filaItem0\'"><td align="left" height="15">&nbsp;<span class="textoboton"><a href="#" onclick="xajax_productos_linea(\''.$RResLineas["Consecutivo"].'\')">'.htmlentities($RResLineas["Descripcion"]).'</a></span>&nbsp;</td></tr>';
				}
				$linea=$RResLineas["Descripcion"];
			}
		?>
		</table>
	</div>
	<div id="menutopmarcas">
		<table border="0" cellpadding="0" cellspacing="0" width="99">
		<?php 
			$ResMarcas=mysql_query("SELECT Consecutivo, Nombre FROM marcas ORDER BY Nombre");
			while ($RResMarcas=mysql_fetch_array($ResMarcas))
			{
				echo '<tr class="filaItem0" onmouseover="this.className=\'filaItem1\'" onmouseout="this.className=\'filaItem0\'"><td align="left" height="15">&nbsp;<span class="textoboton"><a href="index2.php?contenido=marcas&marca='.$RResMarcas["Consecutivo"].'">'.htmlentities($RResMarcas["Nombre"]).'</a></span>&nbsp;</td></tr>';
			}
		?>
		</table>
	</div>
	<div id="centro"><div id="menumarcas"></div>
		<div id="sitio">
			<div onmouseover="ocultar('menumarcas'); ocultar('menutopmarcas'); ocultar('menutopproductos')"><img src="images/banners/banner1.jpg" border="0"></div>
			<table border="0" cellpadding="0" cellpadding="0" width="100%" align="center" onmousemove="ocultar('menutopproductos')">
				<tr>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=3"><img src="images/logoyaskawa.jpg" onmouseover="this.src='images/logoyaskawa2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('3')"  onmouseout="this.src='images/logoyaskawa.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=2"><img src="images/logoomron.jpg" onmouseover="this.src='images/logoomron2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('2')" onmouseout="this.src='images/logoomron.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=10"><img src="images/logosti.jpg" onmouseover="this.src='images/logosti2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('10')" onmouseout="this.src='images/logosti.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=8"><img src="images/logobeijer.jpg" onmouseover="this.src='images/logobeijer2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('8')" onmouseout="this.src='images/logobeijer.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=9"><img src="images/logomarathon.jpg" onmouseover="this.src='images/logomarathon2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('9')" onmouseout="this.src='images/logomarathon.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=6"><img src="images/logovipa.jpg" onmouseover="this.src='images/logovipa2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('6')" onmouseout="this.src='images/logovipa.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=4"><img src="images/logotectron.jpg" onmouseover="this.src='images/logotectron2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('4')" onmouseout="this.src='images/logotectron.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="index2.php?contenido=marcas&marca=7"><img src="images/logoadvantech.jpg" onmouseover="this.src='images/logoadvantech2.jpg'; mostrar('menumarcas'); xajax_detalles_marca('7')" onmouseout="this.src='images/logoadvantech.jpg'" border="0"></a></td>
				</tr>
			</table>
		</div>
		
	</div>
	<div id="menu"></div>
	<div id="menu2" onmouseover="ocultar('menumarcas'); ocultar('menutopproductos'); ocultar('menutopmarcas')">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
		<?php
		
			$ResCategoria=mysql_query("SELECT Descripcion FROM parametros WHERE Nombre='Categoria' AND PerteneceA='MenuIzq' ORDER BY Consecutivo ASC", $conn);
			$J=1;
			while($RResCategoria=mysql_fetch_array($ResCategoria))
			{
				echo '<tr>
								<td width="9" height="30" bgcolor="#00A0C6"></td>
								<td bgcolor="#00A0C6" height="30" valign="middle" class="titulo1"><a href="#" onclick="xajax_menu_left(\''.$RResCategoria["Descripcion"].'\')">'; if ($J==1){ echo '<img src="images/triang1.png" border="0" align="cbsmiddle" style="float:left;">'; } else { echo '<img src="images/triang2.jpg" border="0" align="cbsmiddle" style="float:left;">'; } echo '&nbsp;'.$RResCategoria["Descripcion"].'</a></td>
								<td width="9" height="30" bgcolor="#00A0C6"></td>
							</tr>';
				if($J==1)
				{
					$ResSubcatego=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE Nombre='".$RResCategoria["Descripcion"]."' AND PerteneceA='MenuIzq' ORDER BY Consecutivo ASC");
					$T=1;
					while($RResSubcatego=mysql_fetch_array($ResSubcatego))
					{
						echo '<tr>
										<td width="9" height="20" bgcolor="#00548E"></td>
										<td bgcolor="#00548E" valign="middle" height="20" class="titulo2">';if ($T>=2){ echo '<hr style="border-style: dotted;">';} echo '<a href="#" onclick="xajax_vepagina(\''.$RResSubcatego["Consecutivo"].'\')"><img src="images/flechita.png" border="0" align="absmiddle">'.$RResSubcatego["Descripcion"].'</a></td>
										<td width="9" height="20" bgcolor="#00548E"></td>
									</tr>';
						
						$T++;
					}
				}
				$J++;
			}
		?>
		</table>
	</div>
	<div id="contenido" onmouseover="ocultar('menumarcas')">
	<?php 
		switch ($_GET["contenido"])
		{
			case 'detproducto':
				include ("detproducto.php");
				break;
			case 'registro':
				include ("registro.php");
				break;
			case 'quienes':
				echo quienes();
				break;
			case 'marcas':
				include('marcas.php');
				break;
			case'eventos':
				include('eventos.php');
				break;
			case'distribuidores':
				include('distribuidores.php');
				break;
			case 'contacto':
				include ("contacto.php");
		}
	?></div>
	<div id="piecera">
		<table border="0" cellpadding="0" cellspacing="0" width="870" align="center" height="101" >
			<tr>
				<td align="center" valign="top" class="direccion">
				CIUDAD DE MEXICO<br />Pillar Mexicana, S. A. de C. V. Av. Revoluci&oacute;n 1315,<br />Col. Campestre San Angel, 01040 M&eacute;xico, D. F., M&eacute;xico.<br />Tel.:5660-5553 Fax: 5651-5573 info@pillar.com.mx				
				</td>
				<td align="center" valign="top" class="direccion">
				MONTERREY<br />Barcelona 2323 Col. Espa&ntilde;a C. P. 64810 Monterrey, N. L.<br />Tel.:8190-1060 Fax 8190-1418
				</td>
				<td align="center" valign="top" class="direccion">
				QUERETARO<br />Playa Roqueta No. 424 Edif. 8-301 Col. Desarrollo San<br />Pablo C. P. 76130 Santiago de Quer&eacute;taro, Quer&eacute;taro
				</td>
			</tr>
		</table>
	</div>
</div></center>
</body>
</html>