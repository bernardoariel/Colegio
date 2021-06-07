<?php

class ControladorArticulos{

	/*=============================================
	MOSTRAR ESCRIBANOS
	=============================================*/

	static public function ctrMostrarArticulos($item, $valor){

		$tabla = "articulos";

		$respuesta = ModeloArticulos::mdlMostrarArticulos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR ESCRIBANOS
	=============================================*/

	static public function ctrCrearArticulo($datos){

		$tabla="articulos";
			   	
		$respuesta = ModeloArticulos::mdlIngresarArticulo($tabla, $datos);


	}
	
	/*=============================================
	CREAR PREPARAR ARTICULOS PARA INGRESAR
	=============================================*/

	static public function ctrPrepararIngresoArticulo(){

		#tomo los productos
		$listarProductos = json_decode($_POST["listaProductos"], true);
		#creo un array del afip
		$items=Array();

		foreach ($listarProductos as $key => $value) {


			if ($value['folio1']!=1){

				$respuesta = ControladorVentas::ctrUltimoId();

				$i = $value['folio1'];

				for ($i; $i <= $value['folio2'] ; $i++) { 
					# code...
					$datos = array("folio"=>$i,
								   "nrocomprobante"=>$value["idnrocomprobante"],
					               "nombre"=>$value["descripcion"],
					               "idfactura"=>$respuesta[0],
					               "fecha"=>"10/10/10",
					               "nrofactura"=>$respuesta['codigo'],
					           	   "nombrecliente"=>$_POST['nombreCliente']);
					print_r($_POST);
					$registro = ControladorArticulos::ctrCrearArticulo($datos);
					
				}
			}
		}
	
}


}