<?php

	$username = $HTTP_POST_VARS["usuario"];
	$password = $HTTP_POST_VARS["pass"];
	
//conecto con la base de datos 
include('conexion.php');

//Sentencia SQL para buscar un usuario con esos datos 
$ssql = "SELECT * FROM usuarios WHERE Username='".$_POST["usuario"]."' and Contrasena='".$_POST["pass"]."'"; 

//Ejecuto la sentencia 
$rs = mysql_query($ssql); 

//vemos si el usuario y contraseña es váildo 
//si la ejecución de la sentencia SQL nos da algún resultado 
//es que si que existe esa conbinación usuario/contraseña 
if (mysql_num_rows($rs)!=0){ 
    //usuario y contraseña válidos 
    $Rowrs=mysql_fetch_array($rs);
    //defino una sesion y guardo datos 
    session_start(); 
    //session_register("autentificado"); 
    $_SESSION["autentificado"]="SI"; 
    $_SESSION["nombreuser"] = $Rowrs["Nombre"];
	$_SESSION["perfil"] = $Rowrs["Perfil"];
	$_SESSION["idusuario"] = $Rowrs["Id"];
    $_SESSION["sadmon"] = $Rowrs["sadmon"];
 //    sesion_register("usuario");
//    $usuario = $username;
	if($_POST["pass"]=='12345678')
	{
		header ("Location: principal2.php");
	}
	else 
	{
    header ("Location: principal.php"); 
	}
}else { 
    //si no existe le mando otra vez a la portada 
    header("Location: index.php"); 
} 
mysql_free_result($rs); 
mysql_close($conn); 
?> 
