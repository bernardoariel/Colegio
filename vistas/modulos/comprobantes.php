<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar comprobantes
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar comprobantes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarComprobante">
          
          Agregar Comprobante

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>nombre</th>
           <th>Ultimo numero</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $categorias = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);

          foreach ($categorias as $key => $value) {
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase">'.$value["nombre"].'</td>';
            
             echo   '<td class="text-uppercase">'.$value["numero"].'</td>';
           
             echo      '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarComprobante" idComprobante="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarComprobante"><i class="fa fa-pencil"></i></button>';

                       

             echo '<button class="btn btn-danger btnEliminarComprobante" idComprobante="'.$value["id"].'"><i class="fa fa-times"></i></button></div>  

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
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarComprobante" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar comprobante</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoComprobante" id="nuevoComprobante" placeholder="Ingresar comprobante" required>

              </div>

            </div>

             <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoNumeroComprobante" placeholder="Ingresar numero" required>

              </div>

            </div>
  
          </div>

        </div>
        
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Comprobante</button>

        </div>

        <?php

          $crearComprobante = new ControladorComprobantes();
          $crearComprobante -> ctrCrearComprobante();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarComprobante" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar comprobante</h4>

        </div>
        
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                
                <input type="hidden" id="idComprobante" name="idComprobante">
                
                <input type="text" class="form-control input-lg" name="editarComprobante" id="editarComprobante" placeholder="Ingresar comprobante" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="editarNumeroComprobante" id="editarNumeroComprobante" placeholder="Ingresar numero" required>

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

          $editarComprobante = new ControladorComprobantes();
          $editarComprobante -> ctrEditarComprobante();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarComprobantes = new ControladorComprobantes();
  $borrarComprobantes -> ctrBorrarComprobante();
 
?>


