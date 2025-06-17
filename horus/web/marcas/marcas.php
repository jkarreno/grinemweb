<?php

	include ("conexion.php");
	
	$ResMarca=mysql_query("SELECT * FROM marcas WHERE Consecutivo='".$_GET["marca"]."'");
	$RResMarca=mysql_fetch_array($ResMarca);	
	
	echo $_GET["marca"].'<p align="right"><img src="images/'.$RResMarca["Logo"].'">
	<p align="left" class="textox">'.$RResMarca["Nombre"].'
	<p align="left" class="textox">'.$RResMarca["Desc_corta"].'
	<p align="left" class="textox">'.htmlentities($RResMarca["Desc_larga"]).'
	<p align="left" class="textox">'.$RResMarca["Productos"];
	

?>