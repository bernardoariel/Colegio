$("#guardarEditarVenta").on("click",function(){

  $("#btn-editarVenta").attr('disabled','disabled');
  var idUltimaFactura=0;
  var codigoUltimaFactura=0;

  var datos = new FormData();
  datos.append("idVenta", $('#idVenta').val());
  datos.append("listaProductos", $('#listaProductos').val());
  datos.append("idVendedor", $('#idVendedor').val());
  
  datos.append("seleccionarCliente", $('#seleccionarCliente').val());
  datos.append("documentoCliente", $('#documentoCliente').val());
  datos.append("tipoCliente", $('#tipoCliente').val());
  datos.append("tipoDocumento", $('#tipoDocumento').val());
  
  datos.append("listaMetodoPago", $('#listaMetodoPago').val());
  datos.append("nuevaReferencia", $('#nuevaReferencia').val());
  datos.append("totalVenta", $('#totalVenta').val());
  datos.append("nuevoPrecioImpuesto", $('#nuevoPrecioImpuesto').val());
  datos.append("nuevoPrecioNeto", $('#nuevoPrecioNeto').val());
  datos.append("nuevoTotalVentas", $('#nuevoTotalVentas').val());
  datos.append("tipoCuota", $('#tipoCuota').val());
    
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
          console.log("respuesta", respuesta);
          
          if(respuesta){

                  sinComunicacion="No pudimos comunicarnos con AFIP: Could not connect to host";
                  comprobanteRechazado="El comprobante fue rechazado, controle los datos del cliente.";
                  
                  respuestaCortada=respuesta.substring(0, 2);
                  
                  switch(respuestaCortada) {
                      
                      case 'FE':
                          //tengo que tomar el id de la ultima factura
                           var datos = new FormData();

                            datos.append("ultimoId", 1);
    

                           $.ajax({

                            url:"ajax/ultimoIdVentas.ajax.php",
                              method: "POST",
                              data: datos,
                              cache: false,
                              contentType: false,
                              processData: false,
                             
                              success:function(respuesta){
                                console.log("respuesta", respuesta);
                                window.open("extensiones/fpdf/pdf/facturaElectronica.php?id="+respuesta,"FACTURA",1,2);
                                $('#modalLoader').modal('hide');
                                window.location = "index.php?ruta=inicio&tipo=cuota&idventa="+$('#idVenta').val()+"&idescribano="+$('#seleccionarCliente').val();
                              }

                            })

                          
                          // 
                          break;
                      
                     
                      default:
                          swal({
                          type: "warning",
                          title: "Error",
                          text: respuesta,
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                              if (result.value) {

                              window.location = "cuotas";
                              
                              }
                          })
                  } 
                  
            
                }

          
          
        },timeout: 15000, // sets timeout to 20 seconds  
     error: function(request, status, err){
          
          if(status == "timeout"){
              
              $('#modalLoader').modal('hide');
              
              
              swal({
                        type: "warning",
                        title: 'ERROR',
                        text: "Se el tiempo de respuesta de AFIP",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                            
                            if (result.value) {
                              window.location = "ventas";
                            }

                        })
              
        }else{
            // another error occured  
            alert("error: " + request + status + err);
            swal({
                        type: "warning",
                        title: 'ERROR',
                        text: "Se el tiempo de respuesta de AFIP",
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