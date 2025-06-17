function mostrar(nombreCapa){ 
document.getElementById(nombreCapa).style.visibility="visible"; 
} 
function ocultar(nombreCapa){ 
document.getElementById(nombreCapa).style.visibility="hidden"; 
} 
function calculo(cantidad,precio,inputtext){
// Calculo del subtotal
subtotal = (precio*cantidad)*1.16;
inputtext.value=subtotal.toFixed(2);
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
//seleccionar todo sumaatelas
function seleccionar_todo_sumaatelas(){ 
if(document.getElementById("allatelas").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaatelas.elements.length;i++) 
          if(document.fsumaatelas.elements[i].type == "checkbox") 
             document.fsumaatelas.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaatelas.elements.length;i++) 
          if(document.fsumaatelas.elements[i].type == "checkbox") 
             document.fsumaatelas.elements[i].checked=0
   }
}
//seleccionar todo adeudo clientes
function seleccionar_todo_sumaaclientes(){ 
if(document.getElementById("allaclientes").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaaclientes.elements.length;i++) 
          if(document.fsumaaclientes.elements[i].type == "checkbox") 
             document.fsumaaclientes.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaaclientes.elements.length;i++) 
          if(document.fsumaaclientes.elements[i].type == "checkbox") 
             document.fsumaaclientes.elements[i].checked=0
   }
}
//seleccionar todo adeudo provedores
function seleccionar_todo_sumaaprovedores(){ 
if(document.getElementById("allaprovedores").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaaprovedores.elements.length;i++) 
          if(document.fsumaaprovedores.elements[i].type == "checkbox") 
             document.fsumaaprovedores.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaaprovedores.elements.length;i++) 
          if(document.fsumaaprovedores.elements[i].type == "checkbox") 
             document.fsumaaprovedores.elements[i].checked=0
   }
}
//seleccionar todo compra telas
function seleccionar_todo_compratelas(){ 
if(document.getElementById("checallacompras").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumacompras.elements.length;i++) 
          if(document.fsumacompras.elements[i].type == "checkbox") 
             document.fsumacompras.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumacompras.elements.length;i++) 
          if(document.fsumacompras.elements[i].type == "checkbox") 
             document.fsumacompras.elements[i].checked=0
   }
}
//seleccionar todo ventas telas
function seleccionar_todo_ventatelas(){ 
if(document.getElementById("checkallaventas").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaventas.elements.length;i++) 
          if(document.fsumaventas.elements[i].type == "checkbox") 
             document.fsumaventas.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaventas.elements.length;i++) 
          if(document.fsumaventas.elements[i].type == "checkbox") 
             document.fsumaventas.elements[i].checked=0
   }
}
//seleccionar todo vicunha
function seleccionar_todo_vicunha(){ 
if(document.getElementById("checkallvicunha").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumatodosvicunha.elements.length;i++) 
          if(document.fsumatodosvicunha.elements[i].type == "checkbox") 
             document.fsumatodosvicunha.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumatodosvicunha.elements.length;i++) 
          if(document.fsumatodosvicunha.elements[i].type == "checkbox") 
             document.fsumatodosvicunha.elements[i].checked=0
   }
}
//seleccionar todo corduroy
function seleccionar_todo_corduroy(){ 
if(document.getElementById("checkallcorduroy").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumatodoscorduroy.elements.length;i++) 
          if(document.fsumatodoscorduroy.elements[i].type == "checkbox") 
             document.fsumatodoscorduroy.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumatodoscorduroy.elements.length;i++) 
          if(document.fsumatodoscorduroy.elements[i].type == "checkbox") 
             document.fsumatodoscorduroy.elements[i].checked=0
   }
}
//seleccionar todo fabricato
function seleccionar_todo_fabricato(){ 
if(document.getElementById("checkallfabricato").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumatodosfabricato.elements.length;i++) 
          if(document.fsumatodosfabricato.elements[i].type == "checkbox") 
             document.fsumatodosfabricato.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumatodosfabricato.elements.length;i++) 
          if(document.fsumatodosfabricato.elements[i].type == "checkbox") 
             document.fsumatodosfabricato.elements[i].checked=0
   }
}
//seleccionar todo premitex
function seleccionar_todo_premitex(){ 
if(document.getElementById("checkallpremitex").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumatodospremitex.elements.length;i++) 
          if(document.fsumatodospremitex.elements[i].type == "checkbox") 
             document.fsumatodospremitex.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumatodospremitex.elements.length;i++) 
          if(document.fsumatodospremitex.elements[i].type == "checkbox") 
             document.fsumatodospremitex.elements[i].checked=0
   }
}
//seleccionar todo acabados
function seleccionar_todo_acabados(){ 
if(document.getElementById("checkallacabados").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumatodosacabados.elements.length;i++) 
          if(document.fsumatodosacabados.elements[i].type == "checkbox") 
             document.fsumatodosacabados.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumatodosacabados.elements.length;i++) 
          if(document.fsumatodosacabados.elements[i].type == "checkbox") 
             document.fsumatodosacabados.elements[i].checked=0
   }
}