<?php

class Conexion{

	static public function conectar(){
		//CONEXION LOCAL
		$link = new PDO("mysql:host=localhost;dbname=colegio",
			            "root",
			            "");

		$link->exec("set names utf8");

		return $link;
		
	}

	static public  function conectarEnlace(){
		
		try {

			//CONEXION DE BACKUP EN LA WEB  --ORIGINAL--
			// $link = new PDO("mysql:host=66.97.41.81;dbname=colegioe_enlace01",
			// 	            "root",
			// 	            "Bgtoner123456");

			//CONEXION DE BACKUP EN LA WEB  --PRUEBA--
			$link = new PDO("mysql:host=66.97.41.81;dbname=colegioe_enlace01prueba",
				            "root",
				            "Bgtoner123456");

			$link->exec("set names utf8");

			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $link;

    
    
		} catch (PDOException $e) {
			
			echo '<script>window.location = "iniciosinconexion";</script>';

		}

	}
	static public function conectarWs(){

		//CONEXION DE BACKUP EN LA WEB  --ORIGINAL--
		// $link = new PDO("mysql:host=66.97.41.81;dbname=webservice",
		// 		            "root",
		// 		            "Bgtoner123456");
		//CONEXION PARA WEBSERVICE  --PRUEBA--
		$link = new PDO("mysql:host=66.97.41.81;dbname=webservice_prueba",
				            "root",
				            "Bgtoner123456");

		

			$link->exec("set names utf8");

			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $link;
		
	}

}

   