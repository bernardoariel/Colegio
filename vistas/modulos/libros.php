
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar libros
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar escribanos</li>
    
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
           <th>Nombre</th>
           <th>Direccion</th>
           <th>Localidad</th>
           <th>Ultimo Libro</th>
           <th>Libro Devuelto</th>
           <th>En Escribania</th>
         
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

          foreach ($escribanos as $key => $value) {
            
            $item = "id";
            $valor = $value["id_categoria"];
            $libros = $value["ultimolibrocomprado"] - $value["ultimolibrodevuelto"];
            $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$categorias["categoria"].'</td>

                    <td>'.$value["localidad"].'</td>

                    <td>'.$value["ultimolibrocomprado"].'</td>

                    <td>'.$value["ultimolibrodevuelto"].'</td>

                    <td>'.$libros.'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarLibro" data-toggle="modal" data-target="#modalEditarLibros" idEscribano="'.$value["id"].'"><i class="fa fa-pencil"></i> Editar</button>';

                      

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

<div id="modalEditarLibros" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Cantidad de Libros</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <label for="">Nombre de Escribano</label>
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editarNombreEscribano" id="editarNombreEscribano" readonly>

                 <input type="hidden"  name="editarIdEscribano" id="editarIdEscribano" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <label for="">Ultimo Libro Comprado</label>

              <div class="input-group">
              
                <span class="input-group-addon"><i class="glyphicon glyphicon-chevron-up"></i></span> 

                <input type="text" class="form-control input-lg" name="editarUltimoLibroComprado" id="editarUltimoLibroComprado" required>

              </div>

            </div>
            
             <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">

              <label for="">Ultimo Libro Devuelto</label>
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="glyphicon glyphicon-chevron-down"></i></span> 

                <input type="text" class="form-control input-lg" name="editarUltimoLibroDevuelto" id="editarUltimoLibroDevuelto" required>

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

          $editarLibros = new ControladorParametros();
          $editarLibros -> ctrEditarLibro();

        ?> 

      </form>

    </div>

  </div>

</div>