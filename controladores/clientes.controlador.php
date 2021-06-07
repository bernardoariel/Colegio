<?php

class ControladorClientes{

	/*=============================================
	MOSTRAR ESCRIBANOS
	=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR CLIENTE
	=============================================*/

	static public function ctrCrearCliente($datos){
		
		
		$tabla = "clientes";

		$respuesta = ModeloCLientes::mdlCrearCliente($tabla, $datos);
	   	
	}

	/*=============================================
	MOSTRAR ULTIMO CLIENTE
	=============================================*/

	static public function ctrUltimoCliente(){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlUltimoCliente($tabla);

		return $respuesta;

	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarCliente($datos){

		$tabla = "clientes";

		$respuesta = ModeloCLientes::mdlEditarCliente($tabla, $datos);
	   	
	}
	
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarCliente(){

		if(isset($_GET["idCliente"])){



			$tabla ="clientes";
			
			$datos = $_GET["idCliente"];

			$valor = $_GET["idCliente"];
			
			#ENVIAMOS LOS DATOS
			ControladorClientes::ctrbKCliente($tabla, "id", $valor, "ELIMINAR");

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

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

								window.location = "clientes";

								}
							})

				</script>';

			}		

		}

	}

	static public function ctrbKCliente($tabla, $item, $valor,$tipo){

		#TRAEMOS LOS DATOS DE IDESCRIBANO
		echo $item. " ". $valor;
		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		$valor='[{"id":"'.$respuesta[0].'",
				  "nombre":"'.$respuesta[1].'",
				  "direccion":"'.$respuesta[2].'",
				  "localidad":"'.$respuesta[3].'",
				  "telefono":"'.$respuesta[4].'",
				  "tipoiva":"'.$respuesta[3].'",
				  "cuit":"'.$respuesta[2].'"}]';

        $datos = array("tabla"=>$tabla,
	   				    "tipo"=>$tipo,
			            "datos"=>$valor,
			        	"usuario"=>$_SESSION['nombre']);
        $tabla = "backup";

        $respuesta = ModeloClientes::mdlbKCliente($tabla, $datos);
	}



}