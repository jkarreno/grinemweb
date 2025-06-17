<?php
function pagos($cliente=NULL, $accion=NULL, $form=NULL, $anno='todos', $annohist='todos')
{
	include ("conexion.php");
	
	switch($accion)
	{	
		//Agregamos venta
		case 'adventa':
			mysql_query("INSERT INTO ventas (Cliente, Fecha, Apagar, Importe, Provedor, Comision, SComision, Comentarios, checka)
									 VALUES ('".$cliente."',
											 '".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
											 '".$form["apagar"]."',
											 '".$form["importe"]."',
											 '".$form["provedor"]."',
											 '".$form["comision"]."',
											 '".$form["scomision"]."',
											 '".$form["comentarios"]."',
											 '".$form["checka"]."')") or die(mysql_error());
			break;
		//pagar venta
		case 'pagaventa':
			mysql_query("UPDATE ventas SET Status='PAGADO' WHERE Id='".$form."'") or die(mysql_error());
			break;
		//editar venta
		case 'editventa':
			mysql_query("UPDATE ventas SET Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
										   Apagar='".$form["apagar"]."',
										   Importe='".$form["importe"]."',
										   Provedor='".$form["provedor"]."',
										   Comision='".$form["comision"]."',
										   SComision='".$form["scomision"]."',
										   Status='".$form["status"]."',
										   Comentarios='".$form["comentarios"]."',
										   checka='".$form["checka"]."',
										   Historico='".$form["historico"]."',
										   AnnoHistorico='".$form["annohistorico"]."'
									 WHERE Id='".$form["idventa"]."'") or die(mysql_error());
			break;
		//agregar Pago
		case 'adpago':
			mysql_query("INSERT INTO pagos (Cliente, Banco, Cheque, Fecha, Comision, Pago, Comentarios, checka)
									VALUES ('".$cliente."',
											'".$form["banco"]."',
											'".$form["numcheque"]."',
											'".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
											'".$form["comision"]."',
											'".$form["pago"]."',
											'".utf8_decode($form["comentarios"])."',
											'".$form["checka"]."')") or die(mysql_error());
											
			if(isset($form["idcheque"]))
			{
				mysql_query("DELETE FROM chequepost WHERE Id='".$form["idcheque"]."'");
			}
			break;
		//aplicarpago
		case 'aplicapago':
			$importe=$form["restante"];
			
			for($i=0;$i<count($form["ventas"]);$i++)
			{	
				//obtenemos cantidad de la cuenta
				$cantidad=mysql_fetch_array(mysql_query("SELECT Importe FROM ventas WHERE Id='".$form["ventas"][$i]."' LIMIT 1"));
				//revisamos los pagos hechos
				$pagoshechos=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS pagos FROM detpago WHERE IdVenta='".$form["ventas"][$i]."'"));
				//sacamos el adeudo
				$adeudo=$cantidad["Importe"]-$pagoshechos["pagos"];
				//comparamos
				if($importe>=$adeudo){$pago=$adeudo;}
				else{$pago=$importe;}
				//guardamos
				mysql_query("INSERT INTO detpago (IdVenta, IdPago, Importe)
										  VALUES ('".$form["ventas"][$i]."',
												  '".$form["idpago"]."',
												  '".$pago."')")or die(mysql_error());
				//restamos el pago del importe
				$importe=$importe-$pago;
				
				//comprobamos el pago de la venta
				if($cantidad["Importe"]<=($pagoshechos["pagos"]+$pago))
				{
					mysql_query("UPDATE ventas SET Status='PAGADO' WHERE Id='".$form["ventas"][$i]."'") or die(mysql_error());
				}
			}
			break;
		//agregar cheque post fechado
		case 'adcheque':
			mysql_query("INSERT INTO chequepost (Banco, Fecha, NumCheque, Importe, Cliente, checka)
										 VALUES ('".$form["banco"]."',
												 '".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
												 '".$form["numcheque"]."',
												 '".$form["importe"]."',
												 '".$cliente."',
												 '".$form["checka"]."')") or die(mysql_error());
			break;
		//edita cheque
		case 'editcheque':
			mysql_query("UPDATE chequepost SET Banco='".$form["banco"]."',
											   Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
											   NumCheque='".$form["numcheque"]."',
											   Importe='".$form["importe"]."',
											   checka='".$form["checka"]."'
										WHERE Id='".$form["idcheque"]."'")or die(mysql_error());
			break;
		//suma pagos selesccionados
		case 'suma':
			$suma=0;
			$ResSuma=mysql_query("SELECT Id, Importe FROM ventas WHERE Cliente='".$cliente."' ORDER BY Id ASC");
			while($RResSuma=mysql_fetch_array($ResSuma))
			{
				if($form["check_".$RResSuma["Id"]]==1)
				{
					$suma=$suma+$RResSuma["Importe"];
				}
			}
			break;
		//suma los pagos hechos
		case 'sumapagos':
			$sumapagos=0;
			$ResSumaPagos=mysql_query("SELECT Id, Pago FROM pagos WHERE Cliente='".$cliente."' ORDER BY Id ASC");
			while($RResSumaPagos=mysql_fetch_array($ResSumaPagos))
			{
				if($form["pago_".$RResSumaPagos["Id"]]==1)
				{
					$sumapagos=$sumapagos+$RResSumaPagos["Pago"];
				}
			}
			break;
		//editar pagos
		case 'editpago':
			mysql_query("UPDATE pagos SET Banco='".$form["banco"]."', 
										   Cheque='".$form["numcheque"]."', 
										   Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
										   Comision='".$form["comision"]."', 
										   Pago='".$form["pago"]."',
										   Status='".$form["status"]."',
										   Comentarios='".utf8_decode($form["comentarios"])."',
										   checka='".$form["checka"]."',
										   Historico='".$form["historico"]."',
										   AnnoHistorico='".$form["annohistorico"]."'
									 WHERE Id='".$form["idpago"]."'") or die(mysql_error());
			break;
		//suma adeudos de clienes
		case 'sumaaclientes':
			$sumaaclientes=0;
			$ResSumaAClientes=mysql_query("SELECT Id, Adeudo FROM clientes ORDER BY Id ASC");
			while($RResSumaAClientes=mysql_fetch_array($ResSumaAClientes))
			{
				if($form["acliente_".$RResSumaAClientes["Id"]]==1)
				{
					$sumaaclientes=$sumaaclientes+$RResSumaAClientes["Adeudo"];
				}
			}
			break;
		//suma adeudos de provedores
		case 'sumaaprovedores':
			$sumaaprovedores=0;
			$ResSumaAProvedores=mysql_query("SELECT Id, Adeudo, TipoCambio FROM provedores ORDER BY Id ASC");
			while($RResSumaAProvedores=mysql_fetch_array($ResSumaAProvedores))
			{
				if($form["aprovedor_".$RResSumaAProvedores["Id"]]==1)
				{
					if($RResSumaAProvedores["TipoCambio"]==0)
					{
						$sumaaprovedores=$sumaaprovedores+$RResSumaAProvedores["Adeudo"];
					}
					else
					{
						$sumaaprovedores=$sumaaprovedores+($RResSumaAProvedores["Adeudo"]*$RResSumaAProvedores["TipoCambio"]);
					}
				}
			}
			break;
		//suma existencia de telas
		case 'sumaatelas':
			$sumaatelas=0;
			$ResSumaAtelas=mysql_query("SELECT Id, Importe FROM telas ORDER By Id ASC");
			while($RResSumaAtelas=mysql_fetch_array($ResSumaAtelas))
			{
				if($form["atela_".$RResSumaAtelas["Id"]]==1)
				{
					$sumaatelas=$sumaatelas+$RResSumaAtelas["Importe"];
				}
			}
			break;
	}
	
	$cadena='<p align="center" class="texto">Cliente: <select name="cliente" id="cliente" onchange="xajax_pagos(this.value)"><option>SELECCIONE</option>';
	$ResCliente=mysql_query("SELECT * FROM clientes ORDER BY Nombre ASC");
	while($RResCliente=mysql_fetch_array($ResCliente))
	{
		$ResHist=mysql_num_rows(mysql_query("SELECT Historico FROM ventas WHERE Cliente='".$RResCliente["Id"]."' AND Historico='1'"));
		$ResHistp=mysql_num_rows(mysql_query("SELECT Historico FROM pagos WHERE Cliente='".$RResCliente["Id"]."' AND Historico='1'"));
		
		if($RResCliente["Juridico"]==2 OR $ResHist!=0 OR $ResHistp!=0)
		{	
			$cadena.='<option value="'.$RResCliente["Id"].'"';if($RResCliente["Id"]==$cliente){$cadena.=' selected';}$cadena.='>'.$RResCliente["Nombre"].'</option>';
		}
	}
	$cadena.='</select> <a href="reportes/reportecliente.php?cliente='.$cliente.'" target="_blank"><img src="images/impresora.jpg" border="0"></a> Provedor: <select name="provedor" id="provedor" onchange="xajax_pagos_provedor(this.value)"><option>SELECCIONE</option>';
	$ResProvedor=mysql_query("SELECT * FROM provedores ORDER BY Nombre ASC");
	while($RResProvedor=mysql_fetch_array($ResProvedor))
	{
		$ResHistProv=mysql_num_rows(mysql_query("SELECT Historico FROM compras WHERE Provedor='".$RResProvedor["Id"]."' AND Historico='1'"));
		//$ResHistp=mysql_num_rows(mysql_query("SELECT Historico FROM pagos WHERE Cliente='".$RResCliente["Id"]."' AND Historico='1'"));
		
		if($RResProvedor["Status"]==2 OR $ResHistProv!=0)
		{	
			$cadena.='<option value="'.$RResProvedor["Id"].'">'.$RResProvedor["Nombre"].'</option>';
		}
	}
	$cadena.='</select> <img src="images/impresora.jpg" border="0"> Tela: <select name="telas" id="telas" onchange="xajax_existencias(this.value)"><option>SELECCIONE</option>';
	$ResTelas=mysql_query("SELECT Id, Nombre, Status FROM telas ORDER BY Nombre ASC");
	while($RResTelas=mysql_fetch_array($ResTelas))
	{
		$exihis=mysql_num_rows(mysql_query("SELECT Id FROM existencias WHERE Tela='".$RResTelas["Id"]."' AND Historico='1'"));
		if($RResTelas["Status"]==2 OR $exihis!=0)
		{
			$cadena.='<option value="'.$RResTelas["Id"].'">'.$RResTelas["Nombre"].'</option>';
		}
	}
	$cadena.='</select> </p>';
	if($cliente!=NULL)
	{
	$ResCredito=mysql_fetch_array(mysql_query("SELECT Credito FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	$cadena.='<p class="texto">Limite de Credito: $ '.number_format($ResCredito["Credito"],2).'
				<br />&nbsp;<br />A&ntilde;o: <select name="anno" id="anno" onChange="xajax_pagos(\''.$cliente.'\', \''.$accion.'\', \''.$form.'\', this.value, document.getElementById(\'annohist\').value)">
					<option value="todos">Todos</option>';
	for($i=2000; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($anno==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}	
	$cadena.='	</select> A&ntilde;o: Historico:  <select name="annohist" id="annohist" onChange="xajax_pagos(\''.$cliente.'\', \''.$accion.'\', \''.$form.'\', document.getElementById(\'anno\').value, this.value)">
					<option value="todos">Todos</option>';
	for($i=2000; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($annohist==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}	
	$cadena.='	</select>
				</p>
			  <table border="0" align="center">
				<tr>
					<td valign="top" align="center">
					<form id="fsumaventas" id="fsumaventas">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">';if($suma>0){$cadena.='$ '.number_format($suma,2);}$cadena.='</td>
								<td colspan="5" align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_venta(\''.$cliente.'\');">Agregar Venta</a> |</td>
							</tr>
							<tr>
								<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS</td>
								<td bgcolor="#5263ab" align="center" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENCE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
							</tr>';
	if($annohist=='todos'){$ah='%';}else{$ah=$annohist;}
	
	$ResClienteV=mysql_fetch_array(mysql_query("SELECT Juridico FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	if($ResClienteV["Juridico"]==2)
	{
		$ResVentas=mysql_query("SELECT * FROM ventas WHERE Cliente='".$cliente."' ORDER BY Fecha ASC");
	}
	else
	{
		$ResVentas=mysql_query("SELECT * FROM ventas WHERE Cliente='".$cliente."' AND Historico='1' AND AnnoHistorico LIKE '".$ah."' ORDER BY Fecha ASC");
	}
	$saldo=0;
	while($RResVentas=mysql_fetch_array($ResVentas))
	{
		$bgcolor='#A9A9A9';
		$fecha=$RResVentas["Fecha"];
		$nuevafecha = strtotime ( '+'.$RResVentas["Apagar"].' day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$comision=$RResVentas["Comision"]/100;
		
		if(date("Y-m-d")>$nuevafecha)
		{
			$status="VENCIDA";
		}
		if($RResVentas["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		if($RResVentas["Status"]=='PAGADO')
		{
			$bgcolor="#FFC0CB"; $status="PAGADO";
		}
		
		$saldo=$saldo+$RResVentas["Importe"];
		
		if($anno=='todos' OR $anno==$RResVentas["Fecha"][0].$RResVentas["Fecha"][1].$RResVentas["Fecha"][2].$RResVentas["Fecha"][3])
		{
		$cadena.='			<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResVentas["Id"].'" id="check_'.$RResVentas["Id"].'" value="1" onclick="xajax_pagos(\''.$cliente.'\', \'suma\', xajax.getFormValues(\'fsumaventas\'), \''.$anno.'\')"'; if($form["check_".$RResVentas["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResVentas["Fecha"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" ';if($RResVentas["SComision"]!='Pagado'){$cadena.=' class="Ntooltip"';}else{$cadena.=' class="Ntooltip0"';}$cadena.=' onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta(\''.$RResVentas["Id"].'\')">$ '.number_format($RResVentas["Importe"],2).'<span>'.$RResVentas["Comentarios"].'</span></a></td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldo,2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($nuevafecha).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$status.'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format(($RResVentas["Importe"]*$comision),2).'</td>
							</tr>';
		}
		$status='';
	}
	$cadena.='			</table></form>
					</td>';
	//PAGOS
	$cadena.='		<td valign="top" align="center">
						<form name="fsumapagos" id="fsumapagos">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="5" align="center" class="texto">&nbsp;</td>
								<td align="right" class="texto">';if($sumapagos>0){$cadena.='$ '.number_format($sumapagos,2);}$cadena.='</td>
								<td align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_pago(\''.$cliente.'\');">Agregar Pago</a> |</td>
							</tr>
							<tr>
								<td colspan="8" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGOS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
							</tr>';
	if($ResClienteV["Juridico"]==2)
	{
		$ResPagos=mysql_query("SELECT * FROM pagos WHERE Cliente='".$cliente."' ORDER BY Fecha ASC");
	}
	else
	{
		$ResPagos=mysql_query("SELECT * FROM pagos WHERE Cliente='".$cliente."' AND Historico='1' AND AnnoHistorico LIKE '".$ah."' ORDER BY Fecha ASC");
	}
	$pago=0;
	while($RResPagos=mysql_fetch_array($ResPagos))
	{
		$comision=$RResPagos["Comision"]/100;
		$pago=$pago+$RResPagos["Pago"];
		if($RResPagos["Banco"]==0){$banco="EFECTIVO";}
		elseif($RResPagos["Banco"]!=0){$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResPagos["Banco"]."' LIMIT 1")); $banco=$ResBanco["Nombre"];}
		
		$ResDetPago=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS Aplicado FROM detpago WHERE IdPago='".$RResPagos["Id"]."'"));
		$Restante=$RResPagos["Pago"]-$ResDetPago["Aplicado"];
		
		if($RResPagos["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		else
		{
			$bgcolor="#A9A9A9";
		}
		if($anno=='todos' OR $anno==$RResPagos["Fecha"][0].$RResPagos["Fecha"][1].$RResPagos["Fecha"][2].$RResPagos["Fecha"][3])
		{
		$cadena.='			<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="pago_'.$RResPagos["Id"].'" id="pago_'.$RResPagos["Id"].'" value="1" onclick="xajax_pagos(\''.$cliente.'\', \'sumapagos\', xajax.getFormValues(\'fsumapagos\'), \''.$anno.'\')"'; if($form["pago_".$RResPagos["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$banco.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResPagos["Cheque"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResPagos["Fecha"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_pago(\''.$RResPagos["Id"].'\');"';if($RResPagos["Status"]!='Pagado'){$cadena.=' class="Ntooltip"';}else{$cadena.=' class="Ntooltip0"';}$cadena.='>$ '.number_format($RResPagos["Pago"],2).'<span>'.$RResPagos["Comentarios"].'</span></a></td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($pago,2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format(($RResPagos["Pago"]*$comision),2).'</td>
							</tr>';
		}
		
	}
	$cadena.='			</table>
						</form>
					</td>';
	//CHEQUES
	$cadena.='		<td valign="top" align="center">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="6" align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_cheque(\''.$cliente.'\');">Agregar Cheque</a> |</td>
							</tr>
							<tr>
								<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUES POR COBRAR</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
							</tr>';
	$ResCheques=mysql_query("SELECT * FROM chequepost WHERE Cliente='".$cliente."' ORDER BY Fecha ASC");
	$saldoc=0;
	while($RResCheques=mysql_fetch_array($ResCheques))
	{
		$saldoc=$saldoc+$RResCheques["Importe"];
		$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResCheques["Banco"]."' LIMIT 1"));
		if($RResCheques["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		else
		{
			$bgcolor="#A9A9A9";
		}
		if($anno=='todos' OR $anno==$RResCheques["Fecha"][0].$RResCheques["Fecha"][1].$RResCheques["Fecha"][2].$RResCheques["Fecha"][3])
		{
		$cadena.='			<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResBanco["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResCheques["Fecha"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResCheques["NumCheque"].'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_cheque(\''.$RResCheques["Id"].'\')"  class="Ntooltip">$ '.number_format($RResCheques["Importe"], 2).'</a></td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldoc, 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_cheque_pago(\''.$RResCheques["Id"].'\');"><img src="images/ok.png" border="0" width="12" height="12"></a></td>
							</tr>';
		}
	}
	$cadena.='			</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="left">
					<p></p>
					<p></p>
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">DEUDA DEL CLIENTE ACTUAL : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format(($saldo-$pago),2).'</td>
							</tr>
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">DEUDA MENOS CHEQUES POST FECHADOS : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format((($saldo-$pago)-$saldoc),2).'</td>
							</tr>
							<tr>
								<td bgcolor="#000066" colspan="2" align="center" class="texto style="border: 1px solid #FFFFFF">';
	$ResJur=mysql_fetch_array(mysql_query("SELECT Juridico FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	if($ResJur["Juridico"]==0)
	{
		$cadena.='					<a href="#" onclick="xajax_juridico(\''.$cliente.'\')">ENVIAR A JURIDICO</a>';
	}
	elseif($ResJur["Juridico"]==1)
	{
		$cadena.='					<a href="#" onclick="xajax_juridico(\''.$cliente.'\', \'NO\', \'activar\')">ENVIAR A ACTIVO</a>';
	}
	$cadena.='					</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" colspan="2" align="center" class="texto style="border: 1px solid #FFFFFF">';
	$ResJur=mysql_fetch_array(mysql_query("SELECT Juridico FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	if($ResJur["Juridico"]!=2)
	{
		$cadena.='					<a href="#" onclick="xajax_historico_cliente(\''.$cliente.'\')">ENVIAR A HISTORICO</a>';
	}
	elseif($ResJur["Juridico"]==2)
	{
		$cadena.='					<a href="#" onclick="xajax_historico_cliente(\''.$cliente.'\', \'NO\', \'activar\')">ENVIAR A ACTIVO</a>';
	}
	$cadena.='					</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			';
		$adeudo=$saldo-$pago;
		if($ResClienteV["Juridico"]==2)
		{
			mysql_query("UPDATE clientes SET Adeudo='".$adeudo."' WHERE Id='".$cliente."'") or die(mysql_error());
		}
		
	}
//////// PANTALLA HOME /////////
	elseif($cliente==NULL)
	{
		$cadena.='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
					<td valign="top">';
		$cadena.='<form name="fsumaaclientes" id="fsumaaclientes"><table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_pagos(\'\', \'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES CON ADEUDO</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaclientes" id="allaclientes" value="1"';if($form["allaclientes"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaclientes()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
		$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo, Juridico FROM clientes ORDER BY Nombre ASC");
		$A=1; $B=1;
		while($RResClientesA=mysql_fetch_array($ResClientesA))
		{
			if($B==31)
			{
				$cadena.='<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES CON ADEUDO</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
				$B=1;
			}
			
			$ResHMC=mysql_fetch_array(mysql_query("SELECT Historico FROM pagos WHERE Cliente='".$RResClientesA["Id"]."' AND Historico='1'"));
			$ResHMC2=mysql_fetch_array(mysql_query("SELECT Historico FROM ventas WHERE Cliente='".$RResClientesA["Id"]."' AND Historico='1'"));
			
			if($RResClientesA["Juridico"]==2 OR $ResHMC!=0 OR $ResHMC2!=0)
			{
			$cadena.='<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="acliente_'.$RResClientesA["Id"].'" id="acliente_'.$RResClientesA["Id"].'" value="1"'; if($form["acliente_".$RResClientesA["Id"]]==1){$cadena.=' checked';}elseif($form["allaclientes"]==0){$cadena.='';}$cadena.='></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="xajax_pagos(\''.$RResClientesA["Id"].'\')">'.$RResClientesA["Nombre"].'</a></td>
						<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResClientesA["Adeudo"],2).'</td>
					</tr>';
			$A++; $B++;
			}
		}
		
		$cadena.='<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_pagos(\'\', \'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
					</tr></table></form></td><td valign="top">';
		
		$cadena.='<form name="fsumaaprovedores" id="fsumaaprovedores">
				<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_pagos(\'\', \'sumaaprovedores\', xajax.getFormValues(\'fsumaaprovedores\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaprovedores>0){$cadena.='$ '.number_format($sumaaprovedores, 2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO A PROVEEDORES</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaprovedores" id="allaprovedores" value="1"';if($form["allaprovedores"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaprovedores()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
		$ResProvedoresA=mysql_query("SELECT Id, Nombre, Adeudo, TipoCambio, Status FROM provedores ORDER BY Nombre ASC");
		$A=1;
		while($RResProvedoresA=mysql_fetch_array($ResProvedoresA))
		{
			$ResHMP=mysql_fetch_array(mysql_query("SELECT Historico FROM pagos_prov WHERE Provedor='".$RResProvedoresA["Id"]."' AND Historico='1'"));
			$ResHMP2=mysql_fetch_array(mysql_query("SELECT Historico FROM compras WHERE Provedor='".$RResProvedoresA["Id"]."' AND Historico='1'"));
			
			if($RResProvedoresA["Status"]==2 OR $ResHMP!=0 OR $ResHMP2!=0)
			{
			$cadena.='<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="aprovedor_'.$RResProvedoresA["Id"].'" id="aprovedor_'.$RResProvedoresA["Id"].'" value="1"'; if($form["aprovedor_".$RResProvedoresA["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="xajax_pagos_provedor(\''.$RResProvedoresA["Id"].'\')">'.$RResProvedoresA["Nombre"].'</a></td>
						<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ ';if($RResProvedoresA["TipoCambio"]==0){$cadena.=number_format($RResProvedoresA["Adeudo"],2);}else{$cadena.=number_format(($RResProvedoresA["Adeudo"]*$RResProvedoresA["TipoCambio"]),2);}$cadena.='</td>
					</tr>';
			$A++;
			}
		}
		$cadena.='<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_pagos(\'\', \'sumaaprovedores\', xajax.getFormValues(\'fsumaaprovedores\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaprovedores>0){$cadena.='$ '.number_format($sumaaprovedores, 2);}$cadena.='</td>
					</tr></table></form></td>
					<td valign="top">';
		//Existencia de telas
		$cadena.='<form name="fsumaatelas" id="fsumaatelas"><table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="5" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_pagos(\'\', \'sumaatelas\', xajax.getFormValues(\'fsumaatelas\'))">Calcular :</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaatelas>0){$cadena.='$ '.number_format($sumaatelas,2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">EXISTENCIA TELAS</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allatelas" id="allatelas" value="1" ';if($form["allatelas"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaatelas()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">EXISTENCIA</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					</tr>';
		$A=1;
		$ResTelas=mysql_query("SELECT Id, Nombre, Color, Existencia, Importe, Status FROM telas ORDER BY Nombre ASC");
		while($RResTelas=mysql_fetch_array($ResTelas))
		{
			$exihis=mysql_num_rows(mysql_query("SELECT Id FROM existencias WHERE Tela='".$RResTelas["Id"]."' AND Historico='1'"));
			if($RResTelas["Status"]==2 OR $exihis!=0)
			{
			$cadena.='<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="atela_'.$RResTelas["Id"].'" id="atela_'.$RResTelas["Id"].'" value="1" '; if($form["atela_".$RResTelas["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_existencias(\''.$RResTelas["Id"].'\')" class="Ntooltip">'.$RResTelas["Nombre"].'</a></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResTelas["Color"].'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResTelas["Existencia"].'</td>
						<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResTelas["Importe"], 2).'</td>
					</tr>';
					$A++;
			}
		}
		$cadena.='	<tr>
						<td colspan="5" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_pagos(\'\', \'sumaatelas\', xajax.getFormValues(\'fsumaatelas\'))">Calcular :</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaatelas>0){$cadena.='$ '.number_format($sumaatelas,2);}$cadena.='</td>
					</tr>	
						</table></form>
					</td>
					</tr>
					
					</table>';
	}
	
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_venta($cliente)
{
	include ("conexion.php");
	
	$cadena='<form name="fadventa" id="fadventa" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="7" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">A PAGAR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PROVEEDOR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS COMISION</td>
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
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="apagar" id="apagar">
							<option value="1">1</option>
							<option value="15">15</option>
							<option value="30">30</option>
							<option value="45">45</option>
							<option value="60">60</option>
							<option value="75">75</option>
							<option value="90">90</option>
							<option value="105">105</option>
							<option value="120">120</option>
						</select> dias
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="provedor" id="provedor"><option>SELECCIONE</option>';
	$ResProvedores=mysql_query("SELECT * FROM provedores ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='			<option value="'.$RResProvedores["Id"].'">'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="comision" id="comision" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="scomision" id="scomision">
							<option value="Pendiente">PENDIENTE</option>
							<option value="Pagado">PAGADO</option>
						</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">Comentarios: <br /><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadpago" id="botadpago" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$cliente.'\', \'adventa\', xajax.getFormValues(\'fadventa\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}	
function editar_venta($venta)
{
	include ("conexion.php");
	
	$ResVenta=mysql_fetch_array(mysql_query("SELECT * FROM ventas WHERE Id='".$venta."' LIMIT 1"));
	
	$cadena='<form name="feditventa" id="feditventa" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="9" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
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
	for($i=2010; $i<=(date("Y")+1); $i++)
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
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResVenta["checka"]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResVenta["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResVenta["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select>
					</td>
				</tr>
				<tr>
					<td colspan="8" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">Comentarios: <br /><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResVenta["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td colspan="8" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idventa" id="idventa" value="'.$ResVenta["Id"].'">';
if($ResVenta["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="botadpago" id="botadpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResVenta["Cliente"].'\', \'editventa\', xajax.getFormValues(\'feditventa\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResVenta["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="botadpago" id="botadpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResVenta["Cliente"].'\', \'editventa\', xajax.getFormValues(\'feditventa\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
$cadena.='			</td>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
	
}
function agregar_pago($cliente)
{
	$cadena='<form name="fadpago" id="fadpago" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="6" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">EFECTIVO</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'">'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
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
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="comision" id="comision" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="pago" id="pago" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<textarea name="comentarios" id="comentarios" rows="5" cols="50"></textarea>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadpago" id="botadpago" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$cliente.'\', \'adpago\', xajax.getFormValues(\'fadpago\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function aplica_restante($cliente, $pago)
{
	include ("conexion.php");
	
	$ResPago=mysql_fetch_array(mysql_query("SELECT * FROM pagos WHERE Id='".$pago."' LIMIT 1"));
	
	$cadena='<form name="fadpago" id="fadpago" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="7" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">RESTANTE</td>
					<td bgcolor="#FFFF99" align="center" class="texto3" style="border:1px solid #FFFFFF">CUENTA</td>
				</tr>
				<tr>
					<td bgcolor="#FFFF99" align="left" class="texto" style="border:1px solid #FFFFFF">';
	if($ResPago["Banco"]==0){$cadena.='EFECTIVO';}
	else{$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$ResPago["Banco"]."' LIMIT 1")); $cadena.=$ResBanco["Nombre"];}
	$ResAplicado=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS Aplicado FROM detpago WHERE IdPago='".$ResPago["Id"]."'"));
	$restante=$ResPago["Pago"]-$ResAplicado["Aplicado"];
	$cadena.='		</td>
					<td bgcolor="#FFFF99" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResPago["Cheque"].'</td>
					<td bgcolor="#FFFF99" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($ResPago["Fecha"]).'</td>
					<td bgcolor="#FFFF99" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResPago["Comision"].'</td>
					<td bgcolor="#FFFF99" align="center" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($ResPago["Pago"],2).'</td>
					<td bgcolor="#FFFF99" align="center" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($restante,2).'</td>
					<td bgcolor="#FFFF99" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select multiple name="ventas[]" id="ventas[]" style="direction: rtl;">';
	$ResCuentas=mysql_query("SELECT Id, Importe FROM ventas WHERE Cliente='".$cliente."' AND Status!='PAGADO' ORDER BY Fecha ASC");
	while($RResCuentas=mysql_fetch_array($ResCuentas))
	{
		$cadena.='<option value="'.$RResCuentas["Id"].'">$'.number_format($RResCuentas["Importe"], 2).'</option>';
	}
	$cadena.='			</select>
					</td>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="restante" id="restante" value="'.$restante.'">
						<input type="hidden" name="idpago" id="idpago" value="'.$ResPago["Id"].'">
						<input type="submit" name="botadpago" id="botadpago" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$cliente.'\', \'aplicapago\', xajax.getFormValues(\'fadpago\'))">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;	
}
function agregar_cheque($cliente)
{
$cadena='<form name="fadcheque" id="fadcheque" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="5" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">SELECCIONE</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'">'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
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
	for($i=2010; $i<=(date("Y")+2); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadpago" id="botadpago" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$cliente.'\', \'adcheque\', xajax.getFormValues(\'fadcheque\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_cheque($cheque)
{
	$ResCheque=mysql_fetch_array(mysql_query("SELECT * FROM chequepost WHERE Id='".$cheque."' LIMIT 1"));
	
$cadena='<form name="feditcheque" id="feditcheque" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="5" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">SELECCIONE</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($RResBancos["Id"]==$ResCheque["Banco"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResCheque["Fecha"][8].$ResCheque["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+2); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResCheque["Fecha"][0].$ResCheque["Fecha"][1].$ResCheque["Fecha"][2].$ResCheque["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input" value="'.$ResCheque["NumCheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input" value="'.$ResCheque["Importe"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResCheque["checka"]==1){$cadena.=' checked';}$cadena.='></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcheque" id="idcheque" value="'.$ResCheque["Id"].'">';
	if($ResCheque["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="boteditcheque" id="boteditcheque" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResCheque["Cliente"].'\', \'editcheque\', xajax.getFormValues(\'feditcheque\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	elseif($ResCheque["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="boteditcheque" id="boteditcheque" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResCheque["Cliente"].'\', \'editcheque\', xajax.getFormValues(\'feditcheque\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	$cadena.='		</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_pago($pago)
{
	include ("conexion.php");
	
	$ResPago=mysql_fetch_array(mysql_query("SELECT * FROM pagos WHERE Id='".$pago."' LIMIT 1"));
	
	$cadena='<form name="feditpago" id="feditpago" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="8" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0"';if($ResPago["Banco"]==0){$cadena.=' selected';}$cadena.='>EFECTIVO</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($ResPago["Banco"]==$RResBancos["Id"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input" value="'.$ResPago["Cheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResPago["Fecha"][8].$ResPago["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResPago["Fecha"][0].$ResPago["Fecha"][1].$ResPago["Fecha"][2].$ResPago["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="comision" id="comision" class="input" value="'.$ResPago["Comision"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="pago" id="pago" class="input" value="'.$ResPago["Pago"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<SELECT name="status" id="status"';if($ResPago["Status"]=='Pagado'){$cadena.=' disabled';}$cadena.='>
							<option value="Pendiente"';if($ResPago["Status"]=='Pendiente'){$cadena.=' selected';}$cadena.='>Pendiente</option>
							<option value="Pagado"';if($ResPago["Status"]=='Pagado'){$cadena.=' selected';}$cadena.='>Pagado</option>
						</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResPago["checka"]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResPago["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResPago["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select>
					</td>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<textarea name="comentarios" id="comentarios" rows="5" cols="50">'.$ResPago["Comentarios"].'</textarea>
				</tr>
				<tr>
					<td colspan="7" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idpago" id="idpago" value="'.$ResPago["Id"].'">';
if($ResPago["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="boteditpago" id="boteditpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResPago["Cliente"].'\', \'editpago\', xajax.getFormValues(\'feditpago\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResPago["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="boteditpago" id="boteditpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResPago["Cliente"].'\', \'editpago\', xajax.getFormValues(\'feditpago\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}

$cadena.='			</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function cheque_pago($cheque)
{
	include ("conexion.php");
	
	$ResCheque=mysql_fetch_array(mysql_query("SELECT * FROM chequepost WHERE Id='".$cheque."' LIMIT 1"));
	
	$cadena='<form name="fchequepago" id="fchequepago" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="5" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0"';if($ResPago["Banco"]==0){$cadena.=' selected';}$cadena.='>EFECTIVO</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($ResCheque["Banco"]==$RResBancos["Id"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input" value="'.$ResCheque["NumCheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResCheque["Fecha"][8].$ResCheque["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResCheque["Fecha"][0].$ResCheque["Fecha"][1].$ResCheque["Fecha"][2].$ResCheque["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="comision" id="comision" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="pago" id="pago" class="input" value="'.$ResCheque["Importe"].'"></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcheque" id="idcheque" value="'.$ResCheque["Id"].'">
						<input type="submit" name="boteditchequepago" id="boteditchequepago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos(\''.$ResCheque["Cliente"].'\', \'adpago\', xajax.getFormValues(\'fchequepago\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}

function pagos_provedor($provedor=NULL, $accion=NULL, $form=NULL, $anno='todos', $annohist='todos')
{
	include ("conexion.php");
	
	switch($accion)
	{	
		//Agregamos venta
		case 'adcompra':
			mysql_query("INSERT INTO compras (Provedor, Fecha, Apagar, Importe, Comentarios, checka)
									 VALUES ('".$provedor."',
											 '".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
											 '".$form["apagar"]."',
											 '".$form["importe"]."',
											 '".$form["comentarios"]."',
											 '".$form["checka"]."')") or die(mysql_error());
			break;
		//pagar venta
		case 'pagaventa':
			mysql_query("UPDATE ventas SET Status='PAGADO' WHERE Id='".$form."'") or die(mysql_error());
			break;
		//editar compra
		case 'editcompra':
			mysql_query("UPDATE compras SET Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
										   Apagar='".$form["apagar"]."',
										   Importe='".$form["importe"]."',
										   Status='".$form["status"]."',
										   Comentarios='".$form["comentarios"]."',
										   checka='".$form["checka"]."',
										   Historico='".$form["historico"]."',
										   AnnoHistorico='".$form["annohistorico"]."'
									 WHERE Id='".$form["idcompra"]."'") or die(mysql_error());
			break;
		//agregar Pago
		case 'adpagoprov':
			mysql_query("INSERT INTO pagos_prov (Provedor, Banco, Cheque, Fecha, Pago, Comentarios, checka)
									VALUES ('".$provedor."',
											'".$form["banco"]."',
											'".$form["numcheque"]."',
											'".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
											'".$form["pago"]."',
											'".utf8_decode($form["comentarios"])."',
											'".$form["checka"]."')") or die(mysql_error());
											
			if(isset($form["idcheque"]))
			{
				mysql_query("DELETE FROM chequepost_prov WHERE Id='".$form["idcheque"]."'");
			}
											
			break;
		//agregar cheque post fechado
		case 'adcheque':
			mysql_query("INSERT INTO chequepost_prov (Banco, Fecha, NumCheque, Importe, Provedor, checka)
										 VALUES ('".$form["banco"]."',
												 '".$form["anno"]."-".$form["mes"]."-".$form["dia"]."',
												 '".$form["numcheque"]."',
												 '".$form["importe"]."',
												 '".$provedor."',
												 '".$form["checka"]."')") or die(mysql_error());
			break;
		//editar cheque
		case 'editcheque':
			mysql_query("UPDATE chequepost_prov SET Banco='".$form["banco"]."', 
													Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
													NumCheque='".$form["numcheque"]."', 
													Importe='".$form["importe"]."', 
													checka='".$form["checka"]."'
											  WHERE Id='".$form["idcheque"]."'") or die(mysql_error());
			break;
		//suma compras seleccionados
		case 'suma':
			$suma=0;
			$ResSuma=mysql_query("SELECT Id, Importe FROM compras WHERE Provedor='".$provedor."' ORDER BY Id ASC");
			while($RResSuma=mysql_fetch_array($ResSuma))
			{
				if($form["check_".$RResSuma["Id"]]==1)
				{
					$suma=$suma+$RResSuma["Importe"];
				}
			}
			break;
		//suma los pagos hechos
		case 'sumapagos':
			$sumapagos=0;
			$ResSumaPagos=mysql_query("SELECT Id, Pago FROM pagos_prov WHERE Provedor='".$provedor."' ORDER BY Id ASC");
			while($RResSumaPagos=mysql_fetch_array($ResSumaPagos))
			{
				if($form["pago_".$RResSumaPagos["Id"]]==1)
				{
					$sumapagos=$sumapagos+$RResSumaPagos["Pago"];
				}
			}
			break;
		//editar pagos
		case 'editpagoprov':
			mysql_query("UPDATE pagos_prov SET Banco='".$form["banco"]."', 
										   Cheque='".$form["numcheque"]."', 
										   Fecha='".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
										   Pago='".$form["pago"]."',
										   Comentarios='".utf8_decode($form["comentarios"])."',
										   checka='".$form["checka"]."',
										   Historico='".$form["historico"]."',
										   AnnoHistorico='".$form["annohistorico"]."'
									 WHERE Id='".$form["idpago"]."'") or die(mysql_error());
			break;
		//agregar tipo de cambio
		case 'tipocambio':
			mysql_query("UPDATE provedores SET TipoCambio='".$form["tipocambio"]."' WHERE Id='".$provedor."'")or die(mysql_error());
			break;
	}
	
	$cadena='<p align="center" class="texto">Cliente: <select name="cliente" id="cliente" onchange="xajax_pagos(this.value)"><option>Seleccione</option>';
	$ResCliente=mysql_query("SELECT * FROM clientes ORDER BY Nombre ASC");
	while($RResCliente=mysql_fetch_array($ResCliente))
	{
		$ResHist=mysql_num_rows(mysql_query("SELECT Historico FROM ventas WHERE Cliente='".$RResCliente["Id"]."' AND Historico='1'"));
		$ResHistp=mysql_num_rows(mysql_query("SELECT Historico FROM pagos WHERE Cliente='".$RResCliente["Id"]."' AND Historico='1'"));
		
		if($RResCliente["Juridico"]==2 OR $ResHist!=0 OR $ResHistp!=0)
		{
			$cadena.='<option value="'.$RResCliente["Id"].'">'.$RResCliente["Nombre"].'</option>';
		}
	}
	$cadena.='</select> <img src="images/impresora.jpg" border="0"> Provedor: <select name="provedor" id="provedor" onchange="xajax_pagos_provedor(this.value)"><option>Seleccione</option>';
	$ResProvedor=mysql_query("SELECT * FROM provedores ORDER BY Nombre ASC");
	while($RResProvedor=mysql_fetch_array($ResProvedor))
	{
		$ResHistProv=mysql_num_rows(mysql_query("SELECT Historico FROM compras WHERE Provedor='".$RResProvedor["Id"]."' AND Historico='1'"));
		//$ResHistp=mysql_num_rows(mysql_query("SELECT Historico FROM pagos WHERE Cliente='".$RResCliente["Id"]."' AND Historico='1'"));
		
		if($RResProvedor["Status"]==2 OR $ResHistProv!=0)
		{	
			$cadena.='<option value="'.$RResProvedor["Id"].'"';if($provedor==$RResProvedor["Id"]){$cadena.=' selected';}$cadena.='>'.$RResProvedor["Nombre"].'</option>';
		}
	}
	$cadena.='</select><a href="reportes/reporteprovedor.php?provedor='.$provedor.'" target="_blank"><img src="images/impresora.jpg" border="0"></a></p>
		<p align="center" class="texto">&nbsp;<br />A&ntilde;o: <select name="anno" id="anno" onChange="xajax_pagos_provedor(\''.$provedor.'\', \''.$accion.'\', \''.$form.'\', this.value, document.getElementById(\'annohist\').value)">
			<option value="todos">Todos</option>';
	for($i=2000; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($anno==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}	
	$cadena.='	</select> A&ntilde;o Historico: <select name="annohist" id="annohist" onChange="xajax_pagos_provedor(\''.$provedor.'\', \''.$accion.'\', \''.$form.'\', document.getElementById(\'anno\').value, this.value)">
					<option value="todos">Todos</option>';
	for($i=2000; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($annohist==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}	
	$cadena.='	</select>';
	if($provedor!=NULL)
	{
	$cadena.='<table border="0" align="center">
				<tr>
					<td valign="top" align="center">
					<form id="fsumacompras" id="fsumacompras">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">';if($suma>0){$cadena.='$ '.number_format($suma,2);}$cadena.='</td>
								<td colspan="5" align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_compra(\''.$provedor.'\');">Agregar Compra</a> |</td>
							</tr>
							<tr>
								<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMPRAS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENCIMIENTO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
							</tr>';
	if($annohist=='todos'){$ah='%';}else{$ah=$annohist;}						
	
	$ResProvedorC=mysql_fetch_array(mysql_query("SELECT Status FROM provedores WHERE Id='".$provedor."' LIMIT 1"));
	if($ResProvedorC["Status"]==2)
	{
		$ResCompras=mysql_query("SELECT * FROM compras WHERE Provedor='".$provedor."' ORDER BY Fecha ASC");
	}
	else
	{
		$ResCompras=mysql_query("SELECT * FROM compras WHERE Provedor='".$provedor."' AND Historico='1' AND AnnoHistorico LIKE '".$ah."' ORDER BY Fecha ASC");
	}
	while($RResCompras=mysql_fetch_array($ResCompras))
	{
		$bgcolor='#A9A9A9';
		$fecha=$RResCompras["Fecha"];
		$nuevafecha = strtotime ( '+'.$RResCompras["Apagar"].' day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
		
		if(date("Y-m-d")>$nuevafecha)
		{
			$status="VENCIDA";
		}
		if($RResCompras["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		if($RResCompras["Status"]=='PAGADO')
		{
			$bgcolor="#FFC0CB"; $status="PAGADO";
		}
		$saldo=$saldo+$RResCompras["Importe"];
		if($anno=='todos' OR $anno==$RResCompras["Fecha"][0].$RResCompras["Fecha"][1].$RResCompras["Fecha"][2].$RResCompras["Fecha"][3])
		{
		$cadena.='			<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="check_'.$RResCompras["Id"].'" id="check_'.$RResCompras["Id"].'" value="1" onclick="xajax_pagos_provedor(\''.$provedor.'\', \'suma\', xajax.getFormValues(\'fsumacompras\'))"'; if($form["check_".$RResCompras["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResCompras["Fecha"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_compra(\''.$RResCompras["Id"].'\')">$ '.number_format($RResCompras["Importe"],2).'<span>'.$RResCompras["Comentarios"].'</span></a></td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldo,2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($nuevafecha).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$status.'</td>
							</tr>';
		}
		$status='';
	}
	
	$cadena.='			</table></form>
					</td>';
	//PAGOS
	$cadena.='		<td valign="top" align="center">
						<form name="fsumapagos" id="fsumapagos">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="4" align="center" class="texto">&nbsp;</td>
								<td align="right" class="texto">';if($sumapagos>0){$cadena.='$ '.number_format($sumapagos,2);}$cadena.='</td>
								<td align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_pago_prov(\''.$provedor.'\');">Agregar Pago</a> |</td>
							</tr>
							<tr>
								<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGOS</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
							</tr>';
	if($ResProvedorC["Status"]==2)
	{
		$ResPagos=mysql_query("SELECT * FROM pagos_prov WHERE Provedor='".$provedor."' ORDER BY Fecha ASC");
	}
	else
	{
		$ResPagos=mysql_query("SELECT * FROM pagos_prov WHERE Provedor='".$provedor."' AND Historico='1' AND AnnoHistorico LIKE '".$ah."' ORDER BY Fecha ASC");
	}
	$pago=0;
	while($RResPagos=mysql_fetch_array($ResPagos))
	{
		$pago=$pago+$RResPagos["Pago"];
		if($RResPagos["Banco"]==0){$banco="EFECTIVO";}
		elseif($RResPagos["Banco"]!=0){$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResPagos["Banco"]."' LIMIT 1")); $banco=$ResBanco["Nombre"];}
		
		$ResDetPago=mysql_fetch_array(mysql_query("SELECT SUM(Importe) AS Aplicado FROM detpago WHERE IdPago='".$RResPagos["Id"]."'"));
		$Restante=$RResPagos["Pago"]-$ResDetPago["Aplicado"];
		$bgcolor="#A9A9A9";
		if($RResPagos["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		if($anno=='todos' OR $anno==$RResPagos["Fecha"][0].$RResPagos["Fecha"][1].$RResPagos["Fecha"][2].$RResPagos["Fecha"][3])
		{
		$cadena.='			<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="pago_'.$RResPagos["Id"].'" id="pago_'.$RResPagos["Id"].'" value="1" onclick="xajax_pagos_provedor(\''.$provedor.'\', \'sumapagos\', xajax.getFormValues(\'fsumapagos\'))"'; if($form["pago_".$RResPagos["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$banco.'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResPagos["Cheque"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResPagos["Fecha"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_pago_prov(\''.$RResPagos["Id"].'\');" class="Ntooltip">$ '.number_format($RResPagos["Pago"],2).'<span>'.$RResPagos["Comentarios"].'</span></a></td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($pago,2).'</td>
							</tr>';
		}
		
	}
	
	$cadena.='			</table>
						</form>
					</td>';
	//CHEQUES
	$cadena.='		<td valign="top" align="center">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td colspan="5" align="right" class="texto">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_cheque(\''.$cliente.'\');">Agregar Cheque</a> |</td>
							</tr>
							<tr>
								<td colspan="5" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUES POR PAGAR</td>
							</tr>
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">SALDO</td>
							<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
							</tr>';
	$ResCheques=mysql_query("SELECT * FROM chequepost_prov WHERE Provedor='".$provedor."' ORDER BY Fecha ASC");
	$saldoc=0;
	while($RResCheques=mysql_fetch_array($ResCheques))
	{
		$bgcolor="#A9A9A9";
		$saldoc=$saldoc+$RResCheques["Importe"];
		$ResBanco=mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Id='".$RResCheques["Banco"]."' LIMIT 1"));
		if($RResCheques["checka"]==1)
		{
			$bgcolor="#CCCCCC";
		}
		if($anno=='todos' OR $anno==$RResCheques["Fecha"][0].$RResCheques["Fecha"][1].$RResCheques["Fecha"][2].$RResCheques["Fecha"][3])
		{
		$cadena.='			<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$ResBanco["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.fecha($RResCheques["Fecha"]).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResCheques["NumCheque"].'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResCheques["Importe"], 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($saldoc, 2).'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_cheque_pago_prov(\''.$RResCheques["Id"].'\');"><img src="images/ok.png" border="0" width="12" height="12"></a></td>
							</tr>';
		}
	}
	$cadena.='			</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="left">';
	$ResTipoCambio=mysql_fetch_array(mysql_query("SELECT TipoCambio FROM provedores WHERE Id='".$provedor."' LIMIT 1"));
	$cadena.='			<p></p>
						<p></p>
						<form name="ftipocambio" id="ftipocambio">
						<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="left">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">USD</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TIPO DE CAMBIO</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">MXN</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">DEUDA DEL PROVEDOR ACTUAL : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format(($saldo-$pago),2).'</td>
								<td bgcolor="#CCCCCC" rowspan="2" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="tipocambio" id="tipocambio" class="input" size="5" value="';if($ResTipoCambio["TipoCambio"]!=0){$cadena.=$ResTipoCambio["TipoCambio"];}$cadena.='"></td>
								<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">';if($ResTipoCambio["TipoCambio"]==0){$cadena.='$ '.number_format(($saldo-$pago),2);}else{$cadena.='$ '.number_format((($saldo-$pago)*$ResTipoCambio["TipoCambio"]),2);}$cadena.='</td>
								<td bgcolor="#CCCCCC" rowspan="2" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="button" name="botcalctipocambio" id="botcalctipocambio" value="Calcular" class="boton" onclick="xajax_pagos_provedor(\''.$provedor.'\', \'tipocambio\', xajax.getFormValues(\'ftipocambio\'))"></td>
							</tr>
							<tr>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">DEUDA MENOS CHEQUES POST FECHADOS : </td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format((($saldo-$pago)-$saldoc),2).'</td>
								<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">';if($ResTipoCambio["TipoCambio"]==0){$cadena.='$ '.number_format((($saldo-$pago)-$saldoc),2);}else{$cadena.='$ '.number_format(((($saldo-$pago)-$saldoc)*$ResTipoCambio["TipoCambio"]),2);}$cadena.='</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
			
			';
			
			$adeudo=$saldo-$pago;
		if($ResProvedorC["Status"]==2)
		{	
			mysql_query("UPDATE provedores SET Adeudo='".$adeudo."' WHERE Id='".$provedor."'") or die(mysql_error());
		}
					
	}
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_compra($provedor)
{
	include ("conexion.php");
	
	$cadena='<form name="fadcompra" id="fadcompra" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="4" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">A PAGAR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
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
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="apagar" id="apagar">
						<option value="1">1</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
						<option value="60">60</option>
						<option value="75">75</option>
						<option value="90">90</option>
						<option value="105">105</option>
						<option value="120">120</option>
					</select> dias
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td colspan="3" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">Comentarios: <br /><textarea name="comentarios" id="comentarios" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td colspan="3" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadcompra" id="botadcompra" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$provedor.'\', \'adcompra\', xajax.getFormValues(\'fadcompra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_compra($compra)
{
	include ("conexion.php");
	
	$ResCompra=mysql_fetch_array(mysql_query("SELECT * FROM compras WHERE Id='".$compra."' LIMIT 1"));
	
	$cadena='<form name="feditcompra" id="feditcompra" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="6" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">A PAGAR</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">STATUS</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
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
	for($i=2010; $i<=(date("Y")+1); $i++)
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
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResCompra["checka"]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResCompra["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResCompra["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select>
					</td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">Comentarios: <br /><textarea name="comentarios" id="comentarios" cols="50" rows="5">'.$ResCompra["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcompra" id="idcompra" value="'.$ResCompra["Id"].'">';
if($ResCompra["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="boteditcompra" id="boteditcompra" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$ResCompra["Provedor"].'\', \'editcompra\', xajax.getFormValues(\'feditcompra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
elseif($ResCompra["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="boteditcompra" id="boteditcompra" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$ResCompra["Provedor"].'\', \'editcompra\', xajax.getFormValues(\'feditcompra\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
$cadena.='			</td>
			</table>
			</form>';
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
	
}
function agregar_pago_prov($provedor)
{
	$cadena='<form name="fadpagoprov" id="fadpagoprov" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="5" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">EFECTIVO</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'">'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
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
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="pago" id="pago" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<textarea name="comentarios" id="comentarios" rows="3" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadpago" id="botadpago" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$provedor.'\', \'adpagoprov\', xajax.getFormValues(\'fadpagoprov\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_pago_prov($pago)
{
	include ("conexion.php");
	
	$ResPago=mysql_fetch_array(mysql_query("SELECT * FROM pagos_prov WHERE Id='".$pago."' LIMIT 1"));
	
	$cadena='<form name="feditpagoprov" id="feditpagoprov" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="6" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHECK</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0"';if($ResPago["Banco"]==0){$cadena.=' selected';}$cadena.='>EFECTIVO</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($ResPago["Banco"]==$RResBancos["Id"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input" value="'.$ResPago["Cheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResPago["Fecha"][8].$ResPago["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResPago["Fecha"][5].$ResPago["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResPago["Fecha"][0].$ResPago["Fecha"][1].$ResPago["Fecha"][2].$ResPago["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="pago" id="pago" class="input" value="'.$ResPago["Pago"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="checka" id="checka" value="1"';if($ResPago["checka"]==1){$cadena.=' checked';}$cadena.='></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="historico" id="historico" value="1"';if($ResPago["Historico"]==1){$cadena.=' checked';}$cadena.='> <select name="annohistorico" id="annohistorico">';
for($i=date("Y");$i>=2000;$i--)
{
	$cadena.='<option value="'.$i.'"';if($ResPago["AnnoHistorico"]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
}
$cadena.='				</select>
					</td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<textarea name="comentarios" id="comentarios" rows="3" cols="50">'.$ResPago["Comentarios"].'</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="6" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idpago" id="idpago" value="'.$ResPago["Id"].'">';
	if($ResPago["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="boteditpago" id="boteditpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$ResPago["Provedor"].'\', \'editpagoprov\', xajax.getFormValues(\'feditpagoprov\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	elseif($ResPago["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="boteditpago" id="boteditpago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$ResPago["Provedor"].'\', \'editpagoprov\', xajax.getFormValues(\'feditpagoprov\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	$cadena.='		</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_cheque_prov($provedor)
{
$cadena='<form name="fadcheque" id="fadcheque" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="4" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">SELECCIONE</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'">'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='			</select></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
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
	for($i=2010; $i<=(date("Y")+2); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input"></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="submit" name="botadpago" id="botadpago" value="Agregar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$provedor.'\', \'adcheque\', xajax.getFormValues(\'fadcheque\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function editar_cheque_prov($cheque)
{
	$ResCheque=mysql_fetch_array(mysql_query("SELECT * FROM chequepost_prov WHERE Id='".$cheque."' LIMIT 1"));
	
$cadena='<form name="feditcheque" id="feditcheque" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="4" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0">SELECCIONE</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($RResBancos["Id"]==$ResCheque["Banco"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='			</select></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResCheque["Fecha"][8].$ResCheque["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+2); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==date("Y")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input" value="'.$ResCheque["NumCheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="importe" id="importe" class="input" value="'.$ResCheque["Importe"].'"></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcheque" id="idcheque" value="'.$ResCheque["Id"].'">';
	if($ResCheque["checka"]==1 AND $_SESSION["perfil"]=='administra'){$cadena.='<input type="submit" name="boteditcheque" id="boteditcheque" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$provedor.'\', \'editcheque\', xajax.getFormValues(\'feditcheque\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	elseif($ResCheque["checka"]==0 AND ($_SESSION["perfil"]=='administra' OR $_SESSION["perfil"]=="usuario")){$cadena.='<input type="submit" name="boteditcheque" id="boteditcheque" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$provedor.'\', \'editcheque\', xajax.getFormValues(\'feditcheque\')); document.getElementById(\'lightbox\').innerHTML = \'\'">';}
	$cadena.='		</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function cheque_pago_prov($cheque)
{
	include ("conexion.php");
	
	$ResCheque=mysql_fetch_array(mysql_query("SELECT * FROM chequepost_prov WHERE Id='".$cheque."' LIMIT 1"));
	
	$cadena='<form name="fchequepago" id="fchequepago" method="post" action="javascript:void(null)">
			<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="5" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">BANCO</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CHEQUE</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">FECHA</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COMISION</td>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">PAGO</td>
				</tr>
				<tr>
					<td bgcolor="CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
						<select name="banco" id="banco"><option value="0"';if($ResPago["Banco"]==0){$cadena.=' selected';}$cadena.='>EFECTIVO</option>';
	$ResBancos=mysql_query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
	while($RResBancos=mysql_fetch_array($ResBancos))
	{
		$cadena.='<option value="'.$RResBancos["Id"].'"';if($ResCheque["Banco"]==$RResBancos["Id"]){$cadena.=' selected';}$cadena.='>'.$RResBancos["Nombre"].'</option>';
	}
	$cadena.='		</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="numcheque" id="numcheque" class="input" value="'.$ResCheque["NumCheque"].'"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">
					<select name="dia" id="dia">';
	for($i=1;$i<=31;$i++)
	{
		if($i<=9){$i='0'.$i;}
		$cadena.='			<option value="'.$i.'"';if($ResCheque["Fecha"][8].$ResCheque["Fecha"][9]==$i){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select> <select name="mes" id="mes">
							<option value="01"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"';if($ResCheque["Fecha"][5].$ResCheque["Fecha"][6]=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select> <select name="anno" id="anno">';
	for($i=2010; $i<=(date("Y")+1); $i++)
	{
		$cadena.='		<option value="'.$i.'"';if($i==$ResCheque["Fecha"][0].$ResCheque["Fecha"][1].$ResCheque["Fecha"][2].$ResCheque["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='		</select>
					</td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="text" name="comision" id="comision" class="input"></td>
					<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">$ <input type="number" name="pago" id="pago" class="input" value="'.$ResCheque["Importe"].'"></td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="center" class="texto" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idcheque" id="idcheque" value="'.$ResCheque["Id"].'">
						<input type="submit" name="boteditchequepago" id="boteditchequepago" value="Editar>" onclick="lightbox.style.visibility=\'hidden\'; xajax_pagos_provedor(\''.$ResCheque["Provedor"].'\', \'adpago\', xajax.getFormValues(\'fchequepago\')); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function juridico($cliente, $juridico='NO', $activar=NULL)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	
	if($activar==NULL) //mandar a juridico
	{
	
	if($juridico=='NO')
	{
		$cadena='<p align="center" class="textomensaje">Esta seguro que desea enviar a Juridico al cliente: '.$ResCliente["Nombre"].'<br />
					<a href="#" onclick="xajax_juridico(\''.$cliente.'\', \'SI\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_pagos(\''.$cliente.'\')">NO</a></p>';
	}
	elseif($juridico=='SI')
	{
		mysql_query("UPDATE clientes SET Juridico='1' WHERE Id='".$cliente."'");
		$cadena='<p align="center" class="textomensaje">Se movio el cliente a Juridico</p>';
	}
	}
	elseif($activar=='activar') //mandar a activo
	{
		if($juridico=='NO')
	{
		$cadena='<p align="center" class="textomensaje">Esta seguro que desea enviar a Activo al cliente: '.$ResCliente["Nombre"].'<br />
					<a href="#" onclick="xajax_juridico(\''.$cliente.'\', \'SI\', \'activar\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_pagos(\''.$cliente.'\')">NO</a></p>';
	}
	elseif($juridico=='SI')
	{
		mysql_query("UPDATE clientes SET Juridico='0' WHERE Id='".$cliente."'");
		$cadena='<p align="center" class="textomensaje">Se movio el cliente a Activo</p>';
	}
	}
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function ver_juridico($cliente=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	switch($accion)
	{
		case 'sumaaclientes':
			$sumaaclientes=0;
			$ResSumaAClientes=mysql_query("SELECT Id, Adeudo FROM clientes ORDER BY Id ASC");
			while($RResSumaAClientes=mysql_fetch_array($ResSumaAClientes))
			{
				if($form["acliente_".$RResSumaAClientes["Id"]]==1)
				{
					$sumaaclientes=$sumaaclientes+$RResSumaAClientes["Adeudo"];
				}
			}
			break;
	}
	
	$cadena.='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
					<td valign="top">';
		$cadena.='<form name="fsumaaclientes" id="fsumaaclientes"><table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_juridico(\'\', \'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES EN JURIDICO</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaclientes" id="allaclientes" value="1"';if($form["allaclientes"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaclientes()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
		$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo FROM clientes WHERE Juridico='1' ORDER BY Adeudo DESC");
		$A=1; $B=1;
		while($RResClientesA=mysql_fetch_array($ResClientesA))
		{
			if($B==31)
			{
				$cadena.='<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">CLIENTES EN JURIDICO</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
				$B=1;
			}
			$cadena.='<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="acliente_'.$RResClientesA["Id"].'" id="acliente_'.$RResClientesA["Id"].'" value="1"'; if($form["acliente_".$RResClientesA["Id"]]==1){$cadena.=' checked';}elseif($form["allaclientes"]==0){$cadena.='';}$cadena.='></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="xajax_pagos(\''.$RResClientesA["Id"].'\')">'.$RResClientesA["Nombre"].'</a></td>
						<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResClientesA["Adeudo"],2).'</td>
					</tr>';
			$A++; $B++;
		}
		
		$cadena.='<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_juridico(\'\', \'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
					</tr></table></form></td><td valign="top">';
		
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function historico_cliente($cliente, $juridico='NO', $activar=NULL)
{
	include ("conexion.php");
	
	$ResCliente=mysql_fetch_array(mysql_query("SELECT Id, Nombre FROM clientes WHERE Id='".$cliente."' LIMIT 1"));
	
	if($activar==NULL) //mandar a historico
	{
	
	if($juridico=='NO')
	{
		$cadena='<p align="center" class="textomensaje">Esta seguro que desea enviar a historico al cliente: '.$ResCliente["Nombre"].'<br />
					<a href="#" onclick="xajax_historico_cliente(\''.$cliente.'\', \'SI\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_pagos(\''.$cliente.'\')">NO</a></p>';
	}
	elseif($juridico=='SI')
	{
		mysql_query("UPDATE clientes SET Juridico='2' WHERE Id='".$cliente."'");
		$cadena='<p align="center" class="textomensaje">Se movio el cliente a historico</p>';
	}
	}
	elseif($activar=='activar') //mandar a activo
	{
		if($juridico=='NO')
	{
		$cadena='<p align="center" class="textomensaje">Esta seguro que desea enviar a Activo al cliente: '.$ResCliente["Nombre"].'<br />
					<a href="#" onclick="xajax_historico_cliente(\''.$cliente.'\', \'SI\', \'activar\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="xajax_pagos(\''.$cliente.'\')">NO</a></p>';
	}
	elseif($juridico=='SI')
	{
		mysql_query("UPDATE clientes SET Juridico='0' WHERE Id='".$cliente."'");
		$cadena='<p align="center" class="textomensaje">Se movio el cliente a Activo</p>';
	}
	}
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function ver_historico($cliente=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena='<p align="center" class="texto">Cliente: <select name="cliente" id="cliente" onchange="xajax_pagos(this.value)"><option>SELECCIONE</option>';
	$ResCliente=mysql_query("SELECT * FROM clientes WHERE Juridico='2' ORDER BY Nombre ASC");
	while($RResCliente=mysql_fetch_array($ResCliente))
	{
		$cadena.='<option value="'.$RResCliente["Id"].'"';if($RResCliente["Id"]==$cliente){$cadena.=' selected';}$cadena.='>'.$RResCliente["Nombre"].'</option>';
	}
	$cadena.='</select> <a href="reportes/reportecliente.php?cliente='.$cliente.'" target="_blank"><img src="images/impresora.jpg" border="0"></a> Provedor: <select name="provedor" id="provedor" onchange="xajax_pagos_provedor(this.value)"><option>SELECCIONE</option>';
	$ResProvedor=mysql_query("SELECT Id, Nombre FROM provedores WHERE Status='2' ORDER BY Nombre ASC");
	while($RResProvedor=mysql_fetch_array($ResProvedor))
	{
		$cadena.='<option value="'.$RResProvedor["Id"].'">'.$RResProvedor["Nombre"].'</option>';
	}
	$cadena.='</select> <img src="images/impresora.jpg" border="0"> Tela: <select name="telas" id="telas" onchange="xajax_existencias(this.value)"><option>SELECCIONE</option>';
	$ResTelas=mysql_query("SELECT Id, Nombre FROM telas WHERE Status='2' ORDER BY Nombre ASC");
	while($RResTelas=mysql_fetch_array($ResTelas))
	{
		$cadena.='<option value="'.$RResTelas["Id"].'">'.$RResTelas["Nombre"].'</option>';
	}
	$cadena.='</select> </p>';
	
//////// PANTALLA HOME /////////
	
		$cadena.='<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
					<td valign="top">';
		$cadena.='<form name="fsumaaclientes" id="fsumaaclientes"><table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_historico(\'\', \'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO CLIENTES</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaclientes" id="allaclientes" value="1"';if($form["allaclientes"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaclientes()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
		$ResClientesA=mysql_query("SELECT Id, Nombre, Adeudo FROM clientes WHERE Juridico='2' ORDER BY Adeudo DESC");
		$A=1; $B=1;
		while($RResClientesA=mysql_fetch_array($ResClientesA))
		{
			if($B==31)
			{
				$cadena.='<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO CLIENTES</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
				$B=1;
			}
			$cadena.='<tr>
						<td bgcolor="#ba9464" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="acliente_'.$RResClientesA["Id"].'" id="acliente_'.$RResClientesA["Id"].'" value="1"'; if($form["acliente_".$RResClientesA["Id"]]==1){$cadena.=' checked';}elseif($form["allaclientes"]==0){$cadena.='';}$cadena.='></td>
						<td bgcolor="#ba9464" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#ba9464" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="xajax_pagos(\''.$RResClientesA["Id"].'\')">'.$RResClientesA["Nombre"].'</a></td>
						<td bgcolor="#ba9464" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResClientesA["Adeudo"],2).'</td>
					</tr>';
			$A++; $B++;
		}
		
		$cadena.='<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_historico(\'\', \'sumaaclientes\', xajax.getFormValues(\'fsumaaclientes\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaclientes>0){$cadena.='$ '.number_format($sumaaclientes, 2);}$cadena.='</td>
					</tr></table></form></td><td valign="top">';
		
		$cadena.='<form name="fsumaaprovedores" id="fsumaaprovedores">
				<table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_historico(\'\', \'sumaaprovedores\', xajax.getFormValues(\'fsumaaprovedores\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaprovedores>0){$cadena.='$ '.number_format($sumaaprovedores, 2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="4" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO PROVEEDORES</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allaprovedores" id="allaprovedores" value="1"';if($form["allaprovedores"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaaprovedores()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">NOMBRE</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">ADEUDO</td>
					</tr>';
		$ResProvedoresA=mysql_query("SELECT Id, Nombre, Adeudo, TipoCambio FROM provedores WHERE Status='2' ORDER BY Adeudo DESC");
		$A=1;
		while($RResProvedoresA=mysql_fetch_array($ResProvedoresA))
		{
			$cadena.='<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="aprovedor_'.$RResProvedoresA["Id"].'" id="aprovedor_'.$RResProvedoresA["Id"].'" value="1"'; if($form["aprovedor_".$RResProvedoresA["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" class="Ntooltip" onclick="xajax_pagos_provedor(\''.$RResProvedoresA["Id"].'\')">'.$RResProvedoresA["Nombre"].'</a></td>
						<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ ';if($RResProvedoresA["TipoCambio"]==0){$cadena.=number_format($RResProvedoresA["Adeudo"],2);}else{$cadena.=number_format(($RResProvedoresA["Adeudo"]*$RResProvedoresA["TipoCambio"]),2);}$cadena.='</td>
					</tr>';
			$A++;
		}
		$cadena.='<tr>
						<td colspan="3" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_historico(\'\', \'sumaaprovedores\', xajax.getFormValues(\'fsumaaprovedores\'))">Calcular:</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaaprovedores>0){$cadena.='$ '.number_format($sumaaprovedores, 2);}$cadena.='</td>
					</tr></table></form></td>
					<td valign="top">';
		//Existencia de telas
		$cadena.='<form name="fsumaatelas" id="fsumaatelas"><table border="0" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="5" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_historico(\'\', \'sumaatelas\', xajax.getFormValues(\'fsumaatelas\'))">Calcular :</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaatelas>0){$cadena.='$ '.number_format($sumaatelas,2);}$cadena.='</td>
					</tr>
					<tr>
						<td colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">HISTORICO TELAS</td>
					</tr>
					<tr>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"><input type="checkbox" name="allatelas" id="allatelas" value="1" ';if($form["allatelas"]==1){$cadena.=' checked';}$cadena.=' onchange="seleccionar_todo_sumaatelas()"></td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">#</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">TELA</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">COLOR</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">EXISTENCIA</td>
						<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">IMPORTE</td>
					</tr>';
		$A=1;
		$ResTelas=mysql_query("SELECT Id, Nombre, Color, Existencia, Importe FROM telas WHERE Status='2' ORDER BY Nombre ASC");
		while($RResTelas=mysql_fetch_array($ResTelas))
		{
			$cadena.='<tr>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><input type="checkbox" name="atela_'.$RResTelas["Id"].'" id="atela_'.$RResTelas["Id"].'" value="1" '; if($form["atela_".$RResTelas["Id"]]==1){$cadena.=' checked';}$cadena.='></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$A.'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF"><a href="#" onclick="xajax_existencias(\''.$RResTelas["Id"].'\')" class="Ntooltip">'.$RResTelas["Nombre"].'</a></td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResTelas["Color"].'</td>
						<td bgcolor="#CCCCCC" align="center" class="texto" style="border:1px solid #FFFFFF">'.$RResTelas["Existencia"].'</td>
						<td bgcolor="#CCCCCC" align="right" class="texto" style="border:1px solid #FFFFFF">$ '.number_format($RResTelas["Importe"], 2).'</td>
					</tr>';
					$A++;
		}
		$cadena.='	<tr>
						<td colspan="5" align="right" class="texto" style="border: 1px solid #FFFFFF"><a href="#" onclick="xajax_ver_historico(\'\', \'sumaatelas\', xajax.getFormValues(\'fsumaatelas\'))">Calcular :</a></td>
						<td align="right" class="texto" style="border: 1px solid #FFFFFF">';if($sumaatelas>0){$cadena.='$ '.number_format($sumaatelas,2);}$cadena.='</td>
					</tr>	
						</table></form>
					</td>
					</tr>
					
					</table>';
		
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
?>