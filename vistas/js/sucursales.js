/*=============================================
FECHA EN EL DATAPICKER
=============================================*/
$('#datapicker').datepicker({
     
 }).datepicker("setDate", new Date());

/*=============================================
BUSCADOR POR FECHA
=============================================*/
$("#bsqlClorinda").on("click",function(){
	window.location = "index.php?ruta=clorinda&fecha="+$("#datapicker").val();
})
$("#bsqlColorado").on("click",function(){
	window.location = "index.php?ruta=colorado&fecha="+$("#datapicker").val();
})

/*=============================================
IMPRIMIR LAS VENTAS
=============================================*/
$("#imprimirClorinda").on("click",function(){

	var fecha = $(this).attr("fecha");
	console.log("fecha", fecha);

	window.open("extensiones/fpdf/pdf/cajaclorinda.php?fecha1="+fecha);
	// window.location = "update";

})

$("#imprimirColorado").on("click",function(){

	var fecha = $(this).attr("fecha");
	console.log("fecha", fecha);

	window.open("extensiones/fpdf/pdf/cajacolorado.php?fecha1="+fecha);
	// window.location = "update";

})

/*=============================================
IMPRIMIR FACTURA CLORINDA
=============================================*/

$(".tablas").on("click", ".btnImprimirFacturaClorinda", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	var adeuda = $(this).attr("adeuda");
	var total = $(this).attr("total");
	
	window.open("extensiones/fpdf/pdf/facturaclorinda.php?codigo="+codigoVenta, "_blank");

})

$(".tablas").on("click", ".btnImprimirFacturaColorado", function(){

	var codigoVenta = $(this).attr("codigoVenta");
	var adeuda = $(this).attr("adeuda");
	var total = $(this).attr("total");
	
	window.open("extensiones/fpdf/pdf/facturacolorado.php?codigo="+codigoVenta, "_blank");

})


/*=============================================
BOTON VER  VENTA
=============================================*/

$(".tablas").on("click", ".btnVerVentaClorinda", function(){

	var idVenta = $(this).attr("idVenta");
	console.log("idVenta", idVenta);
	
	var codigo = $(this).attr("codigo");
	$(".finFactura #imprimirItems").remove();

	boton = '<a href="extensiones/tcpdf/pdf/facturaclorinda.php?codigo='+codigo+'" target="_blank" id="imprimirItems"><button type="button" class="btn btn-info pull-left">Imprimir Factura</button></a>';
	
	$(".finFactura").append(boton);
	$(".tablaArticulosVer").empty();
	
	var datos = new FormData();
    datos.append("idVenta", idVenta);

  	$.ajax({

	    url:"ajax/ctacorriente.clorinda.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",

    	success:function(respuesta){
    		
    		console.log("respuesta", respuesta);

  		  	$("#verTotalFc").val(respuesta["total"]);

	      var datos = new FormData();
	      datos.append("idEscribano", respuesta["id_cliente"]);
	     
	      $.ajax({

		        url:"ajax/ctacorriente.clorinda.ajax.php",
		        method: "POST",
		        data: datos,
		        cache: false,
		        contentType: false,
		        processData: false,
		        dataType:"json",

		        success:function(respuesta2){

		          $("#verEscribano").val(respuesta2["nombre"]); //

		        }

	       })

	      var datos = new FormData();
	      datos.append("idVentaArt", idVenta);
	      console.log("idVentaArt", idVenta);

	      $.ajax({

	        url:"ajax/ctacorriente.clorinda.ajax.php",
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
BOTON VER  VENTA
=============================================*/

$(".tablas").on("click", ".btnVerVentaColorado", function(){

	var idVenta = $(this).attr("idVenta");
	console.log("idVenta", idVenta);
	
	var codigo = $(this).attr("codigo");
	$(".finFactura #imprimirItems").remove();

	boton = '<a href="extensiones/tcpdf/pdf/facturacolorado.php?codigo='+codigo+'" target="_blank" id="imprimirItems"><button type="button" class="btn btn-info pull-left">Imprimir Factura</button></a>';
	
	$(".finFactura").append(boton);
	$(".tablaArticulosVer").empty();
	
	var datos = new FormData();
    datos.append("idVenta", idVenta);

  	$.ajax({

	    url:"ajax/ctacorriente.colorado.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",

    	success:function(respuesta){
    		
    		console.log("respuesta", respuesta);

  		  	$("#verTotalFc").val(respuesta["total"]);

	      var datos = new FormData();
	      datos.append("idEscribano", respuesta["id_cliente"]);
	     
	      $.ajax({

		        url:"ajax/ctacorriente.colorado.ajax.php",
		        method: "POST",
		        data: datos,
		        cache: false,
		        contentType: false,
		        processData: false,
		        dataType:"json",

		        success:function(respuesta2){

		          $("#verEscribano").val(respuesta2["nombre"]); //

		        }

	       })

	      var datos = new FormData();
	      datos.append("idVentaArt", idVenta);
	      console.log("idVentaArt", idVenta);

	      $.ajax({

	        url:"ajax/ctacorriente.colorado.ajax.php",
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
