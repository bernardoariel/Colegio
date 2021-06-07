<?php 
include("bibliotecas/fechas.inicio.php");
include("bibliotecas/parametros.inicio.php"); 
include("bibliotecas/caja.inicio.php"); 
include("bibliotecas/paneles-nube.inicio.php"); 
include("bibliotecas/ventas-nube.inicio.php"); 
include("bibliotecas/fechas-cuotas.inicio.php"); 
?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Tablero <?php echo $mesNombre;?>
      
      <small>Panel de Control </small>
      
    </h1>

    <ol class="breadcrumb">
      
       <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Escritorio</li>

    </ol>

  </section>

  <section class="content">
      
    <div class="box-body">

    

     <div class="col-md-4">
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
                <h5 class="description-header" style="color:red;"><button class="btn btn-link" id="btnMostrarInhabilitados"><?php echo count($escribanosInabilitados);?></button></h5>
                <span class="description-text" style="color:red;">INHABILITADOS</span>
                <h3 class="description-header"><button class="btn btn-warning"id="upInhabilitados"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button></h3>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><button class="btn btn-link" id="btnMostrarEscribanos"><?php echo count($escribanos);?></button></h5>
                <span class="description-text">TODOS</span>
                <h3 class="description-header"><button class="btn btn-success"id="upEscribanos"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button></h3>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header"><button class="btn btn-link" id="btnMostrarProductos"><?php echo $productos[0];?></button></h5>
                <span class="description-text">PRODUCTOS</span>
                <h3 class="description-header"><button class="btn btn-danger"id="upProductos"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button></h3>
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
        
    <div class="col-md-5">
      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow">
          <h3 class="widget-user-username">VENTAS</h3>
          <h5 class="widget-user-desc">En las delegaciones</h5>
        </div>

        <a href="crear-venta">

          <div class="widget-user-image">
          
            <img class="img-circle" src="vistas/img/usuarios/admin/colegio.jpg" alt="User Avatar">
          
          </div>

        </a>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?php echo count ($ventasColorado); ?></h5>
                <h6> - </h6>
                <span class="description-text">COLORADO</span>

                <h3 class="description-header"><a href="colorado"><button class="btn btn-success"><i class="fa fa-file-text-o" aria-hidden="true"></i></button></a></h3>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?php echo count($ventas); ?></h5>
                <h6> - </h6>
                <span class="description-text">FORMOSA</span>
                <h3 class="description-header"><a href="ventas"><button class="btn btn-warning"><i class="fa fa-file" aria-hidden="true"></i></button></a></h3>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header"><?php echo count($ventasClorinda); ?></h5>
                <h6> - </h6>
                <span class="description-text">CLORINDA</span>
                <h3 class="description-header"><a href="clorinda"><button class="btn btn-success"><i class="fa fa-file-text-o" aria-hidden="true"></i></button></a></h3>
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
    
    <div class="col-md-3">

      <div class="row">

        <div class="info-box">
          <span class="info-box-icon bg-orange"><i class="fa fa-book"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Máximo de libros </span>
            <span class="info-box-number"><?php echo $libro["valor"]; ?> Libros</span>
          </div>
        
        </div>
        
      </div>

      <div class="row">

        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Máximo de Dias</span>
            <span class="info-box-number"><?php echo $atraso["valor"]; ?> Días</span>
          </div>
        
        </div>
        
      </div>

      <div class="row">

        <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fa  fa-file-pdf-o"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Última Factura</span>
            <span class="info-box-number"><small><?php echo $ultimaVenta["codigo"]." $ ".$ultimaVenta["total"]; ?></small></span>
            <span class="info-box-number"><small><?php echo $ultimaVenta["nombre"]; ?></small></span>
          </div>
        
        </div>
        
      </div>

      
      
    </div>

      <div class="col-md-3">
          <div class="info-box"><a href="cuotas">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text"><strong>CUOTAS/OSDE</strong></span>
              <span class="info-box-number"><?php echo $cantCuotas[0]."/".$cantOsde[0];?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <!-- /.col -->
        <div class="col-md-4">
          <div class="box box-danger">
            
            <!-- /.box-header -->
            <div class="box-body">

              
              <p>Se generaron las <strong>CUOTAS</strong> del mes de <strong><?php echo $cuotas['mes']."/".$cuotas['anio'];?></strong> en la fecha <?php echo $cuotas['fecha'];?></p>
              <p>Se generaron los  <strong>REINTEGROS de OSDE</strong> del mes de <strong><?php echo $osde['mes']."/".$osde['anio'];?></strong> en la fecha <?php echo $osde['fecha'];?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2">
          <div class="box box-warning">
            
            <!-- /.box-header -->
            <div class="box-body">

              <span class="info-box-text"><strong>Inhabilitados</strong></span>
             
           <button class="btn btn-success" id="revisarInabilitados">

                  REVISAR

              </button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      
      
      <div class="col-md-3">
          <div class="info-box pull-right">
            <span class="info-box-icon bg-purple"><i class="fa fa-cloud"></i></span>

            <div class="info-box-content">
             
              <div style="font-size: x-small;"><strong>Facturas Actualizacion: 
                <?php 
                if(!empty($modificacionesFc)){echo $modificacionesFc['fecha'];}else{echo "NULL";}
                 
                ?></strong></div>
               
              <div style="font-size: x-small;"><strong>Cuotas  Actualizacion: <?php 
               if(!empty($modificacionesCuota)){echo $modificacionesCuota['fecha'];}else{echo "NULL";} ?></strong></div>
              <br>
              <button class="btn btn-success" id="actualizarCuota">

                  <i class="fa fa-cloud-upload" aria-hidden="true"> Cuota</i>

              </button>

              <button class="btn btn-warning"id="actualizarFc">

                <i class="fa fa-cloud-upload" aria-hidden="true"> Factura</i>

              </button>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
       

        

     </div>

  </section>
 
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