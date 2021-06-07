<?php
   // FECHA DEL DIA DE HOY
  $fecha=date('Y-m-d');
?>
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
    
    <div class="col-lg-8">

      <div class="box box-primary cajaPrincipal">

        <div class="box-body">
        
          <div class="col-lg-8">

          <?php

          $item = null;
          $valor = null;
          $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

          if(isset($_GET["tipo"])){

            

            if($_GET['tipo']=="ventas"){

                $labelBtn ="CUOTAS";

                $tipo = "cuotas";

              }else{

                $labelBtn ="VENTAS";

                $tipo = "ventas";

              }

          }else{

             $tipo = "ventas";

             $labelBtn ="CUOTAS";

          }

          ?>

            <select name="selectescribanos" id="selectescribanos" class="form-control">
            
            <?php
            
                $bnd=0;

                foreach ($escribanos as $key => $value) {

                  if(isset($_GET["idEscribano"])){

                    if ($_GET["idEscribano"]==$value['id']){

                      echo '<option value="'.$value['id'].'" selected>'.$value['nombre'].'</option>';

                    }else{

                      echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                    }
                    

                  }else{

                    if ($bnd==0){
                      
                      echo '<option value="0" selected>SIN ESCRIBANO</option>';
                      $bnd=1;

                    }

                    echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                  }

                }
            ?>

            </select>

        </div>

        <div class="col-lg-4">
          
          <?php

            if(isset($_GET["idEscribano"])){

              echo '<button class="btn btn-warning" id="btnVerCuotas" idEscribano="'.$_GET['idEscribano'].'" valor="'.$tipo.'">'.$labelBtn.'</button>';

            }else{

              echo '<button class="btn btn-warning" id="btnVerCuotas" valor="'.$tipo.'">'.$labelBtn.'</button>';

            }


          ?>
          

        </div>

        <br>
        
        <div class="col-lg-12">
          
          <table class="table table-bordered table-striped dt-responsive tablas"  width="100%">

           <?php
           
            if(isset($_GET["idEscribano"])){

              $item = "id_cliente";
              $valor = $_GET["idEscribano"];

              if($_GET['tipo']=="ventas"){

                ?>
            <thead>
           
             <tr>
               
               <th style="width:10px">#</th>
               <th style="width:45px">Fecha</th>
               <th style="width:35px">Tipo</th>
               <th>Nro. Factura</th>
               <th>Escribano</th>
               <th>Forma de pago</th>
               <th>Detalle de pago</th>
               <th>Total</th> 
               <th>Acciones</th>

             </tr> 

            </thead>

            <tbody id="tablaHistorica">

            <?php

                $respuesta = ControladorVentas::ctrMostrarVentasClientes($item, $valor);

                foreach ($respuesta as $key => $value) {
                      # code...

                      echo '<tr>'.

                              '<td>1</td>'.

                              '<td>'.$value['fecha'].'</td>'.

                              '<td>'.$value['tipo'].'</td>'.

                              '<td>'.$value['codigo'].'</td>'.

                              '<td>ESCRIBANO</td>'.

                              '<td>'.$value['metodo_pago'].'</td>'.

                              '<td>'.$value['referenciapago'].'</td>'.

                              '<td>'.$value['total'].'</td>'.



                              '<td>

                                <div class="btn-group">
                                    <button class="btn btn-info btnVerVenta" idVenta="'.$value["id"].'" codigo="'.$value["codigo"].'" title="ver la factura" data-toggle="modal" data-target="#modalVerArticulos"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-danger btnImprimirFactura" idVenta="'.$value["id"].'" total="'.$value["total"].'" adeuda="'.$value["adeuda"].'" codigoVenta="'.$value["codigo"].'"><i class="fa fa-file-pdf-o"></i></button>
                                </div>

                              </td>'.

                            '</tr>';
                    }

                  }else{

                    $respuesta = ControladorCuotas::ctrMostrarCuotasEscribano($item, $valor);

                  ?>
                  <thead>
           
                   <tr>
                     
                     <th style="width:10px">#</th>
                     <th>Fecha</th>
                     <th>Tipo</th>
                     <th>Nombre</th>
                     <th>Total</th> 
                     <th>Acciones</th>

                   </tr> 

                </thead>

                <tbody>

                <?php

                foreach ($respuesta as $key => $value) {
             
             echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["fecha"].'</td>

                    <td>'.$value["tipo"].'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>$ '.number_format($value["total"],2).'</td>';

                  echo '

                    <td>

                      <div class="btn-group">';

                        echo '<button class="btn btn-info btnVerVenta" idVenta="'.$value["id"].'" title="ver la factura" data-toggle="modal" data-target="#modalVerArticulos" title="Ver articulos de esta Factura"><i class="fa fa-eye"></i></button>';
                            
                        

                      
                        echo '<button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'" title="ver la factura" idVenta="'.$value["id"].'" title="Editar la Venta"><i class="fa fa-pencil"></i></button>';

                   echo '</div>  

                    </td>

                  </tr>';
              }

                  }

              }
           
          ?>
                 
          </tbody>

         </table>
        
        </div>  
      
       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();


      $eliminarPago = new ControladorVentas();
      $eliminarPago -> ctrEliminarPago();

      ?>
       

      

    </div>

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
