<?php
 date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once (__DIR__ . '/wsfev1.php');
include_once (__DIR__ . '/wsfexv1.php');
include_once (__DIR__ . '/wsaa.php');

//PUNTO DE VENTAS
$item = "nombre";
$valor = "ventas";
$registro = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);
$puntoVenta = $registro["cabezacomprobante"];

include ('modo.php');

$PTOVTA = intval($puntoVenta);//lo puse acá para pasarlo como parámetro para los certificados por pto de vta
//echo "----------Script de prueba de AFIP WSFEV1----------\n";
$ERRORAFIP = 0;
$afip = new Wsfev1($CUIT,$MODO,$PTOVTA);
$result = $afip->init();
if ($result["code"] === Wsfev1::RESULT_OK) {

    $result = $afip->dummy();

    if ($result["code"] === Wsfev1::RESULT_OK) {
        
       

		// $ptovta = intval($puntoVenta);
		#COMPROBANTE C
		$tipocbte = 11;

		//ULTIMO NRO DE COMPROBANTE
		$cmp = $afip->consultarUltimoComprobanteAutorizado($PTOVTA,$tipocbte);
		$ult = $cmp["number"];
		$ult = $ult +1;
		
		$cantRegistro = strlen($ult);
 
		switch ($cantRegistro) {
				case 1:
		          $ultimoComprobante="0000000".$ult;
		          break;
				case 2:
		          $ultimoComprobante="000000".$ult;
		          break;
		      case 3:
		          $ultimoComprobante="00000".$ult;
		          break;
		      case 4:
		          $ultimoComprobante="0000".$ult;
		          break;
		      case 5:
		          $ultimoComprobante="000".$ult;
		          break;
		      case 6:
		          $ultimoComprobante="00".$ult;
		          break;
		      case 7:
		          $ultimoComprobante="0".$ult;
		          break;
		      case 8:
		          $ultimoComprobante=$ult;
		          break;
		  }

	
	
	//$ult=3;
	// echo 'Nro. comp. a emitir: ' . $ult;
	$date_raw=date('Y-m-d');
	$desde= date('Ymd', strtotime('-2 day', strtotime($date_raw)));
	$hasta=date('Ymd', strtotime('-1 day', strtotime($date_raw)));

	
	//Si el comprobante es C no debe informarse
	$detalleiva=Array();
	//$detalleiva[0]=array('codigo' => 5,'BaseImp' => 100.55,'importe' => 21.12); //IVA 21%
	//$detalleiva[1]=array('codigo' => 4,'BaseImp' => 100,'importe' => 10.5); //IVA 10,5%
	
	$regcomp['numeroPuntoVenta'] =$PTOVTA;
	$regcomp['codigoTipoComprobante'] =$tipocbte;
	$comprob= array();
	$regcomp['CbtesAsoc'] = $comprob;
	$regcomp['codigoConcepto'] = 1; 					# 1: productos, 2: servicios, 3: ambos


	
	#OBETNER EL CODIGO DEL TIPO DE ........
	
	switch ($tabla) {
		case 'clientes':
			# code...
			$codigoTipoDoc = 80;
			
			break;
		case 'escribanos':
			# code...
			$codigoTipoDoc = 80;
			
			break;
		case 'casual':
			# code...
			$codigoTipoDoc = 96;
			
			break;
		case 'consumidorfinal':
			# code...
			$codigoTipoDoc = 99;
			
			break;
		
	}
	
	$regcomp['codigoTipoDocumento'] = $codigoTipoDoc;//80;				# 80: CUIT, 96: DNI, 99: Consumidor Final
	$regcomp['numeroDocumento'] =$documento;//$traerCliente['cuit'];
	// $regcomp['codigoTipoDocumento'] = 80;				# 80: CUIT, 96: DNI, 99: Consumidor Final
	// $regcomp['numeroDocumento'] = $traerCliente['cuit'];			# 0 para Consumidor Final (<$1000)
	
	$regcomp['importeTotal'] = $ventas["total"];//121.00;				# total del comprobante
	$regcomp['importeGravado'] = $ventas["total"];	#subtotal neto sujeto a IVA
	$regcomp['importeIVA'] = 0;
	
	$regcomp['importeOtrosTributos'] = 0;
	$regcomp['importeExento'] = 0.0;
	$regcomp['numeroComprobante'] = $ult;
	$regcomp['importeNoGravado'] = 0.00;
	$regcomp['subtotivas'] = $detalleiva; 
	$regcomp['codigoMoneda'] = 'PES';
	$regcomp['cotizacionMoneda'] = 1;
	$regcomp['fechaComprobante'] = date('Ymd');
	$regcomp['fechaDesde'] =  $desde;
	$regcomp['fechaHasta'] =  $hasta;
	$regcomp['fechaVtoPago'] = date('Ymd');
	
	//ITEMS COMPROBANTE
		
		
	$regcomp['items'] = $items;	
	
  
	 } else {

    	$ERRORAFIP=1;
        echo "ER.si no hace el dummy".$result["msg"] ." ".$result["code"]."\n";

    }

} else {
	
	$ERRORAFIP=1;
    echo "ER.si no inicia de primnera".$result["msg"] ." ".$result["code"]."\n";

}