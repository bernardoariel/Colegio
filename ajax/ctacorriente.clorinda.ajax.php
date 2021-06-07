<?php

require_once "../controladores/enlace.controlador.php";
require_once "../modelos/enlace.modelo.php";

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";

class AjaxCtaCorrienteVentaClorinda{

	/*=============================================
	UPDATE SELECCIONAR VENTA
	=============================================*/	
	public function ajaxVerVentaClorinda(){

		$item = "id";
		$valor = $_POST["idVenta"];

		$respuesta = ControladorEnlace::ctrMostrarVentasClorinda($item, $valor);
		
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
	public function ajaxVerArtClorinda(){

		$item = "id";
		$valor = $_POST["idVentaArt"];

		$respuesta = ControladorEnlace::ctrMostrarVentasClorinda($item, $valor);
		
		$listaProductos = json_decode($respuesta['productos'], true);

		echo json_encode($listaProductos);
		

	}

	/*=============================================
	VER ESCRIBANO
	=============================================*/	
	public function ajaxVerPagoDerechoClorinda(){

		$item = "id";
		$valor = $_POST["idPagoDerecho"];

		$respuesta = ControladorEnlace::ctrMostrarVentasClorinda($item, $valor);
		
		$listaProductos = json_decode($respuesta['productos'], true);

		echo json_encode($listaProductos);
		

	}
	
}

/*=============================================
EDITAR CUENTA CORRIENTE
=============================================*/	
if(isset($_POST["idVenta"])){


	$seleccionarFactura = new AjaxCtaCorrienteVentaClorinda();
	
	$seleccionarFactura -> ajaxVerVentaClorinda();
}

/*=============================================
VER CUENTA CORRIENTE CLIENTE
=============================================*/	
if(isset($_POST["idEscribano"])){

	$verEscribano = new AjaxCtaCorrienteVentaClorinda();
	
	$verEscribano -> ajaxVerEscribano();
}

/*=============================================
VER ARTICULOS CORRIENTE 
=============================================*/	
if(isset($_POST["idVentaArt"])){

	$verTabla = new AjaxCtaCorrienteVentaClorinda();
	
	$verTabla -> ajaxVerArtClorinda();
}

/*=============================================
VER ARTICULOS CORRIENTE 
=============================================*/	
if(isset($_POST["idPagoDerecho"])){

	$verTabla = new AjaxCtaCorrienteVentaClorinda();
	
	$verTabla -> ajaxVerPagoDerechoClorinda();
}


