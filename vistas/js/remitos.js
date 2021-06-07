/*=============================================
BOTON VER  VENTA
=============================================*/

$(".tablas").on("click", ".btnVerRemito", function(){

	var idVenta = $(this).attr("idVenta");
	var codigo = $(this).attr("codigo");

	console.log("codigo", codigo);
	
	$(".finFactura #imprimirItems").remove();
	boton = '<a href="extensiones/tcpdf/pdf/remito.php?id='+idVenta+'" target="_blank" id="imprimirItems"><button type="button" class="btn btn-info pull-left">Imprimir Factura</button></a>';
	$(".finFactura").append(boton);
	$(".tablaArticulosVer").empty();
	var datos = new FormData();
    datos.append("idVenta", idVenta);
    

  	$.ajax({

	    url:"ajax/remitos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",

    	success:function(respuesta){
    		console.log("respuesta", respuesta);

  		  $("#verTotalFc").val(respuesta["total"]);

	      $("#verEscribano").val(respuesta["nombre"]); //

	      var datos = new FormData();
	      datos.append("idVentaArt", idVenta);
	      console.log("idVentaArt", idVenta);

	      $.ajax({

	        url:"ajax/remitos.ajax.php",
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

/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirRemito", function(){

	var idVenta = $(this).attr("idVenta");
	var adeuda = $(this).attr("adeuda");
	var total = $(this).attr("total");
	
	window.open("extensiones/tcpdf/pdf/remito.php?id="+idVenta, "_blank");

})