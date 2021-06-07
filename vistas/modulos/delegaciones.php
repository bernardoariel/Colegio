<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Delegaciones
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar delegaciones</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDelegacion">
          
          Agregar Delegacion

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
           <th>P.Venta</th>
           <th>Titular</th>
          
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $clientes = ControladorDelegaciones::ctrMostrarDelegaciones($item, $valor);

          foreach ($clientes as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["direccion"].'</td>

                    <td>'.$value["localidad"].'</td>

                    <td>'.$value["puntodeventa"].'</td>

                    <td>'.$value["escribano"].'</td>';

   
          echo      '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarDelgacion" data-toggle="modal" data-target="#modalEditarDelegacion" idDelegacion="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                          echo '<button class="btn btn-danger btnEliminarDelegacion" idDelegacion="'.$value["id"].'"><i class="fa fa-times"></i></button>';

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

<div id="modalAgregarDelegacion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar los Datos de la Delegacion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                

                <input type="text" class="form-control input-lg" name="nombreNuevoDelegacion" id="nombreNuevoDelegacion" placeholder="Ingresar Delegacion" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DIRECCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="direccionNuevoDelegacion" id="direccionNuevoDelegacion" placeholder="Ingresar Direccion" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL LOCALIDAD -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="localidadNuevoDelegacion" id="localidadNuevoDelegacion" placeholder="Ingresar Localidad" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL Telefono -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="telefonoNuevoDelegacion" id="telefonoNuevoDelegacion" placeholder="Ingresar Telefono" style="text-transform:uppercase; " required>

              </div>

            </div>

             <!-- ENTRADA PARA EL Punto de venta -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-qrcode"></i></span> 

                <input type="text" class="form-control input-lg" name="puntoVentaNuevoDelegacion" id="puntoVentaNuevoDelegacion" placeholder="Ingresar Punto de Venta" style="text-transform:uppercase; "  required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR Escribano -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-male"></i></span> 

                <select class="form-control input-lg" id="escribanoNuevoDelegacion" name="escribanoNuevoDelegacion" style="text-transform:uppercase; " required>
                  
                  <option value="0">Seleccionar Escribano</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.strtoupper($value["id"]).'">'.strtoupper($value["nombre"]).'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>
            
            
           
  
          </div>  

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-danger"  data-dismiss="modal" id="btnDelegacionAgregar">Guardar Cambios</button>

        </div>
        
   
    </div>

  </div>

</div>


<div id="modalEditarDelegacion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar los Datos de la Delegacion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 
                
                <input type="hidden" name="idEditar" id="idEditar">

                <input type="text" class="form-control input-lg" name="nombreEditarDelegacion" id="nombreEditarDelegacion" placeholder="Ingresar Delegacion" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DIRECCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="direccionEditarDelegacion" id="direccionEditarDelegacion" placeholder="Ingresar Direccion" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL LOCALIDAD -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="localidadEditarDelegacion" id="localidadEditarDelegacion" placeholder="Ingresar Localidad" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL Telefono -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="telefonoEditarDelegacion" id="telefonoEditarDelegacion" placeholder="Ingresar Telefono" style="text-transform:uppercase; " required>

              </div>

            </div>

             <!-- ENTRADA PARA EL Punto de venta -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-qrcode"></i></span> 

                <input type="text" class="form-control input-lg" name="puntoVentaEditarDelegacion" id="puntoVentaEditarDelegacion" placeholder="Ingresar Punto de Venta" style="text-transform:uppercase; "  required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR Escribano -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-male"></i></span> 

                <select class="form-control input-lg" id="escribanoEditarDelegacion" name="escribanoEditarDelegacion" style="text-transform:uppercase; " required>
                  
                  <option value="0">Seleccionar Escribano</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.strtoupper($value["id"]).'">'.strtoupper($value["nombre"]).'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>
            
            
           
  
          </div>  

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-danger"  data-dismiss="modal" id="btnDelegacionEditar">Guardar Cambios</button>

        </div>
        
   
    </div>

  </div>

</div>
<?php

  $eliminarDelegacion = new ControladorDelegaciones();
  $eliminarDelegacion -> ctrEliminarDelegacion();

?>
