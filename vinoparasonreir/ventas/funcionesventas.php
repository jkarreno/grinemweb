<?php
function ventas($tipo=NULL, $accion=NULL, $form=NULL, $anno)
{
	include ("conexion.php");

    switch ($accion)
    {
        case 'adventa':
            mysql_query("INSERT INTO ventas_pollos (Tipo, Concepto, Fecha, Cantidad, Comentarios)
                                            VALUES ('".$tipo."', '".$form['concepto']."', '".$form['anno']."-".$form['mes']."-".$form['dia']."', '".$form['cantidad']."', '".$form['comentarios']."')");
			break;   
		case 'editventa':
			mysql_query("UPDATE ventas_pollos SET Concepto = '".$form["concepto"]."', 
													Fecha = '".$form["anno"]."-".$form["mes"]."-".$form["dia"]."', 
													Cantidad = '".$form["cantidad"]."', 
													Comentarios = '".$form["comentarios"]."' 
											WHERE Id = '".$form["idventa"]."'");
			break;

    }

	$totalenero=0; $totalfebrero=0; $totalmarzo=0; $totalabril=0; $totalmayo=0; $totaljunio=0; $totaljulio=0; $totalagosto=0; $totalseptiembre=0; $totaloctubre=0; $totalnoviembre=0; $totaldiciembre=0;

	$cadena='<form name="fventas" id="fventas">
            <table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
				<tr>
					<td colspan="15" bgcolor="#ffffff" align="right" class="texto" style="border:1px solid #FFFFFF">';if($tipo!=NULL){$cadena.='|<a href="#" onclick="lightbox.style.visibility=\'visible\'; xajax_agregar_venta_2(\''.$tipo.'\',\''.$anno.'\')">Agregar Venta</a>|';}$cadena.='</td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="15" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS '.$tipo.' '.'<select name="anno" id="anno" onchange="xajax_ventas(\''.$tipo.'\',\'\',\'\', this.value)">';
						for($i=2014; $i<=(date("Y")+2);$i++)
						{
							$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
						}
						$cadena.='</select></td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Enero</td>
							</tr>';
$sql01= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-01-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas01=mysql_query($sql01);
while($RResV01=mysql_fetch_array($ResVentas01))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV01["Fecha"][8].$RResV01["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV01["Id"].'\');">$ '.number_format($RResV01["Cantidad"], 2).'<span>'.$RResV01["Comentarios"].'</span></a></td>
							</tr>';
	$totalenero = $totalenero + $RResV01["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalenero, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Febrero</td>
							</tr>';
$sql02= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-02-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas02=mysql_query($sql02);
while($RResV02=mysql_fetch_array($ResVentas02))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV02["Fecha"][8].$RResV02["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV02["Id"].'\');">$ '.number_format($RResV02["Cantidad"], 2).'<span>'.$RResV02["Comentarios"].'</span></a></td>
							</tr>';
	$totalfebrero = $totalfebrero + $RResV02["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalfebrero, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Marzo</td>
							</tr>';
$sql03= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-03-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas03=mysql_query($sql03);
while($RResV03=mysql_fetch_array($ResVentas03))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV03["Fecha"][8].$RResV03["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV03["Id"].'\');">$ '.number_format($RResV03["Cantidad"], 2).'<span>'.$RResV03["Comentarios"].'</span></a></td>
							</tr>';
	$totalmarzo = $totalmarzo + $RResV03["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalmarzo, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Abril</td>
							</tr>';
$sql04= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-04-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas04=mysql_query($sql04);
while($RResV04=mysql_fetch_array($ResVentas04))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV04["Fecha"][8].$RResV04["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV04["Id"].'\');">$ '.number_format($RResV04["Cantidad"], 2).'<span>'.$RResV04["Comentarios"].'</span></a></td>
							</tr>';
	$totalabril = $totalabril + $RResV04["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalabril, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Mayo</td>
							</tr>';
$sql05= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-05-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas05=mysql_query($sql05);
while($RResV05=mysql_fetch_array($ResVentas05))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV05["Fecha"][8].$RResV05["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV05["Id"].'\');">$ '.number_format($RResV05["Cantidad"], 2).'<span>'.$RResV05["Comentarios"].'</span></a></td>
							</tr>';
	$totalmayo = $totalmayo + $RResV05["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalmayo, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Junio</td>
							</tr>';
$sql06= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-06-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas06=mysql_query($sql06);
while($RResV06=mysql_fetch_array($ResVentas06))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV06["Fecha"][8].$RResV06["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV06["Id"].'\');">$ '.number_format($RResV06["Cantidad"], 2).'<span>'.$RResV06["Comentarios"].'</span></a></td>
							</tr>';
	$totaljunio = $totaljunio + $RResV06["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaljunio, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Julio</td>
							</tr>';
$sql07= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-07-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas07=mysql_query($sql07);
while($RResV07=mysql_fetch_array($ResVentas07))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV07["Fecha"][8].$RResV07["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV07["Id"].'\');">$ '.number_format($RResV07["Cantidad"], 2).'<span>'.$RResV07["Comentarios"].'</span></a></td>
							</tr>';
	$totaljulio = $totaljulio + $RResV07["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaljulio, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Agosto</td>
							</tr>';
$sql08= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-08-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas08=mysql_query($sql08);
while($RResV08=mysql_fetch_array($ResVentas08))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV08["Fecha"][8].$RResV08["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV08["Id"].'\');">$ '.number_format($RResV08["Cantidad"], 2).'<span>'.$RResV08["Comentarios"].'</span></a></td>
							</tr>';
	$totalagosto = $totalagosto + $RResV08["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalagosto, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Septiembre</td>
							</tr>';
$sql09= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-09-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas09=mysql_query($sql09);
while($RResV09=mysql_fetch_array($ResVentas09))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV09["Fecha"][8].$RResV09["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV09["Id"].'\');">$ '.number_format($RResV09["Cantidad"], 2).'<span>'.$RResV09["Comentarios"].'</span></a></td>
							</tr>';
	$totalseptiembre = $totalseptiembre + $RResV09["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalseptiembre, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Octubre</td>
							</tr>';
$sql10= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-10-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas10=mysql_query($sql10);
while($RResV10=mysql_fetch_array($ResVentas10))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV10["Fecha"][8].$RResV10["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV10["Id"].'\');">$ '.number_format($RResV10["Cantidad"], 2).'<span>'.$RResV10["Comentarios"].'</span></a></td>
							</tr>';
	$totaloctubre = $totaloctubre + $RResV10["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaloctubre, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Noviembre</td>
							</tr>';
$sql11= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-11-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas11=mysql_query($sql11);
while($RResV11=mysql_fetch_array($ResVentas11))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV11["Fecha"][8].$RResV11["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV11["Id"].'\');">$ '.number_format($RResV11["Cantidad"], 2).'<span>'.$RResV11["Comentarios"].'</span></a></td>
							</tr>';
	$totalnoviembre = $totalnoviembre + $RResV11["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totalnoviembre, 2).'</td>
							</tr>
						</table>
					</td>
					<td style="border:1px solid #FFFFFF" valign="top">
						<table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
							<tr>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">D&iacute;a</td>
								<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Diciembre</td>
							</tr>';
$sql12= "SELECT * FROM ventas_pollos WHERE Fecha LIKE '".$anno."-12-%' ".($tipo!=NULL ? " AND Tipo = '".$tipo."'" : "")." ORDER BY Fecha ASC";
$ResVentas12=mysql_query($sql12);
while($RResV12=mysql_fetch_array($ResVentas12))
{
	$cadena.='				<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">'.$RResV12["Fecha"][8].$RResV12["Fecha"][9].'</td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"><a href="#" class="Ntooltip" onclick="lightbox.style.visibility=\'visible\'; xajax_editar_venta_pollos(\''.$RResV12["Id"].'\');">$ '.number_format($RResV12["Cantidad"], 2).'<span>'.$RResV12["Comentarios"].'</span></a></td>
							</tr>';
	$totaldiciembre = $totaldiciembre + $RResV12["Cantidad"];
}
$cadena.='					<tr>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;"></td>
								<td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($totaldiciembre, 2).'</td>
							</tr>
						</table>
					</td>
				</tr>
				
            </table>
        </form>';

    $respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function agregar_venta_2($tipo=NULL, $anno)
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
						<input type="button" name="botadventa" id="botadventa" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_ventas(\''.$tipo.'\', \'adventa\', xajax.getFormValues(\'fadventa\'), \''.$anno.'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

    $respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
function ventas_vs_gastos($tipo=NULL, $anno)
{
    include ("conexion.php");

    $cadena='<form name="fventas" id="fventas">
            <table style="border:1px solid #FFFFFF" cellpadding="1" cellspacing="0" align="center">
				<tr>
					<td colspan="15" bgcolor="#ffffff" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="15" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS vs GASTOS <select name="anno" id="anno" onchange="xajax_ventas_vs_gastos(this.value)">';
						for($i=2014; $i<=(date("Y")+2);$i++)
						{
							$cadena.='<option value="'.$i.'"';if($i==$anno){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
						}
						$cadena.='</select></td>
					<td bgcolor="#FFFFFF" align="right" class="texto" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF"></td>
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
				</tr>
                <tr>
                    <td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">VENTAS</td>';
    for($i=1; $i<=12; $i++)
    {
        if($i<=9){$i='0'.$i;}
        $ResVentas = mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Cantidad FROM ventas_pollos WHERE Fecha LIKE '".$anno."-".$i."-%' ".($tipo!=NULL ? " AND Tipo='".$tipo."'" : '')));
        $cadena.='  <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($ResVentas['Cantidad'], 2).'</td>';
		$ventas[$i] = $ResVentas['Cantidad'];
    }
    $cadena.='  </tr>
                <tr>
                    <td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">GASTOS</td>';
    for($i=1; $i<=12; $i++)
    {
        if($i<=9){$i='0'.$i;}
		if($tipo==NULL)
		{
			$ResGastos = mysql_fetch_array(mysql_query("SELECT SUM(Cantidad) AS Cantidad FROM gastos_montos WHERE Fecha LIKE '".$anno."-".$i."-%' AND Estado='PAGADO'"));
		}
		else{
			$ResGastos = mysql_fetch_array(mysql_query("SELECT SUM(gm.Cantidad) AS Cantidad FROM gastos_montos AS gm 
														INNER JOIN gastos AS g ON g.Id = gm.IdGasto
														WHERE gm.Fecha LIKE '".$anno."-".$i."-%' AND gm.Estado='PAGADO' AND g.Tipo = '".$tipo."'"));
		}
        
        $cadena.='  <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC;">$ '.number_format($ResGastos['Cantidad'], 2).'</td>';
		$gastos[$i] = $ResGastos['Cantidad'];
    }
    $cadena.='  </tr>
				<tr>
					<td bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">GANANCIA</td>';
	for($i=1; $i<=12; $i++)
	{
		if($i<=9){$i='0'.$i;}
		$ganancia = $ventas[$i] - $gastos[$i];
		$cadena.='  <td class="texto" align="center" style="border:1px solid #FFFFFF; background-color: #CCCCCC; color: '.($ganancia < 0 ? '#ff0000' : '#000000').'">$ '.number_format($ganancia, 2).'</td>';
	}
	$cadena.='  </tr>
            </table>
        </form>';
    
    $respuesta = new xajaxResponse(); 
    $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
    return $respuesta;
}
function editar_venta_pollos($idventa)
{
	include ("conexion.php");

	$ResV = mysql_fetch_array(mysql_query("SELECT * FROM ventas_pollos WHERE Id = '".$idventa."' LIMIT 1"));

    $cadena='<form name="feditventa" id="feditventa">
			<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td colspan="2" align="right" class="texto">[ <a href="#" onclick="lightbox.style.visibility=\'hidden\';">X</a> ]</td>
				</tr>
				<tr>
					<th colspan="2" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Editar Venta</th>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Concepto: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><input type="text" name="concepto" id="concepto" class="input" size="100" value="'.$ResV["Concepto"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Fecha: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
                        <select name="dia" id="dia"><option value="00">Día</option>';
    for($i=1; $i<=31; $i++)
    {
        if($i<=9){$i='0'.$i;}
        $cadena.='          <option value="'.$i.'"'.($i==$ResV["Fecha"][8].$ResV["Fecha"][9] ? ' selected' : '').'>'.$i.'</option>';
    }
    $cadena.='			</select> <select name="mes" id="mes
                        <select name="mes" id="mes">
							<option value="00">Mes</option>
							<option value="01"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='01' ? ' selected' : '').'>Enero</option>
							<option value="02"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='02' ? ' selected' : '').'>Febrero</option>
							<option value="03"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='03' ? ' selected' : '').'>Marzo</option>
							<option value="04"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='04' ? ' selected' : '').'>Abril</option>
							<option value="05"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='05' ? ' selected' : '').'>Mayo</option>
							<option value="06"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='06' ? ' selected' : '').'>Junio</option>
							<option value="07"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='07' ? ' selected' : '').'>Julio</option>
							<option value="08"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='08' ? ' selected' : '').'>Agosto</option>
							<option value="09"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='09' ? ' selected' : '').'>Septiembre</option>
							<option value="10"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='10' ? ' selected' : '').'>Octubre</option>
							<option value="11"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='11' ? ' selected' : '').'>Noviembre</option>
							<option value="12"'.($ResV["Fecha"][5].$ResV["Fecha"][6]=='12' ? ' selected' : '').'>Diciembre</option>
						</select> <select name="anno" id="anno"><option value="0000">Año</option>';
	for($i=2014; $i<=(date("Y")+2); $i++)
	{
		$cadena.='<option value="'.$i.'"';if($i==$ResV["Fecha"][0].$ResV["Fecha"][1].$ResV["Fecha"][2].$ResV["Fecha"][3]){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
	}
	$cadena.='			</select></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Cantidad: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">$ <input type="text" name="cantidad" id="cantidad" class="input" size="100" value="'.$ResV["Cantidad"].'"></td>
				</tr>
				<tr>
					<td class="texto" align="right" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">Comentarios: </td>
					<td class="texto" align="left" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF"><textarea name="comentarios" id="comentarios" rows="3" cols="50">'.$ResV["Comentarios"].'</textarea></td>
				</tr>
				<tr>
					<td class="texto" align="center" colspan="2" bgcolor="#CCCCCC" style="border:1px solid #FFFFFF">
						<input type="hidden" name="idventa" id="idventa" value="'.$ResV["Id"].'">
						<input type="button" name="botadventa" id="botadventa" value="Agregar>>" class="boton" onclick="lightbox.style.visibility=\'hidden\';  xajax_ventas(\''.$ResV["Tipo"].'\', \'editventa\', xajax.getFormValues(\'feditventa\'), \''.$ResV["Fecha"][0].$ResV["Fecha"][1].$ResV["Fecha"][2].$ResV["Fecha"][3].'\'); document.getElementById(\'lightbox\').innerHTML = \'\'">
					</td>
				</tr>
			</table>
			</form>';

    $respuesta = new xajaxResponse(); 
	$respuesta->addAssign("lightbox","innerHTML",utf8_encode($cadena));
	return $respuesta;
}