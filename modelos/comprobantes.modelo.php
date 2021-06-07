<?php

require_once "conexion.php";

class ModeloComprobantes{

	/*=============================================
	MOSTRAR COMPROBANTES
	=============================================*/

	static public function mdlMostrarComprobantes($tabla, $item, $valor){

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
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarComprobante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,numero) VALUES (:nombre,:numero)");

		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":numero", $datos['numero'], PDO::PARAM_STR);

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

	static public function mdlEditarComprobante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre,numero = :numero WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":numero", $datos["numero"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarComprobante($tabla, $datos){

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
     BORRAR TODOS LOS COMPROBANTES
	=============================================*/

	static public function mdlIniciarTabla($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla");

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	INSERTAR DATOS A LA TABLA
	=============================================*/

	static public function mdlIniciarCargaTmpComprobantes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id,nombre,numero) VALUES (:id,:nombre,:numero)");

		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":numero", $datos['numero'], PDO::PARAM_INT);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


	


	/*=============================================
	AGREGAR ULTIMO ID CATEGORIA
	=============================================*/

	static public function mdlAgregarItemsComprobantes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla 
			(idproducto, cantidad, nombre, idnrocomprobante, cantventaproducto, precioventa, folio1, folio2) VALUES ( :idproducto,:cantidad,:nombre,:idnrocomprobante,:cantventaproducto,:precioventa,:folio1,:folio2)");

		$stmt->bindParam(":idproducto", $datos['idproducto'], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datos['cantidadProducto'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":idnrocomprobante", $datos['idNroComprobante'], PDO::PARAM_INT);
		$stmt->bindParam(":cantventaproducto", $datos['cantVentaProducto'], PDO::PARAM_INT);
		$stmt->bindParam(":precioventa", $datos['precioVenta'], PDO::PARAM_INT);
		$stmt->bindParam(":folio1", $datos['folio1'], PDO::PARAM_INT);
		$stmt->bindParam(":folio2", $datos['folio2'], PDO::PARAM_INT);
		

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

	static public function mdlUpdateFolioComprobantes($tabla, $item, $valor, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET numero = $datos WHERE id = $valor");

		// $stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
		// $stmt -> bindParam(":numero", $datos, PDO::PARAM_INT);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	UPDATE FOLIOS
	=============================================*/

	static public function mdlUpdateFolio($tabla,$campo, $id,$numero){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $campo = $numero WHERE id = $id");


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR NURO COMPROBANTES CATEGORIA
	=============================================*/

	static public function mdlUpdateComprobante($tabla,  $valor,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET numero = :numero WHERE id = :id");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":numero", $datos, PDO::PARAM_INT);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlbKComprobante($tabla, $datos){

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

}

