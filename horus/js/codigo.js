function mostrar(nombreCapa){ 
document.getElementById(nombreCapa).style.visibility="visible"; 
} 
function ocultar(nombreCapa){ 
document.getElementById(nombreCapa).style.visibility="hidden"; 
} 
function calculo(cantidad,precio,inputtext){
// Calculo del subtotal
subtotal = precio*cantidad;
inputtext.value=subtotal;
}
//convertir a mayusculas
function conMayusculas(field) {  
    fieldfield.value = field.value.toUpperCase()  
}  
//sumar valores
function sumavalores(valor1, valor2, campo)
{
subtotal=valor1+valor2;
campo.value=subtotal;
}
//descuentos
function descuentos(cantidad,precio,descuento1,descuento2,inputtext){
	importe=cantidad*precio;
	subtotal1=importe - (importe*(descuento1/100));
	subtotal2=subtotal1 - (subtotal1*(descuento2/100));
	inputtext.value=subtotal2;
}
//valida formulario agregar cliente
function valida_agregar_cliente(){ 
   	//valido el RFC
	if(document.fadcliente.nombre.value.length==0){
		 alert("Nombre no puede ser un valor vacio") 
     	 document.fadcliente.nombre.focus() 
     	 return 0;
	}
	if(document.fadcliente.direccion.value.length==0){
		alert("Direccion no puede ser un valor vacio") 
    	document.fadcliente.nombre.focus() 
    	return 0;
	}
	if(document.fadcliente.colonia.value.length==0){
		alert("Colonia no puede ser un valor vacio") 
    	document.fadcliente.colonia.focus() 
    	return 0;
	}
	if(document.fadcliente.ciudad.value.length==0){
		alert("Deleg. / Municipio no puede ser un valor vacio") 
    	document.fadcliente.ciudad.focus() 
    	return 0;
	}
	if(document.fadcliente.cp.value.length==0){
		alert("Codigo Postal no puede ser un valor vacio") 
    	document.fadcliente.cp.focus() 
    	return 0;
	}
	if(document.fadcliente.estado.value.length==0){
		alert("Estado no puede ser un valor vacio") 
    	document.fadcliente.estado.focus() 
    	return 0;
	}
	if(document.fadcliente.rfc.value.length<12){ 
      	 alert("El RFC es Incorrecto") 
      	 document.fadcliente.rfc.focus() 
      	 return 0; 
   	}
   	if(!document.fadcliente.rfc.value.match(/[a-zA-Z0-9]/)){
   	 alert('RFC solo letras y numeros');
   	 document.form.nombre.focus();
   	 return 0;
   	 }	
   	

   	//el formulario se envia 
   	//alert("Muchas gracias por enviar el formulario"); 
   	xajax_clientes('0', 'agregar', '2', xajax.getFormValues('fadcliente'));
   	//document.fvalida.submit(); 
} 
//funcion para imprimir el frame
function Imprimir(){
	if (navigator.appName != "Netscape"){
		parent.imprimiendo.focus();
	}
	parent.imprimiendo.print();
}