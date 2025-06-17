<?php
function agentes()
{
	include ("conexion.php");
	
	$cadena='
    
    <table border="0" align="center">
    <tr>
    <td valign="top" align="center">
    
    
    <table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agentes</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telefono</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$ResAgentes=mysql_query("SELECT * FROM usuarios WHERE Perfil='AgenteV' ORDER BY Nombre ASC");
	$bgcolor="#CCCCCC"; $A=1; $I=1;
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["Nombre"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["Telefono"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["Celular"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["CorreoE"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_editar_agente(\''.$RResAgentes["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
				</tr>';
				
		$A++;
	}
		
    		
	$cadena.='</table>';
    
    
    $cadena.='
    
    </td>
    
    <td valign="top" align="center">

    
    ';
    
    if($_SESSION["sadmon"] == 1)
    {        
        
    $cadena.='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Administradores</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telefono</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Celular</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
                
	$ResAgentes=mysql_query("SELECT * FROM usuarios WHERE Perfil NOT IN ('AgenteV') ORDER BY Nombre ASC"); 
	$bgcolor="#CCCCCC"; $A=1; $I=1;
	while($RResAgentes=mysql_fetch_array($ResAgentes))
	{
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["Nombre"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["Telefono"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["Celular"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResAgentes["CorreoE"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_editar_agente(\''.$RResAgentes["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
				</tr>';
				
		$A++;
	}
				
	$cadena.='
    
    
    </table>
    
    ';
    
    }
            
    
    $cadena.='
                    
    </td>
    
    </tr>
    </table>';
    
    
    



	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function agregar_agente()
{
	include ("conexion.php");
	
	$cadena='<form name="fadagente" id="fadagente">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Agente</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telefono" id="telefono" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celular" id="celular" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correoe" id="correoe" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Usuario: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="user" id="user" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Contraseña: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="pass" id="pass" class="input" size="100"></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="button" name="botadcliente" id="botadcliente" value="Agregar >" class="boton" onclick="xajax_agregar_agente_2(xajax.getFormValues(\'fadagente\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_agente_2($form)
{
	include ("conexion.php");
	
	mysql_query("INSERT InTO usuarios (Username, Contrasena, Nombre, Telefono, Celular, CorreoE, Perfil) VALUES ('".utf8_decode($form["user"])."', '".utf8_decode($form["pass"])."', '".utf8_decode($form["nombre"])."', '".$form["telefoo"]."', '".$form["celular"]."', '".$form["correoe"]."', 'AgenteV')") or die(mysql_error());
	
	$cadena='<p class="textomensaje" align="center">Se agrego el agente satisfactoriamente</p>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function editar_agente($agente)
{
	include ("conexion.php");
	
	$ResUser=mysql_fetch_array(mysql_query("SELECT * FROM usuarios WHERE Id='".$agente."' LIMIT 1"));
	
	$cadena='<form name="feditagente" id="feditagente">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Agente</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="100" value="'.$ResUser["Nombre"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Telefono: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="telefono" id="telefono" class="input" size="100" value="'.$ResUser["Telefono"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Celular: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="celular" id="celular" class="input" size="100" value="'.$ResUser["Celular"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Correo Electr&oacute;nico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="correoe" id="correoe" class="input" size="100" value="'.$ResUser["CorreoE"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Usuario: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="user" id="user" class="input" size="100" value="'.$ResUser["Username"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Contraseña: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="pass" id="pass" class="input" size="100" value="'.$ResUser["Contrasena"].'"></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="hidden" name="iduser" id="iduser" value="'.$ResUser["Id"].'">
						<input type="button" name="botadcliente" id="botadcliente" value="Editar >" class="boton" onclick="xajax_editar_agente_2(xajax.getFormValues(\'feditagente\'))">
					</td>
				</tr>
			</table>
			</form>';
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function editar_agente_2($form)
{
	include ("conexion.php");
	
	mysql_query("UPDATE usuarios SET Username='".$form["user"]."',
									 Contrasena='".$form["pass"]."', 
									 Nombre='".utf8_decode($form["nombre"])."',
									 Telefono='".$form["telefono"]."',
									 Celular='".$form["celular"]."',
									 CorreoE='".$form["correoe"]."'
							WHERE Id='".$form["iduser"]."'") or die(mysql_error());
							
	$cadena='<p align="center" class="textomensaje">Se actualizo el agente satisfactoriamente</p>';
							
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
?>