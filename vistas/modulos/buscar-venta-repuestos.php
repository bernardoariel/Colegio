<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Buscar x Articulo
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Buscar x Articulo</li>
    
    </ol>


  </section>

  <section class="content">

    <div class="box cajaPrincipal">

      <div class="box-header with-border">
      
        <div class="col-lg-1">

           <strong> <p style="font-size: 22px">Producto:</p> </strong> 

        </div>

        <div class="col-lg-3">

           <?php

           $item = null;
           $valor = null;
           $order ="nombre";
           $productos = ControladorProductos::ctrMostrarProductos($item, $valor,$order);

           ?>

           <select name="productos" id="productos" class="form-control input-lg" >
             <option value="1">SIN REFERENCIA</option>
             <?php 
                 foreach ($productos as $key => $value) {

                  echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';

                 }

             ?>
           </select>

        </div>

        <div class="col-lg-3">

            <button type="button" class="btn btn-primary" id="btn-bsqVentaProducto">Buscar</button>

        </div>
        
        
        

        
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
          <th>#</th>
           <th>Fecha</th>
           <th>Codigo</th>
           <th>Cliente</th>
           <th>Id</th>
           <th>Detalle</th>
           <th>Importe</th>

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

        //DATOS DE TODAS LAS VENTAS DEL MES
        $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);
        
       
       
        $tablaVendido='';
        $contadorTabla=1;
          // inicio el recorrido
          foreach ($respuesta as $key => $value) {

            $fecha = $value["fecha"];
            
            $nrofc = $value["nrofc"];

            $detalle =$value['detalle'];
            // valores para MostrarClientes
            $itemCliente = "id";

            $valorCliente = $value["id_cliente"];

            $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

            // nombre del cliente
            $cliente = $respuestaCliente["nombre"];

            //tomo los datos de los items
            $listaProducto= json_decode($value["productos"],true);
        
            foreach ($listaProducto as $key2 => $value2) {

              // TRAER EL STOCK
              $tablaProductos = "productos";

             
              if(isset($_GET["idProducto"])){

                if($_GET["idProducto"]==$value2["id"]){

                  $tablaVendido = $tablaVendido . '<tr>
                          
                          <td>'.$contadorTabla.'</td>
                          <td>'.$fecha.'</td>
                          <td>'.$nrofc.'</td>
                          <td>'.$cliente.'</td>
                          <td>'.$value2['id'].'</td>
                          <td>'.$value2['descripcion'].'</td>
                          <td>'.$value2['total'].'</td>

                        </tr>';
                  $contadorTabla++;
                 }
              }
              

              
            
              

                  
                }

                

             

            }

            echo $tablaVendido;
      
        ?>
               
        </tbody>

       </table>

      
       

      </div>

    </div>

  </section>

</div>




