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
$nombreDePdf="PAGOS DE CUENTA CORRIENTE";

#BUSCO LA FECHA
$fecha1=$_GET['fecha1'];
if(!isset($_GET['fecha2'])){

	$fecha2=$_GET['fecha1'];

}else{

	$fecha2=$_GET['fecha2'];

}
#DATOS DE LA EMPRESA
$item = "id";
$valor = 1;

$empresa = ControladorEmpresa::ctrMostrarEmpresa($item, $valor);


// VENTAS
// $item= "fecha";
// $valor = $fecha1;

// $ventasPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);

// PAGOS 
$item= "fechapago";
$valor = $fecha1;

$ventasPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);

// REMITOS
$item= "fechapago";
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
$pdf->SetFillColor(52,73,94);
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



foreach($ventasPorFecha as $key=>$rsVentas){

	if($rsVentas['fecha']!=$fecha1){

		if($contador<=33){

			$pdf->SetXY(3,$altura);
			$pdf->Cell(20,5,$rsVentas['fecha'],1,0,"C");
			$pdf->Cell(9,5,$rsVentas['tipo'],1,0,"C");
			$pdf->Cell(31,5,$rsVentas['metodo_pago'],1,0,"C");
			$pdf->Cell(30,5,$rsVentas['codigo'],1,0,"C");
			
			
			$pdf->Cell(95,5,convertirLetras($rsVentas['nombre']),1,0,"L");
			

			// $listaProductos = json_decode($rsVentas["productos"], true);

			// foreach ($listaProductos as $key => $value) {

			//    switch ($value['id']) {

			//    	case '20':
			//    		# cuota...
			//    		$cantCuota++;
			//    		$cuotaSocial=$value['total']+$cuotaSocial;
			//    		break;

			//    	case '19':
			//    		# derech...
			//    		$cantDerecho++;
			//    		$derecho=$value['total']+$derecho;
			//    		break;

			//    	case '22':
			//    		# derech...
			//    		$cantOsde++;
			//    		$osde=$value['total']+$osde;
			//    		break;
			   	
			//    	default:
			//    		# venta...
			//    		$cantVentas++;
			//    		$otros=$value['total']+$otros;
			//    		break;
			//    }

			    
			// }

			if($rsVentas['tipo']=='NC'){

				$importe=$rsVentas['total']*(-1);
				$pdf->Cell(20,5,$importe,1,0,"C");

			}else{

				$importe=$rsVentas['total'];
				$pdf->Cell(20,5,$importe,1,0,"C");

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
			$pdf->SetFillColor(255,0,0);
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


	 

	 		$pdf->SetXY(3,$altura);
			$pdf->Cell(20,5,$rsVentas['fecha'],1,0,"C");
			$pdf->Cell(9,5,$rsVentas['tipo'],1,0,"C");
			$pdf->Cell(31,5,$rsVentas['metodo_pago'],1,0,"C");
			$pdf->Cell(30,5,$rsVentas['codigo'],1,0,"C");
			$pdf->Cell(95,5,convertirLetras($rsVentas['nombre']),1,0,"L");
			
			if ($rsVentas['tipo']=='FC'){
				$pdf->Cell(20,5,$importe,1,0,"C");
				$pdf->Cell(20,5,'0',1,0,"C");
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

// $totalRemitos = 0;
foreach ($remitos as $key => $valueRemitos) {
	# code...
	// $totalRemitos = $totalRemitos + $value['total'];
	if($valueRemitos['fecha']!=$fecha1){
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
$cantEfectivoPagos = 0;
$cantChequePagos =0;
$cantTarjetaPagos =0;
$cantTransferenciaPagos =0;
$efectivoPagos = 0; 
$chequePagos = 0; 
$tarjetaPagos =0; 
$transferenciaPagos=0;

foreach ($pagosPorFecha as $key => $valuePagos) {
	# code...
	if($valuePagos['tipo']=='NC'){

			$importe=$valuePagos['total']*(-1);
			// $pdf->Cell(20,5,$importe,1,0,"C");

		}else{

			$importe=$valuePagos['total'];
			// $pdf->Cell(20,5,$importe,1,0,"C");

		}
		
		if (substr($valuePagos['metodo_pago'],0,2)=='EF'){

			$efectivoPagos=$efectivoPagos+$importe;
			$cantEfectivoPagos++;

		}

		if (substr($valuePagos['metodo_pago'],0,2)=='TA'){
			
			$tarjetaPagos=$tarjetaPagos+$importe;
			$cantTarjetaPagos++;

		}

		if (substr($valuePagos['metodo_pago'],0,2)=='CH'){
			
			$chequePagos=$chequePagos+$importe;
			$cantChequePagos++;
		}

		if (substr($valuePagos['metodo_pago'],0,2)=='TR'){
			
			$transferenciaPagos=$transferenciaPagos+$importe;
			$cantTransferenciaPagos++;
		}
		if (substr($valuePagos['metodo_pago'],0,2)=='CT'){
			
			$ctaCorrientePagos=$ctaCorrientePagos+$importe;
			$cantCtaPagos++;
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
$pdf->Cell(42,28,'',1,0,"C");
#TITULO
$pdf->SetFont('','U');
$pdf->SetXY(3,$altura+3);
$pdf->Write(0,'PAGOS Cta.C Y REMITOS');
#PRIMER RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+7);
$pdf->Cell(23,0,"($cantidadEfectivoVentas)".' Efectivo:',0,0,'R');//CANTIDAD
$pdf->SetXY(18 ,$altura+7);
$pdf->Cell(22,0,$efectivoVentas+$efectivoRemitos,0,0,'R');//IMPORTE
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

#TOTALES
$pdf->SetFont('','B');
$pdf->SetXY(4,$altura+24);
$totalCantVentas = $cantEfectivo + $cantCheque + $cantTransferencia + $cantTarjeta + $cantOsde;
$pdf->Cell(23,0,"(".$totalCantidadesCaja1 .")".' Total:',0,0,'R');//CANTIDAD
$pdf->SetXY(20 ,$altura+24);
$pdf->Line(25,$altura+21	,44,$altura+21	);
$pdf->Cell(19,0,$totalCuadro1,0,0,'R');//IMPORTE

#TOTALES DE LAS CANTIDADES DEL PRIMER RECUADRO
$cantidadFacturas = $cantEfectivoVentas + $cantChequeVentas + $cantTarjetaVentas + $cantTransferenciaVentas;
$cantidadRemitos = $cantEfectivoRemitos + $cantChequeRemitos + $cantTarjetaRemitos + $cantTransferenciaRemitos;
// $cantidadCtaCorriente = $cantCtaVentas+$cantCtaRemitos;
$importeFacturas = $efectivoVentas + $transferenciaVentas + $tarjetaVentas + $chequeVentas;
$importeRemitos = $efectivoRemitos + $transferenciaRemitos + $tarjetaRemitos + $chequeRemitos;
// $importeCta = $ctaCorrienteVentas+$ctaCorrienteRemitos;

$totalCuadro4 = $importeFacturas + $importeRemitos;//+ $importeCta;
$totalCantPagos = $cantEfectivoPagos + $cantChequePagos + $cantTarjetaPagos + $cantTransferenciaPagos;
$totalPagos = $efectivoPagos + $chequePagos + $tarjetaPagos + $transferenciaPagos;
//SEGUNDO CUADRADO
$pdf->SetXY(46,$altura);
$pdf->Cell(42,28,'',1,0,"C");
#TITULO
$pdf->SetFont('','U');
$pdf->SetXY(59,$altura+5);
$pdf->Write(0,'PAGOS');
	

#SEGUNDA RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(43,$altura+11);
$pdf->Cell(25,0,"(".$cantidadFacturas.")".' Facturas:',0,0,'R');//CANTIDAD
$pdf->SetXY(65,$altura+11);
$pdf->Cell(19,0,$importeFacturas,0,0,'R');//IMPORTE
#TERCERO RENGLON		
$pdf->SetFont('','B');
$pdf->SetXY(43,$altura+15);
$pdf->Cell(25,0,"(".$cantidadRemitos.")".' Remitos:',0,0,'R');//CANTIDAD
$pdf->SetXY(65,$altura+15);
$pdf->Cell(19,0,$importeRemitos,0,0,'R');//IMPORTE

#TOTALES	
$pdf->SetFont('','B');
$pdf->SetXY(60,$altura+21);
$totales=$cantidadFacturas+$cantidadRemitos;
$pdf->Cell(8,0,"(".$totales.")".' Total:',0,0,'R');//CANTIDAD
$pdf->SetXY(65 ,$altura+21);
$pdf->Line(66,$altura+18,88,$altura+18);
$pdf->Cell(19,0,$importeFacturas+$importeRemitos ,0,0,'R');//IMPORTE










// El documento enviado al navegador
$pdf->Output();
?>
