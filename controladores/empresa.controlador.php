<?php

class ControladorEmpresa{

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarEmpresa($item, $valor){

		$tabla = "empresa";

		$respuesta = ModeloEmpresa::mdlMostrarEmpresa($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR EMPRESA DATOS
	=============================================*/

	static public function ctrEditarEmpresa($datos){


				$tabla = "empresa";

				
				 $respuesta = ModeloEmpresa::mdlEditarEmpresa($tabla, $datos);

				 return $respuesta;
			
	}

	/*=============================================
	ACTUALIZAR LOGO O ICONO
	=============================================*/

	static public function ctrActualizarImagen($item, $valor){

		$tabla = "empresa";
		$id = 1;

		$empresa = ModeloEmpresa::mdlSeleccionarEmpresa($tabla);
	    
	    /*=============================================
		CAMBIANDO LOGOTIPO O ICONO
		=============================================*/	

		

		if(isset($valor["tmp_name"])){

			list($ancho, $alto) = getimagesize($valor["tmp_name"]);

			/*=============================================
			CAMBIANDO LOGOTIPO
			=============================================*/	
			
		   
		    unlink("../".$empresa[$item]);

			switch ($item) {
				case 'backend':
					$nuevoAncho = 1000;
					$nuevoAlto = 633;
					$nombre ="back";
					$carpeta="plantilla";

					break;
				case 'iconochicoblanco':
					$nuevoAncho = 172;
					$nuevoAlto = 172;
					$nombre ="icono-blanco";
					$carpeta="plantilla";

					break;
				case 'iconochiconegro':
					$nuevoAncho = 172;
					$nuevoAlto = 172;
					$nombre ="icono-negro";
					$carpeta="plantilla";

					break;
				case 'logoblancobloque':
					$nuevoAncho = 500;
					$nuevoAlto = 183;
					$nombre ="logo-blanco-bloque";
					$carpeta="plantilla";

					break;
				case 'logonegrobloque':
					$nuevoAncho = 500;
					$nuevoAlto = 183;
					$nombre ="logo-negro-bloque";
					$carpeta="plantilla";

					break;
				case 'logoblancolineal':
					$nuevoAncho = 800;
					$nuevoAlto = 117;
					$nombre ="logo-blanco-lineal";
					$carpeta="plantilla";

					break;
				case 'logonegrolineal':
					$nuevoAncho = 800;
					$nuevoAlto = 117;
					$nombre ="logo-negro-lineal";
					$carpeta="plantilla";

					break;
				case 'fotorecibo':
					$nuevoAncho = 500;
					$nuevoAlto = 183;
					$nombre ="logoimpreso";
					$carpeta="empresa";
					
					break;
				default:
					# code...
					break;
			}
				

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/".$carpeta."/".$nombre.".jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

					$valorNuevo = "vistas/img/".$carpeta."/".$nombre.".jpg";

				}

				
					
				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/".$carpeta."/".$nombre.".png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);

					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

					$valorNuevo = "vistas/img/".$carpeta."/".$nombre.".png";

				}

				

			}
			$id = 1;

			$respuesta = ModeloEmpresa::mdlActualizarLogoIcono($tabla, $id, $item, $valorNuevo);

			return $respuesta;
	}

}
