<?php

	$username0 = $_POST["usuario"];
	$password0 = $_POST["pass"];
	
//conecto con la base de datos 
include('conexion.php');

//Sentencia SQL para buscar un usuario con esos datos 
$ssql = "SELECT * FROM usuarios WHERE Usuario='$username0' and Contrasena='$password0' and Perfil='administrador'"; 

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
    session_register("autentificado"); 
    $autentificado = "SI"; 
    $_SESSION["usuario"] = $username0;
    $_SESSION["pas"] = $password0;
    $_SESSION["Nombre"]=$Rowrs["Nombre"];

//    $_SESSION["perfil"] = $Rowrs["Perfil"];

 //   sesion_register("usuario");
    $usuario = $username0;
    header ("Location: principal.php"); 
}else { 
    //si no existe le mando otra vez a la portada 
  	header("Location: index.php"); 
} 
?> 
