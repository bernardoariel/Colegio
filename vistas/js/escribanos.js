

/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarEscribano", function(){

	 var idEscribano = $(this).attr("idEscribano");
   console.log("idEscribano", idEscribano);

	  var datos = new FormData();
    datos.append("idEscribano", idEscribano);

    $.ajax({

      url:"ajax/escribanos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
        console.log("respuesta", respuesta);

    	  $("#idEscribano").val(respuesta["id"]);
        $("#editarEscribano").val(respuesta["nombre"]);
        $("#editarDocumento").val(respuesta["documento"]);
        $("#editarCuit").val(respuesta["cuit"]);
        $("#editarLocalidad").val(respuesta["localidad"]);
        $("#editarDireccion").val(respuesta["direccion"]);
        $("#editarTelefono").val(respuesta["telefono"]);
        $("#editarEmail").val(respuesta["email"]);

        
        $("#editarCategoriaEscribano option[value="+ respuesta["id_categoria"] +"]").attr("selected",true);
        $("#editarEscribanoRelacionado option[value="+ respuesta["id_escribano_relacionado"] +"]").attr("selected",true);
        $("#editarCategoriaOsde option[value="+ respuesta["id_osde"] +"]").attr("selected",true);

        $("#editarTipoIva option[value="+ respuesta["id_tipo_iva"] +"]").attr("selected",true);
        
	    }

  	})

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarEscribano", function(){

	var idEscribano = $(this).attr("idEscribano");
  console.log("idEscribano", idEscribano);
	
	swal({
        title: '¿Está seguro de borrar el Escribano?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar escribano!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=escribanos&idEscribano="+idEscribano;
        }

  })

})

/*=============================================
HACER FOCO EN EL BUSCADOR CLIENTES
=============================================*/
$('#modalAgregarEscribano').on('shown.bs.modal', function () {
    
    $('#nuevoEscribano').focus();
   
  
  })