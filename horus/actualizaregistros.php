<?php
include ("conexion.php");

$ResProductos=mysql_query("SELECT Id FROM productos WHERE Empresa='1' AND Sucursal='1' ORDER BY Id ASC");
while($RResProductos=mysql_fetch_array($ResProductos))
{
	mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Ajuste)
																	VALUES ('1_1_PRINCIPAL',
																					'".$RResProductos["Id"]."',
																					'Entrada',
																					'100',
																					'2012-09-13',
																					'II')");
}
echo "Ready !!";

?>