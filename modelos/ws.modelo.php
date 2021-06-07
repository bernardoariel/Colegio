<?php

require_once "conexion.php";

class ModeloWs{

	/*=============================================
	MOSTRAR ESCRIBANOS WEBSERVICE
	=============================================*/

	static public function mdlMostrarEscribanosWs($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectarWs()->prepare("SELECT * FROM $tabla WHERE $item = :$item and activo = 1");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectarWs()->prepare("SELECT * FROM $tabla where activo = 1 order by nombre");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	PONER A NULL TODOS LOS ESCRIBANOS DEL WS
	=============================================*/

	static public function mdlNullEscribanosWs($tabla){

		$stmt = Conexion::conectarWs()->prepare("UPDATE $tabla SET inhabilitado = 2");

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	CAMBIAR EL ESTADO DE LOS ESCRIBANOS
	=============================================*/

	static public function mdlModificarEstadosWs($tabla, $datos){
	
		$stmt = Conexion::conectarWs()->prepare("UPDATE $tabla SET inhabilitado =:inhabilitado where id=:idcliente");

		$stmt->bindParam(":idcliente", $datos['idcliente'], PDO::PARAM_INT);
		$stmt->bindParam(":inhabilitado", $datos['inhabilitado'], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
}

