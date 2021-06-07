/*=============================================
   AGREGAR LAS DELEGACIONES
=============================================*/

$("#btnDelegacionAgregar").click(function(){

	miError = 0;

    if ($("#nombreNuevoDelegacion").val().length<1) {miError=1}
    if ($("#direccionNuevoDelegacion").val().length<1) {miError=1}
    if ($("#localidadNuevoDelegacion").val().length<1) {miError=1}
    if ($("#telefonoNuevoDelegacion").val().length<1) {miError=1}
    if ($("#puntoVentaNuevoDelegacion").val().length<1) {miError=1}
    if ($("#nombreNuevoDelegacion").val()==0) {miError=1}

    if (miError!=1){
    	
    	var datos = new FormData();
	    datos.append("nombreDelegacion", $("#nombreNuevoDelegacion").val());
	    datos.append("direccion", $("#direccionNuevoDelegacion").val());
	    datos.append("localidad", $("#localidadNuevoDelegacion").val());
	    datos.append("telefono", $("#telefonoNuevoDelegacion").val());
	    datos.append("puntodeventa", $("#puntoVentaNuevoDelegacion").val());
	    datos.append("escribano", $('select[name="escribanoNuevoDelegacion"] option:selected').text());
	    datos.append("idescribano", $("#escribanoNuevoDelegacion").val());
	    

	    $.ajax({

	      url:"ajax/delegaciones.ajax.php",
	      method: "POST",
	      data: datos,
	      cache: false,
	      contentType: false,
	      processData: false,
	      success: function(respuesta){

	        swal({
	              title: "Cambios guardados",
	              text: "¡SE HA AGREGADO UNA NUEVA DELEGACION!",
	              type: "success",
	              confirmButtonText: "¡Cerrar!"
	            }).then(function(result){

	              if(result.value){

	                window.location = "index.php?ruta=delegaciones";

	              }

	           })

   
	      }

	    })

	}else{

		swal({
	              title: "No se realizaron los cambios",
	              text: "¡REVISE QUE LOS CAMPOS NO ESTEN VACIOS!",
	              type: "warning",
	              confirmButtonText: "¡Cerrar!"
	            }).then(function(result){

	              if(result.value){
					
					$('#modalAgregarDelegacion').modal('toggle');

	              }

	           })

	}

  })

/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarDelgacion", function(){

	var idDelegacion = $(this).attr("idDelegacion");
	console.log("idDelegacion", idDelegacion);

	var datos = new FormData();
	datos.append("idDelegacion", idDelegacion);

	$.ajax({
		url: "ajax/delegaciones.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

     		console.log("respuesta", respuesta);
     		
     		$("#idEditar").val(respuesta["id"]);
     		$("#nombreEditarDelegacion").val(respuesta["nombre"]);
     		$("#direccionEditarDelegacion").val(respuesta["direccion"]);
			$("#localidadEditarDelegacion").val(respuesta["localidad"]);
			$("#telefonoEditarDelegacion").val(respuesta["telefono"]);
     		$("#puntoVentaEditarDelegacion").val(respuesta["puntodeventa"]);
			
			 $("#escribanoEditarDelegacion option[value='"+ respuesta["idescribano"] +"']").attr("selected",true);
     	}

	})


})

// /*=============================================
//    AGREGAR LAS DELEGACIONES
// =============================================*/

$("#btnDelegacionEditar").click(function(){

	miError = 0;

    if ($("#nombreEditarDelegacion").val().length<1) {miError=1}
    if ($("#direccionEditarDelegacion").val().length<1) {miError=1}
    if ($("#localidadEditarDelegacion").val().length<1) {miError=1}
    if ($("#telefonoEditarDelegacion").val().length<1) {miError=1}
    if ($("#puntoVentaEditarDelegacion").val().length<1) {miError=1}
    if ($("#nombreEditarDelegacion").val()==0) {miError=1}

    if (miError!=1){
    	
    	var datos = new FormData();
	    datos.append("nombreDelegacionEditar", $("#nombreEditarDelegacion").val());
	    datos.append("direccionEditar", $("#direccionEditarDelegacion").val());
	    datos.append("localidadEditar", $("#localidadEditarDelegacion").val());
	    datos.append("telefonoEditar", $("#telefonoEditarDelegacion").val());
	    datos.append("puntodeventaEditar", $("#puntoVentaEditarDelegacion").val());
	    datos.append("escribanoEditar", $('select[name="escribanoEditarDelegacion"] option:selected').text());
	    datos.append("idescribanoEditar", $("#escribanoEditarDelegacion").val());
	    datos.append("idEditar", $("#idEditar").val());

	    $.ajax({

	      url:"ajax/delegaciones.ajax.php",
	      method: "POST",
	      data: datos,
	      cache: false,
	      contentType: false,
	      processData: false,
	      success: function(respuesta){
	      	console.log("respuesta", respuesta);

	        swal({
	              title: "Cambios guardados",
	              text: "¡SE HA EDITADO CORRECTAMENTE",
	              type: "success",
	              confirmButtonText: "¡Cerrar!"
	            }).then(function(result){

	              if(result.value){

	                 window.location = "index.php?ruta=delegaciones";

	              }

	           })

   
	      }

	    })

	}else{

		swal({
	              title: "No se realizaron los cambios",
	              text: "¡REVISE QUE LOS CAMPOS NO ESTEN VACIOS!",
	              type: "warning",
	              confirmButtonText: "¡Cerrar!"
	            }).then(function(result){

	              if(result.value){
					
					$('#modalEditarDelegacion').modal('toggle');

	              }

	           })

	}

  })


/*=============================================
ELIMINAR DELEGACION
=============================================*/
$(".tablas").on("click", ".btnEliminarDelegacion", function(){

	 var idDelegacion = $(this).attr("idDelegacion");
	 console.log("idDelegacion", idDelegacion);

	 swal({
	 	title: '¿Está seguro de borrar la Delegacion?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar delegación!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=delegaciones&idDelegacion="+idDelegacion;

	 	}

	 })

})