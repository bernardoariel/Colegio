<?php
      
/*============================================
=              GENERO LA CAJA                =
=============================================*/
$item = "fecha";
$valor = date('Y-m-d');

$caja = ControladorCaja::ctrMostrarCaja($item, $valor);
        
  
if(count($caja)==0){
  //SI NO EXISTE LA CAJA  CREO UNA
        
  include("con-caja.incio.php");
  
}

/*===========================================
 =  SI VIENE DE UN PAGO DE UNA CUOTA      =
===========================================*/
$cantHabilitados = 0;

if(isset($_GET['tipo'])){

  if($_GET['tipo']=="cuota"){

    /*=============================================
    VEO SI SE ENCUENTRA INHABILITADO
    =============================================*/
    $item = "id";
    $valor = $_GET['idescribano'];

    $respuesta = ControladorEscribanos::ctrMostrarEstado($item, $valor);
          
    if($respuesta["inhabilitado"]!=0){//SI SE ENCUENTRA HABILITADO 0//QUE NO HAGA NADA

      include("servidor.inicio.php");#ELIMINAR LOS INHABILITADOS EN EL SERVIDOR y habilito

      include("inhabilitados.inicio.php");#INABILITO A QUIEN CORRESPONDA

      include("ws.inicio.php");#LO SUBO EN LA WS

    }

  }

  if($_GET['tipo']=="revisar"){

    include("cuotas.inicio.php");#CHEQUEO SI SE GENERARON Y SI NO SE GENERARON GENERARLA

    include("servidor.inicio.php");#ELIMINAR LOS INHABILITADOS EN EL SERVIDOR y habilito

    include("inhabilitados.inicio.php");#INABILITO A QUIEN CORRESPONDA

    include("ws.inicio.php");#LO SUBO EN LA WS

  }

   echo '<script>window.location = "inicio"</script>';

}