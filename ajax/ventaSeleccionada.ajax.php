<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxSeleccionarVenta{

	/*=============================================
	UPDATE SELECCIONAR VENTA
	=============================================*/	
	public function ajaxSeleccionoVenta(){

		$item = "id";
		$valor = $_POST["idVenta"];

		$respuesta = ControladorVentas::ctrSeleccionarVenta($item, $valor);
		

	}

	
}

/*=============================================
EDITAR VENTA
=============================================*/	
if(isset($_POST["idVenta"])){

	$seleccionarFactura = new AjaxSeleccionarVenta();
	
	$seleccionarFactura -> ajaxSeleccionoVenta();
}

