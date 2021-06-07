<?php

class ControladorDelegaciones{

	/*=============================================
	MOSTRAR DELEGACIONES
	=============================================*/
	static public function ctrMostrarDelegaciones($item, $valor){

		$tabla = "delegaciones";

		$respuesta = ModeloDelegaciones::mdlMostrarDelegaciones($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	AGREGAR DELEGACIONES
	=============================================*/
	static public function ctrIngresarDelegacion($datos){

		$tabla = "delegaciones";

		$respuesta = ModeloDelegaciones::mdlIngresarDelegacion($tabla, $datos);

		return $respuesta;
	
	}
	
	/*=============================================
	AGREGAR DELEGACIONES
	=============================================*/
	static public function ctrEditarDelegacion($datos){
		// print_r($datos);
		$tabla = "delegaciones";

		$respuesta = ModeloDelegaciones::mdlEditarDelegacion($tabla, $datos);

		return $respuesta;
	
	}

	/*=============================================
	BORRAR DELEGACIONES
	=============================================*/

	static public function ctrEliminarDelegacion(){

		if(isset($_GET["idDelegacion"])){

			$tabla ="delegaciones";
			$datos = $_GET["idDelegacion"];
			
			#ENVIAMOS LOS DATOS
			// ControladorCategorias::ctrbKCategorias($tabla, "id", $_GET["idCategoria"], "ELIMINAR");

			$respuesta = ModeloDelegaciones::mdlBorrarDelegacion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "La delegacion ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "delegaciones";

									}
								})

					</script>';
			}
		 }
		
	}


}
