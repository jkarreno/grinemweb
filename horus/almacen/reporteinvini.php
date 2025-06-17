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

require('../clientes/fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");
include("../funciones.php");

//recibo datos
$cliente=$_POST["cliente"];
$producto=$_POST["producto"];
$fechai=$_POST["annoi"].'-'.$_POST["mesi"].'-'.$_POST["diai"].' 00:00:00';
$fechaf=$_POST["annof"].'-'.$_POST["mesf"].'-'.$_POST["diaf"].' 23:59:59';

//Datos de la sucursal
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage();

//posicion inicial y por pagina
$y_axis_initial = 25;

//Imprimir Datos de la Empresa
$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE ID='".$_SESSION["empresa"]."' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);
//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(10);
$pdf->SetX(8);
$pdf->Cell(120,4,utf8_encode($RResEmpresa["Nombre"]),0,0,'L',1);
//separador
$pdf->Line(8, 14, 200, 14);
//Titulo
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(16);
$pdf->SetX(8);
$pdf->Cell(120,4,'REPORTE DE INVENTARIO INICIAL',0,0,'L',1);
//Producto
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(20);
$pdf->SetX(8);
$pdf->Cell(120,4,$producto,0,0,'L',1);

//separador
$pdf->Line(8, 24, 200, 24);
//posicion inicial y por pagina
$y_axis_initial = 30; $y_axis=34;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(10,4,' ',1,0,'C',1);
$pdf->cell(30,4,'Clave',1,0,'C',1);
$pdf->Cell(100,4,'Producto',1,0,'C',1);
$pdf->Cell(30,4,'Fecha',1,0,'C',1);
$pdf->Cell(20,4,'Cantidad',1,0,'C',1);
$i=1; $j=1;
if($producto=='%'){$ResProductos=mysql_query("SELECT * FROM movinventario WHERE Almacen LIKE '".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_%' AND Producto LIKE '%' AND Descripcion='Inventario Inicial' AND Fecha>'2011-02-01' ORDER BY Fecha ASC, Id ASC");}
elseif($producto!='%'){$ResProductos=mysql_query("SELECT * FROM movinventario WHERE Almacen LIKE '".$_SESSION["empresa"]."_".$_SESSION["sucursal"]."_%' AND Producto='".$producto."' AND Descripcion='Inventario Inicial' AND Fecha>'2011-02-01' ORDER BY Fecha ASC, Id ASC");}
while($RResProductos=mysql_fetch_array($ResProductos))
{
if($j==51)
	{
		$j=1;
		$pdf->AddPage();
		
		//nombre de la empresa
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(10);
		$pdf->SetX(8);
		$pdf->Cell(120,4,utf8_encode($RResEmpresa["Nombre"]),0,0,'L',1);
		//separador
		$pdf->Line(8, 14, 200, 14);
		//Titulo
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(000,000,000);
		$pdf->SetY(16);
		$pdf->SetX(8);
		$pdf->Cell(120,4,'REPORTE DE INVENTARIO INICIAL',0,0,'L',1);
		//separador
		$pdf->Line(8, 24, 200, 24);
		//posicion inicial y por pagina
		$y_axis_initial = 30; $y_axis=34;
		//titulos de las columnas
		$pdf->SetFillColor(000,000,000);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(8);
		$pdf->Cell(10,4,' ',1,0,'C',1);
		$pdf->cell(30,4,'Clave',1,0,'C',1);
		$pdf->Cell(100,4,'Producto',1,0,'C',1);
		$pdf->Cell(30,4,'Fecha',1,0,'C',1);
		$pdf->Cell(20,4,'Cantidad',1,0,'C',1);
	}
	//despliega los productos
	$ResProducto=mysql_fetch_array(mysql_query("SELECT Clave, Nombre FROM productos WHERE Id='".$RResProductos["Producto"]."' LIMIT 1"));
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->SetY($y_axis);
	$pdf->SetX(8);
	$pdf->Cell(10,4,$i,1,0,'C',1);
	$pdf->cell(30,4,$ResProducto["Clave"],1,0,'C',1);
	$pdf->Cell(100,4,$ResProducto["Nombre"],1,0,'L',1);
	$pdf->Cell(30,4,fecha($RResProductos["Fecha"]),1,0,'C',1);
	$pdf->Cell(20,4,$RResProductos["Cantidad"],1,0,'C',1);
	$i++; $j++; $y_axis=$y_axis+4; 
}
//Envio Archivo
$pdf->Output();
?>
