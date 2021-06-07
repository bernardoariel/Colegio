<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		return $respuesta;

	}
	static public function ctrMostrarCuotas($item, $valor){

		$tabla = "cuotas";

		$respuesta = ModeloVentas::mdlMostrarCuotas($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarVentasFecha($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentasFecha($tabla, $item, $valor);

		return $respuesta;

	}
	
	static public function ctrMostrarVentasClientes($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentasClientes($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarVentasEscribanos($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentasEscribanos($tabla, $item, $valor);

		return $respuesta;

	}
	
	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearVenta(){

		
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
		
		include('../extensiones/afip/afip.php');

		/*=============================================
				GUARDAR LA VENTA
		=============================================*/	
		$tabla = "ventas";

		$fecha = date("Y-m-d");
			
		if ($_POST["listaMetodoPago"]=="CTA.CORRIENTE"){
			
			$adeuda=$_POST["totalVenta"];

			$fechapago="0000-00-00";
			
		}else{
			
			$adeuda = 0;

			$fechapago = $fecha;
		}
	
		if($ERRORAFIP==0){

			$result = $afip->emitirComprobante($regcomp); //$regcomp debe tener la estructura esperada (ver a continuación de la wiki)
			
			if ($result["code"] === Wsfev1::RESULT_OK) {
				
			/*=============================================
			FORMATEO LOS DATOS
			=============================================*/	
			
			$cantCabeza = strlen($PTOVTA); 
			switch ($cantCabeza) {
					case 1:
			          $ptoVenta="000".$PTOVTA;
			          break;
					case 2:
			          $ptoVenta="00".$PTOVTA;
			          break;
				  case 3:
			          $ptoVenta="0".$PTOVTA;
			          break;   
			}

	        $codigoFactura = $ptoVenta .'-'. $ultimoComprobante;
	        $fechaCaeDia = substr($result["fechaVencimientoCAE"],-2);
			$fechaCaeMes = substr($result["fechaVencimientoCAE"],4,-2);
			$fechaCaeAno = substr($result["fechaVencimientoCAE"],0,4);
			
			$afip=1;
	            
	        	
		    if($_POST['listaMetodoPago']=="CTA.CORRIENTE"){

				$adeuda = $_POST['totalVenta'];

			}else{

				$adeuda = 0;

			}
			$totalVenta = $_POST["totalVenta"];
			include('../extensiones/qr/index.php');

	        $datos = array(
				   "id_vendedor"=>1,
				   "fecha"=>date('Y-m-d'),
				   "codigo"=>$codigoFactura,
				   "tipo"=>'FC',
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
				   "cae"=>$result["cae"],
				   "fecha_cae"=>$fechaCaeDia.'/'.$fechaCaeMes.'/'.$fechaCaeAno,
				   "fechapago"=>$fechapago,
				   "metodo_pago"=>$_POST['listaMetodoPago'],
				   "referenciapago"=>$_POST['nuevaReferencia'],
				   "qr"=>$datos_cmp_base_64."="
				   );    
			
			$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);

	        }
		}
			
        if(isset($respuesta)){

        	if($respuesta == "ok"){

        		if($afip==1){

        			/*=============================================
					AGREGAR EL NUMERO DE COMPROBANTE
					=============================================*/
					
				  	$tabla = "comprobantes";
					$datos = $ult;
					
					ModeloVentas::mdlAgregarNroComprobante($tabla, $datos);
					$nroComprobante = substr($_POST["nuevaVenta"],8);

					//ULTIMO NUMERO DE COMPROBANTE
					$item = "nombre";
					$valor = "FC";

					$registro = ControladorVentas::ctrUltimoComprobante($item, $valor);
        		}
			
			  
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
        	}
		
			  
        	if($afip==1){

        		 echo 'FE';

			}else{

				echo "ER";

			}

		}



	}
    

	static public function ctrHomologacionVenta(){

		if(isset($_POST["idVentaHomologacion"])){

			$item="id";
			$valor=$_POST["idVentaHomologacion"];
			$ventas=ControladorVentas::ctrMostrarVentas($item,$valor);

			$listaProductos = json_decode($ventas["productos"], true);
			$items=Array();//del afip
			
			foreach ($listaProductos as $key => $value) {

				$items[$key]=array('codigo' => $value["id"],'descripcion' => $value["descripcion"],'cantidad' => $value["cantidad"],'codigoUnidadMedida'=>7,'precioUnitario'=>$value["precio"],'importeItem'=>$value["total"],'impBonif'=>0);
				
			}

			$nombre=$ventas['nombre'];
			$documento=$ventas['documento'];
			$tabla=$ventas['tabla'];

		   

			include('../extensiones/afip/homologacion.php');


			/*=============================================
				GUARDAR LA VENTA
			=============================================*/	
			if($ERRORAFIP==0){

				$result = $afip->emitirComprobante($regcomp); //$regcomp debe tener la estructura esperada (ver a continuación de la wiki)
				
		        
		        if ($result["code"] === Wsfev1::RESULT_OK) {
		        	
		        	$cantCabeza = strlen($PTOVTA); 
					switch ($cantCabeza) {
							case 1:
					          $ptoVenta="000".$PTOVTA;
					          break;
							case 2:
					          $ptoVenta="00".$PTOVTA;
					          break;
						  case 3:
					          $ptoVenta="0".$PTOVTA;
					          break;   
					}

				    $codigoFactura = $ptoVenta .'-'. $ultimoComprobante;
					
					$fechaCaeDia = substr($result["fechaVencimientoCAE"],-2);
					$fechaCaeMes = substr($result["fechaVencimientoCAE"],4,-2);
					$fechaCaeAno = substr($result["fechaVencimientoCAE"],0,4);

		        	$tabla = "comprobantes";
					$datos = $ult;
						
					ModeloVentas::mdlAgregarNroComprobante($tabla, $datos);
					$numeroDoc=$documento;
					$totalVenta=$ventas["total"];
					include('../extensiones/qr/index.php');

					$datos = array("id"=>$_POST["idVentaHomologacion"],
						           "fecha" => date('Y-m-d'),
								   "codigo"=>$codigoFactura,
								   "nombre"=>$nombre,
							       "documento"=>$documento,
								   "cae"=>$result["cae"],
								   "fecha_cae"=>$fechaCaeDia.'/'.$fechaCaeMes.'/'.$fechaCaeAno,"qr"=>$datos_cmp_base_64."=");

					$tabla="ventas";

					$respuesta = ModeloVentas::mdlHomologacionVenta($tabla,$datos);

					echo 'FE';
				

				}

			}else{

				echo "ER";
				
			}

		}


	}

	

	


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

			if(isset($_GET["password"])){
				
				$tabla = "ventas";

				$item = "id";
				$valor = $_GET["idVenta"];

				$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
				echo '<pre>'; print_r($traerVenta); echo '</pre>';

				/*=============================================
				ELIMINAR VENTA
				=============================================*/

				//AGREGAR A LA CAJA
					  $item = "fecha";
			          $valor = $traerVenta['fechapago'];

			          $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
			          echo '<pre>'; print_r($caja); echo '</pre>';
				          
				          
			          $efectivo = $caja[0]['efectivo'];
			          $tarjeta = $caja[0]['tarjeta'];
			          $cheque = $caja[0]['cheque'];
			          $transferencia = $caja[0]['transferencia'];

			          switch ($traerVenta['metodo_pago']){

			          	case 'EFECTIVO':
			          		# code...
			          		$efectivo = $efectivo - $traerVenta["total"];
			          		break;
			          	case 'TARJETA':
			          		# code...
			          		$tarjeta = $tarjeta - $traerVenta["total"];
			          		break;
			          	case 'CHEQUE':
			          		# code...
			          		$cheque = $cheque - $traerVenta["total"];
			          		break;
			          	case 'TRANSFERENCIA':
			          		# code...
			          		$transferencia = $transferencia - $traerVenta["total"];
			          		break;
				        }  
				          
			          	$datos = array("fecha"=>$traerVenta['fechapago'],
						             "efectivo"=>$efectivo,
						             "tarjeta"=>$tarjeta,
						             "cheque"=>$cheque,
						             "transferencia"=>$transferencia);
				          
				        $caja = ControladorCaja::ctrEditarCaja($item, $datos);

				$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "La venta ha sido borrada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "ventas";

										}
									})

						</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "warning",
						  title: "La autenticacion es incorrecta",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "ventas";

									}
								})

					</script>';
			}

		
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	static public function ctrRangoFechasVentas2($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas2($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	static public function ctrRangoFechasCtaCorriente($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasCtaCorriente($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	static public function ctrRangoFechasaFacturar($fechaInicial, $fechaFinal){

		$tabla = "cuotas";

		$respuesta = ModeloVentas::mdlRangoFechasaFacturar($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}
	static public function ctrRangoFechasaFacturarVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasaFacturar($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}
	static public function ctrTmpVentasCopia($tipo){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlTmpVentasCopia($tabla, $tipo);

		return $respuesta;
		
	}
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentasCobrados($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentasCobrados($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentasNroFc($fechaInicial, $fechaFinal, $nrofc){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentasNroFc($tabla, $fechaInicial, $fechaFinal, $nrofc);

		return $respuesta;
		
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentasMetodoPago($fechaInicial, $fechaFinal, $metodoPago){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentasMetodoPago($tabla, $fechaInicial, $fechaFinal, $metodoPago);

		return $respuesta;
		
	}

	/*=============================================
	LISTADO DE ETIQUETAS
	=============================================*/	

	static public function ctrEtiquetasVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlEtiquetasVentas($tabla);

		return $respuesta;
		
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentasCtaCorriente($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::RangoFechasVentasCtaCorriente($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	SELECCIONO UNA FACTURA PARA LA ETIQUETA
	=============================================*/
	static public function ctrSeleccionarVenta($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSeleccionarVenta($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MUESTRO LAS FACTURAS SELECCIONADAS
	=============================================*/
	static public function ctrMostrarFacturasSeleccionadas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarFacturasSeleccionadas($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	BORRAR LAS FACTURAS SELECCIONADAS
	=============================================*/
	static public function ctrBorrarFacturasSeleccionadas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlBorrarFacturasSeleccionadas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	BORRAR PAGO DE LAS FACTURAS
	=============================================*/
	static public function ctrEliminarPago(){

		if(isset($_GET["idPago"])){

			$tabla = "ventas";

			$valor =$_GET["idPago"];

			$respuesta = ModeloVentas::mdlEliminarPago($tabla,$valor);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El pago ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}		
		}

	}
	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = $_GET["ruta"];

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ControladorEnlace::ctrRangoFechasEnlace($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}
				// else{

			// 	$item = null;
			// 	$valor = null;

			// 	$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			// }


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["ruta"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TIPO</td>  
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>				
					</tr>");

			foreach ($ventas as $row => $item){
				
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["fecha"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["tipo"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["documento"]."</td>
			 			");

			 	$productos =  json_decode($item["productos"], true);

			 	echo utf8_decode("<td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["descripcion"]." ".$valueProductos["folio1"]."-".$valueProductos["folio2"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>	
		 			</tr>");
			}


			echo "</table>";

		}

	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentasEntreFechas($fechaInicial,$fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentasEntreFechas($tabla,$fechaInicial,$fechaFinal);

		return $respuesta;

	}

	public function ctrUltimoComprobante($item,$valor){

		$tabla = "comprobantes";

		$respuesta = ModeloVentas::mdlUltimoComprobante($tabla, $item, $valor);
		
		return $respuesta;
				
		
	} 

	#ACTUALIZAR PRODUCTO EN CTA_ART_TMP
	#---------------------------------
	public function ctrAgregarTabla($datos){

		
		echo '<table class="table table-bordered">
                <tbody>
                    <tr>
                      <th style="width: 10px;">#</th>
                      <th style="width: 10px;">Cantidad</th>
                      <th style="width: 400px;">Articulo</th>
                      <th style="width: 70px;">Precio</th>
                      <th style="width: 70px;">Total</th>
                      <th style="width: 10px;">Opciones</th> 
                    </tr>';
		
			echo "<tr>
					
					<td>1.</td>
					<td><span class='badge bg-red'>".$datos['cantidadProducto']."</span></td>
					<td>".$datos['productoNombre']."</td>
					<td style='text-align: right;'>$ ".$datos['precioVenta'].".-</td>
					<td style='text-align: right;'>$ ".$datos['cantidadProducto']*$datos['precioVenta'].".-</td>
					<td><button class='btn btn-link btn-xs' data-toggle='modal' data-target='#myModalEliminarItemVenta'><span class='glyphicon glyphicon-trash'></span></button></td>
					
				  </tr>";
				
		echo '</tbody></table>';
				
		
	}

	/*=============================================
	REALIZAR Pago
	=============================================*/

	static public function ctrRealizarPago($redireccion){

		if(isset($_POST["nuevoPago"])){

			$adeuda = $_POST["adeuda"]-$_POST["nuevoPago"];

			$tabla = "ventas";

			

			$fechaPago = explode("-",$_POST["fechaPago"]); //15-05-2018
  	        $fechaPago = $fecha[2]."-".$fecha[1]."-".$fecha[0];

			

			$datos = array("id"=>$_POST["idPago"],
						   "adeuda"=>$adeuda,
						   "fecha"=>$_POST["fechaPago"]);

		
			
			$respuesta = ModeloVentas::mdlRealizarPago($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "'.$redireccion.'";

								}
							})

				</script>';

			}	
		}


	}
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrHistorial(){

		// FACTURAS
		$tabla = "cta";
		$respuesta = ModeloVentas::mdlHistorial($tabla);
		

		foreach ($respuesta as $key => $value) {

			// veo los items de la factura
			$tabla = "ctaart";
			$repuestos = ModeloVentas::mdlHistorialCta_art($tabla,$value['idcta']);
			
			$productos='';

			for($i = 0; $i < count($repuestos)-1; $i++){
				
				$productos = '{"id":"'.$repuestos[$i]["idarticulo"].'",
			      "descripcion":"'.$repuestos[$i]["nombre"].'",
			      "cantidad":"'.$repuestos[$i]["cantidad"].'",
			      "precio":"'.$repuestos[$i]["precio"].'",
			      "total":"'.$repuestos[$i]["precio"].'"},';
			}

			$productos = $productos . '{"id":"'.$repuestos[count($repuestos)-1]["idarticulo"].'",
			      "descripcion":"'.$repuestos[count($repuestos)-1]["nombre"].'",
			      "cantidad":"'.$repuestos[count($repuestos)-1]["cantidad"].'",
			      "precio":"'.$repuestos[count($repuestos)-1]["precio"].'",
			      "total":"'.$repuestos[count($repuestos)-1]["precio"].'"}';

			$productos ="[".$productos."]";
			
			echo '<pre>'; print_r($productos); echo '</pre>';
			
			// datos para cargar la factura
			$tabla = "ventas";
			
			$datos = array("id_vendedor"=>1,
						   "fecha"=>$value['fecha'],
						   "id_cliente"=>$value["idcliente"],
						   "codigo"=>$key,
						   "nrofc"=>$value["nrofc"],
						   "detalle"=>strtoupper($value["obs"]),
						   "productos"=>$productos,
						   "impuesto"=>0,
						   "neto"=>0,
						   "total"=>$value["importe"],
						   "adeuda"=>$value["adeuda"],
						   "obs"=>"",
						   "metodo_pago"=>$value["detallepago"],
						   "fechapago"=>$value['fecha']);

			$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
			

		}
		
		return $respuesta;

		
		
	}

	/*=============================================
	INGRESAR DERECHO DE ESCRITURA
	=============================================*/

	static public function ctringresarDerechoEscritura(){

		if(isset($_POST["nuevoPagoDerecho"])){

			$tabla = "ventas";

			$item = "id";
			$valor =$_POST["idPagoDerecho"];

			$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			REVISO LOS PRODUCTOS
			=============================================*/	

			$listaProductos = json_decode($respuesta['productos'], true);
			
			$totalFactura = 0;
			foreach ($listaProductos as $key => $value) {
				


			   if($value['id']==19){

			   	//ELIMINO EL ID 19 QUE ES DEL TESTIMONIO
			   	unset($listaProductos[$key]);
			   	
			   }else{
			   	// SUMO EL TOTAL DE LA FACTURA
			   	$totalFactura = $totalFactura +$value['total'];
			   	
			   }

			}
			echo '<pre>'; print_r(count($listaProductos)); echo '</pre>';
			$productosNuevosInicio = '[';

			for($i = 0; $i <= count($listaProductos); $i++){
				
				
			$productosNuevosMedio = '{
			      "id":"'.$listaProductos[0]["id"].'",
			      "descripcion":"'.$listaProductos[0]["descripcion"].'",
			      "idnrocomprobante":"'.$listaProductos[0]["idnrocomprobante"].'",
			      "cantventaproducto":"'.$listaProductos[0]["cantventaproducto"].'",
			      "folio1":"'.$listaProductos[0]["folio1"].'",
			      "folio2":"'.$listaProductos[0]["folio2"].'",
			      "cantidad":"'.$listaProductos[0]["cantidad"].'",
			      "precio":"'.$listaProductos[0]["precio"].'",
			      "total":"'.$listaProductos[0]["total"].'"
			    },';

			}

			$productosNuevosFinal = '{
			      "id":"19",
			      "descripcion":"DERECHO DE ESCRITURA",
			      "idnrocomprobante":"100",
			      "cantventaproducto":"1",
			      "folio1":"1",
			      "folio2":"1",
			      "cantidad":"1",
			      "precio":"'.$_POST["nuevoPagoDerecho"].'",
			      "total":"'.$_POST["nuevoPagoDerecho"].'"
			    }]';


echo $productosNuevosInicio . $productosNuevosMedio . $productosNuevosFinal;
			
		}

	}
	
	

	

	

	static public function ctrNombreMes($mes){

		setlocale(LC_TIME, 'spanish');  

		$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 

		return $nombre;
	}

	static public function ctrRealizarPagoVenta(){

		if(isset($_POST["idVentaPago"])){

			$tabla = "ventas";

			$datos = array("id"=>$_POST['idVentaPago'],
						   "metodo_pago"=>$_POST['listaMetodoPago'],
						   "referenciapago"=>$_POST["nuevaReferencia"],
						   "fechapago"=>date('Y-m-d'),
						   "adeuda"=>0);

			$respuesta = ModeloVentas::mdlRealizarPagoVenta($tabla, $datos);

				  

			if($respuesta == "ok"){

				//AGREGAR A LA CAJA
				  $item = "fecha";
		          $valor = date('Y-m-d');

		          $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
		          echo '<pre>'; print_r($caja); echo '</pre>';
			          
			          
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
				
				 			window.location = "ventas";

				 		</script>';
			}

		}
	}

	static public function ctrUltimoId(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlUltimoId($tabla);

		return $respuesta;

	}

	/*=============================================
	CREAR NC
	=============================================*/

	static public function ctrCrearNc($datos){
		
		$facturaOriginal =  explode("-",$datos["nroFactura"]);

		$facturaOriginal = intval($facturaOriginal[1]);
	
		$item="id";
		$valor=$datos['idVenta'];
		$ventas=ControladorVentas::ctrMostrarVentas($item,$valor);
		#creo un array del afip
		$items=json_decode($datos["productos"], true);

		#paso los datos al archivo de conexnion de afip
		include('../extensiones/afip/notacredito.php');

		if($ERRORAFIP==0){
			/*=============================================
					GUARDAR LA VENTA
			=============================================*/	

			$tabla = "ventas";

			$result = $afip->emitirComprobante($regcomp); 
			

			if ($result["code"] === Wsfev1::RESULT_OK) {

			/*=============================================
			FORMATEO LOS DATOS
			=============================================*/	

				$fecha = date("Y-m-d");
				$adeuda=0;
				$fechapago = $fecha;
			
				$cantCabeza = strlen($PTOVTA); 
				switch ($cantCabeza) {
						case 1:
						$ptoVenta="000".$PTOVTA;
						break;
						case 2:
						$ptoVenta="00".$PTOVTA;
						break;
					case 3:
						$ptoVenta="0".$PTOVTA;
						break;   
				}

				$codigoFactura = $ptoVenta .'-'. $ultimoComprobante;
				$fechaCaeDia = substr($result["fechaVencimientoCAE"],-2);
				$fechaCaeMes = substr($result["fechaVencimientoCAE"],4,-2);
				$fechaCaeAno = substr($result["fechaVencimientoCAE"],0,4);
				$totalVenta = $datos["total"];
				include('../extensiones/qr/index.php');
	            
        		$datos = array(
					   "id_vendedor"=>1,
					   "fecha"=>date('Y-m-d'),
					   "codigo"=>$codigoFactura,
					   "tipo"=>'NC',
					   "id_cliente"=>$datos['idcliente'],
					   "nombre"=>$datos['nombre'],
					   "documento"=>$datos['documento'],
					   "tabla"=>$datos['tabla'],
					   "productos"=>$datos['productos'],
					   "impuesto"=>0,
					   "neto"=>0,
					   "total"=>$datos["total"],
					   "adeuda"=>'0',
					   "obs"=>'FC-'.$ventas['codigo'],
					   "cae"=>$result["cae"],
					   "fecha_cae"=>$fechaCaeDia.'/'.$fechaCaeMes.'/'.$fechaCaeAno,
					   "fechapago"=>$fechapago,
					   "metodo_pago"=>"EFECTIVO",
					   "referenciapago"=>"EFECTIVO",
					   "qr"=>$datos_cmp_base_64."="
					   
					   );

        	#grabo la nota de credito
			$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
			#resto de la caja
			$item = "id";
			$datos = array(
					   "id"=>$ventas['id'],
					   "obs"=>'NC-'.$codigoFactura);
			$respuesta = ModeloVentas::mdlAgregarNroNotadeCredito($tabla,$datos);

			echo 'FE';

	        } 

	    }


	}

	static public function ctrMostrarUltimaAVenta(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarUltimaVenta($tabla);

		return $respuesta;

	}

	static public function ctrMostrarUltimasVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarUltimasVentas($tabla, $item, $valor);

		return $respuesta;

	}

}



