<?php

require_once "../controladores/comprobantes.controlador.php";
require_once "../modelos/comprobantes.modelo.php";
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxComprobantes{

	// /*=============================================
	// EDITAR COMPROBANTES
	// =============================================*/	

	public $idComprobante;

	public function ajaxEditarComprobante(){

		$item = "id";
		$valor = $this->idComprobante;

		$respuesta = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	EDITAR COMPROBANTES
	=============================================*/	

	public function ajaxTodosComprobantes(){

		$item = null;
		$valor = null;
		$respuesta = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);

		echo json_encode($respuesta);

	}
	/*=============================================
	BORRA LA TABLA tmp_comprobantes
	=============================================*/	

	public function iniciarComprobantes(){

		$item = null;
		$valor = null;

		$respuesta = ControladorComprobantes::ctrIniciarComprobantes($item, $valor);

		return $respuesta;

	}
	/*=============================================
	INICIAR TABLA
	=============================================*/	
	public $idTmp;
	public $nombreTmp;
	public $numeroTmp;

	public function iniciarCargaComprobantes(){

		$datos = array("id"=>$this->idTmp,
					   "nombre"=>$this->nombreTmp,
					   "numero"=>$this->numeroTmp);

		$respuesta = ControladorComprobantes::ctrIniciarCargaTmpComprobantes($datos);

		return $respuesta;
	}

	/*=============================================
	INICIAR ITEMS
	=============================================*/	

	public function borrarItems(){

		$item = null;
		$valor = null;
		$respuesta = ControladorComprobantes::ctrIniciarItems($item, $valor);

		

	}

	/*=============================================
	VER ULTIMO  COMPROBANTE ID
	=============================================*/	

	public $idItem;

	public function ajaxBorrarItem(){

		$item = "id";
		$valor = $this->idItem;

		$respuesta = ControladorComprobantes::ctrBorrarItem($item, $valor);

		// BORRAR LA TABLA TMP_COMPROBANTES
		$item = null;
		$valor = null;

		$borrarComprobantes = ControladorComprobantes::ctrIniciarComprobantes($item, $valor);

		// CREAR LA TABLA TMP_COMPROBANTES
		
		// 1..cargamos la tabla
		$item = null;
		$valor = null;

		$tablaPrincipalComprobantes = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);
		foreach ($tablaPrincipalComprobantes as $key => $value) {
			# code...
			$datos = array("id"=>$value['id'],
					   "nombre"=>$value['nombre'],
					   "numero"=>$value['numero']);

			$cargarTmpComprobantes = ControladorComprobantes::ctrIniciarCargaTmpComprobantes($datos);
		}
		

		// MUESTRO TODOS LOS ITEMS DE LA TABLA tmp_items
		$item = null;
		$valor = null;

		$respuesta = ControladorComprobantes::ctrMostrarItemsComprobantes($item, $valor);
	

		foreach ($respuesta as $key => $value) {

			$item = "id";
			$valor = $value['idnrocomprobante'];
			$comprobantes = ControladorComprobantes::ctrMostrarTMPComprobantes($item, $valor);
			

	        $folio1 = $comprobantes['numero']+1;

	        if ($value['cantidad']==1){

	            $folio2 =($value['cantventaproducto'] - 1) + ($folio1);
	            

	          }else{

	            $folio2 =$value['cantventaproducto'] * $value['cantidad'];

	            $folio2 =$folio2 + $folio1;

	            $folio2 = $folio2 - 1; 

	        }
		   
			
			echo '<tr>
                    <td>'.($key + 1) .'</td>
                    <td>

                        
                       <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto"  value="'.$value['cantidad'].'"  readonly>

                    </td>
                    <td>
                    <div>
                          
                          <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value['idproducto'].'" idNroComprobante="'.$value['idnrocomprobante'].'" cantVentaProducto="'.$value['cantventaproducto'].'" name="agregarProducto" value="'.$value['nombre'].'" readonly required>
                          

                        </div>
                    </td>
                    <td>
                    <div class="input-group">
                          
                         <input type="text" class="form-control nuevoFolio1"  name="folio1"  value="'.$folio1.'" readonly required>   

                       </div>
                    </td>
                    <td>
                    <div class="input-group">

                          <input type="text" class="form-control nuevoFolio2"  name="folio2"  value="'.$folio2.'" readonly required>

                        </div>
                    </td>
                    <td>
                    <div class="input-group">

                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                             
                          <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$value['precioventa'].'" name="nuevoPrecioProducto" value="'.$value['precioventa'].'" readonly required>
             
                        </div>
                    </td>
                    <td style="text-align: right;">
                    <div class="input-group">

                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                             
                          <input type="text" class="form-control nuevoTotalProducto" precioTotal="'.($value['cantidad']*$value['precioventa']).'" name="nuevoTotalProducto" value="'.($value['cantidad']*$value['precioventa']).'" readonly required>
             
                      </div>

                    </td>
                    <td>
                    
                   <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idItem="'.$value['id'].'" ><i class="fa fa-times"></i></button></span>
                    </td>
                    
                    </tr>';

            // GRABO EL ULTIMO ID
			$item = "id";
			$valor = $value['idnrocomprobante'];
			$datos = $folio2;
			$respuesta = ControladorComprobantes::ctrUpdateFolioComprobantes($item, $valor,$datos);

			// ACTUALIZO EL Folio1
			$campo = "folio1";
			$id = $value['id'];
			$numero = $folio1;

			$folios = ControladorComprobantes::ctrUpdateFolio($campo, $id,$numero);
			// ACTUALIZO EL Folio1
			$campo = "folio2";
			$id = $value['id'];
			$numero = $folio2;

			$folios = ControladorComprobantes::ctrUpdateFolio($campo, $id,$numero);

			

		}

	}

	/*=============================================
	AGREGAR ITEMS
	=============================================*/	

	public $idproducto;
	public $productoNombre;
	public $idNroComprobante;
	public $cantidadProducto;
	public $cantVentaProducto;
	public $precioVenta;
	public $idVenta;

	public function ajaxAgregarItems(){
		$idVenta = $this->idVenta;
		// tomo todos los datos que vienen por el formulario
		$datos = array("idproducto"=>$this->idproducto,
					   "nombre"=>$this->productoNombre,
					   "idNroComprobante"=>$this->idNroComprobante,
					   "cantidadProducto"=>$this->cantidadProducto,
					   "cantVentaProducto"=>$this->cantVentaProducto,
					   "precioVenta"=>$this->precioVenta,
					   "folio1"=>1,
					   "folio2"=>2);
		
		//los agrego en la tabla tmp_items
		$respuesta = ControladorComprobantes::ctrAgregarItemsComprobantes($datos);

		// BORRAR LA TABLA TMP_COMPROBANTES
		$item = null;
		$valor = null;

		$borrarComprobantes = ControladorComprobantes::ctrIniciarComprobantes($item, $valor);

		// CREAR LA TABLA TMP_COMPROBANTES
		
		// 1..cargamos la tabla
		$item = null;
		$valor = null;

		$tablaPrincipalComprobantes = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);
		foreach ($tablaPrincipalComprobantes as $key => $value) {
			# code...
			$datos = array("id"=>$value['id'],
					   "nombre"=>$value['nombre'],
					   "numero"=>$value['numero']);

			$cargarTmpComprobantes = ControladorComprobantes::ctrIniciarCargaTmpComprobantes($datos);
		}
		

		// MUESTRO TODOS LOS ITEMS DE LA TABLA tmp_items
		$item = null;
		$valor = null;

		$respuesta = ControladorComprobantes::ctrMostrarItemsComprobantes($item, $valor);
	

		foreach ($respuesta as $key => $value) {

			$item = "id";
			$valor = $value['idnrocomprobante'];
			$comprobantes = ControladorComprobantes::ctrMostrarTMPComprobantes($item, $valor);
			

	        $folio1 = $comprobantes['numero']+1;

	        if ($value['cantidad']==1){

	            $folio2 =($value['cantventaproducto'] - 1) + ($folio1);
	            

	          }else{

	            $folio2 =$value['cantventaproducto'] * $value['cantidad'];

	            $folio2 =$folio2 + $folio1;

	            $folio2 = $folio2 - 1; 

	        }
		   
			
			echo '<tr>
                    <td>'.($key + 1) .'</td>
                    <td>

                        
                       <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto"  value="'.$value['cantidad'].'"  readonly>

                    </td>
                    <td>
                    <div>
                          
                          <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value['idproducto'].'" idNroComprobante="'.$value['idnrocomprobante'].'" cantVentaProducto="'.$value['cantventaproducto'].'" name="agregarProducto" value="'.$value['nombre'].'" readonly required>
                          

                        </div>
                    </td>
                    <td>
                    <div class="input-group">
                          
                         <input type="text" class="form-control nuevoFolio1"  name="folio1"  value="'.$folio1.'" readonly required>   

                       </div>
                    </td>
                    <td>
                    <div class="input-group">

                          <input type="text" class="form-control nuevoFolio2"  name="folio2"  value="'.$folio2.'" readonly required>

                        </div>
                    </td>
                    <td>
                    <div class="input-group">

                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                             
                          <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$value['precioventa'].'" name="nuevoPrecioProducto" value="'.$value['precioventa'].'" readonly required>
             
                        </div>
                    </td>
                    <td style="text-align: right;">
                    <div class="input-group">

                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                             
                          <input type="text" class="form-control nuevoTotalProducto" precioTotal="'.($value['cantidad']*$value['precioventa']).'" name="nuevoTotalProducto" value="'.($value['cantidad']*$value['precioventa']).'" readonly required>
             
                      </div>

                    </td>
                    <td>';
                    if ($idVenta == 0){
                   echo '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idItem="'.$value['id'].'" ><i class="fa fa-times"></i></button></span>
                    </td>';
                }
                    
                  echo '  </tr>';

            // GRABO EL ULTIMO ID
			$item = "id";
			$valor = $value['idnrocomprobante'];
			$datos = $folio2;
			$respuesta = ControladorComprobantes::ctrUpdateFolioComprobantes($item, $valor,$datos);

			// ACTUALIZO EL Folio1
			$campo = "folio1";
			$id = $value['id'];
			$numero = $folio1;

			$folios = ControladorComprobantes::ctrUpdateFolio($campo, $id,$numero);
			// ACTUALIZO EL Folio1
			$campo = "folio2";
			$id = $value['id'];
			$numero = $folio2;

			$folios = ControladorComprobantes::ctrUpdateFolio($campo, $id,$numero);

			

		}

	}
	// /*=============================================
	// EDITAR COMPROBANTES
	// =============================================*/	

	public $idEscribano;

	public function ajaxMostrarFc(){

		$item = "id_cliente";
		$valor = $this->idEscribano;

		$respuesta = ControladorVentas::ctrMostrarVentasClientes($item, $valor);

foreach ($respuesta as $key => $value) {
			# code...

			echo '<tr>'.

                    '<td>1</td>'.

                    '<td>'.$respuesta[$key]['fecha'].'</td>'.

                    '<td>'.$respuesta[$key]['tipo'].'</td>'.

                    '<td>'.$respuesta[$key]['codigo'].'</td>'.

                    '<td>ESCRIBANO</td>'.

                    '<td>'.$respuesta[$key]['metodo_pago'].'</td>'.

                    '<td>'.$respuesta[$key]['referenciapago'].'</td>'.

                    '<td>'.$respuesta[$key]['total'].'</td>'.

                    '<td>'.$respuesta[$key]['adeuda'].'</td>'.

                  '</tr>';
		}
		

	}
}

/*=============================================
EDITAR COMPROBANTES
=============================================*/	
if(isset($_POST["idComprobante"])){

	$categoria = new AjaxComprobantes();
	$categoria -> idComprobante = $_POST["idComprobante"];
	$categoria -> ajaxEditarComprobante();
}

/*=============================================
INICIALIZAR  COMPROBANTES 
=============================================*/	
if(isset($_POST["iniciar"])){

	$comprobantes = new AjaxComprobantes();
	$comprobantes -> iniciarComprobantes();
}

/*=============================================
EDITAR COMPROBANTES todos
=============================================*/	
if(isset($_POST["todos"])){

	$comprobantes = new AjaxComprobantes();
	$comprobantes -> idComprobante = $_POST["todos"];
	$comprobantes -> ajaxTodosComprobantes();
}


/*=============================================
INICIALIZAR TABLA TMP
=============================================*/	
if(isset($_POST["idTmp"])){

	$comprobantes = new AjaxComprobantes();
	$comprobantes -> idTmp = $_POST["idTmp"];
	$comprobantes -> nombreTmp = $_POST["nombreTmp"];
	$comprobantes -> numeroTmp = $_POST["numeroTmp"];
	$comprobantes -> iniciarCargaComprobantes();

}
/*=============================================
INICIALIZAR  COMPROBANTES 
=============================================*/	
if(isset($_POST["items"])){

	$items = new AjaxComprobantes();
	$items -> borrarItems();
}

/*=============================================
AL TOCAR GRABAR ITEM 
=============================================*/	
if(isset($_POST["idNroComprobante"])){

	$categoria = new AjaxComprobantes();
	$categoria -> cantidadProducto = $_POST["cantidadProducto"];
	$categoria -> idproducto = $_POST["idproducto"];
	$categoria -> idNroComprobante = $_POST["idNroComprobante"];
	$categoria -> cantVentaProducto = $_POST["cantVentaProducto"];
	$categoria -> productoNombre = $_POST["productoNombre"];
	$categoria -> precioVenta = $_POST["precioVenta"];
	$categoria -> idVenta = $_POST['idVenta'];
	$categoria -> ajaxAgregarItems();
}




/*=============================================
EDITAR COMPROBANTES
=============================================*/	
if(isset($_POST["idItem"])){

	$categoria = new AjaxComprobantes();
	$categoria -> idItem = $_POST["idItem"];
	$categoria -> ajaxBorrarItem();
}

/*=============================================
EDITAR COMPROBANTES
=============================================*/	
if(isset($_POST["idEscribano"])){

	$historico = new AjaxComprobantes();
	$historico -> idEscribano = $_POST["idEscribano"];
	$historico -> ajaxMostrarFc();
}

