<?php

require_once "../controladores/cuotas.controlador.php";
require_once "../modelos/cuotas.modelo.php";

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/osde.controlador.php";
require_once "../modelos/osde.modelo.php";
class AjaxCuota{

	/*=============================================
	EDITAR CUOTAS
	=============================================*/	

	public function ajaxGenerarCuota(){

		/*=============================================
          =            GENERO LAS CUOTAS         =
          =============================================*/

          $item = null;
          $valor = null;

          $GenerarCuota = ControladorCuotas::ctrGeneraCuota($item, $valor);
          echo '<pre>'; print_r($GenerarCuota); echo '</pre>';

	}

	/*=============================================
	EDITAR OSDE
	=============================================*/	

	public function ajaxGenerarOsde(){

		/*=============================================
          =            GENERO LAS CUOTAS         =
          =============================================*/

          $item = null;
          $valor = null;

          $GenerarOsde = ControladorCuotas::ctrGeneraOsde($item, $valor);
          echo '<pre>'; print_r($GenerarOsde); echo '</pre>';
	}

}

/*=============================================
EDITAR CUOTAS
=============================================*/	
if(isset($_POST["cuotas"])){

	$cuotas = new AjaxCuota();
	$cuotas -> ajaxGenerarCuota();
}
/*=============================================
EDITAR CUOTAS
=============================================*/	
if(isset($_POST["osde"])){

	$cuotas = new AjaxCuota();
	$cuotas -> ajaxGenerarOsde();
}