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
//seleccionar todo existencias
function seleccionar_todo_sumaaexistencias(){ 
if(document.getElementById("allexistencias").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaaexistencias.elements.length;i++) 
          if(document.fsumaaexistencias.elements[i].type == "checkbox") 
             document.fsumaaexistencias.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaaexistencias.elements.length;i++) 
          if(document.fsumaaexistencias.elements[i].type == "checkbox") 
             document.fsumaaexistencias.elements[i].checked=0
   }
}
//seleccionar todo sumaaavio
function seleccionar_todo_sumaavios(){ 
if(document.getElementById("allavios").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumavios.elements.length;i++) 
          if(document.fsumavios.elements[i].type == "checkbox") 
             document.fsumavios.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumavios.elements.length;i++) 
          if(document.fsumavios.elements[i].type == "checkbox") 
             document.fsumavios.elements[i].checked=0
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
//seleccionar todo compra avios
function seleccionar_todo_compraavios(){ 
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
//seleccionar todo ventas avios
function seleccionar_todo_ventaavios(){ 
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
//seleccionar todo suma pagos
function seleccionar_todo_sumapagos(){ 
if(document.getElementById("allsumapagos").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumapagos.elements.length;i++) 
          if(document.fsumapagos.elements[i].type == "checkbox") 
             document.fsumapagos.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumapagos.elements.length;i++) 
          if(document.fsumapagos.elements[i].type == "checkbox") 
             document.fsumapagos.elements[i].checked=0
   }
}
//seleccionar todo suma ventas
function seleccionar_todo_sumaventas(){ 
if(document.getElementById("allsumaventas").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaventas.elements.length;i++) 
          if(document.fsumaventas.elements[i].type == "checkbox") 
             document.fsumaventas.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaventas.elements.length;i++) 
          if(document.fsumaventas.elements[i].type == "checkbox") 
             document.fsumaventas.elements[i].checked=0
   }
}
//seleccionar todo suma ventas
function seleccionar_todo_sumapagosp(){ 
if(document.getElementById("allsumapagosp").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumapagos.elements.length;i++) 
          if(document.fsumapagos.elements[i].type == "checkbox") 
             document.fsumapagos.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumapagos.elements.length;i++) 
          if(document.fsumapagos.elements[i].type == "checkbox") 
             document.fsumapagos.elements[i].checked=0
   }
}
//costos
//rendimiento
function costos_rendimiento(cantidad,inputtext){
// Calculo del subtotal
subtotal = 1*cantidad;
inputtext.value=subtotal.toFixed(2);
}
//costo tela
function costos_costo_tela(cantidad, precio, inputtext){
	subtotal=precio*cantidad;
	inputtext.value=subtotal.toFixed(2);
}
//diseño molde
function costos_diseno_molde(cantidad,inputtext){
// Calculo del subtotal
subtotal = 1*cantidad;
inputtext.value=subtotal.toFixed(2);
}
function costos_total_diseno_molde(costounidad, cantidad, total) {
	// Calculo del subtotal
	subtotal = costounidad/cantidad;
	total.value=subtotal.toFixed(2);
}
function costos(costounidad, cantidad, total) {
	subtotal=costounidad*cantidad;
	total.value=subtotal.toFixed(2);
}

//costoprenda
function costo_prenda(total1, total2, total3, total4, total5, total6, total7, total8, total9, total10, total11, total12, total13, total14, total15, total16, total17, total18, total19, total20, total21, total22, total) {
	subtotal=total1+total2+total3+total4+total5+total6+total7+total8+total9+total10+total11+total12+total13+total14+total15+total16+total17+total18+total19+total20+total21+total22;
	total.value=subtotal.toFixed(2);
}

//comision vendedor
function comision_vendedor(costo, porcentaje, total) {
	subtotal=costo*(porcentaje/100);
	total.value=subtotal.toFixed(2);
}

//utilidad
function costo_utilidad(costo, venta, total)
{
	subtotal=venta-costo;
	total.value=subtotal.toFixed(2);
}
function costo_utilidad_real(utilidad, cantidad, total){
	subtotal=utilidad*cantidad;
	total.value=subtotal.toFixed(2);
}
//seleccionar todo suma compras metros
function seleccionar_todo_sumacompras_metros(){ 
if(document.getElementById("allsumacomprasmetros").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumacomprasmetros.elements.length;i++) 
          if(document.fsumacomprasmetros.elements[i].type == "checkbox") 
             document.fsumacomprasmetros.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumacomprasmetros.elements.length;i++) 
          if(document.fsumacomprasmetros.elements[i].type == "checkbox") 
             document.fsumacomprasmetros.elements[i].checked=0
   }
}
//seleccionar todo suma ventas metros
function seleccionar_todo_sumaventas_metros(){ 
if(document.getElementById("allsumaventasmetros").checked==true){ // selecciona todos con visto
       for (i=0;i<document.fsumaventasmetros.elements.length;i++) 
          if(document.fsumaventasmetros.elements[i].type == "checkbox") 
             document.fsumaventasmetros.elements[i].checked=1; 
   }else{ // deselecciona todos
        for (i=0;i<document.fsumaventasmetros.elements.length;i++) 
          if(document.fsumaventasmetros.elements[i].type == "checkbox") 
             document.fsumaventasmetros.elements[i].checked=0
   }
}