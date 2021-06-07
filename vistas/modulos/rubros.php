<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar rubros
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar rubros</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarRubro">
          
          Agregar rubros

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Categoria</th>
           <th>Tiene Movimiento?</th>
           <th>Mensual</th>
           <th>Obs</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $rubros = ControladorRubros::ctrMostrarRubros($item, $valor);

          foreach ($rubros as $key => $value) {
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase">'.$value["nombre"].'</td>';
            
            if ($value["movimiento"]==1){

              echo   '<td class="text-uppercase">C/STOCK</td>';

            }else{

              echo   '<td class="text-uppercase">S/STOCK</td>';

            }
             

            if ($value["mensual"]==1){

              echo   '<td class="text-uppercase">NO MENSUAL</td>';

            }else{

              echo   '<td class="text-uppercase">MENSUAL</td>';

            }

           

             echo   '<td class="text-uppercase">'.$value["obs"].'</td>';
           
             echo   '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarRubro" idRubro="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarRubro"><i class="fa fa-pencil"></i></button>';

                       

             echo      '<button class="btn btn-danger btnEliminarRubro" idRubro="'.$value["id"].'"><i class="fa fa-times"></i></button></div>  

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

<div id="modalAgregarRubro" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar rubro</h4>

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

                <input type="text" class="form-control input-lg" name="nuevoRubro" placeholder="Ingresar rubro" required>

              </div>

            </div>
  
          

          <!-- ENTRADA PARA SELECCIONAR EL MOVIMIENTO -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="nuevoMovimiento">
                  
                  <option value="">SELECCIONAR MOVIMIENTO</option>

                   <option value="1">Si, C/STOCK</option>

                  <option value="2">No, S/STOCK</option>

                  

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR MENSUAL -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="nuevoMensual">
                  
                  <option value="">SELECCIONAR TIPO MENSUAL</option>

                  <option value="1">NO ES MENSUAL</option>

                  <option value="2">SI ES MENSUAL</option>

                </select>

              </div>

            </div>

             <!-- ENTRADA PARA EL OBS -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoObs" placeholder="Ingresar Observaciones" required>

              </div>

            </div>

          </div>

        </div>
        
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar rubro</button>

        </div>

        <?php

          $crearRubro = new ControladorRubros();
          $crearRubro -> ctrCrearRubro();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR RUBRO
======================================-->

<div id="modalEditarRubro" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar rubro</h4>

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

                <input type="hidden" name="idRubro" id="idRubro" >

                <input type="text" class="form-control input-lg" name="editarRubro" id="editarRubro" placeholder="Ingresar rubro" required>
                
              </div>

            </div>
  
          

          <!-- ENTRADA PARA SELECCIONAR EL MOVIMIENTO -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="editarMovimiento" id="editarMovimiento">
                  
                  <option value="">SELECCIONAR MOVIMIENTO</option>

                  <option value="1">Si, C/STOCK</option>

                  <option value="2">No, S/STOCK</option>

                  

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR MENSUAL -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="editarMensual" id="editarMensual">
                  
                  <option value="">SELECCIONAR TIPO MENSUAL</option>

                  <option value="1">NO ES MENSUAL</option>

                  <option value="2">SI ES MENSUAL</option>

                </select>

              </div>

            </div>

             <!-- ENTRADA PARA EL OBS -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="editarObs" id="editarObs" placeholder="Ingresar Observaciones" required>

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

          $editarRubro = new ControladorRubros();
          $editarRubro -> ctrEditarRubro();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarRubro = new ControladorRubros();
  $borrarRubro -> ctrBorrarRubro();
 
?>


