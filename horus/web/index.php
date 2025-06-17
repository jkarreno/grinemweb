<?php
include ("conexion.php");

require ('xajax/xajax.inc.php');

include ("funciones.php");

$xajax = new xajax(); 

//factura electronica
$xajax->registerFunction("factura_clientes");

$xajax->processRequests();
?>
<html>
<head>
<title>Surtidora Electrica del Centro</title>

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
	background-image: url(images/fondogral.png);
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

#centro {
	width:984px;
	height:730px;
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
	left:621px;
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


#botonquienes a {
	position:absolute;
	width:102px;
	height:41px;
	left:723px;
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

#sitio {
	position: absolute;
	width: 872px;
	height: 720px;
	top: 160px;
	left: 53px;
	z-index: 7;
	background-color: #FFFFFF;
}
#menu {
	position: absolute;
	width: 253px;
	height: 420px;
	left: 63px;
	top: 450px;
	background-color: #00548E;
	z-index:8;
}
#menu2 {
	position: absolute;
	width: 245px;
	height: 352px;
	left: 67px;
	top: 453px;
	background-color: #00548E;
	z-index:9;
}
#contenido {
	position: absolute;
	width: 600px;
	height: 400px;
	left: 320px;
	top: 450px;
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
	top: 260px;
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

<?php $xajax->printJavascript('xajax/'); ?>
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
		</table>
		
		<div id="tipocambio"><span class="busqueda">$ <?php echo $RResTCambio["Descripcion"]; ?></span></div>
		<div id="tipo"><a href="#" onmouseover="mostrar('tipocambio')" onmouseout="ocultar('tipocambio')"><img src="images/tipocambio.png" border="0" onmouseover="mostrar('tipocambio')" onmouseout="ocultar('tipocambio')"></a><img src="images/barrita.png" boder="0"><a href="#" onclick="xajax_quejas()"><img src="images/quejas.png" border="0"></a></div>
		<div id="botonproductos" align="center"><a href="#" onmouseover="mostrar('menutopproductos'); ocultar('menutopmarcas')" onclick="xajax_productos()"><br />Productos</a></div>
		<div id="botonquienes" align="center"><a href="index2.php?contenido=quienes"><br />Qui&eacute;nes Somos</a></div>
		<div id="botoncontacto" align="center"><a href="index2.php?contenido=contacto"><br />Contacto</a></div>
	</div>
	<div id="menutopproductos">
		<table border="0" cellpadding="0" cellspacing="0" >
		
		</table>
	</div>
	<div id="menutopmarcas">
		<table border="0" cellpadding="0" cellspacing="0" width="99">
		
		</table>
	</div>
	<div id="centro"><div id="menumarcas"></div>
		<div id="sitio">
			<div><embed src="flash/portada.swf" width="856" height="243" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed></div>
			<table border="0" cellpadding="0" cellpadding="0" width="100%" align="center">
				<tr>
					<td align="center" valign="middle"><a href="#"><img src="images/logoschneider.jpg" onmouseover="this.src='images/logoschneider2.jpg';"  onmouseout="this.src='images/logoschneider.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logophilips.jpg" onmouseover="this.src='images/logophilips2.jpg';" onmouseout="this.src='images/logophilips.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logoosram.jpg" onmouseover="this.src='images/logoosram2.jpg';" onmouseout="this.src='images/logoosram.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logolegrand.jpg" onmouseover="this.src='images/logolegrand2.jpg';" onmouseout="this.src='images/logolegrand.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logosteren.jpg" onmouseover="this.src='images/logosteren2.jpg';" onmouseout="this.src='images/logosteren.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logoviakon.jpg" onmouseover="this.src='images/logoviakon.jpg';" onmouseout="this.src='images/logoviakon.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logomagg.jpg" onmouseover="this.src='images/logomagg2.jpg';" onmouseout="this.src='images/logomagg.jpg'" border="0"></a></td>
					<td align="center" valign="middle"><img src="images/separador.jpg"></td>
					<td align="center" valign="middle"><a href="#"><img src="images/logotecnolite.jpg" onmouseover="this.src='images/logotecnolite2.jpg';" onmouseout="this.src='images/logotecnolite.jpg'" border="0"></a></td>
				</tr>
			</table>
		</div>
		
	</div>
	<div id="menu"></div>
	<div id="menu2">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
			<tr><td><img src="images/barrafactelect.jpg" border="0"></td></tr>
			<tr><td class="textomenu"><a href="#" class="textomenu" onclick="xajax_factura_clientes()"><img src="images/flechita.png" border="0"> Clientes</a></td></tr>
			<tr><td><hr style="border:1px dotted white; width:100%" /></td></tr>
			<tr><td class="textomenu"><a href="cliente.html" class="textomenu"><img src="images/flechita.png" border="0"> Provedores</a></td></tr>
			<tr><td><hr style="border:1px dotted white; width:100%" /></td></tr>
		</table>
	</div>
	<div id="contenido">
		<img src="images/bienvenidos.jpg" border="0">
		<table border="0" cellpadding="3" cellspacing="0" width="100%">
			<tr>
				<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</td>
				<td>&nbsp;</td>
				<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</td>
		</table>
	</div>
	<div id="piecera">
		<table border="0" cellpadding="0" cellspacing="0" width="870" align="center" height="101" >
			<tr>
				<td align="center" valign="top" class="direccion">
				CIUDAD DE MEXICO<br />Revillagigedo No. 34 y 36,<br />Col. Centro, 06050 M&eacute;xico, D. F., M&eacute;xico.<br />Tel.:5521-2049 secsa@gruposecsa.com.mx			
				</td>
				<td align="center" valign="top" class="direccion">
				CANCUN<br />Av. Tankah Mza. 11 Lote 13 y 14 Local 1 y 2 <br />Col. Supermanzana 27 C. P. 77509 Quintana Roo.<br />Tel.:(01998)892-4337 secsacancun@prodigy.net.mx
				</td>
				<td align="center" valign="top" class="direccion">
				HIDALGO<br />Av. Cruz Azul No. 25 <br />Col. Centro C. P. 42840 Tula de Allende, Hidalgo
				</td>
			</tr>
		</table>
	</div>
</div></center>
</body>
</html>