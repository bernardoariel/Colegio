<?php

require_once "../controladores/cuotas.controlador.php";
require_once "../modelos/cuotas.modelo.php";
require_once "../controladores/enlace.controlador.php";
require_once "../modelos/enlace.modelo.php";
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxUpdateTodos{

	/*=============================================
	ACTUALIZAR CUOTAS
	=============================================*/	
	public function ajaxActualizarCuotas(){

      #ELIMINAR CUOTAS DEL ENLACE
      ControladorEnlace::ctrEliminarEnlace('cuotas');
      
      #TRAER PRODUCTOS DEL COLEGIO
      $item = null;
      $valor = null;

      $cuotas = ControladorCuotas::ctrMostrarCuotas($item, $valor);
      

      $cant=0;
      foreach ($cuotas as $key => $value) {
        # code...
        $tabla = "cuotas";
        $datos = array(
              "id"=>$value['id'],
              "fecha"=>$value['fecha'],
              "tipo"=>$value['tipo'],
              "id_cliente"=>$value['id_cliente'],
              "nombre"=>$value['nombre'],
              "documento"=>$value['documento'],
              "productos"=>$value['productos'],
              "total"=>$value['total']);

        #registramos los productos
        $respuesta = ModeloEnlace::mdlIngresarCuota($tabla, $datos);

       
        
      }

      /*===========================================
      =     CONSULTAR SI EXISTEN MODIFICACIONES   =
      ===========================================*/
      $tabla ="modificaciones"; 
      $datos = array("nombre"=>"cuotas","fecha"=>date("Y-m-d"));
      $modificaciones = ModeloEnlace::mdlConsultarModificaciones($tabla,$datos);
      
      if(!$modificaciones[0]>=1){

       $datos = array("nombre"=>"cuotas","fecha"=>date("Y-m-d"));
       ControladorEnlace::ctrSubirModificaciones($datos);

      }

    }

    /*=============================================
    ACTUALIZAR FACTURAS
    =============================================*/ 
  public function ajaxActualizarFacturas(){

      $ventasEnlace =ControladorEnlace::ctrMostrarUltimaAVenta();
      $ultimoIdServidor = $ventasEnlace['id'];

      $ventasLocal = ControladorVentas::ctrMostrarUltimaAVenta();
      $ultimoIdLocal = $ventasLocal['id'];

      if ($ultimoIdServidor < $ultimoIdLocal){
              #CONSULTA DE VENTAS MAYORES AL ULTIMO ID DEL SERVIDOR
              $item = "id";
              $valor = $ultimoIdServidor;
              
              $ventasUltimasVentas = ControladorVentas::ctrMostrarUltimasVentas($item, $valor);
              
              foreach ($ventasUltimasVentas as $key => $value) {
                # code...
                $tabla = "ventas";

                $datos = array("id"=>$value["id"],
                            "fecha"=>$value["fecha"],
                            "codigo"=>$value["codigo"],
                            "tipo"=>$value["tipo"],
                            "id_cliente"=>$value["id_cliente"],
                            "nombre"=>$value["nombre"],
                            "documento"=>$value["documento"],
                            "tabla"=>$value["tabla"],
                            "id_vendedor"=>$value["id_vendedor"],
                            "productos"=>$value["productos"],
                            "impuesto"=>$value["impuesto"],
                            "neto"=>$value["neto"],
                            "total"=>$value["total"],
                            "adeuda"=>$value["adeuda"],       
                            "metodo_pago"=>$value["metodo_pago"],       
                            "fechapago"=>$value["fechapago"],       
                            "cae"=>$value["cae"],       
                            "fecha_cae"=>$value["fecha_cae"],
                            "referenciapago"=>$value["referenciapago"],
                            "observaciones"=>$value["observaciones"]);

                #registramos los productos
                $respuesta = ModeloEnlace::mdlIngresarVentaEnlace2($tabla, $datos);
                
              }

            } 

      /*===========================================
      =     CONSULTAR SI EXISTEN MODIFICACIONES   =
      ===========================================*/
      $tabla ="modificaciones"; 
      $datos = array("nombre"=>"ventas","fecha"=>date("Y-m-d"));
      $modificaciones = ModeloEnlace::mdlConsultarModificaciones($tabla,$datos);
      
      if(!$modificaciones[0]>=1){

       $datos = array("nombre"=>"ventas","fecha"=>date("Y-m-d"));
       ControladorEnlace::ctrSubirModificaciones($datos);

      }

	}
  
  
}



/*=============================================
ACTUALIZAR TODO
=============================================*/ 
if(isset($_POST["actualizarCuota"])){

  $productos = new AjaxUpdateTodos();
  $productos -> ajaxActualizarCuotas();
}

if(isset($_POST["actualizarFc"])){

  $productos = new AjaxUpdateTodos();
  $productos -> ajaxActualizarFacturas();
}