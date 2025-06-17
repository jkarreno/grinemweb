<?php

function tipodecambio($tipo=NULL)
{
	include ("conexion.php");
	
	if($tipo["dolar"]!=NULL)
	{
		if(mysql_query("UPDATE parametros SET Descripcion='".$tipo["dolar"]."' WHERE Nombre='Dolar' AND PerteneceA='TipoC'", $conn))
		{
			$mensaje='<p class="textotitulo">Se ha actualizado el tipo de cambio del Dolar';
		}
	}
	
	$ResTipo=mysql_query("SELECT * FROM parametros WHERE Nombre='Dolar' AND PerteneceA='TipoC'", $conn);
	$RResTipo=mysql_fetch_array($ResTipo);
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<td align="center" class="textotitpanel" bgcolor="#0284c2">Tipo de Cambio</td>
						</tr>
						<tr bgcolor="#CCCCC">
							<td align="center">'.$mensaje.'
							<p class="texto">
							 <form name="tipocambio" id="tipocambio">
								&nbsp; Tipo de Cambio Dolar: <input type="text" name="dolar" value="'.$RResTipo["Descripcion"].'">&nbsp;
								<input type="button" name="bottipcam" value="Modificar>>" onclick="xajax_tipodecambio(xajax.getFormValues(\'tipocambio\'))">
								</form>
							</td>
						</tr>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}

?>