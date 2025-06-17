<?php
function agregar_cuenta()
{
	include("conexion.php");
	
	$cadena='<form name="fadcuenta" id="fadcuenta">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Cuenta</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Banco: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">SELECCIONE</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos WHERE RazonSocial!='' ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'">'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Num. Cuenta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="numcuenta" id="numcuenta" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Sucursal: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="sucursal" id="sucursal" class="input"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">CLABE: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="clabe" id="clabe" class="input"></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="button" name="botadcuenta" id="botadcuenta" value="Agregar >" class="boton" onclick="xajax_agregar_cuenta_2(xajax.getFormValues(\'fadcuenta\'))">
					</td>
				</tr>
			</table>
			</form>';
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_cuenta_2($cuenta)
{
	include ("conexion.php");
	
	mysql_query("INSERT INTO cuentas (Banco, NumCuenta, Nombre, CLABE, Sucursal) 
							  VALUES ('".$cuenta["banco"]."', 
									  '".$cuenta["numcuenta"]."',
									  '".utf8_decode($cuenta["nombre"])."',
									  '".$cuenta["clabe"]."',
									  '".utf8_decode($cuenta["sucursal"])."')") or die(mysql_error());
	
	$cadena.='<p align="center" class="textomensaje">Se agrego la cuenta satisfactoriamente</p>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_cuenta($cuenta)
{
	include("conexion.php");
	
	$ResCuenta=mysql_fetch_array(mysql_query("SELECT * FROM cuentas WHERE Id='".$cuenta."' LIMIT 1")); 
	
	$cadena='<form name="feditcuenta" id="feditcuenta">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Cuenta</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Status: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="status" id="status" class="input">
							<option value="0"';if($ResCuenta["Status"]==0){$cadena.=' selected';}$cadena.='>Activo</option>
							<option value="2"';if($ResCuenta["Status"]==2){$cadena.=' selected';}$cadena.='>Historico</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Banco: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">SELECCIONE</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($RResBancos["Id"]==$ResCuenta["Banco"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Nombre: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="nombre" id="nombre" class="input" value="'.$ResCuenta["Nombre"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Num. Cuenta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="numcuenta" id="numcuenta" class="input" value="'.$ResCuenta["NumCuenta"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Sucursal: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="sucursal" id="sucursal" class="input" value="'.$ResCuenta["Sucursal"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">CLABE: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="clabe" id="clabe" class="input" value="'.$ResCuenta["CLABE"].'"></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#FFFFFF" style="border:1px solid #FFFFFF" align="center">
						<input type="hidden" name="idcuenta" id="idcuenta" value="'.$ResCuenta["Id"].'">
						<input type="button" name="botadcuenta" id="botadcuenta" value="Agregar >" class="boton" onclick="xajax_editar_cuenta_2(xajax.getFormValues(\'feditcuenta\'))">
					</td>
				</tr>
			</table>
			</form>';
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_cuenta_2($cuenta)
{
	include ("conexion.php");
	
	mysql_query("UPDATE cuentas SET Banco='".$cuenta["banco"]."', 
									 NumCuenta='".$cuenta["numcuenta"]."', 
									 Nombre='".utf8_decode($cuenta["nombre"])."', 
									 CLABE='".$cuenta["clabe"]."', 
									 Sucursal='".utf8_decode($cuenta["sucursal"])."',
									 Status='".$cuenta["status"]."'
							   WHERE Id='".$cuenta["idcuenta"]."'") or die(mysql_error());
	
	$cadena.='<p align="center" class="textomensaje">Se actualizo la cuenta satisfactoriamente</p>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function bancos ()
{
	include ("conexion.php");
	
	$cadena='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Bancos</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Banco</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Saldo</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NumCuenta</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Sucursal</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLABE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$ResCuentas=mysql_query("SELECT * FROM cuentas ORDER BY Id ASC");
	
	$i=1; $saldo=0;
	while($RResCuentas=mysql_fetch_array($ResCuentas))
	{
		$histdet=mysql_num_rows(mysql_query("SELECT Id FROM detcuenta WHERE Cuenta='".$RResCuentas["Id"]."' AND Historico='1'"));
		
		if($RResCuentas["Status"]==2 OR $histdet!=0)
		{
		$ResDetCuenta=mysql_query("SELECT Deposito, Retiro, Cancelado FROM detcuenta WHERE Cuenta='".$RResCuentas["Id"]."' AND Cancelado='0' AND Fecha LIKE '".date("Y")."%' ORDER BY Fecha ASC, Id ASC");
		while($RResDetCuenta=mysql_fetch_array($ResDetCuenta))
		{
			$saldo=$saldo+$RResDetCuenta["Deposito"];
			$saldo=$saldo-$RResDetCuenta["Retiro"];
		}
		
		$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResCuentas["Banco"]."' LIMIT 1"));
		$cadena.='<tr>	
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$i.'</a></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResBanco["Nombre"].'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResCuentas["Nombre"].'</td>
					<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$'.number_format($saldo,2).'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_cuenta(\''.$RResCuentas["Id"].'\', \''.date("Y").'\')" class="Ntooltip0">'.$RResCuentas["NumCuenta"].'</a></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResCuentas["Sucursal"].'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResCuentas["CLABE"].'</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_editar_cuenta(\''.$RResCuentas["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
				  </tr>';
		$i++; $saldo=0;
		}
	}
	$cadena.='</table>';
				
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function cuenta($cuenta,$annio,$accion=NULL,$form=NULL)
{
	include ("conexion.php");
	
	switch($accion)
	{
		case 'adcuenta':
			mysql_query("INSERT INTO detcuenta (Cuenta, Fecha, Concepto, Cheque, Deposito, Retiro, Comentarios, checka)
										VALUES ('".$cuenta."',
												'".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
												'".utf8_decode($form["concepto"])."',
												'".$form["cheque"]."',
												'".$form["deposito"]."',
												'".$form["retiro"]."',
												'".utf8_decode($form["comentarios"])."',
												'".$form["checka"]."')") or die(mysql_error());
			break;
		case 'editcuenta':
			mysql_query("UPDATE detcuenta SET Cuenta='".$cuenta."', 
											  Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
											  Concepto='".utf8_decode($form["concepto"])."', 
											  Cheque='".$form["cheque"]."',
											  Deposito='".$form["deposito"]."', 
											  Retiro='".$form["retiro"]."', 
											  Comentarios='".utf8_decode($form["comentarios"])."',
											  checka='".$form["checka"]."',
											  Cancelado='".$form["cancela"]."',
											  Historico='".$form["historico"]."'
										WHERE Id='".$form["idconcepto"]."'") or die(mysql_error());
			break;
	}
	
	$ResCuenta=mysql_fetch_array(mysql_query("SELECT * FROM cuentas WHERE Id='".$cuenta."' LIMIT 1"));
	$ResBanco=mysql_fetch_array(mysql_query("SELECT * FROM bancos WHERE Id='".$ResCuenta["Banco"]."' LIMIT 1"));
	
	$cadena='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="8" align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_concepto(\''.$cuenta.'\');">Agregar Concepto</a> |</td>
				</tr>
				<tr>
					<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">'.$ResBanco["Nombre"].' - '.$ResCuenta["Nombre"].' - '.$ResCuenta["NumCuenta"].' 
					<select name="anno" id="anno" onchange="xajax_cuenta(\''.$cuenta.'\', this.value)">';
					for($i=2014; $i<=(date("Y")+2); $i++)
					{
						$cadena.='<option value="'.$i.'"';if($i==$annio){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
					}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DEPOSITO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETIRO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$ResDetCuenta=mysql_query("SELECT * FROM detcuenta WHERE Cuenta='".$cuenta."' AND Fecha LIKE '".$annio."%' AND Historico='1' ORDER BY Fecha ASC, Id ASC");
	$i=1; $saldo=0; $J=1;
	while($RResDetCuenta=mysql_fetch_array($ResDetCuenta))
	{
		if($J==41)
		{
			$cadena.='<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DEPOSITO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETIRO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
			$J=1;
		}
		if($RResDetCuenta["Cancelado"]==0)
		{
			$saldo=$saldo+$RResDetCuenta["Deposito"];
			$saldo=$saldo-$RResDetCuenta["Retiro"];
		}
		if($RResDetCuenta["Deposito"]>0 AND $RResDetCuenta["checka"]==0){$bgcolor='#1E90FF';}elseif($RResDetCuenta["Deposito"]>0 AND $RResDetCuenta["checka"]==1){$bgcolor='#00CED1';}
		if($RResDetCuenta["Retiro"]>0 AND $RResDetCuenta["checka"]==0){$bgcolor='#A9A9A9';}elseif($RResDetCuenta["Retiro"]>0 AND $RResDetCuenta["checka"]==1){$bgcolor='#CCCCCC';}
		if($RResDetCuenta["Cancelado"]==1){$bgcolor='#DB7093';}
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$i.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResDetCuenta["Fecha"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResDetCuenta["Concepto"].'</td>
					<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResDetCuenta["Cheque"].'</td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if($RResDetCuenta["Deposito"]>0){$cadena.='<a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_concepto(\''.$RResDetCuenta["Id"].'\');" class="Ntooltip">';}$cadena.='$ '.number_format($RResDetCuenta["Deposito"], 2).'';if($RResDetCuenta["Deposito"]>0){$cadena.='<span>'.$RResDetCuenta["Comentarios"].'</span></a>';}$cadena.='</td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if($RResDetCuenta["Retiro"]>0){$cadena.='<a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_concepto(\''.$RResDetCuenta["Id"].'\');" class="Ntooltip">';}$cadena.='$ '.number_format($RResDetCuenta["Retiro"], 2).'';if($RResDetCuenta["Retiro"]>0){$cadena.='<span>'.$RResDetCuenta["Comentarios"].'</span></a>';}$cadena.='</td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldo, 2).'</td>
					<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a hreF="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_concepto(\''.$RResDetCuenta["Id"].'\');"><img src="images/edit.png" border="0"></a></td>
				</tr>';
		$i++; $J++;
	}
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_concepto($cuenta)
{
	$cadena='<form name="fadcuenta" id="fadcuenta" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="6" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DEPOSITO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETIRO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if(date("d")==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
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
	for($i=2010; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" size="50" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="cheque" id="cheque" size="50" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="deposito" id="deposito" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="retiro" id="retiro" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<textarea name="comentarios" id="comentarios" rows="3" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadcompra" id="botadcompra" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_cuenta(\''.$cuenta.'\', document.getElementById(\'anno\').value, \'adcuenta\', xajax.getFormValues(\'fadcuenta\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;

}
function editar_concepto($concepto)
{
	include ("conexion.php");
	
	$ResConcepto=mysql_fetch_array(mysql_query("SELECT * FROM detcuenta WHERE Id='".$concepto."' LIMIT 1"));
	
	$cadena='<form name="feditcuenta" id="feditcuenta" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="8" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DEPOSITO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETIRO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CANCELADO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResConcepto["Fecha"][8].$ResConcepto["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResConcepto["Fecha"][5].$ResConcepto["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResConcepto["Fecha"][0].$ResConcepto["Fecha"][1].$ResConcepto["Fecha"][2].$ResConcepto["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" size="40" class="input" value="'.$ResConcepto["Concepto"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="cheque" id="cheque" size="20" class="input" value="'.$ResConcepto["Cheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="deposito" id="deposito" class="input" value="'.$ResConcepto["Deposito"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="retiro" id="retiro" class="input" value="'.$ResConcepto["Retiro"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResConcepto["checka"]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="cancela" id="cancela" value="1"';if($ResConcepto["Cancelado"]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResConcepto["Historico"]==1){$cadena.=' checked';}$cadena.='></td>
				</tr>
				<tr>
					<td colspan="8" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<textarea name="comentarios" id="comentarios" rows="3" cols="50">'.$ResConcepto["Comentarios"].'</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="8" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idconcepto" id="idconcepto" value="'.$ResConcepto["Id"].'">';
if($ResConcepto["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="botadcompra" id="botadcompra" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_cuenta(\''.$ResConcepto["Cuenta"].'\', document.getElementById(\'anno\').value, \'editcuenta\', xajax.getFormValues(\'feditcuenta\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResConcepto["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="botadcompra" id="botadcompra" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_cuenta(\''.$ResConcepto["Cuenta"].'\', document.getElementById(\'anno\').value, \'editcuenta\', xajax.getFormValues(\'feditcuenta\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
$cadena.='			</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;

}
?>