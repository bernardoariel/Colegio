<?php

require_once "conexion.php";

class ModeloEnlace{

	/*=============================================
	ELIMINAR DATOS DE LA TABLA ENLACE
	=============================================*/

	static public function mdlEliminarEnlace($tabla){

		$stmt = Conexion::conectarEnlace()->prepare("DELETE FROM $tabla");

		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	INGRESAR PRODUCTOS A ENLACE
	=============================================*/
	static public function mdlIngresarProducto($tabla, $datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO $tabla(`id`,`nombre`, `descripcion`, `codigo`, `nrocomprobante`, `cantventa`, `id_rubro`, `cantminima`, `cuotas`, `importe`, `obs`) VALUES (:id,:nombre,:descripcion,:codigo,:nrocomprobante,:cantventa,:id_rubro,:cantminima,:cuotas,:importe,:obs)");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datos["nrocomprobante"], PDO::PARAM_INT);
		$stmt->bindParam(":cantventa", $datos["cantventa"], PDO::PARAM_INT);
		$stmt->bindParam(":id_rubro", $datos["id_rubro"], PDO::PARAM_INT);
		$stmt->bindParam(":cantminima", $datos["cantminima"], PDO::PARAM_INT);
		$stmt->bindParam(":cuotas", $datos["cuotas"], PDO::PARAM_INT);
		$stmt->bindParam(":importe", $datos["importe"], PDO::PARAM_STR);
		$stmt->bindParam(":obs", $datos["obs"], PDO::PARAM_STR);
		
	

		if($stmt->execute()){

			 return "ok";

			
		}else{

			 return "error";

		
		}

		// $stmt->close();
		// $stmt = null;

	}

	/*=============================================
	INTRODUCIR  ESCRIBANOS AL ENLACE
	=============================================*/

	static public function mdlIngresarEscribano($tabla, $datos){

		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO $tabla(`id`,`nombre`,`documento`,id_tipo_iva,tipo,facturacion,tipo_factura,`cuit`, `direccion`,`localidad`, `telefono`,`email` , `id_categoria`,`id_escribano_relacionado`, `id_osde`,`ultimolibrocomprado`,`ultimolibrodevuelto`,`apellido_ws`,`nombre_ws`,`matricula_ws`) VALUES
					 (:id,:nombre,:documento,:id_tipo_iva,:tipo,:facturacion,:tipo_factura,:cuit,:direccion,:localidad,:telefono,:email,:id_categoria,:id_escribano_relacionado,:id_osde,:ultimolibrocomprado,:ultimolibrodevuelto,:apellido_ws,:nombre_ws,:matricula_ws)");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_INT);

		$stmt->bindParam(":id_tipo_iva", $datos["id_tipo_iva"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
        $stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_factura", $datos["tipo_factura"], PDO::PARAM_STR);
      
		$stmt->bindParam(":cuit", $datos["cuit"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":localidad", $datos["localidad"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		
		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":id_escribano_relacionado", $datos["id_escribano_relacionado"], PDO::PARAM_INT);
		$stmt->bindParam(":id_osde", $datos["id_osde"], PDO::PARAM_INT);
		$stmt->bindParam(":ultimolibrocomprado", $datos["ultimolibrocomprado"], PDO::PARAM_INT);
		$stmt->bindParam(":ultimolibrodevuelto", $datos["ultimolibrodevuelto"], PDO::PARAM_INT);
		
		$stmt->bindParam(":apellido_ws", $datos["apellido_ws"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_ws", $datos["nombre_ws"], PDO::PARAM_STR);
		$stmt->bindParam(":matricula_ws", $datos["matricula_ws"], PDO::PARAM_STR);
			   
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

	static public function mdlMostrarVentasColegio($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo LIKE 1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		
		
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos){
	 
		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO $tabla(id,fecha,tipo,id_cliente,nombre,documento, productos,total)VALUES
					 (:id,:fecha,:tipo,:id_cliente,:nombre,:documento,:productos,:total)");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
	
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		
		
		if($stmt->execute()){

			return "ok";

		}else{



			 return "error";
		
		}



		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	INGRESO DE CUOTAS
	=============================================*/

	static public function mdlIngresarCuota($tabla, $datos){

		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO $tabla(id,fecha,tipo,id_cliente,nombre,documento, productos,total)VALUES
					 (:id,:fecha,:tipo,:id_cliente,:nombre,:documento,:productos,:total)");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
	
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return $stmt->errorInfo();
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarUltimaActualizacion($tabla){

		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla limit 1");

		$stmt -> execute();

		return $stmt -> fetch();

		
		
		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarUltimaActualizacionModificaciones($tabla,$valor){

		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla where nombre = :nombre ORDER BY id DESC LIMIT 1");

		$stmt->bindParam(":nombre", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		
		
		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarVentasFechaClorinda($tabla, $item, $valor){

		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE $item = '".$valor."' ORDER BY codigo ASC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarVentasFechaColorado($tabla, $item, $valor){

		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE $item = '".$valor."' ORDER BY codigo ASC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarVentasClorinda($tabla, $item, $valor){


		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE $item = $valor");

		// $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

	
		
		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarVentasClorindaCodigoFc($tabla, $item, $valor){


		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE $item = '$valor'");

		// $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

	
		
		$stmt -> close();

		$stmt = null;

	}
static public function mdlMostrarVentasColorado($tabla, $item, $valor){


		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE $item = $valor");

		// $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

	
		
		$stmt -> close();

		$stmt = null;

	}
static public function mdlMostrarVentasColoradoCodigoFc($tabla, $item, $valor){

		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE codigo = '".$valor."'");

		

		$stmt -> execute();

		return $stmt -> fetch();

	
		
		$stmt -> close();

		$stmt = null;

	}

/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasEnlace($tabla, $fechaInicial, $fechaFinal){

		

		if($fechaInicial == null){
// 
			$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla ORDER BY codigo asc limit 60");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){
// 
			$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY codigo DESC ");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			// $fechaFinal = new DateTime();
			// $fechaFinal->add(new DateInterval('P1D'));
			// $fechaFinal2 = $fechaFinal->format('Y-m-d');

			$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY codigo asc");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	INGRESAR HABILITADOS A ENLACE
	=============================================*/
	static public function mdlSubirInhabilitado($tabla, $datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO `inhabilitados`(`id_cliente`, `nombre`) VALUES (:id_cliente,:nombre)");

		$stmt->bindParam(":id_cliente", $datos["id"], PDO::PARAM_INT);
	    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);

		if($stmt->execute()){

			 return "ok";

			
		}else{

			 return "error";

		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	INGRESAR HABILITADOS A ENLACE
	=============================================*/
	static public function mdlSubirHabilitado($tabla, $datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("DELETE FROM $tabla where id_cliente=:id_cliente");

		$stmt->bindParam(":id_cliente", $valor, PDO::PARAM_INT);
	   

		if($stmt->execute()){

			 return "ok";

			
		}else{

			 return "error";

		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	REGISTRAR MODIFICACIONES
	=============================================*/
	static public function mdlSubirModificaciones($tabla,$datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO $tabla(`fecha`,`nombre`,`colegio`) VALUES (:fecha,:nombre,1)");


		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
	    $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
	   

		if($stmt->execute()){

			 return "ok";

			
		}else{

			 return "error";

		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlUpdateModificaciones($tabla,$datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("UPDATE $tabla SET colorado = 0 , clorinda = 0 WHERE fecha =:fecha and nombre =:nombre");


		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
	    $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
	   

		if($stmt->execute()){

			 return "ok";

			
		}else{

			 return "error";

		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	VER REGISTROS DE MODIFICACIONES
	=============================================*/
	static public function mdlVerModificaciones($tabla,$datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("SELECT *From $tabla where fecha=:fecha,nombre=:nombre");

		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
	    $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);

		if($stmt->execute()){

			 return "ok";

			
		}else{

			 return "error";

		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	CONSULTAR MODIFICACIONES
	=============================================*/
	static public function mdlConsultarModificaciones($tabla,$datos){
	
		$stmt = Conexion::conectarEnlace()->prepare("SELECT COUNT(nombre)FROM $tabla WHERE nombre =:nombre  AND fecha =:fecha");

		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
	    $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

	
		
		$stmt -> close();

		$stmt = null;


	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVentaEnlace($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id,fecha,tipo,codigo, id_cliente,nombre,documento,tabla, id_vendedor, productos, impuesto, neto, total,adeuda,observaciones,metodo_pago,referenciapago,fechapago,cae,fecha_cae) VALUES (:id,:fecha,:tipo,:codigo, :id_cliente,:nombre,:documento,:tabla, :id_vendedor, :productos, :impuesto, :neto, :total,:adeuda,:obs, :metodo_pago,:referenciapago,:fechapago,:cae,:fecha_cae)");
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
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
		if($stmt->execute()){

			return "ok";

		}else{

			return "              error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR CUOTA
	=============================================*/
	static public function mdlEliminarCuota($tabla, $valor){
	
		$stmt = Conexion::conectarEnlace()->prepare("DELETE FROM $tabla where id=:id");

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
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarUltimaVenta($tabla){

		$stmt = Conexion::conectarEnlace()->prepare("SELECT * FROM $tabla  order by id desc limit 1");

		$stmt -> execute();

		return $stmt -> fetch();

		
		
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/
	static public function mdlIngresarVentaEnlace2($tabla, $datos){

		$stmt = Conexion::conectarEnlace()->prepare("INSERT INTO $tabla(id,fecha,codigo,tipo,id_cliente,nombre,documento,tabla, id_vendedor, productos,impuesto,neto,total,adeuda,cae,fecha_cae,metodo_pago,fechapago,referenciapago,observaciones) VALUES (:id,:fecha,:codigo,:tipo, :id_cliente,:nombre,:documento,:tabla, :id_vendedor, :productos, :impuesto, :neto, :total,:adeuda,:cae,:fecha_cae,:metodo_pago,:fechapago,:referenciapago,:observaciones)");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":tabla", $datos["tabla"], PDO::PARAM_STR);

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":adeuda", $datos["adeuda"], PDO::PARAM_STR);

		$stmt->bindParam(":cae", $datos["cae"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_cae", $datos["fecha_cae"], PDO::PARAM_STR);

		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":referenciapago", $datos["referenciapago"], PDO::PARAM_STR);
		$stmt->bindParam(":fechapago", $datos["fechapago"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		

                    
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
}

