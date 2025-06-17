<?php
function factura_clientes($rfc=NULL)
{
	include ("conexion.php");
	
	$cadena='<img src="images/cfacturae.jpg" border="0">';
	if($rfc==NULL)
	{
	$cadena.='<p>&nbsp;</p>
			  <form name="frfc" id="frfc"><table border="0" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td align="center" class="textox"><center>Ingrese su RFC</center></td>
				</tr>
				<tr>
					<td align="center" class="textox"><center><input type="text" name="rfc" id="rfc" size="15" class="input"></center></</td>
				</tr>
				<tr>
					<td align="center" class="textox"><center>
						<select name="emisor" id="emisor" class="input">';
	$ResEmisor=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");
	while($RResEmisor=mysql_fetch_array($ResEmisor))
	{
		$cadena.='			<option value="'.$RResEmisor["Id"].'">'.$RResEmisor["Nombre"].'</option>';
	}
	$cadena.='			</select></center></td>
				</tr>
				<tr>
					<td align="center" class="textox"><center><input type="button" name="botconsulfac" id="botconsulfac" value="Consultar>>" class="botbusca" onclick="xajax_factura_clientes(xajax.getFormValues(\'frfc\'))"></center></td>
				</tr>
			</table></form>';
	}
	else
	{
		$r=$rfc["rfc"];
		
		$cliente=mysql_fetch_array(mysql_query("SELECT Id FROM clientes WHERE RFC='".$r."' AND Empresa='".$rfc["emisor"]."' LIMIT 1"));
		
		$cadena.='<table border="0" cellpadding="3" cellspacing="0" align="center">
					<tr>
						<td colspan="5" align="center" class="textomenu" bgcolor="#005490">Listado de Facturas para el rfc '.$r.'</td>
					</tr>
					<tr>
						<td align="center" class="textotit" bgcolor="#0284c0"><center>Fecha</center></td>
						<td align="center" class="textotit" bgcolor="#0284c0"><center>Serie - Num. Factura</center></td>
						<td align="center" class="textotit" bgcolor="#0284c0">&nbsp;</td>
						<td align="center" class="textotit" bgcolor="#0284c0">&nbsp;</td>
					</tr>';
		$ResFacturas=mysql_query("SELECT Id, Empresa, Sucursal, Serie, NumFactura, Fecha, Version FROM facturas WHERE Cliente='".$cliente["Id"]."' AND Status!='Cancelada' ORDER BY Fecha DESC");
		$bgcolor="#FFFFFF";
		while($RResFacturas=mysql_fetch_array($ResFacturas))
		{
			$cadena.='<tr>
						<td align="center" bgcolor="'.$bgcolor.'" class="textox">'.$RResFacturas["Fecha"].'</td>
						<td align="center" bgcolor="'.$bgcolor.'" class="textox">'.$RResFacturas["Serie"].$RResFacturas["NumFactura"].'</td>
						<td align="center" bgcolor="'.$bgcolor.'" class="textox"><a href="';if($RResFacturas["Version"]=='2.0'){$cadena.='../clientes/factura.php?idfactura='.$RResFacturas["Id"];}elseif($RResFacturas["Version"]=='2.2'){$cadena.='../clientes/factura2_2.php?idfactura='.$RResFacturas["Id"].'&empresa='.$RResFacturas["Empresa"].'&sucursal='.$RResFacturas["Sucursal"];}$cadena.='" target="_blank"><img src="images/file__pdf.png" border="0"></a></td>
						<td align="center" bgcolor="'.$bgcolor.'" class="textox"><a href="';if($RResFacturas["Version"]=='2.0'){$cadena.='../clientes/xml.php?idfactura='.$RResFacturas["Id"];}elseif($RResFacturas["Version"]=='2.2'){$cadena.='../clientes/xml2_2.php?idfactura='.$RResFacturas["Id"];}$cadena.='" target="_blank"><img src="images/file_xml.png" border="0"></a></td>
					</tr>';
			if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
			elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
		}
		$cadena.='</table>';
	}
	
	
	$respuesta = new xajaxResponse(); 
	$respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
	return $respuesta;
}
?>