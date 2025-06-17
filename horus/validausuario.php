<?php

	$username0 = $_POST["usuario"];//jvarela
	$password0 = $_POST["pass"]; //12345678
	$empresa0 = $_POST["empresa"];//3
	$sucursal0 = $_POST["sucursal"];//4
	
	
//conecto con la base de datos 
include('conexion.php');

//Sentencia SQL para buscar un usuario con esos datos 
$ssql = "SELECT * FROM usuarios WHERE User='$username0' AND Pass='$password0' LIMIT 1"; 

//Ejecuto la sentencia 
$rs = mysql_query($ssql); 

//vemos si el usuario y contrase�a es v�ildo 
//si la ejecuci�n de la sentencia SQL nos da alg�n resultado 
//es que si que existe esa conbinaci�n usuario/contrase�a 
if (mysql_num_rows($rs)!=0)
{ 
	$Rowrs=mysql_fetch_array($rs);
	//validar que sea administrador
	if($Rowrs["Perfil"]!='administrador')
	{
		$perfil = mysql_query("SELECT * FROM usuarios WHERE User='$username0' and Pass='$password0' and Empresa='".$empresa0."' and Sucursal='".$sucursal0."' LIMIT 1");
		$Rperfil=mysql_fetch_array($perfil);
		 
		if($Rperfil["Empresa"]!=$_POST["empresa"] AND $Rperfil["Sucursal"]!=$_POST["sucursal"]) //no es administrador y no es su empresa
  	{
    	header("Location: index.php?mensaje=1");
    }
    else //no es administrador y si es su empresa
    {
		if(($Rperfil["Empresa"]!=$_POST["empresa"] AND $Rperfil["Sucursal"]!=$_POST["sucursal"]) OR ($Rperfil["Empresa"]==$_POST["empresa"] AND $Rperfil["Sucursal"]!=$_POST["sucursal"])) //no es administrador y no es su empresa
		{
    	header("Location: index.php?mensaje=1");
		}
		else
		{
    	//defino una sesion y guardo datos 
    	session_start(); 
    	//session_register("autentificado"); 
    	$_SESSION["autentificado"] = "SI"; 
    	$_SESSION["usuario"] = $Rowrs["Id"];
    	$_SESSION["perfil"] = $Rowrs["Perfil"];
    	$_SESSION["empresa"] = $Rowrs["Empresa"];
    	$_SESSION["nombreuser"]=$Rowrs["Nombre"];
    	$_SESSION["sucursal"]=$Rowrs["Sucursal"];
    	if($Rperfil["Pass"]=='12345678')
    	{
    		header("Location:principal2.php");
    	}
    	elseif($Rperfil["Pass"]!='12345678')
    	{
    		header ("Location: principal.php");
    	}
		}
    } 
	}
	else//si es administrador
	{
		//defino una sesion y guardo datos 
    	session_start(); 
    	//session_register("autentificado"); 
    	$_SESSION["autentificado"] = "SI"; 
    	$_SESSION["usuario"] = $Rowrs["Id"];
    	$_SESSION["perfil"] = $Rowrs["Perfil"];
    	$_SESSION["empresa"] = $Rowrs["Empresa"];
    	$_SESSION["nombreuser"]=$Rowrs["Nombre"];
    	$_SESSION["sucursal"]=$Rowrs["Sucursal"];
    	header ("Location: principal.php");
	}
}
else 
{ 
    //si no existe le mando otra vez a la portada 
  	header("Location: index.php?mensaje=2"); 
} 

//echo $_POST["usuario"].'<br />'.$_POST["pass"].'<br />'.$_POST["empresa"].'<br />'.$_POST["sucursal"].'<br />';
//echo$_SESSION["usuario"].'<br />'.$_SESSION["perfil"].'<br />'.$_SESSION["empresa"].'<br />'.$_SESSION["sucursal"].'<br />'.$_SESSION["nombreuser"];
//aqui termina*/
?> 
