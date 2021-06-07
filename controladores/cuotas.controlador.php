<?php

class ControladorCuotas{

	
	/*=============================================
	MOSTRAR CUOTAS
	=============================================*/

	static public function ctrMostrarCuotas($item, $valor){

		$tabla = "cuotas";

		$respuesta = ModeloCuotas::mdlMostrarCuotas($tabla, $item, $valor);

		return $respuesta;
	
	}
	
	static public function ctrMostrarCuotasEscribano($item, $valor){

		$tabla = "cuotas";

		$respuesta = ModeloCuotas::mdlMostrarCuotasEscribano($tabla, $item, $valor);

		return $respuesta;
	
	}
	/*=============================================
	EDITAR CUOTAS
	=============================================*/

	static public function ctrEditarCuota(){

		if(isset($_POST["idVenta"])){
			

			$listaProductos = json_decode($_POST["listaProductos"], true);
			
			$items=Array();//del afip
			
			foreach ($listaProductos as $key => $value) {

				$items[$key]=array('codigo' => $value["id"],'descripcion' => $value["descripcion"],'cantidad' => $value["cantidad"],'codigoUnidadMedida'=>7,'precioUnitario'=>$value["precio"],'importeItem'=>$value["total"],'impBonif'=>0);
			}
			
			$codigoFactura=1;

			include('../extensiones/afip/afip.php');

			/*=============================================
				GUARDAR LA VENTA
			=============================================*/	
			if($ERRORAFIP==0){
				
				$result = $afip->emitirComprobante($regcomp); //$regcomp debe tener la estructura esperada (ver a continuación de la wiki)
	        
	        	if ($result["code"] === Wsfev1::RESULT_OK){

	        		$tablaClientes = "escribanos";

					$item = "id";
					$valor = $_POST["seleccionarCliente"];

					$traerCliente = ModeloEscribanos::mdlMostrarEscribanos($tablaClientes, $item, $valor);

					if($traerCliente['facturacion']=="CUIT"){

						$nombre=$traerCliente['nombre'];
						$documento=$traerCliente['cuit'];

					}else{

						$nombre=$traerCliente['nombre'];
						$documento=$traerCliente['documento'];

					}
				
					/*=============================================
					FORMATEO LOS DATOS
					=============================================*/	
				
					$fecha = date("Y-m-d");

					if ($_POST["listaMetodoPago"]=="CTA.CORRIENTE"){
						
						$adeuda=$_POST["totalVenta"];

						$fechapago="0000-00-00";


					}else{

						$adeuda=0;

						$fechapago = $fecha;
					}
			
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

					$tabla = "ventas";
					$fechaCaeDia = substr($result["fechaVencimientoCAE"],-2);
					$fechaCaeMes = substr($result["fechaVencimientoCAE"],4,-2);
					$fechaCaeAno = substr($result["fechaVencimientoCAE"],0,4);

		        	$afip=1;
		        	$totalVenta = $_POST["totalVenta"];
		        	include('../extensiones/qr/index.php');
 
		            //La facturacion electronica finalizo correctamente
		            $datos = array("fecha"=>date('Y-m-d'),
					               "tipo"=>$_POST['tipoCuota'],
					               "codigo"=>$codigoFactura,
					               "id_cliente"=>$_POST['seleccionarCliente'],
								   "nombre"=>$nombre,
								   "documento"=>$documento,
								   "tabla"=>$_POST['tipoCliente'],
		            		       "id_vendedor"=>1,						   
									"productos"=>$_POST['listaProductos'],
									"impuesto"=>0,
									"neto"=>0,
									"total"=>$_POST["totalVenta"],
									"adeuda"=>'0',
									"obs"=>'',
									"metodo_pago"=>$_POST['listaMetodoPago'],
									"referenciapago"=>$_POST['nuevaReferencia'],
									"fechapago"=>$fechapago,
									"cae"=>$result["cae"],
									"fecha_cae"=>$fechaCaeDia.'/'.$fechaCaeMes.'/'.$fechaCaeAno,
								"qr"=>$datos_cmp_base_64."=");

					$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);

					$eliminarCuota = ModeloCuotas::mdlEliminarVenta("cuotas", $_POST["idVenta"]);

					if(isset($respuesta)){

			        	if($respuesta == "ok"){

			        		if($afip==1){

			        			/*=============================================
								AGREGAR EL NUMERO DE COMPROBANTE
								=============================================*/
								
							  	$tabla = "comprobantes";
								$datos = $ult;
								
								ModeloVentas::mdlAgregarNroComprobante($tabla, $datos);
								$nroComprobante = substr($codigoFactura,8);

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

						}

	        		} 
			
			}
	        	
}
			
		} }
		

	static public function ctrContarCuotayOsde($item, $valor){

		$tabla = "cuotas";

		$respuesta = ModeloCuotas::mdlContarCuotayOsde($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarGeneracion($tipo){

		$tabla = "generacion";
		# code...
     	$mimes=date("m")-1;
     	

     	if($mimes==0){

			$mes=ControladorVentas::ctrNombreMes(12);
			
			$anio = date("Y")-1;
			
	

		}else{

			$anio = date("Y");
			
			$mes=ControladorVentas::ctrNombreMes($mimes);
			

		}

		// $mes=ControladorVentas::ctrNombreMes($mimes);

		$datos = array("tipo"=>$tipo,
					   "mes"=>strtoupper($mes),
					   "anio"=>$anio);

		$respuesta = ModeloCuotas::mdlChequearGeneracion($tabla, $datos);

		return $respuesta;

	}
	static public function ctrChequearGeneracion($tipo){
		
		/*=============================================
		BUSCO UNA COINCIDENCIA EN GENERACIÓN 
		=============================================*/
		
		$tabla = "generacion";
     	$mimes=date("m")-1;
     	
		if($mimes==0){

			$mes=ControladorVentas::ctrNombreMes(12);
			$anio = date("Y")-1;

		}else{

			$anio = date("Y");
			$mes=ControladorVentas::ctrNombreMes($mimes);

		}
		
		$datos = array("tipo"=>$tipo,
					   "mes"=>$mes,
					   "anio"=>$anio);

		$respuesta = ModeloCuotas::mdlChequearGeneracion($tabla, $datos);
		
		if(empty($respuesta)){ //SI NO EXITE CREO UNA ETRADA

		  if($tipo=="CUOTA"){

		  	 $GenerarCuota = ControladorCuotas::ctrgeneraCuota();

		  }
          
		  if($tipo=="OSDE"){

		  	$GenerarCuota = ControladorCuotas::ctrGeneraOsde();
		  	
		  }

		}

	}
	/*=============================================
	SE GENERAN LAS FACTURAS AUTOMATICAMENTE
	=============================================*/
	static public function ctrgeneraCuota(){

		$fechaactual = date('Y-m-d'); // 2016-12-29
		$nuevafecha = strtotime ('-1 year' , strtotime($fechaactual)); //Se añade un año mas
		$nuevafecha = date ('Y-m-d',$nuevafecha);
		$nuevafecha  = explode("-", $nuevafecha );
		$nuevafecha=$nuevafecha[0];

		if(date("m")=='01'||date("m")=='1'){

			$anio=$nuevafecha;

		}else{

			$anio=date("Y");

		}
		//PRIMERO CONTAMOS CUANTOS ESCRIBANOS EXISTEN
		$item = null;
	    $valor = null;

	    $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);
		     
	    $cantidadCuotas = 0;
	    foreach ($escribanos as $key => $value) {

	     	$mimes=date("m")-1;
			$mes=ControladorVentas::ctrNombreMes($mimes);

	     	$item = "id";
	     	$valor = $value['id_categoria'];

	     	$categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);
	     	$importe = $categoria["importe"];
	     	
	     	$productos = '[{"id":"20","descripcion":"CUOTA MENSUAL '.strtoupper($mes).'/'.$anio.'","idnrocomprobante":"100","cantventaproducto":"1","folio1":"1","folio2":"1","cantidad":"1","precio":"'.$categoria["importe"].'","total":"'.$categoria["importe"].'"}]';

	     	$tabla = "cuotas";

			$datos = array("fecha"=>date('Y-m-d'),
						   "tipo"=>'CU',
						   "id_cliente"=>$value['id'],
						   "nombre"=>$value['nombre'],
						   "documento"=>$value['cuit'],
						   "productos"=>$productos,
						   "total"=>$importe);


			$respuesta = ModeloCuotas::mdlIngresarCuota($tabla, $datos);
			$cantidadCuotas++;

	    }
	    $tabla ='generacion';
	    $datos = array("fecha"=>date('Y-m-d'),
					   "nombre"=>'CUOTA',
					   "mes"=>strtoupper($mes),
					   "anio"=>$anio,
					   "cantidad"=>$cantidadCuotas);
		ModeloCuotas::mdlIngresarGeneracionCuota($tabla, $datos);
		
	}

	/*=============================================
	SE GENERAN LOS REINTEGROS OSDE
	=============================================*/

	static public function ctrGeneraOsde(){

		$fechaactual = date('Y-m-d'); // 2016-12-29
		$nuevafecha = strtotime ('-1 year' , strtotime($fechaactual)); //Se añade un año mas
		$nuevafecha = date ('Y-m-d',$nuevafecha);
		$nuevafecha  = explode("-", $nuevafecha );
		$nuevafecha=$nuevafecha[0];

		if(date("m")=='01'||date("m")=='1'){

			$anio=$nuevafecha;

		}else{

			$anio=date("Y");

		}
		$item = null;
	    $valor = null;
		$escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);
		     
		     
		$cantidadCuotas = 0;
	    foreach ($escribanos as $key => $value) {
	     	# code...
	     	$mimes=date("m")-1;
			$mes=ControladorVentas::ctrNombreMes($mimes);

			

			if(date("m")-1==0){

	    		$anio =date("Y")-1;
	    	}
	    	
	     	if($value['id_osde']!=0){

		     	$item = "id";
		     	$valor = $value['id_osde'];

		     	$osde = ControladorOsde::ctrMostrarOsde($item, $valor);

		     	$productos = '[{"id":"22","descripcion":"REINTEGRO OSDE '.strtoupper($mes).'/'.$anio.'","idnrocomprobante":"12000","cantventaproducto":"1","folio1":"1","folio2":"1","cantidad":"1","precio":"'.$osde["importe"].'","total":"'.$osde["importe"].'"}]';

		     	$tabla = "cuotas";

				$datos = array("fecha"=>$fechaactual,
						   "tipo"=>'RE',
						   "id_cliente"=>$value['id'],
						   "nombre"=>$value['nombre'],
						   "documento"=>$value['cuit'],
						   "productos"=>$productos,
						   "total"=>$osde["importe"]
						   );

				$respuesta = ModeloCuotas::mdlIngresarCuota($tabla, $datos);
				$cantidadCuotas++;
			}
		
		}

		$tabla ='generacion';
	    $datos = array("fecha"=>date('Y-m-d'),
					   "nombre"=>'OSDE',
					   "mes"=>strtoupper($mes),
					   "anio"=>$anio,
					   "cantidad"=>$cantidadCuotas);
		ModeloCuotas::mdlIngresarGeneracionCuota($tabla, $datos);
		
	}

	// static public function ctrEscribanosConDeuda($item, $valor,$tipo){
		
	// 	$tabla = "cuotas";

	// 	$respuesta = ModeloCuotas::mdlEscribanosConDeuda($tabla, $item, $valor);

	// 	if ($tipo=='contar'){

	// 		return count($respuesta);

	// 	}else{
			
	// 		return $respuesta;

	// 	}
		

	// }
	static public function ctrEscribanosDeuda($item, $valor){
		
		$tabla = "cuotas";

		$respuesta = ModeloCuotas::mdlEscribanosDeuda($tabla, $item, $valor);

		
		return $respuesta;


	}
	/*=============================================
	ACTUALIZAR INHABILITADO
	=============================================*/

	static public function ctrEscribanosInhabilitar($valor){

		$tabla ="escribanos";

		$respuesta = ModeloCuotas::mdlEscribanosInhabilitar($tabla, $valor);

		return $respuesta;
	}

	/*=============================================
	ACTUALIZAR HABILITADO
	=============================================*/
	static public function ctrHabilitarUnEscribano($valor){

		$tabla ="escribanos";

		$respuesta = ModeloCuotas::mdlHabilitarUnEscribano($tabla, $valor);
	}
	/*=============================================
	ACTUALIZAR HABILITADO
	=============================================*/

	static public function ctrEscribanosHabilitar(){

		$tabla ="escribanos";

		$respuesta = ModeloCuotas::mdlEscribanosHabilitar($tabla);

		return $respuesta;
	}
	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarCuotas(){

		if(isset($_GET["descargar_cuota"])){

			$tabla = "cuotas";

			$cuotas = ModeloCuotas::mdlMostrarCuotas($tabla, null, null);

			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $tabla.'.xls';

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
					<td style='font-weight:bold; border:1px solid #eee;'>NOMBRE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>				
					</tr>");

			foreach ($cuotas as $row => $item){
				
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["fecha"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["tipo"]."</td>
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
	MODIFICAR CUOTAS
	=============================================*/

	static public function ctrModificarImporte(){

		

		// 	$item = 'fecha';
		// $valor = '2021-05-03';
		// $tabla = "cuotas";
		// $cuotas = ModeloCuotas::mdlMostrarCuotasEscribano($tabla, $item, $valor);
		

		// foreach ($cuotas as $key => $value) {

		// 	if($value['tipo']=='CU'){

		// 		switch ($value['total']) {
					
		// 			case '1300':
		// 				echo 'entro por 1300';
		// 				$datos = array("id"=>$value["id"],
		// 				"importe"=>$_POST["importe2"]);
		// 				$respuesta = ModeloCuotas::mdlModificarCuota("cuotas", $datos);
		// 				break;
		// 				case '1500':
		// 					echo 'entro por 1500';
		// 					$datos = array("id"=>$value["id"],
		// 					"importe"=>$_POST["importe3"]);
		// 				$respuesta = ModeloCuotas::mdlModificarCuota("cuotas", $datos);
		// 				break;
		
		// 		}
		// 	}
			
		// }

		
		$item = 'fecha';
		$valor = '2021-05-03';
		$tabla = "cuotas";
		$cuotas = ModeloCuotas::mdlMostrarCuotasEscribano($tabla, $item, $valor);

		foreach ($cuotas as $key => $value) {

			$datos = array("id"=>$value["id"],
					"productos"=>'[{"id":"20","descripcion":"CUOTA MENSUAL ABRIL/2021","idnrocomprobante":"100","cantventaproducto":"1","folio1":"1","folio2":"1","cantidad":"1","precio":"'.$value["total"].'","total":"'.$value["total"].'"}]');
					$respuesta = ModeloCuotas::mdlModificarCuotaProductos("cuotas", $datos);
		}
		echo "listo";
		
		
	
	}
}
