
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box cajaPrincipal box-danger">

      <div class="box-header with-border">
  
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>id</th>
           <th>tabla</th>
           <th>tipo</th>
           <th>fecha</th>
           <th>Usuario</th>
          
           
           <th style="width:140px">Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;
          $respuesta = ControladorParametros::ctrMostrarBackUp($item, $valor);
         
          foreach ($respuesta as $key => $value) {

            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value['id'].'</td>
                    <td>'.$value['tabla'].'</td>
                    <td>'.$value['tipo'].'</td>
                    <td>'.$value['fechacreacion'].'</td>
                    <td>'.$value['usuario'].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-info btnVerBackupEliminacion" idbackup="'.$value["id"].'" title="ver detalle" data-toggle="modal" data-target="#modalVerBackUp"><i class="fa fa-eye"></i></button>
                        </button>
                      </div>
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
      VER ARTICULOS
======================================-->

<div id="modalVerBackUp" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <form role="form" method="post">
      
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Ver Articulos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            
            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="bkFecha" id="bkFecha"readonly>

                <input type="hidden" id="idBackUp" name="idBackUp">

              </div>

            </div>

            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-database"></i></span> 

                <input type="text" class="form-control input-lg" name="bkTabla" id="bkTabla" readonly>

              </div>

            </div>

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" name="bkTipo" id="bkTipo" readonly>

              </div>

            </div>
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="bkUsuario" id="bkUsuario" readonly>

              </div>

            </div>
            
            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group" >
              
              <div class="input-group">
              
                <table class="table table-bordered tablaProductosVendidos">

                  <thead style="background:#3c8dbc; color:white">

                      <tr>

                        <th>Campo</th>

                        <th>Valor</th>

                      </tr>

                  </thead>    

                  <tbody id="verItems"></tbody>

              </table>

              </div>

            </div>
            



          </div>

        </div>
      
       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer" id="finalFooterRestaurar">

          
          <!--  -->
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Salir</button>

        </div>

      </form>
        
        <?php

          $restaurarBackup = new ControladorParametros();
          $restaurarBackup -> ctrRestaurarBackup();

        ?>
    </div>

  </div>
</div>


<?php

  $eliminarBackup = new ControladorParametros();
  $eliminarBackup -> ctrEliminarBackup();

?>