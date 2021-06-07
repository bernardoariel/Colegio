<?php

class ControladorParametros{

	/*=============================================
	MOSTRAR PARAMETROS DE FACTURACION
	=============================================*/

	static public function ctrMostrarParametros($item, $valor){

		$tabla = "facturaconfig";

		$respuesta = ModeloParametros::mdlMostrarParametros($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR PARAMETROS DE VENTAS
	=============================================*/

	static public function ctrMostrarParametroAtraso($item, $valor){

		$tabla = "parametros";

		$respuesta = ModeloParametros::mdlMostrarParametros($tabla, $item, $valor);

		return $respuesta;
	
	}

	static public function ctrEditarParametros(){

		if (isset($_POST["editarId"])){

			$tabla = "parametros";

			$datos = array("id" => $_POST["editarId"],
						   "valor" => $_POST["editarValor"]);

			$respuesta =ControladorParametros::ctrbKParametros($tabla, "id", $_POST["editarId"], "UPDATE");

			$respuesta = ModeloParametros::mdlEditarParametros($tabla, $datos);

			if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "Ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "parametros";

										}
									})

						</script>';

				}
		
		}
		
	
	}



	static public function ctrEditarLibro(){



		if(isset($_POST['editarIdEscribano'])){

			$tabla = "escribanos";

			$datos = array("ultimolibrocomprado"=>$_POST["editarUltimoLibroComprado"],
						   "ultimolibrodevuelto"=>$_POST["editarUltimoLibroDevuelto"],
						   "id"=>$_POST["editarIdEscribano"]);

			$respuesta = ModeloParametros::mdlEditarLibro($tabla, $datos);

			if($respuesta == "ok"){


        

       

					echo'<script>

						window.location = "index.php?ruta=inicio&tipo=revisar";

						</script>';

				}
		
		}

	}

	static public function ctrbKParametros($tabla, $item, $valor,$tipo){
		

			#TRAEMOS LOS DATOS DE IDESCRIBANO
			
			 $respuesta = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);
			 
			

			$valor='[{"id":"'.$respuesta[0].'",
					  "parametro":"'.$respuesta[1].'",
					  "valor":"'.$respuesta[2].'"}]';

	        $datos = array("tabla"=>"parametros",
		   				    "tipo"=>$tipo,
				            "datos"=>$valor,
				        	"usuario"=>$_SESSION['nombre']);

	        $tabla = "backup";

	        $respuesta = ModeloParametros::mdlbKParametro($tabla, $datos);
	        

		}
	
	/*=============================================
	MOSTRAR DATOS ELIMINADOs
	=============================================*/

	static public function ctrMostrarBackUp($item, $valor){

		$tabla = "backup";

		$respuesta = ModeloParametros::mdlMostrarBackUp($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
		ELIMINAR DATOS
	=============================================*/

	static public function ctrEliminarBackup(){

		if (isset($_GET['idBackUpEliminar'])){

			
			$datos = $_GET['idBackUpEliminar'];
			
			$tabla = "backup";

			$respuesta = ModeloParametros::mdlEliminarBackup($tabla, $datos);

			if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "Ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "restaurar";

										}
									})

						</script>';

				}

		}
		
	
	}

	/*=============================================
		ELIMINAR DATOS
	=============================================*/

	static public function ctrRestaurarBackup(){

		if (isset($_GET['idBackUpRestaurar'])){

			
			$datos = $_GET['idBackUpRestaurar'];
			
			$tabla = "backup";

			$respuesta = ModeloParametros::mdlMostrarBackup($tabla,"id", $datos);
			echo '<pre>'; print_r($respuesta); echo '</pre>';

			

		}
		
	
	}

	static public function ctrCountTablas($tabla,$item,$valor){

		$respuesta = ModeloParametros::mdlCountTablas($tabla,$item,$valor);

		return $respuesta;
	}

}
