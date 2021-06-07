/*=============================================
SUBIR ICONO DEL MENU
=============================================*/
$("#subirIconoBlanco").change(function(){

  var iconochicoblanco = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(iconochicoblanco["type"] != "image/jpeg" && iconochicoblanco["type"] != "image/png"){

      $("#subirIconoBlanco").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(iconochicoblanco["size"] > 2000000){

      $("#subirIconoBlanco").val("");

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
      datosImagen.readAsDataURL(iconochicoblanco);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarIconoBlanco").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarIconoBlanco").click(function(){

    var datos = new FormData();
    datos.append("iconochicoblanco", iconochicoblanco);

    $.ajax({

      url:"ajax/empresa.fotos.ajax.php",
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
              text: "¡Actualice la plantilla tocando Ctrl + F5!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
      
        



        }
    
      }

    });

  })

})



/*=============================================
SUBIR ICONO NEGRO
=============================================*/

$("#subirIconoNegro").change(function(){

  var iconochiconegro = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(iconochiconegro["type"] != "image/jpeg" && iconochiconegro["type"] != "image/png"){

      $("#subirIconoNegro").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(iconochiconegro["size"] > 2000000){

      $("#subirIconoNegro").val("");

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
      datosImagen.readAsDataURL(iconochiconegro);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarIconoNegro").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarIconoNegro").click(function(){

    var datos = new FormData();
    datos.append("iconochiconegro", iconochiconegro);

    $.ajax({

      url:"ajax/empresa.fotos.ajax.php",
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
              text: "¡Actualice la plantilla tocando Ctrl + F5!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
      
        }
    
      }

    });

  })

})


/*=============================================
SUBIR LOGO BLANCO BLOQUE
=============================================*/

$("#subirLogoBlancoBloque").change(function(){

  var logoblancobloque = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(logoblancobloque["type"] != "image/jpeg" && logoblancobloque["type"] != "image/png"){

      $("#subirLogoBlancoBloque").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(logoblancobloque["size"] > 2000000){

      $("#subirLogoBlancoBloque").val("");

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
      datosImagen.readAsDataURL(logoblancobloque);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarLogoBlancoBloque").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarLogoBlancoBloque").click(function(){

    var datos = new FormData();
    datos.append("logoblancobloque", logoblancobloque);

    $.ajax({

      url:"ajax/empresa.fotos.ajax.php",
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
              text: "¡Actualice la plantilla tocando Ctrl + F5!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
      
        }
    
      }

    });

  })

})





/*=============================================
SUBIR LOGO BLANCO LINEAL
=============================================*/

$("#subirBlancoLineal").change(function(){

  var logoblancolineal = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(logoblancolineal["type"] != "image/jpeg" && logoblancolineal["type"] != "image/png"){

      $("#subirBlancoLineal").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(logoblancolineal["size"] > 2000000){

      $("#subirBlancoLineal").val("");

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
      datosImagen.readAsDataURL(logoblancolineal);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarBlancoLineal").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarBlancoLineal").click(function(){

    var datos = new FormData();
    datos.append("logoblancolineal", logoblancolineal);

    $.ajax({

      url:"ajax/empresa.fotos.ajax.php",
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
              text: "¡Actualice la plantilla tocando Ctrl + F5!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
        }
    
      }

    });

  })

})

/*=============================================
SUBIR LOGO BLANCO LINEAL
=============================================*/

$("#subirNegroLineal").change(function(){

  var logonegrolineal = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(logonegrolineal["type"] != "image/jpeg" && logonegrolineal["type"] != "image/png"){

      $("#subirNegroLineal").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(logonegrolineal["size"] > 2000000){

      $("#subirNegroLineal").val("");

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
      datosImagen.readAsDataURL(logonegrolineal);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarNegroLineal").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarNegroLineal").click(function(){

    var datos = new FormData();
    datos.append("logonegrolineal", logonegrolineal);

    $.ajax({

      url:"ajax/empresa.fotos.ajax.php",
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
              text: "¡Actualice la plantilla tocando Ctrl + F5!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
        }
    
      }

    });

  })

})


/*=============================================
SUBIR LOGO RECIBO
=============================================*/

$("#subirFotoRecibo").change(function(){

  var fotorecibo = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(fotorecibo["type"] != "image/jpeg" && fotorecibo["type"] != "image/png"){

      $("#subirFotoRecibo").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(fotorecibo["size"] > 2000000){

      $("#subirFotoRecibo").val("");

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
      datosImagen.readAsDataURL(fotorecibo);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarFotoRecibo").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarFotoRecibo").click(function(){

    var datos = new FormData();
    datos.append("fotorecibo", fotorecibo);

    $.ajax({

      url:"ajax/empresa.fotos.ajax.php",
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
              text: "¡Actualice la plantilla tocando Ctrl + F5!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
      
        }
    
      }

    });

  })

})


  /*=============================================
    GUARDAR EL DATOS DE LA EMPRESA
  =============================================*/

    $("#guardarDatosEmpresa").click(function(){

    var datos = new FormData();
    datos.append("editarEmpresa", $("#editarEmpresa").val());
    datos.append("editarDireccion", $("#editarDireccion").val());
    datos.append("editarTelefono", $("#editarTelefono").val());
    datos.append("editarEmail", $("#editarEmail").val());
    datos.append("editarCuit", $("#editarCuit").val());
    datos.append("editarWeb", $("#editarWeb").val());
    datos.append("editarDetalle1", $("#editarDetalle1").val());
    datos.append("editarDetalle2", $("#editarDetalle2").val());
   
    $.ajax({

      url:"ajax/empresa.datos.ajax.php",
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
              text: "¡Los datos han sido actualizados!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){

              if(result.value){

                window.location = "index.php?ruta=miempresa";

              }

           })
      
        }
    
      }

    });

  })