<?php
function cotizaciones($limite=0, $status='Pendiente')
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="3" bgcolor="#ffffff" align="left" class="texto">
								Status: <select name="status" id="status">
									<option value="Pendiente"';if($status=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente</option>
									<option value="Cancelada"';if($status=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
									<option value="Vendido"';if($status=='Vendido'){$cadena.=' selected';}$cadena.='>Facturada</option>
								</select> <input type="button" name="botbustatus" id="botbustatus" value="buscar>>" class="boton" onclick="xajax_cotizaciones(\'0\', document.getElementById(\'status\').value)"></th>
							<th colspan="3" bgcolor="#ffffff" align="right" class="texto">| <a href="#" onclick="xajax_nueva_cotizacion()">Nueva Cotizacion</a> |</th>
						</tr>
						<tr>
							<th colspan="6" bgcolor="#287d29" align="center" class="texto3">Cotizaciones</th>
						</tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Num. Cotizacion</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Cliente</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Status</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Modificado Por</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResCotizaciones=mysql_query("SELECT * FROM cotizaciones WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='".$status."' ORDER BY NumCotizacion DESC LIMIT ".$limite.", 25");
	$regs=mysql_num_rows(mysql_query("SELECT Id FROM cotizaciones WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='".$status."'"));
	$J=1; $bgcolor="#7ac37b";
	while($RResCotizaciones=mysql_fetch_array($ResCotizaciones))
	{
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResCotizaciones["Cliente"]."' LIMIT 1"));
		$ResUsuario=mysql_fetch_array(mysql_query("SELECT Nombre FROM usuarios WHERE Id='".$RResCotizaciones["Usuario"]."' LIMIT 1"));
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResCotizaciones["NumCotizacion"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResCliente["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResCotizaciones["Status"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResUsuario["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="clientes/cotizacion.php?idcot='.$RResCotizaciones["Id"].'" target="_blank"><img src="images/print.png" border="0"></a>';
		if($status=='Pendiente' OR $status=='Facturado'){$cadena.='<a href="#" onclick="xajax_cancela_cotizacion(\''.$RResCotizaciones["Id"].'\')"><img src="images/x.png" border="0"></a>';}
		$cadena.='	</td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor="#5ac15b";}
		elseif($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
	}
	$cadena.='	<tr>
								<th colspan="5" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_cotizaciones(\''.$J.'\', \''.$status.'\')">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function nueva_cotizacion($orden=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenventa" id="fordenventa">
					 <table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="7" bgcolor="#287d29" align="center" class="texto3">Cotización</th>
						</tr>
						<tr>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cliente: </td>
							<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><select name="cliente" id="cliente"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"'; if($RResClientes["Id"]==$orden["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
							<td align="left" bgcolor="#7abc7a" class="texto"></td>
							<td align="left" bgcolor="#7abc7a" class="texto">';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC LIMIT 1");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<input type="hidden" name="almacen" id="almacen" value="'.$RResAlmacen["Nombre"].'">';
	}
	$cadena.='		</td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#7abc7a class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$orden["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#7abc7a" class="texto" valign="top">Pedido Num.:</td>
						 	<td algin="left" bgcolor="#7abc7a" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="'.$orden["pedido"].'"></td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Agente: </td>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgente=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgente=mysql_fetch_array($ResAgente))
	{
		$cadena.='<option value="'.$RResAgente["Id"].'"';if($RResAgente["Id"]==$orden["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
							<td align="left" bgcolor="#7abc7a" class="texto">Precio: </td>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">
								<select name="pp" id="pp">
									<option value="PrecioPublico"';if($orden["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($orden["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($orden["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
							</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Total</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="hidden" name="idproducto" id="idproducto" value="">
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_clientes(this.value, document.getElementById(\'cliente\').value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_productos_clientes(this.value, document.getElementById(\'cliente\').value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_nueva_cotizacion(xajax.getFormValues(\'fordenventa\'))"></td>
						 </tr>';
	$bgcolor="#7ac37b"; $i=1; $J=1; $array=array();
	if($orden==NULL)
	{
		$partidas=1;
	}
	elseif($orden!=NULL)
	{
		if($borraprod==NULL)
		{
			//agrega partidas existentes
//			for($J=1; $J<$orden["partidas"];$J++)
//			{
//				$ftotal=str_replace(',','',$orden["total_".$J]);
//				$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["precio_".$J], $ftotal);
//				array_push($array, $arreglo);
//			}
			//Revisa que exista la clave
			$ResCantidad=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"]." FROM inventario WHERE IdProducto='".$orden["idproducto"]."' LIMIT 1"));
			
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0)
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#7abc7a" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$orden["partidas"];
			}
			//Revisa existencia en inventario
	//		else if($ResCantidad[$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"]]>=$orden["cantidad"])
	//		{
				for($J=1; $J<$orden["partidas"];$J++)
				{
					if($orden["idproducto_".$J]==$orden["idproducto"])
					{
						$ftotal=str_replace(',','',$orden["total_".$J])+str_replace(',','',$orden["total"]);
						$arreglo=array($J, $orden["idproducto_".$J], ($orden["cantidad_".$J]+$orden["cantidad"]), $orden["clave_".$J], $orden["precio_".$J], $ftotal);
						array_push($array, $arreglo);
						$agregado=1;
					}
					else
					{
						$ftotal=str_replace(',','',$orden["total_".$J]);
						$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["precio_".$J], $ftotal);
						array_push($array, $arreglo);
					}
				}
				if(!$agregado)
				{
					$ftotal=str_replace(',','',$orden["total"]);
					$arreglo=array($J, $orden["idproducto"], $orden["cantidad"], $orden["clave"], $orden["precio"], $ftotal);
					array_push($array, $arreglo);
					$partidas=count($array)+1;
				}
	//		}
			//no hay existencia
//			else
//			{
//				for($J=1; $J<$orden["partidas"];$J++)
//				{
//					$ftotal=str_replace(',','',$orden["total_".$J]);
//					$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["precio_".$J], $ftotal);
//					array_push($array, $arreglo);
//				}
//				$cadena.='<tr>
//									<th colspan="7" bgcolor="#7abc7a" class="textomensaje">No puede vender un producto sin existencia</th>
//								</tr>';
//				$partidas=$orden["partidas"];
//			}
//			
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$orden["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$orden["total_".$i]);
					$arreglo=array($j, $orden["idproducto_".$i], $orden["cantidad_".$i], $orden["clave_".$i], $orden["precio_".$i], $ftotal);
					array_push($array, $arreglo);
					$j++;
				}
				$i++;
			}
			$partidas=$orden["partidas"]-1;
		}
		
		
		
		
		
		
		//despliega la orden
		for($T=0;$T<count($array);$T++)
		{
			$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$array[$T][1]."' LIMIT 1"));
			$cadena.='<tr>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idproducto_'.$array[$T][0].'" id="idproducto_'.$array[$T][0].'" value="'.$array[$T][1].'">'.$array[$T][0].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="cantidad_'.$array[$T][0].'" id="cantidad_'.$array[$T][0].'" value="'.$array[$T][2].'">'.$array[$T][2].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="clave_'.$array[$T][0].'" id="clave_'.$array[$T][0].'" value="'.$array[$T][3].'">'.$array[$T][3].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResProducto["Nombre"].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="precio_'.$array[$T][0].'" id="precio_'.$array[$T][0].'" value="'.$array[$T][4].'">'.$array[$T][4].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="total_'.$array[$T][0].'" id="total_'.$array[$T][0].'" value="'.$array[$T][5].'">'.$array[$T][5].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto">
							 		<a href="#" onclick="xajax_nueva_cotizacion(xajax.getFormValues(\'fordenventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
			elseif($bgcolor="#5ac15b"){$bgcolor='#7ac37b';}
			
			$subtotal=$subtotal+$array[$T][5];
		}
		
	}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	$iva=$subtotal*$ivaa;
	$cadena.=' <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($subtotal, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Iva '.($ivaa*100).' %: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($iva, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format(($iva+$subtotal), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 	<th colspan="7" bgcolor="#7abc7a" align="center" class="texto">
						 	<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
						 	<input type="hidden" name="cotpos" id="cotpos" value="0">
						 		<input type="button" name="botfincotizacion" id="botonfincotizacion" value="Guardar Cotización>>" class="boton" onclick="xajax_guarda_cotizacion(xajax.getFormValues(\'fordenventa\'))">
						 	</th>
						 </tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_cotizacion($orden)
{
	include ("conexion.php");
	
	//numero de cotización
	$numcot=mysql_fetch_array(mysql_query("SELECT NumCotizacion FROM cotizaciones WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumCotizacion DESC LIMIT 1"));
	
	$numc=$numcot["NumCotizacion"]+1;
	if(mysql_query("INSERT INTO cotizaciones (NumCotizacion, Empresa, Sucursal, Cliente, Fecha, Status, Observaciones, NumPedido, Agente, Usuario, Pos)
																  VALUES ('".$numc."', '".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."',
																  				'".$orden["cliente"]."', '".date("Y-m-d")."', 'Pendiente', '".$orden["observaciones"]."', '".$orden["pedido"]."', '".$orden["agente"]."', '".$_SESSION["usuario"]."', '".$orden["cotpos"]."')"))
	{
		$idcot=mysql_fetch_array(mysql_query("SELECT Id, NumCotizacion FROM cotizaciones WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumCotizacion='".$numc."' LIMIT 1"));
		for($i=1; $i<$orden["partidas"]; $i++)
		{
			mysql_query("INSERT INTO detcotizaciones (idcotizacion, Producto, Clave, Cantidad, PrecioUnitario, SubTotal, Status, Usuario)
																			VALUES ('".$idcot["Id"]."', '".$orden["idproducto_".$i]."', '".$orden["clave_".$i]."',
																							'".$orden["cantidad_".$i]."', '".$orden["precio_".$i]."', '".$orden["total_".$i]."', 'Pendiente', '".$_SESSION["usuario"]."')");
		}
		$mensaje='Se genero la cotizacion numero '.$idcot["NumCotizacion"];
	}
	else
	{
		$mensaje='Ocurrio un problema, intente nuevamente<br />'.mysql_error();
	}
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Cotización</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="center" class="textomensaje"><a href="clientes/cotizacion.php?idcot='.$idcot["Id"].'" target="_blank">Imprimir Cotizacion</a></td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function unidades_cliente($cliente)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	$ResUnidades=mysql_query("SELECT * FROM unidades_cliente WHERE Cliente='".$cliente."' ORDER BY Nombre ASC");
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="xajax_ad_unidades_clientes(\''.$cliente.'\')">Agregar Unidad</a> |</td>
						</tr>
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Unidades del Cliente '.$ResCliente["Nombre"].'</td>
						</tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Nombre</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$bgcolor='#7ac37b'; $A=1;
	while($RResUnidades=mysql_fetch_array($ResUnidades))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$A.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResUnidades["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="#" onclick="xajax_edit_unidades_clientes(\''.$RResUnidades["Id"].'\')"><img src="images/edit.png" border="0"></a> 
									<a href="#" onclick="xajax_delete_unidades_clientes(\''.$RResUnidades["Id"].'\', \''.$cliente.'\')"><img src="images/x.png" border="0"></a>
								</td>
							</tr>';
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ad_unidades_clientes($cliente)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	
	$cadena.='<form name="fadunidad" id="fadunidad">
						<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Unidades del Cliente '.$ResCliente["Nombre"].'</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Unidad: </td>
							<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="nombre" id="nombre" size="50" class="input"></td>
							<td bgcolor="#7abc7a" aling="center" class="texto"><input type="button" name="botadunidad" id="botadunidad" class="boton" value="Agregar>>" onclick="xajax_ad_unidades_clientes_2(xajax.getFormValues(\'fadunidad\'))"></td>
						</tr>
						</table>
						<input type="hidden" name="cliente" id="cliente" value="'.$cliente.'">
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ad_unidades_clientes_2($unidad)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$unidad["cliente"]."' LIMIT 1"));
	
	if(mysql_query("INSERT INTO unidades_cliente (Cliente, Nombre)
																				VALUES ('".$unidad["cliente"]."', '".utf8_decode($unidad["nombre"])."')"))
	{
		$mensaje='Se agrego la Unidad Satisfactoriamente, para regresar click <a href="#" onclick="xajax_unidades_cliente(\''.$unidad["cliente"].'\')">aqui</a>';
	}
	else
	{
		$mensaje='Ocurrio un error, intente nuevamente click <a href="#" onclick="xajax_unidades_cliente(\''.$unidad["cliente"].'\')">aqui</a>';
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Unidades del Cliente '.$ResCliente["Nombre"].'</td>
						</tr>
						<tr>
							<td colspan bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function edit_unidades_clientes($unidad)
{
	include ("conexion.php");
	
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT * FROM unidades_cliente WHERE Id='".$unidad."' LIMIT 1"));
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResUnidad["Cliente"]."' LIMIT 1"));
	
	$cadena.='<form name="feditunidad" id="feditunidad">
						<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Unidades del Cliente '.$ResCliente["Nombre"].'</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="left" class="texto">Unidad: </td>
							<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="nombre" id="nombre" size="50" class="input" value="'.$ResUnidad["Nombre"].'"></td>
							<td bgcolor="#7abc7a" aling="center" class="texto"><input type="button" name="boteditunidad" id="boteditunidad" class="boton" value="Editar>>" onclick="xajax_edit_unidades_clientes_2(xajax.getFormValues(\'feditunidad\'))"></td>
						</tr>
						</table>
						<input type="hidden" name="cliente" id="cliente" value="'.$ResUnidad["Cliente"].'">
						<input type="hidden" name="idunidad" id="idunidad" value="'.$ResUnidad["Id"].'">
						</form>';
		
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function edit_unidades_clientes_2($unidad)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$unidad["cliente"]."' LIMIT 1"));
	
	if(mysql_query("UPDATE unidades_cliente SET Nombre='".utf8_decode($unidad["nombre"])."' WHERE Id='".$unidad["idunidad"]."'"))
	{
		$mensaje='Se actualizo la unidad satisfactoriamente';
	}
	else
	{
		$mensaje='Ocurrio un error, intente nuevamente';
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Unidades del Cliente '.$ResCliente["Nombre"].'</td>
						</tr>
						<tr>
							<td colspan bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function delete_unidades_clientes($unidad, $cliente, $borrar=NULL)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	
	if($borrar=='SI')
	{
		if(mysql_query("DELETE FROM unidades_cliente WHERE Id='".$unidad."'"))
		{
			$mensaje='<p class="textomensaje">Se elimino la Unidad Satisfactoriamente</p>';
		}
		else
		{
			$mensaje='<p class="textomensaje">Ocurrio un error, intente nuevamente</p>';
		}
	}
	else
	{
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT * FROM unidades_cliente WHERE Id='".$unidad."' LIMIT 1"));
		$mensaje='Esta seguro que desea eliminar la Unidad '.$ResUnidad["Nombre"].'?<br /><a href="#" onclick="xajax_delete_unidades_clientes(\''.$unidad.'\', \''.$cliente.'\', \'SI\')">Si</a>     <a href="#" onclick="xajax_unidades_cliente(\''.$cliente.'\')">No</a>';		
	}
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Unidades del Cliente '.$ResCliente["Nombre"].'</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function unidades_cliente_orden($cliente)
{
	include ("conexion.php");
	
	$cadena.='<select name="unidadclie" id="unidadclie"><option>Seleccione</option>';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$cliente."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'">'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("uniclie","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function venta_agente($form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
							<td colspan="7" aling="left" class="texto3" bgcolor="#7abc7a">Reporte de Ventas Por Agente</td>
							</tr>
							<tr>
								<td colspan="7" aling="left" class="texto" bgcolor="#FFFFFF">
									<form name="freppagos" id="freppagos" method="POST" action="clientes/reporteventasagente2.php" target="_blank">
										Cliente: <select name="cliente" id="cliente"><option value="%">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$form["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='				</select> <p>
										Agente: <select name="agente" id="agente"><option value="%">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='AgenteV' AND Descripcion!='Inactivo' ORDER BY Nombre ASC");
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='				<option value="'.$RResAgentes["Id"].'"';if($form["agente"]==$RResAgentes["Id"]){$cadena.=' selected';}$cadena.='>'.$RResAgentes["Nombre"].'</option>';
	}
	$cadena.='				</select> <p>
										Fecha De: <select name="diai" id="diai"><option value="01">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'"';if($form["diai"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesi" id="mesi"><option value="01">Mes</option>
									<option value="01"';if($form["mesi"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
									<option value="02"';if($form["mesi"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
									<option value="03"';if($form["mesi"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
									<option value="04"';if($form["mesi"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
									<option value="05"';if($form["mesi"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
									<option value="06"';if($form["mesi"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
									<option value="07"';if($form["mesi"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
									<option value="08"';if($form["mesi"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
									<option value="09"';if($form["mesi"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
									<option value="10"';if($form["mesi"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
									<option value="11"';if($form["mesi"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
									<option value="12"';if($form["mesi"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
								</select><select name="annoi" id="annoi"><option value="2011">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'"';if($form["annoi"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	} 
	$cadena.='		</select> A <select name="diaf" id="diaf"><option value="'.date("d").'">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'"';if($form["diaf"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesf" id="mesf"><option value="'.date("m").'">Mes</option>
									<option value="01"';if($form["mesf"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
									<option value="02"';if($form["mesf"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
									<option value="03"';if($form["mesf"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
									<option value="04"';if($form["mesf"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
									<option value="05"';if($form["mesf"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
									<option value="06"';if($form["mesf"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
									<option value="07"';if($form["mesf"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
									<option value="08"';if($form["mesf"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
									<option value="09"';if($form["mesf"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
									<option value="10"';if($form["mesf"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
									<option value="11"';if($form["mesf"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
									<option value="12"';if($form["mesf"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
								</select><select name="annof" id="annof"><option value="'.date("Y").'">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'"';if($form["annof"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	} 
	$cadena.='				</select> 
											<p><input type="radio" name="tipo" id="tipo" value="pdf"> PDF <input type="radio" name="tipo" id="tipo" value="excel">Excell
											<p><input type="submit" name="botbuspagos" id="botbuspagos" value="Mostrar>>" class="boton">
									</form>
								</td>
							</tr>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function edit_status_orden($orden)
{
	include ("conexion.php");
	
	$ResOrdenV=mysql_fetch_array(mysql_query("SELECT * FROM ordenventa WHERE Id='".$orden."' LIMIT 1"));
	$cliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResOrdenV["Cliente"]."' LIMIT 1"));
	
	$cadena='<form name="feditov" id="feditov">
					 <table border="1" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="2" bgcolor="#287d29" align="center" class="texto3">Orden de Venta No. '.$ResOrdenV["NumOrden"].'</th>
						</tr>
						<tr>
							<td bgcolor="#7ac37b" align="right" class="texto">Cliente: </td>
							<td bgcolor="#7ac37b" align="left" class="texto">'.$cliente["Nombre"].'</td>
						</tr>
						<tr>
							<td bgcolor="#7ac37b" align="right" class="texto">Fecha: </td>
							<td bgcolor="#7ac37b" align="left" class="texto">'.$ResOrdenV["Fecha"].'</td>
						</tr>
						<tr>
							<td bgcolor="#7ac37b" align="right" class="texto">Status: </td>
							<td bgcolor="#7ac37b" align="left" class="texto"><select name="status" id="status">
								<option value="Pendiente"';if($ResOrdenV["Status"]=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente</option>
								<option value="Cancelada"';if($ResOrdenV["Status"]=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
								<option value="Facturado"';if($ResOrdenV["Status"]=='Facturado'){$cadena.=' selected';}$cadena.='>Facturada</option>
							</option></td>
						</tr>
						<tr>
							<td bgcolor="#7ac37b" align="right" class="texto">Factura: </td>
							<td bgcolor="#7ac37b" align="left" class="texto">Serie: <input type="text" name="serie" id="serie" size="3" class="input"> Num. Factura: <input type="text" name="numfactura" id="numfactura" size="5" class="input"></td>
						</tr>
						<tr>
							<td bgcolor="#7ac37b" align="center" class="texto" colspan="2">
								<input type="hidden" name="idorden" id="idorden" value="'.$ResOrdenV["Id"].'">
								<input type="button" id="boteditov" name="boteditov" value="Modificar >>" class="boton" onclick="xajax_edit_status_orden_2(xajax.getFormValues(\'feditov\'))">
							</td>
						</tr>
					</table>
					</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function edit_status_orden_2($orden)
{
	include ("conexion.php");
	
	if($orden["status"]!='Cancelada'){$idfactura=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$orden["serie"]."' AND NumFactura='".$orden["numfactura"]."' LIMIT 1"));}
	
	if(!isset($idfactura["Id"]))
	{
		$cadena='<p class="textomensaje" align="center">La Factura '.$orden["serie"].$orden["numfactura"].' no esta registrada en sistema</p>';
	}
	else 
	{
		switch($orden["status"])
		{
			case 'Pendiente': 
				mysql_query("UPDATE ordenventa SET Facturas='".$idfactura["Id"].">>' WHERE Id='".$orden["idorden"]."'") or die(mysql_error());
				break;
			case 'Cancelada':
				mysql_query("UPDATE ordenventa SET Status='Cancelada' WHERE Id='".$orden["idorden"]."'") or die(mysql_error());
				break;
			case 'Facturado':
				mysql_query("UPDATE ordenventa SET Status='Facturado', 
																					 Facturas='".$idfactura["Id"].">>'
																		 WHERE Id='".$orden["idorden"]."'") or die(mysql_error());
				break;
		}
		$cadena='<p class="textomensaje">Se actualizo la orden de venta satisfactoriamente</p>';
	}
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function orden_cotizacion($cotizacion, $borra=NULL)
{
	include ("conexion.php");

	if(!is_array($cotizacion))
	{
		$ResCot=mysql_fetch_array(mysql_query("SELECT * FROM cotizaciones WHERE Id='".$cotizacion."' LIMIT 1"));
	}
	else
	{
		$ResCot=mysql_fetch_array(mysql_query("SELECT * FROM cotizaciones WHERE Id='".$cotizacion["idcotizacion"]."' LIMIT 1"));
	}
	
	$cadena='<form name="fordenventa" id="fordenventa">
					 <input type="text" name="idcotizacion" id="idcotizacion" value="'.$ResCot["Id"].'">
					 <table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="7" bgcolor="#287d29" align="center" class="texto3">Orden de Venta</th>
						</tr>';
	$cadena.='<tr>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cliente: </td>
							<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><input type="hidden" name="cliente" id="cliente" value="'.$ResCot["Cliente"].'">';
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$ResCot["Cliente"]."' ORDER BY Nombre ASC"));
	$cadena.=$ResCliente["Nombre"].'</td>
							<td rowspan="2" valign="middle" align="left" bgcolor="#7abc7a" class="texto">Almacen: </td>
							<td rowspan="2" valign="middle" align="left" bgcolor="#7abc7a" class="texto"><select name="almacen" id="almacen"><option value="">Seleccione</option>';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$cotizacion["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
						 </tr>
						 <tr>
						 <td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Unidad: </td>
						 <td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><select name="unidadclie" id="unidadclie"><option>Seleccione</option>';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$ResCot["Cliente"]."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'"';if($RResUnidadesCliente["Id"]==$cotizacion["unidadclie"]){$cadena.=' selected';}$cadena.='>'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select></div></td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#7abc7a class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">';if(!is_array($cotizacion)){$cadena.=$ResCot["Observaciones"];}else{$cadena.=$cotizacion["observaciones"];}$cadena.='</textarea></td>
						 	<td align="left" bgcolor="#7abc7a" class="texto" valign="top">Pedido Num.:</td>
						 	<td algin="left" bgcolor="#7abc7a" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="';if(!is_array($cotizacion)){$cadena.=$ResCot["NumPedido"];}else{$cadena.=$cotizacion["pedido"];}$cadena.='"></td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Agente: </td>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgente=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgente=mysql_fetch_array($ResAgente))
	{
		$cadena.='<option value="'.$RResAgente["Id"].'"';if($RResAgente["Id"]==$cotizacion["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
							<td align="left" bgcolor="#7abc7a" class="texto">Precio: </td>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">
								<select name="pp" id="pp">
									<option value="PrecioPublico"';if($cotizacion["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($cotizacion["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($cotizacion["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
							</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Total</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						 </tr>';
	$bgcolor="#7ac37b"; $i=1; $J=1; $array=array();
	if(!is_array($cotizacion)) //ingresa la cotizacion original para la orden
	{
		$ResDetCotizacion=mysql_query("SELECT * FROM detcotizaciones WHERE idcotizacion='".$cotizacion."' AND Status='Pendiente' OR Status='Surtido' ORDER BY Id ASC");
		$J=1; $array=array();
		while($RResDetCotizacion=mysql_fetch_array($ResDetCotizacion))
		{
			$arreglo=array($J, $RResDetCOtizacion["Id"], $RResDetCotizacion["idcotizacion"], $RResDetCotizacion["Producto"], $RResDetCotizacion["Clave"], $RResDetCotizacion["Cantidad"], $RResDetCotizacion["PrecioUnitario"], $RResDetCotizacion["Subtotal"], $RResDetCotizacion["Id"]);
			array_push($array, $arreglo);
			$J++;
		}
	}
	else //cambia la factura quitando productos
	{
		$J=1; $array=array();
		for($T=1;$T<=$cotizacion["elementos"]; $T++)
		{
			if($T!=$borra)
			{
				$arreglo=array($J, $cotizacion["idelemento_".$T], $ResCot["Id"], $cotizacion["producto_".$T], $cotizacion["clave_".$T], $cotizacion["cantidad_".$T], $cotizacion["preciouni_".$T], $cotizacion["total_".$T], $cotizacion["iddetcotizacion_".$T]);
				array_push($array, $arreglo);
				$J++;
			}
		}
	}
	for($T=0;$T<count($array);$T++)
	{
		$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$array[$T][3]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><input type="hidden" name="idelemento_'.$array[$T][0].'" id="idelemento_'.$array[$T][0].'" value="'.$array[$T][0].'">'.$array[$T][0].'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"><input type="texto" name="cantidad_'.$array[$T][0].'" id="cantidad_'.$array[$T][0].'" size="10" class="input" value="'.$array[$T][5].'" onKeyUp="calculo(this.value, preciouni_'.$array[$T][0].'.value, total_'.$array[$T][0].')"></td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><input type="hidden" name="clave_'.$array[$T][0].'" id="clave_'.$array[$T][0].'" value="'.$array[$T][4].'">'.$array[$T][4].'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto"><input type="hidden" name="producto_'.$array[$T][0].'" id="producto_'.$array[$T][0].'" value="'.$array[$T][3].'">'.$ResProducto["Nombre"].'<input type="hidden" name="iddetcotizacion_'.$array[$T][0].'" id="iddetcotiazcion_'.$array[$T][0].'" value="'.$array[$T][8].'"></td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"><input type="texto" name="preciouni_'.$array[$T][0].'" id="preciouni_'.$array[$T][0].'" size="10" class="input" value="'.$array[$T][6].'" onKeyUp="calculo(cantidad_'.$array[$T][0].'.value, this.value, total_'.$array[$T][0].')"></td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"><input type="texto" name="total_'.$array[$T][0].'" id="total_'.$array[$T][0].'" size="10" class="input" value="'.$array[$T][7].'"></td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><a href="#" onclick="xajax_factura_orden(xajax.getFormValues(\'fordenfact\'), \''.$array[$T][0].'\')"><img src="images/x.png" border="0"></a></td>
							</tr>';
	$J++;
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	$cadena.='	<tr>
								<th colspan="7" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botfinfact" id="botfinfact" value="Guardar Orden de Venta >>" class="boton" onclick="xajax_guarda_orden_cotizacion(xajax.getFormValues(\'fordenventa\'))">
								</th>
							</tr>
						</table>
						<input type="hidden" name="elementos" id="elementos" value="'.count($array).'">
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_orden_cotizacion($orden)
{
	include ("conexion.php");
	
	$almacen=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"];
	//numero de orden
	$numorden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumOrden DESC LIMIT 1"));
	$numo=$numorden["NumOrden"]+1;
	
	//guarda orden de venta
	mysql_query("INSERT INTO ordenventa (NumOrden, IdCotizacion, Empresa, Sucursal, Cliente, UnidadCliente, Fecha, Status, Observaciones, NumPedido, Agente, Usuario)
																  VALUES ('".$numo."', 
																  				'".$orden["idcotizacion"]."',
																  				'".$_SESSION["empresa"]."', 
																  				'".$_SESSION["sucursal"]."',
																  				'".$orden["cliente"]."', 
																  				'".$orden["unidadclie"]."', 
																  				'".date("Y-m-d")."', 
																  				'Pendiente', 
																  				'".$orden["observaciones"]."', 
																  				'".$orden["pedido"]."', 
																  				'".$orden["agente"]."', 
																  				'".$_SESSION["usuario"]."')") or die(mysql_error());
	$idorden=mysql_fetch_array(mysql_query("SELECT Id, NumOrden FROM ordenventa ORDER BY Id DESC LIMIT 1"));
	//guarda detalles de la orden
	for($i=1;$i<=$orden["elementos"];$i++)
	{
		mysql_query("INSERT INTO detordenventa (idorden, Producto, Clave, Cantidad, PrecioUnitario, Subtotal, Status, Usuario)
																		VALUES ('".$idorden["Id"]."', 
																						'".$orden["producto_".$i]."',
																						'".$orden["clave_".$i]."',
																						'".$orden["cantidad_".$i]."',
																						'".$orden["preciouni_".$i]."',
																						'".$orden["total_".$i]."',
																						'Pendiente',
																						'".$_SESSION["usuario"]."')") or die(mysql_error());
		//registramos movimiento
		mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenVenta, Fecha, Descripcion, Usuario)
																		VALUES ('".$almacen."',
																						'".$orden["producto_".$i]."',
																						'Salida',
																						'".$orden["cantidad_".$i]."',
																						'".$idorden["Id"]."',
																						'".date("Y-m-d")."',
																						'Salida de Mercancia por Orden de Venta',
																						'".$_SESSION["usuario"]."')") or die(mysql_error());
	}
	//actualiza cotizacion
	mysql_query("UPDATE cotizaciones SET Status='Vendido' WHERE Id='".$orden["idcotizacion"]."'") or die(mysql_error());
	
	$mensaje='Se genero la orden de venta numero '.$idorden["NumOrden"];
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Orden de Venta</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						<tr>
							<td bgcolor="#7abc7a" align="center" class="textomensaje"><a href="clientes/ordenventa.php?idorden='.$idorden["Id"].'" target="_blank">Imprimir Orden de Venta</a></td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function factura_cotizacion($cotizacion)
{
	include ("conexion.php");
	
	if(!is_array($cotizacion)){$ResCotizacion=mysql_query("SELECT * FROM cotizaciones WHERE Id='".$cotizacion."' LIMIT 1");}
	else{$ResCotizacion=mysql_query("SELECT * FROM cotizaciones WHERE Id='".$cotizacion["idcotizacion"]."' LIMIT 1");}
	$RResCotizacion=mysql_fetch_array($ResCotizacion);
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResCotizacion["Cliente"]."' LIMIT 1"));
	//$ResUnidadCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResOrdenVenta["UnidadCliente"]."' LIMIT 1"));
	
	$cadena='<form name="fcotizafact" id="fcotizafact">
						<input type="hidden" name="idcotizacion" id="idcotizacion" value="'.$RResCotizacion["Id"].'">
						<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
							<tr>
								<th colspan="7" align="center" bgcolor="#287d29" class="texto3">Facturación</th>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#7abc7a" align="left" class="texto">Num. Cotizacion: '.$RResCotizacion["NumCotizacion"].'</td>
								<td colspan="5" bgcolor="#7abc7a" align="left" class="texto">Cliente: '.$ResCliente["Nombre"].'</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#7abc7a" align="left" class="texto" valign="top">Observaciones: </td>
								<td colspan="5" bgcolor="#7abc7a" align="left" class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$RResCotizacion["Observaciones"].'</textarea></td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#7abc7a" align="left" class="texto" valign="top"><div id="moneda">Moneda: <select name="moneda" id="moneda" onchange="xajax_moneda(this.value)">
						 		<option value="M.N."'; if($cotizacion["moneda"]=='M.N.'){$cadena.=' selected';}$cadena.='>M.N.</option>
						 		<option value="USD"'; if($cotizacion["moneda"]=='USD'){$cadena.=' selected';}$cadena.='>USD</option>
						 	</select>';
	if($cotizacion["moneda"]=='USD')
	{
		$cadena.=' $ <input type="text" name="tipocambio" id="tipocambio" class="input" size="5" value="'.$cotizacion["tipocambio"].'">';
	}
	elseif($cotizacion["moneda"]=='M.N.')
	{
		$cadena.=' $ <input type="hidden" name="tipocambio" id="tipocambio" class="input" size="5" value="0.00">';
	}
	$cadena.='</div></td>
								<td colspan="5" bgcolor="#7abc7a" align="left" class="texto" valign="top">Almacen: <select name="almacen" id="almacen"><option value="">Seleccione</option>';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$cotizacion["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select>
								</td>
							</tr>
							<tr>
						 	<td colspan="7" align="left" bgcolor="#7abc7a" class="texto" valig="top">
						 		<div id="pagocliente">
						 		Forma de Pago: <select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO"';if($ResCliente["Fpago"]=='NO IDENTIFICADO'){$cadena.=' selected';}$cadena.='>NO IDENTIFICADO</option>
											<option value="EFECTIVO"';if($ResCliente["Fpago"]=='EFECTIVO'){$cadena.=' selected';}$cadena.='>EFECTIVO</option>
											<option value="TARJETA DE CREDITO"';if($ResCliente["Fpago"]=='TARJETA DE CREDITO'){$cadena.=' selected';}$cadena.='>TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO"';if($ResCliente["Fpago"]=='TARJETA DE DEBITO'){$cadena.=' selected';}$cadena.='>TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA"';if($ResCliente["Fpago"]=='TRANSFERENCIA ELECTRONICA'){$cadena.=' selected';}$cadena.='>TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE"';if($ResCliente["Fpago"]=='CHEQUE'){$cadena.=' selected';}$cadena.='>CHEQUE</option>
										</select>&nbsp;&nbsp;Num. Cuenta: <input type="text" name="numcuenta" id="numcuenta" size="5" class="input" value="'.$ResCliente["Ncuenta"].'">
						 		</div></td>
						 </tr>
							<tr>
								<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Cantidad</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Clave</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Producto</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Precio Unitario</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Total</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
							</tr>';
	if(!is_array($ordenventa)) //ingresa la orden original para facturar
	{
		$ResDetCotizacion=mysql_query("SELECT * FROM detcotizaciones WHERE idcotizacion='".$cotizacion."' AND Status='Pendiente' OR Status='Surtido' ORDER BY Id ASC");
		$J=1; $array=array();
		while($RResDetCotizacion=mysql_fetch_array($ResDetCotizacion))
		{
			$arreglo=array($J, $RResDetCotizacion["Id"], $RResDetCotizacion["idcotizaccion"], $RResDetCotizacion["Producto"], $RResDetCotizacion["Clave"], $RResDetCotizacion["Cantidad"], $RResDetCotizacion["PrecioUnitario"], $RResDetCotizacion["Subtotal"], $RResDetCotizacion["Id"]);
			array_push($array, $arreglo);
			$J++;
		}
	}
	else //cambia la factura quitando productos
	{
		$J=1; $array=array();
		for($T=1;$T<=$ordenventa["elementos"]; $T++)
		{
			if($T!=$borra)
			{
				$arreglo=array($J, $cotizacion["idelemento_".$T], $cotizacion["idcotizacion"], $cotizacion["producto_".$T], $cotizacion["clave_".$T], $cotizacion["cantidad_".$T], $cotizacion["preciouni_".$T], $cotizacion["total_".$T], $cotizacion["iddetcotizacion_".$T]);
				array_push($array, $arreglo);
				$J++;
			}
		}
	}
	$J=1; $bgcolor="#7ac37b";
	for($T=0;$T<count($array);$T++)
	{
		$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$array[$T][3]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><input type="hidden" name="idelemento_'.$array[$T][0].'" id="idelemento_'.$array[$T][0].'" value="'.$array[$T][0].'">'.$array[$T][0].'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"><input type="texto" name="cantidad_'.$array[$T][0].'" id="cantidad_'.$array[$T][0].'" size="10" class="input" value="'.$array[$T][5].'" onKeyUp="calculo(this.value, preciouni_'.$array[$T][0].'.value, total_'.$array[$T][0].')"></td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><input type="hidden" name="clave_'.$array[$T][0].'" id="clave_'.$array[$T][0].'" value="'.$array[$T][4].'">'.$array[$T][4].'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto"><input type="hidden" name="producto_'.$array[$T][0].'" id="producto_'.$array[$T][0].'" value="'.$array[$T][3].'">'.$ResProducto["Nombre"].'<input type="hidden" name="iddetorden_'.$array[$T][0].'" id="iddetorden_'.$array[$T][0].'" value="'.$array[$T][8].'"></td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"><input type="texto" name="preciouni_'.$array[$T][0].'" id="preciouni_'.$array[$T][0].'" size="10" class="input" value="'.$array[$T][6].'" onKeyUp="calculo(cantidad_'.$array[$T][0].'.value, this.value, total_'.$array[$T][0].')"></td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"><input type="texto" name="total_'.$array[$T][0].'" id="total_'.$array[$T][0].'" size="10" class="input" value="'.$array[$T][7].'"></td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><a href="#" onclick="xajax_factura_cotizacion(xajax.getFormValues(\'fcotizafact\'), \''.$array[$T][0].'\')"><img src="images/x.png" border="0"></a></td>
							</tr>';
	$J++;
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	$cadena.='	<tr>
								<th colspan="7" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botfinfact" id="botfinfact" value="Finalizar Factura >>" class="boton" onclick="xajax_finaliza_factura_cotizacion(xajax.getFormValues(\'fcotizafact\'), document.getElementById(\'reloj\').value)">
								</th>
							</tr>
						</table>
						<input type="hidden" name="elementos" id="elementos" value="'.count($array).'">
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function finaliza_factura_cotizacion($cotiza, $hora)
{
	include ("conexion.php");
	
	$almacen=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$cotiza["almacen"];
	
	//calcula subtotal, iva y total de la factura
	for($A=1; $A<=$cotiza["elementos"]; $A++)
	{
		$subtotal=$subtotal+$cotiza["total_".$A];
	}
if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	$iva=$subtotal*$ivaa;
	$total=$subtotal+$iva;
	
	$ResCotizacion=mysql_query("SELECT * FROM cotizaciones WHERE Id='".$cotiza["idcotizacion"]."' LIMIT 1");
	$RResCotizacion=mysql_fetch_array($ResCotizacion);
	
	$ResFFactura=mysql_query("SELECT * FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1");
	$RResFFactura=mysql_fetch_array($ResFFactura);
	
	if($RResFactura["Factura"]>$RResFactura["FolioF"]) //avisa si no existen folios disponibles
	{
		$cadena='<p align="center" class="textomensaje">Lo sentimos no tiene mas folios para emitir facturas, por favor consulte al administrador</p>';
	}
	else //guarda la factura si existen folios disponibles
	{
		//ingreso datos generales de factura
		mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, NumPedido, NumCotizacion, Fecha, Subtotal, Iva, Total, Moneda, TipoCambio, Status, Observaciones, Agente, Version, Fpago, Ncuenta, Usuario)
															 VALUES ('".$RResFFactura["Serie"]."', 
															 				 '".$RResFFactura["Factura"]."', 
															 				 '".$_SESSION["empresa"]."', 
															 				 '".$_SESSION["sucursal"]."',
																 			 '".$RResCotizacion["Cliente"]."', 
																 			 '".$RResCotizacion["NumPedido"]."', 
																 			 '".$RResCotizacion["NumCotizacion"]."', 
																 			 '".date("Y-m-d")." ".$hora."', 
																 			 '".$subtotal."', 
																			 '".$iva."', 
																			 '".$total."', 
																			 '".$cotiza["moneda"]."', 
																			 '".$cotiza["tipocambio"]."', 
																			 'Pendiente', 
																			 '".utf8_decode($orden["observaciones"])."', 
																			 '".$RResCotizacion["Agente"]."',
																			 '".$RResFFactura["Version"]."',
																			 '".$cotiza["fpago"]."',
																			 '".$cotiza["numcuenta"]."',
																			 '".$_SESSION["usuario"]."')");
		//actualizo el numero de factura
		mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Id='".$RResFFactura["Id"]."'");
		
		//ingreso los productos de la factura
		$ResIdFact=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente='".$RResCotizacion["Cliente"]."' AND NumCotizacion='".$RResCotizacion["NumCotizacion"]."' ORDER BY Id DESC LIMIT 1"));
		//$cadena='Id de Factura: '.$ResIdFact["Id"];
		for($A=1; $A<=$cotiza["elementos"]; $A++)
		{
			mysql_query("INSERT INTO detfacturas (IdFactura, Producto, Clave, Cantidad, PrecioUnitario, Subtotal, Usuario)
			 															VALUES ('".$ResIdFact["Id"]."', 
			 																		  '".$cotiza["producto_".$A]."', 
			 																		  '".$cotiza["clave_".$A]."',
			 																			'".$cotiza["cantidad_".$A]."', 
			 																			'".$cotiza["preciouni_".$A]."', 
			 																			'".$cotiza["total_".$A]."', 
			 																			'".$_SESSION["usuario"]."')") or die($cadena.=mysql_error());
			//movimientos al inventario
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdFactura, Fecha, Descripcion, Usuario)
																		VALUES ('".$almacen."',
																						'".$cotiza["producto_".$A]."',
																						'Salida',
																						'".$cotiza["cantidad_".$A]."',
																						'".$ResIdFact["Id"]."',
																						'".date("Y-m-d")."',
																						'Salida de Mercancia por Factura/Cotizacion',
																						'".$_SESSION["usuario"]."')") or die(mysql_error());
			
		}
		//Actualizo el status de la cotizacion
		mysql_query("UPDATE cotizaciones SET Status='Vendido' WHERE Id='".$cotiza["idcotizacion"]."'") or die(mysql_error());
		
//Genera Cadena Original
		//datos de la factura
		$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$ResIdFact["Id"]."' LIMIT 1"));
		$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));
		$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$ResIdFact["Id"]."' ORDER BY Id ASC");
		
		//Datos del Emisor y del Receptor
		$ResEmpresa=mysql_fetch_array(mysql_query("SELECT * FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1"));
		$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
		$ResSuc=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id!='".$_SESSION["sucursal"]."' AND Empresa='".$_SESSION["empresa"]."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));
		
	//cadena orginal
	//version
	$cadenaoriginal='||'.$ResFactura["Version"].'|'; 
	//serie
	if($ResFactura["Serie"]!=''){$cadenaoriginal.=$ResFFacturas["Serie"].'|';}
	//folio
	$cadenaoriginal.=$ResFactura["NumFactura"].'|';
	//fecha
	for($i=0; $i<=9; $i++){$cadenaoriginal.=$ResFactura["Fecha"][$i];}
	$cadenaoriginal.='T';
	for($i=11; $i<=18;$i++){$cadenaoriginal.=$ResFactura["Fecha"][$i];}
	//datos emisor
	//numaprobacion
	//$cadenaoriginal.='|'.$ResFFacturas["NumAprobacion"].'|'.$ResFFacturas["NumCertificado"].'|';
	$cadenaoriginal.='|'.$ResFFacturas["NumAprobacion"].'|';
	//añoaprovacion
	$cadenaoriginal.=$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3].'|';
	//tipo de comprovante
	$cadenaoriginal.='ingreso|';
	//forma de pago
	$cadenaoriginal.='PAGO EN UNA SOLA EXHIBICION|';
	//condiciones de pago
	//subtotal
	$cadenaoriginal.=$ResFactura["Subtotal"].'|';
	//descuento
	if($ResFactura["Descuento"]!=0)
	{
		$desc='0.'.$ResFactura["Descuento"];
		$sdescuento=$ResFactura["Subtotal"]*$desc;
		$cadenaoriginal.=number_format($sdescuento, 2).'|';
	}
	//total
	$cadenaoriginal.=$ResFactura["Total"].'|';
	//metodo de pago
	$cadenaoriginal.=$ResFactura["Fpago"].'|';
	//lugar expedicion
	$cadenaoriginal.=$ResEmisor["Estado"].'|';
	//numero de la cuenta
	if($ResFactura["Ncuenta"]!=''){$cadenaoriginal.=$ResFactura["Ncuenta"].'|';}
	//rfc del emisor
	$cadenaoriginal.=$ResEmisor["RFC"].'|';	
	if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ' OR $ResSuc["Nombre"][0].$ResSuc["Nombre"][1].$ResSuc["Nombre"][2].$ResSuc["Nombre"][3].$ResSuc["Nombre"][4].$ResSuc["Nombre"][5].$ResSuc["Nombre"][6].$ResSuc["Nombre"][7]=='MATRIZPB')
	{
		//Nombre del emisor
		$cadenaoriginal.=$ResEmpresa["Nombre"].'|';
		//Calle del domicilio fiscal del emisor
		$cadenaoriginal.=$ResEmisor["Calle"].'|';
		//numero exterior del emisor
		if($ResEmisor["NoExterior"]!=''){$cadenaoriginal.=$ResEmisor["NoExterior"].'|';}
		//numero interior del emisor
		if($ResEmisor["NoInterior"]!=''){$cadenaoriginal.=$ResEmisor["NoInterior"].'|';}
		//colonia del emisor
		if($ResEmisor["Colonia"]!=''){$cadenaoriginal.=$ResEmisor["Colonia"].'|';}
		//localidad del emisor
		if($ResEmisor["Localidad"]!=''){$cadenaoriginal.=$ResEmisor["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResEmisor["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResEmisor["Pais"].'|';
		//codigo porstal del emisor
		//$cadenaoriginal.=$ResEmisor["CodPostal"].'|LUG. EXPEDICION ';if($_SESSION["sucursal"]==1){$cadenaoriginal.='CANCUN QUINTANA ROO';}else{$cadenaoriginal.='MEXICO D. F.';}$cadenaoriginal.=' A '.$ResFactura["Fecha"][8].$ResFactura["Fecha"][9].'/'.$ResFactura["Fecha"][5].$ResFactura["Fecha"][6].'/'.$ResFactura["Fecha"][0].$ResFactura["Fecha"][1].$ResFactura["Fecha"][2].$ResFactura["Fecha"][3].'|';
		$cadenaoriginal.=$ResEmisor["CodPostal"].'|';
		//lugar de emision
		//$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//$cadenaoriginal.=$ResEmisor["Pais"].'|';
		//repite el emisor
		$cadenaoriginal.=$ResEmisor["Calle"].'|';
		//numero exterior del emisor
		if($ResEmisor["NoExterior"]!=''){$cadenaoriginal.=$ResEmisor["NoExterior"].'|';}
		//numero interior del emisor
		if($ResEmisor["NoInterior"]!=''){$cadenaoriginal.=$ResEmisor["NoInterior"].'|';}
		//colonia del emisor
		if($ResEmisor["Colonia"]!=''){$cadenaoriginal.=$ResEmisor["Colonia"].'|';}
		//localidad del emisor
		if($ResEmisor["Localidad"]!=''){$cadenaoriginal.=$ResEmisor["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResEmisor["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResEmisor["Pais"].'|';
		//codigo porstal del emisor
		//$cadenaoriginal.=$ResEmisor["CodPostal"].'|LUG. EXPEDICION ';if($_SESSION["sucursal"]==1){$cadenaoriginal.='CANCUN QUINTANA ROO';}else{$cadenaoriginal.='MEXICO D. F.';}$cadenaoriginal.=' A '.$ResFactura["Fecha"][8].$ResFactura["Fecha"][9].'/'.$ResFactura["Fecha"][5].$ResFactura["Fecha"][6].'/'.$ResFactura["Fecha"][0].$ResFactura["Fecha"][1].$ResFactura["Fecha"][2].$ResFactura["Fecha"][3].'|';
		$cadenaoriginal.=$ResEmisor["CodPostal"].'|';
		//lugar de emision
		//$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//$cadenaoriginal.=$ResEmisor["Pais"].'|';
		
	}
	else
	{
		//Nombre del emisor
		$cadenaoriginal.=$ResEmpresa["Nombre"].'|';
		//Calle del domicilio fiscal del emisor
		$cadenaoriginal.=$ResEmisor["Calle"].'|';
		//numero exterior del emisor
		if($ResEmisor["NoExterior"]!=''){$cadenaoriginal.=$ResEmisor["NoExterior"].'|';}
		//numero interior del emisor
		if($ResEmisor["NoInterior"]!=''){$cadenaoriginal.=$ResEmisor["NoInterior"].'|';}
		//colonia del emisor
		if($ResEmisor["Colonia"]!=''){$cadenaoriginal.=$ResEmisor["Colonia"].'|';}
		//localidad del emisor
		if($ResEmisor["Localidad"]!=''){$cadenaoriginal.=$ResEmisor["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResEmisor["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResEmisor["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResEmisor["Pais"].'|';
		//codigo porstal del emisor
		$cadenaoriginal.=$ResEmisor["CodPostal"].'|';
		
		//Calle del domicilio fiscal de la sucursal (lugar de expedicion)
		$cadenaoriginal.=$ResSuc["Calle"].'|';
		//numero exterior del emisor
		if($ResSuc["NoExterior"]!=''){$cadenaoriginal.=$ResSuc["NoExterior"].'|';}
		//numero interior del emisor
		if($ResSuc["NoInterior"]!=''){$cadenaoriginal.=$ResSuc["NoInterior"].'|';}
		//colonia del emisor
		if($ResSuc["Colonia"]!=''){$cadenaoriginal.=$ResSuc["Colonia"].'|';}
		//localidad del emisor
		if($ResSuc["Localidad"]!=''){$cadenaoriginal.=$ResSuc["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResSuc["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResSuc["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResSuc["Pais"].'|';
		//codigo porstal del emisor
		$cadenaoriginal.=$ResSuc["CodPostal"].'|';
	}
	
	//regimen fiscal
	$cadenaoriginal.=$ResEmpresa["Regimen"].'|';
	
	//datos receptor
	//rfc del receptor
	$cadenaoriginal.=$ResCliente["RFC"].'|';
	//nombre del receptor
	$cadenaoriginal.=$ResCliente["Nombre"].'|';
	//calle del receptor
	$cadenaoriginal.=$ResCliente["Direccion"].'|';
	//numero exterior del receptor
	if($ResCliente["NumExterior"]!=''){$cadenaoriginal.=$ResCliente["NumExterior"].'|';}
	//numero interior del receptor
	if($ResCliente["NumInterior"]!=''){$cadenaoriginal.=$ResCliente["NumInterior"].'|';}
	//colonia del receptor
	if($ResCliente["Colonia"]!=''){$cadenaoriginal.=$ResCliente["Colonia"].'|';}
	//localidad del receptor
	if($ResCliente["Ciudad"]!=''){$cadenaoriginal.=$ResCliente["Ciudad"].'|';}
	//municipio del receptor
	if($ResCliente["Municipio"]!=''){$cadenaoriginal.=$ResCliente["Municipio"].'|';}
	//estado del receptor
	if($ResCliente["Estado"]!=''){$cadenaoriginal.=$ResCliente["Estado"].'|';}
	//pais del receptor
	$cadenaoriginal.=$ResCliente["Pais"].'|';
	//codigo postal del receptor
	if($ResCliente["CP"]!=''){$cadenaoriginal.=$ResCliente["CP"].'|';}
	
	
	
	while($RResPartidas=mysql_fetch_array($ResPartidas))
	{
		
		$ProdOV=mysql_fetch_array(mysql_query("SELECT Producto FROM detordenventa WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1")); //selecciona el producto de la orden de venta
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$ProdOV["Producto"]."' LIMIT 1"));//Selecciona los datos del producto
		
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResProd["Unidad"]."' AND PerteneceA='unidades' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'	"));
		//cantidad
		$cadenaoriginal.=$RResPartidas["Cantidad"].'|';
		//unidad
		$cadenaoriginal.=$ResUnidad["Nombre"].'|';
		//numero de identificacion (clave)
		$cadenaoriginal.=$RResPartidas["Clave"].'|';
		//descripcion
		if($RResPartidas["Producto"]!=0){$cadenaoriginal.=$ResProd["Nombre"].' - '.$ResProd["Clave"].'|';}
		else{$cadenaoriginal.=$RResPartidas["Descripcion"].'|';}		
		//valor unitario
		$cadenaoriginal.=$RResPartidas["PrecioUnitario"].'|';
		//importe
		$cadenaoriginal.=$RResPartidas["Subtotal"].'|';
	}
	//continua cadena original
	//tipo de inpuesto
	$cadenaoriginal.='IVA|'.($_SESSION["iva"]*100).'.00|';
	//importe
	$cadenaoriginal.=$ResFactura["Iva"].'|'.$ResFactura["Iva"].'||';

	//sellamos cadena
		$cadenaoriginal_sellada = utf8_encode($cadenaoriginal) ;
		//guardamos en archivo
		$fp = fopen ("certificados2/sellos2/".$ResIdFact["Id"].".txt", "w+");
  	     fwrite($fp, $cadenaoriginal_sellada);
		fclose($fp);
		//archivo .key
		$key='certificados/'.$ResFFacturas["ArchivoCadena"];
		//sellamos archivo
		exec("openssl dgst -sha1 -sign $key certificados2/sellos2/".$ResIdFact["Id"].".txt | openssl enc -base64 -A > certificados2/sellos2/sello_".$ResIdFact["Id"].".txt");
		//leer sello
		$f=fopen("certificados2/sellos2/".$ResIdFact["Id"].".txt",'r');
 	  $selloemisor=fread($f,filesize("certificados2/sellos2/sello_".$ResIdFact["Id"].".txt"));
  	fclose($f);
	
	
	//Generamos XML
	$cer=file_get_contents('certificados/'.$ResFFacturas["NumCertificado"].'.cer.pem'); //leemos el certificado
	$cer1=str_replace('-----BEGIN CERTIFICATE-----','',$cer);
	$certificado=str_replace('-----END CERTIFICATE-----','',$cer1);
	
	$xml='<?xml version="1.0" encoding="UTF-8"?>
					<Comprobante xmlns="http://www.sat.gob.mx/cfd/2" 
						 					 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
						 					 xsi:schemaLocation="http://www.sat.gob.mx/cfd/2 http://www.sat.gob.mx/sitio_internet/cfd/2/cfdv2.xsd http://www.sat.gob.mx/ecc http://www.sat.gob.mx/sitio_internet/cfd/ecc/ecc.xsd" 
						 					 version="'.$ResFactura["Version"].'"';
	//serie
	if($ResFactura["Serie"]!=''){$xml.=' serie="'.$ResFactura["Serie"].'"';}
	//folio
	$xml.=' folio="'.$ResFactura["NumFactura"].'" fecha="';
	//fecha
	for($i=0; $i<=9; $i++){$xml.=$ResFactura["Fecha"][$i];}
	$xml.='T';
	for($i=11; $i<=18;$i++){$xml.=$ResFactura["Fecha"][$i];}
	//sello
	$xml.='" sello="'.file_get_contents('certificados2/sellos2/sello_'.$idfactura["Id"].'.txt').'"';
	//numaprobacion
	$xml.=' noAprobacion="'.$ResFFacturas["NumAprobacion"].'"';
	//añoaprovacion
	$xml.=' anoAprobacion="'.$ResFFacturas["Fecha"][0].$ResFFacturas["Fecha"][1].$ResFFacturas["Fecha"][2].$ResFFacturas["Fecha"][3].'"';
	//tipo de comprovante
	$xml.=' tipoDeComprobante="ingreso"';
	//forma de Pago
	$xml.=' formaDePago="PAGO EN UNA SOLA EXHIBICION"';
	//num certificado
	$xml.=' noCertificado="'.$ResFFacturas["NumCertificado"].'"';
	//certificado
	$xml.=' certificado="'.utf8_encode($certificado).'"';
	//condiciones de pago
	//subtotal
	$xml.=' subTotal="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Subtotal"];}$xml.='"';
	//descuento
	if($ResFactura["Descuento"]!=0)
	{
		$desc='0.'.$ResFactura["Descuento"];
		$sdescuento=$ResFactura["Subtotal"]*$desc;
		$xml.=' descuento="'.number_format($sdescuento, 2).'"';
	}
	//total
	$xml.=' total="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]),2,'.','' );}else{$xml.=$ResFactura["Total"];}$xml.='"';
	//metodo de pago
	$xml.=' metodoDePago="'.$ResFactura["Fpago"].'"';
	//lugar expedicion
	$xml.=' LugarExpedicion="'.$ResEmisor["Estado"].'"';
	//numero de la cuenta
	if($ResFactura["Ncuenta"]!=''){$xml.=' NumCtaPago="'.$ResFactura["Ncuenta"].'"';}$xml.='>';
//datos del emisor

if($ResEmisor["Nombre"][0].$ResEmisor["Nombre"][1].$ResEmisor["Nombre"][2].$ResEmisor["Nombre"][3].$ResEmisor["Nombre"][4].$ResEmisor["Nombre"][5]=='MATRIZ')
{
	//RFC del emisor
	$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'">';
	//domicilio del emisor
	$xml.='<DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.='<ExpedidoEn calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'" />';
	//regimen fiscal
	$xml.='<RegimenFiscal Regimen="'.$ResEmpresa["Regimen"].'" />
    </Emisor>';
}
else
{
	$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' AND Nombre LIKE 'MATRIZ%' ORDER BY Id DESC LIMIT 1"));
	//RFC del emisor
	$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'" >';
	//domicilio del emisor
	$xml.=' <DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.=' <ExpedidoEn calle="'.$ResMatriz["Calle"].'"';if($ResMatriz["NoExterior"]!=''){$xml.=' noExterior="'.$ResMatriz["NoExterior"].'"';}if($ResMatriz["NoInterior"]!=''){$xml.=' noInterior="'.$ResMatriz["NoInterior"].'"';}$xml.=' colonia="'.$ResMatriz["Colonia"].'"';if($ResMatriz["Localidad"]!=''){$xml.=' localidad="'.$ResMatriz["Localidad"].'"';}$xml.=' municipio="'.$ResMatriz["Municipio"].'" estado="'.$ResMatriz["Estado"].'" pais="'.$ResMatriz["Pais"].'" codigoPostal="'.$ResMatriz["CodPostal"].'"/>';
	//regimen fiscal
	$xml.='<RegimenFiscal Regimen.="'.$ResEmpresa["Regimen"].'" />
		</Emisor>';
}
	//datos receptor
	//rfc del receptor
	$xml.='<Receptor rfc="'.$ResCliente["RFC"].'"';
	//nombre del receptor
	$xml.=' nombre="'.$ResCliente["Nombre"].'">';
	//domicilio receptor
  $xml.='<Domicilio calle="'.$ResCliente["Direccion"].'"';if($ResCliente["NumExterior"]!=''){$xml.=' noExterior="'.$ResCliente["NumExterior"].'"';}if($ResCliente["NumInterior"]!=''){$xml.=' noInterior="'.$ResCliente["NumInterior"].'"';}$xml.=' colonia="'.$ResCliente["Colonia"].'" estado="'.$ResCliente["Estado"].'"';if($ResCliente["Ciudad"]){$xml.=' localidad="'.$ResCliente["Ciudad"].'"';}if($ResCliente["Municipio"]!=''){$xml.=' municipio="'.$ResCliente["Municipio"].'"';}$xml.=' pais="'.$ResCliente["Pais"].'" codigoPostal="'.$ResCliente["CP"].'"/>
		</Receptor>
		<Conceptos>';

$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$ResIdFact["Id"]."' ORDER BY Id ASC");
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	
	$ProdOV=mysql_fetch_array(mysql_query("SELECT Producto FROM detordenventa WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1")); //selecciona el producto de la orden de venta
	$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$ProdOV["Producto"]."' LIMIT 1"));//Selecciona los datos del producto
	
	
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
  $xml.='<Concepto cantidad="'.$RResPartidas["Cantidad"].'" ';
	if($RResPartidas["Producto"]!=0)
	{
  	$xml.='unidad="'.$ResUnidad["Nombre"].'" noIdentificacion="'.$RResPartidas["Clave"].'" descripcion="'.$ResProd["Nombre"].' - '.$ResProd["Clave"].'"';
	}
	else
	{
		$xml.='descripcion="'.$RResPartidas["Descripcion"].'" noIdentificacion="'.$RResPartidas["Clave"].'"';
	}
	$xml.=' valorUnitario="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($RResPartidas["PrecioUnitario"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$RResPartidas["PrecioUnitario"];}$xml.='" importe="';if($ResFactura["TipoCambio"]!='0.00'){$xml.=number_format(($RResPartidas["Subtotal"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$RResPartidas["Subtotal"];}$xml.='"/>';
}
$IVA=explode('.', $_SESSION["iva"]);
$xml.='</Conceptos>
    <Impuestos totalImpuestosTrasladados="';if($ResFactura["Moneda"]=='USD'){$xml.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Iva"];}$xml.='">
        <Traslados>
            <Traslado importe="';if($ResFactura["Moneda"]=='USD'){$xml.=number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]),2,'.','');}else{$xml.=$ResFactura["Iva"];}$xml.='" impuesto="IVA" tasa="'.$IVA[1].'.00"/>
        </Traslados>
    </Impuestos>
</Comprobante>';

//guarda XML y Cadena original

mysql_query("UPDATE facturas SET CadenaOriginal='".$cadenaoriginal_sellada."',
																 XML='".$xml."'
													WHERE Id='".$ResIdFact["Id"]."'");
		

		
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
							<tr>
								<th colspan="3" align="center" bgcolor="#287d29" class="texto3">Facturación</th>
							</tr>
							<tr>
								<td colspan="3" align="center" bgcolor="#7abc7a" align="center" class="textomensaje">Se genero la factura Num. '.$RResFFactura["Factura"].'</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
								<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/factura.php?idfactura='.$ResIdFact["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/factura2_2.php?idfactura='.$ResIdFact["Id"].'&empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"];}$cadena.='" target="_blank">Imprimir Factura</a>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
								<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/xml.php?idfactura='.$ResIdFact["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/xml2_2.php?idfactura='.$ResIdFact["Id"];}$cadena.='" target="_blank">Descargar XML</a>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botenviarfactura" id="botneviarfactura" value="Enviar Factura por Correo>>" class="boton">
								</td>
							</tr>
						</table>';
	
	}
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function unidades_cliente_facturas($cliente)
{
	include ("conexion.php");
	
	$cadena.='<p>Unidad: <select name="unidad" id="unidad"><option value="todas">Seleccione</option>';
	$ResUnidades=mysql_query("SELECT * FROM unidades_cliente WHERE Cliente='".$cliente."' ORDER BY Nombre ASC");
	while($RResUnidades=mysql_fetch_array($ResUnidades))
	{
		$cadena.='<option value="'.$RResUnidades["Id"].'">'.$RResUnidades["Nombre"].'</option>';
	}
	$cadena.='</select></p>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("unidad","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function cancela_cotizacion($cot, $cancela='no')
{
	include ("conexion.php");
	
	if($cancela=='no')
	{
		$ResNumCotizacion=mysql_fetch_array(mysql_query("SELECT NumCotizacion, Cliente FROM cotizaciones WHERE Id='".$cot."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNumOrdenVenta["Cliente"]."' LIMIT 1"));
		
		$mensaje='Esta seguro de cancelar la cotización Num.: '.$ResNumCotizacion["NumCotizacion"].' del Cliente: '.$ResCliente["Nombre"].'? <br />
							<a href="#" onclick="xajax_cancela_cotizacion(\''.$cot.'\', \'si\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_cotizaciones()">No</a>';
	}
	elseif($cancela=='si')
	{
		//cancelamos la orden
		mysql_query("UPDATE cotizaciones SET Status='Cancelada', Usuario='".$_SESSION["usuario"]."' WHERE Id='".$cot."'");
		
		$ResNumCotizacion=mysql_fetch_array(mysql_query("SELECT NumCotizacion, Cliente FROM cotizaciones WHERE Id='".$cot."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNumOrdenVenta["Cliente"]."' LIMIT 1"));
		
		$mensaje='<p class="textomensaje">Se cancelo la Cotizacion Num: '.$ResNumCotizacion["NumCotizacion"].' del Cliente: '.$ResCliente["Nombre"].' satisfactoriamente';
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#287d29" align="center" class="texto3">Cotizaciones</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</th>
						</tr>
					 </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function forma_pago_cliente($cliente)
{
	include ("conexion.php");
	
	$ResFpagoCliente=mysql_fetch_array(mysql_query("SELECT Fpago, Ncuenta FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	
	$cadena.='Forma de Pago: <select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO"';if($ResFpagoCliente["Fpago"]=='NO IDENTIFICADO'){$cadena.=' selected';}$cadena.='>NO IDENTIFICADO</option>
											<option value="EFECTIVO"';if($ResFpagoCliente["Fpago"]=='EFECTIVO'){$cadena.=' selected';}$cadena.='>EFECTIVO</option>
											<option value="TARJETA DE CREDITO"';if($ResFpagoCliente["Fpago"]=='TARJETA DE CREDITO'){$cadena.=' selected';}$cadena.='>TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO"';if($ResFpagoCliente["Fpago"]=='TARJETA DE DEBITO'){$cadena.=' selected';}$cadena.='>TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA"';if($ResFpagoCliente["Fpago"]=='TRANSFERENCIA ELECTRONICA'){$cadena.=' selected';}$cadena.='>TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE"';if($ResFpagoCliente["Fpago"]=='CHEQUE'){$cadena.=' selected';}$cadena.='>CHEQUE</option>
										</select>&nbsp;&nbsp;Num. Cuenta: <input type="text" name="numcuenta" id="numcuenta" size="5" class="input" value="'.$ResFpagoCliente["Ncuenta"].'">';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("pagocliente","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>