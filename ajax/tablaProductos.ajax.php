<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/comprobantes.controlador.php";
require_once "../modelos/comprobantes.modelo.php";



class TablaProductos{

	/*=============================================
	MOSTRAR LA TABLA DE PRODUCTOS
	=============================================*/
	public $tipoCliente;
	public $categoria;
	public function mostrarTablaProductos(){
		
		$valorTipoCliente = $this->tipoCliente;

		$item = null;
        $valor = null;
        $orden = "nombre";
		
        $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
		
		$datosJson = '{
			"data": [';
			
			for($i = 0; $i < count($productos); $i++){
				
		
			switch ($valorTipoCliente) {
				
				case 'casual':
					
					if($productos[$i]["vista_consumidor_final"]==1){

						$botones = "<button class='btn btn-primary btnSeleccionarProducto' idProducto='".$productos[$i]["id"]."' idNroComprobante='".$productos[$i]["nrocomprobante"]."' cantVentaProducto='".$productos[$i]["cantventa"]."' productoNombre='".$productos[$i]["nombre"]."' precioVenta='".$productos[$i]["importe"]."'>Seleccionar</button>";
			
						$datosJson .='[
						"'.($i+1).'",
						"'.$productos[$i]['nombre'].'",
						"'.$productos[$i]['importe'].'",
						"'.$botones.'"
						],';

					}
					
					break;
				
				case 'consumidorfinal':
					
					if($productos[$i]["vista_consumidor_final"]==1){

						$botones = "<button class='btn btn-primary btnSeleccionarProducto' idProducto='".$productos[$i]["id"]."' idNroComprobante='".$productos[$i]["nrocomprobante"]."' cantVentaProducto='".$productos[$i]["cantventa"]."' productoNombre='".$productos[$i]["nombre"]."' precioVenta='".$productos[$i]["importe"]."'>Seleccionar</button>";
			
						$datosJson .='[
						"'.($i+1).'",
						"'.$productos[$i]['nombre'].'",
						"'.$productos[$i]['importe'].'",
						"'.$botones.'"
						],';

					}
					
					break;
				
					case 'clientes':
					
						if($productos[$i]["vista_clientes"]==1){

							$botones = "<button class='btn btn-primary btnSeleccionarProducto' idProducto='".$productos[$i]["id"]."' idNroComprobante='".$productos[$i]["nrocomprobante"]."' cantVentaProducto='".$productos[$i]["cantventa"]."' productoNombre='".$productos[$i]["nombre"]."' precioVenta='".$productos[$i]["importe"]."'>Seleccionar</button>";
			
								$datosJson .='[
								"'.($i+1).'",
								"'.$productos[$i]['nombre'].'",
								"'.$productos[$i]['importe'].'",
								"'.$botones.'"
								],';
						}
						break;
					case 'delegacion':
						$botones = "<button class='btn btn-primary btnSeleccionarProducto' idProducto='".$productos[$i]["id"]."' idNroComprobante='".$productos[$i]["nrocomprobante"]."' cantVentaProducto='".$productos[$i]["cantventa"]."' productoNombre='".$productos[$i]["nombre"]."' precioVenta='".$productos[$i]["importe"]."'>Seleccionar</button>";
		
								$datosJson .='[
								"'.($i+1).'",
								"'.$productos[$i]['nombre'].'",
								"'.$productos[$i]['importe'].'",
								"'.$botones.'"
								],';

						break;
					
					case 'escribanos':
						
						if($productos[$i]["vista_escribanos"]==1){ //si la vista esta aprobada para todos los escribanos
							
							if($productos[$i]["vista_categoria"]!=$this->categoria){

								$botones = "<button class='btn btn-primary btnSeleccionarProducto' idProducto='".$productos[$i]["id"]."' idNroComprobante='".$productos[$i]["nrocomprobante"]."' cantVentaProducto='".$productos[$i]["cantventa"]."' productoNombre='".$productos[$i]["nombre"]."' precioVenta='".$productos[$i]["importe"]."'>Seleccionar</button>";
		
								$datosJson .='[
								"'.($i+1).'",
								"'.$productos[$i]['nombre'].'",
								"'.$productos[$i]['importe'].'",
								"'.$botones.'"
								],';
							}
							
						}
					
						break;
				
			}

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=   '] 

		}';
		
		echo $datosJson;
	}

}

/*=============================================
ACTIVAR LA TABLA DE PRODUCTOS
=============================================*/
$activarProductos = new TablaProductos();
$activarProductos -> tipoCliente = $_POST["tipoCliente"];
$activarProductos -> categoria = $_POST["categoria"];
$activarProductos -> mostrarTablaProductos();


        
        

      