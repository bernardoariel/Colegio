
<?php
  
  #ELIMINO TODA LA TABLA
  $item = null;
  $valor = null;
  $respuesta = ControladorComprobantes::ctrIniciarItems($item, $valor); 

  $item= "id";
  $valor = $_GET["idVenta"];
  $venta = ControladorCuotas::ctrMostrarCuotas($item,$valor);

  // $itemUsuario = "id";
  // $valorUsuario = $venta["id_vendedor"];

  // $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario,$valorUsuario);

  $itemCliente = "id";
  $valorCliente = $venta["id_cliente"];

  $cliente = ControladorEscribanos::ctrMostrarEscribanos($itemCliente,$valorCliente);

  $itemTipoCliente = "id";
  $valorTipoCliente = $cliente["id_categoria"];

  $tipoCliente = ControladorCategorias::ctrMostrarCategorias($itemTipoCliente,$valorTipoCliente);
  
 //ULTIMO NUMERO DE VENTAS
$item = "nombre";
$valor = "ventas";

$registro = ControladorComprobantes::ctrMostrarComprobantes($item, $valor);
$puntoVenta = $registro["cabezacomprobante"];

// FORMATEO EL NUMERO DE COMPROBANTE
$ultimoComprobanteAprox=$registro["numero"]+1;
$cantRegistro = strlen($ultimoComprobanteAprox);
 
switch ($cantRegistro) {
    case 1:
          $ultimoComprobante="0000000".$ultimoComprobanteAprox;
          break;
    case 2:
          $ultimoComprobante="000000".$ultimoComprobanteAprox;
          break;
      case 3:
          $ultimoComprobante="00000".$ultimoComprobanteAprox;
          break;
      case 4:
          $ultimoComprobante="0000".$ultimoComprobanteAprox;
          break;
      case 5:
          $ultimoComprobante="000".$ultimoComprobanteAprox;
          break;
      case 6:
          $ultimoComprobante="00".$ultimoComprobanteAprox;
          break;
      case 7:
          $ultimoComprobante="0".$ultimoComprobanteAprox;
          break;
      case 8:
          $ultimoComprobante=$ultimoComprobanteAprox;
          break;
  }

$cantCabeza = strlen($puntoVenta); 
switch ($cantCabeza) {
    case 1:
          $ptoVenta="000".$puntoVenta;
          break;
    case 2:
          $ptoVenta="00".$puntoVenta;
          break;
    case 3:
          $ptoVenta="0".$puntoVenta;
          break;   
  }
 
 $codigoFacturaAprox = $ptoVenta .'-'. $ultimoComprobante;

?>
<div class="content-wrapper">


  <section class="content">

    <form method="post" class="formularioVenta" name="frmVentaEditada" id="frmVentaEditada">

    <div class="row">

      <!--=====================================================
                        PANEL IZQUIERDO
        ========================================================-->
        
        <div class="col-md-3" style="margin-top: 10px;">
           
           <div class="panel " >

            <div class="panel-heading" style="background-color: #212121;color:white">

                <h4>Datos del Escribano</h4>

            </div>

           <div class="panel-body" style="background-color: #37474F;color:white">

                <div class="col-xs-12">

                  <label for="nombre">NRO. FC</label>
                  
                  <?php 
                    
                      $registro=$registro;
                      
              

                    ?>
                  <input type="text" class="form-control" id='editarVenta' name='editarVenta' autocomplete="off"  value="<?php echo $codigoFacturaAprox;?>" style="text-align: center;" readonly>
                  
                  <input type='hidden' id='idVendedor' name='idVendedor' value='1'>

                  <input type='hidden' id='idVenta' name='idVenta' value='<?php echo $_GET["idVenta"];?>'>
                  
                  <input type='hidden' id='tipoFc' name='tipoFc' value='<?php echo $venta["tipo"];?>'>

                  
                </div>

               
                <div class="col-xs-12 ">

                  <!-- <label for="nombre">NOMBRE</label> -->

                  <input type='hidden' id='seleccionarCliente' name='seleccionarCliente' value="<?php echo $cliente['id'];?>">

                  <input type="text" class="form-control" placeholder="NOMBRE...." id='nombrecliente' name='nombreCliente' value="<?php echo $cliente['nombre'];?>" autocomplete="off"   readonly  style="margin-top: 5px">
                  
                  <?php 

                    if($cliente['facturacion']=="CUIT"){

                      echo "<input type='hidden' id='documentoCliente' name='documentoCliente'  value=".$cliente['cuit'].">";

                      echo "<input type='hidden' id='tipoDocumento' name='tipoDocumento'  value='CUIT'>";

                    }else{

                      echo "<input type='hidden' id='documentoCliente' name='documentoCliente'  value=". $cliente['documento'].">";

                      echo "<input type='hidden' id='tipoDocumento' name='tipoDocumento'  value='DNI'>";

                    }
                  
                    ?>

                  <input type='hidden' id='tipoCliente' name='tipoCliente'  value="escribanos">

                  <input type='hidden' id='tipoCuota' name='tipoCuota'  value="<?php echo $venta['tipo'];?>">

                </div>
                
                <!-- <div class="col-xs-12">

                    <button type="button" class="btn btn-primary btn-block btnBuscarCliente" data-toggle="modal" data-target="#myModalClientes" style="margin-top: 5px;" autofocus>Buscar Cliente</button>

                </div> -->

                <div class="col-xs-12">

                  <div class="form-group">
                <label>FECHA:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="fecha" data-date-format="dd-mm-yyyy" value="<?php echo $venta["fecha"];?>">
                </div>
                </div>
                  </div>
                  
                
                
               

                <!-- <div class="col-xs-12">

                      <label for="pago">PAGO</label>

                      <select class="form-control" id='listaMetodoPago' name='listaMetodoPago'>
                        
                       <?php

                        echo '<option value="'.$venta['metodo_pago'].'">'.$venta['metodo_pago'].'</option>';

                       ?>
                        <option value="CTA.CORRIENTE">CTA.CORRIENTE</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TARJETA">TARJETA</option>
                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>

                       
                      </select>

                </div> -->

                <!-- <div class="col-xs-12 ">
                  <label for="nuevaReferencia">REFERENCIA</label>

                  <input type="text" class="form-control" placeholder="REFERENCIA...." id='nuevaReferencia' name='nuevaReferencia' value='EFECTIVO' autocomplete="off">

                </div> -->

                  <input type="hidden" id="nuevoPrecioImpuesto" name="nuevoPrecioImpuesto" value="0">
                  <input type="hidden" id="nuevoPrecioNeto" name="nuevoPrecioNeto" value="0">
                  <input type="hidden" id="nuevoTotalVentas" name="nuevoTotalVentas" value="0">


                 <div class="col-xs-12">

                    <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModalProductos" style="margin-top: 5px;">
                      
                      Articulos

                    </button>

                </div>

            </div>

        </div>

  </div>
  
    <!--=====================================================
                        TABLA DE ARTICULOS
        ========================================================-->
        <div class="col-md-9" style="margin-top: 10px;" id="articulosP">
            
            <div class="box  box-primary">

                <div class="box-header box-info"style="background-color: #212121;color:white">

                  <h3 class="box-title">Articulos</h3>

                </div>

              <!-- /.box-header -->
              <div class="box-body no-padding" id="datosTabla">
                
                <table class="table table-bordered tablaProductosVendidos">

                  <thead>

                      <tr>

                        <th style="width: 10px;">#</th>

                        <th style="width: 10px;">Cantidad</th>

                        <th style="width: 500px;">Articulo</th>

                        <th style="width: 150px;">Folio 1</th>

                        <th style="width: 150px;">Folio 2</th>

                        <th style="width: 150px;">Precio</th>

                        <th style="width: 200px;">Total</th>

                        <th style="width: 100px;">Op.</th>

                      </tr>

                  </thead>    

                  <tbody class="tablaProductosSeleccionados">
                    
                    <?php

                    $listaProducto= json_decode($venta["productos"],true);
                    
                    
                    foreach ($listaProducto as $key => $value) {
                     
                     echo '<tr>
                    <td>'.($key + 1) .'</td>
                    <td>

                        
                       <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto"  value="'.$value['cantidad'].'"  readonly>

                    </td>
                    <td>
                    <div>
                          
                          <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value['id'].'" idNroComprobante="'.$value['idnrocomprobante'].'" cantVentaProducto="'.$value['cantventaproducto'].'" name="agregarProducto" value="'.$value['descripcion'].'" readonly required>
                          

                        </div>
                    </td>
                    <td>
                    <div class="input-group">
                          
                         <input type="text" class="form-control nuevoFolio1"  name="folio1"  value="'.$value['folio1'].'" readonly required>   

                       </div>
                    </td>
                    <td>
                    <div class="input-group">

                          <input type="text" class="form-control nuevoFolio2"  name="folio2"  value="'.$value['folio2'].'" readonly required>

                        </div>
                    </td>
                    <td>
                    <div class="input-group">

                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                             
                          <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$value['precio'].'" name="nuevoPrecioProducto" value="'.$value['precio'].'" readonly required>
             
                        </div>
                    </td>
                    <td style="text-align: right;">
                    <div class="input-group">

                          <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                             
                          <input type="text" class="form-control nuevoTotalProducto" precioTotal="'.($value['cantidad']*$value['precio']).'" name="nuevoTotalProducto" value="'.($value['cantidad']*$value['precio']).'" readonly required>
             
                      </div>

                    </td>
                    <td>
                    
                   
                    </td>
                    
                    </tr>';
                    }

                    ?>
                  </tbody>

                  <tfooter>

                      <tr>

                        <td colspan="8"><div class="col-xs-2">Escribano: </div>

                          <strong>

                            <div class="col-xs-3" id="panel3nombrecliente">

                              <?php echo $cliente['nombre']; ?> 

                            </div>

                          </strong>

                          <div class="col-xs-2">Categoria: </div>

                          <strong> 

                            <div class="col-xs-2" id="panel3TipoCLiente">

                              <?php echo $tipoCliente['categoria'];?>

                            </div>

                          </strong>

                        </td>

                      </tr>

                    </tfooter>
                     
                 
                </table>

                <input type="hidden" id="listaProductos" name="listaProductos" value='<?php echo $venta["productos"];?>'>

                
              </div>

              <div class="box-footer" style="background-color: #FAFAFA">
                  
                  <div class="col-xs-12">

                    <input type="hidden" id="totalVenta" name="totalVenta" value="<?php echo $venta['total']; ?>">

                    <h1><div id="totalVentasMostrar" class="pull-right"><?php echo '$ '.$venta['total'].'.00'; ?></div></h1>

                  </div>

                  <div class="col-xs-12">

                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#myModalPago" style="margin-top: 10px;" id="btn-editarVenta">Guardar Venta </button>

                  </div>

                </div>

            </div>

        </div>


        

      

    </div>
<!--=====================================
MODAL PARA ELEGIR PAGO
======================================-->
<div id="myModalPago" class="modal fade" role="dialog">

  <div class="modal-dialog">
    
    <div class="modal-content">
      
      <div class="modal-header" style="background:#3E4551; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Metodo Pago</h4>

      </div>

      <div class="modal-body">

          <label for="pago">PAGO</label>

          <select class="form-control" id='listaMetodoPago' name='listaMetodoPago'>
            
            <option value="EFECTIVO" selected>EFECTIVO</option>
            <option value="CTA.CORRIENTE">CTA.CORRIENTE</option> 
            <option value="TARJETA">TARJETA</option>
            <option value="TRANSFERENCIA">TRANSFERENCIA</option>
            <option value="CHEQUE">CHEQUE</option>
           
          </select>

          <label for="nuevaReferencia">REFERENCIA</label>

          <input type="text" class="form-control" placeholder="REFERENCIA...." id='nuevaReferencia' name='nuevaReferencia' value='EFECTIVO' autocomplete="off">        
     

      </div><!-- Modal body-->

      <div class="modal-footer">

        <button type="button" class="btn btn-danger" data-dismiss="modal" id="guardarEditarVenta">Guardar Venta</button>
 
      </div>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->
            
  

</div><!-- Modal face-->

   </form>

   <?php
     foreach ($listaProducto as $key => $value) {
      
      // tomo todos los datos que vienen por el formulario
      $datos = array("idproducto"=>$value['id'],
               "nombre"=>$value['descripcion'],
               "idNroComprobante"=>$value['idnrocomprobante'],
               "cantidadProducto"=>$value['cantidad'],
               "cantVentaProducto"=>$value['cantventaproducto'],
               "precioVenta"=>$value['precio'],
               "folio1"=>$value['folio1'],
               "folio2"=>$value['folio2']);
      
      //los agrego en la tabla tmp_items
      $respuesta = ControladorComprobantes::ctrAgregarItemsComprobantes($datos);
     

    }

    $editarVenta = new ControladorCuotas();
    $editarVenta -> ctrEditarCuota();

   ?>
  </section>

</div>


<!--=====================================
MODAL PARA BUSCAR CLIENTES
======================================-->
<div id="myModalClientes" class="modal fade" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button">&times;</button>
        
        <h4 class="modal-title">Seleccione cliente</h4>

         <button class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#modalAgregarCliente">
          
          Agregar cliente

        </button>

      </div>

      <div class="modal-body" >
        
        <div id="datos_ajax"></div>

        <table id="buscarclientetabla" class="table table-striped table-condensed table-hover tablaBuscarClientes">
           
           <thead>
      <tr>
        <th width="150">nombre</th>
        <th width="80">documento</th>
        <th width="80">cuit</th>
        <th width="150">opciones</th>
      </tr>
    </thead>

    <tbody>

            
<?php

$item = null;
$valor = null;

$clientes = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);


foreach ($clientes as $key => $value) {

  echo '<tr>';
    echo '<td>'.$clientes[$key]["nombre"].'</td>'; 
    echo '<td>'.$clientes[$key]["documento"].'</td>'; 
    echo '<td>'.$clientes[$key]["cuit"].'</td>'; 
    echo '<td><button class="btn btn-primary btnBuscarCliente" data-dismiss="modal"  idCliente='.$clientes[$key]["id"].' nombreCliente="'.$clientes[$key]["nombre"].'">Seleccionar</button></td>';   
  echo '</tr>';

}

?>
</tbody>

        </table>

      </div><!-- Modal body-->

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id='cerrarCliente'>Cerrar</button>
 
      </div>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->
            
  

</div><!-- Modal face-->
<!-- Modal -->

<!-- Modal -->

  
<div id="myModalProductos" class="modal fade" role="dialog">
  <div class="modal-dialog">
   
    <div class="modal-content">
      <div class="modal-header" style="background:#3E4551; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Seleccionar articulo</h4>
      </div>
      <div class="modal-body" >
       <div id="datos_ajax_producto"></div>
       <div id="contenidoSeleccionado" style="display: none">
        <div class="row">
          <div class="col-xs-2">
            <label for="cantidadProducto">CANT.</label>

            <input type="text" class="form-control" id="cantidadProducto" name="cantidadProducto" autocomplete="off"  value="1">
            <input type="hidden" class="form-control"  id="idproducto"  name="idproducto">
            <input type="hidden" class="form-control"  id="idVenta"  name="idVenta" value="<?php echo $_GET["idVenta"];?>">
            <input type="hidden" class="form-control"  id="idNroComprobante"  name="idNroComprobante">
            <input type="hidden" class="form-control"  id="cantVentaProducto"  name="cantVentaProducto">
          </div>
          <div class="col-xs-5">
            <label for="nombreProducto">PRODUCTO</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" disabled>
            
          </div>
          <div class="col-xs-3">
            <label for="precioProducto">PRECIO</label>
            <input type="text" class="form-control"  id="precioProducto" name="precioProducto" autocomplete="off" >
          </div>
          <div class="col-xs-2">
            <button class="btn btn-primary" style="margin-top: 25px" id="grabarItem">Grabar</button>
          </div>
       </div>
     </div>
        <div id="contenido_producto">
        <table id="buscararticulotabla" class="table table-bordered table-striped tablaBuscarProductos">
         <thead>
          <tr>
            <th width="10">id</th>
            <th>nombre</th>
            
            <th>precio</th>
            <th>opciones</th>
          </tr>
         </thead>
         <tbody>
      
      
       <?php
       

        $item = null;
        $valor = null;
        $orden = "nombre";

        $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

        foreach ($productos as $key => $value){
          
       
          
          if ($value['id']>=19 && $value['id']<=22){
            
            echo ' <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["nombre"].'</td>';

            echo   '<td>'.$value["importe"].'</td>';
            echo   '<td>
                      
                       <button class="btn btn-primary btnSeleccionarProducto" idProducto="'.$value["id"].'" idNroComprobante="'.$value["nrocomprobante"].'" cantVentaProducto="'.$value["cantventa"].'" productoNombre="'.$value["nombre"].'" precioVenta="'.$value["importe"].'">Seleccionar</button>  

                    </td>

                  </tr>';
            }
          }

       
        

       ?>
      </tbody>
    </table>
</div>
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id='cerrarProducto'>Cerrar</button>
        
      
    </div>
        
      </div><!-- Modal content-->
      
    </div><!-- Modal dialog-->

    </div><!-- Modal face-->
   
 


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