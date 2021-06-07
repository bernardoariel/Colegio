/*=============================================
EDITAR LIBRO
=============================================*/
$(".tablas").on("click", ".btnEditarLibro", function(){

	var idEscribano = $(this).attr("idEscribano");
	console.log("idEscribano", idEscribano);

	var datos = new FormData();
	datos.append("idEscribano", idEscribano);

	$.ajax({
		url: "ajax/escribanos.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta", respuesta);

			$("#editarIdEscribano").val(respuesta["id"]);
     		$("#editarNombreEscribano").val(respuesta["nombre"]);
     		$("#editarUltimoLibroComprado").val(respuesta["ultimolibrocomprado"]);
			$("#editarUltimoLibroDevuelto").val(respuesta["ultimolibrodevuelto"]);

     	}

	})


})

/*=============================================
HACER FOCO EN EL NOMBRE DEL COMPROBANTE
=============================================*/
$('#modalEditarLibros').on('shown.bs.modal', function () {
    
    $('#editarUltimoLibroComprado').focus();
    $('#editarUltimoLibroComprado').select();

})

