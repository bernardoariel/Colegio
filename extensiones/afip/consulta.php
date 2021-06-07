<?php
 date_default_timezone_set('America/Argentina/Buenos_Aires');
include_once (__DIR__ . '/wsfev1.php');
include_once (__DIR__ . '/wsfexv1.php');
include_once (__DIR__ . '/wsaa.php');

include ('modo.php');
// $CUIT = 30584197680;
// $MODO = Wsaa::MODO_PRODUCCION;
$PTOVTA = 4; //lo puse acá para pasarlo como parámetro para los certificados por pto de vta

$afip = new Wsfev1($CUIT,$MODO,$PTOVTA);


$result = $afip->init();
if ($result["code"] === Wsfev1::RESULT_OK) {

    $result = $afip->dummy();

    if ($result["code"] === Wsfev1::RESULT_OK) {
        
        
		$tipocbte = 11;	

				
		
    } else {

        echo $result["msg"] . "\n";

    }

} else {

    echo $result["msg"] . "\n";
    
}