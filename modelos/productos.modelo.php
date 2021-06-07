<?php

require_once "conexion.php";

class ModeloProductos{

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function mdlMostrarProductos($tabla, $item, $valor, $orden){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY nombre DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE PRODUCTO
	=============================================*/
	static public function mdlIngresarProducto($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(`nombre`, `descripcion`, `codigo`, `nrocomprobante`, `cantventa`, `id_rubro`, `cantminima`, `cuotas`, `importe`, `obs`) VALUES (:nombre,:descripcion,:codigo,:nrocomprobante,:cantventa,:id_rubro,:cantminima,:cuotas,:importe,:obs)");

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
	COLOCAR STOCK A CERO
	=============================================*/
	static public function mdlStockNuevo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  stock = :stock");

		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		

		if($stmt->execute()){
			
			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	
	
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre =:nombre, descripcion = :descripcion, codigo = :codigo, nrocomprobante = :nrocomprobante, cantventa = :cantventa , id_rubro = :id_rubro, cantminima = :cantminima, cuotas = :cuotas, importe = :importe, obs = :obs  WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
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

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/

	static public function mdlEliminarProducto($tabla, $datos){

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

	static public function mdlbKProducto($tabla, $datos){

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