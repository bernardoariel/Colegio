<?php 

$desarrollo = 0;
if ($desarrollo==1){

  ?>
  <div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Update
      
      <small>Panel de Control</small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Update</li>
    
    </ol>

  </section>

  <section class="content">

<h1>esta funcion esta desactivada para el desarrollo</h1>
  </section>

  <?php

 
}else{


?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Update
      
      <small>Panel de Control</small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Update</li>
    
    </ol>

  </section>

  <section class="content">
    
    <div class="col-md-4">
      <!-- Info Boxes Style 2 -->
      <div class="info-box bg-yellow">

        <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

    <?php 
      #ELIMINAR PRODUCTOS DEL ENLACE
      ControladorEnlace::ctrEliminarEnlace('productos');
      #TRAER PRODUCTOS DEL COLEGIO
      $item = null;
      $valor = null;
      $orden = "id";

      $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
      $cantidadProductos = count($productos);

       $cant=0;
      foreach ($productos as $key => $value) {
        # code...
       
        if($value['ver']==1){
          
          $tabla ="productos";

          $datos = array("id" => $value["id"],
            "nombre" => strtoupper($value["nombre"]),
            "descripcion" => strtoupper($value["descripcion"]),
            "codigo" => $value["codigo"],
            "nrocomprobante" => $value["nrocomprobante"],
            "cantventa" => $value["cantventa"],
            "id_rubro" => $value["id_rubro"],
            "cantminima" => $value["cantminima"],
            "cuotas" => $value["cuotas"],
            "importe" => $value["importe"],
            "obs" => $value["obs"]);

          $cant ++;

        }
        #registramos los productos
        $respuesta = ModeloEnlace::mdlIngresarProducto($tabla, $datos);
        
      }
      $porcentaje = ($cant * 100) /$cantidadProductos;

  ?>
      <div class="info-box-content">
        <span class="info-box-text">Productos</span>
        <span class="info-box-number"><?php echo $cantidadProductos ;?></span>

        <div class="progress">
          <div class="progress-bar" style="width: <?php echo  $porcentaje; ?>%"></div>
        </div>
        <span class="progress-description">
             Se actualizaron <?php echo  round($porcentaje,0); ?>% de productos (<?php echo $cant;?>)
            </span>
        </div>
      <!-- /.info-box-content -->
      </div>
<?php 
      #ELIMINAR PRODUCTOS DEL ENLACE
     ControladorEnlace::ctrEliminarEnlace('escribanos');
      #TRAER PRODUCTOS DEL COLEGIO
      $item = null;
      $valor = null;
      $orden = "id";

      $escribanos = ControladorEscribanos::ctrMostrarEscribanos($item, $valor, $orden);
      
      $cantidadEscribanos = count($escribanos);

      $cant=0;
      foreach ($escribanos as $key => $value) {
        # code...
          
         $tabla = "escribanos";
         $datos =array("id"=>$value["id"],
                       "nombre"=>strtoupper($value["nombre"]),
                       "documento"=>$value["documento"],
                       "id_tipo_iva"=>$value["id_tipo_iva"],
                       "tipo"=>$value["tipo"],
                       "facturacion"=>$value["facturacion"],
                       "tipo_factura"=>$value["tipo_factura"],
                       "cuit"=>$value["cuit"],
                       "direccion"=>strtoupper($value["direccion"]),
                       "localidad"=>strtoupper($value["localidad"]),
                       "telefono"=>$value["telefono"],
                       "email"=>strtoupper($value["email"]),
                       "id_categoria"=>$value["id_categoria"],
                       "id_escribano_relacionado"=>$value["id_escribano_relacionado"],
                       "id_osde"=>$value["id_osde"],
                       "ultimolibrocomprado"=>strtoupper($value["ultimolibrocomprado"]),
                       "ultimolibrodevuelto"=>strtoupper($value["ultimolibrodevuelto"]));
         
         
          $cant ++;

       
        #registramos los productos
      $respuesta = ModeloEnlace::mdlIngresarEscribano($tabla, $datos);
        
      }
      $porcentaje = ($cant * 100) /$cantidadEscribanos;

  ?>
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Escribanos</span>
              <span class="info-box-number"><?php echo $cantidadEscribanos;?></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo  $porcentaje; ?>%"></div>
              </div>
              <span class="progress-description">
                    Se actualizaron <?php echo  round($porcentaje,0); ?>% de Escribanos (<?php echo $cant;?>)
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>

     <?php 
      #ELIMINAR CUOTAS DEL ENLACE
     ControladorEnlace::ctrEliminarEnlace('cuotas');
      #TRAER PRODUCTOS DEL COLEGIO
      $item = null;
      $valor = null;
     

      $ventas = ControladorVentas::ctrMostrarCuotas($item, $valor);
     
     
      $cantidadVentas = count($ventas);

      $cant=0;
      foreach ($ventas as $key => $value) {
       # code...
       $tabla = "cuotas";

       $datos = array("id"=>$value["id"],
                 "fecha"=>$value["fecha"],
                 "tipo"=>$value["tipo"],
                 "id_cliente"=>$value["id_cliente"],
                 "nombre"=>$value["nombre"],
                 "documento"=>$value["documento"],
                 "productos"=>$value["productos"],
                 "total"=>$value["total"]);

          $cant ++;

       
        #registramos los productos
        $respuesta = ModeloEnlace::mdlIngresarVenta($tabla, $datos);
        
        
      }

      $porcentaje = ($cant * 100) /$cantidadVentas;

  ?>

       <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">DEUDORES</span>
              <span class="info-box-number"><?php echo $cantidadVentas;?></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo  $porcentaje; ?>%"></div>
              </div>
              <span class="progress-description">
                     Se actualizaron <?php echo  round($porcentaje,0); ?>% de Ventas (<?php echo $cant+1;?>)
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
      
  <?php


  $ventas = ControladorEnlace::ctrMostrarUltimaActualizacion();
  echo '<pre>Ultima Actualizacion::: '; print_r($ventas['fechacreacion']); echo '</pre>';

  ?>
  </section>
 
</div>

<?php
}
?>