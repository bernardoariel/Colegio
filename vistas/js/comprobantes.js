/*=============================================
EDITAR COMPROBANTE
=============================================*/
$(".tablas").on("click", ".btnEditarComprobante", function(){

	var idComprobante = $(this).attr("idComprobante");
	console.log("idComprobante", idComprobante);

	var datos = new FormData();
	datos.append("idComprobante", idComprobante);

	$.ajax({
		url: "ajax/comprobantes.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		
     	  console.log("respuesta", respuesta);

          $("#idComprobante").val(respuesta["id"]);
     	  $("#editarComprobante").val(respuesta["nombre"]);
          $("#editarNumeroComprobante").val(respuesta["numero"]);
     		
     		
			
     	}

	})

})
/*=============================================
ELIMINAR COMPROBANTE
=============================================*/
$(".tablas").on("click", ".btnEliminarComprobante", function(){

     var idComprobante = $(this).attr("idComprobante");
     console.log("idComprobante", idComprobante);

     swal({
        title: '¿Está seguro de borrar el comprobante?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar comprobante!'
     }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=comprobantes&idComprobante="+idComprobante;

        }

     })

})


/*=============================================
HACER FOCO EN EL NOMBRE DEL COMPROBANTE
=============================================*/
$('#modalEditarComprobante').on('shown.bs.modal', function () {
    
    $('#editarNumeroComprobante').focus();
    $('#editarNumeroComprobante').select();

})