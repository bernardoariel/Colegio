<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxPerfil{

	/*=============================================
	CAMBIAR FOTO PERFIL
	=============================================*/	

	public $tipo;
	public $miFotoPerfil;
	public $idUsuario;
	public $carpeta;
	public $foto;

	public function ajaxCambiarPerfil(){

		$item = $this ->tipo;
		$valor = $this->miFotoPerfil;
		$idUsuario = $this->idUsuario;
		$carpeta = $this->carpeta;
		$foto = $this->foto;
		
		$respuesta = ControladorUsuarios::ctrActualizarFoto($item, $valor, $idUsuario,$carpeta,$foto);
		
		echo $respuesta;	


	}

	
	public $miPass;
	public $idUsuario2;

	public function ajaxCambiarPass(){

		$idUsuario2 = $this->idUsuario2;
		$pass = $this->miPass;
		
		$respuesta = ControladorUsuarios::ctrActualizarPass($idUsuario2,$pass);
		
		echo $respuesta;	


	}

}
/*=============================================
CAMBIAR FOTO PERFIL
=============================================*/	
 if(isset($_FILES["miFotoPerfil"])){

	$img = new AjaxPerfil();
	$img -> miFotoPerfil = $_FILES["miFotoPerfil"];
	$img -> tipo = 'iconochicoblanco';
	$img -> idUsuario = $_POST['idUsuario'];
	$img -> carpeta = $_POST['carpeta'];
	$img -> foto = $_POST['foto'];

	$img -> ajaxCambiarPerfil();


}

/*=============================================
CAMBIAR CONTRASEÑA
=============================================*/	
 if(isset($_POST["miPass"])){

	$pass = new AjaxPerfil();
	$pass -> idUsuario2 = $_POST['idUsuario2'];
	$pass -> miPass = $_POST['miPass'];

	$pass -> ajaxCambiarPass();


}