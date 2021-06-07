<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Tablero
      
      <small>Panel de Control</small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Tablero</li>
    
    </ol>

  </section>

  <section class="content">

    <!-- <div class="box box-primary"> -->

    
      
      <div class="box-body">

        <?php 

          $cantInhabilitados =0;
          #SE REVISA A LOS DEUDORES
          $item = null;
          $valor = null;

          $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);
          foreach ($escribanos as $key => $value) {
            # code...
            if($value['inhabilitado'] == 1){
              $cantInhabilitados++;
            }
            
          }
              
          #TRAER PRODUCTOS DEL COLEGIO
          $item = null;
          $valor = null;
          $orden ="id";
          $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);    
          
          /*=============================================
          =              GENERO LA CAJA                =
          =============================================*/
          $item = "fecha";
          $valor = date('Y-m-d');

          $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
          
          if(count($caja)==0){
            
            $datos = array("fecha"=>date('Y-m-d'),
               "efectivo"=>0,
               "tarjeta"=>0,
               "cheque"=>0,
               "transferencia"=>0);
            
            $insertarCaja = ControladorCaja::ctrIngresarCaja($item, $datos);

          }

        ?>

         <div class="col-md-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username">ESCRIBANOS</h3>
              <h5 class="widget-user-desc">Actualizacion en Nube</h5>
            </div>
            <a href="escribanos">

              <div class="widget-user-image">
                <img class="img-circle" src="vistas/img/usuarios/admin/escribanos.jpg" alt="User Avatar">
              </div>
            </a>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header" style="color:red;"><button class="btn btn-link" id="btnMostrarInhabilitados"><?php echo $cantInhabilitados;?></button></h5>
                    <span class="description-text" style="color:red;">INHABILITADOS</span>
                    
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><button class="btn btn-link" id="btnMostrarEscribanos"><?php echo count($escribanos);?></button></h5>
                    <span class="description-text">TODOS</span>
                    
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><button class="btn btn-link" id="btnMostrarProductos"><?php echo count($productos);?></button></h5>
                    <span class="description-text">PRODUCTOS</span>
                    
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php

          /*==========================================
          =            CANTIDAD DE VENTAS            =
          ==========================================*/
          
        $item = "fecha";
        $valor= date('Y-m-d');
        
        $ventas = ControladorVentas::ctrMostrarVentasFecha($item, $valor);

        
          
          // /*=====  End of CANTIDAD DE VENTAS  ======*/
          
        ?>
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <h3 class="widget-user-username">VENTAS</h3>
              <h5 class="widget-user-desc">Formosa</h5>
            </div>

            <a href="crear-venta">

              <div class="widget-user-image">
              
                <img class="img-circle" src="vistas/img/usuarios/admin/colegio.jpg" alt="User Avatar">
              
              </div>

            </a>
            <div class="box-footer">
              <div class="row">
               
                <!-- /.col -->
                <div class="col-sm-12">
                  <div class="description-block">
                    
                   <h5 class="description-header"><?php echo count($ventas); ?></h5>
                    <span class="description-text">FORMOSA</span>

                    
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
    
      
<div id="modalLoader" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
  
  <div class="modal-dialog">

    <div class="modal-content">


      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->

      <div class="modal-header" id="cabezaLoader" style="background:#3c8dbc;color:white">

        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

        <h4 class="modal-title">Aguarde un instante</h4>

      </div>

      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->

      <div class="modal-body">

        <div class="box-body">

          <center>
            <img src="vistas/img/afip/loader.gif" alt="">
          </center>
         
         

        </div>  

      </div>

      <div class="modal-footer">

        <p id="actualizacionparrafo"></p>

      </div>
        

    </div>

  </div>

</div>

<div id="modalMostar" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
  
  <div class="modal-dialog">

    <div class="modal-content">


      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->

      <div class="modal-header" id="cabezaLoader" style="background:#3c8dbc;color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title" id="titulo"></h4>

      </div>

      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->

      <div class="modal-body">

        <div class="box-body" id="mostrarBody">
         

        </div>  

      </div>

      <div class="modal-footer">

        <button type="button" id="mostrarSalir" class="btn btn-danger" data-dismiss="modal">Salir</button>

      </div>
        

    </div>

  </div>

</div>



     </div>

  </section>
 
</div>


