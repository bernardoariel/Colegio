<?php

require_once "conexion.php";

class ModeloParametros{

	/*=============================================
	MOSTRAR PARAMETEROS
	=============================================*/

	static public function mdlMostrarParametros($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item order by id desc");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla order by id desc");

			$stmt -> execute();

			return $stmt->fetchAll(PDO::FETCH_CLASS);
		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR LIBROS
	=============================================*/

	static public function mdlEditarLibro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ultimolibrocomprado = :ultimolibrocomprado,ultimolibrodevuelto = :ultimolibrodevuelto WHERE id = :id");

		$stmt -> bindParam(":ultimolibrocomprado", $datos["ultimolibrocomprado"], PDO::PARAM_STR);
		$stmt -> bindParam(":ultimolibrodevuelto", $datos["ultimolibrodevuelto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEditarParametros($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET valor = :valor WHERE id = :id");

		$stmt -> bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
static public function mdlbKParametro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(`tabla`,`tipo`,`datos`,`usuario`) VALUES
					 (:tabla,:tipo,:datos,:usuario)");

		$stmt->bindParam(":tabla", $datos["tabla"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":datos", $datos["datos"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
	   
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR PARAMETEROS
	=============================================*/

	static public function mdlMostrarBackUp($tabla, $item, $valor){

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

	/*=============================================
	ELIMINAR ESCRIBANO
	=============================================*/

	static public function mdlEliminarBackup($tabla, $datos){

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
	CONTAR TABLAS
	=============================================*/

	static public function mdlCountTablas($tabla,$item,$valor){

		if ($item ==null){

			$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM $tabla");
			
		}else{

			$stmt = Conexion::conectarEnlace()->prepare("SELECT count(*) FROM $tabla WHERE $item = :valor");
		
			$stmt -> bindParam(":valor", $valor, PDO::PARAM_STR);
		}
		

		$stmt -> execute();

		return $stmt -> fetch();
}
}

