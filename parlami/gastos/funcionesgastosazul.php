<?php
function gastos_azul($accion=NULL, $form=NULL, $anno)
{
	include ("conexion.php");
	
	switch($accion)
	{	
		//Agregamos gasto
		case 'adgastoazul':
			//agrega el concepto
			mysql_query("INSERT INTO gastos (Tipo, Concepto, Aprox, Fijo)
									 VALUES ('azul',
											 '".utf8_decode($form["concepto"])."',
											 '".$form["aprox"]."',
											 '".$form["fijo"]."')") or die(mysql_error());
			$ResConcepto=mysql_fetch_array(mysql_query("SELECT Id FROM gastos ORDER BY Id DESC LIMIT 1"));
			//agrega el monto
			if(isset($form["cantidad"]))
			{
			mysql_query("INSERT INTO gastos_montos (IdGasto, Fecha, Vencimiento, Cantidad, Estado, Comentarios, checka)
											VALUES ('".$ResConcepto["Id"]."',
													'".$form["anno"]."-".$form["mes"]."-13',
													'".$form["annov"]."-".$form["mesv"]."-".$form["diav"]."',
													'".$form["cantidad"]."',
													'".$form["estado"]."',
													'".utf8_decode($form["comentarios"])."',
													'".$form["checka"]."')") or die(mysql_error());
			}
			break;
		//editar gasto, monto ya existente
		case 'editgastoazul':
			mysql_query("UPDATE gastos SET Concepto='".utf8_decode($form["concepto"])."',
										   Aprox='".$form["aprox"]."',
										   Fijo='".$form["fijo"]."'
									WHERE Id='".$form["idgasto"]."'")or die(mysql_error());
			if(isset($form["idmonto"]))
			{
				mysql_query("UPDATE gastos_montos SET Fecha='".$form["anno"]."-".$form["mes"]."-13',
													  Vencimiento='".$form["annov"]."-".$form["mesv"]."-".$form["diav"]."',
													  Cantidad='".$form["cantidad"]."',
													  Estado='".$form["estado"]."',
													  Comentarios='".utf8_decode($form["comentarios"])."',
													  checka='".$form["checka"]."'
												WHERE Id='".$form["idmonto"]."'")or die(mysql_error());
			}
			break;
		//editar gasto nuevo monto
		case 'editgastoazulnuevomonto':
			mysql_query("UPDATE gastos SET Concepto='".utf8_decode($form["concepto"])."',
										   Aprox='".$form["aprox"]."',
										   Fijo='".$form["fijo"]."'
									WHERE Id='".$form["idgasto"]."'")or die(mysql_error());
									
			if(isset($form["mes"]))
			{
			mysql_query("INSERT INTO gastos_montos (IdGasto, Fecha, Vencimiento, Cantidad, Estado, Comentarios, checka)
											VALUES ('".$form["idgasto"]."',
													'".$form["anno"]."-".$form["mes"]."-13',
													'".$form["annov"]."-".$form["mesv"]."-".$form["diav"]."',
													'".$form["cantidad"]."',
													'".$form["estado"]."',
													'".utf8_decode($form["comentarios"])."',
													'".$form["checka"]."')") or die(mysql_error());
			}
			break;
		//suma checks
		case 'sumachecks':
			$sumaenero=0;$sumafebrero=0;$sumamarzo=0;$sumaabril=0;$sumamayo=0;$sumajunio=0;$sumajulio=0;$sumaagosto=0;$sumaseptiembre=0;$sumaoctubre=0;$sumanoviembre=0;$sumadiciembre=0;
			$ResMontos=mysql_query("SELECT Id, Fecha, Cantidad WHERE Fecha LIKE '".$anno."-%' FROM gastos_montos ORDER BY Id ASC");
			while($RResMontos=mysql_fetch_array($ResMontos))
			{
				if($form["check_".$RResMontos["Id"]]==1)
				{
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='01'){$sumaenero=$sumaenero+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='02'){$sumafebrero=$sumafebrero+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='03'){$sumamarzo=$sumamarzo+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='04'){$sumaabril=$sumaabril+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='05'){$sumamayo=$sumamayo+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='06'){$sumajunio=$sumajunio+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='07'){$sumajulio=$sumajulio+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='08'){$sumaagosto=$sumaagosto+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='09'){$sumaseptiembre=$sumaseptiembre+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='10'){$sumaoctubre=$sumaoctubre+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='11'){$sumanoviembre=$sumanoviembre+$RResMontos["Cantidad"];}
					if($RResMontos["Fecha"][5].$RResMontos["Fecha"][6]=='12'){$sumadiciembre=$sumadiciembre+$RResMontos["Cantidad"];}
				}
			}
			break;
	}
	
	$cadena='<form name="fgastos" id="fgastos"><table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
				<tr>
					<td colspan="15" bgcolor="#ffffff" align="right" class="texto" style="border:1px solid #FFFFFF">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_gasto_azul(\''.$anno.'\')">Agregar Gasto</a> |</td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="15" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PARLAMI GASTOS MENSUALES <select name="anno" id="anno" onchange="xajax_gastos_azul(\'\',\'\',this.value)">';
						for($i=2014; $i<=(date("Y")+2);$i++)
						{
							$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
						}
						$cadena.='</select></td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ENERO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FEBRERO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">MARZO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ABRIL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">MAYO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">JUNIO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">JULIO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">AGOSTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SEPTIEMBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">OCTUBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOVIEMBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DICIEMBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TOTAL</td>
				</tr>';
	$ResGastos=mysql_query("SELECT * FROM gastos WHERE Tipo='azul' ORDER BY Concepto ASC");
	$A=1; $bgcolor="#CCCCCC"; $B=1;
	while($RResGastos=mysql_fetch_array($ResGastos))
	{
		$sumaconcepto=0;
		if($B==31)
		{
			$cadena.='<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CONCEPTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ENERO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FEBRERO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">MARZO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ABRIL</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">MAYO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">JUNIO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">JULIO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">AGOSTO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SEPTIEMBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">OCTUBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOVIEMBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DICIEMBRE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TOTAL</td>
				</tr>';	
			$B=1;
		}
		$ResEnero=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-01-%' LIMIT 1"));
		$ResFebrero=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-02-%' LIMIT 1"));
		$ResMarzo=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-03-%' LIMIT 1"));
		$ResAbril=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-04-%' LIMIT 1"));
		$ResMayo=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-05-%' LIMIT 1"));
		$ResJunio=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-06-%' LIMIT 1"));
		$ResJulio=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-07-%' LIMIT 1"));
		$ResAgosto=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-08-%' LIMIT 1"));
		$ResSeptiembre=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-09-%' LIMIT 1"));
		$ResOctubre=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-10-%' LIMIT 1"));
		$ResNoviembre=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-11-%' LIMIT 1"));
		$ResDiciembre=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE IdGasto='".$RResGastos["Id"]."' AND Fecha LIKE '".$anno."-12-%' LIMIT 1"));
		
		//colores
		//azul																											//ROSA	FFCOCB			 										//checa 													//no hay nada
		if($ResEnero["Estado"]=='VENCIDO' OR $ResEnero["Vencimiento"]<date("Y-m-d")){$bgcolorene='#00CED1';}			if($ResEnero["Estado"]=='PAGADO'){$bgcolorene='#DB7093';}		if($ResEnero["checka"]==1){$bgcolorene='#FFB6C1';}			if(!isset($ResEnero["Estado"])){$bgcolorene="#CCCCCC";} 		
		if($ResFebrero["Estado"]=='VENCIDO' OR $ResFebrero["Vencimiento"]<date("Y-m-d")){$bgcolorfeb='#00CED1';}		if($ResFebrero["Estado"]=='PAGADO'){$bgcolorfeb='#DB7093';}		if($ResFebrero["checka"]==1){$bgcolorfeb='#FFB6C1';}		if(!isset($ResFebrero["Estado"])){$bgcolorfeb="#CCCCCC";}		
		if($ResMarzo["Estado"]=='VENCIDO' OR $ResMarzo["Vencimiento"]<date("Y-m-d")){$bgcolormar='#00CED1';}			if($ResMarzo["Estado"]=='PAGADO'){$bgcolormar='#DB7093';}		if($ResMarzo["checka"]==1){$bgcolormar='#FFB6C1';}			if(!isset($ResMarzo["Estado"])){$bgcolormar="#CCCCCC";}			
		if($ResAbril["Estado"]=='VENCIDO' OR $ResAbril["Vencimiento"]<date("Y-m-d")){$bgcolorabr='#00CED1';}			if($ResAbril["Estado"]=='PAGADO'){$bgcolorabr='#DB7093';}		if($ResAbril["checka"]==1){$bgcolorabr='#FFB6C1';}			if(!isset($ResAbril["Estado"])){$bgcolorabr="#CCCCCC";}			
		if($ResMayo["Estado"]=='VENCIDO' OR $ResMayo["Vencimiento"]<date("Y-m-d")){$bgcolormay='#00CED1';}				if($ResMayo["Estado"]=='PAGADO'){$bgcolormay='#DB7093';}		if($ResMayo["checka"]==1){$bgcolormay='#FFB6C1';}			if(!isset($ResMayo["Estado"])){$bgcolormay="#CCCCCC";}			
		if($ResJunio["Estado"]=='VENCIDO' OR $ResJunio["Vencimiento"]<date("Y-m-d")){$bgcolorjun='#00CED1';}			if($ResJunio["Estado"]=='PAGADO'){$bgcolorjun='#DB7093';}		if($ResJunio["checka"]==1){$bgcolorjun='#FFB6C1';}			if(!isset($ResJunio["Estado"])){$bgcolorjun="#CCCCCC";}			
		if($ResJulio["Estado"]=='VENCIDO' OR $ResJulio["Vencimiento"]<date("Y-m-d")){$bgcolorjul='#00CED1';}			if($ResJulio["Estado"]=='PAGADO'){$bgcolorjul='#DB7093';}		if($ResJulio["checka"]==1){$bgcolorjul='#FFB6C1';}			if(!isset($ResJulio["Estado"])){$bgcolorjul="#CCCCCC";}			
		if($ResAgosto["Estado"]=='VENCIDO' OR $ResAgosto["Vencimiento"]<date("Y-m-d")){$bgcolorago='#00CED1';}			if($ResAgosto["Estado"]=='PAGADO'){$bgcolorago='#DB7093';}		if($ResAgosto["checka"]==1){$bgcolorago='#FFB6C1';}			if(!isset($ResAgosto["Estado"])){$bgcolorago="#CCCCCC";}		
		if($ResSeptiembre["Estado"]=='VENCIDO' OR $ResSeptiembre["Vencimiento"]<date("Y-m-d")){$bgcolorsep='#00CED1';}	if($ResSeptiembre["Estado"]=='PAGADO'){$bgcolorsep='#DB7093';}	if($ResSeptiembre["checka"]==1){$bgcolorsep='#FFB6C1';}		if(!isset($ResSeptiembre["Estado"])){$bgcolorsep="#CCCCCC";}	
		if($ResOctubre["Estado"]=='VENCIDO' OR $ResOctubre["Vencimiento"]<date("Y-m-d")){$bgcoloroct='#00CED1';}		if($ResOctubre["Estado"]=='PAGADO'){$bgcoloroct='#DB7093';}		if($ResOctubre["checka"]==1){$bgcoloroct='#FFB6C1';}		if(!isset($ResOctubre["Estado"])){$bgcoloroct="#CCCCCC";}		
		if($ResNoviembre["Estado"]=='VENCIDO' OR $ResNoviembre["Vencimiento"]<date("Y-m-d")){$bgcolornov='#00CED1';}	if($ResNoviembre["Estado"]=='PAGADO'){$bgcolornov='#DB7093';}	if($ResNoviembre["checka"]==1){$bgcolornov='#FFB6C1';}		if(!isset($ResNoviembre["Estado"])){$bgcolornov="#CCCCCC";}		
		if($ResDiciembre["Estado"]=='VENCIDO' OR $ResDiciembre["Vencimiento"]<date("Y-m-d")){$bgcolordic='#00CED1';}	if($ResDiciembre["Estado"]=='PAGADO'){$bgcolordic='#DB7093';}	if($ResDiciembre["checka"]==1){$bgcolordic='#FFB6C1';}		if(!isset($ResDiciembre["Estado"])){$bgcolordic="#CCCCCC";}		
		
		$cadena.='<tr>
					<td id="row_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="xajax_gastos_azul(\'checkall\', \''.$A.'\', \''.$anno.'\')">'.$A.'</a></td>
					
					<td id="con_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul_nuevo_monto(\''.$RResGastos["Id"].'\', \''.$anno.'\')">'.$RResGastos["Concepto"].'</a></td>'; $bgcolor="#CCCCCC";
		
		$cadena.='<td id="ene_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorene.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResEnero["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResEnero["Id"].'\', \''.$anno.'\')">$ '.number_format($ResEnero["Cantidad"],2).'<span>'.$ResEnero["Comentarios"].'</span></a>';}					$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResEnero["Cantidad"];		$tenero=$tenero+$ResEnero["Cantidad"];	
		$cadena.='<td id="feb_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorfeb.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResFebrero["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResFebrero["Id"].'\', \''.$anno.'\')">$ '.number_format($ResFebrero["Cantidad"],2).'<span>'.$ResFebrero["Comentarios"].'</span></a>';}			$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResFebrero["Cantidad"];	$tfebrero=$tfebrero+$ResFebrero["Cantidad"];
		$cadena.='<td id="mar_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolormar.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResMarzo["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResMarzo["Id"].'\', \''.$anno.'\')">$ '.number_format($ResMarzo["Cantidad"],2).'<span>'.$ResMarzo["Comentarios"].'</span></a>';}					$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResMarzo["Cantidad"];		$tmarzo=$tmarzo+$ResMarzo["Cantidad"];
		$cadena.='<td id="abr_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorabr.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResAbril["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResAbril["Id"].'\', \''.$anno.'\')">$ '.number_format($ResAbril["Cantidad"],2).'<span>'.$ResAbril["Comentarios"].'</span></a>';}					$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResAbril["Cantidad"];		$tabril=$tabril+$ResAbril["Cantidad"];
		$cadena.='<td id="may_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolormay.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResMayo["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResMayo["Id"].'\', \''.$anno.'\')">$ '.number_format($ResMayo["Cantidad"],2).'<span>'.$ResMayo["Comentarios"].'</span></a>';}					$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResMayo["Cantidad"];		$tmayo=$tmayo+$ResMayo["Cantidad"];
		$cadena.='<td id="jun_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorjun.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResJunio["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResJunio["Id"].'\', \''.$anno.'\')">$ '.number_format($ResJunio["Cantidad"],2).'<span>'.$ResJunio["Comentarios"].'</span></a>';}					$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResJunio["Cantidad"];		$tjunio=$tjunio+$ResJunio["Cantidad"];
		$cadena.='<td id="jul_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorjul.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResJulio["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResJulio["Id"].'\', \''.$anno.'\')">$ '.number_format($ResJulio["Cantidad"],2).'<span>'.$ResJulio["Comentarios"].'</span></a>';}					$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResJulio["Cantidad"];		$tjulio=$tjulio+$ResJulio["Cantidad"];
		$cadena.='<td id="ago_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorago.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResAgosto["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResAgosto["Id"].'\', \''.$anno.'\')">$ '.number_format($ResAgosto["Cantidad"],2).'<span>'.$ResAgosto["Comentarios"].'</span></a>';}				$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResAgosto["Cantidad"];		$tagosto=$tagosto+$ResAgosto["Cantidad"];
		$cadena.='<td id="sep_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolorsep.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResSeptiembre["Cantidad"])){	$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResSeptiembre["Id"].'\', \''.$anno.'\')">$ '.number_format($ResSeptiembre["Cantidad"],2).'<span>'.$ResSeptiembre["Comentarios"].'</span></a>';}	$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResSeptiembre["Cantidad"];	$tseptiembre=$tseptiembre+$ResSeptiembre["Cantidad"];
		$cadena.='<td id="oct_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcoloroct.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResOctubre["Cantidad"])){		$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResOctubre["Id"].'\', \''.$anno.'\')">$ '.number_format($ResOctubre["Cantidad"],2).'<span>'.$ResOctubre["Comentarios"].'</span></a>';}			$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$Resoctubre["Cantidad"];	$toctubre=$toctubre+$ResOctubre["Cantidad"];
		$cadena.='<td id="nov_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolornov.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResNoviembre["Cantidad"])){	$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResNoviembre["Id"].'\', \''.$anno.'\')">$ '.number_format($ResNoviembre["Cantidad"],2).'<span>'.$ResNoviembre["Comentarios"].'</span></a>';}		$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResNoviembre["Cantidad"];	$tnoviembre=$tnoviembre+$ResNoviembre["Cantidad"];
		$cadena.='<td id="dic_'.$A.'" onmouseover="row_'.$A.'.style.background=\'#00CED1\';con_'.$A.'.style.background=\'#00CED1\';ene_'.$A.'.style.background=\'#00CED1\';feb_'.$A.'.style.background=\'#00CED1\';mar_'.$A.'.style.background=\'#00CED1\';abr_'.$A.'.style.background=\'#00CED1\';may_'.$A.'.style.background=\'#00CED1\';jun_'.$A.'.style.background=\'#00CED1\';jul_'.$A.'.style.background=\'#00CED1\';ago_'.$A.'.style.background=\'#00CED1\';sep_'.$A.'.style.background=\'#00CED1\';oct_'.$A.'.style.background=\'#00CED1\';nov_'.$A.'.style.background=\'#00CED1\';dic_'.$A.'.style.background=\'#00CED1\';tot_'.$A.'.style.background=\'#00CED1\';" onmouseout="row_'.$A.'.style.background=\'#CCCCCC\';con_'.$A.'.style.background=\'#CCCCCC\';ene_'.$A.'.style.background=\''.$bgcolorene.'\';feb_'.$A.'.style.background=\''.$bgcolorfeb.'\';mar_'.$A.'.style.background=\''.$bgcolormar.'\';abr_'.$A.'.style.background=\''.$bgcolorabr.'\';may_'.$A.'.style.background=\''.$bgcolormay.'\';jun_'.$A.'.style.background=\''.$bgcolorjun.'\';jul_'.$A.'.style.background=\''.$bgcolorjul.'\';ago_'.$A.'.style.background=\''.$bgcolorago.'\';sep_'.$A.'.style.background=\''.$bgcolorsep.'\';oct_'.$A.'.style.background=\''.$bgcoloroct.'\';nov_'.$A.'.style.background=\''.$bgcolornov.'\';dic_'.$A.'.style.background=\''.$bgcolordic.'\';tot_'.$A.'.style.background=\'#CCCCCC\';" bgcolor="'.$bgcolordic.'" align="right" class="texto" style="border:1px solid #FFFFFF">';if(isset($ResDiciembre["Cantidad"])){	$cadena.='<a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_gasto_azul(\''.$RResGastos["Id"].'\', \''.$ResDiciembre["Id"].'\', \''.$anno.'\')">$ '.number_format($ResDiciembre["Cantidad"],2).'<span>'.$ResDiciembre["Comentarios"].'</span></a>';}		$cadena.='</td>';	$sumaconcepto=$sumaconcepto+$ResDiciembre["Cantidad"];	$tdiciembre=$tdiciembre+$ResDiciembre["Cantidad"];
		
		$cadena.='<td id="tot_'.$A.'" bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF"><a hef="#" class="Ntooltip">';if($sumaconcepto>0){$cadena.='$ '.number_format($sumaconcepto,2);}$cadena.='</a></td></tr>';	
		
		$A++; $B++;
	}
	$ttotal=$tenero+$tfebrero+$tmarzo+$tabril+$tmayo+$tjunio+$tjulio+$tagosto+$tseptiembre+$toctubre+$tnoviembre+$tdiciembre;
	$cadena.='<tr>
					<td colspan="16" bgcolor="#ffffff" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
			<tr>
				<td colspan="2" bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" style="color:#FFFFFF" class="total" onclick="xajax_gastos_azul(\'checkallt\', \'\', \''.$anno.'\')">Total: </a></td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tenero,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tfebrero,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tmarzo,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tabril,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tmayo,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tjunio,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tjulio,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tagosto,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tseptiembre,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($toctubre,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tnoviembre,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format($tdiciembre,2).'</td>
				<td bgcolor="#5263ab" align="right" class="texto3" style="border:1px solid #FFFFFF">$ '.number_format(($ttotal/12),2).'</td>
			</tr>
			</table></form>';
	
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_gasto_azul($anno)
{
	$cadena='<form name="fadgastoazul" id="fadgastoazul">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Gasto Parlami</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Concepto: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Pago: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="mes" id="mes">
							<option value="00">Mes</option>
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
						</select> <select name="anno" id="anno"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Vencimiento: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diav" id="diav"><option value="00">Día</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
		$cadena.='			</select> <select name="mesv" id="mesv">
							<option value="00">Mes</option>
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
						</select> <select name="annov" id="annov"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<!--<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Aprox: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="aprox" id="aprox" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fijo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="fijo" id="fijo" class="input" size="100"></td>
				</tr>-->
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="cantidad" id="cantidad" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1">';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Estado: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="estado" id="estado" value="PAGADO">PAGADO <input type="radio" name="estado" id="estado" value="VENCIDO">VENCIDO</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" rows="3" cols="50"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadventatela" id="botadventatela" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_gastos_azul(\'adgastoazul\', xajax.getFormValues(\'fadgastoazul\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_gasto_azul($gasto, $monto=NULL, $anno)
{
	include ("conexion.php");
	
	$ResGasto=mysql_fetch_array(mysql_query("SELECT * FROM gastos WHERE Id='".$gasto."' LIMIT 1"));
	$ResMonto=mysql_fetch_array(mysql_query("SELECT * FROM gastos_montos WHERE Id='".$monto."' LIMIT 1"));
	
	$cadena='<form name="feditgastoazul" id="feditgastoazul">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Gasto Parlami A</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Concepto: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" class="input" size="100" value="'.$ResGasto["Concepto"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="mes" id="mes">
							<option value="00">Mes</option>
							<option value="01"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResMonto["Fecha"][5].$ResMonto["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResMonto["Fecha"][0].$ResMonto["Fecha"][1].$ResMonto["Fecha"][2].$ResMonto["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Vencimiento: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diav" id="diav"><option value="00">Día</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($ResMonto["Vencimiento"][8].$ResMonto["Vencimiento"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
		$cadena.='			</select> <select name="mesv" id="mesv">
							<option value="00">Mes</option>
							<option value="01"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResMonto["Vencimiento"][5].$ResMonto["Vencimiento"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="annov" id="annov"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResMonto["Vencimiento"][0].$ResMonto["Vencimiento"][1].$ResMonto["Vencimiento"][2].$ResMonto["Vencimiento"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<!--<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Aprox: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="aprox" id="aprox" class="input" size="100" value="'.$ResGasto["Aprox"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fijo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="fijo" id="fijo" class="input" size="100" value="'.$ResGasto["Fijo"].'"></td>
				</tr>-->
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="cantidad" id="cantidad" class="input" size="100" value="'.$ResMonto["Cantidad"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1"';if($ResMonto["checka"]==1){$cadena.=' checked';}$cadena.='>';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Estado: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="estado" id="estado" value="PAGADO"';if($ResMonto["Estado"]=='PAGADO'){$cadena.=' checked';}$cadena.='>PAGADO <input type="radio" name="estado" id="estado" value="VENCIDO"';if($ResMonto["Estado"]=='VENCIDO'){$cadena.=' checked';}$cadena.='>VENCIDO</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" rows="3" cols="50">'.$ResMonto["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idgasto" id="idgasto" value="'.$ResGasto["Id"].'">
						<input type="hidden" name="idmonto" id="idmonto" value="'.$ResMonto["Id"].'">';
if($ResMonto["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="button" name="boteditgastoazul" id="boteditgastoazul" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\'; xajax_gastos_azul(\'editgastoazul\', xajax.getFormValues(\'feditgastoazul\'), \''.$anno.'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResMonto["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="button" name="boteditgastoazul" id="boteditgastoazul" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_gastos_azul(\'editgastoazul\', xajax.getFormValues(\'feditgastoazul\'), \''.$anno.'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResMonto["checka"]==1 AND $_SESSION["perfil"]!='administra'){$cadena.='';}
			$cadena.='</td>
				</tr>
			</table>
			</form>';
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_gasto_azul_nuevo_monto($gasto, $anno)
{
	include ("conexion.php");
	
	$ResGasto=mysql_fetch_array(mysql_query("SELECT * FROM gastos WHERE Id='".$gasto."' LIMIT 1"));
	
	$cadena='<form name="feditgastoazul" id="feditgastoazul">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Gasto Parlami</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Concepto: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" class="input" size="100" value="'.$ResGasto["Concepto"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="mes" id="mes">
							<option value="00">Mes</option>
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
						</select> <select name="anno" id="anno"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Vencimiento: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diav" id="diav"><option value="00">Día</option>';
	for($i=1; $i<=31; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
		$cadena.='			</select> <select name="mesv" id="mesv">
							<option value="00">Mes</option>
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
						</select> <select name="annov" id="annov"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<!--<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Aprox: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="aprox" id="aprox" class="input" size="100" value="'.$ResGasto["Aprox"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fijo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="fijo" id="fijo" class="input" size="100" value="'.$ResGasto["Fijo"].'"></td>
				</tr>-->
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="cantidad" id="cantidad" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';if($_SESSION["perfil"]=='administra'){$cadena.='<input type="checkbox" name="checka" id="checka" value="1"';if($ResGasto["checka"]==1){$cadena.=' checked';}$cadena.='>';}$cadena.='</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Estado: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="estado" id="estado" value="PAGADO">PAGADO <input type="radio" name="estado" id="estado" value="VENCIDO">VENCIDO</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" rows="3" cols="50"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idgasto" id="idgasto" value="'.$ResGasto["Id"].'">';
if($ResMonto["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="button" name="boteditgastoazul" id="boteditgastoazul" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_gastos_azul(\'editgastoazulnuevomonto\', xajax.getFormValues(\'feditgastoazul\'), \''.$anno.'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResMonto["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="button" name="boteditgastoazul" id="boteditgastoazul" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_gastos_azul(\'editgastoazulnuevomonto\', xajax.getFormValues(\'feditgastoazul\'), \''.$anno.'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResMonto["checka"]==1 AND $_SESSION["perfil"]=="usuario"){$cadena.='';}
		$cadena.='</td>
				</tr>
			</table>
			</form>';
			
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
?>