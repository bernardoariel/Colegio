<?php

require_once "conexion.php";

class ModeloProgramaViejo{

	static public function mdlEliminarEscribanos(){

		$stmt = Conexion::conectar()->prepare("DELETE FROM `escribanos`");
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlEscribanos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla
			(id,nombre,direccion,localidad,telefono,documento,cuit,email,id_categoria,id_escribano_relacionado,id_osde,ultimolibrocomprado,ultimolibrodevuelto) VALUES 
			(:id,:nombre,:direccion,:localidad,:telefono,:documento,:cuit,:email,:id_categoria,:id_escribano_relacionado,:id_osde,:ultimolibrocomprado	,:ultimolibrodevuelto)");

		

		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos['direccion'], PDO::PARAM_STR);
		$stmt->bindParam(":localidad", $datos['localidad'], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos['telefono'], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos['documento'], PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $datos['cuit'], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
		$stmt->bindParam(":id_categoria", $datos['id_categoria'], PDO::PARAM_INT);
		$stmt->bindParam(":id_escribano_relacionado", $datos['id_escribano_relacionado'], PDO::PARAM_INT);
		$stmt->bindParam(":id_osde", $datos['id_osde'], PDO::PARAM_INT);
		$stmt->bindParam(":ultimolibrocomprado", $datos['ultimolibrocomprado'], PDO::PARAM_INT);
		$stmt->bindParam(":ultimolibrodevuelto", $datos['ultimolibrodevuelto'], PDO::PARAM_INT);


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEliminarComprobantes(){

		$stmt = Conexion::conectar()->prepare("DELETE FROM `comprobantes`");
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	static public function mdlComprobantes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id,nombre,cabezacomprobante,numero) VALUES 
			(:id,:nombre,:cabezacomprobante,:numero)");

		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":cabezacomprobante", $datos['cabezacomprobante'], PDO::PARAM_STR);
		$stmt->bindParam(":numero", $datos['numero'], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEliminarOsde(){

		$stmt = Conexion::conectar()->prepare("DELETE FROM `osde`");
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}
	
	static public function mdlOsde($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id,nombre,importe) VALUES 
			(:id,:nombre,:importe)");

		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":importe", $datos['importe'], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEliminarRubros(){

		$stmt = Conexion::conectar()->prepare("DELETE FROM `rubros`");
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	static public function mdlRubros($tabla, $datos){
		$ssql ="INSERT INTO $tabla(id,nombre,movimiento,mensual,obs,activo,obsdel) VALUES 	(".$datos['id'].",'".$datos['nombre']."',".$datos['movimiento'].",'".$datos['mensual']."','".$datos['obs']."',".$datos['activo'].",'".$datos['obsdel']."')";
		// echo $ssql;
		$stmt = Conexion::conectar()->prepare($ssql);

		// $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		// $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		// $stmt->bindParam(":movimiento", $datos['movimiento'], PDO::PARAM_INT);
		// $stmt->bindParam(":mensual", $datos['mensual'], PDO::PARAM_INT);
		// $stmt->bindParam(":obs", $datos['obs'], PDO::PARAM_STR);
		// $stmt->bindParam(":activo", $datos['activo'], PDO::PARAM_INT);
		// $stmt->bindParam(":obsdel", $datos['obsdel'], PDO::PARAM_STR);

		 
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEliminarProductos(){

		$stmt = Conexion::conectar()->prepare("DELETE FROM `productos`");
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	static public function mdlProductos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla
			(id,nombre,descripcion,codigo,nrocomprobante,cantventa,id_rubro,cantminima,cuotas,importe,ultimonrocompra) VALUES 
			(:id,:nombre,:descripcion,:codigo,:nrocomprobante,:cantventa,:idrubro,:cantminima,:cuotas,:importe,:ultimonrocompra)");

		

		$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_STR);
		$stmt->bindParam(":nrocomprobante", $datos['nrocomprobante'], PDO::PARAM_INT);
		$stmt->bindParam(":cantventa", $datos['cantventa'], PDO::PARAM_INT);
		$stmt->bindParam(":idrubro", $datos['idrubro'], PDO::PARAM_INT);
		$stmt->bindParam(":cantminima", $datos['cantminima'], PDO::PARAM_INT);
		$stmt->bindParam(":cuotas", $datos['cuotas'], PDO::PARAM_INT);
		$stmt->bindParam(":importe", $datos['importe'], PDO::PARAM_STR);
		$stmt->bindParam(":ultimonrocompra", $datos['ultimonrocompra'], PDO::PARAM_INT);

                       
                       
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEliminarVentas(){

		$stmt = Conexion::conectar()->prepare("DELETE FROM `ventas`");
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	static public function mdlVentas($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("ALTER TABLE ventas AUTO_INCREMENT = 1");
		$stmt->execute();

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha,tipo,id_cliente,codigo,id_vendedor,productos,total,adeuda,metodo_pago,referenciapago) VALUES 
			(:fecha,:tipo,:idescribano,1,1,:productos,:total,:adeuda,'CTA.CORRIENTE','CTA.CORRIENTE')");

		

		// $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos['fecha'], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos['tipo'], PDO::PARAM_STR);
		$stmt->bindParam(":idescribano", $datos['idescribano'], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos['productos'], PDO::PARAM_STR);
		// $stmt->bindParam(":nrofc", $datos['nrofc'], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos['adeuda'], PDO::PARAM_STR);
		$stmt->bindParam(":adeuda", $datos['adeuda'], PDO::PARAM_STR);
		

                
                         
                       
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	
}

