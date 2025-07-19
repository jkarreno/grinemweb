<?php
function costos()
{
	include ("conexion.php");
	
	$cadena='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="10" align="right" class="texto">| <a href="#" onclick="xajax_agregar_costo()">Agregar Costo</a> |</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">MODELO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TOTAL PRENDAS</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COSTO REAL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PRECIO VENTA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">U. PANTALON</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">U. MODELO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	// $ResCostos=mysql_query("SELECT Id, Fecha, Modelo, TotalPrendas, CostoPrenda, PrecioVenta, Utilidad, UtilidadReal FROM costos ORDER BY Fecha DESC");
	// $bgcolor="#CCC"; $A=1;
	// while($RResCostos=mysql_fetch_array($ResCostos))
	// {
		// $ResModelo=mysql_fetch_array(mysql_query("SELECT Nombre, TipoTela FROM telas WHERE Id='".$RResCostos["Modelo"]."' LIMIT 1"));
		
		
		// $cadena.='<tr id="row_'.$A.'" style="background: '.$bgcolor.'">
					// <td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$A.'</td>
					// <td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.fecha($RResCostos["Fecha"]).'</td>
					// <td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$ResModelo["Nombre"].'</td>
					// <td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$ResModelo["TipoTela"].'</td>
					// <td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResCostos["TotalPrendas"].'</td>
					// <td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["CostoPrenda"], 2).'</td>
					// <td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["PrecioVenta"], 2).'</td>
					// <td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["Utilidad"], 2).'</td>
					// <td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["UtilidadReal"], 2).'</td>
					// <td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'"><a href="#" onclick="xajax_editar_costo(\''.$RResCostos["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
				// </tr>';
		// $A++;
	// }
	$ResModelo=mysql_query("SELECT Id, Nombre, TipoTela FROM telas ORDER BY Nombre ASC");
	$A=1; $bgcolor="#CCC";
	while($RResModelo=mysql_fetch_array($ResModelo))
	{
		$ResCostos=mysql_query("SELECT Id, Fecha, Modelo, TotalPrendas, CostoPrenda, PrecioVenta, Utilidad, UtilidadReal FROM costos WHERE Modelo='".$RResModelo["Id"]."' AND Historico='0' ORDER BY Fecha DESC");
		
		while($RResCostos=mysql_fetch_array($ResCostos))
		{
		
			$cadena.='<tr id="row_'.$A.'" style="background: '.$bgcolor.'">
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$A.'</td>
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.fecha($RResCostos["Fecha"]).'</td>
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResModelo["Nombre"].'</td>
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResModelo["TipoTela"].'</td>
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">'.$RResCostos["TotalPrendas"].'</td>
						<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["CostoPrenda"], 2).'</td>
						<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["PrecioVenta"], 2).'</td>
						<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["Utilidad"], 2).'</td>
						<td align="right" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">$ '.number_format($RResCostos["UtilidadReal"], 2).'</td>
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'"><a href="#" onclick="xajax_editar_costo(\''.$RResCostos["Id"].'\')"><img src="images/edit.png" border="0"></a></td>
						<td align="center" class="texto" style="border:1px solid #FFFFFF" onmouseover="row_'.$A.'.style.background=\'#00CED1\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'">';if($_SESSION["perfil"]=='administra'){$cadena.='<a href="#" onclick="xajax_eliminar_costo(\''.$RResCostos["Id"].'\')"><img src="images/x.png" border="0"></a>';}$cadena.='</td>
					</tr>';
			$A++;
		}
	}
	
	$cadena.='</table>';
				
				
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_costo($form=NULL)
{
	include ("conexion.php");
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT TipoTela FROM telas WHERE Id='".$form["modelo"]."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResTela["TipoTela"]."' AND PerteneceA='TipoTela' LIMIT 1"));
	
	$cadena='<form name="fadcosto" id="fadcosto">
			
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td align="left" class="texto" colspan="4">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td colspan="3" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Costo Real</td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Modelo: </td>
								<td  colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
									<select name="modelo" id="modelo" class="input" onchange="xajax_agregar_costo(xajax.getFormValues(\'fadcosto\'))">
										<option value="0">SELECCIONE</option>';
				$ResModelos=mysql_query("SELECT Id, Nombre FROM telas ORDER BY Nombre ASC");
				while($RResModelos=mysql_fetch_array($ResModelos))
				{
					$cadena.='			<option value="'.$RResModelos["Id"].'"';if($form["modelo"]==$RResModelos["Id"]){$cadena.=' selected';}$cadena.='>'.$RResModelos["Nombre"].'</option>';
				}
				$cadena.='			</select>
								</td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de Tela: </td>
								<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTela["TipoTela"].'</td>
								<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comen_modelo" id="comen_modelo" cols="25" rows="2" placeholder="comentarios" class="input"></textarea></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Metros enviados: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="metrosenviados" id="metrosenviados" class="input" value="'.$form["metrosenviados"].'"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Rendimiento: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="rendimiento" id="rendimiento" class="input" value="'.$form["rendimiento"].'" onkeyup="costos_rendimiento(this.value, c_costotela)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Total de Prendas: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="tprendas" id="tprendas" class="input" value="'.$form["tprendas"].'" onkeyup="costos_diseno_molde(this.value, c_disenomolde); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, this.value, utilidadreal)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe de la Tela: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="imptela" id="imptela" class="input" value="'.$form["imptela"].'"></td>
							</tr>
							<tr>
								<td class="texto" align="center" colspan="3">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Costo Unidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Cantidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Total</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Costo Tela: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_costotela" id="cu_costotela" class="input" onkeyup="costos_costo_tela(this.value, c_costotela.value, t_costotela); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_costotela" id="c_costotela" class="input"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_costotela" id="t_costotela" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Dise�o Molde: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_disenomolde" id="cu_disenomolde" class="input" onkeyup="costos_total_diseno_molde(this.value, c_disenomolde.value, t_disenomolde); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_disenomolde" id="c_disenomolde" class="input" onkeyup="costos_total_diseno_molde(cu_disenomolde.value, this.value, t_disenomolde); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_disenomolde" id="t_disenomolde" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Maquila: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_maquila" id="cu_maquila" class="input" onkeyup="costos(this.value, c_maquila.value, t_maquila); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_maquila" id="c_maquila" class="input" onkeyup="costos(cu_maquila.value, this.value, t_maquila); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_maquila" id="t_maquila" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Boton: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_boton" id="cu_boton" class="input" onkeyup="costos(this.value, c_boton.value, t_boton); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_boton" id="c_boton" class="input" onkeyup="costos(cu_boton.value, this.value, t_boton); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_boton" id="t_boton" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Remaches: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_remaches" id="cu_remaches" class="input" onkeyup="costos(this.value, c_remaches.value, t_remaches); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_remaches" id="c_remaches" class="input" onkeyup="costos(cu_remaches.value, this.value, t_remaches); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_remaches" id="t_remaches" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cierre: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_cierre" id="cu_cierre" class="input" onkeyup="costos(this.value, c_cierre.value, t_cierre); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_cierre" id="c_cierre" class="input" onkeyup="costos(cu_cierre.value, this.value, t_cierre); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_cierre" id="t_cierre" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Bordado: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_bordado" id="cu_bordado" class="input" onkeyup="costos(this.value, c_bordado.value, t_bordado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_bordado" id="c_bordado" class="input" onkeyup="costos(cu_bordado.value, this.value, t_bordado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_bordado" id="t_bordado" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cinturon: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_cinturon" id="cu_cinturon" class="input" onkeyup="costos(this.value, c_cinturon.value, t_cinturon); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_cinturon" id="c_cinturon" class="input" onkeyup="costos(cu_cinturon.value, this.value, t_cinturon); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_cinturon" id="t_cinturon" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta interna o bordada: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiqintbor" id="cu_etiqintbor" class="input" onkeyup="costos(this.value, c_etiqintbor.value, t_etiqintbor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiqintbor" id="c_etiqintbor" class="input" onkeyup="costos(cu_etiqintbor.value, this.value, t_etiqintbor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiqintbor" id="t_etiqintbor" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Placa: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_placa" id="cu_placa" class="input" onkeyup="costos(this.value, c_placa.value, t_placa); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_placa" id="c_placa" class="input" onkeyup="costos(cu_placa.value, c_placa.value, t_placa); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_placa" id="t_placa" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta de Talla Interna: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiqtallainterna" id="cu_etiqtallainterna" class="input" onkeyup="costos(this.value, c_etiqtallainterna.value, t_etiqtallainterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiqtallainterna" id="c_etiqtallainterna" class="input" onkeyup="costos(cu_etiqtallainterna.value, this.value, t_etiqtallainterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiqtallainterna" id="t_etiqtallainterna" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta Adherible: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiqadherible" id="cu_etiqadherible" class="input" onkeyup="costos(this.value, c_etiqadherible.value, t_etiqadherible); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiqadherible" id="c_etiqadherible" class="input" onkeyup="costos(cu_etiqadherible.value, this.value, t_etiqadherible); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiqadherible" id="t_etiqadherible" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta de Talla Externa: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiqtallaexterna" id="cu_etiqtallaexterna" class="input" onkeyup="costos(this.value, c_etiqtallaexterna.value, t_etiqtallaexterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiqtallaexterna" id="c_etiqtallaexterna" class="input" onkeyup="costos(cu_etiqtallaexterna.value, this.value, t_etiqtallaexterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiqtallaexterna" id="t_etiqtallaexterna" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta Colgante: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiqcolgante" id="cu_etiqcolgante" class="input" onkeyup="costos(this.value, c_etiqcolgane.value, t_etiqcolgante); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiqcolgante" id="c_etiqcolgante" class="input" onkeyup="costos(cu_etiqcolgante.value, this.value, t_etiqcolgante); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiqcolgante" id="t_etiqcolgante" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta Monarch: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiqmonarch" id="cu_etiqmonarch" class="input" onkeyup="costos(this.value, c_etiqmonarch.value, t_etiqmonarch); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiqmonarch" id="c_etiqmonarch" class="input" onkeyup="costos(cu_etiqmonarch.value, this.value, t_etiqmonarch); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiqmonarch" id="t_etiqmonarch" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Etiqueta de Piel Externa: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_etiquetapielexterna" id="cu_etiquetapielexterna" class="input" onkeyup="costos(this.value, c_etiquetapielexterna.value, t_etiquetapielexterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_etiqmonarch.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_etiquetapielexterna" id="c_etiquetapielexterna" class="input" onkeyup="costos(cu_etiquetapielexterna.value, this.value, t_etiquetapielexterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_etiqmonarch.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_etiquetapielexterna" id="t_etiquetapielexterna" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Lavado: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_lavado" id="cu_lavado" class="input" onkeyup="costos(this.value, c_lavado, t_lavado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_lavado" id="c_lavado" class="input" onkeyup="costos(cu_lavado.value, this.value, t_lavado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_lavado" id="t_lavado" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Transfer: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_transfer" id="cu_transfer" class="input" onkeyup="costos(this.value, c_transfer.value, t_transfer); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_transfer" id="c_transfer" class="input" onkeyup="costos(cu_transfer.value, this.value, t_transfer); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_transfer" id="t_transfer" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Terminado: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_terminado" id="cu_terminado" class="input" onkeyup="costos(this.value, c_terminado, t_terminado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_terminado" id="c_terminado" class="input" onkeyup="costos(cu_terminado.value, this.value, t_terminado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_terminado" id="t_terminado" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Transporte: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_transporte" id="cu_transporte" class="input" onkeyup="costos(this.value, c_transporte, t_transporte); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_transporte" id="c_transporte" class="input" onkeyup="costos(cu_transporte.value, this.value, t_transporte); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_transporte" id="t_transporte" class="input" value="0"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comisión Vendedor <select name="comven" id="comven" onchange="comision_vendedor(precioventa.value, this.value, cu_comisionvendedor); costos(cu_comisionvendedor.value, c_comisionvendedor.value, t_comisionvendedor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)">';
	for($i=0;$i<=20;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='		<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='		</select> % : </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_comisionvendedor" id="cu_comisionvendedor" class="input"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_comisionvendedor" id="c_comisionvendedor" class="input" value="1" onkeyup="costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_comisionvendedor" id="t_comisionvendedor" class="input" value="0" onkeyup="costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(this.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad Arturo: </td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cu_utilidadgabriel" id="cu_utilidadgabriel" class="input" onkeyup=costos(this.value, c_utilidadgabriel.value, t_utilidadgabriel); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="c_utilidadgabriel" id="c_utilidadgabriel" class="input" onkeyup="costos(cu_utilidadgabriel.value, this.value, t_utilidadgabriel); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="t_utilidadgabriel" id="t_utilidadgabriel" class="input" value="0"></td>
				</tr>
				<tr>
					<td colspan="4" class="texto">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="texto" align="left">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Costo Real: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="costoporprenda" id="costoporprenda" class="input"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="precioventa" id="precioventa" class="input" onkeyup="comision_vendedor(this.value, comven.value, cu_comisionvendedor); costos(cu_comisionvendedor.value, c_comisionvendedor.value, t_comisionvendedor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(this.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad Por Pantalon: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="utilidad" id="utilidad" class="input"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad total por modelo: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="utilidadreal" id="utilidadreal" class="input"></td>
							</tr>
						</table>
					</td>
					<td colspan="2" class="texto" align="center">
						<input type="button" name="botadcosto" id="botadcosto" value="Guardar" class="boton" onclick="xajax_agregar_costo_2(xajax.getFormValues(\'fadcosto\'))">
					</td>
				</tr>
			</table>
			<p align="center">
		</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_costo_2($form)
{
	include ("conexion.php");
	
	mysql_query("INSERT INTO costos (Fecha, Modelo, ComModelo, MetrosEnviados, Rendimiento, TotalPrendas, ImporteTela,
									 CU_CostoTela, C_CostoTela, T_CostoTela, 
									 CU_DisenoMolde, C_DisenoMolde, T_DisenoMolde,
									 CU_Maquila, C_Maquila, T_Maquila,
									 CU_Boton, C_Boton, T_Boton,
									 CU_Remaches, C_Remaches, T_Remaches,
									 CU_Cierre, C_Cierre, T_Cierre,
									 CU_Bordado, C_Bordado, T_Bordado,
									 CU_Cinturon, C_Cinturon, T_Cinturon,
									 CU_EtiquetaInternaBordada, C_EtiquetaInternaBordada, T_EtiquetaInternaBordada, 
									 CU_Placa, C_Placa, T_Placa,  
									 CU_EtiquetaTallaInterna, C_EtiquetaTallaInterna, T_EtiquetaTallaInterna, 
									 CU_EtiquetaAdherible, C_EtiquetaAdherible, T_EtiquetaAdherible,
									 CU_EtiquetaTallaExterna, C_EtiquetaTallaExterna, T_EtiquetaTallaExterna,
									 CU_EtiquetaColgante, C_EtiquetaColgante, T_EtiquetaColgante,
									 CU_EtiquetaMonarch, C_EtiquetaMonarch, T_EtiquetaMonarch,
									 CU_EtiquetaPielExterna, C_EtiquetaPielExterna, T_EtiquetaPielExterna,
									 CU_Lavado, C_Lavado, T_Lavado, 
									 CU_Transfer, C_Transfer, T_Transfer, 
									 CU_Terminado, C_Terminado, T_Terminado,
									 CU_Transporte, C_Transporte, T_Transporte, 
									 ComisionVendedor, CU_ComisionVendedor, C_ComisionVendedor, T_ComisionVendedor,
									 CU_UtilidadGabriel, C_UtilidadGabriel, T_UtilidadGabriel,
									 CostoPrenda, PrecioVenta, Utilidad, UtilidadReal)
							  VALUES('".date("Y-m-d")."', '".$form["modelo"]."', '".$form["comen_modelo"]."', '".$form["metrosenviados"]."', '".$form["rendimiento"]."', '".$form["tprendas"]."', '".$form["imptela"]."', 
									 '".$form["cu_costotela"]."', '".$form["c_costotela"]."', '".$form["t_costotela"]."', 
									 '".$form["cu_disenomolde"]."', '".$form["c_disenomolde"]."', '".$form["t_disenomolde"]."', 
									 '".$form["cu_maquila"]."', '".$form["c_maquila"]."', '".$form["t_maquila"]."',
									 '".$form["cu_boton"]."', '".$form["c_boton"]."', '".$form["t_boton"]."', 
									 '".$form["cu_remaches"]."', '".$form["c_remaches"]."', '".$form["t_remaches"]."',
									 '".$form["cu_cierre"]."', '".$form["c_cierre"]."', '".$form["t_cierre"]."', 
									 '".$form["cu_bordado"]."', '".$form["c_bordado"]."', '".$form["t_bordado"]."', 
									 '".$form["cu_cinturon"]."', '".$form["c_cinturon"]."', '".$form["t_cinturon"]."', 
									 '".$form["cu_etiqintbor"]."', '".$form["c_etiqintbor"]."', '".$form["t_etiqintbor"]."',
									 '".$form["cu_placa"]."', '".$form["c_placa"]."', '".$form["t_placa"]."', 
									 '".$form["cu_etiqtallainterna"]."', '".$form["c_etiqtallainterna"]."', '".$form["t_etiqtallainterna"]."',
									 '".$form["cu_etiqadherible"]."', '".$form["c_etiqadherible"]."', '".$form["t_etiqadherible"]."', 
									 '".$form["cu_etiqtallaexterna"]."', '".$form["c_etiqtallaexterna"]."', '".$form["t_etiqtallaexterna"]."',
									 '".$form["cu_etiqcolgante"]."', '".$form["c_etiqcolgante"]."', '".$form["t_etiqcolgante"]."',
									 '".$form["cu_etiqmonarch"]."', '".$form["c_etiqmonarch"]."', '".$form["t_etiqmonarch"]."',
									 '".$form["cu_etiquetapielexterna"]."', '".$form["c_etiquetapielexterna"]."', '".$form["t_etiquetapielexterna"]."',
									 '".$form["cu_lavado"]."', '".$form["c_lavado"]."', '".$form["t_lavado"]."',
									 '".$form["cu_transfer"]."', '".$form["c_transfer"]."', '".$form["t_transfer"]."', 
									 '".$form["cu_terminado"]."', '".$form["c_terminado"]."', '".$form["t_terminado"]."', 
									 '".$form["cu_transporte"]."', '".$form["c_transporte"]."', '".$form["t_transporte"]."',
									 '".$form["comven"]."', '".$form["cu_comisionvendedor"]."', '".$form["c_comisionvendedor"]."', '".$form["t_comisionvendedor"]."',
									 '".$form["cu_utilidadgabriel"]."', '".$form["c_utilidadgabriel"]."', '".$form["t_utilidadgabriel"]."', 
									 '".$form["costoporprenda"]."', '".$form["precioventa"]."', '".$form["utilidad"]."', '".$form["utilidadreal"]."')") or die(mysql_error());
									 
									 
	$cadena.='<p align="center" class="textomensaje">Se agrego el costo satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_costo($costo, $campo=NULL, $fcampo=NULL, $fcomen=NULL, $fpcomen=NULL)
{
	include ("conexion.php");
	
	if($fcampo!=NULL)
	{
		mysql_query("UPDATE costos SET P_".$campo."='".$fcampo["status"]."',
									   Comen_".$campo."='".$fcampo["comentarios"]."',
									   Check_".$campo."='".$fcampo["check"]."'
								 WHERE Id='".$costo."'") or die(mysql_error());
	}
	
	if($fcomen!=NULL)
	{
		mysql_query("UPDATE costos SET ComModelo='".$fcomen["comentarios"]."',
									   Historico='".$fcomen["historico"]."',
									   AnnoHistorico='".$fcomen["annohistorico"]."',
									   Check_Costo='".$fcomen["check"]."' 
								 WHERE Id='".$costo."'") or die(mysql_error());
	}
	
	if($fpcomen!=NULL)
	{
		mysql_query("UPDATE costos SET P_Comen_".$campo."='".$fpcomen["comentarios"]."'
								 WHERE Id='".$costo."'") or die(mysql_error());
	}
	
	$ResCosto=mysql_fetch_array(mysql_query("SELECT * FROM costos WHERE Id='".$costo."' LIMIT 1"));
	
	$ResTela=mysql_fetch_array(mysql_query("SELECT Nombre, TipoTela FROM telas WHERE Id='".$ResCosto["Modelo"]."' LIMIT 1"));
	
	
	$cadena='<form name="feditcosto" id="feditcosto">
			';
			$bgcolor='#a9a9a9';
	$cadena.='<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="5" align="left" class="texto">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td colspan="3" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Costo Real</td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Modelo: </td>
								<td  colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTela["Nombre"].'</td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_costo(\''.$costo.'\')">Tipo de Tela:</a> </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTela["TipoTela"].'</td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Metros enviados: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="metrosenviados" id="metrosenviados" class="input" value="'.$ResCosto["MetrosEnviados"].'"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Rendimiento: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="rendimiento" id="rendimiento" class="input" value="'.$ResCosto["Rendimiento"].'" onkeyup="costos_rendimiento(this.value, c_costotela)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Total de Prendas: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="tprendas" id="tprendas" class="input" value="'.$ResCosto["TotalPrendas"].'" onkeyup="costos_diseno_molde(this.value, c_disenomolde); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, this.value, utilidadreal)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe de la Tela: </td>
								<td colspan="2" class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="imptela" id="imptela" class="input" value="'.$ResCosto["ImporteTela"].'"></td>
							</tr>
							<tr>
								<td class="texto" colspan="3">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Concepto</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Costo Unidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Cantidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Total</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;Pagado&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
	if($ResCosto["Check_CostoTela"]==0 AND $ResCosto["P_CostoTela"]=="No Pagado"){$bgcolor_CostoTela='#a9a9a9';}
	if($ResCosto["Check_CostoTela"]==0 AND $ResCosto["P_CostoTela"]=="Pagado"){$bgcolor_CostoTela='#fc97a9';}
	if($ResCosto["Check_CostoTela"]==1 AND $ResCosto["P_CostoTela"]=="No Pagado"){$bgcolor_CostoTela='#cccccc';}
	if($ResCosto["Check_CostoTela"]==1 AND $ResCosto["P_CostoTela"]=="Pagado"){$bgcolor_CostoTela='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_CostoTela.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_costos_check(\''.$ResCosto["Id"].'\', \'CostoTela\')">Costo Tela: <span>'.$ResCosto["Comen_CostoTela"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_CostoTela.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_CostoTela"].'" type="text" name="cu_costotela" id="cu_costotela" class="input" onkeyup="costos_costo_tela(this.value, c_costotela.value, t_costotela); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_CostoTela"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_CostoTela.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_CostoTela"].'" type="text" name="c_costotela" id="c_costotela" class="input"';if($ResCosto["Check_CostoTela"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_CostoTela.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_CostoTela"].'" type="text" name="t_costotela" id="t_costotela" class="input" value="0"';if($ResCosto["Check_CostoTela"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_CostoTela.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_CostoTela"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'CostoTela\')">Pagado<span>'.$ResCosto["P_Comen_CostoTela"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_DisenoMolde='#a9a9a9';
	if($ResCosto["Check_DisenoMolde"]==0 AND $ResCosto["P_DisenoMolde"]=="No Pagado"){$bgcolor_DisenoMolde='#a9a9a9';}
	if($ResCosto["Check_DisenoMolde"]==0 AND $ResCosto["P_DisenoMolde"]=="Pagado"){$bgcolor_DisenoMolde='#fc97a9';}
	if($ResCosto["Check_DisenoMolde"]==1 AND $ResCosto["P_DisenoMolde"]=="No Pagado"){$bgcolor_DisenoMolde='#cccccc';}
	if($ResCosto["Check_DisenoMolde"]==1 AND $ResCosto["P_DisenoMolde"]=="Pagado"){$bgcolor_DisenoMolde='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_DisenoMolde.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'DisenoMolde\')">Dise�o Molde: <span>'.$ResCosto["Comen_DisenoMolde"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_DisenoMolde.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_DisenoMolde"].'" type="text" name="cu_disenomolde" id="cu_disenomolde" class="input" onkeyup="costos_total_diseno_molde(this.value, c_disenomolde.value, t_disenomolde); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_DisenoMolde"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_DisenoMolde.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_DisenoMolde"].'" type="text" name="c_disenomolde" id="c_disenomolde" class="input" onkeyup="costos_total_diseno_molde(cu_disenomolde.value, this.value, t_disenomolde); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_DisenoMolde"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_DisenoMolde.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_DisenoMolde"].'" type="text" name="t_disenomolde" id="t_disenomolde" class="input" value="0"';if($ResCosto["Check_DisenoMolde"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_DisenoMolde.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_DisenoMolde"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'DisenoMolde\')">Pagado<span>'.$ResCosto["P_Comen_DisenoMolde"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Maquila='#a9a9a9';
	if($ResCosto["Check_Maquila"]==0 AND $ResCosto["P_Maquila"]=="No Pagado"){$bgcolor_Maquila='#a9a9a9';}
	if($ResCosto["Check_Maquila"]==0 AND $ResCosto["P_Maquila"]=="Pagado"){$bgcolor_Maquila='#fc97a9';}
	if($ResCosto["Check_Maquila"]==1 AND $ResCosto["P_Maquila"]=="No Pagado"){$bgcolor_Maquila='#cccccc';}
	if($ResCosto["Check_Maquila"]==1 AND $ResCosto["P_Maquila"]=="Pagado"){$bgcolor_Maquila='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Maquila.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Maquila\')">Maquila: <span>'.$ResCosto["Comen_Maquila"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Maquila.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Maquila"].'" type="text" name="cu_maquila" id="cu_maquila" class="input" onkeyup="costos(this.value, c_maquila.value, t_maquila); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Maquila"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Maquila.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Maquila"].'" type="text" name="c_maquila" id="c_maquila" class="input" onkeyup="costos(cu_maquila.value, this.value, t_maquila); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Maquila"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Maquila.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Maquila"].'" type="text" name="t_maquila" id="t_maquila" class="input" value="0"';if($ResCosto["Check_Maquila"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Maquila.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Maquila"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Maquila\')">Pagado<span>'.$ResCosto["P_Comen_Maquila"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Boton='#a9a9a9';
	if($ResCosto["Check_Boton"]==0 AND $ResCosto["P_Boton"]=="No Pagado"){$bgcolor_Boton='#a9a9a9';}
	if($ResCosto["Check_Boton"]==0 AND $ResCosto["P_Boton"]=="Pagado"){$bgcolor_Boton='#fc97a9';}
	if($ResCosto["Check_Boton"]==1 AND $ResCosto["P_Boton"]=="No Pagado"){$bgcolor_Boton='#cccccc';}
	if($ResCosto["Check_Boton"]==1 AND $ResCosto["P_Boton"]=="Pagado"){$bgcolor_Boton='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Boton.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Boton\')">Boton: <span>'.$ResCosto["Comen_Boton"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Boton.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Boton"].'" type="text" name="cu_boton" id="cu_boton" class="input" onkeyup="costos(this.value, c_boton.value, t_boton); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Boton"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Boton.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Boton"].'" type="text" name="c_boton" id="c_boton" class="input" onkeyup="costos(cu_boton.value, this.value, t_boton); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Boton"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Boton.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Boton"].'" type="text" name="t_boton" id="t_boton" class="input" value="0"';if($ResCosto["Check_Boton"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Boton.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Boton"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Boton\')">Pagado<span>'.$ResCosto["P_Comen_Boton"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Remaches='#a9a9a9';
	if($ResCosto["Check_Remaches"]==0 AND $ResCosto["P_Remaches"]=="No Pagado"){$bgcolor_Remaches='#a9a9a9';}
	if($ResCosto["Check_Remaches"]==0 AND $ResCosto["P_Remaches"]=="Pagado"){$bgcolor_Remaches='#fc97a9';}
	if($ResCosto["Check_Remaches"]==1 AND $ResCosto["P_Remaches"]=="No Pagado"){$bgcolor_Remaches='#cccccc';}
	if($ResCosto["Check_Remaches"]==1 AND $ResCosto["P_Remaches"]=="Pagado"){$bgcolor_Remaches='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Remaches.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Remaches\')">Remaches: <span>'.$ResCosto["Comen_Remaches"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Remaches.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Remaches"].'" type="text" name="cu_remaches" id="cu_remaches" class="input" onkeyup="costos(this.value, c_remaches.value, t_remaches); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Remaches"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Remaches.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Remaches"].'" type="text" name="c_remaches" id="c_remaches" class="input" onkeyup="costos(cu_remaches.value, this.value, t_remaches); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Remaches"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Remaches.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Remaches"].'" type="text" name="t_remaches" id="t_remaches" class="input" value="0"';if($ResCosto["Check_Remaches"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Remaches.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Remaches"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Remaches\')">Pagado<span>'.$ResCosto["P_Comen_Remaches"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Cierre='#a9a9a9';
	if($ResCosto["Check_Cierre"]==0 AND $ResCosto["P_Cierre"]=="No Pagado"){$bgcolor_Cierre='#a9a9a9';}
	if($ResCosto["Check_Cierre"]==0 AND $ResCosto["P_Cierre"]=="Pagado"){$bgcolor_Cierre='#fc97a9';}
	if($ResCosto["Check_Cierre"]==1 AND $ResCosto["P_Cierre"]=="No Pagado"){$bgcolor_Cierre='#cccccc';}
	if($ResCosto["Check_Cierre"]==1 AND $ResCosto["P_Cierre"]=="Pagado"){$bgcolor_Cierre='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cierre.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Cierre\')">Cierre: <span>'.$ResCosto["Comen_Cierre"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cierre.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Cierre"].'" type="text" name="cu_cierre" id="cu_cierre" class="input" onkeyup="costos(this.value, c_cierre.value, t_cierre); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Cierre"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cierre.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Cierre"].'" type="text" name="c_cierre" id="c_cierre" class="input" onkeyup="costos(cu_cierre.value, this.value, t_cierre); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Cierre"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cierre.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Cierre"].'" type="text" name="t_cierre" id="t_cierre" class="input" value="0"';if($ResCosto["Check_Cierre"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Cierre.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Cierre"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Cierre\')">Pagado<span>'.$ResCosto["P_Comen_Cierre"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Bordado='#a9a9a9';
	if($ResCosto["Check_Bordado"]==0 AND $ResCosto["P_Bordado"]=="No Pagado"){$bgcolor_Bordado='#a9a9a9';}
	if($ResCosto["Check_Bordado"]==0 AND $ResCosto["P_Bordado"]=="Pagado"){$bgcolor_Bordado='#fc97a9';}
	if($ResCosto["Check_Bordado"]==1 AND $ResCosto["P_Bordado"]=="No Pagado"){$bgcolor_Bordado='#cccccc';}
	if($ResCosto["Check_Bordado"]==1 AND $ResCosto["P_Bordado"]=="Pagado"){$bgcolor_Bordado='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Bordado.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Bordado\')">Bordado: <span>'.$ResCosto["Comen_Bordado"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Bordado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Bordado"].'" type="text" name="cu_bordado" id="cu_bordado" class="input" onkeyup="costos(this.value, c_bordado.value, t_bordado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Bordado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Bordado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Bordado"].'" type="text" name="c_bordado" id="c_bordado" class="input" onkeyup="costos(cu_bordado.value, this.value, t_bordado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Bordado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Bordado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Bordado"].'" type="text" name="t_bordado" id="t_bordado" class="input" value="0"';if($ResCosto["Check_Bordado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Bordado.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Bordado"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Bordado\')">Pagado<span>'.$ResCosto["P_Comen_Bordado"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Cinturon='#a9a9a9';
	if($ResCosto["Check_Cinturon"]==0 AND $ResCosto["P_Cinturon"]=="No Pagado"){$bgcolor_Cinturon='#a9a9a9';}
	if($ResCosto["Check_Cinturon"]==0 AND $ResCosto["P_Cinturon"]=="Pagado"){$bgcolor_Cinturon='#fc97a9';}
	if($ResCosto["Check_Cinturon"]==1 AND $ResCosto["P_Cinturon"]=="No Pagado"){$bgcolor_Cinturon='#cccccc';}
	if($ResCosto["Check_Cinturon"]==1 AND $ResCosto["P_Cinturon"]=="Pagado"){$bgcolor_Cinturon='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cinturon.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Cinturon\')">Cinturon: <span>'.$ResCosto["Comen_Cinturon"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cinturon.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Cinturon"].'" type="text" name="cu_cinturon" id="cu_cinturon" class="input" onkeyup="costos(this.value, c_cinturon.value, t_cinturon); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Cinturon"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cinturon.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Cinturon"].'" type="text" name="c_cinturon" id="c_cinturon" class="input" onkeyup="costos(cu_cinturon.value, this.value, t_cinturon); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Cinturon"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Cinturon.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Cinturon"].'" type="text" name="t_cinturon" id="t_cinturon" class="input" value="0"';if($ResCosto["Check_Cinturon"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Cinturon.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Cinturon"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Cinturon\')">Pagado<span>'.$ResCosto["P_Comen_Cinturon"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaInternaBordada='#a9a9a9';
	if($ResCosto["Check_EtiquetaInternaBordada"]==0 AND $ResCosto["P_EtiquetaInternaBordada"]=="No Pagado"){$bgcolor_EtiquetaInternaBordada='#a9a9a9';}
	if($ResCosto["Check_EtiquetaInternaBordada"]==0 AND $ResCosto["P_EtiquetaInternaBordada"]=="Pagado"){$bgcolor_EtiquetaInternaBordada='#fc97a9';}
	if($ResCosto["Check_EtiquetaInternaBordada"]==1 AND $ResCosto["P_EtiquetaInternaBordada"]=="No Pagado"){$bgcolor_EtiquetaInternaBordada='#cccccc';}
	if($ResCosto["Check_EtiquetaInternaBordada"]==1 AND $ResCosto["P_EtiquetaInternaBordada"]=="Pagado"){$bgcolor_EtiquetaInternaBordada='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaInternaBordada.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaInternaBordada\')">Etiqueta interna o bordada: <span>'.$ResCosto["Comen_EtiquetaInternaBordada"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaInternaBordada.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaInternaBordada"].'" type="text" name="cu_etiqintbor" id="cu_etiqintbor" class="input" onkeyup="costos(this.value, c_etiqintbor.value, t_etiqintbor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaInternaBordada"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaInternaBordada.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaInternaBordada"].'" type="text" name="c_etiqintbor" id="c_etiqintbor" class="input" onkeyup="costos(cu_etiqintbor.value, this.value, t_etiqintbor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaInternaBordada"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaInternaBordada.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaInternaBordada"].'" type="text" name="t_etiqintbor" id="t_etiqintbor" class="input" value="0"';if($ResCosto["Check_EtiquetaInternaBordada"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaInternaBordada.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaInternaBordada"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaInternaBordada\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaInternaBordada"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Placa='#a9a9a9';
	if($ResCosto["Check_Placa"]==0 AND $ResCosto["P_Placa"]=="No Pagado"){$bgcolor_Placa='#a9a9a9';}
	if($ResCosto["Check_Placa"]==0 AND $ResCosto["P_Placa"]=="Pagado"){$bgcolor_Placa='#fc97a9';}
	if($ResCosto["Check_Placa"]==1 AND $ResCosto["P_Placa"]=="No Pagado"){$bgcolor_Placa='#cccccc';}
	if($ResCosto["Check_Placa"]==1 AND $ResCosto["P_Placa"]=="Pagado"){$bgcolor_Placa='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Placa.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Placa\')">Placa: <span>'.$ResCosto["Comen_Placa"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Placa.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Placa"].'" type="text" name="cu_placa" id="cu_placa" class="input" onkeyup="costos(this.value, c_placa.value, t_placa); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Placa"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Placa.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Placa"].'" type="text" name="c_placa" id="c_placa" class="input" onkeyup="costos(cu_placa.value, c_placa.value, t_placa); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Placa"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Placa.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Placa"].'" type="text" name="t_placa" id="t_placa" class="input" value="0"';if($ResCosto["Check_Placa"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Placa.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Placa"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Placa\')">Pagado<span>'.$ResCosto["P_Comen_Placa"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaTallaInterna='#a9a9a9';
	if($ResCosto["Check_EtiquetaTallaInterna"]==0 AND $ResCosto["P_EtiquetaTallaInterna"]=="No Pagado"){$bgcolor_EtiquetaTallaInterna='#a9a9a9';}
	if($ResCosto["Check_EtiquetaTallaInterna"]==0 AND $ResCosto["P_EtiquetaTallaInterna"]=="Pagado"){$bgcolor_EtiquetaTallaInterna='#fc97a9';}
	if($ResCosto["Check_EtiquetaTallaInterna"]==1 AND $ResCosto["P_EtiquetaTallaInterna"]=="No Pagado"){$bgcolor_EtiquetaTallaInterna='#cccccc';}
	if($ResCosto["Check_EtiquetaTallaInterna"]==1 AND $ResCosto["P_EtiquetaTallaInterna"]=="Pagado"){$bgcolor_EtiquetaTallaInterna='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaInterna.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaTallaInterna\')">Etiqueta de Talla Interna: <span>'.$ResCosto["Comen_EtiquetaTallaInterna"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaInterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaTallaInterna"].'" type="text" name="cu_etiqtallainterna" id="cu_etiqtallainterna" class="input" onkeyup="costos(this.value, c_etiqtallainterna.value, t_etiqtallainterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaTallaInterna"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaInterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaTallaInterna"].'" type="text" name="c_etiqtallainterna" id="c_etiqtallainterna" class="input" onkeyup="costos(cu_etiqtallainterna.value, this.value, t_etiqtallainterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaTallaInterna"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaInterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaTallaInterna"].'" type="text" name="t_etiqtallainterna" id="t_etiqtallainterna" class="input" value="0"';if($ResCosto["Check_EtiquetaTallaInterna"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaTallaInterna.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaTallaInterna"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaTallaInterna\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaTallaInterna"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaAdherible='#a9a9a9';
	if($ResCosto["Check_EtiquetaAdherible"]==0 AND $ResCosto["P_EtiquetaAdherible"]=="No Pagado"){$bgcolor_EtiquetaAdherible='#a9a9a9';}
	if($ResCosto["Check_EtiquetaAdherible"]==0 AND $ResCosto["P_EtiquetaAdherible"]=="Pagado"){$bgcolor_EtiquetaAdherible='#fc97a9';}
	if($ResCosto["Check_EtiquetaAdherible"]==1 AND $ResCosto["P_EtiquetaAdherible"]=="No Pagado"){$bgcolor_EtiquetaAdherible='#cccccc';}
	if($ResCosto["Check_EtiquetaAdherible"]==1 AND $ResCosto["P_EtiquetaAdherible"]=="Pagado"){$bgcolor_EtiquetaAdherible='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaAdherible.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaAdherible\')">Etiqueta Adherible: <span>'.$ResCosto["Comen_EtiquetaAdherible"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaAdherible.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaAdherible"].'" type="text" name="cu_etiqadherible" id="cu_etiqadherible" class="input" onkeyup="costos(this.value, c_etiqadherible.value, t_etiqadherible); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaAdherible"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaAdherible.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaAdherible"].'" type="text" name="c_etiqadherible" id="c_etiqadherible" class="input" onkeyup="costos(cu_etiqadherible.value, this.value, t_etiqadherible); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaAdherible"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaAdherible.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaAdherible"].'" type="text" name="t_etiqadherible" id="t_etiqadherible" class="input" value="0"';if($ResCosto["Check_EtiquetaAdherible"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaAdherible.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaAdherible"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaAdherible\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaAdherible"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaTallaExterna='#a9a9a9';
	if($ResCosto["Check_EtiquetaTallaExterna"]==0 AND $ResCosto["P_EtiquetaTallaExterna"]=="No Pagado"){$bgcolor_EtiquetaTallaExterna='#a9a9a9';}
	if($ResCosto["Check_EtiquetaTallaExterna"]==0 AND $ResCosto["P_EtiquetaTallaExterna"]=="Pagado"){$bgcolor_EtiquetaTallaExterna='#fc97a9';}
	if($ResCosto["Check_EtiquetaTallaExterna"]==1 AND $ResCosto["P_EtiquetaTallaExterna"]=="No Pagado"){$bgcolor_EtiquetaTallaExterna='#cccccc';}
	if($ResCosto["Check_EtiquetaTallaExterna"]==1 AND $ResCosto["P_EtiquetaTallaExterna"]=="Pagado"){$bgcolor_EtiquetaTallaExterna='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaExterna.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaTallaExterna\')">Etiqueta de Talla Externa: <span>'.$ResCosto["Comen_EtiquetaTallaExterna"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaExterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaTallaExterna"].'" type="text" name="cu_etiqtallaexterna" id="cu_etiqtallaexterna" class="input" onkeyup="costos(this.value, c_etiqtallaexterna.value, t_etiqtallaexterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaTallaExterna"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaExterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaTallaExterna"].'" type="text" name="c_etiqtallaexterna" id="c_etiqtallaexterna" class="input" onkeyup="costos(cu_etiqtallaexterna.value, this.value, t_etiqtallaexterna); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaTallaExterna"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaTallaExterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaTallaExterna"].'" type="text" name="t_etiqtallaexterna" id="t_etiqtallaexterna" class="input" value="0"';if($ResCosto["Check_EtiquetaTallaExterna"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaTallaExterna.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaTallaExterna"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaTallaExterna\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaTallaExterna"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaColgante='#a9a9a9';
	if($ResCosto["Check_EtiquetaColgante"]==0 AND $ResCosto["P_EtiquetaColgante"]=="No Pagado"){$bgcolor_EtiquetaColgante='#a9a9a9';}
	if($ResCosto["Check_EtiquetaColgante"]==0 AND $ResCosto["P_EtiquetaColgante"]=="Pagado"){$bgcolor_EtiquetaColgante='#fc97a9';}
	if($ResCosto["Check_EtiquetaColgante"]==1 AND $ResCosto["P_EtiquetaColgante"]=="No Pagado"){$bgcolor_EtiquetaColgante='#cccccc';}
	if($ResCosto["Check_EtiquetaColgante"]==1 AND $ResCosto["P_EtiquetaColgante"]=="Pagado"){$bgcolor_EtiquetaColgante='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaColgante.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaColgante\')">Etiqueta Colgante: <span>'.$ResCosto["Comen_EtiquetaColgante"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaColgante.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaColgante"].'" type="text" name="cu_etiqcolgante" id="cu_etiqcolgante" class="input" onkeyup="costos(this.value, c_etiqcolgane.value, t_etiqcolgante); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaColgante"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaColgante.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaColgante"].'" type="text" name="c_etiqcolgante" id="c_etiqcolgante" class="input" onkeyup="costos(cu_etiqcolgante.value, this.value, t_etiqcolgante); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaColgante"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaColgante.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaColgante"].'" type="text" name="t_etiqcolgante" id="t_etiqcolgante" class="input" value="0"';if($ResCosto["Check_EtiquetaColgante"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaColgante.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaColgante"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaColgante\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaColgante"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaMonarch='#a9a9a9';
	if($ResCosto["Check_EtiquetaMonarch"]==0 AND $ResCosto["P_EtiquetaMonarch"]=="No Pagado"){$bgcolor_EtiquetaMonarch='#a9a9a9';}
	if($ResCosto["Check_EtiquetaMonarch"]==0 AND $ResCosto["P_EtiquetaMonarch"]=="Pagado"){$bgcolor_EtiquetaMonarch='#fc97a9';}
	if($ResCosto["Check_EtiquetaMonarch"]==1 AND $ResCosto["P_EtiquetaMonarch"]=="No Pagado"){$bgcolor_EtiquetaMonarch='#cccccc';}
	if($ResCosto["Check_EtiquetaMonarch"]==1 AND $ResCosto["P_EtiquetaMonarch"]=="Pagado"){$bgcolor_EtiquetaMonarch='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaMonarch.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaMonarch\')">Etiqueta Monarch: <span>'.$ResCosto["Comen_EtiquetaMonarch"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaMonarch.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaMonarch"].'" type="text" name="cu_etiqmonarch" id="cu_etiqmonarch" class="input" onkeyup="costos(this.value, c_etiqmonarch.value, t_etiqmonarch); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaMonarch"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaMonarch.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaMonarch"].'" type="text" name="c_etiqmonarch" id="c_etiqmonarch" class="input" onkeyup="costos(cu_etiqmonarch.value, this.value, t_etiqmonarch); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_EtiquetaMonarch"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaMonarch.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaMonarch"].'" type="text" name="t_etiqmonarch" id="t_etiqmonarch" class="input" value="0"';if($ResCosto["Check_EtiquetaMonarch"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaMonarch.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaMonarch"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaMonarch\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaMonarch"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_EtiquetaPielExterna='#a9a9a9';
	if($ResCosto["Check_EtiquetaPielExterna"]==0 AND $ResCosto["P_EtiquetaPielExterna"]=="No Pagado"){$bgcolor_EtiquetaPielExterna='#a9a9a9';}
	if($ResCosto["Check_EtiquetaPielExterna"]==0 AND $ResCosto["P_EtiquetaPielExterna"]=="Pagado"){$bgcolor_EtiquetaPielExterna='#fc97a9';}
	if($ResCosto["Check_EtiquetaPielExterna"]==1 AND $ResCosto["P_EtiquetaPielExterna"]=="No Pagado"){$bgcolor_EtiquetaPielExterna='#cccccc';}
	if($ResCosto["Check_EtiquetaPielExterna"]==1 AND $ResCosto["P_EtiquetaPielExterna"]=="Pagado"){$bgcolor_EtiquetaPielExterna='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaPielExterna.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'EtiquetaPielExterna\')">Etiqueta de Piel Externa: <span>'.$ResCosto["Comen_EtiquetaPielExterna"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaPielExterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_EtiquetaPielExterna"].'" type="text" name="cu_etiquetapielexterna" id="cu_etiquetapielexterna" class="input" onkeyup="costos(this.value, c_etiquetapielexterna, t_etiquetapielexterna)"></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaPielExterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_EtiquetaPielExterna"].'" type="text" name="c_etiquetapielexterna" id="c_etiquetapielexterna" class="input" onkeyup="costos(cu_etiquetapielexterna.value, this.value, t_etiquetapielexterna)"></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_EtiquetaPielExterna.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_EtiquetaPielExterna"].'" type="text" name="t_etiquetapielexterna" id="t_etiquetapielexterna" class="input"></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_EtiquetaPielExterna.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_EtiquetaPielExterna"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'EtiquetaPielExterna\')">Pagado<span>'.$ResCosto["P_Comen_EtiquetaPielExterna"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Lavado='#a9a9a9';
	if($ResCosto["Check_Lavado"]==0 AND $ResCosto["P_Lavado"]=="No Pagado"){$bgcolor_Lavado='#a9a9a9';}
	if($ResCosto["Check_Lavado"]==0 AND $ResCosto["P_Lavado"]=="Pagado"){$bgcolor_Lavado='#fc97a9';}
	if($ResCosto["Check_Lavado"]==1 AND $ResCosto["P_Lavado"]=="No Pagado"){$bgcolor_Lavado='#cccccc';}
	if($ResCosto["Check_Lavado"]==1 AND $ResCosto["P_Lavado"]=="Pagado"){$bgcolor_Lavado='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Lavado.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Lavado\')">Lavado: <span>'.$ResCosto["Comen_Lavado"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Lavado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Lavado"].'" type="text" name="cu_lavado" id="cu_lavado" class="input" onkeyup="costos(this.value, c_lavado, t_lavado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Lavado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Lavado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Lavado"].'" type="text" name="c_lavado" id="c_lavado" class="input" onkeyup="costos(cu_lavado.value, this.value, t_lavado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Lavado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Lavado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Lavado"].'" type="text" name="t_lavado" id="t_lavado" class="input" value="0"';if($ResCosto["Check_Lavado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Lavado.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Lavado"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Lavado\')">Pagado<span>'.$ResCosto["P_Comen_Lavado"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Transfer='#a9a9a9';
	if($ResCosto["Check_Transfer"]==0 AND $ResCosto["P_Transfer"]=="No Pagado"){$bgcolor_Transfer='#a9a9a9';}
	if($ResCosto["Check_Transfer"]==0 AND $ResCosto["P_Transfer"]=="Pagado"){$bgcolor_Transfer='#fc97a9';}
	if($ResCosto["Check_Transfer"]==1 AND $ResCosto["P_Transfer"]=="No Pagado"){$bgcolor_Transfer='#cccccc';}
	if($ResCosto["Check_Transfer"]==1 AND $ResCosto["P_Transfer"]=="Pagado"){$bgcolor_Transfer='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transfer.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Transfer\')">Transfer: <span>'.$ResCosto["Comen_Transfer"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transfer.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Transfer"].'" type="text" name="cu_transfer" id="cu_transfer" class="input" onkeyup="costos(this.value, c_transfer.value, t_transfer); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Transfer"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transfer.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Transfer"].'" type="text" name="c_transfer" id="c_transfer" class="input" onkeyup="costos(cu_transfer.value, this.value, t_transfer); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Transfer"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transfer.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Transfer"].'" type="text" name="t_transfer" id="t_transfer" class="input" value="0"';if($ResCosto["Check_Transfer"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Transfer.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Transfer"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Transfer\')">Pagado<span>'.$ResCosto["P_Comen_Transfer"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Terminado='#a9a9a9';
	if($ResCosto["Check_Terminado"]==0 AND $ResCosto["P_Terminado"]=="No Pagado"){$bgcolor_Terminado='#a9a9a9';}
	if($ResCosto["Check_Terminado"]==0 AND $ResCosto["P_Terminado"]=="Pagado"){$bgcolor_Terminado='#fc97a9';}
	if($ResCosto["Check_Terminado"]==1 AND $ResCosto["P_Terminado"]=="No Pagado"){$bgcolor_Terminado='#cccccc';}
	if($ResCosto["Check_Terminado"]==1 AND $ResCosto["P_Terminado"]=="Pagado"){$bgcolor_Terminado='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Terminado.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Terminado\')">Terminado: <span>'.$ResCosto["Comen_Terminado"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Terminado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Terminado"].'" type="text" name="cu_terminado" id="cu_terminado" class="input" onkeyup="costos(this.value, c_terminado, t_terminado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Terminado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Terminado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Terminado"].'" type="text" name="c_terminado" id="c_terminado" class="input" onkeyup="costos(cu_terminado.value, this.value, t_terminado); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Terminado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Terminado.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Terminado"].'" type="text" name="t_terminado" id="t_terminado" class="input" value="0"';if($ResCosto["Check_Terminado"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Terminado.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Terminado"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Terminado\')">Pagado<span>'.$ResCosto["P_Comen_Terminado"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_Transporte='#a9a9a9';
	if($ResCosto["Check_Transporte"]==0 AND $ResCosto["P_Transporte"]=="No Pagado"){$bgcolor_Transporte='#a9a9a9';}
	if($ResCosto["Check_Transporte"]==0 AND $ResCosto["P_Transporte"]=="Pagado"){$bgcolor_Transporte='#fc97a9';}
	if($ResCosto["Check_Transporte"]==1 AND $ResCosto["P_Transporte"]=="No Pagado"){$bgcolor_Transporte='#cccccc';}
	if($ResCosto["Check_Transporte"]==1 AND $ResCosto["P_Transporte"]=="Pagado"){$bgcolor_Transporte='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transporte.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'Transporte\')">Transporte: <span>'.$ResCosto["Comen_Transporte"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transporte.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_Transporte"].'" type="text" name="cu_transporte" id="cu_transporte" class="input" onkeyup="costos(this.value, c_transporte, t_transporte); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Transporte"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transporte.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_Transporte"].'" type="text" name="c_transporte" id="c_transporte" class="input" onkeyup="costos(cu_transporte.value, this.value, t_transporte); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_Transporte"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_Transporte.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_Transporte"].'" type="text" name="t_transporte" id="t_transporte" class="input" value="0"';if($ResCosto["Check_Transporte"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_Transporte.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_Transporte"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'Transporte\')">Pagado<span>'.$ResCosto["P_Comen_Transporte"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_ComisionVendedor='#a9a9a9';
	if($ResCosto["Check_ComisionVendedor"]==0 AND $ResCosto["P_ComisionVendedor"]=="No Pagado"){$bgcolor_ComisionVendedor='#a9a9a9';}
	if($ResCosto["Check_ComisionVendedor"]==0 AND $ResCosto["P_ComisionVendedor"]=="Pagado"){$bgcolor_ComisionVendedor='#fc97a9';}
	if($ResCosto["Check_ComisionVendedor"]==1 AND $ResCosto["P_ComisionVendedor"]=="No Pagado"){$bgcolor_ComisionVendedor='#cccccc';}
	if($ResCosto["Check_ComisionVendedor"]==1 AND $ResCosto["P_ComisionVendedor"]=="Pagado"){$bgcolor_ComisionVendedor='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_ComisionVendedor.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'ComisionVendedor\')">Comisi�n Vendedor <span>'.$ResCosto["Comen_ComisionVendedor"].'</span></a> <select name="comven" id="comven" onchange="comision_vendedor(precioventa.value, this.value, cu_comisionvendedor); costos(cu_comisionvendedor.value, c_comisionvendedor.value, t_comisionvendedor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)">';
	for($i=0;$i<=20;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='		<option value="'.$i.'"';if($ResCosto["ComisionVendedor"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select> % : </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_ComisionVendedor.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_ComisionVendedor"].'" type="text" name="cu_comisionvendedor" id="cu_comisionvendedor" class="input"';if($ResCosto["Check_ComisionVendedor"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_ComisionVendedor.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_ComisionVendedor"].'" type="text" name="c_comisionvendedor" id="c_comisionvendedor" class="input" value="1" onkeyup="costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda)"';if($ResCosto["Check_ComisionVendedor"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_ComisionVendedor.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_ComisionVendedor"].'" type="text" name="t_comisionvendedor" id="t_comisionvendedor" class="input" value="0" onkeyup="cu_comisionvendedor.value=this.value; costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(this.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_ComisionVendedor"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_ComisionVendedor.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_ComisionVendedor"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'ComisionVendedor\')">Pagado<span>'.$ResCosto["P_Comen_ComisionVendedor"].'</span></a>';}$cadena.='</td>
				</tr>';
	$bgcolor_UtilidadGabriel='#a9a9a9';
	if($ResCosto["Check_UtilidadGabriel"]==0 AND $ResCosto["P_UtilidadGabriel"]=="No Pagado"){$bgcolor_UtilidadGabriel='#a9a9a9';}
	if($ResCosto["Check_UtilidadGabriel"]==0 AND $ResCosto["P_UtilidadGabriel"]=="Pagado"){$bgcolor_UtilidadGabriel='#fc97a9';}
	if($ResCosto["Check_UtilidadGabriel"]==1 AND $ResCosto["P_UtilidadGabriel"]=="No Pagado"){$bgcolor_UtilidadGabriel='#cccccc';}
	if($ResCosto["Check_UtilidadGabriel"]==1 AND $ResCosto["P_UtilidadGabriel"]=="Pagado"){$bgcolor_UtilidadGabriel='#ffc0cb';}
	$cadena.='	<tr>
					<td class="texto" align="right" bgcolor="'.$bgcolor_UtilidadGabriel.'" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\';xajax_costos_check(\''.$ResCosto["Id"].'\', \'UtilidadGabriel\')">Utilidad Arturo: <span>'.$ResCosto["Comen_UtilidadGabriel"].'</span></a> </td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_UtilidadGabriel.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["CU_UtilidadGabriel"].'" type="text" name="cu_utilidadgabriel" id="cu_utilidadgabriel" class="input" onkeyup=costos(this.value, c_utilidadgabriel.value, t_utilidadgabriel); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_UtilidadGabriel"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_UtilidadGabriel.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["C_UtilidadGabriel"].'" type="text" name="c_utilidadgabriel" id="c_utilidadgabriel" class="input" onkeyup="costos(cu_utilidadgabriel.value, this.value, t_utilidadgabriel); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqadherible.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(precioventa.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"';if($ResCosto["Check_UtilidadGabriel"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="right" bgcolor="'.$bgcolor_UtilidadGabriel.'" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["T_UtilidadGabriel"].'" type="text" name="t_utilidadgabriel" id="t_utilidadgabriel" class="input" value="0"';if($ResCosto["Check_UtilidadGabriel"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.=' readonly="readonly"';}$cadena.='></td>
					<td class="texto" align="center" bgcolor="'.$bgcolor_UtilidadGabriel.'" style="border:1px solid #FFFFFF">';if($ResCosto["P_UtilidadGabriel"]=='Pagado'){$cadena.='<a href="#" class="Ntooltip" onclick="document.getElementById(\'lightbox\').innerHTML = \'\'; lightbox.style.visibility=\'visible\'; xajax_comentarios_pago(\''.$ResCosto["Id"].'\', \'UtilidadGabriel\')">Pagado<span>'.$ResCosto["P_Comen_UtilidadGabriel"].'</span></a>';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td class="texto" colspan="2">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Costo Real: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="costoporprenda" id="costoporprenda" class="input" value="'.$ResCosto["CostoPrenda"].'"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["PrecioVenta"].'" type="text" name="precioventa" id="precioventa" class="input" onkeyup="comision_vendedor(this.value, comven.value, cu_comisionvendedor); costos(cu_comisionvendedor.value, c_comisionvendedor.value, t_comisionvendedor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(this.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad Por Pantalon: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["Utilidad"].'" type="text" name="utilidad" id="utilidad" class="input"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad total por modelo: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input value="'.$ResCosto["UtilidadReal"].'" type="text" name="utilidadreal" id="utilidadreal" class="input"></td>
							</tr>
						</table>
					</td>
					<td class="text" colspan="2" align="center">
						<input type="hidden" name="idcosto" id="idcosto" value="'.$ResCosto["Id"].'">';
	if($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=='asistente'){$cadena.='<input type="button" name="botadcosto" id="botadcosto" value="Guardar" class="boton" onclick="xajax_editar_costo_2(xajax.getFormValues(\'feditcosto\'))">';}
	$cadena.='		</td>
				</tr>
			</table>
			
			
		</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_costo_2($form)
{
	include ("conexion.php");
	
	mysql_query("UPDATE costos  SET Fecha='".date("Y-m-d")."', 
									MetrosEnviados='".$form["metrosenviados"]."', 
									Rendimiento='".$form["rendimiento"]."', 
									TotalPrendas='".$form["tprendas"]."', 
									ImporteTela='".$form["imptela"]."',
									CU_CostoTela='".$form["cu_costotela"]."', 
									C_CostoTela='".$form["c_costotela"]."', 
									T_CostoTela='".$form["t_costotela"]."', 
									CU_DisenoMolde='".$form["cu_disenomolde"]."',
									C_DisenoMolde='".$form["c_disenomolde"]."', 
									T_DisenoMolde='".$form["t_disenomolde"]."',
									CU_Maquila='".$form["cu_maquila"]."', 
									C_Maquila='".$form["c_maquila"]."', 
									T_Maquila='".$form["t_maquila"]."',
									CU_Boton='".$form["cu_boton"]."', 
									C_Boton='".$form["c_boton"]."', 
									T_Boton='".$form["t_boton"]."',
									CU_Remaches='".$form["cu_remaches"]."', 
									C_Remaches='".$form["c_remaches"]."', 
									T_Remaches='".$form["t_remaches"]."',
									CU_Cierre='".$form["cu_cierre"]."', 
									C_Cierre='".$form["c_cierre"]."', 
									T_Cierre='".$form["t_cierre"]."',
									CU_Bordado='".$form["cu_bordado"]."', 
									C_Bordado='".$form["c_bordado"]."', 
									T_Bordado='".$form["t_bordado"]."',
									CU_Cinturon='".$form["cu_cinturon"]."', 
									C_Cinturon='".$form["c_cinturon"]."', 
									T_Cinturon='".$form["t_cinturon"]."',
									CU_EtiquetaInternaBordada='".$form["cu_etiqintbor"]."', 
									C_EtiquetaInternaBordada='".$form["c_etiqintbor"]."', 
									T_EtiquetaInternaBordada='".$form["t_etiqintbor"]."', 
									CU_Placa='".$form["cu_placa"]."', 
									C_Placa='".$form["c_placa"]."', 
									T_Placa='".$form["t_placa"]."', 
									CU_EtiquetaTallaInterna='".$form["cu_etiqtallainterna"]."', 
									C_EtiquetaTallaInterna='".$form["c_etiqtallainterna"]."', 
									T_EtiquetaTallaInterna='".$form["t_etiqtallainterna"]."', 
									CU_EtiquetaAdherible='".$form["cu_etiqadherible"]."', 
									C_EtiquetaAdherible='".$form["c_etiqadherible"]."', 
									T_EtiquetaAdherible='".$form["t_etiqadherible"]."',
									CU_EtiquetaTallaExterna='".$form["cu_etiqtallaexterna"]."', 
									C_EtiquetaTallaExterna='".$form["c_etiqtallaexterna"]."', 
									T_EtiquetaTallaExterna='".$form["t_etiqtallaexterna"]."',
									CU_EtiquetaColgante='".$form["cu_etiqcolgante"]."', 
									C_EtiquetaColgante='".$form["c_etiqcolgante"]."', 
									T_EtiquetaColgante='".$form["t_etiqcolgante"]."',
									CU_EtiquetaMonarch='".$form["cu_etiqmonarch"]."', 
									C_EtiquetaMonarch='".$form["c_etiqmonarch"]."', 
									T_EtiquetaMonarch='".$form["t_etiqmonarch"]."',
									CU_EtiquetaPielExterna='".$form["cu_etiquetapielexterna"]."', 
									C_EtiquetaPielExterna='".$form["c_etiquetapielexterna"]."', 
									T_EtiquetaPielExterna='".$form["t_etiquetapielexterna"]."',
									CU_Lavado='".$form["cu_lavado"]."', 
									C_Lavado='".$form["c_lavado"]."', 
									T_Lavado='".$form["t_lavado"]."', 
									CU_Transfer='".$form["cu_transfer"]."', 
									C_Transfer='".$form["c_transfer"]."', 
									T_Transfer='".$form["t_transfer"]."', 
									CU_Terminado='".$form["cu_terminado"]."', 
									C_Terminado='".$form["c_terminado"]."', 
									T_Terminado='".$form["t_terminado"]."',
									CU_Transporte='".$form["cu_transporte"]."', 
									C_Transporte='".$form["c_transporte"]."', 
									T_Transporte='".$form["t_transporte"]."', 
									ComisionVendedor='".$form["comven"]."', 
									CU_ComisionVendedor='".$form["cu_comisionvendedor"]."', 
									C_ComisionVendedor='".$form["c_comisionvendedor"]."', 
									T_ComisionVendedor='".$form["t_comisionvendedor"]."',
									CU_UtilidadGabriel='".$form["cu_utilidadgabriel"]."', 
									C_UtilidadGabriel='".$form["c_utilidadgabriel"]."', 
									T_UtilidadGabriel='".$form["t_utilidadgabriel"]."',
									CostoPrenda='".$form["costoporprenda"]."', 
									PrecioVenta='".$form["precioventa"]."', 
									Utilidad='".$form["utilidad"]."', 
									UtilidadReal='".$form["utilidadreal"]."'
							 WHERE Id='".$form["idcosto"]."'") or die(mysql_error());
							 
	$cadena='<p align="center" class="textomensaje">Se actualizo el registro satisfactoriamente</p>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function costos_check($idcosto, $campo)
{
	include ("conexion.php");
	
	switch ($campo)
	{
		case 'CostoTela': $mostrar='Costo Tela'; break;
		case 'DisenoMolde': $mostrar='Dise�o Molde'; break;
		case 'Maquila': $mostrar='Maquila'; break;
		case 'Boton': $mostrar='Boton'; break;
		case 'Remaches': $mostrar='Remaches'; break;
		case 'Cierre': $mostrar='Cierre'; break;
		case 'Bordado': $mostrar='Bordado'; break;
		case 'Cinturon': $mostrar='Cinturon'; break;
		case 'EtiquetaInternaBordada': $mostrar='Etiqueta Interna o Bordada'; break;
		case 'Placa': $mostrar='Placa'; break;
		case 'EtiquetaTallaInterna': $mostrar='Etiqueta de Talla Interna'; break;
		case 'EtiquetaAdherible': $mostrar='Etiqueta Adherible'; break;
		case 'EtiquetaTallaExterna': $mostrar='Etiqueta de Talla Externa'; break;
		case 'EtiquetaColgante': $mostrar='Etiqueta Colgante'; break;
		case 'EtiquetaMonarch': $mostrar='Etiqueta Monarch'; break;
		case 'Lavado': $mostrar='Lavado'; break;
		case 'Transfer': $mostrar='Transfer'; break;
		case 'Terminado': $mostrar='Terminado'; break;
		case 'Transporte': $mostrar='Transporte'; break;
		case 'ComisionVendedor': $mostrar='Comision Vendedor'; break;
		case 'UtilidadGabriel': $mostrar='Utilidad Gabriel'; break;
	}
	
	$ResCosto=mysql_fetch_array(mysql_query("SELECT Id, P_".$campo.", Comen_".$campo.", Check_".$campo." FROM costos WHERE Id='".$idcosto."' LIMIT 1"));
	
	$cadena='<form name="feditcampo" id="feditcampo" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF" colspan="2">'.$mostrar.'</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="status" id="status" class="input">
							<option value="No Pagado"';if($ResCosto["P_".$campo]=='No Pagado'){$cadena.=' selected';}$cadena.='>No Pagado</option>
							<option value="Pagado"';if($ResCosto["P_".$campo]=='Pagado'){$cadena.=' selected';}$cadena.='>Pagado</option>
						</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="checkbox" name="check" id="check" value="1"';if($ResCosto["Check_".$campo]=='1'){$cadena.=' checked';}$cadena.='>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="texto">
						Comentarios<br /><textarea name="comentarios" id="comentarios" cols="50" rows="3">'.$ResCosto["Comen_".$campo].'</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="texto">';
		if($ResCosto["Check_".$campo]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="button" name="boteditcampo" id="boteditcampo" value="Guardar>>" onclick="lightbox.style.visibility=\'hidden\'; xajax_editar_costo(\''.$idcosto.'\', \''.$campo.'\', xajax.getFormValues(\'feditcampo\'))">';}
		elseif($ResCosto["Check_".$campo]==0){$cadena.='<input type="button" name="boteditcampo" id="boteditcampo" value="Guardar>>" onclick="lightbox.style.visibility=\'hidden\'; xajax_editar_costo(\''.$idcosto.'\', \''.$campo.'\', xajax.getFormValues(\'feditcampo\'))">';}
		elseif($ResCosto["Check_".$campo]==1 AND $_SESSION["perfil"]!='administra'){$cadena.='';}
		$cadena.='	</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function comentarios_costo($costo)
{
	include ("conexion.php");
	
	$ResCosto=mysql_fetch_array(mysql_query("SELECT Id, ComModelo, Historico, AnnoHistorico, Check_Costo FROM costos WHERE Id='".$costo."' LIMIT 1"));
	
	$cadena='<form name="feditcomen" id="feditcomen" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="checkbox" name="historico" id="historico" value="1"';if($ResCosto["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
	for($i=date("Y"); $i>=2015; $i--)
	{
		$cadena.='			<option value="'.$i.'"';if($ResCosto["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check" id="check" value="1"';if($ResCosto["Check_Costo"]==1){$cadena.=' checked';}$cadena.='></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="texto">
						Comentarios<br /><textarea name="comentarios" id="comentarios" cols="30" rows="3">'.$ResCosto["ComModelo"].'</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="texto">
						<input type="button" name="boteditcomen" id="boteditcomen" value="Guardar>>" onclick="lightbox.style.visibility=\'hidden\'; xajax_editar_costo(\''.$costo.'\', \'\', \'\', xajax.getFormValues(\'feditcomen\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function comentarios_pago($idcosto, $campo)
{
	include ("conexion.php");
	
	switch ($campo)
	{
		case 'CostoTela': $mostrar='Costo Tela'; break;
		case 'DisenoMolde': $mostrar='Dise�o Molde'; break;
		case 'Maquila': $mostrar='Maquila'; break;
		case 'Boton': $mostrar='Boton'; break;
		case 'Remaches': $mostrar='Remaches'; break;
		case 'Cierre': $mostrar='Cierre'; break;
		case 'Bordado': $mostrar='Bordado'; break;
		case 'Cinturon': $mostrar='Cinturon'; break;
		case 'EtiquetaInternaBordada': $mostrar='Etiqueta Interna o Bordada'; break;
		case 'Placa': $mostrar='Placa'; break;
		case 'EtiquetaTallaInterna': $mostrar='Etiqueta de Talla Interna'; break;
		case 'EtiquetaAdherible': $mostrar='Etiqueta Adherible'; break;
		case 'EtiquetaTallaExterna': $mostrar='Etiqueta de Talla Externa'; break;
		case 'EtiquetaColgante': $mostrar='Etiqueta Colgante'; break;
		case 'EtiquetaMonarch': $mostrar='Etiqueta Monarch'; break;
		case 'Lavado': $mostrar='Lavado'; break;
		case 'Transfer': $mostrar='Transfer'; break;
		case 'Terminado': $mostrar='Terminado'; break;
		case 'Transporte': $mostrar='Transporte'; break;
		case 'ComisionVendedor': $mostrar='Comision Vendedor'; break;
		case 'UtilidadGabriel': $mostrar='Utilidad Gabriel'; break;
	}
	
	$ResCosto=mysql_fetch_array(mysql_query("SELECT Id, P_Comen_".$campo." FROM costos WHERE Id='".$idcosto."' LIMIT 1"));
	
	$cadena='<form name="feditcampop" id="feditcampop" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF" colspan="2">'.$mostrar.'</td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="texto">
						Comentarios<br /><textarea name="comentarios" id="comentarios" cols="50" rows="3">'.$ResCosto["P_Comen_".$campo].'</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="texto">
						<input type="button" name="boteditcampo" id="boteditcampo" value="Guardar>>" onclick="lightbox.style.visibility=\'hidden\'; xajax_editar_costo(\''.$idcosto.'\', \''.$campo.'\', \'\', \'\', xajax.getFormValues(\'feditcampop\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function eliminar_costo($costo, $borra='no')
{
	include ("conexion.php");
	
	$ResModelo=mysql_fetch_array(mysql_query("SELECT Id, Modelo FROM costos WHERE Id='".$costo."' LIMIT 1"));
	$ResModeloN=mysql_fetch_array(mysql_query("SELECT Nombre FROM telas WHERE Id='".$ResModelo["Modelo"]."' LIMIT 1"));
	
	if($borra=='no')
	{
		$cadena='<p align="center" class="textomensaje">Desea eliminar el costo del modelo '.$ResModeloN["Nombre"].'?<br />
				 <a href="#" onclick="xajax_costos()">NO</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_eliminar_costo(\''.$costo.'\', \'si\')">SI</a></p>';
	}
	elseif($borra=='si')
	{
		mysql_query("DELETE FROM costos WHERE Id='".$costo."'") or die(mysql_error());
		
		$cadena='<p align="center" class="textomensaje">Se elimino el costo del modelo '.$ResModeloN["Nombre"].' satisfactoriamente</p>';
	}
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function costos_pollos()
{
	include ("conexion.php");

	$cadena='<form name="fcostospollos" id="fcostospollos"><table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="13" align="right" class="texto">| <a href="#" onclick="xajax_agregar_costo_pollo()">Agregar Costo</a> | <a href="#" onclick="xajax_guardar_proyeccion(xajax.getFormValues(\'fcostospollos\'))">Guardar meta</a> |</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PRODUCTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COSTO REAL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PRECIO VENTA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">META DIARIA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COSTO DIARIO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTA DIARIA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">GANANCIA DIARIA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COSTO MENSUAL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTA MENSUAL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">GANANCIA MENSUAL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
			
	$ResPollos = mysql_query("SELECT Id, Producto, PrecioVenta, Total, Proyeccion, Ganancia FROM costos_pollos WHERE IdProducto IS NULL AND Activo = 1 ORDER BY Id ASC"); 
	$i=1; $costoTotal=0; $gananciaTotalDiaria=0; $gananciaTotalMensual=0; $costoTotalMensual=0; $ventaDiaria=0; $ventaTotalMensual=0;
	while($RResP = mysql_fetch_array($ResPollos))
	{
		//$ResCosto = mysql_fetch_array(mysql_query("SELECT SUM(Total) AS CostoReal FROM costos_pollos WHERE IdProducto = '".$RResP["Id"]."'"));

		$costodiario = $RResP["Total"] * $RResP["Proyeccion"];
		$ventadiaria = $RResP["PrecioVenta"] * $RResP["Proyeccion"];
		$gananciadiaria = $ventadiaria - $costodiario;
		$costomensual = $costodiario * 30;
		$ventamensual = $ventadiaria * 30;
		$gananciamensual = $gananciadiaria * 30;
		$cadena.='<tr>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$i.'</td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$RResP["Producto"].'</td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ '.number_format($RResP["Total"], 2).'<input type="hidden" name="tprod_'.$RResP["Id"].'" id="tprod_'.$RResP["Id"].'" value="'.$RResP["Total"].'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ '.number_format($RResP["PrecioVenta"], 2).'<input type="hidden" name="gprod_'.$RResP["Id"].'" id="gprod_'.$RResP["Id"].'" value="'.$RResP["PrecioVenta"].'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input" name="proyeccion_'.$RResP["Id"].'" id="proyeccion_'.$RResP["Id"].'" value="'.$RResP["Proyeccion"].'" 
							onkeyup="costo_ganancia_proyeccion(parseFloat(tprod_'.$RResP["Id"].'.value), parseFloat(this.value), costop_'.$RResP["Id"].'); 
								ganancia_ganancia_proyeccion(parseFloat(proyeccion_'.$RResP["Id"].'.value), parseFloat(gprod_'.$RResP["Id"].'.value), parseFloat(tprod_'.$RResP["Id"].'.value), gananciap_'.$RResP["Id"].'); 
								ganancia_ganancia_mensual(parseFloat(gananciap_'.$RResP["Id"].'.value), gananciam_'.$RResP["Id"].');
								costo_ganancia_proyeccion(parseFloat(gprod_'.$RResP["Id"].'.value), parseFloat(proyeccion_'.$RResP["Id"].'.value), ventad_'.$RResP["Id"].');
								ganancia_ganancia_mensual(parseFloat(costop_'.$RResP["Id"].'.value), costom_'.$RResP["Id"].');
								ganancia_ganancia_mensual(parseFloat(ventad_'.$RResP["Id"].'.value), ventam_'.$RResP["Id"].');
								actualizarTotales()"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input c_m" name="costop_'.$RResP["Id"].'" id="costop_'.$RResP["Id"].'" value="'.$costodiario.'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input" name="ventad_'.$RResP["Id"].'" id="ventad_'.$RResP["Id"].'" value="'.(isset($RResP["Proyeccion"]) ? $ventadiaria : '').'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input t_g_d" name="gananciap_'.$RResP["Id"].'" id="gananciap_'.$RResP["Id"].'" value="'.(isset($RResP["Proyeccion"]) ? $gananciadiaria : '').'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input t_c_m" name="costom_'.$RResP["Id"].'" id="costom_'.$RResP["Id"].'" value="'.(isset($RResP["Proyeccion"]) ? $costomensual : '').'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input t_v_m" name="ventam_'.$RResP["Id"].'" id="ventam_'.$RResP["Id"].'" value="'.(isset($RResP["Proyeccion"]) ? $ventamensual : '').'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" class="input t_g_m" name="gananciam_'.$RResP["Id"].'" id="gananciam_'.$RResP["Id"].'" value="'.(isset($RResP["Proyeccion"]) ? $gananciamensual : '').'"></td>
					<td class="texto" align="center" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_editar_costo_pollo(\''.$RResP["Id"].'\')"><img src="images/edit.png"></a></td>
					<td class="texto" align="center" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_eliminar_costo_pollos(\''.$RResP["Id"].'\')"><img src="images/x.png"></a></td>
				</tr>';
		$i++; 
		$costoTotal = $costoTotal + $costodiario; 
		$gananciaTotalDiaria = $gananciaTotalDiaria + $gananciadiaria; 
		$ventaDiaria = $ventaDiaria + $ventadiaria;
		$gananciaTotalMensual = $gananciaTotalMensual + $gananciamensual;
		$costoTotalMensual = $costoTotalMensual + $costomensual;
		$ventaTotalMensual = $ventaTotalMensual + $ventamensual;
	}
	$cadena.='	<tr>
					<td class="texto" colspan="4" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff">Totales:</td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_meta_diaria" id="total_meta_diaria"></td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_costo_meta" id="total_costo_meta" value="'.$costoTotal.'"></td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_costo_meta" id="total_costo_meta" value="'.$ventaDiaria.'"></td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_ganancia_diaria" id="total_ganancia_diaria" value="'.$gananciaTotalDiaria.'"></td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_costo_mensual" id="total_costo_mensual" value="'.$costoTotalMensual.'"></td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_venta_mensual" id="total_venta_mensual" value="'.$ventaTotalMensual.'"></td>
					<td class="texto" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"><input type="text" class="input" name="total_ganancia_mensual" id="total_ganancia_mensual" value="'.$gananciaTotalMensual.'"></td>
					<td class="texto" colspan="2" align="right" bgcolor="#cccccc" style="border:1px solid #ffffff"></td>
				</tr>
			</table></form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_costo_pollo()
{
	include ("conexion.php");

	$cadena='<form name="fadcostopollo" id="fadcostopollo">
			<table style="border:1px solid #FFFFFF; width: 60%;" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td align="left" class="texto" colspan="6">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left" width="100%">
							<tr>
								<td colspan="3" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Costo Real</td>
							</tr>
							<tr>
								<td class="texto" width="20%" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Producto: </td>
								<td class="texto" width="80%" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="producto" id="producto" class="input" value="'.$producto.'" style="width: 98%"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="texto3" width="50%" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Producto</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Costo Unidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Cantidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Precio Venta</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Total</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Ganancia</td>
				</tr>';
	for($i=1; $i<=20; $i++)
	{
		$cadena.='<tr>
					<td class="texto" width="50%" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" name="matprim_'.$i.'" id="matprim_'.$i.'" class="input" style="width:98%"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" name="costo_'.$i.'" id="costo_'.$i.'" class="input" 
							onkeyup="costos(this.value, cantidad_'.$i.'.value, total_'.$i.');
								costo_prenda(parseFloat(total_1.value) || 0, parseFloat(total_2.value) || 0, parseFloat(total_3.value) || 0, parseFloat(total_4.value) || 0, parseFloat(total_5.value) || 0, parseFloat(total_6.value) || 0, parseFloat(total_7.value) || 0, parseFloat(total_8.value) || 0, parseFloat(total_9.value) || 0, parseFloat(total_10.value) || 0, parseFloat(total_11.value) || 0, parseFloat(total_12.value) || 0, parseFloat(total_13.value) || 0, parseFloat(total_14.value) || 0, parseFloat(total_15.value) || 0, parseFloat(total_16.value) || 0, parseFloat(total_17.value) || 0, parseFloat(total_18.value) || 0, parseFloat(total_19.value) || 0, parseFloat(total_20.value) || 0, 0, 0, costoporprenda); 
								ganancia(parseFloat(precioventa_'.$i.'.value) || 0, parseFloat(total_'.$i.'.value) || 0, ganancia_'.$i.'); 
								utilidad_pollo(parseFloat(ganancia_1.value), parseFloat(ganancia_2.value), parseFloat(ganancia_3.value), parseFloat(ganancia_4.value), parseFloat(ganancia_5.value), parseFloat(ganancia_6.value), parseFloat(ganancia_7.value), parseFloat(ganancia_8.value), parseFloat(ganancia_9.value), parseFloat(ganancia_10.value), parseFloat(ganancia_11.value), parseFloat(ganancia_12.value), parseFloat(ganancia_13.value), parseFloat(ganancia_14.value), parseFloat(ganancia_15.value), parseFloat(ganancia_16.value), parseFloat(ganancia_17.value), parseFloat(ganancia_18.value), parseFloat(ganancia_19.value), parseFloat(ganancia_20.value), utilidadtotal)">
					</td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" name="cantidad_'.$i.'" id="cantidad_'.$i.'" class="input" 
							onkeyup="costos(costo_'.$i.'.value, this.value, total_'.$i.');
								costo_prenda(parseFloat(total_1.value), parseFloat(total_2.value), parseFloat(total_3.value), parseFloat(total_4.value), parseFloat(total_5.value), parseFloat(total_6.value), parseFloat(total_7.value), parseFloat(total_8.value), parseFloat(total_9.value), parseFloat(total_10.value), parseFloat(total_11.value), parseFloat(total_12.value), parseFloat(total_13.value), parseFloat(total_14.value), parseFloat(total_15.value), parseFloat(total_16.value), parseFloat(total_17.value), parseFloat(total_18.value), parseFloat(total_19.value), parseFloat(total_20.value), 0, 0, costoporprenda); 
								ganancia(parseFloat(precioventa_'.$i.'.value) || 0, parseFloat(total_'.$i.'.value) || 0, ganancia_'.$i.');
								utilidad_pollo(parseFloat(ganancia_1.value), parseFloat(ganancia_2.value), parseFloat(ganancia_3.value), parseFloat(ganancia_4.value), parseFloat(ganancia_5.value), parseFloat(ganancia_6.value), parseFloat(ganancia_7.value), parseFloat(ganancia_8.value), parseFloat(ganancia_9.value), parseFloat(ganancia_10.value), parseFloat(ganancia_11.value), parseFloat(ganancia_12.value), parseFloat(ganancia_13.value), parseFloat(ganancia_14.value), parseFloat(ganancia_15.value), parseFloat(ganancia_16.value), parseFloat(ganancia_17.value), parseFloat(ganancia_18.value), parseFloat(ganancia_19.value), parseFloat(ganancia_20.value), utilidadtotal)">
					</td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" name="precioventa_'.$i.'" id="precioventa_'.$i.'" class="input" 
							onkeyup="precio_venta(parseFloat(precioventa_1.value) || 0, parseFloat(precioventa_2.value) || 0, parseFloat(precioventa_3.value) || 0, parseFloat(precioventa_4.value) || 0, parseFloat(precioventa_5.value) || 0, parseFloat(precioventa_6.value) || 0, parseFloat(precioventa_7.value) || 0, parseFloat(precioventa_8.value) || 0, parseFloat(precioventa_9.value) || 0, parseFloat(precioventa_10.value) || 0, parseFloat(precioventa_11.value) || 0, parseFloat(precioventa_12.value) || 0, parseFloat(precioventa_13.value) || 0, parseFloat(precioventa_14.value) || 0, parseFloat(precioventa_15.value) || 0, parseFloat(precioventa_16.value) || 0, parseFloat(precioventa_17.value) || 0, parseFloat(precioventa_18.value) || 0, parseFloat(precioventa_19.value) || 0, parseFloat(precioventa_20.value) || 0, precioventa); 
								ganancia(parseFloat(precioventa_'.$i.'.value) || 0, parseFloat(total_'.$i.'.value) || 0, ganancia_'.$i.');
								utilidad_pollo(parseFloat(ganancia_1.value), parseFloat(ganancia_2.value), parseFloat(ganancia_3.value), parseFloat(ganancia_4.value), parseFloat(ganancia_5.value), parseFloat(ganancia_6.value), parseFloat(ganancia_7.value), parseFloat(ganancia_8.value), parseFloat(ganancia_9.value), parseFloat(ganancia_10.value), parseFloat(ganancia_11.value), parseFloat(ganancia_12.value), parseFloat(ganancia_13.value), parseFloat(ganancia_14.value), parseFloat(ganancia_15.value), parseFloat(ganancia_16.value), parseFloat(ganancia_17.value), parseFloat(ganancia_18.value), parseFloat(ganancia_19.value), parseFloat(ganancia_20.value), utilidadtotal)"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="total_'.$i.'" id="total_'.$i.'" class="input" value="0"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="ganancia_'.$i.'" id="ganancia_'.$i.'" class="input" value="0"></td>
				</tr>';
	}
	$cadena.='	<tr>
					<td colspan="2" class="texto" align="left">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Costo Real: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="costoporprenda" id="costoporprenda" class="input"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="precioventa" id="precioventa" class="input" onkeyup="comision_vendedor(this.value, comven.value, cu_comisionvendedor); costos(cu_comisionvendedor.value, c_comisionvendedor.value, t_comisionvendedor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(this.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="utilidadtotal" id="utilidadtotal" class="input" value="0"></td>
							</tr>
						</table>
					</td>
					<td colspan="2" class="texto" align="center">
						<input type="button" name="botadcosto" id="botadcosto" value="Guardar" class="boton" onclick="xajax_agregar_costo_pollo_detalle(xajax.getFormValues(\'fadcostopollo\'))">
					</td>
				</tr>
			</table>
			</form>';


	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_costo_pollo_detalle($form)
{
	include ("conexion.php");

	mysql_query("INSERT INTO costos_pollos (Producto, Costo, Cantidad, Total, PrecioVenta, Ganancia, Fecha, Activo) 
									VALUES ('".$form["producto"]."', '".$form["costoporprenda"]."', '1', '".$form["costoporprenda"]."', '".$form["precioventa"]."', '".$form["utilidadtotal"]."', '".date("Y-m-d")."', '1')");

	$ResIdPollo = mysql_fetch_array(mysql_query("SELECT Id FROM costos_pollos WHERE Producto = '".$form["producto"]."' ORDER BY Id DESC LIMIT 1"));

	$IdP = $ResIdPollo["Id"];

	for($i=1; $i<=20; $i++)
	{
		//if($form["matprim_".$i]!=NULL AND $fomr["matprim_".$i]!='')
		//{
			mysql_query("INSERT INTO costos_pollos (IdProducto, Producto, Costo, Cantidad, PrecioVenta, Total, Ganancia, Fecha) 
										VALUES ('".$IdP."', '".$form["matprim_".$i]."', '".$form["costo_".$i]."', '".$form["cantidad_".$i]."', '".$form["precioventa_".$i]."', '".$form["total_".$i]."', '".$form["ganancia_".$i]."', '".date("Y-m-d")."')");
		//}			
	}

	$cadena='<p align="center" class="textomensaje">Se agrego el producto '.$producto.' satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}

function eliminar_costo_pollos($costo, $borra='no')
{
	include ("conexion.php");
	
	$ResPollo=mysql_fetch_array(mysql_query("SELECT Id, Producto FROM costos_pollos WHERE Id='".$costo."' LIMIT 1"));
	
	if($borra=='no')
	{
		$cadena='<p align="center" class="textomensaje">Desea eliminar el producto '.$ResPollo["Producto"].'?<br />
				 <a href="#" onclick="xajax_costos_pollos()">NO</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_eliminar_costo_pollos(\''.$costo.'\', \'si\')">SI</a></p>';
	}
	elseif($borra=='si')
	{
		mysql_query("DELETE FROM costos_pollos WHERE Id='".$costo."'") or die(mysql_error());
		
		$cadena='<p align="center" class="textomensaje">Se elimino el producto '.$Respollo["Producto"].' satisfactoriamente</p>';
	}
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_costo_pollo($idp)
{
	include ("conexion.php");

	$ResCP=mysql_fetch_array(mysql_query("SELECT Id, Producto, PrecioVenta, Total, ProductoOrigen, Ganancia FROM costos_pollos WHERE Id='".$idp."' LIMIT 1"));	

	$cadena='<form name="fadcostopollo" id="fadcostopollo">
			<table style="border:1px solid #FFFFFF; width: 60%;" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td align="left" class="texto" colspan="6">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left" width="100%">
							<tr>
								<td colspan="3" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Costo Real</td>
							</tr>
							<tr>
								<td class="texto" width="20%" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Producto: </td>
								<td class="texto" width="80%" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="producto" id="producto" class="input" value="'.$ResCP["Producto"].'" style="width: 98%"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Producto</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Costo Unidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Cantidad</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Precio Venta</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Total</td>
					<td class="texto3" align="center" bgcolor="#5263ab" style="border:1px solid #FFFFFF">Ganancia</td>
				</tr>';
	$ResDCP = mysql_query("SELECT * FROM costos_pollos WHERE IdProducto = '".$ResCP["Id"]."' AND Producto != 'ComisionVendedor' ORDER BY Id ASC");
	$i=1;
	while($RResDCP = mysql_fetch_array($ResDCP))
	{
		$cadena.='<tr>
					<td class="texto" width="50%" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="text" name="matprim_'.$i.'" id="matprim_'.$i.'" class="input" style="width:98%" value="'.$RResDCP["Producto"].'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="number" name="costo_'.$i.'" id="costo_'.$i.'" class="input" value="'.$RResDCP["Costo"].'"
							onkeyup="costos(this.value, cantidad_'.$i.'.value, total_'.$i.');
								costo_prenda(parseFloat(total_1.value), parseFloat(total_2.value), parseFloat(total_3.value), parseFloat(total_4.value), parseFloat(total_5.value), parseFloat(total_6.value), parseFloat(total_7.value), parseFloat(total_8.value), parseFloat(total_9.value), parseFloat(total_10.value), parseFloat(total_11.value), parseFloat(total_12.value), parseFloat(total_13.value), parseFloat(total_14.value), parseFloat(total_15.value), parseFloat(total_16.value), parseFloat(total_17.value), parseFloat(total_18.value), parseFloat(total_19.value), parseFloat(total_20.value), 0, 0, costoporprenda); 
								ganancia(parseFloat(precioventa_'.$i.'.value) || 0, parseFloat(total_'.$i.'.value) || 0, ganancia_'.$i.'); 
								utilidad_pollo(parseFloat(ganancia_1.value), parseFloat(ganancia_2.value), parseFloat(ganancia_3.value), parseFloat(ganancia_4.value), parseFloat(ganancia_5.value), parseFloat(ganancia_6.value), parseFloat(ganancia_7.value), parseFloat(ganancia_8.value), parseFloat(ganancia_9.value), parseFloat(ganancia_10.value), parseFloat(ganancia_11.value), parseFloat(ganancia_12.value), parseFloat(ganancia_13.value), parseFloat(ganancia_14.value), parseFloat(ganancia_15.value), parseFloat(ganancia_16.value), parseFloat(ganancia_17.value), parseFloat(ganancia_18.value), parseFloat(ganancia_19.value), parseFloat(ganancia_20.value), utilidadtotal)">
					</td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="number" name="cantidad_'.$i.'" id="cantidad_'.$i.'" class="input" value="'.$RResDCP["Cantidad"].'"
							onkeyup="costos(costo_'.$i.'.value, this.value, total_'.$i.');
								costo_prenda(parseFloat(total_1.value), parseFloat(total_2.value), parseFloat(total_3.value), parseFloat(total_4.value), parseFloat(total_5.value), parseFloat(total_6.value), parseFloat(total_7.value), parseFloat(total_8.value), parseFloat(total_9.value), parseFloat(total_10.value), parseFloat(total_11.value), parseFloat(total_12.value), parseFloat(total_13.value), parseFloat(total_14.value), parseFloat(total_15.value), parseFloat(total_16.value), parseFloat(total_17.value), parseFloat(total_18.value), parseFloat(total_19.value), parseFloat(total_20.value), 0, 0, costoporprenda); 
								ganancia(parseFloat(precioventa_'.$i.'.value) || 0, parseFloat(total_'.$i.'.value) || 0, ganancia_'.$i.');
								utilidad_pollo(parseFloat(ganancia_1.value), parseFloat(ganancia_2.value), parseFloat(ganancia_3.value), parseFloat(ganancia_4.value), parseFloat(ganancia_5.value), parseFloat(ganancia_6.value), parseFloat(ganancia_7.value), parseFloat(ganancia_8.value), parseFloat(ganancia_9.value), parseFloat(ganancia_10.value), parseFloat(ganancia_11.value), parseFloat(ganancia_12.value), parseFloat(ganancia_13.value), parseFloat(ganancia_14.value), parseFloat(ganancia_15.value), parseFloat(ganancia_16.value), parseFloat(ganancia_17.value), parseFloat(ganancia_18.value), parseFloat(ganancia_19.value), parseFloat(ganancia_20.value), utilidadtotal)">
					</td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="number" name="precioventa_'.$i.'" id="precioventa_'.$i.'" class="input" value="'.$RResDCP["PrecioVenta"].'"
							onkeyup="precio_venta(parseFloat(precioventa_1.value) || 0, parseFloat(precioventa_2.value) || 0, parseFloat(precioventa_3.value) || 0, parseFloat(precioventa_4.value) || 0, parseFloat(precioventa_5.value) || 0, parseFloat(precioventa_6.value) || 0, parseFloat(precioventa_7.value) || 0, parseFloat(precioventa_8.value) || 0, parseFloat(precioventa_9.value) || 0, parseFloat(precioventa_10.value) || 0, parseFloat(precioventa_11.value) || 0, parseFloat(precioventa_12.value) || 0, parseFloat(precioventa_13.value) || 0, parseFloat(precioventa_14.value) || 0, parseFloat(precioventa_15.value) || 0, parseFloat(precioventa_16.value) || 0, parseFloat(precioventa_17.value) || 0, parseFloat(precioventa_18.value) || 0, 	parseFloat(precioventa_19.value) || 0, parseFloat(precioventa_20.value) || 0, precioventa); 
								ganancia(parseFloat(precioventa_'.$i.'.value) || 0, parseFloat(total_'.$i.'.value) || 0, ganancia_'.$i.');
								utilidad_pollo(parseFloat(ganancia_1.value) || 0, 
												parseFloat(ganancia_2.value) || 0, 
												parseFloat(ganancia_3.value) || 0, 
												parseFloat(ganancia_4.value) || 0, 
												parseFloat(ganancia_5.value) || 0, 
												parseFloat(ganancia_6.value) || 0, 
												parseFloat(ganancia_7.value) || 0, 
												parseFloat(ganancia_8.value) || 0, 
												parseFloat(ganancia_9.value) || 0, 
												parseFloat(ganancia_10.value) || 0,
												parseFloat(ganancia_11.value) || 0, 
												parseFloat(ganancia_12.value) || 0, 
												parseFloat(ganancia_13.value) || 0, 
												parseFloat(ganancia_14.value) || 0, 
												parseFloat(ganancia_15.value) || 0, 
												parseFloat(ganancia_16.value) || 0, 
												parseFloat(ganancia_17.value) || 0, 
												parseFloat(ganancia_18.value) || 0, 
												parseFloat(ganancia_19.value) || 0, 
												parseFloat(ganancia_20.value) || 0, utilidadtotal);"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="number" name="total_'.$i.'" id="total_'.$i.'" class="input" value="'.$RResDCP["Total"].'"></td>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="number" name="ganancia_'.$i.'" id="ganancia_'.$i.'" class="input" value="'.$RResDCP["Ganancia"].'"></td>
				</tr>';
		$i++;
	}
	$cadena.='	<tr>
					<td colspan="2" class="texto" align="left">
						<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Costo Real: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="number" name="costoporprenda" id="costoporprenda" class="input" value="'.$ResCP["Total"].'"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="number" name="precioventa" id="precioventa" class="input"  value="'.$ResCP["PrecioVenta"].'" onkeyup="comision_vendedor(this.value, comven.value, cu_comisionvendedor); costos(cu_comisionvendedor.value, c_comisionvendedor.value, t_comisionvendedor); costo_prenda(parseFloat(t_costotela.value), parseFloat(t_disenomolde.value), parseFloat(t_maquila.value), parseFloat(t_boton.value), parseFloat(t_remaches.value), parseFloat(t_cierre.value), parseFloat(t_bordado.value), parseFloat(t_cinturon.value), parseFloat(t_etiqintbor.value), parseFloat(t_placa.value), parseFloat(t_etiqtallainterna.value), parseFloat(t_etiqtallaexterna.value), parseFloat(t_etiqcolgante.value), parseFloat(t_etiqmonarch.value), parseFloat(t_etiquetapielexterna.value), parseFloat(t_lavado.value), parseFloat(t_transfer.value), parseFloat(t_terminado.value), parseFloat(t_transporte.value), parseFloat(t_comisionvendedor.value), parseFloat(t_utilidadgabriel.value), costoporprenda); costo_utilidad(parseFloat(costoporprenda.value), parseFloat(this.value), utilidad); costo_utilidad_real(utilidad.value, tprendas.value, utilidadreal)"></td>
							</tr>
							<tr>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Utilidad: </td>
								<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="number" name="utilidadtotal" id="utilidadtotal" class="input" value="'.$ResCP["Ganancia"].'"></td>
							</tr>
						</table>
					</td>
					<td colspan="2" class="texto" align="center">
						<input type="hidden" name="prodorigen" id="prodorigen" value="'.($ResCP["ProductoOrigen"]==NULL ? $ResCP["Id"] : $ResCP["ProductoOrigen"]).'">
						<input type="hidden" name="idp" id="idp" value="'.$ResCP["Id"].'">
						<input type="button" name="botadcosto" id="botadcosto" value="Guardar" class="boton" onclick="xajax_editar_costo_pollo_2(xajax.getFormValues(\'fadcostopollo\'))">
					</td>
				</tr>
			</table>
			</form>';
	

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_costo_pollo_2($form)
{
	include ("conexion.php");

	mysql_query("UPDATE costos_pollos SET Activo = 0 WHERE Id = '".$form["idp"]."'");

	mysql_query("INSERT INTO costos_pollos (Producto, Costo, Cantidad, Total, PrecioVenta, Ganancia, ProductoOrigen, Fecha, Activo) 
									VALUES ('".$form["producto"]."', '".$form["costoporprenda"]."', '1', '".$form["costoporprenda"]."', '".$form["precioventa"]."', '".$form["utilidadtotal"]."', '".$form["prodorigen"]."', '".date("Y-m-d")."', '1')");

	$ResIdPollo = mysql_fetch_array(mysql_query("SELECT Id FROM costos_pollos WHERE Producto = '".$form["producto"]."' AND Activo = 1 ORDER BY Id DESC LIMIT 1"));

	$IdP = $ResIdPollo["Id"];

	for($i=1; $i<=20; $i++)
	{
		//if($form["matprim_".$i]!=NULL AND $fomr["matprim_".$i]!='')
		//{
			mysql_query("INSERT INTO costos_pollos (IdProducto, Producto, Costo, Cantidad, Total, PrecioVenta, Ganancia, Fecha) 
										VALUES ('".$IdP."', '".$form["matprim_".$i]."', '".$form["costo_".$i]."', '".$form["cantidad_".$i]."', '".$form["total_".$i]."', '".$form["precioventa_".$i]."', '".$form["ganancia_".$i]."', '".date("Y-m-d")."')");
		//}			
	}

	$cadena='<p align="center" class="textomensaje">Se guardo el producto '.$producto.' satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function guardar_proyeccion($form)
{
	include ("conexion.php");

	$ResProd = mysql_query("SELECT Id FROM costos_pollos WHERE IdProducto IS NULL AND Activo = 1 ORDER BY Id ASC");

	while($RResP = mysql_fetch_array($ResProd))
	{
		mysql_query("UPDATE costos_pollos SET Proyeccion = '".$form["proyeccion_".$RResP["Id"]]."' WHERE Id = '".$RResP["Id"]."'");
	}

	$cadena='<p align="center" class="textomensaje">Meta guardada satisfactoriamente</p>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
?>