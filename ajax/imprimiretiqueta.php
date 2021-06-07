<?php
#FUNCION PARA ÑS Y ACENTOS
function convertirLetras($texto){
$texto = iconv('UTF-8', 'windows-1252', $texto);
return	 $texto;
}
#LLAMO A LAS LIBRERIAS
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../controladores/empresa.controlador.php";
require_once "../modelos/empresa.modelo.php";
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

#ITEMS SELECCIONADOS
$item = "seleccionado";
$valor = 1;
$respuesta = ControladorVentas::ctrMostrarFacturasSeleccionadas($item, $valor);

#DATOS DE LA EMPRESA
$item = "id";
$valor = 1;
$empresa = ControladorEmpresa::ctrMostrarEmpresa($item, $valor);	

#PPREPARO EL PDF
require('../extensiones/fpdf/fpdf.php');
#INICIO EL PDF
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetAutoPageBreak(true, 20);


#INICIO LAS VARIABLES PARA EMPEZAR A CONTAR
$altura=0;
$contador=1;
// Carga de datos
foreach ($respuesta  as $row => $item) {

	#	TOMAR LOS DATOS DEL CLIENTE
	$itemCliente = "id";
	$valorCliente = $item["id_cliente"];
	$cliente = ControladorClientes::ctrMostrarClientes($itemCliente,$valorCliente);

	#	VER TIPO DE CLIENTE
	$itemTipoCliente = "id";
	$valorTipoCliente = $item["id_cliente"];
	$tipoCliente = ControladorClientes::ctrMostrarTipoClientes($itemTipoCliente,$valorTipoCliente);

	if($contador==2){$altura=27;}

	if($contador==3){$altura=27*2;}

	if($contador==4){$altura=27*3;}

	if($contador==5){$altura=27*4;}

	if($contador==6){$altura=27*5;}

	if($contador==7){$altura=27*6;}

	// NOMBRE CLIENTE
	$pdf->SetFont('Arial','B',7);
	// $alturaNombre=$altura+10;
	$altura=$altura+10;
	$pdf->SetXY(60,$altura+10);
	$pdf->Write(0,$item['nombre']);
	//FECHA
	$pdf->SetX(95);
	$pdf->Write(0,$item['fecha']);
	//OBSERVACIONES
	$pdf->SetXY(60,$altura+15);
	$pdf->SetFont('Arial','',7);
	$pdf->Write(0,$item['detalle'].'-'.$item['obs'].' - '.$item['nrofc']);

	//LADO DERECHO CODIGO

	$pdf->SetXY(111.2,$altura+13.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(0,$item['nrofc']);
	$pdf->SetXY(110,$altura+11);
	
	$pdf->Cell(20,16,'',1,1,'C');
	//IMAGEN CODIGO DE BARRAS
	$pdf->Image('codigos/codigodebarras.jpg',113,$altura+15,-900);

	//NOMBRE 
	if($tipoCliente["nombre"] == 'REVENDEDOR'){

		$nombreCliente = $cliente['nombre'];

	}else{

		$nombreCliente = $empresa['empresa'];
	}

	$pdf->SetFont('Arial','B',6);
	if (strlen($nombreCliente)>9){

		$pdf->SetXY(109.5,$altura+26);
	}else{

		$pdf->SetXY(113.5,$altura+26);
		
	}

	$pdf->Write(0,$nombreCliente);
	
	//SERVICIOS
	$matrizServicios=json_decode($item['productos'], true);

	$alturaPromedio =30;
	$pdf->SetFont('Arial','B',5);
	
	// foreach ($matrizServicios  as $row => $value) {
		
	// 	switch ($contador) {
	// 		case '1':
	// 			# code...
	// 			$pdf->SetXY(62,$altura+18+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 		case '2':
	// 			# code...
	// 			$pdf->SetXY(62,$altura+14+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 		case '3':
	// 			# code...
	// 			$pdf->SetXY(62,$altura+10+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 		case '4':
	// 			# code...
	// 			$pdf->SetXY(62,$altura+4+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 		case '5':
	// 			# code...
	// 			$pdf->SetXY(62,$altura+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 		case '6':
	// 			# code...
	// 			$pdf->SetXY(62,$altura-5+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 		case '7':
	// 			# code...
	// 			$pdf->SetXY(62,$altura-8+$p);
	// 			$pdf->Write(0,$value['descripcion']);
	// 			$p=$p+2;
	// 			break;
	// 	}

		

		
		
	// }

	if ($cliente['idtipocliente']==1){

		$pdf->SetXY(60,$altura+29);
		$pdf->Write(0,$empresa['web'].' - '.$empresa['telefono']);
	}

	$pdf->Line(60,  $altura+30,  140, $altura+30);




$contador++;
}

// El documento enviado al navegador
$pdf->Output();
?>
