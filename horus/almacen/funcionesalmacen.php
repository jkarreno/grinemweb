<?php 
function inventario($limite=0, $buscar=NULL)
{
	include ("conexion.php");
	
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	$numalmacenes=mysql_num_rows($ResAlmacenes);
	
	$cadena='<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
							<tr>
								<td colspan="3" bgcolor="#FFFFFF" class="texto" align="left">
									<form name="fbuscaprod" id="fbuscaprod" action="almacen/almacenexcel.php?empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"].'" method="POST" target="_blank">
									 Buscar Clave o Nombre: <input type="text" name="clave" id="clave" class="input" size="50"> <input type="button" name="botbusclave" id="botbusclave" value="Buscar>>" onclick="xajax_inventario(\'0\', xajax.getFormValues(\'fbuscaprod\'))" class="boton"> <input type="submit" name="butexcel" id="butexcel" value="Exportar a Excell>>" class="boton">
									</form>
								</td>
								<td colspan="'.$numalmancenes.'" bgcolor="#FFFFFF" class="texto" align="right">
									<!--| <a href="#" onclick="xajax_existencias()">Existencias</a> |-->
								</td>
							</tr>
							<tr>
								<th colspan="'.(4+$numalmacenes).'" bgcolor="#4db6fc" class="texto3" align="center">Productos en Existencia</th>
							</tr>
							<tr>
								<td bgcolor="#4db6fc" class="texto3" align="center">&nbsp;</td>
								<td bgcolor="#4db6fc" class="texto3" align="center">Unidad</td>
								<td bgcolor="#4db6fc" class="texto3" align="center">Clave</td>
								<td bgcolor="#4db6fc" class="texto3" align="center">Nombre</td>';
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
		$cadena.='<td bgcolor="#4eb24e" class="texto3" align="center">'.$RResAlmacenes["Nombre"].'</td>';
		for($T=1; $T<=$numalmacenes; $T++) //query para almacenes
		{
			$sql=$_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$RResAlmacenes["Nombre"];
			if($T<$numalmacenes){$sql.=', ';}
		}
	}
	$cadena.='</tr>';
	$bgcolor="#fff"; $J=1;
	$ResProductos=mysql_query("SELECT Id, Clave, Unidad, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND (Clave LIKE '".$buscar["clave"]."%' OR Nombre LIKE '%".$buscar["clave"]."%') ORDER BY NOMBRE ASC LIMIT ".$limite.", 25");
	$regs=mysql_num_rows(mysql_query("SELECT Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND (Clave LIKE '".$buscar["clave"]."%' OR Nombre LIKE '%".$buscar["clave"]."%') ORDER BY NOMBRE ASC"));
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResProductos["Unidad"]."' LIMIT 1"));
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResUnidad["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResProductos["Clave"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResProductos["Nombre"].'</td>';
		$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
		while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
		{
			$inventario=0;
			$cadena.='<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.inventario_stock($RResProductos["Id"], $almacen).'</td>';
		}
		$cadena.='</tr>';
		
		if($bgcolor=="#fff"){$bgcolor="#ccc";}
		elseif($bgcolor=="#ccc"){$bgcolor='#fff';}
		$J++;
	}
	$cadena.='	<tr>
								<th colspan="'.(4+$numalmacenes).'" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_inventario(\''.$J.'\')">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
						</table>';
	
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function inventario_inicial($form=NULL)
{
	include ("conexion.php");
	$mensaje=''; $confirmar=''; $clave=''; $cantidad='';
	
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_MX");
	
	if($form!=NULL)
	{
		$ResProducto=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM productos WHERE Clave='".$form["clave"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
		$ResAlmacen=mysql_fetch_array(mysql_query("SELECT Nombre FROM almacenes WHERE Nombre='".$form["almacen"]."' LIMIT 1"));
		//verifica si hay canitdad en el almacen
		//$CantProd=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$ResAlmacen["Nombre"]." FROM inventario WHERE IdProducto='".$ResProducto["Id"]."' LIMIT 1"));
		if(isset($form["confirmar"])=="si")
		{
			mysql_query("UPDATE inventario SET ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$ResAlmacen["Nombre"]."='".$form["cantidad"]."'
																WHERE IdProducto='".$ResProducto["Id"]."'");
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Ajuste, Descripcion, Usuario)
											VALUES ('".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$ResAlmacen["Nombre"]."',
													'".$ResProducto["Id"]."', 'Entrada', '".$form["cantidad"]."', '".date("Y-m-d H:i:s")."', 'II', 'Inventario Inicial', '".$_SESSION["usuario"]."')");
			
			$mensaje='<p align="center" class="textomensaje">Se ingresaron '.$form["cantidad"].' del Producto '.$ResProducto["Nombre"].' al almacen '.$ResAlmacen["Nombre"];
		}
		else if($CantProd[$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$ResAlmacen["Nombre"]]!=0)
		{
			$mensaje='El Producto con Clave '.$form["clave"].' ya cuenta con existencia de '.$CantProd[$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$ResAlmacen["Nombre"]];
			$clave=$form["clave"];
			$cantidad=$form["cantidad"];
			$confirmar=1;
		}
		else if(mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Descripcion, Ajuste, Usuario)
														VALUES ('".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$ResAlmacen["Nombre"]."',
																'".$ResProducto["Id"]."', 'Entrada', '".$form["cantidad"]."', '".date("Y-m-d H:i:s")."', 'Inventario Inicial', 'II', '".$_SESSION["usuario"]."')"))
		{
			$mensaje='<p align="center" class="textomensaje">Se ingresaron '.$form["cantidad"].' del Producto '.$ResProducto["Nombre"].' al almacen '.$ResAlmacen["Nombre"];
		}
		else
		{
			$mensaje='<p align="center" class="textomensaje">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
		}
	}
	
	$cadena='<form name="fadmercancia" id="fadmercancia" action="javascript:void(null)">
						<table border="1" cellpadding="3" cellsapacing="0" align="center" bordercolor="#FFFFFF">
							<tr>
								<th colspan="2" bgcolor="#4db6fc" class="texto3" align="center">Ingresa Inventario Inicial</th>
							</tr>';
	if($mensaje)
	{
		$cadena.='<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</th>
							</tr>';
	}
	if($confirmar==1)
	{
		$cadena.='<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="texto">Actualizar cantidad <input type="checkbox" name="confirmar" id="confirmar" value="si" checked></th>
							</tr>';
	}
	$cadena.='	<tr>
								<td bgcolor="#4db6fc" align="left" class="texto">Producto: </td>
								<td bgcolor="#cccccc" align="left" class="texto">
									<input type="text" name="clave" id="clave" size="15" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_almacen(this.value)" value="'.$clave.'">
									<div id="claves" style="position: absolute; width: 400px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#4db6fc" align="left" class="texto">Cantidad: </td>
								<td bgcolor="#cccccc" align="left" class="texto"><input type="text" name="cantidad" id="cantidad" size="15" class="input" value="'.$cantidad.'"></td>
							</tr>
							<tr>
								<td bgcolor="#4db6fc" align="left" class="texto">Fecha de Caducidad: </td>
								<td bgcolor="#cccccc" align="left" class="texto"></td>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#4db6fc" align="center" class="texto">
									<input type="submit" name="botadmercancia" id="botadmercancia" value="Agregar>>" class="boton" onclick="xajax_inventario_inicial(xajax.getFormValues(\'fadmercancia\'))">
								</th>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function ingresa_mercancia($form=NULL)
{
	include ("conexion.php");
	
	if($form!=NULL)
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave='".$form["clave"]."' LIMIT 1"));
		
		mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Ajuste, Descripcion, Usuario)
									   VALUES ('1_1_Principal', 
											   '".$ResProd["Id"]."', 
											   'Entrada', 
											   '".$form["cantidad"]."', 
											   '".date("Y-m-d H:i:s")."',
											   'IM',
											   'Ingreso de Mercancia',
											   '".$_SESSION["usuario"]."')") or die(mysql_error());
											   
		$cadena='<p class="textomensaje" align="center">Se agregaron '.$form["cantidad"].' del producto '.$ResProd["Nombre"].' satisfactoriamente</p>';
	}
	
	$cadena.='<form name="fingmerc" id="fingmerc">
			<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
				<tr>
					<th colspan="3" bgcolor="#754200" class="texto3" align="center">Ingresar Mercancia</th>
				</tr>';
	$cadena.='	<tr>
					<td bgcolor="#754200" class="texto3" align="center">Cantidad</td>
					<td bgcolor="#754200" class="texto3" align="center">Codigo</td>
					<td bgcolor="#754200" class="texto3" align="center">&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#ba9464" class="texto" align="center"><input type="number" size="10" name="cantidad" id="cantidad" value="1" class="input"></td>
					<td bgcolor="#ba9464" class="texto" align="center"><input type="text" name="clave" id="clave" class="input"></td>
					<td bgcolor="#ba9464" class="texto" align="center">
						<img src="images/pixel.png" border="0" onload="document.fingmerc.clave.focus()">
						<input type="button" name="botingprod" id="botingprod" class="boton" value="Agregar>>" onclick="xajax_ingresa_mercancia(xajax.getFormValues(\'fingmerc\'))"></td>
				</tr>';
	$cadena.='</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function check_orden_prov($orden)
{
	include ("conexion.php");
	
	$ResOrden=mysql_query("SELECT * FROM ordenescompraprovedores WHERE Id='".$orden."' LIMIT 1");
	$RResOrden=mysql_fetch_array($ResOrden);
	
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResOrden["Provedor"]."' LIMIT 1"));
	
	$cadena.='<form name="focadmercancia" id="focadmercancia">
						<table border="1" bordercolor="#ffffff" align="center" cellpadding="3" cellspacing="0">
							<tr>
								<th colspan="4" align="right" class="texto" bgcolor="#ffffff"><img src="images/print.png" border="0"></th>
							</tr>
							<tr>
								<th colspan="4" align="center" class="texto3" bgcolor="#287d29">Detalles de Orden de Compra</th>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">Num. Orden: </td>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">'.$RResOrden["NumOrden"].'</td>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">Provedor: </td>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">'.$ResProvedor["Nombre"].'</td>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">Fecha de Orden: </td>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">'.fecha($RResOrden["FechaOrden"]).'</td>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">Status: </td>
								<td colspan="2" align="left" class="texto" bgcolor="#7abc7a">'.$RResOrden["Status"].'</td>
							</tr>
							<tr>
								<td align="center" class="texto3" bgcolor="#4eb24e">&nbsp;</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Cantidad</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Clave</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Producto</td>
							</tr>';
	$ResProdOrden=mysql_query("SELECT * FROM ordencompraprov WHERE NumOrden='".$RResOrden["NumOrden"]."' AND Provedor='".$RResOrden["Provedor"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' ORDER BY Id ASC");
	$bgcolor='#7ac37b'; $J=1;
	while($RResProdOrden=mysql_fetch_array($ResProdOrden))
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResProdOrden["Producto"]."' LIMIT 1"));
		//busca si ya se ingreso producto
		$ResProdIngresado=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS CantRec FROM ingresoocp WHERE IdOrdenCompra='".$RResProdOrden["Id"]."' AND Prod='".$RResProdOrden["Producto"]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$J.'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'"><input type="text" name="cantidad_'.$RResProdOrden["Producto"].'" id="cantidad_'.$RResProdOrden["Producto"].'" value="'.($RResProdOrden["Cantidad"]-$ResProdIngresado["CantRec"]).'" class="input" size="5"></td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$ResProd["Clave"].'</td>
								<td align="left" class="texto" bgcolor="'.$bgcolor.'">'.$ResProd["Nombre"].'</td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		elseif($bgcolor=="#5ac15b"){$bgcolor='#7ac37b';}
	}
	$cadena.='	<tr>
								<th colspan="3" align="left" bgcolor="'.$bgcolor.'" class="texto">
								<input type="hidden" name="numorden" id="numorden" value="'.$RResOrden["NumOrden"].'">
								<input type="hidden" name="provedor" id="provedor" value="'.$RResOrden["Provedor"].'">
								Almacen: <select name="almacen" id="almacen">';
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
		$cadena.='<option value="'.$RResAlmacenes["Nombre"].'">'.$RResAlmacenes["Nombre"].'</option>';
	}
	$cadena.='		</select>
								</th>
								<td align="right" bgcolor="'.$bgcolor.'" class="texto"> 
								<input type="button" name="botcheckorden" id="botcheckorden" value="Aceptar >>" class="boton" onclick="xajax_ingresa_mercancia_orden(xajax.getFormValues(\'focadmercancia\'))">
								</td>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ingresa_mercancia_orden($form)
{
	include ("conexion.php");
	
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_MX");
	
	
	if($form["almacen"]=='')
	{
		$cadena.='<p class="textomensaje" align="center">No selecciono almacen, intente nuevamente</p>';
	}
	else
	{
	
	$almacen=$_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$form["almacen"];
	
	$cadena='<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
							<tr>
								<th colspan="4" bgcolor="#287d29" class="texto3" align="center">Ingresar Mercancia</th>
							</tr>';
		$ResOrden=mysql_query("SELECT * FROM ordencompraprov WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$form["numorden"]."' AND Provedor='".$form["provedor"]."' ORDER BY Id ASC");
		$cadena.='<tr>
								<th colspan="4" bgcolor="#7abc7a" align="center" class="textomensaje">';
		while($RResOrden=mysql_fetch_array($ResOrden))
		{
			//actualiza inventario
			mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."+".$form["cantidad_".$RResOrden["Producto"]]." 
															 WHERE IdProducto='".$RResOrden["Producto"]."'");
			//registra entradas
			mysql_query("INSERT INTO ingresoocp (IdOrdenCompra, Prod, Cantidad, Fecha) VALUES ('".$RResOrden["Id"]."', '".$RResOrden["Producto"]."', '".$form["cantidad_".$RResOrden["Producto"]]."', '".date("Y-m-d")."')"); //registra entrada de la orden
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Cantidad, Movimiento, IdOrdenCompra, Fecha, Descripcion, Usuario)
																			VALUES ('".$almacen."', '".$RResOrden["Producto"]."', '".$form["cantidad_".$RResOrden["Producto"]]."',
																							'Entrada', '".$RResOrden["Id"]."', '".date("Y-m-d H:m:s")."', 'Ingreso de Mercancia por Orden de Compra', '".$_SESSION["usuario"]."')"); //registra entrada al almacen
			//suma producto ingresado
			$ResSuma=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Total FROM ingresoocp WHERE IdOrdenCompra='".$RResOrden["Id"]."' AND Prod='".$RResOrden["Producto"]."'"));
			//comparo ingresos con orden
			if($ResSuma["Total"]==$RResOrden["Cantidad"])
			{
				mysql_query("UPDATE ordencompraprov SET Status='Recibida' WHERE Id='".$RResOrden["Id"]."'");
			}
			elseif($ResSuma["Total"]>$RResOrden["Cantidad"])
			{
				mysql_query("UPDATE ordencompraprov SET Status='Recibida' WHERE Id='".$RResOrden["Id"]."'");
			}
		}
		//Finaliza la orden
		$cuenta=mysql_query("SELECT Status FROM ordencompraprov WHERE Status!='Recibida' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$form["numorden"]."' AND Provedor='".$form["provedor"]."'");	
		if(mysql_num_rows($cuenta)==0)
		{
			if(mysql_query("UPDATE ordenescompraprovedores SET Status='Recibida', Usuario='".$_SESSION["usuario"]."' WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$form["numorden"]."' AND Provedor='".$form["provedor"]."'"))
			{
				$cadena.='Se actualizo la orden de compra '.$form["numorden"].' satisfactoriamente';
			}
			else
			{
				$cadena.=mysql_error();
			}
			
		}
		else
		{
			$cadena.=mysql_num_rows($cuenta);
		}
		$cadena.='</th>
							</tr>
							</table>';
		
	}
		
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function surtir_mercancia()
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="2" bgcolor="#287d29" align="center" class="texto3">Surtir Mercancía</th>
						</tr>
						<tr>
							<td align="left" bgcolor="#7abc7a" class="texto">Orden de Venta: </td>
							<td align="left" bgcolor="#7abc7a" class="texto"><select name="ordenventa" id="ordenventa" onchange="xajax_surtir_mercancia_orden_venta(this.value)">
								<option value="">Seleccione</option>';
	$ResOrdenSurtir=mysql_query("SELECT Id, NumOrden, Cliente FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' ORDER BY NumOrden ASC");
	while($RResOrdenSurtir=mysql_fetch_array($ResOrdenSurtir))
	{
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenSurtir["Cliente"]."' LIMIT 1"));
		$cadena.='<option value="'.$RResOrdenSurtir["Id"].'">'.$RResOrdenSurtir["NumOrden"].' - '.$ResCliente["Nombre"].'</option>';
	}
	$cadena.='	</seletc></td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function surtir_mercancia_orden_venta($orden)
{
	include ("conexion.php");
	
	$ResOrden=mysql_fetch_array(mysql_query("SELECT * FROM ordenventa WHERE Id='".$orden."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResOrden["Cliente"]."' LIMIT 1"));
	
	$cadena='<form name="fsurmerordenventa" id="surmerordenventa">
					 <input type="hidden" name="idorden" id="idorden" value="'.$orden.'">
					 <table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Surtir Mercancía - Orden de Venta Num. '.$ResOrden["NumOrden"].' '.$ResCliente["Nombre"].'</th>
						</tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Cantidad</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Clave</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Producto</td>
						</tr>';
	$ResProdsOrden=mysql_query("SELECT * FROM detordenventa WHERE idorden='".$orden."' AND Status='Pendiente' ORDER BY Id ASC");
	$J=1; $bgcolor="#7ac37b";
	while($RResProdsOrden=mysql_fetch_array($ResProdsOrden))
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResProdsOrden["Producto"]."' LIMIT 1"));
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idproducto_'.$J.'" id="idproducto_'.$J.'" value="'.$RResProdsOrden["Id"].'">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="text" name="cantidad_'.$J.'" id="cantidad_'.$J.'" size="10" class="input" value="'.$RResProdsOrden["Cantidad"].'"></td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResProd["Clave"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResProd["Nombre"].'</td>
							</tr>';
		$J++;
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	$cadena.='<tr>
							<th colspan="4" align="center" bgcolor="#7abc7a" class="texto">
								<input type="button" name="botsurmerc" id="botsurmer" value="Surtir Mercancia>>" class="boton" onclick="xajax_surtir_mercancia_orden_venta_2(xajax.getFormValues(\'fsurmerordenventa\'))">
							</th>
						</tr>
					</table>
					<input type="hidden" name="elementos" id="elementos" value="'.($J-1).'">
					</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function surtir_mercancia_orden_venta_2($orden)
{
	include ("conexion.php");
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_MX");
	
	for($J=1; $J<=$orden["elementos"]; $J++)
	{
		//registra los productos que salen de la orden de venta
		mysql_query("INSERT INTO surtirovc (Idorden, Producto, Cantidad, Fecha)
																VALUES ('".$orden["idorden"]."', '".$orden["idproducto_".$J]."', 
																				'".$orden["cantidad_".$J]."', '".date("Y-m-d")."')");
		//registra el movimiento al invetario
		$ResProd=mysql_fetch_array(mysql_query("SELECT Producto FROM detordenventa WHERE Id='".$orden["idproducto_".$J]."' LIMIT 1"));
		mysql_query("INSERT INTO movinventario (Producto, Movimiento, IdOrdenVenta, Fecha, Descripcion)
																		VALUES ('".$ResProd["Producto"]."', 'Salida', '".$orden["idorden"]."',
																						'".date("Y-m-d H:i:s")."', 'Salida de mercancia por Orden de Venta')");
		//afecta a inventario
		mysql_query("UPDATE productos SET Inventario=Inventario-".$orden["cantidad_".$J]." WHERE Id='".$orden["idproducto_".$J]."'");
		
		//actualiza status de detordenventa
		$ResCantProdS=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS ProdSur FROM surtirovc WHERE Idorden='".$orden["idorden"]."' AND Producto='".$orden["idproducto_".$J]."'"));
		$ResCantProdO=mysql_fetch_array(mysql_query("SELECT Cantidad FROM detordenventa WHERE idorden='".$orden["idorden"]."' AND Id='".$orden["idproducto_".$J]."' LIMIT 1"));
		if($ResCantProdS["ProdSur"]==$ResCantProdO["Cantidad"])
		{
			mysql_query("UPDATE detordenventa SET Status='Surtido' WHERE idorden='".$orden["idorden"]."' AND Id='".$orden["idproducto_".$J]."'");
		}
		elseif($ResCantProdS["ProdSur"]>$ResCantProdO["Cantidad"])
		{
			mysql_query("UPDATE detordenventa SET Status='Surtido' WHERE idorden='".$orden["idorden"]."' AND Id='".$orden["idproducto_".$J]."'");
		}
		//$cadena.=$ResCantProdS["ProdSur"].' - '.$ResCantProdO["Cantidad"].'<br />';
	}
	//actualiza el status de ordenventa
	if(mysql_num_rows(mysql_query("SELECT Status FROM detordenventa WHERE Status='Pendiente' AND idorden='".$orden["idorden"]."'"))==0)
	{
		mysql_query("UPDATE ordenventa SET Status='Surtido' WHERE Id='".$orden["idorden"]."'");
	}
	
	$ResOrden=mysql_fetch_array(mysql_query("SELECT * FROM ordenventa WHERE Id='".$orden["idorden"]."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResOrden["Cliente"]."' LIMIT 1"));
	$cadena.='<p align="center" class="textomensaje">Se actualizo la orden de venta No. '.$ResOrden["NumOrden"].' del Cliente '.$ResCliente["Nombre"].'<br />Status: '.$ResOrden["Status"].'</p>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function almacenes($empresa, $sucursal, $form=NULL)
{
	include ("conexion.php");
	
	$ResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$empresa."' LIMIT 1"));
	$ResSucursal=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Id='".$sucursal."' LIMIT 1"));
	
	$cadena.='<form name="falmacenes" id="falmacenes">
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="3" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="ocultar(\'lightbox\')">Cerrar [x]</a> |</th>
							</tr>
							<tr>
								<th colspan="3" bgcolor="#287d29" align="center" class="texto3">Almacenes de Sucursal '.$ResSucursal["Nombre"].'</th>
							</tr>
							<tr>
								<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
								<td bgcolor="#4eb24e" align="center" class="texto3">Nombre Almacen</td>
								<td bgcolor="#4eb24e" align="center" class="texto3">Descripción</td>
							</tr>';
	$ResAlmacenes=mysql_query("SELECT * FROM almacenes WHERE Empresa='".$empresa."' AND Sucursal='".$sucursal."' ORDER BY Id ASC");
	if(mysql_num_rows($ResAlmacenes)!=0){$J=1;} $bgcolor='#7ac37b';
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idalmacen_'.$J.'" id="idalmacen_'.$J.'" value="'.$RResAlmacenes["Id"].'">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto"><input type="text" name="nombre_'.$J.'" id="nombre_'.$J.'" value="'.$RResAlmacenes["Nombre"].'" class="input"></td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto"><input type="text" name="descripcion_'.$J.'" id="descripcion_'.$J.'" value="'.$RResAlmacenes["Descripcion"].'" class="input"></td>
							</tr>';
		$J++;
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	if(!$J AND !$form["numalmacenes"]){$J=1;$form["numalmacenes"]=1;}
	elseif(!$J AND $form["numalmacenes"]){$J=1;}
	for($J; $J<=$form["numalmacenes"];$J++)
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="almacen_'.$J.'" id="almacen_'.$J.'" value="'.$J.'">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto"><input type="text" name="nombre_'.$J.'" id="nombre_'.$J.'" value="'.$form["nombre_".$J].'" class="input"></td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto"><input type="text" name="descripcion_'.$J.'" id="descripcion_'.$J.'" value="'.$form["descripcion_".$J].'" class="input"></td>
							</tr>';
	}
	$cadena.='<tr>
								<th colspan="3" bgcolor="#7abc7a" align="right" class="texto">
								<input type="hidden" name="numalmacenes" id="numalmacenes" value="'.($form["numalmacenes"]+1).'">
								<input type="hidden" name="empresa" id="empresa" value="'.$empresa.'">
								<input type="hidden" name="sucursal" id="sucursal" value="'.$sucursal.'">
								<a href="#" onclick="xajax_almacenes(\''.$empresa.'\', \''.$sucursal.'\', xajax.getFormValues(\'falmacenes\'))">Agregar mas</a>
								</th>
							</tr>
							<tr>
								<th colspan="3" bgcolor="#7abc7a" align="center" class="texto">
								<input type="button" name="botgalmacenes" id="botgalmacenes" value="Guardar Almacenes>>" class="boton" onclick="xajax_guarda_almacenes(xajax.getFormValues(\'falmacenes\')); ocultar(\'lightbox\')">
								</th>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#FFFFFF" align="center" class="texto">&nbsp;</th>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_almacenes($form)
{
	include ("conexion.php");
	
	for($J=1; $J<$form["numalmacenes"]; $J++)
	{
		//comprobamos que ya existia el almacen
		$cadena.=$form["almacen_".$J];
		if($form["idalmacen_".$J]!='')
		{
			$cadena.='Actualizando Almacen '.$form["idalmacen_".$J].'<br />';
			$ResAlmacen=mysql_fetch_array(mysql_query("SELECT Nombre FROM almacenes WHERE Id='".$form["idalmacen_".$J]."' LIMIT 1"));
			
			mysql_query("UPDATE almacenes SET Nombre='".$form["nombre_".$J]."',
																				Descripcion='".utf8_decode($form["descripcion_".$J])."'
																  WHERE Id='".$form["idalmacen_".$J]."'") or die ($cadena.=mysql_error());
			mysql_query("ALTER TABLE inventario CHANGE ".$form["empresa"]."_".$form["sucursal"]."_".$ResAlmacen["Nombre"]." ".$form["empresa"]."_".$form["sucursal"]."_".$form["nombre_".$J]." INT NOT NULL") or die ($cadena.=mysql_error());
		}
		elseif($form["almacen_".$J]!='')
		{
			$cadena.='Agregando almacen '.$form["almacen_".$J].'<br />';
			mysql_query("INSERT INTO almacenes (Empresa, Sucursal, Nombre, Descripcion)
																	VALUES ('".$form["empresa"]."', '".$form["sucursal"]."',
																					'".$form["nombre_".$J]."', '".utf8_decode($form["descripcion_".$J])."')") or die ($cadena.=mysql_error());
			mysql_query("ALTER TABLE inventario ADD ".$form["empresa"]."_".$form["sucursal"]."_".$form["nombre_".$J]." INT NOT NULL default '0'") or die ($cadena.=mysql_error());
		}
	}
	
	$cadena='LISTO';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function claves_almacen($clave)
{
	include("conexion.php");
	
	$cadena='<table border="0" cellpadding="1" cellspacing="0">';
	$ResClaves=mysql_query("SELECT Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		$cadena.='<tr>
							 <td style="display: block;outline: none;margin: 0;text-decoration: none;color: #3c833d;" align="left"><a href="#" onclick="document.fadmercancia.clave.value=\''.$RResClaves["Clave"].'\';claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
							 <td style="display: block;outline: none;margin: 0;text-decoration: none;color: #3c833d;" align="left"><a href="#" onclick="document.fadmercancia.clave.value=\''.$RResClaves["Clave"].'\';claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>
							</tr>';
	}
	$cadena.='</table>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function traslado_almacen($form=NULL)
{
	include ("conexion.php");
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_MX");
	
	if($form!=NULL)
	{
		//almacenes
		$almaceno=$_SESSION["empresa"].'_'.$form["almaceno"];
		$almacend=$_SESSION["empresa"].'_'.$form["almacend"];
		//verifica si hay existencia en el almacen origen
		$ResProd=mysql_fetch_array(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave='".$form["clave"]."' LIMIT 1"));
		$ResInv=mysql_fetch_array(mysql_query("SELECT ".$almaceno." FROM inventario WHERE IdProducto='".$ResProd["Id"]."'"));
		if(inventario_stock($ResProd["Id"], $almaceno)<$form["cantidad"])
		{
			$mensaje='No hay suficiente existencia en el almacen origen ';
		}
		//verifica si el producto existe en el almacen destino (sucursal)
		$sucursald=explode('_', $form["almacend"]);
		$ResProd2=mysql_fetch_array(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$sucursald[0]."' AND Clave='".$form["clave"]."' LIMIT 1"));
		if($ResProd2["Id"]=='')
		{
			$mensaje.='El Producto no existe en la sucursal del almacen destino<br />';
		}
		//verifica que los campos contengan datos
		if($form["clave"]==''){$mensaje.='Seleccione clave de producto<br />';}
		if($form["cantidad"]==''){$mensaje.='Ingrese Cantidad de producto<br />';}
		if($form["almaceno"]==''){$mensaje.='Seleccione almacen de origen<br />';}
		if($form["almacend"]==''){$mensaje.='Seleccion almacen destino';}
		
		//realiza traslado
		if(!$mensaje)
		{
			//retira producto de almacen origen
			mysql_query("UPDATE inventario SET ".$almaceno."=".$almaceno."-".$form["cantidad"]." WHERE IdProducto='".$ResProd["Id"]."'");
			//registra movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Ajuste, Usuario)
											VALUES ('".$almaceno."', '".$ResProd["Id"]."', 'Salida', '".$form["cantidad"]."', '".date("Y-m-d H:i:s")."', 'TA', '".$_SESSION["usuario"]."')");
			//ingresa producto a almacen destino
			mysql_query("UPDATE inventario SET ".$almacend."=".$almacend."+".$form["cantidad"]." WHERE IdProducto='".$ResProd2["Id"]."'");
			//registra movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Ajuste, Usuario)
											VALUES ('".$almacend."', '".$ResProd2["Id"]."', 'Entrada', '".$form["cantidad"]."', '".date("Y-m-d H:i:s")."', 'TA', '".$_SESSION["usuario"]."')");
			$mensaje2='Se Realizo el traslado satisfactoriamente';
		}
		else
		{
			$clave=$form["clave"];
			$cantidad=$form["cantidad"];
			$almaceno=$form["almaceno"];
			$almacend=$form["almacend"];
		}
	}
	
	$cadena.='<form name="fadmercancia" id="fadmercancia" action="javascript:void(null)">
						<table border="1" cellpadding="3" cellsapacing="0" align="center" bordercolor="#FFFFFF">
							<tr>
								<th colspan="2" bgcolor="#287d29" class="texto3" align="center">Traslado de Mercancia</th>
							</tr>';
	if($mensaje)
	{
		$cadena.='<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</th>
							</tr>';
	}
	elseif($mensaje2)
 {
		$cadena.='<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje2.'</th>
							</tr>';
	}
	if($confirmar==1)
	{
		$cadena.='<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="texto">Actualizar cantidad <input type="checkbox" name="confirmar" id="confirmar" value="si" checked></th>
							</tr>';
	}
	$cadena.='	<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Producto: </td>
								<td bgcolor="#7abc7a" align="left" class="texto">
									<input type="text" name="clave" id="clave" size="15" class="input" value="'.$clave.'" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_almacen(this.value)" value="'.$clave.'">
									<div id="claves" style="position: absolute; width: 400px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Cantidad: </td>
								<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="cantidad" id="cantidad" size="15" class="input" value="'.$cantidad.'"></td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Almacen Origen: </td>
								<td bgcolor="#7abc7a" align="left" class="texto"><select name="almaceno" id="almaceno">
									<option value="">Seleccione</option>';
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
		while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
		{
			$cadena.='<option value="'.$_SESSION["sucursal"].'_'.$RResAlmacenes["Nombre"].'"'; if($_SESSION["sucursal"].'_'.$RResAlmacenes["Nombre"]==$almaceno){$cadena.=' selected';}$cadena.='>'.$RResAlmacenes["Nombre"].'</option>';
		}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Almacen Destino: </td>
								<td bgcolor="#7abc7a" align="left" class="texto"><select name="almacend" id="almacend">
									<option value="">Seleccione</option>';
	$ResSucursal=mysql_query("SELECT Id, Nombre FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' ORDER BY Nombre ASC");
	while($RResSucursal=mysql_fetch_array($ResSucursal))
	{
		$cadena.='<option value="">--- Suc. '.$RResSucursal["Nombre"].' ---</option>';
		$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$RResSucursal["Id"]."' ORDER BY Nombre ASC");
		while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
		{
			$cadena.='<option value="'.$RResSucursal["Id"].'_'.$RResAlmacenes["Nombre"].'"'; if($RResSucursal["Id"].'_'.$RResAlmacenes["Nombre"]==$almacend){$cadena.=' selected';}$cadena.='>'.$RResAlmacenes["Nombre"].'</option>';
		}
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="texto">
									<input type="submit" name="botadmercancia" id="botadmercancia" value="Trasladar>>" class="boton" onclick="xajax_traslado_almacen(xajax.getFormValues(\'fadmercancia\'))">
								</th>
							</tr>
						</table>
						</form>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function reportes_almacen()
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte de Inventario Inicial</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepinvini" id="frepinvini" method="POST" action="almacen/reporteinvini.php" target="_blank">
								 Producto: <select name="producto" id="producto"><option value="%">Todos</option>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC, Nombre ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$cadena.='<option value="'.$RResProductos["Id"].'">'.$RResProductos["Clave"].' - '.$RResProductos["Nombre"].'</td>';
	}
	$cadena.='		</select> <input type="submit" name="botinvini" id="botinvini" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									<tr>
										<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
											<a href="almacen/reportesininvini.php" target="_blank">Generar Reporte de Productos Sin Inventario Inicial</a>
										</th>
									</tr>
						</table>';
	
//Reporte de movimientos de Inventario
	$cadena.='<p>&nbsp;</p>
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte De Movimientos Al Inventario Por Producto</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepinvini" id="frepinvini" method="POST" action="almacen/reportemovinvprod.php" target="_blank">
								 Producto: <select name="producto" id="producto">';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC, Nombre ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$cadena.='<option value="'.$RResProductos["Id"].'">'.$RResProductos["Clave"].' - '.$RResProductos["Nombre"].'</td>';
	}
	$cadena.='		</select> <input type="submit" name="botinvini" id="botinvini" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									</table>';
	
	//Reporte de Traslados de Mercancia
	$cadena.='<p>&nbsp;</p>
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte De Traslados de Almacen Por Producto</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="freptras" id="freptras" method="POST" action="almacen/reportetraslados.php" target="_blank">
								 Producto: <select name="producto" id="producto"><option value="%">Todos</option>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC, Nombre ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$cadena.='<option value="'.$RResProductos["Id"].'">'.$RResProductos["Clave"].' - '.$RResProductos["Nombre"].'</td>';
	}
	$cadena.='		</select><br />
								Periodo De: <select name="diai" id="diai"><option value="01">Dia</option>';
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
	$cadena.='				</select><br /><input type="submit" name="botinvini" id="botinvini" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									</table>';
	
	//Reporte de Ajustes de Mercancia
	$cadena.='<p>&nbsp;</p>
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte De Ajustes Por Producto</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepajuste" id="frepajuste" method="POST" action="almacen/reporteajustes.php" target="_blank">
								 Producto: <select name="producto" id="producto"><option value="%">Todos</option>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC, Nombre ASC");
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$cadena.='<option value="'.$RResProductos["Id"].'">'.$RResProductos["Clave"].' - '.$RResProductos["Nombre"].'</td>';
	}
	$cadena.='		</select><br />
								Periodo De: <select name="diai" id="diai"><option value="01">Dia</option>';
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
	$cadena.='				</select><br /><input type="submit" name="botinvini" id="botinvini" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									</table>';
									
	//Reporte de Movimientos por Dia
	$cadena.='<p>&nbsp;</p>
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte De Movimientos Por Dia</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepmovdia" id="frepmovdia" method="POST" action="almacen/reportemovdia.php" target="_blank">
								 
								De: <select name="diai" id="diai"><option value="'.date("d").'">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'"';if($form["diai"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesi" id="mesi"><option value="'.date("m").'">Mes</option>
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
								</select><select name="annoi" id="annoi"><option value="'.date("Y").'">Año</option>';
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
	$cadena.='				</select><br /><input type="submit" name="botinvini" id="botinvini" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									</table>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ajustes_inventario($form=NULL)
{
	include ("conexion.php");
	
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_MX");
	
	if($form!=NULL)
	{
		//verificamos todos los campos
		if($form["cantidad"]=='' OR $form["almacen"]=='' OR $form["clave"]=='' OR $form["ajuste"]=='')
		{
			$mensaje='<p align="center" class="textomensaje">Por favor seleccione todos los datos</p>';
		}
		else 
		{
			//id del producto
			$ResIdProd=mysql_fetch_array(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave='".$form["clave"]."' LIMIT 1"));
			//almacen
			$almacen=$_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$form["almacen"];
			//afectamos al inventario
			if($form["movimiento"]=='Entrada'){mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."+".$form["cantidad"]." WHERE IdProducto='".$ResIdProd["Id"]."'")or die(mysql_error());}
			elseif($form["movimiento"]=='Salida'){mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."-".$form["cantidad"]." WHERE IdProducto='".$ResIdProd["Id"]."'")or die(mysql_error());}
			//registramos el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, Fecha, Ajuste, Descripcion, Usuario)
																			VALUES ('".$almacen."', '".$ResIdProd["Id"]."', '".$form["movimiento"]."', '".$form["cantidad"]."',
																							'".date("Y-m-d H:i:s")."', '".$form["ajuste"]."', '".$form["descripcion"]."', '".$_SESSION["usuario"]."')")or die(mysql_error());
			
			$mensaje='<p align="center" class="textomensaje">Se agrego el producto satisfactoriamente</p>';
		}
	}
	if($mensaje)
	{
		$cadena.=$mensaje;
	}
	$cadena.='<form name="fadmercancia" id="fadmercancia">
						<table border="1" cellpadding="3" cellsapacing="0" align="center" bordercolor="#FFFFFF">
							<tr>
								<th colspan="2" bgcolor="#287d29" class="texto3" align="center">Ajuste a Inventario</th>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#7abc7a" class="texto" align="center">
									<input type="radio" name="movimiento" id="movimiento" value="Entrada" checked> Ingreso a Inventario
									<input type="radio" name="movimiento" id="movimiento" value="Salida"> Salida de Inventario
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Ajuste Por: </td>
								<td bgcolor="#7abc7a" align="left" class="texto">
									<select name="ajuste" id="ajuste">
										<option value="">Seleccione</option>
										<option value="A">Ajuste</option>
										<option value="DM">Devolución de Mercancía</option>
										<option value="CM">Cambio por otra Mercancía</option>
										<option value="OP">Obsequio de Provedor</option>
										<option value="CD">Compra Directa</option>
										<option value="FL">Factura Libre</option>
										<option value="OC">Obsequio al Cliente</option>
										<option value="P">Promoción</option>
										<option value="TI">Toma de Inventario</option>
									</select>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Observaciones :</td>
								<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="descripcion" id="descripcion" class="input" size="50">
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Producto: </td>
								<td bgcolor="#7abc7a" align="left" class="texto">
									<input type="text" name="clave" id="clave" size="15" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_almacen(this.value)" value="'.$clave.'">
									<div id="claves" style="position: absolute; width: 400px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Cantidad: </td>
								<td bgcolor="#7abc7a" align="left" class="texto"><input type="text" name="cantidad" id="cantidad" size="15" class="input" value="'.$cantidad.'"></td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" align="left" class="texto">Almacen: </td>
								<td bgcolor="#7abc7a" align="left" class="texto"><select name="almacen" id="almacen">
									<option value="">Seleccione</option>';
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
		$cadena.='<option value="'.$RResAlmacenes["Nombre"].'"'; if($RResAlmacenes["Nombre"]==$form["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacenes["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botajusinv" id="botajusinv" value="Ajustar>>" class="boton" onclick="xajax_ajustes_inventario(xajax.getFormValues(\'fadmercancia\'))">
								</th>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function existencias($buscar=NULL, $clave=NULL, $claveant=NULL)
{
	include ("conexion.php");
	
	$cadena=$buscar["almacen"].'<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
				<tr>
					<td colspan="3" bgcolor="#FFFFFF" class="texto" align="left">
						<form name="fbuscaprod" id="fbuscaprod" action="javascript:void(null)">
							Almacen: <select name="almacen" id="almacen"><option>Seleccione</option>';
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
		$cadena.='				<option value="'.$RResAlmacenes["Nombre"].'"';if($buscar["almacen"]==$RResAlmacenes["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacenes["Nombre"].'</option>';
	}
	$cadena.='				</select> 
							<p>Producto <select name="operador" id="operador">
								<option value="mayor"';if($buscar["operador"]=='mayor'){$cadena.=' selected';}$cadena.='>Mayor Que</option>
								<option value="mayoroigual"';if($buscar["operador"]=='mayoroigual'){$cadena.=' selected';}$cadena.='>Mayor o Igual Que</option>
								<option value="menor"';if($buscar["operador"]=='menor'){$cadena.=' selected';}$cadena.='>Menor Que</option>
								<option value="menoroigual"';if($buscar["operador"]=='menoroigual'){$cadena.=' selected';}$cadena.='>Menor o Igual Que</option>
								<option value="igual"';if($buscar["operador"]=='igual'){$cadena.=' selected';}$cadena.='>Igual Que</option>
							</select> <input type="text" name="valor" id="valor" size="5" class="input" value="';if($buscar==NULL){$cadena.='0';}else{$cadena.=$buscar["valor"];}$cadena.='"> <input type="button" name="botbusclave" id="botbusclave" value="Buscar>>" onclick="xajax_existencias(xajax.getFormValues(\'fbuscaprod\'))" class="boton">
						</form>
					</td>
					<td valign="bottom" bgcolor="#FFFFFF" class="texto" align="right">| <a href="#" onclick="xajax_inventario()">Productos</a> |
				</tr>';
	if($buscar!=NULL)
	{
		$cadena.='<tr>
					<td bgcolor="#4eb24e" class="texto3" align="center">&nbsp;</td>
					<td bgcolor="#4eb24e" class="texto3" align="center">Clave</td>
					<td bgcolor="#4eb24e" class="texto3" align="center">Nombre</td>
					<td bgcolor="#4eb24e" class="texto3" align="center">'.$buscar["almacen"].'</td>
				</tr>';
		if($clave==NULL)
		{
			$ResProductos=mysql_query("SELECT Id, Nombre, Clave FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC");
		}
		else
		{
			$ResProductos=mysql_query("SELECT Id, Nombre, Clave FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave > '".$clave."' ORDER BY Clave ASC");
		}
		$A=1; $bgcolor="#FFFFFF";
		while($RResProductos=mysql_fetch_array($ResProductos))
		{
			//operador
			switch($buscar["operador"])
			{
				case 'mayor';if(inventario_stock($RResProductos["Id"], $_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$buscar["almacen"])>$buscar["valor"]){$imprime='si';}break;
				case 'mayoroigual';if(inventario_stock($RResProductos["Id"], $_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$buscar["almacen"])>=$buscar["valor"]){$imprime='si';}break;
				case 'menor';if(inventario_stock($RResProductos["Id"], $_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$buscar["almacen"])<$buscar["valor"]){$imprime='si';}break;
				case 'menoroigual';if(inventario_stock($RResProductos["Id"], $_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$buscar["almacen"])<=$buscar["valor"]){$imprime='si';}break;
				case 'igual';if(inventario_stock($RResProductos["Id"], $_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$buscar["almacen"])==$buscar["valor"]){$imprime='si';}break;
			}
			if($imprime=='si')
			{
			$cadena.='<tr>
						<td bgcolor="'.$bgcolor.'" class="texto" align="center">'.$A.'</td>
						<td bgcolor="'.$bgcolor.'" class="texto" align="center">'.$RResProductos["Clave"].'</td>
						<td bgcolor="'.$bgcolor.'" class="texto" align="center">'.$RResProductos["Nombre"].'</td>
						<td bgcolor="'.$bgcolor.'" class="texto" align="center">'.inventario_stock($RResProductos["Id"], $_SESSION["empresa"].'_'.$_SESSION["sucursal"].'_'.$buscar["almacen"]).'</td>
					</tr>';
			if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
			elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
			$A++; $clv=$RResProductos["Clave"];
			} 
			$imprime='no';
			if($A==26){break;}
		}
		
	}

	$cadena.='<tr>
				<td colspan="4" bgcolor="'.$bgcolor.'" class="texto" align="right"> <a href="#" onclick="xajax_existencias(xajax.getFormValues(\'fbuscaprod\'), \''.$clv.'\')">Siguiente&gt;&gt;</a> </td>
			</tr>
			  </table>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}


//funcion para calcular inventario
function inventario_stock ($producto=0, $almacen=NULL)
{
	include ("conexion.php"); $cantidad=0;
	
//	$ResII=mysql_fetch_array(mysql_query("SELECT Cantidad, Fecha FROM movinventario WHERE Almacen='".$almacen."' AND Ajuste='II' AND Producto='".$producto."' ORDER BY Fecha DESC LIMIT 1"));
//	//entradas
//	$ResEnt=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS entradas FROM movinventario WHERE Almacen='".$almacen."' AND Movimiento='Entrada' AND Producto='".$producto."' AND Fecha >= '".$ResII["Fecha"]."' AND Ajuste!='II'"));
//	//salidas
//	$ResSal=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS salidas FROM movinventario WHERE Almacen='".$almacen."' AND Movimiento='Salida' AND Producto='".$producto."' AND Fecha >= '".$ResII["Fecha"]."'"));
//	//inventario
//	$inventario=($ResII["Cantidad"]+$ResEnt["entradas"])-$ResSal["salidas"];
	
	//$ResInicio=mysql_fetch_array(mysql_query("SELECT Id FROM movinventario WHERE Producto='".$producto."' AND Almacen='".$almacen."' AND Ajuste='II' ORDER BY Id DESC LIMIT 1"));

	$ResMovimientos=mysql_query("SELECT Id, Movimiento, Cantidad, Ajuste FROM movinventario WHERE Producto='".$producto."' ORDER BY Fecha ASC, Id ASC");
	while($RResMovimientos=mysql_fetch_array($ResMovimientos))
	{
	if($RResMovimientos["Movimiento"]=='Entrada'){$cantidad=$cantidad+$RResMovimientos["Cantidad"]; $cantidad2.=$RResMovimientos["Id"].'-'.$cantidad.'<br />';}
	elseif($RResMovimientos["Movimiento"]=='Salida'){$cantidad=$cantidad-$RResMovimientos["Cantidad"]; $cantidad2.=$RResMovimientos["Id"].'-'.$cantidad.'<br />';}
	if($RResMovimientos["Ajuste"]=='II'){$cantidad=$RResMovimientos["Cantidad"]; $cantidad2.=$RResMovimientos["Id"].'-'.$cantidad.'<br />';}
	}
	
	
	return $cantidad;
}
function inventario_stock_2 ($producto, $almacen)
{
	include ("conexion.php"); $cantidad=0;
	
	$ResII=mysql_fetch_array(mysql_query("SELECT Id, Cantidad, Fecha FROM movinventario WHERE Almacen='".$almacen."' AND Ajuste='II' AND Producto='".$producto."' ORDER BY Id DESC LIMIT 1"));
	//entradas
	$ResEnt=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS entradas FROM movinventario WHERE Almacen='".$almacen."' AND Movimiento='Entrada' AND Producto='".$producto."' AND Fecha >= '".$ResII["Fecha"]."' AND Id != '".$ResII["Id"]."'"));
//	//salidas
	$ResSal=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS salidas FROM movinventario WHERE Almacen='".$almacen."' AND Movimiento='Salida' AND Producto='".$producto."' AND Fecha >= '".$ResII["Fecha"]."' AND Id != '".$ResII["Id"]."'"));
//	//inventario
	$cantidad=($ResII["Cantidad"]+$ResEnt["entradas"])-$ResSal["salidas"];
	
	
	return $cantidad;
}
?>