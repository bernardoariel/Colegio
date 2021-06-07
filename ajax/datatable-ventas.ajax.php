<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class TablaProductos{

  /*=============================================
  MOSTRAR LA TABLA DE PRODUCTO
  =============================================*/ 

  public function mostrarTabla(){

  	if(isset($_GET["fechaInicial"])){

	    $fechaInicial = $_GET["fechaInicial"];
	    $fechaFinal = $_GET["fechaFinal"];
     }else{

	    $fechaInicial = null;
	    $fechaFinal = null;

    }

    $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

    echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){

				 echo '[
			      "'.($i+1).'",
			      "'.$respuesta[$i]["fecha"].'",
			      "'.$respuesta[$i]["codigo"].'",
			      "'.$respuesta[$i]["nrofc"].'",
			      "'.$respuesta[$i]["id_cliente"].'",
			      "'.$respuesta[$i]["metodo_pago"].'",
			      "'.$respuesta[$i]["detalle"].'",
			      "'.$respuesta[$i]["total"].'",
			      "'.$respuesta[$i]["adeuda"].'",
			      "'.$respuesta[$i]["observaciones"].'"
			    ],';

			}

		   echo'[
			      "'.count($respuesta).'",
			      "'.$respuesta[count($respuesta)-1]["fecha"].'",
			      "'.$respuesta[count($respuesta)-1]["codigo"].'",
			      "'.$respuesta[count($respuesta)-1]["nrofc"].'",
			      "'.$respuesta[count($respuesta)-1]["id_cliente"].'",
			      "'.$respuesta[count($respuesta)-1]["metodo_pago"].'",
			      "'.$respuesta[count($respuesta)-1]["detalle"].'",
			      "'.$respuesta[count($respuesta)-1]["total"].'",
			      "'.$respuesta[count($respuesta)-1]["adeuda"].'",
			      "'.$respuesta[count($respuesta)-1]["observaciones"].'"
			    ]
			]
		}';

  }

}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 

$activar = new TablaProductos();
$activar -> mostrarTabla();