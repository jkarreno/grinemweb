<?php
function provedores()
{
	include ("conexion.php");
	
	$cadena='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="9" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Provedores</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Due&ntilde;o</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telefono</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Cel. Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Id. Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$ResProvedores=mysql_query("SELECT * FROM provedores WHERE Status='0' ORDER BY Nombre ASC");
	$bgcolor="#CCCCCC"; $A=1; $I=1;
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{	
		if($I==31)
		{
			$cadena.='<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Due&ntilde;o</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telefono</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Cel. Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Id. Nextel</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
				$I=1;
		}
        
        if($RResProvedores["CheckEdicion"] == 0)
        {
            $bgcolor = "#A9A9A9"; //oscuro
        }
        
                                                                                                                                                                                    ///  \'#CCCCCC\'
		$cadena.='<tr id="row_'.$A.'" style="background: '.$bgcolor.'">                           
					<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$A.'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["Nombre"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["Dueno"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["Telefono"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["Celular"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["CelNextel"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["IdNextel"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResProvedores["CorreoE"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'"><a href="#" onclick="xajax_edita_provedor(\''.$RResProvedores["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
				</tr>';
		$A++;
	}
	$cadena.='</table>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function agregar_provedor()
{
	include ("conexion.php");
	
	$cadena='<form name="fadprovedor" id="fadprovedor">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Provedor</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre Due&ntilde;o: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="duenno" id="duenno" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Direcci&oacute;n Fiscal: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="direccion" id="direccion" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Poblacion: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="poblacion" id="poblacion" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">C.P.: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cp" id="cp" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">RFC: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="rfc" id="rfc" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telefono" id="telefono" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celular" id="celular" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cel. Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celnextel" id="celnextel" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Id. Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="idnextel" id="idnextel" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Eletr&oacute;nico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correoe" id="correoe" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Pagina Web: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="paginaweb" id="paginaweb" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Limite de Credito: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="credito" id="credito" class="input" size="50"></td>
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
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Representante: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="representante" id="representante" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Representante: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correorepresentante" id="correorepresentante" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Encargado de Cobros: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="enccobros" id="enccobros" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo de Cobros: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correocobros" id="correocobros" class="input" size="50"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="button" name="botadprovedor" id="botadprovedor" value="Agregar >" class="boton" onclick="xajax_agregar_provedor_2(xajax.getFormValues(\'fadprovedor\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_provedor_2($provedor)
{
	include ("conexion.php");
	
	mysql_query("INSERT INTO provedores (Nombre, Dueno, Direccion, CP, Poblacion, RFC, Telefono, Celular, CelNextel, IdNextel, CorreoE, PaginaWeb, Credito, PlazoOtorgado, Representante, CorreoRepresentante, EncCobros, CorreoCobros, Comentarios) 
							     VALUES ('".utf8_decode($provedor["nombre"])."',
										 '".utf8_decode($provedor["duenno"])."',
										 '".utf8_decode($provedor["direccion"])."',
										 '".$povedor["cp"]."',
										 '".utf8_decode($provedor["poblacion"])."',
										 '".utf8_decode($provedor["rfc"])."',
										 '".$provedor["telefono"]."',
										 '".$provedor["celular"]."',
										 '".$provedor["celnextel"]."',
										 '".$provedor["idnextel"]."',
										 '".$provedor["correoe"]."',
										 '".$provedor["paginaweb"]."',
										 '".$provedor["credito"]."',
										 '".$provedor["plazoo"]."',
										 '".utf8_decode($provedor["representante"])."',
										 '".$provedor["correorepresentante"]."',
										 '".utf8_decode($provedor["enccobros"])."',
										 '".$provedor["correocobros"]."',
										 '".utf8_decode($provedor["comentarios"])."')") or die(mysql_error());
	
	$cadena='<p class="textomensaje" align="center">Se agrego el provedor satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function edita_provedor($provedor)
{
	include ("conexion.php");
	
	$ResProv=mysql_fetch_array(mysql_query("SELECT * FROM provedores WHERE Id='".$provedor."' LIMIT 1"));
	
	$cadena='<form name="feditprovedor" id="feditprovedor">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Provedor</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Status: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="status" id="status" class="input">
							<option value="0"';if($ResProv["Status"]==0){$cadena.=' selected';}$cadena.='>Activo</option>
							<option value="2"';if($ResProv["Status"]==2){$cadena.=' selected';}$cadena.='>Historico</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$ResProv["Nombre"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Due&ntilde;o: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="duenno" id="duenno" class="input" size="50" value="'.$ResProv["Dueno"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Direcci&oacute;n: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="direccion" id="direccion" class="input" size="100" value="'.$ResProv["Direccion"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Poblacion: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="poblacion" id="poblacion" class="input" size="100" value="'.$ResProv["Poblacion"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">C.P.: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cp" id="cp" class="input" size="100" value="'.$ResProv["CP"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">RFC: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="rfc" id="rfc" class="input" size="50" value="'.$ResProv["RFC"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telefono" id="telefono" class="input" size="100" value="'.$ResProv["Telefono"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celular" id="celular" class="input" size="50" value="'.$ResProv["Celular"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cel. Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celnextel" id="celnextel" class="input" size="50" value="'.$ResProv["CelNextel"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Id. Nextel: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="idnextel" id="idnextel" class="input" size="50" value="'.$ResProv["IdNextel"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Eletr&oacute;nico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correoe" id="correoe" class="input" size="50" value="'.$ResProv["CorreoE"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Pagina Web: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="paginaweb" id="paginaweb" class="input" size="50" value="'.$ResProv["PaginaWeb"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Limite de Credito: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="credito" id="credito" class="input" size="50" value="'.$ResProv["Credito"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Plazo Otorgado: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="plazoo" id="plazoo">
							<option value="">Seleccione</option>
							<option value="COD"';if($ResProv["PlazoOtorgado"]=='COD'){$cadena.=' selected';}$cadena.='>COD</option>
							<option value="30"';if($ResProv["PlazoOtorgado"]=='30'){$cadena.=' selected';}$cadena.='>30</option>
							<option value="60"';if($ResProv["PlazoOtorgado"]=='60'){$cadena.=' selected';}$cadena.='>60</option>
							<option value="90"';if($ResProv["PlazoOtorgado"]=='90'){$cadena.=' selected';}$cadena.='>90</option>
							<option value="CREDITO CANCELADO"';if($ResProv["PlazoOtorgado"]=='CREDITO CANCELADO'){$cadena.=' selected';}$cadena.='>CREDITO CANCELADO</option>
						</selec>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Representante: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="representante" id="representante" class="input" size="50" value="'.$ResProv["Representante"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Representante: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correorepresentante" id="correorepresentante" class="input" size="50" value="'.$ResProv["CorreoRepresentante"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Encargado de Cobros: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="enccobros" id="enccobros" class="input" size="50" value="'.$ResProv["EncCobros"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo de Cobros: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correocobros" id="correocobros" class="input" size="50" value="'.$ResProv["CorreoCobros"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResProv["Comentarios"].'</textarea></td>
				</tr>';
                
        if($RResProvedores["CheckEdicion"] == 0)
        {
            
            if($_SESSION["sadmon"] == 1)
            {
                
                $cadena.='
                
				<tr>
					<td colspan="2" class="texto" align="center" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="checkbox" name="editor" id="editor" value="1"';if($ResProv["CheckEdicion"]==1){$cadena.=' checked';}$cadena.='> Check
					</td>
				</tr>';
                
                
                $cadena.='
                
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="hidden" name="idprovedor" id="idprovedor" value="'.$ResProv["Id"].'">
						<input type="button" name="boteditprovedor" id="boteditprovedor" value="Editar >" class="boton" onclick="xajax_editar_provedor_2(xajax.getFormValues(\'feditprovedor\'))">
					</td>
				</tr> ';
                
            }
 
                
        }
        
                
                
            $cadena.='    

			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_provedor_2($provedor)
{
	include ("conexion.php");
	
	mysql_query("UPDATE provedores SET Nombre='".utf8_decode($provedor["nombre"])."', 
									   Dueno='".utf8_decode($provedor["duenno"])."', 
									   Direccion='".utf8_decode($provedor["direccion"])."', 
									   CP='".$provedor["cp"]."',
									   Poblacion='".utf8_decode($provedor["poblacion"])."',
									   RFC='".utf8_decode($provedor["rfc"])."', 
									   Telefono='".$provedor["telefono"]."', 
									   Celular='".$provedor["celular"]."', 
									   CelNextel='".$provedor["celnextel"]."', 
									   IdNextel='".$provedor["idnextel"]."', 
									   CorreoE='".$provedor["correoe"]."',
									   PaginaWeb='".$provedor["paginaweb"]."',
									   Credito='".$provedor["credito"]."',
									   PlazoOtorgado='".$provedor["plazoo"]."',
									   Representante='".utf8_decode($provedor["representante"])."',
									   CorreoRepresentante='".$provedor["correorepresentante"]."',
									   EncCobros='".utf8_decode($provedor["enccobros"])."',
									   CorreoCobros='".$provedor["correocobros"]."',
									   Comentarios='".utf8_decode($provedor["comentarios"])."',
									   Status='".$provedor["status"]."',
                                       CheckEdicion='".$provedor["editor"]."'
							    WHERE Id='".$provedor["idprovedor"]."'") or die(mysql_error());
	
	$cadena='<p class="textomensaje" align="center">Se actualizo el provedor satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}

?>