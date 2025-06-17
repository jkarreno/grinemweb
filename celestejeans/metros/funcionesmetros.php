<?php
function metros($accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	if($accion!=NULL)
	{
		switch($accion)
		{
			case 'editcompra':
				mysql_query("UPDATE compras SET Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
										   Apagar='".$form["apagar"]."',
										   Importe='".$form["importe"]."',
										   Status='".$form["status"]."',
										   Comentarios='".$form["comentarios"]."',
										   checkaMetros='".$form["checka"]."',
										   HistoricoMetros='".$form["historico"]."',
										   AnnoHistoricoMetros='".$form["annohistorico"]."',
										   Metros='".$form["metros"]."'
									 WHERE Id='".$form["idcompra"]."'") or die(mysql_error());
			break;
			
			case 'editventa':
				mysql_query("UPDATE ventas SET Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
										   Apagar='".$form["apagar"]."',
										   Importe='".$form["importe"]."',
										   Provedor='".$form["provedor"]."',
										   Comision='".$form["comision"]."',
										   SComision='".$form["scomision"]."',
										   Status='".$form["status"]."',
										   Comentarios='".$form["comentarios"]."',
										   checkaMetros='".$form["checka"]."',
										   HistoricoMetros='".$form["historico"]."',
										   AnnoHistoricoMetros='".$form["annohistorico"]."',
										   Metros='".$form["metros"]."'
									 WHERE Id='".$form["idventa"]."'") or die(mysql_error());
			break;
			
			case 'sumacompras':
				$sumacompras=0;
				$ResSuma=mysql_query("SELECT Id, Metros FROM compras WHERE HistoricoMetros='0' AND Metros!='0.00' ORDER BY Id ASC");
				while($RResSuma=mysql_fetch_array($ResSuma))
				{
					if($form["check_".$RResSuma["Id"]]==1)
					{
						$sumacompras=$sumacompras+$RResSuma["Metros"];
					}
				}
			break;
			
			case 'sumaventas':
				$sumaventas=0;
				$ResSumaV=mysql_query("SELECT Id, Metros FROM ventas WHERE HistoricoMetros='0' AND Metros!='0.00' ORDER BY Id ASC");
				while($RResSumaV=mysql_fetch_array($ResSumaV))
				{
					if($form["check_".$RResSumaV["Id"]]==1)
					{
						$sumaventas=$sumaventas+$RResSumaV["Metros"];
					}
				}
			break;
		}
	}
	
	$cadena='<table border="0" align="center">
			<tr>
			<td valign="top" align="center">
				
				<form name="fsumacomprasmetros" id="fsumacomprasmetros">
				<table border="0" align="right" cellpadding="3" cellspacing="0">
					<tr>
						<td colspan="4" align="right" class="texto"><a href="#" onclick="xajax_metros(\'sumacompras\', xajax.getFormValues(\'fsumacomprasmetros\'))">Calcular: </td>
						<td align="right" class="texto">';if($sumacompras>0){$cadena.='$ '.number_format($sumacompras,2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="5" bgcolor="#5263ab" align="center" class="texto3">COMPRAS</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allsumacomprasmetros" id="allsumacomprasmetros" value="1"';if($form["allsumacomprasmetros"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumacompras_metros()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PROVEDOR</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PANTALONES</td>
					</tr>';
	$ResCompras=mysql_query("SELECT Id, Provedor, Fecha, Comentarios, Metros, checkaMetros FROM compras WHERE HistoricoMetros='0' AND Metros!='0.00' ORDER BY Fecha ASC");
	$bgcolor='#CCC'; $A=1;
	while($RResCompras=mysql_fetch_array($ResCompras))
	{
		$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResCompras["Provedor"]."' LIMIT 1"));
		
		if($RResCompras["checkaMetros"]==0){$bgcolor='#a9a9a9';}
		elseif($RResCompras["checkaMetros"]==1){$bgcolor='#CCC';}
		
		$cadena.='	<tr>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResCompras["Id"].'" id="check_'.$RResCompras["Id"].'" value="1"'; if($form["check_".$RResCompras["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResCompras["Fecha"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
						<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_compra_metros(\''.$RResCompras["Id"].'\')">'.number_format($RResCompras["Metros"],2).'<span>'.$RResCompras["Comentarios"].'</span></a></td>
					</tr>';
		$A++; $compras=$compras+$RResCompras["Metros"];
	}
	$cadena.='		<tr>
						<td bgcolor="#5263ab" colspan="5" class="texto3" align="right" style="border:1px solid #FFFFFF">'.number_format($compras, 2).'<td>
					</tr>
				</table>
				</form>
			
			</td>
			<td valign="top" align="center">
	
				<form name="fsumaventasmetros" id="fsumaventasmetros">
				<table border="0" align="left" cellpadding="3" cellspacing="0">
					<tr>
						<td colspan="4" align="right" class="texto"><a href="#" onclick="xajax_metros(\'sumaventas\', xajax.getFormValues(\'fsumaventasmetros\'))">Calcular: </td>
						<td align="right" class="texto">';if($sumaventas>0){$cadena.='$ '.number_format($sumaventas,2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="5" bgcolor="#5263ab" align="center" class="texto3">VENTAS</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allsumaventasmetros" id="allsumaventasmetros" value="1"';if($form["allsumaventasmetros"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaventas_metros()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PANTALONES</td>
					</tr>';
	$ResVentas=mysql_query("SELECT Id, Cliente, Fecha, Comentarios, Metros, checkaMetros FROM ventas WHERE HistoricoMetros='0' AND Metros!='0.00' ORDER BY Fecha ASC");
	$bgcolor='#CCC'; $A=1;
	while($RResVentas=mysql_fetch_array($ResVentas))
	{
		
		if($RResVentas["checkaMetros"]==0){$bgcolor='#a9a9a9';}
		elseif($RResVentas["checkaMetros"]==1){$bgcolor='#CCC';}
		
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResVentas["Cliente"]."' LIMIT 1"));
		
		$cadena.='	<tr>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResVentas["Id"].'" id="check_'.$RResVentas["Id"].'" value="1"'; if($form["check_".$RResVentas["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResVentas["Fecha"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResCliente["Nombre"].'</td>
						<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_metros(\''.$RResVentas["Id"].'\')">'.number_format($RResVentas["Metros"],2).'<span>'.$RResVentas["Comentarios"].'</span></a></td>
					</tr>';
		$A++; $ventas=$ventas+$RResVentas["Metros"];
	}
	$cadena.='		<tr>
						<td bgcolor="#5263ab" colspan="5" class="texto3" align="right" style="border:1px solid #FFFFFF">'.number_format($ventas, 2).'<td>
					</tr>
				</table>
				</form>
			
			</td>
			</tr>
			<tr>
			<td valign="top" align="center">
			
				<table border="0" align="left" cellpadding="3" cellspacing="0">
					<tr>
						<td bgcolor="#CCC" align="right" class="texto" style="border:1px solid #FFFFFF">TOTAL COMPRAS: </td>
						<td bgcolor="#CCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.number_format($compras, 2).'</td>
					</tr>
					<tr>
						<td bgcolor="#CCC" align="right" class="texto" style="border:1px solid #FFFFFF">TOTAL VENTAS: </td>
						<td bgcolor="#CCC" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ventas, 2).'</td>
					</tr>
					<tr>
						<td bgcolor="#ccc" align="right" class="texto" style="border:1px solid #FFFFFF">EXISTENCIA: </td>
						<td bgcolor="#ccc" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format(($compras-$ventas),2).'</td>
					</tr>
				</table>
				
			</td>
			<td valign="top" align="center">&nbsp;</td>
			</tr>
			</table>';
			
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_compra_metros($compra)
{
	include ("conexion.php");
	
	$ResCompra=mysql_fetch_array(mysql_query("SELECT * FROM compras WHERE Id='".$compra."' LIMIT 1"));
	
	$cadena='<form name="feditcompra" id="feditcompra" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="7" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">A PAGAR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PANTALONES</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResCompra["Fecha"][8].$ResCompra["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
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
	for($i=2000; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResCompra["Fecha"][0].$ResCompra["Fecha"][1].$ResCompra["Fecha"][2].$ResCompra["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><select name="apagar" id="apagar">';
	for($i=1;$i<=100;$i++)
	{
		$cadena.='<option value="'.$i.'"';if($ResCompra["Apagar"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> dias
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input" value="'.$ResCompra["Importe"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="status" id="status">
							<option value="VENCIDA"';if($ResCompra["Status"]=='VENCIDA'){$cadena.=' selected';}$cadena.='>VENCIDA</option>
							<option value="PAGADO"';if($ResCompra["Status"]=='PAGADO'){$cadena.=' selected';}$cadena.='>PAGADO</option>
							<option value="DEVOLUCION"';if($ResCompra["Status"]=='DEVOLUCION'){$cadena.=' selected';}$cadena.='>DEVOLUCION</option>
						</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1"';if($ResCompra["checkaMetros"]==1){$cadena.=' checked';}$cadena.='>';}$cadena.='</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResCompra["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResCompra["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="number" name="metros" id="metros" class="input" value="'.$ResCompra["Metros"].'"></td>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">Comentarios: <br /><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResCompra["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcompra" id="idcompra" value="'.$ResCompra["Id"].'">';
if($ResCompra["checkaMetros"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="boteditcompra" id="boteditcompra" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_metros(\'editcompra\', xajax.getFormValues(\'feditcompra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResCompra["checkaMetros"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="boteditcompra" id="boteditcompra" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_metros(\'editcompra\', xajax.getFormValues(\'feditcompra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
$cadena.='			</td>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
	
}
function editar_venta_metros($venta)
{
	include ("conexion.php");
	
	$ResVenta=mysql_fetch_array(mysql_query("SELECT * FROM ventas WHERE Id='".$venta."' LIMIT 1"));
	
	$cadena='<form name="feditventa" id="feditventa" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="10" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">A PAGAR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PROVEEDOR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PANTALONES</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResVenta["Fecha"][8].$ResVenta["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
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
	for($i=2000; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResVenta["Fecha"][0].$ResVenta["Fecha"][1].$ResVenta["Fecha"][2].$ResVenta["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="apagar" id="apagar">
							<option value="1"';if($ResVenta["Apagar"]==1){$cadena.=' selected';}$cadena.='>1</option>
							<option value="15"';if($ResVenta["Apagar"]==15){$cadena.=' selected';}$cadena.='>15</option>
							<option value="30"';if($ResVenta["Apagar"]==30){$cadena.=' selected';}$cadena.='>30</option>
							<option value="45"';if($ResVenta["Apagar"]==45){$cadena.=' selected';}$cadena.='>45</option>
							<option value="60"';if($ResVenta["Apagar"]==60){$cadena.=' selected';}$cadena.='>60</option>
							<option value="75"';if($ResVenta["Apagar"]==75){$cadena.=' selected';}$cadena.='>75</option>
							<option value="90"';if($ResVenta["Apagar"]==90){$cadena.=' selected';}$cadena.='>90</option>
							<option value="105"';if($ResVenta["Apagar"]==105){$cadena.=' selected';}$cadena.='>105</option>
							<option value="120"';if($ResVenta["Apagar"]==120){$cadena.=' selected';}$cadena.='>120</option>
						</select> dias
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input" value="'.$ResVenta["Importe"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="provedor" id="provedor"><option>SELECCIONE</option>';
	$ResProvedores=mysql_query("SELECT * FROM provedores ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='			<option value="'.$RResProvedores["Id"].'"';if($ResVenta["Provedor"]==$RResProvedores["Id"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="comision" id="comision" class="input" value="'.$ResVenta["Comision"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="scomision" id="scomision">
							<option value="Pendiente"';if($ResVenta["SComision"]=='Pendiente'){$cadena.=' selected';}$cadena.='>PENDIENTE</option>
							<option value="Pagado"';if($ResVenta["SComision"]=='Pagado'){$cadena.=' selected';}$cadena.='>PAGADO</option>
						</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="status" id="status">
							<option value="">SELECCIONE</option>
							<option value="VENCIDA"';if($ResVenta["Status"]=='VENCIDA'){$cadena.=' selected';}$cadena.='>VENCIDA</option>
							<option value="PAGADO"';if($ResVenta["Status"]=='PAGADO'){$cadena.=' selected';}$cadena.='>PAGADO</option>
							<option value="DEVOLUCION"';if($ResVenta["Status"]=='DEVOLUCION'){$cadena.=' selected';}$cadena.='>DEVOLUCION</option>
						</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1"';if($ResVenta["checkaMetros"]==1){$cadena.=' checked';}$cadena.='>';}$cadena.='</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResVenta["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResVenta["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="number" name="metros" id="metros" value="'.$ResVenta["Metros"].'" class="input"></td>
				</tr>
				<tr>
					<td colspan="10" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">Comentarios: <br /><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResVenta["Comentarios"].'</textarea></td>
				</tr>
				</tr>
				<tr>
					<td colspan="10" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idventa" id="idventa" value="'.$ResVenta["Id"].'">';
if($ResVenta["checkaMetros"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="botadpago" id="botadpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_metros(\'editventa\', xajax.getFormValues(\'feditventa\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResVenta["checkaMetros"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="botadpago" id="botadpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_metros(\'editventa\', xajax.getFormValues(\'feditventa\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
$cadena.='			</td>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
	
}
?>