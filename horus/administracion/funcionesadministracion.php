<?php
function menu_administracion()
{
		$cadena='<ul id="menu">
							<li><a href="#" onclick="xajax_empresas()">Empresas</a></li>
							<li><a href="#" onclick="xajax_usuarios()">Usuarios</a></li>
						</ul>';

  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("menuizq","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function empresas()
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" align="center">
							<tr>	
								<td align="center" class="texto3" bgcolor="#754200">&nbsp;</td>
								<td align="center" class="texto3" bgcolor="#754200">Empresa</td>
								<td align="center" class="texto3" bgcolor="#754200">&nbsp;</td>
							</tr>';
	$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
	$bgcolor="#FFFFFF"; $J=1;
	while($RResEmpresas=mysql_fetch_array($ResEmpresas))
	{
		$cadena.='<tr>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$J.'</td>
								<td align="left" class="texto" bgcolor="'.$bgcolor.'">'.$RResEmpresas["Nombre"].'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">
									<a href="#" onclick="xajax_edit_empresa(\''.$RResEmpresas["Id"].'\')" class="Ntooltip"><img src="images/edit.png" border="0" alt="Edit"><span>Editar Empresa '.$RResEmpresas["Nombre"].'</span></a>
									<a href="#" onclick="xajax_sucursales(\''.$RResEmpresas["Id"].'\')" class="Ntooltip"><img src="images/sucursales.png" border="0" alt="Sucursales"><span>Sucursales '.$RResEmpresas["Nombre"].'</span></a> 
									<img src="images/x.png" border="0" alt="Eliminar"></td>
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
function edit_empresa($empresa, $edit=0)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="2" bgcolor="#754200" class="texto3" align="center">Editar Empresa</th>
							</tr>';
	
	if($edit==0)
	{
		$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE Id='".$empresa."' LIMIT 1");
		$RResEmpresa=mysql_fetch_array($ResEmpresa);
	
	
		$cadena.='<form name="feditempresa" id="feditempresa">
							<tr>
								<td align="left" bgcolor="#ba9464" class="texto">Nombre: </td>
								<td align="left" bgcolor="#ba9464" class="texto"><input type="text" name="nombre" id="nombre" class="input" value="'.$RResEmpresa["Nombre"].'" size="50"></td>
							</tr>
							<tr>
								<th colspan="2" bgcolor="#ba9464" class="texto" align="center"><a href="#" class="button orange" onclick="xajax_edit_empresa(xajax.getFormValues(\'feditempresa\'), \'1\')">Editar>></a></th>
							</tr>
							</form>';
	}
	else if($edit==1)
	{
		if(mysql_query("UPDATE empresas SET Nombre='".utf8_decode($empresa["nombre"])."' WHERE Id='".$empresa["Id"]."'"))
		{
			$mensaje='<p class="textomensaje">Se actualizo la empresa satisfactoriamente</p>';
		}
		else
		{
			$mensaje='<p class="textomensaje">Ocurrio un problema, intente nuevamente</p>';
		}
		
		$cadena.='<tr>
								<th colspan="2" bgcolor="#ba9464">'.$mensaje.'</th>
							</tr>';
	}
	
	$cadena.='</table>';
	
	
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function sucursales($empresa, $modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$ResEmpresa=mysql_query("SELECT Nombre FROM empresas WHERE Id='".$empresa."' LIMIT 1");
	$RResEmpresa=mysql_fetch_array($ResEmpresa);
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="6" bgcolor="#FFFFFF" class="texto" align="right">| <a href="#" style="text-decoration: none; color: #f26822;" onclick="xajax_sucursales(\''.$empresa.'\', \'agregar\')">Agregar Sucursal</a> |</th>
						</tr>
					 	<tr>
							<td colspan="6" bgcolor="#754200" class="texto3" align="center">Sucursales Empresa '.$RResEmpresa["Nombre"].'</td>
						</tr>';
	switch($modo)
	{
		case 'agregar':
			if($accion==NULL)
			{
				$cadena.='<tr>
							<th colspan="6" bgcolor="#ba9464" class="texto" align="center">
								<form name="fadsuc" id="fadsuc">
								<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th colspan="3" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></th>
									</tr>
									<tr>
										<th align="left" class="texto">R.F.C.: </th>
										<th colspan="3" align="left"><input type="text" name="rfc" id="rfc" class="input" size="50"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Calle: </th>
										<th colspan="3" align="left"><input type="text" name="calle" id="calle" class="input" size="50"></th>
									</tr>
									<tr>
										<th align="left" class="texto">No. Exterior: </th>
										<th align="left"><input type="text" name="numexterior" id="numexterior" class="input" size="5"></th>
										<th align="left" class="texto">No. Interior: </th>
										<th align="left"><input type="text" name="numinterior" id="numinterior" class="input" size="5"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Colonia: </th>
										<th align="left"><input type="text" name="colonia" id="colonia" class="input" size="20"></th>
										<th align="left" class="texto">Estado: </th>
										<th align="left"><input type="text" name="estado" id="estado" class="input" size="20"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Municipio: </th>
										<th align="left"><input type="text" name="municipio" id="municipio" class="input" size="20"></th>
										<th align="left" class="texto">Codigo Postal: </th>
										<th align="left"><input type="text" name="codpostal" id="codpostal" class="input" size="20"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Telefono: </th>
										<th align="left"><input type="text" name="telefono1" id="telefono1" class="input" size="20"></th>
										<th align="left" class="texto">Telefono 2: </th>
										<th align="left"><input type="text" name="telefono2" id="telefono2" class="input" size="20"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Correo Electronico: </th>
										<th colspan="3" align="left"><input type="text" name="correoe" id="correor" class="input" size="50"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Pais: </th>
										<th colspan="3" align="left"><input type="text" name="pais" id="pais" class="input" size="50" value="México"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Num. Nota: </th>
										<th colspan="3" align="left"><input type="text" name="nota" id="nota" value="1" class="input"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Iniciar en: </th>
										<th colspan="3" align="left"><select name="iniciar" id="iniciar"><option value="ventadia">Venta del dia</option><option value="notaventa">Nota de Venta</option></select></th>
									</tr>
									<tr>
										<th colspan="4" class="texto" align="center">
											<input type="button" name="botadsuc" id="botadsuc" value="Agregar Sucursal>>" class="boton" onclick="xajax_sucursales(\''.$empresa.'\', \'agregar\', \'1\', xajax.getFormValues(\'fadsuc\'))">
										</th>
									</tr>
								</table>
								</form>
							</th>
							</tr>';
			}
			else if($accion==1)
			{
				if(mysql_query("INSERT INTO sucursales (Empresa, RFC, Nombre, Calle, NoExterior, NoInterior, Colonia, Estado, Localidad, Municipio, CodPostal, Telefono1, Telefono2, CorreoE, Pais, Nota, Serie, Factura, IniciarEn) 
																			  VALUES ('".$empresa."', '".utf8_decode($form["rfc"])."', '".utf8_decode($form["nombre"])."', '".utf8_decode($form["calle"])."', '".$form["numexterior"]."',
																			  			  '".$form["numinterior"]."', '".utf8_decode($form["colonia"])."', '".utf8_decode($form["estado"])."', '".utf8_decode($form["localidad"])."',
																			  			  '".utf8_decode($form["municipio"])."', '".$form["codpostal"]."', '".$form["telefono1"]."', '".$form["telefono2"]."', '".$form["correoe"]."', '".utf8_decode($form["pais"])."', '".$form["nota"]."', '".$form["serie"]."', 
																			  			  '".$form["factura"]."', '".$form["iniciar"]."')"))
				{
					$mensaje="Se agreg&oacute; la sucursal satisfactoriamente";
				}
				else
				{
					$mensaje="Ocurrio un error, por favor intente nuevamente";
				}
				$cadena.='<tr><th colspan="6" bgcolor="#ba9464" class="textomensaje" align="center">'.$mensaje.'</th></tr>';
			}
			break;
		case 'editar':
			if($accion==1)
			{
				$ResSucursal=mysql_query("SELECT * FROM sucursales WHERE Id='".$form."' LIMIT 1");
				$RResSucursal=mysql_fetch_array($ResSucursal);
				
				$cadena.='<tr>
							<th colspan="6" bgcolor="#ba9464" class="texto" align="center">
								<form name="feditsuc" id="feditsuc">
								<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th colspan="3" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.utf8_encode($RResSucursal["Nombre"]).'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">R.F.C.: </th>
										<th colspan="3" align="left"><input type="text" name="rfc" id="rfc" class="input" size="50" value="'.utf8_encode($RResSucursal["RFC"]).'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Calle: </th>
										<th colspan="3" align="left"><input type="text" name="calle" id="calle" class="input" size="50" value="'.utf8_encode($RResSucursal["Calle"]).'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">No. Exterior: </th>
										<th align="left"><input type="text" name="numexterior" id="numexterior" class="input" size="5" value="'.$RResSucursal["NoExterior"].'"></th>
										<th align="left" class="texto">No. Interior: </th>
										<th align="left"><input type="text" name="numinterior" id="numinterior" class="input" size="5" value="'.$RResSucursal["NoInterior"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Colonia: </th>
										<th align="left"><input type="text" name="colonia" id="colonia" class="input" size="20" value="'.utf8_encode($RResSucursal["Colonia"]).'"></th>
										<th align="left" class="texto">Estado: </th>
										<th align="left"><input type="text" name="estado" id="estado" class="input" size="20" value="'.utf8_encode($RResSucursal["Estado"]).'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Municipio: </th>
										<th align="left"><input type="text" name="municipio" id="municipio" class="input" size="20" value="'.utf8_encode($RResSucursal["Municipio"]).'"></th>
										<th align="left" class="texto">Codigo Postal: </td>
										<th align="left"><input type="text" name="codpostal" id="codpostal" class="input" size="20" value="'.utf8_encode($RResSucursal["CodPostal"]).'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Telefono: </th>
										<th align="left"><input type="text" name="telefono1" id="telefono1" class="input" size="20" value="'.$RResSucursal["Telefono1"].'"></th>
										<th align="left" class="texto">Telefono 2: </th>
										<th align="left"><input type="text" name="telefono2" id="telefono2" class="input" size="20" value="'.$RResSucursal["Telefono2"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Correo Electronico: </th>
										<th colspan="3" align="left"><input type="text" name="correoe" id="correor" class="input" size="50" value="'.$RResSucursal["CorreoE"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Pais: </th>
										<th colspan="3" align="left"><input type="text" name="pais" id="pais" class="input" size="50" value="'.utf8_encode($RResSucursal["Pais"]).'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Num. Nota: </th>
										<th align="left"><input type="text" name="nota" id="nota" value="1" class="input" value="'.$RResSucursal["Nota"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Serie: </th>
										<th align="left"><input type="text" name="serie" id="serie" class="input" size="20" value="'.$RResSucursal["Serie"].'"></th>
										<th align="left" class="texto">Factura: </th>
										<th align="left"><input type="text" name="factura" id="factura" class="input" size="20" value="'.$RResSucural["Factura"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Iniciar en: </th>
										<th colspan="3" align="left">
											<select name="iniciar" id="iniciar">
												<option value="ventadia"';if($RResSucursal["IniciarEn"]=='ventadia'){$cadena.=' selected';}$cadena.='>Venta del dia</option>
												<option value="notaventa"';if($RResSucursal["IniciarEn"]=='notaventa'){$cadena.=' selected';}$cadena.='>Nota de Venta</option>
											</select>
										</th>
									</tr>
									<tr>
										<th colspan="4" class="texto" align="center">
											<input type="hidden" name="idsucursal" id="idsucursal" value="'.$form.'">
											<input type="button" name="boteditsuc" id="boteditsuc" value="Editar Sucursal>>" class="boton" onclick="xajax_sucursales(\''.$empresa.'\', \'editar\', \'2\', xajax.getFormValues(\'feditsuc\'))">
										</th>
									</tr>
								</table>
								</form>
							</th>
							</tr>';
			}
			else if($accion==2)
			{
				if(mysql_query("UPDATE sucursales SET RFC='".utf8_decode($form["rfc"])."', 
																							Nombre='".utf8_decode($form["nombre"])."', 
																							Calle='".utf8_decode($form["calle"])."', 
																							NoExterior='".$form["numexterior"]."', 
																							NoInterior='".$form["numinterior"]."', 
																							Colonia='".utf8_decode($form["colonia"])."', 
																							Estado='".utf8_decode($form["estado"])."', 
																							Localidad='".utf8_decode($form["localidad"])."', 
																							Municipio='".utf8_decode($form["municipio"])."', 
																							CodPostal='".$form["codpostal"]."', 
																							Telefono1='".$form["telefono1"]."',
																							Telefono2='".$form["telefono2"]."',
																							CorreoE='".$form["correoe"]."',
																							Pais='".utf8_decode($form["pais"])."', 
																							Nota='".$form["nota"]."', 
																							Serie='".$form["serie"]."', 
																							Factura='".$form["factura"]."',
																							IniciarEn='".$form["iniciar"]."'
																				WHERE Id='".$form["idsucursal"]."'"))
				{
					$mensaje='Se actualizo la sucursal satisfactoriamente';
				}
				else
				{
					$mensaje='Ocurrio un problema, intente nueamente';
				}
				$cadena.='<tr><th colspan="6" bgcolor="#ba9464" class="textomensaje" align="center">'.$mensaje.'</th></tr>';
			}
			break;
		case 'eliminar':
			if($accion==1)
			{
				$ResSucursal=mysql_query("SELECT * FROM sucursales WHERE Id='".$form."' LIMIT 1");
				$RResSucursal=mysql_fetch_array($ResSucursal);
				
				$cadena.='<tr>
							<th colspan="6" bgcolor="#ba9464" class="texto" align="center">
								Desea eliminar la sucursal '.utf8_encode($RResSucursal["Nombre"]).'?<br />
								<a href="#" onclick="xajax_sucursales(\''.$empresa.'\', \'eliminar\', \'2\', \''.$RResSucursal["Id"].'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_sucursales(\''.$empresa.'\')">No</a>
							</th>
							</tr>';
			}
			if($accion==2)
			{
				mysql_query("DELETE FROM sucursales WHERE Id='".$form."' LIMIT 1");
				$cadena.='<tr><th colspan="6" bgcolor="#ba9464" class="textomensaje" align="center">Se elimino la sucursal satisfactoriamente</th></tr>';
			}
			break;
	}
	$cadena.='<tr>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
							<td colspan="3" bgcolor="#754200" align="center" class="texto3">Sucursal</td>
							<td bgcolor="#754200" align="center" class="texto3">Num. Cuenta</td>
							<td bgcolor="#754200" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResSucursales=mysql_query("SELECT Id, Nombre, Nota FROM sucursales WHERE Empresa='".$empresa."' ORDER BY Nombre ASC");
	$bgcolor="#FFFFFF"; $J=1;
	while($RResSucursales=mysql_fetch_array($ResSucursales))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$J.'</th>
								<td colspan="3" bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResSucursales["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResSucursales["Nota"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto">
									<a href="#" onclick="xajax_sucursales(\''.$empresa.'\', \'editar\', \'1\', \''.$RResSucursales["Id"].'\')" class="Ntooltip"><img src="images/edit.png" border="0" alt="Editar"><span>Editar Sucursal '.$RResSucursales["Nombre"].'</span></a> 
									<a href="#" onclick="xajax_sucursales(\''.$empresa.'\', \'eliminar\', \'1\', \''.$RResSucursales["Id"].'\')" class="Ntooltip"><img src="images/x.png" border="0" alt="Eliminar"><span>Eliminar Sucursal '.$RResSucursales["Nombre"].'</span></a>
									<a href="#" onclick="mostrar(\'lightbox\'); xajax_almacenes(\''.$empresa.'\', \''.$RResSucursales["Id"].'\')" class="Ntooltip"><img src="images/almacenes.png" border="0" alt="Almacenes"><span>Almacenes Sucursal '.$RResSucursales["Nombre"].'</span></a>
								</td>
							</tr>	';
		$J++;
		if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
		else if($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function usuarios($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<th colspan="6" class="texto" bgcolor="#FFFFFF" align="right">| <a href="#" style="text-decoration: none; color: #f26822;" onclick="xajax_usuarios(\'agregar\', \'1\')">Agregar Usuario</a> |</th>
							</tr>
							<tr>
								<th colspan="6" class="texto3" bgcolor="#754200" align="center">Usuarios</th>
							</tr>';
	switch($modo)
	{
		case "agregar":
			$cadena.='<tr>
									<th colspan="6" bgcolor="#ba9464" class="texto" align="center">';
			if($accion==1)
			{
				$ResPerfiles=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='Perfiles' ORDER BY Nombre ASC");
				$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
				$cadena.='<form name="faduser" id="faduser"><table border="0" cellpadding="3" cellspacing="0">
										<tr>
											<th class="texto" align="left">Nombre: </th>
											<th class="texto" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Usuario: </th>
											<th class="texto" align="left"><input type="text" name="usuario" id="usuario" class="input"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Contrase&ntilde;a: </th>
											<th class="texto" align="left"><input type="text" name="contrasena" id="contrasena" class="input"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Perfil: </th>
											<th class="texto" align="left"><select name="perfil" id="perfil"><option value="usuario">Seleccione</option>';
				while($RResPerfiles=mysql_fetch_array($ResPerfiles))
				{
					$cadena.='		<option value="'.$RResPerfiles["Nombre"].'">'.$RResPerfiles["Nombre"].'</option>';
				}
				$cadena.='			</select></td>
										</tr>
										<tr>
											<th class="texto" align="left">Empresa: </th>
											<th class="texto" align="left"><select name="empresa" id="empresa" onchange="xajax_sucursal_empresa_ad_usuario(this.value)"><option>Seleccione</option><option value="0">Todas</option>';
				while($RResEmpresas=mysql_fetch_array($ResEmpresas))
				{
					$cadena.='		<option value="'.$RResEmpresas["Id"].'">'.utf8_encode($RResEmpresas["Nombre"]).'</option>';
				}
				$cadena.='			</select></th>
										</tr>
										<tr>
											<th class="texto" align="left">Sucursal: </th>
											<th class="texto" align="left"><div id="sucursal_ad_user"><select name="sucursal" id="sucursal"><option>Seleccione</option></select></div></th>
										</tr>
										<tr>
											<th colspan="2" class="texto" align="center">
												<input type="button" name="botaduser" id="botaduser" value="Agregar Usuario>>" class="boton" onclick="xajax_usuarios(\'agregar\', \'2\', xajax.getFormValues(\'faduser\'))">
											</th>
										</tr>
									</table></form>';
			}
			else if($accion==2)
			{
				if(mysql_query("INSERT INTO usuarios (Nombre, User, Pass, Perfil, Empresa, Sucursal)
																			VALUES ('".utf8_decode($form["nombre"])."', '".utf8_decode($form["usuario"])."',
																							'".$form["contrasena"]."', '".$form["perfil"]."', '".$form["empresa"]."', 
																							'".$form["sucursal"]."')"))
				{
					$cadena.='<p align="center" class="textomensaje">Se agreg&oacute; el usuario satisfactoriamente</p>';
				}
				else
				{
					$cadena.='<p align="center" class="textomensaje">Ocurrio un error, Intente nuevamente <br />'.mysql_error().'</p>';
				}
			}
			$cadena.='</th>
							</tr>';
			break;
		case 'editar':
			$cadena.='<tr>
									<th colspan="6" bgcolor="#ba9464" class="texto" align="center">';
				if($accion==1)
				{
					$ResUsuario=mysql_query("SELECT * FROM usuarios WHERE Id='".$form."' LIMIT 1");
					$RResUsuario=mysql_fetch_array($ResUsuario);
				
					$ResPerfiles=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='Perfiles' ORDER BY Nombre ASC");
					$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
					$cadena.='<form name="fedituser" id="fedituser">
									<table border="0" cellpadding="3" cellspacing="0">
										<tr>
											<th class="texto" align="left">Nombre: </th>
											<th class="texto" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.utf8_encode($RResUsuario["Nombre"]).'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Usuario: </th>
											<th class="texto" align="left"><input type="text" name="usuario" id="usuario" class="input" value="'.utf8_encode($RResUsuario["User"]).'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Contrase&ntilde;a: </th>
											<th class="texto" align="left"><input type="text" name="contrasena" id="contrasena" class="input" value="'.utf8_encode($RResUsuario["Pass"]).'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Perfil: </th>
											<th class="texto" align="left"><select name="perfil" id="perfil"><option>Seleccione</option>';
					while($RResPerfiles=mysql_fetch_array($ResPerfiles))
					{
						$cadena.='		<option value="'.$RResPerfiles["Nombre"].'"'; if($RResUsuario["Perfil"]==$RResPerfiles["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResPerfiles["Nombre"].'</option>';
					}
					$cadena.='			</select></th>
										</tr>
										<tr>
											<th class="texto" align="left">Empresa: </th>
											<th class="texto" align="left"><select name="empresa" id="empresa" onchange="xajax_sucursal_empresa_ad_usuario(this.value)"><option>Seleccione</option><option value="0">Todas</option>';
					while($RResEmpresas=mysql_fetch_array($ResEmpresas))
					{
						$cadena.='		<option value="'.$RResEmpresas["Id"].'"'; if($RResEmpresas["Id"]==$RResUsuario["Empresa"]){$cadena.=' selected';}$cadena.='>'.utf8_encode($RResEmpresas["Nombre"]).'</option>';
					}
					$cadena.='			</select></th>
										</tr>
										<tr>
											<th class="texto" align="left">Sucursal: </th>
											<th class="texto" align="left"><div id="sucursal_ad_user">
												<select name="sucursal" id="sucursal">
													<option>Seleccione</option>';
					$ResSucursales=mysql_query("SELECT * FROM sucursales WHERE Empresa='".$RResUsuario["Empresa"]."' ORDER BY Nombre ASC");
					while($RResSucursales=mysql_fetch_array($ResSucursales))
					{
						$cadena.='			<option value="'.$RResSucursales["Id"].'"'; if($RResSucursales["Id"]==$RResUsuario["Sucursal"]){$cadena.=' selected';}$cadena.='>'.utf8_encode($RResSucursales["Nombre"]).'</option>';
					}
					$cadena.='			</select>
											</div></th>
										</tr>
										<tr>
											<th colspan="2" class="texto" align="center">
												<input type="hidden" name="iduser" id="iduser" value="'.$form.'">
												<input type="button" name="botedituser" id="botedituser" value="Editar Usuario>>" class="boton" onclick="xajax_usuarios(\'editar\', \'2\', xajax.getFormValues(\'fedituser\'))">
											</th>
										</tr>
									</table>
									</form>';
				}
				if($accion==2)
				{
					if(mysql_query("UPDATE usuarios SET Nombre='".utf8_decode($form["nombre"])."', 
																							User='".utf8_decode($form["usuario"])."', 
																							Pass='".utf8_decode($form["contrasena"])."',
																							Perfil='".$form["perfil"]."',
																							Empresa='".$form["empresa"]."',
																							Sucursal='".$form["sucursal"]."'
																				WHERE Id='".$form["iduser"]."'"))
					{
						$cadena.='<p class="textomensaje" align="center">Se actualizo el usuario satisfactoriamente</p>';
					}
					else
					{
						$cadena.='<p class="textomensaje" align="center">Ocurrio un error, intente nuevamente<br />'.mysql_error().'</p>';
					}
				}
				$cadena.='</th></tr>';
			break;
		case 'eliminar':
			$cadena.='<tr>
									<th colspan="6" bgcolor="#ba9464" class="texto" align="center">';
			if($accion==1)
			{
				$ResUsuario=mysql_query("SELECT Nombre FROM usuarios WHERE Id='".$form."' LIMIT 1");
				$RResUsuario=mysql_fetch_array($ResUsuario);
				
				$cadena.='Esta seguro de eliminar el usuario: '.utf8_encode($RResUsuario["Nombre"]).'<br />
									<a href="#" onclick="xajax_usuarios(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_usuarios()">No</a>';
			}
			else if($accion==2)
			{
				if(mysql_query("DELETE FROM usuarios WHERE Id='".$form."' LIMIT 1"))
				{
					$cadena.='<p class="textomensaje">Se elimino el usuario satisfactoriamente</p>';
				}
				else
				{
					$cadena.='<p class="textomensaje">Ocurrio un problema, intente nuevamente</p>';
				}
			}
			$cadena.='</th></tr>';
			break;
	}
	$cadena.='<tr>	
								<td align="center" class="texto3" bgcolor="#754200">&nbsp;</td>
								<td align="center" class="texto3" bgcolor="#754200">Usuario</td>
								<td align="center" class="texto3" bgcolor="#754200">Empresa</td>
								<td align="center" class="texto3" bgcolor="#754200">Sucursal</td>
								<td align="center" class="texto3" bgcolor="#754200">Perfil</td>
								<td align="center" class="texto3" bgcolor="#754200">&nbsp;</td>
							</tr>';
	$ResUsuarios=mysql_query("SELECT * FROM usuarios ORDER BY Nombre ASC");
	$bgcolor="#FFFFFF"; $J=1;
	while($RResUsuarios=mysql_fetch_array($ResUsuarios))
	{
		$RResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$RResUsuarios["Empresa"]."' LIMIT 1"));
		$RResSucursal=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Id='".$RResUsuarios["Sucursal"]."' AND Empresa='".$RResUsuarios["Empresa"]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$J.'</td>
								<td align="left" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResUsuarios["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResEmpresa["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResSucursal["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResUsuarios["Perfil"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">
									<a href="#" onclick="xajax_usuarios(\'editar\', \'1\', \''.$RResUsuarios["Id"].'\')"><img src="images/edit.png" border="0" alt="Editar"></a> 
									<a href="#" onclick="xajax_usuarios(\'eliminar\', \'1\', \''.$RResUsuarios["Id"].'\')"><img src="images/x.png" border="0" alt="Eliminar"></a> 
									<a href="#" onclick="xajax_permisos_usuarios(\''.$RResUsuarios["Id"].'\')"><img src="images/permisos.png" border="0" alt="Permisos"></a></td>
							</tr>';
		$J++;
		if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
		else if($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
	}
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",$cadena);
  return $respuesta;
}
function sucursal_empresa_ad_usuario($empresa)
{
	include("conexion.php");
	
	$cadena.='<select name="sucursal" id="sucursal"><option>Seleccione</option>';
	$ResSucursales=mysql_query("SELECT Id, Nombre FROm sucursales WHERE Empresa='".$empresa."' ORDER BY Nombre ASC");
	while($RResSucursales=mysql_fetch_array($ResSucursales))
	{
		$cadena.='<option value="'.$RResSucursales["Id"].'">'.utf8_encode($RResSucursales["Nombre"]).'</option>';
	}
	$cadena.='</select>';
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("sucursal_ad_user","innerHTML",$cadena);
  return $respuesta;
}
function adfolios($empresa, $sucursal)
{
	$cadena='<iframe src="certificados/importarcertificados.php?empresa='.$empresa.'&sucursal='.$sucursal.'" width="900" height="600" scrolling="no" frameborder="0"></iframe>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function bancos($accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="6" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="xajax_bancos(\'agregar\')">Agregar Cuenta</a> |</th>
						</tr>
						<tr>
							<th colspan="6" bgcolor="#754200" align="center" class="texto3">Bancos</th>
						</tr>';
	switch($accion)
	{
		case 'agregar':
			$cadena.='<tr><th colspan="6" bgcolor="#ba9464" align="center" class="texto">
									<form name="fadbanco" id="fadbanco">
									<table border="0" cellpadding="3" cellspacing="0">
										<tr>
											<td align="left">Banco: </td>
											<td align="left"><input type="text" name="banco" id="banco" class="input" size="25" value="'.$form["banco"].'"  style="text-transform: uppercase"></td>
										</tr>
										<tr>
											<td align="left">Num. Cuenta: </td>
											<td align="left"><input type="text" name="numcuenta" id="numcuenta" class="input" size="25" value="'.$form["numcuenta"].'"></td>
										</tr>
										<tr>
											<td align="left">Empresa: </td>
											<td align="left"><select name="empresa" id="empresa" onChange="xajax_bancos(\'agregar\', xajax.getFormValues(\'fadbanco\'))"><option value="">Seleccione</option>';
			$ResEmpresas=mysql_query("SELECT * FROM empresas ORDER BY Nombre ASC");
			while($RResEmpresas=mysql_fetch_array($ResEmpresas))
			{
				$cadena.='			<option value="'.$RResEmpresas["Id"].'"';if($form["empresa"]==$RResEmpresas["Id"]){$cadena.=' selected';}$cadena.='>'.$RResEmpresas["Nombre"].'</option>';
			}
			$cadena.='			</select></td>
										</tr>
										<tr>
											<td align="left">Sucursal: </td>
											<td align="left"><select name="sucursal" id="sucursal"><option value="">Seleccione</option>';
			$ResSucursal=mysql_Query("SELECT Id, Nombre FROM sucursales WHERE Empresa='".$form["empresa"]."' ORDER BY Nombre ASC");
			while($RResSucursal=mysql_fetch_array($ResSucursal))
			{
				$cadena.='			<option value="'.$RResSucursal["Id"].'">'.$RResSucursal["Nombre"].'</option>';
			}
			$cadena.='			</select></td>
										</tr>
										<tr>
											<th colspan="2" align="center">
											<input type="button" name="botadcuenta" id="botadcuenta" value="Agregar Cuenta>>" class="boton" onclick="xajax_bancos(\'agregar2\', xajax.getFormValues(\'fadbanco\'))">
											</th>
										</tr>
									</table></form>
								</th></tr>';
			break;
		case 'agregar2':
			$cadena.='<tr><th colspan="6" bgcolor="#ba9464" align="center" class="textomensaje">';
			if(mysql_query("INSERT INTO bancos (Banco, NumCuenta, Empresa, Sucursal)
																	VALUES ('".utf8_decode($form["banco"])."', '".$form["numcuenta"]."', '".$form["empresa"]."', '".$form["sucursal"]."')"))
			{
				$cadena.='Se agrego la Cuenta Satisfactoriamente';
			}
			else
			{
				$cadena.='Ocurrio un problema, intentelo nuevamente<br />'.mysql_error();
			}
			break;
	}
	$cadena.='<tr>
							<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
							<td align="center" bgcolor="#754200" class="texto3">Banco</td>
							<td align="center" bgcolor="#754200" class="texto3">Num. Cuenta</td>
							<td align="center" bgcolor="#754200" class="texto3">Empresa</td>
							<td align="center" bgcolor="#754200" class="texto3">Sucursal</td>
							<td align="center" bgcolor="#754200" class="texto3">&nbsp;</td>
						</tr>';
	$ResBancos=mysql_query("SELECT * FROM bancos ORDER BY Banco ASC");
	$J=1; $bgcolor="#7ac37b";
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$ResEmp=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$RResBancos["Empresa"]."' LIMIT 1"));
		$ResSuc=mysql_fetch_array(mysql_query("SELECT Nombre FROm sucursales WHERE Id='".$RResBancos["Sucursal"]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$J.'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto">'.$RResBancos["Banco"].'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto">'.$RResBancos["NumCuenta"].'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto">'.$ResEmp["Nombre"].'</td>
								<td align="left" bgcolor="'.$bgcolor.'" class="texto">'.$ResSuc["Nombre"].'</td>
								<td align="center" bgcolor="'.$bgcolor.'" class="texto"><img src="images/edit.png" border="0"></td>
							</tr>';
	}
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function agentes($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<th colspan="6" class="texto" bgcolor="#FFFFFF" align="right">| <a href="#" style="text-decoration: none; color: #f26822;" onclick="xajax_agentes(\'agregar\', \'1\')">Agregar Agente</a> |</th>
							</tr>
							<tr>
								<th colspan="6" class="texto3" bgcolor="#754200" align="center">Agentes de Venta</th>
							</tr>';
	switch($modo)
	{
		case "agregar":
			$cadena.='<tr>
									<th colspan="6" bgcolor="#ba9464" class="texto" align="center">';
			if($accion==1)
			{
				$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
				$cadena.='<form name="fadagente" id="fadagente"><table border="0" cellpadding="3" cellspacing="0">
										<tr>
											<td class="texto" align="left">Nombre: </td>
											<td class="texto" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></td>
										</tr>
										<tr>
											<td class="texto" align="left">Empresa: </td>
											<td class="texto" align="left"><select name="empresa" id="empresa" onchange="xajax_sucursal_empresa_ad_usuario(this.value)"><option>Seleccione</option><option value="0">Todas</option>';
				while($RResEmpresas=mysql_fetch_array($ResEmpresas))
				{
					$cadena.='		<option value="'.$RResEmpresas["Id"].'">'.utf8_encode($RResEmpresas["Nombre"]).'</option>';
				}
				$cadena.='			</select></td>
										</tr>
										<tr>
											<td class="texto" align="left">Sucursal: </td>
											<td class="texto" align="left"><div id="sucursal_ad_user"><select name="sucursal" id="sucursal"><option>Seleccione</option></select></div></td>
										</tr>
										<tr>
											<th colspan="2" class="texto" align="center">
												<input type="button" name="botadagente" id="botadagente" value="Agregar Agente>>" class="boton" onclick="xajax_agentes(\'agregar\', \'2\', xajax.getFormValues(\'fadagente\'))">
											</th>
										</tr>
									</table></form>';
			}
			else if($accion==2)
			{
				if(mysql_query("INSERT INTO parametros (Nombre, PerteneceA, Empresa, Sucursal)
																			VALUES ('".utf8_decode($form["nombre"])."', 'AgenteV',
																							'".$form["empresa"]."', 
																							'".$form["sucursal"]."')"))
				{
					$cadena.='<p align="center" class="textomensaje">Se agreg&oacute; el Agente satisfactoriamente</p>';
				}
				else
				{
					$cadena.='<p align="center" class="textomensaje">Ocurrio un error, Intente nuevamente <br />'.mysql_error().'</p>';
				}
			}
			$cadena.='</th>
							</tr>';
			break;
		case 'editar':
			$cadena.='<tr>
									<th colspan="6" bgcolor="#ba9464" class="texto" align="center">';
				if($accion==1)
				{
					$ResAgente=mysql_query("SELECT * FROM parametros WHERE Id='".$form."' LIMIT 1");
					$RResAgente=mysql_fetch_array($ResAgente);
				
					$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
					$cadena.='<form name="feditagente" id="feditagente">
									<table border="0" cellpadding="3" cellspacing="0">
										<tr>
											<td class="texto" align="left">Nombre: </td>
											<td class="texto" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.utf8_encode($RResAgente["Nombre"]).'"></td>
										</tr>
										<tr>
											<td class="texto" align="left">Empresa: </td>
											<td class="texto" align="left"><select name="empresa" id="empresa" onchange="xajax_sucursal_empresa_ad_usuario(this.value)"><option>Seleccione</option><option value="0">Todas</option>';
					while($RResEmpresas=mysql_fetch_array($ResEmpresas))
					{
						$cadena.='		<option value="'.$RResEmpresas["Id"].'"'; if($RResEmpresas["Id"]==$RResAgente["Empresa"]){$cadena.=' selected';}$cadena.='>'.utf8_encode($RResEmpresas["Nombre"]).'</option>';
					}
					$cadena.='			</select></td>
										</tr>
										<tr>
											<td class="texto" align="left">Sucursal: </td>
											<td class="texto" align="left"><div id="sucursal_ad_user">
												<select name="sucursal" id="sucursal">
													<option>Seleccione</option>';
					$ResSucursales=mysql_query("SELECT * FROM sucursales WHERE Empresa='".$RResAgente["Empresa"]."' ORDER BY Nombre ASC");
					while($RResSucursales=mysql_fetch_array($ResSucursales))
					{
						$cadena.='			<option value="'.$RResSucursales["Id"].'"'; if($RResSucursales["Id"]==$RResAgente["Sucursal"]){$cadena.=' selected';}$cadena.='>'.utf8_encode($RResSucursales["Nombre"]).'</option>';
					}
					$cadena.='			</select>
											</div></td>
										</tr>
										<tr>
											<th colspan="2" class="texto" align="center">
												<input type="hidden" name="idagente" id="idagente" value="'.$form.'">
												<input type="button" name="boteditagente" id="boteditagente" value="Editar Agente de Venta>>" class="boton" onclick="xajax_agentes(\'editar\', \'2\', xajax.getFormValues(\'feditagente\'))">
											</th>
										</tr>
									</table>
									</form>';
				}
				if($accion==2)
				{
					if(mysql_query("UPDATE parametros SET Nombre='".utf8_decode($form["nombre"])."', 
																							Empresa='".$form["empresa"]."',
																							Sucursal='".$form["sucursal"]."'
																				WHERE Id='".$form["idagente"]."'"))
					{
						$cadena.='<p class="textomensaje" align="center">Se actualizo el Agente satisfactoriamente</p>';
					}
					else
					{
						$cadena.='<p class="textomensaje" align="center">Ocurrio un error, intente nuevamente<br />'.mysql_error().'</p>';
					}
				}
				$cadena.='</th></tr>';
			break;
		case 'eliminar': //cambiamos eliminar por inactivo
			$cadena.='<tr>
									<th colspan="6" bgcolor="#ba9464" class="texto" align="center">';
			if($accion==1)
			{
				$ResAgente=mysql_query("SELECT Nombre FROM parametros WHERE Id='".$form."' LIMIT 1");
				$RResAgente=mysql_fetch_array($ResAgente);
				
				$cadena.='Esta seguro de desactivar el agente: '.utf8_encode($RResAgente["Nombre"]).'<br />
									<a href="#" onclick="xajax_agentes(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_agentes()">No</a>';
			}
			else if($accion==2)
			{
				if(mysql_query("UPDATE parametros SET Descripcion='Inactivo' WHERE Id='".$form."' LIMIT 1"))
				{
					$cadena.='<p class="textomensaje">Se desactivo el Agente satisfactoriamente</p>';
				}
				else
				{
					$cadena.='<p class="textomensaje">Ocurrio un problema, intente nuevamente</p>';
				}
			}
			$cadena.='</th></tr>';
			break;
	}
	$cadena.='<tr>	
								<td align="center" class="texto3" bgcolor="#754200">&nbsp;</td>
								<td align="center" class="texto3" bgcolor="#754200">Agente</td>
								<td align="center" class="texto3" bgcolor="#754200">Empresa</td>
								<td align="center" class="texto3" bgcolor="#754200">Sucursal</td>
								<td align="center" class="texto3" bgcolor="#754200">&nbsp;</td>
							</tr>';
	$ResAgentes=mysql_query("SELECT * FROM parametros WHERE PerteneceA='AgenteV' AND Descripcion!='Inactivo' ORDER BY Nombre ASC");
	$bgcolor="#7ac37b"; $J=1;
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$RResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$RResAgentes["Empresa"]."' LIMIT 1"));
		$RResSucursal=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Id='".$RResAgentes["Sucursal"]."' AND Empresa='".$RResAgentes["Empresa"]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$J.'</td>
								<td align="left" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResAgentes["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResEmpresa["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResSucursal["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_agentes(\'editar\', \'1\', \''.$RResAgentes["Id"].'\')"><img src="images/edit.png" border="0" alt="Editar"></a> <a href="#" onclick="xajax_agentes(\'eliminar\', \'1\', \''.$RResAgentes["Id"].'\')"><img src="images/x.png" border="0" alt="Eliminar"></a></td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		else if($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
	}
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",$cadena);
  return $respuesta;
}
function permisos_usuarios($usuario)
{
	include ("conexion.php");
	
	$ResUsuario=mysql_fetch_array(mysql_query("SELECT Nombre, Permisos FROM usuarios WHERE Id='".$usuario."' LIMIT 1"));
	
	$cadena.='<form name="fpermuser" id="fpermuser">
						<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="4" class="texto3" bgcolor="#754200" align="center" valign="top">Permisos para el Usuario '.$ResUsuario["Nombre"].'</th>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#754200" class="texto3" align="left" valign="top"><input type="checkbox" name="pos" id="pos" value="pos"';if(ereg('pos-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> POS (Venta del Día)</td>
							</tr>
							<tr>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="posnotv" id="posnotv" value="posnotv"';if(ereg('posnotv-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Nota de Venta</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="posfac" id="posfac" value="posfac"';if(ereg('posfac-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Factura</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="poscorc" id="poscorc" value="poscorc"';if(ereg('poscorc-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Corte de Caja</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="posgas" id="posgas" value="posgas"';if(ereg('posgas-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Gastos</td>
							</tr>
							<tr>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="posdebe" id="posdebe" value="posdebe"';if(ereg('posdebe-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='>Debe (pago de adeudos)</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="posrenva" id="posrenva" value="posrenva"';if(ereg('posrenva-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Resumen Notas de Venta</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top" colspan="3"><input type="checkbox" name="posresven" id="posresven" value="posresven"';if(ereg('posresven-',$ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='>Resumen Total de Venta</td>
							</tr>
							
							
							<tr>
								<td colspan="4" bgcolor="#754200" class="texto3" align="left" valign="top"><input type="checkbox" name="prov" id="prov" value="prov"';if(ereg('prov-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Provedores</td>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="provordc" id="provordc" value="provordc"';if(ereg('provordc-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Ordenes de Compra</td>
							</tr>
							
							<tr>
								<td colspan="4" bgcolor="#754200" class="texto3" align="left" valign="top"><input type="checkbox" name="prod" id="prod" value="prod"';if(ereg('prod-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Productos</td>
							</tr>
							
							<tr>
								<td colspan="4" bgcolor="#754200" class="texto3" align="left" valign="top"><input type="checkbox" name="alm" id="alm" value="alm"';if(ereg('alm-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Almacen</td>
							</tr>
							<tr>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="alminvi" id="alminvi" value="alminvi"';if(ereg('alminvi-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Inventario Inicial</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="almajui" id="almajui" value="almajui"';if(ereg('almajui-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Ajustes al Inventario</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="almingm" id="almingm" value="almingm"';if(ereg('almingm-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Ingresar Mercancia / Orden de Compra</td>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="almtram" id="almtram" value="almtram"';if(ereg('almtram-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Traslado de Mercancia</td>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="almrep" id="almrep" value="almrep"';if(ereg('almrep-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Reportes</td>
							</tr>
							
							<tr>
								<td colspan="4" bgcolor="#754200" class="texto3" align="left" valign="top"><input type="checkbox" name="adm" id="adm" value="adm"';if(ereg('adm-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Administrador</td>
							</tr>
							<tr>
								<td bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="admemp" id="admemp" value="admemp"';if(ereg('admemp-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Empresas</td>
								<td colspan="3" bgcolor="#7ac37b" class="texto" align="left" valign="top"><input type="checkbox" name="admusu" id="admusu" value="admusu"';if(ereg('admusu-', $ResUsuario["Permisos"])){$cadena.=' checked';}$cadena.='> Usuarios</td>
							</tr>
							
							<tr>
								<td colspan="8" bgcolor="#7ac37b" class="texto" align="center">
									<input type="hidden" name="idusuario" id="idusuario" value="'.$usuario.'">
									<input type="button" name="botadperuser" id="botadperuser" value="Modificar Permisos>>" class="boton" onclick="xajax_permisos_usuarios2(xajax.getFormValues(\'fpermuser\'))">
								</td>
							</tr>
							
						</table>
					</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function permisos_usuarios2($form)
{
	include ("conexion.php");
	
	$permisos=$form["pos"].'-'.$form["posnotv"].'-'.$form["posfac"].'-'.$form["poscorc"].'-'.$form["posrenva"].'-'.$form["posresven"].'-'.$form["posgas"].'-'.$form["posdebe"].'-';
	$permisos.=$form["prov"].'-'.$form["provordc"].'-'.$form["provrev"].'-'.$form["provcuep"].'-'.$form["provaplp"].'-'.$form["provrepp"].'-'.$form["prod"].'-'.$form["alm"].'-'.$form["alminvi"].'-'.$form["almajui"].'-'.$form["almingm"].'-';
	$permisos.=$form["almtram"].'-'.$form["almrep"].'-'.$form["adm"].'-'.$form["admemp"].'-'.$form["admusu"].'-'.$form["admage"].'-'.$form["admban"].'-'.$form["admtc"].'-'.$form["cancelar"].'-';
	
	mysql_query("UPDATE usuarios SET Permisos='".$permisos."' WHERE Id='".$form["idusuario"]."'")or die(mysql_error());
	
	$cadena.='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="8" class="texto3" bgcolor="#754200" align="center" valign="top">Permisos para el Usuario '.$ResUsuario["Nombre"].'</th>
							</tr>
							<tr>
								<td colspan="8" bgcolor="#754200" class="textomensaje" align="center" valign="top">Se modifico al usuario Satisfactoriamente</td>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function tipo_cambio($tc=NULL)
{
	include ("conexion.php");
	
	$ResTC=mysql_fetch_array(mysql_query("SELECT * FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1"));
	
	if($tc!=NULL AND $ResTC)
	{
		mysql_query("UPDATE tipodecambio SET USD='".$tc["tipocambio"]."'");
		$mensaje='1 Se actualizo el tipo de Cambio';
	}
	elseif($tc!=NULL AND !$ResTC)
	{
		mysql_query("INSERT INTO tipodecambio (Fecha, USD) VALUES ('".date("Y-m-d")."', '".$tc["tipocambio"]."')");
		$mensaje='2 Se actualizo el tipo de Cambio';
	}

	$ResTC=mysql_fetch_array(mysql_query("SELECT * FROM tipodecambio WHERE Fecha='".date("Y-m-d")."' LIMIT 1"));
		
	$cadena.='<form name="ftipocambio" id="ftipocambio">
						<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<th colspan="2" class="texto3" bgcolor="#754200" align="center" valign="top">Tipo de Cambio al dia '.fecha(date("Y-m-d")).'</th>
							</tr>';
	if($mensaje)
	{
		$cadena.='			<tr>
								<th colspan="2" bgcolor="#754200" class="textomensaje" align="center">'.$mensaje.'</th>
							</tr>';
		
	}
	$cadena.='				<tr>
								<td bgcolor="#754200" class="texto" align="left" valign="top">Tipo de Cambio USD: </td>
								<td bgcolor="#754200" class="texto" align="left" valign="top">$ <input type="text" name="tipocambio" id="tipocambio" size="5" class="input" value="'.number_format($ResTC["USD"], 2).'"> Pesos</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#754200" clas="texto" align="center" valign="top"><input type="button" name="bottipocambio" id="bottipocambio" value="Modificar >>" class="boton" onclick="xajax_tipo_cambio(xajax.getFormValues(\'ftipocambio\'))"></td>
							</tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>