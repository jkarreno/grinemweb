// Documento JavaScript
// Esta funci�n cargar� las paginas
function llamarasincrono(url, id_contenedor){
var pagina_requerida = false
if (window.XMLHttpRequest) {// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest()
} else if (window.ActiveXObject){ // pero si es IE
try {
pagina_requerida = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){ // en caso que sea una versi�n antigua
try{
pagina_requerida = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
pagina_requerida.onreadystatechange=function(){ // funci�n de respuesta
cargarpagina(pagina_requerida, id_contenedor)
}
pagina_requerida.open('GET', url, true) // asignamos los m�todos open y send
pagina_requerida.send(null)
}
// todo es correcto y ha llegado el momento de poner la informaci�n requerida
// en su sitio en la pagina xhtml
function cargarpagina(pagina_requerida, id_contenedor){
if (pagina_requerida.readyState == 4 && (pagina_requerida.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(id_contenedor).innerHTML=pagina_requerida.responseText
}

//funcion para abrir pop-up
function openNewWindow(URLtoOpen, windowName, windowFeatures) { 
	newWindow=window.open(URLtoOpen, windowName, windowFeatures); 
}

function go()
							{
								box = document.forms[0].navi;
								destination = box.options[box.selectedIndex].value;
								if (destination) location.href = destination;
							}

//funcion para ver tranasparentes los png
function PNG_loader() {
   for(var i=0; i<document.images.length; i++) {
      var img = document.images[i];
      var imgName = img.src.toUpperCase();
      if (imgName.substring(imgName.length-3, imgName.length) == "PNG") {
         var imgID = (img.id) ? "id='" + img.id + "' " : "";
         var imgClass = (img.className) ? "class='" + img.className + "' " : "";
         var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
         var imgStyle = "display:inline-block;" + img.style.cssText;
         if (img.align == "left") imgStyle += "float:left;";
         if (img.align == "right") imgStyle += "float:right;";
         if (img.parentElement.href) imgStyle += "cursor:hand;";
         var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>";
         img.outerHTML = strNewHTML;
         i--;
      }
   }
}
window.attachEvent("onload", PNG_loader);

//funcion para mostrar capa//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mostrar(nombreCapa){ 
document.getElementById(nombreCapa).style.visibility="visible"; 
} 
//funcion para ocultar capa//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ocultar(nombreCapa){ 
document.getElementById(nombreCapa).style.visibility="hidden"; 
} 
