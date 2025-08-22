<?php

	$username = $HTTP_POST_VARS["usuario"];
	$password = $HTTP_POST_VARS["pass"];
	
//conecto con la base de datos 
include('conexion.php');

//Sentencia SQL para buscar un usuario con esos datos 
$ssql = "SELECT * FROM usuarios WHERE Username='".$_POST["usuario"]."' and Contrasena='".$_POST["pass"]."'"; 

//Ejecuto la sentencia 
$rs = mysql_query($ssql); 

//vemos si el usuario y contrase�a es v�ildo 
//si la ejecuci�n de la sentencia SQL nos da alg�n resultado 
//es que si que existe esa conbinaci�n usuario/contrase�a 
if (mysql_num_rows($rs)!=0){ 
    //usuario y contrase�a v�lidos 
    $Rowrs=mysql_fetch_array($rs);
    //defino una sesion y guardo datos 
    session_start(); 
    //session_register("autentificado"); 
    $_SESSION["autentificado"]="SI"; 
    $_SESSION["nombreuser"] = $Rowrs["Nombre"];
	$_SESSION["perfil"] = $Rowrs["Perfil"];
	$_SESSION["idusuario"] = $Rowrs["Id"];
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
