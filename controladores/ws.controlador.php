<?php

class ControladorWs{

	/*=============================================
	MOSTRAR ESCRIBANOS WEBSERVICE
	=============================================*/

	static public function ctrMostrarEscribanosWs($item, $valor){

		$tabla = "escribanos";

		$respuesta = ModeloWs::mdlMostrarEscribanosWs($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	PONER A NULL TODOS LOS ESCRIBANOS DEL WS
	=============================================*/

	static public function ctrNullEscribanosWs(){

		$tabla = "escribanos";

		$respuesta = ModeloWs::mdlNullEscribanosWs($tabla);

		return $respuesta;
	
	}

	/*=============================================
	CAMBIAR EL ESTADO DE LOS ESCRIBANOS
	=============================================*/

	static public function ctrModificarEstadosWs($datos){

		$tabla = "escribanos";

		$respuesta = ModeloWs::mdlModificarEstadosWs($tabla,$datos);

		return $respuesta;
	
	}


}
