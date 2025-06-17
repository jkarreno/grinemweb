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

include ("conexion.php");
include ("funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>SECSA - Sistema de Control Interno</title>
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/menu.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="js/codigo.js"></script>

</head>
<body >
<div id="menuizq" style="position: absolute; width:120px; left: 10px; top: 60px "></div>
<div id="top" style="width:100%; height: 81px; background-color: #287d29;">
<div id="bienvenida" style="position: absolute; width: 1000px; left:0px;"><p align="right" class="texto2">Bienvenid@ <?php echo utf8_encode($_SESSION["nombreuser"]);?></p></div>
<div id="empresa" style="position: absolute; width: 1000px; left:0px; z-index:2;">
<?php $ResEmpresa=mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);
$ResSucursal=mysql_query("SELECT Nombre, Iva FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' AND Empresa='".$_SESSION["empresa"]."' LIMIT 1");
$RResSucursal=mysql_fetch_array($ResSucursal);
$_SESSION["iva"]=$RResSucursal["Iva"];
?>
<p align="left" class="texto2"><?php echo utf8_encode($RResEmpresa["Nombre"]).' Suc. '.utf8_encode($RResSucursal["Nombre"]);?></p></div>
</div>
<div id="cuadro" style="width:1000px; background-color: #FFFFFF; border: 1px solid #008001; position: absolute; top: 40px; left:0px;">
	<div id="menutop" style="width:100%; height: 40px; background-color: #3c843d; position: absolute; top: 0px; padding: 0 10 5 10px; z-index:1000;">
		
			
	</div>
	 
	
	<div id="lightbox" style="position: absolute; top:70px; left:100px; width:800px; padding: 10 10 10 10px; z-index:100; visibility:hidden;"></div>
	<div id="contenido" style="position: absolute; top:50px; left:25px; width:950px; padding: 10 10 10 10px; text-align: center;">
	 <!-- Aqui va el formulario -->
	 <?php 
	 
	 if(!$_POST["pass"])
	 {?>
	 <form name="fupdatepass" id="fupdatepass" method="POST" action="principal2.php">
	 <table border="0" cellpadding="3" cellspacing="0" align="center" >
	 	<tr>
			<td colspan="2" class="textomensaje" align="center">Por favor actualice su contrase&ntilde;a</td>
   	<tr>
     	<td class="texto" align="left">Seleccione Contrase&ntilde;a: </td>
    	<td class="texto" align="left"><input type="password" name="pass" id="pass" class="input"></td>
    </tr>
    <tr>
       <td colspan="2" align="center">
       	<a href="#" class="button orange"  onClick="document.forms.fupdatepass.submit();return false">Ingresar >></a>
       </td>
    </tr>
   </table>
   </form>
   <?php 
	 }
	 else
	 {
	 	mysql_query("UPDATE usuarios SET Pass='".$_POST["pass"]."' WHERE Id='".$_SESSION["usuario"]."'") or die(mysql_error());
	 	
	 	echo '<p class="textomensaje">Se actualizo su contrase&ntilde;a satisfactoriamente, es necesario volver a ingresar</p>
	 				<p><a href="logout.php" class="button orange">Salir >></a>';
	 }
	 ?>
        
	
	

	
	</div>
</div>
</body>
</html>

