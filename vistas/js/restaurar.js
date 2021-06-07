/*=============================================
EDITAR LIBRO
=============================================*/
$(".tablas").on("click", ".btnVerBackupEliminacion", function(){

	var idbackup = $(this).attr("idbackup");
    console.log("idbackup", idbackup);
	

	var datos = new FormData();
	datos.append("idbackup", idbackup);

    $.ajax({
        url: "ajax/parametros.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){
            // console.log("respuesta", respuesta);
            
            $("#idBackUp").val(respuesta["id"]);    
            $("#bkFecha").val(respuesta["fechacreacion"]);
            $("#bkTabla").val(respuesta["tabla"]);
            $("#bkTipo").val(respuesta["tipo"]);
            $("#bkUsuario").val(respuesta["usuario"]);

            var datos = new FormData();
            datos.append("idBackUpArt", idbackup);

            $.ajax({

                url: "ajax/parametros.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType:"json",
                success: function(respuesta2){
                    console.log("respuesta2", respuesta2);
                    $("#verItems").html('');
                    $('#finalFooterRestaurar').html('');
                 
                //comprobantes    
                if(respuesta["tabla"]=="comprobantes"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">nombre</td>'+

                                '<td>'+respuesta2[0]['nombre']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">cabezacomprobante</td>'+

                                '<td>'+respuesta2[0]['cabezacomprobante']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">numero</td>'+

                                '<td>'+respuesta2[0]['numero']+'</td>'+

                              '</tr>');
                

                }

                //escribanos
                if(respuesta["tabla"]=="escribanos"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">nombre</td>'+

                                '<td>'+respuesta2[0]['nombre']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">direccion</td>'+

                                '<td>'+respuesta2[0]['direccion']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">localidad</td>'+

                                '<td>'+respuesta2[0]['localidad']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">telefono</td>'+

                                '<td>'+respuesta2[0]['telefono']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">documento</td>'+

                                '<td>'+respuesta2[0]['documento']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">cuit</td>'+

                                '<td>'+respuesta2[0]['cuit']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">email</td>'+

                                '<td>'+respuesta2[0]['email']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">id_categoria</td>'+

                                '<td>'+respuesta2[0]['id_categoria']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">id_escribano_relacionado</td>'+

                                '<td>'+respuesta2[0]['id_escribano_relacionado']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">id_osde</td>'+

                                '<td>'+respuesta2[0]['id_osde']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">ultimolibrocomprado</td>'+

                                '<td>'+respuesta2[0]['ultimolibrocomprado']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">ultimolibrodevuelto</td>'+

                                '<td>'+respuesta2[0]['ultimolibrodevuelto']+'</td>'+

                              '</tr>');
                

                }    
                    
                if(respuesta["tabla"]=="categorias"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">categoria</td>'+

                                '<td>'+respuesta2[0]['categoria']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">importe</td>'+

                                '<td>'+respuesta2[0]['importe']+'</td>'+

                              '</tr>');
                

                }

                //rubros    
                if(respuesta["tabla"]=="rubros"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">nombre</td>'+

                                '<td>'+respuesta2[0]['nombre']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">movimiento</td>'+

                                '<td>'+respuesta2[0]['movimiento']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">mensual</td>'+

                                '<td>'+respuesta2[0]['mensual']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">obs</td>'+

                                '<td>'+respuesta2[0]['obs']+'</td>'+

                              '</tr>');
                

                }

                 //osde    
                if(respuesta["tabla"]=="osde"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">nombre</td>'+

                                '<td>'+respuesta2[0]['nombre']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">importe</td>'+

                                '<td>'+respuesta2[0]['importe']+'</td>'+

                              '</tr>');
                

                }

                //productos    
                if(respuesta["tabla"]=="productos"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">nombre</td>'+

                                '<td>'+respuesta2[0]['nombre']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">descripcion</td>'+

                                '<td>'+respuesta2[0]['descripcion']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">codigo</td>'+

                                '<td>'+respuesta2[0]['codigo']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">nrocomprobante</td>'+

                                '<td>'+respuesta2[0]['nrocomprobante']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">cantventa</td>'+

                                '<td>'+respuesta2[0]['cantventa']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">id_rubro</td>'+

                                '<td>'+respuesta2[0]['id_rubro']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">cantminima</td>'+

                                '<td>'+respuesta2[0]['cantminima']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">cuotas</td>'+

                                '<td>'+respuesta2[0]['cuotas']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">importe</td>'+

                                '<td>'+respuesta2[0]['importe']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">ultimonrocompra</td>'+

                                '<td>'+respuesta2[0]['ultimonrocompra']+'</td>'+

                              '</tr>');
                

                }

                 //parametros    
                if(respuesta["tabla"]=="parametros"){

                    $("#verItems").append('<tr>'+

                                '<td style="background:#BBB9B9">id</td>'+

                                '<td>'+respuesta2[0]['id']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">parametro</td>'+

                                '<td>'+respuesta2[0]['parametro']+'</td>'+

                                '</tr><tr>'+

                                '<td style="background:#BBB9B9">valor</td>'+

                                '<td>'+respuesta2[0]['valor']+'</td>'+

                              '</tr>');
                

                }
           
                $('#finalFooterRestaurar').append('<button type="button" class="btn btn-danger pull-left" id="eliminarBackUp" idBackUp="'+$("#idBackUp").val()+'">Eliminar Registro</button>'); 
                
                if($("#bkTipo").val()=='ELIMINAR'){

                    $('#finalFooterRestaurar').append('<button type="button" class="btn btn-primary pull-left" id="restaurarBackUp" idBackUpRestaurar="'+$("#idBackUp").val()+'">Restaurar Registro</button>');
                }
                
            }//respuesta
              

            })

          
            
           

        }

    })
	


})

/*=============================================
HACER FOCO EN EL NOMBRE DEL COMPROBANTE
=============================================*/
$('#modalEditarParametro').on('shown.bs.modal', function () {
    
    $('#editarValor').focus();
    $('#editarValor').select();

})

$("#finalFooterRestaurar").on("click", "button#eliminarBackUp", function(){
    var idBackUpEliminar = $(this).attr("idBackUp");
   
    swal({
        title: '¿Está seguro de borrar este Registro DEFINITIVAMENTE?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, Borrar registro!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=restaurar&idBackUpEliminar="+idBackUpEliminar;
        }

  })
})

$("#finalFooterRestaurar").on("click", "button#restaurarBackUp", function(){
    

    var idBackUpRestaurar = $(this).attr("idBackUpRestaurar");
    
   
    swal({
        title: '¿Está seguro de RESTAURAR este Registro?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, Restaurar registro!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=restaurar&idBackUpRestaurar="+idBackUpRestaurar;
            
        }

  })
      
})

