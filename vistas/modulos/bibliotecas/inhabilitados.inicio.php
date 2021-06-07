<?php
/*=============================================
=     CARGO UN ARRAY DE  LOS ESCRIBANOS      =
=============================================*/
#SE REVISA A LOS DEUDORES
$item = null;
$valor = null;  
$escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);


#CANTIDAD DE INHABILITADOS
$cantInhabilitados = 0;
#CANTIDAD DE INHABILITADOS
$cantEscribanos = 0;

#HAGO UN FOREACH PARA EVALUAR CUANTOS LIBROS DEBE
foreach ($escribanos as $key => $value) {

  $cantEscribanos++;
  #INHABILITADOS
  $inhabilitado = 0;
  /*=============================================
            INHABILITACION POR LIBROS
  =============================================*/
  #OBTENGO CUANTOS LIBROS... DEBE
  $cantLibros = $value["ultimolibrocomprado"]-$value["ultimolibrodevuelto"];
  
  if ($cantLibros>=$maxLibros){

    $inhabilitado++;//LO SACO DE CERO AL INHABILITADO

  }    
  /*=============================================
            INHABILITACION POR DEUDA
  =============================================*/
  //ACA ENTRAN TODOS LOS ATRASADOS
  $item= "id";
  $valor = $value["id"];
  // //VER LA DEUDA DE CADA ESCRIBANO
  $escribanosConDeudaTodos = ControladorCuotas::ctrEscribanosDeuda($item,$valor);
  
  if(!empty($escribanosConDeudaTodos)){

    $fecha2=date("Y-m-j");
    $dias = (strtotime($escribanosConDeudaTodos["fecha"])-strtotime($fecha2))/86400;
    $dias   = abs($dias); 
    $dias = floor($dias);   
   
  
    if($dias>=$atraso['valor']) {

      if ($value['id']<>1){

        $inhabilitado++;

         // echo '<pre>'; print_r($value["nombre"]); echo ' - ('.$dias.'-'.$inhabilitado. ')</pre>';

      }
          
    }

  }

  /*=============================================
  GUARDO LOS INHABILITADOS EN LA BD LOCAL
  =============================================*/
  if($inhabilitado>=1){

    $valor=$value['id'];
    $respuesta = ControladorCuotas::ctrEscribanosInhabilitar($valor);
    $cantInhabilitados ++;

    /*===========================================
    = SUBIR INHABILITADOS   A LA TABLA INABILITADOS DEL =
    ===========================================*/
    $datos = array("id"=>$value['id'],
                   "nombre"=>$value['nombre']);
    ControladorEnlace::ctrSubirInhabilitado($datos);

  }
     
}//foreach


?>