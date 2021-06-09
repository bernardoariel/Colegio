/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if(localStorage.getItem("capturarRango") != null){

	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));


}else{

	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}
/*=============================================
IMPRIMIR LA FACTURA
=============================================*/
$(".btnImprimirPdfSH").on("click",function(){

	let idFactura = $(this).attr("idFactura");
	/* window.open("extensiones/tcpdf/pdf/factura.php?id="+idFactura, "FACTURA",1,2); */
	window.open("extensiones/tcpdf/pdf/factura.php?id="+idFactura, "FACTURA",1);
	
})

/*=============================================
ACTIVAR LOS BOTONES CON LOS ID CORRESPONDIENTES
=============================================*/

$(".tablaVentas tbody").on( 'click', 'button.agregarProducto', function () {

	var data = table2.row( $(this).parents('tr') ).data();

	$(this).attr("idProducto",data[5]);

})

/*=============================================
FUNCIÓN PARA CARGAR LAS IMÁGENES CON EL PAGINADOR Y EL FILTRO
=============================================*/

function cargarImagenesProductos(){

	 var imgTabla = $(".imgTablaVenta");

	 var limiteStock = $(".limiteStock");

	 for(var i = 0; i < imgTabla.length; i ++){

	    var data = table2.row( $(imgTabla[i]).parents('tr') ).data();
	    
	    $(imgTabla[i]).attr("src",data[1]);

	    if(data[4] <= 10){

	    	$(limiteStock[i]).addClass("btn-danger");
	    	$(limiteStock[i]).html(data[4]);

	    }else if(data[4] > 11 && data[4] <= 15){

	    	$(limiteStock[i]).addClass("btn-warning");
	    	$(limiteStock[i]).html(data[4]);
	    
	    }else{

	    	$(limiteStock[i]).addClass("btn-success");
	    	$(limiteStock[i]).html(data[4]);
	    }

  	}


}

setTimeout(function(){

  cargarImagenesProductos()

},300);

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL PAGINADOR
=============================================*/

$(".dataTables_paginate").click(function(){

	cargarImagenesProductos()
})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL BUSCADOR
=============================================*/
$("input[aria-controls='DataTables_Table_0']").focus(function(){

	$(document).keyup(function(event){

		event.preventDefault();

		cargarImagenesProductos()

	})


})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL FILTRO DE CANTIDAD
=============================================*/

$("select[name='DataTables_Table_0_length']").change(function(){

	cargarImagenesProductos()

})

/*=============================================
CARGAMOS LAS IMÁGENES CUANDO INTERACTUAMOS CON EL FILTRO DE ORDENAR
=============================================*/

$(".sorting").click(function(){

	cargarImagenesProductos()

})

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaVentas tbody").on("click", "button.agregarProducto", function(){

	var idProducto = $(this).attr("idProducto");

	$(this).removeClass("btn-primary agregarProducto");

	$(this).addClass("btn-default");

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

      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stock"];
          	var precio = respuesta["precio_venta"];

          	$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>') 

	        // SUMAR TOTAL DE PRECIOS

	        sumarTotalPrecios()

	        // AGREGAR IMPUESTO

	        agregarImpuesto()

	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);

      	}

     })

});

/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

$(".formularioVenta").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();

	var idProducto = $(this).attr("idProducto");

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

	if($(".nuevoProducto").children().length == 0){

		$("#nuevoImpuestoVenta").val(0);
		$("#nuevoTotalVenta").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalVenta").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPrecios()

    	// AGREGAR IMPUESTO
	        
        agregarImpuesto()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()

	}

})

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

$(".btnAgregarProducto").click(function(){

	var datos = new FormData();
	datos.append("traerProductos", "ok");

	$.ajax({

		url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    	$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionProducto" idProducto name="nuevaDescripcionProducto" required>'+

	              '<option>Seleccione el producto</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3 ingresoCantidad">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');


	        // AGREGAR LOS PRODUCTOS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	$(".nuevaDescripcionProducto").append(

					'<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
	         	)

	         }

	         // SUMAR TOTAL DE PRECIOS

    		sumarTotalPrecios()

    		// AGREGAR IMPUESTO
	        
	        agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);

      	}


	})

})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function(){

	var nombreProducto = $(this).val();

	var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");

	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");

	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);


	  $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

  	      // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

      	}

      })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function(){

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioFinal = $(this).val() * precio.attr("precioReal");
	
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	if(Number($(this).val()) > Number($(this).attr("stock"))){

		$(this).val(1);

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR IMPUESTO
	        
    agregarImpuesto()

    // AGRUPAR PRODUCTOS EN FORMATO JSON

    listarProductos()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){

	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	$("#totalVenta").val(sumaTotalPrecio);
	$("#nuevoTotalVenta").attr("total",sumaTotalPrecio);


}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto(){

	var impuesto = $("#nuevoImpuestoVenta").val();
	var precioTotal = $("#nuevoTotalVenta").attr("total");

	var precioImpuesto = Number(precioTotal * impuesto/100);

	var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);
	
	$("#nuevoTotalVenta").val(totalConImpuesto);

	$("#totalVenta").val(totalConImpuesto);

	$("#nuevoPrecioImpuesto").val(precioImpuesto);

	$("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function(){

	agregarImpuesto();

});

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val();

	if(metodo == "Efectivo"){

		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			 '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+ 

			 		'<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>'+

			 	'</div>'+

			 '</div>'+

			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+

			 	'</div>'+

			 '</div>'

		 )

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);


      	// Listar método en la entrada
      	listarMetodos()

	}else{

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>')

	}

	

})

/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function(){

	var efectivo = $(this).val();

	var cambio =  Number(efectivo) - Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(cambio);

})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioVenta").on("change", "input#nuevoCodigoTransaccion", function(){

	// Listar método en la entrada
     listarMetodos()


})


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".nuevaCantidadProducto");

	var precio = $(".nuevoPrecioProducto");

	for(var i = 0; i < descripcion.length; i++){

		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}

	$("#listaProductos").val(JSON.stringify(listaProductos)); 

}

/*=============================================
LISTAR MÉTODO DE PAGO
=============================================*/

function listarMetodos(){

	var listaMetodos = "";

	if($("#nuevoMetodoPago").val() == "Efectivo"){

		$("#listaMetodoPago").val("Efectivo");

	}else{

		$("#listaMetodoPago").val($("#nuevoMetodoPago").val()+"-"+$("#nuevoCodigoTransaccion").val());

	}

}

/*=============================================
BOTON EDITAR VENTA
=============================================*/

$(".tablas").on("click", ".btnEditarVenta", function(){


	var idVenta = $(this).attr("idVenta");
	console.log("idVenta", idVenta);

	window.location = "index.php?ruta=editar-venta&idVenta="+idVenta;


})


/*=============================================
BOTON VER  VENTA
=============================================*/

$(".tablas").on("click", ".btnVerVenta", function(){

	var idVenta = $(this).attr("idVenta");
	var codigo = $(this).attr("codigo");
	console.log("codigo", codigo);
	$(".finFactura #imprimirItems").remove();
	boton = '<a href="extensiones/tcpdf/pdf/factura.php?id='+idVenta+'" target="_blank" id="imprimirItems"><button type="button" class="btn btn-info pull-left">Imprimir Factura</button></a>';
	$(".finFactura").append(boton);
	$(".tablaArticulosVer").empty();
	var datos = new FormData();
    datos.append("idVenta", idVenta);

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
	      datos.append("idVentaArt", idVenta);
	      console.log("idVentaArt", idVenta);

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
/*=============================================
BOTON PARA HOMOLOGAR LA AFIP
=============================================*/

$(".tablas").on("click", ".btnHomologarAfip", function(){


	var idVenta = $(this).attr("idVenta");
	var nombrehomologacion = $(this).attr("nombrehomologacion");

	$("#btnHomologacion").attr( "idFcHomologar", idVenta );
	$(".tablaArticulosVerHomologacion").empty();
	var datos = new FormData();
    datos.append("idVenta", idVenta);
    

  	$.ajax({

	    url:"ajax/ctacorriente.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",

    	success:function(respuesta){

  		  $("#idVentaHomologacion").val(respuesta["id"]);
  		  $("#verTotalFcHomologacion").val(respuesta["total"]);
  		   $("#verEscribanoHomologacion").val(nombrehomologacion); //
	      
	      var datos = new FormData();
	      datos.append("idVentaArt", idVenta);
	      console.log("idVentaArt", idVenta);

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
		            $(".tablaArticulosVerHomologacion").append('<tr>'+

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
$(".tablas").on("click", ".btnVerVenta-Eliminar", function(){

	var idVenta = $(this).attr("idVenta");
	console.log("idVenta", idVenta);
	var codigo = $(this).attr("codigo");
	
	$(".finFactura #eliminarFactura").remove();
	boton = '<a href="index.php?ruta=ventas&idVenta='+idVenta+'" id="eliminarFactura"><button type="button" class="btn btn-danger pull-left">Eliminar Factura</button></a>';
	$(".finFactura").append(boton);
	$(".tablaArticulosVer").empty();
	var datos = new FormData();
    datos.append("idVenta", idVenta);

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

	      var datos = new FormData();
	      datos.append("idEscribano", respuesta["id_cliente"]);
	     
	      $.ajax({

		        url:"ajax/ctacorriente.ajax.php",
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

	        url:"ajax/ctacorriente.ajax.php",
	        method: "POST",
	        data: datos,
	        cache: false,
	        contentType: false,
	        processData: false,
	        dataType:"json",
	        success:function(respuesta3){
          
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
BORRAR VENTA
=============================================*/

$(".tablas").on("click", ".btnEliminarVenta", function(){

  var idVenta = $(this).attr("idVenta");

  swal({
        title: '¿Está seguro de borrar la venta?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar venta!'
      }).then(function(result) {
        if (result.value) {
          
            window.location = "index.php?ruta=ventas&idVenta="+idVenta;
        }

  })

})

/*=============================================
BORRAR VENTA
=============================================*/

$(".tablas").on("click", ".btnEliminarPago", function(){

  var idVenta = $(this).attr("idVenta");

  swal({
        title: '¿Está seguro de cancelar el pago?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar venta!'
      }).then(function(result) {
        if (result.value) {
          
            window.location = "index.php?ruta=ventas&idPago="+idVenta;
        }

  })

})



/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFactura", function(){

	var idVenta = $(this).attr("idVenta");
	var adeuda = $(this).attr("adeuda");
	var total = $(this).attr("total");
	
	window.open("extensiones/fpdf/pdf/facturaElectronica.php?id="+idVenta, "_blank");

})

/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFacturaSinHomolgar", function(){

	var idVenta = $(this).attr("idVenta");
	
	
	window.open("extensiones/tcpdf/pdf/factura.php?id="+idVenta, "_blank");

})


/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');

    var capturarRango = $("#daterange-btn span").html();
   
   	localStorage.setItem("capturarRango", capturarRango);

   	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "ventas";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){


	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		if(mes < 10){

			var fechaInicial = año+"-0"+mes+"-"+dia;

    		var fechaFinal = año+"-0"+mes+"-"+dia;

		}else if(dia < 10){

			var fechaInicial = año+"-"+mes+"-0"+dia;

    		var fechaFinal = año+"-"+mes+"-0"+dia;


		}else if(mes < 10 && dia < 10){

			var fechaInicial = año+"-0"+mes+"-0"+dia;

    		var fechaFinal = año+"-0"+mes+"-0"+dia;

		}else{

			var fechaInicial = año+"-"+mes+"-"+dia;

    		var fechaFinal = año+"-"+mes+"-"+dia;

		}

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})



/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarPago", function(){

	 var idVenta = $(this).attr("idVenta");
	 console.log("idVenta", idVenta);

	 var datos = new FormData();
     datos.append("idVenta", idVenta);

    $.ajax({

      url:"ajax/ctacorriente.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",

      success:function(respuesta){

        // console.log("respuesta", respuesta);
		$("#idVentaPago").val(respuesta["id"]);

		$("#totalVentaPago").val(respuesta["total"]);
		
		// $("#nuevoPago").val(respuesta["adeuda"]);
		// $("#adeuda").val(respuesta["adeuda"]);
		
	
	}

  	})

})
/*=============================================
BUSCO EL NRO DE SERIE
=============================================*/
$("#btn-bsqnrofc").on("click", function(){

	window.location = "index.php?ruta=buscar-venta-nro&nrofc="+$("#bsqnrofc").val();
})

/*=============================================
BUSCO EL HISTORIAL POR CLIENTE
=============================================*/
$("#btn-bsqVentaCliente").on("click", function(){


	window.location = "index.php?ruta=buscar-venta-cliente&idCliente="+$("#clientes").val();
})

/*=============================================
BUSCO EL HISTORIAL POR ARTICULO
=============================================*/
$("#btn-bsqVentaProducto").on("click", function(){


	window.location = "index.php?ruta=buscar-venta-repuestos&idProducto="+$("#productos").val();
})

$("#btnHomologacion").on("click",function(){
  
  var idVentaHomologacion = $(this).attr("idfchomologar");

  var datos = new FormData();
  datos.append("idVentaHomologacion", idVentaHomologacion);
  
   
  	$.ajax({

        url:"ajax/crearventa.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $('#modalLoader').modal('show');
        },
        success:function(respuesta){
        	console.log("respuesta1", respuesta);
        	
        	respuestaCortada=respuesta.substring(0, 2);
        	console.log("respuestaCortada", respuestaCortada);
        	
        	switch(respuestaCortada) {

        		case 'FE':

        			$('#modalLoader').modal('hide');
                    window.open("extensiones/fpdf/pdf/facturaElectronica.php?id="+idVentaHomologacion, "_blank");
                    window.location = "ventas";
                    break;

                case 'ER':

        			$('#modalLoader').modal('hide');
                    swal({
                        type: "warning",
                        title: "ERROR",
                        text: respuesta,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                            
                            if (result.value) {
                            	window.location = "ventas";
                            }

                        });
                       break;

        		default:
                    swal({
                        type: "warning",
                        title: 'Posiblemente falla en la conexion',
                        text: "INDEFINIDO",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                            
                            if (result.value) {
                            	window.location = "ventas";
                            }

                        })
        			}
        }

	  })


                    
       
})

/*=============================================
NOTA DE CREDITO
=============================================*/

$(".tablas").on("click", ".btnImprimirNC", function(){

	var idVenta = $(this).attr("idVenta");
	var codigo = $(this).attr("codigoventa");

	var datos = new FormData();
    datos.append("idVenta", idVenta);

  	$.ajax({

	    url:"ajax/ctacorriente.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",

    	success:function(respuesta){

    		$("#idClienteNc").val(respuesta["id_cliente"]);
    		$("#nombreClienteNc").val(respuesta["nombre"]);
    		$("#documentoNc").val(respuesta["documento"]);
    		$("#tablaNc").val(respuesta["tabla"]);
    		$("#productosNc").val(respuesta["productos"]);
    		$("#totalNc").val(respuesta["total"]);
			$("#idVentaNc").val(idVenta);
			$("#nroFactura").val(codigo);
    		$(".tablaArticulosVerNc").empty();
	        
	        var datos = new FormData();
	      	datos.append("idVentaArt", idVenta);
	      

	      $.ajax({

	        url:"ajax/ctacorriente.ajax.php",
	        method: "POST",
	        data: datos,
	        cache: false,
	        contentType: false,
	        processData: false,
	        dataType:"json",
	        success:function(respuesta3){
          
	          	for (var i = 0; i < respuesta3.length; i++) {
		            // console.log("respuesta3", respuesta3[i]['descripcion']);
		            $(".tablaArticulosVerNc").append('<tr>'+

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


$("#realizarNc").click(function(){

	$('#modalLoader').modal('show');
	var datos = new FormData();
    datos.append("idVenta", $("#idVentaNc").val());
    datos.append("idClienteNc", $("#idClienteNc").val());
    datos.append("nombreClienteNc", $("#nombreClienteNc").val());
    datos.append("documentoNc", $("#documentoNc").val());
    datos.append("tablaNc", $("#tablaNc").val());
    datos.append("productosNc", $("#productosNc").val());
    datos.append("totalNc", $("#totalNc").val());
    datos.append("nroFactura", $("#nroFactura").val());	
    

  	$.ajax({

	    url:"ajax/nota_credito.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    // dataType:"json",

    	success:function(respuesta){
    	console.log('respuesta: ', respuesta);

	
    		switch(respuesta) {
	            // FACTURA ELECTRONICA
	            case 'FE':
	                ultimaFactura = 'ultimaFactura';
	                var datos = new FormData();
	                datos.append("ultimaFactura",ultimaFactura);
	                
	                $.ajax({

	                  url:"ajax/crearventa.ajax.php",
	                  method: "POST",
	                  data: datos,
	                  cache: false,
	                  contentType: false,
	                  processData: false,
	                  dataType:"json",
	                  success:function(respuestaUltimaFactura){
	                    
	                    idUltimaFactura=respuestaUltimaFactura["id"];
	                    codigoUltimaFactura=respuestaUltimaFactura["codigo"];
	                    
	                    window.open("extensiones/fpdf/pdf/facturaElectronica.php?id="+idUltimaFactura ,"FACTURA",1,2);
	                    $('#modalLoader').modal('hide');
	                    window.location = "ventas";

	                  }

	                })

	            break;
              
                default:
                       comprobanteRechazado="El comprobante fue rechazado, controle los datos del cliente.";
                       swal({
                        type: "warning",
                        title: comprobanteRechazado,
                        text: "Compruebe los datos , o Su conexion",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){

                            if (result.value) {

                            window.location = "ventas";
                            
                            }
                        })

                    
                      
                  } 
                 
          
        }
    	
    })
})