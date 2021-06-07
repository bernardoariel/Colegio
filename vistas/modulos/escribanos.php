<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar escribanos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar escribanos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEscribano">
          
          Agregar escribano

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Direccion</th>
           <th>Localidad</th>
           <th>Telefono</th>
           <th>Documento</th>
           <th>T.Iva</th>
           <th>Cuit</th>
           <th>Caracter</th>
           <th>Osde</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

          foreach ($escribanos as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["direccion"].'</td>

                    <td>'.$value["localidad"].'</td>

                    <td>'.$value["telefono"].'</td>

                    <td>'.$value["documento"].'</td>';


                    $item = "id";
                    $valor = $value["id_tipo_iva"];

                    $tipoIva = ControladorTipoIva::ctrMostrarTipoIva($item, $valor);
          
          echo     '<td>'.$tipoIva["nombre"].'</td>';
                  
           echo    '<td>'.$value["cuit"].'</td>';

                    

                    $item = "id";
                    $valor = $value["id_categoria"];

                    $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);


          echo      '<td>'.$categorias["categoria"].'</td>';

                    $item = "id";
                    $valor = $value["id_osde"];

                    $osde = ControladorOsde::ctrMostrarOsde($item, $valor);
                    
                    if($osde){

                      echo     '<td>'.$osde["nombre"].' - $'.$osde["importe"].'</td>';

                    }else{

                      echo     '<td>Sin Osde</td>';

                    }
                    

                      // if($osde["importe"]==0){

                      //     echo     '<td>Sin Osde</td>';

                      //   }else{
                      //     echo     '<td>'.$osde["nombre"].' - $'.$osde["importe"].'</td>';}

                 

                    

          

          echo      '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarEscribano" data-toggle="modal" data-target="#modalEditarEscribano" idEscribano="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      // if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarEscribano" idEscribano="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                     // }

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
      AGREGAR ESCRIBANO
======================================-->

<div id="modalAgregarEscribano" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <form role="form" method="post">
      
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar escribano</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            
            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoEscribano" id="nuevoEscribano" placeholder="Ingresar nombre" required>

              </div>

            </div>

                <!-- ENTRADA PARA EL DOCUMENTO ID -->
             <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumento" placeholder="Ingresar documento" required>

              </div>

            </div>

          <!-- ENTRADA CATEGORIA DE ESCRIBANO -->
            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="nuevaIdIva">
                  
                  <option value="">SELECCIONAR TIPO IVA</option>

 
                  <?php 


                  $item = null;
                  $valor = null;

                  $tipoIva = ControladorTipoIva::ctrMostrarTipoIva($item, $valor);

                  foreach ($tipoIva as $key => $value) {
                    
                    # code...
                    echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                  }

                  ?>

                
                </select>

              </div>

            </div>
            <!-- ENTRADA PARA EL CUIT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoCuit" placeholder="Ingresar Cuit" data-inputmask="'mask':'99-99999999-9'" data-mask required>

                

              </div>

            </div>

            

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA LOCALIDAD -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaLocalidad" placeholder="Ingresar localidad" required>

              </div>

            </div>

             <div class="form-group">
              
              <div class="input-group">
                 <!-- ENTRADA PARA EL TELÉFONO -->
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>


              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>

              </div>

            </div>
            
            <!-- ENTRADA CATEGORIA DE ESCRIBANO -->
            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="nuevaCategoriaEscribano">
                  
                  <option value="">SELECCIONAR CATEGORIA ESCRIBANO</option>

                 

                  <?php 


                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    # code...
                    echo '<option value="'.$value['id'].'">'.$value['categoria'].'</option>';

                  }

                  ?>

                
                </select>

              </div>

            </div>

            <!-- ENTRADA ESCRIBANO RELACIONADO -->

            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="nuevoEscribanoRelacionado">

                  <option value="">SELECCIONAR ESCRIBANO RELACIONADO</option>
                  
                  <?php 

                    echo '<option value="0">SIN RELACION</option>';

                    $item = null;
                    $valor = null;

                    $escribanosRelacionado = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

                      foreach ($escribanosRelacionado as $key => $value) {
                        
                        # code...
                        echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                      }

                  ?>
                
                </select>

              </div>

            </div>

             <!-- ENTRADA CATEGORIA OSDE -->

            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="nuevoCategoriaOsde">
                  
                  <option value="">SELECCIONAR OSDE</option>

                  <?php 
                    echo '<option value="0">SIN OSDE</option>';
                    $item = null;
                    $valor = null;

                    $osde = ControladorOsde::ctrMostrarOsde($item, $valor);

                      foreach ($osde as $key => $value) {
                        
                        # code...
                        echo '<option value="'.$value['id'].'">'.$value['nombre'].' - $ '.$value['importe'].'</option>';

                      }

                  ?>

                
                </select>

              </div>

            </div>



          </div>

        </div>
      
       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar ESCRIBANO</button>

        </div>

      </form>

       <?php

         $crearEscribano = new ControladorEscribanos();
         $crearEscribano -> ctrCrearEscribano();

      ?>


    </div>

  </div>
</div>


<!--=====================================
      AGREGAR ESCRIBANO
======================================-->

<div id="modalEditarEscribano" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <form role="form" method="post">
      
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar escribano</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            
            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editarEscribano" id="editarEscribano" placeholder="Ingresar nombre" required>

                <input type="hidden" id="idEscribano" name="idEscribano"> 

              </div>

            </div>

                <!-- ENTRADA PARA EL DOCUMENTO ID -->
             <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="editarDocumento" id="editarDocumento" placeholder="Ingresar documento" required>

              </div>

            </div>
             <!-- ENTRADA CATEGORIA OSDE -->

            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="editarTipoIva" id="editarTipoIva">
                  
                   <option value="">SELECCIONAR TIPO IVA</option>

 
                  <?php 


                  $item = null;
                  $valor = null;

                  $tipoIva = ControladorTipoIva::ctrMostrarTipoIva($item, $valor);

                  foreach ($tipoIva as $key => $value) {
                    
                    # code...
                    echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                  }

                  ?>

                
                </select>

              </div>

            </div>
          
            <!-- ENTRADA PARA EL CUIT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" name="editarCuit" id="editarCuit" placeholder="Ingresar Cuit" data-inputmask="'mask':'99-99999999-9'" data-mask required>

                

              </div>

            </div>

            

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA LOCALIDAD -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="editarLocalidad" id="editarLocalidad" placeholder="Ingresar localidad" required>

              </div>

            </div>

             <div class="form-group">
              
              <div class="input-group">
                 <!-- ENTRADA PARA EL TELÉFONO -->
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>


              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail" placeholder="Ingresar email" required>

              </div>

            </div>
            
            <!-- ENTRADA CATEGORIA DE ESCRIBANO -->
            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="editarCategoriaEscribano" id="editarCategoriaEscribano">
                  
                  <option value="">SELECCIONAR CATEGORIA ESCRIBANO</option>

                 

                 <?php 


                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    # code...
                    echo '<option value="'.$value['id'].'">'.$value['categoria'].'</option>';

                  }
                  
                  ?>

                
                </select>

              </div>

            </div>

            <!-- ENTRADA ESCRIBANO RELACIONADO -->

            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="editarEscribanoRelacionado" id="editarEscribanoRelacionado">

                  <option value="">SELECCIONAR ESCRIBANO RELACIONADO</option>
                  
                  <?php 

                    echo '<option value="0">SIN RELACION</option>';

                    $item = null;
                    $valor = null;

                    $escribanosRelacionado = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

                      foreach ($escribanosRelacionado as $key => $value) {
                        
                        # code...
                        echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                      }

                  ?>
                
                </select>

              </div>

            </div>

            <!-- ENTRADA CATEGORIA OSDE -->

            <div class="form-group">
              
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 

                <select class="form-control input-lg" name="editarCategoriaOsde" id="editarCategoriaOsde">
                  
                  <option value="">SELECCIONAR OSDE</option>

                  <?php 
                    echo '<option value="0">SIN OSDE</option>';
                    $item = null;
                    $valor = null;

                    $osde = ControladorOsde::ctrMostrarOsde($item, $valor);

                      foreach ($osde as $key => $value) {
                        
                        # code...
                        echo '<option value="'.$value['id'].'">'.$value['nombre'].' - $ '.$value['importe'].'</option>';

                      }

                  ?>

                
                </select>

              </div>

            </div>



          </div>

        </div>
      
       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar ESCRIBANO</button>

        </div>

      </form>

       <?php

         $editarEscribano = new ControladorEscribanos();
         $editarEscribano -> ctrEditarEscribano();

      ?>


    </div>

  </div>
</div>

<?php

  $eliminarEscribano = new ControladorEscribanos();
  $eliminarEscribano -> ctrEliminarEscribano();

?>
