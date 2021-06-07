<?php

require '../extensiones/qr/phpqrcode/qrlib.php';

$dir = '../extensiones/qr/temp/';

if(!file_exists($dir)){
    mkdir($dir);
}

$filename = $dir.$result["cae"].'.png';

$url = 'https://www.afip.gob.ar/fe/qr/'; // URL que pide AFIP que se ponga en el QR. 

$datos_cmp_base_64 = json_encode([ 
    "ver" => 1,                         // Numérico 1 digito -  OBLIGATORIO – versión del formato de los datos del comprobante	1
    "fecha" => date('Y-m-d'),            // full-date (RFC3339) - OBLIGATORIO – Fecha de emisión del comprobante
    "cuit" => (int) 30584197680,        // Numérico 11 dígitos -  OBLIGATORIO – Cuit del Emisor del comprobante  
    "ptoVta" => (int) $PTOVTA,               // Numérico hasta 5 digitos - OBLIGATORIO – Punto de venta utilizado para emitir el comprobante
    "tipoCmp" => (int) $tipocbte,               // Numérico hasta 3 dígitos - OBLIGATORIO – tipo de comprobante (según Tablas del sistema. Ver abajo )
    "nroCmp" => (int) $ultimoComprobante,               // Numérico hasta 8 dígitos - OBLIGATORIO – Número del comprobante
    "importe" => (float) $totalVenta,         // Decimal hasta 13 enteros y 2 decimales - OBLIGATORIO – Importe Total del comprobante (en la moneda en la que fue emitido)
    "moneda" => "PES",                  // 3 caracteres - OBLIGATORIO – Moneda del comprobante (según Tablas del sistema. Ver Abajo )
    "ctz" => (float) 1,                 // Decimal hasta 13 enteros y 6 decimales - OBLIGATORIO – Cotización en pesos argentinos de la moneda utilizada (1 cuando la moneda sea pesos)
    "tipoDocRec" =>  $codigoTipoDoc ,               // Numérico hasta 2 dígitos - DE CORRESPONDER – Código del Tipo de documento del receptor (según Tablas del sistema )
    "nroDocRec" =>  $numeroDoc,        // Numérico hasta 20 dígitos - DE CORRESPONDER – Número de documento del receptor correspondiente al tipo de documento indicado
    "tipoCodAut" => "E",                // string - OBLIGATORIO – “A” para comprobante autorizado por CAEA, “E” para comprobante autorizado por CAE
    "codAut" => (int) $result["cae"]    // Numérico 14 dígitos -  OBLIGATORIO – Código de autorización otorgado por AFIP para el comprobante
]); 



$datos_cmp_base_64 = base64_encode($datos_cmp_base_64); 
$url = 'https://www.afip.gob.ar/fe/qr/';
$to_qr = $url.'?p='.$datos_cmp_base_64;

$tamanio = 10;
$level = 'M';
$frameSize = 3;

$contenido = $datos_cmp_base_64;//'Hola mundo';

QRcode::png($to_qr,$filename,$level,$tamanio,$frameSize);

// echo '<img src="'.$filename.'" />';

?>