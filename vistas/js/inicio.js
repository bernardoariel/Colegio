$(document).ready(function() {
  // INICIO LOS COMPROBANTES
  var pathname = window.location.pathname;
  
  
  if(pathname =="/colegio/iniciosinconexion"){

    if(navigator.onLine) {
    // el navegador está conectado a la red
      window.location = "inicio";
    } else {
        // el navegador NO está conectado a la red
      $('#modalMostar #titulo').html("ERROR DE CONEXION");
      $('#modalMostar #mostrarBody').html("<center><img src='vistas/img/plantilla/desconectado.jpg'><h3>SIN CONEXION</h3><h4>Funciones reducidas</h4></center>");
      $("#modalMostar #cabezaLoader").css("background", "#ffbb33");
      $("#mostrarSalir").removeClass("btn-danger");
      $("#mostrarSalir").addClass("btn-warning");
      $('#modalMostar').modal('show');
    }

    

  }

})
/*=============================================
CARGAR LA TABLA 
=============================================*/

$("#upInhabilitados").click(function() {

  var datos = new FormData();
  datos.append("upInhabilitados", "1");

  $.ajax({

      url:"ajax/updateInhabilitados.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function(){
        $("#cabezaLoader").css("background", "#ffbb33");
        $('#actualizacionparrafo').html("<strong>ACTUALIZANDO LOS INHABILITADOS</strong>");
        $('#modalLoader').modal('show');
      },
      
      success:function(respuesta){
       $('#modalLoader').modal('hide');
      }

    })

})

$("#btnMostrarInhabilitados").click(function() {

  var datos = new FormData();
  datos.append("mostrarInhabilitados", "1");

  $.ajax({

      url:"ajax/updateInhabilitados.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success:function(respuesta){
        $('#modalMostar #titulo').html("ESCRIBANOS INHABILITADOS");
        $('#modalMostar #mostrarBody').html(respuesta);
        $("#modalMostar #cabezaLoader").css("background", "#ffbb33");
        $("#mostrarSalir").removeClass("btn-danger");
        $("#mostrarSalir").addClass("btn-warning");
        $('#modalMostar').modal('show');
       
      }

    })

})

$("#upProductos").click(function() {

  var datos = new FormData();
  datos.append("updateProductos", "1");

  $.ajax({

      url:"ajax/updateProductos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function(){
        $("#cabezaLoader").css("background", "#ff4444");
        $('#actualizacionparrafo').html("<strong>ACTUALIZANDO LOS PRODUCTOS</strong>");
        $('#modalLoader').modal('show');
      },
      
      success:function(respuesta){
       $('#modalLoader').modal('hide');
      }

    })

})

$("#btnMostrarProductos").click(function() {

  var datos = new FormData();
  datos.append("mostrarProductos", "1");

  $.ajax({

      url:"ajax/updateProductos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success:function(respuesta){
        $('#modalMostar #titulo').html("PRODUCTOS");
        $('#modalMostar #mostrarBody').html(respuesta);
        $("#modalMostar #cabezaLoader").css("background", "#ff4444");
        $("#mostrarSalir").removeClass("btn-danger");
        $("#mostrarSalir").addClass("btn-danger");
        $('#modalMostar').modal('show');
       
      }

    })

})

$("#upEscribanos").click(function() {

  var datos = new FormData();
  datos.append("upEscribanos", "1");

  $.ajax({

      url:"ajax/updateEscribanos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function(){
        $("#cabezaLoader").css("background", "#00C851");
        $('#actualizacionparrafo').html("<strong>ACTUALIZANDO LOS ESCRIBANOS</strong>");
        $('#modalLoader').modal('show');
      },
      
      success:function(respuesta){
       $('#modalLoader').modal('hide');
      }

    })

})

$("#btnMostrarEscribanos").click(function() {

  var datos = new FormData();
  datos.append("mostrarEscribanos", "1");

  $.ajax({

      url:"ajax/updateEscribanos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success:function(respuesta){
        $('#modalMostar #titulo').html("ESCRIBANOS");
        $('#modalMostar #mostrarBody').html(respuesta);
        $("#modalMostar #cabezaLoader").css("background", "#00C851");
        $("#mostrarSalir").removeClass("btn-danger");
        $("#mostrarSalir").addClass("btn-success");
        $('#modalMostar').modal('show');
       
      }

    })

})

$("#actualizarCuota").click(function() {

  var datos = new FormData();
  datos.append("actualizarCuota", "1");

  $.ajax({

      url:"ajax/updateTodo.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function(){
        $("#cabezaLoader").css("background", "#ffbb33");
        $('#actualizacionparrafo').html("<strong>ACTUALIZANDO TODAS LAS CUOTAS</strong>");
        $('#modalLoader').modal('show');
      },
      
      success:function(respuesta){
        console.log("respuesta", respuesta);
       $('#modalLoader').modal('hide');
      }

    })

})

$("#actualizarFc").click(function() {

  var datos = new FormData();
  datos.append("actualizarFc", "1");

  $.ajax({

      url:"ajax/updateTodo.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function(){
        $("#cabezaLoader").css("background", "#ffbb33");
        $('#actualizacionparrafo').html("<strong>ACTUALIZANDO TODAS LAS CUOTAS</strong>");
        $('#modalLoader').modal('show');
      },
      
      success:function(respuesta){
        console.log("respuesta", respuesta);
       $('#modalLoader').modal('hide');
      }

    })

})

$("#revisarInabilitados").click(function() {

 window.location = "index.php?ruta=inicio&tipo=revisar";

})
