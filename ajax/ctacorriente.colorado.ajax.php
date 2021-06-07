<?php

require_once "../controladores/enlace.controlador.php";
require_once "../modelos/enlace.modelo.php";

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";

class AjaxCtaCorrienteVentaColorado{

	/*=============================================
	UPDATE SELECCIONAR VENTA
	=============================================*/	
	public function ajaxVerVentaColorado(){

		$item = "id";
		$valor = $_POST["idVenta"];

		$respuesta = ControladorEnlace::ctrMostrarVentasColorado($item, $valor);
		
		echo json_encode($respuesta);

		

	}

	/*=============================================
	VER ESCRIBANO
	=============================================*/	
	public function ajaxVerEscribano(){

		$itemCliente = "id";
      	$valorCliente = $_POST["idEscribano"];

      	$respuestaCliente = ControladorEscribanos::ctrMostrarEscribanos($itemCliente, $valorCliente);
		
		echo json_encode($respuestaCliente);

	}

	/*=============================================
	VER ESCRIBANO
	=============================================*/	
	public function ajaxVerArtColorado(){

		$item = "id";
		$valor = $_POST["idVentaArt"];

		$respuesta = ControladorEnlace::ctrMostrarVentasColorado($item, $valor);
		
		$listaProductos = json_decode($respuesta['productos'], true);

		echo json_encode($listaProductos);
		

	}

	/*=============================================
	VER ESCRIBANO
	=============================================*/	
	public function ajaxVerPagoDerechoColorado(){

		$item = "id";
		$valor = $_POST["idPagoDerecho"];

		$respuesta = ControladorEnlace::ctrMostrarVentasColorado($item, $valor);
		
		$listaProductos = json_decode($respuesta['productos'], true);

		echo json_encode($listaProductos);
		

	}
	
}

/*=============================================
EDITAR CUENTA CORRIENTE
=============================================*/	
if(isset($_POST["idVenta"])){


	$seleccionarFactura = new AjaxCtaCorrienteVentaColorado();
	
	$seleccionarFactura -> ajaxVerVentaColorado();
}

/*=============================================
VER CUENTA CORRIENTE CLIENTE
=============================================*/	
if(isset($_POST["idEscribano"])){

	$verEscribano = new AjaxCtaCorrienteVentaColorado();
	
	$verEscribano -> ajaxVerEscribano();
}

/*=============================================
VER ARTICULOS CORRIENTE 
=============================================*/	
if(isset($_POST["idVentaArt"])){

	$verTabla = new AjaxCtaCorrienteVentaColorado();
	
	$verTabla -> ajaxVerArtColorado();
}

/*=============================================
VER ARTICULOS CORRIENTE 
=============================================*/	
if(isset($_POST["idPagoDerecho"])){

	$verTabla = new AjaxCtaCorrienteVentaColorado();
	
	$verTabla -> ajaxVerPagoDerechoColorado();
}


