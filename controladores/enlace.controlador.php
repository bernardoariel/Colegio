<?php

class ControladorEnlace{

	/*=============================================
	ELIMINAR SEGUN LA TABLA CAJA
	=============================================*/

	static public function ctrEliminarEnlace($tabla){

		$respuesta = ModeloEnlace::mdlEliminarEnlace($tabla);

		return $respuesta;
	
	}

	static public function ctrMostrarVentasColegio(){

		$tabla = "cuotas";

		$respuesta = ModeloEnlace::mdlMostrarVentasColegio($tabla);

		return $respuesta;

	}
	static public function ctrMostrarVentasClorinda($item,$valor){

		$tabla = "clorinda";
		

		$respuesta = ModeloEnlace::mdlMostrarVentasClorinda($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarVentasColorado($item,$valor){

		$tabla = "colorado";
		

		$respuesta = ModeloEnlace::mdlMostrarVentasClorinda($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarVentasClorindaCodigoFc($item,$valor){

		$tabla = "clorinda";
		

		$respuesta = ModeloEnlace::mdlMostrarVentasClorindaCodigoFc($tabla, $item, $valor);

		return $respuesta;

	}
	static public function ctrMostrarVentasColoradoCodigoFc($item,$valor){

		$tabla = "colorado";
		

		$respuesta = ModeloEnlace::mdlMostrarVentasColoradoCodigoFc($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarUltimaActualizacion(){

		$tabla = "ventas";

		$respuesta = ModeloEnlace::mdlMostrarUltimaActualizacion($tabla);

		return $respuesta;

	}

	static public function ctrMostrarVentasFechaClorinda($item, $valor){

		$tabla = "clorinda";

		$respuesta = ModeloEnlace::mdlMostrarVentasFechaClorinda($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarVentasFechaColorado($item, $valor){

		$tabla = "colorado";

		$respuesta = ModeloEnlace::mdlMostrarVentasFechaColorado($tabla, $item, $valor);

		return $respuesta;

	}
	
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasEnlace($tabla,$fechaInicial, $fechaFinal){

		$respuesta = ModeloEnlace::mdlRangoFechasEnlace($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	SUBIR INHABILITADOS
	=============================================*/	

	static public function ctrSubirInhabilitado($datos){

		$tabla = "inhabilitados";

		$respuesta = ModeloEnlace::mdlSubirInhabilitado($tabla, $datos);

		return $respuesta;
		
	}

	static public function ctrSubirHabilitado($valor){

		$tabla = "inhabilitados";

		$respuesta = ModeloEnlace::mdlSubirHabilitado($tabla, $valor);

		return $respuesta;
		
	}
	/*=============================================
	SUBIR MODIFICACIONES
	=============================================*/	

	static public function ctrSubirModificaciones($datos){

		$tabla = "modificaciones";

		$respuesta = ModeloEnlace::mdlSubirModificaciones($tabla, $datos);

		return $respuesta;
		
	}

	static public function ctrUpdateModificaciones($datos){

		$tabla = "modificaciones";

		$respuesta = ModeloEnlace::mdlUpdateModificaciones($tabla, $datos);

		return $respuesta;
		
	}

	/*=============================================
	ELIMINAR CUOTA
	=============================================*/

	static public function ctrEliminarCuota($valor){

		$tabla = "cuotas";

		$respuesta = ModeloEnlace::mdlEliminarCuota($tabla,$valor);

		return $respuesta;
	
	}

	static public function ctrMostrarUltimaAVenta(){

		$tabla = "ventas";

		$respuesta = ModeloEnlace::mdlMostrarUltimaVenta($tabla);

		return $respuesta;

	}
	

	
	

}
