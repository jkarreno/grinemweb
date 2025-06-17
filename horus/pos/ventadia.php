<?php 
include ("../conexion.php");
require ('../xajax/xajax.inc.php');

//include ("../almacen/funcionesalmacen.php");

$xajax = new xajax();

$xajax->registerFunction("claves");
$xajax->registerFunction("productos");

$xajax->processRequests();

$acumulado=0; $productos=0;

if(isset($_GET["finalizar"]))
{
	/*/actualizamos el debe de los productos
	$ResProductosNotas=mysql_query("SELECT Id FROM det_nota_venta WHERE IdNotaVenta='".$_GET["idnotacierra"]."' ORDER BY Id ASC");
	while($RResPN=mysql_fetch_array($ResProductosNotas))
	{
		mysql_query("UPDATE det_nota_venta SET Debe='".$_POST["debe_".$RResPN["Id"]]."' WHERE Id='".$RResPN["Id"]."'");
	}*/
	
	$ResTotalDebe=mysql_query("SELECT SUM(Debe) AS TotalDebe FROM det_nota_venta WHERE IdNotaVenta='".$_GET["idnotacierra"]."'");
	$RRTD=mysql_fetch_array($ResTotalDebe);
	
	mysql_query("UPDATE nota_venta SET Status='Pagada', Debe='".$_POST["debe"]."' WHERE Id='".$_GET["idnotacierra"]."'") or die (mysql_error());
	
	$ResNumNota=mysql_fetch_array(mysql_query("SELECT Id, NumNota FROM nota_venta WHERE Id='".$_GET["idnotacierra"]."' LIMIT 1"));
	
	$mensaje='<p align="center" class="textomensaje">Se finalizo la cuenta '.$ResNumNota["NumNota"].' <a href="ticket.php?idnota='.$ResNumNota["Id"].'" target="_blank"><img src="../images/imprimir.png" border="0"></a></p>';
}



$ResNotaAbierta=mysql_query("SELECT Status FROM nota_venta WHERE Fecha='".date("Y-m-d")."' AND Status='Abierta' AND Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' LIMIT 1");



if(!isset($_GET["idnota"]) AND mysql_num_rows($ResNotaAbierta)==0)
{
	//Seleccionamos el numero de nota
		$Nota=mysql_query("SELECT NumNota FROM nota_venta WHERE Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' ORDER BY NumNota DESC LIMIT 1");
		$ResNota=mysql_fetch_array($Nota);
		$numnota=$ResNota["NumNota"]+1;
		
		//ingresamos la nota
		mysql_query("INSERT INTO nota_venta (Empresa, Sucursal, NumNota, Fecha, Status)
									 VALUES ('".$_GET["empresa"]."', '".$_GET["sucursal"]."', '".$numnota."', '".date("Y-m-d")."', 'Abierta')") or die(mysql_error());
		//otenemos el id de la nota
		$ResIdNota=mysql_fetch_array(mysql_query("SELECT Id, NumNota FROM nota_venta WHERE Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
		$ResProductosNota=mysql_query("SELECT * FROM det_nota_venta WHERE IdNotaVenta='".$ResIdNota["Id"]."' ORDER BY Id DESC");
		
}
elseif(!isset($_GET["idnota"]) AND mysql_num_rows($ResNotaAbierta)!=0)
{
	//obtenemos Id de la nota
	$ResIdNota=mysql_fetch_array(mysql_query("SELECT Id, NumNota FROM nota_venta WHERE Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' AND Status='Abierta' AND Fecha='".date("Y-m-d")."' ORDER BY Id DESC LIMIT 1"));
	
	//calculamos el total de productos y el total acumulado
	$ResTotalProductos=mysql_query("SELECT SUM(Importe) AS TotalProductos FROM det_nota_venta WHERE IdNotaVenta='".$ResIdNota["Id"]."'");
	$ResProductosNota=mysql_query("SELECT * FROM det_nota_venta WHERE IdNotaVenta='".$ResIdNota["Id"]."' ORDER BY Id DESC");
	$productos=mysql_num_rows($ResProductosNota);
	$RResTotalProductos=mysql_fetch_array($ResTotalProductos);
	$acumulado=$RResTotalProductos["TotalProductos"]; 
}
else
{
	//otenemos el id de la nota
	$ResIdNota=mysql_fetch_array(mysql_query("SELECT Id, NumNota FROM nota_venta WHERE Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' AND Id='".$_GET["idnota"]."' ORDER BY Id DESC LIMIT 1"));
		
	//Obnemos el Id del producto
	$ResIdProducto=mysql_fetch_array(mysql_query("SELECT Id, Clave, Costo, PrecioPublico FROM productos WHERE Clave='".$_POST["clave"]."' AND Empresa='".$_GET["empresa"]."' AND Sucursal='".$_GET["sucursal"]."' LIMIT 1"));
	
if(isset($_GET["idproducto"]))
{
	//borra producto
	mysql_query("DELETE FROM det_nota_venta WHERE Id='".$_GET["idproducto"]."'") or die(mysql_error());
	
	mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdNotaVenta, Fecha, Descripcion, Usuario)
																	VALUES ('".$_GET["empresa"]."_".$_GET["sucursal"]."_PRINCIPAL',
																					'".$ResIdProducto["Id"]."',
																					'Entrada',
																					'".$_POST["cantidad"]."',
																					'".$ResIdNota["Id"]."',
																					'".date("Y-m-d")."',
																					'Cancelación en la Cuenta',
																					'".$_SESSION["usuario"]."')") or die(mysql_error().'1');
}

else 
{
	//Inserta en detalle de la nota
	mysql_query("INSERT INTO det_nota_venta (Empresa, Sucursal, IdNotaVenta, IdProducto, Clave, Cantidad, Hora, Costo, PrecioUnitario, Importe, Usuario)
																	 VALUES ('".$_GET["empresa"]."',
																	 				 '".$_GET["sucursal"]."',	
																	 				 '".$ResIdNota["Id"]."',
																	 				 '".$ResIdProducto["Id"]."',
																	 				 '".$ResIdProducto["Clave"]."',
																	 				 '".$_POST["cantidad"]."',
																	 				 '".date("Y-m-d")." ".$_POST["reloj"]."',
																	 				 '".$ResIdProducto["Costo"]."',
																	 				 '".$ResIdProducto["PrecioPublico"]."',
																	 				 '".($_POST["cantidad"]*$ResIdProducto["PrecioPublico"])."',
																	 				 '".$_SESSION["usuario"]."')") or die (mysql_error().'2');
	
	//registra el movimiento
	mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdNotaVenta, Fecha, Usuario)
																	VALUES ('".$_GET["empresa"]."_".$_GET["sucursal"]."_PRINCIPAL',
																					'".$ResIdProducto["Id"]."',
																					'Salida',
																					'".$_POST["cantidad"]."',
																					'".$ResIdNota["Id"]."',
																					'".date("Y-m-d")."',
																					'".$_SESSION["usuario"]."')") or die(mysql_error().'3');
	
	//actualizamos el debe de los productos
	$ResProductosNotas=mysql_query("SELECT Id FROM det_nota_venta WHERE IdNotaVenta='".$ResIdNota["Id"]."' ORDER BY Id ASC");
	while($RResPN=mysql_fetch_array($ResProductosNotas))
	{
		mysql_query("UPDATE det_nota_venta SET Debe='".$_POST["debe_".$RResPN["Id"]]."' WHERE Id='".$RResPN["Id"]."'");
	}
																					
	
}	
	//calculamos el total de productos y el total acumulado
	$ResTotalProductos=mysql_query("SELECT SUM(Importe) AS TotalProductos, SUM(Debe) AS DebeProducto FROM det_nota_venta WHERE IdNotaVenta='".$ResIdNota["Id"]."'");
	$ResProductosNota=mysql_query("SELECT * FROM det_nota_venta WHERE IdNotaVenta='".$ResIdNota["Id"]."' ORDER BY Id DESC");
	$productos=mysql_num_rows($ResProductosNota);
	$RResTotalProductos=mysql_fetch_array($ResTotalProductos);
	$acumulado=$RResTotalProductos["TotalProductos"]-$RResTotalProductos["DebeProducto"];
	
	//Actualizamos el total de la nota
	mysql_query("UPDATE nota_venta SET Total='".$RResTotalProductos["TotalProductos"]."', Debe='".$RResTotalProductos["DebeProducto"]."' WHERE Id='".$ResIdNota["Id"]."'");

}
?>
<html>
<head>
<title></title>
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css">
<style>
td { border:1px solid #FFFFFF;}
</style>
<?php $xajax->printJavascript('../xajax/'); ?>
<script language="JavaScript" type="text/javascript" src="../js/codigo.js"></script>
<script language="JavaScript">
function mueveReloj(){ 
   	momentoActual = new Date() 
   	hora = momentoActual.getHours() 
   	minuto = momentoActual.getMinutes() 
   	segundo = momentoActual.getSeconds() 

   	str_segundo = new String (segundo) 
   	if (str_segundo.length == 1) 
      	 segundo = "0" + segundo 

   	str_minuto = new String (minuto) 
   	if (str_minuto.length == 1) 
      	 minuto = "0" + minuto 

   	str_hora = new String (hora) 
   	if (str_hora.length == 1) 
      	 hora = "0" + hora 

   	horaImprimible=hora+":"+minuto+":"+segundo 

   	document.fnotaventa.reloj.value = horaImprimible 

   	setTimeout("mueveReloj()",1000) 
} 
</script>
</head>
<body background="" class="body" onload="mueveReloj()">
<?php echo $mensaje;?>

	<form name="ffinalizar" id="ffinalizar" method="POST" action="ventadia.php?empresa=<?php echo $_GET["empresa"];?>&sucursal=<?php echo $_GET["sucursal"];?>&idnotacierra=<?php echo $ResIdNota["Id"];?>&finalizar=si">
	<table border="0" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<td colspan="9" bgcolor="#754200" align="center" class="texto3">Venta del d&iacute;a</td>
		</tr>
		<tr>
			<td colspan="9" bgcolor="#ba9464" align="left" class="texto">Nota Num.: <?php echo $ResIdNota["NumNota"];?> | Productos Vendidos: <?php echo $productos;?> | Acumulado del Dia: $<?php echo number_format($acumulado,2);?> | Debe: $ <input type="text" name="debe" id="debe" size="5" class="input"> <input type="submit" name="botfinnota" id="botfinnota" class="boton" value="Finalizar Cuenta >>"></td>
		</tr>
	</table>
	</form>
	<form name="fnotaventa" id="fnotaventa" method="POST" action="ventadia.php?empresa=<?php echo $_GET["empresa"];?>&sucursal=<?php echo $_GET["sucursal"];?>&idnota=<?php echo $ResIdNota["Id"];?>">
	<table border="0" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<td bgcolor="#754200" align="center" class="texto3">Num.</td>
			<td bgcolor="#754200" align="center" class="texto3">Cantidad</td>
			<td bgcolor="#754200" align="center" class="texto3">Clave</td>
			<td bgcolor="#754200" align="center" class="texto3">Descripci&oacute;n</td>
			<td bgcolor="#754200" align="center" class="texto3">Precio Unitario</td>
			<td bgcolor="#754200" align="center" class="texto3">Subtotal</td>
			<td bgcolor="#754200" align="center" class="texto3">Total</td>
			<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
		</tr>
		<tr>
				<td bgcolor="#ba9464" align="center" class="texto">&nbsp;</td>
				<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="cantidad" id="cantidad" size="3" value="1" class="input"></td>
				<td bgcolor="#ba9464" align="center" class="texto">
					<input type="text" name="clave" id="clave" size="10" value="" class="input" onKeyUp="claves.style.visibility='visible'; xajax_claves(<?php echo $_GET["empresa"];?>, <?php echo $_GET["sucursal"];?>, this.value, document.getElementById('cantidad').value)">
					<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
				</td>
				<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="descripcion" id="descripcion" size="25" value="" class="input" onKeyUp="claves.style.visibility='visible'; xajax_claves(<?php echo $_GET["empresa"];?>, <?php echo $_GET["sucursal"];?>, this.value, document.getElementById('cantidad').value)"></td>
				<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="preciounitario" id="preciounitario" size="5" value="" class="input"></td>
				<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="subtotal" id="subtotal" size="5" value="" class="input"></td>
				<td bgcolor="#ba9464" align="center" class="texto"><input type="text" name="total" id="total" size="5" value="" class="input"></td>
				<td bgcolor="#ba9464" align="center" class="texto"><img src="../images/pixel.png" border="0" onload="document.fnotaventa.clave.focus()">
					<input type="hidden" name="reloj" id="reloj" size="5" class="input">
					<input type="submit" name="botadproducto" id="botadproducto" size="3" value="Agregar >>" class="boton"></td>
			</tr>
<?php 
	$bgcolor="#FFFFFF"; $A=1;
	while($RResProductosNota=mysql_fetch_array($ResProductosNota))
	{
		
		
		$NombreProd=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResProductosNota["IdProducto"]."' AND Clave='".$RResProductosNota["Clave"]."' LIMIT 1"));
		echo '<tr>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$A.'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResProductosNota["Cantidad"].'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResProductosNota["Clave"].'</td>
						<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.utf8_encode($NombreProd["Nombre"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResProductosNota["PrecioUnitario"],2).'</td>
						<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResProductosNota["Importe"],2).'</td>
						<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format(($RResProductosNota["Importe"]-$RResProductosNota["Debe"]),2).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto">
							<a href="ventadia.php?empresa='.$_GET["empresa"].'&sucursal='.$_GET["sucursal"].'&idnota='.$ResIdNota["Id"].'&idproducto='.$RResProductosNota["Id"].'"><img src="../images/x.png" border="0"></a>
						</td>
					</tr>';
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
		$A++;
	}
?>
	</table>
	</form>
</body>

<?php 
function claves ($empresa, $sucursal, $clave, $cantidad)
{
include ("../conexion.php");
	
	$almacen2=$empresa."_".$sucursal."_".'PRINCIPAL';
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
						</tr>';
	
	$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, PrecioPublico FROM productos WHERE Empresa='".$empresa."' AND Sucursal='".$sucursal."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		
			$clave=$RResClaves["Clave"];
			$precio=$RResClaves["PrecioPublico"];
		$iva=1.16;
		 $cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.descripcion.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.preciounitario.value=\''.($precio*$iva).'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.subtotal.value=\''.number_format(($precio*$iva)*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.descripcion.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.preciounitario.value=\''.($precio*$iva).'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.subtotal.value=\''.number_format(($precio*$iva)*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>';
		$cadena.='</tr>';
		
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}

function productos ($empresa, $sucursal, $producto, $cantidad)
{
include ("../conexion.php");
	
	$almacen2=$empresa."_".$sucursal."_".'PRINCIPAL';
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
						</tr>';
	
	$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, PrecioPublico FROM productos WHERE Empresa='".$empresa."' AND Sucursal='".$sucursal."' AND Nombre LIKE '%".$producto."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		
			$clave=$RResClaves["Clave"];
			$precio=$RResClaves["PrecioPublico"];
			$iva=1.16;
		 $cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.descripcion.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.preciounitario.value=\''.($precio*$iva).'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format(($precio*$iva)*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fnotaventa.descripcion.value=\''.$RResClaves["Nombre"].'\'; document.fnotaventa.preciounitario.value=\''.($precio*$iva).'\'; document.fnotaventa.clave.value=\''.$clave.'\'; document.fnotaventa.total.value=\''.number_format(($precio*$iva)*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>';
		$cadena.='</tr>';
		
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}


function ajustes_inventario($form=NULL)
{
	include ("conexion.php");
	
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
																							'".date("Y-m-d")."', '".$form["ajuste"]."', '".$form["descripcion"]."', '".$_SESSION["usuario"]."')")or die(mysql_error());
			
			$mensaje='<p align="center" class="textomensaje">Se agrego el producto satisfactoriamente</p>';
		}
	}
	if($mensaje)
	{
		$cadena.=$mensaje;
	}
	$cadena.='<form name="fadmercancia" id="fadmercancia">
						<table border="0" cellpadding="3" cellsapacing="0" align="center" bordercolor="#FFFFFF">
							<tr>
								<th colspan="2" bgcolor="#754200" class="texto3" align="center">Ajuste a Inventario</th>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#ba9464" class="texto" align="center">
									<input type="radio" name="movimiento" id="movimiento" value="Entrada" checked> Ingreso a Inventario
									<input type="radio" name="movimiento" id="movimiento" value="Salida"> Salida de Inventario
							</tr>
							<tr>
								<td bgcolor="#ba9464" align="left" class="texto">Ajuste Por: </td>
								<td bgcolor="#ba9464" align="left" class="texto">
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
									</select>
							</tr>
							<tr>
								<td bgcolor="#ba9464" align="left" class="texto">Observaciones :</td>
								<td bgcolor="#ba9464" align="left" class="texto"><input type="text" name="descripcion" id="descripcion" class="input" size="50">
							</tr>
							<tr>
								<td bgcolor="#ba9464" align="left" class="texto">Producto: </td>
								<td bgcolor="#ba9464" align="left" class="texto">
									<input type="text" name="clave" id="clave" size="15" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_almacen(this.value)" value="'.$clave.'">
									<div id="claves" style="position: absolute; width: 400px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#ba9464" align="left" class="texto">Cantidad: </td>
								<td bgcolor="#ba9464" align="left" class="texto"><input type="text" name="cantidad" id="cantidad" size="15" class="input" value="'.$cantidad.'"></td>
							</tr>
							<tr>
								<td bgcolor="#ba9464" align="left" class="texto">Almacen: </td>
								<td bgcolor="#ba9464" align="left" class="texto"><select name="almacen" id="almacen">
									<option value="">Seleccione</option>';
	$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
	{
		$cadena.='<option value="'.$RResAlmacenes["Nombre"].'"'; if($RResAlmacenes["Nombre"]==$form["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacenes["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#ba9464" align="center" class="texto">
									<input type="button" name="botajusinv" id="botajusinv" value="Ajustar>>" class="boton" onclick="xajax_ajustes_inventario(xajax.getFormValues(\'fadmercancia\'))">
								</th>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}

//funcion para calcular inventario
function inventario_stock ($producto, $almacen=NULL)
{
	include ("../conexion.php"); $cantidad=0;
	

	$ResMovimientos=mysql_query("SELECT Movimiento, Cantidad FROM movinventario WHERE Producto='".$producto."' ORDER BY Fecha ASC, Id ASC");
	while($RResMovimientos=mysql_fetch_array($ResMovimientos))
	{
	if($RResMovimientos["Movimiento"]=='Entrada'){$cantidad=$cantidad+$RResMovimientos["Cantidad"];}
	elseif($RResMovimientos["Movimiento"]=='Salida'){$cantidad=$cantidad-$RResMovimientos["Cantidad"];}
	if($RResMovimientos["Descripcion"]=='Inventario Inicial'){$cantidad=$RResMovimientos["Cantidad"];}
	}
	
	
	return $cantidad;
}
?>