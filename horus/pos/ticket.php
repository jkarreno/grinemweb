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

include("../conexion.php");


//recibo el id de la nota de venta
if($_POST["idnota"]){$idnota=$_POST["idnota"];}
elseif($_GET["idnota"]){$idnota=$_GET["idnota"];}

//datos de la nota de venta
$ResNota=mysql_fetch_array(mysql_query("SELECT * FROM nota_venta WHERE Id='".$idnota."' AND Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' LIMIT 1"));

//Datos del Emisor 
$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$_SESSION["sucursal"]."' LIMIT 1"));
$ResMatriz=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Empresa='".$_SESSION["empresa"]."' AND Id!='".$_SESSION["sucursal"]."' AND Nombre!='MATANT' ORDER BY Id DESC LIMIT 1"));

//Imprimir Datos de la Empresa
$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE ID='".$_SESSION["empresa"]."' LIMIT 1");
$RResEmpresa=mysql_fetch_array($ResEmpresa);

$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' '.$ResEmisor["NoInterior"];}$dome.=' Col. '.$ResEmisor["Colonia"].' '.$ResEmisor["Estado"].' '.$ResEmisor["Municipio"].' '.$ResEmisor["Pais"].' C.P. '.$ResEmisor["CodPostal"];
$domm=$ResMatriz["Calle"].' No. '.$ResMatriz["NoExterior"];if($ResMatriz["NoInterior"]!=''){$domm.=' '.$ResMatriz["NoInterior"];}$domm.=' Col. '.$ResMatriz["Colonia"].' '.$ResMatriz["Estado"].' '.$ResMatriz["Municipio"].' '.$ResMatriz["Pais"].' C.P. '.$ResMatriz["CodPostal"];
?>
<html>
<head>
<script language="JavaScript" type="text/javascript" src="../js/codigo.js"></script>
<style type="text/css">
<!--
.Nombre {
	font-family: Arial;
	font-size: 16px;
}
.direccion {
	font-family: Arial;
	font-size: 12px;
}
.Gracias {
	font-family: Arial;
	font-size: 14px;
}
.prod {
	font-family: Arial;
	font-size: 12px;
}
generales {
	font-family: Arial;
	font-size: 12px;
}
table {
	text-align: right;
}
.total {
	font-family: Arial;
	font-size: 16px;
}
hr {
height: 0;
border-bottom: 1px dotted #000;
} 
-->
</style>
</head>
<body  onload="javascript:window.print()">
<table border="0" cellpadding="0" width="240">
	<tr>
		<th colspan="2" align="center"><span class="Nombre"><?php echo utf8_encode($RResEmpresa["Nombre"]);?></span><br />
			<span class="direccion"><?php echo $ResEmisor["RFC"];?></span>
	    <hr></th>
	</tr>
	<tr>
		<th  colspan="2" align="center">Fecha: <?php echo $ResNota["Fecha"];?><br />
		Nota de Venta Num.: <?php echo $ResNota["NumNota"];?></span></th>
	</tr>
	<tr>
	  <th colspan="2" align="center"><span>&nbsp;</span></th>
  </tr>
	<tr>
	  <th colspan="2" align="center"><hr></th>
  </tr>
  <tr>
	  <th colspan="2" align="center">Le Atendio: 
	  <?php 
	  	$ResAgente=mysql_fetch_array(mysql_query("SELECT Nombre FROM parametros WHERE Empresa='".$_SESSION["empresa"]."' AND Sucursal='".$_SESSION["sucursal"]."' AND PerteneceA='AgenteV' AND Id='".$ResNota["Agente"]."' LIMIT 1"));
	  	echo $ResAgente["Nombre"];
	  ?></th>
  </tr>
  <tr>
	  <th colspan="2" align="center"><hr></th>
  </tr>

<?php 
	$ResPartidas=mysql_query("SELECT * FROM det_nota_venta WHERE IdNotaVenta='".$idnota."' ORDER BY Id ASC");
	while($RResPartidas=mysql_fetch_array($ResPartidas))
	{
		$ResProducto=mysql_fetch_array(mysql_query("SELECT Nombre, Clave FROM productos WHERE Id='".$RResPartidas["IdProducto"]."' LIMIT 1"));
		echo '<tr>
						<td align="left" class="prod">'.$RResPartidas["Cantidad"].' - '.$ResProducto["Clave"].'<br />'.utf8_encode($ResProducto["Nombre"]).'<br />P. U. $'.$RResPartidas["PrecioUnitario"].'<br />&nbsp;</td>
						<td align="right" class="prod">$ '.number_format($RResPartidas["Importe"], 2).'</td>
					</tr>';
		
		$subtotal=$subtotal+$RResPartidas["Importe"];
	}

?>
	
	<tr>
	<th colspan="2" align="center"><hr></th>
	</tr>
	<tr>
		<td align="rigth"><strong class="total">Total:</strong></td>
		<td align="right" class="total">$<?php echo number_format($subtotal, 2);?></td>
	</tr>
	<tr>
	<th colspan="2" align="center">
	<hr>
	<?php 
		$numero=explode('.', $subtotal);
		$numero2=explode('.', number_format($subtotal,2));
		echo strtoupper(num2letras($numero[0]).' pesos '.$numero2[1].'/100 M. N.');?>
	</th>
	</tr>
	<tr>
		<th colspan="2" align="center"><p><span class="Gracias"><br>
	    Gracias por su Compra</span></p></th>
	</tr>
</table>
</body>
</html>
<?php 
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
} 
?>