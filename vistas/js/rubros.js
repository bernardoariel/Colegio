/*=============================================
EDITAR RUBRO
=============================================*/
$(".tablas").on("click", ".btnEditarRubro", function(){

	var idRubro = $(this).attr("idRubro");

	var datos = new FormData();
	datos.append("idRubro", idRubro);

	$.ajax({
		url: "ajax/rubros.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		console.log("respuesta", respuesta);
     		

     		$("#idRubro").val(respuesta["id"]);
     		$("#editarRubro").val(respuesta["nombre"]);
     		$("#editarObs").val(respuesta["obs"]);

			$("#editarMovimiento option[value="+ respuesta["movimiento"] +"]").attr("selected",true);
			$("#editarMensual option[value="+ respuesta["mensual"] +"]").attr("selected",true);

     	}

	})


})

/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEliminarRubro", function(){

	 var idRubro = $(this).attr("idRubro");
	 console.log("idRubro", idRubro);

	 swal({
	 	title: '¿Está seguro de borrar el rubro?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar Rubro!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=rubros&idRubro="+idRubro;

	 	}

	 })

})