<?php


session_start();
include('../fpdf.php');

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/parametros.controlador.php";
require_once "../../../modelos/parametros.modelo.php";

require_once "../../../controladores/escribanos.controlador.php";
require_once "../../../modelos/escribanos.modelo.php";

class PDF_JavaScript extends FPDF {
	protected $javascript;
	protected $n_js;
	function IncludeJS($script, $isUTF8=false) {
		if(!$isUTF8)
			$script=utf8_encode($script);
		$this->javascript=$script;
	}
	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_put('<<');
		$this->_put('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
		$this->_put('>>');
		$this->_put('endobj');
		$this->_newobj();
		$this->_put('<<');
		$this->_put('/S /JavaScript');
		$this->_put('/JS '.$this->_textstring($this->javascript));
		$this->_put('>>');
		$this->_put('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (!empty($this->javascript)) {
			$this->_put('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}
}


class PDF_AutoPrint extends PDF_JavaScript
{
	function AutoPrint($printer='')
	{
		// Open the print dialog
		if($printer)
		{
			$printer = str_replace('\\', '\\\\', $printer);
			$script = "var pp = getPrintParams();";
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
			$script .= "pp.printerName = '$printer'";
			$script .= "print(pp);";
		}
		else
			$script = 'print(true);';
		$this->IncludeJS($script);
	}
}
function convertirLetras($texto){
$texto = iconv('UTF-8', 'windows-1252', $texto);
return	 $texto;
}
require_once('../../../modelos/conexion.php');



// PARAMETROS
$item= "id";
$valor = 1;

$parametros = ControladorParametros::ctrMostrarParametros($item,$valor);

// VENTA
$item= "codigo";
$valor = $_GET['codigo'];

$ventas = ControladorVentas::ctrMostrarVentas($item,$valor);


// ESCRIBANO
$item= "id";
$valor = $ventas['id_cliente'];

$escribanos = ControladorEscribanos::ctrMostrarEscribanos($item,$valor);

$fechaNueva = explode("-", $ventas['fecha']);
$anio = substr($fechaNueva[0], -2);
//$pdf = new FPDF('P','mm','A4');
$pdf = new PDF_AutoPrint($parametros['formatopagina1'],$parametros['formatopagina2'],$parametros['formatopagina3']);
$pdf->AddPage();
//$pdf -> SetFont('Arial', 'I', 8);  // set the font
$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], $parametros['formatofuente3']); 

 // set the font
//ENCABEZADO FACTURA 1
//primera linea fecha
//$pdf -> SetY(25);    // set the cursor at Y position 5
$pdf -> SetY($parametros['fecha1posY']);    // set the cursor at Y position 5
//$pdf -> SetX(170);
$pdf -> SetX($parametros['fecha1posXdia']);
$pdf->Cell(0,0,$fechaNueva[2]);
//$pdf -> SetX(180);
$pdf -> SetX($parametros['fecha1posXmes']);
$pdf->Cell(0,0,$fechaNueva[1]);
//$pdf -> SetX(192);
$pdf -> SetX($parametros['fecha1posXanio']);
$pdf->Cell(0,0,$anio);

//Carga cliente y condiciones
//$pdf -> SetY(40);    // set the cursor at Y position 5
//$pdf -> SetX(50);
$pdf -> SetY($parametros['formatocabecera1posY1']);    // set the cursor at Y position 5
$pdf -> SetX($parametros['formatocabecera1posX1']);

//convertir en castellano ÑÑÑ
//$str = iconv('UTF-8', 'windows-1252', $rsCta['nombreescribano']);

$pdf->Cell(0,0,convertirLetras($escribanos['nombre']));
//$pdf -> SetY(44);
//$pdf -> SetX(50);
$pdf -> SetY($parametros['formatocabecera1posY2']);
$pdf -> SetX($parametros['formatocabecera1posX2']);
$pdf->Cell(0,0,'s/iva');
//$pdf -> SetY(50);
//$pdf -> SetX(70);
$pdf -> SetY($parametros['formatocabecera1posY3']);
$pdf -> SetX($parametros['formatocabecera1posX3']);

if($ventas['metodo_pago']==$ventas['referenciapago']){

	$metodoDePago = $ventas['metodo_pago'];

}else{

	$metodoDePago = $ventas['metodo_pago']==$ventas['referenciapago'];
}

$pdf->Cell(0,0,$metodoDePago);

//Items
$renglon1=$parametros['formatoitem1posY'];
$espaciorenglon=0;
$veces=0;

$productosVentas =  json_decode($ventas["productos"], true);
foreach ($productosVentas as $key => $rsCtaART) {

	$pdf -> SetY($renglon1+($espaciorenglon*$veces));    // set the cursor at Y position 5
	$pdf -> SetX($parametros['formatoitem1posXcant']);
	$pdf->Cell(0,0,$rsCtaART['cantidad']);
	//$pdf -> SetX(53);
	$pdf -> SetX($parametros['formatoitem1posXart']);
	$miItem=convertirLetras($rsCtaART['descripcion']);
	$cantidaddeLetras=strlen($miItem);
	if($cantidaddeLetras<=27) {
		$pdf->Cell(0,0,$miItem);
	}else{
		$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], 6);  // set the font
		$pdf->Cell(0,0,$miItem);
		$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], $parametros['formatofuente3']);  // set the font
	}
	
	//$pdf -> SetX(100);
	$pdf -> SetX($parametros['formatoitem1posXfolio1']);
	$pdf->Cell(0,0,$rsCtaART['folio1']);
	
	//$pdf -> SetX(126);
	$pdf -> SetX($parametros['formatoitem1posXfolio2']);
	$pdf->Cell(0,0,$rsCtaART['folio2']);
	
	//$pdf -> SetX(157);
	$pdf -> SetX($parametros['formatoitem1posXunitario']);
	$pdf->Cell(0,0,$rsCtaART['precio']);
	$subtotal=$rsCtaART['precio']*$rsCtaART['cantidad'];
	//$pdf -> SetX(185);
	$pdf -> SetX($parametros['formatoitem1posXtotal']);
	$pdf->Cell(0,0,$subtotal);
	$espaciorenglon=$parametros['formatoitem1posY2'];
	$veces++;
}


$pdf->SetY($parametros['formatoobsposY']);
$pdf -> SetX($parametros['formatoobsposX']);
$pdf->Cell(0,0,date("d/m/Y").' :--: '. date("G:H:s").' - '.$_SESSION['perfil']);
$pdf -> SetY($parametros['formatoobsposY']+5);
$pdf -> SetX($parametros['formatoobsposX']);
$pdf->Cell(0,0,'Nro. Fac. '.$ventas['codigo']);
//$pdf -> SetX(185);
$pdf->SetFont('Arial','B',10);
$pdf->SetY($parametros['formatototalposY']);
$pdf -> SetX($parametros['formatototalposX']);
$pdf->Cell(0,0,$ventas['total']);

$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], $parametros['formatofuente3']); 


//$pdf -> SetY(25);    // set the cursor at Y position 5
$pdf -> SetY($parametros['fecha1posY']+$parametros['posYfactura2']);    // set the cursor at Y position 5
//$pdf -> SetX(170);
$pdf -> SetX($parametros['fecha1posXdia']);
$pdf->Cell(0,0,$fechaNueva[2]);
//$pdf -> SetX(180);
$pdf -> SetX($parametros['fecha1posXmes']);
$pdf->Cell(0,0,$fechaNueva[1]);
//$pdf -> SetX(192);
$pdf -> SetX($parametros['fecha1posXanio']);
$pdf->Cell(0,0,$anio);



//Carga cliente y condiciones
//$pdf -> SetY(40);    // set the cursor at Y position 5
//$pdf -> SetX(50);
$pdf -> SetY($parametros['formatocabecera1posY1']+$parametros['posYfactura2']);    // set the cursor at Y position 5
$pdf -> SetX($parametros['formatocabecera1posX1']);

$pdf->Cell(0,0,convertirLetras($escribanos['nombre']));
//$pdf -> SetY(44);
//$pdf -> SetX(50);
$pdf -> SetY($parametros['formatocabecera1posY2']+$parametros['posYfactura2']);
$pdf -> SetX($parametros['formatocabecera1posX2']);
$pdf->Cell(0,0,'s/iva');
//$pdf -> SetY(50);
//$pdf -> SetX(70);
$pdf -> SetY($parametros['formatocabecera1posY3']+$parametros['posYfactura2']);
$pdf -> SetX($parametros['formatocabecera1posX3']);




$pdf->Cell(0,0,$metodoDePago);


$renglon1=$parametros['formatoitem1posY']+$parametros['posYfactura2'];
$espaciorenglon=0;
$veces=0;

$productosVentas =  json_decode($ventas["productos"], true);
foreach ($productosVentas as $key => $rsCtaART) {

	$pdf -> SetY($renglon1+($espaciorenglon*$veces));    // set the cursor at Y position 5
	$pdf -> SetX($parametros['formatoitem1posXcant']);
	$pdf->Cell(0,0,$rsCtaART['cantidad']);
	//$pdf -> SetX(53);
	$pdf -> SetX($parametros['formatoitem1posXart']);
	$miItem=convertirLetras($rsCtaART['descripcion']);
	$cantidaddeLetras=strlen($miItem);
	if($cantidaddeLetras<=27) {
		$pdf->Cell(0,0,$miItem);
	}else{
		$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], 6);  // set the font
		$pdf->Cell(0,0,$miItem);
		$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], $parametros['formatofuente3']);  // set the font
	}
	
	//$pdf -> SetX(100);
	$pdf -> SetX($parametros['formatoitem1posXfolio1']);
	$pdf->Cell(0,0,$rsCtaART['folio1']);
	
	//$pdf -> SetX(126);
	$pdf -> SetX($parametros['formatoitem1posXfolio2']);
	$pdf->Cell(0,0,$rsCtaART['folio2']);
	
	//$pdf -> SetX(157);
	$pdf -> SetX($parametros['formatoitem1posXunitario']);
	$pdf->Cell(0,0,$rsCtaART['precio']);
	$subtotal=$rsCtaART['precio']*$rsCtaART['cantidad'];
	//$pdf -> SetX(185);
	$pdf -> SetX($parametros['formatoitem1posXtotal']);
	$pdf->Cell(0,0,$subtotal);
	$espaciorenglon=$parametros['formatoitem1posY2'];
	$veces++;
}


$pdf->SetY($parametros['formatoobsposY']+$parametros['posYfactura2']);
$pdf -> SetX($parametros['formatoobsposX']);
$pdf->Cell(0,0,date("d/m/Y").' :--: '. date("G:H:s").' - '.$_SESSION['perfil']);
$pdf -> SetY($parametros['formatoobsposY']+$parametros['posYfactura2']+5);
$pdf -> SetX($parametros['formatoobsposX']);
$pdf->Cell(0,0,'Nro. Fac. '.$ventas['codigo']);

//$pdf -> SetX(185);
$pdf->SetFont('Arial','B',10);
$pdf->SetY($parametros['formatototalposY']+$parametros['posYfactura2']);
$pdf -> SetX($parametros['formatototalposX']);
$pdf->Cell(0,0,$ventas['total']);

$pdf->AutoPrint();
$pdf->Output();

?>