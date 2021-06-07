<?php

require_once "../controladores/parametros.controlador.php";
require_once "../modelos/parametros.modelo.php";

class AjaxParametros{

	
/*=============================================
VER ATRASO GENERAL
=============================================*/	


	public function ajaxMostrarMaximoAtraso(){

		$item = "parametro";
		$valor = 'maxAtraso';

		$respuesta = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

		echo json_encode($respuesta);


	}

	public $idParametro;

	public function ajaxMostrarParametros(){

		$item = "id";
		$valor = $this->idParametro;

		$respuesta = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

		echo json_encode($respuesta);


	}

	public $idbackup;

	public function ajaxMostrarBackUp(){

		$item = "id";
		$valor = $this->idbackup;

		$respuesta = ControladorParametros::ctrMostrarBackUp($item, $valor);

		echo json_encode($respuesta);


	}

	public function ajaxVerArtBackUp(){

		$item = "id";
		$valor = $_POST["idBackUpArt"];

		$respuesta = ControladorParametros::ctrMostrarBackUp($item, $valor);
		
		$listaProductos = json_decode($respuesta['datos'], true);

		echo json_encode($listaProductos);
		

	}
}

/*=============================================
VER ATRASO GENERAL
=============================================*/	
if(isset($_POST["maxAtraso"])){

	$cliente = new AjaxParametros();
	$cliente -> ajaxMostrarMaximoAtraso();

}

if(isset($_POST["idParametro"])){

	$parametro = new AjaxParametros();
    $parametro -> idParametro = $_POST["idParametro"];
	$parametro -> ajaxMostrarParametros();

}

if(isset($_POST["idbackup"])){

	$parametro = new AjaxParametros();
    $parametro -> idbackup = $_POST["idbackup"];
	$parametro -> ajaxMostrarBackUp();

}

if(isset($_POST["idBackUpArt"])){

	$parametro = new AjaxParametros();
    $parametro -> idBackUpArt = $_POST["idBackUpArt"];
	$parametro -> ajaxVerArtBackUp();

}