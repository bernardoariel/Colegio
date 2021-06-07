<?php

class ControladorTipoIva{

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function ctrMostrarTipoIva($item, $valor){

		$tabla = "tipo_iva";

		$respuesta = ModeloTipoIva::mdlMostrarTipoIva($tabla, $item, $valor);

		return $respuesta;
	
	}

	
	


}
