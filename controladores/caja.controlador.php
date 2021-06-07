<?php

class ControladorCaja{

	/*=============================================
	MOSTRAR CAJA
	=============================================*/

	static public function ctrMostrarCaja($item, $valor){

		$tabla = "caja";

		$respuesta = ModeloCaja::mdlMostrarCaja($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	INGRESAR CAJA
	=============================================*/

	static public function ctrIngresarCaja($item, $datos){

		$tabla = "caja";

		$respuesta = ModeloCaja::mdlIngresarCaja($tabla,$datos);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CAJA
	=============================================*/

	static public function ctrEditarCaja($item, $datos){

		$tabla = "caja";

		$respuesta = ModeloCaja::mdlEditarCaja($tabla,$datos);

		return $respuesta;
	
	}


}
