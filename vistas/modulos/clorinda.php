 <?php
  $botonDescarga = '';
  // FECHA DEL DIA DE HOY
  $fecha=date('Y-m-d');

  $item = "fecha";
         
  if (isset($_GET['fecha'])){

    $fechaMueva = explode("-", $_GET['fecha']);

    $valor = $fechaMueva[2]."-".$fechaMueva[1]."-".$fechaMueva[0];

    $ventasClorinda = ControladorEnlace::ctrMostrarVentasFechaClorinda($item, $valor);
    
  }else if(isset($_GET['fechaInicial'])){

   // $fechaMueva1 = explode("-",$_GET['fechaInicial']);
   $fechaInicial =$_GET['fechaInicial'];//$fechaMueva1[2]."-".$fechaMueva1[1]."-".$fechaMueva1[0];

   // $fechaMueva2 = explode("-",$_GET['fechaFinal']);
   $fechaFinal = $_GET['fechaFinal'];//$fechaMueva2[2]."-".$fechaMueva2[1]."-".$fechaMueva2[0];

   $ventasClorinda = ControladorEnlace::ctrRangoFechasEnlace("clorinda",$fechaInicial, $fechaFinal);

   $botonDescarga = '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'&ruta='.$_GET["ruta"].'"><button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button></a>';

  }else{
    
   $valor= date('Y-m-d');
   $ventasClorinda = ControladorEnlace::ctrMostrarVentasFechaClorinda($item, $valor);
  
  }
  
  
  
?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1 style="color:red;">
      
      Ventas de Clorinda de <?php echo $valor;?>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box cajaPrincipal">

      <div class="box-header with-border">
      
      <div class="col-lg-2">

        <div class="input-group date">
                   
          <div class="input-group-addon">
            
            <i class="fa fa-calendar"></i>
          
          </div>

          <input type="text" class="form-control pull-right" id="datapicker" name="fecha" data-date-format="dd-mm-yyyy" value="<?php echo $valor; ?>">

        </div>

      </div>
      <div class="col-lg-1">

        <button class="btn btn-primary" id="bsqlClorinda">Buscar</button>

      </div>

      <div class="col-lg-1 pull-left">

        <button class="btn btn-info" id="imprimirClorinda" fecha="<?php echo $valor; ?>"><i class="fa fa-print"></i></button>

      </div>
      
      <?php

      echo $botonDescarga;
      ?>
      <button type="button" class="btn btn-default pull-right" id="daterange-btn-clorinda">
           <span>
             <i class="fa fa-calendar"></i> Rango de Fecha
           </span>
           
           <i class="fa fa-caret-down"></i>
         </button>
         
    </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th style="width:45px">Fecha</th>
           <th style="width:35px">Tipo</th>
           <th>Nro. Factura</th>
           <th>Escribano</th>
          <!--  <th>Vendedor</th> -->
           <th>Forma de pago</th>
           <th style="width:50px">Total</th> 
           <th style="width:50px">Adeuda</th>
           
           <th style="width:140px">Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

       
          foreach ($ventasClorinda as $key => $value) {

           
               echo '<tr>

                      <td>'.($key+1).'</td>

                      <td>'.$value["fecha"].'</td>

                      <td>'.$value["tipo"].'</td>

                      <td>'.$value["codigo"].'</td>';



                      // $itemCliente = "id";
                      // $valorCliente = $value["id_cliente"];

                      // $respuestaCliente = ControladorEscribanos::ctrMostrarEscribanos($itemCliente, $valorCliente);

                      echo '<td>'.$value["nombre"].'</td>';

                      
                      echo '<td>'.$value["metodo_pago"].'</td>

                              

                              <td>$ '.number_format($value["total"],2).'</td>';
                             
                              if ($value["adeuda"]==0){

                                echo '<td style="color:green">$ '.number_format($value["adeuda"],2).'</td>';

                              }else{

                                echo '<td style="color:red">$ '.number_format($value["adeuda"],2).'</td>';

                              }
                              

                    echo '

                              <td>

                                <div class="btn-group">

                                  <button class="btn btn-info btnVerVentaClorinda" idVenta="'.$value["id"].'" codigo="'.$value["codigo"].'" title="ver la factura" data-toggle="modal" data-target="#modalVerArticulos"><i class="fa fa-eye"></i></button>';

                                  // if ($value["adeuda"]==0 && $value["total"]<>0){

                                  //   echo '<button class="btn btn-default"><i class="fa fa-money"></i></button>';

                                  // }else{

                                  //   echo '<button class="btn btn-danger btnEditarPago" idVenta="'.$value["id"].'" data-toggle="modal" data-target="#modalAgregarPago"><i class="fa fa-money"></i></button>';

                                  // }

                    // echo '        <button class="btn btn-danger btnVerVenta-Eliminar" idVenta="'.$value["id"].'" data-toggle="modal" data-target="#modalEliminar"><i class="fa fa-times"></i></button>';
                         // btnEliminarVenta

                      echo '</div>  

                      </td>

                    </tr>';
                // }
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();


      $eliminarPago = new ControladorVentas();
      $eliminarPago -> ctrEliminarPago();

      ?>
       

      </div>

    </div>

  </section>

</div>

<!--=====================================
      VER ARTICULOS
======================================-->

<div id="modalVerArticulos" class="modal fade" role="dialog">

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
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="verEscribano" id="verEscribano" placeholder="Ingresar Pago" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-usd"></i></span> 

                <input type="text" class="form-control input-lg" name="verTotalFc" id="verTotalFc" placeholder="Ingresar Pago" readonly>

              </div>

            </div>

            
            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <table class="table table-bordered tablaProductosVendidos">

                  <thead style="background:#3c8dbc; color:white">

                      <tr>

                        <th style="width: 10px;">Cant.</th>

                        <th style="width: 500px;">Articulo</th>

                        <th style="width: 150px;">Folio 1</th>

                        <th style="width: 150px;">Folio 2</th>

                        <th style="width: 200px;">Total</th>

                      </tr>

                  </thead>    

                  <tbody class="tablaArticulosVer"></tbody>

              </table>

              </div>

            </div>
            



          </div>

        </div>
      
       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer finFactura">

          <button type="button" class="btn btn-info pull-left" data-dismiss="modal" id="imprimirItems" codigo="<?php echo $value["codigo"];?>">Imprimir Factura</button>
          <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Salir</button>

        </div>

      </form>

       


    </div>

  </div>
</div>


<!--=====================================
      AGREGAR PAGO
======================================-->

<div id="modalAgregarPago" class="modal fade" role="dialog">

  <div class="modal-dialog">
    
    <div class="modal-content">

      <form role="form" method="post">
      
        <div class="modal-header" style="background:#3E4551; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Metodo Pago</h4>

        </div>

        <div class="modal-body">

            <input type="hidden" id="idVentaPago" name="idVentaPago" value="13"> 
            <input type="hidden" id="totalVentaPago" name="totalVentaPago" value="13">
            <label for="pago">PAGO</label>

            <select class="form-control" id='listaMetodoPago' name='listaMetodoPago'>
              
              <option value="EFECTIVO" selected>EFECTIVO</option>
              <option value="TARJETA">TARJETA</option>
              <option value="TRANSFERENCIA">TRANSFERENCIA</option>
              <option value="CHEQUE">CHEQUE</option>
             
            </select>

            <label for="nuevaReferencia">REFERENCIA</label>

            <input type="text" class="form-control" placeholder="REFERENCIA...." id='nuevaReferencia' name='nuevaReferencia' value='EFECTIVO' autocomplete="off">        
       

        </div><!-- Modal body-->

        <div class="modal-footer">

          <button type="submit" class="btn btn-danger">Realizar Pago</button>
   
        </div>

        <?php

          $realizarPago = new ControladorVentas();
          $realizarPago -> ctrRealizarPagoVenta();

        ?>


      </form>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->
            
</div><!-- Modal face-->

<!--=====================================
      VER ARTICULOS
======================================-->

<div id="modalEliminar" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <form role="form" method="post">
      
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#ff4444; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Factura para Eliminar</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

           <div class="col-lg-3">

             <img src="vistas/img/usuarios/default/admin.jpg" class="user-image" width="100px">

           </div> 
            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="col-lg-9">

              <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                  <input type="text" class="form-control input-lg" name="usuario" id="usuario" value="ADMIN"  readonly>

                  <input type="hidden" name="pagina" value="ventas">

                </div>

              </div>

            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
              <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                  <input type="password" class="form-control input-lg" name="password" id="password" placeholder="Ingresar Clave" required>

                </div>

              </div>
          </div>
            
            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <table class="table table-bordered tablaProductosVendidos">

                  <thead style="background:#3c8dbc; color:white">

                      <tr>

                        <th style="width: 10px;">Cant.</th>

                        <th style="width: 500px;">Articulo</th>

                        <th style="width: 150px;">Folio 1</th>

                        <th style="width: 150px;">Folio 2</th>

                        <th style="width: 200px;">Total</th>

                      </tr>

                  </thead>    

                  <tbody class="tablaArticulosVer"></tbody>

              </table>

              </div>

            </div>
            



          </div>

        </div>
      
       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer finFactura">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="eliminarFactura" codigo="<?php echo $value["codigo"];?>">Eliminar Factura</button>
          <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Salir</button>

        </div>

      </form>

       <?php

          $realizarPago = new ControladorVentas();
          $realizarPago -> ctrEliminarVenta();

        ?>


    </div>

  </div>
</div>
