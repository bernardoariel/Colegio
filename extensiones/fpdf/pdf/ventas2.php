<?php


require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/caja.controlador.php";
require_once "../../../modelos/caja.modelo.php";

require_once "../../../controladores/escribanos.controlador.php";
require_once "../../../modelos/escribanos.modelo.php";

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

// VENTA
$item= "fecha";
$valor = $fecha1;

$ventasPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);

#DATOS DE LA EMPRESA
$item = "id";
$valor = 1;

$empresa = ControladorEmpresa::ctrMostrarEmpresa($item, $valor);

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
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(20,10,"Fecha",1,0,"C",true);
$pdf->Cell(9,10,"Tipo",1,0,"C",true);
$pdf->Cell(31,10,"Pago",1,0,"C",true);
$pdf->Cell(30,10,"Nro. Factura",1,0,"C",true);
$pdf->Cell(95,10,"Nombre",1,0,"C",true);
$pdf->Cell(20,10,"Entrada",1,0,"C",true);

$total=0;

// Los datos (en negro)
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$altura=$altura+11;

$efectivo=0;
$cantEfectivo=0;
$cheque=0;
$cantCheque=0;
$tarjeta=0;
$cantTarjeta=0;
$transferencia=0;
$cantTransferencia=0;
$cantCtaCorriente=0;
$ctaCorriente=0;

$otros=0;
$cantVentas=0;

$cuotaSocial=0;
$cantCuota=0;
$derecho=0;
$cantDerecho=0;

$cantOsde=0;
$osde=0;

$ventasTotal=0;

$contador=0;



foreach($ventasPorFecha as $key=>$rsVentas){

	if($contador<=33){

		$pdf->SetXY(3,$altura);
		$pdf->Cell(20,5,$rsVentas['fechapago'],1,0,"C");
		$pdf->Cell(9,5,$rsVentas['tipo'],1,0,"C");
		$pdf->Cell(31,5,$rsVentas['metodo_pago'],1,0,"C");
		$pdf->Cell(30,5,$rsVentas['codigo'],1,0,"C");
		
		// ESCRIBANO
		$item= "id";
		$valor = $rsVentas['id_cliente'];

		$escribanos = ControladorEscribanos::ctrMostrarEscribanos($item,$valor);
		$pdf->Cell(95,5,convertirLetras($escribanos['nombre']),1,0,"L");
		
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

		$pdf->Cell(20,5,$rsVentas['total'],1,0,"C");
		
		if (substr($rsVentas['metodo_pago'],0,2)=='EF'){
			$efectivo=$efectivo+$rsVentas['total'];
			$cantEfectivo++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='TA'){
			$tarjeta=$tarjeta+$rsVentas['total'];
			$cantTarjeta++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='CH'){
			$cheque=$cheque+$rsVentas['total'];
			$cantCheque++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='TR'){
			$transferencia=$transferencia+$rsVentas['total'];
			$cantTransferencia++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='CT'){
			$ctaCorriente=$ctaCorriente+$rsVentas['total'];
			$cantCtaCorriente++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
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
		$pdf->Cell(10,10,"Tipo",1,0,"C",true);
		$pdf->Cell(10,10,"Pago",1,0,"C",true);
		$pdf->Cell(30,10,"Nro. Factura",1,0,"C",true);
		$pdf->Cell(95,10,"Nombre",1,0,"C",true);
		$pdf->Cell(20,10,"Entrada",1,0,"C",true);
		$pdf->Cell(20,10,"Salida",1,0,"C",true);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(5,$altura);
 		$altura=$altura+11;
 		$pdf->SetTextColor(0,0,0);
 		//$cantEfectivo++;

 		$pdf->SetXY(3,$altura);
		$pdf->Cell(20,5,$rsVentas['fechapago'],1,0,"C");
		$pdf->Cell(10,5,$rsVentas['tipo'],1,0,"C");
		$pdf->Cell(10,5,$rsVentas['metodo_pago'],1,0,"C");
		$pdf->Cell(30,5,$rsVentas['codigo'],1,0,"C");
		$pdf->Cell(95,5,convertirLetras('ARIEL BERNARDO'),1,0,"L");
		if ($rsVentas['tipo']=='FC'){
			$pdf->Cell(20,5,$rsVentas['total'],1,0,"C");
			$pdf->Cell(20,5,'0',1,0,"C");
			if (substr($rsVentas['metodo_pago'],0,2)=='EF'){
			$efectivo=$efectivo+$rsVentas['total'];
			$cantEfectivo++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='TA'){
			$tarjeta=$tarjeta+$rsVentas['total'];
			$cantTarjeta++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='CH'){
			$cheque=$cheque+$rsVentas['total'];
			$cantCheque++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='TR'){
			$transferencia=$transferencia+$rsVentas['total'];
			$cantTransferencia++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
		if (substr($rsVentas['metodo_pago'],0,2)=='CT'){
			$ctaCorriente=$ctaCorriente+$rsVentas['total'];
			$cantCtaCorriente++;
			$ventasTotal+=$rsVentas['total'];
			$cantVentasTotal++;
		}
			
		}
		
		$altura+=6;
		$contador++;
		
	}
}



$altura+=2;


$pdf->SetFont('Arial','',9);

//PRIMER CUADRADO
$pdf->SetXY(39,$altura);
$pdf->Cell(42,35,'',1,0,"C");

$pdf->SetFont('','U');
$pdf->SetXY(48,$altura+3);
$pdf->Write(0,'RECAUDACION');

$pdf->SetFont('','B');
$pdf->SetXY(38,$altura+7);
$pdf->Cell(23,0,"($cantEfectivo)".' Efectivo:',0,0,'R');//CANTIDAD
$pdf->SetXY(60 ,$altura+7);
$pdf->Cell(19,0,$efectivo,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(38,$altura+11);
$pdf->Cell(23,0,"($cantCheque)".' Cheque:',0,0,'R');//CANTIDAD
$pdf->SetXY(60 ,$altura+11);
$pdf->Cell(19,0,$cheque,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(38,$altura+15);
$pdf->Cell(23,0,"($cantTarjeta)".' Tarjeta:',0,0,'R');//CANTIDAD
$pdf->SetXY(60 ,$altura+15);
$pdf->Cell(19,0,$tarjeta,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(38,$altura+19);
$pdf->Cell(23,0,"($cantTransferencia)".' Transf.:',0,0,'R');//CANTIDAD
$pdf->SetXY(60 ,$altura+19);
$pdf->Cell(19,0,$tarjeta,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(38,$altura+23);
$pdf->Cell(23,0,"($cantCtaCorriente)".' Cta/Corr.:',0,0,'R');//CANTIDAD
$pdf->SetXY(60 ,$altura+23);
$pdf->Cell(19,0,$ctaCorriente,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(38,$altura+28);
$totalCantVentas = $cantEfectivo + $cantCheque + $cantTransferencia + $cantTarjeta + $cantOsde;
$pdf->Cell(23,0,"(".$totalCantVentas.")".' Total:',0,0,'R');//CANTIDAD
$pdf->SetXY(60 ,$altura+28);
$pdf->Line(45,$altura+26,79,$altura+26);
$pdf->Cell(19,0,$ventasTotal,0,0,'R');//IMPORTE

//SEGUNDO CUADRADO
$pdf->SetXY(85,$altura);
$pdf->Cell(42,28,'',1,0,"C");

$pdf->SetFont('','U');
$pdf->SetXY(97,$altura+3);
$pdf->Write(0,'VENTAS');

$pdf->SetFont('','B');
$pdf->SetXY(83,$altura+7);
$pdf->Cell(25,0,"(".$cantVentas.")".' Ventas:',0,0,'R');//CANTIDAD
$pdf->SetXY(103,$altura+7);
$pdf->Cell(19,0,$otros,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(83,$altura+11);
$pdf->Cell(25,0,"(".$cantCuota.")".' C. Social:',0,0,'R');//CANTIDAD
$pdf->SetXY(103,$altura+11);
$pdf->Cell(19,0,$cuotaSocial,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(83,$altura+15);
$pdf->Cell(25,0,"(".$cantDerecho.")".' Derecho:',0,0,'R');//CANTIDAD
$pdf->SetXY(103,$altura+15);
$pdf->Cell(19,0,$derecho,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(83,$altura+19);
$pdf->Cell(25,0,"(".$cantOsde.")".' Osde:',0,0,'R');//CANTIDAD
$pdf->SetXY(103,$altura+19);
$pdf->Cell(19,0,$osde,0,0,'R');//IMPORTE

$pdf->SetFont('','B');
$pdf->SetXY(100,$altura+25);
$totales=$cantDerecho+$cantCuota+$cantVentas+$cantOsde;
$pdf->Cell(8,0,"(".$totales.")".' Total:',0,0,'R');//CANTIDAD
$pdf->SetXY(103 ,$altura+20);
$pdf->Line(90,$altura+22,122,$altura+22);
$pdf->Cell(19,10,$otros+$cuotaSocial+$derecho+$osde,0,0,'R');//IMPORTE




// El documento enviado al navegador
$pdf->Output();
?>
