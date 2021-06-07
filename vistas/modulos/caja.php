<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar caja
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar caja</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
       

      </div>

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
              echo '<td>

                      <button class="btn btn-primary btnImprimirCaja" fecha="'.$value["fecha"].'" title="Imprimir caja"><i class="fa fa-print"></i></button>';
              
              echo '</td>';
            echo '</tr>';
          }

        ?>

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>
