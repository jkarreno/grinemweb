<html>
<head>
<title>Clinica HORUS - Sistema de Administración de Medicamentos</title>
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
<script src="http://www.google.com/jsapi"></script>
	<script>google.load("jquery", "1");</script>
	<script src="js/jquery.ez-bg-resize.js" type="text/javascript" charset="utf-8"></script>
	<script>
		$(document).ready(function() {
			$("contenido").ezBgResize({
				img     : "images/bnr6.jpg", // Relative path example.  You could also use an absolute url (http://...).
				opacity : 1, // Opacity. 1 = 100%.  This is optional.
				center  : true // Boolean (true or false). This is optional. Default is true.
			});
		});
	</script>
</head>
<body>
<div id="top" style="width: 100%; height: 50px; background-color: #4db6fc;">
</div>

<div id="cuadro" style="width:100%; height: 100%; border: 0px solid #008001; position: absolute; top: 25px; left:0px;">
	<div id="menutop" style="width:100%; height: 24px; background-color: #a19aaa; position: absolute; top: 0px;"></div>
	<div id="contenido" style="position: absolute; top:24px; left:0px; width:100%; height: 100%; padding: 0 0 0 0px;">
	<p class="textomensaje" align="center"><?php echo $mensaje;?></p>
	<div id="login" style="position: absolute; top: 50px; left: 60%; width:300px;">
		<b class="b1h"></b><b class="b2h"></b><b class="b3h"></b><b class="b4h"></b>
    <div class="headh">
        <h3 align="center" class="textotit">Ingrese a Sistema</h3>
    </div>
    <div class="contenth">
        <div>
        	<table border="0" cellpadding="3" cellspacing="0" align="center" width="80%">
        	<form name="flogin" id="flogin" method="POST" action="validausuario.php">
         	<tr>
         		<td class="texto" align="left" style="border:0px;">Usuario: </td>
         		<td class="texto" algin="left" style="border:0px;"><input type="text" name="usuario" id="usuario" class="input"></td>
         	</tr>
         	<tr>
         		<td class="texto" align="left" style="border:0px;">Contrase&ntilde;a: </td>
         		<td class="texto" align="left" style="border:0px;"><input type="password" name="pass" id="pass" class="input"></td>
         	</tr>
         	<tr>
         		<th colspan="2" align="center"><a href="#" class="button orange"  onClick="document.forms.flogin.submit();return false">Ingresar >></a></th>
         	</tr></form>
         </table>
        </div>
    </div>
<b class="b4bh"></b><b class="b3bh"></b><b class="b2bh"></b><b class="b1h"></b>
	</div>
	</div>
</div>
</body>
</html>
