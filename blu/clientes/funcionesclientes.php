<?php
function clientes($vendedor='todos')
{
	include ("conexion.php");
	
	$cadena='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="14" bgcolor="#ffffff" align="left" class="texto" style="border:1px solid #FFFFFF">Vendedor: <select name="vendedor" id="vendedor" onchange="xajax_clientes(this.value)">
						<option value="todos"';if($vendedor=='todos'){$cadena.=' selected';}$cadena.='>Todos</option>';
	$ResVendedores=mysql_query("SELECT Id, Nombre FROM usuarios WHERE Perfil='AgenteV' ORDER BY Nombre ASC");
	while($RResVendedores=mysql_fetch_array($ResVendedores))
	{
		$cadena.='		<option value="'.$RResVendedores["Id"].'"';if($vendedor==$RResVendedores["Id"]){$cadena.=' selected';}$cadena.='>'.$RResVendedores["Nombre"].'</option>';
	}
						
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td colspan="14" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Clientes</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Clase</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Due&ntilde;o</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telefono</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Id Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Vendedor</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	if($_SESSION["perfil"]!='AgenteV'){if($vendedor=='todos'){$ResClientes=mysql_query("SELECT * FROM clientes WHERE Juridico='0' ORDER BY Nombre ASC");}else{$ResClientes=mysql_query("SELECT * FROM clientes WHERE Juridico='0' AND Vendedor='".$vendedor."' ORDER BY Nombre ASC");}}
	else{$ResClientes=mysql_query("SELECT * FROM clientes WHERE Juridico='0' AND Vendedor='".$_SESSION["idusuario"]."' ORDER BY Nombre ASC");}
	$bgcolor="#CCCCCC"; $A=1; $I=1;
	while($RResClientes=mysql_fetch_array($ResClientes))
	{	
		$ResVendedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM usuarios WHERE Id='".$RResClientes["Vendedor"]."' LIMIT 1"));
		
		if($RResClientes["Calificacion"]=='MALO' OR $RResClientes["Calificacion"]=='N/I'){$bgcolor='#FFC0CB';}
		else{$bgcolor='#CCCCCC';}
		if($I==31)
		{
			$cadena.='<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Clase</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Due&ntilde;o</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telefono</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Id Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Vendedor</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
			$I=1;
		}
		$cadena.='<tr id="row_'.$A.'" style="background: '.$bgcolor.'">
					<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$A.'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["Nombre"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["Calificacion"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["NombreDueno"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["Telefono"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["Celular"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["CelNextel"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["IdNextel"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResClientes["CorreoE"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$ResVendedor["Nombre"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">';if($_SESSION["perfil"]!='AgenteV' AND $_SESSION["perfil"]!='produccion'){$cadena.='<a href="#" onclick="xajax_editar_cliente(\''.$RResClientes["Id"].'\')"><img src="images/edit.png" border="0"></a>';}$cadena.='
				</tr>';
		$A++; $I++;
		
	}
	$cadena.='</table>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function agregar_cliente()
{
	include ("conexion.php");
	
	$cadena='<form name="fadcliente" id="fadcliente">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Cliente</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre Empresa: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre Due&ntilde;o: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="duenno" id="duenno" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tcliente" id="tcliente" value="T">(T) <input type="radio" name="tcliente" id="tcliente" value="A">(A)</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Marcas: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="marcas" id="marcas" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Direcci&oacute;n Fiscal: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="direccion" id="direccion" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Poblaci&oacute;n: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="poblacion" id="poblacion" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">C.P.: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cp" id="cp" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Zona: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="zona" id="zona">
							<option value="">Seleccione</option>
							<option value="CENTRO (A)">CENTRO (A)</option>
							<option value="CENTRO (B)">CENTRO (B)</option>
							<option value="ORIENTE (A)">ORIENTE (A)</option>
							<option value="ORIENTE (B)">ORIENTE (B)</option>
							<option value="ORIENTE (C)">ORIENTE (C)</option>
							<option value="SUR (A)">SUR (A)</option>
							<option value="SUR (B)">SUR (B)</option>
							<option value="PONIENTE (A)">PONIENTE (A)</option>
							<option value="PONIENTE (B)">PONIENTE (B)</option>
							<option value="NORTE (A)">NORTE (A)</option>
							<option value="NORTE (B)">NORTE (B)</option>
							<option value="SAN MARTIN">SAN MARTIN</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">R.F.C.: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="rfc" id="rfc" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Direcci&oacute;n Entrega: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="direccione" id="direccione" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Transporte: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="transporte" id="transporte" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefonos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telefono" id="telefono" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celular" id="celular" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celnextel" id="celnextel" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Id Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="idnextel" id="idnextel" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correoe" id="correoe" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Pagina Web: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="paginaweb" id="paginaweb" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Vendedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="vendedor" id="vendedor">
							<option value="">Seleccione</option>';
$ResVendedores=mysql_query("SELECT Id, Nombre FROM usuarios WHERE Perfil='AgenteV' ORDER BY Nombre ASC");
while($RResVendedores=mysql_fetch_array($ResVendedores))
{
	$cadena.='				<option value="'.$RResVendedores["Id"].'">'.$RResVendedores["Nombre"].'</option>';
}
$cadena.='				</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Limite de Credito: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="credito" id="credito" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Plazo Otorgado: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="plazoo" id="plazoo">
							<option value="">Seleccione</option>
							<option value="COD">COD</option>
							<option value="30">30</option>
							<option value="60">60</option>
							<option value="90">90</option>
							<option value="CREDITO CANCELADO">CREDITO CANCELADO</option>
						</selec>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Clase: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="calificacion" id="calificacion">
							<option value="">Seleccione</option>
							<option value="AAA">AAA</option>
							<option value="AA">AA</option>
							<option value="A">A</option>
							<option value="MALO">MALO</option>
							<option value="N/I">N/I</option>
						</selec>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Encargado de Compras: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="enccompras" id="enccompras" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Compras: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correocompras" id="correocompras" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Encargado de Pagos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="encpagos" id="encpagos" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Pagos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correopagos" id="correopagos" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono Pagos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telpagos" id="telpagos" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Historial Cliente: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="histcliente" id="histcliente" rows="3" cols="50"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Referencias Comerciales: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="refcomerciales" id="refcomerciales" rows="3" cols="50"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" class="texto" align="center" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="checkbox" name="pancaballero" id="pancaballero" value="1"> Pantalon Caballero
						<input type="checkbox" name="pandama" id="pandama" value="1"> Pantalon Dama
						<input type="checkbox" name="camhombre" id="camhombre" value="1"> Camisa Hombre
						<input type="checkbox" name="bludama" id="bludama" value="1"> Blusa Dama<br />
						<input type="checkbox" name="gabrigida" id="gabrigida" value="1"> Gabardina Rigida
						<input type="checkbox" name="gabstr" id="gabstr" value="1"> Gabardina STR
						<input type="checkbox" name="mezrigida" id="mezrigida" value="1"> Mezclilla Rigida
						<input type="checkbox" name="mezstr" id="mezstr" value="1"> Mezclilla STR
						<input type="checkbox" name="tejcircular" id="tejcircular" value="1"> Tejido Circular
					</td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="button" name="botadcliente" id="botadcliente" value="Agregar >" class="boton" onclick="xajax_agregar_cliente_2(xajax.getFormValues(\'fadcliente\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_cliente_2($cliente)
{
	include ("conexion.php");
	
	mysql_query("INSERT INTO clientes (Nombre, NombreDueno, Marcas, Direccion, CP, Poblacion, RFC, Telefono, Celular, CelNextel, IdNextel, CorreoE, PaginaWeb, Vendedor, PanCaballero, PanDama, CamHombre, BluDama, TejCircular, Credito, Tipo, Zona, DireccionEntrega, Transporte, PlazoOtorgado, Calificacion, EncargadoCompras, CorreoCompras, EncargadoPagos, CorreoPagos, TelPagos, HistorialCliente, ReferenciasComerciales, GabardinaRigida, GabardinaSTR, MezclillaRigida, MezclillaSTR) 
							   VALUES ('".utf8_decode($cliente["nombre"])."',
									   '".utf8_decode($cliente["duenno"])."',
									   '".utf8_decode($cliente["marcas"])."',
									   '".utf8_decode($cliente["direccion"])."',
									   '".$cliente["cp"]."',
									   '".utf8_decode($cliente["poblacion"])."',
									   '".utf8_decode($cliente["rfc"])."',
									   '".$cliente["telefono"]."',
									   '".$cliente["celular"]."',
									   '".$cliente["celnextel"]."',
									   '".$cliente["idnextel"]."',
									   '".$cliente["correoe"]."',
									   '".$cliente["paginaweb"]."',
									   '".utf8_decode($cliente["vendedor"])."',
									   '".$cliente["pancaballero"]."',
									   '".$cliente["pandama"]."',
									   '".$cliente["camhombre"]."',
									   '".$cliente["bludama"]."',
									   '".$cliente["tejcircular"]."',
									   '".$cliente["credito"]."',
									   '".$cliente["tcliente"]."',
									   '".$cliente["zona"]."',
									   '".utf8_decode($cliente["direccione"])."',
									   '".utf8_decode($cliente["transporte"])."',
									   '".$cliente["plazoo"]."',
									   '".$cliente["calificacion"]."',
									   '".utf8_decode($cliente["enccompras"])."',
									   '".$cliente["correocompras"]."',
									   '".utf8_decode($cliente["encpagos"])."',
									   '".$cliente["correopagos"]."',
									   '".$cliente["telpagos"]."',
									   '".utf8_decode($cliente["histcliente"])."',
									   '".utf8_decode($cliente["refcomerciales"])."',
									   '".$cliente["gabrigida"]."',
									   '".$cliente["gabstr"]."',
									   '".$cliente["mezrigida"]."',
									   '".$cliente["mezstr"]."')") or die(mysql_error());
	
	$cadena='<p class="textomensaje" align="center">Se agrego el cliente satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_cliente($cliente)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes  WHERE Id='".$cliente."' LIMIT 1"));
	
	$cadena='<form name="feditcliente" id="feditcliente">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Cliente</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Status: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="status" id="status" class="input">
							<option value="0"';if($ResCliente["Juridico"]==0){$cadena.=' selected';}$cadena.='>Activo</option>
							<option value="1"';if($ResCliente["Juridico"]==1){$cadena.=' selected';}$cadena.='>Juridico</option>
							<option value="2"';if($ResCliente["Juridico"]==2){$cadena.=' selected';}$cadena.='>Historico</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre Empresa: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$ResCliente["Nombre"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre Due&ntilde;o: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="duenno" id="duenno" class="input" size="50" value="'.$ResCliente["NombreDueno"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tcliente" id="tcliente" value="T"';if($ResCliente["Tipo"]=='T'){$cadena.=' checked';}$cadena.='>(T) <input type="radio" name="tcliente" id="tcliente" value="A"';if($ResCliente["Tipo"]=='A'){$cadena.=' checked';}$cadena.='>(A)</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Marcas: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="marcas" id="marcas" class="input" size="50" value="'.$ResCliente["Marcas"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Direcci&oacute;n: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="direccion" id="direccion" class="input" size="100" value="'.$ResCliente["Direccion"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Poblacion </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="poblacion" id="poblacion" class="input" size="50" value="'.$ResCliente["Poblacion"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">C.P.: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cp" id="cp" class="input" size="50" value="'.$ResCliente["CP"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Zona: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="zona" id="zona">
							<option value="">Seleccione</option>
							<option value="CENTRO (A)"';if($ResCliente["Zona"]=='CENTRO (A)'){$cadena.=' selected';}$cadena.='>CENTRO (A)</option>
							<option value="CENTRO (B)"';if($ResCliente["Zona"]=='CENTRO (B)'){$cadena.=' selected';}$cadena.='>CENTRO (B)</option>
							<option value="ORIENTE (A)"';if($ResCliente["Zona"]=='ORIENTE (A)'){$cadena.=' selected';}$cadena.='>ORIENTE (A)</option>
							<option value="ORIENTE (B)"';if($ResCliente["Zona"]=='ORIENTE (B)'){$cadena.=' selected';}$cadena.='>ORIENTE (B)</option>
							<option value="ORIENTE (C)"';if($ResCliente["Zona"]=='ORIENTE (C)'){$cadena.=' selected';}$cadena.='>ORIENTE (C)</option>
							<option value="SUR (A)"';if($ResCliente["Zona"]=='SUR (A)'){$cadena.=' selected';}$cadena.='>SUR (A)</option>
							<option value="SUR (B)"';if($ResCliente["Zona"]=='SUR (B)'){$cadena.=' selected';}$cadena.='>SUR (B)</option>
							<option value="PONIENTE (A)"';if($ResCliente["Zona"]=='PONIENTE (A)'){$cadena.=' selected';}$cadena.='>PONIENTE (A)</option>
							<option value="PONIENTE (B)"';if($ResCliente["Zona"]=='PONIENTE (B)'){$cadena.=' selected';}$cadena.='>PONIENTE (B)</option>
							<option value="NORTE (A)"';if($ResCliente["Zona"]=='NORTE (A)'){$cadena.=' selected';}$cadena.='>NORTE (A)</option>
							<option value="NORTE (B)"';if($ResCliente["Zona"]=='NORTE (B)'){$cadena.=' selected';}$cadena.='>NORTE (B)</option>
							<option value="SAN MARTIN"';if($ResCliente["Zona"]=='SAN MARTIN'){$cadena.=' selected';}$cadena.='>SAN MARTIN</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">R.F.C.: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="rfc" id="rfc" class="input" size="50" value="'.$ResCliente["RFC"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Direcci&oacute;n Entrega: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="direccione" id="direccione" class="input" size="100" value="'.$ResCliente["DireccionEntrega"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Transporte: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="transporte" id="transporte" class="input" size="100" value="'.$ResCliente["Transporte"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telefono" id="telefono" class="input" size="100" value="'.$ResCliente["Telefono"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celular" id="celular" class="input" size="50" value="'.$ResCliente["Celular"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celnextel" id="celnextel" class="input" size="50" value="'.$ResCliente["CelNextel"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Id Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="idnextel" id="idnextel" class="input" size="50" value="'.$ResCliente["IdNextel"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correoe" id="correoe" class="input" size="50" value="'.$ResCliente["CorreoE"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Pagina Web: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="paginaweb" id="paginaweb" class="input" size="50" value="'.$ResCliente["PaginaWeb"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Vendedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="vendedor" id="vendedor">
							<option value="">Seleccione</option>';
$ResVendedores=mysql_query("SELECT Id, Nombre FROM usuarios WHERE Perfil='AgenteV' ORDER BY Nombre ASC");
while($RResVendedores=mysql_fetch_array($ResVendedores))
{
	$cadena.='				<option value="'.$RResVendedores["Id"].'"';if($RResVendedores["Id"]==$ResCliente["Vendedor"]){$cadena.=' selected';}$cadena.='>'.$RResVendedores["Nombre"].'</option>';
}
$cadena.='				</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Credito: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="credito" id="credito" class="input" size="50" value="'.$ResCliente["Credito"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Plazo Otorgado: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="plazoo" id="plazoo">
							<option value="">Seleccione</option>
							<option value="COD"';if($ResCliente["PlazoOtorgado"]=='COD'){$cadena.=' selected';}$cadena.='>COD</option>
							<option value="30"';if($ResCliente["PlazoOtorgado"]=='30'){$cadena.=' selected';}$cadena.='>30</option>
							<option value="60"';if($ResCliente["PlazoOtorgado"]=='60'){$cadena.=' selected';}$cadena.='>60</option>
							<option value="90"';if($ResCliente["PlazoOtorgado"]=='90'){$cadena.=' selected';}$cadena.='>90</option>
							<option value="CREDITO CANCELADO"';if($ResCliente["PlazoOtorgado"]=='CREDITO CANCELADO'){$cadena.=' selected';}$cadena.='>CREDITO CANCELADO</option>
						</selec>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Clase: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="calificacion" id="calificacion">
							<option value="">Seleccione</option>
							<option value="AAA"';if($ResCliente["Calificacion"]=='AAA'){$cadena.=' selected';}$cadena.='>AAA</option>
							<option value="AA"';if($ResCliente["Calificacion"]=='AA'){$cadena.=' selected';}$cadena.='>AA</option>
							<option value="A"';if($ResCliente["Calificacion"]=='A'){$cadena.=' selected';}$cadena.='>A</option>
							<option value="MALO"';if($ResCliente["Calificacion"]=='MALO'){$cadena.=' selected';}$cadena.='>MALO</option>
							<option value="N/I"';if($ResCliente["Calificacion"]=='N/I'){$cadena.=' selected';}$cadena.='>N/I</option>
						</selec>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Encargado de Compras: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="enccompras" id="enccompras" class="input" size="100" value="'.$ResCliente["EncargadoCompras"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Compras: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correocompras" id="correocompras" class="input" size="100" value="'.$ResCliente["CorreoCompras"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Encargado de Pagos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="encpagos" id="encpagos" class="input" size="100" value="'.$ResCliente["EncargadoPagos"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Pagos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correopagos" id="correopagos" class="input" size="100" value="'.$ResCliente["CorreoPagos"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono Pagos: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telpagos" id="telpagos" class="input" size="100" value="'.$ResCliente["TelPagos"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Historial Cliente: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="histcliente" id="histcliente" rows="3" cols="50">'.$ResCliente["HistorialCliente"].'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Referencias Comerciales: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="refcomerciales" id="refcomerciales" rows="3" cols="50">'.$ResCliente["ReferenciasComerciales"].'</textarea></td>
				</tr>
				<tr>
					<td colspan="2" class="texto" align="center" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="checkbox" name="pancaballero" id="pancaballero" value="1"';if($ResCliente["PanCaballero"]==1){$cadena.=' checked';}$cadena.='> Pantalon Caballero
						<input type="checkbox" name="pandama" id="pandama" value="1"';if($ResCliente["PanDama"]==1){$cadena.=' checked';}$cadena.='> Pantalon Dama
						<input type="checkbox" name="camhombre" id="camhombre" value="1"';if($ResCliente["CamHombre"]==1){$cadena.=' checked';}$cadena.='> Camisa Hombre
						<input type="checkbox" name="bludama" id="bludama" value="1"';if($ResCliente["BluDama"]==1){$cadena.=' checked';}$cadena.='> Blusa Dama<br />
						<input type="checkbox" name="gabrigida" id="gabrigida" value="1"';if($ResCliente["GabardinaRigida"]==1){$cadena.=' checked';}$cadena.='> Gabardina Rigida
						<input type="checkbox" name="gabstr" id="gabstr" value="1"';if($ResCliente["GabardinaSTR"]==1){$cadena.=' checked';}$cadena.='> Gabardina STR
						<input type="checkbox" name="mezrigida" id="mezrigida" value="1"';if($ResCliente["MezclillaRigida"]==1){$cadena.=' checked';}$cadena.='> Mezclilla Rigida
						<input type="checkbox" name="mezstr" id="mezstr" value="1"';if($ResCliente["MezclillaSTR"]==1){$cadena.=' checked';}$cadena.='> Mezclilla STR
						<input type="checkbox" name="tejcircular" id="tejcircular" value="1"';if($ResCliente["TejCircular"]==1){$cadena.=' checked';}$cadena.='> Tejido Circular
					</td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="hidden" name="idcliente" id="idcliente" value="'.$ResCliente["Id"].'">
						<input type="button" name="botadcliente" id="botadcliente" value="Editar >" class="boton" onclick="xajax_editar_cliente_2(xajax.getFormValues(\'feditcliente\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_cliente_2($cliente)
{
	include ("conexion.php");
	
	mysql_query("UPDATE clientes SET Nombre='".utf8_decode($cliente["nombre"])."', 
									 NombreDueno='".utf8_decode($cliente["duenno"])."', 
									 Marcas='".utf8_decode($cliente["marcas"])."', 
									 Direccion='".utf8_decode($cliente["direccion"])."',
									 CP='".$cliente["cp"]."',
									 Poblacion='".utf8_decode($cliente["poblacion"])."',
									 RFC='".utf8_decode($cliente["rfc"])."', 
									 Telefono='".$cliente["telefono"]."', 
									 Celular='".$cliente["celular"]."', 
									 CelNextel='".$cliente["celnextel"]."', 
									 IdNextel='".$cliente["idnextel"]."', 
									 CorreoE='".$cliente["correoe"]."', 
									 PaginaWeb='".$cliente["paginaweb"]."',
									 Vendedor='".utf8_decode($cliente["vendedor"])."',
									 PanCaballero='".$cliente["pancaballero"]."',
									 PanDama='".$cliente["pandama"]."',
									 CamHombre='".$cliente["camhombre"]."',
									 BluDama='".$cliente["bludama"]."',
									 TejCircular='".$cliente["tejcircular"]."',
									 Credito='".$cliente["credito"]."',
									 Tipo='".$cliente["tcliente"]."',
									 Zona='".$cliente["zona"]."',
									 DireccionEntrega='".utf8_decode($cliente["direccione"])."',
									 Transporte='".utf8_decode($cliente["transporte"])."',
									 PlazoOtorgado='".$cliente["plazoo"]."',
									 Calificacion='".$cliente["calificacion"]."',
									 EncargadoCompras='".utf8_decode($cliente["enccompras"])."',
									 CorreoCompras='".$cliente["correocompras"]."',
									 EncargadoPagos='".utf8_decode($cliente["encpagos"])."',
									 CorreoPagos='".$cliente["correopagos"]."',
									 TelPagos='".$cliente["telpagos"]."',
									 HistorialCliente='".utf8_decode($cliente["histcliente"])."',
									 ReferenciasComerciales='".utf8_decode($cliente["refcomerciales"])."',
									 GabardinaRigida='".$cliente["gabrigida"]."',
									 GabardinaSTR='".$cliente["gabstr"]."',
									 MezclillaRigida='".$cliente["mezrigida"]."',
									 MezclillaSTR='".$cliente["mezstr"]."',
									 Juridico='".$cliente["status"]."'
							   WHERE Id='".$cliente["idcliente"]."'") or die(mysql_error());
							   
	$cadena='<p align="center" class="textomensaje">Se actualizo el cliente satisfactoriamente</p>';
									  
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function cobranza($accion=NULL, $form=NULL, $vendedor='todos')
{
	include ("conexion.php");
	
	switch($accion)
	{
		case 'sumaaclientes':
			$sumaaclientes=0;
			if($_SESSION["perfil"]!='AgenteV'){$ResSumaAClientes=mysql_query("SELECT Id, Adeudo FROM clientes WHERE Tipo='T' ORDER BY Id ASC");}
			else{$ResSumaAClientes=mysql_query("SELECT Id, Adeudo FROM clientes WHERE Vendedor='".$_SESSION["idusuario"]."' AND Tipo='T' ORDER BY Id ASC");}
			while($RResSumaAClientes=mysql_fetch_array($ResSumaAClientes))
			{
				if($form["acliente_".$RResSumaAClientes["Id"]]==1)
				{
					$RResVencidas=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS ImporteTotal FROM ventas WHERE Cliente='".$RResSumaAClientes["Id"]."' AND Status='VENCIDA'"));
					$RResNoVencidas=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS ImporteTotal FROM ventas WHERE Cliente='".$RResSumaAClientes["Id"]."' AND Status!='VENCIDA' AND Status!='PAGADO'")); //los que no estan vencidos
					
					$sumaaclientes=$sumaaclientes+($RResSumaAClientes["Adeudo"]-$RResNoVencidas["ImporteTotal"]);
				}
			}
			break;
		case 'sumaaclientesa':
			$sumaaclientesa=0;
			if($_SESSION["perfil"]!='AgenteV'){$ResSumaAClientes=mysql_query("SELECT Id, Adeudo FROM clientes WHERE Tipo='A' ORDER BY Id ASC");}
			else{$ResSumaAClientes=mysql_query("SELECT Id, Adeudo FROM clientes WHERE Vendedor='".$_SESSION["idusuario"]."' AND Tipo='A' ORDER BY Id ASC");}
			while($RResSumaAClientes=mysql_fetch_array($ResSumaAClientes))
			{
				if($form["acliente_".$RResSumaAClientes["Id"]]==1)
				{
					$RResVencidas=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS ImporteTotal FROM ventas WHERE Cliente='".$RResSumaAClientes["Id"]."' AND Status='VENCIDA'"));
					$RResNoVencidas=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS ImporteTotal FROM ventas WHERE Cliente='".$RResSumaAClientes["Id"]."' AND Status!='VENCIDA' AND Status!='PAGADO'")); //los que no estan vencidos
					
					$sumaaclientesa=$sumaaclientesa+($RResSumaAClientes["Adeudo"]-$RResNoVencidas["ImporteTotal"]);
				}
			}
			break;
		case 'sumaexistencias':
			$ResTelas=mysql_query("SELECT Id, Existencia FROM telas ORDER BY Id ASC");
			$sumaexistencias=0;
			while($RResTelas=mysql_fetch_array($ResTelas))
			{
				if($form["existencia_".$RResTelas["Id"]]==1)
				{
					$sumaexistencias=$sumaexistencias+$RResTelas["Existencia"];
				}
			}
			break;
	}
	
	// clientes con adeudo T
	$cadena='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="3" align="left" class="texto">
						Vendedor: <select name="vendedor" id="vendedor" onchange="xajax_cobranza(\'\', \'\', this.value)">
							<option value="todos">TODOS</option>';
	if($vendedor=='todos'){$vendedorq='Vendedor LIKE \'%\'';}else{$vendedorq='Vendedor=\''.$vendedor.'\'';}
	if($_SESSION["perfil"]!='AgenteV'){$ResVendedor=mysql_query("SELECT Id, Nombre FROM usuarios WHERE Perfil='AgenteV' ORDER BY Nombre ASC");}
	else{$ResVendedor=mysql_query("SELECT Id, Nombre FROM usuarios WHERE Perfil='AgenteV' AND Id='".$_SESSION["idusuario"]."' ORDER BY Nombre ASC");}
	while($RResVendedor=mysql_fetch_array($ResVendedor))
	{
		$cadena.='			<option value="'.$RResVendedor["Id"].'"';if($RResVendedor["Id"]==$vendedor){$cadena.=' selected';}$cadena.='>'.$RResVendedor["Nombre"].'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td valign="top">';
		$cadena.='		<form name="fsumaaclientest" id="fsumaaclientest">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_cobranza(\'sumaaclientes\', xajax.getFormValues(\'fsumaaclientest\'))">Calcular:</a></td>
									<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
								</tr>
								<tr>
									<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES CON ADEUDO (T)</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaclientest" id="allaclientest" value="1"';if($form["allaclientest"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaavencidas_t()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
								</tr>';
	if($_SESSION["perfil"]!='AgenteV'){$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo, Vencido, DeudaVencida FROM clientes WHERE Juridico='0' AND Tipo='T' AND ".$vendedorq." ORDER BY DeudaVencida DESC");}
	else{$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo, Vencido, DeudaVencida FROM clientes WHERE Juridico='0' AND Vendedor='".$_SESSION["idusuario"]."' AND Tipo='T' ORDER BY DeudaVencida DESC");}
	$A=1; $B=1;
	while($RResClientesA=mysql_fetch_array($ResClientesA))
	{
		if($B==31)
		{
			$cadena.='			<tr>
									<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES CON ADEUDO (T)</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
								</tr>';
				$B=1;
		}
		
		// $ResVentas=mysql_query("SELECT Importe FROM ventas WHERE Cliente='".$RResClientesA["Id"]."' AND Status='VENCIDA'");
		
		// if(mysql_num_rows($ResVentas)!=0)
		// {
			$RResVencidas=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS ImporteTotal FROM ventas WHERE Cliente='".$RResClientesA["Id"]."' AND Status!='VENCIDA' AND Status!='PAGADO'"));
			
			$importe=$RResClientesA["Adeudo"]-$RResVencidas["ImporteTotal"];
			
			$cadena.='				<tr>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="acliente_'.$RResClientesA["Id"].'" id="acliente_'.$RResClientesA["Id"].'" value="1"'; if($form["acliente_".$RResClientesA["Id"]]==1){$cadena.=' checked';}elseif($form["allaclientest"]==0){$cadena.='';}$cadena.='></td>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip"  onclick="xajax_pagos(\''.$RResClientesA["Id"].'\')">'.$RResClientesA["Nombre"].'</a></td>
									<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResClientesA["DeudaVencida"],2).'</td>
								</tr>';
			$A++; $B++;
		// }
		
		
	}
	$cadena.='					<tr>
									<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_cobranza(\'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
									<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
								</tr>
							</table>
						</form>
					</td>';
	
	//clientes con adeudo A
	$cadena.='<td valign="top">';
		$cadena.='		<form name="fsumaaclientes" id="fsumaaclientes">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_cobranza(\'sumaaclientesa\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
									<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientesa>0){$cadena.='$ '.number_format($sumaaclientesa, 2);}$cadena.='</td>
								</tr>
								<tr>
									<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES CON ADEUDO (A)</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaclientes" id="allaclientes" value="1"';if($form["allaclientes"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaclientes()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
								</tr>';
	if($_SESSION["perfil"]!='AgenteV'){$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo, Vencido, DeudaVencida FROM clientes WHERE Juridico='0' AND Tipo='A' AND ".$vendedorq." ORDER BY DeudaVencida DESC");}
	else{$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo, Vencido, DeudaVencida FROM clientes WHERE Juridico='0' AND Vendedor='".$_SESSION["idusuario"]."' AND Tipo='A' ORDER BY DeudaVencida DESC");}
	$A=1; $B=1;
	while($RResClientesA=mysql_fetch_array($ResClientesA))
	{
		if($B==31)
		{
			$cadena.='			<tr>
									<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES CON ADEUDO (A)</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
								</tr>';
				$B=1;
		}
		
		// $ResVentas=mysql_query("SELECT Importe FROM ventas WHERE Cliente='".$RResClientesA["Id"]."' AND Status='VENCIDA'");
		
		// if(mysql_num_rows($ResVentas)!=0)
		//{
			$RResVencidas=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS ImporteTotal FROM ventas WHERE Cliente='".$RResClientesA["Id"]."' AND Status!='VENCIDA' AND Status!='PAGADO'"));
			
			$importe=$RResClientesA["Adeudo"]-$RResVencidas["ImporteTotal"];
			
			$cadena.='				<tr>
										<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="acliente_'.$RResClientesA["Id"].'" id="acliente_'.$RResClientesA["Id"].'" value="1"'; if($form["acliente_".$RResClientesA["Id"]]==1){$cadena.=' checked';}elseif($form["allaclientes"]==0){$cadena.='';}$cadena.='></td>
										<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
										<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip"  onclick="xajax_pagos(\''.$RResClientesA["Id"].'\')">'.$RResClientesA["Nombre"].'</a></td>
										<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResClientesA["DeudaVencida"],2).'</td>
									</tr>';
				$A++; $B++;
		// }
	}
	$cadena.='					<tr>
									<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_cobranza(\'sumaaclientesa\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
									<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientesa>0){$cadena.='$ '.number_format($sumaaclientesa, 2);}$cadena.='</td>
								</tr>
							</table>
						</form>
					</td>
					<td valign="top">';
					
	//existencias
	$cadena.='			<form name="fsumaaexistencias" id="fsumaaexistencias">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="4" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_cobranza(\'sumaexistencias\', xajax.getFormValues(\'fsumaaexistencias\'))">Calcular: </a></td>
									<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaexistencias!=0){$cadena.=number_format($sumaexistencias,0);}$cadena.='</td>
								</tr>
								<tr>
									<td colspan="5" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">EXISTENCIA TELAS</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allexistencias" id="allexistencias" value="1"';if($form["allexistencias"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaexistencias()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">EXISTENCIA</td>
								</tr>';
	$A=1;
	$ResTelas=mysql_query("SELECT Id, Nombre, Color, Existencia, Importe FROM telas WHERE Existencia>0 AND Importe>0 ORDER BY Nombre ASC");
	while($RResTelas=mysql_fetch_array($ResTelas))
	{
		$cadena.='				<tr>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="existencia_'.$RResTelas["Id"].'" id="existencia_'.$RResTelas["Id"].'" value="1"';if($form["existencia_".$RResTelas["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="';if($_SESSION["perfil"]!='AgenteV'){$cadena.='xajax_existencias(\''.$RResTelas["Id"].'\')';}$cadena.='" class="Ntooltip">'.$RResTelas["Nombre"].'</a></td>
									<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResTelas["Color"].'</td>
									<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($RResTelas["Existencia"],0).'</td>
								</tr>';
		$A++;
	}
	$cadena.='					<tr>
									<td colspan="4" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_cobranza(\'sumaexistencias\', xajax.getFormValues(\'fsumaaexistencias\'))">Calcular: </a></td>
									<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaexistencias!=0){$cadena.=number_format($sumaexistencias,0);}$cadena.='</td>
								</tr>
							</table>
						</form>
					</td>
				</table>';
					
	
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;		
}
?>