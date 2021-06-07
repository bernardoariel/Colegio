<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar clientes
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar clientes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
      <!--   <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEscribano">
          
          Agregar clientes

        </button> -->

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Cuit</th>
           <th>T.Iva</th>
           <th>Direccion</th>
           <th>Localidad</th>
          
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

          foreach ($clientes as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["cuit"].'</td>

                    <td>'.$value["tipoiva"].'</td>

                    <td>'.$value["direccion"].'</td>

                    <td>'.$value["localidad"].'</td>';

   
          echo      '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      // if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>';

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


<div id="modalEditarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar los Datos del Cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="hidden" id="idClienteEditar" name="idClienteEditar">

                <input type="text" class="form-control input-lg" name="nombreEditarCliente" id="nombreEditarCliente" placeholder="Ingresar Nombre" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL CUIT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="number" class="form-control input-lg" name="documentoEditarCliente" id="documentoEditarCliente" placeholder="Ingresar Cuit" required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="tipoCuitEditarCliente" name="tipoCuitEditarCliente" required>
                  
                  <option value="">Selecionar categoría</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorTipoIva::ctrMostrarTipoIva($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.strtoupper($value["nombre"]).'">'.strtoupper($value["nombre"]).'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>
            
            <!-- ENTRADA PARA LA DIRECCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="text" class="form-control input-lg" name="direccionEditarCliente" id="direccionEditarCliente" placeholder="Ingresar Direccion" required>

              </div>

            </div>
          
            <!-- ENTRADA PARA LA LOCALIDAD -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="text" class="form-control input-lg" name="localidadEditarCliente" id="localidadEditarCliente" placeholder="Ingresar Localidad" required>

              </div>

            </div>
           
  
          </div>  

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-danger"  data-dismiss="modal" id="btnGuardarCambios">Guardar Cambios</button>

        </div>
        
   
    </div>

  </div>

</div>

<?php

  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarCliente();

?>
