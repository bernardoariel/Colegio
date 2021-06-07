<?php

$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

foreach ($ventas as $key => $value) {
	# code...
	$item = "id";
	$valor =  $value['id_cliente'];
	$orden ='id';
	$escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor, $orden);

	$datos = array("id"=>$value['id'],
					"nombre"=>$escribanos['nombre'],
			       "documento"=>$escribanos['documento']);

	$tabla="ventas";

	$respuesta = ModeloVentas::mdlCorregirNombres($tabla,$datos);

	if($respuesta=="ok"){
		echo 'ok';
	}else{
		echo $value['id'];
		echo $respuesta;
	}
}


?>