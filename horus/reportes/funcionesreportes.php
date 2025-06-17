<?php
function reporte_ventas_x_unidad($cliente=NULL)
{
	include ("conexion.php");
	
	//Reporte de movimientos de Inventario
	$cadena.='<form name="frepvpu" id="frepvpu" method="POST" action="reportes/repvpu.php" target="_blank">
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte De Venta de Producto por Unidad</th>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Cliente: </td>
							<td colspan="3" bgcolor="#7abc7a" align="left" class="texto"><select name="cliente" id="cliente" onchange="xajax_reporte_ventas_x_unidad(this.value)">
								<option value="%">Todos</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($cliente==$RResClientes["Id"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>s';
	}
	$cadena.='		</select> 
									</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Unidad: </td>
							<td bgcolor="#7abc7a" align="left" class="texto"><select name="unidad" id="unidad"><option value="%">Todas</option>';
	$ResUnidad=mysql_query("SELECT * FROM unidades_cliente WHERE Cliente='".$cliente."' ORDER BY Nombre ASC");
	while($RResUnidad=mysql_fetch_array($ResUnidad))
	{
		$cadena.='<option value="'.$RResUnidad["Id"].'">'.$RResUnidad["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Producto: </td>
							<td bgcolor="#7abc7a" align="left" class="texto"><select name="producto" id="producto"><option value="%">Todos</option>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$cadena.='<option value="'.$RResProductos["Id"].'">'.$RResProductos["Clave"].' - '.$RResProductos["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Periodo: </td>
							<td bgcolor="#7abc7a" align="left" class="texto">De: <select name="diai" id="diai"><option value="01">Dia</option>';
	for($j=1; $j<=31; $j++)
	{
		if($j<=9){$j='0'.$j;}
		$cadena.='<option value="'.$j.'">'.$j.'</option>';
	}
	$cadena.='</select> <select name="mesi" id="mesi">
							<option value="01">Mes</option>
							<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select> <select name="annoi" id="annoi"><option value="2011">Año</option>';
	for($t=2011; $t<=date("Y");$t++)
	{
		$cadena.='<option value="'.$t.'">'.$t.'</option>';
	}
	$cadena.='</select> Hasta: <select name="diaf" id="diaf"><option value="'.date("d").'">Dia</option>';
	for($j=1; $j<=31; $j++)
	{
		if($j<=9){$j='0'.$j;}
		$cadena.='<option value="'.$j.'">'.$j.'</option>';
	}
	$cadena.='</select> <select name="mesf" id="mesf">
							<option value="'.date("m").'">Mes</option>
							<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select> <select name="annof" id="annof"><option value="'.date("Y").'">Año</option>';
	for($t=2011; $t<=date("Y");$t++)
	{
		$cadena.='<option value="'.$t.'">'.$t.'</option>';
	}
	$cadena.='</select> </td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Documento: </td>
							<td bgcolor="#7abc7a" align="left" class="texto"><input type="radio" name="documento" id="documento" value="factura"> Factura <input type="radio" name="documento" id="documento" value="ordenv"> Orden de Venta</td>
						</tr>
						<tr>
							<td colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<input type="submit" name="botrepvpu" id="botrepvpu" value="Mostrar>>" class="boton">
							</td>
						</tr>
					</table>
					</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function reporte_saldos()
{
	include ("conexion.php");
	
	//Reporte de Saldos
	$cadena.='<form name="frepvpu" id="frepvpu" method="POST" action="reportes/repsaldos.php" target="_blank">
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte De Saldos Por Cliente</th>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Cliente: </td>
							<td colspan="3" bgcolor="#7abc7a" align="left" class="texto"><select name="cliente" id="cliente">
								<option value="%">Todos</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($cliente==$RResClientes["Id"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>s';
	}
	$cadena.='		</select> 
									</td>
						</tr>
						<tr>
							<td colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<input type="submit" name="botrepsaldos" id="botrepsaldos" value="Mostrar>>" class="boton">
							</td>
						</tr>
						</table></form>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>