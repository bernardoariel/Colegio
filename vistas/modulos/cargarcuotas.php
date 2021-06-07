<?php

$item = null;
$valor = null;

$respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);

foreach ($respuesta as $key => $value) {
	# code...
	$fecha = explode("-",$value["fecha"]);

    // $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];

	$mimes=$fecha[1]-1;


	$mimes = ControladorVentas::ctrNombreMes($mimes);

	if($mimes=='diciembre'){

		$anio=$fecha[0]-1;

	}else{

 		$anio = $fecha[0];

	}

 	

	$productos = '[{"id":"20","descripcion":"CUOTA MENSUAL '.strtoupper($mimes).'/'.$anio.'","idnrocomprobante":"100","cantventaproducto":"1","folio1":"1","folio2":"1","cantidad":"1","precio":"'.$value['adeuda'].'","total":"'.$value['adeuda'].'"}]';
	
	$datos = array("id"=>$value["id"],
					"productos"=>$productos);

	$tabla = 'ventas';

	ModeloVentas::mdlUpdateProductos($tabla,$datos);
}