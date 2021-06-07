<?php

require_once "conexion.php";

class ModeloCaja{

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarCaja($tabla, $item, $valor){

		if($item != null){
		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM caja WHERE fecha like '%$valor%' order by id desc");
			
			
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla order by id desc limit 15");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha,efectivo,tarjeta,cheque,transferencia) VALUES (:fecha,:efectivo,:tarjeta,:cheque,:transferencia)");

		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
		$stmt->bindParam(":efectivo", $datos['efectivo'], PDO::PARAM_STR);
		$stmt->bindParam(":tarjeta", $datos['tarjeta'], PDO::PARAM_STR);
		$stmt->bindParam(":cheque", $datos['cheque'], PDO::PARAM_STR);
		$stmt->bindParam(":transferencia", $datos['transferencia'], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDiTAR CATEGORIA
	=============================================*/

	static public function mdlEditarCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET efectivo = :efectivo,tarjeta = :tarjeta,
			cheque = :cheque,transferencia = :transferencia WHERE fecha = :fecha");

		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
		$stmt->bindParam(":efectivo", $datos['efectivo'], PDO::PARAM_STR);
		$stmt->bindParam(":tarjeta", $datos['tarjeta'], PDO::PARAM_STR);
		$stmt->bindParam(":cheque", $datos['cheque'], PDO::PARAM_STR);
		$stmt->bindParam(":transferencia", $datos['transferencia'], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
}

