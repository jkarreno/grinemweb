<?php
function productos($limite=0, $modo=NULL, $accion=NULL, $form=NULL, $PP=NULL)
{
	include ("conexion.php");
	
	$ResEmpresa=mysql_query("SELECT Nombre FROM empresas WHERE Id='".$_SESSION["empresa"]."' LIMIT 1");
	$RResEmpresa=mysql_fetch_array($ResEmpresa);
	
	if($modo=='agregar' AND $accion=='2')
	{
		$ResClave=mysql_query("SELECT Clave FROM productos WHERE Clave='".$form["clave"]."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'");
		if(mysql_num_rows($ResClave)!=0)
		{
			$mensaje='<p class="textomensaje" align="center">La Clave '.$form["clave"].', ya esta siendo utilizada, por favor seleccione otra clave</p>';
			
			$accion=1;
		}
	}
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="3" bgcolor="#FFFFFF" class="texto" align="left">
								<form name="fbuscar" id="fbuscar">
								Buscar por: <select name="provedor" id="provedor" class="input"><option value="%">Provedores</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'">'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select> <select name="grupo" id="grupo" class="input"><option value="%">Grupos</option>';
	$ResGrupos=mysql_query("SELECT Id, Nombre FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='grupos' ORDER BY Nombre ASC");
	while($RResGrupos=mysql_fetch_array($ResGrupos))
	{
		$cadena.='<option value="'.$RResGrupos["Id"].'">'.$RResGrupos["Nombre"].'</option>';
	}
	$cadena.='		</select><br /><select name="campo" id="campo" class="input">
								<option value="Clave">Clave</option>
								<option value="Nombre">Nombre</option>
								</select> <input type="text" name="buscar" id="buscar" class="input" size="25"> 
								<input type="button" name="botbuscar" id="botbuscar" value="Buscar>>" class="boton" onclick="xajax_buscar_producto(\'0\', xajax.getFormValues(\'fbuscar\'))">
								</form>
							<th colspan="4" bgcolor="#FFFFFF" class="texto" align="right">| <a href="#" onclick="xajax_productos(\''.$limite.'\', \'agregar\', \'1\')">Agregar Producto</a> | <a href="#" onclick="xajax_unidades()">Unidades</a> | <a href="#" onclick="xajax_grupos()">Grupos</a> | <a href="#" onclick="xajax_tipo_producto()">Tipos</a> |</th>
						</tr>
					 	<tr>
							<th colspan="7" bgcolor="#4db6fc" class="texto3" align="center">Productos '.$RResEmpresa["Nombre"].'</th>
						</tr>';
	//area de trabajo
	switch($modo)
	{
		case 'agregar': //AGREGAR PRODUCTO
			$cadena.='<tr>
									<th colspan="10" bgcolor="#cceaff" class="texto" align="center">'.$mensaje;
			if($accion==1)//formulario para agregar producto
  		{
  			$cadena.='<form name="fadproducto" id="fadproducto">
									<table border="0" cellpadding="5" cellspacing="0" align="center">
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor" id="provedor" class="input">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$form["provedor"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor2" id="provedor2" class="input">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$form["provedor2"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor3" id="provedor3" class="input">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$form["provedor3"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor4" id="provedor4" class="input">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$form["provedor4"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor5" id="provedor5" class="input"	>
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$form["provedor5"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Clave: </th>
											<th colspan="3" class="texto" align="left"><input type="text" name="clave" id="clave" class="input" value="'.$form["clave"].'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Nombre: </th>
											<th colspan="3" align="left" class="texto"><input type="text" name="nombre" id="nombre" size="50" class="input" value="'.utf8_decode($form["nombre"]).'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Marca: </th>
											<th class="texto" align="left"><input type="text" name="atributo" id="atributo" class="input" value="'.$form["atributo"].'"></th>
											<th class="texto" align="left">Unidad: </th>
											<th class="texto" align="left"><select name="unidad" id="unidad" class="input">
												<option>Seleccione</option>';
				$ResUnidades=mysql_query("SELECT Id, Nombre FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='unidades' ORDER BY Nombre ASC");
				while($RResUnidades=mysql_fetch_array($ResUnidades))
				{
					$cadena.='		<option value="'.$RResUnidades["Id"].'"'; if($RResUnidades["Id"]==$form["unidad"]){$cadena.=' selected';}$cadena.='>'.$RResUnidades["Nombre"].'</option>';
				}
				$cadena.='			</select>
											</th>
										</tr>
										<tr>
											<th class="texto" align="left">Grupo: </th>
											<th class="texto" align="left" colspan="3"><select name="grupo" id="grupo" class="input" onchange="xajax_productos(\''.$limite.'\', \'agregar\', \'1\', xajax.getFormValues(\'fadproducto\'))"><option value="">Seleccione</option>';
				$ResGrupos=mysql_query("SELECT * FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='grupos' ORDER BY Nombre ASC");
				while($RResGrupos=mysql_fetch_array($ResGrupos))
				{
					$cadena.='		<option value="'.$RResGrupos["Id"].'"';if($RResGrupos["Id"]==$form["grupo"]){$cadena.=' selected';}$cadena.='>'.$RResGrupos["Nombre"].'</option>';
				}
				$cadena.='		</select></td>
										</tr>
										<tr>
											<th class="texto" align="left">Tipo de Producto: </th>
											<th colspan="3" align="left" class="texto"><select name="tipoprod" id="tipoprod" class="input"><option value="">Selecione</option>';
				$ResTipProd=mysql_query("SELECT * FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='tproducto' ORDER BY Id ASC");
				while($RResTipProd=mysql_fetch_array($ResTipProd))
				{
					$cadena.='<option value="'.$RResTipProd["Id"].'"';if($RResTipProd["Id"]==$form["tipoprod"]){$cadena.=' selected';}$cadena.='>'.$RResTipProd["Nombre"].'</option>';
				}
				$cadena.='		</select></th>
										</tr>
										<tr>
											<th class="texto" align="left">Costo: </th>
											<th class="texto" align="left">$ <input type="text" name="costo" id="costo" class="input" value="'.$form["costo"].'" onKeyUp="calculo(this.value,\'1.10\',preciopublico);calculo(this.value,\'1.15\',preciopublico2);calculo(this.value,\'1.20\',preciopublico3);calculo(this.value,\'0\',costodolar);"></th>
											<th class="texto" align="left">Costo Dolares: </th>
											<th class="texto" align="left">$ <input type="text" name="costodolar" id="costodolar" class="input" value="'.$form["costodolar"].'" onKeyUp="calculo(this.value,\'1.10\',preciopublico);calculo(this.value,\'1.15\',preciopublico2);calculo(this.value,\'1.20\',preciopublico3);calculo(this.value,\'0\',costo);"></th>
											</tr>
										<tr>
											<th class="texto" align="left">Precio Público: </th>
											<th class="texto" align="left">$ <input type="text" name="preciopublico" id="preciopublico" class="input" value="'.$form["preciopublico"].'"></th>
											<th class="texto" align="left">Precio Público 2: </th>
											<th class="texto" align="left">$ <input type="text" name="preciopublico2" id="preciopublico2" class="input" value="'.$form["preciopublico2"].'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Precio Público 3: </th>
											<th class="texto" align="left">$ <input type="text" name="preciopublico3" id="preciopublico3" class="input" value="'.$form["preciopublico3"].'"></th>
											<th class="texto" align="left">Anaquel: </th>
											<th class="texto" align="left"><input type="text" name="anaquel" id="anaquel" class="input" value="'.$form["anaquel"].'"></th>
										</tr>
										<tr>';
			$cadena.='	<tr>
											<th colspan="4" align="center"><input type="button" name="botadprod" id="botadprod" value="Agregar Producto>>" class="boton" onclick="xajax_productos(\''.$limite.'\', \'agregar\', \'2\', xajax.getFormValues(\'fadproducto\'))"></th>
										</tr>
										<tr>
										</tr>
									</table>
									</form>';
  		}
  		elseif($accion==2)
  		{
  			if($form["costo"]){$moneda='MN';}
  			if($form["costodolar"]){$moneda='USD';}
  			if(mysql_query("INSERT INTO productos (Empresa, Sucursal, Provedor, Provedor2, Provedor3, Provedor4, Provedor5, Clase, Clave, Nombre, Atributo, Unidad, Grupo, SubGrupo, TipoProducto, Anaquel, Costo, CostoDolar, PrecioPublico, PrecioPublico2, PrecioPublico3, Moneda)
  																		 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$form["provedor"]."', '".$form["provedor2"]."', '".$form["provedor3"]."', '".$form["provedor4"]."', '".$form["provedor5"]."', '".$form["clase"]."', '".utf8_decode($form["clave"])."',
  																		  			 '".utf8_decode($form["nombre"])."', '".utf8_decode($form["atributo"])."', '".$form["unidad"]."', '".utf8_decode($form["grupo"])."',
  																		  			 '".utf8_decode($form["subgrupo"])."', '".utf8_decode($form["tipoprod"])."', '".$form["anaquel"]."', '".$form["costo"]."', '".$form["costodolar"]."', '".$form["preciopublico"]."', '".$form["preciopublico2"]."', '".$form["preciopublico3"]."', '".$moneda."')"))
  			{
  				$ResProducto=mysql_fetch_array(mysql_query("SELECT Id FROM productos WHERE Clave='".$form["clave"]."' ORDER BY Id DESC LIMIT 1"));
  				
  				for($i=1; $i<=$form["clientespactados"]; $i++)
  				{
  					if($form["clave_".$i]!='' AND $form["cliente_".$i]!='' AND $form["costo_".$i]!='' )
  					{
  						mysql_query("INSERT INTO prodpactados (Empresa, Sucursal, Producto, ClaveP, Cliente, PrecioPactado)
  																					 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$ResProducto["Id"]."', '".utf8_decode($form["clave_".$i])."',
  																					 				 '".$form["cliente_".$i]."', '".$form["costo_".$i]."')");
  					}
  				}
  				//ingresa inventaro inicial
  				/*$ResAlmacenes=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id ASC");
  				$comas=mysql_num_rows($ResAlmacenes); $i=1;
  				$sql.="INSERT INTO inventario (IdProducto, ";
  				while($RResAlmacenes=mysql_fetch_array($ResAlmacenes))
  				{
  					$sql.=$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_".$RResAlmacenes["Nombre"];
  					if($i<$comas){$sql.=", ";} $i++;
  				}
  				$sql.=") VALUES ('".$ResProducto["Id"]."', "; $i=1;
  				$ResAlmacenes2=mysql_query("SELECT Nombre FROM almacenes WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id ASC");
  				$comas=mysql_num_rows($ResAlmacenes2); $i=1;
  				while($RResAlmacenes2=mysql_fetch_array($ResAlmacenes2))
  				{
  					$sql.="'".$form[$RResAlmacenes2["Nombre"]]."'";
  					if($i<$comas){$sql.=", ";} $i++;
  				}
  				$sql.=")";
  				mysql_query($sql);*/
  				mysql_query("INSERT INTO inventario (IdProducto) VALUES ('".$ResProducto["Id"]."')");
  				
  				$cadena.='<p class="textomensaje" align="center">Se agrego el Producto satisfactoriamente<br /></p>';
  			}
  			else 
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, Intente nuevamente<br />'.mysql_error().'</p>';	
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'editar': //EDITAR PRODUCTO
		$cadena.='<tr>
									<th colspan="10" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para editar producto
  		{
  			if(is_array($form))
  			{
  				$ResProducto=mysql_query("SELECT * FROM productos WHERE Id='".$form["idproducto"]."' LIMIT 1");
  				$RResProducto=mysql_fetch_array($ResProducto);
  			}
  			else 
  			{
  				$ResProducto=mysql_query("SELECT * FROM productos WHERE Id='".$form."' LIMIT 1");
  				$RResProducto=mysql_fetch_array($ResProducto);
  			}
  			
  			$cadena.='<form name="feditproducto" id="feditproducto">
									<table border="0" cellpadding="5" cellspacing="0" align="center">
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor" id="provedor">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$provedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResProducto["Provedor"]."' LIMIT 1"));
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$RResProducto["Provedor"] OR $RResProvedores["Nombre"]==$provedor["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor2" id="provedor2">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$provedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResProducto["Provedor2"]."' LIMIT 1"));
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$RResProducto["Provedor2"] OR $RResProvedores["Nombre"]==$provedor["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor3" id="provedor3">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$provedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResProducto["Provedor3"]."' LIMIT 1"));
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$RResProducto["Provedor3"] OR $RResProvedores["Nombre"]==$provedor["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor4" id="provedor4">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$provedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResProducto["Provedor4"]."' LIMIT 1"));
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$RResProducto["Provedor4"] OR $RResProvedores["Nombre"]==$provedor["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Provedor: </th>
											<th colspan="3" align="left" class="texto"><select name="provedor5" id="provedor5">
												<option value="0">Seleccione</option>';
  			$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
  			while($RResProvedores=mysql_fetch_array($ResProvedores))
  			{
  				$provedor=mysql_fetch_array(mysql_query("SELECT Nombre FROM provedores WHERE Id='".$RResProducto["Provedor5"]."' LIMIT 1"));
  				$cadena.='		<option value="'.$RResProvedores["Id"].'"'; if($RResProvedores["Id"]==$RResProducto["Provedor5"] OR $RResProvedores["Nombre"]==$provedor["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
  			}
  			$cadena.='			</select>
  										</th>
										</tr>
										<tr>
											<th class="texto" align="left">Clave: </th>
											<th colspan="3" class="texto" align="left"><input type="text" name="clave" id="clave" class="input" value="'.$RResProducto["Clave"].'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Nombre: </th>
											<th colspan="3" align="left" class="texto"><input type="text" name="nombre" id="nombre" size="50" class="input" value="'.$RResProducto["Nombre"].'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Marca: </th>
											<th class="texto" align="left"><input type="text" name="atributo" id="atributo" class="input" value="'.$RResProducto["Atributo"].'"></th>
											<th class="texto" align="left">Unidad: </th>
											<th class="texto" align="left"><select name="unidad" id="unidad">
												<option>Seleccione</option>';
				$ResUnidades=mysql_query("SELECT Id, Nombre FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='unidades' ORDER BY Nombre ASC");
				while($RResUnidades=mysql_fetch_array($ResUnidades))
				{
					$unidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResProducto["Unidad"]."' LIMIT 1"));
					$cadena.='		<option value="'.$RResUnidades["Id"].'"'; if($RResUnidades["Id"]==$RResProducto["Unidad"] OR $RResUnidades["Nombre"]==$unidad["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResUnidades["Nombre"].'</option>';
				}
				$cadena.='			</select>
											</th>
										</tr>
										<tr>
											<th class="texto" align="left">Grupo: </th>
											<th class="texto" align="left" colspan="3"><select name="grupo" id="grupo" onchange="xajax_productos(\''.$limite.'\', \'editar\', \'1\', xajax.getFormValues(\'feditproducto\'))"><option value="">Seleccione</option>';
				$ResGrupos=mysql_query("SELECT * FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='grupos' ORDER BY Nombre ASC");
				while($RResGrupos=mysql_fetch_array($ResGrupos))
				{
					$cadena.='		<option value="'.$RResGrupos["Id"].'"';
					if(is_array($form))
					{
						if($RResGrupos["Id"]==$form["grupo"])
						{
							$cadena.=' selected';
						}
					}
					else
					{ 
						$grupo=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResProducto["Grupo"]."' LIMIT 1"));
						if($RResGrupos["Id"]==$RResProducto["Grupo"] OR $RResGrupos["Nombre"]==$grupo["Nombre"])
						{
							$cadena.=' selected';
						}
					}
					$cadena.='>'.$RResGrupos["Nombre"].'</option>';
				}
				$cadena.='		</select></th>
											
										</tr>
										<tr>
											<th class="texto" align="left">Tipo de Producto: </th>
											<th colspan="3" align="left" class="texto"><select name="tipoprod" id="tipoprod"><option value="">Selecione</option>';
				$ResTipProd=mysql_query("SELECT * FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='tproducto' ORDER BY Id ASC");
				while($RResTipProd=mysql_fetch_array($ResTipProd))
				{
					$tipop=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$RResProducto["TipoProducto"]."' LIMIT 1"));
					$cadena.='<option value="'.$RResTipProd["Id"].'"';if($RResTipProd["Id"]==$RResProducto["TipoProducto"] OR $RResTipProd["Nombre"]==$tipop["Nombre"]){$cadena.=' selected';}$cadena.='>'.$RResTipProd["Nombre"].'</option>';
				}
				$cadena.='		</select></th>
										</tr>
										<tr>
											<th class="texto" align="left">Costo: </th>
											<th class="texto" align="left">$ <input type="text" name="costo" id="costo" class="input" value="'.number_format($RResProducto["Costo"], 2).'" onKeyUp="calculo(this.value,\'1.10\',preciopublico);calculo(this.value,\'1.15\',preciopublico2);calculo(this.value,\'1.20\',preciopublico3);calculo(this.value,\'0\',costodolar);"></th>
											<th class="texto" align="left">Costo Dolares: </th>
											<th class="texto" align="left">$ <input type="text" name="costodolar" id="costodolar" class="input" value="'.number_format($RResProducto["CostoDolar"], 2).'" onKeyUp="calculo(this.value,\'1.10\',preciopublico);calculo(this.value,\'1.15\',preciopublico2);calculo(this.value,\'1.20\',preciopublico3);calculo(this.value,\'0\',costo);"></th>
										</tr>
										<tr>	
											<th class="texto" align="left">Precio Público: </th>
											<th class="texto" align="left">$ <input type="text" name="preciopublico" id="preciopublico" class="input" value="'.number_format($RResProducto["PrecioPublico"], 2).'"></th>
											<th class="texto" align="left">Precio Público 2: </th>
											<th class="texto" align="left">$ <input type="text" name="preciopublico2" id="preciopublico2" class="input" value="'.$RResProducto["PrecioPublico2"].'"></th>
										</tr>
										<tr>
											<th class="texto" align="left">Precio Público 3: </th>
											<th class="texto" align="left">$ <input type="text" name="preciopublico3" id="preciopublico3" class="input" value="'.$RResProducto["PrecioPublico3"].'"></th>
											<th class="texto" align="left">Anaquel: </th>
											<th class="texto" align="left"><input type="text" name="anaquel" id="anaquel" class="input" value="'.$RResProducto["Anaquel"].'"></th>
										</tr>
										<tr>
											<th colspan="4" align="center">
												<input type="hidden" name="idproducto" id="idproducto" value="';if(is_array($form)){$cadena.=$form["idproducto"];} else{$cadena.=$form;}$cadena.='">
												<input type="button" name="boteditprod" id="boteditprod" value="Editar Producto>>" class="boton" onclick="xajax_productos(\''.$limite.'\', \'editar\', \'2\', xajax.getFormValues(\'feditproducto\'))"></th>
										</tr>
										</tr>
									</table>
									</form>';
  		}
  		elseif($accion==2)
  		{
  			if($form["costo"]!='0.00'){$moneda='MN';}
  			elseif($form["costodolar"]!='0.00'){$moneda='USD';}
  			if (mysql_query("UPDATE productos SET Empresa='".$_SESSION["empresa"]."', 
  																						Provedor='".$form["provedor"]."',
  																						Provedor2='".$form["provedor2"]."',
  																						Provedor3='".$form["provedor3"]."',
  																						Provedor4='".$form["provedor4"]."',
  																						Provedor5='".$form["provedor5"]."', 
  																						Clase='".$form["clase"]."', 
  																						Clave='".utf8_decode($form["clave"])."', 
  																						Nombre='".utf8_decode($form["nombre"])."', 
  																						Atributo='".utf8_decode($form["atributo"])."', 
  																						Unidad='".$form["unidad"]."', 
  																						Grupo='".utf8_decode($form["grupo"])."', 
  																						SubGrupo='".utf8_decode($form["subgrupo"])."', 
  																						TipoProducto='".utf8_decode($form["tipoprod"])."', 
  																						Anaquel='".utf8_decode($form["anaquel"])."',
  																						Costo='".$form["costo"]."',
  																						CostoDolar='".$form["costodolar"]."', 
  																						PrecioPublico='".$form["preciopublico"]."',
  																						PrecioPublico2='".$form["preciopublico2"]."',
  																						PrecioPublico3='".$form["preciopublico3"]."',
  																						Moneda='".$moneda."'
  																		  WHERE Id='".$form["idproducto"]."'"))
  			{
  				//edita los precios pactados
  				for($i=1; $i<$form["clientespactados"]; $i++)
  				{
  					if($form["borra_".$i]==1)
  					{
  						mysql_query("DELETE FROM prodpactados WHERE Id='".$form["idprodpac_".$i]."'");
  					}
  					elseif($form["borra_".$i]!=1 AND $form["idprodpac_".$i]!=0)
  					{
  						mysql_query("UPDATE prodpactados SET ClaveP='".$form["clave_".$i]."', 
  																								 Cliente='".$form["cliente_".$i]."', 
  																								 PrecioPactado='".$form["costo_".$i]."' 
  																					 WHERE Id='".$form["idprodpac_".$i]."'");
  					}
  					elseif($form["idprodpac_".$i]==0)
  					{
  						mysql_query("INSERT INTO prodpactados (Empresa, Sucursal, Producto, ClaveP, Cliente, PrecioPactado)
  																					 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".$form["idproducto"]."', '".$form["clave_".$i]."',
  																					 				 '".$form["cliente_".$i]."', '".$form["costo_".$i]."')");
  					}
  				}
  				
  				$cadena.='<p class="textomensaje" align="center">Se Actualizo el Producto satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intentelo nuevamente'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'eliminar': //ELIMINAR PRODUCTO
			$cadena.='<tr>
									<th colspan="10" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)
			{
				$ResProducto=mysql_query("SELECT Nombre FROM productos WHERE Id='".$form."' LIMIT 1");
				$RResProducto=mysql_fetch_array($ResProducto);
				
				$cadena.='<p align="center" class="texto">Esta seguro de eliminar el producto '.$RResProducto["Nombre"].'<br />
									<a href="#" onclick="xajax_productos(\''.$limite.'\', \'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_productos(\''.$limite.'\')">No</a></p>';
			}
			elseif($accion==2)
			{
				if(mysql_query("DELETE FROM productos WHERE Id='".$form."' LIMIT 1") AND mysql_query("DELETE FROM prodpactados WHERE Producto='".$form."'"))
				{
					$cadena.='<p class="textomensaje" align="center">Se elimino el Producto satisfactoriamente</p>';
				}
				else
				{
					$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente</p>';
				}
			}
			$cadena.='</th></tr>';
			break;
	}
	//muestra productos
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Clave</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Nombre</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Marca</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Unidad</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Grupo</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResProductos=mysql_query("SELECT * FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC LIMIT ".$limite.", 25");
	$regs=mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."'"));
	$bgcolor="#FFFFFF"; $J=$limite+1;
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$ResUnidad=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$RResProductos["Unidad"]."' LIMIT 1");
		$RResUnidad=mysql_fetch_array($ResUnidad);
		$ResGrupo=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='grupos' AND Id='".$RResProductos["Grupo"]."' LIMIT 1");
		$RResGrupo=mysql_fetch_array($ResGrupo);
		$ResSubGrupo=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='G_".$RResGrupo["Id"]."' AND Id='".$RResProductos["SubGrupo"]."' LIMIT 1");
		$RResSubGrupo=mysql_fetch_array($ResSubGrupo);
		$ResTipo=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='tproducto' AND Id='".$RResProductos["TipoProducto"]."' LIMIT 1");
		$RResTipo=mysql_fetch_array($ResTipo);
		
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" class="texto" align="center">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResProductos["Clave"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResProductos["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResProductos["Atributo"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResUnidad["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResGrupo["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="center">
									<a href="#" onclick="xajax_productos(\''.$limite.'\', \'editar\', \'1\', \''.$RResProductos["Id"].'\')"><img src="images/edit.png" border="0"></a>
									<a href="#" onclick="xajax_productos(\''.$limite.'\', \'eliminar\', \'1\', \''.$RResProductos["Id"].'\')"><img src="images/x.png" border="0"></a>
									<a href="#" onclick="xajax_imagen_producto(\''.$RResProductos["Id"].'\')"><img src="images/imagen.png" border="0"></a>
								</td>
							</tr>';
		$J++;
		if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
		else if($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
	}
	$cadena.='	<tr>
								<th colspan="7" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_productos(\''.$J.'\')">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function buscar_producto($limite=0, $buscar)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="5" bgcolor="#FFFFFF" class="texto" align="left">
								<form name="fbuscar" id="fbuscar">
								Buscar por:<select name="provedor" id="provedor"><option value="%">Todos</option>';
	$ResProvedores=mysql_query("SELECT Id, Nombre FROM provedores WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	while($RResProvedores=mysql_fetch_array($ResProvedores))
	{
		$cadena.='<option value="'.$RResProvedores["Id"].'"';if($RResProvedores["Id"]==$buscar["provedor"]){$cadena.=' selected';}$cadena.='>'.$RResProvedores["Nombre"].'</option>';
	}
	$cadena.='			</select><br /><select name="campo" id="campo">
								<option value="Clave"';if($buscar["campo"]=='Clave'){$cadena.=' selected';}$cadena.='>Clave</option>
								<option value="Nombre"';if($buscar["campo"]=='Nombre'){$cadena.=' selected';}$cadena.='>Nombre</option>
								</select> <input type="text" name="buscar" id="buscar" class="input" size="25" value="'.$buscar["buscar"].'"> 
								<input type="button" name="botbuscar" id="botbuscar" value="Buscar>>" class="boton" onclick="xajax_buscar_producto(\'0\', xajax.getFormValues(\'fbuscar\'))">
								</form>
							</th>
							<th colspan="5" bgcolor="#FFFFFF" class="texto" align="right">| <a href="#" onclick="xajax_productos(\''.$limite.'\', \'agregar\', \'1\')">Agregar Producto</a> | <a href="#" onclick="xajax_clases()">Clases</a> | <a href="#" onclick="xajax_unidades()">Unidades</a> | <a href="#" onclick="xajax_grupos()">Grupos</a> | <a href="#" onclick="xajax_tipo_producto()">Tipos</a> |</th>
						</tr>
					 	<tr>
							<th colspan="10" bgcolor="#4db6fc" class="texto3" align="center">Productos Empresa '.$RResEmpresa["Nombre"].'</th>
						</tr>';
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Clase</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Clave</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Nombre</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Atributo</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Unidad</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Grupo</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Subgrupo</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">Tipo de Producto</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResProductos=mysql_query("SELECT * FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND ".$buscar["campo"]." LIKE '%".$buscar["buscar"]."%' AND Provedor LIKE '".$buscar["provedor"]."' ORDER BY Nombre ASC LIMIT ".$limite.", 25") or die (mysql_error());
	$regs=mysql_num_rows(mysql_query("SELECT Id FROM productos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND ".$buscar["campo"]." LIKE '%".$buscar["buscar"]."%' AND Provedor LIKE '".$buscar["provedor"]."'"));
	$bgcolor="#FFFFFF"; $J=$limite+1;
	while($RResProductos=mysql_fetch_array($ResProductos))
	{
		$ResClase=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='clases' AND Id='".$RResProductos["Clase"]."' LIMIT 1");
		$RResClase=mysql_fetch_array($ResClase);
		$ResUnidad=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$RResProductos["Unidad"]."' LIMIT 1");
		$RResUnidad=mysql_fetch_array($ResUnidad);
		$ResGrupo=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='grupos' AND Id='".$RResProductos["Grupo"]."' LIMIT 1");
		$RResGrupo=mysql_fetch_array($ResGrupo);
		$ResSubGrupo=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='G_".$RResGrupo["Id"]."' AND Id='".$RResProductos["SubGrupo"]."' LIMIT 1");
		$RResSubGrupo=mysql_fetch_array($ResSubGrupo);
		$ResTipo=mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='tproducto' AND Id='".$RResProductos["TipoProducto"]."' LIMIT 1");
		$RResTipo=mysql_fetch_array($ResTipo);
		
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" class="texto" align="center">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResClase["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResProductos["Clave"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResProductos["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResProductos["Atributo"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResUnidad["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResGrupo["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResSubGrupo["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="left">'.$RResTipo["Nombre"].'</td>
								<td bgcolor="'.$bgcolor.'" class="texto" align="center">
									<a href="#" onclick="xajax_productos(\''.$limite.'\', \'editar\', \'1\', \''.$RResProductos["Id"].'\')"><img src="images/edit.png" border="0"></a>
									<a href="#" onclick="xajax_productos(\''.$limite.'\', \'eliminar\', \'1\', \''.$RResProductos["Id"].'\')"><img src="images/x.png" border="0"></a>
									<a href="#" onclick="xajax_imagen_producto(\''.$RResProductos["Id"].'\')"><img src="images/imagen.png" border="0"></a>
								</td>
							</tr>';
		$J++;
		if($bgcolor=="#FFFFFF"){$bgcolor='#CCCCCC';}
		else if($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
	}
	$cadena.='	<tr>
								<th colspan="10" bgcolor="#ffffff" align="center">| ';
	$J=0;
	for($T=1; $T<=ceil($regs/25); $T++)
	{
		$cadena.='<a href="#" onclick="xajax_buscar_producto(\''.$J.'\', xajax.getFormValues(\'fbuscar\'))">'.$T.'</a> |	';
		$J=$J+25;
	}
	$cadena.='		</th>
							</tr>
						</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;	
}
function clases($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center" width="90%">
						<tr>
							<th colspan="2" bgcolor="#FFFFFF" class="texto" align="left">| <a href="#" onclick="xajax_clases(\'agregar\',\'1\')">Agregar clase</a> | </th>
							<th colspan="2" bgcolor="#FFFFFF" class="texto" align="right">&nbsp;</th>
						</tr>
					 	<tr>
							<th colspan="4" bgcolor="#4db6fc" class="texto3" align="center">Clases Productos</th>
						</tr>';
	//area de trabajo
	switch($modo)
	{
		case 'agregar': //AGREGAR CLASE
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para agregar clase
  		{
  			$cadena.='<form name="fadclase" id="fadclase">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<td align="left" class="texto">Nombre: </td>
										<td align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Descripcion: </th>
										<td align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50"></td>
									</tr>
									<tr>
										<td colspan="2" align="center"><input type="button" name="botadclase" id="botadclase" value="Agregar Clase>>" class="boton" onclick="xajax_clases(\'agregar\', \'2\', xajax.getFormValues(\'fadclase\'))"></td>
									</tr>
									</table>
									</form>';
  		}
  		elseif($accion==2)//agregando clase
  		{
  			if(mysql_query("INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA, Descripcion)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["nombre"])."', 
  																							'clases', '".utf8_decode($form["descripcion"])."')"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se agrego la Clase satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamete<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'editar': //EDITAR CLASE
		$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para editar clase
  		{
  			$ResClase=mysql_query("SELECT * FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResClase=mysql_fetch_array($ResClase);
  			
  			$cadena.='<form name="feditclase" id="feditclase">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<td align="left" class="texto">Nombre: </td>
										<td align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResClase["Nombre"].'"></td>
									</tr>
									<tr>
										<td align="left" class="texto">Descripcion: </th>
										<td align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50" value="'.$RResClase["Descripcion"].'"></td>
									</tr>
									<tr>
										<td colspan="2" align="center">
											<input type="hidden" name="idclase" id="idclase" value="'.$RResClase["Id"].'">
											<input type="button" name="boteditclase" id="boteditclase" value="Editar Clase>>" class="boton" onclick="xajax_clases(\'editar\', \'2\', xajax.getFormValues(\'feditclase\'))">
										</td>
									</tr>
									</table>
									</form>';
  		}
  		if($accion==2)
  		{
  			if (mysql_query("UPDATE parametros SET Nombre='".utf8_decode($form["nombre"])."', 
  																						 Descripcion='".utf8_decode($form["descripcion"])."'
  																			 WHERE Id='".$form["idclase"]."'"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se actualizo la clase satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'eliminar':
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para editar clase
  		{
  			$ResClase=mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResClase=mysql_fetch_array($ResClase);
  			
  			$cadena.='<p class="texto" align="center">Esta seguro de eliminar la Clase '.$RResClase["Nombre"].'<br />
  								<a href="#" onclick="xajax_clases(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_clases()">No</a>';
  		}
  		if($accion==2)
  		{
  			if(mysql_query("DELETE FROM parametros WHERE Id='".$form."' LIMIT 1"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se elimino la Clase satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente mas tarde</br>'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
	}
	//muestra clases
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3" width="10%">&nbsp;</td>
							<td colspan="2" bgcolor="#4db6fc" align="center" class="texto3">Clase</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResClases=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='clases' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	$bgcolor="#7ac37b"; $J=1;
	while($RResClases=mysql_fetch_array($ResClases))
	{
		$cadena.='<tr>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto" width="10%">'.$J.'</td>
							<td colspan="2" bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResClases["Nombre"].'</td>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto">
								<a href="#" onclick="xajax_clases(\'editar\', \'1\', \''.$RResClases["Id"].'\')"><img src="images/edit.png" border="0"></a>
								<a href="#" onclick="xajax_clases(\'eliminar\', \'1\', \''.$RResClases["Id"].'\')"><img src="images/x.png" border="0"></a>
							</td>
							</tr>';
		$J++;
		if($bgcolor=="#7ac37b"){$bgcolor='#5ac15b';}
		else if($bgcolor=="#5ac15b"){$bgcolor="#7ac37b";}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function unidades($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center" width="90%">
						<tr>
							<th colspan="2" bgcolor="#FFFFFF" class="texto" align="left">| <a href="#" onclick="xajax_unidades(\'agregar\',\'1\')">Agregar Unidad</a> | </th>
							<th colspan="2" bgcolor="#FFFFFF" class="texto" align="right">&nbsp;</th>
						</tr>
					 	<tr>
							<th colspan="4" bgcolor="#4db6fc" class="texto3" align="center">Unidades Productos</th>
						</tr>';
	//area de trabajo
	switch($modo)
	{
		case 'agregar': //AGREGAR UNIDAD
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para agregar unidad
  		{
  			$cadena.='<form name="fadunidad" id="fadunidad">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </td>
										<th align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Descripcion: </th>
										<th align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50"></th>
									</tr>
									<tr>
										<th colspan="2" align="center"><input type="button" name="botadunidad" id="botadunidad" value="Agregar Unidad>>" class="boton" onclick="xajax_unidades(\'agregar\', \'2\', xajax.getFormValues(\'fadunidad\'))"></th>
									</tr>
									</table>
									</form>';
  		}
  		elseif($accion==2)//agregando unidad
  		{
  			if(mysql_query("INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA, Descripcion)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["nombre"])."', 
  																							'unidades', '".utf8_decode($form["descripcion"])."')"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se agrego la Unidad satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamete<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'editar': //EDITAR UNIDAD
		$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para editar clase
  		{
  			$ResUnidad=mysql_query("SELECT * FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResUnidad=mysql_fetch_array($ResUnidad);
  			
  			$cadena.='<form name="feditunidad" id="feditunidad">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResUnidad["Nombre"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Descripcion: </th>
										<th align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50" value="'.$RResUnidad["Descripcion"].'"></th>
									</tr>
									<tr>
										<th colspan="2" align="center">
											<input type="hidden" name="idunidad" id="idunidad" value="'.$RResUnidad["Id"].'">
											<input type="button" name="boteditunidad" id="boteditunidad" value="Editar Unidad>>" class="boton" onclick="xajax_unidades(\'editar\', \'2\', xajax.getFormValues(\'feditunidad\'))">
										</th>
									</tr>
									</table>
									</form>';
  		}
  		if($accion==2)
  		{
  			if (mysql_query("UPDATE parametros SET Nombre='".utf8_decode($form["nombre"])."', 
  																						 Descripcion='".utf8_decode($form["descripcion"])."'
  																			 WHERE Id='".$form["idunidad"]."'"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se actualizo la Unidad satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'eliminar':
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para eliminar unidad
			{
  			$ResClase=mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResClase=mysql_fetch_array($ResClase);
  			
  			$cadena.='<p class="texto" align="center">Esta seguro de eliminar la Unidad '.$RResClase["Nombre"].'<br />
  								<a href="#" onclick="xajax_unidades(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_unidades()">No</a>';
  		}
  		if($accion==2)
  		{
  			if(mysql_query("DELETE FROM parametros WHERE Id='".$form."' LIMIT 1"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se elimino la Unidad satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente mas tarde</br>'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
	}
	//muestra unidades
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3" width="10%">&nbsp;</td>
							<td colspan="2" bgcolor="#4db6fc" align="center" class="texto3">Unidad</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResUnidades=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='unidades' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	$bgcolor="#fff"; $J=1;
	while($RResUnidades=mysql_fetch_array($ResUnidades))
	{
		$cadena.='<tr>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto" width="10%">'.$J.'</td>
							<td colspan="2" bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResUnidades["Nombre"].'</td>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto">
								<a href="#" onclick="xajax_unidades(\'editar\', \'1\', \''.$RResUnidades["Id"].'\')"><img src="images/edit.png" border="0"></a>
								<a href="#" onclick="xajax_unidades(\'eliminar\', \'1\', \''.$RResUnidades["Id"].'\')"><img src="images/x.png" border="0"></a>
							</td>
							</tr>';
		$J++;
		if($bgcolor=="#fff"){$bgcolor='#ccc';}
		else if($bgcolor=="#ccc"){$bgcolor="#fff";}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function grupos($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center" width="90%">
						<tr>
							<td colspan="2" bgcolor="#FFFFFF" class="texto" align="left">| <a href="#" onclick="xajax_grupos(\'agregar\',\'1\')">Agregar Grupo</a> | </td>
							<td colspan="2" bgcolor="#FFFFFF" class="texto" align="right">&nbsp;</td>
						</tr>
					 	<tr>
							<td colspan="4" bgcolor="#4db6fc" class="texto3" align="center">Grupos Productos</td>
						</tr>';
	//area de trabajo
	switch($modo)
	{
		case 'agregar': //AGREGAR Grupo
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para agregar grupo
  		{
  			$cadena.='<form name="fadgrupo" id="fadgrupo">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$form["nombre"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Descripcion: </th>
										<th align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50" value="'.$form["descripcion"].'"></th>
									</tr>
									<tr>
										<th colspan="2" align="center" class="texto">Subgrupos</th>
									</tr>';
					if(!$form["nsubgrupos"])
					{
						$cadena.='<tr>
												<th align="left" class="texto">Subgrupo 1: </th>
												<th align="left" clasS="texto"><input type="hidden" name="nsubgrupos" id="nsubgrupos" value="2"><input type="text" name="subgrupo_1" id="subgrupo_1" clasS="input" size="25"></th>
											</tr>
											<tr>
												<th colspan="2" align="right" class="texto"><a href="#" onclick="xajax_grupos(\'agregar\',\'1\', xajax.getFormValues(\'fadgrupo\'))">Agregar Subgrupo>></th>
											</tr>';
					}
					else
					{
						for($i=1; $i<=$form["nsubgrupos"];$i++)
						{
							$cadena.='<tr>
												<th align="left" class="texto">Subgrupo '.$i.': </th>
												<th align="left" clasS="texto"><input type="text" name="subgrupo_'.$i.'" id="subgrupo_'.$i.'" class="input" size="25" value="'.$form["subgrupo_".$i].'"></th>
											</tr>';
						}
						$cadena.='<tr>
												<th colspan="2" align="right" class="texto">
												<input type="hidden" name="nsubgrupos" id="nsubgrupos" value="'.($form["nsubgrupos"]+1).'">
												<a href="#" onclick="xajax_grupos(\'agregar\',\'1\', xajax.getFormValues(\'fadgrupo\'))">Agregar Subgrupo>></th>
											</tr>';
					}				
					$cadena.='<tr>
										<th colspan="2" align="center"><input type="button" name="botadgrupo" id="botadgrupo" value="Agregar Grupo>>" class="boton" onclick="xajax_grupos(\'agregar\', \'2\', xajax.getFormValues(\'fadgrupo\'))"></th>
									</tr>
									</table>
									</form>';
  		}
  		elseif($accion==2)//agregando grupos
  		{
  			if(mysql_query("INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA, Descripcion)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["nombre"])."', 
  																							'grupos', '".utf8_decode($form["descripcion"])."')"))
  			{
  				$ResGrupo=mysql_fetch_array(mysql_query("SELECT Id FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='grupos' ORDER BY Id DESC LIMIT 1"));
  				for($i=1; $i<$form["nsubgrupos"];$i++)
  				{
  					mysql_query("INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA)
  																			 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["subgrupo_".$i])."',
  																			 'G_".$ResGrupo["Id"]."')");
  				}
  				$cadena.='<p class="textomensaje" align="center">Se agrego el Grupo satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamete<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'editar': //EDITAR Grupo
		$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para editar grupo
  		{
  			if(!is_array($form))
  			{
  				$ResGrupo=mysql_query("SELECT * FROM parametros WHERE Id='".$form."' LIMIT 1");
  			}
  			else
  			{
  				$ResGrupo=mysql_query("SELECT * FROM parametros WHERE Id='".$form["idgrupo"]."' LIMIT 1");
  			}
  			$RResGrupo=mysql_fetch_array($ResGrupo);
  			
  			$cadena.='<form name="feditgrupo" id="feditgrupo">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResGrupo["Nombre"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Descripcion: </th>
										<th align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50" value="'.$RResGrupo["Descripcion"].'"></th>
									</tr>';
  			$ResSubGrupos=mysql_query("SELECT * FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='G_".$RResGrupo["Id"]."' ORDER BY Id ASC");
  			$numsubgrupos=mysql_num_rows($ResSubGrupos); $J=1;
  			while($RResSubgrupos=mysql_fetch_array($ResSubGrupos))
  			{
  				$cadena.='<tr>
  										<th align="left" class="texto"><input type="hidden" name="idsubgrupo_'.$J.'" id="idsubgrupo_'.$J.'" value="'.$RResSubgrupos["Id"].'">Subgrupo '.$J.':</th>
  										<th align="left"><input type="text" name="subgrupo_'.$J.'" id="subgrupo_'.$J.'" value="'.utf8_decode($RResSubgrupos["Nombre"]).'" class="input"></th>
  									</tr>';
  				$J++;
  			}
  			if(!is_array($form)){$nsubgrupos=$numsubgrupos+1;}
  			else
  			{
  				$nsubgrupos=$form["nsubgrupos"]+1;
  				for($J; $J<$nsubgrupos; $J++)
  				{
  					$cadena.='<tr>
  										<th align="left" class="texto">Subgrupo '.$J.':</th>
  										<th align="left"><input type="text" name="subgrupo_'.$J.'" id="subgrupo_'.$J.'" value="'.utf8_decode($form["subgrupo_".$J]).'" class="input"></th>
  									</tr>';
  				}
  			}
  			
  			$cadena.='<tr>
												<th colspan="2" align="right" class="texto">
												<input type="hidden" name="nsubgrupos" id="nsubgrupos" value="'.$nsubgrupos.'">
												<a href="#" onclick="xajax_grupos(\'editar\',\'1\', xajax.getFormValues(\'feditgrupo\'))">Agregar Subgrupo>></th>
											</tr>';
  			$cadena.='	<tr>
										<th colspan="2" align="center">
											<input type="hidden" name="numsubgrupos" id="numsubgrupos" value="'.$numsubgrupos.'">
											<input type="hidden" name="idgrupo" id="idgrupo" value="'.$RResGrupo["Id"].'">
											<input type="button" name="boteditgrupo" id="boteditgrupo" value="Editar Grupo>>" class="boton" onclick="xajax_grupos(\'editar\', \'2\', xajax.getFormValues(\'feditgrupo\'))">
										</th>
									</tr>
									</table>
									</form>';
  		}
  		if($accion==2)
  		{
  			if (mysql_query("UPDATE parametros SET Nombre='".utf8_decode($form["nombre"])."', 
  																						 Descripcion='".utf8_decode($form["descripcion"])."'
  																			 WHERE Id='".$form["idgrupo"]."'"))
  			{
  				$grupos=mysql_query("SELECT * FROM parametros WHERE PerteneceA='G_".$form["idgrupo"]."'");
  				
  				for($J=1; $J<=mysql_num_rows($grupos);$J++)
  				{
  					mysql_query("UPDATE parametros SET Nombre='".utf8_decode($form["subgrupo_".$J])."' WHERE Id='".$form["idsubgrupo_".$J]."'");
  					if($J==count($grupos)){$J++;}
  				}
  				//inserta nuevos subgrupos
  				while($J<$form["nsubgrupos"])
  				{
  					mysql_query("INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA)
  																			 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["subgrupo_".$J])."',
  																			 'G_".$form["idgrupo"]."')");
  					$cadena.="INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA)
  																			 VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["subgrupo_".$J])."',
  																			 'G_".$form["idgrupo"]."')<br />";
  					$J++;
  				}
  				$cadena.=mysql_num_rows($grupos).$form["nsubgrupos"].'<p class="textomensaje" align="center">Se actualizo el Grupo satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'eliminar':
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para eliminar unidad
			{
  			$ResClase=mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResClase=mysql_fetch_array($ResClase);
  			
  			$cadena.='<p class="texto" align="center">Esta seguro de eliminar la Unidad '.$RResClase["Nombre"].'<br />
  								<a href="#" onclick="xajax_unidades(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_unidades()">No</a>';
  		}
  		if($accion==2)
  		{
  			if(mysql_query("DELETE FROM parametros WHERE Id='".$form."' LIMIT 1"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se elimino la Unidad satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente mas tarde</br>'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
	}
	//muestra grupos
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3" width="10%">&nbsp;</td>
							<td colspan="2" bgcolor="#4db6fc" align="center" class="texto3">Grupo</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResGrupos=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='grupos' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Nombre ASC");
	$bgcolor="#fff"; $J=1;
	while($RResGrupos=mysql_fetch_array($ResGrupos))
	{
		$cadena.='<tr>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto" width="10%">'.$J.'</td>
							<td colspan="2" bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResGrupos["Nombre"].'</td>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto">
								<a href="#" onclick="xajax_grupos(\'editar\', \'1\', \''.$RResGrupos["Id"].'\')"><img src="images/edit.png" border="0"></a>
							</td>
							</tr>';
		$J++;
		if($bgcolor=="#fff"){$bgcolor='#ccc';}
		else if($bgcolor=="#ccc"){$bgcolor="#fff";}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function tipo_producto($modo=NULL, $accion=NULL, $form=NULL)
{
	include ("conexion.php");
	
	$cadena='<table border="0" bordercolor="#FFFFFF" cellpadding="3" cellspacing="0" align="center" width="90%">
						<tr>
							<th colspan="2" bgcolor="#FFFFFF" class="texto" align="left">| <a href="#" onclick="xajax_tipo_producto(\'agregar\',\'1\')">Agregar Tipo de Producto</a> | </th>
							<th colspan="2" bgcolor="#FFFFFF" class="texto" align="right">&nbsp;</th>
						</tr>
					 	<tr>
							<th colspan="4" bgcolor="#4db6fc" class="texto3" align="center">Tipos Productos</th>
						</tr>';
	//area de trabajo
	switch($modo)
	{
		case 'agregar': //AGREGAR TIPO PRODUCTO
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para agregar tipo de producto
  		{
  			$cadena.='<form name="fadtipoprod" id="fadtipoprod">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th align="left"><input type="text" name="nombre" id="nombre" class="input" size="50"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Descripcion: </th>
										<th align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50"></th>
									</tr>
									<tr>
										<th colspan="2" align="center"><input type="button" name="botadtipoprod" id="botadtipoprod" value="Agregar Tipo de Producto>>" class="boton" onclick="xajax_tipo_producto(\'agregar\', \'2\', xajax.getFormValues(\'fadtipoprod\'))"></th>
									</tr>
									</table>
									</form>';
  		}
  		elseif($accion==2)//agregando tipo de producto
  		{
  			if(mysql_query("INSERT INTO parametros (Empresa, Sucursal, Nombre, PerteneceA, Descripcion)
  																			VALUES ('".$_SESSION["empresa"]."', '".$_SESSION["sucursal"]."', '".utf8_decode($form["nombre"])."', 
  																							'tproducto', '".utf8_decode($form["descripcion"])."')"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se agrego el Tipo de Producto satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamete<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'editar': //EDITAR TIPO DE PRODUCTO
		$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para editar tipo de producto
  		{
  			$ResTipoProd=mysql_query("SELECT * FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResTipoProd=mysql_fetch_array($ResTipoProd);
  			
  			$cadena.='<form name="fedittipoprod" id="fedittipoprod">
									<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th align="left" class="texto">Nombre: </th>
										<th align="left"><input type="text" name="nombre" id="nombre" class="input" size="50" value="'.$RResTipoProd["Nombre"].'"></th>
									</tr>
									<tr>
										<th align="left" class="texto">Descripcion: </th>
										<th align="left"><input type="text" name="descripcion" id="descripcion" class="input" size="50" value="'.$RResTipoProd["Descripcion"].'"></th>
									</tr>
									<tr>
										<th colspan="2" align="center">
											<input type="hidden" name="idtipoprod" id="idtipoprod" value="'.$RResTipoProd["Id"].'">
											<input type="button" name="botedittipoprod" id="botedittipoprod" value="Editar Tipo de Producto>>" class="boton" onclick="xajax_tipo_producto(\'editar\', \'2\', xajax.getFormValues(\'fedittipoprod\'))">
										</th>
									</tr>
									</table>
									</form>';
  		}
  		if($accion==2)
  		{
  			if (mysql_query("UPDATE parametros SET Nombre='".utf8_decode($form["nombre"])."', 
  																						 Descripcion='".utf8_decode($form["descripcion"])."'
  																			 WHERE Id='".$form["idtipoprod"]."'"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se actualizo El Tipo de Producto satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente nuevamente<br />'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
		case 'eliminar':
			$cadena.='<tr>
									<th colspan="4" bgcolor="#cceaff" class="texto" align="center">';
			if($accion==1)//formulario para eliminar unidad
			{
  			$ResTipoProd=mysql_query("SELECT Id, Nombre FROM parametros WHERE Id='".$form."' LIMIT 1");
  			$RResTipoProd=mysql_fetch_array($ResTipoProd);
  			
  			$cadena.='<p class="texto" align="center">Esta seguro de eliminar el Tipo de Producto '.$RResTipoProd["Nombre"].'<br />
  								<a href="#" onclick="xajax_tipo_producto(\'eliminar\', \'2\', \''.$form.'\')">Si</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="xajax_tipo_producto()">No</a>';
  		}
  		if($accion==2)
  		{
  			if(mysql_query("DELETE FROM parametros WHERE Id='".$form."' LIMIT 1"))
  			{
  				$cadena.='<p class="textomensaje" align="center">Se elimino el Tipo de Producto satisfactoriamente</p>';
  			}
  			else
  			{
  				$cadena.='<p class="textomensaje" align="center">Ocurrio un problema, intente mas tarde</br>'.mysql_error().'</p>';
  			}
  		}
  		$cadena.='</th></tr>';
			break;
	}
	//muestra tipos de prodcutos
	$cadena.='<tr>
							<td bgcolor="#4db6fc" align="center" class="texto3" width="10%">&nbsp;</td>
							<td colspan="2" bgcolor="#4db6fc" align="center" class="texto3">Tipo de Producto</td>
							<td bgcolor="#4db6fc" align="center" class="texto3">&nbsp;</td>
						</tr>';
	$ResTipoProd=mysql_query("SELECT Id, Nombre FROM parametros WHERE PerteneceA='tproducto' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' ORDER BY Id ASC");
	$bgcolor="#fff"; $J=1;
	while($RResTipoProd=mysql_fetch_array($ResTipoProd))
	{
		$cadena.='<tr>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto" width="10%">'.$J.'</td>
							<td colspan="2" bgcolor="'.$bgcolor.'" align="left" class="texto">'.$RResTipoProd["Nombre"].'</td>
							<td bgcolor="'.$bgcolor.'" align="center" class="texto">
								<a href="#" onclick="xajax_tipo_producto(\'editar\', \'1\', \''.$RResTipoProd["Id"].'\')"><img src="images/edit.png" border="0"></a>
								<a href="#" onclick="xajax_tipo_producto(\'eliminar\', \'1\', \''.$RResTipoProd["Id"].'\')"><img src="images/x.png" border="0"></a>
							</td>
							</tr>';
		$J++;
		if($bgcolor=="#fff"){$bgcolor='#ccc';}
		else if($bgcolor=="#ccc"){$bgcolor="#fff";}
	}
	$cadena.='</table>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
function imagen_producto($producto)
{
	$cadena='<iframe src="productos/imagenproducto.php?empresa='.$_SESSION["empresa"].'&sucursal='.$_SESSION["sucursal"].'&producto='.$producto.'" width="900" height="600" scrolling="auto" frameborder="0"></iframe>';
	
	$respuesta = new xajaxResponse(); 
  $respuesta->addAssign("contenido","innerHTML",utf8_encode($cadena));
  return $respuesta;
}
?>