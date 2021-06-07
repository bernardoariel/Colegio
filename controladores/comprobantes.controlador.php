<?php

class ControladorComprobantes{

	/*=============================================
	MOSTRAR COMPROBANTES
	=============================================*/

	static public function ctrMostrarComprobantes($item, $valor){

		$tabla = "comprobantes";

		$respuesta = ModeloComprobantes::mdlMostrarComprobantes($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	CREAR COMPROBANTES
	=============================================*/

	static public function ctrCrearComprobante(){


		if(isset($_POST["nuevoComprobante"])){

			if ($_POST["nuevoNumeroComprobante"]<>null){

				if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoComprobante"])){

					$tabla = "comprobantes";

					$datos = $_POST["nuevoComprobante"];

					$datos = array("nombre" => $_POST["nuevoComprobante"],
								   "numero" => $_POST["nuevoNumeroComprobante"]);

					 $respuesta = ModeloComprobantes::mdlIngresarComprobante($tabla, $datos);

					if($respuesta == "ok"){

						echo'<script>

						swal({
							  type: "success",
							  title: "El comprobante ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "comprobantes";

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

								window.location = "comprobantes";

								}
							})

				  	</script>';

				}
			}		

		}

	}

	/*=============================================
	EDITAR Comprobantes
	=============================================*/

	static public function ctrEditarComprobante(){

		if(isset($_POST["editarComprobante"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarComprobante"])){

				$tabla = "comprobantes";

				$datos = array("id"=>$_POST["idComprobante"],
							   "nombre"=>$_POST["editarComprobante"],
							   "numero"=>$_POST["editarNumeroComprobante"]);

				ControladorComprobantes::ctrbKComprobantes($tabla, "id", $_POST["idComprobante"], "UPDATE");

				$respuesta = ModeloComprobantes::mdlEditarComprobante($tabla, $datos);

				if($respuesta == "ok"){

						echo'<script>

						swal({
							  type: "success",
							  title: "La edicion ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "comprobantes";

										}
									})

						</script>';

					}
			}	

		}

	}

/*=============================================
BORRAR COMPROBANTE
=============================================*/

static public function ctrBorrarComprobante(){

	if(isset($_GET["idComprobante"])){

		$tabla ="comprobantes";
		$datos = $_GET["idComprobante"];
		
		ControladorComprobantes::ctrbKComprobantes($tabla, "id", $_GET["idComprobante"], "ELIMINAR");

		// $respuesta = ModeloComprobantes::mdlBorrarComprobante($tabla, $datos);

		// if($respuesta == "ok"){

		// 	echo'<script>

		// 		swal({
		// 			  type: "success",
		// 			  title: "El comprobante ha sido borrado correctamente",
		// 			  showConfirmButton: true,
		// 			  confirmButtonText: "Cerrar"
		// 			  }).then(function(result){
		// 						if (result.value) {

		// 						window.location = "comprobantes";

		// 						}
		// 					})

		// 		</script>';
		// }

	 }
	
}

	/*=============================================
	INICIALIZAR COMPROBANTES
	=============================================*/

	static public function ctrIniciarComprobantes($item, $valor){

		$tabla = "tmp_comprobantes";

		$respuesta = ModeloComprobantes::mdlIniciarTabla($tabla, $item, $valor);

		return $respuesta;
	
	}
	/*=============================================
	INICIAR COMPROBANTES
	=============================================*/
	static public function ctrIniciarCargaTmpComprobantes($datos){

		$tabla = "tmp_comprobantes";

		$respuesta = ModeloComprobantes::mdlIniciarCargaTmpComprobantes($tabla, $datos);

		return $respuesta;
	
	}


	/*=============================================
	AGREGAR ULTIMO ID COMPROBANTES
	=============================================*/
	static public function ctrAgregarItemsComprobantes($datos){
		
		

		$tabla = "tmp_items";

		$respuesta = ModeloComprobantes::mdlAgregarItemsComprobantes($tabla, $datos);

		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR ITEMS COMPROBANTES
	=============================================*/

	static public function ctrMostrarItemsComprobantes($item, $valor){

		$tabla = "tmp_items";

		$respuesta = ModeloComprobantes::mdlMostrarComprobantes($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	ACTUALIZAR FOLIO DE COMPROBANTES
	=============================================*/

	static public function ctrUpdateFolioComprobantes($item, $valor,$datos){

		$tabla = "tmp_comprobantes";

		$respuesta = ModeloComprobantes::mdlUpdateFolioComprobantes($tabla, $item, $valor, $datos);

		return $respuesta;
	
	}

	/*=============================================
	INICIALIZAR COMPROBANTES
	=============================================*/

	static public function ctrIniciarItems($item, $valor){

		$tabla = "tmp_items";

		$respuesta = ModeloComprobantes::mdlIniciarTabla($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR COMPROBANTES
	=============================================*/

	static public function ctrMostrarTMPComprobantes($item, $valor){

		$tabla = "tmp_comprobantes";

		$respuesta = ModeloComprobantes::mdlMostrarComprobantes($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	UPDATE FOLIOS
	=============================================*/

	static public function ctrUpdateFolio($campo, $id,$numero){
		
		$tabla = "tmp_items";

		$respuesta = ModeloComprobantes::mdlUpdateFolio($tabla,$campo, $id,$numero);

		return $respuesta;
	
	}

	/*=============================================
	BORRAR ITEM TMP_ITEMS
	=============================================*/
	static public function ctrBorrarItem($item, $valor){
		
		$tabla = "tmp_items";

		$datos = $valor;
		//uso la misma funcion de modelos con otros parametros
		$respuesta = ModeloComprobantes::mdlBorrarComprobante($tabla, $datos);

		return $respuesta;
	
	}

	static public function ctrbKComprobantes($tabla, $item, $valor,$tipo){

			#TRAEMOS LOS DATOS DE IDESCRIBANO
			
			$respuesta = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);
			

			$valor='[{"id":"'.$respuesta[0].'",
					  "nombre":"'.$respuesta[1].'",
					  "cabezacomprobante":"'.$respuesta[2].'",
					  "numero":"'.$respuesta[3].'"}]';

	        $datos = array("tabla"=>"comprobantes",
		   				    "tipo"=>$tipo,
				            "datos"=>$valor,
				        	"usuario"=>$_SESSION['nombre']);

	        $tabla = "backup";

	        $respuesta = ModeloComprobantes::mdlbKComprobante($tabla, $datos);
	        

		}

	
	
}
