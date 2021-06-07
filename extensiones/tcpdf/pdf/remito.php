<?php

require_once "../../../controladores/remitos.controlador.php";
require_once "../../../modelos/remitos.modelo.php";

require_once "../../../controladores/escribanos.controlador.php";
require_once "../../../modelos/escribanos.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/empresa.controlador.php";
require_once "../../../modelos/empresa.modelo.php";
class imprimirFactura{


public $id;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->id;

$respuestaVenta = ControladorRemitos::ctrMostrarRemitos($itemVenta, $valorVenta);

$fecha = explode("-", $respuestaVenta["fecha"]);
$fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
$productos = json_decode($respuestaVenta["productos"], true);
$adeuda = number_format($respuestaVenta["adeuda"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorEscribanos::ctrMostrarEscribanos($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//TRAEMOS LA INFORMACIÓN DE LA EMPRESA
$itemEmpresa = "id";

$valorEmpresa = 1;
$respuestaEmpresa = ControladorEmpresa::ctrMostrarEmpresa($itemEmpresa, $valorEmpresa);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="../../../$respuestaEmpresa[fotorecibo]"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:6px; text-align:right; line-height:15px;">
					
					<br>
					CUIT: $respuestaEmpresa[cuit]

					<br>
					Dirección: $respuestaEmpresa[direccion]

					<br>
					Teléfono: $respuestaEmpresa[telefono]

				</div>

			</td>

			

			<td style="font-size:10px;background-color:white;  text-align:right; color:red"><br><br>Remito Nro.:$respuestaVenta[codigo]</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

		

	</table>

	<table style="font-size:8px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Cliente: $respuestaVenta[nombre]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $respuestaVendedor[nombre]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:8px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:150px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:50px; text-align:center">Cant.</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Folio 1</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Folio 2</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

$valorUnitario = number_format($item["precio"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:7px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:150px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:50px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[folio1]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[folio2]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">$ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total:
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $total
			</td>

		</tr>

		
		<tr>

			<td style="width:340px; text-align:center"></td>

			<td style="width:100px; text-align:center">
				
			</td>
		
			<td style="background-color:white; width:100px; text-align:center">
				
			</td>


		</tr>
		<tr>
			

				<td style="width:540px;" ></td>
			
		</tr>
		


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');








$bloqueEspacio = <<<EOF

	<br><br><br><br><br><br><br><br>

EOF;

$pdf->writeHTML($bloqueEspacio, false, false, false, false, '');

$bloque6 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="../../../$respuestaEmpresa[fotorecibo]"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:6px; text-align:right; line-height:15px;">
					
					<br>
					CUIT: $respuestaEmpresa[cuit]

					<br>
					Dirección: $respuestaEmpresa[direccion]

					<br>
					Teléfono: $respuestaEmpresa[telefono]

				</div>


			</td>

			

			<td style="font-size:8px;background-color:white;  text-align:rigth; color:red"><br><br>Remito Nro.:$respuestaVenta[codigo]</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

// ---------------------------------------------------------

$bloque7 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

		

	</table>

	<table style="font-size:8px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Cliente: $respuestaVenta[nombre]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $respuestaVendedor[nombre]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

// ---------------------------------------------------------

$bloque8 = <<<EOF

	<table style="font-size:7px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:150px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:50px; text-align:center">Cant.</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Folio 1</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Folio 2</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

$valorUnitario = number_format($item["precio"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque9 = <<<EOF

	<table style="font-size:7px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:150px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:50px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[folio1]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[folio2]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">$ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque10 = <<<EOF

	<table style="font-size:8px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total:
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $total
			</td>

		</tr>

		
		<tr>

			<td style="width:340px; text-align:center"></td>

			<td style="width:100px; text-align:center">
				
			</td>
		
			<td style="background-color:white; width:100px; text-align:center">
				
			</td>


		</tr>
		<tr>
			

				<td style="width:540px;" ></td>
			
		</tr>
		


	</table>

EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output('factura.pdf');

}

}

$factura = new imprimirFactura();
$factura -> id = $_GET["id"];
$factura -> traerImpresionFactura();

?>