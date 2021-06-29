<?php

class ControladorRemitos{

	/*=============================================
	MOSTRAR DELEGACIONES
	=============================================*/
	static public function ctrMostrarRemitos($item, $valor){

		$tabla = "remitos";

		$respuesta = ModeloRemitos::mdlMostrarRemitos($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR REMITOS POR FECHA
	=============================================*/
	static public function ctrMostrarRemitosFecha($item, $valor){

		$tabla = "remitos";

		$respuesta = ModeloRemitos::mdlMostrarRemitosFecha($tabla, $item, $valor);

		return $respuesta;
	
	}
	
	
	/*=============================================
	AGREGAR DELEGACIONES
	=============================================*/
	static public function ctrEditarDelegacion($datos){
		
		$tabla = "remitos";

		$respuesta = ModeloRemitos::mdlEditarDelegacion($tabla, $datos);

		return $respuesta;
	
	}

	/*=============================================
	BORRAR DELEGACIONES
	=============================================*/

	static public function ctrEliminarDelegacion(){

		if(isset($_GET["idDelegacion"])){

			$tabla ="delegaciones";
			$datos = $_GET["idDelegacion"];
			
			#ENVIAMOS LOS DATOS
			// ControladorCategorias::ctrbKCategorias($tabla, "id", $_GET["idCategoria"], "ELIMINAR");

			$respuesta = ModeloRemitos::mdlBorrarDelegacion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "La delegacion ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "delegaciones";

									}
								})

					</script>';
			}
		 }
		
	}
static public function ctrUltimoIdRemito(){

		$tabla = "remitos";

		$respuesta = ModeloRemitos::mdlUltimoIdRemito($tabla);

		return $respuesta;

	}
   /*=============================================
	CREAR REMITO
	=============================================*/

	static public function ctrCrearRemito(){

		#tomo los productos
		$listaProductos = json_decode($_POST["listaProductos"], true);
		#creo un array del afip
		$items=Array();

		#recorro $listaproductos para cargarlos en la tabla de comprobantes
		foreach ($listaProductos as $key => $value) {

		    $tablaComprobantes = "comprobantes";

		    $valor = $value["idnrocomprobante"];
		    $datos = $value["folio2"];

		    $actualizarComprobantes = ModeloComprobantes::mdlUpdateComprobante($tablaComprobantes, $valor,$datos);
		    

		    $miItem=$value["descripcion"];

			if ($value['folio1']!=1){

				$miItem.=' del '.$value['folio1'].' al '.$value['folio2'];

				
			}

			$items[$key]=array('codigo' => $value["id"],'descripcion' => $miItem,'cantidad' => $value["cantidad"],'codigoUnidadMedida'=>7,'precioUnitario'=>$value["precio"],'importeItem'=>$value["total"],'impBonif'=>0 );
			
		}

		$fecha = date("Y-m-d");
				
		if ($_POST["listaMetodoPago"]=="CTA.CORRIENTE"){
					
			$adeuda=$_POST["totalVenta"];

			$fechapago="0000-00-00";
					
		}else{
			
			$adeuda=0;

			$fechapago = $fecha;
		}
		
		
		$ptoVenta="0004";
		

		 //ULTIMO NUMERO DE COMPROBANTE Y LO FORMATERO PARA LOGRAR EL CODIGO
	    $item = "nombre";
	    $valor = "remitos";

	    $ultimoComprobante = ControladorVentas::ctrUltimoComprobante($item, $valor);
	    $cantDigitosRemito = strlen($ultimoComprobante['numero']);
	    // echo '<pre>'; print_r($ultimoComprobante); echo '</pre>';
	    
	    switch ($cantDigitosRemito) {
	    	case 1:
	          $ultimoComprobante="0000000".$ultimoComprobante['numero'];
	          break;
	    	case 2:
	          $ultimoComprobante="000000".$ultimoComprobante['numero'];
	          break;
	        case 3:
	          $ultimoComprobante="00000".$ultimoComprobante['numero'];
	          break;
	        case 4:
	          $ultimoComprobante="0000".$ultimoComprobante['numero'];
	          break;
	        case 5:
	          $ultimoComprobante="000".$ultimoComprobante['numero'];
	          break;
	        case 6:
	          $ultimoComprobante="00".$ultimoComprobante['numero'];
	          break;
	        case 7:
	          $ultimoComprobante="0".$ultimoComprobante['numero'];
	          break;
	        case 8:
	          $ultimoComprobante=$ultimoComprobante['numero'];
	          break;
	  }
	        $codigoFactura = $ptoVenta .'-'. $ultimoComprobante;
	    

	            
			$datos = array(
			   "id_vendedor"=>1,
			   "fecha"=>date('Y-m-d'),
			   "codigo"=>$codigoFactura,
			   "tipo"=>'REM',
			   "id_cliente"=>$_POST['seleccionarCliente'],
			   "nombre"=>$_POST['nombreCliente'],
			   "documento"=>$_POST['documentoCliente'],
			   "tabla"=>$_POST['tipoCliente'],
			   "productos"=>$_POST['listaProductos'],
			   "impuesto"=>0,
			   "neto"=>0,
			   "total"=>$_POST["totalVenta"],
			   "adeuda"=>$adeuda,
			   "obs"=>'',
			   "cae"=>'0',
			   "fecha_cae"=>date('Y-m-d'),
			   "fechapago"=>$fechapago,
			   "metodo_pago"=>$_POST['listaMetodoPago'],
			   "referenciapago"=>$_POST['nuevaReferencia']
			);
		
				$tabla = "remitos";

				$respuesta = ModeloRemitos::mdlIngresarVentaRemito($tabla, $datos);
			    
				$codigocomprobante = 3;
				$ultimoRemito =$ultimoComprobante+1;
				ModeloComprobantes::mdlUpdateComprobante("comprobantes",$codigocomprobante,$ultimoRemito);

				if ($_POST["listaMetodoPago"]!='CTA.CORRIENTE'){

				  	  //AGREGAR A LA CAJA
					  $item = "fecha";
			          $valor = date('Y-m-d');

			          $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
			         
			          
			          $efectivo = $caja[0]['efectivo'];
			          $tarjeta = $caja[0]['tarjeta'];
			          $cheque = $caja[0]['cheque'];
			          $transferencia = $caja[0]['transferencia'];

			          switch ($_POST["listaMetodoPago"]) {

			          	case 'EFECTIVO':
			          		# code...
			          		$efectivo = $efectivo + $_POST["totalVenta"];
			          		break;
			          	case 'TARJETA':
			          		# code...
			          		$tarjeta = $tarjeta + $_POST["totalVenta"];
			          		break;
			          	case 'CHEQUE':
			          		# code...
			          		$cheque = $cheque + $_POST["totalVenta"];
			          		break;
			          	case 'TRANSFERENCIA':
			          		# code...
			          		$transferencia = $transferencia + $_POST["totalVenta"];
			          		break;
			          }
			          

			          $datos = array("fecha"=>date('Y-m-d'),
			          
						             "efectivo"=>$efectivo,
						             "tarjeta"=>$tarjeta,
						             "cheque"=>$cheque,
						             "transferencia"=>$transferencia);
			          
			          $caja = ControladorCaja::ctrEditarCaja($item, $datos);
			    }    

	        	echo 'REM';
		
	}

	static public function ctrRealizarPagoRemito(){

		if(isset($_POST["idVentaPago"])){

			// echo '<center><pre>'; print_r($_POST); echo '</pre></center>';
			$tabla = "remitos";

			$datos = array("id"=>$_POST['idVentaPago'],
						   "metodo_pago"=>$_POST['listaMetodoPago'],
						   "referenciapago"=>$_POST["nuevaReferencia"],
						   "fechapago"=>date('Y-m-d'),
						   "adeuda"=>0);

			$respuesta = ModeloVentas::mdlRealizarPagoVenta($tabla, $datos);//REUTILIZO EL CODIGO DE VENTAS PERO CON LA TABLA REMITO
			// echo '<center><pre>'; print_r($respuesta); echo '</pre></center>';

			if($respuesta == "ok"){

				//AGREGAR A LA CAJA
				  $item = "fecha";
		          $valor = date('Y-m-d');

		          $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
		          // echo '<pre>'; print_r($caja); echo '</pre>';
			          
			          
		          $efectivo = $caja[0]['efectivo'];
		          $tarjeta = $caja[0]['tarjeta'];
		          $cheque = $caja[0]['cheque'];
		          $transferencia = $caja[0]['transferencia'];

		          switch ($_POST["listaMetodoPago"]) {

		          	case 'EFECTIVO':
		          		# code...
		          		$efectivo = $efectivo + $_POST["totalVentaPago"];
		          		break;
		          	case 'TARJETA':
		          		# code...
		          		$tarjeta = $tarjeta + $_POST["totalVentaPago"];
		          		break;
		          	case 'CHEQUE':
		          		# code...
		          		$cheque = $cheque + $_POST["totalVentaPago"];
		          		break;
		          	case 'TRANSFERENCIA':
		          		# code...
		          		$transferencia = $transferencia + $_POST["totalVentaPago"];
		          		break;
			        }  
			          
		          	$datos = array("fecha"=>date('Y-m-d'),
					             "efectivo"=>$efectivo,
					             "tarjeta"=>$tarjeta,
					             "cheque"=>$cheque,
					             "transferencia"=>$transferencia);
			          
			        $caja = ControladorCaja::ctrEditarCaja($item, $datos);
				  

				    echo '<script>
				
				 			window.location = "remitos";

				 		</script>';
			}

		}
	}

}
