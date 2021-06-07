<?php
#escribanos
require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";
#clientes
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
#grabar
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";



class AjaxNotaCredito{

	/*=============================================
	UPDATE SELECCIONAR VENTA
	=============================================*/	
	public function ajaxNotadeCredito(){

		$datos = array("idVenta"=>$_POST['idVenta'],
					 "idcliente"=>$_POST['idClienteNc'],
		             "nombre"=>$_POST['nombreClienteNc'],
		             "documento"=>$_POST['documentoNc'],
		             "tabla"=>$_POST['tablaNc'],
		             "productos"=>$_POST['productosNc'],
		             "total"=>$_POST['totalNc'],
		         	 "nroFactura"=>$_POST['nroFactura']);		
	
		$respuesta = ControladorVentas::ctrCrearNc($datos);
	
	}	
	
}

/*=============================================
REALIZAR NOTA DE CREDITO
=============================================*/	
if(isset($_POST["idClienteNc"])){

	$verTabla = new AjaxNotaCredito();
	
	$verTabla -> ajaxNotadeCredito();
}


