<?php

require_once "../controladores/delegaciones.controlador.php";
require_once "../modelos/delegaciones.modelo.php";

class AjaxDelegaciones{

	// /*=============================================
	// CREO LA NUEVA DELEGACION
	// =============================================*/	
	
	public function ajaxCrearDelegaciones(){

		#CREO UN NUEVO CLIENTE
		$datos = array("nombre"=>strtoupper($_POST["nombreDelegacion"]),
			   		   "direccion"=>$_POST["direccion"],
			           "localidad"=>strtoupper($_POST["localidad"]),
			           "telefono"=>strtoupper($_POST["telefono"]),
			           "puntodeventa"=>strtoupper($_POST["puntodeventa"]),
			           "idescribano"=>$_POST["idescribano"],
			      	   "escribano"=>strtoupper($_POST["escribano"]));

		$respuesta = ControladorDelegaciones::ctrIngresarDelegacion($datos);

		return $respuesta;
		
	}

	/*=============================================
	EDITAR DELEGACION
	=============================================*/	

	public $idDelegacion;

	public function ajaxBuscarDelegacion(){

		$item = "id";
		$valor = $this->idDelegacion;

		$respuesta = ControladorDelegaciones::ctrMostrarDelegaciones($item, $valor);

		echo json_encode($respuesta);

	}

	// /*=============================================
	// EDITAR DELEGACION
	// =============================================*/	
	
	public function ajaxEditarDelegacion(){

		#CREO UN NUEVO CLIENTE
		$datos = array("id"=>strtoupper($_POST["idEditar"]),
					   "nombre"=>strtoupper($_POST["nombreDelegacionEditar"]),
			   		   "direccion"=>$_POST["direccionEditar"],
			           "localidad"=>strtoupper($_POST["localidadEditar"]),
			           "telefono"=>strtoupper($_POST["telefonoEditar"]),
			           "puntodeventa"=>strtoupper($_POST["puntodeventaEditar"]),
			           "idescribano"=>$_POST["idescribanoEditar"],
			      	   "escribano"=>strtoupper($_POST["escribanoEditar"]));

		 	 $respuesta = ControladorDelegaciones::ctrEditarDelegacion($datos);

		// print_r ($datos);
		
	}



}

/*=============================================
CREAR NUEVA DELEGACION
=============================================*/	
if(isset($_POST["nombreDelegacion"])){

	$delegaciones = new AjaxDelegaciones();
	$delegaciones -> ajaxCrearDelegaciones();
}

/*=============================================
BUSCAR DELEGACION
=============================================*/	
if(isset($_POST["idDelegacion"])){

	$delegacion = new AjaxDelegaciones();
	$delegacion -> idDelegacion = $_POST["idDelegacion"];
	$delegacion -> ajaxBuscarDelegacion();
}

/*=============================================
EDITAR DELEGACION
=============================================*/	
if(isset($_POST["nombreDelegacionEditar"])){

	$delegaciones = new AjaxDelegaciones();
	$delegaciones -> ajaxEditarDelegacion();
}
