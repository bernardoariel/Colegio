<?php
#CONTROLADORES
#----------------------------------------------89

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

$datos = array("idProducto"=>$_POST["idProducto"],"cantidadProducto"=>$_POST["cantidadProducto"],"productoNombre"=>$_POST["productoNombre"],"precioVenta"=>$_POST["precioVenta"]);

 $agregarProductos = new ControladorVentas();
 $agregarProductos ->ctrAgregarTabla($datos);
 // var_dump($datos);

 ?>

