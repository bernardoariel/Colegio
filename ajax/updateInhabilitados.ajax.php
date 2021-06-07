<?php

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";
require_once "../controladores/cuotas.controlador.php";
require_once "../modelos/cuotas.modelo.php";
require_once "../controladores/parametros.controlador.php";
require_once "../modelos/parametros.modelo.php";
require_once "../controladores/enlace.controlador.php";
require_once "../modelos/enlace.modelo.php";
require_once "../controladores/ws.controlador.php";
require_once "../modelos/ws.modelo.php";

class AjaxUpdateInhabilitados{

  /*=============================================
  ACTUALIZAR INHABILITADOS
  =============================================*/ 
  public function ajaxActualizarInhabilitados(){

     
      #ELIMINAR LOS INHABILITADOS
      $respuesta = ControladorEnlace::ctrEliminarEnlace("inhabilitados");
     
       $item = null;
      $valor = null;

      $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);
      foreach ($escribanos as $key => $value) {

        if ($value['inhabilitado']==1){

          $datos = array("id"=>$value['id'],
                         "nombre"=>$value['nombre']);
        /*===========================================
        =            SUBIR INHABILITADOS            =
        ===========================================*/
        ControladorEnlace::ctrSubirInhabilitado($datos);
      
        /*=====  End of SUBIR INHABILITADOS  ======*/

        }
        


            
      }

      /*===========================================
      =     CONSULTAR SI EXISTEN MODIFICACIONES   =
       ===========================================*/
      $tabla ="modificaciones"; 
      $datos = array("nombre"=>"inhabilitados","fecha"=>date("Y-m-d"));
      $modificaciones = ModeloEnlace::mdlConsultarModificaciones($tabla,$datos);
      
      if(!$modificaciones[0]>=1){ 

       //SI NO EXISTE CREO UNA NUEVA FILA
       $datos = array("nombre"=>"inhabilitados","fecha"=>date("Y-m-d"));
       ControladorEnlace::ctrSubirModificaciones($datos);

      }else{

       //SI EXISTE ACTUALIZO A CERO 
       $datos = array("nombre"=>"inhabilitados","fecha"=>date("Y-m-d"));
       ControladorEnlace::ctrUpdateModificaciones($datos);

      }
          
          
  }

  /*=============================================
  MOSTRAR INHABILITADOS
  =============================================*/ 
  public function ajaxMostrarInhabilitados(){

    echo '<script>$(".tablaMostrarAjax").DataTable({
      "lengthMenu": [[5, 10, 25], [5, 10, 25]],
      dom: "lBfrtip",buttons: [
        {
          extend: "colvis",
          columns: ":not(:first-child)",
        }
        ],
    "language": {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
    "sFirst":    "Primero",
    "sLast":     "Último",
    "sNext":     "Siguiente",
    "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

  }
})</script>';

    echo '<table class="table table-bordered table-striped dt-responsive tablaMostrarAjax" width="100%">
            <thead>
         
             <tr>
               
               <th style="width:10px">#</th>
               <th style="width:100px">Nombre</th>
               <th>Ws</th>

             </tr> 

            </thead>

            <tbody>';

       

          $escribanos = ControladorEscribanos::ctrMostrarEscribanosInhabilitados();

          foreach ($escribanos as $key => $value) {


           
           
            if ($value["inhabilitado"] ==0){$estado=1;$btnEstado ='<i class="fa fa-info-circle" aria-hidden="true" style="color:green;" ></i>';}//habilitado
            if ($value["inhabilitado"] ==1){$estado=0;$btnEstado ='<i class="fa fa-info-circle" aria-hidden="true" style="color:red;" ></i>';}//inhabilitado
            
            if ($value["inhabilitado"] ==2){$estado=2;}//no consultable
            $data = '{"nombre":"'.$value["nombre_ws"].'","apellido":"'.$value["apellido_ws"].'","matricula":"'.$value["matricula_ws"].'","email":"'.strtolower($value["email"]).'","telefono":"'.$value["telefono"].'","inhabilitado":"'.$estado.'"}';

            $datos = str_replace(' ','',$data);
            $datos = str_replace('{','',$datos);
            $datos = str_replace('}','',$datos);
            $datos = str_replace('"','',$datos);
            $datos = str_replace(',','\n',$datos);
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase" >'.$value["nombre"].'</td>

                    <td class="text-uppercase"><button class="btn btn-danger" onclick=alert("'.$datos.'") >Estado WService</button></td>
                  
                  </tr>';
          }

        
        echo'
        </tbody>

       </table>';

     }
}

/*=============================================
ACTUALIZAR INHABILITADOS
=============================================*/ 
if(isset($_POST["upInhabilitados"])){

  $inhabilitados = new AjaxUpdateInhabilitados();
  $inhabilitados -> ajaxActualizarInhabilitados();
  
}
/*=============================================
MOSTRAR INHABILITADOS
=============================================*/ 
if(isset($_POST["mostrarInhabilitados"])){

  $inhabilitados = new AjaxUpdateInhabilitados();
  $inhabilitados -> ajaxMostrarInhabilitados();
  
}
