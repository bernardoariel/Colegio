<?php

require_once "conexion.php";

class ModeloDelegaciones{

	/*=============================================
	MOSTRAR DELEGACIONES
	=============================================*/

	static public function mdlMostrarDelegaciones($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item order by id asc");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla order by id asc");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	CREAR DELEGACION
	=============================================*/

	static public function mdlIngresarDelegacion($tabla, $datos){

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

	static public function mdlEditarDelegacion($tabla, $datos){

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

	static public function mdlBorrarDelegacion($tabla, $datos){

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


}

