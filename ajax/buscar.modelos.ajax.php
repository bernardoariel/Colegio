<?php

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

	
require_once "../modelos/modelos.modelo.php";
		
// 		$connection = mysqli_connect('localhost','root','','bgtoner2'); 

// // Si la conexión falla, aparece el error 
// if($connection === false) { 
//  echo 'Ha habido un error <br>'.mysqli_connect_error(); 
// } else {
//  echo 'Conectado a la base de datos';
// }

//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];

//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";


//Comprueba si $consultaBusqueda está seteado
if (isset($consultaBusqueda)) {

	//Selecciona todo de la tabla mmv001 
	//donde el nombre sea igual a $consultaBusqueda, 
	//o el apellido sea igual a $consultaBusqueda, 
	//o $consultaBusqueda sea igual a nombre + (espacio) + apellido
	$respuesta=ModeloModelos::mdlBuscarModelos($consultaBusqueda);
	
	// $consulta = mysqli_query($connection, "SELECT * FROM modelo
	// WHERE nombre COLLATE UTF8_SPANISH_CI LIKE '%$consultaBusqueda%' 
	// OR detalle COLLATE UTF8_SPANISH_CI LIKE '%$consultaBusqueda%'
	// OR CONCAT(nombre,' ',detalle) COLLATE UTF8_SPANISH_CI LIKE '%$consultaBusqueda%'
	// ");

		// //Obtiene la cantidad de filas que hay en la consulta
	// $filas = mysqli_num_rows($consulta);

	
		//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		foreach ($respuesta as $key => $value) {
			

			//Output
			$mensaje .= '
			
  
  <tr>
    <td>' . $value['nombre'] . '</td>
    <td><button type="button" class="btn btn-link btnSeleccionarModelo" nombreModelo="'.$value['nombre'].'" idModelo='.$value['id'] .'>Seleccionar</button></td>
  </tr>
			';


		};//Fin while $resultados



};//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
echo '<table id="tablaModelo">'.$mensaje.'</table>';


