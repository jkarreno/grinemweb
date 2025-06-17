<?php
function fecha($fecha)
{
	switch($fecha[5].$fecha[6])
	{
		case '01'; $mes='Ene'; break;
		case '02'; $mes='Feb'; break;
		case '03'; $mes='Mar'; break;
		case '04'; $mes='Abr'; break;
		case '05'; $mes='May'; break;
		case '06'; $mes='Jun'; break;
		case '07'; $mes='Jul'; break;
		case '08'; $mes='Ago'; break;
		case '09'; $mes='Sep'; break;
		case '10'; $mes='Oct'; break;
		case '11'; $mes='Nov'; break;
		case '12'; $mes='Dic'; break;
	}
	
	$fechanew=$fecha[8].$fecha[9].' - '.$mes.' - '.$fecha[0].$fecha[1].$fecha[2].$fecha[3];
	
	return $fechanew;
}
function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
?>