<?php

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";

class AjaxEscribano{

	/*=============================================
	EDITAR ESCRIBANO
	=============================================*/	

	
	public $idEscribano;

	public function ajaxEditarEscribano(){

		$item = "id";
		$valor = $this->idEscribano;

		$respuesta = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR ESCRIBANO
=============================================*/	

if(isset($_POST["idEscribano"])){

	$escribano = new AjaxEscribano();
	$escribano -> idEscribano = $_POST["idEscribano"];
	
	$escribano -> ajaxEditarEscribano();

}