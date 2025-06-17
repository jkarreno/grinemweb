<?php
function programacion($tela=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	switch($accion)
	{
		case "adprogracompra":
			mysql_query("INSERT INTO programacion (Tela, FechaPromesa, FechaProgramacion, Provedor, Cantidad, PrecioU, Importe, Tipo, Comentarios, checka)
										   VALUES ('".$tela."',
												   '".$form["annope"]."-".$form["mespe"]."-".$form["diape"]."',
												   '".$form["annopr"]."-".$form["mespr"]."-".$form["diapr"]."',
												   '".$form["provedor"]."',
												   '".$form["cantidad"]."',
												   '".$form["compra"]."',
												   '".$form["importe"]."',
												   '".$form["tipo"]."',
												   '".utf8_decode($form["comentarios"])."',
												   '".$form["checka"]."')") or die(mysql_error());
			break;
		case"editprogracompra":
			mysql_query("UPDATE programacion SET FechaPromesa='".$form["annope"]."-".$form["mespe"]."-".$form["diape"]."',
												 FechaProgramacion='".$form["annopr"]."-".$form["mespr"]."-".$form["diapr"]."',
												 Provedor='".$form["provedor"]."',
												 Cantidad='".$form["cantidad"]."',
												 PrecioU='".$form["compra"]."',
												 Importe='".$form["importe"]."',
												 Tipo='".$form["tipo"]."',
												 Comentarios='".utf8_decode($form["comentarios"])."',
												 checka='".$form["checka"]."'
										   WHERE Id='".$form["idprogramacion"]."'") or die(mysql_error());
			break;
			
		case "adprogramacionventa":
		mysql_query("INSERT INTO programacion (Tela, FechaPromesa, FechaProgramacion, Cliente, Cantidad, PrecioU, Importe, Tipo, Comentarios, checka)
										   VALUES ('".$tela."',
												   '".$form["annope"]."-".$form["mespe"]."-".$form["diape"]."',
												   '".$form["annopr"]."-".$form["mespr"]."-".$form["diapr"]."',
												   '".$form["cliente"]."',
												   '".$form["cantidad"]."',
												   '".$form["venta"]."',
												   '".$form["importe"]."',
												   '".$form["tipo"]."',
												   '".utf8_decode($form["comentarios"])."',
												   '".$form["checka"]."')") or die(mysql_error());
			break;
		case "editprograventa":
			mysql_query("UPDATE programacion SET FechaPromesa='".$form["annope"]."-".$form["mespe"]."-".$form["diape"]."',
												 FechaProgramacion='".$form["annopr"]."-".$form["mespr"]."-".$form["diapr"]."',
												 Cliente='".$form["cliente"]."',
												 Cantidad='".$form["cantidad"]."',
												 PrecioU='".$form["compra"]."',
												 Importe='".$form["importe"]."',
												 Tipo='".$form["tipo"]."',
												 Comentarios='".utf8_decode($form["comentarios"])."',
												 checka='".$form["checka"]."'
										   WHERE Id='".$form["idprogramacionventa"]."'") or die(mysql_error());
			break;
		case "calculasaldo":
			$importe=($form["existencias"]*$form["precio"])*1.16;
			mysql_query("UPDATE telas SET Precio3='".$form["precio"]."', 
										  Importe2='".$importe."', 
									      Existencia2='".$form["existencias"]."' 
								    WHERE Id='".$tela."'")or die(mysql_error());
			break;
		case 'sumalascompras':
			$sumalascompras=0;
			$ResImportes=mysql_query("SELECT Id, Importe FROM programacion WHERE Tela='".$tela."' AND (Tipo LIKE 'Compra' OR Tipo LIKE 'Devolucion') ORDER BY Id ASC");
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
			$ResImportes=mysql_query("SELECT Id, Importe FROM programacion WHERE Tela='".$tela."' AND (Tipo LIKE 'Venta' OR Tipo LIKE 'Varios' OR Tipo LIKE 'Proveedor') ORDER BY Id ASC");
			while($RResImportes=mysql_fetch_array($ResImportes))
			{
				if($form["check_".$RResImportes["Id"]]==1)
				{
					$sumalasventas=$sumalasventas+$RResImportes["Importe"];
				}
				
			}
			break;
		case 'sumaprov':
			$suma1=0;$suma2=0;$suma3=0;$suma4=0;$suma5=0;$suma6=0;$suma7=0;$suma8=0;
			$ResP=mysql_query("SELECT Id, Cantidad FROM programacion WHERE Provedor='".$form["provedor"]."' AND FechaPromesa LIKE '2014-%' ORDER BY Id ASC");
			while($RResP=mysql_fetch_array($ResP))
			{
				if($form["tabla"]==1){if($form["check1_".$ResP["Id"]]==1){$suma1=$suma1+$ResP["Cantidad"];}}
				if($form["tabla"]==2){if($form["check2_".$ResP["Id"]]==2){$suma2=$suma2+$ResP["Cantidad"];}}
				if($form["tabla"]==3){if($form["check3_".$ResP["Id"]]==3){$suma3=$suma3+$ResP["Cantidad"];}}
				if($form["tabla"]==4){if($form["check4_".$ResP["Id"]]==4){$suma4=$suma4+$ResP["Cantidad"];}}
				if($form["tabla"]==5){if($form["check5_".$ResP["Id"]]==5){$suma5=$suma5+$ResP["Cantidad"];}}
				if($form["tabla"]==6){if($form["check6_".$ResP["Id"]]==6){$suma6=$suma6+$ResP["Cantidad"];}}
				if($form["tabla"]==7){if($form["check7_".$ResP["Id"]]==7){$suma7=$suma7+$ResP["Cantidad"];}}
				if($form["tabla"]==8){if($form["check8_".$ResP["Id"]]==8){$suma8=$suma8+$ResP["Cantidad"];}}
			}
			break;
	}
	
	$cadena='<p class="texto">Tela: <select name="tela" id="tela" onchange="xajax_programacion(this.value)"><option value="0">Seleccione</option>';
	$ResTelas=mysql_query("SELECT Id, Nombre FROM telas ORDER BY Nombre ASC");
	while($RResTelas=mysql_fetch_array($ResTelas))
	{
		$cadena.='<option value="'.$RResTelas["Id"].'"';if($RResTelas["Id"]==$tela){$cadena.=' selected';}$cadena.='	>'.$RResTelas["Nombre"].'</option>';
	}
	$cadena.='</select></p>';
	//ventana inicial
	if($tela==NULL)
	{
		$ResJulio=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Julio FROM programacion WHERE Provedor!='1' AND FechaPromesa LIKE '2014-07-%' AND (Tipo='Compra' OR Tipo='Devolucion') "));
		$ResAgosto=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Agosto FROM programacion WHERE Provedor!='1' AND FechaPromesa LIKE '2014-08-%' AND (Tipo='Compra' OR Tipo='Devolucion') "));
		$ResSeptiembre=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Septiembre FROM programacion WHERE Provedor!='1' AND FechaPromesa LIKE '2014-09-%' AND (Tipo='Compra' OR Tipo='Devolucion') "));
		$ResOctubre=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Octubre FROM programacion WHERE Provedor!='1' AND FechaPromesa LIKE '2014-10-%' AND (Tipo='Compra' OR Tipo='Devolucion') "));
		$ResNoviembre=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Noviembre FROM programacion WHERE Provedor!='1' AND FechaPromesa LIKE '2014-11-%' AND (Tipo='Compra' OR Tipo='Devolucion') "));
		$ResDiciembre=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Diciembre FROM programacion WHERE Provedor!='1' AND FechaPromesa LIKE '2014-12-%' AND (Tipo='Compra' OR Tipo='Devolucion') "));
		
		$cadena.='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Julio</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agosto</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Septiembre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Octubre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Noviembre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Diciembre</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Total</td>
				</tr>
				<tr>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ResJulio["Julio"],2).'</td>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ResAgosto["Agosto"],2).'</td>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ResSeptiembre["Septiembre"],2).'</td>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ResOctubre["Octubre"],2).'</td>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ResNoviembre["Noviembre"],2).'</td>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format($ResDiciembre["Diciembre"],2).'</td>
					<td bgcolor="#A9A9A9" align="right" class="texto" style="border:1px solid #FFFFFF">'.number_format(($ResJulio["Julio"]+$ResAgosto["Agosto"]+$ResSeptiembre["Septiembre"]+$ResOctubre["Octubre"]+$ResNoviembre["Noviembre"]+$ResDiciembre["Diciembre"]),2).'</td>
				</tr>
			  </table>';
			  
		$cadena.='<table border="0" align="left" cellpadding="3" cellspacing="0" width="300%">
					<tr>';
	
	//provedor CORDUROY S.A DE C.V.
	$cadena.='		<td valign="top"><div id="corduroy" name="corduroy">
							<form name="fsumatodoscorduroy" id="fsumatodoscorduroy">
							<input type="hidden" name="provedor" id="provedor" value="1">
							<input type="hidden" name="tabla" id="tabla" value="1">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_calcular_todo(\'corduroy\', \'1\', xajax.getFormValues(\'fsumatodoscorduroy\'))">Calcular: </a></td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">';if($suma1!=0){$cadena.=number_format($suma1,2);}$cadena.='</td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CORDUROY S.A DE C.V.</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallcorduroy" id="checkallcorduroy" value="1" onchange="seleccionar_todo_corduroy()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv0=mysql_query("SELECT * FROM programacion WHERE Provedor='1' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv0=mysql_fetch_array($ResProv0))
	{
		$ResTotCompra=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS totcompra FROM programacion WHERE Provedor='1' AND (Tipo='Compra' OR Tipo='Devolucion') AND FechaPromesa<='".date("Y-m-d")."'"));
		$ResTotVenta=mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS totventa FROM programacion WHERE Provedor='1' AND Tipo='Venta' AND FechaPromesa<='".date("Y-m-d")."'"));
		
		if($ResTotVenta["totventa"]>=$ResTotCompra["totcompra"]){$bgcolor='#DB7093';}
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv0["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResProv0["Id"].'" id="check_'.$RResProv0["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv0["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv0["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv0["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv0["FechaPromesa"]).'</td>
				</tr>';
		$A++; $bgcolor="#A9A9A9";
	}
	
	$cadena.='				</table></form></div>
						</td>';
					
	//provedor VICUNHA
	$cadena.='		<td valign="top"><div id="vicunha" name="vicunha">
							<form name="fsumatodosvicunha" id="fsumatodosvicunha">
							<input type="hidden" name="provedor" id="provedor" value="2">
							<input type="hidden" name="tabla" id="tabla" value="1">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_calcular_todo(\'vicunha\', \'2\', xajax.getFormValues(\'fsumatodosvicunha\'))">Calcular: </a></td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">';if($suma1!=0){$cadena.=number_format($suma1,2);}$cadena.='</td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VICUNHA</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallvicunha" id="checkallvicunha" value="1" onchange="seleccionar_todo_vicunha()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv1=mysql_query("SELECT * FROM programacion WHERE Provedor='2' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv1=mysql_fetch_array($ResProv1))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv1["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResProv1["Id"].'" id="check_'.$RResProv1["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv1["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv1["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv1["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv1["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table>
							</form></div>
						</td>';
						
	//provedor FABRICATO
	$cadena.='		<td valign="top"><div id="fabricato" name="fabricato">
							<form name="fsumatodosfabricato" id="fsumatodosfabricato">
							<input type="hidden" name="provedor" id="provedor" value="7">
							<input type="hidden" name="tabla" id="tabla" value="1">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_calcular_todo(\'fabricato\', \'7\', xajax.getFormValues(\'fsumatodosfabricato\'))">Calcular: </a></td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">';if($suma1!=0){$cadena.=number_format($suma1,2);}$cadena.='</td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FABRICATO</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallfabricato" id="checkallfabricato" value="1" onchange="seleccionar_todo_fabricato()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv2=mysql_query("SELECT * FROM programacion WHERE Provedor='7' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv2=mysql_fetch_array($ResProv2))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv2["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$ResProv2["Id"].'" id="check_'.$ResProv2["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv2["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv2["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv2["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv2["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table></form></div>
						</td>';
					
	//provedor PREMITEX DENIM S.A DE C.V.
		$cadena.='		<td valign="top"><div id="premitex" name="premitex">
							<form name="fsumatodospremitex" id="fsumatodospremitex">
							<input type="hidden" name="provedor" id="provedor" value="4">
							<input type="hidden" name="tabla" id="tabla" value="1">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_calcular_todo(\'premitex\', \'4\', xajax.getFormValues(\'fsumatodospremitex\'))">Calcular: </a></td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">';if($suma1!=0){$cadena.=number_format($suma1,2);}$cadena.='</td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PREMITEX DENIM S.A DE C.V.</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallpremitex" id="checkallpremitex" value="1" onchange="seleccionar_todo_premitex()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv3=mysql_query("SELECT * FROM programacion WHERE Provedor='4' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv3=mysql_fetch_array($ResProv3))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv3["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResProv3["Id"].'" id="check_'.$RResProv3["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv3["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv3["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv3["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv3["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table></form></div>
						</td>';
						
	//provedor ACABADOS FINOS TEXTILES (ACAFINTEX)
	$cadena.='		<td valign="top"><div id="acabados" name="acabados">
							<form name="fsumatodosacabados" id="fsumatodosacabados">
							<input type="hidden" name="provedor" id="provedor" value="40">
							<input type="hidden" name="tabla" id="tabla" value="1">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_calcular_todo(\'acabados\', \'40\', xajax.getFormValues(\'fsumatodosacabados\'))">Calcular: </a></td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">';if($suma1!=0){$cadena.=number_format($suma1,2);}$cadena.='</td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ACABADOS FINOS TEXTILES (ACAFINTEX)</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallacabados" id="checkallacabados" value="1" onchange="seleccionar_todo_acabados()"></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv4=mysql_query("SELECT * FROM programacion WHERE Provedor='40' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv4=mysql_fetch_array($ResProv4))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv4["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResProv4["Id"].'" id="check_'.$RResProv4["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv4["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv4["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv4["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv4["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table></form></div>
						</td>';
						
	//provedor GAMA S. A. de C. V.
	$cadena.='		<td valign="top">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">GAMA S.A. de C. V.</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv5=mysql_query("SELECT * FROM programacion WHERE Provedor='3' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv1=mysql_fetch_array($ResProv5))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv5["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check5_'.$ResProv5["Id"].'" id="check5_'.$ResProv5["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv5["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv5["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv5["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv5["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table>
						</td>';
						
	//provedor TOPMAN
	$cadena.='		<td valign="top">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TOPMAN</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv6=mysql_query("SELECT * FROM programacion WHERE Provedor='26' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv6=mysql_fetch_array($ResProv6))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv6["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check6_'.$ResProv6["Id"].'" id="check6_'.$ResProv6["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv6["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv6["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv6["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv6["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table>
						</td>';
						
	//provedor KAMAFIL
	$cadena.='		<td valign="top">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">KAMAFIL</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv7=mysql_query("SELECT * FROM programacion WHERE Provedor='25' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv7=mysql_fetch_array($ResProv7))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv7["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check7_'.$ResProv7["Id"].'" id="check7_'.$ResProv7["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv7["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv7["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv7["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv7["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table>
						</td>';
						
	//provedor TEJIDOS RAMS
	$cadena.='		<td valign="top">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TEJIDOS RAMS</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA P</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">RETRASO</td>
								</tr>';
	$ResProv8=mysql_query("SELECT * FROM programacion WHERE Provedor='23' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY FechaPromesa ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv8=mysql_fetch_array($ResProv8))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv8["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check8_'.$ResProv8["Id"].'" id="check8_'.$ResProv8["Id"].'" value="1"></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv8["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv8["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv8["FechaPromesa"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"), $RResProv8["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table>
						</td>';
						
		$cadena.='	</tr>
				  </table>';
				  
	
	}
	//ventana despues de seleccionar tela
	elseif($tela!=NULL)
	{
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
	$ccompras=0; $cventas=0;	
	//COMPRAS DE LA TELA
	$cadena.='<table border="0" align="center">
				<tr>
					<td valign="top" align="center">
					
					<form name="fsumacompras" id="fsumacompras">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="4" bgcolor="#FFFFFF" align="left" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_programacion(\''.$tela.'\')">Agregar Programación Compra</a> |</td>
								<td colspan="2" bgcolor="#FFFFFF" align="right" class="texto"><a href="#" onclick="">Calcular:</a></td>
								<td bgcolor="#FFFFFF" align="right" class="texto">';if($sumalascompras!=0){$cadena.='$ '.number_format($sumalascompras,2);}$cadena.='</td>
							</tr>
							<tr>
								<td colspan="7" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PROGRAMACION COMPRAS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checallacompras" id="checallacompras" value="1" onchange="seleccionar_todo_compratelas()"></td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CANTIDAD</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA PROMESA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DIAS RETRASO</td>
							</tr>';
		$ResProgCompra=mysql_query("SELECT * FROM programacion WHERE Tela='".$tela."' AND (Tipo='Compra' OR Tipo='Devolucion') ORDER BY Id ASC");
		$A=1; $bgcolor="#A9A9A9";
		while($RResPC=mysql_fetch_array($ResProgCompra))
		{
			if($RResPC["checka"]==1){$bgcolor='#CCCCCC';}else{$bgcolor='#A9A9A9';}
			$cadena.='<tr>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResPC["Id"].'" id="check_'.$RResPC["Id"].'" value="1" onchange="xajax_programacion(\''.$tela.'\', \'sumalascompras\', xajax.getFormValues(\'fsumacompras\'))"></td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResPC["FechaProgramacion"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_programacion(\''.$RResPC["Id"].'\');" class="Ntooltip">'.$RResPC["Cantidad"].'<span>'.$RResPC["Comentarios"].'</span></a></td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResPC["Importe"],2).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResPC["FechaPromesa"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"),$RResPC["FechaPromesa"]).'</td>
					</tr>';
			$ccompras=$ccompras+$RResPC["Cantidad"];
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
								<td bgcolor="#FFFFFF" colspan="6" align="left" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_programacion_venta(\''.$tela.'\')">Agregar Programación Venta</a> |</td>
								<td bgcolor="#FFFFFF" align="rigth" class="texto"><a href="#" onclick="">Calcular:</a></td>
								<td bgcolor="#FFFFFF" align="right" class="texto">';if($sumalasventas!=0){$cadena.='$ '.number_format($sumalasventas,2);}$cadena.='</td>
							</tr>
							<tr>
								<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkallaventas" id="checkallaventas" value="1" onchange="seleccionar_todo_ventatelas()"></td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CANTIDAD</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA PROMESA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">DIAS RETRASO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTE</td>
							</tr>';
		$ResProgVenta=mysql_query("SELECT * FROM programacion WHERE Tela='".$tela."' AND (Tipo='Venta' OR Tipo='Varios' OR Tipo='Proveedor') ORDER BY Id ASC");
		$A=1; $bgcolor="#A9A9A9";
		while($RResPV=mysql_fetch_array($ResProgVenta))
		{
			if($RResPC["checka"]==1){$bgcolor='#CCCCCC';}else{$bgcolor='#A9A9A9';}
			$ResCliente=mysql_fetch_array(mysql_query("SELECT Nombre FROM clientes WHERE Id='".$RResPV["Cliente"]."' LIMIT 1"));
			$cadena.='<tr>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResPV["Id"].'" id="check_'.$RResPV["Id"].'" value="1" onchange="xajax_programacion(\''.$tela.'\', \'sumalasventas\', xajax.getFormValues(\'fsumaventas\'))"></td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResPV["FechaProgramacion"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_programacion_venta(\''.$RResPV["Id"].'\');" class="Ntooltip">'.$RResPV["Cantidad"].'<span>'.$RResPV["Comentarios"].'</a></td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResPV["Importe"],2).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResPV["FechaPromesa"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.dias_transcurridos(date("Y-m-d"),$RResPV["FechaPromesa"]).'</td>
						<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$ResCliente["Nombre"].'</td>
					</tr>';
			$cventas=$cventas+$RResPV["Cantidad"];
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
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ <input type="text" name="precio" id="precio" value="'.$ResTela["Precio3"].'" class="input"></td>
							</tr>
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">Saldo : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ <input type="text" name="saldo" id="saldo" value="'.number_format($ResTela["Importe2"],2).'" class="input"></td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
									<input type="button" name="botcalcsaldo" id="botcalcsaldo" value="calcular" class="boton" onclick="xajax_programacion(\''.$tela.'\', \'calculasaldo\', xajax.getFormValues(\'fcalculasaldo\'))">
								</td>
						</table>
						</form>
					</td>
				</tr>
			</table>';
	}
	
	mysql_query("UPDATE telas SET Existencia2='".$cantidad."', Importe2='".$ResTela["Importe2"]."', Precio3='".$ResTela["Precio3"]."' WHERE Id='".$tela."'") or die(mysql_error());
	
				
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_programacion($tela)
{
	include ("conexion.php");
	
	$cadena='<form name="fadprogra" id="fadprogra">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Programación Compra</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';
	$ResTelas=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTelas["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTelas["Provedor"]."'"));
	$cadena.=$ResTelas["Nombre"].'</td>
				</tr>
				
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Programación: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diapr" id="diapr"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespr" id="mespr"><option value="00">Mes</option>
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
				</select> <select name="annopr" id="annopr"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Promesa de Entrega: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diape" id="diape"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespe" id="mespe"><option value="00">Mes</option>
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
				</select> <select name="annope" id="annope"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Compra">Compra <input type="radio" name="tipo" id="tipo" value="Devolucion">Devoluci&oacute;n</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value, compra.value, importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Compra: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="compra" id="compra" class="input" value="'.$ResTelas["Precio"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
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
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="hidden" name="provedor" id="provedor" value="'.$ResTelas["Provedor"].'">'.$ResProvedor["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadtela" id="botadtela" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\'; xajax_programacion(\''.$tela.'\', \'adprogracompra\', xajax.getFormValues(\'fadprogra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_programacion($prog)
{
	include ("conexion.php");
	
	$ResProg=mysql_fetch_array(mysql_query("SELECT * FROM programacion WHERE Id='".$prog."' LIMIT 1"));
	$tela=$ResProg["Tela"];
	
	$cadena='<form name="feditprogra" id="feditprogra">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Programación Compra</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';
	$ResTelas=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTelas["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTelas["Provedor"]."'"));
	$cadena.=$ResTelas["Nombre"].'</td>
				</tr>
				
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Programación: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diapr" id="diapr"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$ResProg["FechaProgramacion"][8].$ResProg["FechaProgramacion"][9]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespr" id="mespr"><option value="00">Mes</option>
					<option value="01"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
					<option value="02"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
					<option value="03"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
					<option value="04"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
					<option value="05"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
					<option value="06"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
					<option value="07"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
					<option value="08"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
					<option value="09"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
					<option value="10"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
					<option value="11"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
					<option value="12"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
				</select> <select name="annopr" id="annopr"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResProg["FechaProgramacion"][0].$ResProg["FechaProgramacion"][1].$ResProg["FechaProgramacion"][2].$ResProg["FechaProgramacion"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Promesa de Entrega: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diape" id="diape"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$ResProg["FechaPromesa"][8].$ResProg["FechaPromesa"][9]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespe" id="mespe"><option value="00">Mes</option>
					<option value="01"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
					<option value="02"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
					<option value="03"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
					<option value="04"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
					<option value="05"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
					<option value="06"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='06'){$cadena.=' selected';}$cadena.='">Junio</option>
					<option value="07"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
					<option value="08"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
					<option value="09"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
					<option value="10"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
					<option value="11"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
					<option value="12"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
				</select> <select name="annope" id="annope"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'"';if($ResProg["FechaPromesa"][0].$ResProg["FechaPromesa"][1].$ResProg["FechaPromesa"][2].$ResProg["FechaPromesa"][3]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Compra"';if($ResProg["Tipo"]=='Compra'){$cadena.=' checked';}$cadena.='>Compra <input type="radio" name="tipo" id="tipo" value="Devolucion"';if($ResProg["Tipo"]=='Devolucion'){$cadena.=' checked';}$cadena.='>Devoluci&oacute;n</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value, compra.value, importe);" value="'.$ResProg["Cantidad"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Compra: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="compra" id="compra" class="input" value="'.$ResProg["PrecioU"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="importe" id="importe" class="input" value="'.$ResTelas["Importe"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Provedor: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="hidden" name="provedor" id="provedor" value="'.$ResTelas["Provedor"].'">'.$ResProvedor["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResProg["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResProg["checka"]==1){$cadena.=' checked';}$cadena.='></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idprogramacion" id="idprogramacion" value="'.$ResProg["Id"].'">
						<input type="button" name="botadtela" id="botadtela" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\'; xajax_programacion(\''.$tela.'\', \'editprogracompra\', xajax.getFormValues(\'feditprogra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_programacion_venta($tela)
{
	include ("conexion.php");
	
	$cadena='<form name="fadprogra" id="fadprogra">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Programación Venta</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';
	$ResTelas=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTelas["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTelas["Provedor"]."'"));
	$cadena.=$ResTelas["Nombre"].'</td>
				</tr>
				
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Programación: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diapr" id="diapr"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespr" id="mespr"><option value="00">Mes</option>
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
				</select> <select name="annopr" id="annopr"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Promesa de Entrega: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diape" id="diape"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespe" id="mespe"><option value="00">Mes</option>
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
				</select> <select name="annope" id="annope"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'">'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Venta">Venta <input type="radio" name="tipo" id="tipo" value="Varios">Varios <input type="radio" name="tipo" id="tipo" value="Proveedor">Proveedor</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value, venta.value, importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResTelas["Venta"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
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
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Clientes: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="cliente" id="cliente"><option value="0">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='		<option value="'.$RResClientes["Id"].'">'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='		</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadtela" id="botadtela" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\'; xajax_programacion(\''.$tela.'\', \'adprogramacionventa\', xajax.getFormValues(\'fadprogra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_programacion_venta($prog)
{
	include ("conexion.php");
	
	$ResProg=mysql_fetch_array(mysql_query("SELECT * FROM programacion WHERE Id='".$prog."' LIMIT 1"));
	$tela=$ResProg["Tela"];
	
	$cadena='<form name="feditprograventa" id="feditprograventa">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Programación Venta</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">';
	$ResTelas=mysql_fetch_array(mysql_query("SELECT * FROM telas WHERE Id='".$tela."' LIMIT 1"));
	$ResTipoTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$ResTelas["TipoTela"]."' AND PerteneceA='TipoTela'"));
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM provedores WHERE Id='".$ResTelas["Provedor"]."'"));
	$cadena.=$ResTelas["Nombre"].'</td>
				</tr>
				
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Programación: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diapr" id="diapr"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$ResProg["FechaProgramacion"][8].$ResProg["FechaProgramacion"][9]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespr" id="mespr"><option value="00">Mes</option>
					<option value="01"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
					<option value="02"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
					<option value="03"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
					<option value="04"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
					<option value="05"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
					<option value="06"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
					<option value="07"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
					<option value="08"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
					<option value="09"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
					<option value="10"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
					<option value="11"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
					<option value="12"';if($ResProg["FechaProgramacion"][5].$ResProg["FechaProgramacion"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
				</select> <select name="annopr" id="annopr"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResProg["FechaProgramacion"][0].$ResProg["FechaProgramacion"][1].$ResProg["FechaProgramacion"][2].$ResProg["FechaProgramacion"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha Promesa de Entrega: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="diape" id="diape"><option value="00">Dia</option>';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='<option value="'.$i.'"';if($i==$ResProg["FechaPromesa"][8].$ResProg["FechaPromesa"][9]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='</select> <select name="mespe" id="mespe"><option value="00">Mes</option>
					<option value="01"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
					<option value="02"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
					<option value="03"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
					<option value="04"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
					<option value="05"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
					<option value="06"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='06'){$cadena.=' selected';}$cadena.='">Junio</option>
					<option value="07"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
					<option value="08"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
					<option value="09"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
					<option value="10"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
					<option value="11"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
					<option value="12"';if($ResProg["FechaPromesa"][5].$ResProg["FechaPromesa"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
				</select> <select name="annope" id="annope"><option value="0000">Año</option>';
	for($i=2014;$i<=(date("Y")+2);$i++)
	{
		$cadena.='<option value="'.$i.'"';if($ResProg["FechaPromesa"][0].$ResProg["FechaPromesa"][1].$ResProg["FechaPromesa"][2].$ResProg["FechaPromesa"][3]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="radio" name="tipo" id="tipo" value="Venta"';if($ResProg["Tipo"]=='Venta'){$cadena.=' checked';}$cadena.='>Venta <input type="radio" name="tipo" id="tipo" value="Varios"';if($ResProg["Tipo"]=='Varios'){$cadena.=' checked';}$cadena.='>Varios <input type="radio" name="tipo" id="tipo" value="Proveedor"';if($ResProg["Tipo"]=='Proveedor'){$cadena.=' checked';}$cadena.='>Proveedor</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="cantidad" id="cantidad" class="input" onKeyUp="calculo(this.value, compra.value, importe);" value="'.$ResProg["Cantidad"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Precio Venta: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="venta" id="venta" class="input" value="'.$ResProg["PrecioU"].'" onKeyUp="calculo(cantidad.value,this.value,importe);"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Importe: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="importe" id="importe" class="input" value="'.$ResTelas["Importe"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Tipo de tela: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">'.$ResTipoTela["Nombre"].'</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Clientes: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><select name="cliente" id="cliente"><option value="0">Seleccione</option>';
	$ResClientes=mysql_query("SELECT Id, Nombre FROM clientes ORDER BY Nombre ASC");
	while($RResClientes=mysql_fetch_array($ResClientes))
	{
		$cadena.='		<option value="'.$RResClientes["Id"].'"';if($ResProg["Cliente"]==$RResClientes["Id"]){$cadena.=' selected';}$cadena.='>'.$RResClientes["Nombre"].'</option>';
	}
	$cadena.='		</td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResProg["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Check: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idprogramacionventa" id="idprogramacionventa" value="'.$ResProg["Id"].'">
						<input type="button" name="botadtela" id="botadtela" value="Editar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\'; xajax_programacion(\''.$tela.'\', \'editprograventa\', xajax.getFormValues(\'feditprograventa\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function calcular_todo($capa, $provedor, $form)
{
	include ("conexion.php");
	
	$ResP=mysql_query("SELECT Id, Cantidad FROM programacion WHERE Provedor='".$provedor."' AND FechaPromesa LIKE '2014-%' ORDER BY Id ASC");
	while($RResP=mysql_fetch_array($ResP))
	{
		if($form["check_".$RResP["Id"]]==1){$suma=$suma+$RResP["Cantidad"];}
	}
	
	$ResProvedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$provedor."' LIMIT 1"));
	
	$cadena='<form name="fsumatodos'.$capa.'" id="fsumatodos'.$capa.'">
							<input type="hidden" name="provedor" id="provedor" value="2">
							<input type="hidden" name="tabla" id="tabla" value="1">
							<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
								<tr>
									<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto3" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_calcular_todo(\''.$capa.'\', \''.$provedor.'\', xajax.getFormValues(\'fsumatodos'.$capa.'\'))">Calcular: </a></td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">';if($suma!=0){$cadena.=number_format($suma,2);}$cadena.='</td>
									<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="7" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">'.$ResProvedor["Nombre"].'</td>
								</tr>
								<tr>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="checkall'.$capa.'" id="checkall'.$capa.'" value="1" onchange="seleccionar_todo_'.$capa.'()"';if($form["checkall".$capa]==1){$cadena.=' checked';}$cadena.='></td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">METROS</td>
									<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA ENTREGA</td>
								</tr>';
	$ResProv1=mysql_query("SELECT * FROM programacion WHERE Provedor='".$provedor."' AND (Tipo='Compra' OR Tipo='Devolucion')ORDER BY Id ASC");
	$A=1; $bgcolor="#A9A9A9";
	while($RResProv1=mysql_fetch_array($ResProv1))
	{
		$ResTela=mysql_fetch_array(mysql_query("SELECT Id, Nombre, Color FROM telas WHERE Id='".$RResProv1["Tela"]."' LIMIT 1"));
		
		$cadena.='<tr>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResProv1["Id"].'" id="check_'.$RResProv1["Id"].'" value="1"';if($form["check_".$RResProv1["Id"]]==1 OR $form["checkall".$capa]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv1["FechaProgramacion"]).'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_programacion(\''.$ResTela["Id"].'\')" class="Ntooltip">'.$ResTela["Nombre"].'</a></td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResTela["Color"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResProv1["Cantidad"].'</td>
					<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResProv1["FechaPromesa"]).'</td>
				</tr>';
		$A++;
	}
	
	$cadena.='				</table>
							</form>';
							
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign($capa,"innerHTML",utf8_encode($cadena));
	return $respuesta;
}
?>