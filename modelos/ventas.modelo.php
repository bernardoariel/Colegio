<?php 

require_once "conexion.php";

class ModeloVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY codigo DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY codigo DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt -> close();

		$stmt = null;

	}

	

	/*=============================================
	MOSTRAR VENTAS porFECHA
	=============================================*/

	static public function mdlMostrarVentasFecha($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = '".$valor."' ORDER BY codigo ASC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarVentasClientes($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY codigo ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarVentasEscribanos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and tabla='escribanos' ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tabla='escribanos' ORDER BY codigo ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt -> close();

		$stmt = null;

	}

	

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha,tipo,codigo, id_cliente,nombre,documento,tabla, id_vendedor, productos, impuesto, neto, total,adeuda,observaciones,metodo_pago,referenciapago,fechapago,cae,fecha_cae,qr) VALUES (:fecha,:tipo,:codigo, :id_cliente,:nombre,:documento,:tabla, :id_vendedor, :productos, :impuesto, :neto, :total,:adeuda,:obs, :metodo_pago,:referenciapago,:fechapago,:cae,:fecha_cae,:qr)");

		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":tabla", $datos["tabla"], PDO::PARAM_STR);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":adeuda", $datos["adeuda"], PDO::PARAM_STR);
		$stmt->bindParam(":obs",$datos["obs"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":referenciapago", $datos["referenciapago"], PDO::PARAM_STR);
		$stmt->bindParam(":fechapago", $datos["fechapago"], PDO::PARAM_STR);
		$stmt->bindParam(":cae", $datos["cae"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_cae", $datos["fecha_cae"], PDO::PARAM_STR);
		$stmt->bindParam(":qr", $datos["qr"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return $stmt->errorInfo();
		
		}

		$stmt->close();
		$stmt = null;

	}

	

	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function mdlEditarVenta($tabla, $datos){
		$mifecha ='0000-00-00';
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  fecha = :fecha, codigo = :codigo,id_cliente = :id_cliente,nombre=:nombre,documento=:documento,
			id_vendedor = :id_vendedor,productos = :productos, impuesto = :impuesto, neto = :neto, total= :total,adeuda =:adeuda, metodo_pago = :metodo_pago,fechapago = :fechapago,referenciapago =:referenciapago, cae =:cae, fecha_cae =:fecha_cae WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":cae", $datos["cae"], PDO::PARAM_STR);
		$stmt->bindParam(":fechapago", $datos["fechapago"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_cae", $datos["fecha_cae"], PDO::PARAM_STR);
		$stmt->bindParam(":adeuda", $datos["adeuda"], PDO::PARAM_STR);
		
		if($datos["metodo_pago"]=="CTA.CORRIENTE"){

			$stmt->bindParam(":fechapago", $mifecha , PDO::PARAM_STR);

		}else{

			$stmt->bindParam(":fechapago", $datos["fechapago"], PDO::PARAM_STR);

		}
		
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":referenciapago", $datos["referenciapago"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			
		    echo "\nPDO::errorInfo():\n";
		    print_r($stmt->errorInfo());

		
		}

		$stmt->close();
		$stmt = null;

	}
	

	/*=============================================
	SELECCIONAR VENTA
	=============================================*/

	static public function mdlSeleccionarVenta($tabla,$item, $datos){

		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  seleccionado = 1 WHERE id =:id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlAgregarNroNotadeCredito($tabla, $datos){

		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  observaciones = :obs WHERE id =:id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":obs", $datos["obs"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	HOMOLOGAR  VENTA
	=============================================*/

	static public function mdlHomologacionVenta($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  fecha = :fecha,codigo = :codigo,cae =:cae,fecha_cae=:fecha_cae,nombre=:nombre,documento=:documento,qr=:qr WHERE id =:id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":cae", $datos["cae"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_cae", $datos["fecha_cae"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":qr", $datos["qr"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarFacturasSeleccionadas($tabla, $item, $valor){

		

		$stmt = Conexion::conectar()->prepare("SELECT ventas.id as id,ventas.nrofc as nrofc,ventas.detalle as detalle,ventas.observaciones as obs,ventas.productos as productos,ventas.fecha as fecha,clientes.nombre as nombre,clientes.id as id_cliente FROM ventas,clientes WHERE seleccionado = 1 and clientes.id = ventas.id_cliente ORDER BY ventas.id ASC");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlBorrarFacturasSeleccionadas($tabla, $item, $valor){

		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET seleccionado = 0 ");

		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;


	}

	
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){

		

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY codigo asc limit 60");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY codigo DESC ");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal2' ORDER BY codigo asc");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}
	static public function mdlRangoFechasVentas2($tabla, $fechaInicial, $fechaFinal){

		

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo<> '1' ORDER BY fecha desc,codigo DESC,tipo asc limit 150");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' and codigo<> '1' ORDER BY fecha desc,codigo DESC,tipo asc");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal2' and codigo<> '1' ORDER BY codigo desc");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	static public function mdlRangoFechasCtaCorriente($tabla, $fechaInicial, $fechaFinal){
		
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE adeuda >0 and codigo <> '1' ORDER BY id desc limit 150");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' and adeuda >0 and codigo <> '1' ORDER BY id DESC ");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal2' and adeuda >0 and codigo <> '1' ORDER BY id desc");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}
	static public function mdlRangoFechasaFacturar($tabla, $fechaInicial, $fechaFinal){
		
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  ORDER BY id desc limit 150");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY id DESC ");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal2'ORDER BY id desc");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}
	static public function mdlRangoFechasVentasCobrados($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY codigo asc limit 60");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechapago like '%$fechaFinal%' ORDER BY codigo asc limit 60");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechapago BETWEEN '$fechaInicial' AND '$fechaFinal2' ORDER BY codigo asc");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVentasNroFc($tabla, $fechaInicial, $fechaFinal, $nrofc){
		

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where nrofc='".$nrofc."' ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' and $nrofc ='".$nrofc."' ORDER BY id DESC");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal2' and $nrofc ='".$nrofc."' ORDER BY id DESC");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	RANGO FECHAS clientes que deben
	=============================================*/	

	static public function RangoFechasVentasCtaCorriente($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where adeuda > 0 and codigo = 1 ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE adeuda > 0 and fecha like '%$fechaFinal%' and codigo = 1 ORDER BY id DESC");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE adeuda > 0 AND fecha BETWEEN '$fechaInicial' AND '$fechaFinal2' ORDER BY id DESC ");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVentasMetodoPago($tabla, $fechaInicial, $fechaFinal,$metodoPago){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM ventas WHERE metodo_pago ='".$metodoPago."' and fechapago like '%".date('Y-m-d')."%' ORDER BY id DESC limit 60");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM ventas WHERE metodo_pago ='".$metodoPago."' and fechapago like '%$fechaFinal%' ORDER BY id DESC limit 60");

			$stmt -> bindParam(":fechapago", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaFinal = new DateTime();
			$fechaFinal->add(new DateInterval('P1D'));
			$fechaFinal2 = $fechaFinal->format('Y-m-d');

			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM ventas WHERE metodo_pago ='".$metodoPago."' and fecha BETWEEN '$fechaInicial' AND '$fechaFinal2' ORDER BY id DESC");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}
	/*=============================================
	LISTADO DE ETIQUETAS
	=============================================*/	

	static public function mdlEtiquetasVentas($tabla){

		

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC limit 30");

		$stmt -> execute();

		return $stmt -> fetchAll();	

		$stmt -> close();

		$stmt = null;



	}

	static public function mdlTmpVentasCopia($tabla, $tipo){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where tipo =:tipo and adeuda > 0");

		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();	

		$stmt -> close();

		$stmt = null;



	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/

	static public function mdlSumaTotalVentas($tabla){	

		// VENTAS DEL DIA

		$fechaFinal = new DateTime();
		
		$fechaFinal2 = $fechaFinal->format('Y-m-d');

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla where fecha='".$fechaFinal2."'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/

	static public function mdlSumaTotalVentasEntreFechas($tabla,$fechaInicial,$fechaFinal){	

		// VENTAS DEL DIA

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla where fecha BETWEEN '".$fechaInicial."' and '".$fechaFinal."'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}


	public function mdlUltimoComprobante($tabla, $item, $valor){

		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();
		

		$stmt->close();

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlAgregarNroComprobante($tabla, $datos){
		

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET numero = :numero WHERE id=1");

		
		
		$stmt->bindParam(":numero", $datos, PDO::PARAM_INT);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlRealizarPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE ventas SET adeuda = ".$datos["adeuda"].", fechapago='".$datos["fecha"]."' WHERE id = ".$datos["id"]);

		// $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		// $stmt->bindParam(":adeuda", $datos["adeuda"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlHistorial($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where tipo='FC' ");

			$stmt -> execute();

			return $stmt -> fetchAll();	

	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlHistorialCta_art($tabla, $idcta){

		 // echo "SELECT * FROM $tabla where idcta=".$idcta;
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where idcta=".$idcta);

		$stmt -> execute();

		return $stmt -> fetchAll();

		
		
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ELIMINAR PAGO
	=============================================*/

	static public function mdlEliminarPago($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  fechapago = '0000-00-00', adeuda = total WHERE id = :id");

		
		$stmt->bindParam(":id", $valor, PDO::PARAM_INT);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR DERECHO DE ESCRITURA
	=============================================*/

	static public function mdlDerechoEscrituraVenta($tabla, $datos,$total){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  productos = :productos,total = :total, adeuda = :adeuda WHERE id = :id");

		$stmt->bindParam(":id",$valor, PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos, PDO::PARAM_STR);
		$stmt->bindParam(":total", $total, PDO::PARAM_STR);
		$stmt->bindParam(":adeuda", $total, PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	
	

	

	/*=============================================
	SELECCIONAR VENTA
	=============================================*/

	static public function mdlRealizarPagoVenta($tabla,$datos){

		echo '<center><pre>'; print_r($datos); echo '</pre></center>';
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  metodo_pago = :metodo_pago,referenciapago =:referenciapago,fechapago =:fechapago, adeuda =:adeuda WHERE id =:id");


		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":metodo_pago", $datos['metodo_pago'], PDO::PARAM_STR);
		$stmt->bindParam(":referenciapago", $datos['referenciapago'], PDO::PARAM_STR);
		$stmt->bindParam(":fechapago", $datos['fechapago'], PDO::PARAM_STR);
		$stmt->bindParam(":adeuda", $datos['adeuda'], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlUpdateProductos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  productos = :productos WHERE id =:id");


		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos['productos'], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	OBTENER EL ULTIMO ID
	=============================================*/

	static public function mdlUltimoId($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id,codigo FROM `ventas` ORDER BY id DESC LIMIT 1");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

// static public function mdlCorregirNombres($tabla, $datos){
		
// 		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  nombre = :nombre, documento = :documento WHERE id = :id");

// 		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
// 		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
// 		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);

// 		if($stmt->execute()){

// 			return "ok";

// 		}else{

			
// 		    echo "\nPDO::errorInfo():\n";
// 		    print_r($stmt->errorInfo());

		
// 		}

// 		$stmt->close();
// 		$stmt = null;

// 	}

	static public function mdlMostrarUltimaVenta($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  order by id desc limit 1");

		$stmt -> execute();

		return $stmt -> fetch();

		
		
		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarUltimasVentas($tabla, $item, $valor){

		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item > :$item ORDER BY id");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}
	
	
}