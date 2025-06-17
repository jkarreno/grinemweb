<?php
function clientes($limite=0, $modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$ResEmpresa=mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1");
	$RResEmpresa=mysql_fetch_array($ResEmpresa);
	
	$cadena='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="10" bgcolor="#FFFFFF" class="texto" align="right">| <a href="#" onclick="xajax_clientes(\''.$limite.'\', \'agregar\', \'1\')">Agregar Cliente</a> |</th>
						</tr>
					 	<tr>
							<th colspan="10" bgcolor="#287d29" class="texto3" align="center">Clientes Empresa '.$RResEmpresa["Nombre"].'</th>
						</tr>';
//area de trabajo
  switch ($modo)
  {
  	case 'agregar': //AGREGAR CLIENTE
  		$cadena.='<tr>
							<th colspan="10" bgcolor="#7abc7a" class="texto" align="center">';
  		if($accion==1)//formulario para agregar cliente
  		{
  			$cadena.='<form name="fadcliente" id="fadcliente">
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
										<td align="left" class="texto">Deleg. / Municipio: </td>
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
										<td align="left" class="texto">$ <input type="text" name="lcredito" id="lcredito" size="10" class="input"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Num. Provedor: </td>
										<td align="left" class="texto"><input type="text" name="numprovedor" id="numprovedor" size="5" class="input"></td>
										<td align="left" class="texto">&nbsp;</td>
										<td align="left" class="texto">&nbsp;</td>
									</tr>
									<tr>
										<td align="left" class="texto">Forma de Pago: </td>
										<td align="left" class="texto"><select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO">NO IDENTIFICADO</option>
											<option value="EFECTIVO">EFECTIVO</option>
											<option value="TARJETA DE CREDITO">TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO">TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA">TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE">CHEQUE</option>
										</select></td>
										<td align="left" class="texto">Num. Cuenta: </td>
										<td align="left" class="texto"><input type="text" name="numcuenta" id="numcuenta" size="5" class="input"></td>
									</tr>
									<tr>
										<th colspan="4" align="center" class="texto"><input type="button" name="botadcliente" id="botadcliente" value="Agregar Cliente>>" class="boton" onclick="valida_agregar_cliente();"></th>
									</tr>
								</table>
								</form>';
  		}
  		else if($accion==2)//agregando al cliente
  		{
  			if(mysql_query("INSERT INTO clientes (Empresa, Sucursal, NumProvedor, Nombre, Direccion, Colonia, Ciudad, CP, Estado, RFC, Telefono, Telefono2, Fax, CorreoE, DiasCredito, Credito, Fpago, Ncuenta)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$form["numprovedor"]."', '".utf8_decode($form["nombre"])."', '".utf8_decode($form["direccion"])."',
  																							'".utf8_decode($form["colonia"])."', '".utf8_decode($form["ciudad"])."', '".$form["cp"]."', 
  																							'".utf8_decode($form["estado"])."', '".utf8_decode($form["rfc"])."', '".$form["telefono"]."',
  																							'".$form["telefono2"]."', '".$form["fax"]."', '".$form["correoe"]."', '".$form["dcredito"]."', '".str_replace(',','',$form["lcredito"])."', '".$form["fpago"]."', '".$form["numcuenta"]."')"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se agrego el cliente satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un error, por favor intente nueamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
  		break;
  	case 'editar': //EDITAR Cliente
  		$cadena.='<tr>
									<th colspan="9" bgcolor="#7abc7a" class="texto" align="center">';
  		if($accion==1)//formulario para editar cliente
  		{
  			$ResCliente=mysql_query("SELECT * FROM clientes WHERE Id='".$form."' LIMIT 1");
  			$RResCliente=mysql_fetch_array($ResCliente);
  			
  			$cadena.='<form name="feditcliente" id="feditcliente">
								<table border="0" cellpadding="5" cellspacing="0" align="center">
									<tr>
										<td align="left" class="texto">Nombre: </td>
										<th colspan="3" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResCliente["Nombre"].'"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Direcci&oacute;n: </th>
										<th colspan="3" align="left"><input type="text" name="direccion" id="direccion" class="input" size="50" value="'.$RResCliente["Direccion"].'"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Colonia: </td>
										<td align="left" class="texto"><input type="text" name="colonia" id="colonia" class="input" value="'.$RResCliente["Colonia"].'"></td>
										<td align="left" class="texto">Deleg. / Municipio: </td>
										<td align="left" class="texto"><input type="text" name="ciudad" id="ciudad" class="input" value="'.$RResCliente["Ciudad"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Codigo Postal: </td>
										<td align="left" class="texto"><input type="text" name="cp" id="cp" class="input" value="'.$RResCliente["CP"].'"></td>
										<td align="left" class="texto">Estado: </td>
										<td align="left" class="texto"><input type="text" name="estado" id="estado" class="input" value="'.$RResCliente["Estado"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">R.F.C.: </td>
										<th colspan="3" align="left" class="texto"><input type="text" name="rfc" id="rfc" size="50" class="input" value="'.$RResCliente["RFC"].'"></th>
									</tr>
									<tr>
										<td align="left" class="texto">Telefono: </td>
										<td align="left" class="texto"><input type="text" name="telefono" id="telefono" class="input" value="'.$RResCliente["Telefono"].'"></td>
										<td align="left" class="texto">Telefono 2: </td>
										<td align="left" class="texto"><input type="text" name="telefono2" id="telefono2" class="input" value="'.$RResCliente["Telefono2"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Fax: </td>
										<td align="left" class="texto"><input type="text" name="fax" id="fax" class="input" value="'.$RResCliente["Fax"].'"></td>
										<td align="left" class="texto">Email: </td>
										<td align="left" class="texto"><input type="text" name="correoe" id="correoe" class="input" value="'.$RResCliente["CorreoE"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Credito: </td>
										<td align="left" class="texto"><input type="text" name="dcredito" id="dcredito" size="5" class="input" value="'.$RResCliente["DiasCredito"].'"> dias</td>
										<td align="left" class="texto">Limite de Credito: </td>
										<td align="left" class="texto">$ <input type="text" name="lcredito" id="lcredito" size="10" class="input" value="'.number_format($RResCliente["Credito"], 2).'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Num. Provedor: </td>
										<td align="left" class="texto"><input type="text" name="numprovedor" id="numprovedor" size="5" class="input" value="'.$RResCliente["NumProvedor"].'"></td>
										<td align="left" class="texto">&nbsp;</td>
										<td align="left" class="texto">&nbsp;</td>
									</tr>
									<tr>
										<td align="left" class="texto">Forma de Pago: </td>
										<td align="left" class="texto"><select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO"';if($RResCliente["Fpago"]=="NO IDENTIFICADO"){$cadena.=' selected';}$cadena.='>NO IDENTIFICADO</option>
											<option value="EFECTIVO"';if($RResCliente["Fpago"]=="EFECTIVO"){$cadena.=' selected';}$cadena.='>EFECTIVO</option>
											<option value="TARJETA DE CREDITO"';if($RResCliente["Fpago"]=="TARJETA DE CREDITO"){$cadena.=' selected';}$cadena.='>TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO"';if($RResCliente["Fpago"]=="TARJETA DE DEBITO"){$cadena.=' selected';}$cadena.='>TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA"';if($RResCliente["Fpago"]=="TRANSFERENCIA ELECTRONICA"){$cadena.=' selected';}$cadena.='>TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE"';if($RResCliente["Fpago"]=="CHEQUE"){$cadena.=' selected';}$cadena.='>CHEQUE</option>
										</select></td>
										<td align="left" class="texto">Num. Cuenta: </td>
										<td align="left" class="texto"><input type="text" name="numcuenta" id="numcuenta" size="5" class="input" value="'.$RResCliente["Ncuenta"].'"></td>
									</tr>
									<tr>
										<th colspan="4" align="center" class="texto">
											<input type="hidden" name="idcliente" id="idcliente" value="'.$form.'">
											<input type="button" name="boteditclienter" id="boteditcliente" value="Editar Cliente>>" class="boton" onclick="xajax_clientes(\''.$limite.'\', \'editar\', \'2\', xajax.getFormValues(\'feditcliente\'))">
										</th>
									</tr>
								</table>
								</form>';
  		}
  		if($accion==2)//Editando el cliente
  		{
  			if(mysql_query("UPDATE clientes SET Nombre='".utf8_decode($form["nombre"])."',
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
  																						Credito='".str_replace(',','',$form["lcredito"])."',
  																						NumProvedor='".$form["numprovedor"]."',
  																						Fpago='".$form["fpago"]."',
  																						Ncuenta='".$form["numcuenta"]."'
  																			WHERE Id='".$form["idcliente"]."'"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se actualizo el cliente satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadea.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
  		break;
  	case 'eliminar': //ELIMINAR CLIENTE
  		$cadena.='<tr>
									<th colspan="9" bgcolor="#7abc7a" class="texto" align="center">';
  		if($accion==1)
  		{
  			$ResProvedor=mysql_query("SELECT Id, Nombre FROM clientes WHERE Id='".$form."' LIMIT 1");
  			$RResProvedor=mysql_fetch_array($ResProvedor);
  			
  			$cadena.='Esta seguro de eliminar al cliente '.$RResProvedor["Nombre"].'<br />
  								<a href="#" onclick="xajax_clientes(\''.$limite.'\', \'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_clientes()">No</a>';
  		}
  		elseif($accion==2)
  		{
  			if(mysql_query("DELETE FROM clientes WHERE Id='".$form."' LIMIT 1"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se elimino el Cliente satisfactoriamente</p>';
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
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Nombre</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Direcci&oacute;n</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Colonia</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Ciudad</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Estado</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">R.F.C.</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Telefono</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResClientes=mysql_query("SELECT * FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC LIMIT ".$limite.", 25");
	$regs=mysql_num_rows(mysql_query("SELECT Id FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'"));
	$bgcolor="#7ac37b"; $J=$limite+1;
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="middle">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["Direccion"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["Colonia"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["Ciudad"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["Estado"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["RFC"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" valign="top">'.$RResClientes["Telefono"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="middle">
									<a href="#" onclick="xajax_clientes(\''.$limite.'\', \'editar\', \'1\', \''.$RResClientes["Id"].'\')"><img src="images/edit.png" border="0" alt="Editar"></a> 
									<a href="#" onclick="xajax_clientes(\''.$limite.'\', \'eliminar\', \'1\', \''.$RResClientes["Id"].'\')"><img src="images/x.png" border="0" alt="Eliminar"></a>
								</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" valign="middle"><a href="#" onclick="xajax_unidades_cliente(\''.$RResClientes["Id"].'\')">Unidades</a></td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		else if($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
	}
	$cadena.='	<tr>
								<th colspan="9" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_clientes(\''.$J.'\')">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function lista_ordenes_venta($limite=0, $buscaorden=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="6" bgcolor="#ffffff" align="left" class="texto">
								<form name="fbusorden" id="fbusorden" method="POST" action="clientes/ordenexcel.php">
								Cliente: <select name="cliente" id="cliente"><option value="todos">Todos</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($buscaorden["cliente"]==$RResClientes["Id"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}								
	$cadena.='</select><br /><br />
						Numero de Orden: <input type="text" name="numorden" id="numorden" class="input" size="15"><br /><br />
								De: <select name="diai" id="diai">
									<option value="01">Dia</option>';
	for($J=1;$J<=31;$J++)
	{
		if($J<=9){$J='0'.$J;}
		$cadena.='		<option value="'.$J.'"';if($buscaorden["diai"]==$J){$cadena.=' selected';}$cadena.='>'.$J.'</option>';
	}
	$cadena.='		</select> <select name="mesi" id="mesi">
									<option value="01">Mes</option>
									<option value="01"';if($buscaorden["mesi"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
									<option value="02"';if($buscaorden["mesi"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
									<option value="03"';if($buscaorden["mesi"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
									<option value="04"';if($buscaorden["mesi"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
									<option value="05"';if($buscaorden["mesi"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
									<option value="06"';if($buscaorden["mesi"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
									<option value="07"';if($buscaorden["mesi"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
									<option value="08"';if($buscaorden["mesi"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
									<option value="09"';if($buscaorden["mesi"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
									<option value="10"';if($buscaorden["mesi"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
									<option value="11"';if($buscaorden["mesi"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
									<option value="12"';if($buscaorden["mesi"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
								</select> <select name="annoi" id="annoi">
									<option value="2011">Año</option>';
	for($T=2011;$T<=date("Y");$T++)
	{
		$cadena.='		<option value="'.$T.'"';if($buscaorden["annoi"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select> A: <select name="diaf" id="diaf">
									<option value="'.date("d").'">Dia</option>';
	for($J=1;$J<=31;$J++)
	{
		if($J<=9){$J='0'.$J;}
		$cadena.='		<option value="'.$J.'"';if($buscaorden["diaf"]==$J){$cadena.=' selected';}$cadena.='>'.$J.'</option>';
	}
	$cadena.='		</select> <select name="mesf" id="mesf">
									<option value="'.date("m").'">Mes</option>
									<option value="01"';if($buscaorden["mesf"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
									<option value="02"';if($buscaorden["mesf"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
									<option value="03"';if($buscaorden["mesf"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
									<option value="04"';if($buscaorden["mesf"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
									<option value="05"';if($buscaorden["mesf"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
									<option value="06"';if($buscaorden["mesf"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
									<option value="07"';if($buscaorden["mesf"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
									<option value="08"';if($buscaorden["mesf"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
									<option value="09"';if($buscaorden["mesf"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
									<option value="10"';if($buscaorden["mesf"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
									<option value="11"';if($buscaorden["mesf"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
									<option value="12"';if($buscaorden["mesf"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
								</select> <select name="annof" id="annof">
									<option value="'.date("Y").'">Año</option>';
	for($T=2011;$T<=date("Y");$T++)
	{
		$cadena.='		<option value="'.$T.'"';if($buscaorden["annof"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><br /><br />
								Status: <select name="status" id="status">
									<option value="Pendiente"';if($buscaorden["status"]=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente</option>
									<option value="Cancelada"';if($buscaorden["status"]=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
									<option value="Facturado"';if($buscaorden["status"]=='Facturado'){$cadena.=' selected';}$cadena.='>Facturada</option>
								</select> <input type="button" name="botbustatus" id="botbustatus" value="buscar>>" class="boton" onclick="xajax_lista_ordenes_venta(\'0\', xajax.getFormValues(\'fbusorden\'))">
								 <input type="submit" name=botexportarexcel" id="botexportexcel" value="Exportar a Excell>>" class="boton">
								</form>
							</th>
							<th colspan="2" bgcolor="#ffffff" align="right" class="texto" valign="bottom">| <a href="#" onclick="xajax_orden_venta()">Nueva Orden de Venta</a> |</th>
						</tr>
						<tr>
							<th colspan="8" bgcolor="#287d29" align="center" class="texto3">Ordenes de Venta</th>
						</tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Num. Orden</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Fecha</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Cliente</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Status</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Facturas</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Modificado Por</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	if($buscaorden==NULL)
	{
		$buscaorden["status"]='Pendiente';
		$fechai='2011-01-01';	
		$fechaf=date("Y-m-d");
		$cliente='%';
		$numorden='%';
	}
	else 
	{
		$fechai=$buscaorden["annoi"].'-'.$buscaroden["mesi"].'-'.$buscaorden["diai"];
		$fechaf=$buscaorden["annof"].'-'.$buscaorden["mesf"].'-'.$buscaorden["diaf"];
		if($buscaorden["cliente"]=='todos'){$cliente='%';}else{$cliente=$buscaorden["cliente"];}
		if($buscaorden["numorden"]==''){$numorden='%';}else{$numorden=$buscaorden["numorden"];}
	}
	$ResOrdenesVenta=mysql_query("SELECT * FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='".$buscaorden["status"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' AND NumOrden LIKE '".$numorden."' ORDER BY NumOrden DESC LIMIT ".$limite.", 25");
	$regs=mysql_num_rows(mysql_query("SELECT Id FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='".$buscaorden["status"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' AND NumOrden LIKE '".$numorden."'"));
	$J=1; $bgcolor="#7ac37b";
	while($RResOrdenesVenta=mysql_fetch_array($ResOrdenesVenta))
	{
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenesVenta["Cliente"]."' LIMIT 1"));
		$ResUsuario=mysql_fetch_array(mysql_query("SELECT Nombre FROM usuarios WHERE Id='".$RResOrdenesVenta["Usuario"]."' LIMIT 1"));
		$ary = explode('>>',$RResOrdenesVenta["Facturas"]);
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResOrdenesVenta["NumOrden"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResOrdenesVenta["Fecha"][8].$RResOrdenesVenta["Fecha"][9].'-'.$RResOrdenesVenta["Fecha"][5].$RResOrdenesVenta["Fecha"][6].'-'.$RResOrdenesVenta["Fecha"][0].$RResOrdenesVenta["Fecha"][1].$RResOrdenesVenta["Fecha"][2].$RResOrdenesVenta["Fecha"][3].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResCliente["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResOrdenesVenta["Status"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">';
		for($i=0;$i<count($ary);$i++)
		{
			$ResFactura=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura FROM facturas WHERE Id='".$ary[$i]."' LIMIT 1"));
			$cadena.=$ResFactura["Serie"].$ResFactura["NumFactura"].'<br />';
		}
		$cadena.='  </td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResUsuario["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="clientes/ordenventa.php?idorden='.$RResOrdenesVenta["Id"].'" target="_blank"><img src="images/print.png" border="0"></a>';
		if($RResOrdenesVenta["Status"]=='Pendiente'){$cadena.=' <a href="#" onclick="xajax_edit_status_orden(\''.$RResOrdenesVenta["Id"].'\')"><img src="images/edit.png" border="0"></a>';}
		if($RResOrdenesVenta["Status"]=='Pendiente' OR $RResOrdenesVenta["Status"]=='Facturado'){$cadena.=' <a href="#" onclick="xajax_cancela_orden_venta(\''.$RResOrdenesVenta["Id"].'\')"><img src="images/x.png" border="0"></a>';}
		$cadena.='	</td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor="#5ac15b";}
		elseif($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
	}
	$cadena.='	<tr>
								<th colspan="8" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_lista_ordenes_venta(\''.$J.'\', xajax.getFormValues(\'fbusorden\'))">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function orden_venta($orden=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenventa" id="fordenventa">
					 <table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="7" bgcolor="#287d29" align="center" class="texto3">Orden de Venta</th>
						</tr>';
	if($orden==NULL)
	{
		$fecha=date("Y-m-d", mktime(0,0,0,date("m"),date("d")-30,date("Y")));
		$cadena.='<tr>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cotización: </td>
							<td colspan="5" align="left" bgcolor="#7abc7a" class="texto"><select name="cotizacion" id="cotizacion" onchange="xajax_orden_cotizacion(this.value)">
								<option>Seleccione</option>';
		$ResCot=mysql_query("SELECT * FROM cotizaciones WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' AND Fecha<='".date("Y-m-d")."' AND Fecha>='".$fecha."' ORDER BY NumCotizacion ASC");
		while($RResCot=mysql_fetch_array($ResCot))
		{
			$cliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResCot["Cliente"]."' LIMIT 1"));
			$cadena.='<option value="'.$RResCot["Id"].'">'.$RResCot["NumCotizacion"].' - '.$cliente["Nombre"].'</option>';
		}
		$cadena.='	</select></td></tr>';
	}
	$cadena.='<tr>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cliente: </td>
							<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><select name="cliente" id="cliente" onchange="xajax_unidades_cliente_orden(this.value)"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"'; if($RResClientes["Id"]==$orden["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
							<td rowspan="2" valign="middle" align="left" bgcolor="#7abc7a" class="texto">Almacen: </td>
							<td rowspan="2" valign="middle" align="left" bgcolor="#7abc7a" class="texto"><select name="almacen" id="almacen"><option value="">Seleccione</option>';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$orden["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
						 </tr>
						 <tr>
						 <td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Unidad: </td>
						 <td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><div id="uniclie"><select name="unidadclie" id="unidadclie"><option>Seleccione</option>';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$orden["cliente"]."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'"';if($RResUnidadesCliente["Id"]==$orden["unidadclie"]){$cadena.=' selected';}$cadena.='>'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select></div></td>
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
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_orden_venta(xajax.getFormValues(\'fordenventa\'))"></td>
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
			//revisa el credito del cliente
			//$creditofa=mysql_fetch_array(mysql_query("SELECT SUM(total) AS creditof FROM facturas WHERE Cliente='".$orden["cliente"]."' AND Status='Pendiente'"));
			//$creditocli=mysql_fetch_array(mysql_query("SELECT Credito FROM clientes WHERE Id='".$orden["cliente"]."' LIMIT 1"));
						
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0)
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#7abc7a" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$orden["partidas"];
			}
			//Revisa existencia en inventario
			else if($ResCantidad[$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"]]>=$orden["cantidad"])
			{
				for($J=1; $J<$orden["partidas"];$J++)
				{
//					if($orden["idproducto_".$J]==$orden["idproducto"])
//					{
//						$ftotal=str_replace(',','',$orden["total_".$J])+str_replace(',','',$orden["total"]);
//						$arreglo=array($J, $orden["idproducto_".$J], ($orden["cantidad_".$J]+$orden["cantidad"]), $orden["clave_".$J], $orden["precio_".$J], $ftotal);
//						array_push($array, $arreglo);
//						$agregado=1; $partidas=$orden["partidas"];
//					}
//					else
//					{
						$ftotal=str_replace(',','',$orden["total_".$J]);
						$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["precio_".$J], $ftotal);
						array_push($array, $arreglo);
	//				}
				}
				if(!$agregado)
				{
					$ftotal=str_replace(',','',$orden["total"]);
					$arreglo=array($J, $orden["idproducto"], $orden["cantidad"], $orden["clave"], $orden["precio"], $ftotal);
					array_push($array, $arreglo);
					$partidas=count($array)+1;
				}
			}
			//no hay existencia
			else
			{
				for($J=1; $J<$orden["partidas"];$J++)
				{
					$ftotal=str_replace(',','',$orden["total_".$J]);
					$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["precio_".$J], $ftotal);
					array_push($array, $arreglo);
				}
				$cadena.='<tr>
									<th colspan="7" bgcolor="#7abc7a" class="textomensaje">No puede vender un producto sin existencia</th>
								</tr>';
				$partidas=$orden["partidas"];
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
							 		<a href="#" onclick="xajax_orden_venta(xajax.getFormValues(\'fordenventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
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
						 		<input type="button" name="botfinordenventa" id="botonfinordenventa" value="Guardar Orden de Venta>>" class="boton" onclick="this.disabled = true;xajax_guarda_orden_venta(xajax.getFormValues(\'fordenventa\'))">
						 	</th>
						 </tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_orden_venta($orden)
{
	include ("conexion.php");
	
	$almacen=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"];
	//numero de orden
	$numorden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumOrden DESC LIMIT 1"));
	
	$numo=$numorden["NumOrden"]+1;
	if(mysql_query("INSERT INTO ordenventa (NumOrden, Empresa, Sucursal, Cliente, UnidadCliente, Fecha, Status, Observaciones, NumPedido, Agente, Usuario)
																  VALUES ('".$numo."', '".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."',
																  				'".$orden["cliente"]."', '".$orden["unidadclie"]."', '".date("Y-m-d")."', 'Pendiente', '".$orden["observaciones"]."', '".$orden["pedido"]."', '".$orden["agente"]."', '".$_SESSION["usuario"]."')"))
	{
		$idorden=mysql_fetch_array(mysql_query("SELECT Id, NumOrden FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumOrden='".$numo."' LIMIT 1"));
		for($i=1; $i<$orden["partidas"]; $i++)
		{
			mysql_query("INSERT INTO detordenventa (IdOrden, Producto, Clave, Cantidad, PrecioUnitario, SubTotal, Status, Usuario)
																			VALUES ('".$idorden["Id"]."', '".$orden["idproducto_".$i]."', '".$orden["clave_".$i]."',
																							'".$orden["cantidad_".$i]."', '".$orden["precio_".$i]."', '".$orden["total_".$i]."', 'Pendiente', '".$_SESSION["usuario"]."')");
			//descuenta producto del inventario
			mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."-".$orden["cantidad_".$i]." WHERE IdProducto='".$orden["idproducto_".$i]."'");
			//regisra el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenVenta, Fecha, Descripcion, Usuario)
																			vALUES ('".$almacen."', '".$orden["idproducto_".$i]."', 'Salida', '".$orden["cantidad_".$i]."',
																							'".$idorden["Id"]."', '".date("Y-m-d")."', 'Salida de Mercancia por Orden de Venta', '".$_SESSION["usuario"]."')") or die ($cadena.=mysql_error());
		}
		$mensaje='Se genero la orden de venta numero '.$idorden["NumOrden"];
	}
	else
	{
		$mensaje='Ocurrio un problema, intente nuevamente<br />'.mysql_error();
	}
	
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
function cancela_orden_venta($orden, $cancela='no')
{
	include ("conexion.php");
	
	if($cancela=='no')
	{
		$ResNumOrdenVenta=mysql_fetch_array(mysql_query("SELECT NumOrden, Cliente FROM ordenventa WHERE Id='".$orden."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNumOrdenVenta["Cliente"]."' LIMIT 1"));
		
		$mensaje='Esta seguro de cancelar la orden de venta Num.: '.$ResNumOrdenVenta["NumOrden"].' del Cliente: '.$ResCliente["Nombre"].'? <br />
							<a href="#" onclick="xajax_cancela_orden_venta(\''.$orden.'\', \'si\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_lista_ordenes_venta()">No</a>';
	}
	elseif($cancela=='si')
	{
		//cancelamos la orden
		mysql_query("UPDATE ordenventa SET Status='Cancelada', Usuario='".$_SESSION["usuario"]."' WHERE Id='".$orden."'");
		//cancelamos los productos
		mysql_query("UPDATE detordenventa SET Status='Cancelada' WHERE idorden='".$orden."'");
		//devolvemos los productos al inventario
		$ResProductos=mysql_query("SELECT Almacen, Cantidad, Producto FROM movinventario WHERE IdOrdenVenta='".$orden."' ORDER BY Id ASC");
		while($RResProductos=mysql_fetch_array($ResProductos))
		{
			mysql_query("UPDATE inventario SET ".$RResProductos["Almacen"]."=".$RResProductos["Almacen"]."+".$RResProductos["Cantidad"]." WHERE IdProducto='".$RResProductos["Producto"]."'");
			//registramos el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenVenta, Fecha, Descripcion, Usuario)
																			VALUES ('".$RResProductos["Almacen"]."', '".$RResProductos["Producto"]."', 'Entrada', '".$RResProductos["Cantidad"]."',
																							'".$orden."', '".date("Y-m-d")."', 'Ingreso a almacen por cancelacion de orden de venta', '".$_SESSION["usuario"]."')");
		}
		$ResNumOrdenVenta=mysql_fetch_array(mysql_query("SELECT NumOrden, Cliente FROM ordenventa WHERE Id='".$orden."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNumOrdenVenta["Cliente"]."' LIMIT 1"));
		
		$mensaje='<p class="textomensaje">Se cancelo la Orden de Venta Num: '.$ResNumOrdenVenta["NumOrden"].' del Cliente: '.$ResCliente["Nombre"].' satisfactoriamente';
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#287d29" align="center" class="texto3">Ordenes de Venta</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</th>
						</tr>
					 </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function facturacion_cliente($factura=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenventa" id="fordenventa">
					<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
							<tr>
								<th colspan="7" align="center" bgcolor="#287d29" class="texto3">Facturación Orden de Venta</th>
							</tr>';
	if($factura==NULL)
	{
		$cadena.='<tr>
								<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Orden de Venta: </td>
								<td colspan="5" align="left" bgcolor="#7abc7a" class="texto">
									<select name="ordenventa" id="ordenventa" onchange="xajax_factura_orden(this.value)"><option value="">Seleccione</option>';
		$ResOrdenesVenta=mysql_query("SELECT Id, NumOrden, Cliente FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' OR Status='Surtido' ORDER BY NumOrden ASC");
		while($RResOrdenesVenta=mysql_fetch_array($ResOrdenesVenta))
		{
			$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenesVenta["Cliente"]."' LIMIT 1"));
			$cadena.='<option value="'.$RResOrdenesVenta["Id"].'">'.$RResOrdenesVenta["NumOrden"].' - '.$ResCliente["Nombre"].'</option>';
		}
		$ResSuc=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' AND Empresa='".$_SESSION["empresa"]."'"));
		if($ResSuc["Nombre"]=='MATRIZ')
		{
			$ResSucursal=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
			$cadena.='			<option> </option><option>------------Sucursal '.$ResSucursal["Nombre"].'-------------</option>';
			$ResOrdenesVenta2=mysql_query("SELECT Id, NumOrden, Cliente FROM ordenventa WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$ResSucursal["Id"]."' AND Status='Pendiente' OR Status='Surtido' ORDER BY NumOrden ASC");
			while($RResOrdenesVenta2=mysql_fetch_array($ResOrdenesVenta2))
			{
				$ResCliente2=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenesVenta2["Cliente"]."' LIMIT 1"));
				$cadena.='<option value="'.$RResOrdenesVenta2["Id"].'">'.$RResOrdenesVenta2["NumOrden"].' - '.$ResCliente2["Nombre"].'</option>';
			}
		}
		$cadena.='		</select></td>
							</tr>
							<tr>
								<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cotización: </td>
								<td colspan="5" align="left" bgcolor="#7abc7a" class="texto">
									<select name="cotizacion" id="cotizacion" onchange="xajax_factura_cotizacion(this.value)"><option value="">Seleccione</option>';
		$ResCotizaciones=mysql_query("SELECT Id, NumCotizacion, Cliente FROM cotizaciones WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status='Pendiente' AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= Fecha");
		while($RResCotizaciones=mysql_fetch_array($ResCotizaciones))
		{
			$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResCotizaciones["Cliente"]."' LIMIT 1"));
			$cadena.='		<option value="'.$RResCotizaciones["Id"].'">'.$RResCotizaciones["NumCotizacion"].' - '.$ResCliente["Nombre"].'</option>';
		}
		$cadena.='		</select></td>
							</tr>';
	}
	$cadena.='	<tr>
								<th colspan="7" align="center" bgcolor="#287d29" class="texto3">Facturación Directa</th>
							</tr>
							<tr>
								<td colspan="2" aling="left" bgcolor="#7abc7a" class="texto">Cliente:</td>
								<td colspan="3" align="left" bgcolor="#7abc7a" class="texto">
									<select name="cliente" id="cliente" onchange="xajax_unidades_cliente_orden(this.value); xajax_forma_pago_cliente(this.value);"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='	<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$factura["cliente"]){$cadena.=' selected';}
		$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							<td valign="middle" align="left" bgcolor="#7abc7a" class="texto">Almacen: </td>
							<td valign="middle" align="left" bgcolor="#7abc7a" class="texto"><select name="almacen" id="almacen"><option value="">Seleccione</option>';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$factura["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
								<td colspan="2" aling="left" bgcolor="#7abc7a" class="texto">Unidad:</td>
								<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><div id="uniclie"><select name="unidadclie" id="unidadclie"><option>Seleccione</option>';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$factura["cliente"]."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'"';if($RResUnidadesCliente["Id"]==$factura["unidadclie"]){$cadena.=' selected';}$cadena.='>'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select></div></td>
								<td align="left" bgcolor="#7abc7a" class="texto">Descuento: </td>
								<td align="left" bgcolor="#7abc7a" class="texto"><input type="text" name="descuento" id="descuento" class="input" size="5" value="'.$factura["descuento"].'"> % </td>
							<tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#7abc7a class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$factura["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#7abc7a" class="texto" valign="top">Pedido Num.:</td>
						 	<td algin="left" bgcolor="#7abc7a" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="'.$factura["pedido"].'"></td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valign="top">Agente: </td>
						 	<td colspan="2" align="left" bgcolor=#7abc7a class="texto" valign="top"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<option value="'.$RResAgentes["Id"].'"'; if($RResAgentes["Id"]==$factura["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgentes["Nombre"].'</option>';
	}
	$cadena.='		</select>
						 	</td>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valing="top">Precio: 
						 		<select name="pp" id="pp">
						 			<option value="PrecioPublico"';if($factura["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
									<option value="PrecioPublico2"';if($factura["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
									<option value="PrecioPublico3"';if($factura["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
								</select>
						 	</td>
						 	<td align="left" bgcolor="#7abc7a" class="texto" valign="top"><div id="moneda">Moneda: <select name="moneda" id="moneda" onchange="xajax_moneda(this.value)">
						 		<option value="M.N."'; if($factura["moneda"]=='M.N.'){$cadena.=' selected';}$cadena.='>M.N.</option>
						 		<option value="USD"'; if($factura["moneda"]=='USD'){$cadena.=' selected';}$cadena.='>USD</option>
						 	</select>';
	if($factura["moneda"]=='USD')
	{
		$cadena.=' $ <input type="text" name="tipocambio" id="tipocambio" class="input" size="5" value="'.$factura["tipocambio"].'">';
	}
	elseif($factura["moneda"]=='M.N.')
	{
		$cadena.=' $ <input type="hidden" name="tipocambio" id="tipocambio" class="input" size="5" value="0.00">';
	}
	$cadena.='</div></td>
						 </tr>
						 <tr>
						 	<td colspan="7" align="left" bgcolor="#7abc7a" class="texto" valig="top">
						 		<div id="pagocliente">
						 		Forma de Pago: <select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO"';if($factura["fpago"]=='NO IDENTIFICADO'){$cadena.=' selected';}$cadena.='>NO IDENTIFICADO</option>
											<option value="EFECTIVO"';if($factura["fpago"]=='EFECTIVO'){$cadena.=' selected';}$cadena.='>EFECTIVO</option>
											<option value="TARJETA DE CREDITO"';if($factura["fpago"]=='TARJETA DE CREDITO'){$cadena.=' selected';}$cadena.='>TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO"';if($factura["fpago"]=='TARJETA DE DEBITO'){$cadena.=' selected';}$cadena.='>TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA"';if($factura["fpago"]=='TRANSFERENCIA ELECTRONICA'){$cadena.=' selected';}$cadena.='>TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE"';if($factura["fpago"]=='CHEQUE'){$cadena.=' selected';}$cadena.='>CHEQUE</option>
										</select>&nbsp;&nbsp;Num. Cuenta: <input type="text" name="numcuenta" id="numcuenta" size="5" class="input" value="'.$factura["numcuenta"].'">
						 		</div></td>
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
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_facturacion_cliente(xajax.getFormValues(\'fordenventa\'))"></td>
						 </tr>';
	$bgcolor="#7ac37b"; $i=1; $j=1; $array=array();
	if($factura==NULL)
	{
		$partidas=1;
	}
	elseif($factura!=NULL)
	{
		if($borraprod==NULL)
		{
			//agrega partidas existentes
//			for($J=1; $J<$factura["partidas"];$J++)
//			{
//				$ftotal=str_replace(',','',$factura["total_".$J]);
//				$arreglo=array($J, $factura["idproducto_".$J], $factura["cantidad_".$J], $factura["clave_".$J], $factura["precio_".$J], $ftotal);
//				array_push($array, $arreglo);
//			}
			//Revisa que exista la clave
			$ResCantidad=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$factura["almacen"]." FROM inventario WHERE IdProducto='".$factura["idproducto"]."' LIMIT 1"));
			//revisa el credito del cliente
			//$creditofa=mysql_fetch_array(mysql_query("SELECT SUM(total) AS creditof FROM facturas WHERE Cliente='".$orden["cliente"]."' AND Status='Pendiente'"));
			//$creditocli=mysql_fetch_array(mysql_query("SELECT Credito FROM clientes WHERE Id='".$orden["cliente"]."' LIMIT 1"));
			
			
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0 OR $factura["precio"]==0 OR $factura["precio"]=='0.00')
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#7abc7a" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$factura["partidas"];
			}
			//Revisa existencia en inventario
			else if(inventario_stock($factura["idproducto"],$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$factura["almacen"])>=$factura["cantidad"])
			{
				for($J=1; $J<$factura["partidas"];$J++)
				{
//					if($factura["idproducto_".$J]==$factura["idproducto"])
//					{
//						$ftotal=str_replace(',','',$factura["total_".$J])+str_replace(',','',$factura["total"]);
//						$arreglo=array($J, $factura["idproducto_".$J], ($factura["cantidad_".$J]+$factura["cantidad"]), $factura["clave_".$J], $factura["precio_".$J], $ftotal);
//						array_push($array, $arreglo);
//						$agregado=1;
//					}
//					else
//					{
						$ftotal=str_replace(',','',$factura["total_".$J]);
						$arreglo=array($J, $factura["idproducto_".$J], $factura["cantidad_".$J], $factura["clave_".$J], $factura["precio_".$J], $ftotal);
						array_push($array, $arreglo);
					//}
				}
				if(!$agregado)
				{
					$ftotal=str_replace(',','',$factura["total"]);
					$arreglo=array($J, $factura["idproducto"], $factura["cantidad"], $factura["clave"], $factura["precio"], $ftotal);
					array_push($array, $arreglo);
				}
				$partidas=count($array)+1;
			}
			//no hay existencia
			else
			{
				for($J=1; $J<$factura["partidas"];$J++)
				{
					$ftotal=str_replace(',','',$factura["total_".$J]);
					$arreglo=array($J, $factura["idproducto_".$J], $factura["cantidad_".$J], $factura["clave_".$J], $factura["precio_".$J], $ftotal);
					array_push($array, $arreglo);
				}
				$cadena.='<tr>
									<th colspan="7" bgcolor="#7abc7a" class="textomensaje">No puede vender un producto sin existencia</th>
								</tr>';
				$partidas=$factura["partidas"];
			}
			
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$factura["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$factura["total_".$i]);
					$arreglo=array($j, $factura["idproducto_".$i], $factura["cantidad_".$i], $factura["clave_".$i], $factura["precio_".$i], $ftotal);
					array_push($array, $arreglo);
					$j++;
				}
				$i++;
			}
			$partidas=$factura["partidas"]-1;
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
							 		<a href="#" onclick="xajax_facturacion_cliente(xajax.getFormValues(\'fordenventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
			elseif($bgcolor="#5ac15b"){$bgcolor='#7ac37b';}
			
			$subtotal=$subtotal+$array[$T][5];
		}
		
	}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	if($factura["descuento"]!='')
	{
		$descuento=$subtotal*($factura["descuento"]/100);
		$subtotal2=$subtotal-$descuento;
		$iva=$subtotal2*$ivaa;
		$total=$subtotal2+$iva;
	}
	else 
	{
		$iva=($subtotal*$ivaa);
		$total=$subtotal+$iva;
	}
	
	$cadena.=' <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'"><input type="hidden" name="subtotal" id="subtotal" value="'.$subtotal.'">$ '.number_format($subtotal, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	if($factura["descuento"]!='')
	{
		$cadena.='<tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Descuento '.$factura["descuento"].' %: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($descuento, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($subtotal2, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	}
	$cadena.=' <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Iva '.($ivaa*100).' %: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'"><input type="hidden" name="iva" id="iva" value="'.$iva.'">$ '.number_format($iva, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'"><input type="hidden" name="totaltotal" id="totaltotal" value="'.$total.'">$ '.number_format(($total), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	$cadena.='<tr>
							<th colspan="7" align="center" bgcolor="#7abc7a" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
								<input type="button" name="botfinfact" id="botfinfact" value="Guardar Factura>>" class="boton" onclick="this.disabled = true;xajax_finaliza_factura_directa(xajax.getFormValues(\'fordenventa\'), document.getElementById(\'reloj\').value)">
							</th>
						</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function finaliza_factura_directa($factura, $hora)
{
	include ("conexion.php");
	
	$almacen=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$factura["almacen"];
	//numero de factura
	$numfactura=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	
	if($numfactura["Factura"]>$numfactura["FolioF"])
	{
		$mensaje='No existen Folios disponibles para facturar';
	}
	else 
	{
		//incrementa el numero de Factura
		mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$numfactura["Id"]."'");
		//guarda Factura
		for($i=1; $i<$factura["partidas"];$i++)
		{
			$subtotal=$subtotal+$factura["total_".$i];
		}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
		$iva=$subtotal*$ivaa;
		$total=$subtotal+$iva;
		$fechahora=date("Y-m-d").' '.$hora;
		//ingreso datos generales de factura
		mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, UnidadCliente, NumPedido, NumOrden, Fecha, Subtotal, Descuento, Iva, Total, Moneda, TipoCambio, Status, Observaciones, Fpago, Ncuenta, Agente, Version, Usuario)
															 VALUES ('".$numfactura["Serie"]."', '".$numfactura["Factura"]."', '".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."',
																 			 '".$factura["cliente"]."', '".$factura["unidadclie"]."', '".$factura["pedido"]."', '0', '".$fechahora."', '".$factura["subtotal"]."',  '".$factura["descuento"]."',
																			 '".$factura["iva"]."', '".$factura["totaltotal"]."', '".$factura["moneda"]."', '".$factura["tipocambio"]."', 'Pendiente', '".$factura["observaciones"]."', '".$factura["fpago"]."', '".$factura["numcuenta"]."', '".$factura["agente"]."', '".$numfactura["Version"]."', '".$_SESSION["usuario"]."')") or die($cadena.=mysql_error());
		
		$idfactura=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE NumFactura='".$numfactura["Factura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
		
		for($i=1; $i<$factura["partidas"]; $i++)
		{
			//registra los productos de la factura
			mysql_query("INSERT INTO detfacturas (IdFactura, Producto, Clave, Cantidad, PrecioUnitario, Subtotal, Usuario)
			 															VALUES ('".$idfactura["Id"]."', '".$factura["idproducto_".$i]."', '".$factura["clave_".$i]."',
			 																			'".$factura["cantidad_".$i]."', '".$factura["precio_".$i]."', '".$factura["total_".$i]."', '".$_SESSION["usuario"]."')");
			//descuenta producto del inventario
			mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."-".$factura["cantidad_".$i]." WHERE IdProducto='".$factura["idproducto_".$i]."'");
			//regisra el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenVenta, IdFactura, Fecha, Descripcion, Usuario)
																			VALUES ('".$almacen."', '".$factura["idproducto_".$i]."', 'Salida', '".$factura["cantidad_".$i]."',
																							'0', '".$idfactura["Id"]."', '".date("Y-m-d")."', 'Salida de Mercancia por Factura Directa al cliente', '".$_SESSION["usuario"]."')");
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
		$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' AND Nombre LIKE 'MATRIZ%' ORDER BY Id DESC LIMIT 1"));
		
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
		$cadenaoriginal.=$ResMatriz["Calle"].'|';
		//numero exterior del emisor
		if($ResMatriz["NoExterior"]!=''){$cadenaoriginal.=$ResMatriz["NoExterior"].'|';}
		//numero interior del emisor
		if($ResMatriz["NoInterior"]!=''){$cadenaoriginal.=$ResMatriz["NoInterior"].'|';}
		//colonia del emisor
		if($ResMatriz["Colonia"]!=''){$cadenaoriginal.=$ResMatriz["Colonia"].'|';}
		//localidad del emisor
		if($ResMatriz["Localidad"]!=''){$cadenaoriginal.=$ResMatriz["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResMatriz["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResMatriz["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResMatriz["Pais"].'|';
		//codigo porstal del emisor
		$cadenaoriginal.=$ResMatriz["CodPostal"].'|';
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
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
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
	
	//RFC del emisor
	$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'" >';
	//domicilio del emisor
	$xml.=' <DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.=' <ExpedidoEn calle="'.$ResMatriz["Calle"].'"';if($ResMatriz["NoExterior"]!=''){$xml.=' noExterior="'.$ResMatriz["NoExterior"].'"';}if($ResMatriz["NoInterior"]!=''){$xml.=' noInterior="'.$ResMatriz["NoInterior"].'"';}$xml.=' colonia="'.$ResMatriz["Colonia"].'"';if($ResMatriz["Localidad"]!=''){$xml.=' localidad="'.$ResMatriz["Localidad"].'"';}$xml.=' municipio="'.$ResMatriz["Municipio"].'" estado="'.$ResMatriz["Estado"].'" pais="'.$ResMatriz["Pais"].'" codigoPostal="'.$ResMatriz["CodPostal"].'"/>';
	//regimen fiscal
	$xml.='<RegimenFiscal Regimen="'.$ResEmpresa["Regimen"].'" />
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
		
			
		$mensaje='Se genero la Factura  numero '.$numfactura["Factura"].' '.$fechahora;
			
	}
	
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Factura</td>
						</tr>
						<tr>
							<td colspan="3" bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						<tr>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
									<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/factura.php?idfactura='.$idfactura["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/factura2_2.php?idfactura='.$idfactura["Id"].'&empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"];}$cadena.='" target="_blank">Imprimir Factura</a>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
								<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/xml.php?idfactura='.$idfactura["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/xml2_2.php?idfactura='.$idfactura["Id"];}$cadena.='" target="_blank">Descargar XML</a>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botenviarfactura" id="botneviarfactura" value="Enviar Factura por Correo>>" class="boton">
								</td>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function factura_orden($ordenventa, $borra=NULL)
{
	include ("conexion.php");
	
	if(!is_array($ordenventa)){$ResOrdenVenta=mysql_query("SELECT * FROM ordenventa WHERE Id='".$ordenventa."' LIMIT 1");}
	else{$ResOrdenVenta=mysql_query("SELECT * FROM ordenventa WHERE Id='".$ordenventa["idorden"]."' LIMIT 1");}
	$RResOrdenVenta=mysql_fetch_array($ResOrdenVenta);
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre, Fpago, Ncuenta FROM clientes WHERE Id='".$RResOrdenVenta["Cliente"]."' LIMIT 1"));
	$ResUnidadCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResOrdenVenta["UnidadCliente"]."' LIMIT 1"));
	
	$cadena='<form name="fordenfact" id="fordenfact">
						<input type="hidden" name="idorden" id="idorden" value="'.$RResOrdenVenta["Id"].'">
						<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
							<tr>
								<th colspan="7" align="center" bgcolor="#287d29" class="texto3">Facturación</th>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#7abc7a" align="left" class="texto">Num. Orden: '.$RResOrdenVenta["NumOrden"].'</td>
								<td colspan="5" bgcolor="#7abc7a" align="left" class="texto">Cliente: '.$ResCliente["Nombre"].'<br />Unidad: '.$ResUnidadCliente["Nombre"].'</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#7abc7a" align="left" class="texto" valign="top">Observaciones: </td>
								<td colspan="5" bgcolor="#7abc7a" align="left" class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$RResOrdenVenta["Observaciones"].'</textarea></td>
							</tr>
							<tr>
								<td colspan="7" bgcolor="#7abc7a" align="left" class="texto" valign="top"><div id="moneda">Moneda: <select name="moneda" id="moneda" onchange="xajax_moneda(this.value)">
						 		<option value="M.N."'; if($ordenventa["moneda"]=='M.N.'){$cadena.=' selected';}$cadena.='>M.N.</option>
						 		<option value="USD"'; if($ordenventa["moneda"]=='USD'){$cadena.=' selected';}$cadena.='>USD</option>
						 	</select>';
	if($ordenventa["moneda"]=='USD')
	{
		$cadena.=' $ <input type="text" name="tipocambio" id="tipocambio" class="input" size="5" value="'.$factura["tipocambio"].'">';
	}
	elseif($ordenventa["moneda"]=='M.N.')
	{
		$cadena.=' $ <input type="hidden" name="tipocambio" id="tipocambio" class="input" size="5" value="0.00">';
	}
	$cadena.='</div></td>
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
		$ResDetOrdenVenta=mysql_query("SELECT * FROM detordenventa WHERE idorden='".$ordenventa."' AND Status='Pendiente' OR Status='Surtido' ORDER BY Id ASC");
		$J=1; $array=array();
		while($RResDetOrdenVenta=mysql_fetch_array($ResDetOrdenVenta))
		{
			$arreglo=array($J, $RResDetOrdenVenta["Id"], $RResDetOrdenVenta["idorden"], $RResDetOrdenVenta["Producto"], $RResDetOrdenVenta["Clave"], $RResDetOrdenVenta["Cantidad"], $RResDetOrdenVenta["PrecioUnitario"], $RResDetOrdenVenta["Subtotal"], $RResDetOrdenVenta["Id"]);
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
				$arreglo=array($J, $ordenventa["idelemento_".$T], $ordenventa["idorden"], $ordenventa["producto_".$T], $ordenventa["clave_".$T], $ordenventa["cantidad_".$T], $ordenventa["preciouni_".$T], $ordenventa["total_".$T], $ordenventa["iddetorden_".$T]);
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
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><a href="#" onclick="xajax_factura_orden(xajax.getFormValues(\'fordenfact\'), \''.$array[$T][0].'\')"><img src="images/x.png" border="0"></a></td>
							</tr>';
	$J++;
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	$cadena.='	<tr>
								<th colspan="7" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botfinfact" id="botfinfact" value="Finalizar Factura >>" class="boton" onclick="xajax_finaliza_factura_orden(xajax.getFormValues(\'fordenfact\'), document.getElementById(\'reloj\').value)">
								</th>
							</tr>
						</table>
						<input type="hidden" name="elementos" id="elementos" value="'.count($array).'">
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function finaliza_factura_orden($orden, $hora)
{
	include ("conexion.php");
	
	//calcula subtotal, iva y total de la factura
	for($A=1; $A<=$orden["elementos"]; $A++)
	{
		$subtotal=$subtotal+$orden["total_".$A];
	}
if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	$iva=$subtotal*$ivaa;
	$total=$subtotal+$iva;
	
	$ResOrdenVenta=mysql_query("SELECT * FROM ordenventa WHERE Id='".$orden["idorden"]."' LIMIT 1");
	$RResOrdenVenta=mysql_fetch_array($ResOrdenVenta);
	
	$ResFFactura=mysql_query("SELECT * FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1");
	$RResFFactura=mysql_fetch_array($ResFFactura);
	
	if($RResFactura["Factura"]>$RResFactura["FolioF"]) //avisa si no existen folios disponibles
	{
		$cadena='<p align="center" class="textomensaje">Lo sentimos no tiene mas folios para emitir facturas, por favor consulte al administrador</p>';
	}
	else //guarda la factura si existen folios disponibles
	{
		//ingreso datos generales de factura
		mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, UnidadCliente, NumPedido, NumOrden, Fecha, Subtotal, Iva, Total, Moneda, TipoCambio, Status, Observaciones, Fpago, Ncuenta, Agente, Version, Usuario)
															 VALUES ('".$RResFFactura["Serie"]."', '".$RResFFactura["Factura"]."', '".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."',
																 			 '".$RResOrdenVenta["Cliente"]."', '".$RResOrdenVenta["UnidadCliente"]."', '".$RResOrdenVenta["NumPedido"]."', '".$RResOrdenVenta["NumOrden"]."', '".date("Y-m-d")." ".$hora."', '".$subtotal."', 
																			 '".$iva."', '".$total."', '".$orden["moneda"]."', '".$orden["tipocambio"]."', 'Pendiente', '".utf8_decode($orden["observaciones"])."', '".$orden["fpago"]."', '".$orden["numcuenta"]."', '".$RResOrdenVenta["Agente"]."', '".$RResFFactura["Version"]."', '".$_SESSION["usuario"]."')");
		//actualizo el numero de factura
		mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Id='".$RResFFactura["Id"]."'");
		
		//ingreso los productos de la factura
		$ResIdFact=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente='".$RResOrdenVenta["Cliente"]."' AND NumOrden='".$RResOrdenVenta["NumOrden"]."' ORDER BY Id DESC LIMIT 1"));
		//$cadena='Id de Factura: '.$ResIdFact["Id"];
		for($A=1; $A<=$orden["elementos"]; $A++)
		{
			mysql_query("INSERT INTO detfacturas (IdFactura, Producto, Clave, Cantidad, PrecioUnitario, Subtotal, Usuario)
			 															VALUES ('".$ResIdFact["Id"]."', '".$orden["iddetorden_".$A]."', '".$orden["clave_".$A]."',
			 																			'".$orden["cantidad_".$A]."', '".$orden["preciouni_".$A]."', '".$orden["total_".$A]."', '".$_SESSION["usuario"]."')") or die($cadena.=mysql_error());
			//total de producto facturado
			$ResProdOrden=mysql_fetch_array(mysql_query("SELECT Id, Cantidad, Producto FROM detordenventa WHERE idorden='".$orden["idorden"]."' AND Id='".$orden["producto_".$A]."' LIMIT 1")); //cuantos de pidieron
			$RResProdFact=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS ProdFact FROM detfacturas WHERE IdFactura='".$RResFFactura["Factura"]."' AND Producto='".$orden["producto_".$A]."'"));//cuantos se han facturado
			if($RResProdFact["ProdFact"]==$ResProdOrden["Cantidad"])
			{
				mysql_query("UPDATE detordenventa SET Status='Facturado', Usuario='".$_SESSION["usuario"]."' WHERE Id='".$ResProdOrden["Id"]."'");
			}
		}
		//Actualizo el status de la orden de venta
		$ResFacturas=mysql_fetch_array(mysql_query("SELECT Facturas FROM ordenventa WHERE Id='".$orden["idorden"]."' LIMIT 1"));
		mysql_query("UPDATE ordenventa SET Status='Facturado', Usuario='".$_SESSION["usuario"]."', Facturas='".$ResFacturas["Facturas"].$RResFFactura["Factura"].">>' WHERE Id='".$orden["idorden"]."'");

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
		$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' AND Nombre LIKE 'MATRIZ%' ORDER BY Id DESC LIMIT 1"));
		
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
		$cadenaoriginal.=$ResMatriz["Calle"].'|';
		//numero exterior del emisor
		if($ResMatriz["NoExterior"]!=''){$cadenaoriginal.=$ResMatriz["NoExterior"].'|';}
		//numero interior del emisor
		if($ResMatriz["NoInterior"]!=''){$cadenaoriginal.=$ResMatriz["NoInterior"].'|';}
		//colonia del emisor
		if($ResMatriz["Colonia"]!=''){$cadenaoriginal.=$ResMatriz["Colonia"].'|';}
		//localidad del emisor
		if($ResMatriz["Localidad"]!=''){$cadenaoriginal.=$ResMatriz["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResMatriz["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResMatriz["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResMatriz["Pais"].'|';
		//codigo porstal del emisor
		$cadenaoriginal.=$ResMatriz["CodPostal"].'|';
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
	//RFC del emisor
	$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'" >';
	//domicilio del emisor
	$xml.=' <DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.=' <ExpedidoEn calle="'.$ResMatriz["Calle"].'"';if($ResMatriz["NoExterior"]!=''){$xml.=' noExterior="'.$ResMatriz["NoExterior"].'"';}if($ResMatriz["NoInterior"]!=''){$xml.=' noInterior="'.$ResMatriz["NoInterior"].'"';}$xml.=' colonia="'.$ResMatriz["Colonia"].'"';if($ResMatriz["Localidad"]!=''){$xml.=' localidad="'.$ResMatriz["Localidad"].'"';}$xml.=' municipio="'.$ResMatriz["Municipio"].'" estado="'.$ResMatriz["Estado"].'" pais="'.$ResMatriz["Pais"].'" codigoPostal="'.$ResMatriz["CodPostal"].'"/>';
	//regimen fiscal
	$xml.='<RegimenFiscal Regimen="'.$ResEmpresa["Regimen"].'" />
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
function cancela_factura($factura, $cancela='no', $hora=NULL)
{
	include ("conexion.php");
	
	$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$factura."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));
	$ResAlmacen=mysql_fetch_array(mysql_query("SELECT Empresa, Sucursal, Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	$almacen=$ResAlmacen["Empresa"].'_'.$ResAlmacen["Sucursal"].'_'.$ResAlmacen["Nombre"];
	
	if($cancela=='no')
	{
		$mensaje='Esta seguro de cancelar la Factura Num: '.$ResFactura["NumFactura"].' del Cliente '.$ResCliente["Nombre"].'<br />
							<a href="#" onclick="xajax_cancela_factura(\''.$factura.'\', \'si\', document.getElementById(\'reloj\').value)">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_facturas()">No</a>';
	}
	elseif($cancela=='si')
	{
		$horacancelacion=date("Y-m-d").' '.$hora;
		//Selecciona los productos de la factura
		//2011$ResProd=mysql_query("SELECT Almacen, Cantidad, Producto FROM movinventario WHERE IdFactura='".$factura."' ORDER BY Id ASC");
		$ResProd=mysql_query("SELECT Producto, Cantidad FROM detfacturas WHERE IdFactura='".$factura."' ORDER BY Id ASC");
		//verifica si la factura fue a travez de orden de venta
		if($ResFactura["NumOrden"]!=0 AND $ResFactura["Fecha"][2].$ResFactura["Fecha"][3]==12) //facurado de una orden de venta
		{
			//obtener id y status de orden de venta
			$ResIdOrden=mysql_fetch_array(mysql_query("SELECT Id, Status FROM ordenventa WHERE NumOrden='".$ResFactura["NumOrden"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
			if($ResIdOrden["Status"]!='Cancelada')
			{
				$mensaje='<p class="textomensaje">No se puede cancelar la Factura Num.: '.$ResFactura["NumFactura"].' antes de cancelar la Orden de Venta Num.: '.$ResFactura["NumOrden"].'</p>';
			}
			else
			{
				mysql_query("UPDATE facturas SET Status='Cancelada', FechaCancelada='".$horacancelacion."', Usuario='".$_SESSION["usuario"]."' WHERE Id='".$factura."'");
				$mensaje='<p class="textomensaje">Se cancelo la Factura '.$ResFactura["NumFactura"].' del Cliente '.$ResCliente["Nombre"].'</p>';
			}
		}
		//cancela Factura Directa
		elseif($ResFactura["NumOrden"]==0 OR $ResFactura["Fecha"][2].$ResFactura["Fecha"][3]=11)//factura directa o facturado en 2011
		{
		while($RResProd=mysql_fetch_array($ResProd))
			{
				//regresa el producto al almacen
				mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."+".$RResProd["Cantidad"]." WHERE IdProducto='".$RResProd["Producto"]."'")or die(mysql_error());
					//registra el movimiento al inventario
					mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdFactura, Fecha, Descripcion, Usuario)
																					VALUES ('".$almacen."', '".$RResProd["Producto"]."', 'Entrada', '".$RResProd["Cantidad"]."',
																									'".$factura."', '".date("Y-m-d")."', 'Devolucion de mercancia por cancelacion de factura', '".$_SESSION["usuario"]."')");
				
			}
		mysql_query("UPDATE facturas SET Status='Cancelada', FechaCancelada='".$horacancelacion."', Usuario='".$_SESSION["usuario"]."' WHERE Id='".$factura."'");
		$mensaje='<p class="textomensaje">Se cancelo la Factura '.$ResFactura["NumFactura"].' del Cliente '.$ResCliente["Nombre"].'<br />Se actualizo el inventario</p>';
		}
		//Cancela la factura
		
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#287d29" align="center" class="texto3">Facturas</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</th>
						</tr>
					 </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function claves_clientes($clave, $cliente, $cantidad, $almacen, $pp)
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
							<td bgcolor="#287d29" align="center" class="texto3">'.$almacen.'</td>
						</tr>';
//	$ResClavesPac=mysql_query("SELECT ClaveP, Producto, PrecioPactado FROM prodpactados WHERE ClaveP LIKE '".$clave."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente='".$cliente."' LIMIT 25");
//	while($RResClavesPac=mysql_fetch_array($ResClavesPac))
//	{
//		$cadena.='<tr>';
//		$ResProd=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM productos WHERE Id='".$RResClavesPac["Producto"]."' LIMIT 1"));
//		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$ResProd["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$ResProd["Id"].'\'; document.fordenventa.clave.value=\''.$RResClavesPac["ClaveP"].'\'; document.fordenventa.precio.value=\''.$RResClavesPac["PrecioPactado"].'\'; document.fordenventa.total.value=\''.number_format($RResClavesPac["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClavesPac["ClaveP"].'</a></td>
//							<td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$ResProd["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$ResProd["Id"].'\'; document.fordenventa.clave.value=\''.$RResClavesPac["ClaveP"].'\'; document.fordenventa.precio.value=\''.$RResClavesPac["PrecioPactado"].'\'; document.fordenventa.total.value=\''.number_format($RResClavesPac["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResProd["Nombre"].'</a></td>';
//		$ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$ResClavesPac["Producto"]."' LIMIT 1"));
//		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$ResProd["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$ResProd["Id"].'\'; document.fordenventa.clave.value=\''.$RResClavesPac["ClaveP"].'\'; document.fordenventa.precio.value=\''.$RResClavesPac["PrecioPactado"].'\'; document.fordenventa.total.value=\''.number_format($RResClavesPac["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResCantAlma[$almacen2].'</a></td>';
//		$cadena.='</tr>';
//	}
	
	$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, ".$pp." FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
		//if(mysql_num_rows(mysql_query("SELECT Id FROM prodpactados WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente='".$cliente."' AND Producto='".$RResClaves["Id"]."' LIMIT 1"))==0)
		//{
		//busca si el producto esta pactado
		$ResProdpactado=mysql_query("SELECT ClaveP, PrecioPactado FROM prodpactados WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente='".$cliente."' AND Producto='".$RResClaves["Id"]."' LIMIT 1");
		$RResProdpactado=mysql_fetch_array($ResProdpactado);
		if(mysql_num_rows($ResProdpactado)!=0)
		{
			if($RResProdpactado["ClaveP"]!=''){$clave=$RResProdpactado["ClaveP"];}else{$clave=$RResClaves["Clave"];}
			$precio=$RResProdpactado["PrecioPactado"];
		}
		else
		{
			$clave=$RResClaves["Clave"];
			if($RResClaves["Moneda"]=='MN'){$precio=$RResClaves[$pp];}
			elseif($RResClaves["Moneda"]=='USD')
			{
				$ResTC=mysql_fetch_array(mysql_query("SELECT * FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1"));
				$precio=$RResClaves[$pp]*$ResTC["USD"];
			}
		}
		 $cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenventa.precio.value=\''.$precio.'\'; document.fordenventa.clave.value=\''.$clave.'\'; document.fordenventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenventa.precio.value=\''.$precio.'\'; document.fordenventa.clave.value=\''.$clave.'\'; document.fordenventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>';
		$ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$RResClaves["Id"]."' LIMIT 1"));
		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenventa.precio.value=\''.$precio.'\'; document.fordenventa.clave.value=\''.$clave.'\'; document.fordenventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.inventario_stock($RResClaves["Id"],$almacen2).'</a></td>';
		$cadena.='</tr>';
		//}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function productos_clientes($producto, $cliente, $cantidad, $almacen, $pp) //sirve para buscar el producto por nombre
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
							<td bgcolor="#287d29" align="center" class="texto3">'.$almacen.'</td>
						</tr>';
	$ResProductos=mysql_query("SELECT Id, Clave, Nombre, Moneda, ".$pp." FROM productos WHERE Nombre LIKE '%".$producto."%' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Clave ASC LIMIT 25");
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
		 $cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fordenventa.precio.value=\''.$precio.'\'; document.fordenventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fordenventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fordenventa.precio.value=\''.$precio.'\'; document.fordenventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fordenventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Nombre"].'</a></td>';
		 $ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$RResProductos["Id"]."' LIMIT 1"));
		 $cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fordenventa.precio.value=\''.$precio.'\'; document.fordenventa.clave.value=\''.$RResProductos["Clave"].'\'; document.fordenventa.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.inventario_stock($RResProductos["Id"],$almacen2).'</a></td>';
		/*}
		else
		{
			$ResClavepactada=mysql_fetch_array($clavepactada);
			$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fordenventa.precio.value=\''.$ResClavepactada["PrecioPactado"].'\'; document.fordenventa.clave.value=\''.$ResClavepactada["ClaveP"].'\'; document.fordenventa.total.value=\''.number_format($ResClavepactada["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResClavepactada["ClaveP"].'</a></td>';
			$cadena.='<td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fordenventa.precio.value=\''.$ResClavepactada["PrecioPactado"].'\'; document.fordenventa.clave.value=\''.$ResClavepactada["ClaveP"].'\'; document.fordenventa.total.value=\''.number_format($ResClavepactada["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResProductos["Nombre"].'</a></td>';
		$ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$RResProductos["Id"]."' LIMIT 1"));
		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.producto.value=\''.$RResProductos["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResProductos["Id"].'\'; document.fordenventa.precio.value=\''.$ResClavepactada["PrecioPactado"].'\'; document.fordenventa.clave.value=\''.$ResClavepactada["ClaveP"].'\'; document.fordenventa.total.value=\''.number_format($ResClavepactada["PrecioPactado"]*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$ResCantAlma[$almacen2].'</a></td>';
		}*/
		
		$cadena.='</tr>';
		
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function facturas($limite=0, $buscar=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="12" bgcolor="#FFFFFF" align="left" class="texto">
							<form name="fbusfact" id="fbusfact" method="POST" action="clientes/facturasexcel.php" target="_blank">
							 Serie: <input type="text" name="serie" id="serie" size="10" class="input" value="'.$buscar["serie"].'"> Num. Factura: <input type="text" name="numfactura" id="numfactura" size="10" class="input" value="'.$buscar["numfactura"].'"> Cliente: <select name="cliente" id="cliente" onchange="xajax_unidades_cliente_facturas(this.value)"><option value="%">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.=' <option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$buscar["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	 </select> 
							 <div id="unidad"><p>Unidad: <select name="unidad" id="unidad"><option value="todas">Seleccione</option>';
	$ResUnidades=mysql_query("SELECT * FROM unidades_cliente WHERE Cliente='".$buscar["cliente"]."' ORDER BY Nombre ASC");
	while($RResUnidades=mysql_fetch_array($ResUnidades))
	{
		$cadena.='<option value="'.$RResUnidades["Id"].'"';if($RResUnidades["Id"]==$buscar["unidad"]){$cadena.=' selected';}$cadena.='>'.$RResUnidades["Nombre"].'</option>';
	}
	$cadena.='</select></p></div>
							 <p>Status: <select name="status" id="status"><option value="%">Seleccione</option>
									<option value="Pendiente"';if($buscar["status"]=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente de Cobro</option>
									<option value="Cobrada"';if($buscar["status"]=='Cobrada'){$cadena.=' selected';}$cadena.='>Cobrada</option>
									<option value="Cancelada"';if($buscar["status"]=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
								</select>
								Fecha: De <select name="diai" id="diai"><option value="01">Dia</option>';
	for($T=1; $T<=31; $T++)
	{
		if($T<=9){$T='0'.$T;}
		$cadena.='		<option value="'.$T.'"';if($buscar["diai"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><select name="mesi" id="mesi"><option value="01">Mes</option>
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
								</select><select name="annoi" id="annoi"><option value="2011">Año</option>';
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
	$cadena.='		</select> <input type="button" name="botbuscarfact" id="botbuscarfact" value="Buscar>>" class="boton" onclick="xajax_facturas(\'0\', xajax.getFormValues(\'fbusfact\'))">
								<input type="submit" name="botexcel" id="botexcel" value="Exportar a Excel>>" class="boton"><p></form>';
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="12" bgcolor="#287d29" align="center" class="texto3">Facturas</th>
						<tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">Serie</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Num. Factura</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Fecha</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Cliente</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Unidad</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Importe</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">IVA</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Total</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Status</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	if($buscar==NULL)
	{
		$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Fecha DESC, NumFactura DESC LIMIT ".$limite.", 25");
		$regs=mysql_num_rows(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'"));
	}
	else 
	{
		if($buscar["serie"]==''){$serie="%";}else{$serie=$buscar["serie"];}
		if($buscar["numfactura"]==''){$numfactura='%';}else{$numfactura=$buscar["numfactura"];}
		$fechai=$buscar["annoi"].'-'.$buscar["mesi"].'-'.$buscar["diai"].' 00:00:00';
		$fechaf=$buscar["annof"].'-'.$buscar["mesf"].'-'.$buscar["diaf"].' 23:59:59';
		if($buscar["unidad"]=='todas'){$unidadc='%';}else{$unidadc=$buscar["unidad"];}
		
		$ResFacturas=mysql_query("SELECT * FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie LIKE '".$serie."' AND NumFactura LIKE '".$numfactura."' AND Cliente LIKE '".$buscar["cliente"]."' AND UnidadCliente LIKE '".$unidadc."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status LIKE '".$buscar["status"]."' ORDER BY Fecha DESC, NumFactura DESC LIMIT ".$limite.", 25");
		$regs=mysql_num_rows(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie LIKE '".$serie."' AND NumFactura LIKE '".$numfactura."' AND Cliente LIKE '".$buscar["cliente"]."' AND UnidadCliente LIKE '".$unidadc."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status LIKE '".$buscar["status"]."'"));
	}
	$bgcolor="#7ac37b";
	while($RResFacturas=mysql_fetch_array($ResFacturas))
	{
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResFacturas["Cliente"]."' LIMIT 1"));
		$ResUniClie=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResFacturas["UnidadCliente"]."' LIMIT 1"));
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResFacturas["Serie"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResFacturas["NumFactura"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResFacturas["Fecha"][8].$RResFacturas["Fecha"][9].'-'.$RResFacturas["Fecha"][5].$RResFacturas["Fecha"][6].'-'.$RResFacturas["Fecha"][0].$RResFacturas["Fecha"][1].$RResFacturas["Fecha"][2].$RResFacturas["Fecha"][3].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResCliente["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResUniClie["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$'.number_format($RResFacturas["Subtotal"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$'.number_format($RResFacturas["Iva"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$'.number_format($RResFacturas["Total"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResFacturas["Status"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="';if($RResFacturas["Version"]=='2.0'){$cadena.='clientes/factura.php?idfactura='.$RResFacturas["Id"];}elseif($RResFacturas["Version"]=='2.2'){$cadena.='clientes/factura2_2.php?idfactura='.$RResFacturas["Id"].'&empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"];}$cadena.='" target="_blank">VER</a>
								</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="';if($RResFacturas["Version"]=='2.0'){$cadena.='clientes/xml.php?idfactura='.$RResFacturas["Id"];}elseif($RResFacturas["Version"]=='2.2'){$cadena.='clientes/xml2_2.php?idfactura='.$RResFacturas["Id"];}$cadena.='" target="_blank">XML</a>
								</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">';
		if($RResFacturas["Status"]=='Pendiente')
		{
			$cadena.='<a href="#" onclick="'.activapermisos('xajax_cancela_factura(\''.$RResFacturas["Id"].'\')', 'cancelar').'">Cancelar</a>';
		}
		$cadena.='	</td>						
							</tr>';
		
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	$cadena.='	<tr>
								<th colspan="12" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		if($buscar==NULL)
		{
			if($J!=$limite){$cadena.='<a href="#" onclick="xajax_facturas(\''.$J.'\')">'.$T.'</a> |	';}
			else{$cadena.=$T.' | ';}
		}
		else
		{
			if($J!=$limite){$cadena.='<a href="#" onclick="xajax_facturas(\''.$J.'\', xajax.getFormValues(\'fbusfact\'))">'.$T.'</a> |	';}
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
function factura_libre($factura=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenventa" id="fordenventa">
					<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
							<tr>
								<th colspan="8" align="center" bgcolor="#287d29" class="texto3">Factura Libre</th>
							</tr>';
	$cadena.='	<tr>
								<td colspan="2" align="right" bgcolor="#7abc7a" class="texto">Cliente:</td>
								<td colspan="3" align="left" bgcolor="#7abc7a" class="texto">
									<select name="cliente" id="cliente" onchange="xajax_forma_pago_cliente(this.value);"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='	<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$factura["cliente"]){$cadena.=' selected';}
		$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							<td align="left" bgcolor="#7abc7a" class="texto">Almacen: </td>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto"><select name="almacen" id="almacen"><option value="">Seleccione</option>';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$factura["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#7abc7a class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$factura["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#7abc7a" class="texto" valign="top">Pedido Num.:</td>
						 	<td colspan="2" algin="left" bgcolor="#7abc7a" class="texto" valign="top"><input type="text" name="pedido" id="pedido" class="input" size="10" value="'.$factura["pedido"].'"></td>
						 </tr>
						 <tr>
						 	<td colspan="2" align="right" bgcolor="#7abc7a" class="texto" valign="top">Nota: </td>
						 	<td colspan="6" align="left" bgcolor="#7abc7a" class="texto" valign="top"><input type="text" name="nota" id="nota" class="input" size="150" value="'.$factura["nota"].'">
						 </tr>
						 <tr>
						 	<td colspan="2" align="right" bgcolor="#7abc7a" class="texto" valign="top">Agente: </td>
						 	<td colspan="2" align="left" bgcolor=#7abc7a class="texto" valign="top"><select name="agente" id="agente"><option value="">Seleccione</option>';
	$ResAgentes=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='AgenteV' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<option value="'.$RResAgentes["Id"].'"'; if($RResAgentes["Id"]==$factura["agente"]){$cadena.=' selected';}$cadena.='>'.$RResAgentes["Nombre"].'</option>';
	}
	$cadena.='		</select>
						 	</td>
						 	<td colspan="4" align="left" bgcolor="#7abc7a" class="texto" valign="top"><div id="moneda">Moneda: <select name="moneda" id="moneda" onchange="xajax_moneda(this.value)">
						 		<option value="M.N."'; if($factura["moneda"]=='M.N.'){$cadena.=' selected';}$cadena.='>M.N.</option>
						 		<option value="USD"'; if($factura["moneda"]=='USD'){$cadena.=' selected';}$cadena.='>USD</option>
						 	</select>';
	if($factura["moneda"]=='USD')
	{
		$cadena.=' $ <input type="text" name="tipocambio" id="tipocambio" class="input" size="5" value="'.$factura["tipocambio"].'">';
	}
	elseif($factura["moneda"]=='M.N.')
	{
		$cadena.=' $ <input type="hidden" name="tipocambio" id="tipocambio" class="input" size="5" value="0.00">';
	}
	$cadena.='</div></td>
						 </tr>
						 <tr>
						 	<td colspan="8" align="left" bgcolor="#7abc7a" class="texto" valig="top">
						 		<div id="pagocliente">
						 		Forma de Pago: <select name="fpago" id="fpago">
											<option value="NO IDENTIFICADO"';if($factura["fpago"]=='NO IDENTIFICADO'){$cadena.=' selected';}$cadena.='>NO IDENTIFICADO</option>
											<option value="EFECTIVO"';if($factura["fpago"]=='EFECTIVO'){$cadena.=' selected';}$cadena.='>EFECTIVO</option>
											<option value="TARJETA DE CREDITO"';if($factura["fpago"]=='TARJETA DE CREDITO'){$cadena.=' selected';}$cadena.='>TARJETA DE CREDITO</option>
											<option value="TARJETA DE DEBITO"';if($factura["fpago"]=='TARJETA DE DEBITO'){$cadena.=' selected';}$cadena.='>TARJETA DE DEBITO</option>
											<option value="TRANSFERENCIA ELECTRONICA"';if($factura["fpago"]=='TRANSFERENCIA ELECTRONICA'){$cadena.=' selected';}$cadena.='>TRANSFERENCIA ELECTRONICA</option>
											<option value="CHEQUE"';if($factura["fpago"]=='CHEQUE'){$cadena.=' selected';}$cadena.='>CHEQUE</option>
										</select>&nbsp;&nbsp;Num. Cuenta: <input type="text" name="numcuenta" id="numcuenta" size="5" class="input" value="'.$factura["numcuenta"].'">
						 		</div></td>
						 </tr>
						 <tr>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Cantidad</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Unidad</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Clave</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Producto</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Precio</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">Total</td>
						 	<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						 </tr>
						 <tr>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		&nbsp;
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
						 	</td>
						 		<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="unidad" id="unidad" size="10" class="input" value="s/u">
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="clave" id="clave" size="10" class="input">
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto">
						 		<input type="text" name="producto" id="producto" size="50" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_factura_libre(xajax.getFormValues(\'fordenventa\'))"></td>
						 </tr>';
	$bgcolor="#7ac37b"; $i=1; $j=1; $array=array();
	if($factura==NULL)
	{
		$partidas=1;
	}
	elseif($factura!=NULL)
	{
		if($borraprod==NULL)
		{
			//agrega partidas existentes
			for($J=1; $J<$factura["partidas"];$J++)
			{
				$ftotal=str_replace(',','',$factura["total_".$J]);
				$arreglo=array($J, $factura["cantidad_".$J], $factura["unidad_".$J], $factura["clave_".$J], $factura["producto_".$J], $factura["precio_".$J], $ftotal);
				array_push($array, $arreglo);
			}
			if($factura["precio"]==0 OR $factura["precio"]=='0.00')
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#7abc7a" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$factura["partidas"];
			}
			//Revisa existencia en inventario
			else 
			{
				$ftotal=str_replace(',','',$factura["total"]);
				$arreglo=array($J, $factura["cantidad"], $factura["unidad"], $factura["clave"], $factura["producto"], $factura["precio"], $ftotal);
				array_push($array, $arreglo);
				$partidas=count($array)+1;
			}
			
			
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$factura["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$factura["total_".$i]);
					$arreglo=array($j, $factura["cantidad_".$i], $factura["unidad_".$i], $factura["clave_".$i], $factura["producto_".$i], $factura["precio_".$i], $ftotal);
					array_push($array, $arreglo);
					$j++;
				}
				$i++;
			}
			$partidas=$factura["partidas"]-1;
		}
		
		
		
		
		
		
		//despliega la orden
		for($T=0;$T<count($array);$T++)
		{
			$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$array[$T][1]."' LIMIT 1"));
			$cadena.='<tr>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$array[$T][0].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="cantidad_'.$array[$T][0].'" id="cantidad_'.$array[$T][0].'" value="'.$array[$T][1].'">'.$array[$T][1].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="unidad_'.$array[$T][0].'" id="unidad_'.$array[$T][0].'" value="'.$array[$T][2].'">'.$array[$T][2].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="clave_'.$array[$T][0].'" id="clave_'.$array[$T][0].'" value="'.$array[$T][3].'">'.$array[$T][3].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="left" class="texto"><input type="hidden" name="producto_'.$array[$T][0].'" id="producto_'.$array[$T][0].'" value="'.utf8_decode($array[$T][4]).'">'.utf8_decode($array[$T][4]).'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="precio_'.$array[$T][0].'" id="precio_'.$array[$T][0].'" value="'.$array[$T][5].'">'.$array[$T][5].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="total_'.$array[$T][0].'" id="total_'.$array[$T][0].'" value="'.$array[$T][6].'">'.$array[$T][6].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto">
							 		<a href="#" onclick="xajax_factura_libre(xajax.getFormValues(\'fordenventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
			elseif($bgcolor="#5ac15b"){$bgcolor='#7ac37b';}
			
			$subtotal=$subtotal+$array[$T][6];
		}
		
		
	}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	$iva=($subtotal*$ivaa);
	$cadena.=' <tr>
							<th colspan="6" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($subtotal, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="6" align="right" class="texto" bgcolor="'.$bgcolor.'">Iva '.($ivaa*100).' %: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($iva, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="6" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format(($iva+$subtotal), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>';
	$cadena.='<tr>
							<th colspan="8" align="center" bgcolor="#7abc7a" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
								<input type="button" name="botfinfact" id="botfinfact" value="Guardar Factura>>" class="boton" onclick="this.disabled = true;xajax_finaliza_factura_libre(xajax.getFormValues(\'fordenventa\'), document.getElementById(\'reloj\').value)">
							</th>
						</tr>
						</table>
						</form>';

	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function finaliza_factura_libre($factura, $hora)
{
	include ("conexion.php");
	
	//numero de factura
	$numfactura=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	
	if($numfactura["Factura"]>$numfactura["FolioF"])
	{
		$mensaje='No existen Folios disponibles para facturar';
	}
	else 
	{
		//incrementa el numero de Factura
		mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$numfactura["Id"]."'");
		//guarda Factura
		for($i=1; $i<$factura["partidas"];$i++)
		{
			$subtotal=$subtotal+$factura["total_".$i];
		}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
		$iva=$subtotal*$ivaa;
		$total=$subtotal+$iva;
		$fechahora=date("Y-m-d").' '.$hora;
		//ingreso datos generales de factura
		mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, NumPedido, NumOrden, Fecha, Subtotal, Iva, Total, Moneda, TipoCambio, Status, Observaciones, Nota, Fpago, Ncuenta, Agente, Version, Usuario)
															 VALUES ('".$numfactura["Serie"]."', '".$numfactura["Factura"]."', '".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."',
																 			 '".$factura["cliente"]."', '".$factura["pedido"]."', '0', '".$fechahora."', '".$subtotal."', 
																			 '".$iva."', '".$total."', '".$factura["moneda"]."', '".$factura["tipocambio"]."', 'Pendiente', '".$factura["observaciones"]."', '".$factura["nota"]."', '".$factura["fpago"]."', '".$factura["numcuenta"]."', '".$factura["agente"]."', '".$numfactura["Version"]."', '".$_SESSION["usuario"]."')") or die($cadena.=mysql_error());
		
		$idfactura=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE NumFactura='".$numfactura["Factura"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
		
		for($i=1; $i<$factura["partidas"]; $i++)
		{
			//registra los productos de la factura
			mysql_query("INSERT INTO detfacturas (IdFactura, Unidad, Descripcion, Clave, Cantidad, PrecioUnitario, Subtotal, Usuario)
			 															VALUES ('".$idfactura["Id"]."', '".$factura["unidad_".$i]."', '".$factura["producto_".$i]."', '".$factura["clave_".$i]."',
			 																			'".$factura["cantidad_".$i]."', '".$factura["precio_".$i]."', '".$factura["total_".$i]."', '".$_SESSION["usuario"]."')");
			//descuenta producto del inventario
			//mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."-".$factura["cantidad_".$i]." WHERE IdProducto='".$factura["idproducto_".$i]."'");
			//regisra el movimiento
			//mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenVenta, IdFactura, Fecha, Descripcion)
			//																VALUES ('".$almacen."', '".$factura["idproducto_".$i]."', 'Salida', '".$factura["cantidad_".$i]."',
			//																				'0', '".$idfactura["Id"]."', '".date("Y-m-d")."', 'Salida de Mercancia por Factura Directa al cliente')");
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
		$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' AND Nombre LIKE 'MATRIZ%' ORDER BY Id DESC LIMIT 1"));
		
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
		$cadenaoriginal.=$ResMatriz["Calle"].'|';
		//numero exterior del emisor
		if($ResMatriz["NoExterior"]!=''){$cadenaoriginal.=$ResMatriz["NoExterior"].'|';}
		//numero interior del emisor
		if($ResMatriz["NoInterior"]!=''){$cadenaoriginal.=$ResMatriz["NoInterior"].'|';}
		//colonia del emisor
		if($ResMatriz["Colonia"]!=''){$cadenaoriginal.=$ResMatriz["Colonia"].'|';}
		//localidad del emisor
		if($ResMatriz["Localidad"]!=''){$cadenaoriginal.=$ResMatriz["Localidad"].'|';}
		//municipio del emisro
		$cadenaoriginal.=$ResMatriz["Municipio"].'|';
		//estado del emisor
		$cadenaoriginal.=$ResMatriz["Estado"].'|';
		//pais del emisor
		$cadenaoriginal.=$ResMatriz["Pais"].'|';
		//codigo porstal del emisor
		$cadenaoriginal.=$ResMatriz["CodPostal"].'|';
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
		$cadenaoriginal.=$RResPartidas["Unidad"].'|';
		//numero de identificacion (clave)
		$cadenaoriginal.=$RResPartidas["Clave"].'|';
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
	//RFC del emisor
	$xml.='<Emisor rfc="'.$ResEmisor["RFC"].'"';
	//Nombre del emisor
	$xml.=' nombre="'.$ResEmpresa["Nombre"].'" >';
	//domicilio del emisor
	$xml.=' <DomicilioFiscal calle="'.$ResEmisor["Calle"].'"';if($ResEmisor["NoExterior"]!=''){$xml.=' noExterior="'.$ResEmisor["NoExterior"].'"';}if($ResEmisor["NoInterior"]!=''){$xml.=' noInterior="'.$ResEmisor["NoInterior"].'"';}$xml.=' colonia="'.$ResEmisor["Colonia"].'"';if($ResEmisor["Localidad"]!=''){$xml.=' localidad="'.$ResEmisor["Localidad"].'"';}$xml.=' municipio="'.$ResEmisor["Municipio"].'" estado="'.$ResEmisor["Estado"].'" pais="'.$ResEmisor["Pais"].'" codigoPostal="'.$ResEmisor["CodPostal"].'"/>';
	//lugar de emision
	$xml.=' <ExpedidoEn calle="'.$ResMatriz["Calle"].'"';if($ResMatriz["NoExterior"]!=''){$xml.=' noExterior="'.$ResMatriz["NoExterior"].'"';}if($ResMatriz["NoInterior"]!=''){$xml.=' noInterior="'.$ResMatriz["NoInterior"].'"';}$xml.=' colonia="'.$ResMatriz["Colonia"].'"';if($ResMatriz["Localidad"]!=''){$xml.=' localidad="'.$ResMatriz["Localidad"].'"';}$xml.=' municipio="'.$ResMatriz["Municipio"].'" estado="'.$ResMatriz["Estado"].'" pais="'.$ResMatriz["Pais"].'" codigoPostal="'.$ResMatriz["CodPostal"].'"/>';
	//regimen fiscal
	$xml.='<RegimenFiscal Regimen="'.$ResEmpresa["Regimen"].'" />
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
	
	$xml.='unidad="'.$RResPartidas["Unidad"].'" noIdentificacion="'.$RResPartidas["Clave"].'" descripcion="'.$RResPartidas["Descripcion"].'"';
	
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
		
			
		
			
		$mensaje='Se genero la Factura  numero '.$numfactura["Factura"].' '.$fechahora;
			
	}
	
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="3" bgcolor="#287d29" align="center" class="texto3">Factura</td>
						</tr>
						<tr>
							<td colspan="3" bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						<tr>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
								<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/factura.php?idfactura='.$idfactura["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/factura2_2.php?idfactura='.$idfactura["Id"].'&empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"];}$cadena.='" target="_blank">Imprimir Factura</a>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
								<a href="';if($ResFactura["Version"]=='2.0'){$cadena.='clientes/xml.php?idfactura='.$idfactura["Id"];}elseif($ResFactura["Version"]=='2.2'){$cadena.='clientes/xml2_2.php?idfactura='.$idfactura["Id"];}$cadena.='" target="_blank">Descargar XML</a>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
									<input type="button" name="botenviarfactura" id="botneviarfactura" value="Enviar Factura por Correo>>" class="boton">
								</td>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function aplica_pagos_clientes($form=NULL, $borrapago=NULL)
{
	include ("conexion.php");
	
	$fecha=$form["anno"].'-'.$form["mes"].'-'.$form["dia"];
	
	$cadena='<form name="faplicapagos" id="faplicapagos">
					 <table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#FFFFFF" align="center" class="textomensaje">';
	if($form!=NULL AND $form["banco"]==''){$cadena.='No Selecciono cuenta Bancaria <br />';$boton='no';}
	if($form!=NULL AND $form["movimiento"]!='Efectivo' AND $form["nummov"]==''){$cadena.='No Ingreso Numero de Movimiento <br />';$boton='no';}
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Aplicar Pagos Clientes</th>
						</tr>
						<tr>
							<td align="left" bgcolor="#7abc7a" class="texto">Cliente :</td>
							<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><select name="clientes" id="clientes"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$form["clientes"] AND $accion==NULL){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='			</select>
							</td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Cuenta Bancaria :</td>
								<td colspan="3" bgcolor="#7abc7a" class="texto" align="left"><select name="banco" id="banco"><option value="">Seleccione</option>';
		$ResBancos=mysql_query("SELECT * FROM bancos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Banco ASC, NumCuenta ASC");
		while($RResBancos=mysql_fetch_array($ResBancos))
		{
			$cadena.='	<option value="'.$RResBancos["Id"].'"';if($RResBancos["Id"]==$form["banco"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Banco"].' - '.$RResBancos["NumCuenta"].'</option>';
		}
		$cadena.='	</select></td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Movimiento :</td>
								<td bgcolor="#7abc7a" class="texto" align="left"><select name="movimiento" id="movimiento">
									<option value="Transferencia"';if($form["movimiento"]=='Transferencia'){$cadena.=' selected';}$cadena.='>Transferencia Bancaria</option>
									<option value="Cheque"';if($form["movimiento"]=='Cheque'){$cadena.=' selected';}$cadena.='>Cheque</option>
									<option value="Efectivo"';if($form["movimiento"]=='Efectivo'){$cadena.=' selected';}$cadena.='>Pago en Efectivo</option>
									</select>
								</td>
								<td bgcolor="#7abc7a" class="texto" align="left">Numero :</td>
								<td bgcolor="#7abc7a" class="texto" align="left"><input type="text" name="nummov" id="nummov" class="input" value="'.$form["nummov"].'"></td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Fecha: </td>
								<td colspan="3" bgcolor="#7abc7a" class="texto" align="left"><select name="dia" id="dia"><option value="'.date("d").'">Dia</option>';
		for($i=1; $i<=31; $i++)
		{
			if($i<=9){$i='0'.$i;}
			$cadena.='<option value="'.$i.'"'; if($i==$form["dia"]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
		}
		$cadena.='		</select> <select name="mes" id="mes"><option value="'.date("m").'">Mes</option>
										<option value="01"';if($form["mes"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
										<option value="02"';if($form["mes"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
										<option value="03"';if($form["mes"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
										<option value="04"';if($form["mes"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
										<option value="05"';if($form["mes"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
										<option value="06"';if($form["mes"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
										<option value="07"';if($form["mes"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
										<option value="08"';if($form["mes"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
										<option value="09"';if($form["mes"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
										<option value="10"';if($form["mes"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
										<option value="11"';if($form["mes"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
										<option value="12"';if($form["mes"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
									</select> <select name="anno" id="anno"><option value="'.date("Y").'">Año</option>';
		for($i=2011; $i<=date("Y"); $i++)
		{
			$cadena.='		<option value="'.$i.'"';if($i==$form["anno"]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
		}
		$cadena.='		</select></td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Documento: </td>
								<td bgcolor="#7abc7a" class="texto" align="left">
									<input type="hidden" name="idfactura" id="idfactura" value="">
									<input type="text" name="documento" id="documento" value="" class="input" onKeyUp="documentos.style.visibility=\'visible\'; xajax_documentos_clientes(document.getElementById(\'clientes\').value, this.value)">
									<div id="documentos" style="position: absolute; width: 100px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
								</td>
								<td bgcolor="#7abc7a" class="texto" align="left">Abono : </td>
								<td bgcolor="#7abc7a" class="texto" align="left">$ <input type="text" name="abono" id="abono" class="input"></td>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#7abc7a" class="texto" algin="center">
									<input type="button" name="botadmov" id="botadmov" value="Agregar>>" class="boton" onclick="xajax_aplica_pagos_clientes(xajax.getFormValues(\'faplicapagos\'))">
								</td>
							</tr>';
	if($form==NULL)
	{
		$partidas=1;
	}
	if($form!=NULL)
	{
		$cadena.='<tr>
								<td colspan="4" bgcolor="#7abc7a" class="texto" align="center">
									<table border="1" bordercolor="#7abc7a" cellpadding="3" cellspacing="0">
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
				$arreglo=array($J, $form["idfactura_".$J], $form["abono_".$J]);
				array_push($array, $arreglo);
			}
			//agrega nueva partida
			if($form["idfactura"] AND $form["abono"])
			{
				$arreglo=array($J, $form["idfactura"], $form["abono"]);
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
					$arreglo=array($J, $form["idfactura_".$i], $form["abono_".$i]);
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
			$ResNumFact=mysql_fetch_array(mysql_query("SELECT NumFactura, Total FROM facturas WHERE Id='".$array[$i][1]."' LIMIT 1"));
			$cadena.='<tr>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$array[$i][0].'</td>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idfactura_'.$array[$i][0].'" id="idfactura_'.$array[$i][0].'" value="'.$array[$i][1].'">'.$ResNumFact["NumFactura"].'</td>
									<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($ResNumFact["Total"], 2).'</td>
									<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="abono_'.$array[$i][0].'" id="abono_'.$array[$i][0].'" value="'.$array[$i][2].'">$ '.number_format($array[$i][2],2).'</td>
									<td bgcolor="'.$bgcolor.'" align="center" class="texto">
										<a href="#" onclick="xajax_aplica_pagos_clientes(xajax.getFormValues(\'faplicapagos\'), \''.$array[$i][0].'\')"><img src="images/x.png" border="0"></a>
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
								<td colspan="4" bgcolor="#7abc7a" class="texto" align="center">';
	if(!$boton AND $form!=NULL)
	{
		$cadena.='<input type="button" name="botadmovimientos" id="botadmovimientos" value="Guardar Pagos>>" class="boton" onclick="xajax_guarda_aplica_pagos_clientes(xajax.getFormValues(\'faplicapagos\'))">';				
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
function guarda_aplica_pagos_clientes($form)
{
	include ("conexion.php");
	
	$fecha=$form["anno"].'-'.$form["mes"].'-'.$form["dia"];
	//buscafolio
	$ResFolio=mysql_fetch_array(mysql_query("SELECT NumFolio FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumFolio DESC LIMIT 1"));
	$Folio=$ResFolio["NumFolio"]+1;
	
	$tabla='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Detalles del Movimiento</th>
					</tr>
					<tr>
							<td align="left" bgcolor="#7abc7a" class="texto">Cliente :</td>
							<td colspan="3" align="left" bgcolor="#7abc7a" class="texto">';
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$form["clientes"]."' LIMIT 1"));
	$tabla.=$ResCliente["Nombre"].'</td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Cuenta Bancaria :</td>
								<td colspan="3" bgcolor="#7abc7a" class="texto" align="left">';
		$ResBancos=mysql_fetch_array(mysql_query("SELECT * FROM bancos WHERE Id='".$form["banco"]."' LIMIT 1"));
		$tabla.=$ResBancos["Banco"].' - '.$ResBancos["NumCuenta"].'</td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Movimiento :</td>
								<td bgcolor="#7abc7a" class="texto" align="left">'.$form["movimiento"].'</td>
								<td bgcolor="#7abc7a" class="texto" align="left">Numero :</td>
								<td bgcolor="#7abc7a" class="texto" align="left">'.$form["nummov"].'</td>
							</tr>
							<tr>
								<td bgcolor="#7abc7a" class="texto" align="left">Fecha: </td>
								<td colspan="3" bgcolor="#7abc7a" class="texto" align="left">'.fecha($fecha).'</td>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#7abc7a" class="texto" align="center">
									<table border="1" bordercolor="#7abc7a" cellpading="3" cellspacing="0" align="center" width="100%">
										<tr>
											<td align="center" class="texto3" bgcolor="#4eb24e">&nbsp;</td>
											<td align="center" class="texto3" bgcolor="#4eb24e">Num. Factura</td>
											<td align="center" class="texto3" bgcolor="#4eb24e">Importe</td>
											<td align="center" class="texto3" bgcolor="#4eb24e">Abono</td>
										</tr>';
	$bgcolor='#7ac37b'; 
	for($i=1; $i<$form["partidas"];$i++)
	{
		//ingresa movimiento
		mysql_query("INSERT INTO pagos_clientes (Empresa, Sucursal, NumFolio, Fecha, Banco, TipoMovimiento, NumMovimiento, IdFactura, Cliente, Abono, Usuario)
																			 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$Folio."', '".$fecha."', '".$form["banco"]."',
																			 				 '".$form["movimiento"]."', '".$form["nummov"]."', '".$form["idfactura_".$i]."', '".$form["clientes"]."', '".$form["abono_".$i]."', '".$_SESSION["usuario"]."')") or die(mysql_query());
	 //revisa si el documento fue liquidado
	 //pagos
	 $ResPagos=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS Pagado FROM pagos_clientes WHERE IdFactura='".$form["idfactura_".$i]."' AND Status='Aplicado'"));
	 $ResTotalFact=mysql_fetch_array(mysql_query("SELECT NumFactura, Total FROM facturas WHERE Id='".$form["idfactura_".$i]."' LIMIT 1"));
	 //notacredito
	 $ResNC=mysql_fetch_array(mysql_query("SELECT SUM(Total) AS Pagado FROM nota_credito WHERE IdFactura='".$form["idfactura_".$i]."' AND Status='Aplicada'"));
	 if(($ResPagos["Pagado"]+$ResNC["Total"])>=$ResTotalFact["Total"])
	 {
	 	mysql_query("UPDATE facturas SET Status='Pagada' WHERE Id='".$form["idfactura_".$i]."'")or die(mysql_error());
	 }
	 //despliega el detalle
	 $tabla.='<tr>
	 						<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$i.'</td>
	 						<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$ResTotalFact["NumFactura"].'</td>
	 						<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($ResTotalFact["Total"],2).'</td>
	 						<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($form["abono_".$i],2).'</td>
	 					</tr>';
	 if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
	 elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';} 
	}
	$tabla.='	<tr>
							<td colspan="4" aling="center" class="texto" bgcolor="'.$bgcolor.'">
								<a href="clientes/movclientes.php?banco='.$form["banco"].'&movimiento='.$form["movimiento"].'&nummov='.$form["nummov"].'&cliente='.$form["clientes"].'&fecha='.$fecha.'&folio='.$Folio.'" target="_blank">Imprimir Movimiento</a></td>
						</tr>
						</table>';
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Aplicar Pagos Clientes</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="textomensaje">Se han registrado los pagos</th>
						</tr>
						</table>'.$tabla;
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function documentos_clientes($cliente, $documento)
{
	include ("conexion.php");
	
	$cadena='<table border="0" cellpadding="1" cellspacing="0">';
	$ResDocs=mysql_query("SELECT Id, NumFactura, Total FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$cliente."' AND NumFactura LIKE '".$documento."%'  AND Status='Pendiente' ORDER BY Id ASC");
	while($RResDocs=mysql_fetch_array($ResDocs))
	{ 
		//calcula el restante
		$ResPagos=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS Pagado FROM pagos_clientes WHERE IdFactura='".$RResDocs["Id"]."' AND Status='Aplicado'"));
	 	$ResTotalFact=mysql_fetch_array(mysql_query("SELECT Total FROM facturas WHERE Id='".$RResDocs["Id"]."' LIMIT 1"));
	 
		$cadena.='<tr>
							 <td style="display: block;outline: none;margin: 0;text-decoration: none;color: #3c833d;" align="left"><a href="#" onclick="document.faplicapagos.idfactura.value=\''.$RResDocs["Id"].'\';document.faplicapagos.documento.value=\''.$RResDocs["NumFactura"].'\'; document.faplicapagos.abono.value=\''.($ResTotalFact["Total"]-$ResPagos["Pagado"]).'\';documentos.style.visibility=\'hidden\';">'.$RResDocs["NumFactura"].'</a></td>
							</tr>';
	}
	$cadena.='</table>';

	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("documentos","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function reporte_pagos_clientes($form=NULL, $limite=0)
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0">
							<tr>
								<td colspan="11" aling="left" class="texto" bgcolor="#FFFFFF">
									<form name="freppagos" id="freppagos">
										Cliente: <select name="cliente" id="cliente"><option value="%">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$form["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
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
										<p>Serie: <input type="text" name="serie" id="serie" class="input"> Num. Factura: <input type="text" name="factura" id="factura" class="input"> 
									  <input type="button" name="botbuspagos" id="botbuspagos" value="Mostrar>>" class="boton" onclick="xajax_reporte_pagos_clientes(xajax.getFormValues(\'freppagos\'))">
									</form>
								</td>
							</tr>';
	if($form!=NULL)
	{
		$fechai=$form["annoi"].'-'.$form["mesi"].'-'.$form["diai"];
		$fechaf=$form["annof"].'-'.$form["mesf"].'-'.$form["diaf"];
		
		if($form["serie"]!=NULL OR $form["factura"]!=NULL)
		{
			$idfactura=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Serie='".$form["serie"]."' AND NumFactura='".$form["factura"]."' LIMIT 1"));
		}
		
		$cadena.='<tr>
								<th colspan="11" bgcolor="#287d29" align="center" class="texto3">Reporte de Pagos</th>
							</tr>
							<tr>
								<td align="center" bgcolor="#4eb24e" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Num. Folio</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Fecha</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Banco</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Movimiento</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Num. Movimiento</td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Factura </td>
								<td align="center" bgcolor="#4eb24e" class="texto3">Importe Factura</td>
								<td align="center" bgcolor="#43b24e" class="texto3">Abono</td>
								<td align="center" bgcolor="#43b24e" class="texto3">&nbsp;</td>
								<td align="center" bgcolor="#43b24e" class="texto3">&nbsp;</td>
							</tr>';
		if($idfactura)
		{
			$ResPagos=mysql_query("SELECT * FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$form["cliente"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status='Aplicado' AND IdFactura='".$idfactura["Id"]."' ORDER BY NumFolio DESC LIMIT ".$limite.", 25");
			$regs=mysql_num_rows(mysql_query("SELECT Id FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$form["cliente"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status='Aplicado' AND IdFactura='".$idfactura["Id"]."'"));
		}
		else 
		{
			$ResPagos=mysql_query("SELECT * FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$form["cliente"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status='Aplicado' ORDER BY NumFolio DESC LIMIT ".$limite.", 25");
			$regs=mysql_num_rows(mysql_query("SELECT Id FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Cliente LIKE '".$form["cliente"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status='Aplicado'"));
		}
		$bgcolor="#7ac37b"; $A=1;
		while($RResPagos=mysql_fetch_array($ResPagos))
		{
			$ResBanco=mysql_fetch_array(mysql_query("SELECT Banco, NumCuenta FROM bancos WHERE Id='".$RResPagos["Banco"]."' LIMIT 1"));
			$ResFactura=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura, Total FROM facturas WHERE Id='".$RResPagos["IdFactura"]."' LIMIT 1"));
			$cadena.='<tr>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$A.'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.=$RResPagos["NumFolio"];}else{$cadena.='&nbsp;';}$cadena.='</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.=fecha($RResPagos["Fecha"]);}else{$cadena.='&nbsp;';}$cadena.='</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.=$ResBanco["Banco"];}else{$cadena.='&nbsp;';}$cadena.='</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.=$RResPagos["TipoMovimiento"];}else{$cadena.='&nbsp;';}$cadena.='</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.=$RResPagos["NumMovimiento"];}else{$cadena.='&nbsp;';}$cadena.='</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$ResFactura["Serie"].' - '.$ResFactura["NumFactura"].'</td>
									<td align="rigth" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($ResFactura["Total"],2).'</td>
									<td align="rigth" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResPagos["Abono"], 2).'</td>
									<td align="center" bgcolor="'.$bgcolor.'" class="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.='<a href="clientes/movclientes.php?banco='.$RResPagos["Banco"].'&movimiento='.$RResPagos["TipoMovimiento"].'&nummov='.$RResPagos["NumMovimiento"].'&cliente='.$RResPagos["Cliente"].'&fecha='.$RResPagos["Fecha"].'&folio='.$RResPagos["NumFolio"].'" target="_blank">Ver</a>';}else{$cadena.='&nbsp;';}$cadena.='</td>
									<td align="center" bgcolor="'.$bgcolor.'" clas="texto">';if($nf!=$RResPagos["NumFolio"]){$cadena.='<a href="#" onclick="'.activapermisos('xajax_cancela_pago_cliente(\''.$RResPagos["NumFolio"].'\')', 'cancelar').'">Cancelar<a>';}else{$cadena.='&nbsp;';}$cadena.='</td>
								</tr>';
			$nf=$RResPagos["NumFolio"];
			if($bgcolor=="#7ac37b"){$bgcolor="#5ac15b";}
			elseif($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
			$A++;
		}
		$cadena.='<tr>
								<th colspan="11" bgcolor="#FFFFFF" align="center" class="texto">';
		$J=0;
		for($T=1; $T<=ceil($regs/25); $T++)
		{
			if($J!=$limite){$cadena.='<a href="#" onclick="xajax_reporte_pagos_clientes(xajax.getFormValues(\'freppagos\'), \''.$J.'\')">';}$cadena.=$T;if($J!=$limite){$cadena.='</a>';}$cadena.=' |	';
			$J=$J+25;
		}
		$cadena.='</th>
							</tr>';
	}
	$cadena.='</table>';
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function reporte_mensual()
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte de Facturación Mensual</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepmensual" id="frepmensual" method="POST" action="clientes/reportemensual.php" target="_blank">
									Seleccione Mes a reportar: <select name="mes" id="mes">
										<option value="01"'; if(date("m")=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
										<option value="02"'; if(date("m")=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
										<option value="03"'; if(date("m")=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
										<option value="04"'; if(date("m")=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
										<option value="05"'; if(date("m")=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
										<option value="06"'; if(date("m")=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
										<option value="07"'; if(date("m")=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
										<option value="08"'; if(date("m")=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
										<option value="09"'; if(date("m")=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
										<option value="10"'; if(date("m")=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
										<option value="11"'; if(date("m")=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
										<option value="12"'; if(date("m")=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
									</select><select name="anno" id="anno">';
	for($a=2011; $a<=date("Y"); $a++)
	{
		$cadena.='			<option value="'.$a.'"';if(date("Y")==$a){$cadena.=' selected';}$cadena.='>'.$a.'</option>';
	}
	$cadena.='			</select> <input type="submit" name="botrepmens" id="botrepmens" value="Generar Reporte>>" class="boton">
								</form>
							</th>
						</tr>
						</table>';
	
	$cadena.='</table>';
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ventas()
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte de Ventas</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepventas" id="frepventas" method="POST" action="clientes/reporteventas.php" target="_blank">
								 Cliente: <select name="cliente" id="cliente"><option value="%">Todos</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'">'.$RResClientes["Nombre"].'</td>';
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
						<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="4" bgcolor="#287d29" align="center" class="texto3">Reporte Concentrado de Ventas</th>
						</tr>
						<tr>
							<th colspan="4" bgcolor="#7abc7a" align="center" class="texto">
								<form name="frepventas" id="frepventas" method="POST" action="clientes/reporteconcentradoventas.php" target="_blank">
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
function nota_credito($factura=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenventa" id="fordenventa">
					<table border="1" bordercolor="#FFFFFF" cellpadding="4" cellspacing="0" align="center">
						<tr>
								<th colspan="7" align="center" bgcolor="#287d29" class="texto3">Nota de Credito</th>
							</tr>
							<tr>
								<td colspan="2" aling="left" bgcolor="#7abc7a" class="texto">Cliente:</td>
								<td colspan="3" align="left" bgcolor="#7abc7a" class="texto">
									<select name="cliente" id="cliente" onchange="xajax_nota_credito(xajax.getFormValues(\'fordenventa\'))"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='	<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$factura["cliente"]){$cadena.=' selected';}
		$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
								<td align="left" bgcolor="#7abc7a" class="texto">Almacen: </td>
							<td align="left" bgcolor="#7abc7a" class="texto"><select name="almacen" id="almacen"><option value="">Seleccione</option>';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$factura["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
							</tr>
							<tr>
						 	<td colspan="2" align="left" bgcolor="#7abc7a" class="texto" valign="top">Observaciones: </td>
						 	<td colspan="3" align="left" bgcolor=#7abc7a class="texto" valign="top"><textarea name="observaciones" id="observaciones" cols="60" rows="3" class="input">'.$factura["observaciones"].'</textarea></td>
						 	<td align="left" bgcolor="#7abc7a" class="texto" valign="top">Factura Num.:</td>
						 	<td algin="left" bgcolor="#7abc7a" class="texto" valign="top"><select name="factura" id="factura" class="input"><option>Seleccione</option>';
	$ResFacturas=mysql_query("SELECT Id, Serie, NumFactura FROM facturas WHERE Cliente='".$factura["cliente"]."' AND Status='Pendiente' ORDER BY NumFactura DESC");
	while($RResFacturas=mysql_fetch_array($ResFacturas))
	{
			$cadena.='<option value="'.$RResFacturas["Id"].'"'; if($RResFacturas["Id"]==$factura["factura"]){$cadena.=' selected';}$cadena.='>'.$RResFacturas["Serie"].' - '.$RResFacturas["NumFactura"].'</option>';
	}
	$cadena.='</select>
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
						 		<input type="text" name="clave" id="clave" size="10" class="input" onFocus="claves.style.visibility=\'visible\'; xajax_claves_clientes_nc(this.value, document.getElementById(\'cliente\').value, document.getElementById(\'factura\').value, document.getElementById(\'cantidad\').value)">
						 		<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
						 	</td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="producto" id="producto" size="50" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="text" name="total" id="total" size="10" class="input"></td>
						 	<td bgcolor="#7abc7a" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_nota_credito(xajax.getFormValues(\'fordenventa\'))"></td>
						 </tr>';
	$bgcolor="#7ac37b"; $i=1; $j=1; $array=array();
	if($factura==NULL)
	{
		$partidas=1;
	}
	elseif($factura!=NULL)
	{
		if($borraprod==NULL)
		{
			//agrega partidas existentes
			for($J=1; $J<$factura["partidas"];$J++)
			{
				$ftotal=str_replace(',','',$factura["total_".$J]);
				$arreglo=array($J, $factura["idproducto_".$J], $factura["cantidad_".$J], $factura["clave_".$J], $factura["producto_".$J], $factura["precio_".$J], $ftotal);
				array_push($array, $arreglo);
			}
			//Revisa que exista la clave
			
			//$ResCantidad=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$factura["almacen"]." FROM inventario WHERE IdProducto='".$factura["idproducto"]."' LIMIT 1"));
			
			if(mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"))==0 OR $factura["precio"]==0 OR $factura["precio"]=='0.00')
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#7abc7a" class="textomensaje">Operación Invalida</th>
									</tr>';
				$partidas=$factura["partidas"];
			}
			else 
			{
				$ftotal=str_replace(',','',$factura["total"]);
				$arreglo=array($J, $factura["idproducto"], $factura["cantidad"], $factura["clave"], $factura["producto"], $factura["precio"], $ftotal);
				array_push($array, $arreglo);
				$partidas=count($array)+1;
			}

			
		}
		else if($borraprod!=NULL)
		{
			//agrega productos a la orden
			$j=1;
			while($i<$factura["partidas"])
			{
				if($borraprod!=$i)
				{
					$ftotal=str_replace(',','',$factura["total_".$i]);
					$arreglo=array($j, $factura["idproducto_".$i], $factura["cantidad_".$i], $factura["clave_".$i], $factura["producto_".$i], $factura["precio_".$i], $ftotal);
					array_push($array, $arreglo);
					$j++;
				}
				$i++;
			}
			$partidas=$factura["partidas"]-1;
		}
	//despliega la orden
		for($T=0;$T<count($array);$T++)
		{
			$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$array[$T][1]."' LIMIT 1"));
			$cadena.='<tr>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="idproducto_'.$array[$T][0].'" id="idproducto_'.$array[$T][0].'" value="'.$array[$T][1].'">'.$array[$T][0].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="cantidad_'.$array[$T][0].'" id="cantidad_'.$array[$T][0].'" value="'.$array[$T][2].'">'.$array[$T][2].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto"><input type="hidden" name="clave_'.$array[$T][0].'" id="clave_'.$array[$T][0].'" value="'.$array[$T][3].'">'.$array[$T][3].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="left" class="texto"><input type="hidden" name="producto_'.$array[$T][0].'" id="producto_'.$array[$T][0].'" value="'.$array[$T][4].'">'.$array[$T][4].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="precio_'.$array[$T][0].'" id="precio_'.$array[$T][0].'" value="'.$array[$T][5].'">'.$array[$T][5].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="right" class="texto"><input type="hidden" name="total_'.$array[$T][0].'" id="total_'.$array[$T][0].'" value="'.$array[$T][6].'">'.$array[$T][6].'</td>
							 		<td bgcolor="'.$bgcolor.'" align="center" class="texto">
							 		<a href="#" onclick="xajax_nota_credito(xajax.getFormValues(\'fordenventa\'), '.$array[$T][0].')"><img src="images/x.png" border="0"></a></td>
							 	</tr>';
			if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
			elseif($bgcolor="#5ac15b"){$bgcolor='#7ac37b';}
			
			$subtotal=$subtotal+$array[$T][6];
		}
		
	}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
	$iva=($subtotal*$ivaa);
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
						 <tr>';
	$cadena.='<tr>
							<th colspan="7" align="center" bgcolor="#7abc7a" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
								<input type="button" name="botfinfact" id="botfinfact" value="Guardar Nota de Credito>>" class="boton" onclick="xajax_guarda_nota_credito(xajax.getFormValues(\'fordenventa\'), document.getElementById(\'reloj\').value)">
							</th>
						</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function guarda_nota_credito($nota, $hora)
{
	$almacen=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$nota["almacen"];
	//numero de nota
	$numnota=mysql_fetch_array(mysql_query("SELECT * FROM fnotascredito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	//IdFactura
	$idfact=$nota["factura"];
	
	if($numnota["Nota"]>$numnota["FolioF"])
	{
		$mensaje='No existen Folios disponibles para notas de credito, consulte al administrador';
	}
	else 
	{
		//incrementa el numero de Factura
		mysql_query("UPDATE fnotascredito SET Nota=Nota+1 WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$numnota["Id"]."'");
		//guarda nota de credito
		for($i=1; $i<$nota["partidas"];$i++)
		{
			$subtotal=$subtotal+$nota["total_".$i];
		}
	if($_SESSION["sucursal"]==1){$ivaa=0.11;}
	else{$ivaa=0.16;}
		$iva=$subtotal*$ivaa;
		$total=$subtotal+$iva;
		$fechahora=date("Y-m-d").' '.$hora;
		//ingreso datos generales de nota de credito
		mysql_query("INSERT INTO nota_credito (IdFactura, Serie, NumNota, Empresa, Sucursal, Cliente, Fecha, Importe, Iva, Total, Observaciones, Usuario)
															 VALUES ('".$idfact."', '".$numnota["Serie"]."', '".$numnota["Nota"]."', '".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."',
																 			 '".$nota["cliente"]."', '".$fechahora."', '".$subtotal."', 
																			 '".$iva."', '".$total."', '".utf8_decode($nota["observaciones"])."', '".$_SESSION["usuario"]."')") or die($cadena.=mysql_error());
		
		$idnotacredito=mysql_fetch_array(mysql_query("SELECT Id FROM nota_credito WHERE NumNota='".$numnota["Nota"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
		
		if($nota["almacen"]!='')
		{
		for($i=1; $i<$nota["partidas"]; $i++)
		{
			//registra los productos de la nota de credito
			mysql_query("INSERT INTO det_nota_credito (IdNota, Producto, Clave, Descripcion, Cantidad, PrecioUnitario, Importe, Usuario)
			 															VALUES ('".$idnotacredito["Id"]."', '".$nota["idproducto_".$i]."', '".$nota["clave_".$i]."', '".utf8_decode($nota["producto_".$i])."',
			 																			'".$nota["cantidad_".$i]."', '".$nota["precio_".$i]."', '".$nota["total_".$i]."', '".$_SESSION["usuario"]."')");
			//regresa producto al inventario
			mysql_query("UPDATE inventario SET ".$almacen."=".$almacen."+".$nota["cantidad_".$i]." WHERE IdProducto='".$nota["idproducto_".$i]."'");
			//regisra el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenVenta, IdFactura, IdNotaCredito, Fecha, Descripcion, Usuario)
																			VALUES ('".$almacen."', '".$nota["idproducto_".$i]."', 'Entrada', '".$nota["cantidad_".$i]."',
																							'0', '0', '".$idnotacredito["Id"]."', '".date("Y-m-d")."', 'Devolución de Mercancia por Nota de Credito', '".$_SESSION["usuario"]."')");
		}
		}
		
		//guarda movimiendo de pago
		$ResFolio=mysql_fetch_array(mysql_query("SELECT NumFolio FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumFolio DESC LIMIT 1"));
		$Folio=$ResFolio["NumFolio"]+1;
		
		mysql_query("INSERT INTO pagos_clientes (Empresa, Sucursal, NumFolio, Fecha, TipoMovimiento, NumMovimiento, IdFactura, Cliente, Abono, Usuario)
																		 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$Folio."', '".date("Y-m-d")."', 'Nota de Credito', 
																		 				 '".$numnota["Nota"]."', '".$idfact."', '".$nota["cliente"]."', '".$total."', '".$_SESSION["usuario"]."')");
		
	//revisa si el documento fue liquidado
	 $ResPagos=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS Pagado FROM pagos_clientes WHERE IdFactura='".$idfact."'"));
	 $ResTotalFact=mysql_fetch_array(mysql_query("SELECT NumFactura, Total FROM facturas WHERE Id='".$idfact."' LIMIT 1"));
	 if($ResPagos["Pagado"]>=$ResTotalFact["Total"])
	 {
	 	mysql_query("UPDATE facturas SET Status='Pagada' WHERE Id='".$idfact."'")or die(mysql_error());
	 }
			
		$mensaje='Se genero la Nota de Credito numero '.$numnota["Nota"].' '.$fechahora;
			
	}
	
	
	$cadena.='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<td colspan="2" bgcolor="#287d29" align="center" class="texto3">Nota de Credito</td>
						</tr>
						<tr>
							<td colspan="2" bgcolor="#7abc7a" align="center" class="textomensaje">'.$mensaje.'</td>
						</tr>
						<tr>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
									<form name="fimprimefact" id="fimprimefact" method="POST" action="clientes/notacredito.php" target="_blank">
									<input type="hidden" name="idnota" id="idnota" value="'.$idnotacredito["Id"].'">
									<input type="submit" name="botverfactura" id="botverfactura" value="Imprimir Nota de Credito>>" class="boton">
									</form>
								</td>
								<td align="center" bgcolor="#7abc7a" align="center" class="texto">
									<form name="fxml" id="fxml" method="POST" action="clientes/xmlnc.php" target="_blank">
									<input type="hidden" name="idnota" id="idnota" value="'.$idnotacredito["Id"].'">
									<input type="submit" name="botdescargarxml" id="botdescargarxml" value="Descargar XML>>" class="boton">
									</form>
								</td>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function claves_clientes_nc($clave, $cliente, $factura, $cantidad)
{
	include ("conexion.php");
	
	//$idfactura=mysql_fetch_array(mysql_query("SELECT Id FROM facturas WHERE Id='".$factura."' AND Cliente='".$cliente."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));
	
	//$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
						</tr>';

	$ResDetFactura=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$factura."' ORDER BY Id ASC");
	while($RResDetFactura=mysql_fetch_array($ResDetFactura))
	{
		$sql="SELECT Id, Clave, Nombre FROM productos WHERE Id='".$RResDetFactura["Producto"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'";
		$ResClaves=mysql_query("SELECT Id, Clave, Nombre FROM productos WHERE Id='".$RResDetFactura["Producto"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1");
		$RResClaves=mysql_fetch_array($ResClaves);
		
			$cadena.='<tr>
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.cantidad.value=\''.$RResDetFactura["Cantidad"].'\'; document.fordenventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenventa.precio.value=\''.$RResDetFactura["PrecioUnitario"].'\'; document.fordenventa.clave.value=\''.$RResClaves["Clave"].'\'; document.fordenventa.total.value=\''.number_format($RResDetFactura["Subtotal"], 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenventa.cantidad.value=\''.$RResDetFactura["Cantidad"].'\'; document.fordenventa.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenventa.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenventa.precio.value=\''.$RResDetFactura["PrecioUnitario"].'\'; document.fordenventa.clave.value=\''.$RResClaves["Clave"].'\'; document.fordenventa.total.value=\''.number_format($RResDetFactura["Subtotal"], 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>
							</tr>';
			
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function ver_notas_credito($limite=0, $buscar=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="11" bgcolor="#FFFFFF" align="left" class="texto">
							<form name="fbusnota" id="fbusnota">
							 Num. Nota de Credito: <input type="text" name="numnota" id="numnota" size="10" class="input" value="'.$buscar["numnota"].'"> Cliente: <select name="cliente" id="cliente"><option value="%">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.=' <option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$buscar["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	 </select> Status: <select name="status" id="status"><option value="%">Seleccione</option>
									<option value="Pendiente"';if($buscar["status"]=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente de Cobro</option>
									<option value="Cobrada"';if($buscar["status"]=='Cobrada'){$cadena.=' selected';}$cadena.='>Cobrada</option>
									<option value="Cancelada"';if($buscar["status"]=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
								</select>
								<p>Fecha: De <select name="diai" id="diai"><option value="00">Dia</option>';
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
	$cadena.='		</select> <input type="button" name="botbuscarnota" id="botbuscarnota" value="Buscar>>" class="boton" onclick="xajax_ver_notas_credito(\'0\', xajax.getFormValues(\'fbusnota\'))"><p>';
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="11" bgcolor="#287d29" align="center" class="texto3">Notas de Credito</th>
						<tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">Num. Nota</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Fecha</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Factura</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Cliente</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Importe</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">IVA</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Total</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Status</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	if($buscar==NULL)
	{
		$ResNotas=mysql_query("SELECT * FROM nota_credito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumNota DESC LIMIT ".$limite.", 25");
		$regs=mysql_num_rows(mysql_query("SELECT Id FROM nota_credito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'"));
	}
	else 
	{
		if($buscar["numnota"]==''){$numnota='%';}else{$numnota=$buscar["numnota"];}
		$fechai=$buscar["annoi"].'-'.$buscar["mesi"].'-'.$buscar["diai"].' 00:00:00';
		$fechaf=$buscar["annof"].'-'.$buscar["mesf"].'-'.$buscar["diaf"].' 00:00:00';
		
		$ResNotas=mysql_query("SELECT * FROM nota_credito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumNota LIKE '".$numnota."' AND Cliente LIKE '".$buscar["cliente"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status LIKE '".$buscar["status"]."' ORDER BY NumNota DESC LIMIT ".$limite.", 25");
		$regs=mysql_num_rows(mysql_query("SELECT Id FROM nota_credito WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumNota LIKE '".$numnota."' AND Cliente LIKE '".$buscar["cliente"]."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Status LIKE '".$buscar["status"]."'"));
	}
	$bgcolor="#7ac37b";
	while($RResNotas=mysql_fetch_array($ResNotas))
	{
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResNotas["Cliente"]."' LIMIT 1"));
		$ResFactura=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura FROM facturas WHERE Id='".$RResNotas["IdFactura"]."' LIMIT 1"));
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResNotas["NumNota"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResNotas["Fecha"][8].$RResNotas["Fecha"][9].' - '.$RResNotas["Fecha"][5].$RResNotas["Fecha"][6].' - '.$RResNotas["Fecha"][0].$RResNotas["Fecha"][1].$RResNotas["Fecha"][2].$RResNotas["Fecha"][3].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResFactura["Serie"].' - '.$ResFactura["NumFactura"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto">'.$ResCliente["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResNotas["Importe"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResNotas["Iva"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto">$ '.number_format($RResNotas["Total"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResNotas["Status"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="clientes/notacredito.php?idnota='.$RResNotas["Id"].'" target="_blank">VER</a>
								</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="clientes/xmlnc.php?idnota='.$RResNotas["Id"].'" target="_blank">XML</a>
								</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="#" onclick="'.activapermisos('xajax_cancela_nota_credito(\''.$RResNotas["Id"].'\')', 'cancelar').'">Cancelar</a></td>
							</tr>';
		
		if($bgcolor=='#7ac37b'){$bgcolor='#5ac15b';}
		elseif($bgcolor=='#5ac15b'){$bgcolor='#7ac37b';}
	}
	$cadena.='	<tr>
								<th colspan="10" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		if($buscar==NULL)
		{
			$cadena.='<a href="#" onclick="xajax_ver_notas_credito(\''.$J.'\')">'.$T.'</a> |	';
		}
		else
		{
			$cadena.='<a href="#" onclick="xajax_ver_notas_credito(\''.$J.'\', xajax.getFormValues(\'fbusnota\'))">'.$T.'</a> |	';
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
function cancela_nota_credito($nota, $cancela='no', $hora=NULL)
{
	include ("conexion.php");
	
	$ResNota=mysql_fetch_array(mysql_query("SELECT * FROM nota_credito WHERE Id='".$nota."' LIMIT 1"));
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNota["Cliente"]."' LIMIT 1"));
	
	if($cancela=='no')
	{
		$mensaje='Esta seguro de cancelar la Nota de Credito Num: '.$ResNota["NumNota"].' del Cliente '.$ResCliente["Nombre"].'<br />
							<a href="#" onclick="xajax_cancela_nota_credito(\''.$nota.'\', \'si\', document.getElementById(\'reloj\').value)">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_facturas()">No</a>';
	}
	elseif($cancela=='si')
	{
		$horacancelada=date("Y-m-d").' '.$hora;
		//Selecciona los productos de la nota
		$ResProd=mysql_query("SELECT Almacen, Cantidad, Producto FROM movinventario WHERE IdNotaCredito='".$nota."' ORDER BY Id ASC");
		
		while($RResProd=mysql_fetch_array($ResProd))
			{
					//retira  el producto al almacen
					mysql_query("UPDATE inventario SET ".$RResProd["Almacen"]."=".$RResProd["Almacen"]."-".$RResProd["Cantidad"]." WHERE IdProducto='".$RResProd["Producto"]."'")or die(mysql_error());
					//registra el movimiento al inventario
					mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdNotaCredito, Fecha, Descripcion, Usuario)
																					VALUES ('".$RResProd["Almacen"]."', '".$RResProd["Producto"]."', 'Salida', '".$RResProd["Cantidad"]."',
																									'".$nota."', '".date("Y-m-d")."', 'Salida de mercancia por cancelacion de nota de credito', '".$_SESSION["usuario"]."')");
				
			}
		mysql_query("UPDATE nota_credito SET Status='Cancelada', FechaCancelada='".$horacancelada."', Usuario='".$_SESSION["usuario"]."' WHERE Id='".$nota."'");
		$mensaje='<p class="textomensaje">Se cancelo la Nota de Credito '.$ResNota["NumNota"].' del Cliente '.$ResCliente["Nombre"].'<br />Se actualizo el inventario</p>';
		
		//Cancela la factura
		
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#287d29" align="center" class="texto3">Notas de Credito</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</th>
						</tr>
					 </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function moneda($moneda)
{
	$cadena='Moneda: <select name="moneda" id="moneda" onchange="xajax_moneda(this.value)">
						 		<option value="M.N."'; if($moneda=='M.N.'){$cadena.=' selected';}$cadena.='>M.N.</option>
						 		<option value="USD"'; if($moneda=='USD'){$cadena.=' selected';}$cadena.='>USD</option>
						 	</select>';
	if($moneda=='USD')
	{
		$cadena.=' $ <input type="text" name="tipocambio" id="tipocambio" class="input" size="5" value="0.00">';
	}
	elseif($moneda=='M.N.')
	{
		$cadena.='<input type="hidden" name="tipocambio" id="tipocambio" class="input" size="5" value="0.00">';
	}
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("moneda","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function cancela_pago_cliente($numfolio, $cancela='no')
{
	include ("conexion.php");
	
	if($cancela=='no')
	{
		$mensaje='Esta seguro de cancelar el Folio Num: '.$numfolio.'<br />
							<a href="#" onclick="xajax_cancela_pago_cliente(\''.$numfolio.'\', \'si\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_reporte_pagos_clientes()">No</a>';
	}
	elseif($cancela=='si')
	{
		//cancela el folio
		mysql_query("UPDATE pagos_clientes SET Status='Cancelado' WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumFolio='".$numfolio."'");
		//actualiza el estatus de las facturas
		$ResFactura=mysql_query("SELECT IdFactura FROM pagos_clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND NumFolio='".$numfolio."'");
		while($RResFactura=mysql_fetch_array($ResFactura))
		{
			$ResPagos=mysql_fetch_array(mysql_query("SELECT SUM(Abono) AS Pagado FROM pagos_clientes WHERE IdFactura='".$RResFactura["IdFactura"]."' AND Status='Aplicado'"));
	 		$ResTotalFact=mysql_fetch_array(mysql_query("SELECT NumFactura, Total FROM facturas WHERE Id='".$RResFactura["IdFactura"]."' LIMIT 1"));
	 		if($ResPagos["Pagado"]<=$ResTotalFact["Total"])
	 		{
	 			mysql_query("UPDATE facturas SET Status='Pendiente' WHERE Id='".$RResFactura["IdFactura"]."'")or die(mysql_error());
	 		}
		}
		
		$mensaje='Se cancelo el Folio Num. '.$numfolio;
	}
	
		$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#287d29" align="center" class="texto3">Pagos Clientes</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</th>
						</tr>
					 </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function cobro_agente($form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
							<td colspan="7" aling="left" class="texto3" bgcolor="#7abc7a">Reporte de Cobro Por Agente</td>
							</tr>
							<tr>
								<td colspan="7" aling="left" class="texto" bgcolor="#FFFFFF">
									<form name="freppagos" id="freppagos" method="POST" action="clientes/reporteventasagente.php" target="_blank">
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
?>