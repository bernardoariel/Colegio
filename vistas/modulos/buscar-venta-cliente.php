<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Buscar x Cliente
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Buscar x Cliente</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box cajaPrincipal">

      <div class="box-header with-border">
      
        <div class="col-lg-1">

           <strong> <p style="font-size: 22px">Cliente:</p> </strong> 

        </div>

        <div class="col-lg-3">

           <?php

           $item = null;
           $valor = null;

           $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

           ?>

           <select name="clientes" id="clientes" class="form-control input-lg" >
             <option value="1">SIN REFERENCIA</option>
             <?php 
                 foreach ($clientes as $key => $value) {

                  echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                 }

             ?>
           </select>

        </div>

        <div class="col-lg-3">

            <button type="button" class="btn btn-primary" id="btn-bsqVentaCliente">Buscar</button>

        </div>


        

        
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Fecha</th>
           <th>Nro. Factura</th>
           <th>Codigo</th>
           <th>Cliente</th>
          <!--  <th>Vendedor</th> -->
           <th>Forma de pago</th>
           <th>Detalle</th>
           <th>Total</th> 
           <th>Adeuda</th>
           <th>Obs</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          // if(isset($_GET["fechaInicial"])){

          //   $fechaInicial = $_GET["fechaInicial"];
          //   $fechaFinal = $_GET["fechaFinal"];

          // }else{

          //   $fechaInicial = null;
          //   $fechaFinal = null;

          // }

          if(isset($_GET["idCliente"])){

            

            $item= "id_cliente";
            $valor = $_GET["idCliente"];

            $respuesta = ControladorVentas::ctrMostrarVentasClientes($item,$valor);
            foreach ($respuesta as $key => $value) {
               
               echo '<tr>

                      <td>'.($key+1).'</td>

                      <td>'.$value["fecha"].'</td>

                      <td>'.$value["codigo"].'</td>

                      <td>'.$value["nrofc"].'</td>';

                      $itemCliente = "id";
                      $valorCliente = $value["id_cliente"];

                      $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                      echo '<td>'.$respuestaCliente["nombre"].'</td>';

                      
                      echo '  <td>'.$value["metodo_pago"].'</td>

                              <td>'.$value["detalle"].'</td>

                              <td>$ '.number_format($value["total"],2).'</td>';
                              if ($value["adeuda"]==0){
                                echo '<td style="color:green">$ '.number_format($value["adeuda"],2).'</td>';
                              }else{
                                echo '<td style="color:red">$ '.number_format($value["adeuda"],2).'</td>';
                              }
                              

                              echo '<td>'.$value["observaciones"].'</td>

                              <td>

                        <div class="btn-group">
                            
                          <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'">

                            <i class="fa fa-print"></i>

                          </button>';

                         

                           echo '<button class="btn btn-primary btnVerVenta" idVenta="'.$value["id"].'"><i class="fa fa-eye"></i></button>';

                   
                        echo '</div>  

                      </td>

                    </tr>';
                }
              }

        ?>
               
        </tbody>

       </table>

      
       

      </div>

    </div>

  </section>

</div>




