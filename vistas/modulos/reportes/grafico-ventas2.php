<?php

function getUltimoDiaMes($dato) {

   $datoNuevo = explode("-",$dato);

   $elMes = $datoNuevo[1];

   $elAnio = $datoNuevo[0]; 

  return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));

}

function nombreDelMes($dato) {

   $datoNuevo = explode("-",$dato);

   $elMes = $datoNuevo[1];

  
   switch ($elMes) {
      case '01':
       # code...
        return 'Enero';
       break;
      case '02':
       # code...
        return 'Febrero';
       break;
      case '03':
       # code...
        return 'Marzo';
       break;
      case '04':
       # code...
        return 'Abril';
       break;
      case '05':
       # code...
        return 'Mayo';
       break;
      case '06':
       # code...
        return 'Junio';
       break;
      case '07':
       # code...
        return 'Julio';
       break;
      case '08':
       # code...
        return 'Agosto';
       break;
      case '09':
       # code...
        return 'Septiembre';
       break;
      case '10':
       # code...
        return 'Octubre';
       break;
      case '11':
       # code...
        return 'Noviembre';
       break;
      case '12':
       # code...
        return 'Diciembre';
       break;
   }
  

}



// los diez ultimos meses
$mes0= Date("Y-m");

$nombreMes0=nombreDelMes($mes0);

$fechaInicial = $mes0.'-01';
$fechaFinal = $mes0.'-'.getUltimoDiaMes($mes0);
$respuestaMes0 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-j' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-j' , $fechaFinal );


$respuestaMes0B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------



$mes1 = strtotime ( '-1 month' , strtotime ( $mes0 ) ) ;
$mes1 = date ( 'Y-m' , $mes1 );

$nombreMes1=nombreDelMes($mes1);

$fechaInicial = $mes1.'-01';
$fechaFinal =$mes1.'-'.getUltimoDiaMes($mes1);

$respuestaMes01 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );

$respuestaMes01B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);


// ---------------------------------------------------------------------------------------------------


$mes2 = strtotime ( '-1 month' , strtotime ( $mes1 ) ) ;
$mes2 = date ( 'Y-m' , $mes2 );

$nombreMes2=nombreDelMes($mes2);

$fechaInicial = $mes2.'-01';
$fechaFinal =$mes2.'-'.getUltimoDiaMes($mes2);

$respuestaMes02 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes02B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);


// ---------------------------------------------------------------------------------------------------


$mes3 = strtotime ( '-1 month' , strtotime ( $mes2 ) ) ;
$mes3 = date ( 'Y-m' , $mes3 );

$nombreMes3=nombreDelMes($mes3);

$fechaInicial = $mes3.'-01';
$fechaFinal =$mes3.'-'.getUltimoDiaMes($mes3);
$respuestaMes03 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes03B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------

$mes4 = strtotime ( '-1 month' , strtotime ( $mes3 ) ) ;
$mes4 = date ( 'Y-m' , $mes4 );

$nombreMes4=nombreDelMes($mes4);

$fechaInicial = $mes4.'-01';
$fechaFinal =$mes4.'-'.getUltimoDiaMes($mes4);
$respuestaMes04 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes04B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------

$mes5 = strtotime ( '-1 month' , strtotime ( $mes4 ) ) ;
$mes5 = date ( 'Y-m' , $mes5 );

$nombreMes5=nombreDelMes($mes5);

$fechaInicial = $mes5.'-01';
$fechaFinal =$mes5.'-'.getUltimoDiaMes($mes5);
$respuestaMes05 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes05B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------

$mes6 = strtotime ( '-1 month' , strtotime ( $mes5 ) ) ;
$mes6 = date ( 'Y-m' , $mes6 );

$nombreMes6=nombreDelMes($mes6);

$fechaInicial = $mes6.'-01';
$fechaFinal =$mes6.'-'.getUltimoDiaMes($mes6);
$respuestaMes06 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes06B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------

$mes7 = strtotime ( '-1 month' , strtotime ( $mes6 ) ) ;
$mes7 = date ( 'Y-m' , $mes7 );

$nombreMes7=nombreDelMes($mes7);

$fechaInicial = $mes7.'-01';
$fechaFinal =$mes7.'-'.getUltimoDiaMes($mes7);
$respuestaMes07 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes07B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------

$mes8 = strtotime ( '-1 month' , strtotime ( $mes7 ) ) ;
$mes8 = date ( 'Y-m' , $mes8 );

$nombreMes8=nombreDelMes($mes8);

$fechaInicial = $mes8.'-01';
$fechaFinal =$mes8.'-'.getUltimoDiaMes($mes8);
$respuestaMes08 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes08B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);

// ---------------------------------------------------------------------------------------------------

$mes9 = strtotime ( '-1 month' , strtotime ( $mes8 ) ) ;
$mes9 = date ( 'Y-m' , $mes9 );

$nombreMes9=nombreDelMes($mes9);

$fechaInicial = $mes9.'-01';
$fechaFinal =$mes9.'-'.getUltimoDiaMes($mes9);


$respuestaMes09 = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal); 

$fechaInicial = strtotime ( '-1 year' , strtotime ( $fechaInicial ) ) ;
$fechaInicial = date ( 'Y-m-d' , $fechaInicial );

$fechaFinal = strtotime ( '-1 year' , strtotime ( $fechaFinal ) ) ;
$fechaFinal = date ( 'Y-m-d' , $fechaFinal );


$respuestaMes09B = ControladorVentas::ctrSumaTotalVentasEntreFechas($fechaInicial, $fechaFinal);


?>
<!-- AREA CHART -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Ventas de los ultimos dos periodos</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="chart">
        <canvas id="areaChart" style="height:250px"></canvas>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

  <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : ['<?php echo $nombreMes9;?>', '<?php echo $nombreMes8;?>', '<?php echo $nombreMes7;?>', '<?php echo $nombreMes6;?>', '<?php echo $nombreMes5;?>', '<?php echo $nombreMes4;?>', '<?php echo $nombreMes3;?>','<?php echo $nombreMes2;?>','<?php echo $nombreMes1;?>','<?php echo $nombreMes0;?>'],
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $respuestaMes09B['total'];?>, <?php echo $respuestaMes08B['total'];?>, <?php echo $respuestaMes07B['total'];?>, <?php echo $respuestaMes06B['total'];?>, <?php echo $respuestaMes05B['total'];?>, <?php echo $respuestaMes04B['total'];?>, <?php echo $respuestaMes03B['total'];?>, <?php echo $respuestaMes02B['total'];?>, <?php echo $respuestaMes01B['total'];?> ,<?php echo $respuestaMes0B['total'];?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $respuestaMes09['total'];?>, <?php echo $respuestaMes08['total'];?>, <?php echo $respuestaMes07['total'];?>, <?php echo $respuestaMes06['total'];?>, <?php echo $respuestaMes05['total'];?>, <?php echo $respuestaMes04['total'];?>, <?php echo $respuestaMes03['total'];?>, <?php echo $respuestaMes02['total'];?>, <?php echo $respuestaMes01['total'];?> ,<?php echo $respuestaMes0['total'];?>]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData, lineChartOptions)

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : 700,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Chrome'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'IE'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'FireFox'
      },
      {
        value    : 600,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Safari'
      },
      {
        value    : 300,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Opera'
      },
      {
        value    : 100,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'Navigator'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>