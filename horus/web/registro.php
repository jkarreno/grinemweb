<?php
echo '<img src="images/registro.jpg"><br />
			
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="400">
						<p class="textox">Lo invitamos a que se registre con nosotros para que pueda tener acceso a contenido exclusivo de nuestras marcas y productos, asi como resibir nuestras ultimas novedades directamente en su correo electronico.</p>
						<p class="textox">Por favor llene nuestro formulario con sus datos.
						<form name="fregistro" id="fregistro">
							<span class="textox">
							E-mail: <input type="text" name="correoe" size="25">
							<hr style="border-style: dotted; color: blue;" width="400" align="left">
							Nombre: <input type="text" name="nombre" size="25">
							<hr style="border-style: dotted; color: blue;" width="400" align="left">
							Compa&ntilde;ia: <input type="text" name="compania" size="25">
							<hr style="border-style: dotted; color: blue;" width="400" align="left">
							Comentarios: <textarea name="comentarios" ></textarea>
							<hr style="border-style: dotted; color: blue;" width="400" align="left">
							Contrase&ntilde;a: <input type="password" name="contrasena" size="10">
							<hr style="border-style: dotted; color: blue;" width="400" align="left">
							<input type="reset" name="botreset" value="Limpiar Formulario" style="font-size:10px; font-family:Verdana; font-weight:bold; color:white; background:#638cb5; border:0px; width:120px; height:19px;">&nbsp;
							<input type="button" name="botenviar" value="Enviar>>" onClick="xajax_registro(xajax.getFormValues(\'fregistro\'))" style="font-size:10px; font-family:Verdana; font-weight:bold; color:white; background:#638cb5; border:0px; width:120px; height:19px;">
							</span>
						</form>
					</td>
					<td width="20">&nbsp;</td>
					<td width="180" valign="top">
					<p class="textox">Si ya se ha registrado anteriormente, por favor ingrese aqui:
					<form name="ingreso" method="POST" action="validausuario.php">
						<p class="textox">Correo Electr&oacute;nico:<br />
							<input type="text" name="mail" size="20"><br />
							Contraseña:<br />
							<input type="password" name="contrasena" size="20"><br />
							<input type="submit" name="botingresar" value="Ingresar>>" style="font-size:10px; font-family:Verdana; font-weight:bold; color:white; background:#638cb5; border:0px; width:120px; height:19px;">
					</form>
					</td>
				</tr>
			</table>';
?>