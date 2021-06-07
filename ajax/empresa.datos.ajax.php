<?php

require_once "../controladores/empresa.controlador.php";
require_once "../modelos/empresa.modelo.php";

class AjaxEmpresa{

	/*=============================================
	CAMBIAR DATOS
	=============================================*/	

	public $editarEmpresa;
    public $editarDireccion;
    public $editarTelefono;
    public $editarEmail;
    public $editarCuit;
    public $editarWeb;
    public $editarDetalle1;
    public $editarDetalle2;
   
	public function ajaxCambiarDatos(){

		$empresa = $this->editarEmpresa;
		$direccion = $this->editarDireccion;
		$telefono = $this->editarTelefono;
		$email = $this->editarEmail;
		$cuit = $this->editarCuit;
		$web = $this->editarWeb;
		$detalle1 = $this->editarDetalle1;
		$detalle2 = $this->editarDetalle2;

		$datos = array("empresa" => $empresa ,
					   "direccion" => $direccion,
					   "telefono" => $telefono,
					   "email" => $email,
					   "cuit" => $cuit,
					   "web" => $web,
					   "detalle1" => $detalle1,
					   "detalle2" => $detalle2);
		

		$respuesta = ControladorEmpresa::ctrEditarEmpresa($datos);
		
		echo $respuesta;	


	}
}

/*=============================================
CAMBIAR DATOS
=============================================*/	
$empresaDatos = new AjaxEmpresa();

$empresaDatos -> editarEmpresa = $_POST["editarEmpresa"];
$empresaDatos -> editarDireccion = $_POST["editarDireccion"];
$empresaDatos -> editarTelefono = $_POST["editarTelefono"];
$empresaDatos -> editarEmail = $_POST["editarEmail"];
$empresaDatos -> editarCuit = $_POST["editarCuit"];
$empresaDatos -> editarWeb = $_POST["editarWeb"];
$empresaDatos -> editarDetalle1 = $_POST["editarDetalle1"];
$empresaDatos -> editarDetalle2 = $_POST["editarDetalle2"];

$empresaDatos -> ajaxCambiarDatos();


