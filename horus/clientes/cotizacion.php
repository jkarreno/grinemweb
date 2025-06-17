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

require('fpdf/fpdf.php');

//conecto a la base de datos
include("../conexion.php");

//recibo el id de la factura
if($_POST["idcot"]){$idcot=$_POST["idcot"];}
elseif($_GET["idcot"]){$idcot=$_GET["idcot"];}

//datos de la orden
$ResCotizacion=mysql_fetch_array(mysql_query("SELECT * FROM cotizaciones WHERE Id='".$idcot."' LIMIT 1"));

//Datos del Emisor y del Receptor
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResCotizacion["Cliente"]."' LIMIT 1"));
	
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
//RFC del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(8);
$pdf->Cell(120,4,utf8_encode($ResEmisor["RFC"]),0,0,'L',1);
//Domicilio del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(8);
$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' Interior '.$ResEmisor["NoInterior"];}
$pdf->Cell(120,4,$dome,0,0,'L',1);
//Colonia del Emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(8);
$pdf->Cell(120,4,'Col. '.utf8_encode($ResEmisor["Colonia"]),0,0,'L',1);
//Localidad del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(8);
$pdf->Cell(120,4,$ResEmisor["Municipio"].' '.utf8_encode($ResEmisor["Localidad"]).' '.$ResEmisor["Estado"],0,0,'L',1);
//codigo postal y pais del emisor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(8);
$pdf->Cell(120,4,'C. P.: '.$ResEmisor["CodPostal"].' '.$ResEmisor["Pais"],0,0,'L',1);
//Telefonos
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(8);
$telefonos=$ResEmisor["Telefono1"];if($ResEmisor["Telefono2"]!=''){$telefonos.=', '.$ResEmisor["Telefono2"];}
$pdf->Cell(120,4,'Telefonos: '.$telefonos,0,0,'L',1);
//Correo electronico
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(8);
$pdf->Cell(120,4,'Correo Electronico: '.$ResEmisor["CorreoE"],0,0,'L',1);
//DATOS DE LA COTIZACION

//num orden
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(135);
$pdf->Cell(120,4,'Cotizacion Num.: '.$ResCotizacion["NumCotizacion"],0,0,'L',1);
//fecha
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(135);
$pdf->Cell(120,4,'Fecha: '.$ResCotizacion["Fecha"],0,0,'L',1);
//separador
$pdf->Line(8, 42, 200, 42);
//DATOS DEL RECEPTOR
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(8);
$pdf->Cell(8,4,'Cliente: ',0,0,'L',1);
//Nombre
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(44);
$pdf->SetX(25);
$pdf->Cell(8,4,$ResCliente["Nombre"],0,0,'L',1);
//RFC
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(25);
$pdf->Cell(8,4,$ResCliente["RFC"],0,0,'L',1);
//domicilio y colonia
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(52);
$pdf->SetX(25);
$pdf->Cell(8,4,utf8_encode($ResCliente["Direccion"]).' Col. '.utf8_encode($ResCliente["Colonia"]),0,0,'L',1);
//ciudad y estado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(56);
$pdf->SetX(25);
$pdf->Cell(8,4,utf8_encode($ResCliente["Ciudad"]).' '.utf8_encode($ResCliente["Estado"]),0,0,'L',1);
//codigo postal y pais
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(60);
$pdf->SetX(25);
$pdf->Cell(8,4,'C. P.: '.$ResCliente["CP"].' '.utf8_encode($ResCliente["Pais"]),0,0,'L',1);
//Numero de Provedor
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(8);
$pdf->Cell(10,4,'Provedor Num.: '.$ResCliente["NumProvedor"],0,0,'L',1);
//Numero de Pedido
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(80);
$pdf->Cell(10,4,'Pedido Num.: '.$ResCotizacion["NumPedido"],0,0,'L',1);
//separador
$pdf->Line(8, 68, 200, 68);
//Partida de la Orden
//observaciones
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(70);
$pdf->SetX(8);
$pdf->Cell(195,4,'Observaciones: '.$ResCotizacion["Observaciones"],0,0,'L',1);
//Agente
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(8);
$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Id='".$ResCotizacion["Agente"]."' LIMIT 1"));
$pdf->Cell(195,4,'Agente: '.$ResAgente["Nombre"],0,0,'L',1);
//posicion inicial y por pagina
$y_axis_initial = 80; $y_axis=84;
//titulos de las columnas
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(255,255,255);
$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(15,4,'Cantidad',1,0,'C',1);
$pdf->cell(30,4,'Clave',1,0,'C',1);
$pdf->Cell(110,4,'Descripcion',1,0,'C',1);
$pdf->Cell(20,4,'Precio',1,0,'C',1);
$pdf->Cell(20,4,'Importe',1,0,'C',1);

$ResPartidas=mysql_query("SELECT * FROM detcotizaciones WHERE idcotizacion='".$idcot."' ORDER BY Id ASC");
$partidas=1;
while($RResPartidas=mysql_fetch_array($ResPartidas))
{
	$ResProd=mysql_fetch_array(mysql_query("SELECT Clave, Nombre, Unidad, TipoProducto FROM productos WHERE Id='".$RResPartidas["Producto"]."' LIMIT 1"));
	$ResUnidad=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE PerteneceA='unidades' AND Id='".$ResProd["Unidad"]."' LIMIT 1"));
	
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    $pdf->SetY($y_axis);
    $pdf->SetX(8);
    $pdf->Cell(15,4,$RResPartidas["Cantidad"],0,0,'C',1);
    $pdf->Cell(30,4,$RResPartidas["Clave"],0,0,'C',1);
    $ResMarca=mysql_query("SELECT Id FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='tproducto' ORDER BY Id ASC"); 
    $J=1;
    while($RResMarca=mysql_fetch_array($ResMarca))
    {
    	if($RResMarca["Id"]==$ResProd["TipoProducto"]){$numero=$J;}
    	$J++;
    }
    $pdf->Cell(110,4,utf8_encode($ResProd["Nombre"]).' - '.$ResProd["Clave"].' - '.$numero,0,0,'L',1);
    if($ResCotizacion["POS"]=='0')
    {
    $pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"], 2),0,0,'R',1);
    $pdf->Cell(20,4,'$ '.number_format($RResPartidas["Subtotal"], 2),0,0,'R',1);
    }
    elseif($ResCotizacion["POS"]=='1')
    {
    $pdf->Cell(20,4,'$ '.number_format(($RResPartidas["PrecioUnitario"]*1.16), 2),0,0,'R',1);
    $pdf->Cell(20,4,'$ '.number_format(($RResPartidas["Subtotal"]*1.16), 2),0,0,'R',1);	
    }
    $y_axis = $y_axis + 4;
    
    $subtotal=$subtotal+$RResPartidas["Subtotal"];
		
	$partidas++;
}
//partidas en blanco
for($partidas; $partidas<=15; $partidas++)
{
	$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(000,000,000);
    $pdf->SetY($y_axis);
    $pdf->SetX(8);
    $pdf->Cell(15,4,'',0,0,'C',1);
    $pdf->Cell(30,4,'',0,0,'C',1);
    $pdf->Cell(110,4,'',0,0,'L',1);
    $pdf->Cell(20,4,'',0,0,'R',1);
    $pdf->Cell(20,4,'',0,0,'R',1);
    $y_axis = $y_axis + 4;
}

//desplegar subtotal, Iva y total
//desplegar subtotal
if($ResCotizacion["POS"]=='0')
{
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Subtotal: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($subtotal, 2),0,0,'R',1);
$y_axis=$y_axis+4;
}
$iva=$subtotal*0.16;
$total=$subtotal+$iva;
//desplegar numero en letra
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(8);
$numero=explode('.', $total);
$numero2=explode('.',number_format($total,2));
$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' pesos '.$numero2[1].'/100 M. N.'),0,0,'L',1);
//despliega Iva
if($ResCotizacion["POS"]=='0')
{
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Iva: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($iva, 2),0,0,'R',1);
$y_axis=$y_axis+4;
}
//despliega total
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(163);
$pdf->Cell(20,4,'Total: ',0,0,'L',1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(20,4,'$ '.number_format($total, 2),0,0,'R',1);
$y_axis=$y_axis+4;
//Envio Archivo
$pdf->Output();

// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.

function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' uno' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'un'; 
         $subcent = 'os'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'un'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} ?>

