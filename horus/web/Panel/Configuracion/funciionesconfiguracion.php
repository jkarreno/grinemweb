<?php
function menuconfiguracion()
{
	$cadena='<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
	<tr>
		<th colspan="4" align="center" class="textotitpanel" bgcolor="#0284c2">Configuracion</th>
	</tr>
<tr>
	<td align="center"><a href="#" onclick="xajax_marcas()"><span class="texto">Modificar Marcas</span></a></td>
	<td align="center"><a href="#" onclick="xajax_menuizq()"><span class="texto">Menu Izquierdo</span></a></td>
	<td align="center"><a href="#" onclick="xajax_cuestionarios()"><span class="texto">Cuestionarios</span></a></td>
	<td align="center"><a href="#" onclick="xajax_eventos()"><span class="texto">Eventos</span></a></td>
</tr>
<tr>
	<td colspan="4"><hr border="4" color="#0284c2"></td>
</tr>
<tr>
	<td align="center"><a href="#" onclick="xajax_generapagina()"><span class="texto">Generar Pagina</span></a></td>
	<td align="center"><a href="#" onclick="xajax_modificapagina()"><span class="texto">Modificar Pagina</span></a></td>
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
function marcas()
{
	include ("conexion.php");
	
	$ResMarca=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='Marcas'");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<td align="center" class="textotitpanel" bgcolor="#0284c2">Modificar Marcas</td>
						</tr>
						<tr bgcolor="#CCCCCC">
							<td class="texto2">
							<form name="fmarcas" id="fmarcas">
							 &nbsp;Seleccione Marca:<select name="marca">';
	while($RResMarca=mysql_fetch_array($ResMarca))
	{
		$cadena.='		<option value="'.$RResMarca["Nombre"].'">'.htmlentities($RResMarca["Nombre"]).'</option>';
	}
		$cadena.=' </select>&nbsp;<input type="button" name="butmodmarca" value="Seleccionar>>" onclick="xajax_modificamarca(xajax.getFormValues(\'fmarcas\'))">
							</form>
							<div id="detallesmarca"></div>
						</tr>
						</table>';
		
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function modificamarca($marca)
{
	$cadena='<iframe name="marcas" frameborder="0" scrolling="no" width="100%" height="1000" src="Configuracion/modificarmarcas.php?marca='.$marca["marca"].'"></iframe>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("detallesmarca","innerHTML",$cadena);
   return $respuesta;
}
function modificamarca_2($marca)
{
	include ("conexion.php");
	
	if (mysql_query("UPDATE marcas SET Nombre='".$marca["nombre"]."', 				
																		 Desc_corta='".$marca["desc_corta"]."', 
																		 Desc_larga='".$marca["desc_larga"]."', 
																		 Productos='".$marca["productos"]."',
																		 Logo='".$marca["logotipo"]."' 
															 WHERE Consecutivo='".$marca["consecutivo"]."'"))
	{
		$cadena='<p class="textomensaje">Se modifico la marca '.$marca["nombre"].' correctamente</p>';
	}
	else 
	{
		$cadena='<p class="textomensaje">Ocurrio un error, no se pudo modificar la marca '.$marca["nombre"].' consulte a Frank Sinatra';
	}
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("detallesmarca","innerHTML",$cadena);
   return $respuesta;
}
function menuizq()
{
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<th colspan="2" align="center" class="textotitpanel" bgcolor="#0284c2">Menu Izquierdo</td>
						</tr>
						<tr bgcolor="#CCCCCC">
							<td>
								<ul>
									<li>Categorias
										<ul>
											<li><a href="#" onClick="xajax_menuizq_adcat()">Agregar</a></li>
											<li>Modificar</li>
											<li>Eliminar</li>
										</ul>
									</li>
									<li>Subcategorias
										<ul>
											<li><a href="#" onClick="xajax_menuizq_adsubcat()">Agregar</a></li>
											<li>Modificar</li>
											<li>Eliminar</li>
										</ul>
									</li>
								</ul>
							</td>
							<td>
								<div id="modmenuizq"></div>
							</td>
						</tr>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function menuizq_adcat()
{
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<th colspan="2" align="center" class="textotitpanel" bgcolor="#0284c2">Agregar Categoria</td>
						</tr>
						<tr bgcolor="#CCCCCB">
							<td>
								<form id="fadcateizq">
									&nbsp;Categoria: <input type="text" name="categoria">&nbsp;
									<input type="button" name="botadcatizq" value="Agregar>>" onclick="xajax_menuizq_adcat_2(xajax.getFormValues(\'fadcateizq\'))">
								</form>
							</td>
						</tr>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("modmenuizq","innerHTML",$cadena);
   return $respuesta;
}
function menuizq_adcat_2($catego)
{
	include ("conexion.php");
	
	if(mysql_query("INSERT INTO parametros (Nombre, PerteneceA, Descripcion) VALUES ('Categoria', 'MenuIzq', '".$catego["categoria"]."')"))
	{
		$cadena='<p class="textomensaje">&nbsp;Se ha agregado la categoria '.$catego["categoria"].' satisfactoriamente</p>';
	}
	else 
	{
		$cadena='<p class="textomensaje">&nbsp;Ocurrio un error, consulte a Elvis </p>';
	}
	
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("modmenuizq","innerHTML",$cadena);
   return $respuesta;
}
function menuizq_adsubcat()
{
	include ("conexion.php");
	
	$ResCat=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE Nombre='Categoria' AND PerteneceA='MenuIzq'", $conn);
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<th colspan="2" align="center" class="textotitpanel" bgcolor="#0284c2">Agregar subcategoria</td>
						</tr>
						<tr bgcolor="#CCCCCB">
							<td>
								<form id="fadsubcateizq">
									&nbsp;Categoria: <select name="categoria">
										<option>Selecciona</option>';
	while($RResCat=mysql_fetch_array($ResCat))
	{
		$cadena.='			<option value="'.$RResCat["Consecutivo"].'">'.$RResCat["Descripcion"].'</option>';
	}
	$cadena.='			</select>	
									&nbsp;Subcategoria: <input type="text" name="subcategoria">&nbsp;
									<input type="button" name="botadcatizq" value="Agregar>>" onclick="xajax_menuizq_adsubcat_2(xajax.getFormValues(\'fadsubcateizq\'))">
								</form>
							</td>
						</tr>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("modmenuizq","innerHTML",$cadena);
   return $respuesta;
}
function menuizq_adsubcat_2($subcatego)
{
	include ("conexion.php");
	
	$ResCatt=mysql_query("SELECT Descripcion FROM parametros WHERE Consecutivo='".$subcatego["categoria"]."'", $conn);
	$RResCatt=mysql_fetch_array($ResCatt);
	
	if(mysql_query("INSERT INTO parametros (Nombre, PerteneceA, Descripcion) VALUES ('".$RResCatt["Descripcion"]."', 'MenuIzq', '".$subcatego["subcategoria"]."')"))//Nombre-categoria, PerteneceA-MenuIzq, Descripcion-subcategoria
	{
		$cadena='<p class="textomensaje">&nbsp;Se ha agregado la subcategoria '.$subcatego["subcategoria"].' en la categoria '.$RResCatt["Descripcion"].' satisfactoriamente</p>';
	}
	else 
	{
		$cadena='<p class="textomensaje">&nbsp;Ocurrio un error, consulte a Madonna </p>';
	}
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("modmenuizq","innerHTML",$cadena);
   return $respuesta;
}
function generapagina()
{
	include ("conexion.php");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<td align="center" class="textotitpanel" bgcolor="#0284c2">Genera Pagina</td>
						</tr>
						<tr bgcolor="#CCCCCC">
							<td class="texto2">
								<form name="pagagen">
									&nbsp;Seleccione opcion: <select name="nombrepag">
									<option>-----Menu Izquierdo-----</option>';
	$ResMenuIzquierdo=mysql_query("SELECT Descripcion FROM parametros WHERE PerteneceA='MenuIzq' AND Nombre='Categoria'");
	while($RResMenuIzquierdo=mysql_fetch_array($ResMenuIzquierdo))
	{
		$cadena.='		<option value="'.$RResMenuIzquierdo["Descripcion"].'">'.$RResMenuIzquierdo["Descripcion"].'</option>';
		$ResSubcate=mysql_query("SELECT Consecutivo, Descripcion FROM parametros WHERE PerteneceA='MenuIzq' AND Nombre='".$RResMenuIzquierdo["Descripcion"]."'");
		while($RResSubcate=mysql_fetch_array($ResSubcate))
		{
			$cadena.=' <option value="'.$RResSubcate["Consecutivo"].'">--'.$RResSubcate["Descripcion"].'</option>';
		}
	}
	$cadena.='			</select>&nbsp;<input type="button" name="butgenerapag" value="Generar>>" onclick="xajax_generapagina_2(xajax.getFormValues(\'pagagen\'))">
								</form>
								<div id="detallepagina"></div>
							</td>
						</tr>
						</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function generapagina_2($pagina)
{
	 $cadena='<iframe name="pagina" frameborder="0" scrolling="no" width="100%" height="600" src="Configuracion/agregarpagina.php?pagina='.$pagina["nombrepag"].'"></iframe>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("detallepagina","innerHTML",$cadena);
   return $respuesta;
}
function modificapagina()
{
	include ("conexion.php");
	
	$ResPagina=mysql_query("SELECT Consecutivo, Pagina FROM paginas ORDER BY Pagina ASC");
	
	$cadena='<table align="center" border="1" bordercolor="#00548E" cellpadding="0" cellspacing="0" width="90%">
						<tr>
							<td align="center" class="textotitpanel" bgcolor="#0284c2">Modificar Pagina</td>
						</tr>
						<tr bgcolor="#CCCCCC">
							<td class="texto2">
	<form name="pagamod">
		<p class="texto2">&nbsp;Pagina: <select name="pagina">';
	while($RResPagina=mysql_fetch_array($ResPagina))
	{
		$cadena.='<option value="'.$RResPagina["Consecutivo"].'">'.$RResPagina["Pagina"].'</option>';
	}
	$cadena.='</selec>&nbsp;<input type="button" name="botmodpag" value="Seleccionar>>" onclick="xajax_modificapagina_2(xajax.getFormValues(\'pagamod\'))">
	</form>
	</td>
	</tr>
	<tr bgcolor="#CCCCCC"><td>
	<div id="modpagina"></div>
	</td></tr></table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("conteni2","innerHTML",$cadena);
   return $respuesta;
}
function modificapagina_2($pagina)
{
	$cadena='<iframe name="pagina" frameborder="0" scrolling="no" width="100%" height="600" src="Configuracion/modificarpagina.php?pagina='.$pagina["pagina"].'"></iframe>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("modpagina","innerHTML",$cadena);
   return $respuesta;
}
function agregarevento()
{
	
}
?>