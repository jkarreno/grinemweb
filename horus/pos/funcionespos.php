<?php
function nota_nueva($form=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <form name="fnotaventa" id="fnotaventa" action="javascript:void(null)">
						<tr>
								<td colspan="7" align="center" bgcolor="#754200" class="texto3">Nota de Venta</td>
							</tr>
							<tr>
							<td colspan="4" align="left" bgcolor="#ba9464" class="texto">Almacen: <select name="almacen" id="almacen">';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$form["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
								<td colspan="4" align="left" bgcolor="#ba9464" class="texto">
									Precio: <select name="pp" id="pp">
									<option value="PrecioPublico"';if($form["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($form["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($form["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
								</td>
							</tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">Agente: </td>
						 	<td colspan="2" align="left" bgcolor=#ba9464 class="texto" valign="top"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<option value="'.$RResAgentes["Id"].'"'; if($RResAgentes["Id"]==$form["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgentes["Nombre"].'</option>';
	}
	$cadena.='		</select>
						 	</td>
							<td align="left" bgcolor="#ba9464" class="texto" valign="top">Debe: </td>
							<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">$ <input type="text" name="debe" id="debe" class="input" size="5" value="'.$form["debe"].'"></td>
						 </tr>';
	
	$cadena.=' <tr>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Total</td>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="hidden" name="idproducto" id="idproducto" value="">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_clientes_mostrador_pos(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_productos_clientes_mostrador_pos(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><img src="images/pixel.png" border="0" onload="document.fnotaventa.clave.focus()"><input type="submit" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_nota_nueva(xajax.getFormValues(\'fnotaventa\'))"></td>
						 </tr>';
	$bgcolor="#FFFFFF"; $i=1; $j=1; $array=array();
	if($form==NULL)
	{
		$partidas=1;
	}
	elseif($form!=NULL)
	{
		
		$ResIdProducto=mysql_fetch_array(mysql_query("SELECT Id, ".$form["pp"]." FROM productos WHERE Clave='".$form["clave"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
		if($form["idproducto"]==''){$form["idproducto"]=$ResIdProducto["Id"];}
		if($form["precio"]==''){$form["precio"]=$ResIdProducto[$form["pp"]];}
		if($form["total"]=='' OR $form["total"]==0){$form["total"]=$form["precio"]*$form["cantidad"];}
		
		if($borraprod==NULL)
		{

			//Revisa que exista la clave
			$ResCantidad=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$form["almacen"]." FROM inventario WHERE IdProducto='".$form["idproducto"]."' LIMIT 1"));
			
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0 OR $form["clave"]=='')
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#ba9464" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$form["partidas"];
			}
			//Revisa existencia en inventario
			else if(inventario_stock($form["idproducto"], $_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$form["almacen"])>=$form["cantidad"])
			{
				for($J=1; $J<$form["partidas"];$J++)
				{
					
					$ftotal=str_replace(',','',$form["total_".$J]);
					$arreglo=array($J, $form["idproducto_".$J], $form["cantidad_".$J], $form["clave_".$J], $form["precio_".$J], $ftotal);
					array_push($array, $arreglo);
					
				}
				if(!$agregado)
				{
					$ftotal=str_replace(',','',$form["total"]);
					$arreglo=array($J, $form["idproducto"], $form["cantidad"], $form["clave"], $form["precio"], $ftotal);
					array_push($array, $arreglo);
					$partidas=count($array)+1;
				}
			}
			//no hay existencia
			else
			{
				$cadena.='<tr>
									<th colspan="7" bgcolor="#ba9464" class="textomensaje">No puede vender un producto sin existencia</th>
								</tr>';
				$partidas=$form["partidas"];
			}	
			
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$form["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$form["total_".$i]);
					$arreglo=array($j, $form["idproducto_".$i], $form["cantidad_".$i], $form["clave_".$i], $form["precio_".$i], $ftotal);
					array_push($array, $arreglo);
					$j++;
				}
				$i++;
			}
			$partidas=$form["partidas"]-1;
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
							 		<a href="#" onclick="xajax_nota_nueva(xajax.getFormValues(\'fnotaventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0" onload="document.fnotaventa.clave.focus()"></a></td>
							 	</tr>';
			if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
			elseif($bgcolor="#CCCCCC"){$bgcolor='#FFFFFF';}
			
			$subtotal=$subtotal+$array[$T][5];
		}
	}
	$cadena.='<tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($subtotal, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	$cadena.='<tr>
							<th colspan="7" align="center" bgcolor="#FFFFFF" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
								<input type="hidden" name="totalnota" id="totalnota" value="'.$subtotal.'">
								<input type="button" name="botfinfact" id="botfinfact" value="Guardar>>" class="boton" onclick="xajax_finaliza_nota(xajax.getFormValues(\'fnotaventa\'), document.getElementById(\'reloj\').value)">
							</th>
						</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function factura_pos($form=NULL, $rfc=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <form name="fcliente" id="fcliente">
						<tr>
								<th colspan="7" align="center" bgcolor="#754200" class="texto3">Factura de Venta</th>
							</tr>
							<tr>
								<td colspan="2" aling="left" bgcolor="#ba9464" class="texto">RFC o Nombre:</td>
								<td colspan="5" align="left" bgcolor="#ba9464" class="texto">
									<input type="text" name="rfc" id="rfc" size="50" class="input" value="'.$rfc.'" onKeyUp="rfcnom.style.visibility=\'visible\'; xajax_rfc_nombre_clientepos(this.value)">
									<div id="rfcnom" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div> 
									<input type="button" name="botbuscliente" id="botbuscliente" value="Mostrar>>" class="boton" onclick="xajax_cliente_mostrador(xajax.getFormValues(\'fcliente\'))">
								</td>
							</tr>
							<tr>
								<td colspan="7" align="left" bgcolor="#ba9464" class="texto">
								<div id="datoscliente">';
	if($rfc!=NULL)
	{
		$ResCliente=mysql_query("SELECT * FROM clientes WHERE (RFC LIKE '%".$rfc."%' OR Nombre LIKE '%".$rfc."%') AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Mostrador='1' LIMIT 1");
		$RResCliente=mysql_fetch_array($ResCliente);
		$cadena.='<table border="0" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td align="left" class="texto">Nombre: </td>
							<th colspan="3" align="left" class="textorojo"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResCliente["Nombre"].'"> Obligatorio</th>
						</tr>
						<tr>
							<td align="left" class="texto">Direcci&oacute;n: </th>
							<th colspan="3" align="left" class="textorojo"><input type="text" name="direccion" id="direccion" class="input" size="50" value="'.$RResCliente["Direccion"].'"> Obligatorio</th>
						</tr>
						<tr>
							<td align="left" class="texto">Colonia: </td>
							<td align="left" class="textorojo"><input type="text" name="colonia" id="colonia" class="input" value="'.$RResCliente["Colonia"].'"> Obligatorio</td>
							<td align="left" class="texto">Deleg. / Municipio: </td>
							<td align="left" class="textorojo"><input type="text" name="ciudad" id="ciudad" class="input" value="'.$RResCliente["Municipio"].'"> Obligatorio</td>
						</tr>
						<tr>
							<td align="left" class="texto">Codigo Postal: </td>
							<td align="left" class="textorojo"><input type="text" name="cp" id="cp" class="input" value="'.$RResCliente["CP"].'"> Obligatorio</td>
							<td align="left" class="texto">Estado: </td>
							<td align="left" class="textorojo"><input type="text" name="estado" id="estado" class="input" value="'.$RResCliente["Estado"].'"> Obligatorio</td>
						</tr>
						<tr>
							<td align="left" class="texto">Telefono: </td>
							<td align="left" class="texto"><input type="text" name="telefono" id="telefono" class="input" value="'.$RResCliente["telefono"].'"></td>
							<td align="left" class="texto">Telefono 2: </td>
							<td align="left" class="texto"><input type="text" name="telefono2" id="telefono2" class="input" value="'.$RResCliente["telefono2"].'"></td>
						</tr>
						<tr>
							<td align="left" class="texto">Fax: </td>
							<td align="left" class="texto"><input type="text" name="fax" id="fax" class="input" value="'.$RResCliente["Fax"].'"></td>
							<td align="left" class="texto">Email: </td>
							<td align="left" class="texto"><input type="text" name="correoe" id="correoe" class="input" value="'.$RResCliente["CorreoE"].'"></td>
						</tr>
						<tr>
							<th colspan="4" align="center" class="texto"><input type="hidden" name="idcliente" id="idcliente" value="'.$RResCliente["Id"].'">';
	$cadena.='		<input type="button" name="botadcliente" id="botadcliente" value="Actualizar Cliente>>" class="boton">';
	$cadena.='	</th>
						</tr>
					</table>';
	}
	$cadena.='			</div>
								</td>
							</tr>
							</form>
							<form name="fnotaventa" id="fnotaventa">
							<tr>
							<td colspan="3" align="left" bgcolor="#ba9464" class="texto">Almacen: <select name="almacen" id="almacen">';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$form["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
								<td align="left" bgcolor="#ba9464" class="texto">Descuento: <select name="descuento" id="descuento" class="input">
									<option value="00"';if($form["descuento"]=='00'){$cadena.=' selected';}$cadena.='>Sin</option>
									<option value="01"';if($form["descuento"]=='01'){$cadena.=' selected';}$cadena.='>1</option>
									<option value="02"';if($form["descuento"]=='02'){$cadena.=' selected';}$cadena.='>2</option>
									<option value="03"';if($form["descuento"]=='03'){$cadena.=' selected';}$cadena.='>3</option>
									<option value="04"';if($form["descuento"]=='04'){$cadena.=' selected';}$cadena.='>4</option>
									<option value="05"';if($form["descuento"]=='05'){$cadena.=' selected';}$cadena.='>5</option>
									<option value="06"';if($form["descuento"]=='06'){$cadena.=' selected';}$cadena.='>6</option>
									<option value="07"';if($form["descuento"]=='07'){$cadena.=' selected';}$cadena.='>7</option>
									<option value="08"';if($form["descuento"]=='08'){$cadena.=' selected';}$cadena.='>8</option>
									<option value="09"';if($form["descuento"]=='09'){$cadena.=' selected';}$cadena.='>9</option>
									<option value="10"';if($form["descuento"]=='10'){$cadena.=' selected';}$cadena.='>10</option>
									</select> %
								<td colspan="3" align="left" bgcolor="#ba9464" class="texto">
									Precio: <select name="pp" id="pp">
									<option value="PrecioPublico"';if($form["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($form["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($form["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
								</td>
							</tr>
							<!--<tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#ba9464 class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$factura["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#ba9464" class="texto" valign="top">Pedido Num.:</td>
						 	<td algin="left" bgcolor="#ba9464" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="'.$factura["pedido"].'"></td>
						 </tr>-->
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">Agente: </td>
						 	<td colspan="5" align="left" bgcolor=#ba9464 class="texto" valign="top"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<option value="'.$RResAgentes["Id"].'"'; if($RResAgentes["Id"]==$form["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgentes["Nombre"].'</option>';
	}
	$cadena.='		</select>
						 	</td>
						 </tr>
						 <tr>
						 	<td colspan="7" align="left" bgcolor="#ba9464" class="texto" valig="top">
						 		Forma de Pago: <select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO"';if($form["fpago"]=='NO IDENTIFICADO'){$cadena.=' selected';}$cadena.='>NO IDENTIFICADO</option>
											<option value="EFECTIVO"';if($form["fpago"]=='EFECTIVO'){$cadena.=' selected';}$cadena.='>EFECTIVO</option>
											<option value="TARJETA DE CREDITO"';if($form["fpago"]=='TARJETA DE CREDITO'){$cadena.=' selected';}$cadena.='>TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO"';if($form["fpago"]=='TARJETA DE DEBITO'){$cadena.=' selected';}$cadena.='>TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA"';if($form["fpago"]=='TRANSFERENCIA ELECTRONICA'){$cadena.=' selected';}$cadena.='>TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE"';if($form["fpago"]=='CHEQUE'){$cadena.=' selected';}$cadena.='>CHEQUE</option>
										</select>&nbsp;&nbsp;Num. Cuenta: <input type="text" name="numcuenta" id="numcuenta" size="5" class="input" value="'.$form["numcuenta"].'">
						 		</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Total</td>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="hidden" name="idproducto" id="idproducto" value="">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_clientes_mostrador(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_productos_clientes_mostrador(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_factura_pos(xajax.getFormValues(\'fnotaventa\'), document.getElementById(\'rfc\').value)"></td>
						 </tr>';
	$bgcolor="#FFFFFF"; $i=1; $j=1; $array=array();
	if($form==NULL)
	{
		$partidas=1;
	}
elseif($form!=NULL)
	{
		if($borraprod==NULL)
		{
			//agrega partidas existentes
//			for($J=1; $J<$form["partidas"];$J++)
//			{
//				$ftotal=str_replace(',','',$form["total_".$J]);
//				$arreglo=array($J, $form["idproducto_".$J], $form["cantidad_".$J], $form["clave_".$J], $form["precio_".$J], $ftotal);
//				array_push($array, $arreglo);
//			}
			//Revisa que exista la clave
			$ResCantidad=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$form["almacen"]." FROM inventario WHERE IdProducto='".$form["idproducto"]."' LIMIT 1"));
			
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0 OR $form["precio"]==0 OR $form["precio"]=='0.00')
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#ba9464" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$form["partidas"];
			}
			//Revisa existencia en inventario
			else if($ResCantidad[$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$form["almacen"]]>=$form["cantidad"])
			{
				for($J=1; $J<$form["partidas"];$J++)
				{
					if($form["idproducto_".$J]==$form["idproducto"])
					{
						$ftotal=str_replace(',','',$form["total_".$J])+str_replace(',','',$form["total"]);
						$arreglo=array($J, $form["idproducto_".$J], ($form["cantidad_".$J]+$form["cantidad"]), $form["clave_".$J], $form["precio_".$J], $ftotal);
						array_push($array, $arreglo);
						$agregado=1;
					}
					else
					{
						$ftotal=str_replace(',','',$form["total_".$J]);
						$arreglo=array($J, $form["idproducto_".$J], $form["cantidad_".$J], $form["clave_".$J], $form["precio_".$J], $ftotal);
						array_push($array, $arreglo);
					}
				}
				if(!$agregado)
				{
					$ftotal=str_replace(',','',$form["total"]);
					$arreglo=array($J, $form["idproducto"], $form["cantidad"], $form["clave"], $form["precio"], $ftotal);
					array_push($array, $arreglo);
					$partidas=count($array)+1;
				}
			}
			//no hay existencia
			else
			{
				for($J=1; $J<$form["partidas"];$J++)
				{
					$ftotal=str_replace(',','',$form["total_".$J]);
					$arreglo=array($J, $form["idproducto_".$J], $form["cantidad_".$J], $form["clave_".$J], $form["precio_".$J], $ftotal);
					array_push($array, $arreglo);
				}
				$cadena.='<tr>
									<th colspan="7" bgcolor="#ba9464" class="textomensaje">No puede vender un producto sin existencia</th>
								</tr>';
				$partidas=$form["partidas"];
			}
			
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$form["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$form["total_".$i]);
					$arreglo=array($j, $form["idproducto_".$i], $form["cantidad_".$i], $form["clave_".$i], $form["precio_".$i], $ftotal);
					array_push($array, $arreglo);
					$j++;
				}
				$i++;
			}
			$partidas=$form["partidas"]-1;
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
							 		<a href="#" onclick="xajax_factura_pos(xajax.getFormValues(\'fnotaventa\'), \''.$rfc.'\', \''.$array[$T][0].'\')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
			elseif($bgcolor="#CCCCCC"){$bgcolor='#FFFFFF';}
			
			$subtotal=$subtotal+$array[$T][5];
		}
		
	}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	//$iva=$subtotal*$ivaa;
	$descuento='0.'.$form["descuento"];
	$sdescuento=$subtotal-($subtotal*$descuento);
	$iva=$sdescuento*$ivaa;
	$cadena.=' <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($subtotal, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	if($form["descuento"])
	{
		$cadena.='<tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Descuento -'.number_format($form["descuento"]).'%:</th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format(($subtotal*$descuento), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	}
	$cadena.=' <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($sdescuento, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Iva '.($ivaa*100).' %: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($iva, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format(($iva+$sdescuento), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	$cadena.='<tr>
							<td colspan="7" align="center" bgcolor="#FFFFFF" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
								<input type="hidden" name="subtotalfact" id="subtotalfact" value="'.$subtotal.'">
								<input type="hidden" name="ivafact" id="ivafact" value="'.$iva.'">
								<input type="hidden" name="totalfact" id="totalfact" value="'.($iva+$subtotal).'">
								<input type="button" name="botfinfact" id="botfinfact" value="Guardar>>" class="boton" onclick="xajax_finaliza_factura_pos(xajax.getFormValues(\'fnotaventa\'), document.getElementById(\'rfc\').value, document.getElementById(\'reloj\').value)">
							</td>
						</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function cliente_mostrador($cliente, $accion=NULL)
{
	include ("conexion.php");
	
	if($cliente["nombre"]=='' OR $cliente["direccion"]=='' OR $cliente["colonia"]=='' OR $cliente["ciudad"]=='' OR 
		 $cliente["estado"]=='' OR $cliente["cp"]=='' OR $cliente["rfc"]=='')
	{
		 	$mensaje='<p class="textomensaje">Debe de llenar todos los campos obligatorios</p>';
	}
	
	elseif($accion=='agregar')
	{
		mysql_query("INSERT INTO clientes (Empresa, Sucursal, Nombre, Direccion, Colonia, Ciudad, CP, Estado, RFC, Telefono, Telefono2, Fax, CorreoE, Mostrador)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($cliente["nombre"])."', '".utf8_decode($cliente["direccion"])."',
  																							'".utf8_decode($cliente["colonia"])."', '".utf8_decode($cliente["ciudad"])."', '".$cliente["cp"]."', 
  																							'".utf8_decode($cliente["estado"])."', '".utf8_decode($cliente["rfc"])."', '".$cliente["telefono"]."',
  																							'".$cliente["telefono2"]."', '".$cliente["fax"]."', '".$cliente["correoe"]."', '1')") or die(mysql_error());
		$mensaje='<p class="textomensaje">Cliente Agregado Satisfactoriamente</p>';
		
	}
	elseif($accion=='editar')
	{
		mysql_query("UPDATE clientes SET Nombre='".utf8_decode($cliente["nombre"])."',
  																						Direccion='".utf8_decode($cliente["direccion"])."', 
  																						Colonia='".utf8_decode($cliente["colonia"])."',
  																						Municipio='".utf8_decode($cliente["ciudad"])."',
  																						Estado='".utf8_decode($cliente["estado"])."',
  																						CP='".$cliente["cp"]."',
  																						RFC='".$cliente["rfc"]."',
  																						Telefono='".$cliente["telefono"]."',
  																						Telefono2='".$cliente["telefono2"]."',
  																						Fax='".$cliente["fax"]."',
  																						CorreoE='".$cliente["correoe"]."'
  																			WHERE Id='".$cliente["idcliente"]."'") or die(mysql_error());
		$mensaje='<p class="textomensaje">Cliente Actualizado Satisfactoriamente</p>';
		
	}
	
	$ResCliente=mysql_query("SELECT * FROM clientes WHERE RFC='".$cliente["rfc"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Mostrador='1' LIMIT 1");
	$RResCliente=mysql_fetch_array($ResCliente);
	
	$cadena='<table border="0" cellpadding="5" cellspacing="0" align="center">';
	if($mensaje)
	{
		$cadena.='<tr><th colspan="4" align="center">'.$mensaje.'</th></tr>';
	}
	$cadena.='<tr>
							<td align="left" class="texto">Nombre: </td>
							<th colspan="3" align="left" class="textorojo"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResCliente["Nombre"].'"> Obligatorio</th>
						</tr>
						<tr>
							<td align="left" class="texto">Direcci&oacute;n: </th>
							<th colspan="3" align="left" class="textorojo"><input type="text" name="direccion" id="direccion" class="input" size="50" value="'.$RResCliente["Direccion"].'"> Obligatorio</th>
						</tr>
						<tr>
							<td align="left" class="texto">Colonia: </td>
							<td align="left" class="textorojo"><input type="text" name="colonia" id="colonia" class="input" value="'.$RResCliente["Colonia"].'"> Obligatorio</td>
							<td align="left" class="texto">Deleg. / Municipio: </td>
							<td align="left" class="textorojo"><input type="text" name="ciudad" id="ciudad" class="input" value="'.$RResCliente["Municipio"].'"> Obligatorio</td>
						</tr>
						<tr>
							<td align="left" class="texto">Codigo Postal: </td>
							<td align="left" class="textorojo"><input type="text" name="cp" id="cp" class="input" value="'.$RResCliente["CP"].'"> Obligatorio</td>
							<td align="left" class="texto">Estado: </td>
							<td align="left" class="textorojo"><input type="text" name="estado" id="estado" class="input" value="'.$RResCliente["Estado"].'"> Obligatorio</td>
						</tr>
						<tr>
							<td align="left" class="texto">Telefono: </td>
							<td align="left" class="texto"><input type="text" name="telefono" id="telefono" class="input" value="'.$RResCliente["telefono"].'"></td>
							<td align="left" class="texto">Telefono 2: </td>
							<td align="left" class="texto"><input type="text" name="telefono2" id="telefono2" class="input" value="'.$RResCliente["telefono2"].'"></td>
						</tr>
						<tr>
							<td align="left" class="texto">Fax: </td>
							<td align="left" class="texto"><input type="text" name="fax" id="fax" class="input" value="'.$RResCliente["Fax"].'"></td>
							<td align="left" class="texto">Email: </td>
							<td align="left" class="texto"><input type="text" name="correoe" id="correoe" class="input" value="'.$RResCliente["CorreoE"].'"></td>
						</tr>
						<tr>
							<th colspan="4" align="center" class="texto"><input type="hidden" name="idcliente" id="idcliente" value="'.$RResCliente["Id"].'">';
	if(mysql_num_rows($ResCliente)!=0)
	{
		$cadena.='<input type="button" name="boteditcliente" id="boteditcliente" value="Actualizar Cliente>>" class="boton" onclick="xajax_cliente_mostrador(xajax.getFormValues(\'fcliente\'), \'editar\')">';
	}
	else
	{
		$cadena.='<input type="button" name="botadcliente" id="botadcliente" value="Agregar Cliente>>" class="boton" onclick="xajax_cliente_mostrador(xajax.getFormValues(\'fcliente\'), \'agregar\')">';
	}
	$cadena.='	</th>
						</tr>
					</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("datoscliente","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function claves_clientes_mostrador($clave, $cantidad, $almacen, $pp)
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="0" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">Clave</td>
							<td bgcolor="#754200" align="center" class="texto3">Producto</td>
							<td bgcolor="#754200" align="center" class="texto3">Precio</td>
						</tr>';

	$ResClaves=mysql_query("SELECT Id, Clave, Nombre, ".$pp." FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		
			$clave=$RResClaves["Clave"];
			$precio=$RResClaves[$pp];
			
		
		 $cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>
		 					 <td bgcolor="#96d096" align="right">$ '.$pp.'</td>';
		 
		$cadena.='</tr>';
		//}
	}
	$cadena.='</table>';
	
	$cadena="SELECT Id, Clave, Nombre, ".$pp." FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25";
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function productos_clientes_mostrador($producto, $cantidad, $almacen, $pp) //sirve para buscar el producto por nombre
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="0" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">Clave</td>
							<td bgcolor="#754200" align="center" class="texto3">Producto</td>
							<td bgcolor="#754200" align="center" class="texto3">'.$almacen.'</td>
						</tr>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre, Mondea, ".$pp." FROM productos WHERE Nombre LIKE '%".$producto."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC LIMIT 25");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
			if($RResProductos["Moneda"]=='MN'){$precio=$RResProductos[$pp];}
			elseif($RResProductos["Moneda"]=='USD')
			{
				$ResTC=mysql_fetch_array(mysql_query("SELECT * FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1"));
				$precio=$RResProductos[$pp]*$ResTC["USD"];
			}
		$cadena.='<tr>';
		//$clavepactada=mysql_query("SELECT ClaveP, PrecioPactado FROM prodpactados WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente='".$cliente."' AND Producto='".$RResProductos["Id"]."' LIMIT 1");
		//if(mysql_num_rows($clavepactada)==0)
		//{
		 $cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Nombre"].'</a></td>';
		 $ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$RResProductos["Id"]."' LIMIT 1"));
		 $cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResCantAlma[$almacen2].'</a></td>';
		/*}
		else
		{
			$ResClavepactada=mysql_fetch_array($clavepactada);
			$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$ResClavepactada["PrecioPactado"].'\'; document.fnotaventa.clave.value=\''.$ResClavepactada["ClaveP"].'\'; document.fnotaventa.total.value=\''.number_format($ResClavepactada["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResClavepactada["ClaveP"].'</a></td>';
			$cadena.='<td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$ResClavepactada["PrecioPactado"].'\'; document.fnotaventa.clave.value=\''.$ResClavepactada["ClaveP"].'\'; document.fnotaventa.total.value=\''.number_format($ResClavepactada["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Nombre"].'</a></td>';
		$ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$RResProductos["Id"]."' LIMIT 1"));
		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$ResClavepactada["PrecioPactado"].'\'; document.fnotaventa.clave.value=\''.$ResClavepactada["ClaveP"].'\'; document.fnotaventa.total.value=\''.number_format($ResClavepactada["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResCantAlma[$almacen2].'</a></td>';
		}*/
		
		$cadena.='</tr>';
		
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function finaliza_nota($nota, $hora)
{
	include ("conexion.php");
	
	$fechahora=date("Y-m-d").' '.$hora;
	
	//crear almance
	$almacen=$_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$nota["almacen"];
		//Seleccionamos el numero de nota
		$Nota=mysql_query("SELECT NumNota FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumNota DESC LIMIT 1");
		$ResNota=mysql_fetch_array($Nota);
		
		//ingresamos la nota
		mysql_query("INSERT INTO nota_venta (Empresa, Sucursal, Agente, NumNota, Fecha, Total, Debe)
																 VALUES ('".$_SESSION["empresa"]."', 
																		 '".$_SESSION["sucursal"]."', 
																		 '".$nota["agente"]."', 
																		 '".($ResNota["NumNota"]+1)."', 
																		 '".date("Y-m-d")."', 
																		 '".$nota["totalnota"]."', 
																		 '".$nota["debe"]."')") or die(mysql_error());
		//otenemos el id de la nota
		$ResIdNota=mysql_fetch_array(mysql_query("SELECT Id FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
		//ingresamos los productos a la nota
		for($i=1; $i<$nota["partidas"]; $i++)
		{
			$ResCosto=mysql_fetch_array(mysql_query("SELECT Costo FROM productos WHERE Id='".$nota["idproducto_".$i]."' LIMIT 1"));
			
			mysql_query("INSERT INTO det_nota_venta (IdNotaVenta, IdProducto, Clave, Cantidad, Hora, Costo, PrecioUnitario, Importe)
											 VALUES ('".$ResIdNota["Id"]."', 
													 '".$nota["idproducto_".$i]."', 
													 '".$nota["clave_".$i]."',
													 '".$nota["cantidad_".$i]."', 
													 '".$fechahora."',
													 '".$ResCosto["Costo"]."',
													 '".$nota["precio_".$i]."', 
													 '".$nota["total_".$i]."')") or die(mysql_error());
			//restamos los productos del inventario
			mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."-".$nota["cantidad_".$i]." WHERE IdProducto='".$nota["idproducto_".$i]."'");
			//registra el movimiento de inventario
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdNotaVenta, Fecha, Descripcion)
																			VALUES ('".$almacen."', '".$nota["idproducto_".$i]."', 'Salida', '".$nota["cantidad_".$i]."', 
																						  '".$ResIdNota["Id"]."', '".date("Y-m-d")."', 'Venta de Mostrador')");
		}
		//incrementamos el numero de nota
		mysql_query("UPDATE sucursales SET Nota='".($ResNota["NumNota"]+1)."' WHERE Empresa='".$_SESSION["empresa"]."' AND Id='".$_SESSION["sucursal"]."'") or die(mysql_error());
		
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <tr>
								<th colspan="7" align="center" bgcolor="#754200" class="texto3">Nota de Venta</th>
							</tr>
							<tr>
								<td colspan="7" align="left" bgcolor="#ba9464" class="texto">Se genero la nota de venta Num.: '.($ResNota["NumNota"]+1).'</td>
							<tr>
							<tr>
								<td colspan="7" align="right" bgcolor="#ba9464" class="texto">';
	
	$cadena.='<a href="pos/ticket.php?idnota='.$ResIdNota["Id"].'" target="_blank">Imprimir >></a>';
	
	$cadena.='		</td>
							</tr>
						</table>
			<iframe src="pos/ticket.php?idnota='.$ResIdNota["Id"].'" width="1" height="1" scrolling="no" frameborder="0"></iframe>';
			
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <form name="fnotaventa" id="fnotaventa"  action="javascript:void(null)">
						<tr>
								<td colspan="7" align="center" bgcolor="#754200" class="texto3">Nota de Venta</td>
							</tr>
							<tr>
							<td colspan="4" align="left" bgcolor="#ba9464" class="texto">Almacen: <select name="almacen" id="almacen">';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$form["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
								<td colspan="4" align="left" bgcolor="#ba9464" class="texto">
									Precio: <select name="pp" id="pp">
									<option value="PrecioPublico"';if($form["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($form["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($form["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
								</td>
							</tr>
							<!--<tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#ba9464 class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$factura["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#ba9464" class="texto" valign="top">Pedido Num.:</td>
						 	<td algin="left" bgcolor="#ba9464" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="'.$factura["pedido"].'"></td>
						 </tr>-->
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">Agente: </td>
						 	<td colspan="5" align="left" bgcolor=#ba9464 class="texto" valign="top"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<option value="'.$RResAgentes["Id"].'"'; if($RResAgentes["Id"]==$form["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgentes["Nombre"].'</option>';
	}
	$cadena.='		</select>
						 	</td>
						 </tr>';
	
	$cadena.=' <tr>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Total</td>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="hidden" name="idproducto" id="idproducto" value="">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_clientes_mostrador_pos(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_productos_clientes_mostrador_pos(this.value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><img src="images/pixel.png" border="0" onload="document.fnotaventa.clave.focus()"><input type="submit" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_nota_nueva(xajax.getFormValues(\'fnotaventa\'))"></td>
						 </tr>';
		$cadena.='<tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($subtotal, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	$cadena.='<tr>
							<th colspan="7" align="center" bgcolor="#FFFFFF" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
								<input type="hidden" name="totalnota" id="totalnota" value="'.$subtotal.'">
								<input type="button" name="botfinfact" id="botfinfact" value="Guardar>>" class="boton" onclick="xajax_finaliza_nota(xajax.getFormValues(\'fnotaventa\'))">
							</th>
						</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function finaliza_factura_pos($factura, $rfc, $reloj)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <tr>
								<th colspan="7" align="center" bgcolor="#754200" class="texto3">Factura de Venta</th>
							</tr>
							<tr>
								<td colspan="7" align="left" bgcolor="#ba9464" class="texto">';
	if($factura["partidas"]==1)
	{
		$cadena.='<p class="textomensaje">No puede facturar partidas en blanco</p>
		</td>
							</tr>
						</table>';
	}
	else
	{
		
	//Busca cliente
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM clientes WHERE RFC='".$rfc."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	//armamos almacen
	$almacen=$_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$factura["almacen"];
	//armamos fecha 
	$fecha=date("Y-m-d").' '.$reloj;
	//consultamos factura
	$ResNumFact=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	//Revisamos si hay folios disponibles
	if($ResNumFact["Factura"]>$ResNumFact["FolioF"]) //no hay folios disponibles
	{
		$cadena.='<p class="textomensaje">Lo sentimos, No hay folios disponibles para emitir facturas, consulte con el administrador</p>
								</td>
							</tr>
						</table>';
	}
	else // si hay folios disponibles
	{
		//incrementamos el numero de la factura
		mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Id='".$ResNumFact["Id"]."'");
		//guardamos la factura
		mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, Fecha, Subtotal, Descuento, Iva, Total, Status, Agente, Fpago, Ncuenta, Version)
															 VALUES ('".$ResNumFact["Serie"]."', '".$ResNumFact["Factura"]."', '".$_SESSION["empresa"]."',
															 				 '".$_SESSION["sucursal"]."', '".$ResCliente["Id"]."', '".$fecha."', '".$factura["subtotalfact"]."', '".$factura["descuento"]."',
															 				 '".$factura["ivafact"]."', '".$factura["totalfact"]."', 'Pendiente', '".$factura["agente"]."', '".$factura["fpago"]."', '".$factura["numcuenta"]."', '".$ResNumFact["Version"]."')");
		//obtenemos el Id
		$idfactura=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumFactura='".$ResNumFact["Factura"]."' LIMIT 1"));
		//guardamos las partidas
		for($i=1; $i<$factura["partidas"]; $i++)
		{
			mysql_query("INSERT INTO detfacturas (IdFactura, Producto, Clave, Cantidad, PrecioUnitario, Subtotal)
																		VALUES ('".$idfactura["Id"]."', '".$factura["idproducto_".$i]."', '".$factura["clave_".$i]."',
																						'".$factura["cantidad_".$i]."', '".$factura["precio_".$i]."', '".$factura["total_".$i]."')")or die(mysql_error());
			//descontamos producto de inventario
			mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."-".$factura["cantidad_".$i]." WHERE IdProducto='".$factura["idproducto_".$i]."'") or die(mysql_error());
			//registramos el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdFactura, Fecha, Descripcion)
																			VALUES ('".$almacen."', '".$factura["idproducto_".$i]."', 'Salida', '".$factura["cantidad_".$i]."', 
																							'".$idfactura["Id"]."', '".date("Y-m-d")."', 'Venta de Mostrador')") or die(mysql_error());
		}
		
//Genera Cadena Original
		//datos de la factura
		$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura["Id"]."' LIMIT 1"));
		$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));
		$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura["Id"]."' ORDER BY Id ASC");
		
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
		
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResProd["Unidad"]."' AND PerteneceA='unidades' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'	"));
		//cantidad
		$cadenaoriginal.=$RResPartidas["Cantidad"].'|';
		//unidad
		if($ResUnidad["Nombre"]){$cadenaoriginal.=$ResUnidad["Nombre"].'|';}
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
		$fp = fopen ("certificados2/sellos2/".$idfactura["Id"].".txt", "w+");
  	     fwrite($fp, $cadenaoriginal_sellada);
		fclose($fp);
		//archivo .key
		$key='certificados/'.$ResFFacturas["ArchivoCadena"];
		//sellamos archivo
		exec("openssl dgst -sha1 -sign $key certificados2/sellos2/".$idfactura["Id"].".txt | openssl enc -base64 -A > certificados2/sellos2/sello_".$idfactura["Id"].".txt");
		//leer sello
		$f=fopen("certificados2/sellos2/".$idfactura["Id"].".txt",'r');
 	  $selloemisor=fread($f,filesize("certificados2/sellos2/sello_".$idfactura["Id"].".txt"));
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

$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura["Id"]."' ORDER BY Id ASC");
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	if($ResFactura["NumOrden"]==0)//no es de orden
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
	}
	elseif($ResFactura["NumOrden"]!=0)//si es de orden
	{
		$ProdOV=mysql_fetch_array(mysql_query("SELECT Producto FROM detordenventa WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1")); //selecciona el producto de la orden de venta
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$ProdOV["Producto"]."' LIMIT 1"));//Selecciona los datos del producto
	}
	
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
													WHERE Id='".$idfactura["Id"]."'");
		
			
		
		
		$cadena.='<p class="textomensaje">Se genero la factura Num.: '.$ResNumFact["Factura"].' para el cliente: '.$ResCliente["Nombre"].'</p>
								</td>
							</tr>
							<tr>
								<td colspan="7" align="right" bgcolor="#ba9464" class="texto">
									<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/factura.php?idfactura='.$idfactura["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/factura2_2.php?idfactura='.$idfactura["Id"].'&empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"];}$cadena.='" target="_blank">Imprimir Factura</a>
								</td>
							</tr>
						</table>';
	
	}
	}
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function factura_dia($reloj, $fechac)
{
	include ("conexion.php");
	
	//creamos reloj
	$fecha=date("Y-m-d").' '.$reloj;
	//buscamos el cliente
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND RFC='xaxx010101000' LIMIT 1"));
	//buscamos el folio de factura
	$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	//Revisamos si hay folios disponibles
	if($ResNumFact["Factura"]>$ResNumFact["FolioF"]) //no hay folios disponibles
	{
		$mensaje.='<p class="textomensaje">Lo sentimos, No hay folios disponibles para emitir facturas, consulte con el administrador</p>';
	}
	else
	{
		$partida='Venta Mostrador ';
		$observaciones='Venta Correspondiente a las notas: ';
		//incrementamos la factura
		mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Id='".$ResFactura["Id"]."'");
		//Buscamos notas
		$ResNotas=mysql_query("SELECT * FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fechac["anno"].'-'.$fechac["mes"].'-'.$fechac["dia"]."' AND Status='Pagada' ORDER BY NumNota ASC");
		while($RResNotas=mysql_fetch_array($ResNotas))
		{
			//Generamos Partida
			$observaciones.=$RResNotas["NumNota"].', ';
			//Sumamos total
			$total=$total+$RResNotas["Total"];
		}
		//calculamos Iva
		$viva=1.16;
		$subtotal=$total/$viva;
		//creamos la factura
		mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, Fecha, Subtotal, Iva, Total, Status, Observaciones, Fpago, Version, Usuario)
															 VALUES ('".$ResFactura["Serie"]."', '".$ResFactura["Factura"]."', '".$_SESSION["empresa"]."', 
															 				 '".$_SESSION["sucursal"]."', '".$ResCliente["Id"]."', '".$fecha."', '".$subtotal."', '".$iva."',
															 				 '".$total."', 'Pendiente', '".$observaciones."', 'NO IDENTIFICADO', '".$ResFactura["Version"]."', '".$_SESSION["usuario"]."')")or die(mysql_error());
		//obtenemos el Id de la factura
		$ResFactId=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
		//Ingresamos la Partida
		mysql_query("INSERT INTO detfacturas (IdFactura, Unidad, Descripcion, Cantidad, PrecioUnitario, Subtotal, Usuario)
																	VALUES ('".$ResFactId["Id"]."', 's/u', '".$partida."', '1', '".$subtotal."', '".$subtotal."', '".$_SESSION["usuario"]."')") or die(mysql_error());

//Genera Cadena Original
		//datos de la factura
		$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$ResFactId["Id"]."' LIMIT 1"));
		$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));
		$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$ResFactId["Id"]."' ORDER BY Id ASC");
		
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
		//cantidad
		$cadenaoriginal.=$RResPartidas["Cantidad"].'|';
		//unidad
		$cadenaoriginal.=$RResPartidas["Nombre"].'|';
		//numero de identificacion (clave)
		$cadenaoriginal.=$RResPartidas["Unidad"].'|';
		//descripcion
		$cadenaoriginal.=$RResPartidas["Descripcion"].'|';
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
		$fp = fopen ("certificados2/sellos2/".$idfactura["Id"].".txt", "w+");
  	     fwrite($fp, $cadenaoriginal_sellada);
		fclose($fp);
		//archivo .key
		$key='certificados/'.$ResFFacturas["ArchivoCadena"];
		//sellamos archivo
		exec("openssl dgst -sha1 -sign $key certificados2/sellos2/".$idfactura["Id"].".txt | openssl enc -base64 -A > certificados2/sellos2/sello_".$idfactura["Id"].".txt");
		//leer sello
		$f=fopen("certificados2/sellos2/".$idfactura["Id"].".txt",'r');
 	  $selloemisor=fread($f,filesize("certificados2/sellos2/sello_".$idfactura["Id"].".txt"));
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

$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura["Id"]."' ORDER BY Id ASC");
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	$xml.='<Concepto cantidad="'.$RResPartidas["Cantidad"].'" ';
	
	$xml.='unidad="'.$RResPartidas["Unidad"].'" noIdentificacion="'.$RResPartidas["Clave"].'" descripcion="'.$RResPartidas["Descripcion"].'" noIdentificacion="'.$RResPartidas["Clave"].'"';
	
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
													WHERE Id='".$ResFactId["Id"]."'");
		
			
		
			
		
		
		
		$mensaje.='<p class="textomensaje">Se Genero la Factura '.$ResFactura["Factura"].' para la venta en mostrador';
	}
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <tr>
								<th colspan="7" align="center" bgcolor="#754200" class="texto3">Nota de Venta</th>
							</tr>
							<tr>
								<td colspan="7" align="left" bgcolor="#ba9464" class="texto">'.$mensaje.'</td>
							</tr>
								<td colspqn="7" align="right" bgcolor="#ba9464" class="texto">
									<a href="clientes/factura.php?idfactura='.$ResFactId["Id"].'" target="_blank">Imprimir >></a>
								</td>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function corte_caja($fechac=NULL)
{
	include ("conexion.php");
	
	if($fechac==NULL){$fecha=date("Y").'-'.date("m").'-'.date("d"); $clasificado='notas';}
	else{$fecha=$fechac["anno"].'-'.$fechac["mes"].'-'.$fechac["dia"]; $clasificado=$fechac["clasificado"];}
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="4" align="right" bgcolor="#FFFFFF" class="texto">| <a href="pos/corteexcel.php?tipo='.$clasificado.'&fecha='.$fecha.'" target="_blank">Exportar a Excel</a> |</td>
							</tr>
							<tr>
								<th colspan="4" align="center" bgcolor="#FFFFFF" class="texto">
								<form name="fdcorte" id="fdcorte">
									<input type="radio" name="clasificado" id="clasificado" value="notas"';if($clasificado=='notas'){$cadena.=' checked';}$cadena.='> Resumen por Num. Notas <input type="radio" name="clasificado" id="clasificado" value="horario"';if($clasificado=='horario'){$cadena.=' checked';}$cadena.='>Resumen por Horas <br /><br />
									Dia de Corte: <select name="dia" id="dia">';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$fecha[8].$fecha[9]){$cadena.='selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
										<option value="01"';if($fecha[5].$fecha[6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
										<option value="02"';if($fecha[5].$fecha[6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
										<option value="03"';if($fecha[5].$fecha[6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
										<option value="04"';if($fecha[5].$fecha[6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
										<option value="05"';if($fecha[5].$fecha[6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
										<option value="06"';if($fecha[5].$fecha[6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
										<option value="07"';if($fecha[5].$fecha[6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
										<option value="08"';if($fecha[5].$fecha[6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
										<option value="09"';if($fecha[5].$fecha[6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
										<option value="10"';if($fecha[5].$fecha[6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
										<option value="11"';if($fecha[5].$fecha[6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
										<option value="12"';if($fecha[5].$fecha[6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
									</select><select name="anno" id="anno">';
	for($i=2011; $i<=date("Y"); $i++)
	{
		$cadena.='			<option value="'.$i.'"';if($fecha[0].$fecha[1].$fecha[2].$fecha[3]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select><input type="button" name="botcortecaja" id="botcortecaja" value="Consultar>>" class="boton" onclick="xajax_corte_caja(xajax.getFormValues(\'fdcorte\'))">
									</form>
								</th>
							</tr>
					</table>';
	
	if($clasificado=='notas')
	{
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="9" align="center" bgcolor="#754200" class="texto3">Nota de Venta</th>
							</tr>
							<tr>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#754200" class="texto3">Num. Nota</td>
								<td align="center" bgcolor="#754200" class="texto3">Importe</td>
								<td align="center" bgcolor="#754200" class="texto3">Debe</td>
								<td align="center" bgcolor="#754200" class="texto3">Total</td>
								<td align="center" bgcolor="#754200" class="texto3">Status</td>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
							</tr>';
	$bgcolor='#FFFFFF'; $J=1;
	$ResNotas=mysql_query("SELECT * FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fecha."' ORDER BY NumNota ASC");
	while($RResNotas=mysql_fetch_array($ResNotas))
	{
		$cadena.='<tr>
								<td align="center" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto">'.$J.'</td>
								<td align="center" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto">'.$RResNotas["NumNota"].'</td>
								<td align="right" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto">$'.number_format($RResNotas["Total"], 2).'</td>
								<td align="right" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto">$'.number_format($RResNotas["Debe"], 2).'</td>
								<td align="right" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto">$'.number_format(($RResNotas["Total"]-$RResNotas["Debe"]), 2).'</td>
								<td align="right" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto">'.$RResNotas["Status"].'</td>
								<td align="right" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto"><a href="pos/ticket.php?idnota='.$RResNotas["Id"].'" target="_blank">Imprimir</a></td>
								<td align="right" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class="texto"><a href="#" onclick="xajax_detalle_nota(\''.$RResNotas["Id"].'\')">Detalle</a></td>
								<td align="center" bgcolor="';if($RResNotas["Debe"]!='0.00'){$cadena.='#FFFF00';}else{$cadena.=$bgcolor;}$cadena.='" class=texto"></td>
							</tr>';
	
	
		$J++;
		if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
		elseif($bgcolor=="#CCCCCC"){$bgcolor='#FFFFFF';}
		
		if($RResNotas["Status"]=='Pagada')
		{
		$total=$total+$RResNotas["Total"];
		}
							
	}
	
	$ResGastos=mysql_query("SELECT SUM(Cantidad) AS TotalGastos FROM gastos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fecha."'");
	$RResGastos=mysql_fetch_array($ResGastos);
	$ResDebeAdeudo=mysql_query("SELECT SUM(Cantidad) AS TotalDebeAdeudo FROM debeadeudos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fecha."'");
	$RResDebeAdeudo=mysql_fetch_array($ResDebeAdeudo);
	$ResDebe=mysql_query("SELECT SUM(Debe) AS TDebe FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fecha."'");
	$RResDebe=mysql_fetch_array($ResDebe);
	
	$cadena.='		</table>
					<p>
					<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<th colspan="6" align="center" bgcolor="#754200" class="texto3">Resumen</th>
					</tr>
					<tr>
						<td colspan="2" align="right" bgcolor="'.$bgcolor.'" class="texto">Subtotal: </td>
						<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($total, 2).'</td>
						<td colspan="3" align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
					</tr>';
	if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}elseif($bgcolor=="#CCCCCC"){$bgcolor='#FFFFFF';}
	$cadena.='		<tr>
						<td colspan="2" align="right" bgcolor="'.$bgcolor.'" class="texto">Debe: </td>
						<td align="right" bgcolor="'.$bgcolor.'" class="texto">- $ '.number_format($RResDebe["TDebe"], 2).'</td>
						<td colspan="3" align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
					</tr>';
	if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}elseif($bgcolor=="#CCCCCC"){$bgcolor='#FFFFFF';}
	$cadena.='		<tr>
						<td colspan="2" align="right" bgcolor="'.$bgcolor.'" class="texto"><a href="#" onclick="xajax_gastos(\'\', \''.$fecha.'\')">Gastos:</a> </td>
						<td align="right" bgcolor="'.$bgcolor.'" class="texto">- $ '.number_format($RResGastos["TotalGastos"], 2).'</td>
						<td colspan="3" align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
					</tr>';
	if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}elseif($bgcolor=="#CCCCCC"){$bgcolor='#FFFFFF';}
	$cadena.='		<tr>
						<td colspan="2" align="right" bgcolor="'.$bgcolor.'" class="texto">Debe (Pago Adeudos): </td>
						<td align="right" bgcolor="'.$bgcolor.'" class="texto">+ $ '.number_format($RResDebeAdeudo["TotalDebeAdeudo"], 2).'</td>
						<td colspan="3" align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
					</tr>';
	if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}elseif($bgcolor=="#CCCCCC"){$bgcolor='#FFFFFF';}
	$cadena.='		<tr>
								<td colspan="2" align="right" bgcolor="'.$bgcolor.'" class="texto">Total: </td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format(((($total-$RResGastos["TotalGastos"])-$RResDebe["TDebe"])+$RResDebeAdeudo["TotalDebeAdeudo"]), 2).'</td>
								<td colspan="3" align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
							</tr>
						</table>';
	/*/facturas de venta
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="8" align="center" bgcolor="#754200" class="texto3">Facturas de Venta</th>
							</tr>
							<tr>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#754200" class="texto3">Num. Factura</td>
								<td align="center" bgcolor="#754200" class="texto3">Cliente</td>
								<td align="center" bgcolor="#754200" class="texto3">Importe</td>
								<td align="center" bgcolor="#754200" class="texto3">Iva</td>
								<td align="center" bgcolor="#754200" class="texto3">Total</td>
								<td align="center" bgcolor="#754200" class="texto3">Status</td>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
							</tr>';
	$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha LIKE '".$fecha."%' ORDER BY NumFactura ASC");
	$bgcolor='#FFFFFF'; $J=1;
	while($RResFacturas=mysql_fetch_array($ResFacturas))
	{
		$cliente=mysql_fetch_array(mysql_query("SELECT Nombre, RFC, Mostrador FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
		if($cliente["Mostrador"]==1)
		{
			$cadena.='<tr>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$J.'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResFacturas["NumFactura"].'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$cliente["Nombre"].'</td>
									<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResFacturas["Subtotal"], 2).'</td>
									<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResFacturas["Iva"], 2).'</td>
									<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResFacturas["Total"], 2).'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResFacturas["Status"].'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">
										<a href="#" onclick="xajax_cancela_factura(\''.$RResFacturas["Id"].'\')"><img src="images/x.png" border="0"></a></td>
								</tr>';
			if($RResFacturas["Status"]!='Cancelada')
			{
				$totalf=$totalf+$RResFacturas["Total"];
			}
			$J++;
			if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
			elseif($bgcolor=="#CCCCCC"){$bgcolor='#FFFFFF';}
		}
	}
	$cadena.='	<tr>
								<td colspan="5" align="right" bgcolor="'.$bgcolor.'" class="texto">Total: </td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($totalf, 2).'</td>
								<td colspan="2" align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
							</tr>
							
						</table>';
						*/
	}
	elseif($clasificado=='horario')
	{
		$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="6" align="center" bgcolor="#754200" class="texto3">Venta Por Hora</th>
							</tr>
							<tr>
								<td align="center" bgcolor="#754200" class="texto3">Hora</td>
								<td align="center" bgcolor="#754200" class="texto3">Num. Productos</td>
								<td align="center" bgcolor="#754200" class="texto3">Importe</td>
								<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
							</tr>';
		$bgcolor="#FFFFFF";
		for($z=7;$z<=22; $z++)
		{
			if($z<=9){$z='0'.$z;}
			//$ResProductos=mysql_query("SELECT SUM(Cantidad) AS TotalProductos FROM det_nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Hora>='".$fecha." ".$z.":00:00' AND Hora<='".$fecha." ".$z.":59:59'");
			//$numProd=mysql_fetch_array($ResProductos);
			$ResProductos=mysql_fetch_array(mysql_query("SELECT Sum(Importe) AS TotalHora, Sum(Cantidad) AS TotalProductos FROM det_nota_venta WHERE Hora>='".$fecha." ".$z.":00:00' AND Hora<='".$fecha." ".$z.":59:59'"));
			$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$z.':00</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$ResProductos["TotalProductos"].'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($ResProductos["TotalHora"],2).'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><a href="#" onclick="xajax_ver_detalle(\'hora\', \''.$z.'\', \''.$fecha.'\')">Ver detalle</a></td>
							</tr>';
			if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
			elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
			
			$totalproductos=$totalproductos+$ResProductos["TotalProductos"];
			$ventatotal=$ventatotal+$ResProductos["TotalHora"];
		}
		$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"></td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$totalproductos.'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($ventatotal,2).'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><a href="#" onclick="xajax_ver_detalle(\'hora\', \'00\', \''.$fecha.'\')">Ver detalle</a></td>
							</tr>';
		$cadena.='</table>';
		
	}
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function cancela_nota($idnota, $cancela='no')
{
	include ("conexion.php");
	
	$ResNota=mysql_fetch_array(mysql_query("SELECT * FROM nota_venta WHERE Id='".$idnota."' LIMIT 1"));
	
	if($cancela=='no')
	{
		$mensaje='Esta seguro de cancelar la Nota Num: '.$ResNota["NumNota"].'<br />
							<a href="#" onclick="'.activapermisos('xajax_cancela_nota(\''.$idnota.'\', \'si\')', 'cancelar').'">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_corte_caja()">No</a>';
	}
	else
	{
		//selecciona los productos de la nota
		$ResProdNota=mysql_query("SELECT IdProducto, Cantidad FROM det_nota_venta WHERE IdNotaVenta='".$idnota."'");
		while($RResProdNota=mysql_fetch_array($ResProdNota))
		{
			//Selecciona el almacen de donde salio el producto
			$ResAlmacen=mysql_fetch_array(mysql_query("SELECT * FROM movinventario WHERE IdNotaVenta='".$idnota."' AND Producto='".$RResProdNota["IdProducto"]."' LIMIT 1"));
			//regresa el producto al almacen
			mysql_query("UPDATE inventario SET ".$ResAlmacen["Almacen"]."=".$ResAlmacen["Almacen"]."+".$RResProdNota["Cantidad"]." WHERE IdProducto='".$RResProdNota["IdProducto"]."'") or die(mysql_error());
			//registra el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdNotaVenta, Fecha, Descripcion, Usuario)
																			VALUES ('".$ResAlmacen["Almacen"]."',
																							'".$ResAlmacen["Producto"]."',
																							'Entrada',
																							'".$ResAlmacen["Cantidad"]."',
																							'".$ResAlmacen["IdNotaVenta"]."',
																							'".date("Y-m-d")."',
																							'Cancelación de Venta Mostrador',
																							'".$_SESSION["usuario"]."')");
		}
		//actualizamos el status de la nota
		mysql_query("UPDATE nota_venta SET Status='Cancelada' WHERE Id='".$idnota."'")or die(mysql_error());
		$mensaje='<p class="textomensaje">Se Cancelo la nota '.$ResNota["NumNota"].' satisfactoriamente';
	}
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td align="center" bgcolor="#754200" class="texto3">Nota de Venta</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#ba9464" class="texto">'.$mensaje.'</td>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function claves_clientes_mostrador_pos($clave, $cantidad, $almacen, $pp)
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="0" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">Clave</td>
							<td bgcolor="#754200" align="center" class="texto3">Producto</td>
							<td bgcolor="#754200" align="center" class="texto3">Precio</td>
						</tr>';

	$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, ".$pp." FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		
		$clave=$RResClaves["Clave"];
		$precio=$RResClaves[$pp];
		
		
		//$iva=1.16;
		 $cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>';
		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">$ '.number_format($precio,2).'</a></td>';
		$cadena.='</tr>';
		//}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function productos_clientes_mostrador_pos($producto, $cantidad, $almacen, $pp) //sirve para buscar el producto por nombre
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="0" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">Clave</td>
							<td bgcolor="#754200" align="center" class="texto3">Producto</td>
						</tr>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre, Moneda, ".$pp." FROM productos WHERE Nombre LIKE '%".$producto."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC LIMIT 25");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$precio=$RResProductos[$pp];
		
		$cadena.='<tr>';
		
		 $cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fnotaventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fnotaventa.precio.value=\''.$precio.'\'; document.fnotaventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fnotaventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Nombre"].'</a></td>';
		
		
		$cadena.='</tr>';
		
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function resumen_notas_ventas($limite=0, $buscar=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#FFFFFF" align="left" class="texto">
							<form name="fbusnotav" id="fbusnotav">
							 Num. Nota: <input type="text" name="numnota" id="numnota" size="10" class="input" value="'.$buscar["numnota"].'"> 
								Fecha: De <select name="diai" id="diai"><option value="00">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'"';if($buscar["diai"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesi" id="mesi"><option value="00">Mes</option>
									<option value="01"';if($buscar["mesi"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
									<option value="02"';if($buscar["mesi"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
									<option value="03"';if($buscar["mesi"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
									<option value="04"';if($buscar["mesi"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
									<option value="05"';if($buscar["mesi"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
									<option value="06"';if($buscar["mesi"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
									<option value="07"';if($buscar["mesi"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
									<option value="08"';if($buscar["mesi"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
									<option value="09"';if($buscar["mesi"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
									<option value="10"';if($buscar["mesi"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
									<option value="11"';if($buscar["mesi"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
									<option value="12"';if($buscar["mesi"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
								</select><select name="annoi" id="annoi"><option value="0000">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'"';if($buscar["annoi"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	} 
	$cadena.='		</select> A <select name="diaf" id="diaf"><option value="'.date("d").'">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'"';if($buscar["diaf"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesf" id="mesf"><option value="'.date("m").'">Mes</option>
									<option value="01"';if($buscar["mesf"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
									<option value="02"';if($buscar["mesf"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
									<option value="03"';if($buscar["mesf"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
									<option value="04"';if($buscar["mesf"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
									<option value="05"';if($buscar["mesf"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
									<option value="06"';if($buscar["mesf"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
									<option value="07"';if($buscar["mesf"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
									<option value="08"';if($buscar["mesf"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
									<option value="09"';if($buscar["mesf"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
									<option value="10"';if($buscar["mesf"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
									<option value="11"';if($buscar["mesf"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
									<option value="12"';if($buscar["mesf"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
								</select><select name="annof" id="annof"><option value="'.date("Y").'">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'"';if($buscar["annof"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	} 
	$cadena.='		</select> <input type="button" name="botbuscarnotav" id="botbuscarnotav" value="Buscar>>" class="boton" onclick="xajax_resumen_notas_ventas(\'0\', xajax.getFormValues(\'fbusnotav\'))"><p>';
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#754200" align="center" class="texto3">Notas de Venta</th>
						<tr>
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">Num. Nota</td>
							<td bgcolor="#754200" align="center" class="texto3">Fecha</td>
							<td bgcolor="#754200" align="center" class="texto3">Importe</td>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						</tr>';
	
if($buscar==NULL)
	{
		$ResNotas=mysql_query("SELECT * FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Fecha DESC, NumNota DESC LIMIT ".$limite.", 25");
		$regs=mysql_num_rows(mysql_query("SELECT Id FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'"));
	}
	else 
	{
		if($buscar["numnota"]==''){$numnota='%';}else{$numnota=$buscar["numnota"];}
		$fechai=$buscar["annoi"].'-'.$buscar["mesi"].'-'.$buscar["diai"].' 00:00:00';
		$fechaf=$buscar["annof"].'-'.$buscar["mesf"].'-'.$buscar["diaf"].' 23:59:59';
		
		$ResNotas=mysql_query("SELECT * FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumNota LIKE '".$numnota."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' ORDER BY Fecha DESC, NumNota DESC LIMIT ".$limite.", 25");
		$regs=mysql_num_rows(mysql_query("SELECT Id FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumNota LIKE '".$numnota."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."'"));
	}
	$bgcolor="#FFFFFF";
	while($RResNotas=mysql_fetch_array($ResNotas))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResNotas["NumNota"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResNotas["Fecha"][8].$RResNotas["Fecha"][9].' - '.$RResNotas["Fecha"][5].$RResNotas["Fecha"][6].' - '.$RResNotas["Fecha"][0].$RResNotas["Fecha"][1].$RResNotas["Fecha"][2].$RResNotas["Fecha"][3].'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResNotas["Total"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="pos/ticket.php?idnota='.$RResNotas["Id"].'" target="_blank">Imprimir</a>
								</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="#" onclick="xajax_detalle_nota(\''.$RResNotas["Id"].'\')">Detalle</a>
								</td>
							</tr>';
		
		if($bgcolor=='#FFFFFF'){$bgcolor='#CCCCCC';}
		elseif($bgcolor=='#CCCCCC'){$bgcolor='#FFFFFF';}
	}
	
		$cadena.='	<tr>
								<th colspan="4" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		if($buscar==NULL)
		{
			if($J!=$limite){$cadena.='<a href="#" onclick="xajax_resumen_notas_ventas(\''.$J.'\')">'.$T.'</a> |	';}
			else{$cadena.=$T.' | ';}
		}
		else
		{
			if($J!=$limite){$cadena.='<a href="#" onclick="xajax_resumen_notas_ventas(\''.$J.'\', xajax.getFormValues(\'fbusnotav\'))">'.$T.'</a> |	';}
			else{$cadena.=$T.' | ';}
		}
		$J=$J+25;
	}
	$cadena.='		</th>
							</tr>
						</table>';
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function pos_ventas_agente()
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
							<td colspan="7" aling="left" class="texto3" bgcolor="#ba9464">Reporte de Ventas Por Agente POS</td>
							</tr>
							<tr>
								<td colspan="7" aling="left" class="texto" bgcolor="#FFFFFF">
									<form name="freppagos" id="freppagos" method="POST" action="pos/reporteventasagentepos.php" target="_blank">
										Agente: <select name="agente" id="agente"><option value="%">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='AgenteV' ORDER BY Nombre ASC");
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
	$cadena.='				</select> <input type="submit" name="botbuspagos" id="botbuspagos" value="Mostrar>>" class="boton">
									</form>
								</td>
							</tr>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function nueva_cotizacion_pos($orden=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenventa" id="fordenventa">
					 <table border="0" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="7" bgcolor="#754200" align="center" class="texto3">Cotización</th>
						</tr>
						<tr>
							<td colspan="2" align="left" bgcolor="#ba9464" class="texto">Cliente: </td>
							<td colspan="3" align="left" bgcolor="#ba9464" class="texto"><select name="cliente" id="cliente"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Mostrador='1' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"'; if($RResClientes["Id"]==$orden["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
							<td align="left" bgcolor="#ba9464" class="texto"></td>
							<td align="left" bgcolor="#ba9464" class="texto">';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC LIMIT 1");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<input type="hidden" name="almacen" id="almacen" value="'.$RResAlmacen["Nombre"].'">';
	}
	$cadena.='		</td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#ba9464 class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$orden["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#ba9464" class="texto" valign="top">Pedido Num.:</td>
						 	<td algin="left" bgcolor="#ba9464" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="'.$orden["pedido"].'"></td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto">Agente: </td>
						 	<td colspan="2" align="left" bgcolor="#ba9464" class="texto"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgente=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgente=mysql_fetch_array($ResAgente))
	{
		$cadena.='<option value="'.$RResAgente["Id"].'"';if($RResAgente["Id"]==$orden["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
							<td align="left" bgcolor="#ba9464" class="texto">Precio: </td>
							<td colspan="2" align="left" bgcolor="#ba9464" class="texto">
								<select name="pp" id="pp">
									<option value="PrecioPublico"';if($orden["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($orden["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($orden["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
							</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#754200" align="center" class="texto3">Total</td>
						 	<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="hidden" name="idproducto" id="idproducto" value="">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_clientes(this.value, document.getElementById(\'cliente\').value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#ba9464" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_productos_clientes(this.value, document.getElementById(\'cliente\').value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#ba9464" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_nueva_cotizacion_pos(xajax.getFormValues(\'fordenventa\'))"></td>
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
										<th colspan="7" bgcolor="#ba9464" class="textomensaje">Venta Invalida</th>
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
//									<th colspan="7" bgcolor="#ba9464" class="textomensaje">No puede vender un producto sin existencia</th>
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
		if($_SESSION["sucursal"]==1){$ivaa=1.11;}
		else{$ivaa=1.16;}
		for($T=0;$T<count($array);$T++)
		{
			$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$array[$T][1]."' LIMIT 1"));
			$cadena.='<tr>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idproducto_'.$array[$T][0].'" id="idproducto_'.$array[$T][0].'" value="'.$array[$T][1].'">'.$array[$T][0].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="cantidad_'.$array[$T][0].'" id="cantidad_'.$array[$T][0].'" value="'.$array[$T][2].'">'.$array[$T][2].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="clave_'.$array[$T][0].'" id="clave_'.$array[$T][0].'" value="'.$array[$T][3].'">'.$array[$T][3].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResProducto["Nombre"].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="precio_'.$array[$T][0].'" id="precio_'.$array[$T][0].'" value="'.$array[$T][4].'">'.($array[$T][4]*$ivaa).'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="total_'.$array[$T][0].'" id="total_'.$array[$T][0].'" value="'.$array[$T][5].'">'.($array[$T][5]*$ivaa).'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto">
							 		<a href="#" onclick="xajax_nueva_cotizacion(xajax.getFormValues(\'fordenventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
			elseif($bgcolor="#5ac15b"){$bgcolor='#7ac37b';}
			
			$subtotal=$subtotal+$array[$T][5];
		}
		
	}
	
	$total=$subtotal*$ivaa;
	$cadena.='<tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format(($total), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 	<th colspan="7" bgcolor="#ba9464" align="center" class="texto">
						 	<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
						 	<input type="hidden" name="cotpos" id="cotpos" value="1">
						 		<input type="button" name="botfincotizacion" id="botonfincotizacion" value="Guardar Cotización>>" class="boton" onclick="xajax_guarda_cotizacion(xajax.getFormValues(\'fordenventa\'))">
						 	</th>
						 </tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function rfc_nombre_clientepos($rfcnombre)
{
	include ("conexion.php");
	
	$ResClientes=mysql_query("SELECT RFC, Nombre FROM clientes WHERE RFC LIKE '%".$rfcnombre."%' OR Nombre LIKE '%".$rfcnombre."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Mostrador='1' ORDER BY Nombre ASC");
	
	$cadena.='<table border="0" cellpadding="0" cellspacing="0" width="100%">';
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<tr>
								<td class="texto" align="left"><a href="#" onclick="document.fcliente.rfc.value=\''.$RResClientes["RFC"].'\'; rfcnom.style.visibility=\'hidden\';">'.$RResClientes["RFC"].'</a></td>
								<td class="texto" align="left"><a href="#" onclick="document.fcliente.rfc.value=\''.$RResClientes["RFC"].'\'; rfcnom.style.visibility=\'hidden\';">'.$RResClientes["Nombre"].'</a></td>
							</tr>';
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("rfcnom","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function venta_dia()
{
	$cadena='<iframe src="pos/ventadia.php?empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"].'" width="900" height="600" scrolling="auto" frameborder="0"></iframe>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ver_detalle($tipo, $num, $fecha)
{
	switch ($tipo)
	{
		case 'hora':
			
			if($num=='00')
			{
			$ResDetalle=mysql_query("SELECT * FROM det_nota_venta WHERE Hora>='".$fecha." ".$num.":00:00' AND Hora<='".$fecha." 23:59:59' ORDER BY Hora ASC");	
			}
			else
			{
			$ResDetalle=mysql_query("SELECT * FROM det_nota_venta WHERE Hora>='".$fecha." ".$num.":00:00' AND Hora<='".$fecha." ".$num.":59:59' ORDER BY Hora ASC");
			}
			$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="8" align="center" bgcolor="#754200" class="texto3">Detalle Venta Por Hora</th>
							</tr>
							<tr>
								<td align="center" bgcolor="#754200" class="texto3">Hora</td>
								<td align="center" bgcolor="#754200" class="texto3">Cantidad</td>
								<td align="center" bgcolor="#754200" class="texto3">Clave</td>
								<td align="center" bgcolor="#754200" class="texto3">Producto</td>
								<td align="center" bgcolor="#754200" class="texto3">Costo</td>
								<td align="center" bgcolor="#754200" class="texto3">Precio Unitario</td>
								<td align="center" bgcolor="#754200" class="texto3">Importe</td>
								<td align="center" bgcolor="#754200" class="texto3">Ganancia</td>
							</tr>';
			$bgcolor="#FFFFFF";
			while($RResDetalle=mysql_fetch_array($ResDetalle))
			{
				$Producto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResDetalle["IdProducto"]."' LIMIT 1"));
				$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResDetalle["Hora"][11].$RResDetalle["Hora"][12].$RResDetalle["Hora"][13].$RResDetalle["Hora"][14].$RResDetalle["Hora"][15].$RResDetalle["Hora"][16].$RResDetalle["Hora"][17].$RResDetalle["Hora"][18].'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResDetalle["Cantidad"].'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResDetalle["Clave"].'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto">'.$Producto["Nombre"].'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResDetalle["Costo"],2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResDetalle["PrecioUnitario"],2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResDetalle["Importe"],2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format((($RResDetalle["PrecioUnitario"]-$RResDetalle["Costo"])*$RResDetalle["Cantidad"]),2).'</td>
							</tr>';
				$totalimporte=$totalimporte+$RResDetalle["Importe"];
				$totalganancia=$totalganancia+(($RResDetalle["PrecioUnitario"]-$RResDetalle["Costo"])*$RResDetalle["Cantidad"]);
				if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
				elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
			}
			$cadena.='<tr>
								<td colspan="6" align="right" bgcolor="'.$bgcolor.'" class="texto">Totales: </td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($totalimporte,2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($totalganancia,2).'</td>
							</tr>
						</table>';
			break;
	}
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function detalle_nota($idnota)
{
	include ("conexion.php");
	
	$ResNota=mysql_fetch_array(mysql_query("SELECT * FROM nota_venta WHERE Id='".$idnota."' LIMIT 1"));
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="8" bgcolor="#754200" align="center" class="texto3">Detalles de la Nota de Venta Num. '.$ResNota["NumNota"].', con fecha '.fecha($ResNota["Fecha"]).'</th>
						<tr>
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">#</td>
							<td bgcolor="#754200" align="center" class="texto3">Clave</td>
							<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
							<td bgcolor="#754200" align="center" class="texto3">Producto</td>
							<td bgcolor="#754200" align="center" class="texto3">Precio Unitario</td>
							<td bgcolor="#754200" align="center" class="texto3">Subtotal</td>
							
						</tr>';
	
	$ResDetNota=mysql_query("SELECT * FROM det_nota_venta WHERE IdNotaVenta='".$idnota."' ORDER BY Id ASC");
	$bgcolor="#FFFFFF"; $A=1;
	while($RResDetNota=mysql_fetch_array($ResDetNota))
	{
		$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResDetNota["IdProducto"]."' LIMIT 1"));
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$A.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResDetNota["Clave"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResDetNota["Cantidad"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResProducto["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResDetNota["PrecioUnitario"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResDetNota["Importe"], 2).'</td>
							</tr>';
		$totalimporte=$totalimporte+$RResDetNota["Importe"];
		$totaldebe=$totaldebe+$RResDetNota["Debe"];
		$totaltotal=$totaltotal+($RResDetNota["Importe"]-$RResDetNota["Debe"]);
		
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
		$A++;
	}
	
	$cadena.='<tr>
				<td bgcolor="'.$bgcolor.'" align="right" class="texto" colspan="5">SubTotal: </td>
				<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($ResNota["Total"],2).'</td>
			  </tr>';
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}	  
	$cadena.='<tr>
				<td bgcolor="'.$bgcolor.'" align="right" class="texto" colspan="5">Debe: </td>
				<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($ResNota["Debe"],2).'</td>
			  </tr>';
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}	  
	$cadena.='<tr>
				<td bgcolor="'.$bgcolor.'" align="right" class="texto" colspan="5">Total: </td>
				<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format(($ResNota["Total"]-$ResNota["Debe"]), 2).'</td>
			  </tr>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function resumen_total_venta($fecha=NULL)
{
	include ("conexion.php");
	
	if($fecha==NULL){$fechaconsulta=date("Y-m-d");}
	else{$fechaconsulta=$fecha["anno"].'-'.$fecha["mes"].'-'.$fecha["dia"];}
	
	$cadena='<table border="0" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<td colspan="5" bgcolor="#FFFFFF" align="left" class="texto">
								<form name="ffecha" id="ffecha">
									<select name="dia" id="dia">';
	for($j=1;$j<=31;$j++)
	{
		if($j<=9){$j='0'.$j;}
		$cadena.='<option value="'.$j.'"';if($j==$fechaconsulta[8].$fechaconsulta[9]){$cadena.=' selected';}$cadena.='>'.$j.'</option>';
	}
	$cadena.='</select> <select name="mes" id="mes">
							<option value="01"';if($fechaconsulta[5].$fechaconsulta[6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($fechaconsulta[5].$fechaconsulta[6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($fechaconsulta[5].$fechaconsulta[6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($fechaconsulta[5].$fechaconsulta[6]=='04'){$cadena.=' selected';}$cadena.='>Abril<option>
							<option value="05"';if($fechaconsulta[5].$fechaconsulta[6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($fechaconsulta[5].$fechaconsulta[6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($fechaconsulta[5].$fechaconsulta[6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($fechaconsulta[5].$fechaconsulta[6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($fechaconsulta[5].$fechaconsulta[6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($fechaconsulta[5].$fechaconsulta[6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($fechaconsulta[5].$fechaconsulta[6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($fechaconsulta[5].$fechaconsulta[6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($t=2012;$t<=date("Y");$t++)
	{
		$cadena.='<option value="'.$t.'"';if($t==$fechaconsulta[0].$fechaconsulta[1].$fechaconsulta[2].$fechaconsulta[3]){$cadena.=' selected';}$cadena.='>'.$t.'</option>';
	}
	$cadena.='</select> <input type="button" name="botconsultafecha" id="botconsultafecha" value="Consultar>>" class="boton" onclick="xajax_resumen_total_venta(xajax.getFormValues(\'ffecha\'))">
					</form>
					</td>
					<td colspan="3" bgcolor="#FFFFFF" align="right" class="texto"><a href="pos/corteexcel.php?tipo=resumen&fechaconsulta='.$fechaconsulta.'" target="_blank"><img src="images/excel.png" border="0"></a></td>
					</tr>
					<tr>
					<td colspan="8" bgcolor="#754200" class="texto3">Resumen Total de Venta</td>
					</tr>
					<tr>
						<td align="center" bgcolor="#754200" class="texto3">Cantidad</td>
						<td align="center" bgcolor="#754200" class="texto3">Clave</td>
						<td align="center" bgcolor="#754200" class="texto3">Producto</td>
						<td align="center" bgcolor="#754200" class="texto3">Costo</td>
						<td align="center" bgcolor="#754200" class="texto3">Precio Unitario</td>
						<td align="center" bgcolor="#754200" class="texto3">Importe Costo</td>
						<td align="center" bgcolor="#754200" class="texto3">Importe Venta</td>
						<td align="center" bgcolor="#754200" class="texto3">Ganancia</td>
					</tr>';
	
	$ResPartidas=mysql_query("SELECT * FROM det_nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Hora LIKE '".$fechaconsulta."%' ORDER BY Id ASC");
	$bgcolor="#FFFFFF"; $A=1;
	while($RResPartidas=mysql_fetch_array($ResPartidas))
	{
		$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResPartidas["IdProducto"]."' LIMIT 1"));
		
		$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResPartidas["Cantidad"].'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResPartidas["Clave"].'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$ResProducto["Nombre"].'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResPartidas["Costo"],2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResPartidas["PrecioUnitario"],2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format(($RResPartidas["Costo"]*$RResPartidas["Cantidad"]),2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format(($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"]),2).'</td>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format((($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"])-($RResPartidas["Costo"]*$RResPartidas["Cantidad"])),2).'</td>
							</tr>';
		$totalimportecosto=$totalimportecosto+($RResPartidas["Costo"]*$RResPartidas["Cantidad"]);
		$totalimporteventa=$totalimporteventa+($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"]);
		$totalganancia=$totalganancia+(($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"])-($RResPartidas["Costo"]*$RResPartidas["Cantidad"]));
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
		$A++;
	}
	$cadena.='<tr>
							<td align="right" bgcolor="'.$bgcolor.'" class="texto" colspan="5">Total: </td>
							<td align="right" bgcolor="'.$bgcolor.'" class="texto" >$ '.number_format($totalimportecosto,2).'</td>
							<td align="right" bgcolor="'.$bgcolor.'" class="texto" >$ '.number_format($totalimporteventa,2).'</td>
							<td align="right" bgcolor="'.$bgcolor.'" class="texto" >$ '.number_format($totalganancia,2).'</td>
						</tr>
					</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function gastos($gastos=NULL, $fecha=NULL)
{
	include ("conexion.php");
	
	if($fecha==NULL){$fecha=date("Y-m-d");}
	
	if($gastos!=NULL AND $gastos["descripcion"]!='' AND $gastos["cantidad"]!='')
	{
		mysql_query("INSERT INTO gastos (Empresa, Sucursal, Fecha, Descripcion, Cantidad)
							   VALUES ('".$_SESSION["empresa"]."',
									   '".$_SESSION["sucursal"]."',
									   '".$fecha."',
									   '".utf8_decode($gastos["descripcion"])."',
									   '".$gastos["cantidad"]."')")or die(mysql_error());
	}
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <form name="fgastos" id="fgastos">
						<tr>
							<td colspan="4" align="center" bgcolor="#754200" class="texto3">Gastos del Día</td>
						</tr>
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#754200" align="center" class="texto3">Descripción</td>
							<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						</tr>
						<tr>
							<td bgcolor="#ba9464" align="center" class="texto">&nbsp;</td>
							<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="descripcion" id="descripcion" value="" size="50" class="input"></td>
							<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="cantidad" id="cantidad" value="" size="10" class="input"></td>
							<td bgcolor="#ba9464" align="center" class="texto"><input type="button" name="butagregargasto" id="butagregargasto" value="Agregar>>" class="boton" onclick="xajax_gastos(xajax.getFormValues(\'fgastos\'))"></td>
						</tr>';
	$ResGastos=mysql_query("SELECT * FROM gastos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$fecha."' ORDER BY Id ASC");
	$A=1; $bgcolor="#FFFFFF";
	while($RResGastos=mysql_fetch_array($ResGastos))
	{
		$cadena.='		<tr>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$A.'</td>
							<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResGastos["Descripcion"].'</td>
							<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResGastos["Cantidad"],2).'</td>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto"><a href="#" onclick="xajax_gastos(\'\',\''.$RResGastos["Id"].'\')"><img src="images/x.png" border="0"></a></td>
						</tr>';
		$A++;
		if($bgcolor="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor="#CCCCCC"){$bgcolor="#FFFFF";}
		$totalgastos=$totalgastos+$RResGastos["Cantidad"];
	}
	$cadena.='			<tr>
							<td bgcolor="'.$bgcolor.'" align="right" class="texto" colspan="2">Total Gastos: </td>
							<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($totalgastos, 2).'</td>
							<td bgcolor="'.$bgcolor.'" align="left" class="texto">&nbsp;</td>
						</tr>';
	
	$cadena.='</form></table>';
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function debe($debe=NULL)
{
	include ("conexion.php");
	
	if($debe!=NULL AND $debe["descripcion"]!='' AND $debe["cantidad"]!='')
	{
		mysql_query("INSERT INTO debeadeudos (Empresa, Sucursal, Fecha, Descripcion, Cantidad)
							   VALUES ('".$_SESSION["empresa"]."',
									   '".$_SESSION["sucursal"]."',
									   '".date("Y-m-d")."',
									   '".utf8_decode($debe["descripcion"])."',
									   '".$debe["cantidad"]."')")or die(mysql_error());
	}
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
					 <form name="fdebe" id="fdebe">
						<tr>
							<td colspan="4" align="center" bgcolor="#754200" class="texto3">Debe (pago de adeudos)</td>
						</tr>
						<tr>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#754200" align="center" class="texto3">Descripción</td>
							<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						</tr>
						<tr>
							<td bgcolor="#ba9464" align="center" class="texto">&nbsp;</td>
							<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="descripcion" id="descripcion" value="" size="50" class="input"></td>
							<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="cantidad" id="cantidad" value="" size="10" class="input"></td>
							<td bgcolor="#ba9464" align="center" class="texto"><input type="button" name="butagregardebe" id="butagregardebe" value="Agregar>>" class="boton" onclick="xajax_debe(xajax.getFormValues(\'fdebe\'))"></td>
						</tr>';
	$ResDebe=mysql_query("SELECT * FROM debeadeudos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".date("Y-m-d")."' ORDER BY Id ASC");
	$A=1; $bgcolor="#FFFFFF";
	while($RResDebe=mysql_fetch_array($ResDebe))
	{
		$cadena.='		<tr>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$A.'</td>
							<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResDebe["Descripcion"].'</td>
							<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResDebe["Cantidad"],2).'</td>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto"><a href="#" onclick="xajax_gastos(\'\',\''.$RResDebe["Id"].'\')"><img src="images/x.png" border="0"></a></td>
						</tr>';
		$A++;
		if($bgcolor="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor="#CCCCCC"){$bgcolor="#FFFFF";}
		$totaldebe=$totaldebe+$RResDebe["Cantidad"];
	}
	$cadena.='			<tr>
							<td bgcolor="'.$bgcolor.'" align="right" class="texto" colspan="2">Total: </td>
							<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($totaldebe, 2).'</td>
							<td bgcolor="'.$bgcolor.'" align="left" class="texto">&nbsp;</td>
						</tr>';
	
	$cadena.='</form></table>';
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>