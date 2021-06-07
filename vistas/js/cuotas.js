/*=============================================
BOTON VER  CUOTA
=============================================*/

$(".tablas").on("click", ".btnVerCuota", function(){

	var idCuota = $(this).attr("idCuota");
	var codigo = $(this).attr("codigo");
	
	
	$(".tablaArticulosVer").empty();
	var datos = new FormData();
    datos.append("idCuota", idCuota);

  	$.ajax({

	    url:"ajax/ctacorriente.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",

    	success:function(respuesta){

  		  $("#verTotalFc").val(respuesta["total"]);

	      $("#verEscribano").val(respuesta["nombre"]); //

	      var datos = new FormData();
	      datos.append("idCuotaArt", idCuota);
	    

	      $.ajax({

	        url:"ajax/ctacorriente.ajax.php",
	        method: "POST",
	        data: datos,
	        cache: false,
	        contentType: false,
	        processData: false,
	        dataType:"json",
	        success:function(respuesta3){
	        	console.log("respuesta3", respuesta3);
          
	          	for (var i = 0; i < respuesta3.length; i++) {
		            // console.log("respuesta3", respuesta3[i]['descripcion']);
		            $(".tablaArticulosVer").append('<tr>'+

		                        '<td>'+respuesta3[i]['cantidad']+'</td>'+

		                        '<td>'+respuesta3[i]['descripcion']+'</td>'+

		                        '<td>'+respuesta3[i]['folio1']+'</td>'+

		                        '<td>'+respuesta3[i]['folio2']+'</td>'+

		                        '<td>'+respuesta3[i]['total']+'</td>'+

		                      '</tr>');
	          	
	          	}

        	}

     	  })

	  }

	})
})