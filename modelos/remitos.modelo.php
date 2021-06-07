<?php

require_once "conexion.php";

class ModeloRemitos{

	/*=============================================
	MOSTRAR DELEGACIONES
	=============================================*/

	static public function mdlMostrarRemitos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

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

	/*=============================================
	MOSTRAR DELEGACIONES
	=============================================*/

	static public function mdlMostrarRemitosFecha($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	CREAR DELEGACION
	=============================================*/

	static public function mdlIngresarRemito($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,direccion,localidad,telefono,puntodeventa,idescribano,escribano) VALUES (:nombre,:direccion,:localidad,:telefono,:puntodeventa,:idescribano,:escribano)");

		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos['direccion'], PDO::PARAM_STR);
		$stmt->bindParam(":localidad", $datos['localidad'], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos['telefono'], PDO::PARAM_STR);
		$stmt->bindParam(":puntodeventa", $datos['puntodeventa'], PDO::PARAM_STR);
		$stmt->bindParam(":idescribano", $datos['idescribano'], PDO::PARAM_INT);
		$stmt->bindParam(":escribano", $datos['escribano'], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	
	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarRemito($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre,direccion = :direccion, localidad = :localidad, telefono = :telefono, puntodeventa = :puntodeventa, idescribano = :idescribano,escribano = :escribano WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt -> bindParam(":localidad", $datos["localidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":puntodeventa", $datos["puntodeventa"], PDO::PARAM_STR);
		$stmt -> bindParam(":idescribano", $datos["idescribano"], PDO::PARAM_INT);
		$stmt -> bindParam(":escribano", $datos["escribano"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR DELEGACION
	=============================================*/

	static public function mdlBorrarRemito($tabla, $datos){

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

	/*=============================================
	OBTENER EL ULTIMO ID
	=============================================*/

	static public function mdlUltimoIdRemito($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id,codigo FROM `remitos` ORDER BY id DESC LIMIT 1");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVentaRemito($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha,tipo,codigo, id_cliente,nombre,documento,tabla, id_vendedor, productos, impuesto, neto, total,adeuda,observaciones,metodo_pago,referenciapago,fechapago,cae,fecha_cae) VALUES (:fecha,:tipo,:codigo, :id_cliente,:nombre,:documento,:tabla, :id_vendedor, :productos, :impuesto, :neto, :total,:adeuda,:obs, :metodo_pago,:referenciapago,:fechapago,:cae,:fecha_cae)");

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

			return $stmt->errorInfo();
		
		}

		$stmt->close();
		$stmt = null;

	}
}

