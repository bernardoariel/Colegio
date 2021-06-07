<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{

	// /*=============================================
	// CREO EL CLIENTE
	// =============================================*/	

	
	public function ajaxCrearClientes(){

		#CREO UN NUEVO CLIENTE
		$datos = array("nombre"=>strtoupper($_POST["nombreAgregarCliente"]),
			   		   "cuit"=>$_POST["documentoAgregarCliente"],
			           "tipoiva"=>strtoupper($_POST["tipoCuitAgregarCliente"]),
			           "direccion"=>strtoupper($_POST["direccionAgregarCliente"]),
			           "localidad"=>strtoupper($_POST["localidadAgregarCliente"]));

		ControladorClientes::ctrCrearCliente($datos);

		#TOMO EL ULTIMO ID PARA COLOCARLO EN EL FORMULARIO
		$respuesta = ControladorClientes::ctrUltimoCliente();

		echo json_encode($respuesta);
		

	}

	public function ajaxBuscarClientes(){

		$item = "cuit";
		$valor = $_POST["documentoVerificar"];

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);

	}

	public function ajaMostrarCliente(){
		
		$item = "id";
		$valor = $_POST["idCliente"];

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);

	}

	// /*=============================================
	// EDITAR CLIENTE
	// =============================================*/	

	
	public function ajaXEditarCliente(){

		#CREO UN NUEVO CLIENTE
		$datos = array("id"=>strtoupper($_POST["idClienteEditar"]),
					   "nombre"=>strtoupper($_POST["nombreEditarCliente"]),
			   		   "cuit"=>$_POST["documentoEditarCliente"],
			           "tipoiva"=>strtoupper($_POST["tipoCuitEditarCliente"]),
			           "direccion"=>strtoupper($_POST["direccionEditarCliente"]),
			           "localidad"=>strtoupper($_POST["localidadEditarCliente"]));
		echo '<pre>'; print_r($datos); echo '</pre>';
		ControladorClientes::ctrEditarCliente($datos);
		

		#TOMO EL ULTIMO ID PARA COLOCARLO EN EL FORMULARIO
		// $respuesta = ControladorClientes::ctrUltimoCliente();

		// echo json_encode($respuesta);
		

	}

}
/*=============================================
EDITAR CLIENTES
=============================================*/	
if(isset($_POST["nombreAgregarCliente"])){

	$clientes = new AjaxClientes();
	$clientes -> ajaxCrearClientes();
}
/*=============================================
bUSCAR cLIENTE x cuit
=============================================*/	
if(isset($_POST["documentoVerificar"])){

	$clientes = new AjaxClientes();
	$clientes -> ajaxBuscarClientes();
}
/*=============================================
bUSCAR cLIENTE por id
=============================================*/	
if(isset($_POST["idCliente"])){

	$clientes = new AjaxClientes();
	$clientes -> ajaMostrarCliente();
}
/*=============================================
bUSCAR cLIENTE por id
=============================================*/	
if(isset($_POST["idClienteEditar"])){

	$clientes = new AjaxClientes();
	$clientes -> ajaXEditarCliente();
}
