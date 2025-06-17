<?php
function menu_usuarios()
{
	$cadena='<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<th colspan="4" align="center" class="textotitpanel" bgcolor="#0284c2">Usuarios</th>
	</tr>
<tr>
	<td align="center"><a href="#" onclick="xajax_lista_usuarios()"><span class="texto">Lista de Usuarios</span></a></td>
	<td align="center">&nbsp;</td>
	<td align="center">&nbsp;</td>
	<td align="center">&nbsp;</td>
</tr>
<tr>
	<th colspan="4"><div id="conteni2"></div></th>
</tr>
</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
function lista_usuarios()
{
	include ("conexion.php");
	
	$ResUsuarios=mysql_query("SELECT Nombre, Email FROM usuarios ORDER BY Consecutivo DESC");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<th colspan="3" align="center" class="textotitpanel" bgcolor="#0284c2">Lista de Usuarios</td>
						</tr>
						<tr bgcolor="#CCCCCC">
							<td align="center" class="texto2">No.</td>
							<td align="center" class="texto2">Nombre</td>
							<td align="center" class="texto2">Correo Electronico</td>
						</tr>';
	$bgcolor="#FFFFFF";
	$contador=1;
	while ($RResUsuarios=mysql_fetch_array($ResUsuarios))
	{
		$cadena.='<tr bgcolor="'.$bgcolor.'">
								<td align="left" class="textox">&nbsp;'.$contador.'</td>
								<td align="left" class="textox">&nbsp;'.htmlentities($RResUsuarios["Nombre"]).'</td>
								<td align="left" class="textox">&nbsp;'.$RResUsuarios["Email"].'</td>
							</tr>';
		$contador++;
		
		if ($bgcolor="#FFFFFF"){$bgcolor="#CCCCCC";}
		else if($bgcolor="#CCCCCC"){$bgcolor="#FFFFF";}
	}
	
	$cadena.='</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;

}
?>