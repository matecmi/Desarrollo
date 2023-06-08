var inicio = document.getElementById("linkInicio");
var tienda = document.getElementById("linkTienda");
var nosotros = document.getElementById("linkNosotros");
var contacto = document.getElementById("linkContacto");


$(function () {
  // Obtener el enlace activo según la URL actual

var currentUrl = window.location.href;
var segmentos = currentUrl.split("/");
var ultimoSegmento = segmentos.pop();
console.log(ultimoSegmento);

if (ultimoSegmento=="") {
  inicio.style.color = "#53B8B4";
  tienda.style.color = "#333";
  nosotros.style.color = "#333";
  contacto.style.color = "#333";

}

if (ultimoSegmento=="tienda") {
  inicio.style.color = "#333";
  tienda.style.color = "#53B8B4";
  nosotros.style.color = "#333";
  contacto.style.color = "#333";

}

if (ultimoSegmento=="nosotros") {
  inicio.style.color = "#333";
  tienda.style.color = "#333";
  nosotros.style.color = "#53B8B4";
  contacto.style.color = "#333";
}

if (ultimoSegmento=="contacto") {
  inicio.style.color = "#333";
  tienda.style.color = "#333";
  nosotros.style.color = "#333";
  contacto.style.color = "#53B8B4";

}

});