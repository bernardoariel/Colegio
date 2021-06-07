<?php

class ControladorRubros{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearRubro(){

		

		if(isset($_POST["nuevoRubro"])){

				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoRubro"]) &&
			      ($_POST["nuevoMovimiento"]!=null)&&
			      ($_POST["nuevoMensual"]!=null)){

					$tabla = "rubros";

					$datos = $_POST["nuevoRubro"];

					$datos = array("nombre" => $_POST["nuevoRubro"],
								   "movimiento" => $_POST["nuevoMovimiento"],
								   "mensual" => $_POST["nuevoMensual"],
								   "obs" => $_POST["nuevoObs"]);

					$respuesta = ModeloRubros::mdlIngresarRubro($tabla, $datos);

					if($respuesta == "ok"){

						echo'<script>

						swal({
							  type: "success",
							  title: "El Rubro ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "rubros";

										}
									})

						</script>';

					}


				}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "¡El rubro no puede ir vacía o llevar caracteres especiales! o faltan algunos datos",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {

								window.location = "rubros";

								}
							})

				  	</script>';

				}
					

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarRubros($item, $valor){

		$tabla = "rubros";

		$respuesta = ModeloRubros::mdlMostrarRubros($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarRubro(){

		if(isset($_POST["editarRubro"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarRubro"]) 
		      ){

				$tabla = "rubros";

				$datos = array("id"=>$_POST["idRubro"],
							   "nombre"=>$_POST["editarRubro"],
							   "movimiento"=>$_POST["editarMovimiento"],
							   "mensual"=>$_POST["editarMensual"],
							   "obs"=>$_POST["editarObs"],
							);
 				
 				ControladorRubros::ctrbKRubros($tabla, "id", $_POST["idRubro"], "UPDATE");

				$respuesta = ModeloRubros::mdlEditarRubro($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Rubro ha sido actualizado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rubros";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!, o faltan algunos datos",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "rubros";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR RUBRO
	=============================================*/

	static public function ctrBorrarRubro(){

		if(isset($_GET["idRubro"])){

			$tabla ="rubros";
			$datos = $_GET["idRubro"];
			
			ControladorRubros::ctrbKRubros($tabla, "id", $_GET["idRubro"], "ELIMINAR");

			$respuesta = ModeloRubros::mdlBorrarRubro($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El rubro ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "rubros";

									}
								})

					</script>';
			}
		}
		
	}

	static public function ctrbKRubros($tabla, $item, $valor,$tipo){

		#TRAEMOS LOS DATOS DE IDESCRIBANO
		
		$respuesta = ControladorRubros::ctrMostrarRubros($item, $valor);

		$valor='[{"id":"'.$respuesta[0].'",
				  "nombre":"'.$respuesta[1].'",
				  "movimiento":"'.$respuesta[2].'",
				  "mensual":"'.$respuesta[3].'",
				  "activo":"'.$respuesta[4].'",
				  "osbdel":"'.$respuesta[5].'",
				  "fecha":"'.$respuesta[6].'"}]';

        $datos = array("tabla"=>"rubros",
	   				    "tipo"=>$tipo,
			            "datos"=>$valor,
			        	"usuario"=>$_SESSION['nombre']);

        $tabla = "backup";

        $respuesta = ModeloRubros::mdlbKRubro($tabla, $datos);

	}
}
