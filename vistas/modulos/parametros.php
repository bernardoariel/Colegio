
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Parametros
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Parametros</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
       
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Tipo</th>
           <th>Valor</th>
          
         
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $parametros = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);
         

          foreach ($parametros as $key => $value) {
            
           

            echo '<tr>

                    <td>'.($key+1).'</td>';

            if ($value["parametro"]=="maxLibro"){$tipo="CANTIDAD MAXIMA DE LIBROS";}
            if ($value["parametro"]=="maxAtraso"){$tipo="CANTIDAD MAXIMA DE DIAS DE ATRASO";}

             echo  '<td>'.$tipo.'</td>

                    <td>'.$value["valor"].'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarParametros" data-toggle="modal" data-target="#modalEditarParametro" idParametro="'.$value["id"].'"><i class="fa fa-pencil"></i> Editar</button>';

                      

                      echo '</div>  

                    </td>

                  </tr>';
          
            }

        ?>
   
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarParametro" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edicion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <label for="" id="lbNombre">Nombre de Escribano</label>
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span> 

                <input type="text" class="form-control input-lg" name="editarValor" id="editarValor" requery>

                 <input type="hidden"  name="editarId" id="editarId" required>

              </div>

            </div>

  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      <?php

          $edicion = new ControladorParametros();
          $edicion -> ctrEditarParametros();

        ?> 

      </form>

    </div>

  </div>

</div>