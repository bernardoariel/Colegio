<?php

require_once "../controladores/osde.controlador.php";
require_once "../modelos/osde.modelo.php";

class AjaxOsde{

	/*=============================================
	EDITAR OSDE
	=============================================*/	

	public $idOsde;

	public function ajaxEditarOsde(){

		$item = "id";
		$valor = $this->idOsde;

		$respuesta = ControladorOsde::ctrMostrarOsde($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idOsde"])){

	$categoria = new AjaxOsde();
	$categoria -> idOsde = $_POST["idOsde"];
	$categoria -> ajaxEditarOsde();
}
