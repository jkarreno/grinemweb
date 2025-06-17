<?php
 include ("../conexion.php");
?>
<html>
<head>

<style type="text/css">
body {	
 margin-left: 0px; 
 margin-top: 0px; 
 margin-right: 0px;	
 margin-bottom: 0px;	
 background-color: #CCCCCC;
}
</style>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>

</head>
<body>
<?php

	$ResMarc=mysql_query("SELECT * FROM marcas WHERE Nombre='".$_GET["marca"]."'");
	$RResMarc=mysql_fetch_array($ResMarc);
	
	echo '<form name="marcamod" id="marcamod" methoc="POST" action="modificarmarcas.php">
						<p class="texto2">&nbsp;Nombre: <input type="text" name="nombre" value="'.$RResMarc["Nombre"].'"><br />
						&nbsp;Descripcion Corta: <br /><textarea id="desc_corta" name="desc_corta" rows="15" cols="80" style="width: 80%">'.$RResMarc["Desc_corta"].'</textarea><br />
						&nbsp;Descripcion Larga: <br /><textarea id="desc_larga" name="desc_larga" rows="15" cols="80" style="width: 80%">'.htmlentities($RResMarc["Desc_larga"]).'</textarea><br />
						&nbsp;Productos: <br /><textarea id="productos" name="productos" rows="15" cols="80" style="width: 80%">'.htmlentities($RResMarc["Productos"]).'</textarea><br />
						&nbsp;Logotipo: <input type="text" name="logotipo" value="'.$RResMarc["Logo"].'"><br />
						<input type="hidden" name="consecutivo" value="'.$RResMarc["Consecutivo"].'">
						&nbsp;<input type="submit" name="botmodmarc" value="Modificar>>">
					 </form>';
?>
</body>
</html>