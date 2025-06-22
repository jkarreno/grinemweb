<?php
function ventas($accion=NULL, $form=NULL, $anno)
{
	include ("conexion.php");

    switch ($accion)
    {
        case 'adventa':
            mysql_query("INSERT INTO ventas_pollos (Concepto, Fecha, Cantidad, Comentarios)
                                            VALUES ('".$form['concepto']."', '".$form['anno']."-".$form['mes']."-".$form['dia']."', '".$form['cantidad']."', '".$form['comentarios']."')");
        break;       
    }

	$cadena=$form['cantidad'].'<form name="fventas" id="fventas">
            <table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
				<tr>
					<td colspan="15" bgcolor="#ffffff" align="right" class="texto" style="border:1px solid #FFFFFF">| <a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_venta_2(\''.$anno.'\')">Agregar Venta</a> |</td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="15" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS<select name="anno" id="anno" onchange="xajax_ventas(\'\',\'\',this.value)">';
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
				</tr>';
    $ResVentas = mysql_query("SELECT * FROM ventas_pollos ORDER BY Id ASC");
    $i=1; $totalenero=0; $totalfebrero=0; $totalmarzo=0; $totalabril=0; $totalmayo=0; $totaljunio=0; $totaljulio=0; $totalagosto=0; $totalseptiembre=0; $totaloctubre=0; $totalnoviembre=0; $totaldiciembre=0;
    while($RResV=mysql_fetch_array($ResVentas))
    {
        $cadena.='<tr>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$i.'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV["Concepto"].'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '01' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '02' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '03' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '04' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '05' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '06' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '07' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '08' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '09' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '10' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '11' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.($RResV["Fecha"][5].$RResV["Fecha"][6] == '12' ? '$ '.number_format($RResV["Cantidad"], 2) : '' ).'</td>
                </tr>';

        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '01'){$totalenero += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '02'){$totalfebrero += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '03'){$totalmarzo += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '04'){$totalabril += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '05'){$totalmayo += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '06'){$totaljunio += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '07'){$totaljulio += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '08'){$totalagosto += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '09'){$totalseptiembre += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '10'){$totaloctubre += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '11'){$totalnoviembre += $RResV["Cantidad"];}
        if($RResV["Fecha"][5].$RResV["Fecha"][6] == '12'){$totaldiciembre += $RResV["Cantidad"];}

        $i++;
    }
    $cadena.='  <tr>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">&nbsp;</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">TOTAL</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalenero, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalfebrero, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalmarzo, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalabril, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalmayo, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaljunio, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaljulio, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalagosto, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalseptiembre, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaloctubre, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalnoviembre, 2).'</td>
                    <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaldiciembre, 2).'</td>
                </tr>
            </table>
        </form>';

    $respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_venta_2($anno)
{
    include ("conexion.php");

    $cadena='<form name="fadventa" id="fadventa">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agregar Venta</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Concepto: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
                        <select name="dia" id="dia"><option value="00">Día</option>';
    for($i=1; $i<=31; $i++)
    {
        if($i<=9){$i='0'.$i;}
        $cadena.='          <option value="'.$i.'"'.($i==date("d") ? ' selected' : '').'>'.$i.'</option>';
    }
    $cadena.='			</select> <select name="mes" id="mes
                        <select name="mes" id="mes">
							<option value="00">Mes</option>
							<option value="01"'.(date("m")=='01' ? ' selected' : '').'>Enero</option>
							<option value="02"'.(date("m")=='02' ? ' selected' : '').'>Febrero</option>
							<option value="03"'.(date("m")=='03' ? ' selected' : '').'>Marzo</option>
							<option value="04"'.(date("m")=='04' ? ' selected' : '').'>Abril</option>
							<option value="05"'.(date("m")=='05' ? ' selected' : '').'>Mayo</option>
							<option value="06"'.(date("m")=='06' ? ' selected' : '').'>Junio</option>
							<option value="07"'.(date("m")=='07' ? ' selected' : '').'>Julio</option>
							<option value="08"'.(date("m")=='08' ? ' selected' : '').'>Agosto</option>
							<option value="09"'.(date("m")=='09' ? ' selected' : '').'>Septiembre</option>
							<option value="10"'.(date("m")=='10' ? ' selected' : '').'>Octubre</option>
							<option value="11"'.(date("m")=='11' ? ' selected' : '').'>Noviembre</option>
							<option value="12"'.(date("m")=='12' ? ' selected' : '').'>Diciembre</option>
						</select> <select name="anno" id="anno"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="cantidad" id="cantidad" class="input" size="100"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" rows="3" cols="50"></textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="button" name="botadventa" id="botadventa" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_ventas(\'adventa\', xajax.getFormValues(\'fadventa\'), \''.$anno.'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

    $respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}