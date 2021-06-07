 <?php

    #VEO QUE CANTIDAD DE CUOTAS
    $cuotas = ControladorCuotas::ctrMostrarGeneracion("CUOTA");
    $osde = ControladorCuotas::ctrMostrarGeneracion("OSDE");

    $tabla ="modificaciones"; 
    $valor = "cuotas";
    $modificacionesCuota = ModeloEnlace::mdlMostrarUltimaActualizacionModificaciones($tabla,$valor);
    

    $tabla ="modificaciones"; 
    $valor = "ventas";
    $modificacionesFc = ModeloEnlace::mdlMostrarUltimaActualizacionModificaciones($tabla,$valor);
    
  ?>