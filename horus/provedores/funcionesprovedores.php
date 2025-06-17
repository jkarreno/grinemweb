<?php
function provedores($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$ResEmpresa=mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1");
	$RResEmpresa=mysql_fetch_array($ResEmpresa);
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="9" bgcolor="#FFFFFF" class="texto" align="right">| <a href="#" onclick="xajax_provedores(\'agregar\', \'1\')">Agregar Provedor</a> |</th>
						</tr>
					 	<tr>
							<th colspan="9" bgcolor="#4db6fc" class="texto3" align="center">Provedores '.$RResEmpresa["Nombre"].'</th>
						</tr>';
//area de trabajo
  switch ($modo)
  {
  	case 'agregar': //AGREGAR PROVEDOR
  		$cadena.='<tr>
							<th colspan="9" bgcolor="#cceaff" class="texto" align="center">';
  		if($accion==1)//formulario para agregar provedor
  		{
  			$cadena.='<form name="fadprov" id="fadprov">
								<table border="0" cellpadding="5" cellspacing="0" align="center">
									<tr>
										<td align="left" class="texto">Nombre: </td>
										<th colspan="3" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Direcci&oacute;n: </th>
										<th colspan="3" align="left"><input type="text" name="direccion" id="direccion" class="input" size="50"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Colonia: </td>
										<td align="left" class="texto"><input type="text" name="colonia" id="colonia" class="input"></td>
										<td align="left" class="texto">Ciudad: </td>
										<td align="left" class="texto"><input type="text" name="ciudad" id="ciudad" class="input"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Codigo Postal: </td>
										<td align="left" class="texto"><input type="text" name="cp" id="cp" class="input"></td>
										<td align="left" class="texto">Estado: </td>
										<td align="left" class="texto"><input type="text" name="estado" id="estado" class="input"></td>
									</tr>
									<tr>
										<td align="left" class="texto">R.F.C.: </td>
										<th colspan="3" align="left" class="texto"><input type="text" name="rfc" id="rfc" size="50" class="input"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Telefono: </td>
										<td align="left" class="texto"><input type="text" name="telefono" id="telefono" class="input"></td>
										<td align="left" class="texto">Telefono 2: </td>
										<td align="left" class="texto"><input type="text" name="telefono2" id="telefono2" class="input"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Fax: </td>
										<td align="left" class="texto"><input type="text" name="fax" id="fax" class="input"></td>
										<td align="left" class="texto">Email: </td>
										<td align="left" class="texto"><input type="text" name="correoe" id="correoe" class="input"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Credito: </td>
										<td align="left" class="texto"><input type="text" name="dcredito" id="dcredito" size="5" class="input"> dias</td>
										<td align="left" class="texto">Limite de Credito: </td>
										<td align="left" class="texto">$ <input type="text" name="lcredito" id="lcredito" size="10" clasS="input"></td>
									</tr>
									<tr>
										<th colspan="4" align="center" class="texto"><input type="button" name="botadprovedor" id="botadprovedor" value="Agregar Provedor>>" class="boton" onclick="xajax_provedores(\'agregar\', \'2\', xajax.getFormValues(\'fadprov\'))"></th>
									</tr>
								</table>
								</form>';
  		}
  		else if($accion==2)//agregando al provedor
  		{
  			if(mysql_query("INSERT INTO provedores (Empresa, Sucursal, Nombre, Direccion, Colonia, Ciudad, CP, Estado, RFC, Telefono, Telefono2, Fax, CorreoE, DiasCredito, Credito)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["nombre"])."', '".utf8_decode($form["direccion"])."',
  																							'".utf8_decode($form["colonia"])."', '".utf8_decode($form["ciudad"])."', '".$form["cp"]."', 
  																							'".utf8_decode($form["estado"])."', '".utf8_decode($form["rfc"])."', '".$form["telefono"]."',
  																							'".$form["telefono2"]."', '".$form["fax"]."', '".$form["correoe"]."', '".$form["dcredito"]."', '".str_replace(',','',$form["lcredito"])."')"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se agrego el provedor satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un error, por favor intente nueamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
  		break;
  	case 'editar': //EDITAR PROVEDOR
  		$cadena.='<tr>
									<th colspan="9" bgcolor="#cceaff" class="texto" align="center">';
  		if($accion==1)//formulario para editar provedor
  		{
  			$ResProvedor=mysql_query("SELECT * FROM provedores WHERE Id='".$form."' LIMIT 1");
  			$RResProvedor=mysql_fetch_array($ResProvedor);
  			
  			$cadena.='<form name="feditprov" id="feditprov">
								<table border="0" cellpadding="5" cellspacing="0" align="center">
									<tr>
										<td align="left" class="texto">Nombre: </td>
										<th colspan="3" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResProvedor["Nombre"].'"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Direcci&oacute;n: </th>
										<th colspan="3" align="left"><input type="text" name="direccion" id="direccion" class="input" size="50" value="'.$RResProvedor["Direccion"].'"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Colonia: </td>
										<td align="left" class="texto"><input type="text" name="colonia" id="colonia" class="input" value="'.$RResProvedor["Colonia"].'"></td>
										<td align="left" class="texto">Ciudad: </td>
										<td align="left" class="texto"><input type="text" name="ciudad" id="ciudad" class="input" value="'.$RResProvedor["Ciudad"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Codigo Postal: </td>
										<td align="left" class="texto"><input type="text" name="cp" id="cp" class="input" value="'.$RResProvedor["CP"].'"></td>
										<td align="left" class="texto">Estado: </td>
										<td align="left" class="texto"><input type="text" name="estado" id="estado" class="input" value="'.$RResProvedor["Estado"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">R.F.C.: </td>
										<th colspan="3" align="left" class="texto"><input type="text" name="rfc" id="rfc" size="50" class="input" value="'.$RResProvedor["RFC"].'"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Telefono: </td>
										<td align="left" class="texto"><input type="text" name="telefono" id="telefono" class="input" value="'.$RResProvedor["Telefono"].'"></td>
										<td align="left" class="texto">Telefono 2: </td>
										<td align="left" class="texto"><input type="text" name="telefono2" id="telefono2" class="input" value="'.$RResProvedor["Telefono2"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Fax: </td>
										<td align="left" class="texto"><input type="text" name="fax" id="fax" class="input" value="'.$RResProvedor["Fax"].'"></td>
										<td align="left" class="texto">Email: </td>
										<td align="left" class="texto"><input type="text" name="correoe" id="correoe" class="input" value="'.$RResProvedor["CorreoE"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Credito: </td>
										<td align="left" class="texto"><input type="text" name="dcredito" id="dcredito" size="5" class="input" value="'.$RResProvedor["DiasCredito"].'"> dias</td>
										<td align="left" class="texto">Limite de Credito: </td>
										<td align="left" class="texto">$ <input type="text" name="lcredito" id="lcredito" size="10" clasS="input" value="'.number_format($RResProvedor["Credito"], 2).'"></td>
									</tr>
									<tr>
										<th colspan="4" align="center" class="texto">
											<input type="hidden" name="idprovedor" id="idprovedor" value="'.$form.'">
											<input type="button" name="botadprovedor" id="botadprovedor" value="Editar Provedor>>" class="boton" onclick="xajax_provedores(\'editar\', \'2\', xajax.getFormValues(\'feditprov\'))">
										</th>
									</tr>
								</table>
								</form>';
  		}
  		if($accion==2)//Editando el provedor
  		{
  			if(mysql_query("UPDATE provedores SET Nombre='".utf8_decode($form["nombre"])."',
  																						Direccion='".utf8_decode($form["direccion"])."', 
  																						Colonia='".utf8_decode($form["colonia"])."',
  																						Ciudad='".utf8_decode($form["ciudad"])."',
  																						Estado='".utf8_decode($form["estado"])."',
  																						CP='".$form["cp"]."',
  																						RFC='".$form["rfc"]."',
  																						Telefono='".$form["telefono"]."',
  																						Telefono2='".$form["telefono2"]."',
  																						Fax='".$form["fax"]."',
  																						CorreoE='".$form["correoe"]."',
  																						DiasCredito='".$form["dcredito"]."',
  																						Credito='".str_replace(',','',$form["lcredito"])."'
  																			WHERE Id='".$form["idprovedor"]."'"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se actualizo el provedor satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadea.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
  		break;
  	case 'eliminar': //ELIMINAR PROVEDOR
  		$cadena.='<tr>
									<th colspan="9" bgcolor="#cceaff" class="texto" align="center">';
  		if($accion==1)
  		{
  			$ResProvedor=mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$form."' LIMIT 1");
  			$RResProvedor=mysql_fetch_array($ResProvedor);
  			
  			$cadena.='Esta seguro de eliminar al provedor '.$RResProvedor["Nombre"].'<br />
  								<a href="#" onclick="xajax_provedores(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_provedores()">No</a>';
  		}
  		elseif($accion==2)
  		{
  			if(mysql_query("DELETE FROM provedores WHERE Id='".$form."' LIMIT 1"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se elimino el Provedor satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
  		break;
  }
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Nombre</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Direcci&oacute;n</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Colonia</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Ciudad</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Estado</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">R.F.C.</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Telefono</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResProvedores=mysql_query("SELECT * FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	$bgcolor="#FFFFFF"; $J=1;
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="middle">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["Direccion"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["Colonia"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["Ciudad"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["Estado"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["RFC"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResProvedores["Telefono"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="middle">
									<a href="#" onclick="xajax_provedores(\'editar\', \'1\', \''.$RResProvedores["Id"].'\')"><img src="images/edit.png" border="0" alt="Editar"></a> 
									<a href="#" onclick="xajax_provedores(\'eliminar\', \'1\', \''.$RResProvedores["Id"].'\')"><img src="images/x.png" border="0" alt="Eliminar"></a>
								</td>
							</tr>';
		$J++;
		if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
		else if($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function compra_provedor($limite=0, $status='Pendiente', $modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="3" bgcolor="#FFFFFF" class="texto" align="rigth">
							 Status: <select name="bcomprov" id="bcomprov">
							 	<option value="Pendiente"';if($status=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente</option>
							 	<option value="Recibida"';if($status=='Recibida'){$cadena.=' selected';}$cadena.='>Recibida</option>
							 	<option value="Facturado"';if($status=='Facturado'){$cadena.=' selected';}$cadena.='>Facturada</option>
							 	<option value="Cancelada"';if($status=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
							 	</select><input type="button" name="botbuscomprov" id="botbuscomprov" value="Buscar>>" class="boton" onclick="xajax_compra_provedor(\'0\', document.getElementById(\'bcomprov\').value)">
							<th colspan="6" bgcolor="#FFFFFF" class="texto" align="right" valign="top">| <a href="#" onclick="xajax_nueva_orden_compra_provedor()">Nueva Orden de Compra</a> |</th>
						</tr>
					 	<tr>
							<th colspan="9" bgcolor="#4db6fc" class="texto3" align="center">Ordenes de Compra</th>
						</tr>';
	switch($modo)
	{
		case 'cancelar':
			if($accion==1)
			{
				$ResOrden=mysql_fetch_array(mysql_query("SELECT NumOrden, Provedor FROM ordenescompraprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$form."' LIMIT 1"));
				$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$ResOrden["Provedor"]."' LIMIT 1"));
				$cadena.='<tr>
										<th colspan="8" bgcolor="#cceaff" align="center" class="texto">
											Esta seguro de cancelar la orden numero '.$ResOrden["NumOrden"].' asiganada al Provedor '.$ResProvedor["Nombre"].'? <br />
											<a href="#" onclick="xajax_compra_provedor(\''.$limite.'\', \''.$status.'\', \'cancelar\', \'2\', \''.$form.'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_compra_provedor(\''.$limite.'\')">No</a>
									</tr>';
			}
			elseif($accion==2)
			{
				$ResOrden=mysql_fetch_array(mysql_query("SELECT NumOrden, Provedor FROM ordenescompraprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$form."' LIMIT 1"));
				mysql_query("UPDATE ordenescompraprovedores SET Status='Cancelada' WHERE Id='".$form."'");
				mysql_query("UPDATE ordencompraprov SET Status='Cancelada' WHERE Empresa='".$_SESION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$ResOrden["NumOrden"]."' AND Provedor='".$ResOrden["Provedor"]."'");
				$cadena.='<tr>
										<th colspan="9" bgcolor="#cceaff" align="center" class="textomensaje">
										Se cancelo la Orden satisfactoriamente
										</th>
									</tr>';
			}
			break;
	}
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Num. Orden</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Fecha</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Provedor</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Status</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Comprador</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Modificada Por</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Factura Provedor</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResOrdenes=mysql_query("SELECT * FROM ordenescompraprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status LIKE '".$status."' ORDER BY NumOrden DESC LIMIT ".$limite.", 25");
	$bgcolor="#FFFFFF"; $J=1;
	while($RResOrdenes=mysql_fetch_array($ResOrdenes))
	{
		$ResProv=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResOrdenes["Provedor"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
		$ResUsuario=mysql_fetch_array(mysql_query("SELECT Nombre FROM usuarios WHERE Id='".$RResOrdenes["Usuario"]."' LIMIT 1"));
		
		$ResFacProv=mysql_query("SELECT FacturaP FROM facturasprovedores WHERE IdOrdenCompra LIKE '".$RResOrdenes["Id"].">>' ORDER BY Id ASC");
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$RResOrdenes["NumOrden"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$RResOrdenes["FechaOrden"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$ResProv["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$RResOrdenes["Status"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$RResOrdenes["Comprador"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">'.$ResUsuario["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">';
		while($RResFacProv=mysql_fetch_array($ResFacProv))
		{
			$cadena.='- '.$RResFacProv["FacturaP"].'<br />';
		}
		$cadena.='	</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="top">
									<a href="provedores/ordencompra.php?numorden='.$RResOrdenes["NumOrden"].'" target="_blank"><img src="images/print.png" border="0"></a>
									<a href="#" onclick="xajax_ver_orden_compra_provedor(\''.$RResOrdenes["Id"].'\')"><img src="images/ver.png" border="0" alt="Consultar Orden"></a>';
		if($RResOrdenes["Status"]!='Cancelada')
		{
			$cadena.='<a href="#" onclick="xajax_compra_provedor(\''.$limite.'\', \''.$status.'\', \'cancelar\', \'1\', \''.$RResOrdenes["Id"].'\')"><img src="images/x.png" border="0" alt="Cancelar"></a>';
		}
		$cadena.='	</td>
							</tr>';
		
		$J++;
		if($bgcolor=='#FFFFFF'){$bgcolor='#CCCCCC';}
		elseif($bgcolor=='#CCCCCC'){$bgcolor='#FFFFFF';}
	}
	$regs=mysql_num_rows(mysql_query("SELECT Id FROM ordenescompraprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status LIKE '".$status."'"));
	$cadena.='	<tr>
								<th colspan="9" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_compra_provedor(\''.$J.'\', \''.$status.'\')">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
	          </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function nueva_orden_compra_provedor($orden=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena.='<form name="fordencompra" id="fordencompra">
						<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="7" bgcolor="#4db6fc" class="texto3" align="center">Nueva Orden de Compra</th>
						</tr>';
	if($mensaje)
	{
		$cadena.='<tr>
								<th colspan="7" bgcolor="#cceaff">'.$mensaje.'</th>
							</tr>
							<tr>
							<td align="center" class="texto3" bgcolor="#4db6fc">&nbsp;</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Cantidad</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Clave</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Nombre</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Costo</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Importe</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">&nbsp;</td>
						</tr>';
	}
	else
	{
		$cadena.='<tr>
							<th colspan="2" class="texto" bgcolor="#cceaff" align="left">Provedor: </th>
							<th colspan="2" class="texto" bgcolor="#cceaff" align="left"><select name="provedor" id="provedor" onchange="document.fordencompra.cantidad.focus();">
								<option value="todos">Todos</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='	<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$orden["provedor"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='	</select>
						 </th>
						 <th class="texto" bgcolor="#cceaff" align="left">Descuento: </th>
						 <th class="texto" bgcolor="#cceaff" align="left" colspan="2"><input type="text" name="descuento" id="descuento" class="input" size="5"> %</th>
						</tr>
						<tr>
							<th colspan="2" class="texto" bgcolor="#cceaff" align="left" valign="top">Observaciones: </th>
							<th colspan="5" class="texto" bgcolor="#cceaff" align="left" valign="top"><textarea name="observaciones" id="observaciones" cols="50" rows="3" class="input">'.$orden["observaciones"].'</textarea></th>
						</tr>
						<tr>
							<th colspan="2" class="texto" bgcolor="#cceaff" align="left" valign="top">Comprador: </th>
							<th colspan="5" class="texto" bgcolor="#cceaff" align="left" valign="top"><input type="text" name="comprador" id="comprador" value="'.$orden["comprador"].'" class="input" size="50"></td>
						</tr>
						<tr>
							<td align="center" class="texto3" bgcolor="#4db6fc">&nbsp;</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Cantidad</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Clave</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Nombre</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Costo</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">Importe</td>
							<td align="center" class="texto3" bgcolor="#4db6fc">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="texto" bgcolor="#cceaff"><input type="hidden" name="idproducto" id="idproducto" value=""></td>
							<td align="center" class="texto" bgcolor="#cceaff"><input type="text" name="cantidad" id="cantidad" class="input" size="5" value="1" onKeyUp="calculo(this.value,costo.value,importe);"></td>
							<td align="center" class="texto" bgcolor="#cceaff">
								<input type="text" name="clave" id="clave" class="input" size="15" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves(this.value, document.getElementById(\'provedor\').value, document.getElementById(\'cantidad\').value)">
								<div id="claves" style="position: absolute; width: 100px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
							</td>
							<td align="left" class="texto" bgcolor="#cceaff">
								<input type="text" name="nombre" id="nombre" class="input" size="60" onKeyUp="nombres.style.visibility=\'visible\'; xajax_nombres(this.value, document.getElementById(\'provedor\').value, document.getElementById(\'cantidad\').value)">
								<div id="nombres" style="position: absolute; width: 300px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
							</td>
							<td align="center" class="texto3" bgcolor="#cceaff"><input type="text" name="costo" id="costo" class="input" size="10" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
							<td align="center" class="texto3" bgcolor="#cceaff"><input type="text" name="importe" id="importe" class="input" size="10"></td>
							<td align="center" class="texto" bgcolor="#cceaff">
								<input type="hidden" name="totalproductos" id="totalproductos" value="'.($numprod-1).'">
								<input type="button" name="botadprod" id="botadprod" value="Agregar>>" onclick="xajax_nueva_orden_compra_provedor(xajax.getFormValues(\'fordencompra\'))" class="boton"></td>
						</tr>';
	  }
$bgcolor="#FFFFFF"; $i=1; $J=1; $array=array();
	if($orden==NULL)
	{
		$partidas=1;
	}
	elseif($orden!=NULL)
	{
		if($borraprod==NULL)
		{
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0)
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#cceaff" class="textomensaje">Compra Invalida</th>
									</tr>';
				$partidas=$orden["partidas"];
			}
			//Agrega Productos a la orden
			
				for($J=1; $J<$orden["partidas"];$J++)
				{
					if($orden["idproducto_".$J]==$orden["idproducto"])
					{
						$ftotal=str_replace(',','',$orden["importe_".$J])+str_replace(',','',$orden["importe"]);
						$arreglo=array($J, $orden["idproducto_".$J], ($orden["cantidad_".$J]+$orden["cantidad"]), $orden["clave_".$J], $orden["costo_".$J], $ftotal);
						array_push($array, $arreglo);
						$agregado=1;
						$partidas=$orden["partidas"];
					}
					else
					{
						$ftotal=str_replace(',','',$orden["importe_".$J]);
						$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["costo_".$J], $ftotal);
						array_push($array, $arreglo);
					}
				}
				if(!$agregado)
				{
					$ftotal=str_replace(',','',$orden["importe"]);
					$arreglo=array($J, $orden["idproducto"], $orden["cantidad"], $orden["clave"], $orden["costo"], $ftotal);
					array_push($array, $arreglo);
					$partidas=count($array)+1;
				}
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$orden["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$orden["importe_".$i]);
					$arreglo=array($j, $orden["idproducto_".$i], $orden["cantidad_".$i], $orden["clave_".$i], $orden["costo_".$i], $ftotal);
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
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="costo_'.$array[$T][0].'" id="costo_'.$array[$T][0].'" value="'.$array[$T][4].'">'.$array[$T][4].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="importe_'.$array[$T][0].'" id="importe_'.$array[$T][0].'" value="'.$array[$T][5].'">'.$array[$T][5].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto">
							 		<a href="#" onclick="xajax_nueva_orden_compra_provedor(xajax.getFormValues(\'fordencompra\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
			elseif($bgcolor="#CCCCCC"){$bgcolor='#FFFFFF';}
			
			$subtotal=$subtotal+$array[$T][5];
		}
		
	}
	$ivaa=0.16;
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
						 	<th colspan="7" bgcolor="#FFFFFF" align="center" class="texto">
						 	<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
						 		<input type="button" name="botfinordenventa" id="botonfinordenventa" value="Guardar Orden de Venta>>" class="boton" onclick="xajax_guarda_orden_compra_provedor(xajax.getFormValues(\'fordencompra\'))">
						 	</th>
						 </tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_orden_compra_provedor($orden)
{
	include("conexion.php");
		
	//numero de orden
	$numorden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenescompraprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumOrden DESC LIMIT 1"));
	
	$numo=$numorden["NumOrden"]+1;
	if(mysql_query("INSERT INTO ordenescompraprovedores (Empresa, Sucursal, Provedor, NumOrden, FechaOrden, Status, Observaciones, Comprador, Usuario)
																						 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$orden["provedor"]."', '".$numo."', '".date("Y-m-d")."',
																						 				 'Pendiente', '".utf8_decode($orden["observaciones"])."', '".utf8_decode($orden["comprador"])."', '".$_SESSION["usuario"]."')"))
	{
		$idorden=mysql_fetch_array(mysql_query("SELECT Id, NumOrden FROM ordenescompraprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
		for($t=1; $t<$orden["partidas"];$t++)
		{
			mysql_query("INSERT INTO ordencompraprov (Empresa, Sucursal, NumOrden, Provedor, Cantidad, Producto, Costo, Importe, Status, Usuario)
																				VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$idorden["NumOrden"]."', '".$orden["provedor"]."',
																								'".$orden["cantidad_".$t]."', '".$orden["idproducto_".$t]."', '".$orden["costo_".$t]."', '".$orden["importe_".$t]."', 'Pendiente', '".$_SESSION["usuario"]."')") or die(mysql_error());
		}
		$mensaje='Se genero la orden de compra numero '.$idorden["NumOrden"];
	}
	else
	{
		$mensaje='Ocurrio un problema, intente nuevamente<br />'.mysql_error();
	}
	
	$cadena.='<table border="0" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3">Orden de Compra</td>
						</tr>
						<tr>
							<td bgcolor="#cceaff" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						<tr>
							<td bgcolor="#cceaff" align="center" class="textomensaje"><a href="provedores/ordencompra.php?numorden='.$idorden["NumOrden"].'" target="_blank">Imprimir Orden de Compra</a></td>
						</tr>
						</table>';
	

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function claves($clave, $provedor, $cantidad)
{
	include ("conexion.php");
	
	if($provedor=='todos')
	{
		$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, Costo, CostoDolar FROM productos WHERE Clave LIKE '".$clave."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC");
	}
	else 
	{
		$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, Costo, CostoDolar FROM productos WHERE Clave LIKE '".$clave."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Provedor='".$provedor."' OR Provedor2='".$provedor."' OR Provedor3='".$provedor."' OR Provedor4='".$provedor."' OR Provedor5='".$provedor."' ORDER BY Clave ASC");
	}
	$cadena='<ul style="list-style: none; margin: 0;	padding: 0;	display: block;	text-align: left;">';
	
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		//selecciona moneda
		if($RResClaves["Moneda"]=='MN'){$costo=$RResClaves["Costo"];}
		elseif($RResClaves["Moneda"]=='USD')
		{
			$ResTC=mysql_fetch_array(mysql_query("SELECT * FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1"));
			$costo=$RResClaves["CostoDolar"]*$ResTC["USD"];
		}
		$cadena.='<li><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordencompra.nombre.value=\''.$RResClaves["Nombre"].'\'; document.fordencompra.clave.value=\''.$RResClaves["Clave"].'\'; document.fordencompra.costo.value=\''.number_format($costo, 2).'\'; document.fordencompra.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordencompra.importe.value=\''.number_format(($costo*$cantidad),2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></li>';
	}
	$cadena.='</ul>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function nombres($nombre, $provedor, $cantidad)
{
	include ("conexion.php");
	
	if($provedor=='todos')
	{
		$ResClaves=mysql_query("SELECT Clave, Nombre Costo FROM productos WHERE Nombre LIKE '".$nombre."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC");
	}
	else 
	{
		$ResClaves=mysql_query("SELECT Clave, Nombre Costo FROM productos WHERE Nombre LIKE '".$nombre."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Provedor='".$provedor."' OR Provedor2='".$provedor."' OR Provedor3='".$provedor."' OR Provedor4='".$provedor."' OR Provedor5='".$provedor."' ORDER BY Clave ASC");
	}
	$cadena='<ul style="list-style: none; margin: 0;	padding: 0;	display: block;	text-align: left;">';
	
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		$cadena.='<li><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordencompra.nombre.value=\''.$RResClaves["Nombre"].'\'; document.fordencompra.clave.value=\''.$RResClaves["Clave"].'\'; document.fordencompra.costo.value=\''.number_format($RResClaves["Costo"], 2).'\'; document.fordencompra.importe.value=\''.number_format(($RResClaves["Costo"]*$cantidad),2).'\'; nombres.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></li>';
	}
	$cadena.='</ul>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("nombres","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ver_orden_compra_provedor($orden, $partida=NULL)
{
	include ("conexion.php");
	
	$ResOrden=mysql_query("SELECT * FROM ordenescompraprovedores WHERE Id='".$orden."' LIMIT 1");
	$RResOrden=mysql_fetch_array($ResOrden);
	
	if($partida!=NULL)
	{
		mysql_query("DELETE FROM ordencompraprov WHERE Id='".$partida."'");
		
		if(mysql_num_rows(mysql_query("SELECT * FROM ordencompraprov WHERE NumOrden='".$RResOrden["NumOrden"]."' AND Provedor='".$RResOrden["Provedor"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='pendiente'"))==0)
		{
			mysql_query("UPDATE ordenescompraprovedores SET Status='Recibida' WHERE Id='".$orden."'");
		}
	}
	
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResOrden["Provedor"]."' LIMIT 1"));
	
	$cadena.='<table border="0" bordercolor="#ffffff" align="center" cellpadding="3" cellspacing="0">
							<tr>
								<th colspan="5" align="right" class="texto" bgcolor="#ffffff"><img src="images/print.png" border="0"></th>
							</tr>
							<tr>
								<th colspan="5" align="center" class="texto3" bgcolor="#4db6fc">Detalles de Orden de Compra</th>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#cceaff">Num. Orden: </td>
								<td colspan="3" align="left" class="texto" bgcolor="#cceaff">'.$RResOrden["NumOrden"].'</td>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#cceaff">Provedor: </td>
								<td colspan="3" align="left" class="texto" bgcolor="#cceaff">'.$ResProvedor["Nombre"].'</td>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#cceaff">Fecha de Orden: </td>
								<td colspan="3" align="left" class="texto" bgcolor="#cceaff">'.fecha($RResOrden["FechaOrden"]).'</td>
							</tr>
							<tr>
								<td colspan="2" align="left" class="texto" bgcolor="#cceaff">Status: </td>
								<td colspan="3" align="left" class="texto" bgcolor="#cceaff">'.$RResOrden["Status"].'</td>
							</tr>
							<tr>
								<td align="center" class="texto3" bgcolor="#4eb24e">&nbsp;</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Cantidad</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Clave</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Producto</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">&nbsp;</td>
							</tr>';
	$ResProdOrden=mysql_query("SELECT * FROM ordencompraprov WHERE NumOrden='".$RResOrden["NumOrden"]."' AND Provedor='".$RResOrden["Provedor"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' ORDER BY Id ASC");
	$bgcolor='#7ac37b'; $J=1;
	while($RResProdOrden=mysql_fetch_array($ResProdOrden))
	{
		$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResProdOrden["Producto"]."' LIMIT 1"));
		
		$cadena.='<tr>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$J.'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$RResProdOrden["Cantidad"].'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$ResProd["Clave"].'</td>
								<td align="left" class="texto" bgcolor="'.$bgcolor.'">'.$ResProd["Nombre"].'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_ver_orden_compra_provedor(\''.$orden.'\', \''.$RResProdOrden["Id"].'\')"><img src="images/x.png" border="0"></a></td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		elseif($bgcolor=="#5ac15b"){$bgcolor='#7ac37b';}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function revisiones($form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<form name="fadrevision" id="fadrevision">
						<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="2" align="center" class="texto3" bgcolor="#4db6fc">Ingresar Documento a Revision</td>
							</tr>';
	$cadena.='	<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Provedor: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><select name="provedor" id="provedor" onchange="xajax_revisiones(xajax.getFormValues(\'fadrevision\'))"><option value="">Seleccione</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'"';if($RResProvedores["Id"]==$form["provedor"] AND $accion==NULL){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select></td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Orden de Compra: </td>
								<td align="left" class="texto" bgcolor="#cceaff">';
	$ResOrdenesCompra=mysql_query("SELECT Id, NumOrden FROM ordenescompraprovedores WHERE Provedor='".$form["provedor"]."' AND (Status='Recibida' OR Status='Pendiente') ORDER BY NumOrden ASC");
	$Ordenes=mysql_num_rows($ResOrdenesCompra); $T=1;
	while($RResOrdenesCompra=mysql_fetch_array($ResOrdenesCompra))
	{
		$cadena.='		<input type="checkbox" name="ordenc_'.$T.'" id="ordenc_'.$T.'" value="'.$RResOrdenesCompra["Id"].'"'; if($form["ordenc_".$T]==$RResOrdenesCompra["Id"]){$cadena.=' checked';}$cadena.='>'.$RResOrdenesCompra["NumOrden"].' - ';
		$T++;
	}
	$cadena.='		<input type="hidden" name="numordenes" id="numordenes" value="'.$Ordenes.'">';if($form!=NULL){$cadena.='<input type="button" name="botverordenes" id="botverordenes" value="Ver Ordenes>>" class="boton" onclick="xajax_revisiones(xajax.getFormValues(\'fadrevision\'))">';}$cadena.='</td>
							</tr>';
	//despliega orden de compra
	if($form["numordenes"]!=0)
	{
		$A=1;
		for($i=1; $i<=$form["numordenes"]; $i++)
		{
			if($form["ordenc_".$i]!='')
			{
				$ResNumOrden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenescompraprovedores WHERE Id='".$form["ordenc_".$i]."' LIMIT 1"));
				$cadena.='<tr>
								<th colspan="2" bgcolor="#cceaff" align="center">
									<table border="0" cellpadding="3" cellspacing="0" align="center" width="800">
										<tr>
											<td colspan="8" bgcolor="#4eb24e" class="texto3" align="center">Orden Num. '.$ResNumOrden["NumOrden"].'</td>
										</tr>
										<tr>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="5%">&nbsp;</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%">Cantidad</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%">Clave</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="35%">Producto</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%">Precio</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%">Descuento 1</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%">Descuento 2</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%">Importe</td>
										</tr>';
				$bgcolor="#7ac37b";
				$ResDetOrden=mysql_query("SELECT * FROM ordencompraprov WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$ResNumOrden["NumOrden"]."' AND Status!='Facturado' ORDER BY Id ASC");
				while($RResDetOrden=mysql_fetch_array($ResDetOrden))
				{
					$ResProducto=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResDetOrden["Producto"]."' LIMIT 1"));
					$ResCantRec=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS CantRec FROM det_fact_prov WHERE IdDetOrdenCompra='".$RResDetOrden["Id"]."'"));
					$cadena.='		<tr>
											<td align="center" bgcolor="'.$bgcolor.'" class="texto" width="5%" valign="top">
												<input type="hidden" name="idproducto_'.$A.'" id="idproducto_'.$A.'" value="'.$RResDetOrden["Producto"].'">
												<input type="hidden" name="iddetordencompra_'.$A.'" id="iddetordencompra_'.$A.'" value="'.$RResDetOrden["Id"].'">'.$A.'</td>
											<td align="center" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												<input type="text" name="cantidad_'.$A.'" id="cantidad_'.$A.'" value="'.($RResDetOrden["Cantidad"]-$ResCantRec["CantRec"]).'" size="1" class="input" onKeyUp="descuentos(this.value, costo_'.$A.'.value, desc1_'.$A.'.value, desc2_'.$A.'.value, importe_'.$A.')">
											</td>
											<td align="center" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">'.$ResProducto["Clave"].'</td>
											<td align="left" bgcolor="'.$bgcolor.'" class="texto" width="35%" valign="top">'.$ResProducto["Nombre"].'</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												$<input type="text" name="costo_'.$A.'" id="costo_'.$A.'" value="'.number_format($RResDetOrden["Costo"],2).'" size="5" class="input" onKeyUp="descuentos(cantidad_'.$A.'.value, this.value, desc1_'.$A.'.value, desc2_'.$A.'.value, importe_'.$A.')">
											</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												<input type="text" name="desc1_'.$A.'" id="desc1_'.$A.'" value="0" size="1" class="input" onKeyUp="descuentos(cantidad_'.$A.'.value, costo_'.$A.'.value, this.value, desc2_'.$A.'.value, importe_'.$A.')"> %
											</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												<input type="text" name="desc2_'.$A.'" id="desc2_'.$A.'" value="0" size="1" class="input" onKeyUp="descuentos(cantidad_'.$A.'.value, costo_'.$A.'.value, desc1_'.$A.'.value, this.value, importe_'.$A.')"> %
											</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												$<input type="text" name="importe_'.$A.'" id="importe_'.$A.'" value="'.number_format($RResDetOrden["Importe"],2).'" size="5" class="input">
											</td>
										</tr>';
					if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
					elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
					$A++;
				}		
				$cadena.='		</table><input type="hidden" name="partidas" id="partidas" value="'.($A-1).'">
								</th>
							</tr>';
			}
		}
	}
	$cadena.='	<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Num. Factura: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="text" name="facturap" id="facturap" size="15" class="input"></td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Fecha de Emisión: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><select name="diae" id="diae"><option value="">Dia</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='		</select> <select name="mese" id="mese"><option value="">Mes</option>
									<option value="01">Enero</toption>
									<option value="02">Febrero</toption>
									<option value="03">Marzo</toption>
									<option value="04">Abril</toption>
									<option value="05">Mayo</toption>
									<option value="06">Junio</toption>
									<option value="07">Julio</toption>
									<option value="08">Agosto</toption>
									<option value="09">Septiembre</toption>
									<option value="10">Octubre</toption>
									<option value="11">Noviembre</toption>
									<option value="12">Diciembre</toption>
								</select> <select name="annoe" id="annoe"><option value="">Año</option>';
	for($i=(date("Y")-1); $i<=(date("Y")+1); $i++)
	{
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Fecha de Recepción: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><select name="diar" id="diar"><option value="">Dia</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"'; if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select> <select name="mesr" id="mesr"><option value="">Mes</option>
									<option value="01"';if(date("m")=='01'){$cadena.=' selected';}$cadena.='>Enero</toption>
									<option value="02"';if(date("m")=='02'){$cadena.=' selected';}$cadena.='>Febrero</toption>
									<option value="03"';if(date("m")=='03'){$cadena.=' selected';}$cadena.='>Marzo</toption>
									<option value="04"';if(date("m")=='04'){$cadena.=' selected';}$cadena.='>Abril</toption>
									<option value="05"';if(date("m")=='05'){$cadena.=' selected';}$cadena.='>Mayo</toption>
									<option value="06"';if(date("m")=='06'){$cadena.=' selected';}$cadena.='>Junio</toption>
									<option value="07"';if(date("m")=='07'){$cadena.=' selected';}$cadena.='>Julio</toption>
									<option value="08"';if(date("m")=='08'){$cadena.=' selected';}$cadena.='>Agosto</toption>
									<option value="09"';if(date("m")=='09'){$cadena.=' selected';}$cadena.='>Septiembre</toption>
									<option value="10"';if(date("m")=='10'){$cadena.=' selected';}$cadena.='>Octubre</toption>
									<option value="11"';if(date("m")=='11'){$cadena.=' selected';}$cadena.='>Noviembre</toption>
									<option value="12"';if(date("m")=='12'){$cadena.=' selected';}$cadena.='>Diciembre</toption>
								</select> <select name="annor" id="annor"><option value="">Año</option>';
	for($i=(date("Y")-1); $i<=(date("Y")+1); $i++)
	{
		$cadena.='<option value="'.$i.'"'; if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Descuento 1: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="text" name="descuento_1" id="descuento_1" size="3" class="input" value="0"> %</td>
							</tr>
							<!--<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Descuento 2: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="text" name="descuento_2" id="descuento_2" size="3" class="input"> %</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Descuento 3: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="text" name="descuento_3" id="descuento_3" size="3" class="input"> %</td>
							</tr>-->
							<tr>
								<td colspan="2" align="center" bgcolor="#cceaff" class="texto">
									<input type="button" name="botadrevision" id="botadrevision" value="Verificar Documento>>" class="boton" onclick="xajax_guarda_revision_prev(xajax.getFormValues(\'fadrevision\'))">
								</td>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_revision_prev($form)
{
	include ("conexion.php");
	
	$cadena.='<form name="fadrevision" id="fadrevision">
						<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="2" align="center" class="texto3" bgcolor="#4db6fc">Ingresar Documento a Revision</td>
							</tr>';
	//busca que la factura no haya sido ingresada
	$ResFact=mysql_query("SELECT Id FROM facturasprovedores WHERE Provedor='".$form["provedor"]."' AND FacturaP='".$form["facturap"]."' LIMIT 1");
	if(mysql_num_rows($ResFact)!=0)
	{
		$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$form["provedor"]."' LIMIT 1"));
		$cadena.='	<tr>
								<td align="left" class="textomensaje" bgcolor="#cceaff" colspan="2">La factura Num. '.$form["facturap"].' del Provedor '.$ResProvedor["Nombre"].' ya fue ingresada, verifique datos</td>
								</tr>';
	}
	else 
	{
	$cadena.='	<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Provedor: </td>
								<td align="left" class="texto" bgcolor="#cceaff">';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$form["provedor"]."' LIMIT 1");
	$RResProvedores=mysql_fetch_array($ResProvedores);
	$cadena.='<input type="hidden" name="provedor" id="provedor" value="'.$RResProvedores["Id"].'">'.$RResProvedores["Nombre"];
	$cadena.='		</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Orden de Compra: </td>
								<td align="left" class="texto" bgcolor="#cceaff"> - ';
	
		for($i=1; $i<=$form["numordenes"]; $i++)
	{
		if($form["ordenc_".$i]!='')
		{
			$numord++;
			$ResOrdenesCompra=mysql_query("SELECT Id, NumOrden FROM ordenescompraprovedores WHERE Id='".$form["ordenc_".$i]."' LIMIT 1");
			$RResOrdenesCompra=mysql_fetch_array($ResOrdenesCompra);
			$cadena.='		<input type="hidden" name="ordenc_'.$numord.'" id="ordenc_'.$numord.'" value="'.$RResOrdenesCompra["Id"].'">'.$RResOrdenesCompra["NumOrden"].'-';
			$ids_ordenes.=$RResOrdenesCompra["Id"].'>>';
		}
	}
	$cadena.='		<input type="hidden" name="numordenes" id="numordenes" value="'.$numord.'">
								<input type="hidden" name="ids_ordenes" id="ids_ordenes" value="'.$ids_ordenes.'"></td>
							</tr>';
	$cadena.='<tr>
								<th colspan="2" bgcolor="#cceaff" align="center">
									<table border="0" cellpadding="3" cellspacing="0" align="center" width="800">
										<tr>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="5%" valign="top">&nbsp;</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%" valign="top">Cantidad</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%" valign="top">Clave</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="35%" valign="top">Producto</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%" valign="top">Precio</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%" valign="top">Descuento 1</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%" valign="top">Descuento 2</td>
											<td align="center" bgcolor="#4eb24e" class="texto3" width="10%" valign="top">Importe</td>
										</tr>';
	//despliega orden de compra
	$A=1; $J=1; $bgcolor="#7ac37b";
	for($i=1; $i<=$form["numordenes"]; $i++)
	{
		if($form["ordenc_".$i]!='')
		{
			$ResNumOrden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenescompraprovedores WHERE Id='".$form["ordenc_".$i]."' LIMIT 1"));
			
				
				$ResDetOrden=mysql_query("SELECT * FROM ordencompraprov WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$ResNumOrden["NumOrden"]."' AND Status!='Facturado' ORDER BY Id ASC");
				while($RResDetOrden=mysql_fetch_array($ResDetOrden))
				{
					if($form["cantidad_".$J]!=0)
					{
					$ResProducto=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResDetOrden["Producto"]."' LIMIT 1"));
					$ResCantRec=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS CantRec FROM det_fact_prov WHERE IdDetOrdenCompra='".$RResDetOrden["Id"]."'"));
					$cadena.='<tr>
											<td align="center" bgcolor="'.$bgcolor.'" class="texto" width="5%" valign="top">
												<input type="hidden" name="idproducto_'.$A.'" id="idproducto_'.$A.'" value="'.$RResDetOrden["Producto"].'">
												<input type="hidden" name="iddetordencompra_'.$A.'" id="iddetordencompra_'.$A.'" value="'.$RResDetOrden["Id"].'">'.$A.'</td>
											<td align="center" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												<input type="hidden" name="cantidad_'.$A.'" id="cantidad_'.$A.'" value="'.$form["cantidad_".$J].'" size="3" class="input">'.$form["cantidad_".$J].'
											</td>
											<td align="center" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">'.$ResProducto["Clave"].'</td>
											<td align="left" bgcolor="'.$bgcolor.'" class="texto" width="35%" valign="top">'.$ResProducto["Nombre"].'</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												$ <input type="hidden" name="costo_'.$A.'" id="costo_'.$A.'" value="'.str_replace(',','',$form["costo_".$J]).'" size="10" class="input">'.number_format(str_replace(',','',$form["costo_".$J]),2).'
											</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												<input type="hidden" name="desc1_'.$A.'" id="desc1_'.$A.'" value="'.$form["desc1_".$J].'" size="1" class="input">'.$form["desc1_".$J].' %
											</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												<input type="hidden" name="desc2_'.$A.'" id="desc2_'.$A.'" value="'.$form["desc2_".$J].'" size="1" class="input">'.$form["desc2_".$J].' %
											</td>
											<td align="right" bgcolor="'.$bgcolor.'" class="texto" width="10%" valign="top">
												$ <input type="hidden" name="importe_'.$A.'" id="importe_'.$A.'" value="'.str_replace(',','',$form["importe_".$J]).'" size="10" class="input">'.number_format(str_replace(',','',$form["importe_".$J]),2).'
											</td>
										</tr>';
					$totalfactura=$totalfactura+str_replace(',','',$form["importe_".$J]);
					if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
					elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
					$A++;
					}
				$J++;
			}
				
		
		}
		
		
	}
	$cadena.='		</table><input type="hidden" name="partidas" id="partidas" value="'.($A-1).'">
								</th>
							</tr>';
	$cadena.='	<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Num. Factura: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="hidden" name="facturap" id="facturap" size="15" class="input" value="'.$form["facturap"].'">'.$form["facturap"].'</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Fecha de Emisión: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="hidden" name="diae" id="diae" value="'.$form["diae"].'">'.$form["diae"].' - <input type="hidden" name="mese" id="mese" value="'.$form["mese"].'">';
	switch($form["mese"])
	{
		case '01': $cadena.='Enero';break;
		case '02': $cadena.='Febrero';break;
		case '03': $cadena.='Marzo';break;
		case '04': $cadena.='Abril';break;
		case '05': $cadena.='Mayo';break;
		case '06': $cadena.='Junio';break;
		case '07': $cadena.='Julio';break;
		case '08': $cadena.='Agosto';break;
		case '09': $cadena.='Septiembre';break;
		case '10': $cadena.='Octubre'; break;
		case '11': $cadena.='Noviembre';break;
		case '12': $cadena.='Diciembre';break;
	}
	$cadena.=' - <input type="hidden" name="annoe" id="annoe" value="'.$form["annoe"].'">'.$form["annoe"].'</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Fecha de Recepción: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="hidden" name="diar" id="diar" value="'.$form["diar"].'">'.$form["diar"].' - <input type="hidden" name="mesr" id="mesr" value="'.$form["mesr"].'">';
	switch($form["mesr"])
	{
		case '01': $cadena.='Enero';break;
		case '02': $cadena.='Febrero';break;
		case '03': $cadena.='Marzo';break;
		case '04': $cadena.='Abril';break;
		case '05': $cadena.='Mayo';break;
		case '06': $cadena.='Junio';break;
		case '07': $cadena.='Julio';break;
		case '08': $cadena.='Agosto';break;
		case '09': $cadena.='Septiembre';break;
		case '10': $cadena.='Octubre'; break;
		case '11': $cadena.='Noviembre';break;
		case '12': $cadena.='Diciembre';break;
	}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	$iva=$totalfactura*$ivaa;
	$total=$totalfactura+$iva;
	$totalpagar=$total-(($total*$form["descuento_1"])/100);
	$cadena.=' - <input type="hidden" name="annor" id="annor" value="'.$form["annor"].'">'.$form["annor"].'</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Importe de la Factura: </td>
								<td align="left" class="texto" bgcolor="#cceaff">$ <input type="hidden" name="importefactura" id="importefactura" size="15" class="input" value="'.$totalfactura.'">'.number_format($totalfactura,2).'</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Iva '.($ivaa*100).' %: </td>
								<td align="left" class="texto" bgcolor="#cceaff">$ <input type="hidden" name="iva" id="iva" size="15" class="input" value="'.$iva.'">'.number_format($iva,2).'</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Total : </td>
								<td align="left" class="texto" bgcolor="#cceaff">$ <input type="hidden" name="total" id="total" size="15" class="input" value="'.($iva+$totalfactura).'">'.number_format(($iva+$totalfactura),2).'</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Descuento: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="hidden" name="descuento_1" id="descuento_1" size="3" class="input" value="'.$form["descuento_1"].'">'.$form["descuento_1"].' %</td>
							</tr>
							<!--<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Descuento 2: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="text" name="descuento_2" id="descuento_2" size="3" class="input"> %</td>
							</tr>
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Descuento 3: </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="text" name="descuento_3" id="descuento_3" size="3" class="input"> %</td>
							</tr>-->
							<tr>
								<td align="left" class="texto" bgcolor="#cceaff">Total a Pagar:  </td>
								<td align="left" class="texto" bgcolor="#cceaff"><input type="hidden" name="totalpagar" id="totalpagar" size="3" class="input" value="'.$totalpagar.'">$ '.number_format($totalpagar,2).'</td>
							</tr>
							<tr>
								<td colspan="2" align="center" bgcolor="#cceaff" class="texto">
									<input type="button" name="botadrevision" id="botadrevision" value="Agregar Documento>>" class="boton" onclick="xajax_guarda_revision(xajax.getFormValues(\'fadrevision\'))">
								</td>
							</tr>';
	}
	$cadena.='</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_revision($form)
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="2" align="center" class="texto3" bgcolor="#4db6fc">Ingresar Documento a Revision</td>
							</tr>';
	//agregar el documento
	$fechaemision=$form["annoe"].'-'.$form["mese"].'-'.$form["diae"];
	$fecharecepcion=$form["annor"].'-'.$form["mesr"].'-'.$form["diar"];
	 
	
	$ResDiasCred=mysql_fetch_array(mysql_query("SELECT DiasCredito FROM provedores WHERE Id='".$form["provedor"]."' LIMIT 1"));
	
	$fechapago=dateAdd($fecharecepcion, $ResDiasCred["DiasCredito"]); 
		
	mysql_query("INSERT INTO facturasprovedores (Empresa, Sucursal, Provedor, IdOrdenCompra, FacturaP, FechaEmision, FechaRecepcion, FechaPago, ImporteFactura, Descuento1, TotalFactura, Usuario)
																			 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$form["provedor"]."', '".$form["ids_ordenes"]."', '".$form["facturap"]."', '".$fechaemision."', '".$fecharecepcion."',
																			         '".$fechapago."', '".$form["importefactura"]."', '".$form["descuento_1"]."', '".$form["totalpagar"]."', '".$_SESSION["usuario"]."')") or die(mysql_error());
	//obtenemos id de la factura
	$IdFP=mysql_insert_id();
	//insertamos partidas de la factura
	for($A=1; $A<=$form["partidas"]; $A++)
	{
		if($form["cantidad_".$A]!=0)
		{
			mysql_query("INSERT INTO det_fact_prov (IdFactura, IdProducto, IdDetOrdenCompra, Cantidad, PrecioUnitario, Importe, Usuario)
																			VALUES ('".$IdFP."', '".$form["idproducto_".$A]."', '".$form["iddetordencompra_".$A]."', '".$form["cantidad_".$A]."',
																							'".str_replace(',','',$form["costo_".$A])."', '".str_replace(',','',$form["importe_".$A])."', '".$_SESSION["usuario"]."')") or die(mysql_error());
			//busca la cantidad
			$ResCantPedida=mysql_fetch_array(mysql_query("SELECT Cantidad FROM ordencompraprov WHERE Id='".$form["iddetordencompra_".$A]."' LiMIT 1"));
			//suma la cantidad recibida
			$ResCantRecibida=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Cantireci FROM det_fact_prov WHERE IdDetOrdenCompra='".$form["iddetordencompra_".$A]."'"));
			//actualizamos status del producto recibido
			if($ResCantPedida["Cantidad"]==$ResCantRecibida["Cantireci"])
			{
				mysql_query("UPDATE ordencompraprov SET Status='Facturado' WHERE Id='".$form["iddetordencompra_".$A]."'") or die(mysql_error());
			}
		}
	}
//actualiza status de orden de compra
for($A=1; $A<=$form["numordenes"]; $A++)
{
	$ResNumOrden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenescompraprovedores WHERE Id='".$form["ordenc_".$A]."' LIMIT 1"));
	$ResFacturado=mysql_num_rows(mysql_query("SELECT Id FROM ordencompraprov WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$ResNumOrden["NumOrden"]."' AND Status!='Facturado'"));
	if($ResFacturado==0)
	{
		mysql_query("UPDATE ordenescompraprovedores SET Status='Facturado' WHERE Id='".$form["ordenc_".$A]."'") or die(mysql_error());
	}
}
	
	$cadena.='<tr>
							<td colspan="2" align="center" class="textomensaje" bgcolor="#cceaff">Se guardo el documento para su revisión</td>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function cuentas_pagar($form=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center"
						<tr>
							<th colspan="9" bgcolor="#FFFFFF" align="left" class="texto">
								<form name="fbuscuenta" id="fbuscuenta">
									<select name="provedor" id="provedor"><option value="%">Provedor</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='			<option value="'.$RResProvedores["Id"].'">'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select> <br /><select name="fecha" id="fecha">
										<option value="FechaPago">Fecha de...</option>
										<option value="FechaEmision">Emision</option>
										<option value="FechaRecepcion">Recepcion</option>
										<option value="FechaPago">Limite de Pago</option>
										<option value="FechaPagada">Pagada</option>
									</select> De: <select name="diai" id="diai"><option value="01">Dia</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='			</select><select name="mesi" id="mesi">
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
									</select><select name="annoi" id="annoi"><option value="2011">Año</option>';
	for($i=2010; $i<=date("Y"); $i++)
	{
		$cadena.='			<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='			</select> A: <select name="diaf" id="diaf"><option value="'.date('d').'">Dia</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='			</select><select name="mesf" id="mesf">
										<option value="'.date('m').'">Mes</option>
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
									</select><select name="annof" id="annof"><option value="'.date('Y').'">Año</option>';
	for($i=2010; $i<=date("Y"); $i++)
	{
		$cadena.='			<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='			</select><select name="status" id="status">
										<option value="Pendiente">Status</option>
										<option value="Pendiente">Pendiente</option>
										<option value="Pagada">Pagada</option>
										<option value="Vencida">Vencida</option>
									</select> <input type="button" name="botbusfact" id="botbusfact" value="Buscar>>" class="boton" onclick="xajax_cuentas_pagar(xajax.getFormValues(\'fbuscuenta\'))">
								</form>
							</th>
						</tr>
						<tr>
							<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Provedor</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Num. Factura</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Total Factura</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Orden de Compra</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Fecha de Emision</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Fecha de Recepcion</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Fecha Limite de Pago</td>
							<td align="center" bgcolor="#4eb24e" class="texto3">Status</td>
						</tr>';
	if($form==NULL)
	{
		$ResCuentas=mysql_query("SELECT * FROM facturasprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' ORDER BY FechaPago ASC");
	}
	else
	{
		$fechaini=$form["annoi"]."-".$form["mesi"]."-".$form["diai"];
		$fechafin=$form["annof"]."-".$form["mesf"]."-".$form["diaf"];
		$ResCuentas=mysql_query("SELECT * FROM facturasprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND 
																																	Sucursal='".$_SESSION["sucursal"]."' AND
																																	Provedor LIKE '".$form["provedor"]."' AND
																																	".$form["fecha"].">='".$fechaini."' AND
																																	".$form["fecha"]."<='".$fechafin."' AND 
																																	Status='".$form["status"]."'
																												 ORDER BY FechaPago ASC");
		
	}
	$bgcolor='#7ac37b'; $J=1;
	while($RResCuentas=mysql_fetch_array($ResCuentas))
	{
		$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResCuentas["Provedor"]."' LIMIT 1"));
		$ResNumOrden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenescompraprovedores WHERE Id='".$RResCuentas["IdOrdenCompra"]."' LIMIT 1"));
		if($RResCuentas["FechaPago"]>=date("Y-m-d")){$clase='texto';}
		elseif($RResCuentas["FechaPago"]<date("Y-m-d")){$clase='textored';}
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="'.$clase.'">'.$ResProvedor["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'"><a href="provedores/factprovedor.php?idfactura='.$RResCuentas["Id"].'" target="_blank">'.$RResCuentas["FacturaP"].'</a></td>
								<td bgcolor="'.$bgcolor.'" align="right" class="'.$clase.'">$ '.number_format($RResCuentas["TotalFactura"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'">';if($RResCuentas["IdOrdenCompra"]==0){$cadena.='Compra Directa';}else{$cadena.='<a href="provedores/ordencompra.php?numorden='.$ResNumOrden["NumOrden"].'" target="_blank">'.$ResNumOrden["NumOrden"].'</a>';}$cadena.='</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'">'.fecha($RResCuentas["FechaEmision"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'">'.fecha($RResCuentas["FechaRecepcion"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'">'.fecha($RResCuentas["FechaPago"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="'.$clase.'">'.$RResCuentas["Status"].'</td>
							</tr>';
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
		$J++;
	}
	$cadena.='</table>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function dateAdd($fecha, $dias)
   {
      $mes = $fecha[5].$fecha[6];
      $anio = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
      $dia = $fecha[8].$fecha[9];
      $ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
      $dias_adelanto = $dias;
      $siguiente = $dia + $dias_adelanto;
      if ($ultimo_dia < $siguiente)
      {
         $dia_final = $siguiente - $ultimo_dia;
         $mes++;
         if ($mes == '13')
         {
            $anio++;
            $mes = '01';
         }
         $fecha_final = $anio.'-'.$mes.'-'.$dia_final;         
      }
      else
      {
         $fecha_final = $anio.'-'.$mes.'-'.$siguiente;         
      }
      return $fecha_final;
   }
function aplica_pagos($form=NULL, $borrapago=NULL)
{
	include ("conexion.php");
	
	$fecha=$form["anno"].'-'.$form["mes"].'-'.$form["dia"];
	
	$cadena='<form name="faplicapagos" id="faplicapagos">
					 <table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#FFFFFF" align="center" class="textomensaje">';
	if($form!=NULL AND $form["banco"]==''){$cadena.='No Selecciono cuenta Bancaria <br />';$boton='no';}
	if($form!=NULL AND $form["movimiento"]!='Efectivo' AND $form["nummov"]==''){$cadena.='No Ingreso Numero de Movimiento <br />';$boton='no';}
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#4db6fc" align="center" class="texto3">Aplicar Pagos</th>
						</tr>
						<tr>
							<td align="left" bgcolor="#cceaff" class="texto">Provedor :</td>
							<td colspan="3" align="left" bgcolor="#cceaff" class="texto"><select name="provedor" id="provedor"><option value="">Seleccione</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'"';if($RResProvedores["Id"]==$form["provedor"] AND $accion==NULL){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select>
							</td>
							</tr>
							<tr>
								<td bgcolor="#cceaff" class="texto" align="left">Cuenta Bancaria :</td>
								<td colspan="3" bgcolor="#cceaff" class="texto" align="left"><select name="banco" id="banco"><option value="">Seleccione</option>';
		$ResBancos=mysql_query("SELECT * FROM bancos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Banco ASC, NumCuenta ASC");
		while($RResBancos=mysql_fetch_array($ResBancos))
		{
			$cadena.='	<option value="'.$RResBancos["Id"].'"';if($RResBancos["Id"]==$form["banco"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Banco"].' - '.$RResBancos["NumCuenta"].'</option>';
		}
		$cadena.='	</select></td>
							</tr>
							<tr>
								<td bgcolor="#cceaff" class="texto" align="left">Movimiento :</td>
								<td bgcolor="#cceaff" class="texto" align="left"><select name="movimiento" id="movimiento">
									<option value="Transferencia"';if($form["movimiento"]=='Transferencia'){$cadena.=' selected';}$cadena.='>Transferencia Bancaria</option>
									<option value="Cheque"';if($form["movimiento"]=='Cheque'){$cadena.=' selected';}$cadena.='>Cheque</option>
									<option value="Efectivo"';if($form["movimiento"]=='Efectivo'){$cadena.=' selected';}$cadena.='>Pago en Efectivo</option>
									</select>
								</td>
								<td bgcolor="#cceaff" class="texto" align="left">Numero :</td>
								<td bgcolor="#cceaff" class="texto" align="left"><input type="text" name="nummov" id="nummov" class="input" value="'.$form["nummov"].'"></td>
							</tr>
							<tr>
								<td bgcolor="#cceaff" class="texto" align="left">Fecha: </td>
								<td colspan="3" bgcolor="#cceaff" class="texto" align="left"><select name="dia" id="dia">';
		for($i=1; $i<=31; $i++)
		{
			if($i<=9){$i='0'.$i;}
			$cadena.='<option value="'.$i.'"'; if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
		}
		$cadena.='		</select> <select name="mes=" id="mes">
										<option value="01"';if(date("m")=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
										<option value="02"';if(date("m")=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
										<option value="03"';if(date("m")=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
										<option value="04"';if(date("m")=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
										<option value="05"';if(date("m")=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
										<option value="06"';if(date("m")=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
										<option value="07"';if(date("m")=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
										<option value="08"';if(date("m")=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
										<option value="09"';if(date("m")=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
										<option value="10"';if(date("m")=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
										<option value="11"';if(date("m")=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
										<option value="12"';if(date("m")=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
									</select> <select name="anno" id="anno">';
		for($i=2011; $i<=date("Y"); $i++)
		{
			$cadena.='		<option value="'.$i.'"';if($i==$form["anno"]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
		}
		$cadena.='		</select></td>
							<tr>
								<td bgcolor="#cceaff" class="texto" align="left">Documento: </td>
								<td bgcolor="#cceaff" class="texto" align="left">
									<input type="hidden" name="idfacturap" id="idfacturap" value="">
									<input type="text" name="documento" id="documento" value="" class="input" onKeyUp="documentos.style.visibility=\'visible\'; xajax_documentos_provedores(document.getElementById(\'provedor\').value, this.value)">
									<div id="documentos" style="position: absolute; width: 100px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
								</td>
								<td bgcolor="#cceaff" class="texto" align="left">Abono : </td>
								<td bgcolor="#cceaff" class="texto" align="left">$ <input type="text" name="abono" id="abono" class="input"></td>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#cceaff" class="texto" algin="center">
									<input type="button" name="botadmov" id="botadmov" value="Agregar>>" class="boton" onclick="xajax_aplica_pagos(xajax.getFormValues(\'faplicapagos\'))">
								</td>
							</tr>';
	if($form==NULL)
	{
		$partidas=1;
	}
	if($form!=NULL)
	{
		$cadena.='<tr>
								<td colspan="4" bgcolor="#cceaff" class="texto" align="center">
									<table border="0" bordercolor="#cceaff" cellpadding="3" cellspacing="0">
										<tr>
											<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
											<td align="center" bgcolor="#4eb24e" class="texto3">Num. Factura</td>
											<td align="center" bgcolor="#4eb24e" class="texto3">Importe</td>
											<td align="center" bgcolor="#4eb24e" class="texto3">Pago</td>
											<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
										</tr>';
		$bgcolor="#7ac37b"; $array=array();
		if($borrapago==NULL)
		{
		//agrega partidas existentes
			for($J=1;$J<$form["partidas"];$J++)
			{
				$arreglo=array($J, $form["idfacturap_".$J], $form["abono_".$J]);
				array_push($array, $arreglo);
			}
			//agrega nueva partida
			if($form["idfacturap"] AND $form["abono"])
			{
				$arreglo=array($J, $form["idfacturap"], $form["abono"]);
				array_push($array, $arreglo);
				$partidas=count($array)+1;
			}
			
		}
		elseif($borrapago!=NULL)
		{
			//agrega productos a la orden
			$J=1; $i=1;
			while($i<$form["partidas"])
			{
				if($borrapago!=$i)
				{
					$arreglo=array($J, $form["idfacturap_".$i], $form["abono_".$i]);
					array_push($array, $arreglo);
					$J++;
				}
				$i++;
			}
			$partidas=count($array)+1;
		}
		//despliega los pagos
		$bgcolor='#7ac37b';
		for($i=0; $i<count($array); $i++)
		{
			$ResNumFact=mysql_fetch_array(mysql_query("SELECT FacturaP, TotalFactura FROM facturasprovedores WHERE Id='".$array[$i][1]."' LIMIT 1"));
			$cadena.='<tr>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$array[$i][0].'</td>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idfacturap_'.$array[$i][0].'" id="idfacturap_'.$array[$i][0].'" value="'.$array[$i][1].'">'.$ResNumFact["FacturaP"].'</td>
									<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($ResNumFact["TotalFactura"], 2).'</td>
									<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="abono_'.$array[$i][0].'" id="abono_'.$array[$i][0].'" value="'.$array[$i][2].'">$ '.number_format($array[$i][2],2).'</td>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto">
										<a href="#" onclick="xajax_aplica_pagos(xajax.getFormValues(\'faplicapagos\'), \''.$array[$i][0].'\')"><img src="images/x.png" border="0"></a>
									</td>
								</tr>';
			$totalpagado=$totalpagado+$array[$i][2];
			if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
			elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
		}
		
		$cadena.=' 	<tr>
									<td colspan="3" bgcolor="'.$bgcolor.'" align="left" class="texto">Total :</td>
									<td bgcolor="'.$bgcolor.'" align="left" class="texto">$ '.number_format($totalpagado, 2).'</td>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto">&nbsp;</td>
								</tr>
								</table>
								</td>
							</tr>';
	}
	$cadena.='	<tr>
								<td colspan="4" bgcolor="#cceaff" class="texto" align="center">';
	if(!$boton AND $form!=NULL)
	{
		$cadena.='<input type="button" name="botadmovimientos" id="botadmovimientos" value="Guardar Pagos>>" class="boton" onclick="xajax_guarda_aplica_pagos(xajax.getFormValues(\'faplicapagos\'))">';				
	}
	$cadena.='		</td>
							</tr>
						</table>
						<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_aplica_pagos($form)
{
	include ("conexion.php");
	
	$fecha=$form["anno"].'-'.$form["mes"].'-'.$form["dia"];
	
	for($i=1; $i<$form["partidas"];$i++)
	{
		//ingresa movimiento
		mysql_query("INSERT INTO pagos_provedores (Empresa, Sucursal, Fecha, Banco, TipoMovimiento, NumMovimiento, IdFacturaP, Provedor, Abono, Usuario)
																			 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$fecha."', '".$form["banco"]."',
																			 				 '".$form["movimiento"]."', '".$form["nummov"]."', '".$form["idfacturap_".$i]."', '".$form["provedor"]."', '".$form["abono_".$i]."', '".$_SESSION["usuario"]."')") or die(mysql_query());
	 //revisa si el documento fue liquidado
	 $ResPagos=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS Pagado FROM pagos_provedores WHERE IdFacturaP='".$form["idfacturap_".$i]."'"));
	 $ResTotalFact=mysql_fetch_array(mysql_query("SELECT TotalFactura FROM facturasprovedores WHERE Id='".$form["idfacturap_".$i]."' LIMIT 1"));
	 if($ResPagos["Pagado"]>=$ResTotalFact["TotalFactura"])
	 {
	 	mysql_query("UPDATE facturasprovedores SET Status='Pagada' WHERE Id='".$form["idfacturap_".$i]."'")or die(mysql_error());
	 }
	}
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#4db6fc" align="center" class="texto3">Aplicar Pagos</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#cceaff" align="center" class="textomensaje">Se han registrado los pagos</th>
						</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function documentos_provedores($provedor, $documento)
{
	include ("conexion.php");
	
	$cadena='<table border="0" cellpadding="1" cellspacing="0">';
	$ResDocs=mysql_query("SELECT Id, FacturaP, TotalFactura FROM facturasprovedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Provedor LIKE '".$provedor."' AND FacturaP LIKE '".$documento."%'  AND Status='Pendiente' ORDER BY Id ASC");
	while($RResDocs=mysql_fetch_array($ResDocs))
	{ 
		//calcula el restante
		$ResPagos=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS Pagado FROM pagos_provedores WHERE IdFacturaP='".$RResDocs["Id"]."'"));
	 	$ResTotalFact=mysql_fetch_array(mysql_query("SELECT TotalFactura FROM facturasprovedores WHERE Id='".$RResDocs["Id"]."' LIMIT 1"));
	 
		$cadena.='<tr>
							 <td style="display: block;outline: none;margin: 0;text-decoration: none;color: #3c833d;" align="left"><a href="#" onclick="document.faplicapagos.idfacturap.value=\''.$RResDocs["Id"].'\';document.faplicapagos.documento.value=\''.$RResDocs["FacturaP"].'\'; document.faplicapagos.abono.value=\''.($ResTotalFact["TotalFactura"]-$ResPagos["Pagado"]).'\';documentos.style.visibility=\'hidden\';">'.$RResDocs["FacturaP"].'</a></td>
							</tr>';
	}
	$cadena.='</table>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("documentos","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function reporte_pagos($form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0">
							<tr>
								<td colspan="7" aling="left" class="texto" bgcolor="#FFFFFF">
									<form name="freppagos" id="freppagos">
										Provedor: <select name="provedor" id="provedor"><option value="%">Seleccione</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'"';if($RResProvedores["Id"]==$form["provedor"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='				</select><p>
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
	$cadena.='				</select> <input type="button" name="botbuspagos" id="botbuspagos" value="Mostrar>>" class="boton" onclick="xajax_reporte_pagos(xajax.getFormValues(\'freppagos\'))">
									</form>
								</td>
							</tr>';
	if($form!=NULL)
	{
		$fechai=$form["annoi"].'-'.$form["mesi"].'-'.$form["diai"];
		$fechaf=$form["annof"].'-'.$form["mesf"].'-'.$form["diaf"];
		
		$cadena.='<tr>
								<th colspan="8" bgcolor="#4db6fc" align="center" class="texto3">Reporte de Pagos</th>
							</tr>
							<tr>
								<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Fecha</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Banco</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Movimiento</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Num. Movimiento</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Factura </td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Importe Factura</td>
								<td align="center" bgcolor="#43b24e" class="texto3">Abono</td>
							</tr>';
		$ResPagos=mysql_query("SELECT * FROM pagos_provedores WHERE Provedor LIKE '".$form["provedor"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' ORDER BY Fecha DESC");
		$bgcolor="#7ac37b"; $A=1;
		while($RResPagos=mysql_fetch_array($ResPagos))
		{
			$ResBanco=mysql_fetch_array(mysql_query("SELECT Banco, NumCuenta FROM bancos WHERE Id='".$RResPagos["Banco"]."' LIMIT 1"));
			$ResFactura=mysql_fetch_array(mysql_query("SELECT FacturaP, TotalFactura FROM facturasprovedores WHERE Id='".$RResPagos["IdFacturaP"]."' LIMIT 1"));
			$cadena.='<tr>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$A.'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.fecha($RResPagos["Fecha"]).'</td>
									<td algin="center" bgcolor="'.$bgcolor.'" class="texto">'.$ResBanco["Banco"].'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResPagos["TipoMovimiento"].'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResPagos["NumMovimiento"].'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$ResFactura["FacturaP"].'</td>
									<td align="rigth" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($ResFactura["TotalFactura"],2).'</td>
									<td align="rigth" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResPagos["Abono"], 2).'</td>
								</tr>';
			if($bgcolor=="#7ac37b"){$bgcolor="#5ac15b";}
			elseif($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
			$A++;
		}
	}
	$cadena.='</table>';
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function compras()
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#4db6fc" align="center" class="texto3">Reporte de Compras</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#cceaff" align="center" class="texto">
								<form name="frepcompras" id="frepcompras" method="POST" action="provedores/reportecompras.php" target="_blank">
								 Provedor: <select name="provedor" id="provedor"><option value="%">Todos</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'">'.$RResProvedores["Nombre"].'</td>';
	}
	$cadena.='		</select><br />
							<br />Periodo: De: <select name="diai" id="diai"><option value="01">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesi" id="mesi"><option value="01">Mes</option>
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
								</select><select name="annoi" id="annoi"><option value="2011">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	} 
	$cadena.='		</select> A <select name="diaf" id="diaf"><option value="'.date("d").'">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesf" id="mesf"><option value="'.date("m").'">Mes</option>
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
								</select><select name="annof" id="annof"><option value="'.date("Y").'">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	} 
	$cadena.='				</select> <input type="submit" name="botbuspagos" id="botbuspagos" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									</table>';
	
//concentrado de ventas por cliente
	$cadena.='<p>&nbsp;</p>
						<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#4db6fc" align="center" class="texto3">Reporte Concentrado de Compras</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#cceaff" align="center" class="texto">
								<form name="frepcompras" id="frepcompras" method="POST" action="provedores/reporteconcentradocompras.php" target="_blank">
								 Periodo: De: <select name="diai" id="diai"><option value="01">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesi" id="mesi"><option value="01">Mes</option>
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
								</select><select name="annoi" id="annoi"><option value="2011">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	} 
	$cadena.='		</select> A <select name="diaf" id="diaf"><option value="'.date("d").'">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesf" id="mesf"><option value="'.date("m").'">Mes</option>
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
								</select><select name="annof" id="annof"><option value="'.date("Y").'">Año</option>';
	for($T=2011; $T<=date("Y"); $T++)
	{
		$cadena.='		<option value="'.$T.'">'.$T.'</option>';
	} 
	$cadena.='				</select> <input type="submit" name="botbuspagos" id="botbuspagos" value="Mostrar>>" class="boton">
									</form>
									</th>
									</tr>
									</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>