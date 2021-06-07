

  <section class="content">

    <div class="box cajaPrincipal">

      <div class="box-header with-border">

         <button type="button" class="btn btn-default pull-right" id="daterange-btn-repuestos-tecnico">
           <span>

             <i class="fa fa-calendar"></i> Rango de Fecha

           </span>
           
           <i class="fa fa-caret-down"></i>

         </button>

      </div>


      <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          //DATOS DE TODAS LAS VENTAS DEL MES
          $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

          $totalFacturado = 0;

          $repuestosVendidos = 0;

          $gananciaTotal = 0;

          $serviciosTerceros = 0;

          $cantidadSericiosTerceros =0;

           $tablaVendido="";
         

          // inicio el recorrido
          foreach ($respuesta as $key => $value) {

            

            // tomo los valores
            $fecha = $value["fecha"];
            
            $nrofc = $value["nrofc"];

            // valores para MostrarClientes
            $itemCliente = "id";

            $valorCliente = $value["id_cliente"];

            $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

            // nombre del cliente
            $cliente = $respuestaCliente["nombre"];

            //tomo los datos de los items
            $listaProducto= json_decode($value["productos"],true);
        
            foreach ($listaProducto as $key => $value2) {

              // TRAER EL STOCK
              $tablaProductos = "productos";

              $item = "id";
              $valor = $value2["id"];
              $orden = "id";

              $stock = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
              
              // VER QUE TIPO DE STOCK TIENE
              $item = "id";
              $valor = $stock["id_categoria"];

              $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
            

              $totalFacturado = $value2['total']+$totalFacturado; 
            
              if($categorias["movimiento"]=="SI"){
                
                  //ESTE ES EL TOTAL DE LOS REPUESTOS
                  $repuestosVendidos = $value2['total']+$repuestosVendidos; 

                  
                
              }else{

                  if ($stock['codigo']==302){

                    $serviciosTerceros= $value2['total']+$serviciosTerceros; 

                    

                    $cantidadSericiosTerceros++;

                  }else{

                    $gananciaTotal = $value2['total']+$gananciaTotal; 

                  }

                }

                

              }

            }
       ?>
      
      <div class="box-header with-border">
        
       <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">

          <div class="info-box">

            <span class="info-box-icon bg-red"><i class="fa fa-wrench"></i></span>

            <div class="info-box-content">

              <span class="info-box-text">Servicio Terceros</span>
              <span class="info-box-number"><center>$ <?php echo $serviciosTerceros;?></center></span>
              <span class="info-box-number"> <center><small><?php echo $cantidadSericiosTerceros;?> Uni.</small></center></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

  </div>
     
    
    

 
  
  </section>  

</div>


