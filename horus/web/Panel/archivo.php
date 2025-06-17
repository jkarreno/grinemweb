<?php
//edit this
$_max_file_size = '250000000'; //file size in bytes.
switch ($_GET["directorio"])
{
	case "productos":
		$upload_dir = '../Productos/images/'; //upload folder..chmod to 777
		break;
}

$_i = "1";                //number of files to upload at one time
//end edit 

echo '<html><head><style type="text/css">body {	margin-left: 0px; margin-top: 0px; margin-right: 0px;	margin-bottom: 0px;	background-color: #CCCCCC;}</style></head><body>';
if (!$_POST["butsubearchivo"])
{
	echo '<table border="0" cellpadding="0" cellspading="0" width="500" height="50"><tr><td bgcolor="#CCCCCC">
				<form name="subearchivo" action="archivo.php?directorio=productos" method="POST" enctype="multipart/form-data">
				<input type="file" name="uparchivo">&nbsp;<input type="submit" name="butsubearchivo" value="Anexar>>" style="font-size:10px; font-family:Verdana; font-weight:bold; color:white; background:#638cb5; border:0px; width:120px; height:19px;">
				</form>
				</td></tr></table>';
}
else if($_POST["butsubearchivo"])
{
	//datos del arhivo 
	$nombre_archivo = $HTTP_POST_FILES['uparchivo']['name']; 
	$tipo_archivo = $HTTP_POST_FILES['uparchivo']['type']; 
	$tamano_archivo = $HTTP_POST_FILES['uparchivo']['size']; 
	
	if (is_uploaded_file($HTTP_POST_FILES['uparchivo']['tmp_name']))
    { 
    	copy($HTTP_POST_FILES['uparchivo']['tmp_name'], $upload_dir.$nombre_archivo);
    	
    	$_SESSION["archivo"]=$nombre_archivo;
    	
    	echo 'Se ha anexado el archivo '.$_SESSION["archivo"];
    	echo '<input type="hidden" name="archivo" value="'.$_SESSION["archivo"].'">';
    }
    else
    {
    	echo 'Ocurrio un error, no se pudo anexar el archivo';
    }
}
echo '</body></html>';
?>