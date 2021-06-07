<?php


require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/remitos.controlador.php";
require_once "../../../modelos/remitos.modelo.php";


require_once "../../../controladores/caja.controlador.php";
require_once "../../../modelos/caja.modelo.php";

require_once "../../../controladores/escribanos.controlador.php";
require_once "../../../modelos/escribanos.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/empresa.controlador.php";
require_once "../../../modelos/empresa.modelo.php";



#FUNCION PARA ÑS Y ACENTOS
function convertirLetras($texto){

	$texto = iconv('UTF-8', 'windows-1252', $texto);
	return	 $texto;

}
#NOMBRE DEL INFORME
$nombreDePdf="VENTAS DEL DIA";

#BUSCO LA FECHA
$fecha1=$_GET['fecha1'];
if(!isset($_GET['fecha2'])){

	$fecha2=$_GET['fecha1'];

}else{

	$fecha2=$_GET['fecha2'];

}



$tipoVenta = $_GET['tipoventa'];

#DATOS DE LA EMPRESA
$item = "id";
$valor = 1;

$empresa = ControladorEmpresa::ctrMostrarEmpresa($item, $valor);


// VENTAS
$item= "fecha";
$valor = $fecha1;

$ventasPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);



// REMITOS
$item= "fecha";
$valor = $fecha1;

$remitos = ControladorRemitos::ctrMostrarRemitosFecha($item,$valor);




#PPREPARO EL PDF
require('../fpdf.php');
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$hoja=1;	
//CONFIGURACION DEL LA HORA
date_default_timezone_set('America/Argentina/Buenos_Aires');
//DATOS DEL MOMENTO
$fecha= date("d")."-".date("m")."-".date("Y");
$hora=date("g:i A");
//DATOS QUE RECIBO


$fechaInicio=explode ( '-', $fecha1 );
$fechaInicio=$fechaInicio[2].'-'.$fechaInicio[1].'-'.$fechaInicio[0];
$fechaFin=explode ( '-', $fecha2 );
$fechaFin=$fechaFin[2].'-'.$fechaFin[1].'-'.$fechaFin[0];



//COMIENZA ENCABEZADO
$pdf->SetFont('Arial','B',9);

$pdf->Image('../../../vistas/img/plantilla/logo.jpg' , 5 ,0, 25 , 25,'JPG', 'http://www.bgtoner.com.ar');
$pdf->Text(35, 7,convertirLetras("COLEGIO DE ESCRIBANOS"));
$pdf->Text(35, 10,convertirLetras("DE LA PROVINCIA DE FORMOSA"));
$pdf->Text(150, 7,convertirLetras($nombreDePdf));

$pdf->SetFont('','',8);
$pdf->Text(150, 12,convertirLetras("Fecha: ".$fecha));
$pdf->Text(178, 12,convertirLetras("Hora: ".$hora));
// $pdf->Text(150, 16,convertirLetras("Usuario: ADMIN"));

$pdf->SetFont('','',6);
$pdf->Text(35, 19,convertirLetras($empresa['direccion']."   Tel.: ".$empresa['telefono']));
$pdf->Text(35, 22,convertirLetras("CUIT Nro. ".$empresa['cuit']." Ingresos Brutos 01-".$empresa['cuit']));
$pdf->Text(35, 25,convertirLetras("Inicio Actividades 02-01-1981 IVA Excento"));




$pdf->SetFont('','',8);
$pdf->Text(100, 27,convertirLetras("Hoja -".$hoja++));

if($fecha1==$fecha2){

	$pdf->Text(135, 25,convertirLetras("FECHA DE CONSULTA: Del ".$fechaInicio));

}else{

	$pdf->Text(135, 25,convertirLetras("FECHA DE CONSULTA: Del ".$fechaInicio." al ".$fechaFin));

}

$pdf->Line(0,28,210, 28);
$altura=30;

// 3º Una tabla con los articulos comprados
$pdf->SetFont('Arial','B',11);
// La cabecera de la tabla (en azulito sobre fondo rojo)
$pdf->SetXY(3,$altura);
$pdf->SetFillColor(26,188,156);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(20,10,"Fecha",1,0,"C",true);
$pdf->Cell(9,10,"Tipo",1,0,"C",true);
$pdf->Cell(31,10,"Pago",1,0,"C",true);
$pdf->Cell(30,10,"Nro. Factura",1,0,"C",true);
$pdf->Cell(95,10,"Nombre",1,0,"C",true);
$pdf->Cell(20,10,"Entrada",1,0,"C",true);


// Los datos (en negro)
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$altura=$altura+11;
#EFECTIVO VARIBLES
$efectivoVentas=0;
$cantEfectivoVentas=0;
$efectivoRemitos=0;
$cantEfectivoRemitos=0;
#CHEQUE VARIABLES
$chequeVentas=0;
$cantChequeVentas=0;
$chequeRemitos=0;
$cantChequeRemitos=0;
#Tarjeta VARIABLES
$tarjetaVentas=0;
$cantTarjetaVentas=0;
$tarjetaRemitos=0;
$cantTarjetaRemitos=0;
#TRANSFERENCIA VARIABLES
$transferenciaVentas=0;
$cantTransferenciaVentas=0;
$transferenciaRemitos=0;
$cantTransferenciaRemitos=0;
#CTA.CORRIENTE VARIABLES
$ctaCorrienteVentas=0;
$cantCtaVentas=0;
$ctaCorrienteRemitos=0;
$cantCtaRemitos=0;


// $cheque=0;
// $cantCheque=0;
// $tarjeta=0;
// $cantTarjeta=0;
// $transferencia=0;
// $cantTransferencia=0;

$otros=0;
$cantVentas=0;

$cuotaSocial=0;
$cantCuota=0;

$derecho=0;
$cantDerecho=0;

$cantOsde=0;
$osde=0;

$otrosRemitos=0;
$cantVentasRemitos=0;

$cuotaSocialRemitos=0;
$cantCuotaRemitos=0;

$derechoRemitos=0;
$cantDerechoRemitos=0;

$cantOsdeRemitos=0;
$osdeRemitos=0;

$ventasTotal=0;

$contador=0;



if($tipoVenta != "REMITO"){


	foreach($ventasPorFecha as $key=>$rsVentas){

		

			$pdf->SetXY(3,$altura);
			$pdf->Cell(20,5,$rsVentas['fecha'],1,0,"C");
			$pdf->Cell(9,5,$rsVentas['tipo'],1,0,"C");
			$pdf->Cell(31,5,$rsVentas['metodo_pago'],1,0,"C");
			$pdf->Cell(30,5,$rsVentas['codigo'],1,0,"C");
			
			
			$pdf->Cell(95,5,convertirLetras($rsVentas['nombre']),1,0,"L");
			if($rsVentas['tipo']=='NC'){

				$importe=$rsVentas['total']*(-1);
				$pdf->Cell(20,5,$importe,1,0,"C");

			}else{

				$importe=$rsVentas['total'];
				$pdf->Cell(20,5,$importe,1,0,"C");

			}
			
			if($contador<=33){
				
			$listaProductos = json_decode($rsVentas["productos"], true);

			foreach ($listaProductos as $key => $value) {

			   switch ($value['id']) {

			   	case '20':
			   		# cuota...
			   		$cantCuota++;
			   		$cuotaSocial=$value['total']+$cuotaSocial;
			   		break;

			   	case '19':
			   		# derech...
			   		$cantDerecho++;
			   		$derecho=$value['total']+$derecho;
			   		break;

			   	case '22':
			   		# derech...
			   		$cantOsde++;
			   		$osde=$value['total']+$osde;
			   		break;
			   	
			   	default:
			   		# venta...
			   		$cantVentas++;
			   		$otros=$value['total']+$otros;
			   		break;
			   }

			    
			}

			
			
			if (substr($rsVentas['metodo_pago'],0,2)=='EF'){

				$efectivoVentas=$efectivoVentas+$importe;
				$cantEfectivoVentas++;

			}

			if (substr($rsVentas['metodo_pago'],0,2)=='TA'){
				
				$tarjetaVentas=$tarjetaVentas+$importe;
				$cantTarjetaVentas++;

			}

			if (substr($rsVentas['metodo_pago'],0,2)=='CH'){
				
				$chequeVentas=$chequeVentas+$importe;
				$cantChequeVentas++;
			}

			if (substr($rsVentas['metodo_pago'],0,2)=='TR'){
				
				$transferenciaVentas=$transferenciaVentas+$importe;
				$cantTransferenciaVentas++;
			}
			if (substr($rsVentas['metodo_pago'],0,2)=='CT'){
				
				$ctaCorrienteVentas=$ctaCorrienteVentas+$importe;
				$cantCtaVentas++;
			}

			

			$altura+=6;
			$contador++;

		}else{

			$contador=0;	
			$pdf->AddPage();
			
		
			
			//ENCAABREZADO
			$altura=30;

			$pdf->SetFont('Arial','B',11);
			// La cabecera de la tabla (en azulito sobre fondo rojo)
			$pdf->SetXY(3,$altura);
			$pdf->SetFillColor(26,188,156);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(20,10,"Fecha",1,0,"C",true);
			$pdf->Cell(9,10,"Tipo",1,0,"C",true);
			$pdf->Cell(31,10,"Pago",1,0,"C",true);
			$pdf->Cell(30,10,"Nro. Factura",1,0,"C",true);
			$pdf->Cell(95,10,"Nombre",1,0,"C",true);
			$pdf->Cell(20,10,"Entrada",1,0,"C",true);
			// $pdf->Cell(20,10,"Salida",1,0,"C",true);
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(5,$altura);
	 		$altura=$altura+11;
	 		$pdf->SetTextColor(0,0,0);
	 		//$cantEfectivo++;


	 

	 		if($rsVentas['tipo']=='NC'){

				$importe=$rsVentas['total']*(-1);
				$pdf->Cell(20,5,$importe,1,0,"C");

			}else{

				// $importe=$rsVentas['total'];
				// $pdf->Cell(20,5,$importe,1,0,"C");

			
			
			if (substr($rsVentas['metodo_pago'],0,2)=='EF'){

				$efectivoVentas=$efectivoVentas+$importe;
				$cantEfectivoVentas++;

			}
			if (substr($rsVentas['metodo_pago'],0,2)=='TA'){
				
				$tarjetaVentas=$tarjetaVentas+$importe;
				$cantTarjetaVentas++;

			}

			if (substr($rsVentas['metodo_pago'],0,2)=='CH'){
				
				$chequeVentas=$chequeVentas+$importe;
				$cantChequeVentas++;

			}

			if (substr($rsVentas['metodo_pago'],0,2)=='TR'){
				
				$transferenciaVentas=$transferenciaVentas+$importe;
				$cantTransferenciaVentas++;

			}

			if (substr($rsVentas['metodo_pago'],0,2)=='CT'){
				
				$ctaCorrienteVentas=$ctaCorrienteVentas+$importe;
				$cantCtaVentas++;

			}
				
			}


			
			$altura+=6;
			$contador++;
			
		}
	}

}

if($tipoVenta != "VENTA"){
	// $totalRemitos = 0;
	foreach ($remitos as $key => $valueRemitos) {
		# code...
		// $totalRemitos = $totalRemitos + $value['total'];
		if($contador<=33){

			$pdf->SetXY(3,$altura);
			$pdf->Cell(20,5,$valueRemitos['fecha'],1,0,"C");
			$pdf->Cell(9,5,$valueRemitos['tipo'],1,0,"C");
			$pdf->Cell(31,5,$valueRemitos['metodo_pago'],1,0,"C");
			$pdf->Cell(30,5,$valueRemitos['codigo'],1,0,"C");
			
			
			$pdf->Cell(95,5,convertirLetras($valueRemitos['nombre']),1,0,"L");
		
			
			
			$listaProductos = json_decode($valueRemitos["productos"], true);

			foreach ($listaProductos as $key => $valueProductos) {

			   switch ($valueProductos['id']) {

			   	case '20':
			   		# cuota...
			   		$cantCuotaRemitos++;
			   		$cuotaSocialRemitos=$valueProductos['total']+$cuotaSocialRemitos;
			   		break;

			   	case '19':
			   		# derech...
			   		$cantDerechoRemitos++;
			   		$derechoRemitos=$valueProductos['total']+$derechoRemitos;
			   		break;

			   	case '22':
			   		# derech...
			   		$cantOsdeRemitos++;
			   		$osdeRemitos=$valueProductos['total']+$osdeRemitos;
			   		break;
			   	
			   	default:
			   		# venta...
			   		$cantVentasRemitos++;
			   		$otrosRemitos=$valueProductos['total']+$otrosRemitos;
			   		break;
			   }

			    
			}

			if($valueRemitos['tipo']=='NC'){
				$importe=$valueRemitos['total']*(-1);
				$pdf->Cell(20,5,$importe,1,0,"C");
			}else{
				$importe=$valueRemitos['total'];
				$pdf->Cell(20,5,$importe,1,0,"C");
			}
			
			if (substr($valueRemitos['metodo_pago'],0,2)=='EF'){
				
				$efectivoRemitos=$efectivoRemitos+$importe;
				$cantEfectivoRemitos++;
			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='TA'){
				
				$tarjetaRemitos=$tarjetaRemitos+$importe;
				$cantTarjetaRemitos++;

			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='CH'){
				
				
				$chequeRemitos=$chequeRemitos+$importe;
				$cantChequeRemitos++;
			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='TR'){
				
				$transferenciaRemitos=$transferenciaRemitos+$importe;
				$cantTransferenciaRemitos++;
			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='CT'){
				
				$ctaCorrienteRemitos=$ctaCorrienteRemitos+$importe;
				$cantCtaRemitos++;
			}


			$altura+=6;
			$contador++;

		}else{

			$contador=0;	
			$pdf->AddPage();
			
		
			
			//ENCAABREZADO
			$altura=30;

			$pdf->SetFont('Arial','B',11);
			// La cabecera de la tabla (en azulito sobre fondo rojo)
			$pdf->SetXY(3,$altura);
			$pdf->SetFillColor(255,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(20,10,"Fecha",1,0,"C",true);
			$pdf->Cell(9,10,"Tipo",1,0,"C",true);
			$pdf->Cell(31,10,"Pago",1,0,"C",true);
			$pdf->Cell(30,10,"Nro. Factura",1,0,"C",true);
			$pdf->Cell(95,10,"Nombre",1,0,"C",true);
			$pdf->Cell(20,10,"Entrada",1,0,"C",true);
		
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(5,$altura);
	 		$altura=$altura+11;
	 		$pdf->SetTextColor(0,0,0);



	 

	 		$pdf->SetXY(3,$altura);
			$pdf->Cell(20,5,$valueRemitos['fecha'],1,0,"C");
			$pdf->Cell(9,5,$valueRemitos['tipo'],1,0,"C");
			$pdf->Cell(31,5,$valueRemitos['metodo_pago'],1,0,"C");
			$pdf->Cell(30,5,$valueRemitos['codigo'],1,0,"C");
			$pdf->Cell(95,5,convertirLetras($valueRemitos['nombre']),1,0,"L");
			
			if ($valueRemitos['tipo']=='FC'){
				$pdf->Cell(20,5,$importe,1,0,"C");
				$pdf->Cell(20,5,'0',1,0,"C");
				if (substr($valueRemitos['metodo_pago'],0,2)=='EF'){
				
				$efectivoRemitos=$efectivoRemitos+$importe;
				$cantEfectivoRemitos++;

			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='TA'){
				
				$tarjetaRemitos=$tarjetaRemitos+$importe;
				$cantTarjetaRemitos++;

			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='CH'){
				
				$chequeRemitos=$chequeRemitos+$importe;
				$cantChequeRemitos++;

			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='TR'){

				$transferenciaRemitos=$transferenciaRemitos+$importe;
				$cantTransferenciaRemitos++;

			}

			if (substr($valueRemitos['metodo_pago'],0,2)=='CT'){
				
				$ctaCorrienteRemitos=$ctaCorrienteRemitos+$importe;
				$cantCtaRemitos++;
			}

				
			}
			
			$altura+=6;
			$contador++;
			
		}
	}

}
$altura+=2;
#TOTALES DE LAS CANTIDADES DEL PRIMER RECUADRO
$cantidadEfectivoVentas = $cantEfectivoVentas+$cantEfectivoRemitos;
$cantidadChequeVentas = $cantChequeVentas+$cantChequeRemitos;
$cantidadTarjetaVentas = $cantTarjetaVentas+$cantTarjetaRemitos;
$cantidadTrasnferenciaVentas = $cantTransferenciaVentas+$cantTransferenciaRemitos;
$cantidadCtaVentas =$cantCtaVentas+$cantCtaRemitos;
#TOTALES DE LA SUMA DE TODOS
$totalCuadro1 = $efectivoVentas+$efectivoRemitos+$transferenciaVentas+$transferenciaRemitos+$tarjetaRemitos+$tarjetaVentas+$chequeRemitos+$chequeVentas+$ctaCorrienteVentas+$ctaCorrienteRemitos;
$totalCantidadesCaja1 = $cantidadEfectivoVentas + $cantidadChequeVentas + $cantidadTarjetaVentas + $cantidadTrasnferenciaVentas + $cantidadCtaVentas;
$pdf->SetFont('Arial','',9);

//PRIMER CUADRADO
$pdf->SetXY(2,$altura);
$pdf->Cell(42,34,'',1,0,"C");
#TITULO
$pdf->SetFont('','U');
$pdf->SetXY(16,$altura+3);
$pdf->Write(0,$_GET['tipoventa']);
#PRIMER RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+7);
$pdf->Cell(23,0,"($cantidadEfectivoVentas)".' Efectivo:',0,0,'R');//CANTIDAD
$pdf->SetXY(18 ,$altura+7);
$pdf->Cell(21,0,$efectivoVentas+$efectivoRemitos,0,0,'R');//IMPORTE
#SEGUNDO RENGLON
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+11);
$pdf->Cell(23,0,"($cantidadChequeVentas)".' Cheque:',0,0,'R');//CANTIDAD
$pdf->SetXY(20 ,$altura+11);
$pdf->Cell(19,0,$chequeVentas+$chequeRemitos,0,0,'R');//IMPORTE
#TERCER RENGLON
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+15);
$pdf->Cell(23,0,"($cantidadTarjetaVentas)".' Tarjeta:',0,0,'R');//CANTIDAD
$pdf->SetXY(20 ,$altura+15);
$pdf->Cell(19,0,$tarjetaVentas+$tarjetaRemitos,0,0,'R');//IMPORTE
#CUARTO RENGLON
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+19);
$pdf->Cell(23,0,"($cantidadTrasnferenciaVentas)".' Transf.:',0,0,'R');//CANTIDAD
$pdf->SetXY(20 ,$altura+19);
$pdf->Cell(19,0,$transferenciaVentas+$transferenciaRemitos,0,0,'R');//IMPORTE
#QUINTO RENGLON
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+23);
$pdf->Cell(23,0,"($cantidadCtaVentas)".' Cta.Corr.:',0,0,'R');//CANTIDAD
$pdf->SetXY(20 ,$altura+23);
$pdf->Cell(19,0,$ctaCorrienteVentas+$ctaCorrienteRemitos,0,0,'R');//IMPORTE

#TOTALES
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+30);
$totalCantVentas = $cantEfectivo + $cantCheque + $cantTransferencia + $cantTarjeta + $cantOsde;
$pdf->Cell(23,0,"(".$totalCantidadesCaja1 .")".' Total:',0,0,'R');//CANTIDAD
$pdf->SetXY(20 ,$altura+30);
$pdf->Line(25,$altura+26	,44,$altura+26	);
$pdf->Cell(19,0,$totalCuadro1,0,0,'R');//IMPORTE

if($_GET['tipoventa']=="VENTA"){

	//SEGUNDO CUADRADO
$pdf->SetXY(46,$altura);
$pdf->Cell(42,34,'',1,0,"C");
#TITULO
$pdf->SetFont('','U');
$pdf->SetXY(49,$altura+3);
$pdf->Write(0,'VENTAS EN INSUMOS');
#PRIMER RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(43,$altura+7);
$pdf->Cell(25,0,"(".$cantVentas.")".' Ventas:',0,0,'R');//CANTIDAD
$pdf->SetXY(65,$altura+7);
$pdf->Cell(19,0,$otros,0,0,'R');//IMPORTE
#SEGUNDA RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(43,$altura+11);
$pdf->Cell(25,0,"(".$cantCuota.")".' C. Social:',0,0,'R');//CANTIDAD
$pdf->SetXY(65,$altura+11);
$pdf->Cell(19,0,$cuotaSocial,0,0,'R');//IMPORTE
#TERCERO RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(43,$altura+15);
$pdf->Cell(25,0,"(".$cantDerecho.")".' Derecho:',0,0,'R');//CANTIDAD
$pdf->SetXY(65,$altura+15);
$pdf->Cell(19,0,$derecho,0,0,'R');//IMPORTE
#CUARTO RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(43,$altura+19);
$pdf->Cell(25,0,"(".$cantOsde.")".' Osde:',0,0,'R');//CANTIDAD
$pdf->SetXY(65,$altura+19);
$pdf->Cell(19,0,$osde,0,0,'R');//IMPORTE
#QUINTO RENGLON
// $pdf->SetFont('','B');
// $pdf->SetXY(43,$altura+23);
// $totalesCantRemitos = $cantCuotaRemitos+$cantDerechoRemitos+$cantOsdeRemitos+$cantVentasRemitos;
// $pdf->Cell(25,0,"($totalesCantRemitos)".' Remitos:',0,0,'R');//CANTIDAD
// $pdf->SetXY(65 ,$altura+23);
// $pdf->Cell(19,0,$ctaCorrienteVentas+$ctaCorrienteRemitos,0,0,'R');//IMPORTE
// $totalRemitos = $otrosRemitos+$cuotaSocialRemitos+$derechoRemitos+$osdeRemitos;
#TOTALES	
$pdf->SetFont('','B');
$pdf->SetXY(60,$altura+30);
$totales=$cantDerecho+$cantCuota+$cantVentas+$cantOsde+$totalesCantRemitos;
$pdf->Cell(8,0,"(".$totales.")".' Total:',0,0,'R');//CANTIDAD
$pdf->SetXY(65 ,$altura+30);
$pdf->Line(66,$altura+26,88,$altura+26);

$pdf->Cell(19,0,$otros+$cuotaSocial+$derecho+$osde+$totalRemitos ,0,0,'R');//IMPORTE

}



// El documento enviado al navegador
$pdf->Output();
?>
