<?php

include_once (__DIR__ . '/wsfev1.php');
include_once (__DIR__ . '/wsfexv1.php');
include_once (__DIR__ . '/wsaa.php');


// $CUIT = 30584197680;
// $MODO = Wsaa::MODO_PRODUCCION;
include ('modo.php');
$PTOVTA = 4; //lo puse acá para pasarlo como parámetro para los certificados por pto de vta
//echo "----------Script de prueba de AFIP WSFEV1----------\n";
$afip = new Wsfev1($CUIT,$MODO,$PTOVTA);
$result = $afip->init();
if ($result["code"] === Wsfev1::RESULT_OK) {
    $result = $afip->dummy();
    if ($result["code"] === Wsfev1::RESULT_OK) {
        //$datos = print_r($result["msg"], TRUE);
        //echo "Resultado: " . $datos . "\n";
		
		 //$afip = new Wsfev1($CUIT, Wsaa::MODO_HOMOLOGACION); 

    //$result = $afip->init(); //Crea el cliente SOAP
	//$ptovta = 2;
	$tipocbte = 13; //aca va el codigo de NC creo que es 13
	$cmp = $afip->consultarUltimoComprobanteAutorizado($PTOVTA,$tipocbte);
	$ult = $cmp["number"];
	$ult = $ult +1;
	//$ult=3;
	echo 'Nro. comp. a emitir: ' . $ult;
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
	$regcomp['codigoTipoDocumento'] = 99;				# 80: CUIT, 96: DNI, 99: Consumidor Final
	$regcomp['numeroDocumento'] = 0;			# 0 para Consumidor Final (<$1000)
	//Ejemplo Factura A con iva discriminado
	//$regcomp['importeTotal'] = 1.21;					# total del comprobante
	//$regcomp['importeGravado'] = 1;				# subtotal neto sujeto a IVA
	//$regcomp['importeIVA'] = 0.21;
	//Ejemplo Factura C  -  Descomentar los siguientes y comentar los anteriores 
	$regcomp['importeTotal'] = 1.00;				# total del comprobante
	$regcomp['importeGravado'] = 1.00;				#subtotal neto sujeto a IVA
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
	
	//Ejemplo de otros tributos  -  Para que los tenga en cuenta deben cargar valor mayores a cero y modificar el total cumandole el $per_ARBA_importe
	/*$per_ARBA_importe=0;
	$per_ARBA_imponible=0; 
	$per_ARBA_alic=0;
	$per_ARBA_importe=0;
	if($per_ARBA_importe>0){
		$regcomp['importeOtrosTributos'] = [per_ARBA_importe];
		$detalleTributos=Array();	
		$detalleTributos[0]=array('Id' => 02 , 'Desc' => 'Perc. ARBA', 'BaseImp' => $per_ARBA_imponible , 'Alic' => $per_ARBA_alic ,'Importe' => $per_ARBA_importe);
		
		$regcomp['Tributos'] = $detalleTributos;
	}else{
		$regcomp['importeOtrosTributos'] = 0;
	}	
*/
	
/*=============================================
ESTE HAY QUE DESTILDAR
=============================================*/

$result = $afip->emitirComprobante($regcomp); //$regcomp debe tener la estructura esperada (ver a continuación de la wiki)

/*=====  End of Section comment block  ======*/

	
       // $result = $afip->emitirComprobante($regcomp); //$regcomp debe tener la estructura esperada (ver a continuación de la wiki)
 
        if ($result["code"] === Wsfev1::RESULT_OK) {

            //La facturacion electronica finalizo correctamente

            //$result["cae"] y $result["fechaVencimientoCAE"] son datos que deberías almacenar
			//print_r($result);
			echo '  ** Resultado: OK ** - CAE: ' . $result["cae"];
			echo ' - Cae Vto.: ' .  $result["fechaVencimientoCAE"]  . "\n";
        } else {

            //No pudo emitirse la factura y $result["msg"] contendrá el motivo
			echo $result["msg"] . "\n";
        }

  
		
    } else {
        echo $result["msg"] . "\n";
    }
} else {
    echo $result["msg"] . "\n";
}
echo "--------------Ejecución WSFEV1 finalizada-----------------\n";
