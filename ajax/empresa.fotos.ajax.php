<?php

require_once "../controladores/empresa.controlador.php";
require_once "../modelos/empresa.modelo.php";

class AjaxEmpresa{

	/*=============================================
	CAMBIAR BACKEND
	=============================================*/	

	public $tipo;
	public $imagen;

	public function ajaxCambiarImagen(){

		$item = $this ->tipo;
		$valor = $this->imagen;

		$respuesta = ControladorEmpresa::ctrActualizarImagen($item, $valor);
		
		echo $respuesta;	


	}
}
/*=============================================
CAMBIAR ICONO CHICO BLANCO
=============================================*/	
 if(isset($_FILES["iconochicoblanco"])){

	$img = new AjaxEmpresa();
	$img -> imagen = $_FILES["iconochicoblanco"];
	$img -> tipo = 'iconochicoblanco';
	$img -> ajaxCambiarImagen();


}

/*=============================================
CAMBIAR ICONO CHICO NEGRO
=============================================*/	
 if(isset($_FILES["iconochiconegro"])){

	$img = new AjaxEmpresa();
	$img -> imagen = $_FILES["iconochiconegro"];
	$img -> tipo = 'iconochiconegro';
	$img -> ajaxCambiarImagen();


}

/*=============================================
CAMBIAR BLOQUE  BLANCO
=============================================*/	
 if(isset($_FILES["logoblancobloque"])){

	$img = new AjaxEmpresa();
	$img -> imagen = $_FILES["logoblancobloque"];
	$img -> tipo = 'logoblancobloque';
	$img -> ajaxCambiarImagen();


}


/*=============================================
CAMBIAR BLOQUE  LINEAL BLANCO
=============================================*/	
 if(isset($_FILES["logoblancolineal"])){

	$img = new AjaxEmpresa();
	$img -> imagen = $_FILES["logoblancolineal"];
	$img -> tipo = 'logoblancolineal';
	$img -> ajaxCambiarImagen();


}


/*=============================================
CAMBIAR RECIBO FOTO
=============================================*/	
 if(isset($_FILES["fotorecibo"])){

	$img = new AjaxEmpresa();
	$img -> imagen = $_FILES["fotorecibo"];
	$img -> tipo = 'fotorecibo';
	$img -> ajaxCambiarImagen();


}