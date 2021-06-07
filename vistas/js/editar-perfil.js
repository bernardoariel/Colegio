/*=============================================
SUBIR ICONO DEL MENU
=============================================*/
$("#subirMiFoto").change(function(){

  var miFotoPerfil = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(miFotoPerfil["type"] != "image/jpeg" && miFotoPerfil["type"] != "image/png"){

      $("#subirMiFoto").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(miFotoPerfil["size"] > 2000000){

      $("#subirMiFoto").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(miFotoPerfil);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarMiFoto").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR MIFOTO
    =============================================*/

    $("#guardarMiFoto").click(function(){

    var datos = new FormData();
    datos.append("miFotoPerfil", miFotoPerfil);
    datos.append("idUsuario", $("#idUsuario").val());
    datos.append("carpeta", $("#carpeta").val());
    datos.append("foto", $("#foto").val());
    


    $.ajax({

      url:"ajax/cambioperfil.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

        console.log("respuesta", respuesta);
      
        if(respuesta == "ok"){
          
          swal({
              title: "Cambios guardados",
              text: "¡ACTUALIZADO MI PERFIL DEBERA VOLVER A INGRESAR",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=salir";

              }

           })
      
        



        }
    
      }

    });

  })

})


/*=============================================
    GUARDAR MIFOTO
 =============================================*/

$("#guardarMiPass").click(function(){

    var datos = new FormData();
    datos.append("miPass", $("#nuevoPassword").val());
    datos.append("idUsuario2", $("#idUsuario").val());
    


    $.ajax({

      url:"ajax/cambioperfil.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

        console.log("respuesta", respuesta);
      
        if(respuesta == "ok"){
          
          swal({
              title: "Cambios guardados",
              text: "¡ACTUALIZADO MI PERFIL DEBERA VOLVER A INGRESAR",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=salir";

              }

           })
      
        



        }
    
      }

    });

  })

