/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnImprimirCaja", function(){

	var fecha = $(this).attr("fecha");
	console.log("fecha", fecha);

	window.open("extensiones/fpdf/pdf/caja.php?fecha1="+fecha);
				 window.location = "inicio";

})
/*=============================================
IMPRIMIR CAJA  
=============================================*/

$(".tablas").on("click", ".btnSeleccionarCaja", function(){

	var fecha = $(this).attr("fecha");
	console.log("fecha", fecha);

window.location = "index.php?ruta=caja2&fecha1="+fecha;

})
