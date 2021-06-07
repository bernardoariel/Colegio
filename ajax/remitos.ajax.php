<?php

require_once "../controladores/remitos.controlador.php";
require_once "../modelos/remitos.modelo.php";

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";

class AjaxRemito{

	/*=============================================
	UPDATE SELECCIONAR VENTA
	=============================================*/	
	public function ajaxVerVenta(){

		$item = "id";
		$valor = $_POST["idVenta"];

		$respuesta = ControladorRemitos::ctrMostrarRemitos($item, $valor);
		
		echo json_encode($respuesta);

	}

	/*=============================================
	VER ESCRIBANO
	=============================================*/	
	public function ajaxVerArt(){

		$item = "id";
		$valor = $_POST["idVentaArt"];

		$respuesta = ControladorRemitos::ctrMostrarRemitos($item, $valor);
		
		$listaProductos = json_decode($respuesta['productos'], true);

		echo json_encode($listaProductos);
		

	}

	/*=============================================
	TRAER LA ULTIMA VENTA
	=============================================*/	
	public function ajaxUltimoRemito(){
	
		$respuesta =  ControladorRemitos::ctrUltimoIdRemito();
		echo json_encode($respuesta);

	}

	/*=============================================
	TRAER LA ULTIMA VENTA
	=============================================*/	
	public function ultimoRemito(){
	
		$respuesta =  ControladorRemitos::ctrUltimoIdRemito();
		echo json_encode($respuesta);

	}
	
}



/*=============================================
EDITAR CUENTA CORRIENTE
=============================================*/	
if(isset($_POST["idVenta"])){

	$seleccionarFactura = new AjaxRemito();
	
	$seleccionarFactura -> ajaxVerVenta();
}



/*=============================================
VER ARTICULOS CORRIENTE 
=============================================*/	
if(isset($_POST["idVentaArt"])){

	$verTabla = new AjaxRemito();
	
	$verTabla -> ajaxVerArt();
}

if(isset($_POST["ultimoRemito"])){

	$nuevaVenta = new AjaxRemito();
	$nuevaVenta -> ajaxUltimoRemito();

}

