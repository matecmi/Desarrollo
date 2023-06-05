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
  inicio.style.color = "blue";
  tienda.style.color = "#333";
  nosotros.style.color = "#333";
  contacto.style.color = "#333";

}

if (ultimoSegmento=="tienda") {
  inicio.style.color = "#333";
  tienda.style.color = "blue";
  nosotros.style.color = "#333";
  contacto.style.color = "#333";

}

if (ultimoSegmento=="nosotros") {
  inicio.style.color = "#333";
  tienda.style.color = "#333";
  nosotros.style.color = "blue";
  contacto.style.color = "#333";
}

if (ultimoSegmento=="contacto") {
  inicio.style.color = "#333";
  tienda.style.color = "#333";
  nosotros.style.color = "#333";
  contacto.style.color = "blue";

}

});