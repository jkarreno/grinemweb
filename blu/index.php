<?php 
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] == "SI") { 
    //si no existe, envio a la pï¿½gina de autentificacion 
    header("Location: principal.php"); 
    //ademas salgo de este script 
    exit(); 
} 



switch($_GET["mensaje"])
{
	case 1: $mensaje="La empresa no corresponte con el usuario o los datos no son validos";break;
	case 2: $mensaje="El Usuario y/o contraseña no son validos"; break;  
}


include ("conexion.php");

?>
<html>
<head>
<title>Sistema de Control de Pagos</title>
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="top" style="width: 1366px; height: 50px; background-color: #5263ab;">
</div>

<div id="cuadro" style="width:100%; height: 100%; background-color: #FFFFFF; border: 0px solid #008001; position: absolute; top: 25px; left:0px;">
	<div id="menutop" style="width:100%; height: 24px; background-color: #a19aaa; position: absolute; top: 0px;"></div>
	<div id="contenido" style="position: absolute; top:24px; left:0px; width:100%; height: 100%; padding: 50 600 10 10px;">
	<p class="textomensaje" align="center"><?php echo $mensaje;?></p>
	<div id="login" style="position: absolute; top: 50px; left: 50px; width:300px;">
		<b class="b1h"></b><b class="b2h"></b><b class="b3h"></b><b class="b4h"></b>
    <div class="headh">
        <h3 align="center" class="textotit">Ingrese a Sistema</h3>
    </div>
    <div class="contenth">
        <div>
        	<table border="0" cellpadding="3" cellspacing="0" align="center" width="80%">
        	<form name="flogin" id="flogin" method="POST" action="validausuario.php">
         	<tr>
         		<td class="texto" align="left" style="border:0px;">Usuario: </td>
         		<td class="texto" algin="left" style="border:0px;"><input type="text" name="usuario" id="usuario" class="input"></td>
         	</tr>
         	<tr>
         		<td class="texto" align="left" style="border:0px;">Contrase&ntilde;a: </td>
         		<td class="texto" align="left" style="border:0px;"><input type="password" name="pass" id="pass" class="input"></td>
         	</tr>
         	<tr>
         		<th colspan="2" align="center"><a href="#" class="button orange"  onClick="document.forms.flogin.submit();return false">Ingresar >></a></th>
         	</tr></form>
         </table>
        </div>
    </div>
<b class="b4bh"></b><b class="b3bh"></b><b class="b2bh"></b><b class="b1h"></b>
	</div>
	</div>
</div>
</body>
</html>