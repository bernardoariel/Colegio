<?php

  $respuesta = ControladorVentas::ctrTmpVentasCopia("CU");
  
  foreach ($respuesta as $key => $value) {

   $tabla = "cuotas";

   $datos = array("id"=>$value["id"],
             "fecha"=>$value["fecha"],
             "tipo"=>$value["tipo"],
             "id_cliente"=>$value["id_cliente"],
             "nombre"=>$value["nombre"],
             "documento"=>$value["documento"],
             "productos"=>$value["productos"],
             "total"=>$value["total"]);

   #registramos los productos
   $respuesta = ModeloCuotas::mdlIngresarCuota($tabla, $datos);

  }

  $respuesta = ControladorVentas::ctrTmpVentasCopia("RE");
  
  foreach ($respuesta as $key => $value2) {

   $tabla = "cuotas";

   $datos = array("id"=>$value2["id"],
             "fecha"=>$value2["fecha"],
             "tipo"=>$value2["tipo"],
             "id_cliente"=>$value2["id_cliente"],
             "nombre"=>$value2["nombre"],
             "documento"=>$value2["documento"],
             "productos"=>$value2["productos"],
             "total"=>$value2["total"]);

   

   
    #registramos los productos
    $respuesta = ModeloCuotas::mdlIngresarCuota($tabla, $datos);

  }

  ?>