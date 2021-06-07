<?php

/*===================================================
= INHABILITO A LOS ESCRIBANOS QUE ESTEN ATRASADOS 
  O DEBAN LIBROS = los paso al nro 2 EN EL WEBSERVICE
===================================================*/    
ControladorWs::ctrNullEscribanosWs();

/*=============================================
GUARDO LOS INHABILITADOS EN LA BD LOCAL
=============================================*/
$verEscribanos = ControladorEscribanos::ctrMostrarInhabilitado();    
foreach ($verEscribanos as $key => $value) {
  
  $datos = array("idcliente"=>$value['id'],
                 "inhabilitado"=>$value['inhabilitado']);

  ControladorWs::ctrModificarEstadosWs($datos);

}


?>