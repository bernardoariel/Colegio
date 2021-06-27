<style>

  .panel-primary>.panel-heading {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8;
}
.box.box-primary {
    border-top-color: #17a2b8;
}
.panel-primary{
  border-color:#17a2b8;
  
}

</style>
<?php
  
// FECHA DEL DIA DE HOY
$fecha=date('d-m-Y');

$item = "parametro";
$valor = 'maxAtraso';

$atraso = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

$item = "parametro";
$valor = 'maxLibro';

$libro = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);


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
<style>
#tablaModelo {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#tablaModelo td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

#tablaModelo tr:nth-child(even) {
    background-color: #dddddd;
}

</style>

<div class="content-wrapper">

  <section class="content">

    <form method="post" class="formularioVenta" name="frmVenta" id="frmVenta">

    <div class="row" style="background-color: #f8f9fa; color:#343a40">

      <!--=====================================================
                        PANEL IZQUIERDO
        ========================================================-->
        
        <div class="col-md-3" style="margin-top: 10px;">
           
           <div class="panel panel-primary">

            <div class="panel-heading" id="headPanel">

                <h4 style="text-align:center">Datos de la Factura</h4>

            </div>

           <div class="panel-body">

                <div class="col-xs-12">

                  <label for="nombre">NRO. FC</label>
                  
                  <input type="text" class="form-control" id='nuevaVenta' name='nuevaVenta' autocomplete="off"  value="<?php echo  $codigoFacturaAprox;?>" style="text-align: center;" readonly>
                  
                  <input type='hidden' id='idVendedor' name='idVendedor' value='<?php echo $_SESSION["id"];?>'>
                </div>

               
                <div class="col-xs-12 ">

                  <input type='hidden' id='seleccionarCliente' name='seleccionarCliente'>

                  <input type="text" class="form-control" placeholder="NOMBRE...." id='nombreCliente' name='nombreCliente' value='' autocomplete="off"  style="margin-top: 5px" readonly>

                  <input type='hidden' id='documentoCliente' name='documentoCliente'>

                  <input type='hidden' id='tipoDocumento' name='tipoDocumento'>

                  <input type='hidden' id='tipoCliente' name='tipoCliente' value="consumidorfinal">
                  
                  <input type='hidden' id='categoria' name='categoria' value="SinCategoria">

                </div>
                <div class="col-xs-12 text-success" style="text-align: center;font-weight: bold;" id="msgCategoria"></div>
                
                <div class="col-xs-12">

                    <button type="button" id="btnBuscarNombreClienteFc" class="btn btn-primary btn-block btnBuscarCliente" data-toggle="modal" data-target="#myModalClientes" style="margin-top: 5px;" autofocus>Seleccionar Escribano o Cliente</button>

                </div>
                
                <div class="col-xs-12">

                      <label for="pago">PAGO</label>

                      <select class="form-control" id='listaMetodoPago' name='listaMetodoPago'>

                        <option value="CTA.CORRIENTE">CTA.CORRIENTE</option>
                        <option value="EFECTIVO" selected>EFECTIVO</option>
                        <option value="TARJETA">TARJETA</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>

                       
                      </select>

                </div>

                <div class="col-xs-12">

                  <label for="nuevaReferencia">REFERENCIA</label>

                  <input type="text" class="form-control" placeholder="REFERENCIA...." id='nuevaReferencia' name='nuevaReferencia' value='EFECTIVO' autocomplete="off">

                </div>
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
            
            <div class="box box-primary">

                <div class="box-header with-border" id="headPanelItems" style="background-color: #17a2b8; color:white">

                  <h3 class="box-title pull-right">Articulos</h3>
                  
                  <button id="reiniciar" type="button" class="btn bg-navy btn-flat btn-xs pull-left">Actualizar <i class="glyphicon glyphicon-refresh"></i> Reiniciar</button>
                  
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

                  <tbody class="tablaProductosSeleccionados"></tbody>
                  
                   <tfooter>

                      <tr>

                        <td colspan="8"><div class="col-xs-2">Escribano: </div>

                          <strong>

                            <div class="col-xs-3" id="panel3nombrecliente">

                              S/REFERENCIA

                            </div>

                          </strong>

                          <div class="col-xs-2">Categoria: </div>

                          <strong> 

                            <div class="col-xs-2" id="panel3TipoCLiente">

                              S/REFERENCIA

                            </div>

                          </strong>

                        </td>

                      </tr>

                    </tfooter>
                 
                </table>

                <input type="hidden" id="listaProductos" name="listaProductos">

                
              </div>
              

                <div class="box-footer" style="background-color: #FAFAFA">
                  
                  <div class="col-xs-12">

                    <input type="hidden" id="totalVenta" name="totalVenta" value="0">

                    <h1><div id="totalVentasMostrar" class="pull-right">0.00</div></h1>

                  </div>

                  <div class="col-xs-12">

                    <button type="button" class="btn btn-danger pull-right" id="guardarVenta" style="margin-top: 10px;" disabled>Guardar Venta </button>

                  </div>

                </div>



            </div>

        </div>



    </div>


   </form>

   <?php

    // $guardarVenta = new ControladorVentas();
    // $guardarVenta -> ctrCrearVenta();

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
      
      <div class="modal-header " style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Seleccione escribano</h4>

         <button type="button" class="btn btn-warning"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteDni"> x DNI</button>

         <button type="button" class="btn btn-warning"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteCuit"> x CUIT</button>

         <button class="btn btn-info pull-right" id="consumidorFinal" data-dismiss="modal"  idCliente="1" nombreCliente="CONSUMIDOR FINAL" documentoCliente="0" tipoDocumento="SINCUIT" tipoCLiente="consumidorfinal" >Consumidor Final</button>

         <button type="button" class="btn btn-primary pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#modalEscribanos"> Escribanos</button>

         <button type="button" class="btn btn-primary pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#modalClientes"> Clientes</button>


      </div>

      <div class="modal-body" >
        
        <div id="datos_ajax"></div>

        <table id="buscarclientetabla" class="table table-striped table-condensed table-hover tablaBuscarClientes">
           
          <thead>
            
            <tr>
              <th width="150">nombre</th>
              <th width="80">documento</th>
              <th width="80">cuit</th>
              <th width="10">libros</th>
              <th width="180">opciones</th>
            </tr>

          </thead>

    <tbody>

            
<?php

$item = null;
$valor = null;

$clientes = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

$item = "parametro";
$valor = "maxLibro";
$parametros = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

foreach ($clientes as $key => $value) {

  $item = 'id';
  $valor = $value["id_categoria"];

  $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);

  $cantLibros =$value["ultimolibrocomprado"]-$value["ultimolibrodevuelto"];
  echo '<tr>';
  echo '<td>'.$value["nombre"].'</td>'; 
  echo '<td>'.$value["documento"].'</td>'; 
  echo '<td>'.$value["cuit"].'</td>'; 
  echo '<td>'.$cantLibros.'</td>'; 

    //CONSULTO SI ESTA ATRASADO O AL DIA 1==NO TIENE DEUDA A FACTURAR
    if($value["cuit"]!='0'){
      
      if($value["inhabilitado"]==0){

        if ($value["facturacion"]=="DNI"){

          echo '<td><button class="btn btn-primary btnBuscarCliente" data-dismiss="modal"  idCliente='.$value["id"].' nombreCliente="'.$value["nombre"].'" documentoCliente="'.$value["documento"].'" tipoDocumento="'.$value["facturacion"].'" categoria="'.$categoria["categoria"].'" tipoCLiente="escribanos" >Seleccionar</button></td>';

        }else{

          if ($cantLibros<=$parametros["valor"]){   

            echo '<td><button class="btn btn-primary btnBuscarCliente" data-dismiss="modal"  idCliente='.$value["id"].' nombreCliente="'.$value["nombre"].'" documentoCliente="'.$value["cuit"].'" tipoDocumento="'.$value["facturacion"].'" categoria="'.$categoria["categoria"].'" tipoCLiente="escribanos" ">Seleccionar</button></td>';

          }else{

            echo '<td><button class="btn btn-danger" data-dismiss="modal">Inhabilitado (Libros)</button></td>';
            
          }

        }

    
            
      }else{

        echo '<td><button class="btn btn-default btnInhabilitado"><a href="index.php?ruta=historico&idEscribano='.$value["id"].'&tipo=cuotas" style="text-color:white;">Inhabilitado</a></button></td>';
      
      }

    }else{

      if ($value["id"]=='1'){
        
        echo '<td><button class="btn btn-primary btnBuscarCliente" data-dismiss="modal"  idCliente='.$value["id"].' nombreCliente="'.$value["nombre"].'" documentoCliente="'.$value["cuit"].'" tipoDocumento="'.$value["facturacion"].'" categoria="categoria" tipoCLiente="consumidorfinal" >Seleccionar</button></td>';

      }else{

        echo '<td><button class="btn btn-danger" data-dismiss="modal">No tiene datos de afip</button></td>';
      }

    }  
      

       
  }

  echo '</tr>';



$item = null;
$valor = null;

$clientes2 = ControladorClientes::ctrMostrarClientes($item, $valor);

foreach ($clientes2 as $key => $value) {

   echo '<tr>';
   echo '<td>'.$value["nombre"].'</td>'; 
   echo '<td> - - </td>'; 
   echo '<td>'.$value["cuit"].'</td>';
   echo '<td> - - </td>';
   echo '<td><button class="btn btn-primary btnBuscarCliente2" data-dismiss="modal"  idCliente='.$value["id"].' nombreCliente="'.$value["nombre"].'" documentoCliente="'.$value["cuit"].'" tipoDocumento="CUIT" categoria="categoria" tipoCLiente="clientes">Seleccionar</button></td>';
   echo '</tr>';


}

$item = null;
$valor = null;

$delegaciones = ControladorDelegaciones::ctrMostrarDelegaciones($item, $valor);

foreach ($delegaciones as $key => $value) {

   echo '<tr>';
   echo '<td>'.$value["nombre"].'</td>'; 
   echo '<td> - - </td>'; 
   echo '<td> - - </td>'; 
   echo '<td> - - </td>';
   echo '<td><button class="btn btn-primary btnBuscarDelegacion" data-dismiss="modal"  idDelegacion='.$value["id"].' categoria="categoria" nombreDelegacion="'.$value["nombre"].'">Seleccionar</button></td>';
   echo '</tr>';


}

?>
</tbody>

        </table>

      </div><!-- Modal body-->

      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-default" data-dismiss="modal" id='cerrarCliente'>Cerrar</button> -->
 
      </div>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->


</div><!-- Modal face-->
<!-- Modal -->

<!-- Modal -->

<!--=====================================
MODAL SOLO ESCRIBANOS
======================================-->
<div id="modalEscribanos" class="modal fade" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header " style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Solo escribanos Habilitados</h4>

         <button type="button" class="btn btn-warning"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteDni"> x DNI</button>

         <button type="button" class="btn btn-warning"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteCuit"> x CUIT</button>

         <button class="btn btn-info pull-right" id="consumidorFinal" data-dismiss="modal"  idCliente="1" nombreCliente="CONSUMIDOR FINAL" documentoCliente="0" tipoDocumento="SINCUIT" tipoCLiente="consumidorfinal" >Consumidor Final</button>

         <button type="button" class="btn btn-info"  data-dismiss="modal" data-toggle="modal" data-target="#myModalClientes"> Todos</button>

         <button type="button" class="btn btn-primary pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#modalClientes"> Clientes</button>


      </div>

      <div class="modal-body">
        
        <div id="datos_ajax"></div>

        <table id="buscarclientetabla" class="table table-striped table-condensed table-hover tablaBuscarClientes">
           
          <thead>
            
            <tr>
              <th width="150">nombre</th>
              <th width="80">documento</th>
              <th width="80">cuit</th>
              <th width="10">libros</th>
              <th width="180">opciones</th>
            </tr>

          </thead>

      <tbody>

            
<?php

$item = null;
$valor = null;

$clientes = ControladorEscribanos::ctrMostrarEscribanos($item, $valor);

$item = "parametro";
$valor = "maxLibro";
$parametros = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

foreach ($clientes as $key => $value) {

  if($value["cuit"]!='0' && $value["inhabilitado"]==0){
    
    $item = 'id';
    $valor = $value["id_categoria"];

    $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);

    $cantLibros =$value["ultimolibrocomprado"]-$value["ultimolibrodevuelto"];
    echo '<tr>';
    echo '<td>'.$value["nombre"].'</td>'; 
    echo '<td>'.$value["documento"].'</td>'; 
    echo '<td>'.$value["cuit"].'</td>'; 
    echo '<td>'.$cantLibros.'</td>'; 
    
      echo '<td><button class="btn btn-primary btnBuscarCliente" data-dismiss="modal"  idCliente='.$value["id"].' nombreCliente="'.$value["nombre"].'" documentoCliente="'.$value["cuit"].'" tipoDocumento="'.$value["facturacion"].'" categoria="'.$categoria["categoria"].'" tipoCLiente="escribanos" >Seleccionar</button></td>';
    //CONSULTO SI ESTA ATRASADO O AL DIA 1==NO TIENE DEUDA A FACTURAR
   
    
            
    }



       
  }

  echo '</tr>';





$item = null;
$valor = null;

$delegaciones = ControladorDelegaciones::ctrMostrarDelegaciones($item, $valor);

foreach ($delegaciones as $key => $value) {

   echo '<tr>';
   echo '<td>'.$value["nombre"].'</td>'; 
   echo '<td> - - </td>'; 
   echo '<td> - - </td>'; 
   echo '<td> - - </td>';
   echo '<td><button class="btn btn-primary btnBuscarDelegacion" data-dismiss="modal"  idDelegacion='.$value["id"].' categoria="categoria" nombreDelegacion="'.$value["nombre"].'">Seleccionar</button></td>';
   echo '</tr>';


}

?>
</tbody>

        </table>

      </div><!-- Modal body-->

      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-default" data-dismiss="modal" id='cerrarCliente'>Cerrar</button> -->
 
      </div>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->


</div><!-- Modal face-->
<!-- Modal -->

<!-- Modal -->

<!--=====================================
MODAL PARA BUSCAR CLIENTES
======================================-->
<div id="modalClientes" class="modal fade" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header " style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Solo Clientes</h4>

         <button type="button" class="btn btn-warning"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteDni"> x DNI</button>

         <button type="button" class="btn btn-warning"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteCuit"> x CUIT</button>

         <button class="btn btn-info pull-right" id="consumidorFinal" data-dismiss="modal"  idCliente="1" nombreCliente="CONSUMIDOR FINAL" documentoCliente="0" tipoDocumento="SINCUIT" tipoCLiente="consumidorfinal" >Consumidor Final</button>

         <button type="button" class="btn btn-info"  data-dismiss="modal" data-toggle="modal" data-target="#myModalClientes"> Todos</button>

         <button type="button" class="btn btn-primary pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#modalEscribanos"> Escribanos</button>

         


      </div>

      <div class="modal-body">
        
        <div id="datos_ajax"></div>

        <table id="buscarclientetabla" class="table table-striped table-condensed table-hover tablaBuscarClientes">
           
          <thead>
            
            <tr>
              <th width="150">nombre</th>
              <th width="80">documento</th>
              <th width="80">cuit</th>
              <th width="10">libros</th>
              <th width="180">opciones</th>
            </tr>

          </thead>

    <tbody>

            
<?php




$item = null;
$valor = null;

$clientes2 = ControladorClientes::ctrMostrarClientes($item, $valor);

foreach ($clientes2 as $key => $value) {

   echo '<tr>';
   echo '<td>'.$value["nombre"].'</td>'; 
   echo '<td> - - </td>'; 
   echo '<td>'.$value["cuit"].'</td>';
   echo '<td> - - </td>';
   echo '<td><button class="btn btn-primary btnBuscarCliente2" data-dismiss="modal"  idCliente='.$value["id"].' nombreCliente="'.$value["nombre"].'" documentoCliente="'.$value["cuit"].'" tipoDocumento="CUIT" categoria="categoria" tipoCLiente="clientes">Seleccionar</button></td>';
   echo '</tr>';


}



?>
</tbody>

        </table>

      </div><!-- Modal body-->

      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-default" data-dismiss="modal" id='cerrarCliente'>Cerrar</button> -->
 
      </div>
        
    </div><!-- Modal content-->
      
  </div><!-- Modal dialog-->


</div><!-- Modal face-->
<!-- Modal -->

<!-- Modal -->
  
<div id="myModalProductos" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background:#3c8dbc; color:white">
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
            <input type="hidden" class="form-control"  id="idNroComprobante"  name="idNroComprobante">
            <input type="hidden" class="form-control"  id="cantVentaProducto"  name="cantVentaProducto">
            <input type="hidden" class="form-control"  id="idVenta"  name="idVenta" value="0">
          </div>
          <div class="col-xs-5">
            <label for="nombreProducto">PRODUCTO</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" disabled>
            
          </div>
          <div class="col-xs-3">
            <label for="precioProducto">PRECIO</label>
            <input type="number" class="form-control"  id="precioProducto" name="precioProducto" autocomplete="off" >
          </div>
          <div class="col-xs-2">
            <button class="btn btn-primary" style="margin-top: 25px" id="grabarItem">Grabar</button>
          </div>
       </div>
     </div>
        <div id="contenido_producto">
        <table id="buscararticulotabla" class="table table-bordered table-striped tablaBuscarProductos" width="100%">
         <thead>
          <tr>
            <th width="10">id</th>
            <th>nombre</th>
            <th>precio</th>
            <th>opciones</th>
          </tr>
         </thead>
         <tbody>
         </tbody>
    </table>
</div>
      </div><!-- Modal body-->
       <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal" id='cerrarProducto'>Cerrar</button> -->
        
      
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

<div id="modalClienteDni" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          
          <h4 class="modal-title">Ingrese los Datos del Cliente <button type="button" class="btn btn-warning pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteCuit">cambiar a CUIT </button></h4>

          

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nombreClienteEventual" id="nombreClienteEventual" placeholder="Ingresar Nombre" style="text-transform:uppercase; " required>

              </div>

            </div>

             <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="number" class="form-control input-lg" name="documentoClienteEventual" id="documentoClienteEventual" placeholder="Ingresar Dni" required>

              </div>

            </div>
  
          
           
  
          </div>  

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-danger" id="seleccionarClienteDni">Ingresar Datos</button>

        </div>
        
       

        

     

    </div>

  </div>

</div>


<div id="modalClienteCuit" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

          <h4 class="modal-title">Ingrese los Datos del Cliente <button type="button" class="btn btn-warning pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#modalClienteDni">cambiar a DNI </button></h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nombreAgregarCliente" id="nombreAgregarCliente" placeholder="Ingresar Nombre" style="text-transform:uppercase; " required>

              </div>

            </div>

            <!-- ENTRADA PARA EL CUIT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="number" class="form-control input-lg" name="documentoAgregarCliente" id="documentoAgregarCliente" placeholder="Ingresar Cuit" required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="tipoCuitAgregarCliente" name="tipoCuitAgregarCliente" required>
                  
                  <option value="">Selecionar categoría</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorTipoIva::ctrMostrarTipoIva($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.$value["nombre"].'">'.$value["nombre"].'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>
            
            <!-- ENTRADA PARA LA DIRECCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="text" class="form-control input-lg" name="direccionAgregarCliente" id="direccionAgregarCliente" placeholder="Ingresar Direccion" required>

              </div>

            </div>
          
            <!-- ENTRADA PARA LA LOCALIDAD -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 

                <input type="text" class="form-control input-lg" name="localidadAgregarCliente" id="localidadAgregarCliente" placeholder="Ingresar Localidad" required>

              </div>

            </div>
           
  
          </div>  

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-danger"  data-dismiss="modal" id="seleccionarClientCuit">Ingresar Datos</button>

        </div>
        
       

        

     

    </div>

  </div>

</div>