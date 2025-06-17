<?php
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("../conexion.php");
include ("../funciones.php");
include ("../reportes/excelgen.class.php");

//initiate a instance of "excelgen" class
$excel = new ExcelGen("CorteCaja");

//initiate $row,$col variables
$row=0;
$col=0;

switch ($_GET["tipo"])
{
	case 'notas':
	
		$excel->WriteText($row,$col,"Corte de Caja del dia: ".fecha($_GET["fecha"]));
		
		$row++;$row++;
		$col=0;
		
		$ResVenta=mysql_query("SELECT SUM(Total) AS TotalTotal, SUM(Debe) AS TotalDebe FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$_GET["fecha"]."'");
		$RResVenta=mysql_fetch_array($ResVenta);
		
		$ResGastos=mysql_query("SELECT SUM(Cantidad) AS TotalGastos FROM gastos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$_GET["fecha"]."'");
		$RResGastos=mysql_fetch_array($ResGastos);
		
		$ResDebe=mysql_query("SELECT SUM(Cantidad) AS TotalDebe FROM debeadeudos WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$_GET["fecha"]."'");
		$RResDebe=mysql_fetch_array($ResDebe);
		
		$excel->WriteText($row,$col,"Subtotal Venta:");$col++;
		$excel->WriteNumber($row,$col,$RResVenta["TotalTotal"]);$col++;
		$excel->WriteText($row,$col,"Debe:");$col++;
		$excel->WriteNumber($row,$col,$RResVenta["TotalDebe"]);$col++;
		$excel->WriteText($row,$col,"Gastos:");$col++;
		$excel->WriteNumber($row,$col,$RResGastos["TotalGastos"]);$col++;
		$excel->WriteText($row,$col,"Pago Adeudos:");$col++;
		$excel->WriteNumber($row,$col,$RResDebe["TotalDebe"]);$col++;
		$excel->WriteText($row,$col,"Total Corte:");$col++;
		$excel->WriteNumber($row,$col,($RResVenta["TotalTotal"]-$RResVenta["TotalDebe"]-$RResGastos["TotalGastos"]+$RResDebe["TotalDebe"]));$col++;
		
		$row++;$row++;
		$col=0;
		
		$excel->WriteText($row,$col,"Num. Nota");$col++;
		$excel->WriteText($row,$col,"Cantidad");$col++;
		$excel->WriteText($row,$col,"Producto");$col++;
		$excel->WriteText($row,$col,"Costo");$col++;
		$excel->WriteText($row,$col,"Precio Unitario");$col++;
		$excel->WriteText($row,$col,"Importe");$col++;
		$excel->WriteText($row,$col,"Ganacia");$col++;

		$row++;
		$col=0;
		
		$ResNotas=mysql_query("SELECT Id, NumNota FROM nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Fecha='".$_GET["fecha"]."' ORDER BY NumNota ASC");
		while($RResNotas=mysql_fetch_array($ResNotas))
		{
			$ResDetNota=mysql_query("SELECT * FROM det_nota_venta WHERE IdNotaVenta='".$RResNotas["Id"]."'");
			while($RResDetNota=mysql_fetch_array($ResDetNota))
			{
				$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResDetNota["IdProducto"]."' LIMIT 1"));
				$excel->WriteText($row,$col,$RResNotas["NumNota"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["Cantidad"]);$col++;
				$excel->WriteText($row,$col,$ResProducto["Nombre"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["Costo"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["PrecioUnitario"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["Importe"]);$col++;
				$excel->WriteNumber($row,$col,(($RResDetNota["PrecioUnitario"]-$RResDetNota["Costo"])*$RResDetNota["Cantidad"]));$col++;
				$row++;
				$col=0;
			}
		}
		
		break;
	
	case 'horario':
		
		$excel->WriteText($row,$col,"Hora");$col++;
		$excel->WriteText($row,$col,"Cantidad");$col++;
		$excel->WriteText($row,$col,"Producto");$col++;
		$excel->WriteText($row,$col,"Costo");$col++;
		$excel->WriteText($row,$col,"Precio Unitario");$col++;
		$excel->WriteText($row,$col,"Importe");$col++;
		$excel->WriteText($row,$col,"Ganacia");$col++;

		$row++;
		$col=0;
		
		for($A=7;$A<=22;$A++)
		{
			if($A<=9){$A='0'.$A;}
			$ResDetNota=mysql_query("SELECT * FROM det_nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Hora>='".$_GET["fecha"]." ".$A.":00:00' AND Hora<='".$_GET["fecha"]." ".$A.":59:59' ORDER BY Hora ASC");
			while($RResDetNota=mysql_fetch_array($ResDetNota))
			{
				$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResDetNota["IdProducto"]."' LIMIT 1"));
				$excel->WriteText($row,$col,$A.':00');$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["Cantidad"]);$col++;
				$excel->WriteText($row,$col,$ResProducto["Nombre"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["Costo"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["PrecioUnitario"]);$col++;
				$excel->WriteNumber($row,$col,$RResDetNota["Importe"]);$col++;
				$excel->WriteNumber($row,$col,(($RResDetNota["PrecioUnitario"]-$RResDetNota["Costo"])*$RResDetNota["Cantidad"]));$col++;

				$row++;
				$col=0;
			}
		}
		break;
	case 'resumen':
		
		$excel->WriteText($row,$col,"Cantidad");$col++;
		$excel->WriteText($row,$col,"Clave");$col++;
		$excel->WriteText($row,$col,"Producto");$col++;
		$excel->WriteText($row,$col,"Costo");$col++;
		$excel->WriteText($row,$col,"Precio Unitario");$col++;
		$excel->WriteText($row,$col,"Importe Costo");$col++;
		$excel->WriteText($row,$col,"Importe Venta");$col++;
		$excel->WriteText($row,$col,"Ganacia");$col++;
		
		$row++;
		$col=0;
		
		$ResPartidas=mysql_query("SELECT * FROM det_nota_venta WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND Hora LIKE '".$_GET["fechaconsulta"]."%' ORDER BY Id ASC");
		while($RResPartidas=mysql_fetch_array($ResPartidas))
		{
			$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre FROM productos WHERE Id='".$RResPartidas["IdProducto"]."' LIMIT 1"));
		
			$excel->WriteText($row,$col,$RResPartidas["Cantidad"]);$col++;
			$excel->WriteText($row,$col,$RResPartidas["Clave"]);$col++;
			$excel->WriteText($row,$col,$ResProducto["Nombre"]);$col++;
			$excel->WriteNumber($row,$col,$RResPartidas["Costo"]);$col++;
			$excel->WriteNumber($row,$col,$RResPartidas["PrecioUnitario"]);$col++;
			$excel->WriteNumber($row,$col,($RResPartidas["Costo"]*$RResPartidas["Cantidad"]));$col++;
			$excel->WriteNumber($row,$col,($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"]));$col++;
			$excel->WriteNumber($row,$col,(($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"])-($RResPartidas["Costo"]*$RResPartidas["Cantidad"])));$col++;
		
		$totalimportecosto=$totalimportecosto+($RResPartidas["Costo"]*$RResPartidas["Cantidad"]);
		$totalimporteventa=$totalimporteventa+($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"]);
		$totalganancia=$totalganancia+(($RResPartidas["PrecioUnitario"]*$RResPartidas["Cantidad"])-($RResPartidas["Costo"]*$RResPartidas["Cantidad"]));
		
		$row++;
		$col=0;
		}
		
		$col=5;
		
		$excel->WriteNumber($row,$col,$totalimportecosto);$col++;
		$excel->WriteNumber($row,$col,$totalimporteventa);$col++;
		$excel->WriteNumber($row,$col,$totalganancia);$col++;
		
	  break;
}

//stream Excel for user to download or show on browser
$excel->SendFile();

function fecha($fecha)
{
	switch($fecha[5].$fecha[6])
	{
		case '01':$mes='Enero';break;
		case '02':$mes='Febrero';break;
		case '03':$mes='Marzo';break;
		case '04':$mes='Abril';break;
		case '05':$mes='Mayo';break;
		case '06':$mes='Junio';break;
		case '07':$mes='Julio';break;
		case '08':$mes='Agosto';break;
		case '09':$mes='Septiembre';break;
		case '10':$mes='Octubre';break;
		case '11':$mes='Noviembre';break;
		case '12':$mes='Diciembre';break;
	}
	
	return $fecha[8].$fecha[9].'-'.$mes.'-'.$fecha[0].$fecha[1].$fecha[2].$fecha[3];
}
?>