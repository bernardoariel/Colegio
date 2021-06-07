<?php

require_once "conexion.php";

class ModeloCuotas{

	/*=============================================
	MOSTRAR CUOTAS
	=============================================*/

	static public function mdlMostrarCuotas($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item order by id desc");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla order by id desc");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarCuotasEscribano($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item order by id desc");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ELIMINAR CUOTA
	=============================================*/

	static public function mdlEliminarVenta($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	// 
	/*=============================================
	// MOSTRAR OSDE 
	// =============================================*/

	// static public function mdlContarOsde($tabla, $item, $valor,$anio){

	// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where tipo ='RE' and MONTH($item)=:valor and YEAR($item)=:anio");

		
	// 	$stmt->bindParam(":anio", $anio, PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);


	// 	$stmt -> execute();

	// 	return $stmt -> fetchAll();

		
		
	// 	$stmt -> close();

	// 	$stmt = null;

	// }
/*=============================================
	MOSTRAR CUOTAS 
	=============================================*/

	// static public function mdlContarCuotas($tabla, $item, $valor,$anio){

	// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where tipo ='CU' and MONTH($item)=:valor and YEAR($item)=:anio");

	// 	$stmt->bindParam(":anio", $anio, PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

	// 	$stmt -> execute();

	// 	return $stmt -> fetchAll();

		
		
	// 	$stmt -> close();

	// 	$stmt = null;

	// }

	/*=============================================
	INGRESO DE CUOTAS
	=============================================*/

	static public function mdlIngresarCuota($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha,tipo,id_cliente,nombre,documento,productos,total) VALUES (:fecha,:tipo,:id_cliente,:nombre,:documento, :productos, :total)");

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
	
	
	static public function mdlChequearGeneracion($tabla, $datos){
		

		$stmt = Conexion::conectar()->prepare("SELECT * FROM  $tabla where nombre=:tipo and mes =:mes and anio =:anio");

		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_STR);
		$stmt->bindParam(":anio", $datos["anio"], PDO::PARAM_INT);

		
		$stmt->execute();

		return $stmt -> fetch();

		$stmt->close();
		$stmt = null;

	}
	static public function mdlIngresarGeneracionCuota($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(`fecha`, `nombre`, `mes`, `anio`, `cantidad`) VALUES (:fecha,:nombre,:mes,:anio, :cantidad)");

		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_STR);
		$stmt->bindParam(":anio", $datos["anio"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return $stmt->errorInfo();
		
		}

		$stmt->close();
		$stmt = null;

	}
	

	static public function mdlEscribanosConDeuda($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_cliente = :id order by fecha asc");

		$stmt->bindParam(":id", $valor, PDO::PARAM_INT);


		$stmt -> execute();

		return $stmt -> fetch();

			

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlEscribanosDeuda($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_cliente = :id order by fecha asc limit 1");

		$stmt->bindParam(":id", $valor, PDO::PARAM_INT);


		$stmt -> execute();

		return $stmt -> fetch();

			

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	ACTUALIZAR INHABILITADO
	=============================================*/

	static public function mdlEscribanosInhabilitar($tabla, $valor){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET inhabilitado = 1 WHERE id = :id");

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
	ACTUALIZAR HABILITADO
	=============================================*/

	static public function mdlHabilitarUnEscribano($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET inhabilitado = 0 WHERE id = :id");

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
	ACTUALIZAR HABILITADO
	=============================================*/

	static public function mdlEscribanosHabilitar($tabla){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET inhabilitado = 0");

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlContarCuotayOsde($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM $tabla WHERE $item = :tipo");

		$stmt->bindParam(":tipo", $valor, PDO::PARAM_STR);


		$stmt -> execute();

		return $stmt -> fetch();

			

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	ACTUALIZAR INHABILITADO
	=============================================*/

	static public function mdlModificarCuota($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total =:importe WHERE id = :id");

		$stmt->bindParam(":importe", $datos["importe"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlModificarCuotaProductos($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET productos =:productos WHERE id = :id");

		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
}

