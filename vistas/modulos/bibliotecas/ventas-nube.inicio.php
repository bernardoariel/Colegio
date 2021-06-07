<?php

/*==========================================
=  CANTIDAD DE VENTAS  PARA MOSTRAR        =
==========================================*/

$item = "fecha";
$valor= date('Y-m-d');
$ventas = ControladorVentas::ctrMostrarVentasFecha($item, $valor);


$ventasClorinda = ControladorEnlace::ctrMostrarVentasFechaClorinda($item, $valor);
$ventasColorado = ControladorEnlace::ctrMostrarVentasFechaColorado($item, $valor);




$item = "tipo";
$valor= "CU";
$cantCuotas = ControladorCuotas::ctrContarCuotayOsde($item,$valor);

$item = "tipo";
$valor= "RE";
$cantOsde = ControladorCuotas::ctrContarCuotayOsde($item,$valor);

/*==========================================
      =   BUSCAR LA ULTIMA FACTURA     =
==========================================*/
$ultimoId = ControladorVentas::ctrUltimoId();

$item = "id";
$valor= $ultimoId["id"];
$ultimaVenta = ControladorVentas::ctrMostrarVentas($item, $valor);


?>