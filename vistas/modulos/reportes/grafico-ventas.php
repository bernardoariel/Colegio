<?php

function cargarGrafico($fechaInicial,$fechaFinal){
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
            $datos =array("repuestos"=>$repuestosVendidos,"ganancia"=>$gananciaTotal);
           return $datos;
}


// los diez ultimos meses
$mes0= Date("Y-m");

$fechaInicial = $mes0.'-01';
$fechaFinal = $mes0.'-'.getUltimoDiaMes($mes0);
$respuestaMes0 = cargarGrafico($fechaInicial, $fechaFinal);




// ---------------------------------------------------------------------------------------------------



$mes1 = strtotime ( '-1 month' , strtotime ( $mes0 ) ) ;
$mes1 = date ( 'Y-m' , $mes1 );

$fechaInicial = $mes1.'-01';
$fechaFinal =$mes1.'-'.getUltimoDiaMes($mes1);

$respuestaMes01 = cargarGrafico($fechaInicial, $fechaFinal);



// ---------------------------------------------------------------------------------------------------


$mes2 = strtotime ( '-1 month' , strtotime ( $mes1 ) ) ;
$mes2 = date ( 'Y-m' , $mes2 );

$fechaInicial = $mes2.'-01';
$fechaFinal =$mes2.'-'.getUltimoDiaMes($mes2);

$respuestaMes02 = cargarGrafico($fechaInicial, $fechaFinal);


// ---------------------------------------------------------------------------------------------------



?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">

        <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
       
        <li class="pull-left header"><i class="fa fa-inbox"></i> Ganancia y Repuestos</li>

      </ul>

      <div class="tab-content no-padding">

        <!-- Morris chart - Sales -->
        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>

      </div>

    </div>

</div>

<script>
	
/* Morris.js Charts */
  // Sales chart
  var area = new Morris.Area({
    element   : 'revenue-chart',
    resize    : true,
    data      : [
      { y: '<?php echo $mes2;?>', item1: <?php echo $respuestaMes02['repuestos'];?>, item2: <?php echo $respuestaMes02['ganancia'];?> },
      { y: '<?php echo $mes1;?>', item1: <?php echo $respuestaMes01['repuestos'];?>, item2: <?php echo $respuestaMes01['ganancia'];?> },
      { y: '<?php echo $mes0;?>', item1: <?php echo $respuestaMes0['repuestos'];?>, item2: <?php echo $respuestaMes0['ganancia'];?>}
    ],
    xkey      : 'y',
    ykeys     : ['item1', 'item2'],
    labels    : ['Ganancia', 'Repuestos'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover : 'auto'
  });
  

</script>