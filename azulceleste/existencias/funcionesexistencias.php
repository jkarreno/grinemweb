<?php
function telas($nombretela)
{
	include ("conexion.php");
	
	$cadena='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
    
    
				<tr>
					<td colspan="14" bgcolor="#ffffff" align="left" class="texto" style="border:1px solid #FFFFFF">
                    
                    
					
                    Descripcion de la tela: <input type="text" id="nombretela" name="nombretela" class="texto" value="'.$nombretela.'">
                    
                    <a href="#" onclick="xajax_telas(document.getElementById(\'nombretela\').value)"/>Buscar</a>

                    

				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | <a href="#" onclick="xajax_agregar_tela()">Agregar Tela</a> | 
                    

                    
                    </td>
                    
				</tr>
                
                
				<tr>
					<td colspan="11" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Telas</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Precio Costo</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Precio Venta</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Color</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Composici&oacute;n</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Ancho</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Peso</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Tipo de tela</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Provedor</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$ResTelas=mysql_query("SELECT * FROM telas WHERE Status='0' AND Nombre LIKE '%".$nombretela."%'  ORDER BY Nombre ASC");
	$A=1; $T=1; $bgcolor="#CCCCCC";
	while($RResTelas=mysql_fetch_array($ResTelas))
	{
		if($T==30)
		{
			$cadena.='<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Precio Costo</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Precio Venta</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Color</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Composici&oacute;n</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Ancho</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Peso</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Tipo de tela</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Provedor</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
				$T==1;
		}
		$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResTelas["Provedor"]."' LIMIT 1"));
		$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResTelas["TipoTela"]."' LIMIT 1"));
		
		$cadena.='<tr id="row_'.$A.'" style="background: '.$bgcolor.'">
					<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$A.'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResTelas["Nombre"].'</td>
					<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResTelas["Precio"], 2).'</td>
					<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResTelas["Venta"], 2).'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResTelas["Color"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResTelas["Composicion"].'</td>
					<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResTelas["Ancho"].'</td>
					<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResTelas["Peso"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$ResTipoTela["Nombre"].'</td>
					<td align="left" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$ResProvedor["Nombre"].'</td>
					<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'"><a href="#" onclick="xajax_editar_tela(\''.$RResTelas["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
				</tr>';
		$A++; $T++;
	}
	
				
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_tela()
{
	include ("conexion.php");
	
	
	$cadena='<form name="fadtela" id="fadtela">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Tela</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Color: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="color" id="color" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Costo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="precio" id="precio" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Composici&oacute;n: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="composicion" id="composicion" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Ancho: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="ancho" id="ancho" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Onzas: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="peso" id="peso" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="tipo" id="tipo">';
	$ResTipoTelas=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='TipoTela' ORDER BY Nombre ASC");
	while($RResTipoTelas=mysql_fetch_array($ResTipoTelas))
	{
		$cadena.='<option value="'.$RResTipoTelas["Id"].'">'.$RResTipoTelas["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="provedor" id="provedor">
						<option value="0">Seleccione</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'">'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadtela" id="botadtela" value="Agregar>>" class="boton" onclick="xajax_agregar_tela_2(xajax.getFormValues(\'fadtela\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_tela_2($form)
{
	include ("conexion.php");
	
	mysql_query("INSERT INTO telas (Nombre, Precio, Venta, Color, Composicion, Ancho, Peso, TipoTela, Provedor, Comentarios)
							VALUES ('".utf8_decode($form["nombre"])."',
									'".$form["precio"]."',
									'".$form["venta"]."',
									'".$form["color"]."',
									'".utf8_decode($form["composicion"])."',
									'".$form["ancho"]."',
									'".$form["peso"]."',
									'".$form["tipo"]."',
									'".$form["provedor"]."',
									'".utf8_decode($form["comentarios"])."')")or die(mysql_error());
									
	$cadena='<p align="center" class="textomensaje">Se agrego la tela satisfactoriamente</p>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_tela($tela)
{
	include ("conexion.php");
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	
	$cadena='<form name="fedittela" id="fedittela">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Tela</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Status: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="status" id="status" class="input">
							<option value="0"';if($ResTela["Status"]==0){$cadena.=' selected';}$cadena.='">Activo</option>
							<option value="2"';if($ResTela["Status"]==2){$cadena.=' selected';}$cadena.='">Historico</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" size="100" value="'.$ResTela["Nombre"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Color: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="color" id="color" class="input" size="100" value="'.$ResTela["Color"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Costo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="precio" id="precio" class="input" value="'.$ResTela["Precio"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResTela["Venta"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Composici&oacute;n: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="composicion" id="composicion" class="input" size="100" value="'.$ResTela["Composicion"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Ancho: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="ancho" id="ancho" class="input" value="'.$ResTela["Ancho"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Onzas: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="peso" id="peso" class="input" value="'.$ResTela["Peso"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="tipo" id="tipo">';
	$ResTipoTelas=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='TipoTela' ORDER BY Nombre ASC");
	while($RResTipoTelas=mysql_fetch_array($ResTipoTelas))
	{
		$cadena.='<option value="'.$RResTipoTelas["Id"].'"';if($ResTela["TipoTela"]==$RResTipoTelas["Id"]){$cadena.=' selected';}$cadena.='>'.$RResTipoTelas["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="provedor" id="provedor">
						<option value="0">Seleccione</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'"';if($ResTela["Provedor"]==$RResProvedores["Id"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResTela["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idtela" id="idtela" value="'.$ResTela["Id"].'">
						<input type="button" name="botedittela" id="botedittela" value="Editar>>" class="boton" onclick="xajax_editar_tela_2(xajax.getFormValues(\'fedittela\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_tela_2($form)
{
	include ("conexion.php");
	
	mysql_query("UPDATE telas SET Nombre='".utf8_decode($form["nombre"])."', 
								  Precio='".$form["precio"]."', 
								  Venta='".$form["venta"]."', 
								  Color='".$form["color"]."', 
								  Composicion='".utf8_decode($form["composicion"])."', 
								  Ancho='".$form["ancho"]."', 
								  Peso='".$form["peso"]."', 
								  TipoTela='".$form["tipo"]."', 
								  Provedor='".$form["provedor"]."',
								  Comentarios='".utf8_decode($form["comentarios"])."',
								  Status='".$form["status"]."'
							WHERE Id='".$form["idtela"]."'")or die(mysql_error());
							
	$cadena='<p align="center" class="textomensaje">Se actualizo la tela satisfactoriamente</p>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function existencias($tela, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	switch($accion)
	{	
		//Agregamos venta
		case 'adventa':
			mysql_query("INSERT INTO existencias (Fecha, Tipo, Tela, Precio, Cliente, Cantidad, Importe, Comentarios, checka)
										  VALUES ('".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
												  '".$form["tipo"]."',
												  '".$form["tela"]."',
												  '".$form["venta"]."',
												  '".$form["cliente"]."',
												  '".$form["cantidad"]."',
												  '".$form["importe"]."',
												  '".nl2br(utf8_decode($form["comentarios"]), false)."',
												  '".$form["checka"]."')") or die(mysql_error());
		break;
		//editar venta
		case 'editventa':
			mysql_query("UPDATE existencias SET Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
												Tipo='".$form["tipo"]."', 
												Tela='".$form["tela"]."', 
												Precio='".$form["venta"]."', 
												Cliente='".$form["cliente"]."',
												Cantidad='".$form["cantidad"]."', 
												Importe='".$form["importe"]."', 
												Comentarios='".utf8_decode($form["comentarios"])."', 
												checka='".$form["checka"]."',
												Historico='".$form["historico"]."',
												AnnoHistorico='".$form["annohistorico"]."'
										  WHERE Id='".$form["idventa"]."'") or die(mysql_error());
			break;
		//agregar compra
		case 'adcompra':
			mysql_query("INSERT INTO existencias (Fecha, Tipo, Tela, Precio, Cantidad, Importe, Comentarios, checka)
										  VALUES ('".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
												  '".$form["tipo"]."',
												  '".$form["tela"]."',
												  '".$form["venta"]."',
												  '".$form["cantidad"]."',
												  '".$form["importe"]."',
												  '".nl2br(utf8_decode($form["comentarios"]), false)."',
												  '".$form["checka"]."')") or die(mysql_error());
			break;
		//editar Compra
		case 'editcompra':
			mysql_query("UPDATE existencias SET Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
												Tipo='".$form["tipo"]."', 
												Tela='".$form["tela"]."', 
												Precio='".$form["venta"]."', 
												Cantidad='".$form["cantidad"]."', 
												Importe='".$form["importe"]."', 
												Comentarios='".nl2br(utf8_decode($form["comentarios"]), false)."', 
												checka='".$form["checka"]."',
												Historico='".$form["historico"]."',
												AnnoHistorico='".$form["annohistorico"]."'
										  WHERE Id='".$form["idcompra"]."'") or die(mysql_error());
			break;
		case 'calculasaldo':
			$importe=($form["existencias"]*$form["precio"])*1.16;
			mysql_query("UPDATE telas SET Precio2='".$form["precio"]."', 
										  Importe='".$importe."', 
									      Existencia='".$form["existencias"]."' 
								    WHERE Id='".$tela."'")or die(mysql_error());
			break;
		case 'sumalascompras':
			$sumalascompras=0;
			$ResImportes=mysql_query("SELECT * FROM existencias WHERE Tela='".$tela."' AND (Tipo LIKE 'Compra' OR Tipo LIKE 'Devolucion') ORDER BY Id ASC");
			while($RResImportes=mysql_fetch_array($ResImportes))
			{
				if($form["check_".$RResImportes["Id"]]==1)
				{
					$sumalascompras=$sumalascompras+$RResImportes["Importe"];
				}
				
			}
			break;
		case 'sumalasventas':
			$sumalasventas=0; $check='';
			$ResImportes=mysql_query("SELECT * FROM existencias WHERE Tela='".$tela."' AND Tipo LIKE 'Venta' ORDER BY Id ASC");
			while($RResImportes=mysql_fetch_array($ResImportes))
			{
				if($form["check_".$RResImportes["Id"]]==1)
				{
					$sumalasventas=$sumalasventas+$RResImportes["Importe"];
				}
				
			}
			break;
	}
	
	$cadena='<p align="center" class="texto">Cliente: <select name="cliente" id="cliente" onchange="xajax_pagos(this.value)"><option>Seleccione</option>';
	$ResCliente=mysql_query("SELECT * FROM clientes ORDER BY Nombre ASC");
	while($RResCliente=mysql_fetch_array($ResCliente))
	{
		$cadena.='<option value="'.$RResCliente["Id"].'">'.$RResCliente["Nombre"].'</option>';
	}
	$cadena.='</select> <img src="images/impresora.jpg" border="0"> Provedor: <select name="provedor" id="provedor" onchange="xajax_pagos_provedor(this.value)"><option>Seleccione</option>';
	$ResProvedor=mysql_query("SELECT Id, Nombre FROM provedores  ORDER BY Nombre ASC");
	while($RResProvedor=mysql_fetch_array($ResProvedor))
	{
		$cadena.='<option value="'.$RResProvedor["Id"].'">'.$RResProvedor["Nombre"].'</option>';
	}
	$cadena.='</select><img src="images/impresora.jpg" border="0"> Tela: <select name="telas" id="telas" onchange="xajax_existencias(this.value)"><option>Seleccione</option>';
	$ResTelas=mysql_query("SELECT Id, Nombre FROM telas ORDER BY Nombre ASC");
	while($RResTelas=mysql_fetch_array($ResTelas))
	{
		$cadena.='<option value="'.$RResTelas["Id"].'"';if($RResTelas["Id"]==$tela){$cadena.=' selected';}$cadena.='>'.$RResTelas["Nombre"].'</option>';
	}
	$cadena.='</select> </p>';
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResTela["TipoTela"]."'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$ResTela["Provedor"]."'"));
	
	$cadena.='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="12" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Tela</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Color</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Precio Costo</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Precio Venta</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Composicion</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Ancho</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Onzas</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Tipo de Tela</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Provedor</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="left" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Nombre"].'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($ResTela["Precio"], 2).'</td>
					<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($ResTela["Venta"], 2).'</td>
					<td bgcolor="#CCCCCC" align="left" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Composicion"].'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Ancho"].'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Peso"].'</td>
					<td bgcolor="#CCCCCC" align="left" class="texto" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
					<td bgcolor="#CCCCCC" align="left" class="texto" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
				</tr>
			</table>';
			
	//COMPRAS DE LA TELA
	$cadena.='<table border="0" align="center">
				<tr>
					<td valign="top" align="center">
					
					<form name="fsumacompras" id="fsumacompras">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="4" bgcolor="#FFFFFF" align="left" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_compra_tela(\''.$tela.'\');">Agregar Compra</a> |</td>
								<td colspan="2" bgcolor="#FFFFFF" align="right" class="texto"><a href="#" onclick="xajax_existencias(\''.$tela.'\', \'sumalascompras\', xajax.getFormValues(\'fsumacompras\'))">Calcular:</a></td>
								<td bgcolor="#FFFFFF" align="right" class="texto">';if($sumalascompras!=0){$cadena.='$ '.number_format($sumalascompras,2);}$cadena.='</td>
							</tr>
							<tr>
								<td colspan="7" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMPRAS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checallacompras" id="checallacompras" value="1" onchange="seleccionar_todo_compratelas()"></td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CANTIDAD</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
							</tr>';
	$ResCompras=mysql_query("SELECT * FROM existencias WHERE Tela='".$tela."' AND (Tipo='Compra' OR Tipo='Devolucion') AND Historico='0' ORDER BY Fecha ASC");
	$A=1; $tcompras=0; $ccompras=0; $saldocompras=0;
	while($RResCompras=mysql_fetch_array($ResCompras))
	{
		$saldocompras=$saldocompras+$RResCompras["Importe"];
		$tcompras=$tcompras+$RResCompras["Importe"];
		$ccompras=$ccompras+$RResCompras["Cantidad"];
		if($RResCompras["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		else
		{
			$bgcolor="#A9A9A9";
		}
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResCompras["Id"].'" id="check_'.$RResCompras["Id"].'" value="1"';if($form["check_".$RResCompras["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResCompras["Fecha"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.strtoupper($RResCompras["Tipo"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResCompras["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_compra_tela(\''.$RResCompras["Id"].'\', \''.$tela.'\');" class="Ntooltip">$ '.number_format($RResCompras["Importe"],2).'</a></td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldocompras,2).'</td>
				</tr>';
		$A++;
	}
	$cadena.='		</table>
					</form>
					
					</td>';
	//ventas de la tela
	$cadena.='		<td valign="top" align="center">
	
					<form name="fsumaventas" id="fsumaventas">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#FFFFFF" colspan="6" align="left" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_venta_tela(\''.$tela.'\');">Agregar Venta</a> |</td>
								<td bgcolor="#FFFFFF" align="rigth" class="texto"><a href="#" onclick="xajax_existencias(\''.$tela.'\', \'sumalasventas\', xajax.getFormValues(\'fsumaventas\'))">Calcular:</a></td>
								<td bgcolor="#FFFFFF" align="right" class="texto">';if($sumalasventas!=0){$cadena.='$ '.number_format($sumalasventas,2);}$cadena.='</td>
							</tr>
							<tr>
								<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallaventas" id="checkallaventas" value="1" onchange="seleccionar_todo_ventatelas()"></td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CANTIDAD</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
							</tr>';
	$ResVentas=mysql_query("SELECT * FROM existencias WHERE Tela='".$tela."' AND (Tipo='Venta' OR Tipo='Varios' OR Tipo='Proveedor') AND Historico='0' ORDER BY Fecha ASC");
	$A=1; $tventas=0; $cventas=0; $saldoventas=0;
	while($RResVentas=mysql_fetch_array($ResVentas))
	{
		$saldoventas=$saldoventas+$RResVentas["Importe"];
		$tventas=$tventas+$RResVentas["Importe"];
		$cventas=$cventas+$RResVentas["Cantidad"];
		if($RResVentas["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		else
		{
			$bgcolor="#A9A9A9";
		}
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResVentas["Cliente"]."' LIMIT 1"));
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResVentas["Id"].'" id="check_'.$RResVentas["Id"].'" value="1"';if($form["check_".$RResVentas["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResVentas["Fecha"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.strtoupper($RResVentas["Tipo"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResCliente["Nombre"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResVentas["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_tela(\''.$RResVentas["Id"].'\', \''.$tela.'\');" class="Ntooltip">$ '.number_format($RResVentas["Importe"],2).'</a></td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldoventas,2).'</td>
				</tr>';
		$A++;
	}
	
	$cantidad=round(($ccompras-$cventas),2);
			
	$cadena.='		</table>
					</form>
	
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
					<p></p>
					<p></p>
					<form name="fcalculasaldo" id="fcalculasaldo">
					<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">Existencias : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="existencias" id="existencias" value="'.$cantidad.'" class="input"></td>
							</tr>
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">Precio : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ <input type="text" name="precio" id="precio" value="'.$ResTela["Precio2"].'" class="input"></td>
							</tr>
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">Saldo : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ <input type="text" name="saldo" id="saldo" value="'.number_format($ResTela["Importe"],2).'" class="input"></td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
									<input type="button" name="botcalcsaldo" id="botcalcsaldo" value="calcular" class="boton" onclick="xajax_existencias(\''.$tela.'\', \'calculasaldo\', xajax.getFormValues(\'fcalculasaldo\'))">
								</td>
						</table>
						</form>
					</td>
				</tr>
			</table>';
			
	mysql_query("UPDATE telas SET Existencia='".$cantidad."', Importe='".$ResTela["Importe"]."', Precio2='".$ResTela["Precio2"]."' WHERE Id='".$tela."'") or die(mysql_error());
				
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_venta_tela($tela)
{
	include ("conexion.php");
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTela["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTela["Provedor"]."'"));
	
	
	$cadena='<form name="fadventatela" id="fadventatela">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Venta</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="hidden" name="tela" id="tela" value="'.$ResTela["Id"].'">'.$ResTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
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
	for($i=2014; $i<=(date("Y")+1); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Venta" checked>VENTA <input type="radio" name="tipo" id="tipo" value="Varios">VARIOS <input type="radio" name="tipo" id="tipo" value="Proveedor">PROVEEDOR</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cliente: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="cliente" id="cliente"><option value="0">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'">'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='			</select>				
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value,venta.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResTela["Venta"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="importe" id="importe" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1">';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadventatela" id="botadventatela" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_existencias(\''.$tela.'\', \'adventa\', xajax.getFormValues(\'fadventatela\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_venta_tela($venta, $tela)
{
	include ("conexion.php");
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTela["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTela["Provedor"]."'"));
	$ResVenta=mysql_fetch_array(mysql_query("SELECT * FROM existencias WHERE Id='".$venta."'"));
	
	
	$cadena='<form name="feditventatela" id="feditventatela">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Venta</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="hidden" name="tela" id="tela" value="'.$ResTela["Id"].'">'.$ResTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$ResVenta["Fecha"][8].$ResVenta["Fecha"][9]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResVenta["Fecha"][5].$ResVenta["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2014; $i<=(date("Y")+1); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResVenta["Fecha"][0].$ResVenta["Fecha"][1].$ResVenta["Fecha"][2].$ResVenta["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Venta"';if($ResVenta["Tipo"]=='Venta'){$cadena.=' checked';}$cadena.='>VENTA <input type="radio" name="tipo" id="tipo" value="Varios"';if($ResVenta["Tipo"]=='Varios'){$cadena.=' checked';}$cadena.='>VARIOS <input type="radio" name="tipo" id="tipo" value="Proveedor"';if($ResVenta["Tipo"]=='Proveedor'){$cadena.=' checked';}$cadena.='>PROVEEDOR</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cliente: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="cliente" id="cliente"><option value="0">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($RResClientes["Id"]==$ResVenta["Cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='			</select>				
					</td>
				</tr>
				
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value,venta.value,importe);" value="'.$ResVenta["Cantidad"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResVenta["Precio"].'" onKeyUp="caluculo(cantidad.value,this.value,importe)"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="importe" id="importe" class="input" value="'.$ResVenta["Importe"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.str_replace('<br>', "", $ResVenta["Comentarios"]).'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1"';if($ResVenta["checka"]==1){$cadena.=' checked';}$cadena.='>';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Historico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResVenta["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResVenta["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idventa" id="idventa" value="'.$ResVenta["Id"].'">';
	if($ResVenta["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="button" name="boteditventatela" id="boteditventatela" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_existencias(\''.$tela.'\', \'editventa\', xajax.getFormValues(\'feditventatela\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	elseif($ResVenta["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="button" name="boteditventatela" id="boteditventatela" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_existencias(\''.$tela.'\', \'editventa\', xajax.getFormValues(\'feditventatela\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	$cadena.='		</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_compra_tela($tela)
{
	include ("conexion.php");
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTela["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTela["Provedor"]."'"));
	
	
	$cadena='<form name="fadcompratela" id="fadcompratela">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Compra</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="hidden" name="tela" id="tela" value="'.$ResTela["Id"].'">'.$ResTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
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
	for($i=2014; $i<=(date("Y")+1); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Compra">Compra <input type="radio" name="tipo" id="tipo" value="Devolucion">Devoluci&oacute;n</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value,venta.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Compra: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResTela["Precio"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="importe" id="importe" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1">';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadcompratela" id="botadcompratela" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_existencias(\''.$tela.'\', \'adcompra\', xajax.getFormValues(\'fadcompratela\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_compra_tela($compra, $tela)
{
	include ("conexion.php");
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTela["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTela["Provedor"]."'"));
	$ResCompra=mysql_fetch_array(mysql_query("SELECT * FROM existencias WHERE Id='".$compra."'"));
	
	
	$cadena='<form name="feditcompratela" id="feditcompratela">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Compra</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="hidden" name="tela" id="tela" value="'.$ResTela["Id"].'">'.$ResTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$ResCompra["Fecha"][8].$ResCompra["Fecha"][9]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResCompra["Fecha"][5].$ResCompra["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2014; $i<=(date("Y")+1); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResCompra["Fecha"][0].$ResCompra["Fecha"][1].$ResCompra["Fecha"][2].$ResCompra["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Compra"';if($ResCompra["Tipo"]=='Compra'){$cadena.=' checked';}$cadena.='>Compra <input type="radio" name="tipo" id="tipo" value="Devolucion"';if($ResCompra["Tipo"]=='Devolucion'){$cadena.=' checked';}$cadena.='>Devoluci&oacute;n</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value,venta.value,importe);" value="'.$ResCompra["Cantidad"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Compra: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResCompra["Precio"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="importe" id="importe" class="input" value="'.$ResCompra["Importe"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.str_replace('<br>', "", $ResCompra["Comentarios"]).'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1"';if($ResCompra["checka"]==1){$cadena.=' checked';}$cadena.='>';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Historico: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResCompra["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResCompra["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcompra" id="idcompra" value="'.$ResCompra["Id"].'">';
	if($ResCompra["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="button" name="boteditcompratela" id="boteditcompratela" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_existencias(\''.$tela.'\', \'editcompra\', xajax.getFormValues(\'feditcompratela\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	elseif($ResCompra["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="button" name="boteditcompratela" id="boteditcompratela" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_existencias(\''.$tela.'\', \'editcompra\', xajax.getFormValues(\'feditcompratela\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	$cadena.='		</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
?>