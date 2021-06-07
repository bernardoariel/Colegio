<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";


require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirEtiquetas{


public function traerImpresionEtiquetas(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

// $itemVenta = null;
// $valorVenta = null;

// $respuestaVenta = ControladorVentas::ctrMostrarFacturasSeleccionadas($itemVenta, $valorVenta);

// $fecha = explode("-", $respuestaVenta["fecha"]);
// $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
// $productos = json_decode($respuestaVenta["productos"], true);
// $adeuda = number_format($respuestaVenta["adeuda"],2);
// $impuesto = number_format($respuestaVenta["impuesto"],2);
// $total = number_format($respuestaVenta["total"],2);

// //TRAEMOS LA INFORMACIÓN DEL CLIENTE

// $itemCliente = "id";
// $valorCliente = $respuestaVenta["id_cliente"];

// $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);


// //TRAEMOS LA INFORMACIÓN DE LA EMPRESA
// $itemEmpresa = "id";

// $valorEmpresa = 1;
// $respuestaEmpresa = ControladorUsuarios::ctrMostrarEmpresa($itemEmpresa, $valorEmpresa);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->setPrintHeader(false);

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10);

// define barcode style
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

// $pdf->write1DBarcode('00010053', 'C128C', '', '', '', 16, 0.3, $style, 'N');

// $pdf->Ln();

// $pdf->Cell(0, 0, 'TEST CELL STRETCH: force spacing', 1, 1, 'C', 0, '', 4);

// $pdf->Ln(20);

// $pdf->Cell(45, 0, 'TEST CELL STRETCH: scaling', 1, 1, 'C', 0, '', 1);

// create some HTML content
$html = '
<table cellpadding="1" cellspacing="1" border="1" style="text-align:center;font-size: 	6px;">
	<tr>
		<td>Nombre: <strong>ZLAUTO</strong>----Fecha:<strong>18/05/2018</strong></td>
	</tr>
	<tr>
		<td>Toner hp 1Kg</td>
	</tr>
	<tr>
		<td>Cilindro q85</td>
	</tr>
	<tr>
		<td>Magnetico q35</td>
	</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output('etiquetas.pdf');

}

}

 $etiquetas = new imprimirEtiquetas();
 $etiquetas -> traerImpresionEtiquetas();

?>