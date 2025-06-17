<?php	

//Inicio la sesi�n 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: index.html"); 
    //ademas salgo de este script 
    exit();  
} 

require ('xajax/xajax.inc.php');

include ("Productos/funcionesproductos.php");
include ("Usuarios/funcionesusuarios.php");
include ("TipoCambio/funcionestipocambio.php");
include ("Configuracion/funciionesconfiguracion.php");
include ("Documentos/funcionesdocumentos.php");

$xajax = new xajax(); 
	
	//menus
	$xajax->registerFunction("menuproductos");
	$xajax->registerFunction("menu_usuarios");
	$xajax->registerFunction("menuconfiguracion");
	//productos
	$xajax->registerFunction("adproductos");
	$xajax->registerFunction("adproductos_2");
	$xajax->registerFunction("modificaproducto");
	$xajax->registerFunction("modificaproducto_2");
	$xajax->registerFunction("modificaproducto_3");
	$xajax->registerFunction("eliminaproducto");
	$xajax->registerFunction("eliminaproducto_2");
	$xajax->registerFunction("linea");
	//usuarios
  $xajax->registerFunction("lista_usuarios");
  //Tipo de Cambio
  $xajax->registerFunction("tipodecambio");
  //Configuracion
  $xajax->registerFunction("marcas");
  $xajax->registerFunction("menuizq");
  $xajax->registerFunction("menuizq_adcat");
  $xajax->registerFunction("menuizq_adcat_2");
  $xajax->registerFunction("menuizq_adsubcat");
  $xajax->registerFunction("menuizq_adsubcat_2");
  $xajax->registerFunction("modificamarca");
  $xajax->registerFunction("modificamarca_2");
  $xajax->registerFunction("generapagina");
  $xajax->registerFunction("generapagina_2");
  $xajax->registerFunction("modificapagina");
  $xajax->registerFunction("modificapagina_2");
  //Documentos
  $xajax->registerFunction("menu_documentos");
  $xajax->registerFunction("addocumentos");
   
	$xajax->processRequests();
?>
<html>
<head>
<title>Pillar Mexicana S. A. de C. V.</title>

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="js/codigo.js"></script>
<script type="text/javascript" src="http://127.0.0.1/tinymce/3_1_1/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
      mode : "textareas",
      theme : "simple"
   });
</script> 
<?php $xajax->printJavascript('xajax/'); ?>
<style type="text/css">
/* Capas  */
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #00548E;
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
</style>

</head>
<body>
<center><div id="central">
<div id="header">
		<table border="0" cellpadding="0" cellspacing="0" align="right">
			<tr>
				<td width="247" align="right" class="texto">
				<?php 
				include ("conexion.php");
				$ResUsuario=mysql_query("SELECT Nombre FROM usuarios WHERE Usuario='".$_SESSION["usuario"]."'");
				$RResUsuario=mysql_fetch_array($ResUsuario);
				echo 'Bienvenido: '.$RResUsuario["Nombre"].'&nbsp;<br />
							&nbsp;<br />
							<img src="images/calendar/'.date("m").'_'.date("d").'.png">';
				?>
				</td>
			</tr>
		</table>
	</div>
<?php

include("menuprincipal.php");
?>
</div>
</body>
</html>