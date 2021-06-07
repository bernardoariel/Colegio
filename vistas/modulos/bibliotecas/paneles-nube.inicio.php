<?php

 //TERMINO EL BUCLE DE LOS ESCRIBANOS
 /*====================================
  =     CARGO UN ARRAY DE  LOS ESCRIBANOS      =
  =============================================*/
  #SE REVISA A LOS DEUDORES
  $escribanosInabilitados = ControladorEscribanos::ctrMostrarEscribanosInhabilitados();
  
  #TRAER PRODUCTOS DEL COLEGIO
  $productos = ControladorParametros::ctrCountTablas("productos",null,null);
  

  #SE REVISA A LOS DEUDORES
  $item = null;
  $valor = null;

  $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

  ?>