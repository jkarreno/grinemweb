<?php
function menu_documentos()
{
		$cadena='<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<th colspan="4" align="center" class="textotitpanel" bgcolor="#0284c2">Documentos</th>
	</tr>
<tr>
	<td align="center"><a href="#" onclick="xajax_addocumentos()"><span class="texto">Agregar Documentos</span></a></td>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
</tr>
<tr>
	<td colspan="4"><hr border="4" color="#0284c2"></td>
</tr>
<tr>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
	<td align="center"><a href="#"><span class="texto">&nbsp;</span></a></td>
</tr>
<tr>
	<th colspan="4"><div id="conteni2"></div></th>
</tr>
</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
function addocumentos()
{
		$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<td align="center" class="textotitpanel" bgcolor="#0284c2">Agregar Documento</td>
						</tr>
						<tr bgcolor="#CCCCCC">
						<td>
							<iframe name="documentos" frameborder="0" scrolling="no" width="100%" height="600" src="Documentos/agregardocumento.php"></iframe>
						</td>
						</tr>
						</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
?>