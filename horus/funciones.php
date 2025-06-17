<?php
function fecha($fecha)
{
	switch($fecha[5].$fecha[6])
	{
		case '01'; $mes='Enero'; break;
		case '02'; $mes='Febrero'; break;
		case '03'; $mes='Marzo'; break;
		case '04'; $mes='Abril'; break;
		case '05'; $mes='Mayo'; break;
		case '06'; $mes='Junio'; break;
		case '07'; $mes='Julio'; break;
		case '08'; $mes='Agosto'; break;
		case '09'; $mes='Septiembre'; break;
		case '10'; $mes='Octubre'; break;
		case '11'; $mes='Noviembre'; break;
		case '12'; $mes='Diciembre'; break;
	}
	
	$fechanew=$fecha[8].$fecha[9].' - '.$mes.' - '.$fecha[0].$fecha[1].$fecha[2].$fecha[3];
	
	return $fechanew;
}

function activapermisos($link, $opcion)
{
	include ("conexion.php");
	
	$ResPermiso=mysql_query("SELECT Permisos FROM usuarios WHERE Id='".$_SESSION["usuario"]."'");
	$RResPermiso=mysql_fetch_array($ResPermiso);
	
	if(ereg($opcion, $RResPermiso["Permisos"]))
	{
		return $link;
	}
	else 
	{
		return '#';
	}

}

function consulta_precios()
{
	include ("conexion.php");
	
//alerta tipo de cambio
	$ResTipoCambio=mysql_query("SELECT Id FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1");
	
	if(mysql_num_rows($ResTipoCambio)==0)
	{
		$cadena.='<p class="textomensaje" align="center"><img src="images/warning.png" border="0"> No se ha ingresado el tipo de cambio del dia</p>';
	}
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <form name="fnotaventa" id="fnotaventa">
						<tr>
								<td colspan="5" align="center" bgcolor="#287d29" class="texto3">Consulta de Productos</td>
							</tr>
							<tr>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Precio Publico 1</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Precio Publico 2</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Precio Publico 3</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_consulta_productos(this.value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_productos_clientes_mostrador_pos(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="precio2" id="precio2" size="10" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="precio3" id="precio3" size="10" class="input"></td>
						 	</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function claves_consulta_productos($clave)
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
						</tr>';
	
	$ResClaves=mysql_query("SELECT Id, Clave, Nombre, PrecioPublico, PrecioPublico2, PrecioPublico3 FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		
			$clave=$RResClaves["Clave"];
			if($RResClaves["Moneda"]=='MN'){$precio1=$RResClaves["PrecioPublico"]; $precio2=$RResClaves["PrecioPublico2"]; $precio3=$RResClaves["PrecioPublico3"];}
			elseif($RResClaves["Moneda"]=='USD')
			{
				$ResTC=mysql_fetch_array(mysql_query("SELECT * FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1"));
				$precio=$RResClaves["PrecioPublico"]*$ResTC["USD"];
				$precio2=$RResClaves["PrecioPublico2"]*$ResTC["USD"];
				$precio3=$RResClaves["PrecioPublico3"]*$ResTC["USD"];
			}
		
		if($_SESSION["sucursal"]==1){$iva=1.11;}else{$iva=1.16;}
			
		 $cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.precio.value=\''.number_format(($precio*$iva),2).'\'; document.fnotaventa.precio2.value=\''.number_format(($precio2*$iva),2).'\'; document.fnotaventa.precio3.value=\''.number_format(($precio3*$iva),2).'\'; document.fnotaventa.clave.value=\''.$clave.'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.precio.value=\''.number_format(($precio*$iva),2).'\'; document.fnotaventa.precio2.value=\''.number_format(($precio2*$iva),2).'\'; document.fnotaventa.precio3.value=\''.number_format(($precio3*$iva),2).'\'; document.fnotaventa.clave.value=\''.$clave.'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>';
		$cadena.='</tr>';
		
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>