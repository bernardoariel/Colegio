<?php

class ControladorOsde{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearOsde(){

		

		if(isset($_POST["nuevoOsde"])){

			if ($_POST["nuevoImporte"]<>null){

				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoOsde"])){

					$tabla = "osde";

					$datos = array("nombre" => $_POST["nuevoOsde"],
								   "importe" => $_POST["nuevoImporte"]);

					 echo '<pre>'; print_r($datos); echo '</pre>';

					$respuesta = ModeloOsde::mdlIngresarOsde($tabla, $datos);

					if($respuesta == "ok"){

						echo'<script>

						swal({
							  type: "success",
							  title: "El Nuevo Osde ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "osde";

										}
									})

						</script>';

					}


				}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {

								window.location = "osde";

								}
							})

				  	</script>';

				}
			}		

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarOsde($item, $valor){

		$tabla = "osde";

		$respuesta = ModeloOsde::mdlMostrarOsde($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarOsde(){

		if(isset($_POST["editarOsde"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarOsde"])){

				$tabla = "osde";

				$datos = array("nombre"=>$_POST["editarOsde"],
					"importe"=>$_POST["editarImporte"],
							   "id"=>$_POST["idOsde"]);

				ControladorOsde::ctrbKOsde($tabla, "id", $_POST["idOsde"], "UPDATE");

				$respuesta = ModeloOsde::mdlEditarOsde($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Plan Osde ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "osde";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "osde";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarOsde(){

		if(isset($_GET["idOsde"])){

			$tabla ="osde";
			$datos = $_GET["idOsde"];
			
			ControladorOsde::ctrbKOsde($tabla, "id", $_GET["idOsde"], "ELIMINAR");
			$respuesta = ModeloOsde::mdlBorrarOsde($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El PLan Osde ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "osde";

									}
								})

					</script>';
			}
		}
		if(isset($_GET["todos"])){

			$tabla ="osde";
			
			$respuesta = ModeloOsde::mdlBorrarTodosOsde($tabla);

		}
		
	}

	static public function ctrbKOsde($tabla, $item, $valor,$tipo){

			#TRAEMOS LOS DATOS DE IDESCRIBANO
			
			$respuesta = ControladorOsde::ctrMostrarOsde($item, $valor);
			

			$valor='[{"id":"'.$respuesta[0].'",
					  "nombre":"'.$respuesta[1].'",
					  "importe":"'.$respuesta[2].'"}]';

	        $datos = array("tabla"=>"osde",
		   				    "tipo"=>$tipo,
				            "datos"=>$valor,
				        	"usuario"=>$_SESSION['nombre']);

	        $tabla = "backup";

	        $respuesta = ModeloOsde::mdlbKOsde($tabla, $datos);
	        

		}
	
}
