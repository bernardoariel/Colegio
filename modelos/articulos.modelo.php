<?php

require_once "conexion.php";

class ModeloArticulos{

	/*=============================================
	MOSTRAR ESCRIBANOS
	=============================================*/

	static public function mdlMostrarArticulos($tabla, $item, $valor){

		
		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and activo = 1");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where activo = 1 order by nombre");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	

	/*=============================================
	CREAR ESCRIBANOS
	=============================================*/

	static public function mdlIngresarArticulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(`folio`,`nrocomprobante`,`nombre`,`idfactura`, `fecha`,`nrofactura`, `nombrecliente`) VALUES
					 (:folio,:nrocomprobante,:nombre,:idfactura,:fecha,:nrofactura,:nombrecliente)");

		$stmt->bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datos["nrocomprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":idfactura", $datos["idfactura"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":nrofactura", $datos["nrofactura"], PDO::PARAM_STR);
		$stmt->bindParam(":nombrecliente", $datos["nombrecliente"], PDO::PARAM_STR);
		

			   
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
}
