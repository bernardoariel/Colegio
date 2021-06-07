<?php

require_once "../modelos/ventas.modelo.php";

class AjaxUltimoId{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	


	public function ajaxUltimoIdBsq(){

		$respuesta = ModeloVentas::mdlUltimoId("ventas");
		echo $respuesta['id'];

		

	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["ultimoId"])){

	$ultimoId = new AjaxUltimoId();
	$ultimoId -> ajaxUltimoIdBsq();
}
