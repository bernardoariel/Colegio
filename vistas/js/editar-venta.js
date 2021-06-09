$("#guardarEditarVenta").on("click",function(){

  $("#btn-editarVenta").attr('disabled','disabled');
  var idUltimaFactura=0;
  var codigoUltimaFactura=0;

  var datos = new FormData();
  datos.append("sinHomologacion",1 );
  datos.append("listaProductos", $('#listaProductos').val());
  console.log('listaProductos ', $('#listaProductos').val());
  datos.append("idVendedor", $('#idVendedor').val());
  console.log('idVendedor: ', $('#idVendedor').val());
  
  datos.append("seleccionarCliente", $('#seleccionarCliente').val());
  console.log('seleccionarCliente: ', $('#seleccionarCliente').val());
  
  datos.append("documentoCliente", $('#documentoCliente').val());
  console.log('documentoCliente: ', $('#documentoCliente').val());
  
  datos.append("tipoCliente", $('#tipoCliente').val());
  console.log('tipoCliente: ', $('#tipoCliente').val());
  
  datos.append("tipoDocumento", $('#tipoDocumento').val());
  console.log('tipoDocumento: ', $('#tipoDocumento').val());
  
  datos.append("nombreCliente",$("#nombrecliente").val());
  console.log('nombreCliente: ', $("#nombrecliente").val());
  
  datos.append("listaMetodoPago", $('#listaMetodoPago').val());
  console.log('listaMetodoPago: ', $('#listaMetodoPago').val());
  
  datos.append("nuevaReferencia", $('#nuevaReferencia').val());
  console.log('nuevaReferencia: ', $('#nuevaReferencia').val());
  
  datos.append("totalVenta", $('#totalVenta').val());
  console.log('totalVenta: ', $('#totalVenta').val());
  
  datos.append("nuevoPrecioImpuesto", $('#nuevoPrecioImpuesto').val());
  console.log('nuevoPrecioImpuesto: ', $('#nuevoPrecioImpuesto').val());
  
  datos.append("nuevoPrecioNeto", $('#nuevoPrecioNeto').val());
  console.log('nuevoPrecioNeto: ', $('#nuevoPrecioNeto').val());
  
  datos.append("nuevoTotalVentas", $('#nuevoTotalVentas').val());
  console.log('nuevoTotalVentas: ', $('#nuevoTotalVentas').val());
  
  datos.append("tipoCuota", $('#tipoCuota').val());
  console.log('tipoCuota: ', $('#tipoCuota').val());
  
  datos.append("idVentaNro", $('#idVenta').val());
  console.log('idVentaNro: ', $('#idVenta').val());
  datos.append("tipoFc", $('#tipoFc').val());
  console.log('idVentaNro: ', $('#idVenta').val());
  //CREAMOS LA FACTURA
  $.ajax({
    url:"ajax/crearventa.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
     
    success:function(respuestaSinHomologacion){
      console.log("respuestaSinHomologacion", respuestaSinHomologacion);
        
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
          console.log('respuestaUltimaFactura: ', respuestaUltimaFactura);

          idUltimaFactura=respuestaUltimaFactura["id"];
          codigoUltimaFactura=respuestaUltimaFactura["codigo"];

          window.location = "index.php?ruta=ventas&id="+idUltimaFactura+"&tipo=cuota";
          
        } 

      })
        
    }

  })

 
})
  
