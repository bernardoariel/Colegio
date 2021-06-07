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

    <div class="box cajaPrincipal">

      <div class="box-header with-border">
  
        <a href="crear-venta">

          <button class="btn btn-primary">
            
            Agregar venta

          </button>

        </a>

         <button type="button" class="btn btn-default pull-right" id="daterange-btn">
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
           <th style="width:30px">Tipo</th>
           <th style="width:90px">Nro. Factura</th>
           <th>Nombre</th>
           <th>Documento</th>
           <th>Forma de pago</th>
           <th>Total</th> 
           <th>Obs</th> 
           <th style="width:140px">Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $respuesta = ControladorVentas::ctrRangoFechasVentas2($fechaInicial, $fechaFinal);
          
          foreach ($respuesta as $key => $value) {
           
               echo '<tr>

                      <td>'.($key+1).'</td>

                      <td>'.$value["fecha"].'</td>

                      <td>'.$value["tipo"].'</td>';

                      $itemCliente = "id";
                      $valorCliente = $value["id_cliente"];

                      $respuestaCliente = ControladorEscribanos::ctrMostrarEscribanos($itemCliente, $valorCliente);

                      if($value["codigo"]=='SIN HOMOLOGAR'){

                        echo '<td><center><button class="btn btn-danger btnHomologarAfip" title="aprobacioAfip" data-toggle="modal" data-target="#modalPrepararAfip" idVenta="'.$value["id"].'" documentoHomologacion="'.$value["documento"].'" nombreHomologacion="'.$value["nombre"].'" totalHomologacion="'.$value["total"].'" idCliente="'.$value["id_cliente"].'">'.$value["codigo"].' - COD:'.$value["id"].'</button></center></td>';

                        if (strlen($value["nombre"])==0){
                          echo '<td style=color:red>ERROR -- AVISAR AL PROGRAMADOR </td>';
                        }else{
                          echo '<td>'.$value["nombre"].'</td>';
                        }



                      }else{

                        echo '<td><center>'.$value["codigo"].'</center></td>';
                        
                        if (strlen($value["nombre"])==0){
                          echo '<td style=color:red>ERROR -- AVISAR AL PROGRAMADOR </td>';
                        }else{
                          echo '<td>'.$value["nombre"].'</td>';
                        }
                        
                      }

                      echo '<td>'.$value["documento"].'</td>';

                      

                      
                      echo '<td>'.$value["metodo_pago"].'</td>';

                              

                             // <td>$ '.number_format($value["total"],2).'</td>';
                             
                           /*   if ($value["adeuda"]==0){

                                echo '<td style="color:green">$ '.number_format($value["adeuda"],2).'</td>';

                              }else{

                                echo '<td style="color:red">$ '.number_format($value["adeuda"],2).'</td>';

                              }*/
                                                   
                      if ($value["adeuda"]==0){

                        echo ' <td style="color:green"><strong>$ '.number_format($value["total"],2).'</strong></td>';
                        // <td style="color:green">$ '.number_format($value["adeuda"],2).'</td>';

                      }else{

                        echo ' <td style="color:red"><strong>$ '.number_format($value["total"],2).'</strong></td>';
                        // echo '<td style="color:red">$ '.number_format($value["adeuda"],2).'</td>';

                      }
                    echo '<td>'.$value["observaciones"].'</td>';          

                    echo '<td>
                            <div class="btn-group">
                              <button class="btn btn-info btnVerVenta" idVenta="'.$value["id"].'" codigo="'.$value["codigo"].'" title="ver la factura" data-toggle="modal" data-target="#modalVerArticulos"><i class="fa fa-eye"></i></button>';
                    
                    if ($value["cae"]!=''){   
                         
                        echo '<button class="btn btn-danger btnImprimirFactura" idVenta="'.$value["id"].'" total="'.$value["total"].'" adeuda="'.$value["adeuda"].'" codigoVenta="'.$value["codigo"].'"><i class="fa fa-file-pdf-o"></i></button>';
                        
                        if($_SESSION['perfil']=="SuperAdmin"){
                          
                          if($value["tipo"]<>"NC" && $value["observaciones"]==""){

                            #PARA HACER LA NOTA DE CREDITO
                            echo '<button class="btn btn-warning btnImprimirNC" idVenta="'.$value["id"].'" total="'.$value["total"].'" adeuda="'.$value["adeuda"].'" codigoVenta="'.$value["codigo"].'" title="hacer Nota de Credito" data-toggle="modal" data-target="#modalVerNotaCredito" ><i class="fa fa-file-pdf-o"></i></button>';

                          }
                         
                        }

                     }else{

                      echo '<button class="btn btn-primary btnImprimirFacturaSinHomolgar" idVenta="'.$value["id"].'"><i class="fa fa-print"></i></button>';
                     }

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

          <button type="button" class="btn btn-info pull-left" data-dismiss="modal" id="imprimirItems" codigo="<?php echo $value["id"];?>">aaaa Factura</button>
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

<div id="modalLoader" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
  
  <div class="modal-dialog">

    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

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
            <center>
              <img src="vistas/img/afip/afip.jpg" alt="">
            </center>
  
          </div>  

        </div>

        <div class="modal-footer">

          <p><strong>CONECTANDOSE AL SERVIDOR DE AFIP</strong></p>

        </div>
        
       

        

     

    </div>

  </div>

</div>

<!--=====================================
      PREPARAR AFIP
======================================-->

<div id="modalPrepararAfip" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <form role="form" method="post" name="frmHomologacionlogacion">
      
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#ff4444; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Preparar Homologacion Afip</h4>

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
                
                <input type="hidden" id="idVentaHomologacion" name="idVentaHomologacion">

                <input type="hidden" id="idDocumentoHomologacion" name="idDocumentoHomologacion">

                <input type="hidden" id="idClienteHomologacion" name="idClienteHomologacion">

                <input type="text" class="form-control input-lg" name="verEscribanoHomologacion" id="verEscribanoHomologacion" placeholder="Ingresar Pago" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-usd"></i></span> 

                <input type="text" class="form-control input-lg" name="verTotalFcHomologacion" id="verTotalFcHomologacion" placeholder="Ingresar Pago" readonly>

              </div>

            </div>

            
            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <table class="table table-bordered tablaProductosVendidos">

                  <thead style="background:#ef5350; color:white">

                      <tr>

                        <th style="width: 10px;">Cant.</th>

                        <th style="width: 500px;">Articulo</th>

                        <th style="width: 150px;">Folio 1</th>

                        <th style="width: 150px;">Folio 2</th>

                        <th style="width: 200px;">Total</th>

                      </tr>

                  </thead>    

                  <tbody class="tablaArticulosVerHomologacion"></tbody>

              </table>

              </div>

            </div>
            



          </div>

        </div>
      
       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

         <button type="button" class="btn btn-danger" id="btnHomologacion" data-dismiss="modal">Confirmar Homologacion</button>

        </div>

      </form>


    </div>

  </div>
</div>

<!--=====================================
      HACER UNA NOTA DE CREDITO
======================================-->

<div id="modalVerNotaCredito" class="modal fade" role="dialog">

  <div class="modal-dialog">
    
    <div class="modal-content">

      <form role="form" method="post">
      
        <div class="modal-header" style="background:#FF8800; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Hacer nota de Credito</h4>

        </div>

        <div class="modal-body">
          
          <div class="box-body">

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <!-- ENTRADA PARA EL NOMBRE -->
                
                <input type="hidden" id="idClienteNc" name="idClienteNc">
                <input type="hidden" id="idVentaNc" name="idVentaNc">
                <input type="hidden" id="nroFactura" name="nroFactura">
                <input type="text" class="form-control input-lg" name="nombreClienteNc" id="nombreClienteNc" placeholder="Ingresar Nombre" style="text-transform:uppercase; " readonly>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="hidden" id="tablaNc" name="tablaNc">
                <input type="hidden" id="productosNc" name="productosNc">

                <input type="number" class="form-control input-lg" name="documentoNc" id="documentoNc" placeholder="Ingresar Documento" readonly>

              </div>

            </div>

            
            
            <!-- ENTRADA PARA EL TOTAL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-usd"></i></span> 

                <input type="text" class="form-control input-lg" name="totalNc" id="totalNc" placeholder="Ingresar Total NC" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA EL IMPORTE FACTURA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <table class="table table-bordered tablaProductosVendidosNc">

                  <thead style="background:#ffbb33; color:white">

                      <tr>

                        <th style="width: 10px;">Cant.</th>

                        <th style="width: 500px;">Articulo</th>

                        <th style="width: 150px;">Folio 1</th>

                        <th style="width: 150px;">Folio 2</th>

                        <th style="width: 200px;">Total</th>

                      </tr>

                  </thead>    

                  <tbody class="tablaArticulosVerNc"></tbody>

              </table>

              </div>

            </div>
          
           
           
  
          </div>  
                 
       

        </div><!-- Modal body-->

        <div class="modal-footer">

          <button type="button" id="realizarNc" class="btn btn-danger" data-dismiss="modal">Realizar NC</button>
   
        </div>

        

      </form>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->
            
</div><!-- Modal face-->