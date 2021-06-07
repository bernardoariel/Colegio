<?php

require_once "conexion.php";

class ModeloEmpresa{

	/*=============================================
	MOSTRAR EMPRESA
	=============================================*/

	static public function mdlMostrarEmpresa($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR EMPRESA
	=============================================*/

	static public function mdlEditarEmpresa($tabla, $datos){
		
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET empresa = :empresa, direccion = :direccion, telefono = :telefono,cuit = :cuit, email = :email, web = :web, detalle1 = :detalle1, detalle2 =:detalle2 WHERE id = 1");



		$stmt -> bindParam(":empresa",strtoupper($datos["empresa"]), PDO::PARAM_STR);
		$stmt -> bindParam(":direccion",strtoupper($datos["direccion"]), PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		
		$stmt -> bindParam(":cuit", $datos["cuit"], PDO::PARAM_STR);
		$stmt -> bindParam(":web",strtoupper($datos["web"]), PDO::PARAM_STR);
		$stmt -> bindParam(":email",strtoupper($datos["email"]), PDO::PARAM_STR);
		$stmt -> bindParam(":detalle1",strtoupper($datos["detalle1"]), PDO::PARAM_STR);
		$stmt -> bindParam(":detalle2",strtoupper($datos["detalle2"]), PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	SELECCIONAR EMPRESA
	=============================================*/

	static public function mdlSeleccionarEmpresa($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR LOGO O ICONO
	=============================================*/

	static public function mdlActualizarLogoIcono($tabla, $id, $item, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE id = :id");

		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

}