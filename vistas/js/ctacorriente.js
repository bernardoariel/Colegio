/*=============================================
EDITAR FACTURA Y VER ARTICULOS
=============================================*/
$(".tablas").on("click", ".btnVerArt", function(){

	 var idVenta = $(this).attr("idVenta");
	 // console.log("idVenta", idVenta);
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

  		$("#verTotalFc").val(respuesta["total"]); //respuesta["id_cliente"]

      var datos = new FormData();
      datos.append("idEscribano", respuesta["id_cliente"]);
      console.log("respuesta[\"id_cliente\"]", respuesta["id_cliente"]);

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
EDITAR FACTURA Y VER ARTICULOS
=============================================*/
$(".tablas").on("click", ".btnRealizarFactura", function(){

   var idVenta = $(this).attr("idVenta");
   console.log("idVenta", idVenta);
   
   $(".tablaArticulosVer2").empty();
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

      $("#verTotalFc2").val(respuesta["total"]); //respuesta["id_cliente"]

      var datos = new FormData();
      datos.append("idEscribano", respuesta["id_cliente"]);
      console.log("respuesta[\"id_cliente\"]", respuesta["id_cliente"]);

      $.ajax({

        url:"ajax/ctacorriente.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",

        success:function(respuesta2){

          $("#verEscribano2").val(respuesta2["nombre"]); //

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
            $(".tablaArticulosVer2").append('<tr>'+

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
REALIZAR PAGO CTA CORRIENTE
=============================================*/
$(".tablas").on("click", ".btnPagarCC", function(){

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

        console.log("respuesta", respuesta);
        $("#idPago").val(respuesta["id"]);
        $("#nuevoPago").val(respuesta["adeuda"]);
        $("#adeuda").val(respuesta["adeuda"]);
  
  }

    })

})

/*=============================================
CUANDO ABRO EL MODAL DE DERECHO DE ESCRITURA
=============================================*/
$('#modalAgregarDerechoEscritura').on('shown.bs.modal', function () {
     
  $("#nuevoPagoDerecho").focus();
  $("#nuevoPagoDerecho").select();
      
     
})

/*=============================================
REALIZAR PAGO CTA CORRIENTE
=============================================*/
$(".tablas").on("click", ".btnDerechoEscritura", function(){

   var idVenta = $(this).attr("idVenta");
   console.log("idVenta", idVenta);
   $('#idPagoDerecho').val(idVenta);

   var datos = new FormData();
   datos.append("idPagoDerecho", idVenta);

   $.ajax({

    url:"ajax/ctacorriente.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",

      success:function(respuesta){

        console.log("respuesta", respuesta);
        
        for (var i = 0; i < respuesta.length; i++) {
            
            if (respuesta[i]['id']==19){

              $("#nuevoPagoDerecho").val(respuesta[i]['total']);

            }else{

               $("#nuevoPagoDerecho").val(0);
               
            }


        }
      }
    })

})