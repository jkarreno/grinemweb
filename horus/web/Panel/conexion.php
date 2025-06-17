<?php
//Conexion con la base
$conn = mysql_connect("localhost","root","");
//selecciono la BBDD 
mysql_select_db("pillar",$conn); 
//
//$conn=mysql_connect ("localhost", "grinemc_pillar",
//"pillar") or die('Cannot connect to the database because: ' . mysql_error());
//mysql_select_db ("grinemc_pillar", $conn);

?>