<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxSeleccionarVenta{

	
	/*=============================================
	MOSTRAR FACTURAS SELECCIONADAS
	=============================================*/	
	public function ajaxMostrarFacturas(){

		$item = "seleccionado";
		$valor = $_POST["mostrarSeleccion"];

		$respuesta = ControladorVentas::ctrMostrarFacturasSeleccionadas($item, $valor);
		echo json_encode($respuesta);
		

	}
}



/*=============================================
MOSTRAR SELECCION
=============================================*/	
if(isset($_POST["mostrarSeleccion"])){

	$mostrarFacturasSeleccionadas = new AjaxSeleccionarVenta();
	
	$mostrarFacturasSeleccionadas -> ajaxMostrarFacturas();
}
