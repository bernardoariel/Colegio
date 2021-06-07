<?php

require_once "../controladores/escribanos.controlador.php";
require_once "../modelos/escribanos.modelo.php";
require_once "../controladores/enlace.controlador.php";
require_once "../modelos/enlace.modelo.php";

class AjaxUpdateEscribanos{

  /*=============================================
  ACTUALIZAR PRODUCTOS
  =============================================*/ 
  public function ajaxActualizarEscribanos(){

      #ELIMINAR PRODUCTOS DEL ENLACE
     ControladorEnlace::ctrEliminarEnlace('escribanos');
      #TRAER PRODUCTOS DEL COLEGIO
      $item = null;
      $valor = null;
      $orden = "id";

      $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor, $orden);
      
      $cantidadEscribanos = count($escribanos);

      $cant=0;
      foreach ($escribanos as $key => $value) {
      # code...
          
       $tabla = "escribanos";
       $datos =array("id"=>$value["id"],
                     "nombre"=>strtoupper($value["nombre"]),
                     "documento"=>$value["documento"],
                     "id_tipo_iva"=>$value["id_tipo_iva"],
                     "tipo"=>$value["tipo"],
                     "facturacion"=>$value["facturacion"],
                     "tipo_factura"=>$value["tipo_factura"],
                     "cuit"=>$value["cuit"],
                     "direccion"=>strtoupper($value["direccion"]),
                     "localidad"=>strtoupper($value["localidad"]),
                     "telefono"=>$value["telefono"],
                     "email"=>strtoupper($value["email"]),
                     "id_categoria"=>$value["id_categoria"],
                     "id_escribano_relacionado"=>$value["id_escribano_relacionado"],
                     "id_osde"=>$value["id_osde"],
                     "ultimolibrocomprado"=>strtoupper($value["ultimolibrocomprado"]),
                     "ultimolibrodevuelto"=>strtoupper($value["ultimolibrodevuelto"]),
                     "apellido_ws"=>$value["apellido_ws"],
                     "nombre_ws"=>$value["nombre_ws"],
                     "matricula_ws"=>$value["matricula_ws"],
                     "inhabilitado"=>$value["inhabilitado"]);

        $cant ++;

       #registramos los productos
       $respuesta = ModeloEnlace::mdlIngresarEscribano($tabla, $datos);
      }
      /*===========================================
      =     CONSULTAR SI EXISTEN MODIFICACIONES   =
       ===========================================*/
      $tabla ="modificaciones"; 
      $datos = array("nombre"=>"escribanos","fecha"=>date("Y-m-d"));
      $modificaciones = ModeloEnlace::mdlConsultarModificaciones($tabla,$datos);
      
      if(!$modificaciones[0]>=1){ 

       //SI NO EXISTE CREO UNA NUEVA FILA
       $datos = array("nombre"=>"escribanos","fecha"=>date("Y-m-d"));
       ControladorEnlace::ctrSubirModificaciones($datos);

      }else{

       //SI EXISTE ACTUALIZO A CERO 
       $datos = array("nombre"=>"escribanos","fecha"=>date("Y-m-d"));
       ControladorEnlace::ctrUpdateModificaciones($datos);

      }
  }


  /*=============================================
  MOSTRAR ESCRIBANOS
  =============================================*/ 
  public function ajaxMostrarEscribanos(){

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
               <th>Nombre</th>
               <th>Telefono</th>
               <th>Estado</th>
               <th>WService</th>

             </tr> 

            </thead>

            <tbody>';

       

          $item = null;
          $valor = null;

          $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

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

                    <td class="text-uppercase">'.$value["nombre"].'</td>
                    <td class="text-uppercase">'.$value["telefono"].'</td>';

                    if($value["inhabilitado"]==0){

                      echo '<td class="text-uppercase">HABILITADO</td>';

                    }else{

                      echo '<td class="text-uppercase">INHABILITADO</td>';
                    }
                    
                    if ($value["inhabilitado"] ==0){
                      
                      echo '<td class="text-uppercase"><button class="btn btn-success" onclick=alert("'.$datos.'") >Estado WService</button></td>';
                   
                    }else{

                      echo '<td class="text-uppercase"><button class="btn btn-danger" onclick=alert("'.$datos.'") >Estado WService</button></td>';

                    }

                  echo '</tr>';
          }

        
        echo'
        </tbody>

       </table>';

     }

}

/*=============================================
EDITAR CATEGORÍA
=============================================*/ 
if(isset($_POST["upEscribanos"])){

  $productos = new AjaxUpdateEscribanos();
  $productos -> ajaxActualizarEscribanos();
}

if(isset($_POST["mostrarEscribanos"])){

  $productos = new AjaxUpdateEscribanos();
  $productos -> ajaxMostrarEscribanos();
}
