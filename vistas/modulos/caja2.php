<?php 
/*=============================================
CHEQUEO LAS RESTRICCIONES DE LOS USUARIOS
=============================================*/


// include('restricciones.php');


/*=====  End of Section comment block  ======*/

?>

<?php 

if(isset($_GET['fecha1'])){

  $fecha1 = $_GET['fecha1'];

}else{

  $fecha1 =date('Y-m-d');

}

/*=============================================
LOS IMPORTES DE CAJA
=============================================*/

$item = "fecha";
$valor = $fecha1;
          
$caja = ControladorCaja::ctrMostrarCaja($item, $valor);

/*=====  End of Section comment block  ======*/


/*=============================================
VENTAS
=============================================*/
$item= "fecha";
$valor = $fecha1;

$ventasPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);
$totalventas = 0;
$cuentaCorrienteVenta = 0;
foreach ($ventasPorFecha as $key => $value) {
  # code...
  if($value['metodo_pago']=="CTA.CORRIENTE"){

    $cuentaCorrienteVenta+=$value['total'];
  }

  $totalventas += $value['total'];

}

/*=============================================
REMITOS
=============================================*/
$item= "fecha";
$valor = $fecha1;
$remitos = ControladorRemitos::ctrMostrarRemitosFecha($item,$valor);

$totalRemitos = 0;
$cuentaCorrienteRemito = 0;
foreach ($remitos as $key => $value) {
  # code...
  if($value['metodo_pago']=="CTA.CORRIENTE"){

    $cuentaCorrienteRemito+=$value['total'];
  }

  $totalRemitos += $value['total'];

}



// PAGOS 
$item= "fechapago";
$valor = $fecha1;

$pagosPorFecha = ControladorVentas::ctrMostrarVentasFecha($item,$valor);

$pagosVenta = 0;
$pagoVentaTotal = 0;
foreach ($pagosPorFecha as $key => $value) {
  # code...
  if($value['fecha']!=$fecha1){

    $pagosVenta += $value['total'];
  }
  $pagoVentaTotal+=$value['total'];

}


// REMITOS
$item= "fechapago";
$valor = $fecha1;

$pagosPorFechaRemitos = ControladorRemitos::ctrMostrarRemitosFecha($item,$valor);
$pagosRemito = 0;
$pagoRemitoTotal = 0;
foreach ($pagosPorFechaRemitos as $key => $value) {
  # code...
  if($value['fecha']!=$fecha1){

    $pagosRemito += $value['total'];
  }
   $pagoRemitoTotal+=$value['total'];

}

//FORMATEAR FECHA
 $fechaFormateada = explode("-", $fecha1);


switch (intval($fechaFormateada[1])) {

   
  case 1:

    $mes ="ENERO";
    break;

  case 2:
     
    $mes= "FEBRERO";
    break;

  case 3:
    
    $mes= "MARZO";
    break;

  case 4:
    
    $mes= "ABRIL";
    break;  

  case 5:
    
    $mes= "MAYO";
    break;  

  case 6:
    
    $mes= "JUNIO";
    break;

  case 7:
    
    $mes= "JULIO";
    break;

  case 8:
    
    $mes= "AGOSTO";
    break;

  case 9:
    
    $mes= "SEPTIEMBRE";
    break;
  
  case 10:
    
    $mes= "OCTUBRE";
    break;

  case 11:
    
    $mes= "NOVIEMBRE";
    break;
  
  case 12:
    
    $mes= "DICIEMBRE";
    break;  

   // default:
   //   # code...
   // echo "aaaaaaaaaaaaaaaaaa---------".$fecha1[1];
   //   break;
 }





?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar caja del día <?php echo $fechaFormateada[2]. " de ".$mes." ".$fechaFormateada[0]; ?>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar caja</li>
    
    </ol>

  </section>

  <section class="content">

     <div class="row">

        
        <!-- /.col -->

        <div class="col-md-2 col-sm-3 col-xs-12">

          <div class="info-box" title="Son Todas las Cobranzas en EFECTIVO">

            <span class="info-box-icon bg-blue"><i class="fa fa fa-usd"></i></span>

            <div class="info-box-content">

              <span class="info-box-text"><strong>Efectivo <a href="http://localhost/colegio/extensiones/fpdf/pdf/informe-caja.php?fecha1=<?php echo $fecha1;?>&tipopago=EFECTIVO" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              <span class="info-box-number" style="font-size: 15px">$<?php echo number_format($caja[0]['efectivo'],2); ?></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-2 col-sm-3 col-xs-12">

          <div class="info-box" title="Son Todas las Cobranzas con TARJETA">

            <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>

            <div class="info-box-content">

              <span class="info-box-text"><strong>Tarjeta  <a href="http://localhost/colegio/extensiones/fpdf/pdf/informe-caja.php?fecha1=<?php echo $fecha1;?>&tipopago=TARJETA" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              <span class="info-box-number" style="font-size: 15px">$<?php echo number_format($caja[0]['tarjeta'],2); ?></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-xs-12">

          <div class="info-box" title="Son Todas las Cobranzas con CHEQUE">

            <span class="info-box-icon bg-orange"><i class="fa fa-university"></i></span>

            <div class="info-box-content">

              <span class="info-box-text"><strong>Cheque <a href="http://localhost/colegio/extensiones/fpdf/pdf/informe-caja.php?fecha1=<?php echo $fecha1;?>&tipopago=CHEQUE" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              <span class="info-box-number" style="font-size: 15px">$<?php echo number_format($caja[0]['cheque'],2); ?></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

          <div class="info-box" title="Son Todas las Cobranzas con TRANSFERENCIAS BANCARIAS">

            <span class="info-box-icon bg-purple"><i class="fa fa-bookmark"></i></span>

            <div class="info-box-content">

              <span class="info-box-text"><strong>Transferencias <a href="http://localhost/colegio/extensiones/fpdf/pdf/informe-caja.php?fecha1=<?php echo $fecha1;?>&tipopago=TRANSFERENCIA" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              <span class="info-box-number" style="font-size: 15px">$<?php echo number_format($caja[0]['transferencia'],2); ?></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">

          <div class="info-box" title="Aqui estan acentados toda VENTA (incluida las delegaciones) que no fue cobrada ">

            <span class="info-box-icon bg-yellow"><i class="fa fa fa-users"></i></span>

            <div class="info-box-content">

              <span class="info-box-text"><strong>Cuenta Corriente <a href="http://localhost/colegio/extensiones/fpdf/pdf/informe-caja.php?fecha1=<?php echo $fecha1;?>&tipopago=CTA.CORRIENTE" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              <span class="info-box-number"  style="font-size: 15px">$<?php echo number_format($cuentaCorrienteVenta+$cuentaCorrienteRemito,2); ?></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

         <div class="col-md-3 col-sm-4 col-xs-12">

          <div class="info-box" title="Son Todas LAS VENTAS DEL DIA">

            <span class="info-box-icon bg-red"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
              <h5></h5>
              <span class="info-box-text"><strong>Ventas <a href="http://localhost/colegio/extensiones/fpdf/pdf/ventas.php?fecha1=<?php echo $fecha1;?>&tipoventa=VENTA" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              
              <span class="info-box-number">Total $<?php echo number_format($totalventas,2); ?></span>
              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">

          <div class="info-box" title="Son Todas LAS VENTAS DEL DIA A LAS DELEGACIONES">

            <span class="info-box-icon bg-blue"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
              <h5></h5>
              <span class="info-box-text"><strong>Remitos <a href="http://localhost/colegio/extensiones/fpdf/pdf/ventas.php?fecha1=<?php echo $fecha1;?>&tipoventa=REMITO" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              
              <span class="info-box-number">Total $<?php echo number_format($totalRemitos,2); ?></span>
              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">

          <div class="info-box" title="Son Todos los pagos de aquellos que tenian deuda de escribanos/particulares y/o delegaciones">

            <span class="info-box-icon bg-pink"><i class="fa fa-building"></i></span>

            <div class="info-box-content">

              <span class="info-box-text"><strong>Pagos de Cta.Corriente <a href="http://localhost/colegio/extensiones/fpdf/pdf/pagos.php?fecha1=<?php echo $fecha1;?>" target="_blank"></strong><i class="fa fa-external-link-square" aria-hidden="true"></i></a></span>
              <span class="info-box-number">$<?php echo number_format($pagosVenta+$pagosRemito,2); ?></span>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        
        

        <div class="col-md-3 col-sm-4 col-xs-12">

          <div class="info-box">

            <span class="info-box-icon bg-red"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
              <h5></h5>
              <!-- <span class="info-box-text"><strong>Ventas </strong></span> -->
              
             
              <span class="info-box-number">Total $<?php echo number_format($pagoVentaTotal+ $pagoRemitoTotal,2); ?></span>
              <h6>(Ventas + Remitos + Pagos)</h6>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    

    
   

    </div>
    <div class="box">

     
      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
         <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Fecha</th>
           <th>Efectivo</th>
           <th>Tarjeta</th>
           <th>Cheque</th>
           <th>Transferencia</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          // $item = "fecha";
          // $valor = date('Y-m-d');
          
          $item = null;
          $valor = null;

          $caja = ControladorCaja::ctrMostrarCaja($item, $valor);
          
          foreach ($caja as $key => $value) {
           
            echo '<tr>

                   <td>'.($key+1).'</td>';

              echo '<td class="text-uppercase">'.$value["fecha"].'</td>';
              echo '<td class="text-uppercase">'.$value["efectivo"].'</td>';
              echo '<td class="text-uppercase">'.$value["tarjeta"].'</td>';
              echo '<td class="text-uppercase">'.$value["cheque"].'</td>';
              echo '<td class="text-uppercase">'.$value["transferencia"].'</td>';
              echo '<td><div class="btn-group">
            
                      <button class="btn btn-primary btnImprimirCaja" fecha="'.$value["fecha"].'" title="Imprimir caja"><i class="fa fa-print"></i></button>
                      
                      <button class="btn btn-danger btnSeleccionarCaja" fecha="'.$value["fecha"].'" title="caja del dia '.$value["fecha"].'" ><i class="fa fa-calendar"></a></i></button>
                      ';
              
              echo '</div></td>';
            echo '</tr>';
          }

        ?>

        </tbody>



       

       </table>

      </div>

    </div>

  </section>

</div>
