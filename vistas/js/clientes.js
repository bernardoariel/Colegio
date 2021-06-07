

/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function(){

	 var idCliente  = $(this).attr("idCliente");
   console.log("idCliente", idCliente);

	  var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

        tipoCuit = '#tipoCuitEditarCliente option[value="'+ respuesta['tipocuit'] +'"]';
        $("#nombreEditarCliente").val(respuesta["nombre"]);
        $("#documentoEditarCliente").val(respuesta["cuit"]);
        $("#direccionEditarCliente").val(respuesta["direccion"]);
        $("#localidadEditarCliente").val(respuesta["localidad"]);
        $("#idClienteEditar").val(respuesta["id"]);
        
        // $("#tipoCuitEditarCliente option:contains('"+ respuesta["tipoiva"] +"')").attr('selected', true);
// console.log("respuesta[\"tipoiva\"]", respuesta["tipoiva"]);
        $("#tipoCuitEditarCliente option[value='"+ respuesta["tipoiva"] +"']").attr("selected",true);
        // $("#editarCategoriaOsde option[value="+ respuesta["id_osde"] +"]").attr("selected",true);

        // $("#editarTipoIva option[value="+ respuesta["id_tipo_iva"] +"]").attr("selected",true);
        
	    }

  	})

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function(){

	var idCliente = $(this).attr("idCliente");
  console.log("idCliente", idCliente);
	
	swal({
        title: '¿Está seguro de borrar este Cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
      }).then(function(result){
        
        if (result.value) {
          
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
        }

  })

})

/*=============================================
HACER FOCO EN EL BUSCADOR CLIENTES
=============================================*/
$('#modalAgregarCliente').on('shown.bs.modal', function () {
    
    $('#nuevoCliente').focus();
   
  
  })

/*=============================================
FACTURA ELECTRONICA
=============================================*/

 $("#btnIngresarClienteNuevo").on("click",function(){

  var datos = new FormData();
  datos.append("idClienteEditar", $("#idClienteEditar").val());
  datos.append("nombreEditarCliente", $("#nombreEditarCliente").val());
  datos.append("documentoEditarCliente", $("#documentoEditarCliente").val());
  datos.append("tipoCuitEditarCliente", $("#tipoCuitEditarCliente").val());
  datos.append("direccionEditarCliente", $("#direccionEditarCliente").val());
  datos.append("localidadEditarCliente", $("#localidadEditarCliente").val());
  

  $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      
      success:function(respuesta){

      }

    })
 })

/*=============================================
GUARDAR CAMBIOS DE LOS CLIENTES
=============================================*/
$("#btnGuardarCambios").on("click",function(){

 
  
if (validarCuit($('#documentoEditarCliente').val())){

               var datos = new FormData();
  datos.append("idClienteEditar", $("#idClienteEditar").val());
  datos.append("nombreEditarCliente", $("#nombreEditarCliente").val());
  datos.append("documentoEditarCliente", $("#documentoEditarCliente").val());
  datos.append("tipoCuitEditarCliente", $("#tipoCuitEditarCliente").val());
  datos.append("direccionEditarCliente", $("#direccionEditarCliente").val());
  datos.append("localidadEditarCliente", $("#localidadEditarCliente").val());  

            $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      
      success:function(respuesta){
        // console.log("respuesta", respuesta);

         window.location = "clientes";
      }

    })


              }else{

                swal("Este cuit no es correcto "+$('#documentoEditarCliente').val(), "Verifique los datos", "warning");

              }
  
 })

