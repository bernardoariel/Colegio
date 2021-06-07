<?php

require_once "../controladores/rubros.controlador.php";
require_once "../modelos/rubros.modelo.php";

class AjaxRubros{

	/*=============================================
	EDITAR RUBRO
	=============================================*/	

	public $idRubro;

	public function ajaxEditarRubro(){

		$item = "id";
		$valor = $this->idRubro;

		$respuesta = ControladorRubros::ctrMostrarRubros($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR RUBRO
=============================================*/	
if(isset($_POST["idRubro"])){

	$categoria = new AjaxRubros();
	$categoria -> idRubro = $_POST["idRubro"];
	$categoria -> ajaxEditarRubro();
}
