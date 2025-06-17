<?php
	include ("conexion.php");
	
	$ResDestacados=mysql_query("SELECT  * FROM productos WHERE Destacado='1' ORDER BY Consecutivo DESC LIMIT 2");
	
	echo '<div id="destacados" onmouseover="ocultar(\'menumarcas\')">
					<table width="100%" border="0">';
	$cuenta=1;
	while($RResDestacados=mysql_fetch_array($ResDestacados))
	{
		for($t=0; $t<=200; $t++)
		{
			$cadena.=$RResDestacados["Descripcion"][$t];
		}
		
		echo '<tr>
							<td>';
		if ($cuenta==1){ echo '<p>&nbsp;';}
		echo' 			<p class="textox"><a href="index2.php?contenido=detproducto&producto='.$RResDestacados["Consecutivo"].'&destacado=1" class="textox"><img src="Productos/images/'.$RResDestacados["Imagen"].'" width="100" height="100" style="float:left;" border="0">'.htmlentities($cadena).'...</a>
							</td>
						</tr>';
		if ($cuenta==1){ echo '
						<tr>
						<td>
						<hr style="border-style: dotted; color: blue;">
						</td>
						</tr>';}
		$cadena='';$cuenta++;
	}
						
	echo '</table>
				</div>
				<div id="novedades" onmouseover="ocultar(\'menumarcas\')">';
	$ResNovedades=mysql_query("SELECT * FROM productos ORDER BY Consecutivo DESC LIMIT 1");
	echo '	<table width="100%" border="0">';
	while($RResNovedades=mysql_fetch_array($ResNovedades))
	{
		for($t=0; $t<=200; $t++)
		{
			$cadena2.=$RResNovedades["Descripcion"][$t];
		}
		echo '<tr>
							<td>
							<p>&nbsp;
							<p class="textox" align="justify"><a href="index2.php?contenido=detproducto&producto='.$RResNovedades["Consecutivo"].'&novedad=1" class="textox"><img src="Productos/images/'.$RResNovedades["Imagen"].'" width="100" height="100" border="0" style="float:left;">'.$cadena2.'...</a>
							</td>
						</tr>';
	}
	echo '	</table>
				</div>
				<div id="eventos">';
	$ResEventos=mysql_query("SELECT * FROM eventos ORDER BY Consecutivo DESC LIMIT 1");
	echo '	<table width="100%" border="0">';
	while($RResEventos=mysql_fetch_array($ResEventos))
	{
		for($t=0; $t<=150; $t++)
		{
			$cadena3.=$RResEventos["Descripcion"][$t];
		}
		echo '<tr>
							<td>
							<p>&nbsp;
							<p class="textox"><a href="index2.php?contenido=eventos&evento='.$RResEventos["Consecutivo"].'&eventos=1" class="textox"><img src="images/eventos/'.$RResEventos["Imagen"].'" width="100" height="100" border="0" style="float:left;">'.$cadena3.'...</a>
							</td>
						</tr>';
	}
	echo '	</table>		
				
				</div>';
	
?>