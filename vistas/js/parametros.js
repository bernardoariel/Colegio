/*=============================================
EDITAR LIBRO
=============================================*/
$(".tablas").on("click", ".btnEditarParametros", function(){

	var idParametro = $(this).attr("idParametro");
	console.log("idParametro", idParametro);

	var datos = new FormData();
	datos.append("idParametro", idParametro);

	$.ajax({
		url: "ajax/parametros.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta", respuesta);

            if(respuesta["id"]==1){
                $("#lbNombre").html('CANTIDAD MAXIMA DE DIAS DE ATRASO');
            }else{
                $("#lbNombre").html('CANTIDAD MAXIMA DE LIBROS');
            }
			$("#editarId").val(respuesta["id"]);
     		$("#editarValor").val(respuesta["valor"]);
   //   		$("#editarUltimoLibroComprado").val(respuesta["ultimolibrocomprado"]);
			// $("#editarUltimoLibroDevuelto").val(respuesta["ultimolibrodevuelto"]);

     	}

	})


})

/*=============================================
HACER FOCO EN EL NOMBRE DEL COMPROBANTE
=============================================*/
$('#modalEditarParametro').on('shown.bs.modal', function () {
    
    $('#editarValor').focus();
    $('#editarValor').select();

})

