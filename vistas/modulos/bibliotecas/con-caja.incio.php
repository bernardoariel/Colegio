<?php

#CREO UN NUEVO REGISTRO DE LA CAJA CON LA FECHA DEL DIA
$datos=array("fecha"=>date('Y-m-d'),
             "efectivo"=>0,
             "tarjeta"=>0,
             "cheque"=>0,
             "transferencia"=>0);
    
$insertarCaja = ControladorCaja::ctrIngresarCaja($item, $datos);

include("cuotas.inicio.php");#CHEQUEO SI SE GENERARON Y SI NO SE GENERARON GENERARLA

include("servidor.inicio.php");#ELIMINAR LOS INHABILITADOS EN EL SERVIDOR y habilito

include("inhabilitados.inicio.php");#INABILITO A QUIEN CORRESPONDA

include("ws.inicio.php");#LO SUBO EN LA WS


?>