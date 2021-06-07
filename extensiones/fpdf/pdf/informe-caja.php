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
$nombreDePdf="COBRANZAS ". $_GET["tipopago"];

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



// PAGOS 
if($_GET["tipopago"]=="CTA.CORRIENTE"){

	$item= "fecha";
	$valor = $fecha1;

}else{

	$item= "fechapago";
	$valor = $fecha1;
}

//VENTAS
$ventasPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);

// REMITOS
$remitos = ControladorRemitos::ctrMostrarRemitosFecha($item,$valor);

switch ($_GET["tipopago"]) {

	case 'EFECTIVO':
		# code...
	    $centrarTipoPago = 30;
	    $color1 = 2;
	    $color2 = 117;
	    $color3 = 216;
		break;

	case 'TARJETA':
		# code...
	    $centrarTipoPago = 30;
	    $color1 = 92;
	    $color2 = 184;
	    $color3 = 92;
		break;

	case 'CHEQUE':
		# code...
	    $centrarTipoPago = 29;
	    $color1 = 240;
	    $color2 = 173;
	    $color3 = 78;
		break;
	case 'TRANSFERENCIA':
		# code...
	    $centrarTipoPago = 35;
	    $color1 = 103;
	    $color2 = 58;
	    $color3 = 183;
		break;
	case 'CTA.CORRIENTE':
		# code...
	    $centrarTipoPago = 35;
	    $color1 = 255;
	    $color2 = 163;
	    $color3 = 1;
		break;
	
	default:
		$centrarTipoPago = 50;
	    $color1 = 240;
	    $color2 = 73;
	    $color3 = 94;
		break;
}


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

$pagosRemitos = 0;
$cantPagosRemitos = 0;
$pagosVentas = 0;
$cantPagosVentas = 0;
$contador = 0;


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
$pdf->SetFillColor($color1,$color2,$color3);
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



foreach($ventasPorFecha as $key=>$rsVentas){

	if($rsVentas['metodo_pago']==$_GET["tipopago"]){

		if($contador<=33){

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
			
			$pagosVentas=$pagosVentas+$importe;
			$cantPagosVentas++;

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
			
			if($rsVentas['tipo']=='NC'){

				$importe=$rsVentas['total']*(-1);
				$pdf->Cell(20,5,$importe,1,0,"C");

			}else{

				$importe=$rsVentas['total'];
				$pdf->Cell(20,5,$importe,1,0,"C");

			}

			$pagosVentas=$pagosVentas+$importe;
			$cantPagosVentas++;
		
		$altura+=6;
		$contador++;
		
		}

	}
}

// $totalRemitos = 0;
foreach ($remitos as $key => $valueRemitos) {
	# code...
	// $totalRemitos = $totalRemitos + $value['total'];
	if($valueRemitos['metodo_pago']==$_GET["tipopago"]){

	if($contador<=33){

		$pdf->SetXY(3,$altura);
		$pdf->Cell(20,5,$valueRemitos['fecha'],1,0,"C");
		$pdf->Cell(9,5,$valueRemitos['tipo'],1,0,"C");
		$pdf->Cell(31,5,$valueRemitos['metodo_pago'],1,0,"C");
		$pdf->Cell(30,5,$valueRemitos['codigo'],1,0,"C");
		
		
		$pdf->Cell(95,5,convertirLetras($valueRemitos['nombre']),1,0,"L");

		if($valueRemitos['tipo']=='NC'){

			$importe=$valueRemitos['total']*(-1);
			$pdf->Cell(20,5,$importe,1,0,"C");

		}else{

			$importe=$valueRemitos['total'];
			$pdf->Cell(20,5,$importe,1,0,"C");

		}
		

		$pagosRemitos=$pagosRemitos+$importe;
		$cantPagosRemitos++;

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
		
		if($valueRemitos['tipo']=='NC'){

			$importe=$valueRemitos['total']*(-1);
			$pdf->Cell(20,5,$importe,1,0,"C");

		}else{

			$importe=$valueRemitos['total'];
			$pdf->Cell(20,5,$importe,1,0,"C");

		}

		$pagosRemitos=$pagosRemitos+$importe;
		$cantPagosRemitos++;
		
		$altura+=6;
		$contador++;
		
	}
}

}	
$altura+=2;

$cantTotalPagos = $cantPagosRemitos + $cantPagosVentas;

if ($_GET['tipopago']!="CTA.CORRIENTE"){

	$pdf->SetFont('Arial','',9);

	//PRIMER CUADRADO
	$pdf->SetXY(2,$altura);
	$pdf->Cell(42,28,'',1,0,"C");
	#TITULO
	$pdf->SetFont('','U');
	$pdf->SetXY(15,$altura+3);
	$pdf->Write(0,'IMPORTE');
	#PRIMER RENGLON		
	$pdf->SetFont('','B');
	$pdf->SetXY(4,$altura+12);

	$pdf->Cell($centrarTipoPago,0,"($cantTotalPagos) ".$_GET['tipopago'],0,0,'R');//CANTIDAD

	
	
	$pdf->SetXY(18 ,$altura+25);
	$pdf->Line(25,$altura+21,44,$altura+21);
	$pdf->Cell(23,0,$pagosRemitos+$pagosVentas,0,0,'R');//IMPORTE


	
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
	$pdf->Cell(25,0,"(".$cantPagosVentas.")".' Facturas:',0,0,'R');//CANTIDAD
	$pdf->SetXY(65,$altura+11);
	$pdf->Cell(19,0,$pagosVentas,0,0,'R');//IMPORTE
	#TERCERO RENGLON		
	$pdf->SetFont('','B');
	$pdf->SetXY(43,$altura+15);
	$pdf->Cell(25,0,"(".$cantPagosRemitos.")".' Remitos:',0,0,'R');//CANTIDAD
	$pdf->SetXY(65,$altura+15);
	$pdf->Cell(19,0,$pagosRemitos,0,0,'R');//IMPORTE

	#TOTALES	
	$pdf->SetFont('','B');
	$pdf->SetXY(60,$altura+21);
	// $totales=$cantidadFacturas+$cantidadRemitos;
	$pdf->Cell(8,0,"(".$cantTotalPagos.")".' Total:',0,0,'R');//CANTIDAD
	$pdf->SetXY(65 ,$altura+21);
	$pdf->Line(66,$altura+18,88,$altura+18);
	$pdf->Cell(19,0,$pagosRemitos+$pagosVentas ,0,0,'R');//IMPORTE

}else{



		$pdf->SetFont('Arial','',9);

	//PRIMER CUADRADO
	$pdf->SetXY(2,$altura);
	$pdf->Cell(42,28,'',1,0,"C");
	#TITULO
	$pdf->SetFont('','U');
	$pdf->SetXY(15,$altura+3);
	$pdf->Write(0,'IMPORTE');
	#PRIMER RENGLON		
	$pdf->SetFont('','B');
	$pdf->SetXY(4,$altura+12);

	$pdf->Cell($centrarTipoPago,0,"($cantTotalPagos) ".$_GET['tipopago'],0,0,'R');//CANTIDAD

	
	
	$pdf->SetXY(18 ,$altura+25);
	$pdf->Line(25,$altura+21,44,$altura+21);
	$pdf->Cell(23,0,$pagosRemitos+$pagosVentas,0,0,'R');//IMPORTE


	
	//SEGUNDO CUADRADO
	$pdf->SetXY(46,$altura);
	$pdf->Cell(42,28,'',1,0,"C");
	#TITULO
	$pdf->SetFont('','U');
	$pdf->SetXY(59,$altura+5);
	$pdf->Write(0,'VENTAS');
		

	#SEGUNDA RENGLON		
	$pdf->SetFont('','B');
	$pdf->SetXY(43,$altura+11);
	$pdf->Cell(25,0,"(".$cantPagosVentas.")".' Facturas:',0,0,'R');//CANTIDAD
	$pdf->SetXY(65,$altura+11);
	$pdf->Cell(19,0,$pagosVentas,0,0,'R');//IMPORTE
	#TERCERO RENGLON		
	$pdf->SetFont('','B');
	$pdf->SetXY(43,$altura+15);
	$pdf->Cell(25,0,"(".$cantPagosRemitos.")".' Remitos:',0,0,'R');//CANTIDAD
	$pdf->SetXY(65,$altura+15);
	$pdf->Cell(19,0,$pagosRemitos,0,0,'R');//IMPORTE

	#TOTALES	
	$pdf->SetFont('','B');
	$pdf->SetXY(60,$altura+21);
	// $totales=$cantidadFacturas+$cantidadRemitos;
	$pdf->Cell(8,0,"(".$cantTotalPagos.")".' Total:',0,0,'R');//CANTIDAD
	$pdf->SetXY(65 ,$altura+21);
	$pdf->Line(66,$altura+18,88,$altura+18);
	$pdf->Cell(19,0,$pagosRemitos+$pagosVentas ,0,0,'R');//IMPORTE


}








// El documento enviado al navegador
$pdf->Output();
?>
