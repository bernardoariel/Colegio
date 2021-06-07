/*=============================================
CARGAR LA TABLA 
=============================================*/
var table = $('.tablaProductos').DataTable({
// 	"ajax":"ajax/datatable-vocabulario.ajax.php",
 dom: 'lBfrtip',/*Bfrtip*/
      buttons: [
        {
          extend: 'colvis',
          columns: ':not(:first-child)',
        }
        ],
    "language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}


})

/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevoRubro").change(function(){

	var idCategoria = $(this).val();
	console.log("idCategoria", idCategoria);

	var datos = new FormData();
  datos.append("idCategoria", idCategoria);

  	$.ajax({

      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      	console.log("respuesta", respuesta);

      	if(!respuesta){

      		var nuevoCodigo = idCategoria+"01";
      		$("#nuevoCodigo").val(nuevoCodigo);

      	}else{

      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);

      	}
                
      }

  	})

})



/*=============================================
EDITAR PRODUCTO
=============================================*/

$(".tablaProductos tbody").on("click", "button.btnEditarProducto", function(){

	var idProducto = $(this).attr("idProducto");
	console.log("idProducto", idProducto);
	
	var datos = new FormData();
    datos.append("idProducto", idProducto);

     $.ajax({
      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
        
        console.log("respuesta", respuesta);

        $("#idProductoEditar").val(respuesta["id"]);
      
        $("#editarRubro option[value="+ respuesta["id_rubro"] +"]").attr("selected",true);

        $("#editarCodigo").val(respuesta["codigo"]);

        $("#editarNombre").val(respuesta["nombre"]);

        $("#editarDescripcion").val(respuesta["descripcion"]);

        $("#editarComprobante option[value="+ respuesta["nrocomprobante"] +"]").attr("selected",true);

        $("#editarCantidadVenta").val(respuesta["cantventa"]);

        $("#editarCantidadMinima").val(respuesta["cantminima"]);

        $("#editarCuota").val(respuesta["cuotas"]);

        $("#editarImporte").val(respuesta["importe"]);

        $("#editarObs").val(respuesta["obs"]);


      }

  })

})

/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function(){

	var idProducto = $(this).attr("idProducto");
	var codigo = $(this).attr("codigo");
	var imagen = $(this).attr("imagen");
	
	swal({

		title: '¿Está seguro de borrar el producto?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar producto!'
        }).then(function(result) {
        if (result.value) {

        	window.location = "index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;

        }


	})

})
	
