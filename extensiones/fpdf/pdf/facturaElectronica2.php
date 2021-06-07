<?php
session_start();

include('../fpdf.php');
include ('../../barcode.php');
require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/parametros.controlador.php";
require_once "../../../modelos/parametros.modelo.php";

require_once "../../../controladores/escribanos.controlador.php";
require_once "../../../modelos/escribanos.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/tipoiva.controlador.php";
require_once "../../../modelos/tipoiva.modelo.php";

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
$item= "id";
$valor = $_GET['id'];
$ventas = ControladorVentas::ctrMostrarVentas($item,$valor);

if($ventas['tipo']=='NC'){
	
	
	$codFactura = 'COD. 13';
	$tituloFactura ="NOTA DE CREDITO";
	

}else{

	$codFactura = 'COD. 11';
	$tituloFactura ="FACTURA";
}

// ESCRIBANO
if($ventas['id_cliente']==0){

	$item= "id";
	$valor = 5;

	$descripcionTipoDoc ="DNI:";

	

}else{

	if ($ventas['tabla']=='escribanos') {
		#SI ES UN ESCRIBANO
		$descripcionTipoDoc ="CUIT:";
		$item= "id";
		$valor = $ventas['id_cliente'];
		$escribanos = ControladorEscribanos::ctrMostrarEscribanos($item,$valor);
		#BUSCAR EL TIPO DE IVA
		$item = "id";
		$valor = $escribanos["id_tipo_iva"];
		$tipo_Iva = ControladorTipoIva::ctrMostrarTipoIva($item, $valor);
		$tipoIva = $tipo_Iva["nombre"];

	}elseif($ventas['id_cliente']==1) {

		$descripcionTipoDoc ="CUIT:";
		$tipoIva ="Consumidor Final";

	}
	else{

		$descripcionTipoDoc ="CUIT:";
		$item= "id";
		$valor = $ventas['id_cliente'];
		$escribanos = ControladorClientes::ctrMostrarClientes($item,$valor);

		$tipoIva = $escribanos['tipoiva'];

	}
	

	
}





$fechaNueva = explode("-", $ventas['fecha']);
$anio = substr($fechaNueva[0], -2);

//PUNTO DE VENTAS
$codigo = explode("-", $ventas['codigo']);

//FECHA
$fecha = explode("-", $ventas['fecha']);
$fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];

//CODIGO DE BARRA
$tipocbte = 11;
$fechaCae = explode("/", $ventas['fecha_cae']);
$codigodeBarra = '30584197680'.$tipocbte.$codigo[0].$ventas['cae'].$fechaCae[2].$fechaCae[1].$fechaCae[0];
$cantCodigodeBarra =strlen($codigodeBarra);

$impares = 0;
$pares = 0;

for ($i=0; $i <= $cantCodigodeBarra ; $i+=2) { 
	# code...
	$impares=$impares+$codigodeBarra[$i];
}

for ($i=1; $i <= $cantCodigodeBarra ; $i+=2) { 
	# code...
	$pares=$pares+$codigodeBarra[$i];
}

$impares = $impares * 3;
$resultadoCodigo = $pares + $impares;


$resultadoCodigo2 =$resultadoCodigo;
$ultimoDigito = 0;

for ($j=0; $j <= 10 ; $j++) { 
	
	
	if(substr($resultadoCodigo2,-1,1)=='0'){

		
		$ultimoDigito = $j;

		break;

	}else{
		
		$resultadoCodigo2=$resultadoCodigo2+1;
		
	}


		
	$i++;
	
}



$pdf = new PDF_AutoPrint($parametros['formatopagina1'],$parametros['formatopagina2'],$parametros['formatopagina3']);
$pdf->AddPage('P','A4');

$pdf -> SetFont($parametros['formatofuente1'], $parametros['formatofuente2'], $parametros['formatofuente3']); 
$pdf->Image('../../../vistas/img/afip/factura.jpg' , 5 ,5, 200 , 245,'JPG', '');

//ENCABEZADO FACTURA 

/*=============================================
			CENTRO DE LA FACTURA
=============================================*/

//POSICION ORIGINAL DUPLICADO TRIPLICADO
$pdf -> SetY(11);
$pdf -> SetX(90);
$pdf -> SetFont('Arial','B',16);
$pdf->Cell(0,0,'ORIGINAL');

//POSICION DEL TIPO DE FACTURA
$pdf -> SetY(26);
$pdf -> SetX(98);
$pdf -> SetFont('Arial','B',35);
$pdf->Cell(0,0,'C');

//POSICION DEL NRO COMPROBANTE
$pdf -> SetY(35);
$pdf -> SetX(96);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,$codFactura);


/*=============================================
			IZQUIERDA DE LA FACTURA
=============================================*/

//POSICION DEL NOMBRE FICTICIO
$pdf -> SetY(22);
$pdf -> SetX(12);
$pdf -> SetFont('Arial','B',16);
$pdf->Cell(0,0,'COLEGIO DE ESCRIBANOS');
$pdf -> SetY(28);
$pdf -> SetX(24);
$pdf->Cell(0,0,'DE LA PROVINCIA');
$pdf -> SetY(34);
$pdf -> SetX(32);
$pdf->Cell(0,0,'DE FORMOSA');
//RAZON SOCIAL
$pdf -> SetY(45);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Razón Social:'));
$pdf -> SetX(27);
$pdf -> SetFont('Arial','',7);
$pdf->Cell(0,0,convertirLetras('COLEGIO DE ESCRIBANOS DE LA PROVINCIA DE FORMOSA'));

//DOMICILIO COMERCIAL
$pdf -> SetY(49);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Domicilio Comercial:'));
$pdf -> SetX(35);
$pdf -> SetFont('Arial','',7);
$pdf->Cell(0,0,convertirLetras('PADRE PATINO 812 - FORMOSA '));


//TELEFONO
$pdf -> SetY(53);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Telefono:'));
$pdf -> SetX(22);
$pdf -> SetFont('Arial','',8);
$pdf->Cell(0,0,convertirLetras('3704-429330 // 3704-431837'));

//CONDICION FRENTE AL IVA
$pdf -> SetY(57);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Condición frente al IVA:'));
$pdf -> SetX(40);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Iva Exento'));

/*=============================================
			DERECHA DE LA FACTURA
=============================================*/
//POSICION DE LA PALABRA FACTURA
$pdf -> SetY(22);
$pdf -> SetX(122);
$pdf -> SetFont('Arial','B',18);
$pdf->Cell(0,0,$tituloFactura);


//POSICION DE PUNTO DE VENTA Y NRO DE COMPROBANTE
$pdf -> SetY(33);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Punto de Venta:'));
$pdf -> SetY(33);
$pdf -> SetX(145);
$pdf -> SetFont('Arial','B',9);
$pdf->Cell(0,0,convertirLetras($codigo[0]));

$pdf -> SetY(33);
$pdf -> SetX(160);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Comp. Nro: '));
$pdf -> SetY(33);
$pdf -> SetX(180);
$pdf -> SetFont('Arial','B',9);
$pdf->Cell(0,0,convertirLetras($codigo[1]));

//FECHA DE EMISION
$pdf -> SetY(38);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Fecha de Emisión:'));
$pdf -> SetY(38);
$pdf -> SetX(148);
$pdf -> SetFont('Arial','B',9);
$pdf->Cell(0,0,convertirLetras($fecha));

//CUIT
$pdf -> SetY(46);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('CUIT:'));

$pdf -> SetY(46);
$pdf -> SetX(130);
$pdf -> SetFont('Arial','',9);
$pdf->Cell(0,0,convertirLetras('30584197680'));

//INGRESOS BRUTOS
$pdf -> SetY(50);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Ingresos Brutos:'));

$pdf -> SetY(50);
$pdf -> SetX(146);
$pdf -> SetFont('Arial','',9);
$pdf->Cell(0,0,convertirLetras('30584197680'));

//INICIO DE ACTIVIDADES
$pdf -> SetY(54);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Fecha de Inicio de Actividades:'));

$pdf -> SetY(54);
$pdf -> SetX(165);
$pdf -> SetFont('Arial','',9);
$pdf->Cell(0,0,convertirLetras('07/10/1979'));



/*=============================================
			CAJA CLIENTE
=============================================*/
//CUIT
$pdf -> SetY(68);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras($descripcionTipoDoc));

$pdf -> SetY(68);
$pdf -> SetX(18);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,$ventas["documento"]);
//POSICION DEL NOMBRE DEL CLIENTE
$pdf -> SetY(68);
$pdf -> SetX(50);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Apellido y Nombre / Razón Social:'));

$pdf -> SetY(68);
$pdf -> SetX(110);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras($ventas["nombre"]));
//TIPO DE IVA
$pdf -> SetY(76);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Condición frente al IVA:'));

//primera linea

if ($ventas["id_cliente"]!=0){

	if(strlen($tipoIva)<=37){

	$pdf -> SetY(76);
	$pdf -> SetX(50);
	$pdf -> SetFont('Arial','',10);
	$pdf->Cell(0,0,convertirLetras($tipoIva));

	}else{

		$dividirPalabra =explode('-',$tipoIva);

		$pdf -> SetY(76);
		$pdf -> SetX(50);
		$pdf -> SetFont('Arial','',10);
		$pdf->Cell(0,0,convertirLetras($dividirPalabra[0]));
		$pdf -> SetY(80);
		$pdf -> SetX(50);
		$pdf -> SetFont('Arial','',10);
		$pdf->Cell(0,0,convertirLetras($dividirPalabra[1]));
	}
}else{

	$pdf -> SetY(76);
	$pdf -> SetX(50);
	$pdf -> SetFont('Arial','',10);
	$pdf->Cell(0,0,convertirLetras("CONSUMIDOR FINAL"));
}




//CONDICION DE VENTA
$pdf -> SetY(84);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Condición de Venta:'));

$pdf -> SetY(84);
$pdf -> SetX(45);
$pdf -> SetFont('Arial','',10);

if ($ventas['referenciapago']=="EFECTIVO"){

	$pdf->Cell(0,0,'Contado');

}else{

	$pdf->Cell(0,0,$ventas['metodo_pago']);
}

//DOMICILIO 
$pdf -> SetY(76);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Domicilio:'));

$pdf -> SetY(76);
$pdf -> SetX(138);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras($escribanos['direccion']));

$pdf -> SetY(80);
$pdf -> SetX(138);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras($escribanos['localidad']));
/*=============================================
			ENCABEZADO
=============================================*/
//PRODUCTO
$pdf -> SetY(93);
$pdf -> SetX(50);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Producto / Servicio'));
//CANTIDAD
$pdf -> SetY(93);
$pdf -> SetX(121);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Cantidad'));
//PRECIO UNITARIO
$pdf -> SetY(93);
$pdf -> SetX(143);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Precio Unit.'));

//PRECIO TOTAL
$pdf -> SetY(93);
$pdf -> SetX(176);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Subtotal'));


/*=============================================
			  PRODUCTOS
=============================================*/
$renglon1=101;
$espaciorenglon=0;
$veces=0;
//TOMO LOS PRODUCTOS EN UN ARRAY
$productosVentas =  json_decode($ventas["productos"], true);

foreach ($productosVentas as $key => $rsCtaART) {
	
	$pdf -> SetFont('Arial','',10);	
	$pdf -> SetY($renglon1+($espaciorenglon*$veces));
	$pdf -> SetX(8);

	$miItem=convertirLetras($rsCtaART['descripcion']);

	if($ventas["tipo"]=="FC"){
	
		if ($rsCtaART['folio1']!=1){

			$miItem.=' del '.$rsCtaART['folio1'].' al '.$rsCtaART['folio2'];
		}

	}
	
	$pdf->Cell(0,0,$miItem,0,0,'L');

	
	$pdf -> SetX(110);
	$pdf->Cell(28,0,$rsCtaART['cantidad'],0,0,'R');
	
	
	$pdf -> SetX(147);
	$pdf->Cell(16,0,$rsCtaART['precio'],0,0,'R');
	$subtotal=$rsCtaART['precio']*$rsCtaART['cantidad'];
	
	$pdf -> SetX($parametros['formatoitem1posXtotal']);
	$pdf->Cell(0,0,$subtotal,0,0,'R');
	$espaciorenglon=$parametros['formatoitem1posY2'];
	$veces++;
}

/*=============================================
			CAJA DE SUBTOTALES
=============================================*/
//SUBTOTAL
$pdf -> SetY(207);
$pdf -> SetX(150);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(10,0,convertirLetras('Subtotal: $'),0,0,'R');

$pdf -> SetY(207);
$pdf -> SetX(190);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10,0,number_format($ventas['total'], 2, ',', ''),0,0,'R');

//OTROS ATRIBUTOS
$pdf -> SetY(217);
$pdf -> SetX(150);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(10,0,convertirLetras('Importe Otros Tributos: $'),0,0,'R');

$pdf -> SetY(217);
$pdf -> SetX(190);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10,0,convertirLetras('0,00'),0,0,'R');

//OTROS ATRIBUTOS
$pdf -> SetY(227);
$pdf -> SetX(150);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(10,0,convertirLetras('Importe Total: $'),0,0,'R');

$pdf -> SetY(227);
$pdf -> SetX(190);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10,0,number_format($ventas['total'], 2, ',', ''),0,0,'R');

/*=============================================
			CAJA DEL NOMBRE
=============================================*/
//NOMBRE
$pdf -> SetY(245);
$pdf -> SetX(10);
$pdf -> SetFont('Arial','BI',8);
$pdf->Cell(0,0,convertirLetras('"COLEGIO DE ESCRIBANOS DE LA PROVINCIA DE FORMOSA."'));
$pdf -> SetX(100);
$pdf->Cell(0,0,convertirLetras('"Los trámites de apostilla tienen una demora de 24 a 48 hs. como mínimo."'));

/*=============================================
			PIE DE PAGINA
=============================================*/
//PAGINACION
$pdf -> SetY(255);
$pdf -> SetX(90);
$pdf -> SetFont('Arial','B',12);
$pdf->Cell(0,0,convertirLetras('Pág. 1/3'));

//CAE
$pdf -> SetY(255);
$pdf -> SetX(155);
$pdf -> SetFont('Arial','B',12);
$pdf->Cell(15,0,convertirLetras('CAE Nro.:'),0,0,'R');

$pdf -> SetY(255);
$pdf -> SetX(170);
$pdf -> SetFont('Arial','',12);
$pdf->Cell(15,0,convertirLetras($ventas['cae']),0,0,'L');

//FECHA CAE
$pdf -> SetY(260);
$pdf -> SetX(155);
$pdf -> SetFont('Arial','B',12);
$pdf->Cell(15,0,convertirLetras('Fecha de Vto. de CAE:'),0,0,'R');

$pdf -> SetY(260);
$pdf -> SetX(170);
$pdf -> SetFont('Arial','',12);
$pdf->Cell(15,0,convertirLetras($ventas['fecha_cae']),0,0,'L');

//IMAGEN
$pdf->Image('../../../vistas/img/afip/afip.jpg' , 5 ,252, 45 , 17,'JPG', '');

$pdf -> SetY(270);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','BI',5);
$pdf->Cell(15,0,convertirLetras('Esta Administración Federal no se responsabiliza por los datos ingresados en el detalle de la operación'),0,0,'L');
//IMAGEN
barcode('../../codigos/'.$codigodeBarra.$ultimoDigito.'.png', $codigodeBarra.$ultimoDigito, 50, 'horizontal', 'code128', true);
$pdf->Image('../../codigos/'.$codigodeBarra.$ultimoDigito.'.png', 12 ,273, 70 , 14,'PNG', '');

// $pdf -> SetY(272);
// $pdf -> SetX(18);
// $pdf -> SetFont('Arial','',7);
// $pdf->Cell(15,0,convertirLetras($codigodeBarra.$ultimoDigito));


/*================================
=            PAGINA 2            =
================================*/

$pdf->Image('../../../vistas/img/afip/factura.jpg' , 5,NULL, 200 , 245,'JPG', '');
$pagina2=5;
//ENCABEZADO FACTURA 

/*=============================================
			CENTRO DE LA FACTURA
=============================================*/

//POSICION ORIGINAL DUPLICADO TRIPLICADO
$pdf -> SetY(11+$pagina2);
$pdf -> SetX(87);
$pdf -> SetFont('Arial','B',16);
$pdf->Cell(0,0,'DUPLICADO');

//POSICION DEL TIPO DE FACTURA
$pdf -> SetY(26+$pagina2);
$pdf -> SetX(98);
$pdf -> SetFont('Arial','B',35);
$pdf->Cell(0,0,'C');

//POSICION DEL NRO COMPROBANTE
$pdf -> SetY(35+$pagina2);
$pdf -> SetX(96);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,$codFactura);

/*=============================================
			IZQUIERDA DE LA FACTURA
=============================================*/

//POSICION DEL NOMBRE FICTICIO
$pdf -> SetY(22+$pagina2);
$pdf -> SetX(12);
$pdf -> SetFont('Arial','B',16);
$pdf->Cell(0,0,'COLEGIO DE ESCRIBANOS');
$pdf -> SetY(28+$pagina2);
$pdf -> SetX(24);
$pdf->Cell(0,0,'DE LA PROVINCIA');
$pdf -> SetY(34+$pagina2);
$pdf -> SetX(32);
$pdf->Cell(0,0,'DE FORMOSA');
//RAZON SOCIAL
$pdf -> SetY(45+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Razón Social:'));
$pdf -> SetX(27);
$pdf -> SetFont('Arial','',7);
$pdf->Cell(0,0,convertirLetras('COLEGIO DE ESCRIBANOS DE LA PROVINCIA DE FORMOSA'));

//DOMICILIO COMERCIAL
$pdf -> SetY(49+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Domicilio Comercial:'));
$pdf -> SetX(35);
$pdf -> SetFont('Arial','',7);
$pdf->Cell(0,0,convertirLetras('PADRE PATINO 812 - FORMOSA '));

//TELEFONO
$pdf -> SetY(53+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Telefono:'));
$pdf -> SetX(22);
$pdf -> SetFont('Arial','',8);
$pdf->Cell(0,0,convertirLetras('3704-429330 // 3704-431837'));

//CONDICION FRENTE AL IVA
$pdf -> SetY(57+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Condición frente al IVA:'));
$pdf -> SetX(40);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Iva Exento'));

/*=============================================
			DERECHA DE LA FACTURA
=============================================*/
//POSICION DE LA PALABRA FACTURA
$pdf -> SetY(22+$pagina2);
$pdf -> SetX(122);
$pdf -> SetFont('Arial','B',18);
$pdf->Cell(0,0,$tituloFactura);


//POSICION DE PUNTO DE VENTA Y NRO DE COMPROBANTE
$pdf -> SetY(33+$pagina2);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Punto de Venta:'));
$pdf -> SetY(33+$pagina2);
$pdf -> SetX(145);
$pdf -> SetFont('Arial','B',9);
$pdf->Cell(0,0,convertirLetras($codigo[0]));

$pdf -> SetY(33+$pagina2);
$pdf -> SetX(160);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Comp. Nro: '));
$pdf -> SetY(33+$pagina2);
$pdf -> SetX(180);
$pdf -> SetFont('Arial','B',9);
$pdf->Cell(0,0,convertirLetras($codigo[1]));

//FECHA DE EMISION
$pdf -> SetY(38+$pagina2);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Fecha de Emisión:'));
$pdf -> SetY(38+$pagina2);
$pdf -> SetX(148);
$pdf -> SetFont('Arial','B',9);
$pdf->Cell(0,0,convertirLetras($fecha));

//CUIT
$pdf -> SetY(46+$pagina2);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras($descripcionTipoDoc));

$pdf -> SetY(46+$pagina2);
$pdf -> SetX(130);
$pdf -> SetFont('Arial','',9);
$pdf->Cell(0,0,convertirLetras('30584197680'));

//INGRESOS BRUTOS
$pdf -> SetY(50+$pagina2);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Ingresos Brutos:'));

$pdf -> SetY(50+$pagina2);
$pdf -> SetX(146);
$pdf -> SetFont('Arial','',9);
$pdf->Cell(0,0,convertirLetras('30584197680'));

//INICIO DE ACTIVIDADES
$pdf -> SetY(54+$pagina2);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',8);
$pdf->Cell(0,0,convertirLetras('Fecha de Inicio de Actividades:'));

$pdf -> SetY(54+$pagina2);
$pdf -> SetX(165);
$pdf -> SetFont('Arial','',9);
$pdf->Cell(0,0,convertirLetras('07/10/1979'));



/*=============================================
			CAJA CLIENTE
=============================================*/
//CUIT
$pdf -> SetY(68+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras($descripcionTipoDoc));

$pdf -> SetY(68+$pagina2);
$pdf -> SetX(18);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,$ventas["documento"]);
//POSICION DEL NOMBRE DEL CLIENTE
$pdf -> SetY(68+$pagina2);
$pdf -> SetX(50);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Apellido y Nombre / Razón Social:'));

$pdf -> SetY(68+$pagina2);
$pdf -> SetX(110);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras($ventas["nombre"]));
//TIPO DE IVA
$pdf -> SetY(76+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Condición frente al IVA:'));

//primera linea

if ($ventas["id_cliente"]!=0){

	if(strlen($tipoIva)<=37){

	$pdf -> SetY(81);
	$pdf -> SetX(50);
	$pdf -> SetFont('Arial','',10);
	$pdf->Cell(0,0,convertirLetras($tipoIva));

	}else{

		$dividirPalabra =explode('-',$tipoIva);

		$pdf -> SetY(81);
		$pdf -> SetX(50);
		$pdf -> SetFont('Arial','',10);
		$pdf->Cell(0,0,convertirLetras($dividirPalabra[0]));
		$pdf -> SetY(85);
		$pdf -> SetX(50);
		$pdf -> SetFont('Arial','',10);
		$pdf->Cell(0,0,convertirLetras($dividirPalabra[1]));
	}
}else{

	$pdf -> SetY(81);
	$pdf -> SetX(50);
	$pdf -> SetFont('Arial','',10);
	$pdf->Cell(0,0,convertirLetras("CONSUMIDOR FINAL"));
}




//CONDICION DE VENTA
$pdf -> SetY(84+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Condición de Venta:'));

$pdf -> SetY(84+$pagina2);
$pdf -> SetX(45);
$pdf -> SetFont('Arial','',10);

if ($ventas['referenciapago']=="EFECTIVO"){

	$pdf->Cell(0,0,'Contado');

}else{

	$pdf->Cell(0,0,$ventas['metodo_pago']);
}

//DOMICILIO 
$pdf -> SetY(76+$pagina2);
$pdf -> SetX(120);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(0,0,convertirLetras('Domicilio:'));

$pdf -> SetY(76+$pagina2);
$pdf -> SetX(138);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras($escribanos['direccion']));

$pdf -> SetY(80+$pagina2);
$pdf -> SetX(138);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras($escribanos['localidad']));
/*=============================================
			ENCABEZADO
=============================================*/
//PRODUCTO
$pdf -> SetY(93+$pagina2);
$pdf -> SetX(50);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Producto / Servicio'));
//CANTIDAD
$pdf -> SetY(93+$pagina2);
$pdf -> SetX(121);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Cantidad'));
//PRECIO UNITARIO
$pdf -> SetY(93+$pagina2);
$pdf -> SetX(143);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Precio Unit.'));

//PRECIO TOTAL
$pdf -> SetY(93+$pagina2);
$pdf -> SetX(176);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(0,0,convertirLetras('Subtotal'));


/*=============================================
			  PRODUCTOS
=============================================*/
$renglon1=101;
$espaciorenglon=0;
$veces=0;
//TOMO LOS PRODUCTOS EN UN ARRAY
$productosVentas =  json_decode($ventas["productos"], true);

foreach ($productosVentas as $key => $rsCtaART) {
	
	$pdf -> SetFont('Arial','',10);	
	$pdf -> SetY($renglon1+($espaciorenglon*$veces)+$pagina2);
	$pdf -> SetX(8);

	$miItem=convertirLetras($rsCtaART['descripcion']);

	if ($rsCtaART['folio1']!=1){

		$miItem.=' del '.$rsCtaART['folio1'].' al '.$rsCtaART['folio2'];
	}
	
	

	$pdf->Cell(0,0,$miItem,0,0,'L');

	
	$pdf -> SetX(110);
	$pdf->Cell(28,0,$rsCtaART['cantidad'],0,0,'R');
	
	
	$pdf -> SetX(147+$pagina2);
	$pdf->Cell(12,0,$rsCtaART['precio'],0,0,'R');
	$subtotal=$rsCtaART['precio']*$rsCtaART['cantidad'];
	
	$pdf -> SetX($parametros['formatoitem1posXtotal']);
	$pdf->Cell(0,0,$subtotal,0,0,'R');
	$espaciorenglon=$parametros['formatoitem1posY2'];
	$veces++;
}

/*=============================================
			CAJA DE SUBTOTALES
=============================================*/
//SUBTOTAL
$pdf -> SetY(207+$pagina2);
$pdf -> SetX(150);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(10,0,convertirLetras('Subtotal: $'),0,0,'R');

$pdf -> SetY(207+$pagina2);
$pdf -> SetX(190);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10,0,number_format($ventas['total'], 2, ',', ''),0,0,'R');

//OTROS ATRIBUTOS
$pdf -> SetY(217+$pagina2);
$pdf -> SetX(150);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(10,0,convertirLetras('Importe Otros Tributos: $'),0,0,'R');

$pdf -> SetY(217+$pagina2);
$pdf -> SetX(190);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10,0,convertirLetras('0,00'),0,0,'R');

//OTROS ATRIBUTOS
$pdf -> SetY(227+$pagina2);
$pdf -> SetX(150);
$pdf -> SetFont('Arial','B',10);
$pdf->Cell(10,0,convertirLetras('Importe Total: $'),0,0,'R');

$pdf -> SetY(227+$pagina2);
$pdf -> SetX(190);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10,0,number_format($ventas['total'], 2, ',', ''),0,0,'R');

/*=============================================
			CAJA DEL NOMBRE
=============================================*/
//NOMBRE
$pdf -> SetY(245+$pagina2);
$pdf -> SetX(10);
$pdf -> SetFont('Arial','BI',8);
$pdf->Cell(0,0,convertirLetras('"COLEGIO DE ESCRIBANOS DE LA PROVINCIA DE FORMOSA."'));
$pdf -> SetX(100);
$pdf->Cell(0,0,convertirLetras('"Los trámites de apostilla tienen una demora de 24 a 48 hs. como mínimo."'));

/*=============================================
			PIE DE PAGINA
=============================================*/
//PAGINACION
$pdf -> SetY(255+$pagina2);
$pdf -> SetX(90);
$pdf -> SetFont('Arial','B',12);
$pdf->Cell(0,0,convertirLetras('Pág. 2/3'));

//CAE
$pdf -> SetY(255+$pagina2);
$pdf -> SetX(155);
$pdf -> SetFont('Arial','B',12);
$pdf->Cell(15,0,convertirLetras('CAE Nro.:'),0,0,'R');

$pdf -> SetY(255+$pagina2);
$pdf -> SetX(170);
$pdf -> SetFont('Arial','',12);
$pdf->Cell(15,0,convertirLetras($ventas['cae']),0,0,'L');

//FECHA CAE
$pdf -> SetY(260+$pagina2);
$pdf -> SetX(155);
$pdf -> SetFont('Arial','B',12);
$pdf->Cell(15,0,convertirLetras('Fecha de Vto. de CAE:'),0,0,'R');

$pdf -> SetY(260+$pagina2);
$pdf -> SetX(170);
$pdf -> SetFont('Arial','',12);
$pdf->Cell(15,0,convertirLetras($ventas['fecha_cae']),0,0,'L');

//IMAGEN
$pdf->Image('../../../vistas/img/afip/afip.jpg' , 5 ,252+$pagina2, 45 , 17,'JPG', '');

$pdf -> SetY(270+$pagina2);
$pdf -> SetX(6);
$pdf -> SetFont('Arial','BI',5);
$pdf->Cell(15,0,convertirLetras('Esta Administración Federal no se responsabiliza por los datos ingresados en el detalle de la operación'),0,0,'L');
//IMAGEN
// $pdf->Image('../../../vistas/img/afip/codigobarra.jpg' , 12 ,273+$pagina2, 70 , 14,'JPG', '');

$pdf->Image('../../codigos/'.$codigodeBarra.$ultimoDigito.'.png', 12 ,273+$pagina2, 70 , 14,'PNG', '');

/*=====  End of PAGINA 2  ======*/

/*================================
=            PAGINA 3           =
================================*/

// $pdf->Image('../../../vistas/img/afip/factura.jpg' , 5,NULL, 200 , 245,'JPG', '');
// $pagina2=5;
// //ENCABEZADO FACTURA 

// /*=============================================
// 			CENTRO DE LA FACTURA
// =============================================*/

// //POSICION ORIGINAL DUPLICADO TRIPLICADO
// $pdf -> SetY(11+$pagina2);
// $pdf -> SetX(87);
// $pdf -> SetFont('Arial','B',16);
// $pdf->Cell(0,0,'TRIPLICADO');

// //POSICION DEL TIPO DE FACTURA
// $pdf -> SetY(26+$pagina2);
// $pdf -> SetX(98);
// $pdf -> SetFont('Arial','B',35);
// $pdf->Cell(0,0,'C');

// //POSICION DEL NRO COMPROBANTE
// $pdf -> SetY(35+$pagina2);
// $pdf -> SetX(96);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,$codFactura);

// /*=============================================
// 			IZQUIERDA DE LA FACTURA
// =============================================*/

// //POSICION DEL NOMBRE FICTICIO
// $pdf -> SetY(22+$pagina2);
// $pdf -> SetX(12);
// $pdf -> SetFont('Arial','B',16);
// $pdf->Cell(0,0,'COLEGIO DE ESCRIBANOS');
// $pdf -> SetY(28+$pagina2);
// $pdf -> SetX(24);
// $pdf->Cell(0,0,'DE LA PROVINCIA');
// $pdf -> SetY(34+$pagina2);
// $pdf -> SetX(32);
// $pdf->Cell(0,0,'DE FORMOSA');
// //RAZON SOCIAL
// $pdf -> SetY(45+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Razón Social:'));
// $pdf -> SetX(27);
// $pdf -> SetFont('Arial','',7);
// $pdf->Cell(0,0,convertirLetras('COLEGIO DE ESCRIBANOS DE LA PROVINCIA DE FORMOSA'));

// //DOMICILIO COMERCIAL
// $pdf -> SetY(49+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Domicilio Comercial:'));
// $pdf -> SetX(35);
// $pdf -> SetFont('Arial','',7);
// $pdf->Cell(0,0,convertirLetras('PADRE PATINO 812 - FORMOSA '));

// //CONDICION FRENTE AL IVA
// $pdf -> SetY(53+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Condición frente al IVA:'));
// $pdf -> SetX(40);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Iva Exento'));

// /*=============================================
// 			DERECHA DE LA FACTURA
// =============================================*/
// //POSICION DE LA PALABRA FACTURA
// $pdf -> SetY(22+$pagina2);
// $pdf -> SetX(122);
// $pdf -> SetFont('Arial','B',18);
// $pdf->Cell(0,0,$tituloFactura);


// //POSICION DE PUNTO DE VENTA Y NRO DE COMPROBANTE
// $pdf -> SetY(33+$pagina2);
// $pdf -> SetX(120);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Punto de Venta:'));
// $pdf -> SetY(33+$pagina2);
// $pdf -> SetX(145);
// $pdf -> SetFont('Arial','B',9);
// $pdf->Cell(0,0,convertirLetras($codigo[0]));

// $pdf -> SetY(33+$pagina2);
// $pdf -> SetX(160);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Comp. Nro: '));
// $pdf -> SetY(33+$pagina2);
// $pdf -> SetX(180);
// $pdf -> SetFont('Arial','B',9);
// $pdf->Cell(0,0,convertirLetras($codigo[1]));

// //FECHA DE EMISION
// $pdf -> SetY(38+$pagina2);
// $pdf -> SetX(120);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Fecha de Emisión:'));
// $pdf -> SetY(38+$pagina2);
// $pdf -> SetX(148);
// $pdf -> SetFont('Arial','B',9);
// $pdf->Cell(0,0,convertirLetras($fecha));

// //CUIT
// $pdf -> SetY(46+$pagina2);
// $pdf -> SetX(120);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('CUIT:'));

// $pdf -> SetY(46+$pagina2);
// $pdf -> SetX(130);
// $pdf -> SetFont('Arial','',9);
// $pdf->Cell(0,0,convertirLetras('30584197680'));

// //INGRESOS BRUTOS
// $pdf -> SetY(50+$pagina2);
// $pdf -> SetX(120);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Ingresos Brutos:'));

// $pdf -> SetY(50+$pagina2);
// $pdf -> SetX(146);
// $pdf -> SetFont('Arial','',9);
// $pdf->Cell(0,0,convertirLetras('30584197680'));

// //INICIO DE ACTIVIDADES
// $pdf -> SetY(54+$pagina2);
// $pdf -> SetX(120);
// $pdf -> SetFont('Arial','B',8);
// $pdf->Cell(0,0,convertirLetras('Fecha de Inicio de Actividades:'));

// $pdf -> SetY(54+$pagina2);
// $pdf -> SetX(165);
// $pdf -> SetFont('Arial','',9);
// $pdf->Cell(0,0,convertirLetras('07/10/1979'));



// /*=============================================
// 			CAJA CLIENTE
// =============================================*/
// //CUIT
// $pdf -> SetY(68+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(0,0,convertirLetras('CUIT:'));

// $pdf -> SetY(68+$pagina2);
// $pdf -> SetX(18);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,$ventas["documento"]);
// //POSICION DEL NOMBRE DEL CLIENTE
// $pdf -> SetY(68+$pagina2);
// $pdf -> SetX(50);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(0,0,convertirLetras('Apellido y Nombre / Razón Social:'));

// $pdf -> SetY(68+$pagina2);
// $pdf -> SetX(110);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras($ventas["nombre"]));
// //TIPO DE IVA
// $pdf -> SetY(76+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(0,0,convertirLetras('Condición frente al IVA:'));

// //primera linea

// if(strlen($tipoIva)<=37){

// 	$pdf -> SetY(76+$pagina2);
// 	$pdf -> SetX(50);
// 	$pdf -> SetFont('Arial','',10);
// 	$pdf->Cell(0,0,convertirLetras($tipoIva));

// }else{

// 	$dividirPalabra =explode('-',$tipoIva);

// 	$pdf -> SetY(76+$pagina2);
// 	$pdf -> SetX(50);
// 	$pdf -> SetFont('Arial','',10);
// 	$pdf->Cell(0,0,convertirLetras($dividirPalabra[0]));
// 	$pdf -> SetY(80+$pagina2);
// 	$pdf -> SetX(50);
// 	$pdf -> SetFont('Arial','',10);
// 	$pdf->Cell(0,0,convertirLetras($dividirPalabra[1]));
// }




// //CONDICION DE VENTA
// $pdf -> SetY(84+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(0,0,convertirLetras('Condición de Venta:'));

// $pdf -> SetY(84+$pagina2);
// $pdf -> SetX(45);
// $pdf -> SetFont('Arial','',10);

// if ($ventas['referenciapago']=="EFECTIVO"){

// 	$pdf->Cell(0,0,'Contado');

// }else{

// 	$pdf->Cell(0,0,$ventas['metodo_pago']);
// }

// //DOMICILIO 
// $pdf -> SetY(76+$pagina2);
// $pdf -> SetX(120);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(0,0,convertirLetras('Domicilio:'));

// $pdf -> SetY(76+$pagina2);
// $pdf -> SetX(138);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras($escribanos['direccion']));

// $pdf -> SetY(80+$pagina2);
// $pdf -> SetX(138);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras($escribanos['localidad']));
// /*=============================================
// 			ENCABEZADO
// =============================================*/
// //PRODUCTO
// $pdf -> SetY(93+$pagina2);
// $pdf -> SetX(50);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras('Producto / Servicio'));
// //CANTIDAD
// $pdf -> SetY(93+$pagina2);
// $pdf -> SetX(121);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras('Cantidad'));
// //PRECIO UNITARIO
// $pdf -> SetY(93+$pagina2);
// $pdf -> SetX(143);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras('Precio Unit.'));

// //PRECIO TOTAL
// $pdf -> SetY(93+$pagina2);
// $pdf -> SetX(176);
// $pdf -> SetFont('Arial','',10);
// $pdf->Cell(0,0,convertirLetras('Subtotal'));


// /*=============================================
// 			  PRODUCTOS
// =============================================*/
// $renglon1=101;
// $espaciorenglon=0;
// $veces=0;
// //TOMO LOS PRODUCTOS EN UN ARRAY
// $productosVentas =  json_decode($ventas["productos"], true);

// foreach ($productosVentas as $key => $rsCtaART) {
	
// 	$pdf -> SetFont('Arial','',10);	
// 	$pdf -> SetY($renglon1+($espaciorenglon*$veces)+$pagina2);
// 	$pdf -> SetX(8);

// 	$miItem=convertirLetras($rsCtaART['descripcion']);

// 	if ($rsCtaART['folio1']!=1){

// 		$miItem.=' del '.$rsCtaART['folio1'].' al '.$rsCtaART['folio2'];
// 	}
	
	

// 	$pdf->Cell(0,0,$miItem,0,0,'L');

	
// 	$pdf -> SetX(110);
// 	$pdf->Cell(28,0,$rsCtaART['cantidad'],0,0,'R');
	
	
// 	$pdf -> SetX(147+$pagina2);
// 	$pdf->Cell(12,0,$rsCtaART['precio'],0,0,'R');
// 	$subtotal=$rsCtaART['precio']*$rsCtaART['cantidad'];
	
// 	$pdf -> SetX($parametros['formatoitem1posXtotal']);
// 	$pdf->Cell(0,0,$subtotal,0,0,'R');
// 	$espaciorenglon=$parametros['formatoitem1posY2'];
// 	$veces++;
// }

// /*=============================================
// 			CAJA DE SUBTOTALES
// =============================================*/
// //SUBTOTAL
// $pdf -> SetY(207+$pagina2);
// $pdf -> SetX(150);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(10,0,convertirLetras('Subtotal: $'),0,0,'R');

// $pdf -> SetY(207+$pagina2);
// $pdf -> SetX(190);
// $pdf -> SetFont('Arial','B',10);
// $pdf -> Cell(10,0,number_format($ventas['total'], 2, ',', ''),0,0,'R');

// //OTROS ATRIBUTOS
// $pdf -> SetY(217+$pagina2);
// $pdf -> SetX(150);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(10,0,convertirLetras('Importe Otros Tributos: $'),0,0,'R');

// $pdf -> SetY(217+$pagina2);
// $pdf -> SetX(190);
// $pdf -> SetFont('Arial','B',10);
// $pdf -> Cell(10,0,convertirLetras('0,00'),0,0,'R');

// //OTROS ATRIBUTOS
// $pdf -> SetY(227+$pagina2);
// $pdf -> SetX(150);
// $pdf -> SetFont('Arial','B',10);
// $pdf->Cell(10,0,convertirLetras('Importe Total: $'),0,0,'R');

// $pdf -> SetY(227+$pagina2);
// $pdf -> SetX(190);
// $pdf -> SetFont('Arial','B',10);
// $pdf -> Cell(10,0,number_format($ventas['total'], 2, ',', ''),0,0,'R');

// /*=============================================
// 			CAJA DEL NOMBRE
// =============================================*/
// //NOMBRE
// $pdf -> SetY(245+$pagina2);
// $pdf -> SetX(35);
// $pdf -> SetFont('Arial','I',14);
// $pdf->Cell(0,0,convertirLetras('"COLEGIO DE ESCRIBANOS DE LA PROVINCIA DE FORMOSA"'));

// /*=============================================
// 			PIE DE PAGINA
// =============================================*/
// //PAGINACION
// $pdf -> SetY(255+$pagina2);
// $pdf -> SetX(90);
// $pdf -> SetFont('Arial','B',12);
// $pdf->Cell(0,0,convertirLetras('Pág. 3/3'));

// //CAE
// $pdf -> SetY(255+$pagina2);
// $pdf -> SetX(155);
// $pdf -> SetFont('Arial','B',12);
// $pdf->Cell(15,0,convertirLetras('CAE Nro.:'),0,0,'R');

// $pdf -> SetY(255+$pagina2);
// $pdf -> SetX(170);
// $pdf -> SetFont('Arial','',12);
// $pdf->Cell(15,0,convertirLetras($ventas['cae']),0,0,'L');

// //FECHA CAE
// $pdf -> SetY(260+$pagina2);
// $pdf -> SetX(155);
// $pdf -> SetFont('Arial','B',12);
// $pdf->Cell(15,0,convertirLetras('Fecha de Vto. de CAE:'),0,0,'R');

// $pdf -> SetY(260+$pagina2);
// $pdf -> SetX(170);
// $pdf -> SetFont('Arial','',12);
// $pdf->Cell(15,0,convertirLetras($ventas['fecha_cae']),0,0,'L');

// //IMAGEN
// $pdf->Image('../../../vistas/img/afip/afip.jpg' , 5 ,252+$pagina2, 45 , 17,'JPG', '');

// $pdf -> SetY(270+$pagina2);
// $pdf -> SetX(6);
// $pdf -> SetFont('Arial','BI',5);
// $pdf->Cell(15,0,convertirLetras('Esta Administración Federal no se responsabiliza por los datos ingresados en el detalle de la operación'),0,0,'L');
// //IMAGEN
// $pdf->Image('../../../vistas/img/afip/codigobarra.jpg' , 12 ,273+$pagina2, 70 , 14,'JPG', '');

// $pdf->Image('../../codigos/'.$codigodeBarra.$ultimoDigito.'.png', 12 ,273+$pagina2, 70 , 14,'PNG', '');
// $pdf -> SetY(272+4.5);
// $pdf -> SetX(18);
// $pdf -> SetFont('Arial','',7);
// $pdf->Cell(15,0,convertirLetras($codigodeBarra.$ultimoDigito));	

/*=====  End of PAGINA 2  ======*/
$pdf->AutoPrint();
$pdf->Output();



?>