<?php
function ordenes_servicio ($limite=0, $buscaorden=NULL)
{
	include ("conexion.php");

	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="10" bgcolor="#ffffff" align="left" class="texto">
								<form name="fbusorden" id="fbusorden" method="POST" target="_blank" action="servicios/ordenservicioexcel.php">
								Cliente: <select name="cliente" id="cliente" onchange="xajax_unidades_cliente_orden(this.value)"><option value="todos">Todos</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"';if($buscaorden["cliente"]==$RResClientes["Id"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}								
	$cadena.='</select><br /><br />
			  <div id="uniclie">Unidad: <select name="unidadclie" id="unidadclie"><option value="Seleccione">Seleccione</option>';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$buscaorden["cliente"]."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'"';if($RResUnidadesCliente["Id"]==$buscaorden["unidadclie"]){$cadena.=' selected';}$cadena.='>'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select></div><br />
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
									<option value="2011">A&ntilde;o</option>';
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
									<option value="'.date("Y").'">A&ntilde;o</option>';
	for($T=2011;$T<=date("Y");$T++)
	{
		$cadena.='		<option value="'.$T.'"';if($buscaorden["annof"]==$T){$cadena.=' selected';}$cadena.='>'.$T.'</option>';
	}
	$cadena.='		</select><br /><br />
								Status: <select name="status" id="status">
									<option value="Todas"';if($buscaorden["status"]=='Todas'){$cadena.=' selected';}$cadena.='>Todas</option>
									<option value="Pendiente"';if($buscaorden["status"]=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente</option>
									<option value="Cancelada"';if($buscaorden["status"]=='Cancelada'){$cadena.=' selected';}$cadena.='>Cancelada</option>
									<option value="Facturada"';if($buscaorden["status"]=='Facturada'){$cadena.=' selected';}$cadena.='>Facturada</option>
								</select> <input type="button" name="botbustatus" id="botbustatus" value="buscar>>" class="boton" onclick="xajax_ordenes_servicio(\'0\', xajax.getFormValues(\'fbusorden\'))">
								<input type="submit" name="botexcel" id="botexcel" value="Exportar a Excel>>" class="boton">
								 </form>
							</th>
							<th colspan="2" bgcolor="#ffffff" align="right" class="texto" valign="bottom">| <a href="#" onclick="xajax_orden_servicio()">Nueva Orden de Servicio</a> |</th>
						</tr>
						<tr>
							<th colspan="12" bgcolor="#287d29" align="center" class="texto3">Ordenes de Servicio</th>
						</tr>
						<tr>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Num. Orden</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Fecha</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Cliente</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Unidad</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Tecnico Asignado</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Status</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Importe</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">Facturas</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
						</tr>';
	if($buscaorden==NULL)
	{
		$statusorden='%';
		$fechai='2011-01-01';	
		$fechaf=date("Y-m-d");
		$cliente='%';
		$numorden='%';
		$unidadclie='%';
	}
	else 
	{
		if($buscaorden["status"]=='Todas'){$statusorden='%';}else{$statusorden=$buscaorden["status"];}
		if($buscaorden["unidadclie"]=='Seleccione'){$unidadclie='%';}else{$unidadclie=$buscaorden["unidadclie"];}
		$fechai=$buscaorden["annoi"].'-'.$buscaorden["mesi"].'-'.$buscaorden["diai"];
		$fechaf=$buscaorden["annof"].'-'.$buscaorden["mesf"].'-'.$buscaorden["diaf"];
		if($buscaorden["cliente"]=='todos'){$cliente='%';}else{$cliente=$buscaorden["cliente"];}
		if($buscaorden["numorden"]==''){$numorden='%';}else{$numorden=$buscaorden["numorden"];}
	}
	
	$ResOrdenes=mysql_query("SELECT * FROM ordenservicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status LIKE '".$statusorden."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' AND NumOrden LIKE '".$numorden."' AND UnidadCliente LIKE '".$unidadclie."' ORDER BY NumOrden DESC LIMIT ".$limite.", 25");
	$regs=mysql_num_rows(mysql_query("SELECT * FROM ordenservicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status LIKE '".$statusorden."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' AND NumOrden LIKE '".$numorden."' AND UnidadCliente LIKE '".$unidadclie."' ORDER BY NumOrden DESC"));
	$J=1; $bgcolor="#7ac37b";
	while($RResOrdenes=mysql_fetch_array($ResOrdenes))
	{
		$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM unidades_cliente WHERE Id='".$RResOrdenes["UnidadCliente"]."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResOrdenes["Cliente"]."' LIMIT 1"));
		$ResTecnico=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResOrdenes["Tecnico"]."' LIMIT 1"));
		$ResFactura=mysql_fetch_array(mysql_query("SELECT Serie, NumFactura FROM facturas WHERE IdOrdenServicio='".$RResOrdenes["Id"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$J.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResOrdenes["NumOrden"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResOrdenes["Fecha"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResCliente["Nombre"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResUnidad["Nombre"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResTecnico["Nombre"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$RResOrdenes["Status"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">$ '.number_format($RResOrdenes["Total"], 2).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">'.$ResFactura["Serie"].$ResFactura["NumFactura"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto"><a href="servicios/ordenservicio.php?idorden='.$RResOrdenes["Id"].'" target="_blank">Ver</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">';if($RResOrdenes["Status"]=='Pendiente'){$cadena.='<a href="#" onclick="xajax_form_facturar_orden(\''.$RResOrdenes["Id"].'\')">Facturar</a>';}$cadena.='</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto">';if($RResOrdenes["Status"]=='Pendiente'){$cadena.='<a href="#" onclick="xajax_form_cancelar_orden_servicio(\''.$RResOrdenes["Id"].'\')">Cancelar</a>';}$cadena.='</td>
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
		$cadena.='<a href="#" onclick="xajax_ordenes_servicio(\''.$J.'\', xajax.getFormValues(\'fbusorden\'))">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
						</table>';
						
	//$cadena.="SELECT * FROM ordenservicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Status LIKE '".$statusorden."' AND Fecha>='".$fechai."' AND Fecha<='".$fechaf."' AND Cliente LIKE '".$cliente."' AND NumOrden LIKE '".$numorden."' AND UnidadCliente LIKE '".$unidadclie."' ORDER BY NumOrden DESC LIMIT ".$limite.", 25";					
	
	$respuesta = new xajaxResponse(); 
  	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  	return $respuesta;
}
function orden_servicio($orden=NULL, $borraprod=NULL)
{
	include ("conexion.php");
	
	$cadena='<form name="fordenservicio" id="fordenservicio">
				<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
					<tr>
						<th colspan="7" bgcolor="#287d29" align="center" class="texto3">Orden de Servicio</th>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Fecha de Cierre: </td>
						<td colspan="5" align="left" bgcolor="#7abc7a" class="texto"><select name="dia" id="dia"><option value="'.date("d").'">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($orden["dia"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='				</select> <select name="mes" id="mes">
								<option value="'.date("m").'">Mes</option>
								<option value="01"';if($orden["mes"]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
								<option value="02"';if($orden["mes"]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
								<option value="03"';if($orden["mes"]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
								<option value="04"';if($orden["mes"]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
								<option value="05"';if($orden["mes"]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
								<option value="06"';if($orden["mes"]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
								<option value="07"';if($orden["mes"]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
								<option value="08"';if($orden["mes"]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
								<option value="09"';if($orden["mes"]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
								<option value="10"';if($orden["mes"]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
								<option value="11"';if($orden["mes"]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
								<option value="12"';if($orden["mes"]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
							</select> <select name="anno" id="anno">
								<option value="'.date("Y").'">Año</option>';
	for($Y=2014; $Y<=date("Y"); $Y++)
	{
		$cadena.='<option value="'.$Y.'"'; if($Y==$orden["anno"]){$cadena.=' selected';}$cadena.='>'.$Y.'</option>';
	}
	$cadena.='				</select>
						</td>
					</tr>';
	$cadena.='		<tr>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cliente: </td>
							<td colspan="3" align="left" bgcolor="#7abc7a" class="texto">
								<select name="cliente" id="cliente" onchange="xajax_orden_servicio(xajax.getFormValues(\'fordenservicio\'))"><option value="">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"'; if($RResClientes["Id"]==$orden["cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
	<td valign="middle" align="left" bgcolor="#7abc7a" class="texto">Almacen: </td>
							<td valign="middle" align="left" bgcolor="#7abc7a" class="texto"><select name="almacen" id="almacen">';
	$ResAlmacen=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAlmacen=mysql_fetch_array($ResAlmacen))
	{
		$cadena.='<option value="'.$RResAlmacen["Nombre"].'"';if($RResAlmacen["Nombre"]==$orden["almacen"]){$cadena.=' selected';}$cadena.='>'.$RResAlmacen["Nombre"].'</option>';
	}
	$cadena.='		</select></td>
			</tr>
			<tr>
				<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Unidad: </td>
				<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><select name="unidadclie" id="unidadclie"><option>Seleccione</option>';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$orden["cliente"]."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'"';if($RResUnidadesCliente["Id"]==$orden["unidadclie"]){$cadena.=' selected';}$cadena.='>'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
				<td align="left" bgcolor="#7abc7a" class="texto">Tecnico: </td>
				<td align="left" bgcolor="#7abc7a" class="texto"><select name="tecnico" id="tecnico"><option value="">Seleccione</option>';
	$ResAgente=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='TecnicoS' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgente=mysql_fetch_array($ResAgente))
	{
		$cadena.='<option value="'.$RResAgente["Id"].'"';if($RResAgente["Id"]==$orden["tecnico"]){$cadena.=' selected';}$cadena.='>'.$RResAgente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
						 </tr>
			<tr>
				<td colspan="2" rowspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Motivo del Servicio con Cargo: </td>
				<td colspan="3" rowspan="2" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="motivoservicio" id="motivoservicio" class="input" cols="50" rows="3" >'.$orden["motivoservicio"].'</textarea></td>
				<td align="left" bgcolor="#7abc7a" class="texto">Precio: </td>
				<td align="left" bgcolor="#7abc7a" class="texto">
					<select name="pp" id="pp">
						<option value="PrecioPublico"';if($orden["pp"]=='PrecioPublico'){$cadena.=' selected';}$cadena.='>Precio Publico 1</option>
						<option value="PrecioPublico2"';if($orden["pp"]=='PrecioPublico2'){$cadena.=' selected';}$cadena.='>Precio Publico 2</option>
						<option value="PrecioPublico3"';if($orden["pp"]=='PrecioPublico3'){$cadena.=' selected';}$cadena.='>Precio Publico 3</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left" bgcolor="#7abc7a" class="texto">Costo del Servicio: </td>
				<td align="left" bgcolor="#7abc7a" class="texto"><input type="number" name="costoservicio" id="costoservicio" class="input" size="50" value="'.$orden["costoservicio"].'" onChange="xajax_orden_servicio(xajax.getFormValues(\'fordenservicio\'))"></td>
			</tr>
			<tr>
				<td colspan="2" rowspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Servicio: </td>
				<td colspan="3" rowspan="2" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="evaluacionprev" id="evaluacionprev" class="input" cols="50" rows="3" >'.$orden["evaluacionprev"].'</textarea></td>
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto">Num. Pedido: </td>
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto"><input type="text" name="numpedido" id="numpedido" class="input" value="'.$orden["numpedido"].'"></td> 
			</tr>
			<tr>	
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto">Num. Servicio: </td>
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto"><input type="text" name="numservicio" id="numservicio" class="input" value="'.$orden["numservicio"].'"></td> 
			</tr>
			<tr>
				<td colspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Trabajos Realizados: </td>
				<td colspan="5" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="trabajosrealizados" id="trabajosrealizados" class="input" cols="50" rows="3" >'.$orden["trabajosrealizados"].'</textarea></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Recomendaciones y/o Pendientes por hacer: </td>
				<td colspan="5" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="recomendaciones" id="recomendaciones" class="input" cols="50" rows="3" >'.$orden["recomendaciones"].'</textarea></td>
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
					<input type="hidden" name="idproducto" id="idproducto" value="0">
				</td>
				<td bgcolor="#7abc7a" align="center" class="texto">
					<input type="text" name="cantidad" id="cantidad" size="5" class="input" value="1" onKeyUp="calculo(this.value,precio.value,total);">
				</td>
				<td bgcolor="#7abc7a" align="center" class="texto">
					<input type="text" name="clave" id="clave" size="10" class="input" onKeyUp="claves.style.visibility=\'visible\'; xajax_claves_servicio(this.value, document.getElementById(\'cliente\').value, document.getElementById(\'cantidad\').value, document.getElementById(\'almacen\').value, document.getElementById(\'pp\').value)">
					<div id="claves" style="position: absolute; width: 600px; z-index:5; background-color:#96d096; text-align: left; visibility:hidden;"></div>
				</td>
				<td bgcolor="#7abc7a" align="center" class="texto">
					<input type="text" name="producto" id="producto" size="50" class="input"></td>
				<td bgcolor="#7abc7a" align="center" class="texto"><input type="number" name="precio" id="precio" size="10" class="input" onKeyUp="calculo(cantidad.value,this.value,total)"></td>
				<td bgcolor="#7abc7a" align="center" class="texto"><input type="number" name="total" id="total" size="10" class="input"></td>
				<td bgcolor="#7abc7a" align="center" class="texto"><input type="button" name="botadprod" id="botadprod" value="Agregar>>" class="boton" onclick="xajax_orden_servicio(xajax.getFormValues(\'fordenservicio\'))"></td>
			</tr>';
	$bgcolor="#7ac37b"; $i=1; $J=1; $array=array();
	if($orden==NULL)
	{
		$partidas=1;
	}
	elseif($orden!=NULL AND $orden["idproducto"]!=0)
	{
		if($borraprod==NULL)
		{
			//$ResCantidad=mysql_fetch_array(mysql_query("SELECT ".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"]." FROM inventario WHERE IdProducto='".$orden["idproducto"]."' LIMIT 1"));
			if(inventario_stock($orden["idproducto"],$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"])==0)
			{
				$cadena.='<tr>
										<th colspan="7" bgcolor="#7abc7a" class="textomensaje">Venta Invalida</th>
									</tr>';
				$partidas=$orden["partidas"];
			}
			//Revisa existencia en inventario
			else if(inventario_stock($orden["idproducto"],$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$orden["almacen"])>=$orden["cantidad"])
			{
				for($J=1; $J<$orden["partidas"];$J++)
				{
//					
						$ftotal=str_replace(',','',$orden["total_".$J]);
						$arreglo=array($J, $orden["idproducto_".$J], $orden["cantidad_".$J], $orden["clave_".$J], $orden["precio_".$J], $ftotal);
						array_push($array, $arreglo);
	//				
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
	$ivaa=0.16;
	$iva=($subtotal+$orden["costoservicio"])*$ivaa;
	$cadena.=' <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'"><input type="hidden" name="subtotal" id="subtotal" value="'.($subtotal+$orden["costoservicio"]).'">$ '.number_format(($subtotal+$orden["costoservicio"]), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Iva '.($ivaa*100).' %: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'"><input type="hidden" name="iva" id="iva" value="'.$iva.'">$ '.number_format($iva, 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 <tr>
							<th colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </th>
							<td align="right" class="texto" bgcolor="'.$bgcolor.'"><input type="hidden" name="totalorden" id="totalorden" value="'.($iva+$subtotal+$orden["costoservicio"]).'">$ '.number_format(($iva+$subtotal+$orden["costoservicio"]), 2).'</td>
							<td align="center" clasS="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
						 <tr>
						 	<th colspan="7" bgcolor="#7abc7a" align="center" class="texto">
								<input type="hidden" name="partidas" id="partidas" value="'.$partidas.'">
						 		<input type="button" name="botfinordenservicio" id="botonfinordenservicio" value="Guardar Orden de Servicio>>" class="boton" onclick="this.disabled = true;xajax_orden_servicio_2(xajax.getFormValues(\'fordenservicio\'))">
						 	</th>
						 </tr>
						</table>
						</form>';
	
	$respuesta = new xajaxResponse(); 
  	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  	return $respuesta;
}
function orden_servicio_2($orden)
{
	include ("conexion.php");
	
	//numero de orden
	$numorden=mysql_fetch_array(mysql_query("SELECT NumOrden FROM ordenservicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY NumOrden DESC LIMIT 1"));
	
	mysql_query("INSERT INTO ordenservicio (Empresa, Sucursal, Fecha, NumOrden, NumPedido, NumServicio, Cliente, UnidadCliente, Tecnico, EvaluacionP, TrabajosRealizados, Recomendaciones, Subtotal, Iva, Total, Status)
									 VALUE ('".$_SESSION["empresa"]."', 
											'".$_SESSION["sucursal"]."',
											'".$orden["anno"]."-".$orden["mes"]."-".$orden["dia"]."',
											'".($numorden["NumOrden"]+1)."',
											'".$orden["numpedido"]."',
											'".$orden["numservicio"]."',
											'".$orden["cliente"]."',
											'".$orden["unidadclie"]."',
											'".$orden["tecnico"]."',
											'".utf8_decode($orden["evaluacionprev"])."',
											'".utf8_decode($orden["trabajosrealizados"])."',
											'".utf8_decode($orden["recomendaciones"])."',
											'".$orden["subtotal"]."',
											'".$orden["iva"]."',
											'".$orden["totalorden"]."',
											'Pendiente')") or die(mysql_error());
											
	//obtiene id
	$idorden=mysql_fetch_array(mysql_query("SELECT Id, NumOrden FROM ordenservicio WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	
	//ingresa el motivo del servicio
	mysql_query("INSERT INTO det_orden_servicio (Empresa, Sucursal, IdOrden, Producto, Clave, Descripcion, Cantidad, PrecioUnitario, Importe)
										 VALUES ('".$_SESSION["empresa"]."',
												 '".$_SESSION["sucursal"]."',
												 '".$idorden["Id"]."',
												 '0',
												 'servicio',
												 '".utf8_decode($orden["motivoservicio"])."',
												 '1',
												 '".$orden["costoservicio"]."',
												 '".$orden["costoservicio"]."')") or die(mysql_error());
	
	//ingresa las partidas
	for($i=1; $i<$orden["partidas"]; $i++)
	{
		mysql_query("INSERT INTO det_orden_servicio (Empresa, Sucursal, IdOrden, Producto, Clave, Cantidad, PrecioUnitario, Importe)
											 VALUES ('".$_SESSION["empresa"]."',
													 '".$_SESSION["sucursal"]."',
													 '".$idorden["Id"]."',
													 '".$orden["idproducto_".$i]."',
													 '".$orden["clave_".$i]."',
													 '".$orden["cantidad_".$i]."',
													 '".$orden["precio_".$i]."',
													 '".$orden["total_".$i]."')") or die(mysql_error());
													 
		//descuenta del inventario
		mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenServicio, Fecha, Descripcion, Usuario)
										VALUES ('".$_SESSION["empresa"]."_".$SESSION["sucursal"]."_".$orden["almacen"]."',
												'".$orden["idproducto_".$i]."',
												'Salida',
												'".$orden["cantidad_".$i]."',
												'".$idorden["Id"]."',
												'".date("Y-m-d")."',
												'Salida por Orden de Servicio',
												'".$_SESSION["usuario"]."')") or die(mysql_error());
	}
											
	$cadena='<p align="center" class="textomensaje">Se genero la orden de servicio numero '.$idorden["NumOrden"].'</p>
			 <p align="center" class="texto"><a href="servicios/ordenservicio.php?idorden='.$idorden["Id"].'" target="_blank">Imprimir Orden</a></p>';
	
	$respuesta = new xajaxResponse(); 
  	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  	return $respuesta;
}
function claves_servicio($clave, $cliente, $cantidad, $almacen, $pp)
{
	include ("conexion.php");
	
	$almacen2=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$almacen;
	
	$cadena='<table border="1" bordercolor="#96d096" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#287d29" align="center" class="texto3">Clave</td>
							<td bgcolor="#287d29" align="center" class="texto3">Producto</td>
							<td bgcolor="#287d29" align="center" class="texto3">'.$almacen.'</td>
						</tr>';

						$ResClaves=mysql_query("SELECT Id, Clave, Nombre, Moneda, ".$pp." FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Clave LIKE '".$clave."%' ORDER BY Clave ASC LIMIT 25");
	while($RResClaves=mysql_fetch_array($ResClaves))
	{
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
		 					 <td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenservicio.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenservicio.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenservicio.precio.value=\''.$precio.'\'; document.fordenservicio.clave.value=\''.$clave.'\'; document.fordenservicio.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Clave"].'</a></td>
		 					 <td bgcolor="#96d096" align="left"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenservicio.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenservicio.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenservicio.precio.value=\''.$precio.'\'; document.fordenservicio.clave.value=\''.$clave.'\'; document.fordenservicio.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.$RResClaves["Nombre"].'</a></td>';
		$ResCantAlma=mysql_fetch_array(mysql_query("SELECT ".$almacen2." FROM inventario WHERE IdProducto='".$RResClaves["Id"]."' LIMIT 1"));
		$cadena.='<td bgcolor="#96d096" align="center"><a href="#" style="display: block;outline: none;padding: 0px 0 0px 0;margin: 0;text-decoration: none;color: #3c833d;" onclick="document.fordenservicio.producto.value=\''.$RResClaves["Nombre"].'\'; document.fordenservicio.idproducto.value=\''.$RResClaves["Id"].'\'; document.fordenservicio.precio.value=\''.$precio.'\'; document.fordenservicio.clave.value=\''.$clave.'\'; document.fordenservicio.total.value=\''.number_format($precio*$cantidad, 2).'\'; claves.style.visibility=\'hidden\';">'.inventario_stock($RResClaves["Id"],$almacen2).'</a></td>';
		$cadena.='</tr>';
		//}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("claves","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function tecnicos ($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<th colspan="6" class="texto" bgcolor="#FFFFFF" align="right">| <a href="#" style="text-decoration: none; color: #f26822;" onclick="xajax_tecnicos(\'agregar\', \'1\')">Agregar Tecnico</a> |</th>
							</tr>
							<tr>
								<th colspan="6" class="texto3" bgcolor="#287d29" align="center">Tecnicos de Servicio</th>
							</tr>';
	switch($modo)
	{
		case "agregar":
			$cadena.='<tr>
									<th colspan="6" bgcolor="#7abc7a" class="texto" align="center">';
			if($accion==1)
			{
				$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
				$cadena.='<form name="fadtecnico" id="fadtecnico"><table border="0" cellpadding="3" cellspacing="0">
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
												<input type="button" name="botadtecnico" id="botadtecnico" value="Agregar Tecnico>>" class="boton" onclick="xajax_tecnicos(\'agregar\', \'2\', xajax.getFormValues(\'fadtecnico\'))">
											</th>
										</tr>
									</table></form>';
			}
			else if($accion==2)
			{
				if(mysql_query("INSERT INTO parametros (Nombre, PerteneceA, Empresa, Sucursal)
																			VALUES ('".utf8_decode($form["nombre"])."', 'TecnicoS',
																							'".$form["empresa"]."', 
																							'".$form["sucursal"]."')"))
				{
					$cadena.='<p align="center" class="textomensaje">Se agreg&oacute; el Tecnico satisfactoriamente</p>';
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
									<th colspan="6" bgcolor="#7abc7a" class="texto" align="center">';
				if($accion==1)
				{
					$ResTecnico=mysql_query("SELECT * FROM parametros WHERE Id='".$form."' LIMIT 1");
					$RResTecnico=mysql_fetch_array($ResTecnico);
				
					$ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
					$cadena.='<form name="fedittecnico" id="fedittecnico">
									<table border="0" cellpadding="3" cellspacing="0">
										<tr>
											<td class="texto" align="left">Nombre: </td>
											<td class="texto" align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.utf8_encode($RResTecnico["Nombre"]).'"></td>
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
					$ResSucursales=mysql_query("SELECT * FROM sucursales WHERE Empresa='".$RResTecnico["Empresa"]."' ORDER BY Nombre ASC");
					while($RResSucursales=mysql_fetch_array($ResSucursales))
					{
						$cadena.='			<option value="'.$RResSucursales["Id"].'"'; if($RResSucursales["Id"]==$RResTecnico["Sucursal"]){$cadena.=' selected';}$cadena.='>'.utf8_encode($RResSucursales["Nombre"]).'</option>';
					}
					$cadena.='			</select>
											</div></td>
										</tr>
										<tr>
											<th colspan="2" class="texto" align="center">
												<input type="hidden" name="idtecnico" id="idtecnico" value="'.$form.'">
												<input type="button" name="botedittecnico" id="botedittecnico" value="Editar Tecnico de Servicio>>" class="boton" onclick="xajax_tecnicos(\'editar\', \'2\', xajax.getFormValues(\'fedittecnico\'))">
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
																				WHERE Id='".$form["idtecnico"]."'"))
					{
						$cadena.='<p class="textomensaje" align="center">Se actualizo el Tecnico satisfactoriamente</p>';
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
									<th colspan="6" bgcolor="#7abc7a" class="texto" align="center">';
			if($accion==1)
			{
				$ResTecnico=mysql_query("SELECT Nombre FROM parametros WHERE Id='".$form."' LIMIT 1");
				$RResTecnico=mysql_fetch_array($ResTecnico);
				
				$cadena.='Esta seguro de desactivar el tecnico: '.utf8_encode($RResTecnico["Nombre"]).'<br />
									<a href="#" onclick="xajax_tecnicos(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_agentes()">No</a>';
			}
			else if($accion==2)
			{
				if(mysql_query("UPDATE parametros SET Descripcion='Inactivo' WHERE Id='".$form."' LIMIT 1"))
				{
					$cadena.='<p class="textomensaje">Se desactivo el Tecnico satisfactoriamente</p>';
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
								<td align="center" class="texto3" bgcolor="#4eb24e">&nbsp;</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Tecnico</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Empresa</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">Sucursal</td>
								<td align="center" class="texto3" bgcolor="#4eb24e">&nbsp;</td>
							</tr>';
	$ResTecnicos=mysql_query("SELECT * FROM parametros WHERE PerteneceA='TecnicoS' AND Descripcion!='Inactivo' ORDER BY Nombre ASC");
	$bgcolor="#7ac37b"; $J=1;
	while($RResTecnicos=mysql_fetch_array($ResTecnicos))
	{
		$RResEmpresa=mysql_fetch_array(mysql_query("SELECT Nombre FROM empresas WHERE Id='".$RResTecnicos["Empresa"]."' LIMIT 1"));
		$RResSucursal=mysql_fetch_array(mysql_query("SELECT Nombre FROM sucursales WHERE Id='".$RResTecnicos["Sucursal"]."' AND Empresa='".$RResTecnicos["Empresa"]."' LIMIT 1"));
		$cadena.='<tr>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.$J.'</td>
								<td align="left" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResTecnicos["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResEmpresa["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'">'.utf8_encode($RResSucursal["Nombre"]).'</td>
								<td align="center" class="texto" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_tecnicos(\'editar\', \'1\', \''.$RResTecnicos["Id"].'\')"><img src="images/edit.png" border="0" alt="Editar"></a> <a href="#" onclick="xajax_tecnicos(\'eliminar\', \'1\', \''.$RResTecnicos["Id"].'\')"><img src="images/x.png" border="0" alt="Eliminar"></a></td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		else if($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
	}
	
  $respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",$cadena);
  return $respuesta;
}
function form_facturar_orden($orden)
{
	include ("conexion.php");
	
	$ResOrden=mysql_fetch_array(mysql_query("SELECT * FROM ordenservicio WHERE Id='".$orden."' LIMIT 1"));
	
	$cadena='<form name="ffordenservicio" id="ffordenservicio">
				<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
					<tr>
						<th colspan="7" bgcolor="#287d29" align="center" class="texto3">Orden de Servicio</th>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Fecha de Cierre: </td>
						<td colspan="5" align="left" bgcolor="#7abc7a" class="texto"><select name="dia" id="dia"><option value="'.date("d").'">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($ResOrden["Fecha"][8].$ResOrden["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='				</select> <select name="mes" id="mes">
								<option value="'.date("m").'">Mes</option>
								<option value="01"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
								<option value="02"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
								<option value="03"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
								<option value="04"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
								<option value="05"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
								<option value="06"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
								<option value="07"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
								<option value="08"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
								<option value="09"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
								<option value="10"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
								<option value="11"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
								<option value="12"';if($ResOrden["Fecha"][5].$ResOrden["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
							</select> <select name="anno" id="anno">
								<option value="'.date("Y").'">Año</option>';
	for($Y=2014; $Y<=date("Y"); $Y++)
	{
		$cadena.='<option value="'.$Y.'"'; if($Y==$ResOrden["Fecha"][0].$ResOrden["Fecha"][1].$ResOrden["Fecha"][2].$ResOrden["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$Y.'</option>';
	}
	$cadena.='				</select>
						</td>
					</tr>';
	$cadena.='		<tr>
							<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Cliente: </td>
							<td colspan="5" align="left" bgcolor="#7abc7a" class="texto">
								<select name="cliente" id="cliente">';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Id='".$ResOrden["Cliente"]."' ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='<option value="'.$RResClientes["Id"].'"'; if($RResClientes["Id"]==$ResOrden["Cliente"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
	
			</tr>
			<tr>
				<td colspan="2" align="left" bgcolor="#7abc7a" class="texto">Unidad: </td>
				<td colspan="3" align="left" bgcolor="#7abc7a" class="texto"><select name="unidadclie" id="unidadclie">';
	$ResUnidadesCliente=mysql_query("SELECT * FROM unidades_cliente WHERE cliente='".$ResOrden["Cliente"]."' AND Id='".$ResOrden["UnidadCliente"]."' ORDER BY Nombre ASC");
	while($RResUnidadesCliente=mysql_fetch_array($ResUnidadesCliente))
	{
		$cadena.='<option value="'.$RResUnidadesCliente["Id"].'"';if($RResUnidadesCliente["Id"]==$ResOrden["UnidadCliente"]){$cadena.=' selected';}$cadena.='>'.$RResUnidadesCliente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
				<td align="left" bgcolor="#7abc7a" class="texto">Tecnico: </td>
				<td align="left" bgcolor="#7abc7a" class="texto"><select name="tecnico" id="tecnico"><option value="">Seleccione</option>';
	$ResAgente=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='TecnicoS' AND Descripcion!='Inactivo' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResAgente=mysql_fetch_array($ResAgente))
	{
		$cadena.='<option value="'.$RResAgente["Id"].'"';if($RResAgente["Id"]==$ResOrden["Tecnico"]){$cadena.=' selected';}$cadena.='>'.$RResAgente["Nombre"].'</option>';
	}
	$cadena.='	</select></td>
						 </tr>
						 <tr>
				<td colspan="2" rowspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Servicio: </td>
				<td colspan="3" rowspan="2" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="evaluacionprev" id="evaluacionprev" class="input" cols="50" rows="3" >'.$ResOrden["EvaluacionP"].'</textarea></td>
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto">Num. Pedido: </td>
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto"><input type="text" name="numpedido" id="numpedido" class="input" value="'.$ResOrden["NumPedido"].'"></td> 
			</tr>
			<tr>	
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto">Num. Servicio: </td>
				<td valign="top" align="left" bgcolor="#7abc7a" class="texto"><input type="text" name="numservicio" id="numservicio" class="input" value="'.$ResOrden["NumServicio"].'"></td> 
			</tr>
			<tr>
				<td colspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Trabajos Realizados: </td>
				<td colspan="2" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="trabajosrealizados" id="trabajosrealizados" class="input" cols="50" rows="3" >'.$ResOrden["TrabajosRealizados"].'</textarea></td>
				<td colspan="3" rowspan="2" valign="top" align="left" bgcolor="#7abc7a" class="texto">Observaciones:<br /><textarea name="observaciones" id="observaciones" class="input" cols="40" rows="6" ></textarea></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" aling="left" bgcolor="#7abc7a" class="texto">Recomendaciones y/o<br/>Pendientes por hacer: </td>
				<td colspan="2" valign="top" align="left" bgcolor="#7abc7a" class="texto"><textarea name="recomendaciones" id="recomendaciones" class="input" cols="50" rows="3" >'.$ResOrden["Recomendaciones"].'</textarea></td>
			</tr>
			<tr>
				<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
				<td bgcolor="#4eb24e" align="center" class="texto3">Cantidad</td>
				<td bgcolor="#4eb24e" align="center" class="texto3">Clave</td>
				<td bgcolor="#4eb24e" align="center" class="texto3">Producto</td>
				<td bgcolor="#4eb24e" align="center" class="texto3">Precio</td>
				<td bgcolor="#4eb24e" align="center" class="texto3">Total</td>
				<td bgcolor="#4eb24e" align="center" class="texto3">&nbsp;</td>
			</tr>';
	$ResDetOrden=mysql_query("SELECT * FROM det_orden_servicio WHERE IdOrden='".$ResOrden["Id"]."' ORDER BY Id ASC");
	$bgcolor="#7ac37b"; $i=1;
	while($RResDetOrden=mysql_fetch_array($ResDetOrden))
	{
	if($RResDetOrden["Descripcion"]=='' AND $RResDetOrden["Producto"]==0)
	{
	}
	else
	{
		if($RResDetOrden["Producto"]!=0)
		{
			$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResDetOrden["Producto"]."' LIMIT 1"));
			$producto=$ResProducto["Nombre"];
		}
		else
		{
			$producto=$RResDetOrden["Descripcion"];
		}
		$cadena.='<tr>
				<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$i.'</td>
				<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResDetOrden["Cantidad"].'</td>
				<td align="center" bgcolor="'.$bgcolor.'" class="texto">'.$RResDetOrden["Clave"].'</td>
				<td align="left" bgcolor="'.$bgcolor.'" class="texto">'.$producto.'</td>
				<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResDetOrden["PrecioUnitario"], 2).'</td>
				<td align="right" bgcolor="'.$bgcolor.'" class="texto">$ '.number_format($RResDetOrden["Importe"],2).'</td>
				<td align="center" bgcolor="'.$bgcolor.'" class="texto">&nbsp;</td>
			</tr>';
		$i++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		elseif($bgcolor="#5ac15b"){$bgcolor='#7ac37b';}
	}
	}
	$cadena.='<tr>
				<td colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Subtotal: </td>
				<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($ResOrden["Subtotal"], 2).'</td>
				<td align="center" class="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Iva: </td>
				<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($ResOrden["Iva"], 2).'</td>
				<td align="center" class="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5" align="right" class="texto" bgcolor="'.$bgcolor.'">Total: </td>
				<td align="right" class="texto" bgcolor="'.$bgcolor.'">$ '.number_format($ResOrden["Total"], 2).'</td>
				<td align="center" class="texto" bgcolor="'.$bgcolor.'">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="7" bgcolor="#7abc7a" align="center" class="texto">
					<input type="hidden" name="idorden" id="idorden" value="'.$orden.'">
					<input type="button" name="botfacturaorden" id="botfacturaorden" value="Facturar Orden de Servicio>>" class="boton" onclick="this.disabled = true;xajax_facturar_orden(xajax.getFormValues(\'ffordenservicio\'), document.getElementById(\'reloj\').value)">
				</td>
			</tr>
		</table>
	</form>';
	
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function facturar_orden($orden, $hora)
{
	include ("conexion.php");
	date_default_timezone_set("America/Mexico_City");
	
	//actualizamos la orden de servicio
	mysql_query("UPDATE ordenservicio SET Fecha='".$orden["anno"]."-".$orden["mes"]."-".$orden["dia"]."',
										  NumPedido='".$orden["numpedido"]."',
										  NumServicio='".$orden["numservicio"]."',
										  Evaluacionp='".utf8_decode($orden["evaluacionprev"])."',
										  TrabajosRealizados='".utf8_decode($orden["trabajosrealizados"])."',
										  Recomendaciones='".utf8_decode($orden["recomendaciones"])."'
									WHERE Id='".$orden["idorden"]."'") or die(mysql_error());
	
	$ResOrden=mysql_fetch_array(mysql_query("SELECT * FROM ordenservicio WHERE Id='".$orden["idorden"]."' LIMIT 1"));
	
	$ResDetOrden=mysql_query("SELECT * FROM det_orden_servicio WHERE IdOrden='".$orden["idorden"]."' ORDER BY Id ASC");
	
	//obtenemos numero de factura
	$ResNumFac=mysql_fetch_array(mysql_query("SELECT Serie, Factura FROM ffacturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	$numfac=$ResNumFac["Factura"]; $serie=$ResNumFac["Serie"];
	//incremente la factura
	mysql_query("UPDATE ffacturas SET Factura=Factura+1 WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'") or die(mysql_error());
	//forma de pago del cliente
	$ResFPago=mysql_fetch_array(mysql_query("SELECT Fpago, Ncuenta FROM clientes WHERE Id='".$ResOrden["Cliente"]."' LIMIT 1"));
	
	//insertamos la factura
	mysql_query("INSERT INTO facturas (Serie, NumFactura, Empresa, Sucursal, Cliente, UnidadCliente, NumPedido, IdOrdenServicio, Fecha, Subtotal, Iva, Total, Status, Observaciones, Fpago, Ncuenta, Version, Usuario)
							   VALUES ('".$serie."',
									   '".$numfac."',
									   '".$_SESSION["empresa"]."',
									   '".$_SESSION["sucursal"]."',
									   '".$ResOrden["Cliente"]."',
									   '".$ResOrden["UnidadCliente"]."',
									   '".$ResOrden["NumPedido"]."',
									   '".$orden["idorden"]."',
									   '".date("Y-m-d").' '.$hora."',
									   '".$ResOrden["Subtotal"]."',
									   '".$ResOrden["Iva"]."',
									   '".$ResOrden["Total"]."',
									   'Pendiente',
									   'Num. de Servicio:  ".$ResOrden["NumServicio"]." - ".$ResOrden["observaciones"]."',
									   '".$ResFPago["Fpago"]."',
									   '".$ResFPago["Ncuenta"]."',
									   '3.2', 
									   '".$_SESSION["usuario"]."')") or die(mysql_error());
	//obtenemos id de factura
	$ResIdFac=mysql_fetch_array(mysql_query("SELECT Id, Serie, NumFactura FROM facturas WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id DESC LIMIT 1"));
	//ingresamos partidas
	while($RResDetOrden=mysql_fetch_array($ResDetOrden))
	{
	if($RResDetOrden["Descripcion"]=='' AND $RResDetOrden["Producto"]==0)
	{
	}
	else
	{
		if($RResDetOrden["Producto"]>0)
		{
			$ResUnidad=mysql_fetch_array(mysql_query("SELECT Unidad, Nombre FROM productos WHERE Id='".$RResDetOrden["Producto"]."' LIMIT 1"));
			$descripcion=$ResUnidad["Nombre"];
			$unidad=$RResDetOrden["Unidad"];
		}
		else
		{
			$descripcion=$RResDetOrden["Descripcion"];
			$unidad='No Aplica';
		}
		mysql_query("INSERT INTO detfacturas (IdFactura, Producto, Unidad, Descripcion, Clave, Cantidad, PrecioUnitario, Subtotal, Usuario)
									  VALUES ('".$ResIdFac["Id"]."',
											  '".$RResDetOrden["Producto"]."',
											  '".$unidad."',
											  '".$descripcion."',
											  '".$RResDetOrden["Clave"]."',
											  '".$RResDetOrden["Cantidad"]."',
											  '".$RResDetOrden["PrecioUnitario"]."',
											  '".$RResDetOrden["Importe"]."',
											  '".$_SESSION["usuario"]."')") or die(mysql_error());
	}
	}
	//genera xml y timbra factura
	
	generar_factura($ResIdFac["Id"]);
	
	//actualiza orden de servicio
	mysql_query("UPDATE ordenservicio SET Status='Facturada' WHERE Id='".$orden["idorden"]."'") or die(mysql_error());
									   
	$cadena.='<p align="center" class="textomensaje">Se genero la factura '.$ResIdFac["Serie"].$ResIdFac["NumFactura"].'</p>';
	
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function cancelar_orden_servicio($orden, $cancela='no')
{
	include ("conexion.php");
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_MX");
	
	if($cancela=='no')
	{
		$ResNumOrdenServicio=mysql_fetch_array(mysql_query("SELECT NumOrden, Cliente FROM ordenservicio WHERE Id='".$orden."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNumOrdenServicio["Cliente"]."' LIMIT 1"));
		
		$mensaje='Esta seguro de cancelar la orden de servicio Num.: '.$ResNumOrdenServicio["NumOrden"].' del Cliente: '.$ResCliente["Nombre"].'? <br />
							<a href="#" onclick="xajax_cancelar_orden_servicio(\''.$orden.'\', \'si\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_lista_ordenes_servicio()">No</a>';
	}
	elseif($cancela=='si')
	{
		//cancelamos la orden
		mysql_query("UPDATE ordenservicio SET Status='Cancelada WHERE Id='".$orden."'");
		//devolvemos los productos al inventario
		$ResProductos=mysql_query("SELECT Almacen, Cantidad, Producto FROM movinventario WHERE IdOrdenServicio='".$orden."' ORDER BY Id ASC");
		while($RResProductos=mysql_fetch_array($ResProductos))
		{
			mysql_query("UPDATE inventario SET ".$RResProductos["Almacen"]."=".$RResProductos["Almacen"]."+".$RResProductos["Cantidad"]." WHERE IdProducto='".$RResProductos["Producto"]."'");
			//registramos el movimiento
			mysql_query("INSERT INTO movinventario (Almacen, Producto, Movimiento, Cantidad, IdOrdenServicio, Fecha, Descripcion, Usuario)
											VALUES ('".$RResProductos["Almacen"]."', '".$RResProductos["Producto"]."', 'Entrada', '".$RResProductos["Cantidad"]."',
													'".$orden."', '".date("Y-m-d H:i:s")."', 'Ingreso a almacen por cancelacion de orden de servicio', '".$_SESSION["usuario"]."')");
		}
		$ResNumOrdenServicio=mysql_fetch_array(mysql_query("SELECT NumOrden, Cliente FROM ordenservicio WHERE Id='".$orden."' LIMIT 1"));
		$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$ResNumOrdenServicio["Cliente"]."' LIMIT 1"));
		
		$mensaje='<p class="textomensaje">Se cancelo la Orden de Venta Num: '.$ResNumOrdenServicio["NumOrden"].' del Cliente: '.$ResCliente["Nombre"].' satisfactoriamente';
	}
	
	$cadena='<table border="1" bordercolor="#ffffff" cellpadding="5" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#287d29" align="center" class="texto3">Ordenes de Servicio</th>
						</tr>
						<tr>
							<th colspan="5" bgcolor="#7abc7a" align="center" class="texto">'.$mensaje.'</th>
						</tr>
					 </table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>