/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarOsde", function(){

	var idOsde = $(this).attr("idOsde");

	var datos = new FormData();
	datos.append("idOsde", idOsde);

	$.ajax({
		url: "ajax/osde.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta", respuesta);
     		
     		$("#editarOsde").val(respuesta["nombre"]);
     		$("#idOsde").val(respuesta["id"]);
			$("#editarImporte").val(respuesta["importe"]);
     	}

	})


})

/*=============================================
ELIMINAR OSDE
=============================================*/
$(".tablas").on("click", ".btnEliminarOsde", function(){

	 var idOsde = $(this).attr("idOsde");
	 console.log("idOsde", idOsde);

	 swal({
	 	title: '¿Está seguro de borrar el Plan de Osde?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar Osde!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=osde&idOsde="+idOsde;

	 	}

	 })

})

/*=============================================
ELIMINAR OSDE
=============================================*/
$("#eliminarOsdes").on("click", function(){

	 

	 swal({
	 	title: '¿Está seguro de borrar Todos los Planes Osde?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar Osde!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=osde&todos=si";

	 	}

	 })

})