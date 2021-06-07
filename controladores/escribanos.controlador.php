<?php

class ControladorEscribanos{

	/*=============================================
	MOSTRAR ESCRIBANOS
	=============================================*/

	static public function ctrMostrarEscribanos($item, $valor){

		$tabla = "escribanos";

		$respuesta = ModeloEscribanos::mdlMostrarEscribanos($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarEscribanosInhabilitados(){

		$tabla = "escribanos";

		$respuesta = ModeloEscribanos::mdlMostrarEscribanosInhabilitados($tabla);

		return $respuesta;

	}
	static public function ctrMostrarInhabilitado(){

		$tabla = "escribanos";

		$respuesta = ModeloEscribanos::mdlMostrarInhabilitado($tabla);

		return $respuesta;

	}

	static public function ctrMostrarEstado($item,$valor){

		$tabla = "escribanos";

		$respuesta = ModeloEscribanos::mdlMostrarEstado($tabla,$item,$valor);

		return $respuesta;

	}


	/*=============================================
	CREAR ESCRIBANOS
	=============================================*/

	static public function ctrCrearEscribano(){

		if(isset($_POST["nuevoEscribano"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoEscribano"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoDocumento"]) &&			   
			   preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDireccion"])){

				$cuit = explode("-",$_POST["nuevoCuit"]);
			   	$tabla = "escribanos";

			   	$datos = array("nombre"=>strtoupper($_POST["nuevoEscribano"]),
			   	
					           "documento"=>$_POST["nuevoDocumento"],
					           "id_iva"=>$_POST["nuevaIdIva"],
					           "cuit"=>$cuit[0].$cuit[1].$cuit[2],
					           "direccion"=>strtoupper($_POST["nuevaDireccion"]),
					           "localidad"=>strtoupper($_POST["nuevaLocalidad"]),
					           "telefono"=>$_POST["nuevoTelefono"],
					           "email"=>strtoupper($_POST["nuevoEmail"]),
					           "id_categoria"=>$_POST["nuevaCategoriaEscribano"],
					           "id_escribano_relacionado"=>$_POST["nuevoEscribanoRelacionado"],
					           "id_osde"=>$_POST["nuevoCategoriaOsde"]);
			   	
			   
			   $respuesta = ModeloEscribanos::mdlIngresarEscribano($tabla, $datos);
			   
			  
			   
			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El escribano ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "escribanos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El escribano no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "escribanos";

							}
						})

			  	</script>';



			}

		}

	}

	static public function ctrbKEscribano($tabla, $item, $valor,$tipo){

		#TRAEMOS LOS DATOS DE IDESCRIBANO
		
		$respuesta = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

		$valor='[{"id":"'.$respuesta[0].'",
				  "nombre":"'.$respuesta[1].'",
				  "direccion":"'.$respuesta[2].'",
				  "localidad":"'.$respuesta[3].'",
				  "telefono":"'.$respuesta[4].'",
				  "documento":"'.$respuesta[5].'",
				  "cuit":"'.$respuesta[6].'",
				  "email":"'.$respuesta[7].'",
				  "id_categoria":"'.$respuesta[8].'",
				  "id_escribano_relacionado":"'.$respuesta[9].'",
				  "id_osde":"'.$respuesta[10].'",
				  "ultimolibrocomprado":"'.$respuesta[11].'",
	              "ultimolibrodevuelto":"'.$respuesta[12].'",
				  "obs":"'.$respuesta[13].'",
				  "activo":"'.$respuesta[14].'",
				  "obsdel":"'.$respuesta[15].'",
                  "fechacreacion":"'.$respuesta[16].'"}]';

        $datos = array("tabla"=>"escribanos",
	   				    "tipo"=>$tipo,
			            "datos"=>$valor,
			        	"usuario"=>$_SESSION['nombre']);
        $tabla = "backup";

        $respuesta = ModeloEscribanos::mdlbKEscribano($tabla, $datos);
	}

	/*=============================================
	ELIMINAR ESCRIBANO
	=============================================*/

	static public function ctrEliminarEscribano(){

		if(isset($_GET["idEscribano"])){

			$tabla ="escribanos";
			
			$datos = $_GET["idEscribano"];

			$valor = $_GET["idEscribano"];
			
			#ENVIAMOS LOS DATOS
			ControladorEscribanos::ctrbKEscribano($tabla, "id", $valor, "ELIMINAR");

			$respuesta = ModeloEscribanos::mdlEliminarEscribano($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Escribano ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "escribanos";

								}
							})

				</script>';

			}		

		}

	}


	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarEscribano(){

		if(isset($_POST["editarEscribano"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarEscribano"]) &&
			   preg_match('/^[0-9 ]+$/', $_POST["editarDocumento"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"])){

			   	$tabla = "escribanos";
			    $cuit = explode("-",$_POST["editarCuit"]);
			   	#ENVIAMOS LOS DATOS
			    ControladorEscribanos::ctrbKEscribano($tabla, "id", $_POST["idEscribano"], "UPDATE");

			   $datos = array( "id"=>$_POST["idEscribano"],
			   				   "nombre"=>strtoupper($_POST["editarEscribano"]),
					           "documento"=>$_POST["editarDocumento"],
					           "id_tipo_iva"=>$_POST["editarTipoIva"],
					           "cuit"=>$cuit[0].$cuit[1].$cuit[2],
					           "direccion"=>strtoupper($_POST["editarDireccion"]),
					           "localidad"=>strtoupper($_POST["editarLocalidad"]),
					           "telefono"=>$_POST["editarTelefono"],
					           "email"=>strtoupper($_POST["editarEmail"]),
					           "id_categoria"=>$_POST["editarCategoriaEscribano"],
					           "id_escribano_relacionado"=>$_POST["editarEscribanoRelacionado"],
					           "id_osde"=>$_POST["editarCategoriaOsde"],
					           "matricula_ws"=>$_POST["editarMatricula"]);
			   
			  	$respuesta = ModeloEscribanos::mdlEditarEscribano($tabla, $datos);
			   	

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Escribano ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "escribanos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "escribanos";

							}
						})

			  	</script>';



			}

		}

	}

}