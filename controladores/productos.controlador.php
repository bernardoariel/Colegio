<?php

class ControladorProductos{

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function ctrMostrarProductos($item, $valor, $orden){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);

		return $respuesta;

	}

	/*=============================================
	CREAR PRODUCTO
	=============================================*/

	static public function ctrCrearProducto(){

		
		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

				$tabla = "productos";

				$datos = array("id_rubro" => $_POST["nuevoRubro"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "nombre" => strtoupper($_POST["nuevoNombre"]),
							   "descripcion" => strtoupper($_POST["nuevaDescripcion"]),
							   "nrocomprobante" => $_POST["nuevoComprobante"],
							   "cantventa" => $_POST["nuevaCantidadVenta"],
							   "cantminima" => $_POST["nuevaCantidadMinima"],
							   "cuotas" => $_POST["nuevaCuota"],
							   "importe" => $_POST["nuevoImporte"],
							   "obs" => $_POST["nuevaObs"]);

				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/

	static public function ctrEditarProducto(){

		if(isset($_POST["editarDescripcion"])){
			

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				$tabla = "productos";

				$datos = array("id" => $_POST["idProducto"],
							   "id_rubro" => $_POST["editarRubro"],
							   "codigo" => $_POST["editarCodigo"],
							   "nombre" => strtoupper($_POST["editarNombre"]),
							   "descripcion" => strtoupper($_POST["editarDescripcion"]),
							   "nrocomprobante" => $_POST["editarComprobante"],
							   "cantventa" => $_POST["editarCantidadVenta"],
							   "cantminima" => $_POST["editarCantidadMinima"],
							   "cuotas" => $_POST["editarCuota"],
							   "importe" => $_POST["editarImporte"],
							   "obs" => $_POST["editarObs"]);

				// ControladorProductos::ctrbKProductos($tabla, "id", $_POST["idProducto"], "UPDATE");

				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
				

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
			}
		}

	}

	
	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto(){

		if(isset($_GET["idProducto"])){

			$tabla ="productos";
			$datos = $_GET["idProducto"];

			if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){

				unlink($_GET["imagen"]);
				rmdir('vistas/img/productos/'.$_GET["codigo"]);

			}

			ControladorProductos::ctrbKProductos($tabla, "id", $_GET["idProducto"], "ELIMINAR");

			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "productos";

								}
							})

				</script>';

			}		
		}


	}

	static public function ctrbKProductos($tabla, $item, $valor,$tipo){

			#TRAEMOS LOS DATOS DE IDESCRIBANO
			
			$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
			

			$valor='[{"id":"'.$respuesta[0].'",
					  "nombre":"'.$respuesta[1].'",
					  "descripcion":"'.$respuesta[2].'",
					  "codigo":"'.$respuesta[3].'",
					  "nrocomprobante":"'.$respuesta[4].'",
					  "cantventa":"'.$respuesta[5].'",
					  "id_rubro":"'.$respuesta[6].'",
					  "cantminima":"'.$respuesta[7].'",
					  "cuotas":"'.$respuesta[8].'",
					  "importe":"'.$respuesta[9].'",
					  "ultimonrocompra":"'.$respuesta[10].'",
					  "obs":"'.$respuesta[11].'",
					  "activo":"'.$respuesta[12].'",
					  "obsdel":"'.$respuesta[13].'"}]';

	        $datos = array("tabla"=>"productos",
		   				    "tipo"=>$tipo,
				            "datos"=>$valor,
				        	"usuario"=>$_SESSION['nombre']);

	        $tabla = "backup";

	        $respuesta = ModeloProductos::mdlbKProducto($tabla, $datos);
	        

		}
	
	


}